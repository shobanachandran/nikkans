<?php 
include('includes/config.php');
extract($_REQUEST);
if($_SESSION['userid']==''){
	echo "<script>window.location.href='login.php';</script>";
}

$action = 'dist_areaadd';
	$breadcrumb = 'Add';
	$sucessMsg = 'District Information Added Successfully';
	if(isset($colid)){
		$sucessMsg = 'District Information Updated Successfully';
		$action = 'dist_areaedit';
		$breadcrumb = 'Edit';
		$edtColQry = "SELECT * FROM districts WHERE dist_id='".$colid."'";
		$edtColResource = mysqli_query($zconn,$edtColQry);
		$colData = mysqli_fetch_array($edtColResource,MYSQLI_ASSOC);
		$colid = $colData['dist_id'];
		$state_id = $colData['state_id'];
		$colname = $colData['dist_name'];
		$status = $colData['status'];
	}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Garments ERP">
    <meta name="author" content="Iorange Innovation">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title><?php echo SITE_TITLE;?> - District add</title>
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">    
</head>

<body>
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include('includes/header.php');?>
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <?php include('includes/sidebar.php');?>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="min-height: 100%; height: auto;">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
             <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">District Add</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="district.php">District Info</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <div class="container-fluid">               
                <!-- ============================================================== -->
                <!-- Sales chart -->
					<form name="colInfo" id="colInfo" method="post" enctype="multipart/form-data" action="">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
							<div class="card-body">
							</div>
								<div class="card-body" style="width:100%">
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">State</label>
										<div class="col-sm-3">
                                        <select required class="form-control" name="state_id" id="state_id">
				<option value="">--Select--</option>
				<?php $sel_state = mysqli_query($zconn,"select * from states where status='Active'");
					while($res_state = mysqli_fetch_array($sel_state)){
						if($state_id==$res_state['state_id']){
				?>
				<option selected='selected' value="<?php echo $res_state['state_id'];?>"><?php echo $res_state['state_name'];?></option>
				<?php } else {?>
				<option value="<?php echo $res_state['state_id'];?>"><?php echo $res_state['state_name'];?></option>
				<?php } ?>
				<?php } ?>
				</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">District</label>
										<div class="col-sm-3">
                <input type="text"  required value="<?php echo $colname; ?>" class="form-control" tabindex="1" name="colname" id="colname" placeholder="Enter District name">
										</div>
									</div>
									
									<div class="form-group row">
										<label for="lname" class="col-sm-3 text-right control-label col-form-label">Description	</label>
										<div class="col-sm-3">
											<textarea class="form-control" placeholder="description"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="email1" class="col-sm-3 text-right control-label col-form-label">Status</label>
										<div class="col-sm-6" style="margin-top:10px;">
					  <input type="radio" id="stat-act"  value="Active" <?php if(isset($status)){ if($status=='Active'){ ?> checked <?php } }else{ ?> checked <?php } ?>  name="status" class="flat-red" > Active

					  <input type="radio" id="stat-inact"  value="In active" <?php if($status=='In active'){ ?> checked <?php } ?> name="status" class="flat-red"> In Active
										</div>
									</div>
								</div>
									
							<div class="border-top">
								<div class="card-body" style="margin-left: 250px;">
									<button type="submit" class="btn btn-success">Save</button>
									<button type="reset" class="btn btn-primary">Reset</button>
									<a href="district.php"><button type="button" class="btn btn-danger">Back</button></a>
								</div>
							</div>
                        </div>
                    </div>
                </div>
		<input type="hidden" name="action" id="action" value="<?php echo $action ?>" />
	  <?php if(isset($colid)){ ?>
		<input type="hidden" name="colid" id="colid" value="<?php echo $colid ?>" />
	  <?php  } ?>

				</form>
                <!-- Sales chart -->
                <!-- ============================================================== -->                
            </div>
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
		 
    </div>
    <!-- End Wrapper -->
	<!-- ============================================================== -->
            <!-- footer -->
            <?php include('includes/footer.php');?>
            <!-- End footer -->
            <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
	<script>
	$(function () {
		
		$("form#colInfo").submit(function(e) {
			e.preventDefault();    
			var formData = new FormData(this);
			if($('#colname').val()==''){
				alert("Please enter District Name");
				$('#colname').focus();
				return false;
			}
			$("#save").hide();
			$.ajax({
				url: "ajax/area.php",
				type: 'POST',
				data: formData,
				success: function (data) {
					if($.trim(data)=="exist"){
						alert("Area name Already Exist");
					}
					if($.trim(data)==true){
						alert("<?php echo $sucessMsg; ?>");
						window.location.href="district.php";
					}
					if($.trim(data)=="error"){
						alert("Process Failed Kindly. Try again");
						document.getElementById("colInfo").reset();
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		});
	 });
	

</script>
</body>
</html>
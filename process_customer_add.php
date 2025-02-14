<?php 
include('includes/config.php');
extract($_REQUEST);
if($_SESSION['userid']==''){
	echo "<script>window.location.href='login.php';</script>";
}

	$action = 'partyadd';
	$breadcrumb = 'Add';
	$sucessMsg = 'Party Information Added Successfully';
	if(isset($colid)){
		$sucessMsg = 'Party Information Updated Successfully';
		$action = 'partyedit';
		$breadcrumb = 'Edit';
		$edtColQry = "SELECT * FROM process_customer WHERE party_id='".$colid."'";
		$edtColResource = mysqli_query($zconn,$edtColQry);
		$colData = mysqli_fetch_array($edtColResource,MYSQLI_ASSOC);
		$colid = $colData['party_id'];
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
    <title><?php echo SITE_TITLE;?> - party Add</title>
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
                        <h4 class="page-title">party Add</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="party.php">Users Info</a></li>
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
			<form name="party_info" id="party_info" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
							<div class="card-body" style="width:100%">
								<div class="card" style="width:50%; float:left; left: 50px; ">
									<div class="form-group row">
										<label for="scode" class="col-sm-3 text-right control-label col-form-label">party Code</label>
										<?php 
										if($colid==''){
										$sel_code = mysqli_fetch_array(mysqli_query($zconn,
										"select max(party_id) as SID from process_customer"),MYSQLI_ASSOC);
										$scode = $sel_code['SID'];
										if($scode=='' || $scode==NULL){
											$scode_disp='1';
										} else {
											$scode_disp = $scode+1;
										}
										$party_code = PCONFIG.$scode_disp;
										} else {
											$party_code = $colData['party_code'];
										}
										?>
										<div class="col-sm-6">
											<input type="text" class="form-control" readonly id="scode"  name="scode" required 
											value="<?php echo $party_code;?>">
										</div>
									</div>
									
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">party Type</label>
										<div class="col-sm-6">
                                        <select id="stype" name="stype" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option>Select</option>
											<?php $stype_sql = mysqli_query($zconn,"select * from process_master where status='0'");
										while($res_style = mysqli_fetch_array($stype_sql)){
											if($colData['party_type_id']==$res_style['id']){
											?>
											<option selected value="<?php echo $res_style['id']; ?>"><?php echo $res_style['process_name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $res_style['id']; ?>"><?php echo $res_style['process_name']; ?></option>
											<?php } ?>
										<?php } ?>
										</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="lname" class="col-sm-3 text-right control-label col-form-label">party Name</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" required id="sname" name="sname" placeholder="party name" value="<?php echo $colData['party_name'];?>" autocomplete="off">
										</div>
									</div>
									<div class="form-group row">
										<label for="lname" class="col-sm-3 text-right control-label col-form-label">Address -1</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" required name="txt_add1" id="txt_add1" autocomplete="off" value="<?php echo $colData['party_address1'];?>" placeholder="Address">
										</div>
									</div>
									<div class="form-group row">
										<label for="lname" class="col-sm-3 text-right control-label col-form-label">Address -2</label>
										<div class="col-sm-6">
											<input type="text" required id="txt_add2" name="txt_add2" class="form-control" id="lname" autocomplete="off" value="<?php echo $colData['party_address2'];?>" placeholder="Address">
										</div>
									</div>
									<div class="form-group row">
										<label for="email1" class="col-sm-3 text-right control-label col-form-label">State</label>
										<div class="col-sm-6">
                                        <select name="state_id" id="state_id" class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="sel_dist(this.value);">
                                            <option>Select</option>
											<?php $sel_state = mysqli_query($zconn,"select * from states where status='Active'");
											while($res_state = mysqli_fetch_array($sel_state,MYSQLI_ASSOC)){
												if($colData['state_id']==$res_state['state_id']){
											?>
											<option selected value="<?php echo $res_state['state_id'];?>"><?php echo $res_state['state_name'];?></option>
											<?php } else { ?>
											<option value="<?php echo $res_state['state_id'];?>"><?php echo $res_state['state_name'];?></option>
												<?php } } ?>
										</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label"> District</label>
										<div class="col-sm-6">
                                        <span id="dist_list">
                                        <select class="form-control" name="dist_id" id="dist_id">
				<option value="">--Select--</option>
				<?php $sel_dist = mysqli_query($zconn,"select * from districts where status='Active' and state_id='".$colData['state_id']."'");
					while($res_dist = mysqli_fetch_array($sel_dist,MYSQLI_ASSOC)){
						if($colData['district_id']==$res_dist['dist_id']){
				?>
				<option selected='selected' value="<?php echo $res_dist['dist_id'];?>"><?php echo $res_dist['dist_name'];?></option>
				<?php } else {?>
				<option value="<?php echo $res_dist['dist_id'];?>"><?php echo $res_dist['dist_name'];?></option>
				<?php } ?>
				<?php } ?>
				</select>
				</span>
				</div>
				</div>
				<div class="form-group row">
				<label for="cono1" class="col-sm-3 text-right control-label col-form-label"> Area</label>
				<div class="col-sm-6">
				<span id="area_list">
				<select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="city" id="city">
					<option>Select</option>
				<?php $sel_area = mysqli_query($zconn,"select * from area where status='Active' and dist_id='".$colData['district_id']."'");
					while($res_area = mysqli_fetch_array($sel_area,MYSQLI_ASSOC)){
						if($colData['area_id']==$res_area['id']){
				?>
				<option selected='selected' value="<?php echo $res_area['id'];?>"><?php echo $res_area['area_name'];?></option>
				<?php } else {?>
				<option value="<?php echo $res_area['id'];?>"><?php echo $res_area['area_name'];?></option>
				<?php } ?>
				<?php } ?>	
										</select>
										</span>
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Country</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" autocomplete="off" id="scontry" name="scountry" placeholder="Country" value="<?php echo $colData['party_country'];?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">Pincode </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" autocomplete="off" id="spincode" name="spincode" placeholder="Pincode" value="<?php echo $colData['party_pincode'];?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="email1" class="col-sm-3 text-right control-label col-form-label">Status</label>
										<div class="col-sm-6" style="margin-top:10px;">

					  <input type="radio" id="stat-act"  value="0" <?php if(isset($colData['status'])){ if($colData['status']=='0'){ ?> checked <?php } }else{ ?> checked <?php } ?>  name="rad_status" class="flat-red" > Active
					  <input type="radio" id="stat-inact"  value="1" <?php if($colData['status']=='1'){ ?> checked <?php } ?> name="rad_status" class="flat-red"> In Active

										</div>
									</div>
								</div>
								<div class="card" style="width:50%; float:left; right: 50px;">
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile number</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" autocomplete="off" id="smobile" value="<?php echo $colData['party_mobile'];?>" name="smobile" placeholder="mobile">
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">Telephone</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" autocomplete="off" id="sphone" value="<?php echo $colData['party_phone'];?>" name="sphone" placeholder="Telephone">
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">Email Id</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="semail" name="semail" autocomplete="off" value="<?php echo $colData['party_email'];?>" placeholder="email">
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">Pancard</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" autocomplete="off" name="span_card" value="<?php echo $colData['party_pancard'];?>" id="span_card" placeholder="Pancard">
										</div>
									</div>
									<div class="form-group row">
										<label for="fname" class="col-sm-3 text-right control-label col-form-label">GST</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="party_gst" id="party_gst" value="<?php echo $colData['party_gst'];?>" autocomplete="off" placeholder="GST">
										</div>
									</div>
									<h4 class="card-title" style="text-align: center;"><b>Bank Details</b></h4>

									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Bank Name </label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $colData['bank_name'];?>" autocomplete="off" placeholder="Bank name">
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Branch Name</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="branch_name" id="branch_name" autocomplete="off" placeholder="Branch" value="<?php echo $colData['branch_name'];?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Account Number</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="acc_number" id="acc_number" placeholder="Account number" autocomplete="off" value="<?php echo $colData['account_number'];?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">IFSC Code</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" autocomplete="off" placeholder="IFSC code" value="<?php echo $colData['ifsc_code'];?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Account name</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="account_name" name="account_name" autocomplete="off" placeholder="Account name" value="<?php echo $colData['account_name'];?>">
										</div>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body" style="text-align: center;">
									<button type="submit" class="btn btn-success">Save</button>
									<button type="reset" class="btn btn-primary">Reset</button>
									<a href="process_customer.php"><button type="button" class="btn btn-danger">Back</button></a>
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
            </div>
            <!-- End Container fluid  -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
            <!-- footer -->
            <?php include('includes/footer.php');?>
            <!-- End footer -->
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
		$("form#party_info").submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this);

			$.ajax({
				url: "ajax/party.php",
				type: 'POST',
				data: formData,
				success: function (data) {
				alert(data);
					if($.trim(data)=='1'){
						alert("<?php echo $sucessMsg; ?>");
						window.location.href="process_customer.php";
					} 
					if($.trim(data)=='2'){
						alert("party Name already exists!!");
					} 
					if($.trim(data)=='0'){
						alert("Query Failed");
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		});
	 });
	 
	 function sel_dist(st_id){
		$.ajax({
				url: "ajax/area.php?action=display_dist&state_id="+st_id,
				type: 'POST',
				data: "action=disp_dist&state_id="+st_id,
				success: function (data) {
				//	alert(data);
					$("#dist_list").html(data);
				},
				cache: false,
				contentType: false,
				processData: false
			});
	}
	
	
	function disp_area(dist_id){
		//alert(dist_id);
		$.ajax({
				url: "ajax/area.php?action=disp_area&dist_id="+dist_id,
				type: 'POST',
				data: "action=disp_area&dist_id="+dist_id,
				success: function (data) {
				//	alert(data);
					$("#area_list").html(data);
				},
				cache: false,
				contentType: false,
				processData: false
			});
	}
	</script>
</body>
</html>
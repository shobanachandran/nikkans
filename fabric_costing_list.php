<?php 
include('includes/config.php');

if($_SESSION['userid']==''){
	echo "<script>window.location.href='login.php';</script>";
}
if(isset($_REQUEST['id'])){

	$del_dept = mysqli_query($zconn,"delete from fabric_costing_list where id='".$_REQUEST['id']."'");
    $del_dept = mysqli_query($zconn,"delete from fabric_costing where id='".$_REQUEST['id']."'");
	if($del_dept){
		header('location:fabric_costing_list.php');
	} else {
		echo "0";
	}
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
    <title><?php echo SITE_TITLE;?> - Buyer Accessories</title>
    <!-- Custom CSS -->
	<!--  datatables CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">    
    <link href="dist/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
	<script src="dist/js/jquery.min.js"></script>
	<script src="dist/js/chosen.jquery.min.js"></script>

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
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
             <div class="page-breadcrumb">
                <div class="row">
				<form name="fabric_costing_list" id="fabric_costing_list" method="post">
                    <div class="col-12 d-flex no-block align-items-center">
					
                    <h4 class="page-title">Fabric Costing List</h4>
                        &nbsp;&nbsp;&nbsp;&nbsp; <a href="costing.php"> <button type="button" class="btn btn-info">Costing Process</button></a>
						
						Costing No:<select data-placeholder="Begin typing a name to filter..." tabindex="6" multiple class="chosen-select" 
                        class="select2 form-control custom-select " 
                        style="width: 200px;height: 40px; text-align:center;" 
                        name="sel_buyer" id="sel_buyer" onchange="$('#fabric_costing_list').submit();">
											<option value="">Select</option>
											<?php $sel_buyer = mysqli_query($zconn,"select * 
                                            from costing_entry_master where 1 group by costing_no");
											while($res_buyer = mysqli_fetch_array($sel_buyer,
                                            MYSQLI_ASSOC)){
											if($_POST['sel_buyer']==$res_buyer['id']){
												?>
											<option selected value="<?php echo $res_buyer['id'];?>">
                                            <?php echo $res_buyer['costing_no'];?></option>
											<?php } else { ?>
											<option value="<?php echo $res_buyer['id'];?>">
                                            <?php echo $res_buyer['costing_no'];?>
                                            - (<?php echo $res_buyer['order_no'];?>)
                                        </option>
											<?php 
											}
											} ?>
											</select>
                                            <script type="text/javascript">
												$(".chosen-select").chosen({
											  	no_results_text: "Oops, nothing found!"
												})
											</script>
					    
                    <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
								<li>&nbsp;</li>
								<li class="breadcrumb-item">&nbsp;</li>
									<li class="breadcrumb-item"><a href="fabric_costing.php"><button type="button" class="btn btn-success">Add New </button></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
				</form>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table table-striped table-bordered">
										<thead style="background-color: #626F80; color: #fff; padding: 0px; font-size: 16px;">
											<tr>
												<th>S.No</th>
												<th>Costing No</th>
												<th>Indent No</th>
                                                <th>Style Code</th>
                                               <!--  <th>Total</th> -->
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if($_REQUEST['sel_buyer']!=''){
                                        	$sql_buer1 = "where costing_no='".$_REQUEST['sel_buyer']."'";
                                           
                                         }
                                         else {
                                            $sql_buer1 = "";
                                        }
                                        
                                     $sel_group = mysqli_query($zconn,
                                     "select * from fabric_costing_list ".$sql_buer1." order by id desc");
                                   
										$g=1;
										while($res_group = mysqli_fetch_array($sel_group,MYSQLI_ASSOC)){
                                           
                                        
                                              $sel_costing = mysqli_fetch_array(mysqli_query($zconn,"select 
                                            * from costing_entry_master 
                                            where id='".$res_group['costing_no']."'"),MYSQLI_ASSOC);
                                            
                                         
										?>
											<tr id="delete_<?php echo $res_group['id'];?>">
												<td><?php echo $g;?></td>
                                                <!-- <td><?php echo $sel_costing['id'];?></td>
                                                <td><?php echo $res_group['costing_no'];?></td> -->

												<td><?php echo $sel_costing['costing_no'];?></td>
												 <td><?php echo $res_group['order_no'];?></td> 
                                                 <td><?php echo $res_group['style_no'];?></td> 
												<td><a href="edit_fabric_costing.php?id=
                                                <?php echo $res_group['id'];?>" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            <!--a href="fabric_costing_list.php?id=<?php echo $res_group['costing_no'];?>" title="Delete"> <i class="fas fa-window-close"></i></a--> 
                                        
                                            <a href="javascript:;" onclick="costing_sheet(<?php echo addslashes($sel_costing['id']);?>);">
			 <i class="fas fa-print"></i> </a>
                                        </td>

											</tr>
										<?php $g++;}
                                        //}
											?>
										</tbody>
									</table>
								</div>
							</div>
                        </div>
                    </div>
                </div>
                <!-- Sales chart -->
                <!-- ============================================================== -->
            </div>
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <?php include('includes/footer.php');?>
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- End Wrapper -->
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
	<!--datatables JavaScript -->
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script>
		function costing_sheet(cost_id){
			 window.open("fabric_cost_page.php?costing_no="+cost_id, "Costing Sheet", "width=800,height=700");
		}
	</script>
    <script>
	$(document).ready(function() {
		$('#example').DataTable();
	});

	function Deleteaacg(ID){
	  var UsrStatus = confirm("Are you sure to delete this details?");
	  if(UsrStatus){
		$.ajax({
			url : 'ajax/accessories.php',
			data: {
			   action: 'accgroupdel',
			   typeid: ID
			},
			success: function( data ) {
				if($.trim(data)==true){
					alert("Deleted Successfully");
					document.getElementById("delete_"+ID).style.display = "none";

				}
			},
			error: function (textStatus, errorThrown) {
				//DO NOTHINIG
			}
		});
	  }
	  }
	</script>
</body>
</html>
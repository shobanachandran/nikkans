<?php 
include('includes/config.php');
include('includes/base_functions.php');

if($_SESSION['userid']==''){
    echo "<script>window.location.href='login.php';</script>";
}

if (isset($_REQUEST['id'])) {
    $delete=mysqli_query($zconn,"delete from cutting_dc where id='".$_REQUEST['id']."'");
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
    <title><?php echo SITE_TITLE;?> - Cutting View List </title>
    <!-- Custom CSS -->
    <!--  datatables CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">    
    <link href="dist/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
             <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Cutting View list</h4>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" style="overflow:hidden;">
                                <form name="costing_list" id="costing_list" method="post">
                                    <div class="row" style="float:right;">
                                        <div class="col-sm-12" style="float:right;" >
                                            <a href="cutting_dc.php"><button type="button" class="btn btn-success">Add</button></a>
                                         </div>
                                    </div> 
                                </div>
                            </div>
                            <table id="example" class="table table-striped table-bordered display">
                                    <thead style="background-color: #626F80; color: #fff; padding: 0px; font-size: 12px;">
                                            <tr>
                                                <th>S.No</th>
                                                <th>STYLE NO</th>
                                                <th>FABRIC NAME</th>
                                                <th>color</th>
                                                <th>WGT</th>
                                                <th>Contractor</th>
                                                <th>Send By</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                    </thead>
                                    <tbody>
    <?php
            $costing_sql = mysqli_query($zconn,"select * from cutting_dc");
            $c=1;
            while($res_costing = mysqli_fetch_array($costing_sql,MYSQLI_ASSOC)){

            $style=$res_costing['style_no'];
 
             // $buyer_sql = mysqli_fetch_array(mysqli_query($zconn,"select * from costing_entry_master where id='".$style."'"));

            // $costing_date = date_from_db($res_costing['costing_date']);
            ?>
            <tr id="delete_<?php echo $c;?>">
                <td><?php echo $c;?></td>
                <td><?php echo $res_costing['style_no'];?></td>
                <td><?php echo $res_costing['fabric_name'];?></td>
                <td><?php echo $res_costing['color'];?></td>
                <td><?php echo $res_costing['wgt'];?></td>
                <td><?php echo $res_costing['cont_name'];?></td>
                <td><?php echo $res_costing['send_work'];?></td>
                <td><?php echo $res_costing['date'];?></td>
               <!--  <td>
                    <?php 

               echo $res_costing['process_flow'];
                     // $sql = mysqli_fetch_array(mysqli_query($zconn,"select * from process_groups where process_name='".$res_costing['process_flow']."'"),MYSQLI_ASSOC);
                     //     echo "(".$sql['process_flow'].")";
                    ?>
                        
                    </td> -->




                <td><a href="cutting_dc.php?id=<?php echo addslashes($res_costing['id']);?>"><i class="fas fa-edit"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <!-- <a href="view_knitt_planning.php?id=<?php echo addslashes($res_costing['id']);?>"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->


                    <a href="cutting_view.php?id=<?php echo ($res_costing['id']);?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
            </tr>
            <?php $c++;} ?>
                    </tbody>
                </table>
            </div>
            </form>
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
        $(document).ready(function() {
            //$('#example').DataTable();
            $('#example').DataTable();
        });
    </script>

</body>
</html>
<?php 
include('includes/config.php');
//print_r($_POST);
if($_SESSION['userid']==''){
	echo "<script>window.location.href='login.php';</script>";
}
$id=$_GET['id'];
if(isset($_POST['submit1'])){
	extract($_POST);
	$sel_entry1 = mysqli_query($zconn,"delete from accessories_planning where planning_id='".$_GET['id']."'");

	if ($id!='') {
		$insert_fab_costing = mysqli_query($zconn,"update  accessories_planning_list set costing_no='".$costing_no."', order_no='".$_POST['order']."',style_no='".$_POST['style_no']."',total='".$_POST['grand_tot']."',total_loss='".$_POST['grand_loss']."',created_by='".$_SESSION['userid']."',created_date=now(),buyer='".$_POST['buyer']."',accessor_group='".$accessor_group."'  where costing_no='$id'");	
	}else{
		$insert_fab_costing = mysqli_query($zconn,"insert into accessories_planning_list(costing_no,order_no,style_no,total,total_loss,created_by,created_date,buyer,accessor_group) values('".$costing_no."','".$_POST['order']."','".$_POST['style_no']."','".$_POST['grand_tot']."','".$_POST['grand_loss']."','".$_SESSION['userid']."',now(),'".$_POST['buyer']."','".$accessor_group."')");
}

	$trows = count($_POST['acc_name']);
	$last_id = mysqli_insert_id($zconn);
	for($i=0;$i<$trows;$i++){
		$insert_fab_costing = mysqli_query($zconn,"insert into accessories_planning(costing_no,planning_id,acc_name,uom,order_qty,consumption,total_qty,descr,acc_loss,created_by,created_date) values('".$costing_no."','".$last_id."','".$_POST['acc_name'][$i]."','".$_POST['uom'][$i]."','".$_POST['order_qty'][$i]."','".$_POST['consumption'][$i]."','".$_POST['total_qty'][$i]."','".$_POST['descr'][$i]."','".$_POST['acc_loss'][$i]."','".$_SESSION['userid']."',now())");
	}
		echo "<script>alert('Fabric Planning Added successfully);</script>";
		echo "<script>window.location.href='accessories_planning_list.php';</script>";
}

		$res_costing_dt= mysqli_fetch_array(mysqli_query($zconn,"select * from costing_entry_master where id='".$_REQUEST['costing_no']."'"),MYSQLI_ASSOC);
		$sel_buyer = mysqli_fetch_array(mysqli_query($zconn,"select buyer_name from buyer_master where buyer_id='".$res_costing_dt['buyer_id']."'"),MYSQLI_ASSOC);

		$sel_entry1 = mysqli_fetch_array(mysqli_query($zconn,"select * from accessories_planning_list where costing_no='".$_GET['id']."'"),MYSQLI_ASSOC);
		
		
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
    <title><?php echo SITE_TITLE;?> - Accessories Requistion Entry</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">

	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
	<script src="dist/js/jquery.min.js"></script>
	<script src="dist/js/chosen.jquery.min.js"></script>
</head>

<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
    <div id="main-wrapper">
        <!-- Topbar header - style you can find in pages.scss -->
        <?php include('includes/header.php');?>
        <!-- End Topbar header -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <?php include('includes/sidebar.php');?>
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="min-height: 100%; height: auto;">

            <!-- Bread crumb and right sidebar toggle -->
             <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Accessories Requistion Entry</h4>
						<h4 class="page-title"></h4> &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="requstion.php"> <button type="button" class="btn btn-info">Requistion</button></a>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="requistion.php">Accessories Requistion</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Sales chart -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
								<div class="card-body" style="width:100%">
		<div class="card-body" style="width:100%">
			<div class="card" style="width:50%; float:left; left: 50px; ">
			<div class="form-group row">
			<label for="lname" class="col-sm-3 text-right control-label col-form-label">Order No</label>
			<div class="col-sm-6">
		<select class="select2 form-control custom-select chosen-select" name="order" id="order" required onchange="this.form.submit();">
			<option value="">Select</option>
			<?php
			
			
		  $order = mysqli_query($zconn,"select * from order_entry_master where (`order_no`,`style_no`) NOT IN(select order_no,style_no from accessories_planning_list)  and (`order_no`,`style_no`) IN (select order_no,style_no from process_planning_flow)");
			while($res_buyer = mysqli_fetch_array($order,MYSQLI_ASSOC)){
			if($_POST['order']==$res_buyer['order_no']){  ?>
			<option selected value="<?php echo $res_buyer['order_no'];?>"><?php echo $res_buyer['order_no'];?></option>
			<?php } else { ?>
			<option value="<?php echo $res_buyer['order_no'];?>"><?php echo $res_buyer['order_no'];?></option>
			<?php } ?>
			<?php } ?>
		</select>
	
			</div>
		</div>

		<?php 
		
		$sel_order = mysqli_query($zconn,"select * from order_entry_master where order_no='".$_POST['order']."'");
			$res_order = mysqli_fetch_array($sel_order,MYSQLI_ASSOC);
		?>
			<div class="form-group row">
    <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Style No</label>
    <div class="col-sm-6">
        <?php if(empty($_REQUEST['order']) && empty($_POST['order'])) { ?>
            <input type="text" class="form-control" readonly name="style_no" value="">
        <?php } else { ?>
            <input type="text" class="form-control" readonly name="style_no" value="<?php echo $res_order['style_no']; ?>">
        <?php } ?>
    </div>
</div>
		
			
			</div>

			
		<div class="card" style="width:50%; float:left; right: 50px;">
			<div class="form-group row">
				<label for="fname" class="col-sm-3 text-right control-label col-form-label">Buyer name</label>
				<div class="col-sm-6">
				<?php if($_REQUEST['costing_no']==''){?>
				<input type="text" class="form-control" readonly id="lname" name="buyer" value="<?php echo $res_order['buyer_name'];?>">
			<?php } else { ?>
					<input type="text" class="form-control" readonly id="buyer_name" value="<?php echo $res_order['buyer_name']; ?>" name="buyer_name" placeholder="">
			<?php } ?>
			</div>
			</div>
			<?php 
				$created_arr = explode(" ",$res_order['created_date']);
				$created_arr1 = explode("-",$created_arr['0']);
				$cr_date = $created_arr1['2']."-".$created_arr1['1']."-".$created_arr1['0'];

			?>
			<div class="form-group row">
				<label for="cono1" class="col-sm-3 text-right control-label col-form-label">Order Date</label>
				<div class="col-sm-6">
			<?php if($_REQUEST['costing_no']==''){?>
				<input type="text" class="form-control"  value="<?php echo $cr_date; ?>" readonly id="order_date">
			<?php } else {?>
					<input type="date" class="form-control" readonly id="order_date" value="<?php echo $cr_date; ?>" name="order_date">
			<?php } ?>
				</div>
			</div>
		</div>

<div class="form-group">
		<h4 class="page-title"><b>Component Details</b></h4>
	
	<table id="componentTable" class="table table-striped table-bordered">
		<thead style="background-color: #626F80; color: #fff; padding: 0px; font-size: 16px;">
			<tr>
				<th>Order No</th>
				<th>Style No</th>
				<th>Pcs Weight</th>
				<th>Order Quantity + Excess</th>
				<th>Total Weight [KGS]</th>
			</tr>
		</thead>
        	<?php
        	 $coso = mysqli_fetch_array(mysqli_query($zconn,"SELECT * FROM `costing_entry_master` where order_no='".$_REQUEST['order']."' "),MYSQLI_ASSOC);
			 $cost_ido=$coso['id'];
			 if ($cost_ido!='') {
			 $cos = mysqli_fetch_array(mysqli_query($zconn,"SELECT * FROM `costing_entry_master` where order_no='".$_REQUEST['order']."' "),MYSQLI_ASSOC);
			 $sel_c = mysqli_query($zconn,"SELECT distinct(costing_id)  FROM `costing_entry_details` where costing_id='".$cos['id']."'");
			 $order = mysqli_fetch_array(mysqli_query($zconn,"SELECT * FROM `order_entry_master` where order_no='".$_REQUEST['order']."' "),MYSQLI_ASSOC);	
			 }
			 else{
			 $cos = mysqli_fetch_array(mysqli_query($zconn,"SELECT * FROM `order_entry_master` where order_no='".$_REQUEST['order']."' "),MYSQLI_ASSOC);
			 $sel_0 = mysqli_query($zconn,"SELECT distinct(yarn_id) FROM `order_quantity_details` where yarn_id='".$cos['id']."'");

			 $order = mysqli_fetch_array(mysqli_query($zconn,"SELECT * FROM `order_entry_master` where order_no='".$_REQUEST['order']."' "),MYSQLI_ASSOC);
			 }

			if ($sel_c!='') {
				$sel=$sel_c;
				$tb="costing_entry_details";
				$cond="costing_id";
			} else {
				$sel=$sel_0;
				$tb="yarn_entry_details";
				$cond="yarn_id";
			}
			$tow =0;
			while($resc=mysqli_fetch_array($sel)){ 
			 	$pcs = mysqli_fetch_array(mysqli_query($zconn,"SELECT sum(pcs_weight) as pcs_weight FROM $tb where  $cond='".$cos['id']."'"),MYSQLI_ASSOC);

			//	$exc_cal = ($order['excess_percent']*$order['order_qty'])/100;
				$exc_cal = ($order['excess_percent']*$order['cutting_qty'])/100;
				$excess_cal = $order['cutting_qty'];

			//	$print_order_qty = $order['order_qty']*$order['excess_percent'];
			$pcsweight = number_format($pcs['pcs_weight'], 2, '.', "");
			$tow =$pcsweight*$excess_cal;
			 	?>
				<tr>
					<td><?php echo $_REQUEST['order'];?></td>
					<td><?php echo $_REQUEST['style_no'];?></td>
					<td><?php echo $pcsweight;?><input type="hidden" name="pcs_weight" class="form-control" value="<?php echo $pcs['pcs_weight'];?>"></td>
					<td><?php echo $excess_cal;?><input type="hidden" name="order_qty" class="form-control"  value="<?php echo $excess_cal;?>"></td>
					<td><?php echo number_format($tow, 2, '.', "");?><input type="hidden" name="totweight[]" class="form-control" value="<?php echo number_format($tow, 2, '.', "");?>" id="totweight"></td>
				</tr>
			<?php }
			 ?>
    </table>
	</div>
<br>
<br>
<br>
	<!-- <div class="form-group row">
	<label for="lname" class="col-sm-2 text-right control-label col-form-label"> Accessories Group</label>
	<div class="col-sm-3 text-left" >

	<select class="select2 form-control custom-select chosen-select" name="accessor_group" id="accessor_group" onchange="this.form.submit();" required>
	<option>Select</option>
	<!?php $accssor= mysqli_query($zconn,"select distinct(acc_group) as acc_group_name from accessories_group_details");
	while($assgroup=mysqli_fetch_array($accssor)){
		?>
		<option value="<!?php echo $assgroup['acc_group_name'];?>" <!?php if ($assgroup['acc_group_name']==$_REQUEST['accessor_group']) {
			echo "selected";
			}?> ><!?php echo $assgroup['acc_group_name'];?></option>
			<!?php } ?>
	</select>
	
	</div>
	</div> -->
	<div class="form-group row">
				<h4 class="page-title"><b>Material Details</b></h4>
			
	<table id="example" class="table table-striped table-bordered">
		<thead style="background-color: #626F80; color: #fff; padding: 0px; font-size: 12px;">
			<tr>
				<th>Accessories Name</th>
				<th>UOM</th>
				<th>Total Planed Pcs</th>
				<th>Consumption</th>
				<th>Total Qty</th>
				
				<!-- <th>Rate</th>
				<th>TotalPrice</th> -->
				<th>Loss</th>
				<th><button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i></button></th>
			</tr>
		</thead>
		<tbody>
	
		
					<?php 
						
							if (isset($_REQUEST['order'])) {
								$order_no = $_REQUEST['order'];
							
								$ass_group_query = mysqli_query($zconn, "SELECT costing_no FROM accessories_costing_list WHERE order_no='$order_no'");
								$ass_group_data = mysqli_fetch_array($ass_group_query, MYSQLI_ASSOC);
								
								$costing_no = $ass_group_data['costing_no'];
							
								// Now you have the `costing_no`, you can fetch more data from another table
								$asscost_query = mysqli_query($zconn, "SELECT * FROM accessories_costing WHERE costing_no='$costing_no'");
							
								while ($assdata = mysqli_fetch_array($asscost_query, MYSQLI_ASSOC)) { ?>
		<tr id="rowhide" value="<?php echo $id;?>" >
		<input type="hidden" name="rowid" id="rowid_<?php echo $id;?>" value="<?php echo $id;?>">
		<td>
			<select class="select2 form-control custom-select chosen-select" style="width:100px" name="acc_name[]" id="acc_name_<?php echo $id;?>">
				<option>Select</option>
				<?php $sel_fabric = mysqli_query($zconn,"select * from accessories_master");
			while($res_fabric=mysqli_fetch_array($sel_fabric,MYSQLI_ASSOC)){ 
				if($res_fabric['acc_name']==$assdata['acc_name']){ ?>
			<option value="<?php echo $res_fabric['acc_name'];?>" selected><?php echo $res_fabric['acc_name'];?></option>
			<?php } else{?>
				<option value="<?php echo $res_fabric['acc_name'];?>"><?php echo $res_fabric['acc_name'];?></option>
			<?php } }?>
			</select>
			<script type="text/javascript">
												$(".chosen-select").chosen({
											  	no_results_text: "Oops, nothing found!"
												})
											</script>
		</td>
		<td>
			<select class="select2 form-control custom-select" name="uom[]" style="width:120px;"> 
				<option>Select</option>
					<?php $sel_fabric = mysqli_query($zconn,"select * from uom_master where status='0'");
						while($res_fabric=mysqli_fetch_array($sel_fabric,MYSQLI_ASSOC)){ 
							if($res_fabric['uom_name']==$assdata['uom']){ ?>
							<option selected="selected" value="<?php echo $res_fabric['uom_name'];?>"><?php echo $res_fabric['uom_name'];?></option>
					<?php } else{?>
	<option value="<?php echo $res_fabric['uom_name'];?>"><?php echo $res_fabric['uom_name'];?></option>
	<?php } } ?>
	</select>
	<td>
    <input type="text" name="order_qty[]" class="form-control order_qty" value="<?php echo $excess_cal;?>" onkeyup="cal_total();" onblur="cal_total();">
</td>
<td>
    <input type="text" class="form-control consumption" value="" name="consumption[]" autocomplete="off" onkeyup="cal_total();" onblur="cal_total();">
</td>
<td>
    <input type="text" class="form-control total_qty" value="<?php echo $assdata['total_qty']; ?>" name="total_qty[]" readonly>
</td>
<!-- <td>
    <input type="text" class="form-control rate" readonly value="<?php echo $assdata['rate']; ?>" name="rate[]" placeholder="Rate" autocomplete="off" onkeyup="cal_total();" onblur="cal_total();">
</td>
<td>
    <input type="text" class="form-control tramt" readonly value="" name="total[]" placeholder="Total">
</td> -->
				<td>
						<input type="text" class="form-control acc_loss" value="0" name="acc_loss[]" id="acc_loss0" placeholder="Total" onkeyup="cal_loss();">
				</td>
				<td>
					<a class="delete" title="Delete"><button type="button" class="btn btn-info add-new"><i class="fa fa-minus"></i></button></a>
				</td>
			</tr>
		

		</tbody>
		<?php }  }?>
		
			<tr id="delete_0">
				<td></td>
				<td></td>
				
				<td><?php
	$sel_fabric = mysqli_fetch_array(mysqli_query($zconn,"select * from order_entry_master where order_no='".$_REQUEST['order_no']."' or order_no='".$sel_entry1['order_no']."'"),MYSQLI_ASSOC);
	$order=$sel_fabric['order_qty']*$tot;
?>
<input type="hidden" class="form-control" id="order_tot" value="<?php echo $sel_fabric['order_qty']; ?>" readonly placeholder="" ></td>
				
				
				
				<td>
						Accessories Total Price:
				</td>
				<td>
				<input type="text" class="form-control" id="grand_tot" name="grand_tot" value="0" placeholder="" style="border: 1px solid #000;">
				</td>
				<td>
					<input type="text" class="form-control" id="grand_loss" name="grand_loss" value="<?php echo $tot_loss; ?>" readonly placeholder="" style="border: 1px solid #000;">
				</td>
				
			</tr>
		
	</table>
							<div class="border-top">
								<div class="card-body" style="margin-left: 250px;">
									<button type="submit" name="submit1" value="save" class="btn btn-success">Save</button>
									<button type="reset" class="btn btn-primary">Reset</button>
									<a href="accessories_requistion_list.php"><button type="button" class="btn btn-danger">List</button></a>
								</div>
							</div>
                        </div>
                    </div>
                </div>
                <!-- Sales chart -->
            </div>
            <!-- End Container fluid  -->
        </div>
        </div>
        <!-- End Page wrapper  -->
    </div>
    </form>
    <!-- End Wrapper -->
	<!-- ============================================================== -->
            <!-- footer -->
            <?php include('includes/footer.php');?>
            <!-- End footer -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

	<script type="text/javascript">
	function cal_loss(){
		var loss=0;
		
		$('.acc_loss').each(function(){
			loss += parseFloat($(this).val());
		});

		$('#grand_loss').val(loss.toFixed(2));
		
	}
	// function cal_amt(id){
	// 	var cons = $('#consumption'+id).val();
	// 	var rat = $('#rate'+id).val();
	// 	var ctrws=0;
	// 	if(rat){
	// 		ctrws = parseFloat(cons)*parseFloat(rat);
	// 	} 
	// 	$('#total_qty'+id).val(ctrws);

	// 	var sum = 0;
	// 	$('.tramt').each(function(){
	// 		sum += parseFloat($(this).val());
	// 	});

	// 	$('#grand_tot').val(sum);
	// 		//planning_total();
	// }


	$(document).ready(function() {
    // Function to calculate and update the grand total
    function calculateGrandTotal() {
        var grandTotal = 0;
        
        // Loop through all rows with class 'total_qty'
        $('.total_qty').each(function() {
            var qty = parseFloat($(this).val()) || 0; // Parse the value as a float, default to 0 if not a number
            grandTotal += qty;
        });
        
        // Update the 'grand_tot' input field with the calculated grand total
        $('#grand_tot').val(grandTotal.toFixed(2)); // Display the sum with 2 decimal places
    }

    // Call the calculateGrandTotal function initially
    calculateGrandTotal();

    // Attach a change event handler to all elements with class 'total_qty'
    $('.total_qty').on('input', function() {
        calculateGrandTotal(); // Recalculate the grand total when 'total_qty' values change
    });
});


// function planning_total(){

// 	var ord = $('#order_tot').val();
// 	var tot=$('#grand_tot').val();	
// 	$('#grand_tot').val(tot*ord);
// }

	<?php
	$sel_fabric = mysqli_query($zconn,"select * from accessories_master");
	$acc_list='';
	while($res_fabric=mysqli_fetch_array($sel_fabric,MYSQLI_ASSOC)){ 
		$acc_list .="<option value='".$res_fabric['acc_name']."'>".$res_fabric['acc_name']."</option>";
		} 
		
		$sel_uom = mysqli_query($zconn,"select * from uom_master");
	$uom_list='';
	while($res_color=mysqli_fetch_array($sel_uom,MYSQLI_ASSOC)){ 
		$uom_list .="<option value='".$res_color['uom_name']."'>".$res_color['uom_name']."</option>";
		} 
		?>
		
		
		$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    // Function to add a new row below the thead but above the first tbody
    function addRowBelowThead(tableId) {
        var acc_list = "<?php echo $acc_list; ?>";
        var uom_list = "<?php echo $uom_list; ?>";

        var row = '<tr>' +
            '<td><select class="select2 form-control custom-select chosen-select" name="acc_name[]"><option> Select</option>' + acc_list + '</select></td>' +
            '<td><select class="select2 form-control custom-select" name="uom[]"><option> Select</option>' + uom_list + '</select></td>' +
            '<td><input type="text" class="form-control" placeholder="consumption" name="consumption[]"></td>' +
            '<td><textarea name="descr[]"></textarea></td>' +
            '<td><input type="text" class="form-control" placeholder="Rate" name="rate[]"></td>' +
            '<td><input type="text" class="form-control tramt" name="total[]" readonly placeholder="Total"></td>' +
            '<td><input type="text" class="form-control acc_loss" value="0" name="acc_loss[]" placeholder="Total" onkeyup="cal_loss();"></td>' +
            '<td><a class="delete" title="Delete"><button type="button" class="btn btn-info add-new"><i class="fa fa-minus"></i></button></a></td>' +
            '</tr>';

        $("#" + tableId + " tbody:first").prepend(row); // Prepend to the first tbody
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!"
        });
    }

    // Add a new row when the "Add New" button is clicked for the example table
    $("#example .add-new").click(function () {
        addRowBelowThead("example");
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Delete row on delete button click
    $(document).on("click", "#example .delete", function () {
        $(this).closest("tr").remove();
    });
});

$(document).on("keyup blur", ".order_qty, .consumption, .rate", function () {
    // Find the closest row element
    var row = $(this).closest("tr");

    // Get the values from the 'order_qty', 'consumption', and 'rate' fields within the row
    var orderQty = parseFloat(row.find(".order_qty").val()) || 0;
    var consumption = parseFloat(row.find(".consumption").val()) || 0;
    var rate = parseFloat(row.find(".rate").val()) || 0;

    // Calculate the 'total_qty' for the row
    var totalQty = orderQty * consumption;

    // Update the 'total_qty' input field within the same row
    row.find(".total_qty").val(totalQty.toFixed(2));

    // Calculate the 'total' for the row based on 'total_qty' and 'rate'
    var rowTotal = totalQty * rate;

    // Update the 'total' input field within the same row
    row.find(".tramt").val(rowTotal.toFixed(2));

    // Calculate the total of all 'total' values for all rows
    var grandTotal = 0;
    $(".tramt").each(function () {
        var rowTotalValue = parseFloat($(this).val()) || 0;
        grandTotal += rowTotalValue;
    });

    // Update the 'grand_tot' input field with the calculated grand total
    $("#grand_tot").val(grandTotal.toFixed(2));
});



// Calculate total for all rows when the page loads
$(document).ready(function() {
    // Calculate total for existing rows
    $("table tbody tr").each(function() {
        var rowIndex = $(this).index();
        cal_total(rowIndex);
    });

    // Add row on add button click
    $(".add-new").click(function() {
        var index = $("table tbody tr:last-child").index();
        var newRow = '<tr>' +
            // ... (other <td> elements) ...

            '<td><input type="text" class="form-control tramt" readonly name="total[]" data-row-index="' + (index + 1) + '" placeholder="Total"></td>' +
            '</tr>';
        $("table tbody").append(newRow);
        cal_total(index + 1); // Calculate total for the new row
    });
});

// function cal_total(rowId) {
//     // Get the values from the order_qty and consumption fields for the specified row
//     var orderQty = parseFloat(document.getElementById('order_qty' + rowId).value);
//     var consumption = parseFloat(document.getElementById('consumption' + rowId).value);

//     // Calculate the 'total_qty' for the specified row
//     var totalQty = orderQty * consumption;

//     // Update the 'total_qty' input field for the specified row
//     document.getElementById('total_qty' + rowId).value = totalQty;
// }

// Calculate 'total_qty' for all rows below the material table
// function calculateTotalQtyForMaterialDetailsRows() {
//     // Define the number of material rows below the material table
//     var numRowsBelowMaterialDetailsTable = <?php echo $numRowsBelowMaterialDetailsTable; ?>; // Replace with the actual number

//     for (var i = 0; i < numRowsBelowMaterialDetailsTable; i++) {
//         cal_total(i);
//     }
// }

// // Call the calculateTotalQtyForMaterialRows function to calculate 'total_qty' for rows below the material table when the page loads
// window.onload = calculateTotalQtyForMaterialDetailsRows;
</script>
<script>

</script>
</body>
</html>




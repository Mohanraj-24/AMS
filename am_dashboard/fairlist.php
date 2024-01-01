<?php 
include('../header_am.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_fare_list.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != ''){
  $temp = urldecode($_GET['id']);
	$sqlx= "DELETE FROM `tbl_add_amenity` WHERE amenity = '$temp'";
	mysqli_query($conn,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['added_rent_successfully'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['update_rent_successfully'] ;
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['rent_list'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>am_dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_rent_information_breadcam'];?></li>
	<li class="active"><?php echo $_data['rent_list'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i><?php echo $_data['delete_text'];?> !</h4>
      <?php echo $_data['delete_rent_information'];?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i><?php echo $_data['success'];?> !</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>am_dashboard/addfair.php" data-original-title="<?php echo $_data['add_new_rent_breadcam'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>am_dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['rent_list'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo "Amenity";?></th>
              <th><?php echo "Rent";?></th>
              <th><?php echo "Branch Id";?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
        <?php
		$result = mysqli_query($conn, "Select * from tbl_add_amenity where branch_id = " . (int)$_SESSION['objLogin']['branch_id']);
				while($row = mysqli_fetch_array($result)){
				?>
            <tr>
            <td><?php echo $row['amenity']; ?></td>
            <td><?php echo "Rs.".$row['rent']; ?></td>
            <td><?php echo $row['branch_id']; ?></td>
            
            <td>
            <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>am_dashboard/addfair.php?id=<?php echo $row['amenity']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" data-amenity-id="<?php echo $row['amenity']; ?>" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
            </td>
            </tr>
            <?php } mysqli_close($conn); ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    // Attach click event using jQuery
    $('.btn-danger').on('click', function() {
        var amenityId = $(this).data('amenity-id'); // Assuming you have a data attribute for amenity ID
        deleteFair(amenityId);
    });
});
function deleteFair(Id){
  	var iAnswer = confirm("Are you sure you want to delete this Fair ?");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>am_dashboard/fairlist.php?id=' +Id;
	}
  }
  
  $( document ).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
</script>
<?php include('../footer.php'); ?>

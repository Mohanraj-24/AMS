<?php 
include('../header_am.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_fare.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$rent = '0.00';
$issue_date = '';
$branch_id = '';
$title = $_data['add_new_rent'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_rent_successfully'];
$form_url = WEB_URL . "am_dashboard/addfair.php";
$id="";
$hdnid="0";
$message='';
if(isset($_POST['txtRent'])){
  $sql=mysqli_query($conn,"SELECT count(*) as count FROM tbl_add_amenity where amenity='$_POST[txtRentName]'");
  $rowcount=mysqli_fetch_array($sql);
if($rowcount['count']==0){
	$sql = "INSERT INTO tbl_add_amenity(amenity,rent,branch_id) values('$_POST[txtRentName]','$_POST[txtRent]','".$_SESSION['objLogin']['branch_id']."')";
	mysqli_query($conn,$sql);
	mysqli_close($conn);
	$url = WEB_URL . 'am_dashboard/fairlist.php?m=add';
	header("Location: $url");
}
else{
	$sql = "UPDATE `tbl_add_amenity` SET amenity='".$_POST['txtRentName']."',`rent`='".$_POST['txtRent']."'WHERE amenity='".$_GET['id']."'";
  mysqli_query($conn,$sql);
	$url = WEB_URL . 'am_dashboard/fairlist.php?m=up';
	header("Location: $url");
	}
	$success = "block";
}
if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($conn, "SELECT * FROM tbl_add_amenity where amenity='".$_GET['id']."'");
	while($row = mysqli_fetch_array($result)){
		$form_url = WEB_URL . "am_dashboard/addfair.php?id=".$_GET['id'];
	}
  mysqli_close($conn);
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo $title; ?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>am_dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_rent_information_breadcam'];?></li>
    <li class="active"><?php echo $_data['add_new_rent_breadcam'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>am_dashboard/fairlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_rent_entry_form'];?></h3>
      </div>
     <form onSubmit="return validateMe();" action="<?php echo $form_url;?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="ddlFloorNo"><span class="errorStar">*</span>Amenity :</label>
            <select name="txtRentName" id="txtRentName" class="form-control">
              <option value="">--Select Amenity--</option>
                            <option  value="Gym">Gym</option>
                            <option  value="Swimming Pool">Swimming Pool</option>
                            <option  value="Badminton Court">Badminton Court</option>
                            <option  value="Basketball Court">Basketball Court</option>
            </select>
          </div>
          <div class="form-group">
            <label for="txtRent">Rent :</label>
            <div class="input-group">
              <input type="text" name="txtRent" onkeyup="calculateFairTotal();" value="0.00" id="txtRent" class="form-control" />
              <div class="input-group-addon"> Rs. </div>
            </div>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Save Information"/>
          </div>
        </div>
        <input type="hidden" value="0" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtRentName").val() == ''){
		alert("Amenity Required !!!");
		$("#txtRentName").focus();
		return false;
	}
	else if($("#txtRent").val() == ''){
		alert("Rent Required !!!");
		$("#txtRent").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>

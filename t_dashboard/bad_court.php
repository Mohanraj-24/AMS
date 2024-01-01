<?php include('../header_ten.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_unit_details.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
if(isset($_POST['txtCTitle']) && $_POST['txtCDate']){
    $d=$_POST['txtCDate'];
    $t=$_POST['txtCTitle'];
    $sql=mysqli_query($conn,"SELECT count(*) as count from tbl_amenity_bad_court where g_date='$d' and g_timezone='$t'");
    $countRow = mysqli_fetch_assoc($sql);
    $count = (int)$countRow['count'];
    if($count<=2)
    {
      if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
        $sqlx = "INSERT INTO tbl_amenity_bad_court(g_user_id,g_branch_id,g_date,g_timezone) values('".(int)$_SESSION['objLogin']['rid']."','" . $_SESSION['objLogin']['branch_id'] . "','$_POST[txtCDate]','$_POST[txtCTitle]')";
        mysqli_query($conn,$sqlx);
        $sqla=mysqli_query($conn,"SELECT g_id as gid from tbl_amenity_bad_court where g_user_id='".(int)$_SESSION['objLogin']['rid']."' and g_branch_id='" . $_SESSION['objLogin']['branch_id'] . "' and g_date='$_POST[txtCDate]' and g_timezone='$_POST[txtCTitle]'");
        $array=mysqli_fetch_assoc($sqla);
        $gid=(string)$array['gid'];
        mysqli_close($conn);
        $url = WEB_URL . 't_dashboard/bad_court_pay.php?gid='.$gid;
	      header("Location: $url");
      }
    }
    else{
      $message="Amenity Full";
      $url = WEB_URL . 't_dashboard/amenitylist.php';
      echo "<script type='text/javascript'>alert('$message');window.location.href = '$url';</script>";
  }
    $success = "block";
  }
?>
<section class="content-header">
  <h1> <?php echo 'Amenity Booking';?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>t_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo "Badminton Court";?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>t_dashboard.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo "Badminton Court";?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo WEB_URL?>t_dashboard/bad_court.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
        <div class="form-group">
            <label for="txtCDate">Date <span style="color:red;">*</span> :</label>
            <input type="text" name="txtCDate" value="" id="txtCDate" class="form-control datepicker"/>
          </div>
          <div class="form-group">
            <label for="txtCTitle">Time Zone<span style="color:red;">*</span> :</label>
            <select name="txtCTitle"  id="txtCTitle" class="form-control">
                <option value="">--Select Time Zone--</option>
                <option value="Morning">Morning</option>
                <option value="Afternoon">Afternoon</option>
                <option value="Evening">Evening</option>
              </select>
          </div>
          
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Book Amenity"/>
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
	if($("#txtCTitle").val() == ''){
		alert("Title is Required !!!");
		$("#txtCTitle").focus();
		return false;
	}
	else if($("#txtCDate").val() == ''){
		alert("Date is  Required !!!");
		$("#txtCDate").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>

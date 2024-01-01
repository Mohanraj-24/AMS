<?php include('header_ten.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_admin_dashboard.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<?php
if($_SESSION['login_type'] != '4'){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$total_rent = 0;
$result_amount = mysqli_query($conn, "SELECT sum(rent) as total FROM tbl_add_fair where rid =".(int)$_SESSION['objLogin']['rid']);
if($row_amount_total = mysqli_fetch_array($result_amount)){
	$total_rent = $row_amount_total['total'];
}
$res=mysqli_query($conn,"SELECT COUNT(*) as c FROM tbl_pay where rid=".(int)$_SESSION['objLogin']['rid']);
$rowcount=mysqli_fetch_array($res);
$count=$rowcount['c'];

$msg="You have an unpaid rent";
if($count>0)
echo "<script type='text/javascript'>alert('$msg');</script>";
// if($count>0){
//   $msg="You have an unpaid rent";
//   $url= WEB_URL ."t_dashboard/r_report.php";
// echo "<script type='text/javascript'>alert('$count');window.location.href = '$url';</script>";}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $_data['rented_dashboard'];?><small><?php echo $_data['c_panel'];?></small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>t_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo"Home";?></a></li>
    <li class="active"><?php echo $_data['menu_dashboard'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- /.row start -->
  <div class="row home_dash_box">
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?php echo CURRENCY.$total_rent; ?></h3>
          <p><?php echo $_data['rented_statement'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/report.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/tenant_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Pay</h3>
          <p><?php echo "Rent";?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/fund.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/r_report.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Book</h3>
          <p><?php echo $_data['main_req'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/maintenance.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/addtcomplain.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Bulletin</h3>
          <p><?php echo "Board";?></p>
        </div>
        <div class="icon"> <img height="70" width="80" src="img/insta.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/index.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Book</h3>
          <p><?php echo "Amenity";?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/amenity.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/amenitylist.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>View</h3>
          <p><?php echo $_data['unit_details'];?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="img/rented.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/unit_details.php" class="small-box-footer"><?php echo $_data['dashboard_more_info'];?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
  </div>
  <!-- /.row end -->
</section>
<!-- /.content -->
<?php include('footer.php'); ?>

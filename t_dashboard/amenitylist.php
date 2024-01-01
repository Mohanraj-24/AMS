<?php include('../header_ten.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_admin_dashboard.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
?>
<?php
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo "Amenity List";?><small><?php echo $_data['c_panel'];?></small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>t_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo"Home";?></a></li>
    <li class="active"><?php echo "Amenity";?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- /.row start -->
  <div class="row home_dash_box">
    <!-- col start -->
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Gym</h3>
          <p><?php echo "Amenity";?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="../img/gym.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/gym.php" class="small-box-footer"><?php echo "Book Amenity";?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Swimming Pool</h3>
          <p><?php echo "Amenity";?></p>
        </div>
        <div class="icon"> <img height="80" width="80" src="../img/swim_pool.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/swim_pool.php" class="small-box-footer"><?php echo "Book Amenity";?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>Badminton Court</h3>
          <p><?php echo "Amenity";?></p>
        </div>
        <div class="icon"> <img height="80" width="70" src="../img/bad_court.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/bad_court.php" class="small-box-footer"><?php echo "Book Amenity";?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
    <!-- col start -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>BasketBall Court</h3>
          <p><?php echo "Amenity";?></p>
        </div>
        <div class="icon"> <img height="80" width="67" src="../img/baske_court.png"></a> </div>
        <a href="<?php echo WEB_URL; ?>t_dashboard/bask_court.php" class="small-box-footer"><?php echo "Book Amenity";?> <i class="fa fa-arrow-circle-right"></i></a> </div>
    </div>
    <!-- ./col end -->
  </div>
  <!-- /.row end -->
</section>
<!-- /.content -->
<?php include('../footer.php'); ?>

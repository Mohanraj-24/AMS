<?php
ob_start();
session_start();
include("../config.php");
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
$lang_code_global = "English";
$query_ams_settings = mysqli_query($conn, "SELECT * FROM tbl_settings");
if($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){
	$lang_code_global = $row_query_ams_core['lang_code'];
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_r_all_info.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
$delinfo = 'none';
if(isset($_GET['fid']) && $_GET['fid'] != ''){
  $url = WEB_URL . 't_dashboard/amenitylist.php';
	header("Location: $url");
	$delinfo = 'block';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Apartment Management System</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.4 -->
<link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Font Awesome Icons -->
<link href="<?php echo WEB_URL; ?>dist/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo WEB_URL; ?>dist/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo WEB_URL; ?>dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins 
 folder instead of downloading all of them to reduce the load. -->
<link href="<?php echo WEB_URL; ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck for checkboxes and radio inputs -->
<link href="<?php echo WEB_URL; ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>dist/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_URL; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- jQuery 2.1.4 -->
<script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo WEB_URL; ?>dist/js/printThis.js"></script>
<script src="<?php echo WEB_URL; ?>dist/js/common.js"></script>
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<section class="content">
<!-- Main content -->
<div id="printable">
  <div align="center" style="margin:50px;">
    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 style="text-decoration:underline;font-weight:bold;color:orange" class="box-title"><?php echo $_data['text_1'];?></h3>
          </div>
          <div class="box-body">
            <table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th><?php echo "User ID";?></th>
                  <th><?php echo "Branch ID";?></th>
                  <th><?php echo "Date";?></th>
                  <th><?php echo "Session";?></th>
                  <th><?php echo "Payable Amount";?></th>
                </tr>
              </thead>
              <tbody>
            <?php
			  $result = mysqli_query($conn, "select * from tbl_amenity_bad_court where g_id='".$_GET['gid']."'");
				while($row = mysqli_fetch_array($result))
                {
                  $res=mysqli_query($conn,"SELECT rent as r from tbl_add_amenity where amenity='Badminton Court'");
                  $am=mysqli_fetch_assoc($res);
				$amount=$am['r'];
				?>
                <tr>
                  <td><?php echo $row['g_user_id']; ?></td>
                  <td><?php echo $row['g_branch_id']; ?></td>
                  <td><?php echo $row['g_date']; ?></td>
                  <td><?php echo $row['g_timezone']; ?></td>
                  <td><?php echo $amount. " ".CURRENCY; ?></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th style="color:red;"><?php echo number_format($amount, 2, '.', '') . ' ' . CURRENCY; ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.row -->
<div align="center"><a class="btn btn-primary btn_save" onClick="deleteComplain(<?php echo $row['g_id']; ?>);" href="javascript:;"><?php echo "PAY";?></a></div><br></br>
<div align="center"><a class="btn btn-primary btn_save" onClick="javascript:printContent('printable','Fair Collection Report');" href="javascript:void(0);"><?php echo $_data['text_16'];?></a></div>
</body>
</html>
<script>
  function deleteComplain(Id){
  	var iAnswer = confirm("Are you sure you want to Pay ?");
	if(iAnswer){
        alert("Amenity Booked");
		window.location = '<?php echo WEB_URL; ?>t_dashboard/bad_court_pay.php?fid=' + Id;
	}
  }
  </script>
  <?php } mysqli_close($conn); ?>

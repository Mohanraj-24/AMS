<?php 
include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_complain.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$c_title = '';
$c_date = '';
$c_month = '';
$c_year = '';
$c_userid = '';
$branch_id = '';
$title = $_data['text_1'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['text_8'];
$form_url = WEB_URL . "complain/addcomplain.php";
$id="";
$hdnid="0";
$employname='';
$c_desc='';

// if(isset($_POST['txtCTitle'])){
// 	$xmonth = date('m');
// 	$xyear = date('Y');
// 	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
// 	$sql = "INSERT INTO tbl_add_complain(c_title,c_description, c_date, c_month,c_year,c_userid,branch_id) values('$_POST[txtCTitle]','$_POST[txtCDescription]','$_POST[txtCDate]',$xmonth,$xyear,'".(int)$_SESSION['objLogin']['aid']."','" . $_SESSION['objLogin']['branch_id'] . "')";
// 	//echo $sql;
// 	//die();
// 	mysqli_query($conn,$sql);
// 	mysqli_close($conn);
// 	$url = WEB_URL . 'complain/complainlist.php?m=add';
// 	header("Location: $url");
	
// }
// else{
// 	$sql = "UPDATE `tbl_add_complain` SET `c_title`='".$_POST['txtCTitle']."',`c_description`='".$_POST['txtCDescription']."',`c_date`='".$_POST['txtCDate']."' WHERE complain_id='".$_GET['id']."'";
// 	//echo $sql;
// 	//die();
// 	mysqli_query($conn,$sql);
// 	$url = WEB_URL . 'complain/complainlist.php?m=up';
// 	header("Location: $url");
// }

// $success = "block";
// // }

// if(isset($_GET['id']) && $_GET['id'] != ''){
// 	$result = mysqli_query($conn, "SELECT * FROM tbl_add_complain where complain_id = '" . $_GET['id'] . "'");
// 	while($row = mysqli_fetch_array($result)){
		
// 		$c_title = $row['c_title'];
// 		$c_description = $row['c_description'];
// 		$c_date = $row['c_date'];
// 		$hdnid = $_GET['id'];
// 		$title = $_data['text_1_1'];
// 		$button_text = $_data['update_button_text'];
// 		$successful_msg = $_data['text_9'];
// 		$form_url = WEB_URL . "complain/addcomplain.php?id=".$_GET['id'];
// 	}
	
// 	//mysql_close($link);

// }
$res=mysqli_query($conn,"SELECT complain_id,c_title,c_description,c_date FROM tbl_add_complain where (branch_id='" . $_SESSION['objLogin']['branch_id'] . "') AND (complain_id='".$_GET['id']."')" );
$res3=mysqli_query($conn,"SELECT complain_id,c_title,c_description,c_date FROM tbl_add_complain where (branch_id='" . $_SESSION['objLogin']['branch_id'] . "') AND (complain_id='".$_GET['id']."')" );
$q5=mysqli_fetch_assoc($res3);
$c_desc=$q5['c_description'];
if(isset($_POST['assign']))
    {
      if($_SERVER["REQUEST_METHOD"]=="POST")
      {
        $employname=$_POST['employee_name'];
        $q3=mysqli_fetch_assoc($res);
        $cid=$q3['complain_id'];
        $res1=mysqli_query($conn,"SELECT * FROM tbl_add_employee where e_name='$employname'");
        $q4=mysqli_fetch_assoc($res1);
        $e_id=$q4['e_name'];
       
      
        $res2=mysqli_query($conn,"UPDATE tbl_add_complain set assign='$e_id' where complain_id='$cid'");
      
        $message = "Task Assigned Successfully";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
    }
?>

<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_2'];?></li>
    <li class="active"><?php echo $_data['text_3'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>complain/complainlist.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      <!--<form onSubmit="return validateMe();" action="<?php //echo WEB_URL?>complain/addcomplain.php" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="txtCTitle">Tittle <span style="color:red;">*</span> :</label>
            <input type="text" name="txtCTitle" value="" id="txtCTitle" class="form-control" />
          </div>
          <div class="form-group">
            <label for="txtCDescription">Description <span style="color:red;">*</span> :</label>
            <textarea name="txtCDescription" id="txtCDescription" class="form-control"></textarea>
          </div>
		  <div class="form-group">
		  <label for="txtCDescription">Specification <span style="color:red;">*</span> :</label>
					<select>
						<option>Plumber</option>
						<option>Electrician</option>
                        <option>Cleaner</option>
				    </select>
				</div>
          <div class="form-group">
            <label for="txtCDate">Date <span style="color:red;">*</span> :</label>
            <input type="text" name="txtCDate" value="" id="txtCDate" class="form-control datepicker"/>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="Save Information"/>
          </div>
        </div>
        <input type="hidden" value="0" name="hdn"/>
      </form> -->
      <!-- /.box-body -->
    <!-- </div> -->
    <!-- /.box -->
  <!-- </div> -->
<!-- </div> -->
<!-- /.row -->
<div style="padding:50px; margin-top:10px;">
   <table class="table table-bordered">
    <thead class="thead-dark" style="background-color: black; color: white;">
    <tr>
	  <th scope="col">Complain ID</th>
      <th scope="col">Description</th>
      <th scope="col">Specification</th>
      <th scope="col">Date</th>
    </tr>
       </thead>
      <?php
              while($rows=mysqli_fetch_assoc($res)){
             ?> 
       <tbody style="background-color: white; color: black;">
    <tr>
        
      <td><?php echo $rows['complain_id']; ?></td>
      <td><?php echo $rows['c_title']; ?></td>
      <td><?php echo $rows['c_description']; ?></td>
      <td><?php echo $rows['c_date']; ?></td>
        
        
    </tr>
       </tbody>
       <?php
} 
?>
          
</table>
</div>
</div>
</div>
</div>

<!-- <script type="text/javascript">
function validateMe(){
	if($("#txtCTitle").val() == ''){
		alert("Title is Required !!!");
		$("#txtCTitle").focus();
		return false;
	}
	else if($("#txtCDescription").val() == ''){
		alert("Description is Required !!!");
		$("#txtCDescription").focus();
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
</script> -->
<div class="row">
  <div class="col-md-12">
      <form method="post">
        <div class=form-froup>
          <select class="form-group" name="employee_name" style="margin-left:40%; width:250px;">
                <option> -- <?php echo $c_desc?> -- </option>
                  <?php
                      $e_name=mysqli_query($conn,"SELECT e_name from tbl_add_employee where e_designation='$c_desc'");
                      while($row=mysqli_fetch_array($e_name))
                      {
                  ?><option> <?php echo $row[0]; ?> </option>
                    <?php
                      }
                    ?>
          </select>
        </div>
        <div class="form-group">
          <input type="submit" name="assign" value="Assign task" class="btn btn-primary" style="margin-top:10px; margin-left:45%;">
        </div>
      </form>
  </div>
</div>
<?php include('../footer.php'); ?>

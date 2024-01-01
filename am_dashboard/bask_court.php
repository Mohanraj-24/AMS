<?php include('../header_am.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_employee_rented_details.php');
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> <?php echo "Tenant Details";?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>am_dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
	<li class="active"><?php echo "Tenant Details";?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div align="right" style="margin-bottom:1%;"><a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>am_dashboard.php" data-original-title="<?php echo $_data['dashboard'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo "Tenant Details";?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo "Tenant ID";?></th>
              <th><?php echo "Branch ID";?></th>
              <th><?php echo "Date";?></th>
              <th><?php echo "TimeZone";?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
				$result = mysqli_query($conn, "Select * from tbl_amenity_bask_court where g_branch_id='". (int)$_SESSION['objLogin']['branch_id'] . "'");
        
				
        while ($row = mysqli_fetch_array($result)) {
          
          
	        ?>
            <tr>
              <td><?php echo $row['g_user_id']; ?></td>
              <td><?php echo $row['g_branch_id']; ?></td>
              <td><?php echo $row['g_date']; ?></td>
              <td><?php echo $row['g_timezone'] ?></td>
              

              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#nurse_view_<?php echo $row['g_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a>
                <div id="nurse_view_<?php echo $row['g_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo "Booking Details";?></h3>
                      </div>
                      
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-6"> <br/>
                            <b><?php echo "Date";?> :</b> <?php echo $row['g_date']; ?><br/>
                           
                            
                          </div>
                          <div class="col-xs-6"> <br/>
                          <b><?php echo "TimeZone";?> :</b> <?php echo $row['g_timezone']; ?><br/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                </div></td>
            </tr>
            <?php } mysqli_close($conn); ?>
          </tbody>
          <tfoot>
            
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
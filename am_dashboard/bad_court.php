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
				$result = mysqli_query($conn, "Select * from tbl_amenity_bad_court where g_branch_id='". (int)$_SESSION['objLogin']['branch_id'] . "'");
        $res=mysqli_query($conn,"Select *,f.floor_no as ffloor,u.unit_no from tbl_add_rent r inner join tbl_add_floor f on f.fid = r.r_floor_no inner join tbl_add_unit u on u.uid = r.r_unit_no order by r.r_unit_no asc");
				
        while ($row = mysqli_fetch_array($result)) {
          $row1 = mysqli_fetch_array($res);
          if ($row1) {
            $image = WEB_URL . 'img/no_image.jpg';
          if (file_exists(ROOT_PATH . '/img/upload/' . $row1['image']) && $row1['image'] != '') {
            $image = WEB_URL . 'img/upload/' . $row1['image'];
          }
          } else {
            $image = WEB_URL . 'img/no_image.jpg';
          }
	        ?>
            <tr>
              <td><?php echo $row['g_user_id']; ?></td>
              <td><?php echo $row['g_branch_id']; ?></td>
              <td><?php echo $row['g_date']; ?></td>
              <td><?php echo $row['g_timezone'] ?></td>
              

              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onclick="$('#nurse_view_<?php echo $row['g_user_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a>
                <div id="nurse_view_<?php echo $row['g_user_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title"><?php echo $_data['text_1'];?></h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div><img style="width:200px;height:200px;border-radius:200px;" src="<?php echo $image;  ?>" /></div>
                        <div class="model_title"><?php echo $row1['r_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                        <div class="row">
                          <div class="col-xs-6"> <b><?php echo $_data['text_2'];?> :</b> <?php echo $row1['r_name']; ?><br/>
                            <b><?php echo $_data['text_8'];?> :</b> <?php echo $row1['r_email']; ?><br/>
                            <b><?php echo $_data['text_9'];?> :</b> <?php echo $row1['r_password']; ?><br/>
                            <b><?php echo $_data['text_3'];?> :</b> <?php echo $row1['r_contact']; ?><br/>
                            <b><?php echo $_data['text_10'];?> :</b> <?php echo $row1['r_address']; ?><br/>
                            <b><?php echo $_data['text_11'];?> :</b> <?php echo $row1['r_nid']; ?><br/>
                          </div>
                          <div class="col-xs-6"> <b>Floor No :</b> <?php echo $row1['ffloor']; ?><br/>
                            <b><?php echo $_data['text_4'];?> :</b> <?php echo $row1['unit_no']; ?><br/>
                            <b><?php echo $_data['text_5'];?> :</b> <?php echo $row1['r_advance'].' '.CURRENCY; ?><br/>
                            <b><?php echo $_data['text_6'];?> :</b> <?php echo $row1['r_rent_pm'].' '.CURRENCY; ?><br/>
                            <b><?php echo $_data['text_12'];?> :</b> <?php echo $row1['r_date']; ?><br/>
                            <b><?php echo $_data['text_7'];?> :</b>
                            <?php if($row1['r_status'] == '1'){echo $_data['active'];} else{echo $_data['expired'];}?>
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Device Log</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Device Log </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Log Data</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="userTable" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Direction</th>
                  <th>Log Status</th>
                  <th>RF Tag</th>
                  <th>QR Dispensor</th>
                  <th>QR scanner</th>
                  <th>ANPR</th>
                  <th>at_time</th>                  
                </tr>
              </thead>
              
              <tbody>
                <?php if ($device_log) : ?>
                  <?php foreach ($device_log as $k => $v) : ?>
                    <tr>
                      <td><?php echo $v['id']; ?></td>
                      <td><?php echo $v['deviceid']; ?></td>
                      <td><?php echo $v['devicename']; ?></td>
                      <td><?php echo $v['direction']; ?></td>
                      <td><?php echo $v['log_status']; ?></td>
                      <td><?php echo $v['uhf']; ?></td>
                      <td><?php echo $v['printer']; ?></td>
                      <td><?php echo $v['qrscanner']; ?></td>
                      <td><?php echo $v['anpr']; ?></td>                      
                      <td><?php echo $v['at_time']; ?></td>
                    </tr>
                  <?php endforeach ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();

    $("#userSideTree").addClass('active');
    $("#manageUserSideTree").addClass('active');
  });
</script -->
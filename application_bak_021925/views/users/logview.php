<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>User Log</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User Log/li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">User Log Data</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="userTable" class="table table-bordered table-striped table-hover">
              <thead> 
                <tr>
                  <th>#</th>
                  <th>UserID</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Log Status</th>
                  <th>at_time</th>                  
                </tr>
              </thead>
              
              <tbody>
                <?php if ($user_log) : ?>
                  <?php foreach ($user_log as $k => $v) : ?>
                    <tr>
                      <td><?php echo $v['id']; ?></td>
                      <td><?php echo $v['userid']; ?></td>
                      <td><?php echo $v['username']; ?></td>
                      <td><?php echo $v['email']; ?></td>
                      <td><?php echo $v['log_status']; ?></td>
                      <td><?php echo date('m/d h:i:sa', $v['at_time']); ?></td>
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
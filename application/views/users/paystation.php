<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Paystation</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Paystation</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if (in_array('createUser', $user_permission)) : ?>
          <a href="<?php echo base_url('users/createPTU') ?>" class="btn btn-success"> <i class="fa fa-plus"></i></a>
          <br /> <br />
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Paystation</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="userTable" class="table table-bordered table-striped table-hover">
              <thead>
                <tr> 
                  <th>Id</th>
                  <th>Name</th>
                  <th>vendor</th>
                  <th>accredition</th>
                  <th>accredit_date</th>
                  <th>valid_date</th>
                  <th>BIR_SN</th>
                  <th>issued_date</th>
                  <th>IP</th>
                  <th>location</th>
                  <?php if (in_array('updatePTU', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php if ($ptu_data) : ?>
                  <?php foreach ($ptu_data as $k => $v) : ?>
                    <tr>
                      <td><?php echo $v['id']; ?></td>
                      <td><?php echo $v['name']; ?></td>
                      <td><?php echo $v['vendor']; ?></td>
                      <td><?php echo $v['accredition'] ?></td>
                      <td><?php echo $v['accredit_date']; ?></td>
                      <td><?php echo $v['valid_date']; ?></td>
                      <td><?php echo $v['BIR_SN']; ?></td>
                      <td><?php echo $v['issued_date']; ?></td>
                      <td><?php echo $v['IP']; ?></td>
                      <td><?php echo $v['location']; ?></td>

                      <?php if (in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>

                        <td>
                          <?php if (in_array('updateUser', $user_permission)) : ?>
                            <a href="<?php echo base_url('users/editPTU/' . $v['id']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                          <?php endif; ?>
                          <?php if (in_array('deleteUser', $user_permission)) : ?>
                            <a href="<?php echo base_url('users/deletePTU/' . $v['id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                          <?php endif; ?>
                        </td>
                      <?php endif; ?>
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#userTable').DataTable();

    $("#userSideTree").addClass('active');
    $("#manageUserSideTree").addClass('active');
  });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Payment Terminal 
      <small>List </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Rates</li>
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

        
          <a href="<?php echo base_url('ptu/create') ?>" class="btn btn-success"> <i class="fa fa-plus"></i></a>
          <br /> <br />
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Payment Terminal List</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="datatables" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Vendor</th>
                  <th>accredition</th>
                  <th>Issued </th>
                  <th>Validate</th>
                  <th>BIR no</th>
                  <th>PTU date</th>
                  <th>location</th>
                  <?php if (in_array('updatePtu', $user_permission) || in_array('deletePtu', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($ptu_data as $k => $v) {
                ?>                
                  <tr>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['name']; ?></td>
                    <td><?php echo $v['vendor']; ?></td>
                    <td><?php echo $v['accredition']; ?></td>
                    <td><?php echo $v['accredit_date']; ?></td>
                    <td><?php echo $v['valid_date']; ?></td>
                    <td><?php echo $v['BIR_SN']; ?></td>
                    <td><?php echo $v['issued_date']; ?></td>
                    <td>
                      <a href="<?php echo base_url('ptu/edit/' . $v['id']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>                       
                      <a href="<?php echo base_url('ptu/delete/' . $v['id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>                      
                      </td>                    
                  </tr>
                <?php
                } ?>
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
    $('#datatables').DataTable();
    $("#ratesSideTree").addClass('active');
    $("#manageRatesSideTree").addClass('active');
  });
</script>
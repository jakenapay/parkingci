<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>RFID Vehicle</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">RFID Vehicle</li>
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
       
          <a href="<?php echo base_url('RFID/create') ?>" class="btn btn-success"> <i class="fa fa-plus"></i></a>
          <br /> <br />
        

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage RFID Vehicle</h3>
            <form action="<?= base_url('rfid/getRfidRecords'); ?>" method="GET" class="pull-right">
              <button class="btn btn-primary" type="submit"><i class="fa fa-print"></i> Print RFID Records</button>
            </form>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="datatables" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>Index</th>
                  <th>RFID</th>
                  <th>Plate</th>
                  <th>Owner</th>                  
                  <th>Model</th>                  
                  <!-- th>Payment</th -->                  
                  <th>Action</th>                  
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rfid_active as $k => $v) {
                ?>
                  <tr>
                    <td><?=$v['RFindex'] ?></td>
                    <td><?php echo $v['RFID'] ?></td>
                    <td><?php echo $v['platenumber'] ?></td>
                    <td><?php echo $v['owner'] ?></td>
                    <td><?php echo $v['model'] ?></td>
                    <!-- td><?php echo $v['payment'] ?></td -->
                    <td>                      
                        <a href="<?php echo base_url('RFID/edit/' . $v['id']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>                      
                        <a href="<?php echo base_url('RFID/delete/' . $v['id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>                      
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

    $("#slotsSideTree").addClass('active');
    $("#manageSlotsSideTree").addClass('active');
  });
</script>
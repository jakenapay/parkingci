<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Gate</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Gate</li>
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
       
          <a href="<?php echo base_url('Gate/create') ?>" class="btn btn-success"> <i class="fa fa-plus"></i></a>
          <br /> <br />
        

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Gate</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="datatables" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Gate Name</th>
                  <th>IP address</th>
                  <th>Direction</th>
                  <th>UHF</th>                  
                  <th>Ticket Dispenser</th>                  
                  <th>QR accepter</th>                  
                  <th>ANPR</th>                  
                  <th>Action</th>                                    
                </tr>
              </thead>
              <tbody>
                <?php foreach ($gate_data as $k => $v) {
                ?>
                  <tr>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['GateName'] ?></td>
                    <td><?php echo $v['address'] ?></td>
                    <td><?php echo $v['direction'] ?></td>
                    <td><?php echo $v['RFID'] ?></td>
                    <td><?php if($v['Ticket Dispenser']) echo "yes"; else echo "no";  ?></td>
                    <td><?php if( $v['QR accepter']) echo "yes"; else echo "no"; ?></td>
                    <td><?php echo $v['ANPR'] ?></td>                      
                    <td>                      
                        <a href="<?php echo base_url('Gate/edit/' . $v['id']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>                      
                        <a href="<?php echo base_url('Gate/delete/' . $v['id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>                      
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
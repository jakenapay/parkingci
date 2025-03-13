

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>RFID</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">RFID</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-3 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edit RFID</h3>
            </div>
            <form role="form" action="<?php base_url('RFID/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="group_name">RFID index</label>
                  <input type="text" class="form-control" id="RFindex" name="RFindex" placeholder="RFindex" value="<?php echo ($this->input->post('RFindex'))?:$rfid_data['RFindex']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">RFID</label>
                  <input type="text" class="form-control" id="rfid" name="rfid" placeholder="rfid" value="<?php echo ($this->input->post('RFID'))?:$rfid_data['RFID']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Address </label>
                  <input type="text" class="form-control" id="plate" name="plate" placeholder="plate" value="<?php echo ($this->input->post('platenumber'))?:$rfid_data['platenumber']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Owner </label>
                  <input type="text" class="form-control" id="owner" name="owner" placeholder="owner" value="<?php echo ($this->input->post('owner'))?:$rfid_data['owner']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Model </label>
                  <input type="text" class="form-control" id="model" name="model" placeholder="model" value="<?php echo ($this->input->post('model'))?:$rfid_data['model']; ?>">
                </div>
                <!-- div class="form-group">
                  <label for="group_name">Payment </label>
                  <input type="text" class="form-control" id="payment" name="payment" placeholder="payment" value="<?php echo ($this->input->post('payment'))?:$rfid_data['payment']; ?>">
                </div -->
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('RFID/') ?>" class="btn btn-danger">Back</a>
              </div>
            </form>
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
    $("#slotsSideTree").addClass('active');
    $("#manageSlotsSideTree").addClass('active');
  });
</script>
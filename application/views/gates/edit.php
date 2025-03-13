

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
              <h3 class="box-title">Edit Gate</h3>
            </div>
            <form role="form" action="<?php base_url('Gate/edit') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                
                <div class="form-group">
                  <label for="group_name">gate name</label>
                  <input type="text" class="form-control" id="gate_name" name="gate_name" placeholder="gate name" value="<?php echo ($this->input->post('GateName'))?:$gate_data['GateName']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Address </label>
                  <input type="text" class="form-control" id="addres" name="address" placeholder="address" value="<?php echo ($this->input->post('address'))?:$gate_data['address']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Direction </label>                  
                  <select class="form-control" id="direction" name="direction">
                    <option value="">Select Direction</option>                    
                    <option value="entry" <?php  echo ($gate_data['direction'] == 'entry') ? 'selected':''; ?>>Entry</option>
                    <option value="exit" <?php echo ($gate_data['direction']  == 'exit') ? 'selected':''; ?>>Exit</option>                    
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Activation </label>
                  <select class="form-control" id="act" name="act">
                    <option value="">Select ativation</option>
                    <option value="enable"  <?php  echo ($gate_data['activation'] == 'enable') ? 'selected':''; ?>>enable</option>
                    <option value="disable" <?php  echo ($gate_data['activation'] == 'disable') ? 'selected':''; ?>>disable</option>
                  </select>
                </div>
                                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('Gate/') ?>" class="btn btn-danger">Back</a>
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
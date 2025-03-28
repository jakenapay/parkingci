

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Slots</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Slots</li>
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
              <h3 class="box-title">Edit Slot</h3>
            </div>
            <form role="form" action="<?php base_url('slots/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                
                <div class="form-group">
                  <label for="group_name">Slot name</label>
                  <input type="text" class="form-control" id="slot_name" name="slot_name" placeholder="Slot name" value="<?php echo ($this->input->post('slot_name'))?:$slot_data['slot_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Number of slots</label>
                  <input type="text" class="form-control" id="slot_no" name="slot_no" placeholder="Slot number" value="<?php echo ($this->input->post('slot_no'))?:$slot_data['num_slot']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Occupied slot</label>
                  <input type="text" class="form-control" id="slot_no" name="slot_occ" placeholder="Slot number" value="<?php echo ($this->input->post('slot_occ'))?:$slot_data['occupied']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Active</label>
                  <select class="form-control" id="status" name="status">
                    <option value="1" <?php echo ($slot_data['active'] == 1) ? 'selected':''; ?>>Active</option>
                    <option value="2" <?php echo ($slot_data['active'] == 2) ? 'selected':''; ?>>Inactive</option>
                  </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('slots/') ?>" class="btn btn-danger">Back</a>
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
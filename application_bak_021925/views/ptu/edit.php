

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>PTU</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">PTU</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-6 col-xs-6">
          
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
              <h3 class="box-title">Edit PTU</h3>
            </div>
            <form role="form" action="<?php base_url('ptu/edit') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="group_name">Rate Name</label>
                  <input type="text" class="form-control" id="ptu_name" name="ptu_name" placeholder="PTU name" value="<?php echo ($this->input->post('name'))?:$ptu_data['name']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Vendor</label>
                  <input type="text" class="form-control" id="vendor" name="vendor" placeholder="vendor" value="<?php echo ($this->input->post('vendor'))?:$ptu_data['vendor']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Accredition No</label>
                  <input type="text" class="form-control" id="accredition_no" name="accredition_no" placeholder="accredition_no" value="<?php echo ($this->input->post('accredition'))?:$ptu_data['accredition']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Accredition Issue Date</label>
                  <input type="text" class="form-control" id="accredition_date" name="accredition_date"  value="<?php echo ($this->input->post('accredit_date'))?:$ptu_data['accredit_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Accredition Validate Date</label>
                  <input type="text" class="form-control" id="accredition_valid" name="accredition_valid"  value="<?php echo ($this->input->post('valid_date'))?:$ptu_data['valid_date']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">BIR serial number</label>
                  <input type="text" class="form-control" id="BIR_SN" name="BIR_SN" placeholder="BIR_SN" value="<?php echo ($this->input->post('BIR_SN'))?:$ptu_data['BIR_SN']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">PTU release Date</label>
                  <input type="text" class="form-control" id="ptu_date" name="ptu_date" value="<?php echo ($this->input->post('issued_date'))?:$ptu_data['issued_date']; ?>">
                </div>
                <!-- div class="form-group">
                  <label for="group_name">Active</label>
                  <select class="form-control" id="rate_status" name="rate_status">
                    <option value="1" <?php echo ($ptu_data['active'] == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="2" <?php echo ($ptu_data['active'] == 2) ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div -->
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('ptu/') ?>" class="btn btn-danger">Back</a>
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
    $("#ratesSideTree").addClass('active');
    $("#manageRatesSideTree").addClass('active');
  });
</script>

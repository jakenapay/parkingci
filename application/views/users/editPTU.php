

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
              <h3 class="box-title">Edit Paystation</h3>
            </div>
            <form role="form" action="<?php base_url('users/editPTU') ?>" method="post">
              <div class="box-body">
              <div class="form-group">
                  <label for="username">PTU Name</label>
                  <input type="text" class="form-control" id="ptuname" name="ptuname" placeholder="ptuname" value="<?php echo $ptu_data['name'] ?>">
                </div>

                <div class="form-group">
                  <label for="vendor">Vendor</label>
                  <input type="text" class="form-control" id="vendor" name="vendor" placeholder="vendor" value="<?php echo $ptu_data['vendor'] ?>">
                </div>

                <div class="form-group">
                  <label for="accredition">Acccredition</label>
                  <input type="text" class="form-control" id="accredition" name="accredition" placeholder="accredition" value="<?php echo $ptu_data['accredition'] ?>">
                </div>

                <div class="form-group">
                  <label for="accredit_date">Acccredition Date</label>
                  <input type="date" class="form-control" id="accredit_date" name="accredit_date" placeholder="accredit_date" value="<?php echo $ptu_data['accredit_date'] ?>">
                </div>

                <div class="form-group">
                  <label for="fname">Valid Date</label>
                  <input type="date" class="form-control" id="valid_date" name="valid_date" placeholder="valid_date"  value="<?php echo $ptu_data['valid_date'] ?>">
                </div>

                <div class="form-group">
                  <label for="lname">BIR SN</label>
                  <input type="text" class="form-control" id="BIR_SN" name="BIR_SN" placeholder="BIR_SN"  value="<?php echo $ptu_data['BIR_SN'] ?>">
                </div>

                <div class="form-group">
                  <label for="phone">Issued Date</label>
                  <input type="date" class="form-control" id="issued_date" name="issued_date" placeholder="issued_date"  value="<?php echo $ptu_data['issued_date'] ?>">
                </div>
                <div class="form-group">
                  <label for="phone">IP address</label>
                  <input type="text" class="form-control" id="ip" name="ip" placeholder="ip"  value="<?php echo $ptu_data['IP'] ?>">
                </div>
                <div class="form-group">
                  <label for="phone">Location</label>
                  <input type="text" class="form-control" id="location" name="location" placeholder="location"  value="<?php echo $ptu_data['location'] ?>">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('users/PTU') ?>" class="btn btn-danger">Back</a>
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
    $("#groups").select2();

    $("#userSideTree").addClass('active');
    $("#manageUserSideTree").addClass('active');
  });
</script>

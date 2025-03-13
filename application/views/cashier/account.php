

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Account</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Account </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-4 col-xs-4">
          
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
              <h3 class="box-title">Cashier Management</h3>
            </div>
            <form role="form" action="<?php base_url('RFID/create') ?>" method="post">
              <div class="box-body">
                <?php echo validation_errors(); ?> 
                             
                  <label for="group_name">Cashier name</label> 
                  <?php echo "<input type='text' readonly class='form-control' value='" . $cashierName . "'>" ; ?> 
                  <label for="group_name">Start Time(login Time)</label>                  
                  <?php echo "<input type='text' readonly class='form-control' value='" . $at_time . "'>" ; ?> 
                  <label for="group_name">Start Balance</label>
                  <?php echo "<input type='text' readonly class='form-control' value='" . $Sbalance . " Peso'>" ; ?> 
                  
                  <label for="group_name">Number of transaction</label>
                  <?php echo "<input type='text' readonly class='form-control' value='" . $trasaction . "   '>" ; ?>
                
                  <label for="group_name">Total earn </label>
                  <?php echo "<input type='text' readonly class='form-control' value='" . $earn . " Peso'>" ; ?>
                
                  <label for="group_name">Current Balance </label>
                  <?php echo "<input type='text' readonly class='form-control' value='" . $Cbalance . "  Peso'>" ; ?>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <a href="<?php echo base_url('cashier/') ?>" class="btn btn-danger">Back</a>
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
    $("#createSlotsSideTree").addClass('active');
  });
</script>


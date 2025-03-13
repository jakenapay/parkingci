

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
              <h3 class="box-title">Add RFID</h3>
            </div>
            <form role="form" action="<?php base_url('RFID/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                               
                <div class="form-group">
                  <label for="group_name">RF Tag Index</label>
                  <input type="number" class="form-control" id="RFindex" name="RFindex" required>
                </div>
                <div class="form-group">
                  <label for="group_name">Tag Data</label>
                  <input type="text" class="form-control" id="rfid" name="rfid"  readonly>
                </div>

                <div class="form-group">
                  <label for="group_name">Plate number</label>
                  <input type="text" class="form-control" id="plate" name="plate" placeholder="Plate #">
                </div>
                <div class="form-group">
                  <label for="group_name">Owner Name</label>
                  <input type="text" class="form-control" id="owner" name="owner" placeholder="Owner Name">
                </div>
                <div class="form-group">
                  <label for="group_name">Model</label>
                  <input type="text" class="form-control" id="model" name="model" placeholder="Model">
                </div>
                <!-- div class="form-group">
                  <label for="group_name">Payment</label>
                  <input type="text" class="form-control" id="payment" name="payment" placeholder="Payment">
                </div -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Tag</button>
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
<script>

const RFData = <?php echo  json_encode($rfid_inactive); ?>;
$(document).ready(function(){
  $("#RFindex").change(function(){
    var key = $(this).val();    
    data = document.getElementById('rfid');
    data.value = RFData[key-2]['RFID'];
    data2 = document.getElementById('RFindex');
    data2.value = key;            
  });
})
</script>  
  </div>
  <!-- /.content-wrapper -->
  

<script type="text/javascript">
  $(document).ready(function() {
    $("#slotsSideTree").addClass('active');
    $("#createSlotsSideTree").addClass('active');
  });
</script>


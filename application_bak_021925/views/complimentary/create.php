

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Complimentary
        <small>Create</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
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
              <h3 class="box-title">Create new complimentary</h3>
            </div>
            <form role="form" action="<?php base_url('users/create') ?>" method="post">
              <div class="box-body">
                <form id="addEventForm" method="POST" action="<?= base_url('Complimentary/create')?>">
                        <div class="form-group">
                            <label for="inputEventTitle">Event Title</label>
                            <input type="text" class="form-control rounded-0" id="inputEventTitle" name="event_title" required>
                        </div>

                        <div class="form-group">
                            <label for="inputDateStart">Start Date</label>
                            <input type="date" class="form-control rounded-0" id="inputDateStart" name="start_date" required>
                        </div>

                        <div class="form-group">
                            <label for="inputDateEnd">Expiration Date</label>
                            <input type="date" class="form-control rounded-0" id="inputDateEnd" name="end_date" required>
                        </div>

                        <div class="form-group">
                            <label for="inputEventTitle">Quantity</label>
                            <input type="number" class="form-control rounded-0" id="inputQuantity" name="quantity" placeholder="0">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success rounded-0" id="saveEventBtn">Create Complimentray QR</button>
                        </div>
                    </form>
                

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
    $("#groups").select2();

    $("#userSideTree").addClass('active');
    $("#createUserSideTree").addClass('active');
  });
</script>

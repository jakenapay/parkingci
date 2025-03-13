<!-- Content Wrapper. Contains page content -->
<style>

#clock {
font-family: Arial, sans-serif;
text-align: center;
font-size: 5em;
background-color: purple;
color: white;
margin-top: 50px;
}
.fcc-btn {
  background-color: #5cb85c;
  color: white;
  padding: 7px 25px;
}

</style>

<div class="content-wrapper"> 
  <section class="content-header">
    <h1>
      <small> </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> <?php   echo "Cashier : ".$this->session->userdata('fname')." ".$this->session->userdata('lname') ?> </li>      
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">      
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
      
      <div class="col-lg-3 col-xs-12">   
      <form action="<?php echo base_url("cashier/complimentaryAvailability") ?>" method="get" >   
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Ticket</h3>            
              <p>payment by Complimentary Ticket</p>
              <input type="text" class="form-control" id="complimentary" name="complimentary" placeholder="QR Code" required>              
            </div>
            <div class="icon">
              <i class="ion ion-android-car"></i>
            </div>
            <div class="form-row text-center">  
                  <button class="btn btn-success" type="submit">Continue <i class="fa fa-arrow-circle-right"></i></button>                  
              </div>
          </div>
        </form>
      </div>
 
    <!-- /.row -->
  </section>


  <!-- /.content :  Plate number , Entry time, Parking bill , Discount option , Penalty ,  -->
</div>
<!-- /.content-wrapper -->

<script>
var clock = document.getElementById("clock");
function updateClock() {
var date = new Date();
var hours = date.getHours().toString().padStart(2, "0");
var minutes = date.getMinutes().toString().padStart(2, "0");
var seconds = date.getSeconds().toString().padStart(2, "0");
clock.textContent = date.toDateString() + "    "+hours + ":" + minutes + ":" + seconds;
}
setInterval(updateClock, 1000);
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable();

    $("#slotsSideTree").addClass('active');
    $("#manageSlotsSideTree").addClass('active');
  });
</script>
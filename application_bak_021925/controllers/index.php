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

</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div id="clock"></div>  
  <section class="content-header">

    <h1>
       Cashier Payment [ <?php   echo "Cashier : ".$this->session->userdata('fname')." ".$this->session->userdata('lname')."]" ?>
      <small> </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">cashier</li>
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
        <form action="Cashier/payment" method="post" >  
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>Plate Number  </h3>            
              <p>payment by Plate number</p>
              <input type="text" class="form-control" id="anpr" name="anpr" placeholder="anpr ">
              
            </div>
            <div class="icon">
              <i class="ion ion-navigate"></i>
            </div>
            <div class="form-row text-center">  
                  <button class="btn btn-success" type="submit">Payment</button>
              </div>
              <!-- a href="payment" class="small-box-footer">Payment <i class="fa fa-arrow-circle-right"></i></a -->
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12">      
        <form action="Cashier/payment" method="post" >  
          <div class="small-box bg-green">
            <div class="inner">
              <h3>QR ticket </h3>            
              <p>payment by QR Ticket</p>
              <input type="text" class="form-control" id="QR" name="QR" placeholder="QR ">
              
            </div>
            <div class="icon">
              <i class="ion ion-navigate"></i>
            </div>
            <div class="form-row text-center">  
                  <button class="btn btn-success" type="submit">Payment</button>
              </div>
              <!-- a href="payment" class="small-box-footer">Payment <i class="fa fa-arrow-circle-right"></i></a -->
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12">      
        <form action="Cashier/payment" method="post" >  
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Others </h3>
              <p>Lost Ticket</p>
              <input type="text" class="form-control" id="Others" name="Others" placeholder="Others " disabled >
            </div>
            <div class="icon">
              <i class="ion ion-navigate"></i>
            </div>
            <div class="form-row text-center">
              <button class="btn btn-danger" type="submit">Payment</button>
            </div>
            <!-- a href="payment" class="small-box-footer">Payment <i class="fa fa-arrow-circle-right"></i></a -->            
          </div>
        </form>
    </div>    
    <!-- /.row -->
  </section>
  <section>         
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Recent Transaction</h3>
      </div>    
      <div class="box-body">
        <div class= "table-responsive">
          <table  class="table table-bordered table-hover table-striped">            
            <thead>
              <tr>
                <th>ID#</th>
                <th>Access Type</th>
                <th>Access Coder</th>                 
                <th>Check-In</th>
                <th>Paid time</th>
                <th>Vehicle Type</th>
                <th>Rate code</th>                                
                <th>Total Time</th>
                <th>Total Amount</th>
                <th>Paid Status</th>                
              </tr>
            </thead>
            <tbody>    
            <?php foreach ($payment as $v) {
                  ?>
                    <tr>
                      <td><?php echo $v['id']; ?></td>
                      <td><?php echo $v['AccessType']; ?></td>
                      <td><?php echo $v['parking_code']; ?></td>                    
                      <td><?php echo $v['in_time']; ?></td>                                          
                      <td><?php echo $v['paid_time']; ?> </td>
                      <td><?php echo $v['vechile_cat_id']; ?></td>
                      <td><?php echo $v['rate_id']; ?></td>                      
                      <td><?php if($v['total_time']>24) 
                                    echo '(overday)'.$v['total_time'] . ' hour';
                                else 
                                    echo $v['total_time'] . ' hour';
                               ?></td>
                      <td><?php echo ($v['earned_amount']) ?: '-'; ?></td>
                      <td><?php echo ($v['paid_status'] == 1) ? '<label class="label label-success" style="font-size:12px;">Paid</label>' : '<label class="label label-danger">Not Paid</label>'; ?></td>                      
                    </tr>
                  <?php
                  } ?>          
            </tbody>
          </table>
        </div>
      </div>
    </div>  
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
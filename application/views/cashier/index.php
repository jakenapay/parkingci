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
  <!-- Content Header (Page header) -->
  <div id="clock"></div>  
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
      <form action="<?php echo base_url("cashier/payment") ?>" method="get" >   
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>Plate Number  </h3>            
              <p>payment by Plate number</p>
              <input type="text" class="form-control" id="anpr" name="anpr" placeholder="XXX-XXXX " required>              
            </div>
            <div class="icon">
              <i class="ion ion-android-car"></i>
            </div>
            <div class="form-row text-center">  
                  <button class="btn btn-success" type="submit">Payment <i class="fa fa-arrow-circle-right"></i></button>
                  <a class="btn btn-success" href="<?php echo base_url("cashier/PlateSearch") ?>">Search <i class="fa fa-arrow-circle-right"></i></a>
                  
              </div>
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12">      
        <form action="Cashier/payment" method="post" >  
          <div class="small-box bg-green">
            <div class="inner">
              <h3>QR ticket </h3>            
              <p>payment by QR Ticket</p>
              <input type="text" class="form-control" id="QR" name="QR" placeholder="Please tap scanner... ">
              
            </div>
            <div class="icon">
              <i class="ion ion-qr-scanner"></i>
            </div>
            <div class="form-row text-center">  
                  <button class="btn btn-success" type="submit">Payment<i class="fa fa-arrow-circle-right"></i></button>
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
              <input type="text" class="form-control" id="LOST" name="LOST" placeholder="LOST" value ="LOST" disabled >
            </div>
            <div class="icon">
              <i class="ion ion-ios-speedometer-outline"></i>
            </div>
            <div class="form-row text-center">
              <a href="cashier/lost_ticket" class="btn btn-danger">Payment <i class="fa fa-arrow-circle-right"></i></a>  
            </div>
                      
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12">
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>Cashier </h3>
            <p> <?php   echo " Start   balance : P 12,030" ?> </p>
            <p> <?php   echo " Current balance : P 17,030" ?></p>                        
          </div>
          <div class="icon">
            <i class="ion ion-search"></i>
          </div>
          <div class=" text-center">
              <button class="btn btn-danger" type="text">Detail history</button>
          </div>
        </div> 
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
                <th>OR#</th>
                <th>Access Type</th>  
                <th>Access Code</th>                 
                <th>Check-In</th>
                <th>Paid time</th>
                <th>Vehicle Type</th>
                <th>Rate code</th>                                
                <th>Total Time</th>
                <th>Total Amount</th>
                <th>Pay Mode</th>
                <th>status</th>
                
                <!-- th>Action</th -->                  
              </tr>
            </thead>
            <tbody>    
            <?php if (empty($transaction)): ?>
                <tr>
                    <td colspan="12">No transactions yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($transaction as $rt): ?>
                    <tr>
                        <td><?= $rt['id']; ?></td>
                        <td><?= $rt['ORNO']; ?></td>
                        <td><?= $rt['AccessType']; ?></td>
                        <td><?= $rt['parking_code']; ?></td>
                        <td><?= $rt['in_time']; ?></td>
                        <td><?= $rt['paid_time']; ?></td>
                        <td><?php
                          $vehicle = $rt['vechile_cat_id'];
                          if($vehicle == "1"){
                            echo "Motorcycle";
                          }else if($vehicle == "2"){
                            echo "Car";
                          }else if($vehicle == "3"){
                            echo "BUS/Truck";
                          }else{
                            echo "Unknown";
                          }
                          ?>
                        </td>
                        <td><?= $rt['rate_id']; ?></td>
                        <td><?= $rt['total_time']; ?></td>
                        <td>PHP <?= $rt['earned_amount']; ?></td>
                        <td>
                          <?php
                           $mop = $rt['pay_mode'];
                           if($mop == "Cash"){
                              echo "<p class='label label-info'>Cash</p>"; 
                           }else if($mop == "Paymaya"){
                              echo "<p class='label label-success'>Paymaya</p>"; 
                           }else if($mop == "Gcash"){
                            echo "<p class='label label-primary'>G-Cash</p>"; 
                           }else{
                            echo "<p class='label label-danger'>Complimentary</p>"; 
                           }
                          ?>
                         </td>
                        <td>
                            <?php
                            $pstatus = $rt['paid_status']; 
                            if ($pstatus == 1) {
                                echo "<p class='label label-success'>Paid</p>"; 
                            } else {
                                echo "<p class='label label-danger'>Unpaid</p>"; 
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>


            
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
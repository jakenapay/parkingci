

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard....</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->

    
      <div class="row">
        <div class="col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner ">
              <h3><?php echo $total_availableslots; ?>/<?php echo $total_slots; ?></h3>

              <p>Available Parking Slots</p>
            </div>
            <div class="icon">
              <i class="ion ion-navigate"></i>
            </div>
            <a href="#" class="small-box-footer">Total Parking <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $total_parking[0]['occupied']; ?> / <?php echo $total_parking[0]['num_slot']; ?></h3>
              <p>Available Parking Slots</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-car"></i>
            </div>
            <a href="<?php echo base_url('parking') ?>" class="small-box-footer"><?php echo $total_parking[0]['slot_name']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $total_parking[1]['occupied']; ?> / <?php echo $total_parking[1]['num_slot']; ?></h3>

              <p>Available Parking Slots</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-car"></i>
            </div>
            <a href="<?php echo base_url('parking') ?>" class="small-box-footer"><?php echo $total_parking[1]['slot_name']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-12">          
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo ($total_parking[0]['occupied']+$total_parking[1]['occupied'])?></h3>
              <p>Current parking???</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-car"></i>
            </div>
            <a href="<?php echo base_url('parking') ?>" class="small-box-footer">Total Park <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div >
        <!-- ./col -->       
      <!-- /.row -->
      <!-- div class="row">
        <div class="col-lg-3 col-xs-12"></div>
        <div class="col-lg-3 col-xs-12">
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>Test</h3>
              <p>Available Parking Rates</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-speedometer-outline"></i>
            </div>
            <a href="#" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div -->   
  </section>
  <!-- /.content -->

  <div class="box">
          <div class="box-header">
            <h3 class="box-title">Parking History</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
           
            <table id="datatables" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Access Type</th>
                  <th>Code</th>                 
                  <th>Check-In</th>
                  <th>Check-Out</th>
                  <th>Vehicle Type</th>                  
                  <th>Rate</th>                  
                  <th>Total Time</th>
                  <th>Total Amount</th>
                  <th>Paid Status</th>                  
                </tr>
              </thead>
              <tbody>             
                  <?php foreach ($parking_data as $k => $v) {
                  ?>
                    <tr>
                      <td><?php echo $v['parking']['GateId'].'-'.$v['parking']['AccessType']; ?></td>
                      <td><?php echo $v['parking']['parking_code']; ?></td>                    
                      <td><?php
                          date_default_timezone_set("Asia/Manila");
                          $date = date('m/d', $v['parking']['in_time']);
                          $time = date('h:i:s a', $v['parking']['in_time']);

                          echo $date . '<br />' . $time;
                          // echo date_format($date,"Y-m-d"); echo "<br />"; echo date_format($date,"H:i:s"); 
                          ?>

                      </td>
                      <td><?php
                          if ($v['parking']['out_time'] == '') {
                            echo "-";
                          } 
                          else {
                            date_default_timezone_set("Asia/Manila");
                            $date = date('m/d', $v['parking']['out_time']);
                            $time = date('h:i:s a', $v['parking']['out_time']);
                            echo $date . '<br />' . $time;
                            // echo date_format($date,"Y-m-d"); echo "<br />"; echo date_format($date,"H:i:s");
                          }
                          ?></td>
                      <td><?php echo $v['category']['name']; ?></td>                      
                      <td><?php
                          echo $company_currency . '' . $v['rate']['rate']; ?></td>                      
                      <td><?php 
                            if($v['parking']['total_time'] >1) {
                                echo $v['parking']['total_time'] . ' hour';
                                echo ($v['parking']['total_time'] > 1) ? 's' : '';
                             }
                             else{
                                echo '-';
                             }
                              ?></td>
                      <td><?php echo $company_currency . '' . ($v['parking']['earned_amount']) ?: '-'; ?></td>
                      <td><?php echo ($v['parking']['paid_status'] == 1) ? '<label class="label label-success" style="font-size:12px;">Paid</label>' : '<label class="label label-danger">Not Paid</label>'; ?></td>
                      <?php if (in_array('updateParking', $user_permission) || in_array('deleteParking', $user_permission) || in_array('viewParking', $user_permission)) : ?>
                        <?php endif; ?>
                    </tr>
                  <?php
                  } ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboardSideNav").addClass('active');
  });
</script>
<!-- script>
    window.addEventListener('DOMContentLoaded', function() {
      var audio = new Audio('voice_prompt.mp3'); // Replace with the path to your sound file
      audio.play();
    });
</script -->

<script>
    $(document).ready(function() {
      setInterval(refreshScreen, 3000); // Refresh every 3 seconds
      function refreshScreen() {
        $('#datatables').load(' #datatables');          
      }
    });
 </script>
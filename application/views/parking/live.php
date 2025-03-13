<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to fetch and display live data
    function fetchLiveData() {
        $.ajax({
            url: 'seat/live', // PHP script to fetch data
            method: 'GET',
            success: function(data) {
                // Update the data on the page
                $('#live-data').html(data);
            }
        });
    }
    // Fetch live data every 2 seconds (adjust as needed)
    setInterval(fetchLiveData, 2000);
</script>
<!-- Content Wrapper. Contains page content -->
<meta http-equiv="refresh" content="10">
<div class="content-wrapper">
    
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Live monitor </h1>    
  </section>

  <!-- Main content -->
  <div class="box">
          <div class="box-header">
            <h3 class="box-title">Live Monitoring</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
           
            <table id="datatables" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Gate In</th>
                  <th>Gate Out</th>
                  <th>Type</th>
                  <th>Code</th>
                  <th>Vehicle</th>                 
                  <th>Check-In</th>
                  <th>Check-Out</th>                                    
                  <th>Total Time</th>
                  <th>Total Amount</th>
                  <th>Paid Status</th>                  
                </tr>
              </thead>
              <tbody>             
                  <?php foreach ($parking_data as $k => $v) {
                  ?>
                    <tr>
                      <td><?php echo  date('Y-m-d', $v['parking']['in_time'])  ?></td>                      
                      <td><?php echo $v['parking']['GateId']; ?></td>
                      <td><?php 
                           if($v['parking']['GateEx'] !=null or $v['parking']['GateEx'] !='')
                              echo $v['parking']['GateEx'];
                            else 
                              echo '-'; ?></td>
                      <td><?php echo $v['parking']['AccessType']; ?></td>
                      <td><?php echo $v['parking']['parking_code']; ?></td> 
                      <td><?php if($v['parking']['vechile_cat_id'] ==1) 
                                  echo 'Motocycle';
                                elseif($v['parking']['vechile_cat_id'] ==2)
                                  echo 'Car';
                                elseif($v['parking']['vechile_cat_id'] ==3)
                                  echo 'Bus /Truck';    
                                else
                                  echo 'unknown';
                      ?></td>                    
                      <td><?php
                          date_default_timezone_set("Asia/Manila");
                          $date = date('Y-m-d', $v['parking']['in_time']);
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
                            $date = date('Y-m-d', $v['parking']['out_time']);
                            $time = date('h:i:s a', $v['parking']['out_time']);
                            echo $date . '<br />' . $time;
                            // echo date_format($date,"Y-m-d"); echo "<br />"; echo date_format($date,"H:i:s");
                          }
                          ?></td>                      
                       <td><?php echo $v['parking']['total_time'] . ' min';
                          echo ($v['parking']['total_time'] > 1) ? 's' : ''; ?></td>
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

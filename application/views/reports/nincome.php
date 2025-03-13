<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Reports
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Reports</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <form class="form-inline" action="<?php echo base_url('reports/') ?>" method="POST">          
            <div class="form-group">
              <label for="date">Year</label>
              <select class="form-control" name="select_year" id="select_year">
              <?php
                    $current_year = date("Y");
                    
                    echo "<option value='$current_year'>$current_year</option>";
                    ?>
              </select>
            
              <label for="date">Month</label>
              <select class="form-control" name="select_month" id="select_month">     
                  <option value="">No select month </option>
                  <?php
                    if ($total_months > 0) {
                        for ($i = 1; $i <= $total_months; $i++) {
                            $monthName = date("F", mktime(0, 0, 0, $i, 1));
                            echo "<option value='$i'>$monthName</option>";
                        }
                    } else {
                        echo "<option value=''>No select month </option>";
                    }
                    ?>
              </select>
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>          
        </form>
      </div>
      <br /> <br />


      <div class="col-md-12 col-xs-12">        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Total Income - Report</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart" style="height:250px"></canvas>
              <!-- canvas id="myChart3" style="height:250px"></canvas -->
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Total Income - Report Data</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <table id="datatables" class="table table-bordered table-striped table-hover">
              <thead>
                  <tr>
                      <th>Month - Year</th>
                      <th>Gate1</th>
                      <th>Gate2</th>
                      <th>Gate3</th>
                      <th>Gate4</th>
                      <th>Total Amount</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  $current_year = date('Y');
                  $months = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");

                  $monthly_gate_earnings = array();
                  foreach($annual_park as $row) {
                      $month_year = $row['Year'] . '-' . str_pad($row['Month'], 2, '0', STR_PAD_LEFT);
                      $gate_earnings = isset($monthly_gate_earnings[$month_year]) ? $monthly_gate_earnings[$month_year] : array();
                      $gate_earnings[$row['GateId']] = isset($row['total_earned_amount']) ? $row['total_earned_amount'] : 0;
                      $monthly_gate_earnings[$month_year] = $gate_earnings;
                  }

                  foreach($months as $month_num => $month_name): 
                      $month_year = $current_year . '-' . str_pad($month_num + 1, 2, '0', STR_PAD_LEFT);
                      $gate_earnings = isset($monthly_gate_earnings[$month_year]) ? $monthly_gate_earnings[$month_year] : array();
                      ?>
                      <tr>
                          <td><?= $month_name . " - " . $current_year; ?></td>
                          <td>₱ <?= isset($gate_earnings['G1']) ? $gate_earnings['G1'] : 0; ?></td>
                          <td>₱ <?= isset($gate_earnings['G2']) ? $gate_earnings['G2'] : 0; ?></td>
                          <td>₱ <?= isset($gate_earnings['G3']) ? $gate_earnings['G3'] : 0; ?></td>
                          <td>₱ <?= isset($gate_earnings['G4']) ? $gate_earnings['G4'] : 0; ?></td>
                          <td>
                              <?php 
                              $total_earned_amount = array_sum($gate_earnings);
                              echo "₱ " . $total_earned_amount;
                              ?>
                          </td>
                      </tr>
                      <?php
                  endforeach; 
                  ?>
              </tbody>

            <tbody>
            <?php
              $total_earnings_g1 = 0;
              $total_earnings_g2 = 0;
              $total_earnings_g3 = 0;
              $total_earnings_g4 = 0;
              ?>

              <?php
              // Iterate over the data for each month
              foreach ($annual_park as $row) {
                $total_earnings_g1 += isset($row['G1']) ? $row['G1'] : 0;
                $total_earnings_g2 += isset($row['G2']) ? $row['G2'] : 0;
                $total_earnings_g3 += isset($row['G3']) ? $row['G3'] : 0;
                $total_earnings_g4 += isset($row['G4']) ? $row['G4'] : 0;
            }
              ?>
                <tr>
                  <th>Total amount</th>
                  <th>₱ <?= $total_earnings_g1; ?></th>
                  <th>₱ <?= $total_earnings_g2; ?></th>
                  <th>₱ <?= $total_earnings_g3; ?></th>
                  <th>₱ <?= $total_earnings_g4; ?></th>
              </tr>
            </tbody>
          </table>
          <br>
          <br>
            <div class="text-center">
              <button onclick="printContent('win')" class="btn btn-success btn-sm" target="_BLANK"><i class="fa fa-print"></i></button>
            </div>            
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

<script>
  function printContent() {
    window.print();
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#reportSideTree").addClass('active');
  });
  
  var report_data = <?php echo '[' . implode(',', $sum) . ']'; ?>;
  // var report_data = [100,200,323,232,333,32,34,600,34,0,0,0];


  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    var areaChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'De'],
      datasets: [{
        label: 'Electronics',
        fillColor: 'rgba(210, 214, 222, 1)',
        strokeColor: 'rgba(210, 214, 222, 1)',
        pointColor: 'rgba(210, 214, 222, 1)',
        pointStrokeColor: '#c1c7d1',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data: report_data
      }]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChart = new Chart(barChartCanvas)
    var barChartData = areaChartData
    barChartData.datasets[0].fillColor = '#00a65a';
    barChartData.datasets[0].strokeColor = '#00a65a';
    barChartData.datasets[0].pointColor = '#00a65a';
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>
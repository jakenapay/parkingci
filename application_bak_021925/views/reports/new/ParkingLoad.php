<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Parking Load Reports
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Parking Load Reports</li>
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
              <?php foreach ($report_years as $key => $value) : ?>
                <option value="<?php echo $value ?>" <?php if ($value == $selected_year) {
                                                        echo "selected";
                                                      } ?>><?php echo $value; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label for="date">Month</label>
            <select class="form-control" name="select_year" id="select_year">
              <?php foreach ($report_years as $key => $value) : ?>
                <option value="<?php echo $value ?>" <?php if ($value == $selected_year) {
                                                        echo "selected";
                                                      } ?>><?php echo $value; ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
      </div>

      <br /> <br />


      <div class="col-md-12 col-xs-12">

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

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Parking Load Report</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body"><center>
          <canvas id="myChart" style="width:100%; height:300px;"></canvas></center>
          <script>
                    var xValues = ["Gate 1", "Gate 2", "Gate 3", "Gate 4"];
                    var yValues = [321, 232, 134, 423, 0];
                    var barColors = ["blue", "red", "green", "purple"];
                    
                    new Chart("myChart", {
                      type: "bar",
                      data: {
                        labels: xValues,
                        datasets: [{
                          backgroundColor: barColors,
                          data: yValues
                        }]
                      },
                      options: {
                        legend: {display: false},
                        title: {
                          display: true,
                          text: ""
                        }
                      }
                    });
            </script>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Daily Parking Load Report</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <table id="datatables" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>Daily</th>
                  <th>Gate1</th>
                  <th>Gate2</th>
                  <th>Gate3</th>
                  <th>Gate4</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($parking_data as $k => $v) : ?>
                  
                  <tr>
                    <td><?php echo $k; ?></td>
                    <td><?php echo  '' . $v; ?></td>     
                    <td><?php echo  '' . $v; ?></td>  
                    <td><?php echo  '' . $v; ?></td>  
                    <td><?php echo  '' . $v; ?></td>  
                    <td><?php echo  '' . $v; ?></td>  
                  </tr>
                
                <?php endforeach ?>
                
              </tbody>
              <tbody>
                <tr>
                  <th>Total Amount</th>
                  <th>
                    <?php echo  ' ' . array_sum($parking_data); ?>
                  </th>
                  <th>
                    <?php echo  ' ' . array_sum($parking_data); ?>
                  </th>
                  <th>
                    <?php echo  ' ' . array_sum($parking_data); ?>
                  </th>
                  <th>
                    <?php echo  ' ' . array_sum($parking_data); ?>
                  </th>
                  <th>
                    <?php echo  ' ' . array_sum($parking_data); ?>
                  </th>
                </tr>
              </tbody>              
            </table>
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

  var report_data = <?php echo '[' . implode(',', $parking_data) . ']'; ?>;


  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    var areaChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
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
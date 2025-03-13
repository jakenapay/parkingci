<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Parking</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Parking</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">      
      <div class="col-sm-12 col-lg-12 ml-auto ">
        <form action="" method="GET">
          <div class="row">
            <?php $date = date("Y-m-d", strtotime("today"));  ?> 
            <div class="col-sm-2 col-2">
              <input type="date" name="start" value= "<?php echo $start ?>"  max="<?php echo $date ?>"  class="form-control" required>            
              <?= form_error('start', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-sm-2 col-2">
              <input type="date" name="end" value= "<?php echo $end ?>"  max="<?php echo $date ?>" class="form-control" required>                 
              <?= form_error('end', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-sm-2 col-2">
              <select class="form-control" name="gate">              
                <option value="">All</option>
                <option value="G1">Gate 1</option>
                <option value="G2">Gate 2</option>
                <option value="G3">Gate 3</option>              
                <option value="G4">Gate 4</option>              
              </select>
              <?= form_error('room', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="col-sm-1 col-1">
              <button type="submit" name="submit" value="Show"  class="btn btn-success btn-fill btn-block">Show</button>            
            </div>
            <div class="col-sm-1 col-1">
                <button type="submit" name="submit" value="Print" class="btn btn-success btn-fill btn-block">Print</button>
            </div>
            <div class="col-sm-1 col-1">
              <button type="submit"  name="submit" value="Export" class="btn btn-success btn-fill btn-block">Export</button>
                </div>
          </div>             
        </form>
      </div>
    </div>
        
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Parking</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class= "table-responsive">
              <table id="datatables" class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>                    
                    <th>Date</th>      
                    <th>Gate In</th>
                    <th>Gate Out</th>
                    <th>Type</th>
                    <th>Code</th>                 
                    <th>Vehicle Type</th>                    
                    <th>Check-In</th>
                    <th>Check-Out</th>                    
                    <th>Total Time</th>
                    <th>Total Amount</th>
                    <th>Paid Status</th>          
                    <th>Action</th>                              
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($parking_data as $k => $v) {
                  ?>
                    <tr>                        
                      <td><?php echo date('Y-m-d', $v['in_time']) ?></td>
                      <td><?php echo $v['GateId']; ?></td>
                      <td><?php 
                           if($v['GateEx'])
                              echo $v['GateEx'];
                            else 
                              echo '-'; ?></td>
                      <td><?php echo $v['AccessType']; ?></td>
                      <td><?php echo $v['parking_code']; ?></td>  
                      <td><?php if($v['vechile_cat_id'] ==1) 
                                  echo 'Motorcycle';
                                elseif($v['vechile_cat_id'] ==2)
                                  echo 'Car';
                                elseif($v['vechile_cat_id'] ==3)
                                  echo 'Bus /Truck';    
                                else
                                  echo 'unknown';
                      ?></td>                                      
                      <td><?php
                           date_default_timezone_set("Asia/Manila");
                          if($v['in_time'] == '')
                            echo "-";                          
                          else
                            echo date('m/d h:i:s a', $v['in_time']);                                                                                                          
                          ?>
                      </td>
                      <td><?php
                          date_default_timezone_set("Asia/Manila");
                          if ($v['out_time'] == '') 
                            echo "-";                           
                          else                             
                            echo date('m/d h:i:s a', $v['out_time']);                  
                          ?></td>
                      <td><?php echo $v['total_time'];
                          echo ($v['total_time'] > 1) ? 'm' : ''; ?></td>
                      <td><?php echo $company_currency . '' . ($v['earned_amount']) ?: '-'; ?></td>
                      <td><?php echo ($v['paid_status'] == 1) ? '<label class="label label-success" style="font-size:12px;">Paid</label>' : '<label class="label label-danger">Not Paid</label>'; ?></td>
                      <?php if (in_array('updateParking', $user_permission) || in_array('deleteParking', $user_permission) || in_array('viewParking', $user_permission)) : ?>
                        <td>
                          <div class="btn btn-group-sm">                            
                              <a href="<?php echo base_url('parking/view/' . $v['id']) ?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>                                                        
                              <a href="<?php echo base_url('parking/delete/' . $v['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>                            
                              <!-- a onclick="printParking(<?php echo "'" . base_url('parking/printInvoice/' . $v['id']) . "'"; ?>)" class="btn btn-primary"><i class="fa fa-print"></i></a -->                            
                          </div>
                        </td>
                      <?php endif; ?>
                    </tr>
                  <?php
                  } ?>
                </tbody>
              </table>
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
  function printParking(parking_url) {
    $.ajax({
      url: parking_url,
      type: 'post',
      success: function(response) {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');
        mywindow.document.write(response);
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/
        mywindow.print();
        mywindow.close();
      }
    })
  }

  $(document).ready(function() {
    $('#datatables').DataTable({
      'order': []
    });
    $("#parkingSideTree").addClass('active');
    $("#manageParkingSideTree").addClass('active');
  });
</script>

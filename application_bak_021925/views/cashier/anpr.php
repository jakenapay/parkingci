<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <small> </small>
    </h1>    
             <a href="<?php echo base_url("cashier") ?>"><i class="fa fa-arrow-circle-left fa-2x" aria-hidden="true"></i> Back </a>
  </section>
  <!-- Main content -->
  
  <section>         
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Plate number</h3>        
          <form action="<?= base_url('cashier/searchAnprResult'); ?>" method="GET" >   
            <div class="col-lg-2 col-xs-12"> 
              <input type="text" class="form-control" id="anpr" name="anpr" placeholder="XXX-XXXX " required autocomplete="off">  
            </div>
            <div class="col-lg-2 col-xs-12">
              <button class="btn btn-success" type="submit">Search <i class="fa fa-arrow-circle-right"></i></button>
            </div>                    
          </form>       
      </div>    
      <div class="box-body">         
        <div class= "table-responsive">
          <table  class="table table-bordered table-hover table-striped">            
            <thead>
              <tr>
                <th>ID#</th>
                <th>Gate</th>
                <th>Access Type</th>
                <th>Access Code</th>                 
                <th>Check-In</th>
                <th>Vehicle Type</th>
                <th>Image</th>
                <th>Check</th>
                <!-- th>Action</th -->                  
              </tr>
            </thead>
            <tbody>    

            <?php foreach ($anpr_records as $anpr): ?>
                <tr>
                    <td><?= $anpr['id']; ?></td>
                    <td><?= $anpr['GateId']; ?></td>
                    <td><?= $anpr['AccessType']; ?></td>
                    <td><?= $anpr['parking_code']; ?></td>
                    <td>
                    <?php 
                        date_default_timezone_set('Asia/Manila');
                        echo date('Y-m-d H:i:s A', $anpr['in_time']); 
                        ?>
                    </td>
                    <td>
                      <?php
                        $vehicle = $anpr['vechile_cat_id']; 
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

                    <td>
                      <img src="<?= base_url() . '/' . $anpr['picturePath'] . $anpr['pictureName'] ?>" alt="" style="width: 200px; height:150px">
                    </td>
                    <td><a href="<?php echo base_url('cashier/payment?anpr=' . $anpr['parking_code']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-check"></i></a> </td>
                </tr>
            <?php endforeach; ?>

              
            

            </tbody>
          </table>
        </div>
      </div>
    </div>  
  </section>
</div>
<!-- /.content-wrapper -->
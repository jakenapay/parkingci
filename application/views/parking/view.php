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
      <div class="col-md-3 col-xs-3">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail View</h3>
          </div>          
            <div class="box-body">
                <label for="group_name">Entry Gate</label>
                <input type="text" class="form-control"  value="<?=$parking_data['GateId']; ?>" >
                <label for="group_name">Exit Gate</label>
                <input type="text" class="form-control"  value="<?php 
                      if($parking_data['GateEx'])
                        echo $parking_data['GateEx'];
                      else 
                        echo "not yet exit";
                ?>" >
                <label for="group_name">Access Type</label>
                <input type="text" class="form-control"  value="<?=$parking_data['AccessType']; ?>" >
                <label for="group_name">Code</label>
                <input type="text" class="form-control"  value="<?=$parking_data['parking_code']; ?>" >
                <label for="group_name">Entry time </label>
                <input type="text" class="form-control"  value="<?php 
                  date_default_timezone_set("Asia/Manila");
                  echo  date('Y-m-d  h:i:s a', $parking_data['in_time']); ?>" >
                <label for="group_name">Exit time </label>
                <input type="text" class="form-control"  value="<?php 
                     date_default_timezone_set("Asia/Manila");
                     if($parking_data['out_time'])
                        echo date('Y-m-d  h:i:s a', $parking_data['out_time']);
                     else 
                      echo "-" ;
                    ?>" >
                
                <label for="group_name">Vehicle class </label>
                <input type="text" class="form-control"  value="<?php 
                        $vcate = $parking_data['vechile_cat_id'];
                        switch($vcate){
                          case 1: echo "Motorcycle"; break;
                          case 2: echo "Car"; break;
                          case 3: echo "BUS/Truck"; break;
                          default: echo "Unknown"; break;
                        }
                        ?>">


            </div>
            <div class="box-footer">              
              <a href="<?php echo base_url('parking/') ?>" class="btn btn-danger">Back</a>
            </div>          
        </div>
        <!-- /.box -->
      </div>
      <?php if($parking_data['AccessType'] =='Plate' ){  ?>
      <div class="col-md-6 col-xs-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Image </h3>
          </div>                        
          <div class="box-body text-center">
            <!-- img src="<?= base_url('assets/images/') . "s.jpg" ?>" style="width: 409px; height:400px" class="img-rounded"  id="myImage"  -->
            
            <img src="<?= base_url($parking_data['picturePath']).$parking_data['pictureName'] ?>" style="width: 490px; height:380px" class="img-rounded img-fluid"  id="myImage">
          </div>                  
        </div>
      </div>
      <?php } ?> 
      <!-- col-md-12 -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


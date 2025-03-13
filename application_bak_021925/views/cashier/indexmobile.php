<!-- Content Wrapper. Contains page content -->
<style>
.fcc-btn {
  background-color: #5cb85c;
  color: white;
  padding: 7px 25px;
}
h1 {
  text-align: center;
  font-weight: bold;
  font-family: "Copperplate"; 
}
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
       Smart Parking System </br> 
      <small> PHILIPPINE INTERNATIONAL CONVENTION CENTER </small>
    </h1>    
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
      <form action="<?php echo base_url("mobile/payment") ?>" method="post" >   
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
                  <!-- a class="fcc-btn" href="<?php echo base_url("mobile/PlateSearch?anpr= abc-1234") ?>">Search</a -->
                  
              </div>
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-xs-12">      
        <form action="mobile/payment" method="post" >  
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
  </section>
  <section>         
    <div class="box">
      <div class="box-header">
        <h3 class="box-title " >
        Thank you for smart parking payment. </br> 
        Please enter your Plate number when you enter plate number </br>
        Please enter QR number when you enter using QR ticket dispenser </h3>
      </div>    
      <div class="box-body">
        </div>
      </div>
    </div>  
  </section>

  <!-- /.content :  Plate number , Entry time, Parking bill , Discount option , Penalty ,  -->
</div>
<!-- /.content-wrapper -->

<style>
        /* Custom CSS for extra spacing between radio buttons */
        .custom-radio-spacing .form-check-inline {
            margin-right: 20px; /* Adjust this value to increase or decrease spacing */
        }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Payment</h1>
      <ol class="breadcrumb">
        <li><a href='/parkingci/Cashier'><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cancel</li>        
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-6 col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payment </h3>
            </div>            
            <form onsubmit="return event.keyCode != 13;" action="<?php echo base_url('Cashier/finishpayment') ?>" method="post"> 
              <div class="box-body">  
                <div class="form-group  col-md-6">
                  <label for="group_name">Gate </label>                  
                  <input type="hidden" class="form-control" id="id" name="id"  value="<?php echo ($this->input->post('id'))?:$parking_data['id']; ?>" >                  
                  <input type="text" class="form-control" id="gate" name="gate" placeholder="gate" value="<?php echo ($this->input->post('gate'))?:$parking_data['gate']; ?>"  readonly>
                </div> 
                <div class="form-group  col-md-6">
                  <label for="group_name">Access Type </label>
                  <input type="text" class="form-control" id="accesstype" name="accesstype" placeholder="accesstype" value="<?php echo ($this->input->post('accesstype'))?:$parking_data['accesstype']; ?>" readonly>
                </div>                  
                <div class="form-group col-md-6">                
                  <label for="group_name">Code</label>
                  <input type="text" class="form-control" id="plate" name="code" placeholder="plate" value="<?php echo ($this->input->post('plate'))?:$parking_data['plate']; ?>" readonly>
                </div>                
                <div class="form-group col-md-6">
                  <label for="group_name">Entry time </label>
                  <input type="text" class="form-control" id="entry_time" name="entry_time" placeholder="entry_time" value="<?php echo ($this->input->post('entry_time'))?:$parking_data['entry_time']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Pay time </label>
                  <input type="text" class="form-control" id="pay_time" name="pay_time" placeholder="pay_time" value="<?php echo ($this->input->post('pay_time'))?:$parking_data['pay_time']; ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Vehicle class </label>
                  <input type="text" class="form-control" id="vehicle" name="vehicle" placeholder="vehicle class" value="<?php 
                        $vcate = $this->input->post('vclass')?:$parking_data['vclass'];
                        switch($vcate){
                          case 1: echo "Motorcycle"; break;
                          case 2: echo "Car"; break;
                          case 3: echo "BUS/Truck"; break;
                          default: echo "Unknown"; break;
                        }
                        ?>" readonly >
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Discount Option  </label>
                  <select class="form-control" id="d_option" name="d_option" required>                     
                    <option value='regular'>Regular</option>              
                    <option value='PWD'>Senior or PWD</option>
                    <option value='pasay'>Pasy resident</option>    
                    <option value='tenant'>Tenant</option>         
                    <option value='drop'>Drop Off</option>                
                  </select>                  
                </div>                
                <div class="form-group col-md-6">
                  <label for="group_name">Bill amount</label>
                  <input type="number" class="form-control" id="bill" name="bill" placeholder="bill" value="<?php echo ($this->input->post('bill'))?:$parking_data['bill']; ?>" readonly >
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Parking Time  </label>
                  <input type="text" class="form-control"  value="<?= $parking_data['Ptime']?>" >
                  <input type="hidden" class="form-control" id="Ptime" name="Ptime" placeholder="Ptime" value="<?= $parking_data['parkingtime']?>" readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Paid Amount </label>
                  <input type="number" class="form-control" id="paid_amount" name="paid_amount" required >
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Change  </label>
                  <input type="number" class="form-control" id="change" name="change"  readonly >
                </div>
                <div class="box-footer">                  
                  <div class="form-check  form-check-inline" >
                    <div class="form-group col-md-6"> 
                      <input class="form-check-input" type="radio" name="paysolution" id="paysolution" value="Cash" required >
                      <label class="form-check-label" for="cash"> Cash </label>                  
                      <input class="form-check-input" type="radio" name="paysolution" id="paysolution" value="Gcash" >
                      <label class="form-check-label" for="Gcash"> G-cash </label>
                      <input class="form-check-input" type="radio" name="paysolution" id="paysolution" value="Paymaya" >
                      <label class="form-check-label" for="Paymaya"> Paymaya </label>                  
                      <input class="form-check-input" type="radio" name="paysolution" id="paysolution" value="Complimentary" >
                      <label class="form-check-label" for="Paymaya"> Free </label>                  
                    </div>
                  </div>
                  <div class="form-group col-md-6"> 
                    <input type="text" class="form-control" name="paycode" id="Paycode" value="Reference code" >                                     
                  </div>
                </div>
                <div class="form-group col-md-6">
                      <button type="submit" class="btn btn-success">payment</button>
                      <!-- button onclick="history.back()" class="btn btn-danger">Cancel</button -->     
                      <button onclick ="location.href='/parkingci/Cashier'" class="btn btn-danger" >Cancel</button >                   
                </div>                                
              </div>
            </form>            
          </div>          
        </div>
        <div class="col-md-5 col-xs-5">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Image </h3>
            </div>                        
            <div class="box-body text-center">
              <!-- <img src="<?= base_url() .''. $parking_data['picturepath'] . $parking_data['pictureName'] ?>" alt="" style="width: 200px; height:150px"> -->

                <?php
                if (!empty($parking_data['picturepath']) && !empty($parking_data['picturename'])) {
                    $imagePath = base_url() .''. $parking_data['picturepath'] . $parking_data['picturename'];
                    echo '<img src="' . $imagePath . '" style="width: 600px; height: 480px" class="img-rounded" id="myImage">';
                } else {
                    echo 'No Image';
                }
                ?>
            </div>                  
          </div>
                  
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
<link rel="stylesheet" href="<?php echo base_url('assets/cashier_assets/edit_components/edit.css') ?>">
<!-- script src="<?php echo base_url('assets/cashier_assets/edit_components/edit.js') ?>"></script -->

<script>
let billdata = <?php echo $parking_data['bill']; ?> ;      
var vcat = <?php echo $parking_data['vclass']; ?> ;

$(document).ready(function(){
  $("#d_option").change(function(){ 
    var discount_rate = $(this).val();
    amount = document.getElementById('bill');
    paid =document.getElementById('paid_amount');
   console.log(discount_rate);
    switch (vcat) {
      case 1:
        if((discount_rate == 'PWD') ||(discount_rate =='tenant')) {
          amount.value = parseInt(billdata)-10;
        }          
        else if(discount_rate == 'pasay') {
          amount.value = 0;
          paid.value =0;
        }
        else if(discount_rate == 'drop') {
          amount.value = 0 ;
          paid.value =0;
        }        
        else {
          amount.value =parseInt(billdata);
        }      
        break;
      case 2 :
        if((discount_rate == 'PWD') ||(discount_rate =='tenant')) {
          amount.value = parseInt(billdata)-20;
          console.log(amount.log)
        }          
        else if(discount_rate == 'pasay') {
          amount.value = 0;
          paid.value =0;
       }
        else if(discount_rate == 'drop') {
          amount.value = 0 ;
          paid.value =0;
        }        
        else {
          amount.value = parseInt(billdata);
        }
        break;
      case 3:        
          amount.value = parseInt(billdata);       
        break;      
      default:
          amount.value = parseInt(billdata);    
          console.log(amount.log)
          break;            
    }
  });

    $("#paid_amount").change(function(){
      var amount = $(this).val();  
      billinput = document.getElementById('bill');
      const billamount = billinput.value;  
      console.log (billamount);  
      const change = document.getElementById('change');
      var change_amount = amount - billamount;
      console.log (change_amount);
      change.value = change_amount;
    });
    
})
    
</script>  
<script>
  $(document).ready(function(){
    $(document).on('input', '#paysolution', function(){ 
      var paysolution = $(this).val();
      var billAmountInput = $("#bill");
      var paidAmountInput = $("#paid_amount");
      var changeAmountInput = $("#change");
      var originalBill = <?= $parking_data['bill']; ?>; // Echo PHP value here
      console.log(originalBill);
      
      if(paysolution === "Complimentary") {
        billAmountInput.val(0);
        paidAmountInput.val(0);
        changeAmountInput.val(0);
      } else {
        billAmountInput.val(originalBill);
      }
    });
  });
</script>



</div>
  <!-- /.content-wrapper -->


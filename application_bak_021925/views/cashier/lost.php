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
      <h1>Lost Ticket Payment</h1>
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
              <h3 class="box-title">Lost Ticket </h3>
            </div>            
            <form action="<?php echo base_url('Cashier/lost_receipt/') ?>" method="post"> 
              <div class="box-body">  
                <div class="form-group  col-md-6">
                  <label for="group_name">Gate </label>                  
                  <input type="hidden" class="form-control" id="id" name="id"  value="" >   
                  <input type="hidden" class="form-control" id="vehicletype" name="vehicletype" value="" >
                  <input type="hidden" class="form-control" id="discount" name="discount"  value="" >               
                  <input type="text" class="form-control" id="gate" name="gate" value="G-" disabled >
                </div> 
                <div class="form-group  col-md-6">
                  <label for="group_name">Access Type </label>
                  <input type="text" class="form-control" id="accesstype" name="accesstype" value="QR" disabled>
                </div>                  
                <div class="form-group col-md-6">                
                  <label for="group_name">Code</label>
                  <input type="text" class="form-control" id="plate" name="plate"  value="lost ticket" disabled>
                </div>                
                <div class="form-group col-md-6">
                  <label for="group_name">Entry time </label>
                  <input type="text" class="form-control" id="entry_time" name="entry_time" value="" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Pay time </label>
                  <input type="text" class="form-control" id="pay_time" name="pay_time" value="-" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Vehicle class and discount </label>                  
                    <select class="form-control" id="vehicled" name="vehicled">
                      <option value=0 >---select---</option>
                      <option value= 1 >Motocycle(regular/tenants)</option> 
                      <option value= 2 >Motocycle(pwd/senior)</option>     
                      <option value= 3 >Car (regular/tenants)</option>              
                      <option value= 4 >Car (pwd/senior)</option>
                      <option value= 5 >BUS/Truck</option>              
                    </select>

                </div>                 
                <div class="form-group col-md-6">
                  <label for="group_name">Bill amount</label>
                  <input type="text" class="form-control" id="bill" name="bill" readyonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Parking Time  </label>
                  <input type="text" class="form-control" id="Ptime" name="Ptime" placeholder ='lost ticket' disabled >
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Paid Amount </label>
                  <input type="number" class="form-control" id="paid_amount" name="paid_amount" >
                </div>
                <div class="form-group col-md-6">
                  <label for="group_name">Change </label>
                  <input type="number" class="form-control" id="change" name="change" >
                </div>
                <div class="box-footer">                  
                  <div class="form-check  form-check-inline">
                    <div class="form-group col-md-6"> 
                      <input class="form-check-input" type="radio" name="paysolution" id="cash" value="cash" checked>
                      <label class="form-check-label" for="cash"> Cash </label>                  
                      <input class="form-check-input" type="radio" name="paysolution" id="Gcash" value="Gcash" >
                      <label class="form-check-label" for="Gcash"> G-cash </label>
                      <input class="form-check-input" type="radio" name="paysolution" id="Paymaya" value="Paymaya" >
                      <label class="form-check-label" for="Paymaya"> Paymaya </label>                  
                    </div>
                  </div>
                  <div class="form-group col-md-6"> 
                    <input type="text" class="form-control" name="paycode" id="Paycode" value="Reference code" >                                     
                  </div>
                </div>
                <div class="form-group col-md-6">
                      <button type="submit" class="btn btn-success">payment</button>
                      <!-- button onclick="history.back()" class="btn btn-danger">Cancel</button -->                      
                </div>                                
              </div>
            </form>            
          </div>          
        </div>        
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
<script>

  $(document).ready(function(){
    $("#vehicled").change(function(){
      var vehicle = $(this).val();          
      amount = document.getElementById('bill');
      discount = document.getElementById('discount');
      switch(vehicle){
        case '1': amount.value = '200';
                  discount.value = 'regular';             
          break;
        case '2': amount.value = '140'; 
                  discount.value = "pwd/senior";
          break;
        case '3': amount.value = '300';
                  discount.value = "regular";        
          break;
        case '4': amount.value = '200';
                  discount.value = "pwd/senior";
          break;
        case '5': amount.value = '600';
                  discount.value = "regular";;         
          break;
        default: amount.value = '0';
                  discount.value = "regular";
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
</div>
  <!-- /.content-wrapper -->


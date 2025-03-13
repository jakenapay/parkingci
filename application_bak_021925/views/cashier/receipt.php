<!-- Content Wrapper. Contains page content -->
<style>

#clock {
font-family: Arial, sans-serif;
text-align: center;
font-size: 5em;
background-color: purple;
color: white;
margin-top: 50px;
}
.fcc-btn {
  background-color: #5cb85c;
  color: white;
  padding: 7px 25px;
}

.receipt{
    width: 250px;
    background: #EFECEC;
    padding: 10px;
}

.receipt-header{
    width: 100%;
}

.receipt-header img{
    width: 90%;
    height: 70px
}
.receipt-content{
    width: 100%;
}
.row-justify{
    width: 100%;
    display: flex;
    flex: nowrap;
    margin-top: 8px;
}

.row-justify-receipt{
    width: 100%;
    display: flex;
    flex: nowrap;
}

/*  */

.left{
    width: 50%;

}
.left .content-text {
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}

.row-justify .content-text-bold{
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}
.row-normal{
    width: 100%;
    margin-top: 8px;
}
.row-normal .content-text{
    font-size: 10px;
    padding: 0;
    text-align: left;
}

.row-center{
    width: 100%;
    margin-top: 8px;
}

.right{
    width: 50%;
}
.row-justify-bills{
    width: 100%;
    display: flex;
    margin-top: 8px;
}

.row-justify-bills .content-text-bold{
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}
.row-justify-bills .content-text{
    font-size: 10px;
    padding: 0;
    text-align: left;
}
.row-center .content-text{
    text-align: center;
    font-size: 10px;
    padding: 0;
}

.row-center .content-text-bold{
    text-align: center;
    font-size: 10px;
    padding: 0;
    font-weight: bold;
}

.right .content-text {
    font-size: 10px;
    padding: 0;
    text-align: right;
}

</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <small> </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> <?php   echo "Cashier : ".$this->session->userdata('fname')." ".$this->session->userdata('lname') ?> </li>      
    </ol>
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

    </div>

    <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="row">
                    
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="row">

                        <div class="col-lg-6 col-xs-6">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title pull-left">Client Transaction Summary</h3>
                                    <span class="label label-danger pull-right" style="font-size: 16px; font-weight: 400;"><?= $this->session->userdata('username') ?></span>
                                </div>
                                <div class="box-body">
                                    <div class="col-lg-12 col-xs-12">
                                        <div class="row">
                                            <div class="box-title">
                                                <div class="col-6">
                                                    <h4 class="pull-left"><span class="label label-primary" style="font-size: 16px;"><?= $company_info['organization']; ?></span></h4>
                                                </div>
                                                <div class="col-6">
                                                    <h4 class="pull-right">Date <span class="label label-primary" style="font-size: 16px;"><?= $parking_data['paymenttime']; ?></span></h4>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <p>==============================================================================================</p>
                                                <h3 class="pull-left">Company Information</h3>
                                                
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            
                                                <div class="row">
                                                    <p class="label label-info">******************************************************************************************************************************************************************************************</p>

                                                    <div class="col-6">
                                                        <h5 class="pull-left"><?= $company_info['address']; ?></h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="pull-right"><?= $company_info['telephone']; ?></h5>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">VAT REG TIN: <?= $company_info['tin']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="pull-left">MIN: <?= $company_info['min']; ?></h5>
                                            </div>
                                            <p class="label label-info">******************************************************************************************************************************************************************************************</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="pull-left">Payment Transaction</h3>
                                                <h3 class="pull-right text-danger">OR# <?= $parking_data['ORNO']; ?></h3>
                                            </div>
                                            <p class="label label-warning">******************************************************************************************************************************************************************************************</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Gate Entry Time</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right"><?= $parking_data['etime']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Billing Time</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right"><?= $parking_data['paymenttime']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Parking Time</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right"><?= $parking_data['parktime']; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Amount Due</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right">PHP <?= $amount; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Vat(12%)</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right">PHP <?= $vat; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Total Amount Due</h5>
                                            </div>
                                            <div class="col-6">
                                            <h5 class="pull-right">PHP <?= $parking_data['bill']; ?></h5>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Vatable Sales</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="pull-right">PHP <?= $amount; ?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Vat-Examp</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="pull-right">PHP 0.0</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Discount</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="pull-right">
                                                    <?php
                                                        if($parking_data['discount'] === "regular"){
                                                            echo "PHP 0.0";
                                                        }
                                                    ?>    
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="pull-left">Payment Mode</h5>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="pull-right"><?= $parking_data['paymode']; ?></h5>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row text-center">
                                            <a href="<?= base_url('cashier'); ?>" class="btn btn-danger">&times; Close</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div class="box text-center">
                                <h4 class="text-center">Do you want to print a receipt?</h4>
                                <h4 class="text-center label label-primary" style="font-size: 13px; font-weight: 400">Receipt Preview</h4>
                                <div class="box-body" style="display: flex; justify-content: center;">
                                    <div class="receipt">
                                        <div class="receipt-header">
                                            <img src="<?= base_url('assets/images/')?>picc.png" alt="">
                                        </div>
                                        <div class="receipt-content">
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text"><?= $company_info['organization'] ?></div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">Date: <?= $parking_data['paymenttime'] ?></div>
                                                </div>
                                            </div>
                                            <div class="row-normal">
                                                <div class="content-text"><?= $company_info['address'] ?></div>
                                                <div class="content-text"><?= $company_info['telephone'] ?></div>

                                            </div>


                                            <div class="row-center">
                                                <div class="content-text">VAT REG TIN: <?= $company_info['tin'] ?></div>
                                                <div class="content-text">MIN: <?= $company_info['min'] ?></div>
                                                <div class="content-text">ORNO: <?= $parking_data['ORNO'] ?></div>
                                                <div class="content-text"><?= $parking_data['access'] ?>: <?= $parking_data['code']; ?></div>
                                                <div class="content-text-bold">Vehicle:
                                                    <?php
                                                        $vehicleType = $parking_data['vehicle']; 

                                                        if($vehicleType == "1"){
                                                            echo "Motorcycle";
                                                        }else if ($vehicleType == "2"){
                                                            echo "Car";
                                                        }else if ($vehicleType == "3"){
                                                            echo "BUS/Truck";
                                                        }else{
                                                            echo "Unknown";
                                                        }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="row-center">
                                                    <div class="content-text-bold">Receipt</div>
                                                
                                            </div>

                                            <div class="row-justify">
                                                    <div class="left">
                                                        <div class="content-text-bold">Cashier</div>
                                                    </div>
                                                    <div class="right">
                                                        <div class="content-text"><?= $this->session->userdata['username']; ?></div>
                                                    </div>
                                            </div>

                                            <p>============================</p>

                                            <div class="row-justify-bills">
                                                <div class="left">
                                                    <div class="content-text-bold">Gate In:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text"><?= $parking_data['etime']; ?></div>
                                                </div>
                                            </div>
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Bill Time:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text"><?= $parking_data['paymenttime']; ?></div>
                                                </div>
                                            </div>

                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Parking Time:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text"><?= $parking_data['parktime']; ?></div>
                                                </div>
                                            </div>
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Amount Due:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?= $amount; ?></div>
                                                </div>
                                            </div>

                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Vat(12%):</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?= $vat; ?></div>
                                                </div>
                                            </div>
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Total Amount Due:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?= $parking_data['bill']; ?></div>
                                                </div>
                                            </div>
                                            <p>============================</p>
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Vatable Sales:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?= $amount; ?></div>
                                                </div>
                                            </div>

                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Vat-Examp:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP 0.0</div>
                                                </div>
                                            </div>
                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Discount:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?php
                                                        if($parking_data['discount'] === "regular"){
                                                                echo "0.0";
                                                            }
                                                        ?>    
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row-justify">
                                                <div class="left">
                                                    <div class="content-text-bold">Payment Mode:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="content-text">PHP <?= $parking_data['paymode']; ?></div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row-center">
                                                <div class="content-text">NTEKSYSTEMS Incorporation</div>
                                                <div class="content-text">ACCREDITATION: 044778686889755</div>
                                                <div class="content-text">Date Issued: 12/12/2020</div>
                                                <div class="content-text">Valid Until: 12/12/2024</div>
                                                <div class="content-text">BIR PTU NO: FP2782342-23476238</div>
                                                <div class="content-text">PTU DATE ISSUED: 11/24/2020</div>
                                                <div class="content-text">THIS SERVES AS AN OFFICIAL RECEIPT</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <button class="btn btn-primary btn-sm" onclick="printReceipt()"> Print Receipt</button>
                                <hr>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>


    <!-- /.row -->
  </section>


  <!-- /.content :  Plate number , Entry time, Parking bill , Discount option , Penalty ,  -->
</div>
<!-- /.content-wrapper -->

<script>
var clock = document.getElementById("clock");
function updateClock() {
var date = new Date();
var hours = date.getHours().toString().padStart(2, "0");
var minutes = date.getMinutes().toString().padStart(2, "0");
var seconds = date.getSeconds().toString().padStart(2, "0");
clock.textContent = date.toDateString() + "    "+hours + ":" + minutes + ":" + seconds;
}
setInterval(updateClock, 1000);
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable();

    $("#slotsSideTree").addClass('active');
    $("#manageSlotsSideTree").addClass('active');
  });
</script>

<script>
function printReceipt() {
    // Remove elements with class "no-print"
    var elementsToExclude = document.querySelectorAll('.no-print');
    elementsToExclude.forEach(function(element) {
        element.remove();
    });

    // Adjust the width of the receipt content and its child elements to fit within the printing area
    var receiptContent = document.querySelector('.receipt');
    receiptContent.style.width = '100%';
    receiptContent.style.maxWidth = '250px';

    var receiptContentChildren = receiptContent.children;
    for (var i = 0; i < receiptContentChildren.length; i++) {
        receiptContentChildren[i].style.width = '100%';
        receiptContentChildren[i].style.boxSizing = 'border-box';
    }

    var receiptHTML = document.querySelector('.receipt').outerHTML;

    var myWindow = window.open('', 'PRINT', 'height=400,width=600');
    myWindow.document.write('<html><head><title>Receipt</title>');
    myWindow.document.write('<style>');
    myWindow.document.write(`
    .receipt{
    width: 250px;
    background: #EFECEC;
    padding: 10px;
}

.receipt-header{
    width: 100%;
}

.receipt-header img{
    width: 90%;
    height: 70px
}
.receipt-content{
    width: 100%;
}
.row-justify{
    width: 100%;
    display: flex;
    flex: nowrap;
    margin-top: 8px;
}

.row-justify-receipt{
    width: 100%;
    display: flex;
    flex: nowrap;
}

/*  */

.left{
    width: 50%;

}
.left .content-text {
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}

.row-justify .content-text-bold{
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}
.row-normal{
    width: 100%;
    margin-top: 8px;
}
.row-normal .content-text{
    font-size: 10px;
    padding: 0;
    text-align: left;
}

.row-center{
    width: 100%;
    margin-top: 8px;
}

.right{
    width: 50%;
}
.row-justify-bills{
    width: 100%;
    display: flex;
    margin-top: 8px;
}

.row-justify-bills .content-text-bold{
    font-size: 10px;
    padding: 0;
    text-align: left;
    font-weight: bold;
}
.row-justify-bills .content-text{
    font-size: 10px;
    padding: 0;
    text-align: left;
}
.row-center .content-text{
    text-align: center;
    font-size: 10px;
    padding: 0;
}

.row-center .content-text-bold{
    text-align: center;
    font-size: 10px;
    padding: 0;
    font-weight: bold;
}

.right .content-text {
    font-size: 10px;
    padding: 0;
    text-align: right;
}
    `);
    myWindow.document.write('</style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write(receiptHTML);
    myWindow.document.write('</body></html>');

    myWindow.document.close(); // necessary for IE >= 10
    myWindow.focus(); // necessary for IE >= 10*/

    myWindow.print();
    myWindow.close();

    return true;
}
</script>

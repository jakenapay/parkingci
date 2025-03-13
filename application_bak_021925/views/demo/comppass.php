<section class="content-wrapper">
  <section class="content-header">
    <h1>Parking <small>Gate Pass</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">
        <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
      </li>
    </ol>
  </section>
  <div class="content">
    <div class="receipt">
      <div class="header">
        <div class="company-info">
          PICC<br>
          Philippine International Convention Center<br>
          PICC Complex 1307 Pasay City,<br>
          Metro Manila, Philippines<br>
          VAT REG TIN: 000-000-000-00000<br>
          MIN: 1234567891<br>
          (+63)8396594578
        </div>
      </div>

      <div class="training-mode">TRAINING MODE</div>

      <div class="details">
        <div class="row">
          <div>Date and Time: <?= date("m-d-Y h:i:s A") ?></div>
        </div>
        <div class="row">
          <div><?= $receipt['accessType']; ?>: <?= $receipt['parkingCode']; ?></div>
        </div>
        <div class="row">
          <div>Vehicle: <?php
                            $vehicle = $receipt['vehicleClass'];
                            if($vehicle==1){
                                echo "Motorcycle";
                            } else if($vehicle == 2){
                                echo "Car";
                            } else if($vehicle == 3){
                                echo "BUS/Truck";
                            } else {
                                echo "Unknown";
                            }
                        ?></div>
        </div>
      </div>

      <div class="divider"></div>

      <div class="details">
        <div class="row">
          <div>Gate In:</div>
          <div><?= date('Y-m-d H:i:s A', $receipt['entryTime']); ?></div>
        </div>
        <div class="row">
          <div>Billing Time:</div>
          <div><?= date('Y-m-d H:i:s A', $receipt['billingTime']); ?></div>
        </div>
        <div class="row">
          <div>Parking Time:</div>
          <div><?= $receipt['parkingStay'] ?></span></div>
        </div>
      </div>
    </div>
    <button onclick="printReceipt()">Print Receipt</button>

  </div>
</section>

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
  }

  .receipt {
    background-color: white;
    padding: 20px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 40px auto;
  }

  .header {
    margin-bottom: 20px;
  }

  .company-info {
    font-size: 14px;
    color: #333;
    text-align: center;
    line-height: 1.5;
  }

  .training-mode {
    background-color: #ffda79;
    color: #856404;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
  }

  .details {
    margin-bottom: 20px;
  }

  .row {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    margin-bottom: 8px;
  }

  .row span:first-child {
    font-weight: bold;
  }

  .divider {
    height: 1px;
    background-color: #e0e0e0;
    margin-bottom: 20px;
  }

  .footer {
    font-size: 12px;
    color: #666;
    text-align: center;
  }
</style>
<script>
function printReceipt() {
  const receiptContent = document.querySelector('.receipt').innerHTML;
  const printWindow = window.open('', '_blank');
  printWindow.document.open();
  printWindow.document.write(`
    <html>
      <head>
        <title>Print Receipt</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
          }

          .receipt {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin: 40px auto;
          }

          .header {
            margin-bottom: 20px;
          }

          .company-info {
            font-size: 14px;
            color: #333;
            text-align: center;
            line-height: 1.5;
          }

          .training-mode {
            background-color: #ffda79;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
          }

          .details {
            margin-bottom: 20px;
          }

          .row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            margin-bottom: 8px;
          }

          .row span:first-child {
            font-weight: bold;
          }

          .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin-bottom: 20px;
          }
        </style>
      </head>
      <body onload="window.print(); window.close();">
        <div class="receipt">${receiptContent}</div>
      </body>
    </html>
  `);
  printWindow.document.close();
}
</script>
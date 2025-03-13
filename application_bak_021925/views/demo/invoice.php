<section class="content-wrapper">
    <section class="content-header">
        <h1>Parking
            <small>Manage billing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <button onclick="printReceipt()" class="print-button">Print Receipt</button>

        <div class="receipt">
            <div class="header">
                <div class="company-name">PICC</div>
                <div class="address">Philippine International Convention Center<br>
                    PICC Complex 1307 Pasay City,<br>
                    Metro Manila, Philippines<br>
                    VAT REG TIN: 000-000-000-00000<br>
                    MIN: 1234567891<br>
                    (+63)8396594578
                </div>
            </div>

            <div class="training-mode">TRAINING MODE</div>
            <div class="details">
                
                <div class="row-center-data">
                <div>Date and Time: <?= date("m-d-Y h:i:s A") ?></div>
                </div>
                <div class="row-center-data">
                    <div>S/I: <?= $receipt['salesInvoice'] ?></div>
                </div>
                <div class="row-center-data">
                    <div><?= $receipt['accessType']; ?>: <?= $receipt['parkingCode']; ?></div>
                </div>
                <div class="row-center-data">
                <div>
                    Vehicle:
                        <?php
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
                        ?>
                    </div>
                </div>
                <div class="row-data">
                    <div>
                    Vehicle:
                        <?php
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
                        ?>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="details">
                <div class="row-data">
                    <span>Cashier:</span>
                    <span><?= $this->session->userdata('fname') ?></span>
                </div>
                <div class="row-data">
                    <span>Terminal:</span>
                    <span>terminal1</span>
                </div>
            </div>

            <div class="details">
                <div class="row-data">
                    <span>Gate In:</span>
                    <span><?= date('Y-m-d H:i:s A', $receipt['entryTime']); ?></span>
                </div>
                <div class="row-data">
                    <span>Bill Time:</span>
                    <span><?= date('Y-m-d H:i:s A', $receipt['billingTime']); ?></span>
                </div>
                <div class="row-data">
                    <span>Parking Time:</span>
                    <span><?= $receipt['parkingStay'] ?></span>
                </div>
                <div class="row-data">
                    <span>Total Sales:</span>
                    <span>₱<?= number_format($receipt['totalAmountDue'], 2) ?></span>
                </div>
                <div class="row-data">
                    <span>Vat (12%):</span>
                    <span>₱<?= number_format($receipt['vatAmount'], 2) ?></span>
                </div>
                <div class="row-data">
                    <span>Total Amount Due:</span>
                    <span>₱<?= number_format($receipt['totalAmountDue'], 2) ?></span>
                </div>
            </div>

            <div class="divider"></div>

            <div class="details">
                <div class="row-data">
                    <div>Vatable Sales:</div>
                    <div>₱<?= number_format($receipt['vatableSales'], 2) ?></div>
                </div>
                <div class="row-data">
                    <div>Non-Vat Sales:</div>
                    <div>₱<?= number_format($receipt['nonvatSales'], 2) ?></div>
                </div>
                <div class="row-data">
                    <div>Vat-Exempt:</div>
                    <div>₱<?= number_format($receipt['vatExempt'], 2) ?></div>
                </div>
                <div class="row-data">
                    <div>Discount:</div>
                    <div>₱<?= number_format($receipt['discount'], 2) ?></div>
                </div>
                <div class="row-data">
                    <div>Payment Mode:</div>
                    <div><?= $receipt['paymode'] ?></div>
                </div>
            </div>

            <div class="info-block">
                <div class="row-data"><span>Name:</span> <div class="empty-field"></div></div>
                <div class="row-data"><span>Address:</span> <div class="empty-field"></div></div>
                <div class="row-data"><span>TIN:</span> <div class="empty-field"></div></div>
                <div class="row-data"><span>ID Number:</span> <div class="empty-field"></div></div>
            </div>

            <div class="footer">
                <p>BIR PTU NO: AB1234567-12345678<br>
                PTU DATE ISSUED: 11/24/2020<br>
                THIS SALES INVOICE BE VALID FOR FIVE(5) YEARS<br>
                FROM THE DATE OF PERMIT TO USE</p>
            </div>
        </div>
    </div>
</section>

<style>
  .receipt {
    font-family: 'Courier New', monospace;
    background: white;
    padding: 20px;
    width: 450px;
    margin: 20px auto;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  .print-button {
    display: inline-block;
    padding: 10px 20px;
    margin: 15px 0;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
  }

  .print-button:hover {
    background-color: #45a049;
  }

  .header {
    text-align: center;
    padding-bottom: 15px;
    border-bottom: 1px dashed #ccc;
  }

  .company-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .address {
    font-size: 12px;
    line-height: 1.4;
    color: #333;
  }

  .training-mode {
    color: #272727;
    padding: 8px;
    margin: 15px 0;
    text-align: center;
    font-weight: bold;
    border-radius: 4px;
  }

  .row-data {
    display: flex;
    justify-content: space-between;
    margin: 6px 0;
    font-size: 13px;
  }

  .divider {
    border-top: 1px dashed #ccc;
    margin: 15px 0;
  }

  .total {
    font-weight: bold;
    font-size: 14px;
    background: #f8f9fa;
    padding: 8px;
    margin: 10px -8px;
    border-radius: 4px;
  }

  .info-block {
    margin: 20px 0;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 4px;
  }

  .info-block .row-data {
    margin: 5px 0;
    font-size: 12px;
  }

  .row-center-data{
    text-align: center;
    display: flex;
    justify-content: center
  }

  .empty-field {
    border-bottom: 1px solid #ddd;
    margin: 5px 0;
    height: 16px;
    flex: 1;
  }

  .footer {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px dashed #ccc;
    font-size: 11px;
    color: #666;
    line-height: 1.4;
    text-align: center; /* Center-aligns the text */
}

  @media print {
    .receipt {
      box-shadow: none;
      padding: 0;
    }
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
          .receipt {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 20px;
            width: 450px;
            margin: 20px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
          }
          .print-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 15px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
          }

          .print-button:hover {
            background-color: #45a049;
          }

          .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 1px dashed #ccc;
          }

          .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
          }

          .address {
            font-size: 12px;
            line-height: 1.4;
            color: #333;
          }

          .training-mode {
            color: #272727;
            padding: 8px;
            margin: 15px 0;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
          }

          .row-data {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 13px;
          }

          .divider {
            border-top: 1px dashed #ccc;
            margin: 15px 0;
          }

          .info-block {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
          }

          .info-block .row-data {
            margin: 5px 0;
            font-size: 12px;
          }

          .row-center-data{
            text-align: center;
            display: flex;
            justify-content: center
          }

          .empty-field {
            border-bottom: 1px solid #ddd;
            margin: 5px 0;
            height: 16px;
            flex: 1;
          }

          .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
            font-size: 11px;
            color: #666;
            line-height: 1.4;
            text-align: center;
          }

          @media print {
            .receipt {
              box-shadow: none;
              padding: 0;
            }
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

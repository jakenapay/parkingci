<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
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
        <div class="col-md-6">
        <div class="receipt">
            <div class="header">
                <!-- <div class="logo">PAYMENT STATUS</div> -->
                <div class="success-icon"></div>
                <div style="color: #22c55e; font-weight: bold;">Payment Successful</div>
            </div>

            <div class="parking-details">
                <div class="detail-row">
                    <strong>Access Type:</strong>
                    <span><?php echo $receipt['accessType']; ?></span>
                </div>
                <div class="detail-row">
                    <strong>Parking Code:</strong>
                    <span><?php echo $receipt['parkingCode']; ?></span>
                </div>
                <div class="detail-row">
                    <strong>Entry Time:</strong>
                    <span><?php date_default_timezone_set("Asia/Manila"); echo date('Y-m-d H:i:s A',$receipt['entryTime']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Billing Time:</strong>
                    <span><?php date_default_timezone_set("Asia/Manila"); echo date('Y-m-d H:i:s A',$receipt['paymentTime']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Duration:</strong>
                    <span><span><?php echo $receipt['parkingStay']; ?></span></span>
                </div>
                <div class="detail-row">
                    <strong>Vehicle Type:</strong>
                    <span>
                        <?php
                            $vehicleId = $receipt['vehicleClass'];

                            if($vehicleId == 1){
                                echo "Motorcycle";
                            }else if($vehicleId == 2){
                                echo "Car";
                            }else if($vehicleId == 3){
                                echo "BUS/Truck";
                            }else{
                                echo "Unknown";
                            }
                        ?>
                    </span>
                </div>
            </div>

            <div class="divider"></div>

            <div class="detail-row">
                <strong>Rate:</strong>
                <span><?php echo $receipt['parkingStatus']; ?></span>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>TOTAL PAID</span>
                    <span>&#8369; <?php echo number_format($receipt['totalSales'], 2); ?></span>
                </div>
            </div>

            <div class="detail-row">
                <strong>Payment Method:</strong>
                <span><?php echo $receipt['paymentMode']; ?></span>
            </div>
            <div class="detail-row">
                <strong>Amount Original Due</strong><span> <?php echo number_format($receipt['totalAmountDue'], 2); ?></span></div>
            <div class="detail-row"> <strong>VAT Sales :</strong> <span><?php echo number_format($receipt['vatableSales'], 2); ?></span></div>
            <div class="detail-row"> <strong>VAT EXMPT Sales:</strong> <span><?php echo number_format($receipt['vatExempt'], 2); ?></span></div>
            <div class="detail-row"> <strong>VAT Zero Rated:</strong> <span><?php echo number_format($receipt['nonVat'], 2); ?></span></div>
            <div class="detail-row"> <strong>VAT (12%) :</strong> <span><?php echo number_format($receipt['vatAmount'], 2); ?></span></div>
            <div class="detail-row"> <span><?php echo "==========================================" ?></span></div>
            
            <div class="detail-row"> <strong>Discount Type:</strong> <span><?php echo $receipt['discountDisplay'] ?></span></div>
            <div class="detail-row"> <strong>Total Less VAT :</strong> <span><?php echo number_format($receipt['vatExempt'], 2);  ?></span></div>           
            <div class="detail-row"><strong>Amount Discounted:</strong><span><?php echo number_format($receipt['discount'], 2); ?></span></div>            
            <div class="detail-row"><strong>Amount Due:</strong> <span><?php echo number_format($receipt['totalSales'], 2); ?></span></div>            
            <div class="detail-row"><strong>Cash :</strong> <span><?php echo number_format($receipt['cashReceived'], 2); ?></span></div>            
            <div class="detail-row"><strong>Change:</strong> <span><?php echo number_format($receipt['changeDue'], 2); ?></span></div>            
            
            <div class="printer-selection">
                <div class="printer-dropdown">
                    <label for="printerName">Select an installed Printer:</label>
                    <select name="printerName" id="printerName"></select>
                </div>
                <button onclick="doPrinting();" class="print-button">Print Receipt</button>
            </div>
        </div>
        </div>

        <div class="col-md-6">
            <div class="form-section">
                <h3>Customer Discounted Details</h3>
                <form action="<?php echo base_url('touchpoint/addCustomerDetail') ?>" method="POST">
                    <div class="form-group">
                        <input type="text" id="transact_id" name="transact_id" value="<?php echo $receipt['transactionId']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="discount_type" name="discount_type" value="<?php echo $receipt['discountType']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="tin_id">TIN ID</label>
                        <input type="text" class="form-control" id="tin_id" name="tin_id" value="N/A" value="N/A">
                    </div>
                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" class="form-control" id="id_number" name="id_number" value="N/A">
                    </div>
                    <div class="form-group">
                        <label for="child_name">Child Name</label>
                        <input type="text" class="form-control" id="child_name" name="child_name" value="N/A">
                    </div>
                    <div class="form-group">
                        <label for="child_dob">Child DOB</label>
                        <input type="date" class="form-control" id="child_dob" name="child_dob" >
                    </div>
                    <button type="submit" class="btn-submit">Submit</button>
                </form>
            </div>
        </div>

    </div>
</section>

<style>


        .receipt {
            background: white;
            width: 100%;
            max-width: 380px;   
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #ddd;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background-color: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 15px auto;
        }

        .success-icon::after {
            content: "✓";
            font-size: 35px;
            color: white;
        }

        .parking-details {
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .detail-row strong {
            color: #333;
        }

        .detail-row span {
            color: #666;
        }

        .total-section {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .printer-selection {
        text-align: center;
        margin-top: 20px;
    }

    .checkbox {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #333;
    }

    .checkbox input[type="checkbox"] {
        width: 16px;
        height: 16px;
    }

    .printer-dropdown {
        margin: 10px 0;
    }

    .printer-dropdown label {
        font-size: 14px;
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .printer-dropdown select {
        width: 100%;
        max-width: 280px;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }

        .print-button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #22c55e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
        }

        .print-button:hover {
            background-color: #1ea550;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }

        .divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }

        @media print {

            .receipt {
                box-shadow: none;
            }
            .print-button {
                display: none;
            }
        }

.form-section {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-section h3 {
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-submit {
        background-color: #22c55e;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #1ea550;
    }
    </style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <!--IMPORTANT: BE SURE YOU HONOR THIS JS LOAD ORDER-->
    <script src="https://jsprintmanager.azurewebsites.net/scripts/cptable.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/cputils.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/JSESCPOSBuilder.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/JSPrintManager.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/zip.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/zip-ext.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/deflate.js"></script>
<script>
    var receiptData = <?php echo $this->data['receiptData']; ?>;

    var vehicleClass = <?php echo $receipt['vehicleClass']; ?>;

    var vehicleType = "Unknown"; // Default value
    if (vehicleClass == 1) {
    vehicleType = "Motorcycle";
    } else if (vehicleClass == 2) {
    vehicleType = "Car";
    } else if (vehicleClass == 3) {
    vehicleType = "Bus/Truck";
    }
      var clientPrinters = null;

      // WebSocket settings
      JSPM.JSPrintManager.auto_reconnect = true;
      JSPM.JSPrintManager.start();
      JSPM.JSPrintManager.WS.onStatusChanged = function () {
        if (jspmWSStatus()) {
          // Get client installed printers
          JSPM.JSPrintManager.getPrinters().then(function (printersList) {
            clientPrinters = printersList;
            var options = "";
            for (var i = 0; i < clientPrinters.length; i++) {
              options += "<option>" + clientPrinters[i] + "</option>";
            }
            $("#printerName").html(options);
          });
        }
      };

      // Check JSPM WebSocket status
      function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
          return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
          console.warn(
            "JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm"
          );
          return false;
        } else if (
          JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked
        ) {
          alert("JSPM has blocked this website!");
          return false;
        }
      }

      // Do printing...
      function doPrinting() {
        if (jspmWSStatus()) {
          var escpos = Neodynamic.JSESCPOSBuilder;
          var doc = new escpos.Document();

          // Generate ESC/POS commands with the updated content
          var escposCommands = doc
            .font(escpos.FontFamily.A)
            .align(escpos.TextAlignment.Center)
            .style([escpos.FontStyle.Bold])
            .size(1, 1) // Larger size for "PICC"
            .text("PICC")
            .feed(1)
            .font(escpos.FontFamily.A)
            .size(0, 0) // Standard size for the rest
            .text("Philippine International Convention Center")
            .text("PICC Complex 1307, Pasay City,")
            .text("Metro Manila, Philippines")
            .text("VAT REG TIN: 544-656-656-6166")
            .text("MIN: MCH-001234")
            .text("SN: 6565465416")
            .feed(1)
            .text("TRAINING MODE")
            .feed(1)
            // Additional details
            .text("Date and Time: " + new Date(receiptData.paymentTime * 1000).toISOString().slice(0, 19).replace("T", " "))
            .text("S/I #: 00-" + receiptData.salesInvoice)
            .text(receiptData.accessType + ": " + receiptData.parkingCode)
            .text("Vehicle: " + vehicleType)
            .feed(1)
            .style([escpos.FontStyle.Bold])
            .text("Sales Invoice")
            .feed(1)
            .text("------------------------------------------------") // Divider
            .text(
                "Cashier:" +
                " ".repeat(48 - "Cashier:".length - receiptData.cashierName.length) +
                receiptData.cashierName
            )
            .text(
                "Terminal:" +
                " ".repeat(48 - "Terminal:".length -  receiptData.terminalName.length) +
                receiptData.terminalName
            )
            .text("------------------------------------------------") // Divider
            .text(
                "Gate In:" +
                " ".repeat(48 - "Gate In:".length - + new Date(receiptData.entryTime * 1000).toISOString().slice(0, 19).replace("T", " ").length) +
                new Date(receiptData.entryTime * 1000).toISOString().slice(0, 19).replace("T", " ")
            )
            .text(
                "Billing Time:" +
                " ".repeat(48 - "Billing Time:".length - + new Date(receiptData.paymentTime * 1000).toISOString().slice(0, 19).replace("T", " ").length) +
                new Date(receiptData.paymentTime * 1000).toISOString().slice(0, 19).replace("T", " ")
            )
            .text(
                "Parking Time:" +
                " ".repeat(48 - "Parking Time:".length - receiptData.parkingStay.length) +
                receiptData.parkingStay
            )
            .text(
                "Total Sales:" +
                " ".repeat(48 - "Total Sales:".length - receiptData.totalSales.toFixed(2).length) +
                receiptData.totalSales.toFixed(2)
            )
            .text(
                "Vat(12%):" +
                " ".repeat(48 - "Vat(12%):".length - receiptData.vatAmount.toFixed(2).length) +
                receiptData.vatAmount.toFixed(2)
            )
            .text(
                "Total Amount Due:" +
                " ".repeat(48 - "Total Amount Due: ".length - receiptData.totalAmountDue.toFixed(2).length) +
                receiptData.totalAmountDue.toFixed(2)
            )
            .text("------------------------------------------------") // Divider
            .text(
                "Cash Received:" +
                " ".repeat(51 - "Total Amount Due: ".length - receiptData.cashReceived.length) +
                receiptData.cashReceived
            )
            .text(
                "Cash Change:" +
                " ".repeat(48 - "Cash Change:".length - receiptData.changeDue.length) +
                receiptData.changeDue
            )
            .text("------------------------------------------------") // Divider
            .text(
                "Vatable Sales:" +
                " ".repeat(48 - "Vatable Sales:".length - receiptData.vatableSales.toFixed(2).length) +
                receiptData.vatableSales.toFixed(2)
            )
            .text(
                "Non-Vat Sales:" +
                " ".repeat(48 - "Non-Vat Sales:".length - receiptData.nonVat.toFixed(2).length) +
                receiptData.nonVat.toFixed(2)
            )
            .text(
                "Vat-Exempt:" +
                " ".repeat(48 - "Vat-Exempt:".length - receiptData.vatExempt.toFixed(2).length) +
                receiptData.vatExempt.toFixed(2)
            )
            .text(
                "Zero-Rated Sales:" +
                " ".repeat(48 - "Zero-Rated Sales:".length - receiptData.zeroRated.toFixed(2).length) +
                receiptData.zeroRated.toFixed(2)
            )
            .text(
                "Discount:" +
                " ".repeat(48 - "Discount:".length -  receiptData.discount.toFixed(2).length) +
                receiptData.discount.toFixed(2)
            )
            .text(
                "Discount Type:" +
                " ".repeat(48 - "Discount Type:".length - receiptData.discountType.length) +
                receiptData.discountType
            )
            .text(
                "Paymode:" +
                " ".repeat(48 - "Paymode:".length - receiptData.paymentMode.length) +
                receiptData.paymentMode
            )
            .text(
                "Name:" +
                " ".repeat(48 - "Name:".length - "_____________________________".length) +
                "_____________________________"
            )
            .text(
                "Address:" +
                " ".repeat(45 - "Name:".length - "_____________________________".length) +
                "_____________________________"
            )
            .text(
                "TIN:" +
                " ".repeat(48 - "Name:".length - "_____________________________".length) +
                "_____________________________"
            )
            .text(
                "ID Number:" +
                " ".repeat(42 - "Name:".length - "_____________________________".length) +
                "_____________________________"
            )   
            .feed(1)
            .text("BIR PTU NO: ABC1334567-12345678")
            .text("PTU DATE ISSUED: 11/25/2020")
            .text("THIS SERVES AS YOUR SALES INVOICE")
            .feed(2)
            .cut()
            .generateUInt8Array();
          var cpj = new JSPM.ClientPrintJob();

          var myPrinter = new JSPM.InstalledPrinter($("#printerName").val());
          cpj.clientPrinter = myPrinter;

          cpj.binaryPrinterCommands = escposCommands;

          cpj.sendToClient();
        }
      }

      // Set default DOB to 10 years ago from today
        const childDobInput = document.getElementById('child_dob');
        const today = new Date();
        const defaultDob = new Date(today.getFullYear() - 10, today.getMonth(), today.getDate())
            .toISOString()
            .split('T')[0]; // Format as YYYY-MM-DD
        childDobInput.value = defaultDob;
    </script>
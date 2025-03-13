<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage X Reading Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content-center">
        <div class="custom-card">
            <div class="card-header">
                <h3 class="card-title">Z READING REPORT</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="xReadingTable">
                        <!-- Begin SI -->
                        <tr>
                            <th>Beg. SI #</th>
                            <td><?php echo "00-". $xreading['beginOrNumber'] ?></td>
                        </tr>
                        <!-- End SI -->
                        <tr>
                            <th>End. SI #</th>
                            <td><?php echo "00-" . $xreading['endOrNumber'] ?></td>
                        </tr>
                        <tr>
                            <th>Beg. VOID #</th>
                            <td><?php echo "00-" . str_pad($xreading['beginVoidOr'], 6, '0', STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <th>End. VOID #</th>
                            <td><?php echo "00-" . str_pad($xreading['endVoidOr'], 6, '0', STR_PAD_LEFT); ?></td>
                        </tr>

                        <tr>
                            <th>Beg. RETURN #</th>
                            <td><?php echo "00-" . str_pad($xreading['beginReturnOr'], 6, '0', STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <th>End. RETURN #</th>
                            <td><?php echo "00-" . str_pad($xreading['endReturnOr'], 6, '0', STR_PAD_LEFT); ?></td>
                        </tr>
                        <tr>
                            <th>Reset Counter No</th>
                            <td><?php echo "00"?></td>
                        </tr>
                        <tr>
                            <th>Z Counter No</th>
                            <td><?php echo "01"?></td>
                        </tr>
                        <tr>
                            <th>Present Accumulated Sales</th>
                            <td><?php echo number_format($xreading['presentAccumulatedSales'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Previous Accumulated Sales</th>
                            <td><?php echo number_format($xreading['previousAccumulatedSales'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Sales for the Day</th>
                            <td><?php echo number_format($xreading['dailySales'], 2) ?></td>
                        </tr>
                        <!-- Payments Received Section -->
                        <tr class="table-info">
                            <th colspan="2" class="text-center">BREAKDOWN OF SALES</th>
                        </tr>
                        <tr>
                            <th>Vatable Sales</th>
                            <td><?php echo number_format($xreading['vatableSales'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Vat Amount</th>
                            <td><?php echo number_format($xreading['vatAmount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Vat-Exempt Sales</th>
                            <td><?php echo number_format($xreading['vatExempt'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Zero-Rated Sales</th>
                            <td><?php echo number_format($xreading['zeroRated'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Gross Amount</th>
                            <td><?php echo number_format($xreading['grossAmount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less Discount</th>
                            <td><?php echo number_format($xreading['lessDiscount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less Return</th>
                            <td><?php echo number_format($xreading['lessReturn'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less Void</th>
                            <td><?php echo number_format($xreading['lessVoid'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less VAT Adjustment</th>
                            <td><?php echo number_format($xreading['lessVatAdjustment'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Net Amount</th>
                            <td><?php echo number_format($xreading['netAmount'], 2) ?></td>
                        </tr>
                        <tr class="table-info">
                            <th colspan="2" class="text-center">DISCOUNT SUMMARY</th>
                        </tr>
                        <tr>
                            <th>SC Disc.</th>
                            <td><?php echo number_format($xreading['seniorDiscount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>PWD Disc.</th>
                            <td><?php echo number_format($xreading['pwdDiscount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>NAAC Disc.</th>
                            <td><?php echo number_format($xreading['naacDiscount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Solo Parent Disc.</th>
                            <td><?php echo number_format($xreading['soloparentDiscount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Other Disc.</th>
                            <td><?php echo number_format($xreading['otherDiscount'], 2) ?></td>
                        </tr>
                        <tr class="table-info">
                            <th colspan="2" class="text-center">SALES ADJUSTMENT</th>
                        </tr>
                        <tr>
                            <th>VOID</th>
                            <td><?php echo number_format($xreading['voidAmount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>RETURN</th>
                            <td><?php echo number_format($xreading['refundAmount'], 2) ?></td>
                        </tr>
                        <tr class="table-info">
                            <th colspan="2" class="text-center">VAT ADJUSTMENT</th>
                        </tr>
                        <tr>
                            <th>SC TRANS.</th>
                            <td><?php echo number_format($xreading['seniorTransactions'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>PWD TRANS.</th>
                            <td><?php echo number_format($xreading['pwdTransactions'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>REG. Disc. TRANS.</th>
                            <td><?php echo number_format($xreading['regularDiscTransactions'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>ZERO-RATED TRANS.</th>
                            <td><?php echo number_format($xreading['zeroRated'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>VAT on Return.</th>
                            <td><?php echo number_format($xreading['vatOnReturn'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Other VAT Adjustment.</th>
                            <td><?php echo number_format($xreading['otherVatAdjustment'], 2) ?></td>
                        </tr>

                        <!-- Transaction Summary Section -->
                        <tr class="table-info">
                            <th colspan="2" class="text-center">TRANSACTION SUMMARY</th>
                        </tr>
                        <tr>
                            <th>Cash In Drawer</th>
                            <td><?php echo number_format($xreading['cashInDrawer'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>GCash</th>
                            <td><?php echo number_format($xreading['gcashPayments'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Paymaya</th>
                            <td><?php echo number_format($xreading['paymayaPayments'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Opening Fund</th>
                            <td><?php echo number_format($xreading['openingFund'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less Withdrawal</th>
                            <td><?php echo number_format($xreading['lessWithdrawal'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Payments Received</th>
                            <td><?php echo number_format($xreading['totalPaymentsReceived'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Short / Over</th>
                            <td><?php echo number_format($xreading['shortOver'], 2) ?></td>
                        </tr>
                    </table>
                </div>
                <!-- Only Button to Print X Reading -->
                <div class="printer-selection">
                <div class="printer-dropdown">
                    <label for="printerName">Select an installed Printer:</label>
                    <select name="printerName" id="printerName"></select>
                </div>
                <a href="<?php echo base_url("touchpoint/zreport"); ?>" class="btn btn-danger mt-3">Back</a>
                <button class="btn btn-secondary mt-3" onclick="doPrinting();">Print Z Reading</button>
            </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

    <!--IMPORTANT: BE SURE YOU HONOR THIS JS LOAD ORDER-->
    <script src="https://jsprintmanager.azurewebsites.net/scripts/cptable.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/cputils.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/JSESCPOSBuilder.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/JSPrintManager.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/zip.js"></script>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/zip-ext.js"></script>
<style>
    /* Centering content */
    .content-center {
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: calc(100vh - 200px); */
    }

    /* Custom card styling */
    .custom-card {
        width: 100%;
        max-width: 700px; /* Reduced width */
        padding: 15px; /* Reduced padding */
        border-radius: 8px; /* Slightly reduced border radius */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Softer shadow */
        background-color: #fff;
        height: 100%; /* Allow card to stretch */
    }

    /* Card header styling */
    .custom-card .card-header {
        background-color: #6e8efb;
        padding: 8px 16px; /* Reduced padding */
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        text-align: center;
    }

    .custom-card .card-title {
        color: #fff;
        font-size: 1.2rem; /* Smaller font size */
        font-weight: bold;
    }

    /* Table styling */
    .table {
        width: 100%;
        font-size: 0.9rem; /* Smaller font size */
        border-collapse: collapse;
    }
    printer-selection {
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



    .table th, .table td {
        padding: 8px; /* Reduced padding */
        text-align: left;
        border: 1px solid #ddd;
        font-size: 1.546rem
    }

    .table th {
        background-color: #f8f9fa;
    }

    .table-info th {
        background-color: #e9f7fe;
        text-align: center;
        font-weight: bold;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;  /* Add vertical scrolling */
    }

    /* Button styling */
    .btn-secondary {
        background-color: #6e8efb;
        border-color: #6e8efb;
        color: white;
        border-radius: 5px;
        padding: 8px 20px;
        font-size: 1rem;
    }

    .btn-secondary:hover {
        background-color: #4a7bcf;
        border-color: #4a7bcf;
    }
</style>
    <script src="https://jsprintmanager.azurewebsites.net/scripts/deflate.js"></script>

    <script>
     var xreadingData = <?php echo $this->data['xreadingData']; ?>;
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
            .text("Z READING REPORT")
            
            .feed(1)
            .text(
                "Report Date" +
                " ".repeat(48 - "Report Date".length - xreadingData.reportDate.length) +
                xreadingData.reportDate
            )
            .text(
                "Report Time" +
                " ".repeat(48 - "Report Time".length - xreadingData.reportTime.length) +
                xreadingData.reportTime
            )
            .feed(1)
            .text(
                "Start Date & Time: " +
                " ".repeat(47 - "Start Date & Time:".length - xreadingData.startDateandTime.length) +
                xreadingData.startDateandTime
            )
            .text(
                "End Date & Time: " +
                " ".repeat(47 - "End Date & Time:".length - xreadingData.endDateandTime.length) +
                xreadingData.endDateandTime
            )
            .feed(1)
            .text(
                "Cashier:" +
                " ".repeat(48 - "Cashier:".length - xreadingData.cashierName.length) +
                xreadingData.cashierName
            )
            .feed(1)
            // .align(escpos.TextAlignment.Start)
            .text(
                "Beg. SI #:" +
                " ".repeat(48 - "Beg. SI #:".length - ("00-" + xreadingData.beginOrNumber).length) +
                "00-" + xreadingData.beginOrNumber
            )
            .text(
                "End. SI #:" +
                " ".repeat(48 - "End. SI #:".length - ("00-" + xreadingData.endOrNumber).length) +
                "00-" + xreadingData.endOrNumber
            )
            .text(
                "Beg. VOID #:" +
                " ".repeat(46 - "Beg. SI #:".length - ("00-" + xreadingData.beginVoidOr).length) +
                "00-" + xreadingData.beginVoidOr
            )
            .text(
                "End. VOID #:" +
                " ".repeat(46 - "End. SI #:".length - ("00-" + xreadingData.endVoidOr).length) +
                "00-" + xreadingData.endVoidOr
            )
            .text(
                "Beg. RETURN #:" +
                " ".repeat(44 - "Beg. SI #:".length - ("00-" + xreadingData.beginReturnOr).length) +
                "00-" + xreadingData.beginReturnOr
            )
            .text(
                "End. RETURN #:" +
                " ".repeat(44 - "End. SI #:".length - ("00-" + xreadingData.endReturnOr).length) +
                "00-" + xreadingData.endReturnOr
            )
            .feed(1)
            .text(
                "Resent Counter:" +
                " ".repeat(48 - "Opening Fund:".length - "00".length) +
                "00"
            )
            .text(
                "Resent Counter:" +
                " ".repeat(48 - "Opening Fund:".length - "00".length) +
                "00"
            )

            .text("================================================") // Divider
            // Set the alignment to Left for the "PAYMENTS RECEIVED" text
            .align(escpos.TextAlignment.Left)
            .text("PAYMENTS RECEIVED")
            .text(
                "Cash:" +
                " ".repeat(48 - "Cash:".length - parseFloat(xreadingData.cashPayments).toFixed(2).length) +
                parseFloat(xreadingData.cashPayments).toFixed(2)
            )
            .text(
                "GCASH:" +
                " ".repeat(48 - "GCash:".length - parseFloat(xreadingData.gcashPayments).toFixed(2).length) +
                parseFloat(xreadingData.gcashPayments).toFixed(2)
            )
            .text(
                "Paymaya:" +
                " ".repeat(48 - "Paymaya:".length - parseFloat(xreadingData.paymayaPayments).toFixed(2).length) +
                parseFloat(xreadingData.paymayaPayments).toFixed(2)
            )
            .text(
                "Total Payments Received:" +
                " ".repeat(48 - "Total Payments Received:".length - parseFloat(xreadingData.totalPaymentsReceived).toFixed(2).length) +
                parseFloat(xreadingData.totalPaymentsReceived).toFixed(2)
            )
            .text("================================================") // Divider
            .text(
                "VOID:" +
                " ".repeat(48 - "VOID:".length - parseFloat(xreadingData.voidAmount).toFixed(2).length) +
                parseFloat(xreadingData.voidAmount).toFixed(2)
            )            
            .text(
                "REFUND:" +
                " ".repeat(48 - "REFUND:".length - parseFloat(xreadingData.refundAmount).toFixed(2).length) +
                parseFloat(xreadingData.refundAmount).toFixed(2)
            )
            .text("================================================") // Divider
            .text(
                "WITHDRAWALS:" +
                " ".repeat(48 - "WITHDRAWALS:".length - parseFloat(xreadingData.totalWithdrawals).toFixed(2).length) +
                parseFloat(xreadingData.totalWithdrawals).toFixed(2)
            )
            .text("================================================") // Divider
            .align(escpos.TextAlignment.Left)
            .text("TRANSACTION SUMMARY")
            .text(
                "Cash In Drawer:" +
                " ".repeat(48 - "Cash In Drawer::".length - parseFloat(xreadingData.cashInDrawer).toFixed(2).length) +
                parseFloat(xreadingData.cashInDrawer).toFixed(2)
            )
            .text(
                "GCASH:" +
                " ".repeat(48 - "GCash:".length - parseFloat(xreadingData.gcashPayments).toFixed(2).length) +
                parseFloat(xreadingData.gcashPayments).toFixed(2)
            )
            .text(
                "Paymaya:" +
                " ".repeat(48 - "Paymaya:".length - parseFloat(xreadingData.paymayaPayments).toFixed(2).length) +
                parseFloat(xreadingData.paymayaPayments).toFixed(2)
            )
            .text(
                "Opening Fund:" +
                " ".repeat(48 - "Opening Fund:".length - xreadingData.openingFund.length) +
                xreadingData.openingFund
            )
            .text(
                "Less Withdrawal:" +
                " ".repeat(48 - "Less Withdrawal:".length - xreadingData.lessWithdrawal.length) +
                xreadingData.lessWithdrawal
            )
            .text(
                "Payments Received:" +
                " ".repeat(48 - "Payments Received:".length - parseFloat(xreadingData.totalPaymentsReceived).toFixed(2).length) +
                parseFloat(xreadingData.totalPaymentsReceived).toFixed(2)
            )
            .text("================================================") // Divider
            .text(
                "SHORT/OVER:" +
                " ".repeat(48 - "SHORT/OVER:".length - parseFloat(xreadingData.shortOver).toFixed(2).length) +
                parseFloat(xreadingData.shortOver).toFixed(2)
            )
            .feed(2)
            .cut()
            .generateUInt8Array();
            var cpj = new JSPM.ClientPrintJob();

            var myPrinter = new JSPM.InstalledPrinter($("#printerName").val());
            cpj.clientPrinter = myPrinter;

            cpj.binaryPrinterCommands = escposCommands;

            cpj.sendToClient();
        }
      // Do printing...
    }

    </script>
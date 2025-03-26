<section class="content-wrapper">
  <section class="content-header">
    <h1>Touchpoint v1.0
      <small>Manage Billing</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">
        <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
      </li>
    </ol>
  </section>
  <div class="content">
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Payment Successful</h3>
      </div>
      <div class="box-body">
        <p class="text-success">
          <i class="fa fa-check-circle"></i> Payment has been successfully processed using
          <strong><?php echo $receipt['paymentMode']; ?></strong>.
        </p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sales Invoice</th>
              <th>Parking Code</th>
              <th>Vehicle Type</th>
              <th>In Time</th>
              <th>Total Hours</th>
              <th>Amount Paid</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $receipt['salesInvoice'] ?></td>
              <td><?php echo $receipt['parkingCode'] ?></td>
              <td>
                <?php
                $vehicleId = $receipt['vehicleClass'];

                if ($vehicleId == 1) {
                  echo "Motorcycle";
                } else if ($vehicleId == 2) {
                  echo "Car";
                } else if ($vehicleId == 3) {
                  echo "BUS/Truck";
                } else {
                  echo "Unknown";
                }
                ?>
              </td>
              <td><?php echo date('Y-m-d H:i:s A', $receipt['entryTime']) ?></td>
              <td><?php echo $receipt['parkingStay'] ?></td>
              <td>&#8369; <?php echo number_format($receipt['totalAmountDue'], 2) ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="box-footer">

        <div style="text-align: center">
          <!-- <h1>Advanced ESC/POS Printing from Javascript</h1> -->
          <!-- <hr /> -->
          <!-- <label class="checkbox">
            <input type="checkbox" id="useDefaultPrinter" />
            <strong>Print to Default printer</strong>
          </label>
          <p>or...</p> -->
          <!-- <div id="installedPrinters">
            <label for="printerName">Select an installed Printer:</label><br>
            <select name="printerName" class="" id="printerName"></select>
          </div> -->
          <div id="installedPrinters" class="d-flex justify-content-center">
            <div class="text-center">
              <label class="font-weight-bold" for="printerName">Select an installed Printer:</label>
              <select name="printerName" id="printerName" class="form-control" style="width: 250px; margin: 0 auto;">
              </select>
            </div>
          </div>
          <br />
          <button type="button" onclick="doPrinting();" class="btn btn-primary">Print Now</button>
        </div>
        <!-- <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button> -->
        <a href="<?php echo base_url('touchpoint'); ?>" class="btn btn-success">Back to Dashboard</a>
      </div>
    </div>
  </div>
</section>

<style>
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

      // Generate ESC/POS commands with the new header
      var escposCommands = doc
        .font(escpos.FontFamily.A)
        .align(escpos.TextAlignment.Center)
        .style([escpos.FontStyle.Bold])
        .size(1, 1) // Larger size for "PICC"
        .text("PICC")
        .feed(1)
        .font(escpos.FontFamily.A)
        .size(0, 0) // Standard size for the rest
        .text(receiptData.companyName)
        .text("PICC Complex 1307, Pasay City,")
        .text("Metro Manila, Philippines")
        .text("VAT REG TIN: " + receiptData.companyTin)
        .text("MIN: " + receiptData.companyMin)
        .text("SN: " + receiptData.ptuSN)
        .text("Telephone: " + receiptData.companyTelephone)
        .feed(1)
        // Additional details before the gate pass title
        .text("Date and Time: " + new Date(receiptData.paymentTime * 1000).toLocaleDateString('en-CA') + " " + new Date(receiptData.paymentTime * 1000).toLocaleTimeString())
        .text(receiptData.accessType + ": " + receiptData.parkingCode)
        .text("Vehicle: " + vehicleType)
        .feed(1)
        // Complimentary Gate Pass title
        .text("COMPLIMENTARY GATE PASS")
        .feed(1)
        // Details at the bottom of the pass
        .text("BIR PTU NO: " + receiptData.ptuSerialNo)
        .text("PTU DATE ISSUED: " + receiptData.ptuIssuedDate)
        .text("THIS SERVES AS YOUR SALES INVOICE")
        .feed(2)
        .cut()
        .generateUInt8Array();
     

      // Create ClientPrintJob
      var cpj = new JSPM.ClientPrintJob();

      // Set Printer info
      var myPrinter = new JSPM.InstalledPrinter($("#printerName").val());
      cpj.clientPrinter = myPrinter;

      // Set the ESC/POS commands
      cpj.binaryPrinterCommands = escposCommands;

      // Send print job to printer!
      cpj.sendToClient();
    }
  }
</script>
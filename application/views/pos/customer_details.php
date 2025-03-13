<script>
    function logReceipt() {
        console.log("\n================= RECEIPT LOG =================");
        console.log("PICC");
        console.log("Philippine International Convention Center");
        console.log("PICC Complex 1307, Pasay City,");
        console.log("Metro Manila, Philippines");
        console.log("VAT REG TIN: 001-114-766-000");
        console.log("MIN: MCH-001234");
        console.log("SN: SN681DEF312963");
        console.log("\nTRAINING MODE");

        console.log("\nDate and Time:", new Date(receiptData.paymentTime * 1000).toLocaleDateString('en-CA'),
            new Date(receiptData.paymentTime * 1000).toLocaleTimeString());
        console.log("S/I #: 00-" + receiptData.salesInvoice);
        console.log(receiptData.accessType + ": " + receiptData.parkingCode);
        console.log("Vehicle: " + vehicleType);

        console.log("\nSales Invoice");
        console.log("------------------------------------------------");
        console.log("Cashier:", receiptData.cashierName);
        console.log("Terminal:", receiptData.terminalName);

        console.log("------------------------------------------------");
        console.log("Gate In:", new Date(receiptData.entryTime * 1000).toLocaleDateString('en-CA') + " " +
            new Date(receiptData.entryTime * 1000).toLocaleTimeString('en-US', { hour12: false }));
        console.log("Billing Time:", new Date(receiptData.paymentTime * 1000).toLocaleDateString('en-CA') + " " +
            new Date(receiptData.paymentTime * 1000).toLocaleTimeString());
        console.log("Parking Stay:", `${receiptData.parkingStay.split(":")[0]}hrs:${receiptData.parkingStay.split(":")[1]}min`);

        console.log("Total Sales (w/VAT):", parseFloat(receiptData.origAmount).toFixed(2));
        console.log("Less VAT(12%): " + parseFloat(receiptData.lessVat).toFixed(2));
        // console.log("Less " + receiptData.discountDisplay + " Disc (" + receiptData.discPercent + "): " + 
        //             parseFloat(receiptData.discount).toFixed(2));
        // console.log("Total Amount Due:", parseFloat(receiptData.totalAmountDueForDC).toFixed(2));
        if (receiptData.discountDisplay == "NAAC") {
            console.log("Net of VAT:", parseFloat(receiptData.netofVat).toFixed(2));
            // console.log("Total Amount Due:", parseFloat(receiptData.totalAmountDueForDC).toFixed(2));
        } else {
            console.log("Net of VAT:(VAT EXEMPT)", parseFloat(receiptData.vatableSales).toFixed(2));
        }

        console.log("Less " + receiptData.discountDisplay + " Disc (" + receiptData.discPercent + "): " + parseFloat(receiptData.discount).toFixed(2));
        console.log("Net of Disc:", parseFloat(receiptData.netofdisc).toFixed(2));
        if (receiptData.discountDisplay == "NAAC") {
            console.log("Add 12% VAT:", parseFloat(receiptData.addNVat).toFixed(2)); 
        } else {
            console.log("Add 12% VAT:", parseFloat(receiptData.zeroRated).toFixed(2));
        }
        console.log("Total Amount Due:", parseFloat(receiptData.totalAmountDueForDC).toFixed(2));
        console.log("------------------------------------------------");
        console.log("Cash Received:", receiptData.cashReceived);
        console.log("Cash Change:", receiptData.changeDue);

        console.log("------------------------------------------------");
        console.log("Vatable Sales:", parseFloat(receiptData.vatableSales).toFixed(2));
        console.log("VAT Amount:", parseFloat(receiptData.vatAmount).toFixed(2));
        // console.log("VAT-Exempt Sales:", parseFloat(receiptData.vatExempt).toFixed(2));
        console.log("VAT-Exempt Sales:", parseFloat(receiptData.vatExempt).toFixed(2));
        console.log("Zero-Rated Sales:", receiptData.zeroRated.toFixed(2));

        console.log("\nPaymode:", receiptData.paymentMode);
        console.log("Name: _____________________________");
        console.log("Address: _____________________________");
        console.log("TIN: _____________________________");
        console.log("ID Number: _____________________________");

        console.log("\nBIR PTU NO: ABC1334567-12345678");
        console.log("PTU DATE ISSUED: 11/25/2020");
        console.log("THIS SERVES AS YOUR SALES INVOICE");
        console.log("=============================================");
    }
    logReceipt();
</script>
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
                        <span><?php date_default_timezone_set("Asia/Manila");
                        echo date('Y-m-d H:i:s A', $receipt['entryTime']); ?></span>
                    </div>
                    <div class="detail-row">
                        <strong>Billing Time:</strong>
                        <span><?php date_default_timezone_set("Asia/Manila");
                        echo date('Y-m-d H:i:s A', $receipt['paymentTime']); ?></span>
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
                    <strong>Amount Discounted:</strong>
                    <span><?php echo number_format($receipt['discount'], 2); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Discount Type:</strong>
                    <span><?php echo $receipt['discountDisplay']; ?></span>
                </div>
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
                        <input type="hidden" id="transact_id" name="transact_id"
                            value="<?php echo $receipt['transactionId']; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="discount_type" name="discount_type"
                            value="<?php echo $receipt['discountType']; ?>" required>
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
                        <input type="date" class="form-control" id="child_dob" name="child_dob">

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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        logReceipt();
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
                .text(receiptData.companyName)
                .text("PICC Complex 1307, Pasay City,")
                .text("Metro Manila, Philippines")
                .text("VAT REG TIN: "+ receiptData.companyTin)
                .text("MIN: "+ receiptData.companyMin)
                .text("SN: "+ receiptData.ptuSN)
                .text("Telephone: "+ receiptData.companyTelephone)
                // .feed(1)
                // .text("TRAINING MODE")
                .feed(1)
                // Additional details
                .text("Date and Time: " + new Date(receiptData.paymentTime * 1000).toLocaleDateString('en-CA') + " " + new Date(receiptData.paymentTime * 1000).toLocaleTimeString())
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
                    " ".repeat(48 - "Terminal:".length - receiptData.terminalName.length) +
                    receiptData.terminalName
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Gate In:" +
                    " ".repeat(48 - "Gate In:".length - + new Date(receiptData.entryTime * 1000).toLocaleDateString('en-CA').length - new Date(receiptData.entryTime * 1000).toLocaleTimeString('en-US', { hour12: false }).length - 1) +
                    new Date(receiptData.entryTime * 1000).toLocaleDateString('en-CA') + " " + new Date(receiptData.entryTime * 1000).toLocaleTimeString('en-US', { hour12: false })
                )
                .text(
                    "Billing Time:" +
                    " ".repeat(48 - "Billing Time:".length - + new Date(receiptData.paymentTime * 1000).toISOString().slice(0, 19).replace("T", " ").length) +
                    new Date(receiptData.paymentTime * 1000).toLocaleDateString('en-CA') + " " + new Date(receiptData.paymentTime * 1000).toLocaleTimeString('en-US', { hour12: false })
                )
                .text(
                    "Parking Stay:" +
                    " ".repeat(48 - "Parking Stay:".length -
                        (`${receiptData.parkingStay.split(":")[0]}hrs:${receiptData.parkingStay.split(":")[1]}min`.length)) +
                    `${receiptData.parkingStay.split(":")[0]}hrs:${receiptData.parkingStay.split(":")[1]}min`
                )
                .text(
                    "Total Sales (w/VAT):" +
                    " ".repeat(48 - "Total Sales (w/VAT):".length - parseFloat(receiptData.origAmount).toFixed(2).length) +
                    parseFloat(receiptData.origAmount).toFixed(2)
                )
                .text(
                    "Less VAT(12%):" +
                    " ".repeat(48 - "Less VAT(12%):".length - parseFloat(receiptData.lessVat).toFixed(2).length) +
                    parseFloat(receiptData.lessVat).toFixed(2)
                )
                .text(
                    "Net of VAT:" +
                    " ".repeat(48 - "Net of VAT:".length - (receiptData.vatExempt == 0 ? parseFloat(receiptData.netofVat).toFixed(2).length : parseFloat(receiptData.vatExempt).toFixed(2).length)) +
                    (receiptData.vatExempt == 0 ? parseFloat(receiptData.netofVat).toFixed(2) : parseFloat(receiptData.vatExempt).toFixed(2))
                )
                .text(
                    "Less " + receiptData.discountDisplay + " Disc (" + receiptData.discPercent + "):" +
                    " ".repeat(48 - ("Less " + receiptData.discountDisplay + " Disc (" + receiptData.discPercent + "):").length - parseFloat(receiptData.discount).toFixed(2).length) +
                    parseFloat(receiptData.discount).toFixed(2)
                )
                .text(
                    "Net of Disc:" +
                    " ".repeat(48 - "Net of Disc:".length - parseFloat(receiptData.netofdisc).toFixed(2).length) +
                    parseFloat(receiptData.netofdisc).toFixed(2)
                )
                .text(receiptData.vatExempt == 0 ?
                    "Add 12% VAT:" +
                    " ".repeat(48 - "Add 12% VAT:".length - parseFloat(receiptData.addNVat).toFixed(2).length) +
                    parseFloat(receiptData.addNVat).toFixed(2) : "Add 12% VAT:" +
                    " ".repeat(48 - "Add 12% VAT:".length - parseFloat(receiptData.zeroRated).toFixed(2).length) +
                    parseFloat(receiptData.zeroRated).toFixed(2)
                )
                .text(
                    "Total Amount Due:" +
                    " ".repeat(48 - "Total Amount Due:".length - parseFloat(receiptData.totalAmountDueForDC).toFixed(2).length) +
                    parseFloat(receiptData.totalAmountDueForDC).toFixed(2)
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Cash Received:" +
                    " ".repeat(48 - "Cash Received:".length - parseFloat(receiptData.cashReceived).toFixed(2).length) +
                    parseFloat(receiptData.cashReceived).toFixed(2)
                )
                .text(
                    "Cash Change:" +
                    " ".repeat(48 - "Cash Change:".length - parseFloat(receiptData.changeDue).toFixed(2).length) +
                    parseFloat(receiptData.changeDue).toFixed(2)
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Vatable Sales:" +
                    " ".repeat(48 - "Vatable Sales:".length - parseFloat(receiptData.vatableSales).toFixed(2).length) +
                    parseFloat(receiptData.vatableSales).toFixed(2)
                )
                .text(
                    "VAT Amount:" +
                    " ".repeat(48 - "VAT Amount:".length - parseFloat(receiptData.vatAmount).toFixed(2).length) +
                    parseFloat(receiptData.vatAmount).toFixed(2)
                )
                .text(
                    "VAT-Exempt Sales:" +
                    " ".repeat(48 - "VAT-Exempt Sales:".length - parseFloat(receiptData.vatExempt).toFixed(2).length) +
                    parseFloat(receiptData.vatExempt).toFixed(2)
                )
                .text(
                    "Zero-Rated Sales:" +
                    " ".repeat(48 - "Zero-Rated Sales:".length - receiptData.zeroRated.toFixed(2).length) +
                    receiptData.zeroRated.toFixed(2)
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
                    " ".repeat(48 - "Address:".length - "_____________________________".length) +
                    "_____________________________"
                )
                .text(
                    "TIN:" +
                    " ".repeat(48 - "TIN:".length - "_____________________________".length) +
                    "_____________________________"
                )
                .text(
                    "ID Number:" +
                    " ".repeat(48 - "ID Number:".length - "_____________________________".length) +
                    "_____________________________"
                )
                .feed(1)
                .text("BIR PTU NO: "+ receiptData.ptuSerialNo)
                .text("PTU DATE ISSUED: "+ receiptData.ptuIssuedDate)
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
<?php
date_default_timezone_set("Asia/Manila");
?>
<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Reprint Receipt</small>
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
                <h3 class="card-title">REPRINT RECEIPT</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="xReadingTable">
                        <!-- Begin SI -->
                        <tr>
                            <th>Company</th>
                            <td><?php echo htmlspecialchars($company['company']) ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo htmlspecialchars($company['address']) ?></td>
                        </tr>
                        <tr>
                            <th>TIN</th>
                            <td><?php echo htmlspecialchars($company['tin']) ?></td>
                        </tr>
                        <tr>
                            <th>MIN</th>
                            <td><?php echo htmlspecialchars($receipt['min']) ?></td>
                        </tr>
                        <tr>
                            <th>SN</th>
                            <td><?php echo htmlspecialchars($receipt['sn']) ?></td>
                        </tr>
                        <tr>
                            <th>Telephone</th>
                            <td><?php echo htmlspecialchars($company['telephone']) ?></td>
                        </tr>
                        <tr>
                            <th>Date and Time</th>
                            <td><?php echo date('Y-m-d h:i:s A', (int) $receipt['paid_time']); ?></td>
                        </tr>
                        <tr>
                            <th>Sales Invoice Number</th>
                            <td><?php echo "00-" . $receipt['ornumber'] ?></td>
                        </tr>
                        <tr>
                            <th>Plate</th>
                            <td><?php echo $receipt['parking_code'] ?></td>
                        </tr>
                        <tr>
                            <th>Vehicle</th>
                            <td>
                                <?php
                                if ($receipt['vehicle_cat_id'] == 1) {
                                    echo "Motorcycle";
                                } elseif ($receipt['vehicle_cat_id'] == 2) {
                                    echo "Car";
                                } elseif ($receipt['vehicle_cat_id'] == 3) {
                                    echo "Bus/Truck";
                                } else {
                                    echo "Unknown";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Cashier</th>
                            <td><?php echo $cashier['firstname'] . " " . $cashier['lastname'] ?></td>
                        </tr>
                        <tr>
                            <th>Terminal ID</th>
                            <td><?php echo "TRM00" . $receipt['pid'] ?></td>
                        </tr>
                        <tr>
                            <th>Gate In</th>
                            <td><?php echo date('Y-m-d h:i:s A', (int) $receipt['in_time']); ?></td>
                        </tr>
                        <tr>
                            <th>Billing Time</th>
                            <td><?php echo date('Y-m-d h:i:s A', (int) $receipt['paid_time']); ?></td>
                        </tr>
                        <tr>
                            <th>Parking Time</th>
                            <td>
                                <?php
                                $total_time = explode(':', $receipt['total_time']);
                                echo $total_time[0] . ' hrs ' . $total_time[1] . ' mins';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Sales (w/VAT)</th>
                            <td><?php echo number_format($receipt['amount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less VAT (12%)</th>
                            <td><?php echo number_format($receipt['less_vat'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Net of VAT</th>
                            <td><?php echo number_format($receipt['net_of_vat'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Less <span class="text-uppercase"><?php echo $receipt['discount_type'] ?></span>
                                Discount</th>
                            <td><?php echo number_format($receipt['discount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Net of Discount</th>
                            <td><?php echo number_format($receipt['net_of_disc'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Add 12% VAT</th>
                            <td><?php echo number_format($receipt['add_nvat'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Total Amount Due</th>
                            <td><?php echo number_format($receipt['earned_amount'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Cash Received</th>
                            <td><?php echo number_format($receipt['cash_received'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Cash Change</th>
                            <td><?php echo number_format($receipt['change'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Vatable Sales</th>
                            <td>
                                <?php
                                $vatable_sales = str_replace(',', '', $receipt['vatable_sales']); // Remove commas
                                echo number_format((float) $vatable_sales, 2); // Convert to float and format
                                ?>
                            </td>
                        <tr>
                            <th>VAT Amount</th>
                            <td><?php echo number_format($receipt['vat'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>VAT-Exempt Sales</th>
                            <td><?php echo number_format($receipt['vat_exempt'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Zero-Rated Sales</th>
                            <td><?php echo number_format($receipt['zero_rated'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Paymode</th>
                            <td><?php echo $receipt['paymode']; ?></td>
                        </tr>
                        <tr>
                            <th>BIR PTU Number</th>
                            <td><?php echo $receipt['ptu_num']; ?></td>
                        </tr>
                        <tr>
                            <th>PTU Issued Date</th>
                            <td><?php echo $receipt['ptu_date']; ?></td>
                        </tr>
                    </table>
                </div>
                <!-- Only Button to Print X Reading -->
                <div class="printer-selection text-center">
                    <div class="printer-dropdown">
                        <label for="printerName">Select an installed Printer:</label>
                        <select name="printerName" id="printerName"></select>
                    </div>
                    <a href="<?php echo base_url("touchpoint/reprint"); ?>" class="btn btn-danger mt-3">Back</a>
                    <button class="btn btn-secondary mt-3" onclick="doPrinting();">Reprint Receipt</button>
                    <button class="btn btn-secondary mt-3" data-toggle="modal"
                        data-target="#previewModal">Preview</button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">Preview Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="font-family: monospace; text-align: center;">
                            <!-- Preview content -->
                            <?php echo $company['company']; ?><br>
                            <?php echo $company['address']; ?><br>
                            VAT REG TIN: <?php echo $company['tin']; ?><br>
                            MIN: <?php echo $receipt['min']; ?><br>
                            SN: <?php echo $receipt['sn']; ?><br>
                            Telephone: <?php echo $company['telephone']; ?><br><br>
                            Date and Time: <?php echo date('Y-m-d h:i:s A'); ?><br>
                            S/I #: 00-<?php echo $receipt['ornumber']; ?><br>
                            <?php echo $receipt['access_type'] . ": " . $receipt['parking_code']; ?><br>
                            Vehicle:
                            <?php
                            if ($receipt['vehicle_cat_id'] == 1) {
                                echo "Motorcycle";
                            } elseif ($receipt['vehicle_cat_id'] == 2) {
                                echo "Car";
                            } elseif ($receipt['vehicle_cat_id'] == 3) {
                                echo "Bus/Truck";
                            } else {
                                echo "Unknown";
                            }
                            ?><br><br>
                            Sales Invoice<br><br>
                            ==========================================================================<br>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Cashier:</strong></span>
                                <span
                                    id="cashier"><?php echo $cashier['firstname'] . " " . $cashier['lastname'] ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Terminal:</strong></span>
                                <span id="terminal">TRM00<?php echo $receipt['pid']; ?></span>
                            </div>
                            ==========================================================================
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Gate In:</strong></span>
                                <span id="gatein"><?php echo date('Y-m-d h:i:s A', (int) $receipt['in_time']); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Billing Time:</strong></span>
                                <span
                                    id="bilingtime"><?php echo date('Y-m-d h:i:s A', (int) $receipt['paid_time']); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Parking Time:</strong></span>
                                <span id="parkingtime"><?php
                                $total_time = explode(':', $receipt['total_time']);
                                echo $total_time[0] . ' hrs ' . $total_time[1] . ' mins';
                                ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Total Sales (w/VAT):</strong></span>
                                <span id="totalsales"><?php echo number_format($receipt['amount'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less VAT (12%):</strong></span>
                                <span id="lessvat"><?php echo number_format($receipt['less_vat'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Net of VAT:</strong></span>
                                <span id="netofvat"><?php echo number_format($receipt['net_of_vat'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less <span
                                            class="text-uppercase"><?php echo $receipt['discount_type'] ?></span>
                                        Discount</strong></span>
                                <span id="lessdisc"><?php echo number_format($receipt['discount'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Net of Discount:</strong></span>
                                <span id="netofdisc"><?php echo number_format($receipt['net_of_disc'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Add 12% VAT:</strong></span>
                                <span id="resetCounter2"><?php echo number_format($receipt['add_nvat'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Total Amount Due:</strong></span>
                                <span
                                    id="totalamountdue"><?php echo number_format($receipt['earned_amount'], 2) ?></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Cash Received:</strong></span>
                                <span id="cashreceived"><?php echo number_format($receipt['cash_received'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Cash Change:</strong></span>
                                <span id="cashreceived"><?php echo number_format($receipt['change'], 2) ?></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Vatable Sales:</strong></span>
                                <span id="vatablesales"><?php $vatable_sales = str_replace(',', '', $receipt['vatable_sales']); // Remove commas
                                echo number_format((float) $vatable_sales, 2); // Convert to float and format ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>VAT Amount:</strong></span>
                                <span id="vatamount"><?php echo number_format($receipt['vat'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>VAT-Exempt Sales:</strong></span>
                                <span id="vatexemptsales"><?php echo number_format($receipt['vat_exempt'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Zero-Rated Sales:</strong></span>
                                <span id="zeroratedsales"><?php echo number_format($receipt['zero_rated'], 2) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Paymode:</strong></span>
                                <span id="paymode"><?php echo $receipt['paymode']; ?></span>
                            </div>
                        </div>
                        ======================================================================
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-secondary mt-3" onclick="doPrinting();">Reprint Receipt</button>
                    </div>
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
        max-width: 700px;
        /* Reduced width */
        padding: 15px;
        /* Reduced padding */
        border-radius: 8px;
        /* Slightly reduced border radius */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        /* Softer shadow */
        background-color: #fff;
        height: 100%;
        /* Allow card to stretch */
    }

    /* Card header styling */
    .custom-card .card-header {
        background-color: #6e8efb;
        padding: 8px 16px;
        /* Reduced padding */
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        text-align: center;
    }

    .custom-card .card-title {
        color: #fff;
        font-size: 1.2rem;
        /* Smaller font size */
        font-weight: bold;
    }

    /* Table styling */
    .table {
        width: 100%;
        font-size: 0.9rem;
        /* Smaller font size */
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



    .table th,
    .table td {
        padding: 8px;
        /* Reduced padding */
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
        overflow-y: auto;
        /* Add vertical scrolling */
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
    var data = {
        cashier: <?php echo json_encode($this->data['cashier']); ?>,
        receipt: <?php echo json_encode($this->data['receipt']); ?>,
        company: <?php echo json_encode($this->data['company']); ?>
    };

    var discPercent = 0;
    switch (data.receipt.discount_type) {
        case 'senior':
            discPercent = '20%';
            data.receipt.discount_type = 'Senior Citizen';
            break;
        case 'pwd':
            discPercent = '20%';
            data.receipt.discount_type = 'PWD';
            break;
        case 'naac':
            discPercent = '20%';
            data.receipt.discount_type = 'NAAC';
            break;
        case 'tenant':
            discPercent = '20%';
            data.receipt.discount_type = 'Tenant';
            break;
        case 'sp':
            discPercent = '10%';
            data.receipt.discount_type = 'Solo Parent';
            break;
        case 'none':
            discPercent = '0%';
            data.receipt.discount_type = 'No';
            break;
        default:
            discPercent = '0%';
            break;
    }

    switch (data.receipt.vehicle_cat_id) {
        case '1':
            data.receipt.vehicle_cat_id = 'Motorcycle';
            break;
        case '2':
            data.receipt.vehicle_cat_id = 'Car';
            break;
        case '3':
            data.receipt.vehicle_cat_id = 'Bus/Truck';
            break;
        default:
            data.receipt.vehicle_cat_id = 'Unknown';
            break;
    }

    data.receipt.vatable_sales = data.receipt.vatable_sales.replace(/,/g, '');

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
                .text(data.company.company)
                .text("PICC Complex, 1307 Pasay City")
                .text("Metro Manila, Philippines")
                .text("VAT REG TIN: " + data.company.tin)
                .text("MIN: " + data.receipt.min)
                .text("SN: " + data.receipt.sn)
                .text("Telephone: " + data.company.telephone)
                .feed(1)
                .text("Date and Time: " + new Date().toLocaleDateString('en-CA') + " " + new Date().toLocaleTimeString())
                .text("S/I #: 00-" + data.receipt.ornumber)
                .text(data.receipt.access_type + ": " + data.receipt.parking_code)
                .text("Vehicle: " + data.receipt.vehicle_cat_id)
                .feed(1)
                .style([escpos.FontStyle.Bold])
                .text("Sales Invoice")
                .text('"Reprinted"')
                .feed(1)
                .text("------------------------------------------------") // Divider
                .text(
                    "Cashier:" +
                    " ".repeat(48 - "Cashier:".length - (data.cashier.firstname + " " + data.cashier.lastname).length) +
                    data.cashier.firstname + " " + data.cashier.lastname
                )
                .text(
                    "Terminal:" +
                    " ".repeat(48 - "Terminal:".length - ("TRM00" + data.receipt.pid).length) +
                    "TRM00" + data.receipt.pid
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Gate In:" +
                    " ".repeat(48 - "Gate In:".length - + new Date(data.receipt.in_time * 1000).toLocaleDateString('en-CA').length - new Date(data.receipt.in_time * 1000).toLocaleTimeString('en-US', { hour12: false }).length - 1) +
                    new Date(data.receipt.in_time * 1000).toLocaleDateString('en-CA') + " " + new Date(data.receipt.in_time * 1000).toLocaleTimeString('en-US', { hour12: false })
                )
                .text(
                    "Billing Time:" +
                    " ".repeat(48 - "Billing Time:".length - + new Date(data.receipt.paid_time * 1000).toISOString().slice(0, 19).replace("T", " ").length) +
                    new Date(data.receipt.paid_time * 1000).toLocaleDateString('en-CA') + " " + new Date(data.receipt.paid_time * 1000).toLocaleTimeString('en-US', { hour12: false })
                )
                .text(
                    "Parking Stay:" +
                    " ".repeat(48 - "Parking Stay:".length -
                        (`${data.receipt.total_time.split(":")[0]}hrs:${data.receipt.total_time.split(":")[1]}min`.length)) +
                    `${data.receipt.total_time.split(":")[0]}hrs:${data.receipt.total_time.split(":")[1]}min`
                )
                .text(
                    "Total Sales (w/VAT):" +
                    " ".repeat(48 - "Total Sales (w/VAT):".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.amount).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.amount)
                )
                .text(
                    "Less VAT(12%):" +
                    " ".repeat(48 - "Less VAT(12%):".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.less_vat).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.less_vat)
                )
                .text(
                    "Net of VAT:" +
                    " ".repeat(48 - "Net of VAT:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.net_of_vat).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.net_of_vat)
                )
                .text(
                    "Less " + data.receipt.discount_type + " Disc (" + discPercent + "):" +
                    " ".repeat(48 - ("Less " + data.receipt.discount_type + " Disc (" + discPercent + "):").length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.discount).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.discount)
                )
                .text(
                    "Net of Disc:" +
                    " ".repeat(48 - "Net of Disc:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.net_of_disc).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.net_of_disc)
                )
                .text(
                    "Add 12% VAT:" +
                    " ".repeat(48 - "Add 12% VAT:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.add_nvat).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.add_nvat)
                )
                .text(
                    "Total Amount Due:" +
                    " ".repeat(48 - "Total Amount Due:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.earned_amount).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.earned_amount)
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Cash Received:" +
                    " ".repeat(48 - "Cash Received:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.cash_received).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.cash_received)
                )
                .text(
                    "Cash Change:" +
                    " ".repeat(48 - "Cash Change:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.change).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.change)
                )
                .text("------------------------------------------------") // Divider
                .text(
                    "Vatable Sales:" +
                    " ".repeat(48 - "Vatable Sales:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vatable_sales).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vatable_sales)
                )
                .text(
                    "VAT Amount:" +
                    " ".repeat(48 - "VAT Amount:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vat).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vat)
                )
                .text(
                    "VAT-Exempt Sales:" +
                    " ".repeat(48 - "VAT-Exempt Sales:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vat_exempt).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.vat_exempt)
                )
                .text(
                    "Zero-Rated Sales:" +
                    " ".repeat(48 - "Zero-Rated Sales:".length - new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.zero_rated).length) +
                    new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(data.receipt.zero_rated)
                )
                .text(
                    "Paymode:" +
                    " ".repeat(48 - "Paymode:".length - data.receipt.paymode.length) +
                    data.receipt.paymode
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
                .text("BIR PTU NO: " + data.receipt.ptu_num)
                .text("PTU DATE ISSUED: " + data.receipt.ptu_date)
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
</script>
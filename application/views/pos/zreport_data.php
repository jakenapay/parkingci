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
                            <td><?php echo "00-" . $xreading['beginOrNumber'] ?></td>
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
                            <td><?php echo "00" ?></td>
                        </tr>
                        <tr>
                            <th>Z Counter No</th>
                            <td><?php echo number_format($xreading['zCounter']) ?></td>
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
                            <th>Total Change</th>
                            <td><?php echo number_format($xreading['totalChange'], 2) ?></td>
                        </tr>
                        <tr>
                            <th>Short / Over</th>
                            <td><?php echo number_format($xreading['shortOver'], 2) ?></td>
                        </tr>
                    </table>
                </div>
                <!-- Only Button to Print X Reading -->
                <div class="printer-selection text-center">
                    <div class="printer-dropdown">
                        <label for="printerName">Select an installed Printer:</label>
                        <select name="printerName" id="printerName"></select>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo base_url("touchpoint/zreport"); ?>" class="btn btn-danger mt-3">Back</a>
                        <button class="btn btn-secondary mt-3" onclick="doPrinting();">Print Z Reading</button>
                        <button class="btn btn-secondary mt-3" data-toggle="modal"
                            data-target="#previewZModal">Preview</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="previewZModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">Preview Z Reading</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="font-family: monospace; text-align: center;">
                            <!-- Preview content -->
                            PICC<br>
                            Philippine International Convention Center<br>
                            PICC Complex 1307, Pasay City,<br>
                            Metro Manila, Philippines<br>
                            VAT REG TIN: 001-114-766-00000<br>
                            MIN: 234290423<br>
                            SN: SN681DEF312963<br>
                            <br>
                            Z READING REPORT<br><br>
                            ==========================================================================<br>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Report Date:</strong></span>
                                <span id="reportDate"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Report Time:</strong></span>
                                <span id="reportTime"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Start Date & Time:</strong></span>
                                <span id="startDateTime"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>End Date & Time:</strong></span>
                                <span id="endDateTime"></span>
                            </div>
                            <!-- <div style="display: flex; justify-content: space-between;">
                                <span><strong>Cashier:</strong></span>
                                <span id="cashierName"></span>
                            </div> -->
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Beg. SI #:</strong></span>
                                <span id="beginOrNumber"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>End. SI #:</strong></span>
                                <span id="endOrNumber"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Beg. VOID SI #:</strong></span>
                                <span id="beginVoidOr"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>End. VOID SI #:</strong></span>
                                <span id="endVoidOr"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Beg. Return SI #:</strong></span>
                                <span id="beginReturnOr"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>End. Return SI #:</strong></span>
                                <span id="endReturnOr"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Reset Counter:</strong></span>
                                <span id="resetCounter"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Z Counter:</strong></span>
                                <span id="resetCounter2"></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Present Accumulated Sales:</strong></span>
                                <span id="presAccSales"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Previous Accumulated Sales:</strong></span>
                                <span id="prevAccSales"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Sales for the Day:</strong></span>
                                <span id="salesDay"></span>
                            </div>
                        </div>
                        ======================================================================
                        <!-- BREAKDOWN OF SALES -->
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div class="text-center text-uppercase">breakdown of sales</div>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Vatable Sales:</strong></span>
                                <span id="vatableSales"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Vat Amount:</strong></span>
                                <span id="vatAmount"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Vat-Exempt Sales:</strong></span>
                                <span id="vatExemptSales"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Zero-Rated Sales:</strong></span>
                                <span id="zeroRatedSales"></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Gross Amount:</strong></span>
                                <span id="grossAmount"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less Discount:</strong></span>
                                <span id="lessDiscount"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less Return:</strong></span>
                                <span id="lessReturn"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less Void:</strong></span>
                                <span id="lessVoid"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less VAT Adjustment:</strong></span>
                                <span id="lessVatAdj"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Net Amount:</strong></span>
                                <span id="netAmount"></span>
                            </div>
                        </div>
                        ======================================================================
                        <!-- DISCOUNT SUMMARY -->
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div class="text-center text-uppercase">discount summary</div>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>SC Disc:</strong></span>
                                <span id="scDisc"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>PWD Disc:</strong></span>
                                <span id="pwdDisc"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>NAAC Disc:</strong></span>
                                <span id="naacDisc"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Solo Parent Disc:</strong></span>
                                <span id="spDisc"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Other Disc:</strong></span>
                                <span id="otherDisc"></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div class="text-center text-uppercase">sales adjustment</div>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>VOID:</strong></span>
                                <span id="voidAmount"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>REFUND:</strong></span>
                                <span id="refundAmount"></span>
                            </div>
                        </div>
                        ======================================================================
                        <!-- VAT ADJUSTMENT -->
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div class="text-center text-uppercase">vat adjustment</div>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>SC TRANS:</strong></span>
                                <span id="scTrans"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>PWD TRANS:</strong></span>
                                <span id="pwdTrans"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>REG. Disc. TRANS:</strong></span>
                                <span id="regDiscTrans"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>ZERO-RATED TRANS.:</strong></span>
                                <span id="zeroRatedTrans"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>VAT on return:</strong></span>
                                <span id="vatOnReturn"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Other VAT Adjustments:</strong></span>
                                <span id="otherVatAdj"></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;" class="">
                            <div class="text-center text-uppercase">transaction summary</div>
                        </div>
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Cash in Drawer:</strong></span>
                                <span id="cashInDrawer"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>GCash in Drawer:</strong></span>
                                <span id="gcashPaymentsDrawer"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Paymaya in Drawer:</strong></span>
                                <span id="paymayaPaymentsDrawer"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Opening Fund:</strong></span>
                                <span id="openingFundDrawer"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Less Withdrawal:</strong></span>
                                <span id="lessWithdrawal"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Payments Received:</strong></span>
                                <span id="totalPaymentsReceivedDrawer"></span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>Total Change:</strong></span>
                                <span id="totalChange"></span>
                            </div>
                        </div>
                        ======================================================================
                        <div style="font-family: monospace; margin: 0 auto;">
                            <div style="display: flex; justify-content: space-between;">
                                <span><strong>SHORT/OVER:</strong></span>
                                <span id="shortOver"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button class="btn btn-secondary mt-3" onclick="doPrinting();">Print Z Reading</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Your functions here
    function setZstatus(num) {
        $.ajax({
            url: '<?php echo base_url("touchpoint/setZstatus/"); ?>' + num, // Append parameter to URL
            type: 'POST',
            data: { number: num }, // Send parameter in data
            dataType: 'json',
            success: function (response) {
                // Handle success response
            },
            error: function (xhr, status, error) {
                // Handle error response
            }
        });
    }

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
                .text(
                    "Terminal:" +
                    " ".repeat(48 - "Terminal:".length - xreadingData.ptuName.length) +
                    xreadingData.ptuName
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
                    "Reset Counter:" +
                    " ".repeat(48 - "Reset Counter:".length - "00".length) +
                    "00"
                )
                .text(
                    "Z Counter:" +
                    " ".repeat(48 - "Z Counter:".length - xreadingData.zCounter.length) +
                    xreadingData.zCounter
                )

                .text(
                    "Present Accumulated Sales:" +
                    " ".repeat(48 - "Present Accumulated Sales:".length - parseFloat(xreadingData.presentAccumulatedSales).toFixed(2).length) +
                    parseFloat(xreadingData.presentAccumulatedSales).toFixed(2)
                )
                .text(
                    "Previous Accumulated Sales:" +
                    " ".repeat(48 - "Previous Accumulated Sales:".length - parseFloat(xreadingData.previousAccumulatedSales).toFixed(2).length) +
                    parseFloat(xreadingData.previousAccumulatedSales).toFixed(2)
                )
                .text(
                    "Sales for the Day:" +
                    " ".repeat(48 - "Sales for the Day:".length - parseFloat(xreadingData.dailySales).toFixed(2).length) +
                    parseFloat(xreadingData.dailySales).toFixed(2)
                )
                .text("================================================") // Divider
                .align(escpos.TextAlignment.Left)
                .text("BREAKDOWN OF SALES")
                .text(
                    "Vatable Sales:" +
                    " ".repeat(48 - "Vatable Sales:".length - parseFloat(xreadingData.vatableSales).toFixed(2).length) +
                    parseFloat(xreadingData.vatableSales).toFixed(2)
                )
                .text(
                    "Vat Amount:" +
                    " ".repeat(48 - "Vat Amount:".length - parseFloat(xreadingData.vatAmount).toFixed(2).length) +
                    parseFloat(xreadingData.vatAmount).toFixed(2)
                )
                .text(
                    "Vat-Exempt Sales:" +
                    " ".repeat(48 - "Vat-Exempt Sales:".length - parseFloat(xreadingData.vatExempt).toFixed(2).length) +
                    parseFloat(xreadingData.vatExempt).toFixed(2)
                )
                .text(
                    "Zero-Rated Sales:" +
                    " ".repeat(48 - "Zero-Rated Sales:".length - parseFloat(xreadingData.zeroRated).toFixed(2).length) +
                    parseFloat(xreadingData.zeroRated).toFixed(2)
                )
                .text("================================================") // Divider
                .text(
                    "Gross Amount:" +
                    " ".repeat(48 - "Gross Amount:".length - parseFloat(xreadingData.grossAmount).toFixed(2).length) +
                    parseFloat(xreadingData.grossAmount).toFixed(2)
                )
                .text(
                    "Less Discount:" +
                    " ".repeat(48 - "Less Discount:".length - parseFloat(xreadingData.lessDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.lessDiscount).toFixed(2)
                )
                .text(
                    "Less Return:" +
                    " ".repeat(48 - "Less Return:".length - parseFloat(xreadingData.lessReturn).toFixed(2).length) +
                    parseFloat(xreadingData.lessReturn).toFixed(2)
                )
                .text(
                    "Less Void:" +
                    " ".repeat(48 - "Less Void:".length - parseFloat(xreadingData.lessVoid).toFixed(2).length) +
                    parseFloat(xreadingData.lessVoid).toFixed(2)
                )
                .text(
                    "Less VAT Adjustment:" +
                    " ".repeat(48 - "Less VAT Adjustment:".length - parseFloat(xreadingData.lessVatAdjustment).toFixed(2).length) +
                    parseFloat(xreadingData.lessVatAdjustment).toFixed(2)
                )
                .text(
                    "Net Amount:" +
                    " ".repeat(48 - "Net Amount:".length - parseFloat(xreadingData.netAmount).toFixed(2).length) +
                    parseFloat(xreadingData.netAmount).toFixed(2)
                )
                .text("================================================") // Divider
                .align(escpos.TextAlignment.Left)
                .text("DISCOUNT SUMMARY")
                .text(
                    "SC Disc:" +
                    " ".repeat(48 - "SC Disc:".length - parseFloat(xreadingData.seniorDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.seniorDiscount).toFixed(2)
                )
                .text(
                    "PWD Disc:" +
                    " ".repeat(48 - "PWD Disc:".length - parseFloat(xreadingData.pwdDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.pwdDiscount).toFixed(2)
                )
                .text(
                    "NAAC Disc:" +
                    " ".repeat(48 - "NAAC Disc:".length - parseFloat(xreadingData.naacDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.naacDiscount).toFixed(2)
                )
                .text(
                    "Solo Parent Disc:" +
                    " ".repeat(48 - "Solo Parent Disc:".length - parseFloat(xreadingData.soloparentDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.soloparentDiscount).toFixed(2)
                )
                .text(
                    "Other Disc:" +
                    " ".repeat(48 - "Other Disc:".length - parseFloat(xreadingData.otherDiscount).toFixed(2).length) +
                    parseFloat(xreadingData.otherDiscount).toFixed(2)
                )
                .text("================================================") // Divider
                .align(escpos.TextAlignment.Left)
                .text("SALES ADJUSTMENT")
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
                .align(escpos.TextAlignment.Left)
                .text("VAT ADJUSTMENT")
                .text(
                    "SC TRANS:" +
                    " ".repeat(48 - "SC TRANS:".length - parseFloat(xreadingData.seniorTransactions).toFixed(2).length) +
                    parseFloat(xreadingData.seniorTransactions).toFixed(2)
                )
                .text(
                    "PWD TRANS:" +
                    " ".repeat(48 - "PWD TRANS:".length - parseFloat(xreadingData.pwdTransactions).toFixed(2).length) +
                    parseFloat(xreadingData.pwdTransactions).toFixed(2)
                )
                .text(
                    "REG.Disc. TRANS:" +
                    " ".repeat(48 - "REG.Disc. TRANS:".length - parseFloat(xreadingData.regularDiscTransactions).toFixed(2).length) +
                    parseFloat(xreadingData.regularDiscTransactions).toFixed(2)
                )
                .text(
                    "ZERO-RATED TRANS.:" +
                    " ".repeat(48 - "ZERO-RATED TRANS.:".length - parseFloat(xreadingData.zeroRated).toFixed(2).length) +
                    parseFloat(xreadingData.zeroRated).toFixed(2)
                )
                .text(
                    "VAT on Return:" +
                    " ".repeat(48 - "VAT on Return:".length - parseFloat(xreadingData.vatOnReturn).toFixed(2).length) +
                    parseFloat(xreadingData.vatOnReturn).toFixed(2)
                )
                .text(
                    "Other VAT Adjustments:" +
                    " ".repeat(48 - "Other VAT Adjustments:".length - parseFloat(xreadingData.otherVatAdjustment).toFixed(2).length) +
                    parseFloat(xreadingData.otherVatAdjustment).toFixed(2)
                )
                .text("================================================") // Divider
                .align(escpos.TextAlignment.Left)
                .text("TRANSACTION SUMMARY")
                .text(
                    "Cash In Drawer:" +
                    " ".repeat(48 - "Cash In Drawer:".length - parseFloat(xreadingData.cashInDrawer).toFixed(2).length) +
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
                    " ".repeat(48 - "Opening Fund:".length - parseFloat(xreadingData.openingFund).toFixed(2).length) +
                    parseFloat(xreadingData.openingFund).toFixed(2)
                )
                .text(
                    "Less Withdrawal:" +
                    " ".repeat(48 - "Less Withdrawal:".length - parseFloat(xreadingData.lessWithdrawal).toFixed(2).length) +
                    parseFloat(xreadingData.lessWithdrawal).toFixed(2)
                )
                .text(
                    "Payments Received:" +
                    " ".repeat(48 - "Payments Received:".length - parseFloat(xreadingData.totalPaymentsReceived).toFixed(2).length) +
                    parseFloat(xreadingData.totalPaymentsReceived).toFixed(2)
                )
                .text(
                    "Total Change:" +
                    " ".repeat(48 - "Total Change:".length - parseFloat(xreadingData.totalChange).toFixed(2).length) +
                    parseFloat(xreadingData.totalChange).toFixed(2)
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


            // Z status set to 1
            // Changed 030625
            setZstatus(xreadingData.terminalId);
            // console.log(xreadingData.terminalId);
        } else {
            console.error("Printing aborted: JSPM WebSocket is not open.");
            alert("Printing cannot proceed because JSPrintManager is not running or is blocked.");
        }
        // Do printing...
    }

    // X reading data preview before printing
    function populatePreviewModal(xreadingData) {
        console.log(xreadingData);
        console.log(xreadingData.cashPayments);

        // document.getElementById("cashPayments").textContent = parseFloat(xreadingData.cashPayments).toFixed(2);
        document.getElementById("reportDate").textContent = xreadingData.reportDate;
        document.getElementById("reportTime").textContent = xreadingData.reportTime;
        document.getElementById("startDateTime").textContent = xreadingData.startDateandTime;
        document.getElementById("endDateTime").textContent = xreadingData.endDateandTime;
        // document.getElementById("cashierName").textContent = xreadingData.cashierName;
        document.getElementById("beginOrNumber").textContent = `00-${xreadingData.beginOrNumber}`;
        document.getElementById("endOrNumber").textContent = `00-${xreadingData.endOrNumber}`;
        document.getElementById("beginVoidOr").textContent = `00-${xreadingData.beginVoidOr}`;
        document.getElementById("endVoidOr").textContent = `00-${xreadingData.endVoidOr}`;
        document.getElementById("beginReturnOr").textContent = `00-${xreadingData.beginReturnOr}`;
        document.getElementById("endReturnOr").textContent = `00-${xreadingData.endReturnOr}`;
        // document.getElementById("openingFund").textContent = xreadingData.openingFund;

        // For Resent Counter (similar formatting as the example you provided)
        // let resentCounter = "Resent Counter:" + " ".repeat(48 - "Resent Counter:".length - xreadingData.resentCounter.toString().length) + xreadingData.resentCounter;
        document.getElementById("resetCounter").textContent = '00';
        document.getElementById("resetCounter2").textContent = xreadingData.zCounter;

        // accumulated sales
        document.getElementById('presAccSales').textContent = parseFloat(xreadingData.presentAccumulatedSales).toFixed(2);
        document.getElementById('prevAccSales').textContent = parseFloat(xreadingData.previousAccumulatedSales).toFixed(2);
        document.getElementById('salesDay').textContent = parseFloat(xreadingData.dailySales).toFixed(2);

        // breakdown of sales
        document.getElementById('vatableSales').textContent = parseFloat(xreadingData.vatableSales).toFixed(2);
        document.getElementById('vatAmount').textContent = parseFloat(xreadingData.vatAmount).toFixed(2);
        document.getElementById('vatExemptSales').textContent = parseFloat(xreadingData.vatExempt).toFixed(2);
        document.getElementById('zeroRatedSales').textContent = parseFloat(xreadingData.zeroRated).toFixed(2);

        document.getElementById('grossAmount').textContent = parseFloat(xreadingData.grossAmount).toFixed(2);
        document.getElementById('lessDiscount').textContent = parseFloat(xreadingData.lessDiscount).toFixed(2);
        document.getElementById('lessReturn').textContent = parseFloat(xreadingData.lessReturn).toFixed(2);
        document.getElementById('lessVoid').textContent = parseFloat(xreadingData.lessVoid).toFixed(2);
        document.getElementById('lessVatAdj').textContent = parseFloat(xreadingData.lessVatAdjustment).toFixed(2);
        document.getElementById('netAmount').textContent = parseFloat(xreadingData.netAmount).toFixed(2);

        // discount summary 
        document.getElementById('scDisc').textContent = parseFloat(xreadingData.seniorDiscount).toFixed(2);
        document.getElementById('pwdDisc').textContent = parseFloat(xreadingData.pwdDiscount).toFixed(2);
        document.getElementById('naacDisc').textContent = parseFloat(xreadingData.naacDiscount).toFixed(2);
        document.getElementById('spDisc').textContent = parseFloat(xreadingData.soloparentDiscount).toFixed(2);
        document.getElementById('otherDisc').textContent = parseFloat(xreadingData.otherDiscount).toFixed(2);

        // vat adjustment
        document.getElementById('scTrans').textContent = parseFloat(xreadingData.seniorTransactions).toFixed(2);
        document.getElementById('pwdTrans').textContent = parseFloat(xreadingData.pwdTransactions).toFixed(2);
        document.getElementById('regDiscTrans').textContent = parseFloat(xreadingData.regularDiscTransactions).toFixed(2);
        document.getElementById('zeroRatedTrans').textContent = parseFloat(xreadingData.zeroRated).toFixed(2);
        document.getElementById('vatOnReturn').textContent = parseFloat(xreadingData.vatOnReturn).toFixed(2);
        document.getElementById('otherVatAdj').textContent = parseFloat(xreadingData.otherVatAdjustment).toFixed(2);

        // document.getElementById("cashPayments").textContent = parseFloat(xreadingData.cashPayments).toFixed(2);
        // document.getElementById("gcashPayments").textContent = parseFloat(xreadingData.gcashPayments).toFixed(2);
        // document.getElementById("paymayaPayments").textContent = parseFloat(xreadingData.paymayaPayments).toFixed(2);
        // document.getElementById("totalPaymentsReceived").textContent = parseFloat(xreadingData.totalPaymentsReceived).toFixed(2);

        document.getElementById("voidAmount").textContent = parseFloat(xreadingData.voidAmount).toFixed(2);
        document.getElementById("refundAmount").textContent = parseFloat(xreadingData.refundAmount).toFixed(2);

        // document.getElementById("totalWithdrawals").textContent = parseFloat(xreadingData.totalWithdrawals).toFixed(2);

        document.getElementById("cashInDrawer").textContent = parseFloat(xreadingData.cashInDrawer).toFixed(2);
        document.getElementById("gcashPaymentsDrawer").textContent = parseFloat(xreadingData.gcashPayments).toFixed(2);
        document.getElementById("paymayaPaymentsDrawer").textContent = parseFloat(xreadingData.paymayaPayments).toFixed(2);
        document.getElementById("openingFundDrawer").textContent = xreadingData.openingFund;
        document.getElementById("lessWithdrawal").textContent = xreadingData.lessWithdrawal;
        document.getElementById("totalPaymentsReceivedDrawer").textContent = parseFloat(xreadingData.totalPaymentsReceived).toFixed(2);
        document.getElementById("totalChange").textContent = parseFloat(xreadingData.totalChange).toFixed(2);
        document.getElementById("shortOver").textContent = parseFloat(xreadingData.shortOver).toFixed(2);
    }

    // Call this function when you open the modal, passing the xreadingData
    populatePreviewModal(xreadingData);

</script>
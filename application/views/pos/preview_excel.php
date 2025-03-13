<style>
    .excel-container {
        width: 100%;
        height: calc(100vh - 175px);
        /* This ensures the container fits within the viewport */
        background: #ffffff;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* Prevents accidental overflow on the parent */
    }

    .control-header {
        padding: 10px;
        background-color: #f4f4f4;
        border-bottom: 1px solid #ccc;
        text-align: right;
    }

    .table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        table-layout: fixed;
        /* Ensure consistent column widths */
    }

    .table thead {
        position: sticky;
        top: 0;
        background-color: #ffffff;
        /* Match the background color */
        z-index: 1;
        /* Ensure the thead stays above the tbody */
    }

    .table th {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: left;
        border: 1px solid #272727;
        background: #f4f4f4;
        /* Optional: Different background for header */
    }

    th,
    td {
        border: 1px solid #272727;
        height: 21px;
        width: 100px;
        wordwrap:
    }

    td:nth-child(1),
    th:nth-child(1) {
        text-align: center;
        width: 50px;
        /* Specific width for the first column */
    }


    .table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .xsls-container {
        width: 100%;
        height: 100%;
        /* Fill the available space of the parent */
        overflow: auto;
        /* Enable scrolling */
        white-space: nowrap;
        /* Prevent table content wrapping */
        box-sizing: border-box;
        /* Properly calculate dimensions with borders/padding */
    }


    .tab-content {
        flex: 1;
        padding: 20px;
        background-color: #ffffff;
        display: none;
    }

    .tab-content.active {
        flex: 1;
        display: block;
        /* Ensure active tab takes space */
        padding: 0;
        /* Remove padding to maximize scrollable area */
        overflow: hidden;
        /* Prevent overflow from affecting scroll behavior */
    }

    .tabs {
        display: flex;
        border-top: 1px solid #ccc;
        background-color: #f4f4f4;
        justify-content: start;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid transparent;
        border-top: none;
        margin-right: 5px;
    }

    .tab.active {
        background-color: #ffffff;
        border-color: #ccc;
        border-top: 1px solid #ffffff;
    }
</style>

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
        <div class="excel-container">
            <div class="control-header">

                <form action="<?php echo base_url("touchpoint/discountSummaryReport"); ?>" method="POST">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="start_date" name="start_date" required value="<?= $startDate; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="end_date" name="end_date" required value="<?= $endDate; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="cashier" name="cashier" required value="<?= $cashier_id; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="terminal" name="terminal" required value="<?= $trmId; ?>">
                    </div>
                    <button type="submit" class="btn btn-success"> <i class="fa fa-download"></i> Export</button>
                    <!-- <button  class="btn btn-primary w-100 mt-3">Submit</button> -->
                </form>
            </div>
            <div class="tab-content active">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                                <th>H</th>
                                <th>I</th>
                                <th>J</th>
                                <th>K</th>
                                <th>L</th>
                                <th>M</th>
                                <th>N</th>
                                <th>O</th>
                                <th>P</th>
                                <th>Q</th>
                                <th>R</th>
                                <th>S</th>
                                <th>T</th>
                                <th>U</th>
                                <th>V</th>
                                <th>W</th>
                                <th>X</th>
                                <th>Y</th>
                                <th>Z</th>
                                <th>AA</th>
                                <th>AB</th>
                                <th>AC</th>
                                <th>AD</th>
                                <th>AE</th>
                                <th>AF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="32" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="32" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="32" style="text-align: center;">001-114-766-00000</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>234290423</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>TRM001</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td>10</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>11</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td colspan="32" style="text-align: center; font-weight: bold; border: 2px solid #272727;">BIR SALES SUMMARY REPORT</td>
                            </tr>
                            <tr style="align-content: center;">
                                <td>13</td>
                                <td style="text-align: center; word-wrap: break-word; white-space: normal;" rowspan="3">Date</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Beginning SI/OR No.</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Ending SI/OR No.</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Grand Accum. Sales Ending Balance</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Grand Accum. Beg. Balance</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Sales Issued w/ Manual SI/OR (per RR 16-2018)</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Gross Sales for the Day</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">VATable Sales</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">VAT Amount</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">VAT-Exempt Sales</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Zero-Rated Sales</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center; font-weight: bold;" colspan="8">Deductions</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center; font-weight: bold;" colspan="6">Adjustment on VAT</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">VAT Payable</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Net Sales</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Sales Overrun / Overflow</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Total Income</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Reset Counter</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Z Counter</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center" rowspan="3">Remarks</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td colspan="5" style="text-align: center; font-weight: bold">Discounts</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">Returns</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">Voids</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">Total Deductions</td>
                                <td colspan="3" style="word-wrap: break-word; white-space: normal; text-align: center">Discount</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">VAT on Returns</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">Others</td>
                                <td rowspan="2" style="word-wrap: break-word; white-space: normal; text-align: center">Total VAT Adjustment</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">15</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">SC</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">PWD</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">NAAC</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Solo Parent</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Others</td>
                                <td>SC</td>
                                <td>PWD</td>
                                <td>Others</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php $counter = 16; ?>
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $counter++; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= date("Y-m-d");?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $summaryData['beginOrNumber'];?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $summaryData['endOrNumber']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['grandEndingBalance'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['grandBeginningBalance'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['manualSalesInvoice'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['grossSales'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatableSales'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatAmount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['zeroRated'], 2);?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['zeroRated'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['seniorDiscount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['pwdDiscount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['soloParentDiscount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['naacDiscount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['otherDiscount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['returnAmount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['voidAmount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['totalDeductions'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatSenior'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatPwd'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatOthers'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatReturns'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatOthers'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['totalVatAdjustment'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['vatPayable'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['netSales'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['salesOverflow'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($summaryData['totalIncome'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $summaryData['zCounter']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $zCounter; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $summaryData['remarks']; ?></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                                <th>H</th>
                                <th>I</th>
                                <th>J</th>
                                <th>K</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="11" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="11" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="11" style="text-align: center;">001-114-766-00000</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>234290423</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>TRM001</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td>10</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>11</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td colspan="11" style="text-align: center; font-weight: bold; border: 2px solid #272727;">Senior Citizen Sales Book/Report</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Date</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Name of Senior Citizen</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">OSCA ID No./SC ID No.</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">SC TIN</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">SI/OR Number</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Sales (Inclusive of VAT)</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">VAT Amount</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">VAT Exempt Sales</td>
                                <td colspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Discount</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Net Sales</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>5%</td>
                                <td>20%</td>
                            </tr>
                            <?php $counter = 15;
                            foreach ($seniorsReport as $sr): ?>
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $counter++; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= date("Y-m-d", $sr['paid_time']); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sr['name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sr['id_number']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sr['tin_id']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sr['ornumber']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sr['vat_exempt'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sr['vat'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sr['vat_exempt'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?php ''; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sr['discount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sr['earned_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                                <th>H</th>
                                <th>I</th>
                                <th>J</th>
                                <th>K</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="11" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="11" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="11" style="text-align: center;">001-114-766-00000</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>234290423</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>TRM001</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td>10</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>11</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td colspan="11" style="text-align: center; font-weight: bold; border: 2px solid #272727;">Persons with Disability Sales Book/Report</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Date</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Name of Person with Disability</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">PWD ID No.</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">PWD TIN</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">SI/OR Number</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Sales (Inclusive of VAT)</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">VAT Amount</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">VAT Exempt Sales</td>
                                <td colspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Discount</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Net Sales</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>5%</td>
                                <td>20%</td>
                            </tr>
                            <?php $counter = 14;
                            foreach ($pwdReport as $pr): ?>
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $counter++; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= date("Y-m-d", $pr['paid_time']); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $pr['name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $pr['id_number']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $pr['tin_id']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $pr['ornumber']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['vat_exempt'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['vat'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['vat_exempt'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['discount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['discount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($pr['earned_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="7" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="7" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="7" style="text-align: center;">001-114-766-00000</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>234290423</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>TRM001</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td>10</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>11</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td colspan="7" style="text-align: center; font-weight: bold; border: 2px solid #272727;">National Athletes and Coaches Sales Book/Report</td>
                            </tr>
                            <tr>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">13</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Date</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">National Athletes and Coaches Sales Book/Report</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">PNSTM ID No.</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">SI/OR Number</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Gross Sales/Receipts</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Sales Discount</td>
                                <td style="word-wrap: break-word; white-space: normal; text-align: center">Net Sales</td>
                            </tr>
                            <?php $counter = 14;
                            foreach ($naacReport as $nr): ?>
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $counter++; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= date("Y-m-d", $nr['paid_time']); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $nr['name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $nr['id_number']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $nr['ornumber']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($nr['amount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($nr['discount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($nr['earned_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-content">
                <div class="xsls-container">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><i class="fa fa-arrow"></i></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                                <th>H</th>
                                <th>I</th>
                                <th>J</th>
                                <th>K</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td colspan="11" style="text-align: center;">Philippine International Convention Center</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="11" style="text-align: center;">PICC Complex, 1307 Pasay City, Metro Manila, Philippines</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="11" style="text-align: center;">001-114-766-00000</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Touchpoint v1.0</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>SN8CC58C01A989</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>234290423</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>TRM001</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    2024-11-28 22:43:09
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>10</td>
                                <td>10</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>11</td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td colspan="11" style="text-align: center; font-weight: bold; border: 2px solid #272727;">Solo Parent Sales Book/Report</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Date</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Name of Solo Parent</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">SPIC No.</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Name of Child</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Birth Date of Child</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Age of Child</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">SI/OR Number</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Gross Sales</td>
                                <td colspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Discount</td>
                                <td rowspan="2" style="text-align: center; word-wrap: break-word; white-space: normal;">Net Sales</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td colspan="2" style="text-align: center;">10%</td>
                            </tr>
                            <?php $counter = 14;
                            foreach ($soloparentReport as $sp): ?>
                                <tr>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $counter++; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= date("Y-m-d", $sp['paid_time']); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['id_number']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['child_name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['child_dob']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['child_name']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= $sp['ornumber']; ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sp['amount'], 2); ?></td>
                                    <td colspan="2" style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sp['discount'], 2); ?></td>
                                    <td style="word-wrap: break-word; white-space: normal; text-align: center"><?= number_format($sp['earned_amount'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tabs">
                <div class="tab active" onclick="showTab(0)">E1</div>
                <div class="tab" onclick="showTab(1)">E2</div>
                <div class="tab" onclick="showTab(2)">E3</div>
                <div class="tab" onclick="showTab(3)">E4</div>
                <div class="tab" onclick="showTab(4)">E5</div>
            </div>
        </div>
    </div>
</section>

<script>
    function showTab(index) {
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');
        tabs.forEach((tab, i) => {
            tab.classList.toggle('active', i === index);
        });
        contents.forEach((content, i) => {
            content.classList.toggle('active', i === index);
        });
    }
</script>
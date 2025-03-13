<section class="content-wrapper">
    <section class="content-header">
        <h1>Reports
            <small>Manage reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <section class="content">
        <form action="<?php echo base_url('demo/printZreadingResult') ?>" method="GET">
            <div class="row">
                <!-- Box 1 -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="col-md-6"><label>Beg. S/I No.</label></div>
                            <div class="col-md-6">
                                <input type="text" name="begSalesInvoice" class="form-control" value="<?php echo $zreading['begSalesInvoice']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>End. S/I No.</label></div>
                            <div class="col-md-6">
                                <input type="text" name="endSalesInvoice" class="form-control" value="<?php echo $zreading['endSalesInvoice']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Opening Fund</label></div>
                            <div class="col-md-6">
                                <input type="text" name="openingFund" class="form-control" value="<?php echo $zreading['openingFund']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Cash</label></div>
                            <div class="col-md-6">
                                <input type="text" name="cash" class="form-control" value="<?php echo $zreading['cash']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Gcash</label></div>
                            <div class="col-md-6">
                                <input type="text" name="gcash" class="form-control" value="<?php echo $zreading['gcash']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 2 -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="col-md-6"><label>Paymaya</label></div>
                            <div class="col-md-6">
                                <input type="text" name="paymaya" class="form-control" value="<?php echo $zreading['paymaya']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Total Payments</label></div>
                            <div class="col-md-6">
                                <input type="text" name="totalPaymentsReceived" class="form-control" value="<?php echo $zreading['totalPaymentsReceived']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Total Void Sales</label></div>
                            <div class="col-md-6">
                                <input type="text" name="totalVoidSales" class="form-control" value="<?php echo $zreading['totalVoidSales']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Cash In Drawer</label></div>
                            <div class="col-md-6">
                                <input type="text" name="cashInDrawer" class="form-control" value="<?php echo $zreading['cashInDrawer']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Present Accumulated Sales</label></div>
                            <div class="col-md-6">
                                <input type="text" name="presentAccumulatedSales" class="form-control" value="<?php echo $zreading['presentAccumulatedSales']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Box 3 -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="col-md-6"><label>Previous Accumulated</label></div>
                            <div class="col-md-6">
                                <input type="text" name="previousAccumulatedSales" class="form-control" value="<?php echo $zreading['previousAccumulatedSales']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Sales for the Day</label></div>
                            <div class="col-md-6">
                                <input type="text" name="salesForTheDay" class="form-control" value="<?php echo $zreading['salesForTheDay']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Vatable Sales</label></div>
                            <div class="col-md-6">
                                <input type="text" name="vatableSales" class="form-control" value="<?php echo $zreading['vatableSales']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Total VAT Amount</label></div>
                            <div class="col-md-6">
                                <input type="text" name="totalVatAmount" class="form-control" value="<?php echo $zreading['totalVatAmount']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Gross Amount</label></div>
                            <div class="col-md-6">
                                <input type="text" name="grossAmount" class="form-control" value="<?php echo $zreading['grossAmount']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Continuing with Box 1 -->
                <div class="col-md-4">
                    <div class="box box-warning">
                        <div class="box-body">
                            <div class="col-md-6"><label>Less Discount</label></div>
                            <div class="col-md-6">
                                <input type="text" name="lessDiscount" class="form-control" value="<?php echo $zreading['lessDiscount']; ?>" readonly>
                            </div>
                            <div class="col-md-6"><label>Short/Over</label></div>
                            <div class="col-md-6">
                                <input type="text" name="shortOver" class="form-control" value="<?php echo $zreading['shortOver']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Print Report</button>
        </form>
    </section>
</section>

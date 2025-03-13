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
        <div class="col-md-4">
            <!-- Form with POST action to pass data to printXreadingResult -->
            <form action="<?php echo base_url('demo/printXreadingResult'); ?>" method="get">
                <div class="box box-warning">
                    <div class="box-body">
                        <!-- Begin Sales Invoice Field -->
                        <div class="col-md-6">
                            <label for="begSI">Beg. S/I No.</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="begSalesInvoice" value="<?php echo $xreading['begSalesInvoice']; ?>" readonly>
                        </div>

                        <!-- End Sales Invoice Field -->
                        <div class="col-md-6">
                            <label for="endSI">End. S/I No.</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="endSalesInvoice" value="<?php echo $xreading['endSalesInvoice']; ?>" readonly>
                        </div>

                        <!-- Opening Fund Field -->
                        <div class="col-md-6">
                            <label for="openingFund">Opening Fund</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="openingFund" value="<?php echo $xreading['openingFund']; ?>" readonly>
                        </div>

                        <!-- Cash Field -->
                        <div class="col-md-6">
                            <label for="cash">Cash</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cash" value="<?php echo $xreading['cash']; ?>" readonly>
                        </div>

                        <!-- GCash Field -->
                        <div class="col-md-6">
                            <label for="gcash">GCash</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="gcash" value="<?php echo $xreading['gcash']; ?>" readonly>
                        </div>

                        <!-- Paymaya Field -->
                        <div class="col-md-6">
                            <label for="paymaya">Paymaya</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="paymaya" value="<?php echo $xreading['paymaya']; ?>" readonly>
                        </div>

                        <!-- Total Payments Received Field -->
                        <div class="col-md-6">
                            <label for="totalPayments">Total Payments</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="totalPaymentsReceived" value="<?php echo $xreading['totalPaymentsReceived']; ?>" readonly>
                        </div>

                        <!-- Total Void Sales Field -->
                        <div class="col-md-6">
                            <label for="totalVoidSales">Total Void</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="totalVoidSales" value="<?php echo $xreading['totalVoidSales']; ?>" readonly>
                        </div>

                        <!-- Cash In Drawer Field -->
                        <div class="col-md-6">
                            <label for="cashInDrawer">Cash In Drawer</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="cashInDrawer" value="<?php echo $xreading['cashInDrawer']; ?>" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="cashInDrawer">Short / Over</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="shortOver" value="<?php echo $xreading['shortOver']; ?>" readonly>
                        </div>

                        <!-- Print Button to submit form -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Print</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>

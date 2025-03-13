<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage X-Reading Result</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <form action="<?php echo site_url('touchpoint/xreading'); ?>" method="POST">
            <!-- Form Inputs (same as before) -->
        </form>

        <!-- Display the filtered X-Reading data -->
        <div class="row">
            <div class="col-md-12">
                <h3>X-Reading Report</h3>
                <?php if ($xreading): ?>
                    <p><strong>First OR Number:</strong> <?php echo $xreading['first_ornumber']; ?></p>
                    <p><strong>Last OR Number:</strong> <?php echo $xreading['last_ornumber']; ?></p>
                    <p><strong>Total Payments:</strong> <?php echo number_format($xreading['total_payments'], 2); ?></p>
                    <p><strong>Payments Received (Cash):</strong> <?php echo number_format($xreading['payments_received']['Cash'], 2); ?></p>
                    <p><strong>Payments Received (GCash):</strong> <?php echo number_format($xreading['payments_received']['GCash'], 2); ?></p>
                    <p><strong>Payments Received (Paymaya):</strong> <?php echo number_format($xreading['payments_received']['Paymaya'], 2); ?></p>
                    <p><strong>Cash in Drawer:</strong> <?php echo number_format($xreading['transaction_summary']['cash_in_drawer'], 2); ?></p>
                    <p><strong>Cash:</strong> <?php echo number_format($xreading['transaction_summary']['cash'], 2); ?></p>
                    <p><strong>GCash:</strong> <?php echo number_format($xreading['transaction_summary']['gcash'], 2); ?></p>
                    <p><strong>Paymaya:</strong> <?php echo number_format($xreading['transaction_summary']['paymaya'], 2); ?></p>
                    <p><strong>Opening Fund:</strong> <?php echo number_format($xreading['transaction_summary']['opening_fund'], 2); ?></p>
                    <p><strong>Less Withdrawal:</strong> <?php echo number_format($xreading['transaction_summary']['less_withdrawal'], 2); ?></p>
                    <p><strong>Payments Received:</strong> <?php echo number_format($xreading['transaction_summary']['payments_received'], 2); ?></p>
                    <p><strong>Short/Over:</strong> <?php echo $xreading['short_over']; ?></p>
                <?php else: ?>
                    <p>No X-Reading data available for the selected date and cashier.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

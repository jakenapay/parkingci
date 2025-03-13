<div class="content-wrapper">
    <section class="content-header">
        <h1>Payment Status
            <small>Manage payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Payment Successful</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-success">
                    <strong>Success!</strong> Your payment has been processed successfully.
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Payment Details</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Organization</th>
                                <td><?php echo htmlspecialchars($receipt['organization']); ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo htmlspecialchars($receipt['address']); ?></td>
                            </tr>
                            <tr>
                                <th>Telephone</th>
                                <td><?php echo htmlspecialchars($receipt['telephone']); ?></td>
                            </tr>
                            <tr>
                                <th>TIN</th>
                                <td><?php echo htmlspecialchars($receipt['tin']); ?></td>
                            </tr>
                            <tr>
                                <th>OR Number</th>
                                <td><?php echo htmlspecialchars($receipt['ornumber']); ?></td>
                            </tr>
                            <tr>
                                <th>Vehicle Class</th>
                                <td><?php echo htmlspecialchars($receipt['vehicleClass']); ?></td>
                            </tr>
                            <tr>
                                <th>Parking Code</th>
                                <td><?php echo htmlspecialchars($receipt['parking_code']); ?></td>
                            </tr>
                            <tr>
                                <th>Payment Time</th>
                                <td><?php echo date('Y-m-d H:i:s', htmlspecialchars($receipt['paytime'])); ?></td>
                            </tr>
                            <tr>
                                <th>Parking Time</th>
                                <td><?php echo htmlspecialchars($receipt['parking_time']); ?></td>
                            </tr>
                            <tr>
                                <th>Amount Due</th>
                                <td>PHP <?php echo htmlspecialchars($receipt['bill_amount']); ?></td> <!-- Corrected to use VAT amount -->
                            </tr>
                            <tr>
                                <th>VAT (12%)</th>
                                <td>PHP <?php echo number_format(floatval($receipt['vat']), 2); ?></td> <!-- Corrected to use VAT amount -->
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>PHP <?php echo number_format(floatval($receipt['total_amount']), 2); ?></td>
                            </tr>
                            <tr>
                                <th>Payment Mode</th>
                                <td><?php echo htmlspecialchars($receipt['paymode']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="<?php echo base_url('touchpoint'); ?>" class="btn btn-primary btn-lg">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .content-wrapper {
        background-color: #f9f9f9;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .alert {
        font-size: 18px;
    }
    .btn {
        border-radius: 50px;
        padding: 10px 20px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>

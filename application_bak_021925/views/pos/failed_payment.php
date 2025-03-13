<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage Billing</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                Cashier: John Doe
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Payment Successful</h3>
            </div>
            <div class="box-body">
                <p class="text-danger">
                    <i class="fa fa-times-circle"></i> The payment transaction was not successful.
                </p>
                <div class="alert alert-danger">
                    <strong>Reason:</strong> <?= $voucherStatus; ?>
                </div>
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

                                    if($vehicleId == 1){
                                        echo "Motorcycle";
                                    }else if($vehicleId == 2){
                                        echo "Car";
                                    }else if($vehicleId == 3){
                                        echo "BUS/Truck";
                                    }else{
                                        echo "Unknown";
                                    }
                                ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s A',$receipt['entryTime']) ?></td>
                            <td><?php echo $receipt['parkingStay'] ?></td>
                            <td>&#8369; <?php echo number_format($receipt['totalAmountDue'], 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
                <a href="/dashboard" class="btn btn-success">Back to Dashboard</a>
            </div>
        </div>
    </div>
</section>

<script>
    function printReceipt() {
        alert("Printing receipt...");
        // Add receipt printing logic here
    }
</script>

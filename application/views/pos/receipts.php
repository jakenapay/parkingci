<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Reprint Transaction</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . htmlspecialchars($this->session->userdata('fname')) . " " . htmlspecialchars($this->session->userdata('lname')); ?>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Reprint Transactions</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="paymentTable" class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>S/ I #</th>
                                <th>Parking Code</th>
                                <th>Check-In</th>
                                <th>Paid Time</th>
                                <th>Vehicle Type</th>
                                <th>Rate Code</th>
                                <th>Earned Amount</th>
                                <th>Payment Mode</th>
                                <!-- <th>Reprint Count</th> -->
                                <th>Reprint</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php date_default_timezone_set("Asia/Manila"); ?>
                            <?php if (empty($transactions)): ?>
                                <tr>
                                    <td colspan="10">No transactions yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($transactions as $t): ?>
                                    <tr>
                                        <td>00-<?php echo htmlspecialchars($t['ornumber']); ?></td>
                                        <td><?php echo htmlspecialchars($t['parking_code']); ?></td>
                                        <td><?php echo date('Y-m-d h:i:s A', (int) $t['in_time']); ?></td>
                                        <td><?php echo date('Y-m-d h:i:s A', (int) $t['paid_time']); ?></td>
                                        <td>
                                            <?php
                                            $vehicle_types = [1 => "Motorcycle", 2 => "Car", 3 => "BUS/Truck"];
                                            echo isset($vehicle_types[$t['vehicle_cat_id']]) ? $vehicle_types[$t['vehicle_cat_id']] : "Unknown";
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($t['rate_id']); ?></td>
                                        <td><?php echo number_format($t['earned_amount'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($t['paymode']); ?></td>
                                        <!-- <td>
                                            <span
                                                class="label <?php echo ($t['reprint'] == 0) ? 'label-danger' : 'label-warning'; ?>">
                                                <?php echo $t['reprint']; ?>
                                            </span>
                                        </td> -->
                                        <td>
                                            <form action="<?php echo base_url('Touchpoint/reprintReceipt'); ?>" method="post">
                                                <input type="hidden" name="ornumber"
                                                    value="<?php echo htmlspecialchars($t['ornumber']); ?>">
                                                <button type="submit"
                                                    class="btn btn-sm btn-success reprint-btn">Reprint</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- Include Bootstrap CSS (if not already added) -->

<!-- Include Bootstrap JS after jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('#paymentTable').DataTable({
            'order': []
        });


    });

</script>
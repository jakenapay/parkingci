<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage transactions</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Payment Transaction</h3>
                <div class="box-tools">
                    <!-- Button to view all transaction history -->
                    <a href="<?php echo base_url('touchpoint/transactionhistory'); ?>" class="btn btn-primary btn-sm pull-right">
                        <i class="fa fa-history"></i> View All Transactions
                    </a>
                    
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="paymentTable" class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>S/ I #</th>
                                <th>Access Type</th>
                                <th>Parking Code</th>
                                <th>Check-In</th>
                                <th>Paid time</th>
                                <th>Vehicle Type</th>
                                <th>Rate code</th>
                                <th>Total Time</th>
                                <th>Earned Amount</th>
                                <th>Payment Mode</th>
                                <th>Paid Status</th>
                            </tr>
                        </thead>
                        <tbody><?php date_default_timezone_set("Asia/Manila"); ?>
                            <?php if (empty($transactions)): ?>

                                <tr>
                                    <td colspan="12">No transactions yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($transactions as $t): ?>
                                    <tr>
                                        <td>00-<?php echo $t['ornumber']; ?></td>
                                        <td><?php echo $t['access_type']; ?></td>


                                        <td><?php echo $t['parking_code']; ?></td>


                                        <td><?php $etime = date('Y-m-d H:i:s A',$t['in_time']); echo $etime;  ?></td>
                                        <td><?php $ptime = date('Y-m-d H:i:s A',$t['paid_time']); echo $ptime; ?></td>
                                        <td>
                                            <?php
                                                $vcat = $t['vehicle_cat_id']; 
                                                if($vcat == 1){
                                                    echo "Motorcycle";
                                                }else if($vcat == 2){
                                                    echo "Car";
                                                }else if($vcat == 3){
                                                    echo "BUS/Truck";
                                                }else{
                                                    echo "Unknown";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $t['rate_id']; ?></td>
                                        <td><?php echo $t['total_time']; ?></td>

                                        <td><?php echo number_format($t['amount'], 2); ?></td>
                                        <td><?php echo $t['paymode']; ?></td>
                                        <td>
                                            <?php
                                                $pstatus = $t['status']; 
                                                if($pstatus == 1){
                                                    echo "<p class='label label-success'>Paid</p>";
                                                }else{
                                                    echo "<p class='label label-danger'>Unpaid</p>'";
                                                }
                                            ?>
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

<script>
    $(document).ready(function () {
        $('#paymentTable').DataTable({
            'order': []
        });
    });
</script>

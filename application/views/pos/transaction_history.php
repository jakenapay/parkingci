

<section class="content-wrapper">
    <section class="content-header">
    <!-- <button onclick="downloadExcel()" class="btn btn-primary">Download Excel</button> -->
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
                                        <td><?php echo $t['ornumber']; ?></td>
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

                                        <td><?php echo number_format($t['earned_amount'], 2); ?></td>
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
        <!-- <div class="">
            <div class="btn-group">
                <button onclick="downloadJSON()" class="btn btn-info">Download JSON</button>
                <pre style="max-height: 300px; overflow-y: auto;"><?php echo json_encode($transactions, JSON_PRETTY_PRINT); ?></pre>
            </div>

            <script>
            function downloadJSON() {
                const data = <?php // echo json_encode($transactions); ?>;
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'transactions.json';
                a.click();
                window.URL.revokeObjectURL(url);
            }
            </script>
        </div> -->
    </section>
</section>

<script>
    $(document).ready(function () {
        $('#paymentTable').DataTable({
            'order': []
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
function downloadExcel() {
    $.ajax({
        url: '<?php echo base_url("touchpoint/downloadAllTransaction"); ?>', // Adjust the controller path
        method: 'POST',
        success: function(response) {
            // Create a blob and download
            var blob = new Blob([response], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'transactions.xlsx';
            link.click();
            window.URL.revokeObjectURL(link.href);
        },
        error: function(xhr, status, error) {
            console.error('Error downloading excel:', error);
        }
    });
}
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?> </li>
        </ol>
    </section>
    <!-- Navigation buttons -->
    <section class="content-header">
        <div class="btn-group">
          <a href="<?= base_url('cashier/transaction');?>" class="btn btn-warning">Cashier Transactions</a>
        </div>
        <br>
    </section>
    <br>
    <!-- Main content -->
    <section>
        
        <div class="box">
            
            <div class="box-header">
                <h3 class="box-title">Payment Transaction</h3>
                <div class="pull-right">
                    <div class="col-lg-6">
                        <a href="<?= base_url('cashier/getKioskTransaction?kioskid=12') ?>">
                            <div class="col-lg-2">
                                <div class="btn btn-primary">
                                    Kiosk 1 Transactions
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="<?= base_url('cashier/getKioskTransaction?kioskid=13') ?>">
                            <div class="col-lg-2">
                                <div class="btn btn-primary">
                                    Kiosk 2 Transactions
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="paymentTable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID#</th>
                                <th>ORNO</th>
                                <th>Access Type</th>
                                <th>Access Coder</th>
                                <th>Check-In</th>
                                <th>Paid time</th>
                                <th>Vehicle Type</th>
                                <th>Rate code</th>
                                <th>Total Time</th>
                                <th>Total Amount</th>
                                <th>Pay Mode</th>
                                <th>Paid Status</th>
                                <!-- th>Action</th -->
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($transaction)): ?>
                <tr>
                    <td colspan="12">No transactions yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($transaction as $rt): ?>
                    <tr>
                        <td><?= $rt['id']; ?></td>
                        <td><?= $rt['ORNO']; ?></td>
                        <td><?= $rt['AccessType']; ?></td>
                        <td><?= $rt['parking_code']; ?></td>
                        <td><?= $rt['in_time']; ?></td>
                        <td><?= $rt['paid_time']; ?></td>
                        <td><?php
                          $vehicle = $rt['vechile_cat_id'];
                          if($vehicle == "1"){
                            echo "Motorcycle";
                          }else if($vehicle == "2"){
                            echo "Car";
                          }else if($vehicle == "3"){
                            echo "BUS/Truck";
                          }else{
                            echo "Unknown";
                          }
                          ?>
                        </td>
                        <td><?= $rt['rate_id']; ?></td>
                        <td><?= $rt['total_time']; ?></td>
                        <td>PHP <?= $rt['earned_amount']; ?></td>
                        <td>
                          <?php
                           $mop = $rt['pay_mode'];
                           if($mop == "Cash"){
                              echo "<p class='label label-info'>Cash</p>"; 
                           }else if($mop == "Paymaya"){
                              echo "<p class='label label-success'>Paymaya</p>"; 
                           }else if($mop == "Gcash"){
                            echo "<p class='label label-primary'>G-Cash</p>"; 
                           }else{
                            echo "<p class='label label-danger'>Complimentary</p>"; 
                           }
                          ?>
                         </td>
                        <td>
                            <?php
                            $pstatus = $rt['paid_status']; 
                            if ($pstatus == 1) {
                                echo "<p class='label label-success'>Paid</p>"; 
                            } else {
                                echo "<p class='label label-danger'>Unpaid</p>"; 
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
</div>
<!-- /.content-wrapper -->
<script>
    function loadPayStationTransaction() {
        // Add your code to load Pay Station Transaction data
    }

    function loadCashierTransaction() {
        // Add your code to load Cashier Transaction data
    }

    $(document).ready(function() {
        $('#paymentTable').DataTable({
            'order': []
        });
    });
</script>

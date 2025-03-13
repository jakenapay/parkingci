<section class="content-wrapper">
    <section class="content-header">
        <h1>Billing
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
        <div class="col-md-6">
            <form action="<?php echo base_url("touchpoint/PaymentMode") ?>" method="GET">
                <div class="box">
                    <div class="box-body">
                        <div class="box-header">
                            <h3 class="box-title">Billing Information</h3>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gate_id">Gate ID</label>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $billdata['id']; ?>" readonly>
                            <input type="text" class="form-control" name="gate_id" value="<?= $billdata['gateEntry']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="access_type">Access Type</label>
                            <input type="text" class="form-control" name="access_type" value="<?php echo $billdata['accessType'] ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="access_type">Parking Code</label>
                            <input type="text" class="form-control" name="parking_code" value="<?php echo $billdata['parkingCode'] ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="access_type">Entry Time</label>
                            <input type="hidden" class="form-control" name="unix_entry_time" value="<?php echo $billdata['unixEntryTime'] ?>">
                            <input type="text" class="form-control" name="etime" value="<?php echo date('Y-m-d H:i:s A',$billdata['unixEntryTime']) ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="access_type">Payment Time</label>
                            <input type="hidden" class="form-control" name="paytime" value="<?php echo $billdata['paytime']; ?>">
                            <input type="text" class="form-control" name="pay" value="<?php echo date('Y-m-d H:i:s A',$billdata['paytime']); ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="access_type">Vehicle Class</label>
                            <input type="hidden" class="form-control" name="vehicle_class" value="<?php echo $billdata['vehicleClass'] ?>" readonly>
                            <input type="text" class="form-control" name="vclass" value="<?php
                            $vclass = $billdata['vehicleClass'];
                            if($vclass == 1)
                            {
                                echo "Motorcycle";
                            }else if ($vclass == 2)
                            {
                                echo "Car";
                            }else if ($vclass == 3)
                            {
                                echo "BUS/Truck";
                            }else{
                                echo "Unknown";
                            }
                            ?>" readonly>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="parkingLength">Total Parking Time</label>
                            <input type="hidden" class="form-control" name="parking_time" value="<?php echo $billdata['parkingTime']; ?>" readonly>
                            <input type="text" class="form-control" name="parking_length" id="parkingLength" value="<?php echo $billdata['totalParkTime']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount_due">Amount Due</label>
                            <input type="text" class="form-control" name="amount_due" id="amountDue"
                                value="<?php echo $billdata['amount'] ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vehicleRate">Vehicle Rate</label>
                            <input type="text" class="form-control" name="vehicle_rate" id="vehicleRate"
                                value="<?php echo $billdata['vehicleRate']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="paymentStatus">Status</label>
                            <input type="hidden" class="form-control" name="status" id="paymentStatus"
                                value="<?php echo $billdata['status']; ?>" readonly>
                            <input type="text" class="form-control" name="payment_status" id="paymentStatus"
                                value="<?php 
                                $status = $billdata['status'];

                                if($status == 0)
                                {
                                    echo "Unpaid";
                                }else{
                                    echo "Paid";
                                }
                                 ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Discount Rates</h3>
                    </div>
                    <div class="box-body">
                        <select name="discount_opt" id="discountRate" class="form-control">
                            <option value="Regular">Regular</option>
                            <option value="Tenant">Tenant</option>
                            <option value="SPWD">Senior Citizen / PWD</option>
                            <option value="Resident">Senior Citizen / PWD Pasay Resident</option>
                        </select>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Process Payment</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    let billdata = <?php echo json_encode($billdata['amount']); ?>;
    let vcat = <?php echo json_encode($billdata['vehicleClass']); ?>;

    $(document).ready(function () {
        $("#discountRate").change(function () {
            var discountRate = $(this).val();
            var amount = document.getElementById('amountDue');
            var billAmount = parseInt(billdata);

            // Switch based on vehicle class
            switch (parseInt(vcat)) {
                case 1: // Motorcycle
                    if (discountRate == "SPWD" || discountRate == "Tenant") {
                        amount.value = billAmount - 10;
                    } else if (discountRate == "Resident") {
                        amount.value = 0;
                    } else {
                        amount.value = billAmount;
                    }
                    break;
                case 2: // Car
                    if (discountRate == "SPWD" || discountRate == "Tenant") {
                        amount.value = billAmount - 20;
                    } else if (discountRate == "Resident") {
                        amount.value = 0;
                    } else {
                        amount.value = billAmount;
                    }
                    break;
                case 3: // BUS/Truck
                    amount.value = billAmount; // No discount applied
                    break;
                default:
                    amount.value = billAmount; // Default case
                    break;
            }
        });
    });
</script>

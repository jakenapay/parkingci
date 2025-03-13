<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Parking Billing Information
            <small>Review and complete the payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="col-lg-6">
            <form action="<?= base_url('terminal/paymentmode'); ?>" method="GET">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Bill Details</h3>
                    </div>
                    <div class="box-body">
                        <!-- Gate ID -->
                        <div class="form-group col-md-6">
                            <label for="gate_id">Gate ID</label>
                            <input type="hidden" class="form-control" name="id"
                                value="<?= $billdata['id']; ?>" readonly>
                            <input type="text" class="form-control" name="gate_id"
                                value="<?= $billdata['gateEntry']; ?>" readonly>
                        </div>
                        <!-- Access Type -->
                        <div class="form-group col-md-6">
                            <label for="access_type">Access Type</label>
                            <input type="text" class="form-control" name="access_type"
                                value="<?= $billdata['accessType']; ?>" readonly>
                        </div>
                        <!-- Parking Code -->
                        <div class="form-group col-md-6">
                            <label for="parking_code">Parking Code</label>
                            <input type="text" class="form-control" name="parking_code"
                                value="<?= $billdata['parkingCode']; ?>" readonly>
                        </div>
                        <!-- Decoded Entry Time -->
                        <div class="form-group col-md-6">
                            <label for="decoded_entry_time">Entry Time</label>
                            <input type="text" class="form-control" name="decoded_entry_time"
                                value="<?= $billdata['decodeEntryTime']; ?>" readonly>
                            <input type="hidden" class="form-control" name="unix_entry_time"
                                value="<?= $billdata['unixEntryTime']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="paytime">Payment Time</label>
                            <input type="text" class="form-control"
                                value="<?php date_default_timezone_set("Asia/Manila"); echo date('Y-m-d H:i:s A', $billdata['paytime']); ?>" readonly>
                            <input type="hidden" class="form-control" name="paytime"
                                value="<?= $billdata['paytime']; ?>" readonly>
                        </div>
                        <!-- Vehicle Class -->
                        <div class="form-group col-md-6">
                            <label for="vehicle_class">Vehicle Class</label>
                            <input type="hidden" class="form-control" name="vehicle_class"
                                value="<?= $billdata['vehicleClass']; ?>" readonly>

                            <input type="text" class="form-control"
                             value="<?php 
                                $category = $billdata['vehicleClass'];
                                if($category == 1){
                                    echo "Motorcycle";
                                }else if($category == 2){
                                    echo "Car";
                                }else if ($category == 3){
                                    echo "BUS/Truck";
                                }else{
                                    echo "Unknown";
                                }
                             ?>" readonly>
                        </div>
                        <!-- Total Park Time -->
                        <div class="form-group col-md-6">
                            <label for="total_park_time">Total Parking Time</label>
                            <input type="hidden" class="form-control" name="parking_time" value="<?php echo $billdata['parkingTime']; ?>">
                            <input type="text" class="form-control" name="total_park_time"
                                value="<?= $billdata['totalParkTime']; ?>" readonly>
                        </div>
                        <!-- Amount Due -->
                        <div class="form-group col-md-6">
                            <label for="amount_due">Amount Due</label>
                            <input type="text" class="form-control" name="amount_due" id="amountDue"
                                value="<?= $billdata['amount'] ?>" readonly>
                        </div>
                        <!-- Vehicle Rate -->
                        <div class="form-group col-md-6">
                            <label for="vehicle_rate">Vehicle Rate</label>
                            <input type="text" class="form-control" name="vehicle_rate"
                                value="<?= $billdata['vehicleRate']; ?>" readonly>
                        </div>
                        <!-- Status -->
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <input type="hidden" class="form-control" name="status" value="<?= $billdata['status']; ?>">
                            <input type="text" class="form-control"
                                value="<?= $billdata['status'] == 1 ? 'Paid' : 'Unpaid'; ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Discount Rates -->
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

        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Client Vehicle Image</h3>
                </div>
                <div class="box-body">

                    <?php
                    $imagePath = base_url() . $billdata['picturePath'] . $billdata['pictureName'];
                    $fallbackImagePath = base_url('assets/images/no-image-placeholder.png'); // Path to the fallback image in your assets folder
                    
                    if (!empty($billdata['picturePath']) && !empty($billdata['pictureName']) && file_exists($billdata['picturePath'] . $billdata['pictureName'])) {
                        // Display the original image if it exists
                        echo '<img src="' . $imagePath . '" style="width: 100%; " class="img-rounded" id="myImage">';
                    } else {
                        // Display the fallback image if the original does not exist
                        echo '<img src="' . $fallbackImagePath . '" style="width: 100%; " class="img-rounded" id="myImage">';
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Ensuring PHP values are correctly passed to JavaScript
    let billdata = <?php echo json_encode($billdata['amount']); ?>;
    let vcat = <?php echo json_encode($billdata['vehicleClass']); ?>;

    $(document).ready(function () {
        // Correcting the selector to use ID
        $("#discountRate").change(function () {
            var discountRate = $(this).val();
            var amount = document.getElementById('amountDue');

            // Corrected discount calculation logic
            switch (parseInt(vcat)) {
                case 1: // Motorcycle
                    if ((discountRate == "SPWD") || (discountRate == "Tenant")) {
                        amount.value = parseInt(billdata) - 10;
                    } else if (discountRate == "Resident") {
                        amount.value = 0;
                    } else {
                        amount.value = parseInt(billdata);
                    }
                    break;
                case 2: // Car
                    if ((discountRate == "SPWD") || (discountRate == "Tenant")) {
                        amount.value = parseInt(billdata) - 20;
                    } else if (discountRate == "Resident") {
                        amount.value = 0;
                    } else {
                        amount.value = parseInt(billdata);
                    }
                    break;
                case 3: // Bus/Truck
                    amount.value = parseInt(billdata);
                    break;
                default: // Default case if vehicle class is unknown
                    amount.value = parseInt(billdata);
                    break;
            }
        });
    });

</script>
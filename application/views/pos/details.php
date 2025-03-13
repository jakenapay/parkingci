    <section class="content-wrapper">
        <section class="content-header">
            <h1>Touchpoint v1.0
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
            <div class="row">
                <!-- Parking Details Column -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Form Start -->
                            <form action="<?php echo base_url("touchpoint/applyDiscount"); ?>" method="post">
                                <div class="parking-session">
                                    <h3>Parking Details</h3>
                                    <div class="info-row">
                                        <span class="info-label">Gate:</span>
                                        <span class="info-value"><?php echo $details['gate']; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Access Type:</span>
                                        <span class="info-value"><?php echo $details['access_type']; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Parking Code:</span>
                                        <span class="info-value"><?php echo $details['parking_code']; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Parking Stay:</span>
                                        <span class="info-value"><?php echo $details['parkingStay']; ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Entry Time:</span>
                                        <span
                                            class="info-value"><?php echo date('Y-m-d H:i:s A', $details['entryTime']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Payment Time:</span>
                                        <span
                                            class="info-value"><?php echo date('Y-m-d H:i:s A', $details['paymentTime']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Vehicle Class:</span>
                                        <span class="info-value">
                                            <span class="info-value">
                                                <?php
                                                $vehicle = $details['vehicleClass'];

                                                if ($vehicle == 1) {
                                                    echo "Motorcycle";
                                                } else if ($vehicle == 2) {
                                                    echo "Car";
                                                } else if ($vehicle == 3) {
                                                    echo "BUS/Truck";
                                                } else {
                                                    echo "Unknown";
                                                }
                                                ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Amount Due:</span>
                                        <span
                                            class="info-value"><?php echo "Php " . number_format($details['parking_amount']); ?></span> 
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Parking Rate:</span>
                                        <span
                                            class="info-value"><?php echo $details['parking_status']; ?></span>
                                    </div>
                                    <div class="total-time">
                                        <span class="info-value">Parking Duration:
                                            <?php echo $details['parkingTime'] ?></span>
                                    </div>

                                    <div class="discount-section">
                                        <?php if (isset($validation_errors)): ?>
                                            <div id="validation-errors" class="alert alert-danger">
                                                <?php echo $validation_errors; ?>
                                            </div>
                                            <script>
                                                setTimeout(function() {
                                                    document.getElementById('validation-errors').style.display = 'none';
                                                }, 3000); // 3000 milliseconds = 3 seconds
                                            </script>
                                        <?php endif; ?>
                                        <input type="hidden" name="parking_id" class="form-control"
                                            value="<?php echo $details['id']; ?>">
                                        <input type="hidden" name="gate" class="form-control"
                                            value="<?php echo $details['gate']; ?>">
                                        <input type="hidden" name="access_type" class="form-control"
                                            value="<?php echo $details['access_type']; ?>">
                                        <input type="hidden" name="parking_code" class="form-control"
                                            value="<?php echo $details['parking_code']; ?>">
                                        <input type="hidden" name="parkingStay" class="form-control"
                                            value="<?php echo $details['parkingStay']; ?>">
                                        <input type="hidden" name="entryTime" class="form-control"
                                            value="<?php echo $details['entryTime']; ?>">
                                        <input type="hidden" name="paymentTime" class="form-control"
                                            value="<?php echo $details['paymentTime']; ?>">
                                        <input type="hidden" name="parkingTime" class="form-control"
                                            value="<?php echo $details['parkingTime']; ?>">
                                        <input type="hidden" name="vehicleClass" class="form-control"
                                            value="<?php echo $details['vehicleClass']; ?>">
                                        <input type="hidden" name="parking_status" class="form-control"
                                            value="<?php echo $details['parking_status']; ?>">
                                        <input type="hidden" name="parking_amount" class="form-control"
                                            value="<?php echo $details['parking_amount']; ?>">
                                        <input type="hidden" name="pictureName" class="form-control"
                                            value="<?php echo $details['pictureName']; ?>">
                                        <input type="hidden" name="picturePath" class="form-control"
                                            value="<?php echo $details['picturePath']; ?>">
                                        
                                        <label for="discount">Apply Discount</label>
                                        <select id="discount" name="discount_type" onchange="applyDiscount()">
                                            <option value="none">No Discount</option>
                                            <option value="senior">Senior Citizen</option>
                                            <option value="tenant">Tenant</option>
                                            <option value="pwd">PWD</option>
                                            <option value="naac">NAAC</option>
                                            <option value="sp">Solo Parent</option>
                                        </select>
                                        
                                    </div>

                                    <div class="form-actions text-right">
                                        <button type="submit" class="submit-btn">Proceed Payment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Image Column -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Vehicle Image</h5>
                        </div>
                        <div class="card-body car-image-section">
                            <?php
                            $imagePath = $details['picturePath'] . '/' . $details['pictureName'];

                            if (file_exists($imagePath)) {
                                echo '<img src="' . base_url($imagePath) . '" alt="Vehicle Image" class="car-image">';
                            } else {
                               // echo '<img src="' . base_url('assets/images/noimage-placeholder.png') . '" alt="Placeholder Image" class="car-image">';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .card {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.876rem;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .car-image-section {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .car-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .parking-session {
            font-family: Arial, sans-serif;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
        }

        .parking-session h3 {
            font-size: 1.2em;
            font-weight: 600;
            margin-top: 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eaeaea;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #555;
            font-weight: 500;
        }

        .info-value {
            font-weight: 600;
        }

        .total-time {
            background-color: #e9f5ff;
            color: #007bff;
            font-weight: 600;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-top: 20px;
        }

        .discount-section {
            margin-top: 20px;
        }

        .discount-section label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #555;
        }

        .discount-section select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
        }

        .form-actions {
            /* margin-top: 20px; */
            text-align: end;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>



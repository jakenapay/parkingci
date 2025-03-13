<style>
    .receipt-frame {
        width: 100%;
        height: calc(100vh - 195px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .receipt {
        width: 400px;
        background: #fff;
        padding: 25px;
    }

    .receipt-subheader {
        text-align: center;
    }
    .receipt-subheader p {
        padding: 0;
        margin: 0;
    }

    .receipt-footer {
        text-align: center;
    }

    .receipt-footer p {
        padding: 0;
        margin: 3px;
    }

    .org-abbr {
        text-align: center;
        font-weight: bold;
        font-size: 20px;
    }

    .rh-row {
        width: 100%;
        display: flex;
    }

    .rh-col, .rb-col {
        width: 50%;
        text-align: start;
    }

    .rh-col:nth-child(2), .rb-col:nth-child(2) {
        width: 50%;
        text-align: end;
    }

    .receipt-body-title {
        text-align: center;
        padding: 20px;
    }

    .receipt-body-row {
        width: 100%;
        display: flex;
    }

    /* Button styling */
    .btn-home {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
        cursor: pointer;
    }

    .btn-home:hover {
        background-color: #45a049;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Invoice
            <small>Invoice Preview</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <div class="content">

        <div class="receipt-frame">
            <div class="receipt">
                <div class="receipt-header">
                    <p class="org-abbr"><strong>PICC</strong></p>
                    <div class="rh-row">
                        <div class="rh-col">
                            <p><?php echo $receipt['organization'] ?></p>
                        </div>
                        <div class="rh-col">
                            <p><?php echo date('Y-m-d H:i:s A',$receipt['paytime']); ?></p>
                        </div>
                    </div>
                    <p><?php echo $receipt['address'] ?></p>
                    <p><?php echo $receipt['telephone'] ?></p>
                </div>
                <div class="receipt-subheader">
                    <p>VAT REG TIN: <?php echo $receipt['tin'] ?></p>
                    <p>MIN: <?php echo $receipt['min'] ?></p>
                    <p>Invoice #: <?php echo $receipt['ornumber'] ?></p>
                    <p>Code: <?php echo $receipt['parking_code'] ?></p>
                    <p><strong>Vehicle Class:</strong> 
                        <?php 
                            $vehicleId = $receipt['vehicleClass'];
                            if($vehicleId == 1) {
                                echo "Motorcycle";
                            } else if($vehicleId == 2) {
                                echo "Car";
                            } else if($vehicleId == 3) {
                                echo "BUS/Truck";
                            } else {
                                echo "Unknown";
                            }
                        ?>
                    </p>
                </div>

                <div class="receipt-body">
                    <p class="receipt-body-title"><strong>Receipt</strong></p>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Cashier</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $this->session->userdata('username') ?></p>
                        </div>
                    </div>
                    <p>===========================================</p>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Gate In</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo date('Y-m-d H:i:s', $receipt['in_time']); ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Payment Time</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo date('Y-m-d H:i:s', $receipt['paytime']); ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Parking Time</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $receipt['parking_time']; ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Amount Due:</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo "PHP " . $receipt['amount_due']; ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Vat(12%):</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo "PHP " . $receipt['vat']; ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Total Amount Due:</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo "PHP ". $receipt['amount_due']; ?>.00</p>
                        </div>
                    </div>
                    <p>===========================================</p>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Vatable Sales</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $receipt['amount_due']; ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Vat-Exampt</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $receipt['vat_exampt']; ?></p>
                        </div>
                    </div>

                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Discount</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $receipt['discount']; ?></p>
                        </div>
                    </div>
                    <div class="receipt-body-row">
                        <div class="rb-col">
                            <p><strong>Paymode</strong></p>
                        </div>
                        <div class="rb-col">
                            <p><?php echo $receipt['paymode']; ?></p>
                        </div>
                    </div>
                   
                </div>

                <div class="receipt-footer">
                    <p><?php echo $receipt['vendor']?></p>
                    <p>ACCREDITATION: <?php echo $receipt['accreditation']?> </p>
                    <p>Date Issued: <?php echo $receipt['accreditDate']?></p>
                    <p>Valid Until: <?php echo $receipt['validDate']?></p>
                    <p>BIR PTU NO: <?php echo $receipt['serialNo']?></p>
                    <p>PTU DATE ISSUED: <?php echo $receipt['issuedDate']?> </p>
                    <p>THIS SERVES AS AN OFFICIAL INVOICE</p>
                </div>

                <!-- Back to Home Button -->
                <a href="<?php echo base_url('terminal'); ?>" class="btn-home">Back to Home</a>

            </div>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo $billdata['mode']; ?> Payment
            <small>Continue payment with <?php echo $billdata['mode']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="wallet-payment-container">
            <div class="payment-data">
                <div class="payment-header">
                    <p class="payment-title">Payment Amount</p>
                    <input class="payment-amount" value="₱ <?php echo $billdata['amount']; ?>.00" readonly>
                </div>
                <div class="payment-body">
                    <div id="qrcode" class="qrcode"></div>
                </div>
                <div class="payment-footer">
                    <p class="guide-title">Scan to Pay</p>
                    <p><?php echo $billdata['refNumber']; ?></p>
                </div>
                    <form action="<?php echo base_url('terminal/paymentend') ?>" style="text-align: center; margin-top: 10px;" method="GET">
                        <input type="hidden" class="form-control" name="refno" value="<?php echo $billdata['refNumber']; ?>" readonly>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $billdata['parkingId']; ?>" readonly>
                        <input type="hidden" class="form-control" name="gate_id" value="<?php echo $billdata['gateEntry']; ?>" readonly>
                        <input type="hidden" class="form-control" name="access_type" value="<?php echo $billdata['accessType']; ?>" readonly>
                        <input type="hidden" class="form-control" name="parking_code" value="<?php echo $billdata['parkingCode']; ?>" readonly>
                        <input type="hidden" class="form-control" name="unix_entry_time" value="<?php echo $billdata['entryTime']; ?>" readonly>
                        <input type="hidden" class="form-control" name="paytime" value="<?php echo $billdata['paymentTime']; ?>" readonly>
                        <input type="hidden" class="form-control" name="vehicle_class" value="<?php echo $billdata['vehicleClass']; ?>" readonly>
                        <input type="hidden" class="form-control" name="parking_time" value="<?php echo $billdata['parkingTime']; ?>" readonly>
                        <input type="hidden" class="form-control" name="amount_due" value="<?php echo $billdata['amount']; ?>" readonly>
                        <input type="hidden" class="form-control" name="discount_opt" value="<?php echo $billdata['discount']; ?>" readonly>
                        <input type="hidden" class="form-control" name="vehicle_rate" value="<?php echo $billdata['vehicleRate']; ?>" readonly>
                        <input type="hidden" class="form-control" name="status" value="<?php echo $billdata['status']; ?>" readonly>
                        <input type="hidden" class="form-control" name="paymentmode" value="<?php echo $billdata['mode']; ?>" readonly>
                    <button type="submit" class="btn btn-primary">Proceed Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .wallet-payment-container {
        width: 100%;
        height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-data {
        width: 30%;
        padding: 50px;
        background: #fff;
    }

    .payment-title {
        font-size: 1.869rem;
        color: #758694;
    }

    .payment-amount {
        background: none;
        border: none;
        outline: none;
        color: #006fff;
        font-size: 3rem;
        font-weight: 600;
        border-bottom: 1px solid #EAE4DD;
        width: 100%;
    }

    .payment-body {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
    }

    .payment-footer {
        text-align: center;
    }

    .payment-footer .guide-title {
        font-weight: 600;
        font-size: 1.450rem;
    }

    .qrcode {
        display: inline-block;
    }

    .payment-status{
        padding: 10px;
        margin: 10px 0;
    }

    .payment-indicator {
        background: #6EC207;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- Include jQuery -->

<script>
    var qrText = "<?php echo addslashes($billdata['codeUrl']); ?>";
    var refNo = "<?php echo $billdata['refNumber']; ?>";
    var amount = "<?php echo $billdata['amount']; ?>";
    var verifyUrl = "http://192.168.1.150/parkingci/terminal/verifyTransaction";
    var redirectUrl = "http://192.168.1.150/parkingci/terminal";

    new QRCode(document.getElementById("qrcode"), {
        text: qrText,
        width: 256, 
        height: 256,
        colorDark: "#000000",
        colorLight: "#ffffff", 
        correctLevel: QRCode.CorrectLevel.H
    });

    

    

</script>

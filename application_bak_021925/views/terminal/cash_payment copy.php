<div class="content-wrapper">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="col-lg-4">
            <form action="<?php echo base_url('terminal/paymentend') ?>" method="GET" id="paymentForm">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <?php echo $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <h3>Enter Cash Amount</h3>
                        <!-- Hidden fields to pass data -->
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

                        <div class="row">
                            <div class="col-lg-3">
                                <p>Amount to Pay</p>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="amountDue" value="PHP <?php echo $billdata['amount']; ?>" readonly>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="cashOnHand" name="cash" placeholder="Cash on hand value" required autocomplete="off" oninput="checkCashAmount()">
                        <input type="text" class="form-control" id="changeAmount" name="change" placeholder="Change" readonly>
                        <div id="error-message" style="color: red; display: none;">Cash is lesser than the bill amount.</div>
                    </div>
                    <div class="form-row text-center" style="padding: 15px; text-align: end;">
                        <button class="btn btn-success" type="submit" id="submitButton">Payment <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function checkCashAmount() {
    var amountDue = parseFloat(document.getElementById('amountDue').value.replace('PHP ', '').trim());
    var cashOnHand = parseFloat(document.getElementById('cashOnHand').value.trim());
    var changeAmount = document.getElementById('changeAmount');
    var errorMessage = document.getElementById('error-message');
    var submitButton = document.getElementById('submitButton');

    if (isNaN(cashOnHand) || cashOnHand < amountDue) {
        errorMessage.style.display = 'block'; // Show error message
        submitButton.disabled = true;
        changeAmount.value = ''; // Clear the change amount
    } else {
        errorMessage.style.display = 'none';
        submitButton.disabled = false;
        changeAmount.value =  cashOnHand - amountDue; // Calculate and display change
    }
}
</script>

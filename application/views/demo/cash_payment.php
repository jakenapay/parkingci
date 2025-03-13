<section class="content-wrapper">
    <section class="content-header">
        <h1>Parking
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
            <div class="cash-payment-box">
            <?php if ($this->session->flashdata('failed')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('failed'); ?>
                </div>
                <?php endif; ?>
                <h3 class="section-title">Cash Payment</h3>

                <!-- Amount Display -->
                <div class="amount-display">
                    <div class="amount-label">Total Amount Due</div>
                    <div class="amount-value">₱ <?php echo number_format($details['amount_due'], 2, '.', ''); ?></div>

                </div>

                <!-- Cash Input Form -->
                <form action="<?php echo base_url("demo/transactpayment"); ?>" method="POST">
                    <input type="hidden" name="parking_id" class="form-control" value="<?php echo $details['id']; ?>">
                    <input type="hidden" name="gate" class="form-control" value="<?php echo $details['gate']; ?>">
                    <input type="hidden" name="access_type" class="form-control"
                        value="<?php echo $details['access_type']; ?>">
                    <input type="hidden" name="parking_code" class="form-control"
                        value="<?php echo $details['parking_code']; ?>">
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
                    <input type="hidden" name="pictureName" class="form-control"
                        value="<?php echo $details['pictureName']; ?>">
                    <input type="hidden" name="paymode" class="form-control"
                        value="<?php echo $details['paymode']; ?>">
                    <input type="text" name="discount" class="form-control"
                        value="<?php echo $details['discount']; ?>">


                    <input type="text" name="vat_amount" class="form-control"
                        value="<?php echo $details['vat_amount']; ?>">
                    <input type="text" name="discounted" class="form-control"
                        value="<?php echo $details['amount_due']; ?>">
                    <input type="text" name="discounted_amount" class="form-control"
                        value="<?php echo $details['discount_amount']; ?>">
                    <input type="hidden" name="custname" class="form-control" value="<?php echo !empty($details['name']) ? $details['name'] : 'N/A'; ?>">

                    <input type="hidden" name="custaddress" class="form-control" value="<?php echo !empty($details['address']) ? $details['address'] : 'N/A'; ?>">

                    <input type="hidden" name="custtin" class="form-control" value="<?php echo !empty($details['tin']) ? $details['tin'] : 'N/A'; ?>">

                    <input type="hidden" name="custidnumber" class="form-control" value="<?php echo !empty($details['idnumber']) ? $details['idnumber'] : 'N/A'; ?>">
                    <div class="input-group">
                        <label>Quick Amount</label>
                        <div class="shortcut-buttons">
                            <button type="button" class="shortcut-btn">₱ 100</button>
                            <button type="button" class="shortcut-btn">₱ 200</button>
                            <button type="button" class="shortcut-btn">₱ 500</button>
                            <button type="button" class="shortcut-btn">₱ 1000</button>
                            <button type="button" class="shortcut-btn">₱ 1500</button>
                            <button type="button" class="shortcut-btn">₱ 2000</button>
                            <button type="button" class="shortcut-btn">₱ 2500</button>
                            <button type="button" class="shortcut-btn">₱ 3000</button>
                        </div>
                    </div>

                    <!-- <div class="input-group">
                        <label>Cash Received</label>
                        <input type="text" name="cash_receive" placeholder="Enter amount" value="200.00">
                    </div> -->

                    <!-- Change Calculation Display -->
                    <!-- Change Calculation Display -->
                    <div class="change-display">
                        <div class="change-row">
                            <span class="change-label">Amount Due</span>
                            <span class="change-value" style="color: #444;">₱ <?php echo number_format($details['amount_due'], 2, '.', ''); ?></span>
                        </div>
                        <div class="change-row">
                            <span class="change-label">Cash Received</span>
                            <input type="text" class="change-value" name="cash_received" style="color: #444;" placeholder="e.g. 100, 200">
                        </div>
                        <div class="change-row">
                            <span class="change-label">Change</span>
                            <input type="text" class="change-value" name="change_amount" placeholder="e.g. 100, 200" readonly>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="payment-actions">
                        <button type="button" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary">Complete Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .cash-payment-box {
        background: #fff;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .amount-display {
        background: #f8f9fa;
        border: 2px solid #3c8dbc;
        border-radius: 3px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: right;
    }

    .amount-label {
        font-size: 16px;
        color: #666;
        margin-bottom: 5px;
    }

    .amount-value {
        font-size: 32px;
        font-weight: bold;
        color: #3c8dbc;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        display: block;
        margin-bottom: 5px;
        color: #444;
        font-weight: 600;
    }

    .input-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d2d6de;
        border-radius: 3px;
        font-size: 16px;
        text-align: right;
    }

    .input-group input:focus {
        border-color: #3c8dbc;
        outline: none;
    }

    .change-display {
        background: #f4f4f4;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 15px;
        margin-top: 20px;
    }

    .change-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
    }

    .change-row:last-child {
        border-bottom: none;
    }

    .change-label {
        font-weight: 600;
        color: #444;
    }

    .change-value {
        font-size: 18px;
        font-weight: bold;
        color: #00a65a;
    }

    .payment-actions {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 3px;
        border: 1px solid transparent;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-primary {
        background-color: #3c8dbc;
        border-color: #367fa9;
        color: #fff;
    }

    .btn-default {
        background-color: #f4f4f4;
        border-color: #ddd;
        color: #444;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .section-title {
        color: #444;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .shortcut-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Fixed three columns */
        gap: 10px; /* Space between buttons */
        margin: 15px 0; /* Margin around the grid */
    }

    .shortcut-btn {
        background: #fff;
        border: 1px solid #d2d6de;
        border-radius: 3px;
        padding: 8px; /* Padding for buttons */
        text-align: center; /* Center text inside buttons */
        cursor: pointer; /* Cursor change on hover */
        font-size: 14px; /* Font size for button text */
        color: #444; /* Text color */
    }

    .shortcut-btn:hover {
        background: #f4f4f4; /* Background color on hover */
        border-color: #3c8dbc; /* Border color on hover */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shortcutButtons = document.querySelectorAll('.shortcut-btn');
        const cashReceivedInput = document.querySelector('input[name="cash_received"]');
        const changeInput = document.querySelector('input[name="change_amount"]');
        const amountDueValue = Math.round(parseFloat(document.querySelector('.amount-value').innerText.replace('₱ ', '').replace(',', '')));

        shortcutButtons.forEach(button => {
            button.addEventListener('click', function() {
                const amount = Math.round(parseFloat(this.innerText.replace('₱ ', '').replace(',', '')));
                cashReceivedInput.value = amount; // Set cash received without symbol or decimal places
                updateChange();
            });
        });

        function updateChange() {
            const cashReceived = Math.round(parseFloat(cashReceivedInput.value) || 0);

            const change = cashReceived - amountDueValue;

            changeInput.value = change; // Display change without symbol or decimal places
        }

        cashReceivedInput.addEventListener('input', updateChange);
    });
</script>


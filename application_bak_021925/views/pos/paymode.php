<style>
    .payment-box {
        background: #fff;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .payment-option {
        display: none;
    }

    .payment-label {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #e0e0e0;
        border-radius: 3px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
        height: 100%;
    }

    .payment-label:hover {
        border-color: #3c8dbc;
        background: #f8faff;
    }

    .payment-option:checked+.payment-label {
        border-color: #3c8dbc;
        background: #f8faff;
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        margin-right: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f4f4f4;
        border-radius: 3px;
        font-weight: bold;
        font-size: 18px;
        color: #444;
    }

    .payment-details {
        flex: 1;
    }

    .payment-title {
        font-weight: 600;
        color: #444;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .payment-description {
        font-size: 12px;
        color: #777;
    }

    .voucher-label {
        border-style: dashed;
        background: #fff9e6;
    }

    .voucher-label:hover {
        background: #fff3cc;
    }

    .payment-option:checked+.voucher-label {
        background: #fff3cc;
        border-color: #f39c12;
    }

    .voucher-icon {
        background: #fff3cc;
        color: #f39c12;
    }

    .payment-summary {
        background: #f9f9f9;
        border: 1px solid #e0e0e0;
        border-radius: 3px;
        padding: 15px;
        margin-top: 20px;
    }

    .payment-actions {
        margin-top: 20px;
        text-align: right;
    }

    .btn-proceed {
        background-color: #3c8dbc;
        border-color: #367fa9;
        color: #fff;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 3px;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-proceed:hover {
        background-color: #367fa9;
    }

    .section-title {
        color: #444;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 20px;
    }
</style>
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
        <div class="col-md-5">
            <div class="payment-box">
                <h3 class="section-title">Select Payment Method</h3>
                <form action="<?php echo base_url("touchpoint/transactPayment"); ?>" method="POST">
                    <input type="hidden" name="parking_id" class="form-control" value="<?php echo $details['id']; ?>">
                    <input type="hidden" name="gate" class="form-control" value="<?php echo $details['gate']; ?>">
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
                    <input type="hidden" name="pictureName" class="form-control"
                        value="<?php echo $details['pictureName']; ?>">
                    <input type="hidden" name="discount_type" class="form-control"
                        value="<?php echo $details['discountType']; ?>">
                    
                    <div class="payment-options">
                        <div>
                            <input type="radio" name="paymentmode" value="Cash" id="cash" class="payment-option" checked>
                            <label for="cash" class="payment-label">
                                <div class="payment-icon">
                                    ₱
                                </div>
                                <div class="payment-details">
                                    <div class="payment-title">Cash</div>
                                    <div class="payment-description">Pay with cash or at counter</div>
                                </div>
                            </label>
                        </div>

                        <div>
                            <input type="radio" name="paymentmode" value="GCash" id="gcash" class="payment-option">
                            <label for="gcash" class="payment-label">
                                <div class="payment-icon">
                                    G
                                </div>
                                <div class="payment-details">
                                    <div class="payment-title">GCash</div>
                                    <div class="payment-description">Quick and secure payment via GCash</div>
                                </div>
                            </label>
                        </div>

                        <div>
                            <input type="radio" name="paymentmode" value="Paymaya"  id="paymaya" class="payment-option">
                            <label for="paymaya" class="payment-label">
                                <div class="payment-icon">
                                    P
                                </div>
                                <div class="payment-details">
                                    <div class="payment-title">PayMaya</div>
                                    <div class="payment-description">Pay securely using your PayMaya account</div>
                                </div>
                            </label>
                        </div>

                        <div>
                            <input type="radio" name="paymentmode" value="Complimentary" id="voucher" class="payment-option">
                            <label for="voucher" class="payment-label voucher-label">
                                <div class="payment-icon voucher-icon">
                                    V
                                </div>
                                <div class="payment-details">
                                    <div class="payment-title">Complimentary Ticket</div>
                                    <div class="payment-description">Redeem your voucher or promotional ticket</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="payment-actions">
                        <button type="submit" class="btn-proceed">
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
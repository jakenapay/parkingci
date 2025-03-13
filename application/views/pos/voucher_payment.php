<style>
  .complimentary-payment-box {
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
  }

  .voucher-input-section {
    background: #fff9e6;
    border: 2px dashed #f39c12;
    border-radius: 3px;
    padding: 20px;
    margin-bottom: 20px;
  }

  .input-group {
    width: 100%;
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
    padding: 12px;
    border: 1px solid #d2d6de;
    border-radius: 3px;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 2px;
  }

  .input-group input:focus {
    border-color: #f39c12;
    outline: none;
    background: #fff;
  }

  .voucher-info {
    display: none;
    /* Initially hidden until voucher is validated */
    background: #f4f4f4;
    border: 1px solid #ddd;
    border-radius: 3px;
    margin-top: 20px;
    overflow: hidden;
  }

  .voucher-info.active {
    display: block;
  }

  .voucher-header {
    background: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #ddd;
  }

  .voucher-status {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 10px;
  }

  .status-valid {
    background: #dff0d8;
    color: #3c763d;
  }

  .status-invalid {
    background: #f2dede;
    color: #a94442;
  }

  .status-expired {
    background: #fcf8e3;
    color: #8a6d3b;
  }

  .voucher-title {
    font-size: 18px;
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
  }

  .voucher-subtitle {
    color: #666;
    font-size: 14px;
  }

  .voucher-details {
    padding: 15px;
  }

  .detail-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
  }

  .detail-row:last-child {
    border-bottom: none;
  }

  .detail-label {
    color: #666;
    font-size: 14px;
  }

  .detail-value {
    font-weight: 600;
    color: #444;
  }

  .verification-message {
    margin-top: 10px;
    padding: 10px;
    border-radius: 3px;
    font-size: 14px;
  }

  .verification-success {
    background: #dff0d8;
    color: #3c763d;
    border: 1px solid #d6e9c6;
  }

  .verification-error {
    background: #f2dede;
    color: #a94442;
    border: 1px solid #ebccd1;
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

  .btn-verify {
    background-color: #f39c12;
    border-color: #e08e0b;
    color: #fff;
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

  .instructions {
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-left: 4px solid #f39c12;
    color: #666;
    font-size: 14px;
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
      <div class="complimentary-payment-box">
        <h3 class="section-title">Complimentary Ticket Validation</h3>

        <div class="instructions">
          Please enter your voucher code to validate your complimentary ticket. The code can be found on your ticket or
          in your email confirmation.
        </div>

        <!-- Voucher Input Section -->
        <form action="<?php echo base_url("touchpoint/processTransaction"); ?>" method="POST">
          <input type="hidden" name="parking_id" class="form-control" value="<?php echo $details['id']; ?>">
          <input type="hidden" name="gate" class="form-control" value="<?php echo $details['gate']; ?>">
          <input type="hidden" name="access_type" class="form-control" value="<?php echo $details['access_type']; ?>">
          <input type="hidden" name="parking_code" class="form-control" value="<?php echo $details['parking_code']; ?>">
          <input type="hidden" name="parkingStay" class="form-control" value="<?php echo $details['parkingStay']; ?>">
          <input type="hidden" name="entryTime" class="form-control" value="<?php echo $details['entryTime']; ?>">
          <input type="hidden" name="paymentTime" class="form-control" value="<?php echo $details['paymentTime']; ?>">
          <input type="hidden" name="parkingTime" class="form-control" value="<?php echo $details['parkingTime']; ?>">
          <input type="hidden" name="vehicleClass" class="form-control" value="<?php echo $details['vehicleClass']; ?>">
          <input type="hidden" name="parking_status" class="form-control"
            value="<?php echo $details['parking_status']; ?>">
          <input type="hidden" name="parking_amount" class="form-control"
            value="<?php echo $details['parking_amount']; ?>">
          <input type="hidden" name="pictureName" class="form-control" value="<?php echo $details['pictureName']; ?>">
          <input type="hidden" name="picturePath" class="form-control" value="<?php echo $details['picturePath']; ?>">
          <input type="hidden" name="pictureName" class="form-control" value="<?php echo $details['pictureName']; ?>">
          <input type="hidden" name="discount_type" class="form-control"
            value="<?php echo $details['discountType']; ?>">
          <input type="hidden" name="total_sales" class="form-control" value="<?php echo $details['totalSales']; ?>">
          <input type="hidden" name="paymentmode" class="form-control" value="<?php echo $details['paymode']; ?>">
          <div class="voucher-input-section">
            <div class="input-group">
              <label>Enter Voucher Code</label>
              <input type="text" name="compcode" placeholder="e.g., COMP-2024-XXXX">
            </div>
            <a href="<?php echo base_url("touchpoint/payments") ?>" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-verify">Verify Voucher</button>
          </div>

        </form>
        <!-- Voucher Information (Initially Hidden) -->
        <!-- <div class="voucher-info active">
      <div class="voucher-header">
        <span class="voucher-status status-valid">VALID</span>
        <div class="voucher-title">Complimentary Parking Pass</div>
        <div class="voucher-subtitle">Single-use parking voucher</div>
      </div> -->

        <!-- <div class="voucher-details">
        <div class="detail-row">
          <span class="detail-label">Event Name</span>
          <span class="detail-value">COMP-2024-1234</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Valid Until</span>
          <span class="detail-value">December 31, 2024</span>
        </div>
      </div> -->
      </div>

      <!-- Verification Message -->
      <!-- <div class="verification-message verification-success">
      ✓ Voucher successfully validated. You can proceed with the complimentary parking.
    </div> -->

      <!-- Action Buttons -->
      <!-- <div class="payment-actions">
      <button type="button" class="btn btn-default">Cancel</button>
      <button type="submit" class="btn btn-primary">Apply Voucher</button>
    </div> -->
    </div>
  </div>
  </div>

</section>
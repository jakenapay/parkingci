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
        <input type="hidden" name="parking_status" class="form-control" value="<?php echo $details['parking_status']; ?>">
        <input type="hidden" name="parking_amount" class="form-control" value="<?php echo $details['parking_amount']; ?>">
        <input type="hidden" name="pictureName" class="form-control" value="<?php echo $details['pictureName']; ?>">
        <input type="hidden" name="picturePath" class="form-control" value="<?php echo $details['picturePath']; ?>">
        <input type="hidden" name="pictureName" class="form-control" value="<?php echo $details['pictureName']; ?>">
        <input type="hidden" name="discount_type" class="form-control" value="<?php echo $details['discountType']; ?>">
        <!-- <input type="hidden" name="total_sales" class="form-control" value="<?php echo $details['amountDue']; ?>"> -->
        <!-- <input type="hidden" name="paymentmode" class="form-control" value="<?php echo $details['paymode']; ?>"> -->
        <input type="hidden" name="qrphref" class="form-control" value="<?php echo $details['refnumber']; ?>">

        <input type="hidden" name="discount_type" class="form-control" value="<?php echo $details['discountType']; ?>">
        <input type="hidden" name="discountPercentage" class="form-control" value="<?php echo $details['discountPercentage']; ?>">
        <input type="hidden" name="discountAmount" class="form-control" value="<?php echo $details['discountAmount']; ?>">
        <input type="hidden" name="vatableSale" class="form-control" value="<?php echo $details['vatableSale']; ?>">
        <input type="hidden" name="vatExempt" class="form-control" value="<?php echo $details['vatExempt']; ?>">
        <input type="hidden" name="zeroRatedSales" class="form-control" value="<?php echo $details['zeroRatedSales']; ?>">
        <input type="hidden" name="totalVat" class="form-control" value="<?php echo $details['totalVat']; ?>">
        <input type="hidden" name="paymentmode" class="form-control" value="<?php echo $details['paymode']; ?>">
        <input type="hidden" name="salesamount" class="form-control" value="<?php echo number_format($details['totalSales'], 2); ?>">
        <input type="hidden" name="origAmount" class="form-control" value="<?php echo $details['originalAmount']; ?>">
        <input type="hidden" name="netOfDisc" class="form-control" value="<?php echo $details['netOfDisc']; ?>">

        <input type="hidden" name="netOfVat" class="form-control" value="<?php echo $details['netOfVat']; ?>">
        <input type="hidden" name="lessVat" class="form-control" value="<?php echo $details['lessVat']; ?>">
        <input type="hidden" name="addNVat" class="form-control" value="<?php echo $details['addNVat']; ?>">

        <div class="digital-payment-box">
          <!-- Payment Method Logo -->
          <div class="payment-logo">GCash/PayMaya</div>

          <!-- Amount Display -->
          <div class="amount-display">
            <div class="amount-label">Total Amount Due</div>
            <div class="amount-value">₱ <?php echo number_format($details['totalSales'], 2); ?></div>
          </div>

          <!-- Payment Steps -->
          <div class="payment-steps">
            <div class="step">
              <div class="step-number">1</div>
              <div class="step-content">
                <div class="step-title">Scan QR Code</div>
                <div class="step-description">Use your GCash/PayMaya app to scan the QR code below</div>
                <div class="qr-container">
                  <div id="qrcode" class="qrcode"></div>
                  <div class="qr-note">Please ensure your app is updated to the latest version</div>
                </div>
              </div>
            </div>

          </div>

          <!-- Action Buttons -->
          <div class="payment-actions">
            <button type="button" class="btn btn-default" onclick="history.back();">Cancel</button>
            <button type="submit" class="btn btn-primary">Verify Payment</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<style>
  .digital-payment-box {
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

  .payment-steps {
    margin: 20px 0;
  }

  .step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f4f4f4;
  }

  .step-number {
    width: 24px;
    height: 24px;
    background: #3c8dbc;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .step-content {
    flex: 1;
  }

  .step-title {
    font-weight: 600;
    color: #444;
    margin-bottom: 5px;
  }

  .step-description {
    color: #666;
    font-size: 14px;
    margin-bottom: 10px;
  }

  .qr-container {
    background: #f4f4f4;
    padding: 20px;
    border-radius: 3px;
    text-align: center;
    /* Center text */
    margin: 15px 0;
    display: flex;
    /* Use flexbox to center */
    flex-direction: column;
    /* Arrange children in a column */
    align-items: center;
    /* Center items horizontally */
    justify-content: center;
    /* Center items vertically */
  }

  .qrcode {
    width: 256px;
    /* Set a fixed width */
    height: 256px;
    /* Set a fixed height */
    margin: 0 auto;
    /* Center the QR code */
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .qr-note {
    margin-top: 10px;
    font-size: 13px;
    color: #666;
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
    font-size: 14px;
  }

  .input-group input:focus {
    border-color: #3c8dbc;
    outline: none;
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

  .merchant-details {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 15px;
    margin: 15px 0;
  }

  .merchant-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
  }

  .merchant-label {
    color: #666;
  }

  .merchant-value {
    font-weight: 600;
    color: #444;
  }

  .payment-logo {
    width: 100px;
    height: 40px;
    background: #f4f4f4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #666;
    margin-bottom: 20px;
  }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- <script>
  $(document).ready(function () {
    var qrText = "<?php echo $details['codeUrl']; ?>"; // Properly format PHP output as a JavaScript string

    new QRCode(document.getElementById("qrcode"), {
      text: qrText,
      width: 256,
      height: 256,
      colorDark: "#000000",
      colorLight: "#ffffff",
      correctLevel: QRCode.CorrectLevel.H
    });
  });
</script> -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    var qrImageUrl = "<?php echo isset($details['codeImgUrl']) ? $details['codeImgUrl'] : ''; ?>"; // Ensure variable exists

    // Check if URL is valid and not empty
    if (qrImageUrl.trim() !== "") {
      $("#qrcode").html(`
        <div style="position: relative; width: 256px; height: 256px;">
          <img src="<?php echo base_url('assets/images/QRPH-Logo.png'); ?>" 
               alt="QRPH Logo" 
               style="position: absolute; 
                      left: 50%; 
                      top: 50%; 
                      transform: translate(-50%, -50%); 
                      z-index: 2; 
                      width: 50px;">
          <img src="${qrImageUrl}" 
               alt="QR Code" 
               width="256" 
               height="256" 
               style="position: absolute; 
                      top: 0; 
                      left: 0; 
                      z-index: 1;"
               onerror="this.onerror=null; this.src='fallback.png';">
        </div>
      `);
    } else {
      $("#qrcode").html('<p style="color: red;">QR Code not available.</p>');
    }
  });
</script>
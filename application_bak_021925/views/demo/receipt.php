<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: monospace;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      background: #f0f0f0;
    }
    
    .receipt {
      background: white;
      padding: 2rem;
      width: 350px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .header {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    
    .company-name {
      font-size: 1.1rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    
    .address {
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
    }
    
    .training-mode {
      margin: 1rem 0;
      font-weight: bold;
    }
    
    .details {
      margin-bottom: 1rem;
    }
    
    .row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.3rem;
      font-size: 0.9rem;
    }
    
    .divider {
      border-top: 1px dashed #ccc;
      margin: 0.8rem 0;
    }
    
    .total {
      font-weight: bold;
    }
    
    .footer {
      text-align: left;
      font-size: 0.8rem;
      margin-top: 1.5rem;
    }
    
    .info-block {
      margin-bottom: 0.5rem;
    }
    
    .empty-field {
      border-bottom: 1px solid #ccc;
      margin: 0.3rem 0;
      height: 1rem;
    }
  </style>
</head>
<body>
  <div class="receipt">
    <div class="header">
      <div class="company-name">PICC</div>
      <div class="address">Philippine International Convention Center</div>
      <div class="address">PICC Complex 1307 Pasay City,</div>
      <div class="address">Metro Manila, Philippines</div>
      <div class="address">VAT REG TIN: 000-000-000-00000</div>
      <div class="address">MIN: 1234567891</div>
      <div class="address">(+63)8396594578</div>
    </div>
    
    <div class="training-mode text-center">TRAINING MODE</div>
    
    <div class="details">
      <div class="row">
        <span>Date and Time:</span>
        <span>11-06-2024 08:28:15 AM</span>
      </div>
      <div class="row">
        <span>S/I:</span>
        <span>1</span>
      </div>
      <div class="row">
        <span>Plate Number:</span>
        <span>ABC1234</span>
      </div>
      <div class="row">
        <span>Vehicle:</span>
        <span>Car</span>
      </div>
    </div>
    
    <div class="row">
      <span>Sales Invoice</span>
    </div>
    
    <div class="row">
      <span>Cashier:</span>
      <span>Judy</span>
    </div>
    <div class="row">
      <span>Terminal:</span>
      <span>terminal1</span>
    </div>
    
    <div class="divider"></div>
    
    <div class="details">
      <div class="row">
        <span>Gate In:</span>
        <span>2024-11-06 02:12:52 AM</span>
      </div>
      <div class="row">
        <span>Bill Time:</span>
        <span>2024-11-06 08:13:38 AM</span>
      </div>
      <div class="row">
        <span>Parking Time:</span>
        <span>4 Hour 0 Min</span>
      </div>
      <div class="row">
        <span>Total Sales:</span>
        <span>38.40</span>
      </div>
      <div class="row">
        <span>Vat(12%):</span>
        <span>4.11</span>
      </div>
      <div class="row total">
        <span>Total Amount Due:</span>
        <span>38.40</span>
      </div>
    </div>
    
    <div class="divider"></div>
    
    <div class="details">
      <div class="row">
        <span>Vatable Sales:</span>
        <span>42.86</span>
      </div>
      <div class="row">
        <span>Non-Vat Sales:</span>
        <span>48.00</span>
      </div>
      <div class="row">
        <span>Vat-Exempt:</span>
        <span>5.14</span>
      </div>
      <div class="row">
        <span>Discount:</span>
        <span>12.00</span>
      </div>
      <div class="row">
        <span>Payment Mode:</span>
        <span>Cash</span>
      </div>
    </div>
    
    <div class="info-block">
      <div>Name:</div>
      <div class="empty-field"></div>
      <div>Address:</div>
      <div class="empty-field"></div>
      <div>TIN:</div>
      <div class="empty-field"></div>
      <div>ID Number:</div>
      <div class="empty-field"></div>
    </div>
    
    <div class="footer">
      <p>BIR PTU NO: AB1234567-12345678</p>
      <p>PTU DATE ISSUED: 11/24/2020</p>
      <p>THIS SALES INVOICE BE VALID FOR FIVE(5) YEARS</p>
      <p>FROM THE DATE OF PERMIT TO USE</p>
    </div>
  </div>
</body>
</html>
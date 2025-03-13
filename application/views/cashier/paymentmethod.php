<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo base_url('assets/cashier_assets/pm_components/paymentmethod.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/cashier_assets/pm_components/e-payment.css') ?>">
    </head>
    <body>
      <div class="container">
        <div class="inner">
          <div class="title">
              <h1>Choose Payment Method</h1>
              <p>click to choose</p>
              <h2>Amount to pay: <span style="color: green; text-decoration: underline;"><?php echo $billAmount?> PHP</span></h2>
              <input type="number" id="bill" value="<?php echo $billAmount ?>" hidden disabled>
          </div>
          <div class="category">
            
                <button onclick=gcashBtn() class="gcashMethod" id="buttongcash">
                  <div class="imgName">
                      <div class="imgContainer gcash">
                        <img src="https://www.swirlingovercoffee.com/wp-content/uploads/2022/05/GCASH-Logo-800x675.jpg" alt="">
                      </div>
                      <span class="name"></span>
                  </div>
                </button>
                <button onclick=mayaBtn() class="mayaMethod" id="buttonmaya">
                  <div class="imgName">
                      <div class="imgContainer maya">
                        <img src="https://loadcentral.com.ph/wp-content/uploads/2020/07/Maya-Logo.jpg" alt="">
                      </div>
                      <span class="name"></span>
                  </div>
                </button>
                <button class="cashMethod" onclick="window.location.href='<?php echo base_url("cashier/receipt")?>'">
                  <div class="imgName">
                      <div class="imgContainer cash">
                        <img src="https://png.pngtree.com/png-vector/20191028/ourmid/pngtree-pack-cash-icon-cartoon-style-png-image_1893446.jpg" alt="">
                      </div>
                      <span class="name">Cash</span>
                  </div>
                </button>
                <button class="backMethod" onclick="window.location.href='<?php echo base_url("dashboard")?>'">
                  <div class="imgName">
                      <div class="imgContainer back">
                        <img src="https://www.nicepng.com/png/full/16-163125_back-arrow-icon-creative-commons-logo.png" alt="">
                      </div>
                      <span class="name">Back</span>
                  </div>
                </button>
          </div>
        </div>
        <div class="gcash-popup">
            <div class="gcash-popup-content">
                <div class="qrcode">
                  <div id="gcashqrcode">
                    <h1 class="scan">SCAN TO PAY HERE</h1>
                    <p>PHILIPPINE INTERNATIONAL CONVENTION CENTER PARKING</p>
                  </div>
                </div>
                <a href="#" class="btn-paid" id="gcashpaid">Paid</a>
                <a href="#" class="btn-close" id="gcashclose">Cancel</a>
            </div>
        </div>  
        <div class="maya-popup">
            <div class="maya-popup-content">
                <div class="qrcode" >
                  <div id="mayaqrcode"> 
                    <h1 class="scan">SCAN TO PAY HERE</h1>
                    <h4 class="name">PHILIPPINE INTERNATIONAL CONVENTION CENTER PARKING</h4>
                </div>
                </div>
                <a href="#" class="btn-paid" id="mayapaid">Paid</a>
                <a href="#" class="btn-close" id="mayaclose">Cancel</a>
            </div>  
        </div>
      </div>
    </body> 
  <script src="<?php echo base_url('assets/cashier_assets/pm_components/maya.js') ?>"></script>
  <script src="<?php echo base_url('assets/cashier_assets/pm_components/gcash.js') ?>"></script>
  <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
  <script src="<?php echo base_url('assets/cashier_assets/pm_components/e-payment.js') ?>"></script>
</html>
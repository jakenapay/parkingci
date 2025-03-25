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
    <div class="cash-register-container">
        <form action="<?php echo base_url("touchpoint/processTransaction") ?>" method="POST">
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
            <input type="hidden" name="discountPercentage" class="form-control" value="<?php echo $details['discountPercentage']; ?>">
            <input type="hidden" name="discountAmount" class="form-control" value="<?php echo $details['discountAmount']; ?>">
            <input type="hidden" name="vatableSale" class="form-control" value="<?php echo $details['vatableSale']; ?>">
            <input type="hidden" name="vatExempt" class="form-control" value="<?php echo $details['vatExempt']; ?>">
            <input type="hidden" name="zeroRatedSales" class="form-control" value="<?php echo $details['zeroRatedSales']; ?>">
            <input type="hidden" name="totalVat" class="form-control" value="<?php echo $details['totalVat']; ?>">
            <input type="hidden" name="paymentmode" class="form-control" value="<?php echo $details['paymode']; ?>">
            <input type="hidden" name="salesamount" class="form-control" value="<?php echo $details['totalSales']; ?>">
            <input type="hidden" name="origAmount" class="form-control" value="<?php echo $details['originalAmount']; ?>">

            <input type="hidden" name="netOfDisc" class="form-control" value="<?php echo $details['netOfDisc']; ?>">
            <input type="hidden" name="netOfVat" class="form-control" value="<?php echo $details['netOfVat']; ?>">
            <input type="hidden" name="lessVat" class="form-control" value="<?php echo $details['lessVat']; ?>">
            <input type="hidden" name="addNVat" class="form-control" value="<?php echo $details['addNVat']; ?>">
            

            
            <div class="register-grid">
                <div class="left-panel">
                    <div class="amount-section">
                        <div class="amount-display">
                            <label>Total Amount Due (₱)</label>
                            <input type="text" id="total" name ="salesDue" value="<?php echo number_format($details['totalSales'], 2); ?>" readonly>
                        </div>
                        <div class="amount-display">
                            <label>Cash Balance (₱)</label>
                            <input type="text" id="remainingBalance" name="remainingBalance" value="<?php echo number_format($details['remaining'], 2); ?>" readonly>
                        </div>
                        <div class="amount-display">
                            <label>Cash Received (₱)</label>
                            <input type="text" name="cash_received" id="received" placeholder="0">
                        </div>

                        <div class="change-display">
                            <label>Change Due (₱)</label>
                            <input type="text" name="change_due" class="change-amount" placeholder="0" readonly>
                            <div id="cash-drawer-balance" class="cash-drawer-balance" ></div>
                            <div id="insufficient-cash" style="color: red; display: none;">Not enough cash balance remaining</div>
                        </div>
                    </div>

                    <div class="payment-summary">
                        <h4>Payment Summary</h4>
                        <div class="summary-row">
                            <span>Parking Duration</span>
                            <span><?php echo $details['parkingTime']; ?></span>
                        </div>
                        
                        <?php                              
                            if ($details['discountPercentage']){ ?>
                                <div class="summary-row">
                                    <span>Original Amount</span>
                                    <span><?php echo number_format($details['amountDue'],2) ?> </span>
                                </div>
                                <div class="summary-row">    
                                    <span>Discount Rate</span>
                                    <span><?php echo number_format($details['discountPercentage']*100,0) ."%  (" . $details['discountType'] .")"  ?> </span>
                                </div>
                                <div class="summary-row">        
                                    <span>Discount Amount</span>
                                    <span><?php echo number_format($details['DiscountedAmountDue'],2) ?> </span>
                                </div>
                                <div class="summary-row">    
                                    <span>VAT Exempt</span>
                                    <span><?php echo number_format($details['vatExempt'],2) ?> </span>
                                </div>
                                
                          <?php }else{ ?>
                            <div class="summary-row">
                                <span>No Discount</span>
                                <span><?php echo "No Discount";  ?> </span>
                            </div>
                        <?php     
                        }  ?>
                        <div class="summary-row">
                            <span>Total Amount</span>
                            <span><?php echo number_format($details['totalSales'], 2); ?></span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn-process">Process Payment</button>
                        <button class="btn-cancel">Cancel</button>
                    </div>
                </div>

                <div class="right-panel">
                    <div class="quick-amounts">
                        <button class="quick-amount-btn">$5</button>
                        <button class="quick-amount-btn">$10</button>
                        <button class="quick-amount-btn">$20</button>
                        <button class="quick-amount-btn">$50</button>
                        <button class="quick-amount-btn">$100</button>
                    </div>

                    <div class="numpad">
                        <button class="num-btn">1</button>
                        <button class="num-btn">2</button>
                        <button class="num-btn">3</button>
                        <button class="num-btn">4</button>
                        <button class="num-btn">5</button>
                        <button class="num-btn">6</button>
                        <button class="num-btn">7</button>
                        <button class="num-btn">8</button>
                        <button class="num-btn">9</button>
                        <button class="num-btn">.</button>
                        <button class="num-btn">0</button>
                        <button class="num-btn clear-btn">C</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<style>
    <style>
.cash-register-container {
    background: #fff;
    padding: 20px;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.register-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

.amount-section {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 3px;
    border: 1px solid #f4f4f4;
}

.amount-display {
    margin-bottom: 15px;
}

.amount-display label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.amount-display input {
    width: 100%;
    padding: 10px;
    font-size: 24px;
    text-align: right;
    border: 1px solid #ddd;
    border-radius: 3px;
    background: #fff;
}

.change-display {
    background: #3c8dbc;
    padding: 15px;
    border-radius: 3px;
    color: white;
}
.cash-drawer-balance {
    font-size: 16px;
    margin-top: 5px;
    font-weight: bold;
    color: #f39c12;
}
.cash-drawer-warning {
    color: #dd4b39; /* Red for insufficient funds warning */
}
.change-display label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.change-amount {
    font-size: 32px;
    text-align: right;
    font-weight: bold;
    width: 100%;
    padding: 10px;
    border: none;
    background: #3c8dbc;
    color: white;
}

.quick-amounts {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 15px;
}

.quick-amount-btn {
    background: #00a65a;
    border: none;
    padding: 10px;
    border-radius: 3px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    transition: background 0.3s;
}

.quick-amount-btn:hover {
    background: #008d4c;
}

.numpad {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.num-btn {
    background: #f4f4f4;
    border: none;
    padding: 15px;
    border-radius: 3px;
    font-size: 20px;
    cursor: pointer;
    transition: background 0.3s;
}

.num-btn:hover {
    background: #e7e7e7;
}

.clear-btn {
    background: #dd4b39;
    color: white;
}

.clear-btn:hover {
    background: #d73925;
}

.payment-summary {
    margin-top: 20px;
    padding: 15px;
    background: #f9f9f9;
    border: 1px solid #f4f4f4;
    border-radius: 3px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 5px 0;
    border-bottom: 1px solid #ddd;
}

.summary-row:last-child {
    border-bottom: none;
}

.action-buttons {
    margin-top: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.btn-process {
    background: #00a65a;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.btn-process:hover {
    background: #008d4c;
}

.btn-cancel {
    background: #dd4b39;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.btn-cancel:hover {
    background: #d73925;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const received = document.getElementById('received');
    const total = document.getElementById('total');
    const changeAmount = document.querySelector('.change-amount');
    const numButtons = document.querySelectorAll('.num-btn');
    const quickAmountButtons = document.querySelectorAll('.quick-amount-btn');
    const form = document.querySelector('form');
    const insufficientCashMessage = document.getElementById('insufficient-cash');
    const remainingBalance = parseFloat(document.getElementById('remainingBalance').textContent || 0);
    const cashDrawerBalanceElement = document.getElementById('remainingBalance');
   
    let currentInput = '';

    // Function to format number to 2 decimal places
    function formatAmount(amount) {
        return parseFloat(amount).toFixed(2);
    }


    // Function to calculate change and check for sufficient cash balance
    function calculateChange() {
        const totalAmount = parseFloat(total.value.replace(/,/g, ''));
        const receivedAmount = parseFloat(received.value) || 0;
        const change = receivedAmount - totalAmount;
        changeAmount.value = formatAmount(Math.max(0, change));
        // Check if the change amount exceeds the remaining cash drawer balance
        const cashDrawerBalance = parseFloat(cashDrawerBalanceElement.value);
        
        console.log(changeAmount.value );
        console.log(cashDrawerBalanceElement.value);
        console.log(cashDrawerBalance);
        
        if (change > cashDrawerBalanceElement.value) {
            insufficientCashMessage.style.display = 'block';
        } else {
            insufficientCashMessage.style.display = 'none';
        }
    }

    // Handle numeric button clicks
    numButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent form submission
            const value = button.textContent;

            if (value === 'C') {
                // Clear button
                currentInput = '';
                received.value = '0.00';
                changeAmount.value = '0.00';
            } else {
                // Handle numeric input and decimal point
                if (value === '.' && currentInput.includes('.')) {
                    return; // Prevent multiple decimal points
                }
                
                currentInput += value;
                
                // Format the input as currency
                const numericValue = parseFloat(currentInput) || 0;
                received.value = formatAmount(numericValue);
            }
            calculateChange();
        });
    });

    // Handle quick amount buttons
    quickAmountButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent form submission
            const amount = parseFloat(button.textContent.replace('₱', ''));
            currentInput = amount.toString();
            received.value = formatAmount(amount);
            calculateChange();
        });
    });

    // Update quick amount buttons to use PHP currency symbol
    quickAmountButtons.forEach(button => {
        const amount = button.textContent.replace('$', '');
        button.textContent = '₱' + amount;
    });

    received.addEventListener('input', () => {
        // Recalculate change whenever the received amount changes
        calculateChange();
    });

    form.addEventListener('submit', function(e) {
        //const totalAmount = parseFloat(total.value.replace(/,/g, ''));
        const totalAmount = Math.floor(parseFloat(total.value.replace(/,/g, '')));
        const receivedAmount = parseFloat(received.value) || 0;
        const change = receivedAmount - totalAmount;
        
        console.log(totalAmount);
        console.log(receivedAmount);
        console.log(change);

        if (change < 0) {
            e.preventDefault();
            alert('Insufficient payment amount!');
            return false;
        }
        
        if (change > cashDrawerBalanceElement.value) {
            e.preventDefault();
            alert('Insufficient cash in the drawer!');
            return false;
        }
    });

    const cancelBtn = document.querySelector('.btn-cancel');
    cancelBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (confirm('Are you sure you want to cancel this transaction?')) {
            window.location.href = '<?= base_url("touchpoint/payments") ?>';
        }
    });
});
</script>

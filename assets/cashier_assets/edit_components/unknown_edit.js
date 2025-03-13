  // Create an initiated variable
  var billAmount = 0;

  // Store the original bill amount
  let originalBillAmount;

  // Function to enable or disable the discount option based on the bill amount
  function updateDiscountOption() {
    const discountSelect = document.getElementById("discount");
    const billInput = document.getElementById("bill");
    const hasBillAmount = parseFloat(billInput.value) > 0;

    // Enable or disable the discount select based on the bill amount
    discountSelect.disabled = !hasBillAmount;
  }

  // Function to calculate and update the bill amount based on the selected discount
  function applyDiscount() {
    const discountOption = discountSelect.value;
    const billInput = document.getElementById("bill");
    billAmount = parseFloat(billInput.value)

    if (originalBillAmount === undefined) {
      // Store the original bill amount if not already stored
      originalBillAmount = parseFloat(billInput.value);
      billAmount = parseFloat(billInput.value)
    }

    console.log("This is the discount: "+discountOption)

    if (discountOption === "pwd") {
      // Apply 20% discount for Senior or PWD
      billInput.value = (originalBillAmount * 0.8).toFixed(2); // 20% discount (100% - 20%)
      billAmount = (originalBillAmount * 0.8).toFixed(2);
    } else if (discountOption === "pasay") {
      // Apply 5% discount for Pasy resident
      billInput.value = (originalBillAmount * 0.95).toFixed(2); // 5% discount (100% - 5%)
      billAmount = (originalBillAmount * 0.95).toFixed(2);
    } else if (discountOption === "tenants") {
      // Apply 10% discount for Tenant
      billInput.value = (originalBillAmount * 0.9).toFixed(2); // 10% discount (100% - 10%)
      billAmount = (originalBillAmount * 0.9).toFixed(2);
    } else if (discountOption === "") {
      billInput.value = originalBillAmount;
      billAmount = originalBillAmount;
    } else {
      // No discount option selected, revert to the original amount
      if (originalBillAmount !== undefined) {
        billInput.value = originalBillAmount.toFixed(2);
      }
    }
  }

  // Add an event listener to the Bill amount input to enable or disable the discount option
  const billInput = document.getElementById("bill");
  billInput.addEventListener("input", updateDiscountOption);
  billInput.addEventListener("change", (target) => {
    billAmount = target.target.value
  })

  // Add an event listener to the Discount Option select input
  const discountSelect = document.getElementById("discount");
  discountSelect.addEventListener("change", applyDiscount);

  // Initially, disable the discount option since there's no bill amount entered
  updateDiscountOption();

  // Get input box reference
  const amountReceive = document.getElementById("bill")
  console.log(amountReceive.value);

  if(billAmount < 0){
    billAmount = 0;
  }

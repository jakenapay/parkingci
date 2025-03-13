var billAmount = 0;
var qrCodeGenerated = false;

document.addEventListener("DOMContentLoaded", function(){
    const billReceiver = document.getElementById("bill")
    console.log(billReceiver.value)
    billAmount = billReceiver.value;
    
    // Reset the qrCodeGenerated flag when the page loads
    qrCodeGenerated = false;
})

const gcashBtn = async () => {
    if (qrCodeGenerated) {
        return;
    }

    qrCodeGenerated = true;

    console.log(billAmount);
    var intentResponse = "";
    var methodResponse = "";

    const intent = {
        method: 'POST',
        headers: {
            accept: 'application/json',
            'content-type': 'application/json',
            authorization: 'Basic cGtfdGVzdF9tU3dFUXdmZkpibWNacjhiTG9RQ2tVVVM6'
        },
        body: JSON.stringify({
            data: {
                attributes: {
                    amount: (billAmount * 100),
                    payment_method_allowed: ['gcash', 'paymaya'],
                    payment_method_options: { card: { request_three_d_secure: 'any' } },
                    currency: 'PHP',
                    capture_type: 'automatic'
                }
            }
        })
    };

    await fetch('https://api.paymongo.com/v1/payment_intents', intent)
        .then(response => response.json())
        .then(response => intentResponse = response.data.id)
        .catch(err => console.error(err));

    const paymayaMethod = {
        method: 'POST',
        headers: {
            accept: 'application/json',
            'Content-Type': 'application/json',
            authorization: 'Basic cGtfdGVzdF9tU3dFUXdmZkpibWNacjhiTG9RQ2tVVVM6'
        },
        body: JSON.stringify({ data: { attributes: { type: 'gcash' } } })
    };

    await fetch('https://api.paymongo.com/v1/payment_methods', paymayaMethod)
        .then(response => response.json())
        .then(response => methodResponse = response.data.id)
        .catch(err => console.error(err));

    const attach = {
        method: 'POST',
        headers: {
            accept: 'application/json',
            'content-type': 'application/json',
            authorization: 'Basic c2tfdGVzdF9FRXdZaWhySjFlNWdHZGRDWUFXZXJFWVU6'
        },
        body: JSON.stringify({
            data: {
                attributes: {
                    payment_method: methodResponse,
                    return_url: 'http://localhost/parkingci/dashboard'
                }
            }
        })
    };

    await fetch(`https://api.paymongo.com/v1/payment_intents/${intentResponse}/attach`, attach)
        .then(response => response.json())
        .then(response => {
            // Assuming responseURL contains the URL you want to generate a QR code for
            const responseURL = response.data.attributes.next_action.redirect.url;

            // Create a new QR Code instance
            const qrcode = new QRCode(document.getElementById("gcashqrcode"), {
                text: responseURL,
                
            });

            // Display the QR code on your webpage
            qrcode.makeCode(responseURL);
        })
        .catch(err => console.error(err));
}

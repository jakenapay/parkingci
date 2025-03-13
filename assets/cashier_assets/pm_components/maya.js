var billAmount = 0;
var mayaQrCodeGenerated = false; // Flag for Maya QR code

document.addEventListener("DOMContentLoaded", function(){
    const billReceiver = document.getElementById("bill")
    console.log(billReceiver.value)
    billAmount = billReceiver.value;
})

// Maya Payment Method
const mayaBtn = async () => {
    if (mayaQrCodeGenerated) {
        return;
    }

    mayaQrCodeGenerated = true;
    
    console.log(billAmount)
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
                    payment_method_options: {card: {request_three_d_secure: 'any'}},
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
        body: JSON.stringify({data: {attributes: {type: 'paymaya'}}})
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

    fetch(`https://api.paymongo.com/v1/payment_intents/${intentResponse}/attach`, attach)
    .then(response => response.json())
    .then(response =>  {
                const responseURL = response.data.attributes.next_action.redirect.url;

                // Create a new QR Code instance for Maya
                const qrcode = new QRCode(document.getElementById("mayaqrcode"), {
                    text: responseURL,
                    
                });

                // Display the QR code on your webpage for Maya
                qrcode.makeCode(responseURL);
            })
            .catch(err => console.error(err));
}

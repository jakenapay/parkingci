<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Success Payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="success-container" style="text-align: center; padding: 20px;">
            <div class="icon-box" style="font-size: 80px; color: #4caf50; margin-bottom: 20px;">
                <i class="fa fa-check-circle"></i>
            </div>
            <h2 style="color: #4caf50; margin-bottom: 10px;">Payment Successful!</h2>
            <p style="font-size: 18px; margin-bottom: 20px; color: #555;">
                Thank you for your payment. The transaction was completed successfully.
            </p>

            <div style="margin-top: 30px;">
                <a href="<?php echo base_url('touchpoint'); ?>" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 16px;">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</section>

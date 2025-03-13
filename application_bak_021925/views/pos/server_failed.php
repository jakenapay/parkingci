<style>

    .page_container{
        width: 100%;
        height: calc(100vh - 200px);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .alert-box {
        width: 450px;
        background-color: #ffdddd;
        color: #d9534f;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
        text-align: center;
    }

    .alert-box h3 {
        margin: 0 0 10px;
        font-size: 18px;
    }

    .alert-box p {
        margin: 0;
        font-size: 14px;
    }
</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Failed Payment</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                Cashier: John Doe
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="page_container">
            <div class="alert-box">
                <h1>Payment Failed</h1>
                <p>Please check your server connection and try again.</p>
                <br>
                <a href="<?php echo base_url('touchpoint/payments'); ?>" class="btn btn-danger">Try Again</a>
            </div>
        </div>
    </div>
</section>

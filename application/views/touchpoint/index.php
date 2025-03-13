<style>
    .low-balance-indicator {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1; 
        padding: 5px 10px;
        font-size: 12px; 
    }

    .info-box {
        position: relative;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard
            <small>Manage dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <h3 class="terminal-name text-center">Touchpoint POS System 1.0</h3>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Cashier Balance</span>
                        <span class="info-box-number">Opening Balance: ₱<?php echo $cashier_opening; ?></span>
                        <span class="info-box-number">Remaining Balance: ₱<?php echo $cashier_remaining; ?></span>

                        <?php if ($cashier_remaining < 500): ?>
                        <span class="label label-warning low-balance-indicator"><i class="fa fa-exclamation-triangle"></i> Low Balance!</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-desktop"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kiosk 1 Balance</span>
                        <span class="info-box-number">Opening Balance: ₱<?php echo $kioskone_opening; ?></span>
                        <span class="info-box-number">Remaining Balance: ₱<?php echo $kioskone_remaining; ?></span>

                        <?php if ($kioskone_remaining < 500): ?>
                        <span class="label label-warning low-balance-indicator"><i class="fa fa-exclamation-triangle"></i> Low Balance!</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-desktop"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kiosk 2 Balance</span>
                        <span class="info-box-number">Opening Balance: ₱<?php echo $kiosktwo_opening; ?></span>
                        <span class="info-box-number">Remaining Balance: ₱<?php echo $kiosktwo_remaining; ?></span>

                        <?php if ($kiosktwo_remaining < 500): ?>
                        <span class="label label-warning low-balance-indicator"><i class="fa fa-exclamation-triangle"></i> Low Balance!</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <form action="<?php echo base_url('touchpoint/billing') ?>" method="GET">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Plate Number</h3>
                            <p>Pay with Plate Number</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Plate">
                            <input type="text" class="form-control" id="parkingCode" name="code" placeholder="XXX-XXXX" required autocomplete="off">
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit">Payment <i class="fa fa-arrow-circle-right"></i></button>
                            <a class="btn btn-success" href="<?php echo base_url("touchpoint/search") ?>">Search <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <form action="<?php echo base_url('touchpoint/billing') ?>" method="get">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>QR Ticket</h3>
                            <p>Pay with QR Ticket</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="QR">
                            <input type="text" class="form-control" id="parkingCode" name="code" placeholder="QR123456789G0" required autocomplete="off">
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit">Payment <i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <form action="#" method="get">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Lost Ticket</h3>
                            <p>Ticket lost</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Lost" disabled>
                            <input type="text" class="form-control" id="parkingCode" name="code" value="Lost Ticket" required autocomplete="off" disabled>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <a href="<?php echo base_url('terminal/lostticket'); ?>" class="btn btn-danger">Details <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

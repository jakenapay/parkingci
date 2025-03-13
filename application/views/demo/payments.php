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
        <h3 class="terminal-name text-right">Touchpoint v1.0</h3>


        <div class="row">
            <div class="col-lg-4">
                <form action="<?php echo base_url('demo/cliententry') ?>" method="POST">
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

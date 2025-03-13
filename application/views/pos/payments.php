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
        <h1>Touchpoint v1.0
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
        <!-- <h3 class="terminal-name text-right">Touchpoint v1.</h3> -->

        <!-- for transaction status -->
        <?php if ($this->session->flashdata('status')): ?>
            <?php echo ($this->session->flashdata('status') === 'success') ? '' : '<div
                class="alert alert-danger">
                <p>Transactions are closed at the moment, please try again later.</p>
            </div>'; ?>
        <?php endif; ?>

        <?php if ($this->session->flashdata('refund')) { ?>
            <?php if ($this->session->flashdata('refund') === 'refund_success') {
                    echo '<div class="alert alert-success">
                    <p>Refund was successful.</p>
                    </div>';
                } else if ($this->session->flashdata('refund') === 'refund_failed') {
                    echo '<div class="alert alert-danger">
                    <p>Refund failed</p>
                    </div>';
                } ?>
        <?php } ?>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                setTimeout(function () {
                    let alertBox = document.querySelector(".alert");
                    if (alertBox) {
                        alertBox.style.display = "none";
                    }
                }, 5000); // 5 seconds
            });
        </script>



        <div class="row">
            <div class="col-lg-4">
                <form action="<?php echo base_url('touchpoint/cliententry') ?>" method="POST">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Plate Number</h3>
                            <p>Pay with Plate Number</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Plate">
                            <input type="text" class="form-control" id="parkingCode" name="code" placeholder="XXX-XXXX"
                                required autocomplete="off" <?php echo ($z_status == 1) ? 'disabled' : ''; ?>>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit" <?php echo ($z_status == 1) ? 'disabled' : ''; ?>>Payment <i
                                    class="fa fa-arrow-circle-right"></i></button>
                            <a class="btn btn-success" href="<?php echo base_url("touchpoint/searchplate") ?>" <?php echo ($z_status == 1) ? 'onclick="return false;"' : ''; ?>>Search <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <form action="<?php echo base_url('touchpoint/cliententry') ?>" method="POST">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>QR Ticket</h3>
                            <p>Pay with QR Ticket</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="QR">
                            <input type="text" class="form-control" id="parkingCode" name="code"
                                placeholder="QR123456789G0" required autocomplete="off" <?php echo ($z_status == 1) ? 'disabled' : ''; ?>>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit" <?php echo ($z_status == 1) ? 'disabled' : ''; ?>>Payment <i
                                    class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>

           <!-- Refund -->
            <div class="col-lg-4">
                <form action="<?php echo base_url('touchpoint/refund') ?>" method="POST" onsubmit="return confirmRefund();">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Refund</h3>
                            <p>Refund a transaction</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Lost" disabled>
                            <input type="text" class="form-control" id="parkingCode" name="code" placeholder="XXXXXX"
                                required autocomplete="off">
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-warning" type="submit" <?php echo ($z_status == 1) ? 'disabled' : ''; ?>>
                                Refund <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

<!-- JavaScript Confirmation -->
<script>
    function confirmRefund() {
        return confirm("Are you sure you want to refund?");
    }
</script>

            <!-- LOSS TICKET -->
            <!-- <div class="col-lg-4">
                <form action="#" method="get">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Lost Ticket</h3>
                            <p>Ticket lost</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Lost" disabled>
                            <input type="text" class="form-control" id="parkingCode" name="code" value="Lost Ticket"
                                required autocomplete="off" disabled>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <a href="<?php echo base_url('terminal/lostticket'); ?>" class="btn btn-danger">Details <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
</div>

<!-- JavaScript to remove alert after 10 seconds -->
<script>
    setTimeout(function() {
        var alertBox = document.getElementById("refundAlert");
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(function() {
                alertBox.remove();
            }, 500); // Wait for the fade-out effect
        }
    }, 10000); // 10 seconds
</script>
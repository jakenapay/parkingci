<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">
                    <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
                </li>
            </ol>
        </section>
        <!-- Clock Card -->
        <div class="clock-card">
            <div class="digital-clock">
                <div class="time-segment">
                    <span class="label">Day</span>
                    <span id="day"></span>
                </div>
                <div class="time-segment">
                    <span class="label">Hour</span>
                    <span id="hour"></span>
                </div>
                <div class="colon">:</div>
                <div class="time-segment">
                    <span class="label">Min</span>
                    <span id="minute"></span>
                </div>
                <div class="colon">:</div>
                <div class="time-segment">
                    <span class="label">Sec</span>
                    <span id="second"></span>
                </div>
                <div class="time-segment" id="ampm-segment">
                    <span class="label ampm-label">AM/PM</span>
                    <span id="ampm"></span>
                </div>
            </div>
            <div class="current-date">
                <h4 id="current-date"></h4>
            </div>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <!-- First Row of Cards -->
        <div class="row">
            <!-- Cashier Cash Balance Card -->
            <div class="col-lg-4">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>Cashier Balance</h3>
                        <p>Current Balance</p>
                        <!-- Display the cashier balance -->
                        <h4>
                            ₱
                            <?php echo isset($cashier_remaining) && !empty($cashier_remaining) ? $cashier_remaining : '0.00'; ?>
                            /₱
                            <?php echo isset($cashier_opening) && !empty($cashier_opening) ? $cashier_opening : '0.00'; ?>
                        </h4>
                        <!-- Progress bar for cashier balance -->
                        <div class="progress">
                            <?php
                            $cashier_percentage = isset($cashier_remaining, $cashier_opening) && $cashier_opening > 0
                                ? ($cashier_remaining / $cashier_opening) * 100
                                : 0;
                            ?>
                            <div class="progress-bar progress-bar" role="progressbar"
                                style="width: <?php echo $cashier_percentage; ?>%;"
                                aria-valuenow="<?php echo $cashier_percentage; ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <?php echo round($cashier_percentage, 2); ?>%
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                </div>
            </div>

            <!-- Kiosk 1 Cash Balance Card -->
            <div class="col-lg-4">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>Kiosk 1 Balance</h3>
                        <p>Current Balance</p>
                        <!-- Display the kiosk balance -->
                        <h4>
                            ₱
                            <?php echo isset($kioskone_remaining) && !empty($kioskone_remaining) ? $kioskone_remaining : '0'; ?>
                            / ₱
                            <?php echo isset($kioskone_opening) && !empty($kioskone_opening) ? $kioskone_opening : '0.00'; ?>

                        </h4>
                        <!-- Progress bar for kiosk 1 balance -->
                        <div class="progress">
                            <?php
                            $kiosk1_percentage = isset($kioskone_remaining, $kioskone_opening) && $kioskone_opening > 0
                                ? ($kioskone_remaining / $kioskone_opening) * 100
                                : 0;
                            ?>
                            <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                style="width: <?php echo $kiosk1_percentage; ?>%;"
                                aria-valuenow="<?php echo $kiosk1_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo round($kiosk1_percentage, 2); ?>%
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                </div>
            </div>

            <!-- Kiosk 2 Cash Balance Card -->
            <div class="col-lg-4">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>Kiosk 2 Balance</h3>
                        <p>Current Balance</p>
                        <!-- Display the kiosk balance -->
                        <h4>
                            ₱
                            <?php echo isset($kiosktwo_remaining) && !empty($kiosktwo_remaining) ? $kiosktwo_remaining : '0'; ?>
                            / ₱
                            <?php echo isset($kiosktwo_opening) && !empty($kiosktwo_opening) ? $kiosktwo_opening : '0.00'; ?>

                        </h4>
                        <!-- Progress bar for kiosk 2 balance -->
                        <div class="progress">
                            <?php
                            $kiosk2_percentage = isset($kiosktwo_remaining, $kiosktwo_opening) && $kiosktwo_opening > 0
                                ? ($kiosktwo_remaining / $kiosktwo_opening) * 100
                                : 0;
                            ?>
                            <div class="progress-bar progress-bar bg-success" role="progressbar"
                                style="width: <?php echo $kiosk2_percentage; ?>%;"
                                aria-valuenow="<?php echo $kiosk2_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo round($kiosk2_percentage, 2); ?>%
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-4">
                <form action="<?php echo base_url('terminal/payment') ?>" method="GET">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Plate Number</h3>
                            <p>Pay with Plate Number</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="Plate">
                            <input type="text" class="form-control" id="parkingCode" name="code" placeholder="XXX-XXXX"
                                required autocomplete="off">
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit">Payment <i
                                    class="fa fa-arrow-circle-right"></i></button>
                            <a class="btn btn-success" href="<?php echo base_url("terminal/search") ?>">Search <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <form action="<?php echo base_url('terminal/payment') ?>" method="get">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>QR Ticket</h3>
                            <p>Pay with QR Ticket</p>
                            <input type="hidden" class="form-control" name="accessEntry" value="QR">
                            <input type="text" class="form-control" id="parkingCode" name="code"
                                placeholder="QR123456789G0" required autocomplete="off">
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-car"></i>
                        </div>
                        <div class="form-row text-center" style="padding: 15px; text-align: end;">
                            <button class="btn btn-success" type="submit">Payment <i
                                    class="fa fa-arrow-circle-right"></i></button>
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
            </div>
        </div>

        <div class="pos-information">
            <div class="info-data">
                <h1>CASHIER POS TERMINAL</h1>
                <div class="guidelines">
                    <h4>Usage Guidelines:</h4>
                    <ul>
                        <li><strong>Plate Number:</strong> Enter the vehicle's plate number to process payment.</li>
                        <li><strong>QR Ticket:</strong> Scan or enter the QR code from the ticket to make payment.</li>
                        <li><strong>Lost Ticket:</strong> Click "Details" for procedures if a ticket is lost.</li>
                    </ul>
                </div>
            </div>
            <div class="info-data">
                <h1>OPERATION</h1>
                <div class="guidelines">
                    <h4>Cashier Name:
                        <?php echo $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
                    </h4>
                    <ul>
                        <li><strong>Beginning Invoice:</strong> 100</li>
                        <li><strong>Ending Invoice:</strong> 100</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .clock-card {
        background-color: #ffffff;
        padding: 20px;
        margin: 20px auto;
        text-align: center;
    }

    .digital-clock {
        font-size: 35px;
        font-family: 'Arial', sans-serif;
        color: #272727;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .time-segment {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 5px;
        padding: 5px 20px;
    }

    .label {
        font-size: 12px;
        color: #45474B;
    }

    .colon {
        font-size: 24px;
        line-height: 40px;
        margin: 0 5px;
    }

    #clock span {
        font-weight: bold;
    }

    .pos-information {
        width: 100%;
        padding: 20px;
        background: #fff;
        display: flex;
    }

    .info-data {
        width: 50%;
    }

    .current-date {
        margin-top: 10px;
    }

    .guidelines {
        margin-top: 20px;
    }

    .guidelines ul {
        list-style-type: none;
        padding: 0;
    }

    .guidelines li {
        margin-bottom: 10px;
    }

    .guidelines strong {
        color: #007bff;
    }

    .progress {
        height: 25px;
        background-color: #f5f5f5;
        border-radius: 5px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        background-color: #28a745;
        /* You can change this color based on the balance state */
        font-size: 14px;
        line-height: 25px;
        color: #fff;
        text-align: center;
        transition: width 0.6s ease;
    }
</style>

<script>
    function updateClock() {
        const days = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        const now = new Date();
        const day = days[now.getDay()];
        let hour = now.getHours();
        const minute = now.getMinutes().toString().padStart(2, '0');
        const second = now.getSeconds().toString().padStart(2, '0');
        const ampm = hour >= 12 ? 'PM' : 'AM';

        hour = hour % 12;
        hour = hour ? hour : 12;
        hour = hour.toString().padStart(2, '0');

        document.getElementById('day').textContent = day;
        document.getElementById('hour').textContent = hour;
        document.getElementById('minute').textContent = minute;
        document.getElementById('second').textContent = second;

        const ampmElement = document.getElementById('ampm');
        const ampmSegment = document.getElementById('ampm-segment');
        if (ampm === 'AM' || ampm === 'PM') {
            ampmElement.textContent = ampm;
            ampmSegment.style.display = 'flex';
        } else {
            ampmSegment.style.display = 'none';
        }

        // Update the current date
        const currentDate = now.toDateString();
        document.getElementById('current-date').textContent = `${currentDate}`;
    }

    setInterval(updateClock, 1000);
    updateClock();

</script>
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

    .menu-bars {
        width: 100%;
        padding: 20px;
        background: #fff;
    }

    .btn-card {
        width: 200px;
        background: red;
        color: white;
        /* Ensure text is visible */
    }

    .chart-container {
        width: 100%;
        height: 400px;
        margin-top: 20px;
    }

    .row-transaction-data {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        /* Added spacing between transaction rows */
    }

    .chart-container {
        width: 100%;
        height: 400px;
        
    }
    #weeklyRevenueChart{
        height: 100%;
    }
    .pos-details{
        width: 250px;
        padding: 15px;
        background: #fff;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard <small>Manage dashboard</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <h3 class="terminal-name text-right">Touchpoint v1.0</h3>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Cashier Balance</span>
                        <span class="info-box-number">Opening Balance: ₱<?php echo $cashier_opening; ?></span>
                        <span class="info-box-number">Remaining Balance: ₱<?php echo $cashier_remaining; ?></span>

                        <?php if ($cashier_remaining < 500): ?>
                            <span class="label label-warning low-balance-indicator"><i
                                    class="fa fa-exclamation-triangle"></i> Low Balance!</span>
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
                            <span class="label label-warning low-balance-indicator"><i
                                    class="fa fa-exclamation-triangle"></i> Low Balance!</span>
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
                            <span class="label label-warning low-balance-indicator"><i
                                    class="fa fa-exclamation-triangle"></i> Low Balance!</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h6 class="box-title">Recent Transactions</h6>
                        <a href="#" class="pull-right btn btn-primary">View All</a>
                    </div>
                    <div class="box-body">
                        <div class="row-transaction-data">
                            <div>
                                <h5 class="mb-0">Ticket P-4321</h5> <!-- Fixed closing tag -->
                                <p class="text-muted">Duration: 2h 15m</p>
                            </div>
                            <div class="text-end" style="margin-left: auto;">
                                <h5 class="mb-0">₱120.00</h5>
                                <p class="text-success">Paid</p>
                            </div>
                        </div>
                        <div class="row-transaction-data">
                            <div>
                                <h5 class="mb-0">Ticket P-4321</h5> <!-- Fixed closing tag -->
                                <p class="text-muted">Duration: 2h 15m</p>
                            </div>
                            <div class="text-end" style="margin-left: auto;">
                                <h5 class="mb-0">₱120.00</h5>
                                <p class="text-success">Paid</p>
                            </div>
                        </div>
                        <div class="row-transaction-data">
                            <div>
                                <h5 class="mb-0">Ticket P-4321</h5> <!-- Fixed closing tag -->
                                <p class="text-muted">Duration: 2h 15m</p>
                            </div>
                            <div class="text-end" style="margin-left: auto;">
                                <h5 class="mb-0">₱120.00</h5>
                                <p class="text-success">Paid</p>
                            </div>
                        </div>
                        <div class="row-transaction-data">
                            <div>
                                <h5 class="mb-0">Ticket P-4321</h5> <!-- Fixed closing tag -->
                                <p class="text-muted">Duration: 2h 15m</p>
                            </div>
                            <div class="text-end" style="margin-left: auto;">
                                <h5 class="mb-0">₱120.00</h5>
                                <p class="text-success">Paid</p>
                            </div>
                        </div>
                        <div class="row-transaction-data">
                            <div>
                                <h5 class="mb-0">Ticket P-4321</h5> <!-- Fixed closing tag -->
                                <p class="text-muted">Duration: 2h 15m</p>
                            </div>
                            <div class="text-end" style="margin-left: auto;">
                                <h5 class="mb-0">₱120.00</h5>
                                <p class="text-success">Paid</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body h-100">
                        <div class="chart-container">
                            <canvas id="weeklyRevenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Create a gradient
    const ctx = document.getElementById('weeklyRevenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)');
    gradient.addColorStop(1, 'rgba(75, 192, 192, 0.2)');

    const weeklyRevenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            datasets: [{
                label: 'Weekly Revenue',
                data: [1200, 1900, 3000, 500, 2000, 3000, 2500],
                backgroundColor: [
                    '#133E87',
                    '#1E88E5',
                    '#39A9DB',
                    '#4BBF73',
                    '#FFB74D',
                    '#FF7043',
                    '#D81B60'
                ],
                pointRadius: 5,
                pointBackgroundColor: [
                    '#FF4545',
                    '#FF8A65',
                    '#FFCA28',
                    '#66BB6A',
                    '#29B6F6',
                    '#AB47BC',
                    '#EC407A'
                ],
                fill: true,
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1A1A19',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: '#1A1A19',
                    borderWidth: 1,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue (₱)',
                        color: '#1A1A19',
                        font: {
                            size: 14,
                            weight: 'bold',
                        }
                    },
                    
                },
                
            }
        }
    });
</script>
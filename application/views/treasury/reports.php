<style>
/* Cool Menu Styles */
.menu-item {
    border-radius: 8px; /* Rounded corners */
    transition: background-color 0.3s, color 0.3s, transform 0.2s; /* Smooth transitions */
}

.menu-link {
    display: flex;
    align-items: center;
    padding: 12px 15px; /* Slightly larger padding */
    color: #333; /* Default text color */
    text-decoration: none; /* Remove underline */
    font-weight: 500; /* Slightly bolder text */
    border-left: 5px solid transparent; /* Subtle left border */
    transition: border-left-color 0.3s; /* Transition for left border */
}

.menu-link i {
    margin-right: 10px; /* Space between icon and text */
    font-size: 1.4em; /* Larger icons */
}

</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Reports
            <small>Manage reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    
    <div class="content">
        <div class="row">


            <!-- Daily Sales Summary -->
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daily Sales Summary</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-aqua">
                                    <span class="info-box-icon"><i class="fa fa-file"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Beginning SI</span>
                                        <span class="info-box-number"><?php echo $summary_data['beginningOr']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="fa fa-file"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Ending SI</span>
                                        <span class="info-box-number"><?php echo $summary_data['endingOr']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cashier Opening Fund</span>
                                        <span class="info-box-number">PHP <?php echo $summary_data['cashierTerminalOpFund']; ?>.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-box bg-red">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cashier Remaining</span>
                                        <span class="info-box-number">PHP <?php echo $summary_data['cashierTerminalRemFund']; ?>.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Opening Fund</span>
                                        <span class="info-box-number">Php 10,000.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-box bg-red">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Remaining Fund</span>
                                        <span class="info-box-number">Php 8,500.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-box bg-yellow">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Opening Fund</span>
                                        <span class="info-box-number">Php 10,000.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-box bg-red">
                                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Remaining Fund</span>
                                        <span class="info-box-number">Php 8,500.00</span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-green">
                                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Today's Earning</span>
                                        <span class="info-box-number">Php 15,500.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-orange">
                                    <span class="info-box-icon"><i class="fa fa-ban"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Void Sales</span>
                                        <span class="info-box-number">Php 2,500.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Table -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transaction Counts by Vehicle Type</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Vehicle Type</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>MOTORCYCLE</td>
                                    <td>25</td>
                                </tr>
                                <tr>
                                    <td>CAR</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>BUS/Truck</td>
                                    <td>30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sales Type Table -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transaction Counts by Sales Type</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sales Type</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Regular</td>
                                    <td>40</td>
                                </tr>
                                <tr>
                                    <td>Tenants</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <td>Senior Citizen / PWD</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>Senior Citizen / PWD Resident</td>
                                    <td>5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

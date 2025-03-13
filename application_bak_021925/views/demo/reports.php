<section class="content-wrapper">
    <section class="content-header">
        <h1>Reports
            <small>Manage reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <section class="content">

        <div class="col-md-3">
        <div class="box box-primary">
                    <div class="box-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <i class="fa fa-id-card"></i> Daily Sales
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <i class="fa fa-truck"></i> Merchant Info
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo base_url("demo/xsalesAnalysis") ?>" class="menu-link">
                                    <i class="fa fa-paste"></i> X Reading
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo base_url("demo/zsalesAnalysis") ?>" class="menu-link">
                                    <i class="fa fa-paste"></i> Z Reading
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link">
                                    <i class="fa fa-paste"></i> E Journal
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary ">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="paymentTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Values</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Beg. S/I No.</td>
                                    <td><?php echo $report_summary['begsales_invoice']; ?></td>
                                </tr>
                                <tr>
                                    <td>End. S/I No.</td>
                                    <td><?php echo $report_summary['endsales_invoice']; ?></td>
                                </tr>
                                <tr>
                                    <td>Opening Fund</td>
                                    <td>PHP <?php echo number_format((float)$report_summary['opening_fund'], 2, '.', ','); ?></td>
                                </tr>
                                <tr>
                                    <td>Sales of the Day</td>
                                    <td>PHP <?php echo number_format((float)$report_summary['daily_sales'], 2, '.', ','); ?></td>
                                </tr>
                                <tr>
                                    <td>Void</td>
                                    <td><?php echo $report_summary['void_counts']; ?></td>
                                </tr>
                                <tr>
                                    <td>Total Void</td>
                                    <td>PHP <?php echo number_format((float)$report_summary['void_sales'], 2, '.', ','); ?></td>
                                </tr>
                                <tr>
                                    <td>Void Sales</td>
                                    <td>PHP <?php echo number_format((float)$report_summary['void_sales'], 2, '.', ','); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
</section>


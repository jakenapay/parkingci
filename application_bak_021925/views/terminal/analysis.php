<style>
    .menu {
        background-color: #2c3e50;
        border-radius: 8px;
        padding: 15px;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu h3 {
        margin-top: 0;
        font-size: 20px;
        color: #ecf0f1;
        border-bottom: 1px solid #34495e;
        padding-bottom: 10px;
    }

    .menu ul {
        list-style: none;
        padding-left: 0;
        margin-top: 15px;
    }

    .menu ul li {
        margin-bottom: 10px;
    }

    .menu ul li a {
        color: #bdc3c7;
        font-size: 16px;
        padding: 10px;
        display: block;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .menu ul li a:hover {
        background-color: #34495e;
        color: #ecf0f1;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .view-item {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        margin-left: 15px;
    }

    .view-item h3 {
        font-size: 18px;
        border-bottom: 1px solid #bdc3c7;
        padding-bottom: 10px;
        color: #34495e;
    }

    .analysis-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .receipt-view {
        width: 450px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #E9EFEC;
        text-align: center;
    }

    .row-data {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    .receipt-section {
        font-weight: 600;
        text-align: start;
        text-transform: uppercase;
        color: #45474B;
    }
    .view-data{
        width: 100%;
        display: flex;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Analysis
            <small>Manage report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="menu">
                    <h3>Reports Menu</h3>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#" data-report="Z-Reading">Z-Reading</a></li>
                        <li><a href="#" data-report="X-Reading">X-Reading</a></li>
                        <li><a href="#" data-report="E-Journal">E-Journal</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="view-item">
                    <h3>Report Viewer</h3>
                    <div class="view-data">
                        <div class="receipt form">
                            <div class="row">
                                <form action="">
                                    <div class="col-md-12 col-12">
                                        <input type="date" name="start" class="form-control" required>            
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <input type="date" name="end" class="form-control" required>                 
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <br>
                                        <button class="btn btn-primary">Generate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="analysis-wrapper">
                            <div class="receipt-view">
                                <div class="receipt-header">
                                    <p><strong>ORGANIZATION NAME</strong></p>
                                    <p><strong>PICC Complex, 1307 Pasay City, Metro Manila, Philippines</strong></p>
                                    <p><strong>VAT REG TIN: 123-456-789-00000</strong></p>
                                    <p><strong>MIN: 1234567890</strong></p>
                                    <p><strong>S/N: 1234567890-01</strong></p>
                                </div>
                                <div class="receipt-title">X-READING REPORT</div>
                                <div class="receipt-body">
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Report Date:
                                        </div>
                                        <div class="col-data-value">
                                            March 15, 2024
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Report Time:
                                        </div>
                                        <div class="col-data-value">
                                            11:30 AM
                                        </div>
                                    </div>

                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Start Date & Time:
                                        </div>
                                        <div class="col-data-value">
                                            09/24/2024 9:00 AM
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            End Date & Time:
                                        </div>
                                        <div class="col-data-value">
                                            09/24/2024 9:00 AM
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Cashier Name:
                                        </div>
                                        <div class="col-data-value">
                                            John Doe
                                        </div>
                                    </div>

                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Beg. Invoice #:
                                        </div>
                                        <div class="col-data-value">
                                            00000000000001
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            End. Invoice #:
                                        </div>
                                        <div class="col-data-value">
                                            00000000000010
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Opening Fund:
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <h4 class="receipt-section">Payments Received</h4>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            CASH
                                        </div>
                                        <div class="col-data-value">
                                            718.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            GCASH
                                        </div>
                                        <div class="col-data-value">
                                            30.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            PAYMAYA
                                        </div>
                                        <div class="col-data-value">
                                            50 .00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Total Payment
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            VOID
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            WITHDRAWAL
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <h4 class="receipt-section">Transaction Summary</h4>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Cash In Drawer:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            GCASH:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            PAYMAYA:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Payments Received
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            SHORT/OVER
                                        </div>
                                        <div class="col-data-value">
                                            1.60+
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="view-item" id="e-journal">
                    <h3>Report Viewer</h3>
                    <div class="view-data">
                        <div class="receipt form">
                            <div class="row">
                                <form action="">
                                    <div class="col-md-12 col-12">
                                        <input type="date" name="start" class="form-control" required>            
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <input type="date" name="end" class="form-control" required>                 
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <br>
                                        <button class="btn btn-primary">Generate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="analysis-wrapper">
                            <div class="receipt-view">
                                <div class="receipt-header">
                                    <p><strong>ORGANIZATION NAME</strong></p>
                                    <p><strong>PICC Complex, 1307 Pasay City, Metro Manila, Philippines</strong></p>
                                    <p><strong>VAT REG TIN: 123-456-789-00000</strong></p>
                                    <p><strong>MIN: 1234567890</strong></p>
                                    <p><strong>S/N: 1234567890-01</strong></p>
                                </div>
                                <div class="receipt-title">X-READING REPORT</div>
                                <div class="receipt-body">
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Report Date:
                                        </div>
                                        <div class="col-data-value">
                                            March 15, 2024
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Report Time:
                                        </div>
                                        <div class="col-data-value">
                                            11:30 AM
                                        </div>
                                    </div>

                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Start Date & Time:
                                        </div>
                                        <div class="col-data-value">
                                            09/24/2024 9:00 AM
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            End Date & Time:
                                        </div>
                                        <div class="col-data-value">
                                            09/24/2024 9:00 AM
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Cashier Name:
                                        </div>
                                        <div class="col-data-value">
                                            John Doe
                                        </div>
                                    </div>

                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Beg. Invoice #:
                                        </div>
                                        <div class="col-data-value">
                                            00000000000001
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            End. Invoice #:
                                        </div>
                                        <div class="col-data-value">
                                            00000000000010
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Opening Fund:
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <h4 class="receipt-section">Payments Received</h4>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            CASH
                                        </div>
                                        <div class="col-data-value">
                                            718.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            GCASH
                                        </div>
                                        <div class="col-data-value">
                                            30.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            PAYMAYA
                                        </div>
                                        <div class="col-data-value">
                                            50 .00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Total Payment
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            VOID
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            WITHDRAWAL
                                        </div>
                                        <div class="col-data-value">
                                            0.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <h4 class="receipt-section">Transaction Summary</h4>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Cash In Drawer:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            GCASH:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            PAYMAYA:
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            Payments Received
                                        </div>
                                        <div class="col-data-value">
                                            798.00
                                        </div>
                                    </div>
                                    <p><strong>==================================================</strong></p>
                                    <div class="row-data">
                                        <div class="col-data-title">
                                            SHORT/OVER
                                        </div>
                                        <div class="col-data-value">
                                            1.60+
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
    </div>
</div>
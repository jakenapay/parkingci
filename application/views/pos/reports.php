<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <div class="row">
            <!-- X Reading Card -->
            <div class="col-md-3">
                <a href="<?php echo base_url("touchpoint/xreport") ?>" class="card-link">
                    <div class="card text-center rounded card-custom">
                        <div class="card-body">
                            <p>X Reading</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Z Reading Card -->
            <div class="col-md-3">
                <a href="<?php echo base_url("touchpoint/zreport") ?>" class="card-link">
                    <div class="card text-center rounded card-custom">
                        <div class="card-body">
                            <p>Z Reading</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- e-Journal Reading Card -->
            <div class="col-md-3">
                <a href="<?php echo base_url("touchpoint/ejournal") ?>" class="card-link">
                    <div class="card text-center rounded card-custom">
                        <div class="card-body">
                            <p>e-Journal Reading</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Backend Report Card -->
            <div class="col-md-3">
                <a href="<?php echo base_url('touchpoint/generatesummary'); ?>" class="card-link">
                    <div class="card text-center rounded card-custom">
                        <div class="card-body">
                            <p>Backend Report</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Add styles for the cards -->
<style>
    .card-custom {
        background-color: #ffffff;
        border: 1px solid #ddd;
        padding: 40px;
        margin-top: 20px;
        text-transform: uppercase;
        font-weight: bold;
        color: #333;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        cursor: pointer;
    }
    .card-custom p {
        margin: 0;
        font-size: 1.2em;
        letter-spacing: 1px;
    }
    .card-custom:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        background-color: #f8f9fc; /* Light hover color for contrast */
    }
    .card-link {
        text-decoration: none;
    }
    .content-header h1 {
        font-size: 1.8em;
        font-weight: bold;
        color: #3c8dbc;
    }
    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }
    .breadcrumb a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Sales Analysis
            <small>Manage Analysis</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    
    <div class="content">
        <div class="row">
            <!-- Report Types Sidebar -->
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Types</h3>
                    </div>
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
                                <a href="<?php echo base_url("treasury/analysis") ?>" class="menu-link">
                                    <i class="fa fa-paste"></i> X Reading
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="<?php echo base_url("analysiszreading") ?>" class="menu-link">
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
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">
                            <i class="fa fa-chart-line"></i> Generate X-Reading Report
                        </h3>
                    </div>
                    <div class="card-body">
                        <form id="reportForm" action="<?php echo base_url('treasury/generateReadingReport'); ?>" method="get">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-4">
                                    <label for="report_date">Date:</label>
                                    <input type="date" class="form-control" id="report_date" name="report_date" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cashier_id">Cashier:</label>
                                    <select class="form-control" id="cashier_id" name="cashier_id" required>
                                        <option value="">Select Cashier</option>
                                        <option value="all">All</option>
                                        <?php if(empty($cashiers)): ?>
                                            <option>No cashier</option>
                                        <?php else: ?>
                                            <?php foreach($cashiers as $u): ?>
                                                <option value="<?php echo $u['id'] ?>"><?php echo $u['username']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="terminal_id">Terminal:</label>
                                    <select class="form-control" id="terminal_id" name="terminal_id" required>
                                        <option value="">Select Terminal</option>
                                        <option value="all">All</option>
                                        <option value="12">Terminal 1</option>
                                        <option value="12">Terminal 2</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Generate Report</button>
                        </form>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>

<style>
    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        font-weight: bold;
        font-size: 1.5rem;
        padding: 1rem;
    }

    .card-body {
        padding: 2rem;
        background-color: #ffffff;
    }

    .btn {
        background-color: #007bff;
        color: white;
        border-radius: 0.25rem;
        font-size: 1.2rem;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    .btn:focus {
        outline: none;
    }

    .content-wrapper {
        background-color: #f8f9fa;
        padding: 2rem;
    }

    #report_results {
        min-height: 100px;
        border: 1px dashed #007bff;
        padding: 20px;
        border-radius: 0.5rem;
        background-color: #e9ecef;
    }

    .shadow-lg {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .progress {
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .card {
            margin-bottom: 20px;
        }
    }
</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Manage X Reading</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content-center">
        <div class="custom-card">
            <div class="card-header">
                <h3 class="card-title">BIR Summary Report</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url("touchpoint/discountSummaryReport"); ?>" method="POST">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="cashier">Cashier</label>
                        <select class="form-control" id="cashier" name="cashier" required>
                            <option selected disabled>Select Cashier</option>
                            <?php foreach($cashiers as $c): ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['username']; ?></option>
                            <?php endforeach; ?>
                            <!-- Add other cashier options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="terminal">Terminal</label>
                        <select class="form-control" id="terminal" name="terminal" required>
                            <option selected disabled>Select Terminal</option>
                            <?php foreach($terminals as $t): ?>
                                <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                            <?php endforeach; ?>
                            <!-- Add other terminal options as needed -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Centering content and setting height */
    .content-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 200px);
    }

    /* Custom card styling */
    .custom-card {
        width: 100%;
        max-width: 500px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        background-color: #fff;
    }

    /* Card header styling */
    .custom-card .card-header {
        background-color: #6e8efb;
        padding: 10px 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .custom-card .card-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Form control styling */
    .form-control {
        border-radius: 5px;
        box-shadow: none;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(110, 142, 251, 0.5);
        border-color: #6e8efb;
    }

    /* Submit button styling */
    .btn-primary {
        background-color: #6e8efb;
        border: none;
        border-radius: 5px;
    }
</style>

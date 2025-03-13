<section class="content-wrapper">
    <section class="content-header">
        <h1>Reports
            <small>Manage reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>
    <div class="content">
        <div class="col-md-6">
            <div class="card" style="border: none; border-radius: 0.5rem; background: #007bff; color: white; margin-top: 20px;">
                <div class="card-header" style="border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
                    <h3 class="card-title" style="font-weight: bold; font-size: 1.5rem;">
                        <i class="fa fa-list"></i> Reports Overview
                    </h3>
                </div>
                <div class="card-body" style="padding: 2rem; background-color: #ffffff; color: #333;">
                    <form action="<?php echo site_url('treasury/printAnalysis'); ?>" method="post">
                        <div class="form-group row">
                            <?php
                            // Define fields for summary data
                            $fields = [
                                'first_ornumber' => 'First OR Number',
                                'last_ornumber' => 'Last OR Number',
                                'openingFund' => 'Opening Fund',
                                'remainingFund' => 'Remaining Fund',
                                'presentAccumulatedSales' => 'Present Accumulated Sales',
                                'salesForTheDay' => 'Sales for the Day',
                                'previousAccumulatedSales' => 'Previous Accumulated Sales',
                                'totalPaymentsReceived' => 'Total Payments Received',
                                'dropOffCount' => 'Drop Off Count',
                                'Cash' => 'Cash',
                                'Gcash' => 'Gcash',
                                'Paymaya' => 'Paymaya',
                                'shortOver' => 'Short / Over'
                            ];

                            foreach ($fields as $key => $label): 
                                // Set a default value if the key does not exist
                                $value = isset($summary[$key]) ? ($key == 'first_ornumber' || $key == 'last_ornumber' ? $summary[$key] : number_format($summary[$key], 2)) : '0.00';
                            ?>
                            <div class="col-md-6">
                                <label for="<?php echo $key; ?>" class="col-form-label"><?php echo $label; ?></label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="<?php echo $key; ?>" name="<?php echo $key; ?>" class="form-control" value="<?php echo $value; ?>" readonly>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        border-radius: 0.5rem;
        background: #007bff; /* Card Background Color */
    }

    .card-header {
        padding: 1rem;
    }

    .card-body {
        padding: 2rem;
        background-color: #ffffff; /* Card Body Background Color */
    }

    .table th {
        text-align: left;
        padding: 10px;
    }

    .table td {
        padding: 10px;
        font-size: 1.2rem; /* Adjusted font size */
    }

    @media (max-width: 768px) {
        .card {
            margin-bottom: 20px;
        }
    }

    .col-form-label {
        font-weight: bold;
    }
</style>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Device
            <small>Manage Terminal Profiles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Treasury: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname'); ?>
            </li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- Terminal Card 1 -->
            <div class="col-md-4">
                <div class="card terminal-card">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5><i class="fa fa-terminal"></i> Terminal 1</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> Main Terminal</p>
                        <p><strong>Location:</strong> Main Entrance</p>
                        <p><strong>ID:</strong> T123456</p>
                        <p><strong>Created:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?php echo base_url('path/to/your/terminal/edit/T123456'); ?>" class="btn btn-outline-primary">Edit</a>
                        <a href="<?php echo base_url('path/to/your/terminal/delete/T123456'); ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            </div>

            <!-- Terminal Card 2 -->
            <div class="col-md-4">
                <div class="card terminal-card">
                    <div class="card-header bg-gradient-success text-white">
                        <h5><i class="fa fa-terminal"></i> Terminal 2</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> Cashier Terminal</p>
                        <p><strong>Location:</strong> Second Floor</p>
                        <p><strong>ID:</strong> T123457</p>
                        <p><strong>Created:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?php echo base_url('path/to/your/terminal/edit/T123457'); ?>" class="btn btn-outline-success">Edit</a>
                        <a href="<?php echo base_url('path/to/your/terminal/delete/T123457'); ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            </div>

            <!-- Terminal Card 3 -->
            <div class="col-md-4">
                <div class="card terminal-card">
                    <div class="card-header bg-gradient-info text-white">
                        <h5><i class="fa fa-terminal"></i> Terminal 3</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> Remote Terminal</p>
                        <p><strong>Location:</strong> Parking Lot</p>
                        <p><strong>ID:</strong> T123458</p>
                        <p><strong>Created:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?php echo base_url('path/to/your/terminal/edit/T123458'); ?>" class="btn btn-outline-info">Edit</a>
                        <a href="<?php echo base_url('path/to/your/terminal/delete/T123458'); ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure?');">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo base_url('path/to/your/terminal'); ?>" class="btn btn-secondary">Back to Terminals List</a>
        </div>
    </section>
</section>

<!-- Styles -->
<style>
    .terminal-card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }

    .terminal-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        padding: 15px;
        font-size: 1.2rem;
        text-transform: uppercase;
    }

    .card-body {
        padding: 20px;
        font-size: 1rem;
        line-height: 1.5;
        color: #444;
    }

    .card-footer {
        padding: 15px;
        background-color: #f7f7f7;
    }

    .btn-outline-primary, .btn-outline-success, .btn-outline-info {
        margin: 5px;
        border-width: 2px;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745, #218838);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8, #117a8b);
    }
</style>

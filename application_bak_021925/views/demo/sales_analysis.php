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
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-body">
                    <form action="">
                        <div class="col-md-4 col-2">
                            <label for="form-label">Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4 col-2">
                            <label for="cashierId">Cashier</label>
                            <select name="cashier_id" id="cashierId" class="form-control">
                                <option value="all">All</option>
                                <option value="1">Cashier 1</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-2">
                            <label for="terminalId">Terminal</label>
                            <select name="cashier_id" id="terminalId" class="form-control">
                                <option value="all">All</option>
                                <option value="1">Terminal</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>
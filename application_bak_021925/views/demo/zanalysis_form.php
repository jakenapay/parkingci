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
                    <form action="<?php echo base_url('demo/generateZreadingReport'); ?>" method="post">
                        <div class="col-md-4 col-2">
                            <label for="form-label">Start Date</label>
                            <input type="date" name="date_start" class="form-control" required>
                        </div>
                        <div class="col-md-4 col-2">
                            <label for="form-label">End Date</label>
                            <input type="date" name="date_end" class="form-control" required>
                        </div>
                        <div class="col-md-4 col-2">
                            <label for="cashierId">Cashier</label>
                            <select name="cashier_id" id="cashierId" class="form-control">
                                <option value="all">All</option>
                                <?php foreach($cashiers as $c): ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['username']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-2">
                            <label for="terminalId">Terminal</label>
                            <select name="terminal_id" id="terminalId" class="form-control">
                                <option value="all">All</option>
                                <?php foreach($terminals as $t): ?>
                                    <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</section>

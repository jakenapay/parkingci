<section class="content-wrapper">
    <section class="content-header">
        <h1>Touchpoint v1.0
            <small>Generate Z Reading</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php echo "Cashier: " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?>
            </li>
        </ol>
    </section>

    <div class="content">
        <form action="<?php echo base_url("touchpoint/zresult"); ?>" method="POST">
            <div class="col-md-2">
                <input type="date" name="report_date" id="reportDate" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="" id="" class="form-control">
                    <option value="all">All</option>
                    <?php foreach($cashiers as $c): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['username']; ?></option>
                    <?php endforeach; ?>
                    
                </select>
            </div>
            <div class="col-md-3">
                <select name="" id="" class="form-control">
                    <option value="all">All</option>
                    <?php foreach($terminals as $c): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</section>

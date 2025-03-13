<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> <?php echo "Cashier : " . $this->session->userdata('fname') . " " . $this->session->userdata('lname') ?> </li>
        </ol>
    </section>
    <!-- Navigation buttons -->
    <section class="content-header">
        <div class="btn-group">
          <a href="<?= base_url('cashier/transaction');?>" class="btn btn-light">Cashier Transactions</a>
          <a href="<?= base_url('cashier/kioskTransaction'); ?>" class="btn btn-primary">Paystation Transactions</a>
        </div>
        <br>
    </section>
    <br>
    <!-- Main content -->
    <section>
        <div class="col-lg-12 col-xs-12">
            <div class="row text-center">
                <a href="<?= base_url('cashier/getKioskTransaction?kioskid=12') ?>">
                    <div class="col-lg-2">
                        <div class="btn btn-primary">
                            Kiosk 1 Transactions
                        </div>
                    </div>
                </a>

                <a href="<?= base_url('cashier/getKioskTransaction?kioskid=13') ?>">
                    <div class="col-lg-2">
                        <div class="btn btn-primary">
                            Kiosk 2 Transactions
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<script>
    function loadPayStationTransaction() {
        // Add your code to load Pay Station Transaction data
    }

    function loadCashierTransaction() {
        // Add your code to load Cashier Transaction data
    }

    $(document).ready(function() {
        $('#paymentTable').DataTable({
            'order': []
        });
    });
</script>

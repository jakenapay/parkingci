

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Complimentary
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          

          <div class="box">
            <div class="box-body text-center">
                <h1 class="text-center text-success">Complimentary QR Generated Success</h1>
                <p class="text-center">You can now download the PDF File to print QR Images. Just click the button below</p>
                <?php
                    if(isset($pdfFileName)) {
                        echo '<br><a class="btn btn-primary" href="'.base_url($pdfFileName).'">Download PDF</a>';
                    }
                ?>
            </div>

              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#groups").select2();

    $("#userSideTree").addClass('active');
    $("#createUserSideTree").addClass('active');
  });
</script>

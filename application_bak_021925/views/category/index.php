<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Manage
      <small>Category</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Category</li>
    </ol>
  </section>  
  <section class="content">    
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <?php if (in_array('createCategory', $user_permission)) : ?>
          <a href="<?php echo base_url('category/create') ?>" class="btn btn-success"> <i class="fa fa-plus"></i></a>
          <br /> <br />
        <?php endif; ?>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Category</h3>
          </div>
          <div class="box-body">
            <table id="datatables" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Group Name</th>
                  <th>Status</th>
                  <?php if (in_array('updateCategory', $user_permission) || in_array('deleteCategory', $user_permission)) : ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($category_data as $k => $v) {
                ?>
                  <tr>
                    <td><?php echo $v['name']; ?></td>
                    <td>
                      <?php if ($v['active'] == 1) { ?>
                        <span class="label label-success">Active</span>
                      <?php } else { ?>
                        <span class="label label-warning">Inactive</span>
                      <?php } ?>
                    </td>
                    <?php if (in_array('updateCategory', $user_permission) || in_array('deleteCategory', $user_permission)) : ?>
                      <td>
                        <?php if (in_array('updateCategory', $user_permission)) : ?>
                          <a href="<?php echo base_url('category/edit/' . $v['id']) ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
                        <?php endif; ?>
                        <?php if (in_array('deleteCategory', $user_permission)) : ?>
                          <a href="<?php echo base_url('category/delete/' . $v['id']) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        <?php endif; ?>
                      </td>
                  </tr>
                <?php endif; ?>
              <?php
                } ?>
              </tbody>
            </table>
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
    $('#datatables').DataTable();
    $("#categorySideTree").addClass('active');
    $("#manageCategorySideTree").addClass('active');

  });
</script>
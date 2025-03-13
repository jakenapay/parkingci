<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">    
        <li id="dashboardSideNav">  
          <a href="<?php echo base_url('touchpoint') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard </span>
          </a>   
        </li>     

        <li id="manageParkingSideTree"><a href="<?php echo base_url('touchpoint/payments') ?>"><i class="fa fa-arrow-circle-right"></i> Payments</a></li>
        <li id="settingSideTree"><a href="<?php echo base_url('touchpoint/transactions/') ?>"><i class="fa fa-money"></i> <span>Transactions</span></a></li>  
        <li id="settingSideTree"><a href="<?php echo base_url('touchpoint/reports/') ?>"><i class="glyphicon glyphicon-stats"></i> <span>Reports</span></a></li>  
        <li id="settingSideTree"><a href="<?php echo base_url('touchpoint/reprint/') ?>"><i class="fa fa-file"></i> <span>Reprint</span></a></li>  
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
    
  </aside>
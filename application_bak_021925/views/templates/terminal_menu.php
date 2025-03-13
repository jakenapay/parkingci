<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">    
        <li id="dashboardSideNav">  
          <a href="<?php echo base_url('Terminal') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard ..</span>
          </a>   
        </li>     
           

      
        <li id="manageParkingSideTree"><a href="<?php echo base_url('parking') ?>"><i class="fa fa-arrow-circle-right"></i> Parking Data</a></li>
        <li id="profileSideTree"><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-circle"></i> <span>My Profile</span></a></li>      
        <li id="settingSideTree"><a href="<?php echo base_url('cashier/account/') ?>"><i class="fa fa-cogs"></i> <span>Accounting</span></a></li>    
        <li id="settingSideTree"><a href="<?php echo base_url('cashier/transaction/') ?>"><i class="fa fa-money"></i> <span>Transaction</span></a></li>  
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
    
  </aside>
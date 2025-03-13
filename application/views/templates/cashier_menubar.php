<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">    
        <li id="dashboardSideNav">  
          <a href="<?php echo base_url('Cashier') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard ..</span>
          </a>   
        </li>     
           
        <!-- li class="treeview" id="parkingSideTree">
          <a href="#">
            <i class="fa fa-product-hunt"></i>
            <span>Parkings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">            
              <li id="createParkingSideTree"><a href="<?php echo base_url('parking/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Parking</a></li>                        
              <li id="manageParkingSideTree"><a href="<?php echo base_url('parking') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Parking</a></li>            
          </ul>
        </li -->
      
        <li id="manageParkingSideTree"><a href="<?php echo base_url('parking') ?>"><i class="fa fa-arrow-circle-right"></i> Parking Data</a></li>
        <li id="profileSideTree"><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-circle"></i> <span>My Profile</span></a></li>      
        <li id="settingSideTree"><a href="<?php echo base_url('cashier/account/') ?>"><i class="fa fa-cogs"></i> <span>Accounting</span></a></li>    
        <li id="settingSideTree"><a href="<?php echo base_url('cashier/transaction/') ?>"><i class="fa fa-money"></i> <span>Transaction</span></a></li>  
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
    
  </aside>
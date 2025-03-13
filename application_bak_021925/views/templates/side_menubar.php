<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">                
        <li id="dashboardSideNav">   
          <?php if($this->session->userdata('username') == 'cashier'){ ?>       
          <a href="<?php echo base_url('Cashier') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard ..</span>
          </a>
          <?php } 
          else { ?>
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard ..</span>
          </a>
          <?php } ?>
        </li>
         
        <?php if(in_array('viewParking', $user_permission)): ?>
        <li class="treeview" id="categorySideTree">
          <a href="#">
            <i class="fa fa-car"></i>
            <span>Monitor</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('viewParking', $user_permission)): ?>   
            <li id="createCategorySideTree"><a href="<?php echo base_url('parking/live') ?>"><i class="fa fa-arrow-circle-right"></i> parking monitor</a></li>
            <?php endif; ?>            
          </ul>
        </li>
      <?php endif; ?>
      <?php if(in_array('createParking', $user_permission) || in_array('updateParking', $user_permission) || in_array('viewParking', $user_permission) || in_array('deleteParking', $user_permission)): ?>
        <li class="treeview" id="parkingSideTree">
          <a href="#">
            <i class="fa fa-product-hunt"></i>
            <span>Parkings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('createParking', $user_permission)): ?>
              <li id="createParkingSideTree"><a href="<?php echo base_url('parking/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Parking</a></li>
            <?php endif; ?>
            <?php if(in_array('updateParking', $user_permission) || in_array('viewParking', $user_permission) || in_array('deleteParking', $user_permission)): ?>
              <li id="manageParkingSideTree"><a href="<?php echo base_url('parking') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Parking</a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
      
      <?php if(in_array('createRfid', $user_permission) || in_array('updateRfid', $user_permission) || in_array('viewRfid', $user_permission) || in_array('deleteRfid', $user_permission)): ?>
      <li class="treeview" id="gateSideTree">
          <a href="#">
            <i class="fa fa-list"></i>
            <span>RFID Vehicle</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">            
              <li id="createGateSideTree"><a href="<?php echo base_url('RFID/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Vehicle</a></li>            
              <li id="manageGateSideTree"><a href="<?php echo base_url('RFID') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Vehicle</a></li>            
          </ul>
        </li>
      <?php endif; ?>
      <?php if(in_array('createGate', $user_permission) || in_array('updateGate', $user_permission) || in_array('viewGate', $user_permission) || in_array('deleteGate', $user_permission)): ?>
        <li class="treeview" id="slotsSideTree">
          <a href="#">
            <i class="fa fa-list"></i>
            <span>Parking Gate</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">            
              <li id="createSlotsSideTree"><a href="<?php echo base_url('gate/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Gate</a></li>
              <li id="manageSlotsSideTree"><a href="<?php echo base_url('gate') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Gate</a></li>            
              <li id="manageSlotsSideTree"><a href="<?php echo base_url('gate/devicelog') ?>"><i class="fa fa-arrow-circle-right"></i> Device Log</a></li>            
          </ul>
        </li>
        <?php endif; ?>
      <?php if(in_array('createSlots', $user_permission) || in_array('updateSlots', $user_permission) || in_array('viewSlots', $user_permission) || in_array('deleteSlots', $user_permission)): ?>
        <li class="treeview" id="slotsSideTree">
          <a href="#">
            <i class="fa fa-list"></i>
            <span>Parking Slot</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('createSlots', $user_permission)): ?>
              <li id="createSlotsSideTree"><a href="<?php echo base_url('slots/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Slot</a></li>
            <?php endif; ?>
            <?php if(in_array('updateSlots', $user_permission) || in_array('viewSlots', $user_permission) || in_array('deleteSlots', $user_permission)): ?>
            <li id="manageSlotsSideTree"><a href="<?php echo base_url('slots') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Slot</a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
      <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
        <li class="treeview" id="categorySideTree">
          <a href="#">
            <i class="fa fa-car"></i>
            <span>Access Type Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('createCategory', $user_permission)): ?>   
            <li id="createCategorySideTree"><a href="<?php echo base_url('category/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Category</a></li>
            <?php endif; ?>
            <?php if(in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
            <li id="manageCategorySideTree"><a href="<?php echo base_url('category') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Category</a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>

      <?php if(in_array('createRates', $user_permission) || in_array('updateRates', $user_permission) || in_array('viewRates', $user_permission) || in_array('deleteRates', $user_permission)): ?>
        <li class="treeview" id="ratesSideTree">
          <a href="#">
            <i class="fa fa-usd"></i>
            <span>Rates</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('createRates', $user_permission)): ?>
            <li id="createRatesSideTree"><a href="<?php echo base_url('rates/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Rate</a></li>
            <?php endif; ?>
            <?php if(in_array('updateRates', $user_permission) || in_array('viewRates', $user_permission) || in_array('deleteRates', $user_permission)): ?>
            <li id="manageRatesSideTree"><a href="<?php echo base_url('rates') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Rates</a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?>
    
      <?php if(in_array('viewReports', $user_permission)): ?>        
        <li class="treeview" id="reportSideTree">
          <a href="#">
            <i class="glyphicon glyphicon-stats"></i>
            <span>Reports </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('viewReports', $user_permission)): ?>
              <li id="reportSideTree"><a href="<?php echo base_url('reports/index') ?>"><i class="fa fa-arrow-circle-right"></i> Total Income report</a></li>            
              <li id="reportSideTree"><a href="<?php echo base_url('reports/statistical') ?>"><i class="fa fa-arrow-circle-right"></i> Total statistical report </a></li>
              <li id="reportSideTree"><a href="<?php echo base_url('reports/Transaction') ?>"><i class="fa fa-arrow-circle-right"></i> Transaction Report  </a></li>
              <li id="reportSideTree"><a href="<?php echo base_url('reports/ParkingLoad') ?>"><i class="fa fa-arrow-circle-right"></i> Parking Load report </a></li>
              <li id="reportSideTree"><a href="<?php echo base_url('reports/LenthofStay') ?>"><i class="fa fa-arrow-circle-right"></i> Lenth of Stay report  </a></li>
            <?php endif; ?>
          </ul>
        </li>
      <?php endif; ?> 

      <?php if(in_array('updateCompany', $user_permission)): ?>
        <li id="companySideTree"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-building"></i> <span>Company Info</span></a></li>
      <?php endif; ?>


      <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="groupSideTree">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Access Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="createGroupSideTree"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupSideTree"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
          <li class="treeview" id="userSideTree">
            <a href="#">
              <i class="fa fa-user-secret"></i>
              <span>System Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserSideTree"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add User</a></li>
              <?php endif; ?>
    
              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserSideTree"><a href="<?php echo base_url('users') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Users</a></li>
            <?php endif; ?>
            <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserSideTree"><a href="<?php echo base_url('users/logview') ?>"><i class="fa fa-arrow-circle-right"></i> View Log Data</a></li>
            <?php endif; ?>

            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
          <li class="treeview" id="userSideTree">
            <a href="#"> <i class="fa fa-user-secret"></i><span>System Setup</span><span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserSideTree"><a href="<?php echo base_url('users/createPTU') ?>"><i class="fa fa-arrow-circle-right"></i> Add Paystation</a></li>
              <?php endif; ?>    
              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserSideTree"><a href="<?php echo base_url('users/ptu') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Paystation</a></li>
            <?php endif; ?>
            
            </ul>            
          </li>
          <?php endif; ?>

      <?php if(in_array('viewProfile', $user_permission)): ?>
        <li id="profileSideTree"><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-circle"></i> <span>My Profile</span></a></li>
      <?php endif; ?>
      <?php if(in_array('updateSetting', $user_permission)): ?>
        <li id="settingSideTree"><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-cogs"></i> <span>Settings</span></a></li>
      <?php endif; ?>

      <?php if(in_array('createComp', $user_permission) || in_array('updateComp', $user_permission) || in_array('viewComp', $user_permission) || in_array('deleteComp', $user_permission)): ?>
      <li class="treeview" id="gateSideTree">
        <a href="<?php echo base_url('Complimentary') ?>">
          <i class="fa fa-list"></i>
          <span>Complimentary</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">            
            <li id="createCompSideTree"><a href="<?php echo base_url('complimentary/create') ?>"><i class="fa fa-arrow-circle-right"></i> Add Complimentary</a></li>            
            <li id="manageCompSideTree"><a href="<?php echo base_url('Complimentary') ?>"><i class="fa fa-arrow-circle-right"></i> Manage Complimentary</a></li>            
        </ul>
      </li>
      <?php endif; ?>
      
      <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>
      
    </section>
    <!-- /.sidebar -->
    
  </aside>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/theme/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> USER NAME </p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php echo isset($page_title) && $page_title == 'Dashboard' ? ' active' : ''; ?>">
          <a href="<?php echo site_url('dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?php echo isset($page_title) && $page_title == 'Users' ? ' active' : ''; ?>">
          <a href="<?php echo site_url('users/list'); ?>">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
        <li class="<?php echo isset($page_title) && $page_title == 'Nursery' ? ' active' : ''; ?>">
          <a href="<?php echo site_url('nursery/list'); ?>">
            <i class="fa fa-users"></i> <span>Nursery</span>
          </a>
        </li>
        <li class="<?php echo isset($page_title) && $page_title == 'Plants' ? ' active' : ''; ?>">
          <a href="<?php echo site_url('plant/list'); ?>">
            <i class="fa fa-users"></i> <span>Plants</span>
          </a>
        </li>
        <li class="<?php echo isset($page_title) && $page_title == 'Plant Categories' ? ' active' : ''; ?>">
          <a href="<?php echo site_url('plant_category/list'); ?>">
            <i class="fa fa-users"></i> <span>Plant Categories</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

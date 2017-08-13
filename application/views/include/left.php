<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image"> <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> </div>
      <div class="pull-left info">
        <p>Md. Mahtab Ullah</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
    </div>
    <!--<form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span> </div>
    </form>-->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li> <a href="<?php echo base_url(); ?>Adminhome"><i class="fa fa-dashboard fa-fw"></i><span> Dashboard</span></a> </li>
      <li> <a href="#"><i class="fa fa-users fa-fw"></i><span>User Configuration</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url(); ?>houser"><i class="fa fa-user"></i><span>HO User</span></a> </li>
          <li><a href="<?php echo base_url(); ?>dbuser"><i class="fa fa-user"></i><span>DB User</span></a> </li>
        </ul>
      </li>
      <li class="treeview"> <a href="#"><i class="fa fa-wrench fa-fw"></i> <span>Basic</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li class="treeview" > <a href="#"><i class="fa fa-wrench fa-fw"></i><span>Calander</span> <i class="fa fa-angle-left pull-right"></i></a>
		  <ul class="treeview-menu">
          <li> <a href="<?php echo base_url(); ?>year"><i class="fa fa-university fa-fw"></i><span>Year</span></a> </li>
          <li> <a href="<?php echo base_url(); ?>month"><i class="fa fa-university fa-fw"></i><span>month</span></a> </li>
        </ul></li>
		  
        </ul>
      </li>
      <li  class="treeview"> <a href="#"><i class="fa fa-university fa-fw"></i><span> Distributor Information</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li> <a href="#"><i class="fa fa-university fa-fw"></i><span>Cluster</span></a> </li>
          <li> <a href="<?php echo base_url(); ?>DBinfo"><i class="fa fa-university fa-fw"></i><span>Distributor Profile</span></a> </li>
        </ul>
      </li>
      <li  class="treeview"> <a href="#"><i class="fa fa-cubes fa-fw"></i><span> Distributor Target</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-cubes fa-fw"></i><span>Monthly Target </span></a> </li>
          <li><a href="#"><i class="fa fa-cubes fa-fw"></i><span>Event Wise Target </span></a> </li>
          <li><a href="#"><i class="fa fa-cubes fa-fw"></i><span>Edit Monthly Target </span></a> </li>
          <li><a href="#"><i class="fa fa-cubes fa-fw"></i><span>Edit Event Wise Target </span></a> </li>
        </ul>
      </li>
      <li> <a href="#"><i class="fa fa-cloud-upload fa-fw"></i><span>Trade Promotion</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-cloud-upload fa-fw"></i><span>Trade Promotion Setup</span></a> </li>
          <li><a href="#"><i class="fa fa-cloud-upload fa-fw"></i><span>Change TP Information</span></a> </li>
          <li><a href="#"><i class="fa fa-cloud-upload fa-fw"></i><span>TP Calculator</span></a> </li>
        </ul>
      </li>
      <li> <a href="#"><i class="fa fa-paper-plane fa-fw"></i><span> Journey Plan</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Vehicle </span></a> </li>
          <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Route </span></a> </li>
          <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Subroute </span></a> </li>
          <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Outlet Profile </span></a> </li>
          <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Route Plan </span></a> </li>
        </ul>
      </li>
      <li  class="treeview"> <a href="#"><i class="fa fa-files-o fa-fw"></i><span>Reports</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li> <a href="#"><i class="fa fa-files-o fa-fw"></i><span>KPI Report</span><i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Incentive Report </span></a> </li>
              <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>KPI Report </span></a> </li>
              <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Route/Sub Route</br>
                Wise KPI Report </span></a> </li>
            </ul>
          </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Stock Ledger</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Sku wise Primary Vs </br>
            Secondary sales</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Stock Position</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Stock Statement</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Sales By Date Range</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Yearly Month Wise </br>
            Sales And Collection</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>SKU Wise Sales</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>PSR SKU Wise Sales</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Sales Promo</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Sales Promo Reports</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Outlet Wise Order Summery</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Sales Summary /</br>
            Details of Outlets </span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Top Outlet</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>MIS Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>TSB Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Spoke Sales Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Spoke Sales Claim</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Cause of Return</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Order Time Count Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Distributor Resource</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Distributor Event Target</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Distributor Non </br>
            Buyer Outlet</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>SKU wise non buyer </br>
            (Single/Multi product) sales </span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>SKU wise buyer </br>
            (Single/Multi product) sales </span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>SMS Notification </br>
            Stuatus</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>GRB Outstanding Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Equipment & POSM Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Market Return Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Claim Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Outlet Credit Report</span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>Brand/SKU Mix</br>
            (Contribution) </span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>CLP Report </span></a> </li>
          <li><a href="#"><i class="fa fa-files-o fa-fw"></i><span>SKU Wise Outlet List </span></a> </li>
        </ul>
      </li>
    </ul>
  </section>
</aside>
<div class="content-wrapper">
<section class="content">

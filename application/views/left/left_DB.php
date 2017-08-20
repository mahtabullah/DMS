<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header"><h5 style="color: white; margin-bottom: 15px; font-size: 15px; text-align: center;">
                    <b>Transcom Beverages Ltd.</b>
                </h5>
                <h6 style="color: white; text-align: center;"><b>Secondary Sales System</b></h6>
                <h6 style="color: white; text-align: center;"><b><?php echo $this->session->userdata('dbhouse_name'); ?></b></h6>
                <h6 style="color: white; text-align: center;"><b><?php echo $this->session->userdata('System_date'); ?></b></h6>
            </li>
            <li class="header">



            <li class="">
                <a href="<?php echo base_url(); ?>home/home_page">
                    <i class="fa fa-home"></i>
                    <span class="title">
                        Dashboard
                    </span>
                </a>
            </li>
            <li> <a href="#"><i class="fa fa-paper-plane fa-fw"></i><span> Basic</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    
                    <li><a href="<?php echo base_url(); ?>DB_house/Day_end"><i class="fa fa-paper-plane fa-fw"></i><span>Day End </span></a> </li>
                   
                </ul>

            </li>
            <li> <a href="#"><i class="fa fa-paper-plane fa-fw"></i><span> Journey Plan</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-paper-plane fa-fw"></i><span>Vehicle </span></a> </li>
                    <li><a href="<?php echo base_url(); ?>Route/routeView"><i class="fa fa-paper-plane fa-fw"></i><span>Route </span></a> </li>
                    <li><a href="<?php echo base_url(); ?>Outlet/DbOutletIndex"><i class="fa fa-paper-plane fa-fw"></i><span>Outlet Profile </span></a> </li>
                    <li><a href="<?php echo base_url(); ?>Route_plan"><i class="fa fa-paper-plane fa-fw"></i><span>Route Plan </span></a> </li>
                </ul>

            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Daily Activity</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Order Activity <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            <li><a href="<?php echo base_url(); ?>order/index"><i class="fa fa-circle-o"></i> All Order</a></li>
                             <li><a href="<?php echo base_url(); ?>order/create"><i class="fa fa-circle-o"></i> Order</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Challan</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Purchase Activity <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">

                            <li><a href="<?php echo base_url(); ?>stock/new_stock"><i class="fa fa-circle-o"></i> Purchase Entry </a></li>

                        </ul>
                    </li>
                    

                </ul>
            </li>
            <li class="">
                <a href="<?php echo base_url(); ?>stock">
                    <i class="fa fa-th-list"></i>
                    <span class="title">
                        Stock
                    </span>
                </a>
            </li>

        </ul>
    </section>
</aside>
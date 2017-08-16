<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php foreach($num_of_outlet as $outlet){echo $outlet["Number_of_outlet"];} ?></h3>
                    <p>Number Of Outlet</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="Number_of_order"><?php foreach($num_of_order as $order ){echo $order["Number_of_order"];} ?></h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?php foreach($Schedule_Call as $SC ){echo $SC["SC"];} ?></h3>
                    <p>Schedule Call</p>
                </div>
                <div class="icon">
                    <i class="fa fa-random"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo number_format($order["Number_of_order"]/$SC["SC"]*100,2); ?> %</h3>
                    <p>Strike Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->

    </div><!-- /.row -->
    <!-- Main row -->

</section><!-- /.content -->


<?php $this->load->view('footer/footer'); ?>
<script>
    $(document).ready(function () {        
        Number_of_order();
    });
    function Number_of_order() {
        var start_date="<?php echo $system_date; ?>";
        var end_date="<?php echo $system_date; ?>";
        $('#ajax_load').css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Home/order_qty/",
           data: {start_date:start_date,end_date:end_date},
            dataType: "html",
            success: function (data) {
                $("#Number_of_order").html(data);
                $('#ajax_load').css("display", "none");
            }
        });
    }
    }
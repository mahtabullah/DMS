<div class="dashboard-stat blue">
    <div class="visual">
        <i class="fa fa-outdent"></i>
    </div>
    <div class="details" style="margin-top: 5px;">
        <div class="number">
        </div>
        <div class="desc">
            <a class="desc" href="<?php echo site_url('sales_order/index/mobile');?>">Mobile Order</a>: <?php echo $regular_order;?><br>
            <a class="desc" href="<?php echo site_url('sales_order/index/others');?>">Others Order</a>: <?php echo $others_order;?><br>
            <a class="desc" href="#">Total Order</a>: <?php echo $total_order;?>
        </div>
    </div>
    <a class="more" href="javascript:;">
        ORDER INFO <i class="m-icon-swapright m-icon-white"></i>
    </a>
</div>
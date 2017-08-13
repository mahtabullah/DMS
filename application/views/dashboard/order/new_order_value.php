
<div class="dashboard-stat yellow">
    <div class="visual">
        <i class="fa fa-bar-chart-o"></i>
    </div>
    <div class="details">
        <div class="number">
        </div>
        <div class="desc">
            Order In Case: <?php echo $order_in_case?> <br />
            Order In (8oz): <?php echo number_format((float)$volume_in_oz, 2, '.', '');?> <br />
            Value: <?php echo $order_value;?> TK
        </div>
    </div>
   

    <a class="more" href="javascript:;">
        Order Report <i class="m-icon-swapright m-icon-white"></i>
    </a>
</div>
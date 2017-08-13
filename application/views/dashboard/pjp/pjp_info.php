<div class="dashboard-stat green">
    <div class="visual">
        <i class="fa fa-comments"></i>
    </div>
    <div class="details" style="margin-top: 5px;">
        <div class="number">
        </div>
        <div class="desc" >
            <h5 class="font">Schedule Call : <?php echo $num_of_outlet;?></h5>
            <h5 class="font">No of Visited Outlet  : <?php echo $visited_outlet;?></h5>
            <h5 class="font">No of Non Visited Outlet  : <?php echo $red; ?></h5>
        </div>
    </div>
    <a class="more" href="<?php echo site_url('report/sr_market_pjp/'.$start_date.'/'.$end_date); ?>">
        Visit Status [As of Now] <i class="m-icon-swapright m-icon-white"></i>
    </a>
</div>
<style type="text/css">

.font{
    color: white;
    margin-top : 0px;
    margin-bottom: 0px;

}

</style>
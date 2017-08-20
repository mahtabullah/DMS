<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <h3 class="page-title">
            Current Stock
        </h3>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="">Current Stock</a>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div class="row">
    <div class="col-md-4" id="filter">

    </div>
</div>
<br />




<div class="box box-default">
    <div class="box-title">

        <div class="box-header with-border">
            <h3 class="box-title">Current Stock</h3>
            <div class="box-tools pull-right">
                <div class="actions">

                </div>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->

    </div>
    <div class="box-body">

        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_4">
            <thead>
                <tr>
                    <th style="text-align: center;" rowspan="2">
                        SL No.
                    </th>
                    <th style="text-align: center;" rowspan="2">
                        Sku name
                    </th>
                    <th style="text-align: center;" rowspan="2">
                        Pack Size
                    </th>

                    <th style="text-align: center;" rowspan="2">
                        Price
                    </th>
                    <th style="text-align: center;" colspan="3">
                        Total Stock
                    </th>


                </tr>
                <tr>

                    <th style="text-align: center;">
                        CS
                    </th>
                    <th style="text-align: center;">
                        PS
                    </th>
                    <th style="text-align: center;">
                        Value
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                $Total_Qty = 0;
                $Total_value = 0;
                foreach ($current_stock as $rp_i) {
                    ?>
                    <?php $Total_Qty += $rp_i['Total_Qty']; ?>

                    <tr >
                        <td>
                            <?php
                            echo $sl;
                            $sl++;
                            ?>
                        </td>
                        <td>
    <?php echo $rp_i['sku_name']; ?>
                        </td>
                        <td>
    <?php echo $rp_i['Pack_Size']; ?>
                        </td>

                        <td style="text-align: right;">
    <?php echo $rp_i['Price']; ?>
                        </td>
                        <td style="text-align: right;">
    <?php echo $rp_i['Total_Qty_cs']; ?>
                        </td>
                        <td style="text-align: right;">
    <?php echo $rp_i['Total_Qty_ps']; ?>
                        </td>
                        <td style="text-align:right;">
    <?php echo round($rp_i['Total_Qty'] * $rp_i['Price']*$rp_i['Pack_Size'],2);
    $Total_value += $rp_i['Total_Qty'] * $rp_i['Price']*$rp_i['Pack_Size'];
    ?>
                        </td>

                    </tr>
<?php } ?>

            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right;" colspan="4">
                        Total
                    </td>
                    <td style="text-align: right;" colspan="2">
                        <?php echo round($Total_Qty,2); ?>
                    </td>
                    <td style="text-align: right;" >
                    <?php echo round($Total_value,2); ?>
                    </td>

                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>

<?php
$this->load->view('footer/footer');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sample_4').DataTable({
            dom: 'T<"clear">lfrtip',
            "bSort": false,
            "paging": false,
            searching: true,
            "iDisplayLength": 100
        });
    });
</script>
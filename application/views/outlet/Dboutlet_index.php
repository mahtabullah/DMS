<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Default box -->

<div class="row">
    <div class="col-md-12">

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Outlet List</h3>
                <div class="box-tools pull-right">
                    <div class="actions">
                        <a href="<?php echo site_url('outlet/createOutlets'); ?>" id="add_route"><button class="btn btn-block btn-primary btn-sm"><i class="fa fa-plus"></i> Create Outlet</button></a>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="table-responsive">
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_3">
                                <thead>
                                    <tr>
                                        <th class="center bold">
                                            Code
                                        </th>
                                        <th class="center bold">
                                            Name
                                        </th>

                                        <th class="center bold">
                                            Address
                                        </th>
                                        <th class="center bold">
                                            Sub Route
                                        </th>
                                        <th class="center bold">
                                            Owner Name
                                        </th>
                                        <th class="center bold">
                                            Owner Mobile No.
                                        </th>
                                        <th class="center bold">
                                            VisiCooler
                                        </th>
                                        <th class="center bold">
                                            Status
                                        </th>

                                        <th class="center bold">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_cycle">
                                    <?php
                                    foreach ($outlet as $key) {
                                        ?>

                                        <tr id="row_attr">
                                            <td class="center">
                                                <?php
                                                echo $key['outlet_code'];
                                                ?>
                                            </td>
                                            <td class="center">

                                                <?php
                                                echo $key['outlet_name'];
                                                ?>
                                            </td>

                                            <td class="center">
                                                <?php
                                                echo $key['address_name'];
                                                ?>
                                            </td>
                                            <td class="center">
                                                <?php
                                                echo $key['db_channel_element_name'];
                                                ?>
                                            </td>

                                            <td class="center">
                                                <?php
                                                echo $key['outlet_owner'];
                                                ?>
                                            </td>
                                            <td class="center">
                                                <?php
                                                echo $key['mobile1'];
                                                ?>
                                            </td>
                                            <td class="center">
                                                <?php
                                                if ($key['visicooler'] == 1) {
                                                    echo 'Yes';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </td>

                                            <td class="center">
                                                <?php
                                                if ($key['status'] == '1') {
                                                    echo 'Active';
                                                } elseif ($key['status'] == '2') {
                                                    echo 'Inactive';
                                                } else {
                                                    echo 'Inactive';
                                                }
                                                ?>
                                            </td>

                                            <td class="center">                                       

                                                <a href="<?php echo base_url() . 'outlet/outletEditById/' . $key['outlet_id']; ?>" target="_blank"><button class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> Edit </button></a>
                                                <?php
                                                if ($key['status'] == '1') {
                                                    ?>
                                                    <a href="<?php echo base_url() . 'outlet/outletActiveById/' . $key['outlet_id']; ?>/2" target="_blank"><button class="btn btn-block btn-primary btn-xs">InActive</button></a>
                                                    <?php
                                                } elseif ($key['status'] == '2') {
                                                    ?>
                                                    <a href="<?php echo base_url() . 'outlet/outletActiveById/' . $key['outlet_id']; ?>/1" target="_blank"><button class="btn btn-xs blue"><i class="fa fa-pencil"></i> Active </button></a>
                                                    <?php
                                                } else {
                                                    echo 'Inactive';
                                                }
                                                ?>


                                            </td>    
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>




            <div class="box-footer">
                Footer
            </div>   </div>
    </div>
    <!-- /.box-footer--> </div><!-- /.box-body -->

</section>
</div>
<?php $this->load->view('footer/footer'); ?>

<script>
    $(document).ready(function () {
        $("#sample_3").DataTable({
            dom: 'T<"clear">lfrtip'
        });
    });
</script>
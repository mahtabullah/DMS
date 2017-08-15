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
                        <a href="<?php echo site_url('outlet/createOutlets'); ?>" id="add_route"><button class="btn btn-block btn-primary btn-sm"> <i class="fa fa-plus"></i> Create Route</button></a>
                    </div>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">

                <div class="table-responsive">
                    <div class="portlet-body">
                        <div class="table-scrollable">

                            <table class="table table-striped table-bordered table-hover table-full-width" id="routetable">
                                <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Code
                                        </th>
                                        <th>
                                            Description
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Parent
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($route as $distribution_channel) { ?>
                                        <tr>

                                            <td>
                                                <?php echo $distribution_channel['db_channel_element_name']; ?>
                                            </td>
                                            <td>	
                                                <?php echo $distribution_channel['db_channel_element_code']; ?>
                                            </td>

                                            <td>
                                                <?php echo $distribution_channel['db_channel_element_description']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $distribution_channel['db_channel_element_category_id'];
                                                //var_dump($parent_ids);
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo $distribution_channel['Parent_Route'];
                                                ?>

                                            </td>

                                            <td class="">
                                                <a href="<?php
                                                $segments = array('distribution_channel', 'edit', $distribution_channel['id']);
                                                echo site_url($segments);
                                                ?>" data-id="1" class="btn btn-xs blue btn-editable" onclick="return confirm('Are you sure Edit this item?')"><i class="fa fa-pencil"></i> Edit</a>
                                                <a href="<?php
                                                $segments = array('distribution_channel', 'delete', $distribution_channel['id']);
                                                echo site_url($segments);
                                                ?>" data-id="1" class="btn btn-xs red btn-removable" onclick="return confirm('Are you sure Delete this item?')"><i class="fa fa-times"></i> Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

</section>
</div>
<?php $this->load->view('footer/footer'); ?>

<script>
    $(function () {

        $('#routetable').DataTable({
            dom: 'T<"clear">lfrtip'
        });
    });
</script>
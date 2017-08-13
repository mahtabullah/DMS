<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 class="page-title">
                    DB Type Info
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>DB Type Info</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>DB type Info
                </div>
                <div class="actions">
                    <a href="<?php echo site_url('db_house/createDbType'); ?>" class="btn green" id="add_route"><i class="fa fa-plus"></i>Create DB Type</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
                        <thead>
                        <tr>
                            <th class="bold">
                                SL No.
                            </th>
                            <th class="bold">
                                DB Type Name
                            </th>
                            <th class="bold">
                                Code
                            </th>
                            <th class="bold">
                                Description
                            </th>
                            <th class="bold">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach ($type as $type) {  $i++;?>
                            <tr>

                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $type['name']; ?>
                                </td>

                                <td>
                                    <?php echo $type['code']; ?>
                                </td>

                                <td>
                                    <?php echo $type['description']; ?>
                                </td>
                                <td>
                                    <button class="btn btn-xs blue" onclick="ConfirmationWindow('Edit',<?php echo '\''.base_url().'db_house/dbTypeEditById/'.$type['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Edit </button>
                                    <button class="btn btn-xs red" onclick="ConfirmationWindow('Delete',<?php echo '\''.base_url().'db_house/dbTypeDeleteById/'.$type['id'].'\''; ?>);" ><i class="fa fa-pencil"></i> Delete </button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
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

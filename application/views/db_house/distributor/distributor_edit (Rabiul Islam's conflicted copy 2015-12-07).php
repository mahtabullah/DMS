<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Distributor
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('db_house/distributorIndex'); ?>">Distributor</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Edit</p>
                    </li>
                </ul>
            </div>
        </div>   
        <?php
        foreach ($distributor as $key) {
            $id = $key['id'];
            $distributor_name = $key['distributor_name'];
            $distributor_code = $key['distributor_code'];
            $distributor_description = $key['distributor_description'];
            $distributor_address_id = $key['distributor_address_id'];
        }
        ?>
        <div class="row"> 
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                           
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form role="form" action="<?php $segments = array('db_house', 'distributorUpdateById', $id); echo site_url($segments); ?>" method="post">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="distributor_name">Distributor Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Distributor Name" id="distributor_name" name="distributor_name" value="<?php echo $distributor_name;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="distributor_code">Distributor Code</label>
                                        <input type="text" class="form-control" placeholder="Enter Distributor Code" id="distributor_code" name="distributor_code" value="<?php echo $distributor_code;?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="distributor_description">Distributor Description</label>
                                       
                                        <textarea  class="form-control" rows="4"  placeholder="Enter Distributor Description" id="distributor_description" name="distributor_description"><?php echo $distributor_description;?></textarea>
                                    </div>
                                    <div class="col-md-6">

                                            <label for="distributor_address_name">Address</label>
                                            <?php 
                                                $address_name = '';
                                                foreach ($address as $key) {
                                                if($key['id'] == $distributor_address_id){
                                                        $address_name = $key['address_name'];
                                                    }

                                                }
                                                ?>
                                            <input type="text" class="form-control" placeholder="Distributor Address" id="distributor_address_name" name="distributor_address_name" value="<?php echo $address_name;?>"><input type="text" class="form-control" placeholder="Distributor Address" id="distributor_address_id" name="distributor_address_id" value="<?php echo $distributor_address_id;?>" style="visibility: hidden;">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Update</button>
                                    <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('db_house/distributorIndex');?>'">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer/footer');
?>
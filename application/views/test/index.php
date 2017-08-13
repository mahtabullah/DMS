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
                    Test
                </h3>
                <ul class="page-breadcrumb breadcrumb">


                    <li>
                        Test
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">

                <div id="geo_layer_filter"></div>





        </div>

        <div class="row">
            <table class="table table-bordered table-full-width" id="datatable">
                <thead>
                <tr>
                    <th>column_1</th>
                    <th>column_2</th>
                    <th>column_3</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td rowspan="2">Wide column</td>
                    <td>Normal column</td>
                    <td>Normal column</td>
                </tr>
                <tr>
                    <td style="display:none;"></td>
                    <td>Normal column</td>
                    <td>Normal column</td>
                </tr>
                </tbody>
            </table>
        </div>




    </div>
</div>

<?php
$this->load->view('footer/footer');
?>

<script type="text/javascript">
    $(document).ready(function(){
        //geoLayerFilterInit('#geo_layer_filter','single');

        DataTable('#datatable');
    });


</script>

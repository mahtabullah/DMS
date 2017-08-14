<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<div class="row">

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Inbox</h3>

            </div><!-- /.box-header -->
            <div class="box-body no-padding">

            </div><!-- /.box-body -->
            <div class="box-footer no-padding">

            </div>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div><!-- /.row -->



<?php
$this->load->view('footer/footer');
?>
<script>

</script>

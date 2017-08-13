 <?php
            $user_role_code = $this->session->userdata('user_role_code');
            
             if ($user_role_code == 'DB') {
                 $this->load->view('left/left_DB', $data);
             }elseif ($user_role_code == 'CE') {
                 $this->load->view('left/left_CE', $data);
             }elseif ($user_role_code == 'TDM') {
                 $this->load->view('left/left_TDM', $data);
             }elseif ($user_role_code == 'USM') {
                 $this->load->view('left/left_USM', $data);
             }elseif ($user_role_code == 'NSM') {
                 $this->load->view('left/left_NSM', $data);
             }elseif ($user_role_code == 'MIS') {
                   $this->load->view('left/left_MIS', $data);
             }
             ?>

<div class="content-wrapper">
    <section class="content">

        <div class="page-content">
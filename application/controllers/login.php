<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Logins');
        $this->load->model('Users');
        $this->load->model('Homes');
    }

    public function user_login() {
        $user = $this->input->post('username');
        $password = $this->input->post('password');

        $verify_user_pass = $this->Logins->verify_user_pass($user, $password);

        if (count($verify_user_pass) != 0) {
            $usr_id = $this->Logins->getUserIdByUser($user);

            foreach ($usr_id as $usr) {
                $user_id = $usr['id'];
            }
            $verify_user_status = $this->Logins->verify_user_status($user_id);

            foreach ($verify_user_status as $status) {
                $user_status = $status['user_role_status'];
            }
            if ($user_status == 1) {
                $user_role = $this->Logins->getUserRoleByUserId($user_id);
                foreach ($user_role as $user_role_name) {
                    $user_role_id = $user_role_name['user_role_id'];
                }

                $user_role_name = $this->Logins->getUserRoleNameByUserId($user_role_id);
                $emp_info = $this->Users->getEmpInfoByUserId($user_id);
                $web_service_name = $this->Logins->getWebServiceName();

                foreach ($user_role as $role) {
                    foreach ($emp_info['query'] as $info) {
                        foreach ($user_role_name as $user_role_names) {
                            $this->session->set_userdata(array('user_id' => $user_id, 'user_role' => $role['user_role_id'], 'user_role_code' => $user_role_names['user_role_code'], 'emp_id' => $info['id'], 'db_id' => $info['distribution_house_id'], 'biz_zone_id' => $info['biz_zone_id'], 'emp_name' => $info['first_name'], 'sales_emp_code' => $info['sales_emp_code'], 'emp_type' => $emp_info['emp_type'], 'web_service_name' => $web_service_name[0]['config_code']));
                        }
                    }
                }
                $db_id = $info['distribution_house_id'];
                $db_name_info = $this->Users->getNameInfobyDbId($db_id);
                $System_date=$db_name_info['System_date'];
                if(empty($System_date)){
                    $System_date=date('Y-m-d');
                   // $System_date="2017-08-14";
                }
                $arrayData = array('dbhouse_name' => $db_name_info['dbhouse_name'], 'System_date' => $System_date, 'db_address_name' => $db_name_info['address_name']);
               
                $this->session->set_userdata($arrayData);


                $user_role_id = $this->session->userdata('user_role');
                $emp_id = $this->session->userdata('emp_id');
                $biz_zone_id = $this->session->userdata('biz_zone_id');

                if ($db_id != '') {
                    $db_info = $this->Users->dbInfoByDbId($db_id);
                    $db_active_status = $db_info[0]['db_house_status'];
                }
                if ($db_active_status == 2) {
                    $data['incorrectLogin_flag'] = 4;
                    $this->load->view('login/login', $data);
                } else {

                    if ($user_role_id == 4 || $user_role_id == 5 || $user_role_id == 6 || $user_role_id == 7) {
                        $this->Homes->user_info_log($user_id, $biz_zone_id, $emp_id, $user_role_id);
                    }

                   redirect(site_url('home/home_page'));
                }
            } else {

                $data['incorrectLogin_flag'] = 2;
                $this->load->view('login/login', $data);
            }
        } else {
            $data['incorrectLogin_flag'] = 1;
            $this->load->view('login/login', $data);
        }
    }

    public function user_logout($id) {
        $this->session->set_userdata(array('user_id' => '', 'user_role' => ''));
        $data['incorrectLogin_flag'] = $id;
        $this->load->view('login/login', $data);
    }

    public function profile() {
        $emp_id = $this->session->userdata('emp_id');
        $data['user_details'] = $this->Users->get_user_profile($emp_id);
        $this->load->view('profile/profile', $data);
    }

}

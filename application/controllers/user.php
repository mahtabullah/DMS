<?php

    if( !defined('BASEPATH')){
        exit('No direct script access allowed');
    }

    class User extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->model('Users');
            $this->load->model('Logins');
            $this->method_call = &get_instance();
        }

        public function index()
        {
            $data['tbld_user_role']  = $this->Users->get_tbld_user_role();
            $data['tbld_user_group'] = $this->Users->get_tbld_user_group();
            $data['tbld_user']       = $this->Users->get_tbld_user();
            $this->load->view('user/user_configuration/user_view', $data);
        }

        public function get_user_role_by_id($id)
        {
            $user_role_by_id = $this->Users->get_user_role_by_id($id);

            return $user_role_by_id['user_role_name'];
        }

        public function passsChangeIndex()
        {
            $data['msg'] = "";
            $this->load->view('user/change_user_pass', $data);
        }

        public function user_role()
        {
            $data['tbld_user_role'] = $this->Users->get_tbld_user_role();
            $this->load->view('user/user_role_view', $data);
        }

        public function user_group()
        {
            $data['tbld_user_group'] = $this->Users->get_tbld_user_group();
            $this->load->view('user/user_group_view', $data);
        }

        public function get_user_group_by_id($id)
        {
            $user_group_by_id = $this->Users->get_user_group_by_id($id);

            return $user_group_by_id['user_group_name'];
        }

        public function user_role_add()
        {
            $data['tbld_user_role'] = $this->Users->get_tbld_user_role();
            $this->load->view('user/user_role_add', $data);
        }

        public function user_role_save()
        {
            $data['user_role_name']        = $this->input->post('user_role_name');
            $data['user_role_code']        = $this->input->post('user_role_code');
            $data['user_role_description'] = $this->input->post('user_role_description');

            $datas = $this->Users->save_user_role($data);
            if($datas){

                redirect(site_url('user/user_role'));
            }
        }

        public function user_group_add()
        {
            $data['tbld_user_group'] = $this->Users->get_tbld_user_group();
            $this->load->view('user/user_group_add', $data);
        }

        public function user_group_save()
        {
            $data['user_group_name']        = $this->input->post('user_group_name');
            $data['user_group_code']        = $this->input->post('user_group_code');
            $data['user_group_description'] = $this->input->post('user_group_description');

            $datas = $this->Users->user_group_save($data);
            if($datas){

                redirect(site_url('user/user_group'));
            }
        }

        public function user_add()
        {
            $data['tbld_user_role']  = $this->Users->get_tbld_user_role();
            $data['tbld_user_group'] = $this->Users->get_tbld_user_group();
            $this->load->view('user/user_configuration/user_add', $data);
        }

        public function user_save()
        {
            $data['user_name']     = $this->input->post('user_name');
            $data['user_id']       = $this->input->post('user_id');
            $data['user_email']    = $this->input->post('user_email');
            $data['user_password'] = $this->input->post('user_password');
            

            $insert_id = $this->Users->user_save($data);

            if($insert_id){

                $data_g['user_id']          = $insert_id;
                $data_g['user_group_id']    = $this->input->post('user_group_id');
                $inser                      = $this->Users->user_group_mapping_save($data_g);
                $data_r['user_id']          = $insert_id;
                $data_r['user_role_id']     = $this->input->post('user_role_id');
                $data_r['user_role_status'] = 1;
                $inserts                    = $this->Users->user_role_mapping_save($data_r);
                if($inserts){
                    redirect(site_url('user/index'));
                }
            } else{

                $this->load->view('user/user_configuration/user_add', $error_mg);

            }
        }

        public function user_role_view_edit($id)
        {
            $data['user_role'] = $this->Users->get_tbld_user_role_by_id($id);
            $this->load->view('user/user_role_view_edit', $data);
        }

        public function user_role_view_edit_done($id)
        {
            $data   = array(
                'user_role_name'        => $this->input->post('user_role_name'),
                'user_role_code'        => $this->input->post('user_role_code'),
                'user_role_description' => $this->input->post('user_role_description')
            );
            $update = $this->Users->update_tbld_user_role($id, $data);
            if($update){
                redirect(site_url('user/user_role'));
            }
        }

        public function user_role_view_delete($id)
        {
            $del = $this->Users->delete_tbld_user_role_by_id($id);
            redirect(site_url('user/user_role'));
        }

        public function user_group_view_edit($id)
        {
            $data['user_group'] = $this->Users->get_tbld_user_group_by_id($id);
            $this->load->view('user/user_group_view_edit', $data);
        }

        public function user_group_view_edit_done($id)
        {
            $data   = array(
                'user_group_name'        => $this->input->post('user_group_name'),
                'user_group_code'        => $this->input->post('user_group_code'),
                'user_group_description' => $this->input->post('user_group_description')
            );
            $update = $this->Users->update_tbld_user_group($id, $data);
            if($update){
                redirect(site_url('user/user_group'));
            }
        }

        public function user_group_view_delete($id)
        {
            $del = $this->Users->delete_tbld_user_group_by_id($id);
            redirect(site_url('user/user_group'));
        }

        public function user_view_edit($id)
        {
            $data['user_role_by_id']  = $this->Users->get_tbld_role_by_id($id);
            $data['user_group_by_id'] = $this->Users->get_tbld_group_by_id($id);
            $data['user']             = $this->Users->get_tbld_user_id($id);
            $data['tbld_user_role']   = $this->Users->get_tbld_user_role();
            $data['tbld_user_group']  = $this->Users->get_tbld_user_group();
            $this->load->view('user/user_configuration/user_view_edit', $data);
        }

        public function user_view_edit_done($id)
        {
            $data        = array(
                'user_id'       => $this->input->post('user_id'),
                'user_name'     => $this->input->post('user_name'),
                'user_password' => $this->input->post('user_password'),
                'user_email'    => $this->input->post('user_email'),
            );
            $update_user = $this->Users->update_tbld_user($id, $data);

            $user_id                     = $id;
            $data_group['user_group_id'] = $this->input->post('user_group_id');

            $update_group              = $this->Users->update_tbld_user_group_mapping_by_id($user_id, $data_group);
            $user_id                   = $id;
            $data_role['user_role_id'] = $this->input->post('user_role_id');

            $update_role = $this->Users->update_tbli_user_role_mapping_by_id($user_id, $data_role);

            if($update_user){
                redirect(site_url('user/index'));
            }
        }

        public function user_view_delete($id)
        {
            $del = $this->Users->delete_tbld_user_by_id($id);
            redirect(site_url('user/index'));
        }

        public function update_user_pass()
        {
            $prev_pass         = $this->input->post('prev_pass');
            $new_pass          = $this->input->post('new_pass');
            $user              = $this->session->userdata('user_id');
            $pass_verification = $this->Logins->verify_user_pass_by_id($user, $prev_pass);
            $data['msg']       = "";
            if(count($pass_verification) != 0){
                $data             = array("user_password" => $new_pass);
                $update_user_pass = $this->Users->updatePassByUser($user, $data);
                redirect(site_url('user/passsChangeIndex'));
            } else{
                $data['msg'] = "Passwords do not Match";
                $this->load->view('user/change_user_pass', $data);
            }
        }

    }
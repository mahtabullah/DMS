<?php

    if( !defined('BASEPATH')) exit('No direct script access allowed');

    class Home extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('Homes');
            //$this->load->model('Sales_orders');

        }

        public function index()
        {
            $data['incorrectLogin_flag'] = 0;
            $this->load->view('login/login', $data);
        }

        public function new_order_qty()
        {
            $db_ids       = $this->getDbIds();
            $start_date   = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date     = date('Y-m-d', strtotime($this->input->post('end_date')));
            $num_of_order = $this->Homes->new_order_qty($start_date, $end_date, $db_ids);

            $regular_order = $this->Homes->new_regular_order_qty($start_date, $end_date, $db_ids);
            $data['regular_order'] = $regular_order[0]['num_of_order'];
            $others_order         = $this->Homes->new_others_order_qty($start_date, $end_date, $db_ids);
            $data['others_order'] = $others_order[0]['num_of_order'];

            $sr_list               = $this->getSrList();
            $pjp_status            = $this->Homes->outlet_pjp_status($start_date, $end_date, $sr_list);
            //$data['regular_order'] = $pjp_status[0]['green'] + $pjp_status[0]['yellow'];
            
            $data['total_order'] = $data['regular_order'] + $data['others_order'];
            
                    
            $this->load->view('dashboard/order/new_order_qty', $data);
        }




        public function get_db_info()
        {
            $db_ids       = $this->getDbIds();

            $start_date   = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date     = date('Y-m-d', strtotime($this->input->post('end_date')));

            $num_of_db      = $this->Homes->get_no_of_db($db_ids);            
            $num_of_outlet  = $this->Homes->get_no_of_outlet($db_ids);
            $no_of_sub_route= $this->Homes->get_no_of_sub_route($db_ids);

            $data['no_of_outle'] = $num_of_outlet[0]['no_of_outlet'];
            $data['no_of_sub_route'] = $no_of_sub_route[0]['no_of_sub_route'];
            $data['no_of_db'] = $num_of_db[0]['no_of_db'];            
            

            $this->load->view('dashboard/db_info/db_info', $data);
        }



        public function get_sr_info()
        {
            $db_ids       = $this->getDbIds();
            $start_date   = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date     = date('Y-m-d', strtotime($this->input->post('end_date')));
            $num_of_db_op = $this->Homes->get_db_operator($db_ids);
            $num_of_psr = $this->Homes->get_no_of_psr($db_ids);
            $mv = $this->Homes->get_mv($db_ids);
            $nmv = $this->Homes->get_nmv($db_ids);
            $data['db_operator'] = $num_of_db_op[0]['db_operator'];
            $data['no_of_psr'] = $num_of_psr[0]['no_of_psr'];
            $data['mv'] = $mv[0]['mv'];
            $data['nmv'] = $nmv[0]['nmv'];


            $this->load->view('dashboard/db_info/sr_info', $data);
        }

        public function getDbIds()
        {

            $user_role_code = $this->session->userdata('user_role_code');
            $biz_zone_id    = $this->session->userdata('biz_zone_id');

            if($user_role_code == 'DB'){
                $db_id  = $this->session->userdata('db_id');
                $db_ids = "=$db_id";
            } else{
                if($user_role_code == 'MIS'){
                    $db_ids = "";
                } else{
                    if($user_role_code == 'TM' || $user_role_code == 'RSM' ||
                            $user_role_code == 'TDM' || $user_role_code == 'CE' || $user_role_code == 'USM'  || $user_role_code == 'NSM'  
                    ){
                        $db_ids = $this->Homes->getDBIds($biz_zone_id);
                        $db_ids = " IN (" . $db_ids[0]['dbhouse_id'] . ")";
                    }
                }
            }

            return $db_ids;
        }

        public function getSrList()
        {
            $db_ids  = $this->getDbIds();
            $sr_list = $this->Homes->getDbSrList($db_ids);
            $sr_list = $sr_list[0]['sr_list'];
            if($sr_list != ''){
                $result = "IN($sr_list)";
            } else{
                $result = "";
            }

            return $result;
        }

        public function new_order_value()
        {
            $db_ids                = $this->getDbIds();
            $start_date            = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date              = date('Y-m-d', strtotime($this->input->post('end_date')));
            $order_info            = $this->Homes->new_order_value($start_date, $end_date, $db_ids);
            $order_in_case_info    = $this->Homes->new_order_case_volume($start_date, $end_date, $db_ids);
            $data['volume_in_oz']  = $order_info[0]['order_volume'];
            $data['order_value']  = $order_info[0]['order_value'];
            $data['order_in_case'] = $order_in_case_info[0]['final_order_case'];

            $this->load->view('dashboard/order/new_order_value', $data);
        }

        public function outlet_pjp_info()
        {

            $sr_list               = $this->getSrList();
            $start_date            = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date              = date('Y-m-d', strtotime($this->input->post('end_date')));
            $num_of_outlet         = $this->Homes->outlet_pjp_info($start_date, $end_date, $sr_list);
            $data['num_of_outlet'] = $num_of_outlet[0]['num_of_outlet'];
            $pjp_status            = $this->Homes->outlet_pjp_status($start_date, $end_date, $sr_list);
            $data['green']         = $pjp_status[0]['green'];
            $data['yellow']        = $pjp_status[0]['yellow'];
            $data['exception_reason']  = $pjp_status[0]['exception_reason'];
            $data['red']           = $pjp_status[0]['red'];
            $data['visited_outlet'] = $data['green'] + $data['yellow']+$data['exception_reason'];
            $data['start_date']    = date('d-m-Y', strtotime($start_date));
            $data['end_date']      = date('d-m-Y', strtotime($end_date));
            $this->load->view('dashboard/pjp/pjp_info', $data);
        }

        public function purchase_order_info()
        {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date   = date('Y-m-d', strtotime($this->input->post('end_date')));
            $this->load->view('dashboard/order/purchase_order_info', $data);
        }

        public function target_info()
        {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date   = date('Y-m-d', strtotime($this->input->post('end_date')));
            $this->load->view('dashboard/target/info', $data);
        }

        public function productivity_info()
        {
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date   = date('Y-m-d', strtotime($this->input->post('end_date')));
            $this->load->view('dashboard/productivity/info', $data);
        }

        public function outlet_target_vs_achievement()
        {

            $sr_list               = $this->getSrList();
            $data['start_date']            = date('Y-m-d', strtotime($this->input->post('start_date')));
            $data['end_date']              = date('Y-m-d', strtotime($this->input->post('end_date')));
            $num_of_outlet         = $this->Homes->outlet_pjp_info($data['start_date'], $data['end_date'], $sr_list);
            $data['num_of_outlet'] = $num_of_outlet[0]['num_of_outlet'];
            $pjp_status            = $this->Homes->outlet_pjp_status($data['start_date'], $data['end_date'], $sr_list);
            $data['visited']       = $num_of_outlet[0]['num_of_outlet'] - $pjp_status[0]['red'];
            $this->load->view('dashboard/outlet_target_vs_achievement/index', $data);
        }


        public function getCurrentTargetInfo($date){
            $id = $this->Homes->getCurrentTargetInfo($date);
            return $id;
        }

        public function sku_target_vs_achievement()
                {
                    $db_ids      = $this->getDbIds();
                    $data['start_date']            = date('Y-m-d', strtotime($this->input->post('start_date')));
                    $data['end_date']              = date('Y-m-d', strtotime($this->input->post('end_date')));
                    $target_info = $this->getCurrentTargetInfo($data['end_date']);
                    $target_id = $target_info[0]['id'];
                    $target_start_date = $target_info[0]['start_date'];
                    $target_end_date = $target_info[0]['end_date'];
                    $target = $this->Homes->getTargetById($target_id,$db_ids);
                    $data['target']       = round($target[0]['target_case'],2);
                    $achievement = $this->Homes->getAchievementById($target_id,$db_ids,$target_start_date,$target_end_date);
                    $data['achievement']       = round($achievement[0]['achievement_case'],2);
                    $this->load->view('dashboard/sku_target_vs_achievement/index', $data);
                }

        public function slow_moving_sku()
        {
            $db_ids      = $this->getDbIds();
            $start_date  = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date    = date('Y-m-d', strtotime($this->input->post('end_date')));
            $data['sku'] = $this->Homes->slow_moving_sku($start_date, $end_date, $db_ids);
            $this->load->view('dashboard/slow_moving_sku/index', $data);
        }

        public function brand_wise_sales()
        {
            $db_ids        = $this->getDbIds();
            $data['start_date']    = date('Y-m-d', strtotime($this->input->post('start_date')));
            $data['end_date']      = date('Y-m-d', strtotime($this->input->post('end_date')));
            $data['sales'] = $this->Homes->brand_wise_sales($data['start_date'], $data['end_date'], $db_ids);
            $this->load->view('dashboard/brand_wise_sales/index', $data);
        }

        public function getScheduleCall($db_id,$start_date,$end_date){
            $result = $this->Homes->getScheduleCall($db_id,$start_date,$end_date);
            return $result[0]['schedule_call'];
        }
        public function getProductiveMemo($db_id,$start_date,$end_date){

            $where = '';
            if($db_id != ''){

                $sr_id = $this->Homes->getSrIdsByDbIds($db_id);
                foreach ($sr_id as $v){
                    $srId[] = $v['id'];
                }
                $sr_ids = implode(',',$srId);
                $where = " and dist_emp_id in ($sr_ids)";
            } else {

                $where = '';
            }

            //$result = $this->Homes->getProductiveMemo($where,$start_date,$end_date);
            $result = $this->Homes->getProductiveMemoNew($where,$start_date,$end_date);

            return $result[0]['green'] +$result[0]['yellow'] ;
        }

        public function getTlsd($db_id,$start_date,$end_date){
            $result = $this->Homes->getTlsd($db_id,$start_date,$end_date);
            return $result[0]['line_count'];
        }

        public function getTargetCase($db_id,$start_date,$end_date){
            $target_info = $this->getCurrentTargetInfo($end_date);
            $target_id = $target_info[0]['id'];
            $target_start_date = $target_info[0]['start_date'];
            $target_end_date = $target_info[0]['end_date'];
            $target = $this->Homes->getTargetById($target_id,$db_id);
            return $target[0]['target_case'];
        }

        public function getOrderCase($db_id,$start_date,$end_date){
            $result = $this->Homes->getOrderCase($db_id,$start_date,$end_date);
            return $result[0]['order_case'];
        }


        public function getWorkingDay(){
            $result =  $this->Homes->getWorkingDay();
            return $result[0]['total_day'];
        }



        public function order_kpi()
        {

            $db_ids        = $this->getDbIds();
            $start_date    = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date      = date('Y-m-d', strtotime($this->input->post('end_date')));

            $date1 = new DateTime($start_date);
            $date2 = new DateTime($end_date);

            $diff = $date2->diff($date1)->format("%a") + 1;


            $data['schedule_call'] = $this->getScheduleCall($db_ids,$start_date,$end_date);
            $data['productive_memo'] = $this->getMobileMemo($db_ids,$start_date,$end_date);
            $data['strike_rate'] =  round(($data['productive_memo']/$data['schedule_call'])*100,2)." %";
            $data['tlsd'] = $this->getTlsd($db_ids,$start_date,$end_date);
            $data['lpsc'] = round(($data['tlsd']/$data['productive_memo']),2);
            $working_days = $this->getWorkingDay();
            $target_case = $this->getTargetCase($db_ids,$start_date,$end_date);
            $data['target_case'] = round($target_case/$working_days*$diff,2);
            $data['order_case'] = $this->getOrderCase($db_ids,$start_date,$end_date);
            $data['drop_size'] = round($data['order_case']/$data['productive_memo'],2);

            $this->load->view('dashboard/order_kpi/index', $data);
        }

        public function getMobileMemo($db_id,$start_date,$end_date){
            $where = "where t1.db_id $db_id and t1.sales_order_type_id=1 and t1.so_status !=6 and t1.planned_order_date between '$start_date' and '$end_date'";
            $result = $this->Homes->getMobileMemo($where);
            return $result[0]['productive_momo'];
        }

        public function order_vs_delivery()
        {
            $db_ids                  = $this->getDbIds();
            $data['start_date']              = date('Y-m-d', strtotime('-1 day', strtotime($this->input->post('start_date'))));
            $data['end_date']                = date('Y-m-d', strtotime($this->input->post('end_date')));
            $order       = $this->Homes->getOrder($data['start_date'], $data['end_date'], $db_ids);
            $delivery       = $this->Homes->getDelivery($data['start_date'], $data['end_date'], $db_ids);
            $data['order_value']     = $order[0]['order_value'];
            $data['delivered_value'] = $delivery[0]['delivered_value'];
            $this->load->view('dashboard/order_vs_delivery/index', $data);
        }

        public function geo_location_status()
        {

            $sr_list            = $this->getSrList();
            $start_date         = date('Y-m-d', strtotime($this->input->post('start_date')));
            $end_date           = date('Y-m-d', strtotime($this->input->post('end_date')));
            $pjp_status         = $this->Homes->outlet_pjp_status($start_date, $end_date, $sr_list);
            $data['green']      = $pjp_status[0]['green'];
            $data['yellow']     = $pjp_status[0]['yellow'];
            $data['red']        = $pjp_status[0]['red'];
            $data['exception_reason'] = $pjp_status[0]['exception_reason'];
            $data['start_date'] = date('d-m-Y', strtotime($start_date));
            $data['end_date']   = date('d-m-Y', strtotime($end_date));
            $this->load->view('dashboard/geo_location_status/index', $data);
        }

        public function home_page()
        {

            $db_id = $this->session->userdata('db_id');

            if($db_id != ''){
                $sr_ids = $this->Homes->getSrIds($db_id);
                $sr_ids = $sr_ids[0]['sr_ids'];
            } else{
                $sr_ids = '';
            }
            $current_date = date("Y-m-d");

            //        $data['new_order'] = $this->BI_Reports->new_order($current_date, $db_id);
            //        $data['total_value_volume'] = $this->Homes->getTotalValueVolume($current_date, $db_id);
            //        $data['purchase_indent'] = $this->Homes->getPurchaseIndent($current_date, $db_id);
            //        $data['total_outlet'] = $this->Homes->getTotalOutlet($current_date, $sr_ids);
            //        $data['success_outlet'] = $this->Homes->getTotalSuccessOutlet($current_date, $sr_ids);
            //        $data['not_success_outlet'] = $this->Homes->getTotalNotSuccessOutlet($current_date, $sr_ids);
            //        $data['not_covered_outlet'] = $this->Homes->getTotalNotCoveredOutlet($current_date, $sr_ids);
            //        $data['ordered_delivered'] = $this->Homes->getOrderedDelivered($current_date, $db_id);

//            $data['new_order']          = $this->Homes->new_order($current_date, $db_id);
//            $data['total_value_volume'] = $this->Homes->getTotalValueVolume($current_date, $db_id);
//            $data['purchase_indent']    = $this->Homes->getPurchaseIndent($current_date, $db_id);
//            $data['total_outlet']       = $this->Homes->getTotalOutlet($current_date, $sr_ids);
//            $data['success_outlet']     = $this->Homes->getTotalSuccessOutlet($current_date, $sr_ids);
//            $data['not_success_outlet'] = $this->Homes->getTotalNotSuccessOutlet($current_date, $sr_ids);
//            $data['not_covered_outlet'] = $this->Homes->getTotalNotCoveredOutlet($current_date, $sr_ids);
//            $data['ordered_delivered']  = $this->Homes->getOrderedDelivered($current_date, $db_id);

            //        $data['geolocation_status'] = $this->Homes->getGeoStatus($current_date);
            //        echo '<pre>';
            //        print_r($data['ordered_delivered']);
            //        echo '</pre>';
            //        die();

            //        $data['new_order'] = $this->Homes->getNewOrder($db_id);
             //       $data['new_outlet'] = $this->Homes->getNewOutlet($db_id);
            //        $data['total_purchase'] = $this->Homes->getTotalPurchase($db_id);
            //        $data['total_revenue'] = $this->Homes->getTotalRevenue($db_id);
            //        $data['product_line_a'] = $this->Homes->get_product_line_sales_A($db_id);
            //        $data['product_line_b'] = $this->Homes->get_product_line_sales_B($db_id);
            //        $data['product_line_c'] = $this->Homes->get_product_line_sales_C($db_id);
            //        $data['order_vs_actual'] = $this->Homes->order_vs_actuals($db_id);
            //        $data['geolocation_status'] = $this->Homes->geolocation_status($db_id);
            //        $data['outlet_target'] = $this->Homes->get_outlet_target($db_id);
            //        $data['outlet_achievement'] = $this->Homes->get_outlet_achievement($db_id);
            //        $data['slow_moving_sku'] = $this->Homes->get_slow_moving_sku();
            //        $data['promotional_sku_sales'] = $this->Homes->promotional_sku_sales();

            $data['db_id'] = $db_id;

            $this->load->view('home/home', $data);
        }

        public function get_target_vs_achievement()
        {
            $user_role_id = $this->session->userdata('user_role');
            $db_id        = 0;
            if($user_role_id == 3){
                $emp_id                = $this->session->userdata('emp_id');
                $distribution_house_id = $this->Sales_orders->getAllDistributionEmp($emp_id);
                foreach($distribution_house_id as $key){
                    $db_id = $key['distribution_house_id'];
                }
                $product_line = $this->Homes->get_pl_by_db($db_id);
                $pl           = implode(', ', $product_line);
            } elseif($user_role_id == 2){

                $get_tso_db_info = $this->Homes->get_tso_db_info($emp_id);
                foreach($get_tso_db_info as $key1){
                    $db_id = $key1['dbhouse_id'];
                }
                $pl_info = $this->Homes->get_tso_pl_info($emp_id);
                $pl      = implode(', ', $pl_info);

            } elseif($user_role_id == ''){
                $db_id = - 1;
            }
            $date_frm                   = date('Y-m-d', strtotime($this->input->post('date_frm')));
            $date_to                    = date('Y-m-d', strtotime($this->input->post('date_to')));
            $data['outlet_target']      = $this->Homes->get_outlet_target_filter($date_frm, $date_to, $db_id, $pl);
            $data['outlet_achievement'] = $this->Homes->get_outlet_achievement_filter($date_frm, $date_to, $db_id, $pl);
            $this->load->view('home/target_achievement', $data);
        }

        public function dashboard()
        {
            $data['new_order']      = $this->Homes->getNewOrder();
            $data['new_outlet']     = $this->Homes->getNewOutlet();
            $data['total_revenue']  = $this->Homes->getTotalRevenue();
            $data['total_purchase'] = $this->Homes->getTotalPurchase();
            $this->load->view('dashboard', $data);
        }

        public function dashboard1()
        {
            $data['new_order']             = $this->Homes->getNewOrder();
            $data['new_outlet']            = $this->Homes->getNewOutlet();
            $data['total_revenue']         = $this->Homes->getTotalRevenue();
            $data['total_purchase']        = $this->Homes->getTotalPurchase();
            $data['product_line_a']        = $this->Homes->get_product_line_sales_A();
            $data['product_line_b']        = $this->Homes->get_product_line_sales_B();
            $data['product_line_c']        = $this->Homes->get_product_line_sales_C();
            $data['promotional_sku_sales'] = $this->Homes->promotional_sku_sales();
            $this->load->view('dashboard1', $data);
        }

        public function dashboard2()
        {
            $data['product_line_a'] = $this->Homes->get_product_line_sales_A();
            $data['product_line_b'] = $this->Homes->get_product_line_sales_B();
            $data['product_line_c'] = $this->Homes->get_product_line_sales_C();
            $this->load->view('dashboard2', $data);
        }

        public function get_data()
        {
            $user_role_id = $this->session->userdata('user_role');
            $db_id        = 0;
            if($user_role_id == 3){
                $emp_id                = $this->session->userdata('emp_id');
                $distribution_house_id = $this->Sales_orders->getAllDistributionEmp($emp_id);
                foreach($distribution_house_id as $key){
                    $db_id = $key['distribution_house_id'];
                }
            } elseif($user_role_id == ''){
                $db_id = - 1;
            }
            $where    = null;
            $where1   = null;
            $where2   = null;
            $date_frm = date('Y-m-d', strtotime($this->input->post('date_frm')));
            $date_to  = date('Y-m-d', strtotime($this->input->post('date_to')));
            if($date_frm && $date_to){
                $where .= " AND order_date BETWEEN '$date_frm' AND '$date_to'";
            }
            if($date_frm && $date_to){
                $where1 .= " AND submit_date BETWEEN '$date_frm' AND '$date_to'";
            }
            if($date_frm && $date_to){
                $where2 .= " AND order_date BETWEEN '$date_frm' AND '$date_to'";
            }
            $data['order_value']     = $this->Homes->get_order_value($where, $db_id);
            $data['new_outlet']      = $this->Homes->get_new_outlets($where1, $db_id);
            $data['purchase_indent'] = $this->Homes->get_purchase_indents($where2, $db_id);
            $this->load->view('home/first_filter_data', $data);

        }

        public function get_so_id($where)
        {

            $sql = "SELECT * FROM `tblt_sales_order` WHERE 1";

            if($where != null){
                $sql .= $where;
            }

            $query = $this->db->query($sql);

            return $query->result_array();
        }

        public function promotional_sku_sales()
        {

            $promotional_sku_sales = $this->Homes->promotional_sku_saless();
        }

    }

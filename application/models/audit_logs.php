<?php


class Audit_logs  extends CI_Model{
    
    public function insertAuditData($audit_data){
        return   $this->db->insert('tbld_audit_log',$audit_data);
    }
    public function getAuditData(){
        
        $sql=" select t1.id,t1.user_id as tbld_audit_log_id,t1.user_role_id,t1.object_name,t1.log_data,t1.action,t1.log_date,t2.user_id as tbld_user_id ,t2.user_name,t3.user_role_name from tbld_audit_log as t1
                left join tbld_user as t2 on t2.id = t1.user_id
                left join tbld_user_role as t3 on t3.id = t1.user_role_id
              ";        
        $query = $this->db->query($sql);
        return $query->result_array();
        
        
    }
    public function getAuditDataById($id){
        
        $sql=" select t1.id,t1.user_id as tbld_audit_log_id,t1.user_role_id,t1.object_name,t1.log_data,t1.action,t1.log_date,t2.user_id as tbld_user_id ,t2.user_name,t3.user_role_name from tbld_audit_log as t1
                left join tbld_user as t2 on t2.id = t1.user_id
                left join tbld_user_role as t3 on t3.id = t1.user_role_id 
                WHERE t1.id =$id
              ";
        $query = $this->db->query($sql);
        return $query->result_array();
        
    }
}

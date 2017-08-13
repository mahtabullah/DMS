<?php

class User_accesss  extends CI_Model{

/*
 * Start Menu Category  /
 */    
    public function getAllMenuCategory(){
        $this->db->select('*');
        $query= $this->db->get('tbld_menu_category')->result_array();
        return $query;
    }
    public function insertMenuCategory($data){
        return $this->db->insert('tbld_menu_category',$data);
    }    
    public function getMenuCategoryById($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query= $this->db->get('tbld_menu_category')->result_array();
        return $query;       
    }
    public function updateMenuCategoryById($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbld_menu_category',$data);
    }
    public function deleteMenuCategoryById($id){
        $this->db->where('id',$id);
        return $this->db->delete('tbld_menu_category');
    }
    
/*
 * End Menu Category  /
 */
    
/*
 * Start Menu/    
 */
    public function getAllMenu(){
        $sql=" SELECT t1.id,t1.name,t1.code,t1.show_text,t1.controller,t1.function,t1.status,t3.name as category_name,t2.id as parent_id, t2.name as parent_name FROM `tbld_menu` as t1
                left join tbld_menu as t2 on t1.parent_id=t2.id
                left join tbld_menu_category as t3 on t1.menu_category_id=t3.id
                order by t1.id ";
        
        $query= $this->db->query($sql)->result_array();
        return $query;
    }    
    public function insertMenu($data){
        return $this->db->insert('tbld_menu',$data);
    }
    public function getMenuById($id){        
        $this->db->select('*');
        $this->db->where('id',$id);
        $query= $this->db->get('tbld_menu')->result_array();
        return $query;    
    }
    public function updateMenuById($id,$data){
         $this->db->where('id',$id);
        return $this->db->update('tbld_menu',$data);
    }
    public function deleteMenuById($id){
        $this->db->where('id',$id);
        return $this->db->delete('tbld_menu');
    }

/*
 * End Menu/
 */

    public function getUserRole(){
        $sql = "SELECT id,user_role_name FROM tbld_user_role";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    Public function insertUserRoleMenuMapping($data){
        return $this->db->insert('tbli_user_role_menu_mapping', $data);
        //return $this->db->insert_id();
    }

}

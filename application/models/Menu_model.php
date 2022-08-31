<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Menu_model extends CI_Model{
     public function getSubMenu(){
         $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`, `user_sub_menu`.`id` as `sub_id` 
         FROM `user_sub_menu` JOIN `user_menu`
         ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
         ";
         return $this->db->query($query)->result_array();
     }

    public function getOneSubMenuWhere($where = NULL){
        $this->db->select("user_sub_menu.*, user_menu.menu, user_sub_menu.id as sub_id")->from("user_sub_menu"); 
		$this->db->join("user_menu","user_sub_menu.menu_id = user_menu.id");
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
            //result array ngebuat jadii datanya array 
            //diganti aja biar gak pusing
            return $query->row();
        }else{
            return FALSE;
        }
    }
    public function countSubMenu($where)
    {
        $result = $this->db->get_where('user_sub_menu', $where);
    
        return $result->num_rows();
    }
    public function update_data($data,$table,$where){
        $this->db->update($table,$data,$where);
    }

    public function delete_data($table,$where){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function update_menu($data,$table,$where){
        $this->db->update($table,$data,$where);
    }

    
 }
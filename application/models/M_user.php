<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model{

    public function login($data)
    {
        $this->db->select('*');
        $this->db->from('tb_admin');
        $this->db->where('username', $data['username']);
        $this->db->where('password', $data['password']);
        $query = $this->db->get();

        return $query;
    }

    public function get($user_id = null){
    	$this->db->select('*');
    	$this->db->from('tb_admin');
    	if(!$user_id == null){
    		$this->db->where('id', $user_id);
    	}
    	return $this->db->get();
    }

}
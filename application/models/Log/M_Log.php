<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Log extends VS_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_users(){
        $consulta = ("SELECT * FROM sys_users WHERE sys_users.status = 1");
        $result = $this->db->query($consulta);
        return $result->result();
    }
    
    public function get_user_id($id_user){
        $consulta = ("SELECT * FROM sys_users WHERE id_users = $id_user");
        $result = $this->db->query($consulta);
        return $result->result();
    }
}
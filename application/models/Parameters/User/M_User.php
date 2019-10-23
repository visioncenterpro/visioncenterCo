<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListUser($id = null) {

        if (!empty($id)) {
            $this->db->where("id_users", $id);
        }

        $result = $this->db->select("u.id_users,u.name,u.user, u.email, s.description as rol,e.description as status")
                ->from("sys_users u")
                ->join("sys_status e", "u.status = e.id_status")
                ->join("sys_roles s", "u.rol = s.id_roles")
                ->where("e.module like '%sys%' ")
                ->order_by("u.name")
                ->get();

        return $result->result();
    }

    function ListRolAll($id = null) {

        if (!empty($id)) {
            $this->db->where("id_roles", $id);
        }

        $result = $this->db->select("r.id_roles, r.description as rol, r.status, s.* ")
                ->from("sys_roles r")
                ->join("sys_status s", "r.status = s.id_status")
                ->order_by("r.description")
                ->get();

        return $result->result();
    }

    function CreateUser() {
        $data = array("name" => $this->name, "user" => $this->user, "rol" => $this->rol, "password" => md5(md5($this->password)), "email" => $this->email, "status" => 1, "last_entry" => date("Y-m-d H:i:s"), "avatar" => $this->avatar);
        $result = $this->db->insert("sys_users", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ValidaCorreo() {
        $result = $this->db->select(" u.id_users,u.email")
                ->from("sys_users u")
                ->where("u.email", $this->email)
                ->get();
        if ($result->num_rows() > 0) {
            return "NO";
        } else {
            return "OK";
        }
    }
    
    function DeleteUser() {
        $this->db->where("id_users",$this->id_user);
        $res = $this->db->update("sys_users",array("status"=>3,"last_entry"=>date("Y-m-d H:i:s")));
        return ($res)?"OK":"ERROR : ".$this->db->last_query();
    }
    
    function ListUsers($id) {
        $result = $this->db->select("*")
                ->from("sys_roles")
                ->where("id_users", $id)                
                ->get();
        return $result->row();
    }  
   

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Rol extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
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

    public function UpdateRol() {

        $data = array("description" => strtoupper($this->descripcion), "status" => $this->status, "last_update"=> date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("id_roles", $this->id_roles);
        $result = $this->db->update("sys_roles", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function CreateRol() {
        $data = array("description" => strtoupper($this->descripcion), "status" => $this->status, "last_update"=> date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("sys_roles", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function DeleteRol() {
        $this->db->where("id_roles",$this->id_roles);
        $res = $this->db->update("sys_roles",array("status"=>3,"last_update"=>date("Y-m-d H:i:s"), "modified_by"=>$this->session->IdUser));
        
        return ($res)?"OK":"ERROR : ".$this->db->last_query();
    }

}

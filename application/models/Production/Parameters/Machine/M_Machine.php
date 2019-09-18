<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Machine extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListTypeDamageAll() {

        if (!empty($id)) {
            $this->db->where("id_type_damage", $id);
        }

        $result = $this->db->select("t.*,s.description as statusrecord")
                ->from("pro_type_damage t")
                ->join("sys_status s", "t.`status` = s.id_status")
                ->order_by("t.description")
                ->get();

        return $result->result();
    }

    public function UpdateTypeDamage() {

        $data = array("description" => strtoupper($this->description), "type" => $this->type, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("id_type_damage", $this->id_type_damage);
        $result = $this->db->update("pro_type_damage", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function CreateTypeDamage() {
        $data = array("description" => strtoupper($this->description), "type" => $this->type, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("pro_type_damage", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function DeleteTypeDamage() {
        $this->db->where("id_type_damage", $this->id_type_damage);
        $res = $this->db->update("pro_type_damage", array("status" => 3, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser));

        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
    }

    function ListAreaAll($id = NULL) {

        if (!empty($id)) {
            $this->db->where("id_status", $id);
        }
        $result = $this->db->select("a.id_pro_area, a.description ")
                ->from("pro_area a")
                ->get();
        return $result->result();
    }

    function CreateMachine() {
        $data = array("description" => strtoupper($this->description), "code" => $this->code, "brand" => $this->brand, "model" => $this->model, "area" => $this->area, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("pro_machine", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ListMachineAll() {
        if (!empty($id)) {
            $this->db->where("id_machine", $id);
        }
        $result = $this->db->select("a.id_machine,a.description,a.code,a.brand,a.model,a.area,a.status,s.description as descstatus, w.description as despcarea")
                ->from("pro_machine a")
                ->join("sys_status s", "a.status = s.id_status")
                ->join("pro_area w", "a.area = w.id_pro_area")
                ->order_by("a.id_machine")
                ->get();
        return $result->result();
    }

    function DeleteMachine() {
        $this->db->where("id_machine", $this->id_machine);
        $res = $this->db->update("pro_machine", array("status" => 3, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser));
        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
    }

    function UpdateMachine() {

        $data = array("description" => strtoupper($this->descripcion), "code" => $this->code, "brand" => $this->brand, "model" => $this->model, "area" => $this->area, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("id_machine", $this->id_machine);
        $result = $this->db->update("pro_machine", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ListMachine($id) {

        $result = $this->db->select("*")
                ->from("pro_machine")
                ->where("id_machine", $id)
                ->order_by("id_machine")
                ->get();
        return $result->row();
    }

    function ListFunctionsMachineAll($machine) {
        $result = $this->db->select("f.id_function,f.description,fm.id_machine ")
                ->from("mto_function f")
                ->join("mto_function_machine fm", "f.id_function = fm.id_function and fm.id_machine = " . $machine, "left")
                ->where("f.`status`", 1)
                ->order_by("f.description asc")
                ->get();
        return $result->result();
    }
    
    function ListFunctionsMachine() {
        $result = $this->db->select("*")
                ->from("mto_function f")
                ->where("f.`status`", 1)
                ->order_by("f.description asc")
                ->get();
        return $result->result();
    }


    function ListUserMachineAll($machine) {
        $result = $this->db->select("u.id_users,u.name, p.id_machine")
                ->from("sys_users u")
                ->join("pro_user_machine p", "u.id_users=p.id_user and p.id_machine = " . $machine , "left")
                ->where("u.rol", 5)
                ->where("status", 1)
                ->order_by("u.id_users")
                ->get();
     
        return $result->result();
    }


    function ListUserMachine() {
        $result = $this->db->select("*")
                ->from("sys_users u")
                ->where("u.rol", 5)
                ->where("status", 1)
                ->order_by("u.id_users")
                ->get();
     
        return $result->result();
    }

    function UpdateUserMachine() {
        if ($this->input->post("option") == "insert"):
            $data = array(
                "id_machine" => $this->input->post("id_machine"),
                "id_function" => $this->input->post("id_function")
            );

            $result = $this->db->insert("mto_function_machine", $data);
        else:
            $this->db->where("id_machine", $this->input->post("id_machine"));
            $this->db->where("id_function", $this->input->post("id_function"));
            $result = $this->db->delete("mto_function_machine");
        endif;

        $res = ($result) ? "OK" : "Error : " . $this->db->last_query();
        return $res;
    }

    function UpdateAuxMachine() {
        if ($this->input->post("option") == "insert"):
            $data = array(
            "id_user" => $this->input->post("id_user"),
            "id_machine" => $this->input->post("id_machine")
            );
            $result = $this->db->insert("pro_user_machine", $data);
        else:
            $this->db->where("id_user", $this->input->post("id_user"));
            $this->db->where("id_machine", $this->input->post("id_machine"));            
            $result = $this->db->delete("pro_user_machine");
        endif;

        $res = ($result) ? "OK" : "Error : " . $this->db->last_query();
        return $res;
    }

}

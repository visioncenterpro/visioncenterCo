<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Request extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListRequestAll($id = null) {
        if (!empty($id)) {
            $this->db->where("id_request", $id);
        }

        $result = $this->db->select("s.id_request,s.type_request ,concat(m.description,' (',m.model,')') as maquina,t.description as tipo_dano,a.description as area,s.creation_date as creado ,s.start_maintenance as inicio,s.end_maintenance as fin")
                ->from("mto_request s")
                ->join("pro_machine m", "s.machine = m.id_machine", "left")
                ->join("pro_area a", "s.area = a.id_pro_area", "left")
                ->join("pro_type_damage t", "s.type_damage = t.id_type_damage", "left")
                ->where("s.status != 3")
                ->order_by("id_request", "desc")
                ->get();

        return $result->result();
    }

    function ListMachine($id = null) {
        if (!empty($id)) {
            $this->db->where("id_machine", $id);
        }
        $result = $this->db->select("*")
                ->from("pro_machine")
                ->order_by("description")
                ->get();

        return $result->result();
    }

    function ListTypeDamageLoc() {
        $result = $this->db->select("*")
                ->from("pro_type_damage")
                ->where("type", "LOCATIVO")
                ->where("status", 1)
                ->order_by("description")
                ->get();

        return $result->result();
    }

    function ListTypeDamageMachine() {
        $result = $this->db->select("*")
                ->from("pro_type_damage")
                ->where("type", "MAQUINA")
                ->where("status", 1)
                ->order_by("description")
                ->get();

        return $result->result();
    }

    function ListAreaAll() {
        $result = $this->db->select("*")
                ->from("pro_area")
                ->where("status", 1)
                ->order_by("description")
                ->get();

        return $result->result();
    }

    function CreateRequest() {

        $now = date("Y-m-d H:i:s");

        $this->db->trans_begin();

        $data = array("type_request" => $this->type, "creation_date" => $now, "area" => $this->area, "reason" => $this->reason, "created_by" => $this->session->IdUser, "last_update" => $now, "modified_by" => $this->session->IdUser);

        if ($this->type == "MAQUINA") {
            if ($this->check == 1) {
                $data["delivery_date_machine"] = $now;
            }
            $data["machine"] = $this->maquina;
        } else {
            if (!empty($this->which)) {
                $data2 = array("description" => strtoupper($this->which), "type" => $this->type, "status" => 1, "last_update" => $now, "modified_by" => $this->session->IdUser);
                $result = $this->db->insert("pro_type_damage", $data2);
                $data["type_damage"] = $this->db->insert_id();
            } else {
                $data["type_damage"] = $this->type_damage;
            }
        }

        $result = $this->db->insert("mto_request", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->db->last_query();
        } else {
            $this->db->trans_commit();
            return "OK";
        }
    }

    function LoadRequest($id) {
        $result = $this->db->select("*")
                ->from("mto_request")
                ->where("id_request", $id)
                ->order_by("id_request", "desc")
                ->get();

        return $result->row();
    }

    function UpdateRequest() {

        $now = date("Y-m-d H:i:s");

        $this->db->trans_begin();

        $result = $this->db->select("*")
                ->from("mto_request")
                ->where("id_request", $this->id_request)
                ->get();

        $row = $result->row();

        $data = array("assigned" => $this->asig, "type_request" => $this->type, "area" => $this->area, "reason" => $this->reason, "last_update" => $now, "modified_by" => $this->session->IdUser);

        if ($this->type == "MAQUINA") {
            if (empty($row->delivery_date_machine)) {
                if ($this->check == 1) {
                    $data["delivery_date_machine"] = $now;
                }
            }
            $data["machine"] = $this->maquina;
        } else {
            if (!empty($this->which)) {
                $data2 = array("description" => strtoupper($this->which), "type" => $this->type, "status" => 1, "last_update" => $now, "modified_by" => $this->session->IdUser);
                $result = $this->db->insert("pro_type_damage", $data2);
                $data["type_damage"] = $this->db->insert_id();
            } else {
                $data["type_damage"] = $this->type_damage;
            }
        }

        $this->db->where("id_request", $this->id_request);
        $result = $this->db->update("mto_request", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->db->last_query();
        } else {
            $this->db->trans_commit();
            return "OK";
        }
    }

    function UpdateFieldRequest() {

        $this->db->trans_begin();

        if ($this->campo == "delivery_date_machine" || $this->campo == "start_maintenance" || $this->campo == "end_maintenance") {
            $this->valor = date("Y-m-d H:i:s");
        }

        $data = array($this->campo => $this->valor);
        if ($this->campo == "end_maintenance") {
            $data['type_damage'] = $this->type_damage;
            $data['area'] = $this->area;
            $data['reason'] = $this->reason;
            $data['description_damage'] = $this->description_damage;
            $data['process'] = $this->process;
        }

        if ($this->type_request == "MAQUINA") {
            if ($this->campo == "start_maintenance") {
                $arrData = array("status" => 5);
                $this->db->where("id_machine", $this->machine);
                $this->db->update("pro_machine", $arrData);
            } else if ($this->campo == "end_maintenance") {
                $arrData = array("status" => 1);
                $this->db->where("id_machine", $this->machine);
                $this->db->update("pro_machine", $arrData);
            }
        }


        $this->db->where("id_request", $this->id_request);
        $this->db->update("mto_request", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $this->valor;
    }

    function DeleteRequest() {
        $data = array("status" => 3);

        $this->db->where("id_request", $this->id_request);
        $result = $this->db->update("mto_request", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

}

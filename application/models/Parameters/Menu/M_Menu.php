<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Menu extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListMenuAll($id = null) {

        if (!empty($id)) {
            $this->db->where("id_menu", $id);
        }

        $result = $this->db->select("*")
                ->from("sys_menu")
                ->join("sys_status", "sys_menu.status = sys_status.id_status")
                ->order_by("title")
                ->get();

        return $result->result();
    }

    function ListTypeMenuAll() {
        $result = $this->db->select("*")
                ->from("sys_type_menu")
                ->order_by("description")
                ->get();

        return $result->result();
    }

    function LoadFathers() {
        $result = $this->db->select("*")
                ->from("sys_menu")
                ->where("type in (3,4)")
                ->order_by("title")
                ->get();
        return $result->result();
    }

    public function UpdateMenu() {

        $data = array("title" => $this->titulo, "type" => $this->tipo, "url" => $this->url, "icon" => $this->icon, "root" => $this->padre, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("id_menu", $this->id_menu);
        $result = $this->db->update("sys_menu", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function CreateMenu() {
        $data = array("title" => $this->titulo, "type" => $this->tipo, "url" => $this->url, "icon" => $this->icon, "root" => $this->padre, "status" => $this->status, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("sys_menu", $data);

        if ($result) {
            $id = $this->db->insert_id();
            $result = $this->db->insert("sys_roles_menu", array("id_roles" => 1, "id_menu" => $id));
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->db->last_query();
        } else {
            $this->db->trans_commit();
            return "OK";
        }
    }

    function DeleteMenu() {
        return $this->DeleteChild($this->id_menu);
    }

    function DeleteChild($root) {
        $this->db->where("id_menu", $root);
        $res = $this->db->update("sys_menu", array("status" => 3, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser));

        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
    }

}

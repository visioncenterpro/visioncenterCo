<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Programming extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListProgrammmingAll() {

        $result = $this->db->select(" p.id_abs_employee,p.identification,p.name,p.last_name,a.description,b.code,c.description as tipodescrip,p.work_shift,p.category ")
                ->from("abs_employee p")
                ->join("pro_area a", "p.id_area = a.id_pro_area")
                ->join("abs_type_rol b", "p.id_type_rol = b.id_abs_type_rol")
                ->join("abs_team_work c", "p.id_team_work = c.id_team_work")
                ->where("p.status", 1)
                ->order_by("p.id_area")
                ->get();
      // echo $this->db->last_query();

        return $result->result();
    }

    function DeleteProgramming() {
        $this->db->where("id_abs_employee", $this->id_user);
        $res = $this->db->update("abs_employee", array("status" => 3, "last_update" => date("Y-m-d H:i:s")));
        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
    }

    function ListSeccionAll() {


        $result = $this->db->select(" * ")
                ->from("pro_area p")
                ->where("p.`status", 1)
                ->order_by("p.id_pro_area")
                ->get();

        return $result->result();
    }

    function ListTeamAll() {


        $result = $this->db->select(" *")
                ->from("abs_team_work p")
                ->order_by("p.id_team_work")
                ->get();

        return $result->result();
    }

    function CreateUser() {
        $data = array("identification" => $this->identification,"name" => $this->name, "last_name" => $this->last_name, "id_area" => $this->seccion, "id_team_work" => $this->equipo, "id_type_rol" => $this->tipo, "work_shift" => $this->turno, "category" => $this->cat, "status" => 1, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("abs_employee", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ListTypeRollAll() {

        $result = $this->db->select(" *")
                ->from("abs_type_rol p")
                ->order_by("p.id_abs_type_rol")
                ->get();

        return $result->result();
    }

    function InfoPersonal() {
        $result = $this->M_Machine->UpdateMachine();
        echo json_encode(array("res" => $result));
    }

    function ListProgrammming($id_users) {

        $result = $this->db->select(" p.id_abs_employee,p.identification,p.name,p.last_name,a.description,b.code,c.description as tipodescrip,p.work_shift,p.category ")
                ->from("abs_employee p")
                ->join("pro_area a", "p.id_area = a.id_pro_area")
                ->join("abs_type_rol b", "p.id_type_rol = b.id_abs_type_rol")
                ->join("abs_team_work c", "p.id_team_work = c.id_team_work")
                ->where("p.id_abs_employee", $id_users)
                ->get();
        return $result->row();
    }

    function ListworkshiftAll() {
        $result = $this->db->select(" *")
                ->from("sys_work_shift p ")
                ->order_by("p.id_work_shift")
                ->get();

        return $result->result();
    }

    function UpdatePerson() {

        $data = array("identification" => $this->identification,"name" => strtoupper($this->name), "last_name" => $this->last_name, "id_area" => $this->seccion, "id_team_work" => $this->equipo, "id_type_rol" => $this->tipo,"work_shift" => $this->turno,"category" => $this->cat,  "status" => 1, "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("id_abs_employee", $this->id_users);
        $result = $this->db->update("abs_employee", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

}

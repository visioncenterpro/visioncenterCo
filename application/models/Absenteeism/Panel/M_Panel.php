<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Panel extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function CountIndicators() {

        $result = $this->db->select("count(*) as total")
                ->from("abs_employee")
                ->where("abs_employee.`status`", 1)
                ->get();

        $array['programing'] = $result->row()->total;

        $result = $this->db->select("ifnull(sum(if(a.`type` = 'P',TIMEDIFF( a.end_time,a.start_time), 0)), 0) as `partial`, 
ifnull(sum(if(a.`type` = 'T', 1, 0)), 0) as `total`  ")
                ->from("abs_absenteeism a ")
                ->where("date = CURDATE()")
                ->get();

        $array['partial'] = $result->row()->partial;
        $array['total'] = $result->row()->total;
        $array['porcent'] = 100 - ((100 *  ($array['partial']+ $array['total'])) / $array['programing']);

        return $array;
    }

    function ListPersonAll() {

        $result = $this->db->select("r.id_abs_employee, CONCAT(r.name, ' - ' ,r.last_name ) as operario ")
                ->from("abs_employee r")
                ->order_by("r.id_abs_employee")
                ->get();
        return $result->result();
    }

    function createabsent() {
        $oldDate = $this->datepickerAuse;
        $arr = explode('/', $oldDate);
        $datepickerAuse = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $data = array("date" => $datepickerAuse, "id_employee" => $this->operarioaus, "type" => 'T', "observation" => $this->textobsaus, "status" => 6, "created_by" => $this->session->IdUser, "last_update" => date("Y-m-d H:i:s"));
        $result = $this->db->insert("abs_absenteeism", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function Createnovelty() {
        $oldDate = $this->datepickerNov;
        $arr = explode('/', $oldDate);
        $datepickerNov = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $data = array("date" => $datepickerNov, "id_employee" => $this->operarionov, "type" => 'P', "start_time" => $this->timestar, "end_time" => $this->timeend,"observation" => $this->textobsnov, "status" => 6, "created_by" => $this->session->IdUser, "last_update" => date("Y-m-d H:i:s"));
        $result = $this->db->insert("abs_absenteeism", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function CountSubIndicator() {

        $result = $this->db->select("p.description,count(e.id_abs_employee)as total,e.id_area")
                ->from("abs_employee e")
                ->join("pro_area p", "e.id_area = p.id_pro_area", "left")
                ->join("sys_work_shift h", "e.work_shift = h.id_work_shift", "left")
                ->where("e.`status`", 1)
                ->group_by("e.id_area")
                ->get();

        return $result->result();
    }

    function ModalDetailProg() {
        
        $result = $this->db->select("p.description,count(*)as total,h.id_work_shift AS turno ")
                ->from("abs_employee e")
                ->join("pro_area p", "e.id_area = p.id_pro_area", "left")
                ->join("sys_work_shift h", "e.work_shift = h.id_work_shift", "left")
                ->where("e.id_area", $this->input->post("id_area"))
                ->where("e.`status`", 1)
                ->group_by("e.id_area,h.id_work_shift")
                ->get();

        return $result->result();
    }

}

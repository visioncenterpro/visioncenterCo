<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Time extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function ListHours() {
        $oldDate = $this->input->post("dayOpen");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        $result = $this->db->select("*")
                ->from("pro_hours_production t")
                ->where(" NOT EXISTS (SELECT NULL FROM pro_production_time p 
                          WHERE p.hour = t.hour and p.day = '') ")
                ->get();

        return $result->result();
    }

    function ListMachine() {
        $result = $this->db->select(" a.id_machine,a.description,a.code,a.brand,a.model,a.area,a.status,s.description as descstatus, w.description as despcarea")
                ->from("pro_machine a")
                ->join("sys_status s", "a.status = s.id_status")
                ->join("pro_area w", "a.area = w.id_pro_area")
                ->order_by("a.id_machine")
                ->get();
        return $result->result();
    }

    function ListStop_Machine() {
        $result = $this->db->select("*")
                ->from("pro_reason_stop_machine u")
                ->order_by("u.id_reason_stop_machine asc")
                ->get();
        return $result->result();
    }

    function ListEstado() {
        $result = $this->db->select("u.id_status,u.description")
                ->from("sys_status u")
                ->where("u.module like '%ppt%' ")
                ->get();
        return $result->result();
    }
       function ListProductivity() {
        $result = $this->db->select("u.id_low_productivity,u.description")
                ->from("pro_low_productivity u")
                ->get();
        return $result->result();
    }

    function CreateTime() {
        $oldDate = $this->input->post("datepicker");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $data = array("day" => $datepicker, "hour" => $this->input->post("hour"), "status" => $this->input->post("status"), "id_machine" => $this->input->post("machine"), "quantity" => $this->input->post("quantity"), "number_operators" => $this->input->post("people"), "stopped_time" => $this->input->post("time_stop"), "reason" => $this->input->post("reason"), "check_low_productivity" => $this->input->post("check"), "check_reason" => $this->input->post("baprod"),"date" => date("Y-m-d H:i:s"));
        $result = $this->db->insert("pro_production_time", $data);
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ListRegister() {
        $result = $this->db->select(" u.id_production_time,u.day,u.hour,r.model,u.quantity,u.reason,u.number_operators ")
                ->from("pro_production_time u ")
                ->join("pro_machine r", "r.id_machine =u.id_machine", "left")
                // ->where("where u.day = '2018-11-03'")
                ->get();


        return $result->result();
    }

    function LoadDay($end) {
        $oldDate = $this->input->post("datepicker");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $data = array("day" => $datepicker, "hour" => $this->input->post("hour"), "status" => $this->input->post("status"), "id_machine" => $this->input->post("machine"), "quantity" => $this->input->post("quantity"), "number_operators" => $this->input->post("people"), "stopped_time" => $this->input->post("time_stop"), "reason" => $this->input->post("reason"), "date" => date("Y-m-d H:i:s"));
        $result = $this->db->insert("pro_production_time", $data);
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function ListRegisterWhere() {

        $oldDate = $this->input->post("dayOpen");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        $result = $this->db->select(" r.id_production_time,r.day,r.hour,e.model,r.quantity,o.description,r.stopped_time,r.number_operators  ")
                ->from(" pro_production_time r ")
                ->join("pro_machine e", "r.id_machine=e.id_machine")
                ->join("pro_reason_stop_machine o", " r.reason=o.id_reason_stop_machine", "left")
                ->where("r.day", $datepicker)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }

    function DeleteDay() {
        $this->db->where("id_production_time", $this->input->post("id"));
        $res = $this->db->delete("pro_production_time");
        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
    }

    function ListRegisterWhereDelete() {

        $result = $this->db->select(" * ")
                ->from("pro_production_time r ")
                ->join("pro_no_machine e", "r.id_machine=e.id_machine")
                ->where("u.day", $this->input->post("day"))
                ->get();

        return $result->result();
    }

    function date_Consult() {

        $oldDate = $this->input->post("dayOpen");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $result = $this->db->select("*")
                ->from("pro_programming_diary u ")
                ->where("u.day", $datepicker)
                ->get();
        //echo $this->db->last_query();
        return $result->row();
    }

}

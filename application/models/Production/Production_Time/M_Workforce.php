<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Workforce extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function ListNo_Machine() {
        $result = $this->db->select("u.id_machine,u.model,u.id_no_maquine")
                ->from("pro_no_machine u")
                ->order_by("u.id_machine")
                ->get();
        return $result->result();
        //echo $this->db->last_query();
    }

    function ListHours() {
        // echo "1";
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

    function ListEstado() {
        $result = $this->db->select("u.id_status,u.description")
                ->from("sys_status u")
                ->where("u.module like '%ppt%' ")
                ->get();
        return $result->result();
    }

    function ListStop_Machine() {
        $result = $this->db->select("*")
                ->from("pro_reason_stop_machine u")
                ->order_by("u.id_reason_stop_machine asc")
                ->get();
        return $result->result();
        //echo $this->db->last_query();
    }

    function ListRegisterWhere() {

        $oldDate = $this->input->post("dayOpen");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        $result = $this->db->select(" r.id_production_time,r.day,r.hour,e.model,r.quantity,o.description,r.stopped_time,r.number_operators  ")
                ->from("pro_production_time r ")
                ->join("pro_no_machine e", "r.id_machine=e.id_no_maquine ")
                 ->join("pro_reason_stop_machine o", "o.id_reason_stop_machine = r.reason","left")
                ->where("r.day", $datepicker)
                ->get();
       //echo $this->db->last_query();
        return $result->result();
        
    }

    function Creaworkforce() {
        $oldDate = $this->input->post("datepicker");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '/' . $arr[0] . '/' . $arr[1];

        $data = array("day" => $datepicker, "hour" => $this->input->post("hour"), "status" => $this->input->post("status"), "id_machine" => $this->input->post("manoobra"), "quantity" => $this->input->post("quantity"), "number_operators" => $this->input->post("people"), "stopped_time" => $this->input->post("time_stop"), "reason" => $this->input->post("reason"), "date" => date("Y-m-d H:i:s"));
        $result = $this->db->insert("pro_production_time", $data);
        //echo $this->db->last_query();
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
    
      function DeleteDay() {
        $this->db->where("id_production_time", $this->input->post("id"));
        $res = $this->db->delete("pro_production_time");
        return ($res) ? "OK" : "ERROR : " . $this->db->last_query();
       
    }
        function ListRegister() {
        $result = $this->db->select(" * ")
                ->from("pro_production_time r ")
                ->join("pro_no_machine e", "r.id_machine=e.id_machine")              
                ->get();
       
        return $result->result();
        
    }
      function ListRegisterWhereDelete() {
        
        $result = $this->db->select(" * ")
                ->from("pro_production_time r ")
                ->join("pro_no_machine e", "r.id_machine=e.id_machine")
                ->where("r.day", $this->input->post("day"))
                ->get();
      
        return $result->result();
        
    }

}

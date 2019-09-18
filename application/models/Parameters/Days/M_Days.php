<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Days extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function AddDayCalendar() {
       $data = array("day"=>$this->input->post("datepicker"),"type_day"=>1,"created_by"=>$this->session->IdUser,"last_update"=>date("Y-m-d H:i:s"), "modified_by"=>$this->session->IdUser);
       $result = $this->db->insert("sys_calendar_days",$data);
       $res = ($result)?"OK":$result;
       return $res;
    }

    function DeleteDayCalendar() {
        $this->db->where("day",$this->input->post("day"));
        $this->db->where("type_day",1);
        $result = $this->db->update("sys_calendar_days",array("status"=>3,"last_update"=>date("Y-m-d H:i:s"), "modified_by"=>$this->session->IdUser));
        $res = ($result)?"OK":$result;
        return $res;
    }

}

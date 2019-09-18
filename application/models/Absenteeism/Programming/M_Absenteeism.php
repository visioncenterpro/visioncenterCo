<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Absenteeism extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListAbsenteeismAll() {

        $result = $this->db->select(" a.id_absenteeism,a.id_employee,p.identification,a.evidence,a.date,concat(p.name,' - ', p.last_name) as nombres,a.`type` as tipo,a.start_time,a.end_time,TIMEDIFF(a.end_time,a.start_time) as dif,a.observation,c.description,
                                      u.name as creado,a.last_update,aprov.name as aproved,a.date_aprobed_by,a.obs_resources")
                ->from("abs_absenteeism a")
                ->join("abs_employee p", "a.id_employee = p.id_abs_employee")
                ->join("sys_status c", "a.`status` = c.id_status")
                ->join("sys_users u", "a.created_by = u.id_users") 
                ->join(" sys_users aprov", "a.aprobed_by = aprov.id_users","left")  
                ->order_by("a.date")
                ->get();
   //echo $this->db->last_query();

        return $result->result();
    }
   function ListAbsenteeismAllReport() {

        $result = $this->db->select(" a.id_absenteeism,a.id_employee,a.id_employee,p.identification,a.evidence,a.date,concat(p.name, ' - ',p.last_name) as nombres,a.`type` as tipo,a.start_time,a.end_time, IF(a.`type`= 'T','08:00:00',TIMEDIFF(a.end_time, a.start_time) ) as dif,a.observation,c.description,
                                      u.name as creado,a.last_update,aprov.name as aproved,a.date_aprobed_by,a.obs_resources")
                ->from("abs_absenteeism a")
                ->join("abs_employee p", "a.id_employee = p.id_abs_employee ")
                ->join("sys_status c", "a.`status` = c.id_status")
                ->join("sys_users u", "a.created_by = u.id_users") 
                ->join(" sys_users aprov", "a.aprobed_by = aprov.id_users","left")  
                ->order_by("a.date desc")
                ->get();
 // echo $this->db->last_query();

        return $result->result();
    }
  public function UpdateRH($file) {

        $data = array("obs_resources" => $this->textobsrh,"evidence" => $file, "status" => 8,"date_aprobed_by"=> date("Y-m-d H:i:s"), "aprobed_by" => $this->session->IdUser);
        $this->db->where("id_absenteeism", $this->id_absenteeism);
        $result = $this->db->update("abs_absenteeism", $data);

        
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    } 

}

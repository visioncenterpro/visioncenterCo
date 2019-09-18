<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Program extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function LoadMachineArea() {
        $result = $this->db->select("m.*,a.description as descarea")
                ->from("pro_machine m")
                ->join("pro_area a", "m.area = a.id_pro_area", "left")
                ->get();

        return $result->result();
    }

    function CreateRequestPreventive() {
        
        $now = date("Y-m-d H:i:s");

        $data = array(
            "maintenance_date"=>$this->date, 
            "machine"=>$this->id_machine,
            "creation_date" => $now,
            "created_by" => $this->session->IdUser, 
            "last_update" => $now, 
            "modified_by" => $this->session->IdUser
        );

        $result = $this->db->insert("mto_request_preventive", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
    
    function ListDayPreventiveMaintenance(){
        $result = $this->db->select("id_request_preventive,description,maintenance_date,mto_request_preventive.status,maintenance_date < CURDATE() as expiration")
               ->from("mto_request_preventive")
                ->join("pro_machine","pro_machine.id_machine = mto_request_preventive.machine")
                ->where("DATE_FORMAT(maintenance_date, '%Y') = YEAR(CURDATE())")
               ->order_by("maintenance_date")
               ->get();
        return $result->result();
    }
    
    function DeleteRequestCalendar(){
        if(empty($this->day))://delete request
            $this->db->where("id_request_preventive",$this->id);
            else:
            $this->db->where("machine",substr($this->id, 3)); //remove new to new123
            $this->db->where("maintenance_date",$this->day);
        endif;
        $data = array("status"=>3);
        $result = $this->db->update("mto_request_preventive",$data);
        
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Budgets extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function CreBudgets() {
        $data = array("year_month" => $this->input->post("datepicker"),"business_days" => $this->input->post("business_days"), "budget_sheet_cut" => $this->input->post("ppto_v_corte"),"budget_sheet_canteo" => $this->input->post("ppto_v_enchape"),"budget_sheet_machining" => $this->input->post("ppto_v_maquinado"),"budget_sheet_rta" => $this->input->post("ppto_v_rta"),"budget_sheet_marcos" => $this->input->post("ppto_v_marcos"),"budget_sheet_shelves" => $this->input->post("ppto_v_repizas"),"budget_sheet_doors" => $this->input->post("ppto_v_puertas"),"last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser,"budget_sheets_delivered" => $this->input->post("sheets"));
        $result = $this->db->insert("pro_budget_processes", $data);
        if ($result) {
            return "OK";
        } else {
           // echo $this->db->last_query();
            return $this->db->last_query();
        }
    }

    function validateBudgets() {
        $result = $this->db->select("u.id_budget_processes")
                ->from("pro_budget_processes u")
                ->where("u.year_month", $this->input->post("dayOpen"))                            
                ->get();
        return $result->row();
        
    }
        function validateMonth() {
        $result2 = $this->db->select("*")
                ->from("pro_budget_processes r")
                ->where("r.year_month", $this->input->post("dayOpen"))                            
                ->get();
        return $result2->row();
        //return $result2->result();
        
    }
    
     function LoadDayNotWorking($end) {
        $result = $this->db->select("*")
                ->from("sys_calendar_days r")   
                ->where("r.status",1)
                ->where("r.day between '".$this->input->post("dayOpen")."-01' and  '" .$end. "' "  )               
                
                ->get();
        //echo $this->db->last_query()
        $arraya=array();
        foreach ($result->result() as $r) {
            $arraya[]=$r->day;
        }
        return $arraya;
        
    }
    
     function updateBudgets() {

        $data = array("budget_sheets_delivered" => $this->input->post("sheets"), "budget_sheet_cut" => $this->input->post("ppto_v_corte"), "budget_sheet_canteo" => $this->input->post("ppto_v_enchape"), "budget_sheet_machining" => $this->input->post("ppto_v_maquinado"), "budget_sheet_marcos" => $this->input->post("ppto_v_marcos"), "budget_sheet_rta" => $this->input->post("ppto_v_rta"), "budget_sheet_shelves" => $this->input->post("ppto_v_repizas"), "budget_sheet_doors" => $this->input->post("ppto_v_puertas"), "last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("year_month", $this->input->post("datepicker"));
        $result = $this->db->update("pro_budget_processes", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

}

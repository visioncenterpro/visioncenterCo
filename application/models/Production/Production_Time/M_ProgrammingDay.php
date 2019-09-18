<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_ProgrammingDay extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function Createprogrammingday() {
        $oldDate = $this->input->post("datepicker");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

       $data = array("day" => $datepicker,"machines_corte" => $this->input->post("machines_corte"), "people_corte" => $this->input->post("people_corte"), "turns1_corte" => $this->input->post("checktc1"),"turns2_corte" => $this->input->post("checktc2"),"turns3_corte" => $this->input->post("checktc3"),"turns4_corte" => $this->input->post("checktc4"),"hourt1_corte" => $this->input->post("hcorte1"),"hourt2_corte" => $this->input->post("hcorte2"),"hourt3_corte" => $this->input->post("hcorte3"),"hourt4_corte" => $this->input->post("hcorte4"),"machines_enchape" => $this->input->post("machines_enchape"), "people_enchape" => $this->input->post("people_enchape"),"turns1_enchape" => $this->input->post("checkte1"),"turns2_enchape" => $this->input->post("checkte2"),"turns3_enchape" => $this->input->post("checkte3"),"turns4_enchape" => $this->input->post("checkte4"),"hourt1_enchape" => $this->input->post("henchape1"),"hourt2_enchape" => $this->input->post("henchape2"),"hourt3_enchape" => $this->input->post("henchape3"),"hourt4_enchape" => $this->input->post("henchape4"),"machines_maquinado" => $this->input->post("machines_maquinado"),"people_maquinado" => $this->input->post("people_maquinado"),"turns1_mq" => $this->input->post("checktmq"),"turns2_mq" => $this->input->post("checktmq1"),"turns3_mq" => $this->input->post("checktmq2"),"turns4_mq" => $this->input->post("checktmq4"),"hourt1_mq" => $this->input->post("hmq1"),"hourt2_mq" => $this->input->post("hmq2"),"hourt3_mq" => $this->input->post("hmq3"),"hourt4_mq" => $this->input->post("hmq4"),"machines_rta" => $this->input->post("machines_rta"),"people_rta" => $this->input->post("people_rta"),"turns1_rta" => $this->input->post("checktrta"),"turns2_rta" => $this->input->post("checktrta1"),"turns3_rta" => $this->input->post("checktrta2"),"turns4_rta" => $this->input->post("checktrta4"),"hourt1_rta" => $this->input->post("hrta1"),"hourt2_rta" => $this->input->post("hrta2"),"hourt3_rta" => $this->input->post("hrta3"),"hourt4_rta" => $this->input->post("hrta4"),"machines_marcos" => $this->input->post("machines_marcos"),"people_marcos" => $this->input->post("people_marcos"),"turns1_marcos" => $this->input->post("checktmc"),"turns2_marcos" => $this->input->post("checktmc1"),"turns3_marcos" => $this->input->post("checktmc2"),"turns4_marcos" => $this->input->post("checktmc4"),"hourt1_marcos" => $this->input->post("hmc1"),"hourt2_marcos" => $this->input->post("hmc3"),"hourt1_marcos" => $this->input->post("hmc3"),"hourt4_marcos" => $this->input->post("hmc4"),"machines_repizas" => $this->input->post("machines_repizas"),"people_repizas" => $this->input->post("people_repizas"),"turns1_rpz" => $this->input->post("checktrpz"),"turns2_rpz" => $this->input->post("checktrpz1"),"turns3_rpz" => $this->input->post("checktrpz2"),"turns4_rpz" => $this->input->post("checktrpz4"),"hourt1_rpz" => $this->input->post("hrpz1"),"hourt2_rpz" => $this->input->post("hrpz2"),"hourt3_rpz" => $this->input->post("hrpz3"),"hourt4_rpz" => $this->input->post("hrpz4"),"machines_puertas" => $this->input->post("machines_puertas"),"people_puertas" => $this->input->post("people_puertas"),"turns1_puertas" => $this->input->post("checktpt"),"turns2_puertas" => $this->input->post("checktpt1"),"turns3_puertas" => $this->input->post("checktpt2"),"turns4_puertas" => $this->input->post("checktpt4"),"hourt1_puertas" => $this->input->post("hpt1"),"hourt2_puertas" => $this->input->post("hpt2"),"hourt3_puertas" => $this->input->post("hpt4"),"hourt1_puertas" => $this->input->post("hpt4"),"last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $result = $this->db->insert("pro_programming_diary", $data);
    
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

    function valideprogrammingday() {
        $oldDate = $this->input->post("dayOpen");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        $result = $this->db->select("*")
                ->from("pro_programming_diary t")
                ->where("t.day = '$datepicker' ")
                ->get();
         return $result->row();
    }
    
     function updateProgrammingDay() {
         
        $oldDate = $this->input->post("datepicker");
        $arr = explode('/', $oldDate);
        $datepicker = $arr[2] . '-' . $arr[0] . '-' . $arr[1];

        $data = array("machines_corte" => $this->input->post("machines_corte"), "people_corte" => $this->input->post("people_corte"), "turns1_corte" => $this->input->post("checktc1"),"turns2_corte" => $this->input->post("checktc2"),"turns3_corte" => $this->input->post("checktc3"),"turns4_corte" => $this->input->post("checktc4"),"hourt1_corte" => $this->input->post("hcorte1"),"hourt2_corte" => $this->input->post("hcorte2"),"hourt3_corte" => $this->input->post("hcorte3"),"hourt4_corte" => $this->input->post("hcorte4"),"machines_enchape" => $this->input->post("machines_enchape"), "people_enchape" => $this->input->post("people_enchape"),"turns1_enchape" => $this->input->post("checkte1"),"turns2_enchape" => $this->input->post("checkte2"),"turns3_enchape" => $this->input->post("checkte3"),"turns4_enchape" => $this->input->post("checkte4"),"hourt1_enchape" => $this->input->post("henchape1"),"hourt2_enchape" => $this->input->post("henchape2"),"hourt3_enchape" => $this->input->post("henchape3"),"hourt4_enchape" => $this->input->post("henchape4"),"machines_maquinado" => $this->input->post("machines_maquinado"),"people_maquinado" => $this->input->post("people_maquinado"),"turns1_mq" => $this->input->post("checktmq"),"turns2_mq" => $this->input->post("checktmq1"),"turns3_mq" => $this->input->post("checktmq2"),"turns4_mq" => $this->input->post("checktmq4"),"hourt1_mq" => $this->input->post("hmq1"),"hourt2_mq" => $this->input->post("hmq2"),"hourt3_mq" => $this->input->post("hmq3"),"hourt4_mq" => $this->input->post("hmq4"),"machines_rta" => $this->input->post("machines_rta"),"people_rta" => $this->input->post("people_rta"),"turns1_rta" => $this->input->post("checktrta"),"turns2_rta" => $this->input->post("checktrta1"),"turns3_rta" => $this->input->post("checktrta2"),"turns4_rta" => $this->input->post("checktrta4"),"hourt1_rta" => $this->input->post("hrta1"),"hourt2_rta" => $this->input->post("hrta2"),"hourt3_rta" => $this->input->post("hrta3"),"hourt4_rta" => $this->input->post("hrta4"),"machines_marcos" => $this->input->post("machines_marcos"),"people_marcos" => $this->input->post("people_marcos"),"turns1_marcos" => $this->input->post("checktmc"),"turns2_marcos" => $this->input->post("checktmc1"),"turns3_marcos" => $this->input->post("checktmc2"),"turns4_marcos" => $this->input->post("checktmc4"),"hourt1_marcos" => $this->input->post("hmc1"),"hourt2_marcos" => $this->input->post("hmc3"),"hourt1_marcos" => $this->input->post("hmc3"),"hourt4_marcos" => $this->input->post("hmc4"),"machines_repizas" => $this->input->post("machines_repizas"),"people_repizas" => $this->input->post("people_repizas"),"turns1_rpz" => $this->input->post("checktrpz"),"turns2_rpz" => $this->input->post("checktrpz1"),"turns3_rpz" => $this->input->post("checktrpz2"),"turns4_rpz" => $this->input->post("checktrpz4"),"hourt1_rpz" => $this->input->post("hrpz1"),"hourt2_rpz" => $this->input->post("hrpz2"),"hourt3_rpz" => $this->input->post("hrpz3"),"hourt4_rpz" => $this->input->post("hrpz4"),"machines_puertas" => $this->input->post("machines_puertas"),"people_puertas" => $this->input->post("people_puertas"),"turns1_puertas" => $this->input->post("checktpt"),"turns2_puertas" => $this->input->post("checktpt1"),"turns3_puertas" => $this->input->post("checktpt2"),"turns4_puertas" => $this->input->post("checktpt4"),"hourt1_puertas" => $this->input->post("hpt1"),"hourt2_puertas" => $this->input->post("hpt2"),"hourt3_puertas" => $this->input->post("hpt4"),"hourt1_puertas" => $this->input->post("hpt4"),"last_update" => date("Y-m-d H:i:s"), "modified_by" => $this->session->IdUser);
        $this->db->where("day", $datepicker);
        $result = $this->db->update("pro_programming_diary", $data);
        //echo $this->db->last_query();
        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }

}

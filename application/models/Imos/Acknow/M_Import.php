<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Import extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function ParametersFile($process) {
        $result = $this->db->select("*")
                ->from("sys_import_parameter")
                ->where("id_import_parameter", $process)
                ->get();
        return $result->row();
    }

    function ConfigCell($process) {
        $result = $this->db->select("*")
                ->from("sys_import_config_masterstables")
                ->where("id_import", $process)
                ->order_by("sheet,row")
                ->get();
        return $result->result();
    }

    function ConfigCellDet($process) {
        $result = $this->db->select("*")
                ->from("sys_import_config_detailstables")
                ->where("id_import", $process)
                ->order_by("sheet,row")
                ->get();
        return $result->result();
    }
    
    function get_ack($order){
        $result = $this->db->select("*")
                ->from("sys_import_salestable")
                ->where("`order`", $order)
                ->get();
        return $result->row();
    }

    function SaveAck() {
        $this->db->trans_begin();
        
        $arrayDetail = json_decode($_POST['detail']);
        
        $order;
        $data = array();
        foreach ($_POST as $clave => $valor):
            if ($clave != "detail") {
                $data[$clave] = $valor;
            }
            if ($clave == "order") {
                $order = str_replace("-", "_", $valor);
            }
        endforeach;

        $this->ix = $this->load->database("ImosIX", TRUE);
        $resultIX = $this->ix->select("*")
                ->from("PROADMIN")
                ->where("NAME", $order)
                ->get();
        $dataIX = $resultIX->row();


        $data['last_update'] = date("Y-m-d H:i:s");
        $data['modified_by'] = $this->session->IdUser;
        $data['id_proadmin'] = $dataIX->ID;

        $this->db->insert("sys_import_salestable", $data);
        $id = $this->db->insert_id();
        
        $item = 1;
        foreach ($arrayDetail as $tr) {
            $data = array(
                "id_import_salestable"=>$id,
                "proadmin"=>$dataIX->ID,
                "item"=>$item,
                "qty"=>$tr[2],
                "code"=>$tr[3],
                "code1"=>$tr[4],
                "code_esp"=>$tr[5],
                "hinges_left"=>$tr[6],
                "hinges_right"=>$tr[7],
                "route"=>$tr[8],
                "opening"=>$tr[9],
                "door_style"=>$tr[10],
                "finished_side_left"=>$tr[11],
                "finished_side_right"=>$tr[12],
                "height"=>$tr[13],
                "width"=>$tr[14],
                "depth"=>$tr[15],
                "unit_prices"=>$tr[16],
                "total_prices"=>$tr[17],
                "volume"=>$tr[18],
                "description"=>$tr[19],
                "notes"=>$tr[20],
                "type"=>"AO"
            );
            $this->db->insert("sys_import_salesline", $data);
            $last_id = $this->db->insert_id();
            $item++;
        }

       
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "Error " . $this->db->last_query();
        } else {
            $this->db->trans_commit();
            return "OK";
        }
    }
    
    function UpdateAck() {
        $this->db->trans_begin();
        
        $arrayDetail = json_decode($_POST['detail']);
        
        $data = array();
        foreach ($_POST as $clave => $valor):
            if ($clave != "detail" && $clave != "data_salesline") {
                $data[$clave] = $valor;
            }
        endforeach;

        $data['last_update'] = date("Y-m-d H:i:s");
        $data['modified_by'] = $this->session->IdUser;
        $this->db->where("`order`", $_POST['order']);
        $this->db->update("sys_import_salestable", $data);
        
        $id_pb = $_POST['order'];
        $id = $id_pb;
        
        $item = 1;
        foreach ($arrayDetail as $tr) {
            $data = array(
                "id_import_salestable"=>$id,
                "item"=>$item,
                "qty"=>$tr[2],
                "code"=>$tr[3],
                "code1"=>$tr[4],
                "code_esp"=>$tr[5],
                "hinges_left"=>$tr[6],
                "hinges_right"=>$tr[7],
                "route"=>$tr[8],
                "opening"=>$tr[9],
                "door_style"=>$tr[10],
                "finished_side_left"=>$tr[11],
                "finished_side_right"=>$tr[12],
                "height"=>$tr[13],
                "width"=>$tr[14],
                "depth"=>$tr[15],
                "unit_prices"=>$tr[16],
                "total_prices"=>$tr[17],
                "volume"=>$tr[18],
                "description"=>$tr[19],
                "notes"=>$tr[20],
                "type"=>"AO"
            );
            $this->db->where("id_import_salestable", $id_pb);
            $this->db->update("sys_import_salesline", $data);
            $item++;
        }
       
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "Error " . $this->db->last_query();
        } else {
            $this->db->trans_commit();
            return "OK";
        }
    }

}

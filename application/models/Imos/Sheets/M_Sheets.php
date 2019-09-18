<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Sheets extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    function get_sheets_all(){
        $result = $this->db->select("*")
                ->from("pro_wood_sheet p")
                ->join("pro_sheet_caliber pc","p.id_caliber = pc.id_caliber","left")
                ->get();
        return $result->result();
    }
    
    function get_formats(){
        $result = $this->db->select("*")
                ->from("pro_sheet_area")
                ->get();
        return $result->result();
    }
    
    function get_calibers(){
        $result = $this->db->select("*")
                ->from("pro_sheet_caliber")
                ->get();
        return $result->result();
    }
    
    function get_sheet(){
        $result = $this->db->select("*")
                ->from("pro_wood_sheet p")
                ->join("pro_sheet_caliber pc","p.id_caliber = pc.id_caliber")
                ->where("code", $this->code)
                ->get();
        return $result->row();
    }
    
    function save_sheet(){
        //echo $this->code." ".$this->description." ".$this->format." ".$this->waste." ".$this->caliber;
        $this->db->trans_begin();
        
        if($this->description == ""){
            $get_reference = $this->GetReference($this->code);
            foreach ($get_reference as $value) {
                $this->description = $value->ITEMNAME;
            }
        }
        
        $data = array(
            "code"      => $this->code,
            "description" => $this->description,
            "format"    => $this->format,
            "waste"     => $this->waste,
            "id_caliber"   => $this->caliber,
            "id_pro_sheet_area" => $this->id_format,
            "modified_by"   => $this->session->IdUser
        );

        $this->db->insert("pro_wood_sheet", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            return array("id" => $this->db->insert_id(), 'description' => $this->description);
        }
        
    }
    
    function get_sheet_id(){
        $result = $this->db->select("*")
                ->from("pro_wood_sheet p")
                ->join("pro_sheet_caliber pc","p.id_caliber = pc.id_caliber")
                ->where("id_wood_sheet",$this->id_wood_sheet)
                ->get();
        return $result->result();
    }
    
    function update_sheet(){
        
        $this->db->trans_begin();
        
        if($this->description == ""){
            $get_reference = $this->GetReference($this->code);
            foreach ($get_reference as $value) {
                $this->description = $value->ITEMNAME;
            }
        }
        
        $data = array(
            "code"      => $this->code,
            "description" => $this->description,
            "format"    => $this->format,
            "waste"     => $this->waste,
            "id_caliber"   => $this->caliber,
            "id_pro_sheet_area" => $this->id_format,
            "modified_by"   => $this->session->IdUser
        );
        $this->db->where("id_wood_sheet", $this->id);
        $rs = $this->db->update("pro_wood_sheet", $data);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            return $rs;
        }
    }
    
    function get_pro_sheet_area(){
        $result = $this->db->select("*")
                ->from("pro_sheet_area")
                ->get();
        return $result->result();
    }
    
    function sync_sheet_data(){
        $this->db->trans_begin();
        
        $date = $this->date;
        $date2 = $this->date2;
        $vali = $this->GetReferenceDate(date("d/m/Y", strtotime($date)), date("d/m/Y", strtotime($date2)));
        
        foreach ($vali as $value) {
            $format = "";
            $id_pro_sheet_area = "";
            $area = $this->get_pro_sheet_area();
            foreach ($area as $valuea) {
                $string = $value->ITEMNAME;
                $find = $valuea->format;
                $finder = str_replace(".", ",", $find);
                $pos = strpos($string, $finder);
                if($pos != ""){
                    $id_pro_sheet_area = $valuea->id_pro_shet_area;
                    $format = $valuea->format;
                    break;
                }else{
                    $pos2 = strpos($string, $find);
                    if($pos2 != ""){
                        $id_pro_sheet_area = $valuea->id_pro_shet_area;
                        $format = $valuea->format;
                        break;
                    }
                }
            }
        
            $sheet = $this->db->select("*")
                ->from("pro_wood_sheet p")
                ->where("code", $value->Referencia)
                ->get();
            if(count($sheet->result()) > 0){
                $data_s = $sheet->row();
                $data = array(
                    "code"      => $value->Referencia,
                    "description" => $value->ITEMNAME,
                    "format"    => $format,
                    "id_pro_sheet_area" => $id_pro_sheet_area,
                    "modified_by"   => $this->session->IdUser
                );
                $this->db->where("id_wood_sheet", $data_s->id_wood_sheet);
                $rs = $this->db->update("pro_wood_sheet", $data);
            }else{
                $data = array(
                    "code"      => $value->Referencia,
                    "description" => $value->ITEMNAME,
                    "format"    => $format,
                    "waste"     => '1.1',
                    "id_pro_sheet_area" => $id_pro_sheet_area,
                    "modified_by"   => $this->session->IdUser
                );
                
                $rs = $this->db->insert("pro_wood_sheet", $data);
            }
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            return array("res" => "OK","rs" => $rs);
        }
    }
}


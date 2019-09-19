<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Supplies extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }
    
    public function getTypeSupplies() {
        $result = $this->db->select('id_type_supplies, description')
                ->from('pro_type_supplies')
                ->get();
        
        return $result->result();
    }
    
    public function getUnitSupplies() {
        $result = $this->db->select('id_unit, description')
                ->from('pro_unit')
                ->get();
        
        return $result->result();
    }
    
    public function getSuppliesByFilter() {     
        
        if (!empty($this->typeSupplySelected)) {
            $this->db->where('ps.id_type_supplies', $this->typeSupplySelected);
        }
        if (!empty($this->codeSupply)) {
            $this->db->where('ps.code', $this->codeSupply);
        }
        
        if (!empty($this->codeOrder)) {
            $this->db->join('access_order_supplies aos', 'aos.id_supplies = ps.id_supplies');
            $this->db->where('aos.`order`', $this->codeOrder);
        }
        
        $result = $this->db->select('ps.*, pu.description as d_unit, pt.description as d_type')
                           ->from('pro_supplies ps')
                           ->join('pro_unit pu', 'ps.id_unit = pu.id_unit', 'left')
                           ->join('pro_type_supplies pt', 'ps.id_type_supplies = pt.id_type_supplies', 'left')
                           ->group_by('ps.id_supplies')
                           ->get();
        
        
        return $result->result();
        
    }

    public function getAllSupplies($id = false) {
        if ($id) {
            $this->db->where('ps.id_supplies', $id);
        }
        
        $result = $this->db->select('ps.*, pu.description as d_unit, pt.description as d_type')
                ->from('pro_supplies ps')
                ->join('pro_unit pu', 'ps.id_unit = pu.id_unit', 'left')
                ->join('pro_type_supplies pt', 'ps.id_type_supplies = pt.id_type_supplies', 'left')
                ->get();
        
        if ($id) {
            return $result->row();
        } else {
            return $result->result();
        }
        
    }
    
    public function createSupply() {        
        $data = array(
            "name" => strtoupper($this->name), 
            "code" => $this->code, 
            "quantity_per_package" => $this->quantityPerPackage, 
            "weight_per_package" => $this->weightPerPackage, 
            "dimension" => ($this->type == GROUP_CANTO) ? $this->dimension : '', 
            "id_unit" => $this->unit,
            "id_type_supplies" => $this->type
        );
        $this->db->insert('pro_supplies', $data);
        
        if ($this->db->affected_rows() > 0) {
            return "OK";
        } else {
            return false;
        }
    }
    
    public function updateSupply() {
        $data = array(
            "name" => strtoupper($this->name), 
            "code" => $this->code, 
            "quantity_per_package" => $this->quantityPerPackage, 
            "weight_per_package" => $this->weightPerPackage, 
            "dimension" => ($this->type == GROUP_CANTO) ? $this->dimension : '', 
            "id_unit" => $this->unit,
            "id_type_supplies" => $this->type);
        $this->db->where("id_supplies", $this->id_supply);
        $result = $this->db->update("pro_supplies", $data);

        if ($result) {
            return "OK";
        } else {
            return $this->db->last_query();
        }
    }
   
}

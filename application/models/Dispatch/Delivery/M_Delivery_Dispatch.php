<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Delivery_Dispatch extends VS_Model {
 
    public function __construct() {
        parent::__construct();
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function Load_Type_Delivery(){
        $result = $this->db->select("*")
                ->from("dis_type_delivery")
                ->get();
                
        return $result->result(); 
    }
    
    function SearchDelivery(){
        $result = $this->db->query($this->query." ".$this->id);
        return $result->row_array();
    }
    
    function SelectDelivery($id_delivery = false, $type = false){
        if($id_delivery != 'all')
            $this->db->where("s.id",$id_delivery);
        
        if($type != 'all')
            $this->db->where("s.view",$type);
        
        $result = $this->db->select('s.*')
                ->from('view_delivery s')
                ->get();
        return array('result'=>$result->result(),'num'=>$result->num_rows());
    }
    
    function ListarDelivery($ini = false,$fin = false,$id_delivery, $type){
        if($fin)
            $this->db->limit($fin,$ini);
        
        if($type != 'all')
            $this->db->where("s.view",$type);
        
        if($id_delivery != 'all')
            $this->db->where("s.id",$id_delivery);
        
        $result = $this->db->select('s.*')
                ->from('view_delivery s')
                ->where('id_status in (13,14,15)')
                ->get();
        
        return array('result'=>$result->result(),'num'=>$result->num_rows());
        
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_SalesImos extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function ListTableProAdmin() {
        
        $result = $this->db->select("*")
                ->from("Proadmin")
                ->order_by("ID")
                ->get();
        
       return $result->result();
    }

    

}

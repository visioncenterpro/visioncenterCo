<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Wol extends VS_Model {

    public function __construct() {
        parent::__construct();
    }

    function LoadParameters() {
        $result = $this->db->select("c.seconds_on,c.secure_on,c.cidr,c.port ")
                ->from("sys_configure_wol c")
                ->get();
        return $result->row();
    }

}

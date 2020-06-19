<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_RE extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    public function RE_ORDER(){
    	$query = ("DELETE access_order_package_supplies,access_order_package_supplies_detail FROM access_order_package_supplies INNER JOIN access_order_package_supplies_detail ON access_order_package_supplies.id_order_package_supplies = access_order_package_supplies_detail.access_order_package_supplies WHERE access_order_package_supplies.`order` = $this->order ;");
    	$result = $this->db->query($query);
    	
    	$query = ("UPDATE access_order_package A SET A.delivered_quantity = 0, A.quantity_dispatch = 0, A.packets_completed = 0 WHERE A.`order` = $this->order ;");
    	$result = $this->db->query($query);

    	$query = ("DELETE pro_delivery_package, pro_delivery_package_detail FROM pro_delivery_package INNER JOIN pro_delivery_package_detail ON pro_delivery_package.id_delivery_package = pro_delivery_package_detail.id_delivery_package WHERE pro_delivery_package.`order` = $this->order ;");
    	$result = $this->db->query($query);

    	$query = ("DELETE pro_delivery_supplies, pro_delivery_supplies_detail FROM pro_delivery_supplies INNER JOIN pro_delivery_supplies_detail ON pro_delivery_supplies.id_delivery_supplies = pro_delivery_supplies_detail.id_delivery_supplies WHERE pro_delivery_supplies.`order` = $this->order ;");
    	$result = $this->db->query($query);

		$query = ("DELETE dis_request_sd_detail,dis_request_sd FROM dis_request_sd_detail INNER JOIN dis_request_sd ON dis_request_sd_detail.id_request_sd = dis_request_sd.id_request_sd WHERE dis_request_sd_detail.`order` = $this->order ;");
    	$result = $this->db->query($query);

    	$query = ("DELETE dis_remission,dis_request_cargue_detail,dis_request_cargue FROM dis_remission INNER JOIN dis_request_cargue_detail ON dis_request_cargue_detail.id_remission = dis_remission.id_remission INNER JOIN dis_request_cargue ON dis_request_cargue.id_request_cargue = dis_request_cargue_detail.id_request_cargue WHERE dis_remission.`order` = $this->order;");
    	$result = $this->db->query($query);


		$query = ("UPDATE dis_request_sd_subdetail_package  a SET a.id_request_detail = 0, a.id_request_sd = 0, a.id_order_package_supplies = 0, a.pack = '',a.id_status = 17 WHERE `order` = $this->order ;");
    	$result = $this->db->query($query);

    	return $result;

    }

    public function get_remissions(){
    	$query = ("SELECT * FROM `dis_remission` d WHERE d.`order`= $this->order");
    	$result = $this->db->query($query);
    	return $result->result();
    }

    public function delete_data_dis_cargue($id_request_sd){
    	$query = ("DELETE `dis_request_cargue_detail`,`dis_request_cargue` FROM `dis_request_cargue_detail` INNER JOIN `dis_request_cargue` ON `dis_request_cargue_detail`.`id_request_cargue` = `dis_request_cargue`.`id_request_cargue` WHERE dis_request_cargue_detail.`id_request_sd` = $id_request_sd");
    	$result = $this->db->query($query);
    	return $result;
    }

    public function delete_data_dis_weight($id_request_sd){
    	$query = ("DELETE FROM `dis_request_weight` WHERE id_request_sd = $id_request_sd");
    	$result = $this->db->query($query);
    	return $result;
    }

    public function get_data_dis_cargue($id_request_sd){
    	$query = ("SELECT * FROM dis_request_cargue_detail WHERE id_request_sd = $id_request_sd");
    	$result = $this->db->query($query);
    	return $result->result();
    }

    public function get_data_dis_weight($id_request_sd){
    	$query = ("SELECT * FROM dis_request_weight WHERE id_request_sd = $id_request_sd");
    	$result = $this->db->query($query);
    	return $result->result();
    }
    
}
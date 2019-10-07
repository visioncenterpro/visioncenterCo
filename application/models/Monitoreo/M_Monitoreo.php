<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Monitoreo extends VS_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_pending($orden,$request){
        $query = ("SELECT id_status, COUNT(*) AS total FROM dis_request_sd_subdetail_package "
                . "WHERE dis_request_sd_subdetail_package.`order` = $orden AND dis_request_sd_subdetail_package.id_request_sd = $request"
                . " GROUP BY id_status ORDER BY id_request_sd ASC");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_pending2($order,$request){
        $query = ("SELECT S.id_status, COUNT(D.id_status) AS total FROM sys_status S LEFT JOIN dis_request_sd_subdetail_package D ON S.id_status = D.id_status "
                . "AND D.id_request_sd = $request AND D.`order` = $order GROUP BY S.id_status");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_data($orden,$request){
        $query = ("SELECT * FROM dis_request_sd_subdetail_package WHERE dis_request_sd_subdetail_package.`order` = $orden "
                . " AND dis_request_sd_subdetail_package.id_request_sd = $request ORDER BY id_request_sd");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_orders(){
        $query = ("SELECT a.id_access_order, a.order, a.client, a.project, d2.name, d.quantity_packages, d.id_request_sd FROM access_order a INNER JOIN dis_request_sd d "
                . "INNER JOIN dis_request_sd_detail d2 WHERE a.order = d2.order AND d.id_request_sd = d2.id_request_sd AND d.id_status = 17 GROUP BY d2.id_request_sd");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_packages_m($request,$order){
        $query = ("SELECT *, count(d.id_forniture) as packages, SUM(d.quantity_packets) as packet_sum, SUM(d.weight) as total_weight"
                . " FROM dis_request_sd_detail d WHERE d.id_request_sd = $request  AND d.`order` = $order AND type = 'Modulado' GROUP BY d.id_forniture");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_sd_detail_m($order,$request){
        $query = ("SELECT sd.name, sd.id_forniture, SUM(sd.quantity_packets) as quantity_packets, count(sd.quantity_packets) as paquetes"
                . " FROM dis_request_sd_detail sd "
                . " WHERE sd.`order` = $order AND sd.id_request_sd = $request AND type = 'Modulado' GROUP BY sd.id_forniture");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_forniture($order,$request,$id_forniture){
        $query = ("SELECT * FROM dis_request_sd_subdetail_package sd2 WHERE sd2.id_forniture = $id_forniture AND sd2.`order` = $order "
                . " AND sd2.id_request_sd = $request;");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_weight_trunk($order,$request){
        $query = ("SELECT dd.*, d.id_weight_vehicle, v.max_weight as weight_estimate_trunk FROM dis_request_sd_detail dd "
                . "INNER JOIN dis_request_sd d INNER JOIN dis_weight_vehicle v WHERE dd.id_request_sd = d.id_request_sd AND dd.`order` = $order "
                . "AND d.id_weight_vehicle = v.id_weight_vehicle AND dd.id_request_sd = $request ");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_detail($order,$request){
        $query = ("SELECT * FROM dis_request_sd_subdetail_package d WHERE d.`order` = $order AND d.id_request_sd = $request");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_orders_request($request){
        $query = ("SELECT * FROM dis_remission WHERE id_request_sd = $request");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_supplies_detail($order,$request){
        $query = (" SELECT sd.pack, sd.id_order_package, sd.`order` "
                . " FROM dis_request_sd_detail sd "
                . " WHERE sd.`order` = $order AND sd.id_request_sd = $request AND type = 'Insumos'");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function get_supplies($order,$id_order_package_supplies){
        $query = (" SELECT A.id_order_package_supplies,A.number_pack,ATP.code as L_code,P.name,P.code, AO.quantity_packaged,P.weight_per_supplies "
                . " FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO ON "
                . " A.id_order_package_supplies = AO.access_order_package_supplies INNER JOIN pro_supplies P ON AO.id_supplies = P.id_supplies"
                . " INNER JOIN access_type_package ATP ON A.type_package = ATP.id_type_package WHERE A.`order` = $order "
                . " AND A.id_order_package_supplies = $id_order_package_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    public function data_dis_supplies($order,$id_order_package_supplies){
        $query = ("SELECT * FROM dis_request_sd_subdetail_package WHERE `order` = $order AND id_order_package_supplies = $id_order_package_supplies "
                . " AND type = 'I'");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_supplies_header($order,$id_order_package_supplies){
        $query = ("SELECT * FROM dis_request_sd_detail D INNER JOIN access_order_package_supplies A ON "
                . "D.id_order_package = A.id_order_package_supplies WHERE A.`order` = $order AND D.id_order_package = $id_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function get_data_trunk($request){
        $query = ("SELECT * FROM dis_request_sd D INNER JOIN dis_weight_vehicle DV ON D.id_weight_vehicle = DV.id_weight_vehicle "
                . " WHERE D.id_request_sd = $request");
        $result = $this->db->query($query);
        return $result->row();
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Delivery extends VS_Model {

    public function __construct() {
        parent::__construct();
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function SearchOrderSupplies($exclude) {

        if (!$exclude) {
            $this->db->where("p.exclude", 0);
        }

        $result = $this->db->select("*")
                ->from("access_order_supplies p")
                ->join("pro_supplies i", "p.id_supplies = i.id_supplies")
                ->where("p.`order`", $this->order)
                ->get();
        
        if ($result) {
            $array['res'] = "OK";
            $array['rows'] = $result->num_rows();
            $array['record'] = $result->result();
        } else {
            $array['res'] = "Error = " . $this->db->last_query();
        }

        return $array;
    }
    
    function SearchOrderSupplies2($order){
        $query = ("SELECT p.*,i.*,u.description,u.code as cd FROM access_order_supplies p JOIN pro_supplies i ON "
                . " p.id_supplies = i.id_supplies JOIN pro_unit u ON u.id_unit = i.id_unit WHERE p.`order` = $order AND p.id_status = 1");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }

    function searchOrderSupplies_deleted($order){
        $query = ("SELECT p.*,i.*,u.description,u.code as cd FROM access_order_supplies p JOIN pro_supplies i ON "
                . " p.id_supplies = i.id_supplies JOIN pro_unit u ON u.id_unit = i.id_unit WHERE p.`order` = $order AND p.id_status = 2");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_quantity_supplies($order,$id_order_supplies,$id_supplies){
        $query = ("SELECT A.* FROM access_order_package_supplies_detail A INNER JOIN access_order_package_supplies P "
                . " ON A.access_order_package_supplies = P.id_order_package_supplies WHERE A.id_order_supplies = $id_order_supplies "
                . " AND A.id_supplies = $id_supplies AND P.`order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_orders_supplies(){
        $query = ("SELECT A.* FROM access_order A INNER JOIN access_order_supplies S ON A.`order` = S.`order`"
                . " INNER JOIN pro_supplies P ON S.id_supplies = P.id_supplies GROUP BY A.`order`");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies($order){
        $query = ("SELECT A.* FROM access_order A INNER JOIN access_order_supplies S ON A.`order` = S.`order`"
                . " INNER JOIN pro_supplies P ON S.id_supplies = P.id_supplies WHERE A.`order` = $order GROUP BY A.`order`");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_package_supplies($order){
        $query = ("SELECT A.* FROM access_order A INNER JOIN access_order_supplies S ON A.`order` = S.`order`"
                . " INNER JOIN pro_supplies P ON S.id_supplies = P.id_supplies WHERE A.`order` = $order GROUP BY A.`order`");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_data_edit(){
        $query = ("SELECT OP.*, P.name, P.code, A.`order`, A.weight_per_package, OS.quantity, P.weight_per_supplies FROM access_order_package_supplies_detail OP "
                . "INNER JOIN access_order_package_supplies A ON OP.access_order_package_supplies = A.id_order_package_supplies "
                . "INNER JOIN pro_supplies P ON OP.id_supplies = P.id_supplies INNER JOIN access_order_supplies OS "
                . "ON OP.id_order_supplies = OS.id_order_supplies WHERE A.`order` = $this->order AND A.number_pack = $this->number_pack "
                . " AND OS.exclude = 0 ORDER BY OP.id_order_supplies ASC");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_data_add(){
        $query = ("SELECT OP.*, P.name, P.code, A.`order`, A.weight_per_package, OS.quantity, P.weight_per_supplies FROM access_order_package_supplies_detail OP "
                . " INNER JOIN access_order_package_supplies A ON OP.access_order_package_supplies = A.id_order_package_supplies "
                . " INNER JOIN pro_supplies P ON OP.id_supplies = P.id_supplies INNER JOIN access_order_supplies OS "
                . " ON OP.id_order_supplies = OS.id_order_supplies WHERE A.`order` = $this->order AND A.number_pack != $this->number_pack "
                . " AND OS.exclude = 0 ORDER BY OP.id_order_supplies ASC");
        $result = $this->db->query($query);
        //echo $this->db->last_query(); 
        return $result->result();
    }
    
    function get_items_supplies($order,$id_order_package_supplies,$number_pack){
        $query = ("SELECT A.number_pack, COUNT(*) AS total_pack FROM access_order_package_supplies_detail AO INNER JOIN access_order_package_supplies A "
                . " ON AO.access_order_package_supplies = A.id_order_package_supplies "
                . " WHERE A.`order` = $order AND A.id_order_package_supplies = $id_order_package_supplies AND A.number_pack = $number_pack");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->row();
    }
    
    function get_order_package_supplies($order){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order ORDER BY number_pack");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_order_package_supplies2($order){
        $query = ("SELECT A.*, SUM(AO.quantity_packaged) as quantity_pq FROM access_order_package_supplies A "
                . " INNER JOIN access_order_package_supplies_detail AO ON A.id_order_package_supplies = AO.access_order_package_supplies "
                . " WHERE A.`order` =  $order GROUP BY AO.access_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_data_manual($order){
        $query = ("SELECT P.id_supplies,P.name,P.code,P.weight_per_supplies,S.quantity, S.`order`, S.id_order_supplies, S.exclude "
                . " FROM pro_supplies P INNER JOIN access_order_supplies S ON S.id_supplies = P.id_supplies WHERE S.`order` = $order "
                . " AND S.exclude = 0 AND S.id_status = 1 ORDER BY S.id_order_supplies ASC");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_detail($id_order_supplies){
        $query = ("SELECT * FROM access_order_package_supplies_detail WHERE id_order_supplies = $id_order_supplies "
                . " ORDER BY id_order_supplies ASC");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_detail_modal($id_order_supplies){
        $query = ("SELECT aos.id_order_supplies,SUM(aos.quantity_packaged) AS quantity_packaged FROM access_order_package_supplies ao "
                . " INNER JOIN access_order_package_supplies_detail aos ON ao.id_order_package_supplies = aos.access_order_package_supplies "
                . " WHERE aos.id_order_supplies = $id_order_supplies GROUP BY aos.id_order_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_detail2($access_order_package_supplies,$id_order_supplies,$number_pack,$order){
        $query = ("SELECT a.* FROM access_order_package_supplies_detail a INNER JOIN access_order_package_supplies aos "
                . " ON aos.id_order_package_supplies = a.access_order_package_supplies WHERE a.id_order_supplies = $id_order_supplies "
                . " AND aos.`order` = $order AND a.access_order_package_supplies = $access_order_package_supplies "
                . " ORDER BY a.id_order_supplies ASC");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_supplies_detail21($access_order_package_supplies,$id_order_supplies,$number_pack,$order){
        $query = ("SELECT a.* FROM access_order_package_supplies_detail a INNER JOIN access_order_package_supplies aos "
                . " ON aos.id_order_package_supplies = a.access_order_package_supplies WHERE a.id_order_supplies = $id_order_supplies "
                . " AND aos.`order` = $order ORDER BY a.id_order_supplies ASC");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_detail3($access_order_package_supplies,$id_order_supplies,$number_pack,$order){
        $query = ("SELECT  a.id_order_package_supplies_detail,SUM(a.quantity_packaged) as quantity_packaged FROM "
                . " access_order_package_supplies_detail a INNER JOIN access_order_package_supplies aos ON "
                . " aos.id_order_package_supplies = a.access_order_package_supplies WHERE a.id_order_supplies = $id_order_supplies AND"
                . " aos.`order` = $order  ORDER BY a.id_order_supplies ASC");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_detail_sum($id_order_supplies){
        $query = ("SELECT SUM(A.quantity_packaged) AS quantity_packaged, AO.quantity FROM access_order_package_supplies_detail A "
                . " INNER JOIN access_order_supplies AO ON AO.id_order_supplies = A.id_order_supplies "
                . " WHERE A.id_order_supplies = $id_order_supplies AND AO.`order` = $this->order");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_package_supplies_pack(){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $this->order AND number_pack = $this->number_pack");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function Add_Packed(){
        $query = ("SELECT * FROM access_order_package_supplies WHERE number_pack = $this->package_number AND `order` = $this->order");
        $result = $this->db->query($query);
        if(count($result->result()) > 0){
            foreach ($result->result() as $key => $value) {
                $data = array(
                    "quantity_per_package" => $this->count + $value->quantity_per_package,
                    "quantity_total_supplies" => $this->count + $value->quantity_total_supplies,
                    "quantity_supplies" => $this->count + $value->quantity_supplies,
                    "weight_per_package" => $this->weight_package //+ $value->weight_per_package
                );
                $this->db->where("id_order_package_supplies", $value->id_order_package_supplies);
                $rs = $this->db->update("access_order_package_supplies", $data);
                $id = $value->id_order_package_supplies;
            }
        }else{
            $data = array(
                "number_pack"               => $this->package_number,
                "order"                     => $this->order,
                "type_package"              => '1',
                "quantity_packets"          => '1',
                "quantity_per_package"      => $this->count,
                "quantity_total_supplies"   => $this->count,
                "quantity_supplies"         => $this->count,
                "weight_per_package"        => $this->weight_package
            );

            $rs = $this->db->insert("access_order_package_supplies", $data);
            $id = $this->db->insert_id();
        }
        $this->data_dis_table($this->order);
        return $id;
    }
    
    function Add_Packed_Detail($id_access_order_package_supplies,$id_order_supplies,$id_supplies,$quantity_packaged){

        $query = ("SELECT a.*,ao.quantity FROM access_order_package_supplies_detail a INNER JOIN access_order_supplies ao ON a.id_order_supplies = ao.id_order_supplies "
                . "  WHERE a.id_order_supplies = $id_order_supplies AND a.access_order_package_supplies = $id_access_order_package_supplies "
                . " AND ao.`order` = $this->order ORDER BY a.id_order_supplies ASC");
        $result = $this->db->query($query);
        if(count($result->result()) > 0){
            $validation = ("SELECT * FROM access_order_package_supplies_detail WHERE id_order_supplies = $id_order_supplies");
            $result_vali = $this->db->query($validation);
            $quantity_packaged_sum = 0;
            foreach ($result_vali->result() as $value_r) {
                $quantity_packaged_sum = $quantity_packaged_sum + $value_r->quantity_packaged;
            }
            $quantity_packaged_sum = $quantity_packaged_sum + $quantity_packaged;
            foreach ($result->result() as $key => $value) {
                $quantity_packaged_sum2 = $value->quantity_packaged + $quantity_packaged;
                $total = $value->quantity;
                $id_order_package_supplies_detail = $value->id_order_package_supplies_detail;
            }
            //echo $total. " - ".$quantity_packaged_sum."<br>";
            if($total >= $quantity_packaged_sum){
               $data = array(
                    "quantity_packaged" => $quantity_packaged_sum2
                );
                $qt = $quantity_packaged + $quantity_packaged_sum2;
                $this->db->where("id_order_package_supplies_detail", $id_order_package_supplies_detail);
                $rs = $this->db->update("access_order_package_supplies_detail", $data); 
            }else{
                $qt = 0;
            }
            
        }else{
            $query2 = ("SELECT a.*,ao.quantity FROM access_order_package_supplies_detail a INNER JOIN access_order_supplies ao "
                    . " ON a.id_order_supplies = ao.id_order_supplies INNER JOIN access_order_package_supplies aos "
                    . " ON a.access_order_package_supplies = aos.id_order_package_supplies WHERE a.id_order_supplies = $id_order_supplies "
                    . " AND ao.`order` = $this->order");
            $result2 = $this->db->query($query2);
            //echo $this->db->last_query();
            $insert = 0;
            if(count($result2->result()) > 0){
                $total = 0;
                foreach ($result2->result() as $key => $value) {
                    $total = $total + $value->quantity_packaged;
                    if($value->quantity == $total || $quantity_packaged == 0 || $quantity_packaged == ""){
                        $insert = 1;
                    }else{
                        $insert = 0;
                    }
                }
                
            }
            if($insert == 0){
                $data = array(
                    "access_order_package_supplies" => $id_access_order_package_supplies,
                    "id_order_supplies"             => $id_order_supplies,
                    "id_supplies"                   => $id_supplies,
                    "quantity_packaged"             => $quantity_packaged
                );
                $qt = $quantity_packaged;
                $rs = $this->db->insert("access_order_package_supplies_detail", $data);
                $id = $this->db->insert_id();
            }else{
                $qt = 0;
                $id = 0;
            }
            
        }
        //$this->validation_supplies($this->order);
        return $qt;
    }
    
    function update_header(){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $this->order AND number_pack = $this->number_pack");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        foreach ($result->result() as $key => $value) {
            $data = array(
                "quantity_per_package"  => $this->count,
                "quantity_total_supplies"   => $this->count,
                "quantity_supplies"     => $this->count,
                "weight_per_package" => $this->weight_package
            );
            $this->db->where("id_order_package_supplies", $value->id_order_package_supplies);
            $rs = $this->db->update("access_order_package_supplies", $data); 
        }
        $this->data_dis_table($this->order);
        return $rs;
    }

    function update_header2(){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $this->order AND number_pack = $this->number_pack");
        $result = $this->db->query($query);
        foreach ($result->result() as $key => $value) {
            $data = array(
                "weight_per_package" => $this->weight_package
            );
            $this->db->where("id_order_package_supplies", $value->id_order_package_supplies);
            $rs = $this->db->update("access_order_package_supplies", $data); 
        }
        $this->data_dis_table($this->order);
        return $rs;
    }
    
    function Update_Packed_Detail($id_access_order_package_supplies,$id_order_supplies,$id_supplies,$quantity_packaged){
        $this->db->trans_begin();
        
        $query = ("SELECT ao.*, aos.quantity FROM access_order_package_supplies a INNER JOIN access_order_package_supplies_detail ao "
                . " ON a.id_order_package_supplies = ao.access_order_package_supplies INNER JOIN access_order_supplies aos "
                . " ON aos.id_order_supplies = ao.id_order_supplies WHERE a.`order` = $this->order "
                . " AND a.number_pack = $this->number_pack AND ao.id_order_supplies = $id_order_supplies "
                . " AND ao.access_order_package_supplies = $id_access_order_package_supplies "
                . " ORDER BY ao.id_order_supplies ASC");
        $result = $this->db->query($query);
        //echo $this->db->last_query();exit;
        $total = 0;
        $quantity_packaged_sum = 0;
        $id_order_package_supplies_detail = "";
        foreach ($result->result() as $key => $value) {
            $id_order_package_supplies_detail = $value->id_order_package_supplies_detail;
            $quantity_packaged_sum = $value->quantity_packaged + $quantity_packaged;
        }
        $query_quantity = ("SELECT * FROM access_order_supplies WHERE `order` = $this->order AND id_supplies = $id_supplies");
        $result_q = $this->db->query($query_quantity);
        //echo $this->db->last_query();
        foreach ($result_q->result() as $value_q){
            $total = $value_q->quantity; // 72
        }
        $validation = ("SELECT * FROM access_order_package_supplies_detail WHERE id_order_supplies = $id_order_supplies");
        $result_vali = $this->db->query($validation);
        //echo $this->db->last_query();
        $quantity_packaged_sum2 = 0;
        $count_total = 0;
        $count_id = 0;
        foreach ($result_vali->result() as $value_r) {
            //echo $value_r->id_order_package_supplies_detail ."-". $id_order_package_supplies_detail."<br>";
            $count_total = $count_total + $value_r->quantity_packaged;
            //$count_total =  $value_r->quantity_packaged;
            if($value_r->id_order_package_supplies_detail != $id_order_package_supplies_detail){
                //echo $value_r->quantity_packaged;
                $quantity_packaged_sum2 = $quantity_packaged_sum2 + $value_r->quantity_packaged;
            }else{
                //echo '-g-';
                $count_id = 1;
                $quantity_packaged_sum2 = $quantity_packaged + $quantity_packaged_sum2;
            }
        }
        //echo $quantity_packaged_sum2." - ".$total;
        //$rs = "";
        if($quantity_packaged_sum2 <= $total){
            //echo 'netx';exit;
            if($count_id == 1){
                //echo 'update';
                $data = array(
                    "quantity_packaged" => $quantity_packaged
                );
                $qt = $quantity_packaged;
                $this->db->where("id_order_package_supplies_detail", $id_order_package_supplies_detail);
                $rs = $id_order_package_supplies_detail;
                $this->db->update("access_order_package_supplies_detail", $data);
            }else{
                $data = array(
                    "access_order_package_supplies" => $id_access_order_package_supplies,
                    "id_order_supplies"             => $id_order_supplies,
                    "id_supplies"                   => $id_supplies,
                    "quantity_packaged"             => $quantity_packaged
                );
                $qt = $quantity_packaged;
                $this->db->insert("access_order_package_supplies_detail", $data);
                $rs = $this->db->insert_id();
            }
            //echo $id_order_package_supplies_detail;   
        }else{
            $rs = 0;
        }
        //$this->validation_supplies($this->order);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $rs = array("rs" => $this->db->last_query());
        } else {
            $this->db->trans_commit();

            $rs = $rs;
        }
        return $rs;
    }
    
    function delete_packed_detail(){
        $query = ("SELECT A.* FROM access_order_package_supplies_detail A INNER JOIN access_order_package_supplies O "
                . " ON A.access_order_package_supplies = O.id_order_package_supplies WHERE A.id_order_package_supplies_detail = $this->id_order_package_supplies_detail "
                . " AND O.`order` = $this->order");
        $result = $this->db->query($query);
        //echo $this->db->last_query(); exit;
        if(count($result->result()) > 0){
            $cnt = 0;
            foreach ($result->result() as $key => $value) {
                $id_order_package_supplies_detail = $value->id_order_package_supplies_detail;
                $id_supplies = $value->id_supplies;
                $id_order_package_supplies = $value->access_order_package_supplies;
                
                $this->db->where("`id_order_package_supplies_detail`", $id_order_package_supplies_detail);
                $rs = $this->db->delete("access_order_package_supplies_detail");
                $this->delete_dis_subdetail($this->order,$id_order_package_supplies,$id_supplies);
            }
        }else{
            $rs = 0;
        }
        //$this->update_h();
        //$res = $this->validation_supplies($this->order);
        return $rs;
    }
    
    function update_h(){
        $query2 = ("SELECT * FROM access_order_package_supplies WHERE `order` = $this->order AND number_pack = $this->number_pack");
        $result = $this->db->query($query2);
        
        $val_cnt = ("SELECT AO.* FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO ON "
                . " A.id_order_package_supplies = AO.access_order_package_supplies WHERE A.`order` = $this->order "
                . " AND A.number_pack = $this->number_pack ");
        $result_val = $this->db->query($val_cnt);
        //echo $this->db->last_query();
        $cnt = 0;
        $weight = 0;
        if(count($result_val->result()) != null){
            //print_r($result_val->result());
            foreach ($result_val->result() as $value) {
                $cnt = $cnt + $value->quantity_packaged;
                $query_w = (" SELECT * FROM access_order_package_supplies_detail A INNER JOIN pro_supplies P ON A.id_supplies = P.id_supplies "
                        . " WHERE A.id_order_package_supplies_detail = $value->id_order_package_supplies_detail");
                $result_w = $this->db->query($query_w);
                foreach ($result_w->result() as $valuew) {
                    $weight = $weight + ( $valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
            }
        }
        //echo $this->db->last_query();
        foreach ($result->result() as $key => $value2) {
            $data = array(
                "quantity_per_package"  => $cnt,
                "quantity_total_supplies"   => $cnt,
                "quantity_supplies"     => $cnt,
                "weight_per_package" => $weight
            );
            $this->db->where("id_order_package_supplies", $value2->id_order_package_supplies);
            $rs = $this->db->update("access_order_package_supplies", $data); 
        }
        return $this->data_dis_table($this->order);
    }
    
    function last_pack($order){
       $query = ("SELECT MAX(number_pack) AS pack FROM access_order_package_supplies WHERE `order` = $order");
        $result = $this->db->query($query);
        return $result->result(); 
    }
    
    function get_order_supplies(){
        $query = ("SELECT * FROM access_order_supplies WHERE id_order_supplies = $this->id_order_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_order_supplies_back(){
        $query = ("SELECT ao.* FROM access_order_supplies ao INNER JOIN access_order_package_supplies_detail aop ON "
                . " ao.id_order_supplies = aop.id_order_supplies INNER JOIN access_order_pacakge_supplies aops ON "
                . " aops.id_order_package_supplies = aop.access_order_package_supplies WHERE ao.id_order_supplies = $this->id_order_supplies "
                . " AND aops.number_pack = $this->package_number");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function total_order_supplies($order){
        $query = ("SELECT A.id_order_supplies, A.quantity FROM access_order_supplies A WHERE A.`order` = $order "
                . " AND A.exclude = 0 AND A.id_status = 1");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_total_quantity_packet(){
        $query = ("SELECT aos.id_order_supplies,SUM(aos.quantity_packaged) AS quantity_packed FROM access_order_package_supplies ao "
                . " INNER JOIN access_order_package_supplies_detail aos ON ao.id_order_package_supplies = aos.access_order_package_supplies "
                . " WHERE ao.`order` = $this->order GROUP BY aos.id_order_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_total_quantityxsupplies($id_order_supplies,$order){
        $query = ("SELECT aos.id_order_supplies,SUM(aos.quantity_packaged) AS quantity_packaged FROM access_order_package_supplies ao "
                . " INNER JOIN access_order_package_supplies_detail aos ON ao.id_order_package_supplies = aos.access_order_package_supplies "
                . " WHERE ao.`order` = $order AND aos.id_order_supplies = $id_order_supplies GROUP BY aos.id_order_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        //return $result->result();
    }
    
    function get_data_header(){
        $query = ("SELECT * FROM access_order_package_supplies WHERE id_order_package_supplies = $this->id_order_package_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function validation_supplies($order){
        $res = true;
        $where = "";
//        if(isset($this->number_pack)){
//            $where = " AND number_pack = $this->number_pack ";
//        }
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order ".$where);
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        if(count($result->result()) > 0){
            $number_pack_total = 0;
            foreach ($result->result() as $value) {
                $number_pack_total++;
                $array_id_order_package[] = $value->id_order_package_supplies;
            }
            
            $number_pack = 0;
            $total_packs_detail = 0;
            $count = 0;
            foreach ($result->result() as $value2) {
                $number_pack++;
                $query2 = ("SELECT A.* FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO "
                        . " ON A.id_order_package_supplies = AO.access_order_package_supplies WHERE A.`order` = $order AND A.number_pack = $value2->number_pack "
                        . " AND AO.access_order_package_supplies = $array_id_order_package[$count] GROUP BY AO.access_order_package_supplies");
                $result2 = $this->db->query($query2);
                //echo $this->db->last_query();
                if(count($result2->result()) > 0){
                    $total_packs_detail++;
                    $array_id_update[] = $array_id_order_package[$count];
                }else{
                    $array_id_delete[] = $array_id_order_package[$count];
                }
                $count++;
            }
            
            if(isset($array_id_delete)){
                for($i = 0; $i < count($array_id_delete); $i++){
                    $this->db->where("id_order_package_supplies", $array_id_delete[$i]);
                    $rs = $this->db->delete("access_order_package_supplies");
                }
                $res = 1;
            }
            
            if(isset($total_packs_detail) && isset($array_id_update)){
                for($e = 0; $e < count($array_id_update); $e++){
                    $data = array(
                        "number_pack" => $e + 1
                    );
                    $this->db->where("id_order_package_supplies", $array_id_update[$e]);
                    $rs = $this->db->update("access_order_package_supplies", $data);
                }
            }
            
        }
        return $res;
    }
    
    function validation_supplies2($order){
        $this->db->trans_begin();
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order AND number_pack = $this->number_pack ");
        $result = $this->db->query($query);
        //echo $this->db->last_query();exit;
        if(count($result->result()) > 0){
            foreach ($result->result() as $value) {
                $this->db->where("id_order_package_supplies", $value->id_order_package_supplies);
                $rs = $this->db->delete("access_order_package_supplies");
            }
            $query2 = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order");
            $result2 = $this->db->query($query2);
            $count = $result2->result();
            foreach ($count as $key => $value2) {
                $data = array(
                    "number_pack" => $key + 1
                );
                $this->db->where("id_order_package_supplies", $value2->id_order_package_supplies);
                $rs = $this->db->update("access_order_package_supplies", $data);
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $res = array("res" => $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $res = true;
        }
        return $res;
    }
    
    function get_empty_packs($order){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order AND quantity_total_supplies = 0");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_number_pack_order($order){
        $query = ("SELECT MAX(A.number_pack) AS number_pack FROM access_order_package_supplies A WHERE A.`order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_dis_table($order){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        if(count($result->result()) > 0){
           
            foreach ($result->result() as $value) {
                $query21 = ("SELECT * FROM access_order_package_supplies_detail AO INNER JOIN pro_supplies P ON AO.id_supplies = P.id_supplies "
                        . " WHERE AO.access_order_package_supplies = $value->id_order_package_supplies ");
                $result21 = $this->db->query($query21);
                $count_pack = 0;
                $weight_per_supplies = 0;
                foreach ($result21->result() as $value21) {
                    $count_pack++;
                    $weight_per_supplies = $weight_per_supplies + ($value21->weight_per_supplies * $value21->quantity_packaged);
                }
                
//                $query_dis = ("SELECT * FROM dis_request_sd_subdetail_package WHERE id_order_package_supplies = $value->id_order_package_supplies "
//                        . " AND `order` = $order AND type = 'I'");
//                $result_dis = $this->db->query($query_dis);
//                if(count($result_dis->result()) > 0){
//                    foreach ($result_dis->result() as $value_dis) {
//                        $number = $value_dis->number;
//                    }
//                }else{
//                    $number = 0;
//                }
                
                $validation = ("SELECT * FROM dis_request_sd_subdetail_package WHERE id_order_package_supplies = $value->id_order_package_supplies "
                        . " AND `order` = $order");
                $result_vali = $this->db->query($validation);
                //echo $this->db->last_query();
                if(count($result_vali->result()) > 0){
                    foreach ($result_vali->result() as $value_vali) {
                        $data = array(
                            "number"         => $value->number_pack,
                            "weight_package" => $weight_per_supplies,
                            "type"           => 'I',
                            "quantity_total" => count($result->result())
                        );
                        $this->db->where("id_request_detail_package", $value_vali->id_request_detail_package);
                        $rs = $this->db->update("dis_request_sd_subdetail_package", $data);
                    }
                }else{
                    $data = array(
                        "id_request_detail" => '0',
                        "id_request_sd"     => '0',
                        "id_order_package_supplies"  => $value->id_order_package_supplies, //id_order_package_supplies @saraorrego
                        "id_forniture"      => '0',
                        "id_supplies"       => '0',
                        "`order`"           => $order,
                        "pack"              => "",
                        "weight_package"    => $weight_per_supplies,
                        "number"            => $value->number_pack,
                        "id_status"         => '17',
                        "type"              => 'I',
                        "quantity_total"    => $count_pack,
                        "number_pack"       => $value->number_pack,
                        "type_package"      => '1'
                    );
                    $this->db->insert("dis_request_sd_subdetail_package", $data);
                    $rs = $this->db->insert_id();
                }
            }
            
        }
    }
    
    function delete_dis_subdetail($order,$id_order_package_supplies,$id_supplies){
        $validation = ("SELECT * FROM dis_request_sd_subdetail_package WHERE id_order_package_supplies = $id_order_package_supplies "
                        . " AND `order` = $order");
        $result_vali = $this->db->query($validation);
        //echo $this->db->last_query();
        if(count($result_vali->result()) > 0){
            foreach ($result_vali->result() as $value_vali) {
                $this->db->where("`id_request_detail_package`", $value_vali->id_request_detail_package);
                $rs = $this->db->delete("dis_request_sd_subdetail_package");
            }
        }
    }
    
    function data_tags_supplies($order,$id_order_package_supplies){
        $query = ("SELECT AO.id_order_package_supplies,P.id_supplies,P.name AS supplies, P.code, AC.project, AC.`client`, AC.`type`,"
                . " A.quantity_packaged FROM access_order_package_supplies_detail A INNER JOIN pro_supplies P ON A.id_supplies = P.id_supplies "
                . " INNER JOIN access_order_package_supplies AO ON A.access_order_package_supplies = AO.id_order_package_supplies "
                . " INNER JOIN access_order AC ON AO.`order` = AC.`order` "
                . " WHERE AO.`order` = $order AND AO.id_order_package_supplies = $id_order_package_supplies");
        $result = $this->bd->query($query);
        //echo $this->db->last_query(); 
        if(count($result->result()) > 0){
            foreach ($result->result() as $value) {
                $query_tags = ("");
                $result_tags = $this->db->query($query_tags);
                if(count($result_tags->result()) > 0){
                    foreach ($result_tags->result() as $value_tags) {
                        $data = array( // array
                            "quantity" => $value->quantity_packaged
                        );
                        $this->db->where("id_tags_supplies", $value_tags->id_tags_supplies);
                        $rs = $this->db->update("pro_tags_supplies", $data);
                    }
                }else{
                    $data = array(
                        "id_order_package_supplies" => $value->id_order_package_supplies,
                        "id_supplies"               => $value->id_supplies,
                        "supplies"                  => $value->supplies,
                        "code"                      => $value->code,
                        "project"                   => $value->project,
                        "client"                    => $value->client,
                        "type"                      => $value->type,
                        "order"                     => $order,
                        "quantity"                  => $value->quantity_package
                    );
                    $this->db->insert("dis_request_sd_subdetail_package", $data);
                    $rs = $this->db->insert_id();
                }
                
            } 
        }
    }


    function data_supplies_all(){ // function add item
        $query = ("SELECT * FROM pro_supplies p INNER JOIN access_order_supplies A ON p.id_supplies = A.id_supplies WHERE A.`order` <> $this->order");
        $result = $this->db->query($query);
        return $result->result();
    }

    function data_suppliesxSupplies($id_supplies){ // function replace
        $query = ("SELECT * FROM pro_supplies p INNER JOIN access_order_supplies A ON p.id_supplies = A.id_supplies WHERE A.`order` = $this->order AND A.id_supplies = $id_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }

    function data_suppliesxSuppliesParam($id_supplies,$order){ // function replace
        $query = ("SELECT * FROM pro_supplies p INNER JOIN access_order_supplies A 
        ON p.id_supplies = A.id_supplies WHERE A.`order` = $order AND A.id_order_supplies = $id_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->row();
    }

    function get_supplies_all(){
        $query = ("SELECT * FROM pro_supplies p INNER JOIN access_order_supplies A ON p.id_supplies = A.id_supplies WHERE A.`order` = $this->order");
        $result = $this->db->query($query);
        return $result->result();
    }

    function get_suppliesXid($id_supplies){
        $query = ("SELECT * FROM pro_supplies p WHERE p.id_supplies = $id_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }

    function get_type_supplies(){
        $query = ("SELECT * FROM pro_type_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }

    function get_unity(){
        $query = ("SELECT * FROM pro_unit");
        $result = $this->db->query($query);
        return $result->result();
    }

    function Add_new_to_order(){
        $this->db->trans_begin();

        $data = array(
            "order"         => $this->order,
            "id_supplies"   => $this->id_supplies,
            "quantity"      => $this->quantity,
            "additional"    => '2',
            "observation_additional" => $this->observation
        );
        $this->db->insert("access_order_supplies", $data);

        $array = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $array = array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $array = array("res" => $this->db->insert_id());
        }

        return $array;
    }

    function get_suppliesXcode(){
        $query = ("SELECT * FROM pro_supplies p WHERE p.code = '$this->code'");
        $result = $this->db->query($query);
        return $result->result();
    }

    function get_suppliesXcodeParam($code){
        $query = ("SELECT * FROM pro_supplies p WHERE p.code = '$code'");
        $result = $this->db->query($query);
        return $result->result();
    }

    function save_supplies($arr,$id_unit){
        $this->db->trans_begin();

        $data = array(
            "name"          => $arr->ITEMNAME,
            "code"          => $arr->Referencia,
            "id_unit"       => $id_unit,
            "id_type_supplies"    => '1' // netx
            //"quantity_per_package"  => ,
            //"weight_per_supplies"   => $arr->weight_unt,
        );
        $this->db->insert("pro_supplies", $data);

        $array = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $array = array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $array = array("res" => $this->db->insert_id());
        }
        
        return $array;

    }

    function get_unitxDes($description){
        $query = ("SELECT * FROM pro_unit WHERE description LIKE '%$description%'");
        $result = $this->db->query($query);
        return $result->row();
    }

    function save_new_item(){

        $this->db->trans_begin();

        $data = array(
            "name"         => $this->name,
            "code"   => $this->code,
            "id_unit"      => $this->unity,
            "id_type_supplies"    => $this->type,
            "quantity_per_package"  => $this->cnt,
            "weight_per_supplies"   => $this->weight_unt,
        );
        $this->db->insert("pro_supplies", $data);
        $id = $this->db->insert_id();

        $data = array(
            "order"     => $this->order,
            "id_supplies"   => $id,
            "quantity"      => $this->cnt,
            "additional"    => '2',
            "observation_additional" => $this->observation
        );
        $this->db->insert("access_order_supplies", $data);

        $array = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $array = array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $array = array("res" => $this->db->insert_id());
        }
        
        return $array;
    }

    function Replace_to_order(){
        $this->db->trans_begin();

        $query = ("SELECT * FROM access_order_supplies WHERE `order` = $this->order AND id_supplies = $this->id_supplies");
        $result = $this->db->query($query);
        $data_query = $result->row();


        //se agrega el item nuevo
        $data = array(
            "order"         => $this->order,
            "id_supplies"   => $this->supplies,
            "quantity"      => $this->cnt,
            "additional"    => '2',
            "replaced_supplies" => $data_query->id_order_supplies,
            "observation_replaced"  => $this->observation
        );
        $id = $this->db->insert("access_order_supplies", $data);

        // se actualiza el item viejo
        $data = array(
            "exclude"           => '1',
            "id_status"         => '2',
            "replaced_supplies" => $this->db->insert_id(), //id_order_supplies
            "observation_replaced"  => $this->observation
        );
        $this->db->where("id_order_supplies", $data_query->id_order_supplies);
        $rs = $this->db->update("access_order_supplies", $data);

        $array = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $array = array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $array = array("res" => $this->db->insert_id());
        }
        
        return $array;
    }

    function Delete_to_order(){

        $this->db->trans_begin();

        $data = array(
            "id_status" => '2'
        );
        $this->db->where("id_order_supplies", $this->id_order_supplies);
        $rs = $this->db->update("access_order_supplies", $data);

        $array = array();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $array = array("res" => "Error " . $this->db->last_query());
        } else {
            $this->db->trans_commit();
            $array = array("res" => $rs);
        }
        
        return $array;
    }

    function Detail_replaced($id_order_supplies){
        $query = ("SELECT * FROM pro_supplies p INNER JOIN access_order_supplies A ON p.id_supplies = A.id_supplies WHERE A.id_order_supplies=$id_order_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_supplies($order,$id_order_package_supplies){
        $query = ("SELECT AO.id_order_package_supplies,AO.number_pack,AO.quantity_packets,P.id_supplies,P.name AS supplies, P.code, AC.project, AC.`client`, AC.`type`,"
                . " A.quantity_packaged FROM access_order_package_supplies_detail A INNER JOIN pro_supplies P ON A.id_supplies = P.id_supplies "
                . " INNER JOIN access_order_package_supplies AO ON A.access_order_package_supplies = AO.id_order_package_supplies "
                . " INNER JOIN access_order AC ON AO.`order` = AC.`order` "
                . " WHERE AO.`order` = $order AND AO.id_order_package_supplies = $id_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function detail_supplies($order,$id_order_package_supplies){
        $query = ("SELECT A.id_order_package_supplies, P.name, P.code, P.dimension,PT.description,P.weight_per_supplies,AO.quantity_packaged FROM access_order_package_supplies_detail"
                . " AO INNER JOIN access_order_package_supplies A ON AO.access_order_package_supplies = A.id_order_package_supplies "
                . " INNER JOIN pro_supplies P ON AO.id_supplies = P.id_supplies INNER JOIN pro_type_supplies PT ON P.id_type_supplies = PT.id_type_supplies"
                . " WHERE A.`order` = $order AND A.id_order_package_supplies = $id_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_data_dis($order,$id_order_package_supplies){
        $query = ("SELECT o.`client`,o.project,SUM(p.quantity_packaged) AS cantidad_insumos, p.access_order_package_supplies,ao.number_pack,d.number,"
                . " CONCAT(p.access_order_package_supplies,'-',d.number,'-',d.`type`) AS codeqr,t.code AS tipo_paquete,ao.quantity_packets "
                . " FROM dis_request_sd_subdetail_package d JOIN access_order_package_supplies_detail p JOIN pro_supplies m "
                . " ON p.id_supplies = m.id_supplies JOIN access_order_package_supplies ao ON ao.id_order_package_supplies = p.access_order_package_supplies "
                . " AND ao.id_order_package_supplies = d.id_order_package_supplies JOIN access_order o ON ao.`order` = o.`order` "
                . " JOIN access_type_package t ON ao.type_package = t.id_type_package WHERE ao.`order` = $order "
                . " AND ao.id_order_package_supplies = $id_order_package_supplies GROUP BY p.access_order_package_supplies ");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function Count_packs($order){
        $query = ("SELECT COUNT(*) as total FROM access_order_package_supplies a WHERE a.`order` = $order ");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_data_weight($order,$id_order_package_supplies){
        $query = ("SELECT A.id_order_package_supplies,P.weight_per_supplies,AO.quantity_packaged, P.weight_per_supplies * AO.quantity_packaged AS total"
                . " FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO "
                . " ON A.id_order_package_supplies = AO.access_order_package_supplies INNER JOIN pro_supplies P ON AO.id_supplies = P.id_supplies "
                . " WHERE A.`order` = $order AND A.id_order_package_supplies = $id_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function searchOrderSuppliesPending($order){
        $query = ("SELECT A.*,AO.id_order_supplies,AO.id_supplies, SUM(AO.quantity_packaged) as quantity_packaged "
                . " FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO "
                . " ON A.id_order_package_supplies = AO.access_order_package_supplies WHERE A.`order` = $order GROUP BY AO.id_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_order_package($orders){
        $query = ("");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_order_supplies($orders){
        $query = ("SELECT A.`order`,AO.*, SUM(AO.quantity_packaged) as total FROM access_order_package_supplies A "
                . " INNER JOIN access_order_package_supplies_detail AO ON  A.id_order_package_supplies = AO.access_order_package_supplies "
                . " WHERE A.`order` IN ($orders) GROUP BY AO.id_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_order_supplies2($orders){
        $query = ("SELECT P.code,P.name,A.*, SUM(A.quantity) as total FROM access_order_supplies A INNER JOIN pro_supplies P "
                . " ON A.id_supplies = P.id_supplies WHERE A.`order` IN ($orders) GROUP BY A.id_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }

    function SearchOrderPackSD() {
        
        $result = $this->db->select("*")
                ->from("access_order_pieces p")
                ->join("access_order_item i", "p.id_order_item = i.id_access_order_item")
                ->join("pro_wood_sheet l", "p.code_sheet_ax = l.code", "left")
                ->where("i.`order`", $this->order)
                ->get();
        
        if ($result) {
            $array['res'] = "OK";
            $array['rows'] = $result->num_rows();
            $array['record'] = $result->result();
        } else {
            $array['res'] = "Error = " . $this->db->last_query();
        }
        
        return $array;
    }

    function InfoOrder() {
        $rs = $this->db->select("*")
                ->from("access_order p")
                ->where("p.`order`", $this->order)
                ->get();
        return $rs->row();
    }
    
    function SuppliesOrderWeight($order){
        $result = $this->db->select("*")
                ->from("access_order_supplies p")
                ->join("pro_supplies i", "p.id_supplies = i.id_supplies")
                ->where("p.`order`", $order)
                ->where("i.weight_per_package is null ")
                ->or_where("i.quantity_per_package is null ")
                ->group_by("p.id_supplies")
                ->get();
        if($result->num_rows() > 0){
            $array['res'] = "";
            $array['result'] = $result->result();
        }else{
            $array['res'] = "OK";
        }
        return $array;
    }
    
    function UpdateWeightSupplies(){
        //var_dump($this->GeneralArray);
        $array = array();
        foreach ($this->GeneralArray as $v) {
            $array[] = array("id_supplies"=>$v[0],"quantity_per_package"=>$v[1],"weight_per_package"=>$v[2]);
        }
        $rs = $this->db->update_batch('pro_supplies', $array, "id_supplies");
        
        if ($rs) {
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }

        return $array;
    }

    function UpdateOrderSupplies() {
        if($this->value == 0){
            $this->obs = "";
        }
        $data = array(
            $this->field => $this->value,
            'observation_exclude'   => $this->obs
        );

        $this->db->where("id_order_supplies", $this->id_order_supplies);
        $rs = $this->db->update("access_order_supplies", $data);

        if ($rs) {
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query(), "id" => "");
        }

        return $array;
    }

    function CreatePackSupplies($data, $tags) {

        $rs = $this->db->insert("access_order_package_supplies", $data);
        if ($rs) {
            $tags['id_order_package_supplies'] = $this->db->insert_id();
            for ($index = 1; $index <= $data["quantity_packets"]; $index++) {
                $this->db->insert("pro_tags_supplies", $tags);
            }

            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }
        return $array;
    }

    function DeliverySuppliesCount($order) {
        
        $rs = $this->db->select("id_delivery_supplies,s.hex")
                ->from("pro_delivery_supplies p")
                ->join("sys_status s", "p.`status` = s.id_status")
                ->where("p.`order`", $order)
                ->where("p.`status` <> 3")
                ->order_by("id_delivery_supplies")
                ->get();

        return $rs->result();
    }

    function InfoPackSupplies($order) {
        $result = $this->db->select("i.code,i.name,t.code as pack,e.*")
                ->from("access_order_package_supplies e")
                ->join("pro_supplies i", "e.id_order_supplies = i.id_supplies")
                ->join("access_type_package t", "e.type_package = t.id_type_package")
                ->where("e.`order`", $order)
                ->order_by("e.id_order_supplies")
                ->get();
        $array = array("data" => $result->result(), "count" => $result->num_rows());
        return $array;
    }
    
    function InfoPackSupplies2($order) {
        $result = $this->db->select("i.code,i.name,t.code as pack,e.*")
                ->from("access_order_package_supplies e")
                ->join("pro_supplies i", "e.id_order_supplies = i.id_supplies")
                ->join("access_type_package t", "e.type_package = t.id_type_package")
                ->where("e.`order`", $order)
                ->order_by("e.id_order_supplies")
                ->get();
        //echo $this->db->last_query();
        $array = array("data" => $result->result(), "count" => $result->num_rows());
        return $array;
    }
    
    function InfoPackSupplies_RE($order) {
        $result = $this->db->select("i.code,i.name,t.code as pack,e.*")
                ->from("access_order_package_supplies e")
                ->join("access_order_package_supplies_detail ao", "e.id_order_package_supplies = ao.access_order_package_supplies")
                ->join("pro_supplies i", "ao.id_order_supplies = i.id_supplies")
                ->join("access_type_package t", "e.type_package = t.id_type_package")
                ->where("e.`order`", $order)
                ->group_by("ao.access_order_package_supplies")
                ->order_by("ao.id_order_supplies")
                ->get();
        //echo $this->db->last_query();
        $array = array("data" => $result->result(), "count" => $result->num_rows());
        return $array;
    }
    
    function LoadContentPendintOrder($order){
        $query = ("SELECT AO.*, AOS.quantity, SUM(AO.quantity_packaged) AS total FROM access_order_package_supplies A INNER JOIN "
                . " access_order_package_supplies_detail AO ON A.id_order_package_supplies = AO.access_order_package_supplies "
                . " INNER JOIN access_order_supplies AOS ON A.`order` = AOS.`order` AND AOS.id_supplies = AO.id_supplies "
                . " WHERE A.`order` = $order GROUP BY AO.id_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function LoadContentPendintOrderPack($order){
        $query = ("SELECT A.id_order_package,A.number_pack,A.`order`,A.quantity_packets,A.delivered_quantity,AF.description,AF.item, "
                . " A.id_forniture, ATP.code FROM access_order_package A INNER JOIN access_forniture AF ON A.id_forniture = AF.id_forniture "
                . " INNER JOIN access_type_package ATP ON A.type_package = ATP.id_type_package WHERE A.`order` =  $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_order_suppliesxorder($order){
        $query = ("SELECT * FROM access_order_supplies A INNER JOIN pro_supplies P ON A.id_supplies = P.id_supplies "
                . " WHERE A.`order` = $order AND A.exclude = '0'");
        $result = $this->db->query($query);
        return $result->result();
    }

    function get_order_suppliesxorder2($order){
        $query = ("SELECT * FROM access_order_supplies A INNER JOIN pro_supplies P ON A.id_supplies = P.id_supplies "
                . " WHERE A.`order` = $order");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_quantity_packaged($order,$id_order_supplies){
        $query = ("SELECT AO.* FROM access_order_package_supplies A INNER JOIN access_order_package_supplies_detail AO "
                . " ON A.id_order_package_supplies = AO.access_order_package_supplies WHERE A.`order` = $order "
                . " AND AO.id_order_supplies = $id_order_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function packs_quantity($order){
        $query = ("SELECT COUNT(*) AS packs FROM access_order_package_supplies A WHERE A.`order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function data_order($order){
        $query = ("SELECT * FROM access_order WHERE `order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }

    function InfoPackSD($order) {

        $result = $this->db->select("pp.id_order_package,m.item,m.description,pp.number_pack,tp.code,pp.quantity_packets,pp.delivered_quantity,"
                . "(pp.quantity_packets-pp.delivered_quantity) as saldo,pp.quantity_pieces,pp.weight,`fcount_quantity_pieces_add`(pp.id_order_package)as quantity_pieces_add")
                ->from("access_order_package  pp")
                ->join("view_forniture_sd m ", " pp.id_forniture = m.id_forniture","left")
                ->join("access_type_package tp ", " pp.type_package = tp.id_type_package")
                ->where("pp.`order`", $order)
                ->order_by("pp.id_forniture,pp.type_package,pp.number_pack")
                ->get();
        //echo $this->db->last_query();
        $total_weight = 0;
        foreach ($result->result() as $key => $value) {
            $total_weight = $total_weight + $value->weight;
        }
        $array = array("data" => $result->result(), "count" => $result->num_rows(), "total_weight" => $total_weight);
        return $array;
    }

    function WeightForPackSD() {
        $result = $this->db->select("p.id_order_package,sum(pz.weight)+ifnull(fsum_weight_pieces_add(p.id_order_package),0) as weight")
                ->from("access_order_package p")
                ->join("access_order_package_detail d", "p.id_order_package = d.id_order_package")
                ->join("access_order_pieces pz", "d.id_order_pieces = pz.id_access_order_pieces")
                ->where("p.`order`", $this->order)
                ->group_by("d.id_order_package")
                ->get();
        //echo $this->db->last_query();
        if ($result->num_rows() > 0) {
            $data = $result->result_array();
            $rs = $this->db->update_batch('access_order_package', $data, 'id_order_package');
            
            $result2 = $this->db->query("SELECT * FROM access_order_package WHERE `order` = $this->order");
            foreach ($result2->result() as $r) {
                $result3 = $this->db->query("SELECT * FROM dis_request_sd_subdetail_package WHERE `order` = $r->order "
                        . "AND id_forniture = $r->id_forniture"
                        . " AND id_order_package = $r->id_order_package");
                //echo $this->db->last_query();
                
                foreach ($result3->result() as $r2) {
                    $datos = array("weight_package" => $r->weight/$r->quantity_packets);
                    $this->db->where("id_request_detail_package", $r2->id_request_detail_package);
                    $rs = $this->db->update("dis_request_sd_subdetail_package", $datos);
                }
            }
            $res = "OK";
            
        }else{
            $res = "EMPTY";
        }
        return $res;
    }

    function Delete_Packs_And_Tags_Supplies() {
        $this->db->where("`order`", $this->order);
        $rs = $this->db->delete("access_order_package_supplies");

        $this->db->where("`order`", $this->order);
        $rs = $this->db->delete("pro_tags_supplies");
    }

    function InfoTagsSupplies($order) {
        $rs = $this->db->select("*")
                ->from("pro_tags_supplies")
                ->where("`order`", $order)
                ->get();
        return $rs->result();
    }

    function LoadHeaderOrder($order) {
        $result = $this->db->select("*")
                ->from("access_order")
                ->where("`order`", $order)
                ->get();
        
        return $result->row();
    }

    function LoadFornitureOrder($order) {
        $result = $this->db->select("*,o.color as colored")
                ->from("access_order_item o")
                ->join("access_forniture f", "o.id_forniture = f.id_forniture and f.type_forniture = o.type_forniture")
                ->where("`order`", $order)
                ->order_by("f.item")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }

    function LoadPackages($order, $forniture) {

        $result = $this->db->query("SELECT p.*, t.code, tp.description
            FROM access_order_package p
            JOIN access_type_package t ON p.type_package = t.id_type_package
            JOIN access_type_packing tp ON p.type_packing = tp.id_type_packing
            WHERE `order` = '$order' AND p.id_forniture = '$forniture'
            ORDER BY CASE p.type_package WHEN 2 THEN 2 WHEN 1 THEN 0 ELSE 1 END, p.number_pack asc");
        //echo $this->db->last_query();
        return $result->result();
    }

    function LoadPackagesSupplies($order) {

        $result = $this->db->select("i.code,i.name,t.code as pack,p.quantity_per_package,p.quantity_supplies,p.quantity_packets,p.id_order_package_supplies,p.type_package,delivered_quantity")
                ->from("access_order_package_supplies p")
                ->join("access_order_package_supplies_detail ao", "p.id_order_package_supplies = ao.access_order_package_supplies")
                ->join("pro_supplies i", "ao.id_supplies = i.id_supplies")
                ->join("access_type_package t", "p.type_package = t.id_type_package")
                ->where("p.`order`", $order)
                ->order_by("i.code,t.code desc")
                ->get();

        return $result->result();
    }
    
    function LoadPackagesSupplies2($id_order_package_supplies) {

        $result = $this->db->select("AO.*,P.*,AS.quantity as quantity_t")
                ->from("access_order_package_supplies_detail AO")
                ->join("pro_supplies P", "AO.id_supplies = P.id_supplies")
                ->join("access_order_supplies AS", "AO.id_order_supplies = AS.id_order_supplies AND P.id_supplies = AS.id_supplies")
                ->where("AO.access_order_package_supplies", $id_order_package_supplies)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadPackagesSuppliesIni($order) {

        $result = $this->db->select("*")
                ->from("access_order_package_supplies A")
                ->where("A.`order`", $order)
                ->get();

        return $result->result();
    }

    // -------------------------------------------------   ENTREGA DE PAQUETES SD ----------------------------------------------------------------

    function ListDeliveryPackageSD() {
        $rs = $this->db->select("ep.id_delivery_package,ep.date, p.`order`,p.`client`,ep.start_order,e.description ")
                ->from("pro_delivery_package ep")
                ->join("access_order p", "ep.`order` = p.`order`")
                ->join("sys_status e", "ep.`status` = e.id_status")
                ->order_by("ep.id_delivery_package", "desc")
                ->get();

        return $rs->result();
    }

    function ListOrderIncomplete() {
        $rs = $this->db->select("`order`,sum(quantity_packets) as qt1,  sum(delivered_quantity) as qt2")
                ->from("access_order_package")
                ->group_by("access_order_package.`order`")
                ->having("qt1 > qt2")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }

    function CreateDeliveryPackage() {
        $validation = $this->db->select("*")
                ->from("dis_request_sd_subdetail_package")
                ->where("`order`", $this->order)
                ->group_by("`order`")
                ->get();
        $result_validation = $validation->result();
        foreach ($result_validation as $key => $value) {
            if($value->weight_package != "0"){
                $res = 1;
            }else{
                $res = 0;
            }
        }
        if ($res == 0) {
            $array = array("res" => "weight", "id" => "No se ha generado el peso para los paquetes de esta orden");
        }else{
            $rs = $this->db->select("`order`,sum(quantity_packets) as qt1,  sum(delivered_quantity) as qt2")
                ->from("access_order_package")
                ->where("access_order_package.`order`", $this->order)
                ->group_by("access_order_package.`order`")
                ->having("qt1 > qt2")
                ->get();

            $reg = $rs->row();

            if ($rs->num_rows() <= 0) {
                $array = array("res" => "zero", "id" => "La order " . $this->order . " No tiene paquetes pendientes ");
    //        }else if($reg->status == 1){
    //            $array = array("res"=>"open","id"=>"La order ".$this->order." Tiene una entrega Pendiente ");
            } else {
                $data = array(
                    "modified_by" => $this->session->IdUser,
                    "`order`" => $this->order,
                    "start_order" => $this->order,
                    "date" => date("Y-m-d H:i:s"),
                );

                $rs = $this->db->insert("pro_delivery_package", $data);

                if ($rs) {
                    $array["res"] = "OK";
                    $array["id"] = $this->db->insert_id();
                } else {
                    $array = array("res" => $this->db->last_query(), "id" => "");
                }
            }
        }
        return $array;
    }

    function AddAllPackToDelivery() {

        $rs = $this->db->select("p.id_order_package, `order`, quantity_packets , delivered_quantity, (quantity_packets - delivered_quantity) as balance,d.id_delivery_package_detail,d.id_delivery_package")
                ->from("access_order_package p")
                ->join("pro_delivery_package_detail d ", "d.id_order_package = p.id_order_package and d.id_delivery_package = " . $this->delivery . " ", "left")
                ->where("p.`order`", $this->order)
                ->where("(quantity_packets - delivered_quantity) > 0")
                ->get();

        return $rs->result();
    }

    function Delivery($order) {

        $rs = $this->db->select("id_delivery_package,s.hex")
                ->from("pro_delivery_package p")
                ->join("sys_status s", "p.`status` = s.id_status")
                ->where("p.`order`", $order)
                ->order_by("id_delivery_package")
                ->get();

        return $rs->result();
    }

    function DeliveryPackage($id_delivery_package, $id_order_package) {

        $rs = $this->db->select("*")
                ->from("pro_delivery_package_detail p")
                ->where("p.id_delivery_package", $id_delivery_package)
                ->where("p.id_order_package", $id_order_package)
                ->get();

        return $rs->row();
    }

    function InfoDeliveryPackage($id_delivery) {

        $rs = $this->db->select("pro_delivery_package.*,access_order.`client`,sys_status.description")
                ->from("pro_delivery_package")
                ->join("access_order ", " pro_delivery_package.`order` = access_order.`order`")
                ->join("sys_status", "pro_delivery_package.`status` = sys_status.id_status")
                ->where("id_delivery_package", $id_delivery)
                ->get();

        return $rs->row();
    }

    function DeletePackToDelivery($id_detalle = false, $id_order_package = false) {
        
        if($id_detalle && $id_order_package){
            $this->id_delivery_package_detail = $id_detalle;
            $this->id_order_package = $id_order_package;
        }
        
        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,quantity,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                ->from("pro_delivery_package_detail d")
                ->join("access_order_package p", "d.id_order_package = p.id_order_package")
                ->where("id_delivery_package_detail", $this->id_delivery_package_detail)
                ->get();

        $rowDelivery = $reg->row();

        $new_delivered_quantity = $rowDelivery->delivered_quantity - $rowDelivery->quantity;
        $new_balance = $rowDelivery->balance + $rowDelivery->quantity;

        $this->db->where("id_delivery_package_detail", $this->id_delivery_package_detail);
        $this->db->delete("pro_delivery_package_detail");

        $data = array("delivered_quantity" => $new_delivered_quantity);
        $this->db->where("id_order_package", $this->id_order_package);
        $rs = $this->db->update("access_order_package", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $array = array("res" => $this->db->last_query());
        } else {
            $this->db->trans_commit();

            $array["res"] = "OK";
            $array["delivered_quantity"] = $new_delivered_quantity;
            $array["balance"] = $new_balance;
        }


        return $array;
    }
    
    // Created Ivan Contreras 03/04/2019
    function add_furniture(){
        $reg = $this->db->select("*")
                ->from("access_order_package o")
                //->where("o.`order`", $this->order)
                //->where("o.number_pack", $this->pack)
                //->where("o.id_forniture", $this->furniture)
                ->where("o.id_order_package", $this->id_order_package)
                ->get();

        $rowDelivery = $reg->row();
        
        $data = array("delivered_quantity" => $this->sum);
        $this->db->where("id_order_package", $this->id_order_package);
        $rs = $this->db->update("access_order_package", $data);
        
        $data = array("id_delivery_package" => $this->delivery, "id_order_package" => $rowDelivery->id_order_package, "quantity" => $this->sum);

        $rs = $this->db->insert("pro_delivery_package_detail", $data);
    }
    
    function get_data_furniture($order,$furniture){
        $rs = $this->db->select("*")
                ->from("access_order_package")
                ->where("`order`", $order)
                ->where("id_forniture", $furniture)
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }
    
    function update_data_furniture($id_order_package,$packets){
        $data = array("packets_completed" => $packets);
        $this->db->where("id_order_package", $id_order_package);
        $rs = $this->db->update("access_order_package", $data);
    }

    //***********************************************************************
    
    function AddPackToDelivery($array = false) {

        if ($array) {
            $this->id_order_package = $array['id_order_package'];
            $this->delivery = $array['delivery'];
            $this->quantity = $array['quantity'];
        }

        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                        ->from("access_order_package p")
                        ->where("id_order_package", $this->id_order_package)
                        ->get()->row();
        
        $array["res"] = "OK";
        if ($reg->balance > 0) {

            $data = array("id_delivery_package" => $this->delivery, "quantity" => $this->quantity, "id_order_package" => $this->id_order_package);
            //$rs = 1;
            $rs = $this->db->insert("pro_delivery_package_detail", $data);

            if ($rs) {

                $array["id"] = $this->db->insert_id();

                $new_delivered_quantity = $reg->delivered_quantity + $this->quantity;

                $data = array("delivered_quantity" => $new_delivered_quantity);
                $this->db->where("id_order_package", $this->id_order_package);
                $rs = $this->db->update("access_order_package", $data);


                $array["res"] = "OK";
                $array["delivered_quantity"] = $new_delivered_quantity;
                $array["balance"] = $reg->balance - $this->quantity;
            } else {
                $array = array("res" => $this->db->last_query(), "id" => "");
            }
        } else {
            $array = array("res" => "El paquete no tiene saldo disponible, por favor actualice el navegador", "id" => "");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $array;
    }

    function AddPackToDelivery2($array = false) {

        if ($array) {
            $this->id_order_package = $array['id_order_package'];
            $this->delivery = $array['delivery'];
            $this->quantity = $array['quantity'];
        }

        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                        ->from("access_order_package p")
                        ->where("id_order_package", $this->id_order_package)
                        ->get()->row();
        
        $array["res"] = "OK";
        if ($reg->balance > 0) {

            //$array["id"] = $this->db->insert_id();
            $array["id"] = "";

            $new_delivered_quantity = $reg->delivered_quantity + $this->quantity;

            $data = array("delivered_quantity" => $new_delivered_quantity);
            $this->db->where("id_order_package", $this->id_order_package);
            $rs = $this->db->update("access_order_package", $data);


            $array["res"] = "OK";
            $array["delivered_quantity"] = $new_delivered_quantity;
            $array["balance"] = $reg->balance - $this->quantity;

        } else {
            $array = array("res" => "El paquete no tiene saldo disponible, por favor actualice el navegador", "id" => "");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $array;
    }

    function UpdateDetailDelivery($array = false) {

        if ($array) {
            $this->id_delivery_package_detail = $array['id_delivery_package_detail'];
            $this->id_order_package = $array['id_order_package'];
            $this->quantity = $array['quantity'];
        }

        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,quantity,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                ->from("pro_delivery_package_detail d")
                ->join("access_order_package p", "d.id_order_package = p.id_order_package")
                ->where("id_delivery_package_detail", $this->id_delivery_package_detail)
                ->get();

        $rowDelivery = $reg->row();

        if ($this->quantity > 0) {

            $delivered_quantity = $rowDelivery->delivered_quantity - $rowDelivery->quantity;
            $new_balance = $rowDelivery->quantity_packets - $delivered_quantity;


            $this->quantity = ($this->quantity > $new_balance) ? $new_balance : $this->quantity;

            $data = array("quantity" => $this->quantity);

            $this->db->where("id_delivery_package_detail", $this->id_delivery_package_detail);
            $rs = $this->db->update("pro_delivery_package_detail", $data);

            if ($rs) {

                $new_quantity = $delivered_quantity + $this->quantity;

                $data = array("delivered_quantity" => $new_quantity);
                $this->db->where("id_order_package", $this->id_order_package);
                $rs = $this->db->update("access_order_package", $data);

                $new_balance = $rowDelivery->quantity_packets - $new_quantity;

                $array = array("res" => "OK", "quantity" => $this->quantity, "balance" => $new_balance, "delivered_quantity" => $new_quantity);
            } else {
                $array = array("res" => "Error " . $this->db->last_query());
            }
        } else {
            $array = array("res" => "OK", "quantity" => $rowDelivery->quantity, "balance" => $rowDelivery->balance, "delivered_quantity" => $rowDelivery->delivered_quantity);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $array;
    }

    function ListPackDetail($order) {
        $rs = $this->db->select("pp.id_order_package,pp.id_forniture,m.item,m.description,pp.number_pack,tp.code,pp.quantity_packets,pp.delivered_quantity,(pp.quantity_packets-pp.delivered_quantity) as saldo")
                ->from("access_order_package  pp")
                ->join("view_forniture_sd m ", " pp.id_forniture = m.id_forniture")
                ->join("access_type_package tp ", " pp.type_package = tp.id_type_package")
                ->where("pp.`order`", $order)
                ->order_by("pp.id_forniture,pp.type_package,pp.number_pack")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }
    
    function Listfurniture($order){
        $rs = $this->db->select("`pp`.`id_forniture`,`m`.description, pp.delivered_quantity")
                ->from("access_order_package  pp")
                ->join("view_forniture_sd m ", " pp.id_forniture = m.id_forniture")
                ->join("access_type_package tp ", " pp.type_package = tp.id_type_package")
                ->where("pp.`order`", $order)
                ->group_by("`m`.description")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }

    function ListeliberyDetail($id_delivery) {
        $rs = $this->db->select("d.id_delivery_package_detail,p.id_order_package,p.id_forniture,m.item,m.description,tp.code,p.number_pack ,d.quantity")
                ->from("pro_delivery_package_detail d")
                ->join("pro_delivery_package e", "e.id_delivery_package = d.id_delivery_package")
                ->join("access_order_package p", "d.id_order_package = p.id_order_package")
                ->join("view_forniture_sd m", "p.id_forniture = m.id_forniture")
                ->join("access_type_package tp", "p.type_package = tp.id_type_package")
                ->where("d.id_delivery_package", $id_delivery)
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }
    
    function get_orders(){
        $query = ("SELECT A.* FROM access_order A INNER JOIN access_order_package P ON A.`order` = P.`order` "
                . " INNER JOIN view_forniture_sd F ON P.id_forniture = F.id_forniture GROUP BY P.`order`");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }

    function DeliverPacksSD() {

        $data = array("`status`" => 13, "date_deliver" => date("Y-m-d H:i:s"), "delivered_by" => $this->session->IdUser);

        $this->db->where("id_delivery_package", $this->delivery);
        $rs = $this->db->update("pro_delivery_package", $data);

        $res = ($rs) ? "OK" : "Error " . $this->db->last_query();

        return array("res" => $res, "date" => date("Y-m-d H:i:s"));
    }

    function ApproveDeliverPack() {
        $data = array("`status`" => $this->status, "date_received" => date("Y-m-d H:i:s"), "received_by" => $this->session->IdUser, "observation" => $this->observation);

        $this->db->where("id_delivery_package", $this->delivery);
        $rs = $this->db->update("pro_delivery_package", $data);

        $res = ($rs) ? "OK" : "Error " . $this->db->last_query();

        return array("res" => $res, "date" => date("Y-m-d H:i:s"));
    }

    function LoadHeaderPack2($order,$min,$max) {
        $result = $this->db->select("*")
                ->from("dis_request_sd_subdetail_package")
                ->join("access_order", "dis_request_sd_subdetail_package.`order` = access_order.`order`")
                ->join("access_forniture", "access_forniture.id_forniture = dis_request_sd_subdetail_package.id_forniture and access_forniture.type_forniture = access_order.line")
                ->where("dis_request_sd_subdetail_package.`order`", $order)
//                ->where("id_order_package",166)
                ->order_by("dis_request_sd_subdetail_package.id_order_package,dis_request_sd_subdetail_package.number")
                ->limit($max,$min)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }

    function LoadHeaderPack($order) {
        $result = $this->db->select("*")
                ->from("access_order_package")
                ->join("access_order", "access_order_package.`order` = access_order.`order`")
                ->join("access_forniture", "access_forniture.id_forniture = access_order_package.id_forniture and access_forniture.type_forniture = access_order.line")
                ->where("access_order_package.`order`", $order)
                ->order_by("access_order_package.id_order_package")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadHeaderPackSupplies($order){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function LoadHeaderPackSuppliesPending($order){
        $query = ("SELECT * FROM access_order_package_supplies WHERE `order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }

    function CountPackSD() {
        $result = $this->db->select("ifnull(sum(s.quantity_packets),0) as total_packs")
                ->from("access_order_package s")
                ->where("s.`order`", $this->order)
                ->get();
        
        return $result->row()->total_packs;
    }

    function MaxPack($order, $forniture, $type) {
        $result = $this->db->select("max(p.number_pack) as `end`,t.description")
                ->from("access_order_package p")
                ->join("access_type_package t", "p.type_package = t.id_type_package", "left")
                ->where("`order`", $order)
                ->where("id_forniture", $forniture)
                ->where("type_package", $type)
                ->get();
        //echo $this->db->last_query();
        return $result->row();
    }
    

    function LoadDetailPack($id_order_package) {
        $result = $this->db->select("p.piece,p.code_sheet,p.code_sheet_ax,p.weight,p.caliber,p.`long`,p.longF,p.width,p.widthF,pd.quantity_pieces,p.quantity,if(ifnull(code_canto_l1,'')<>'',1,0) as l1, if(ifnull(code_canto_l2,'')<>'',1,0) as l2,if(ifnull(code_canto_a1,'')<>'',1,0) as a1, if(ifnull(code_canto_a2,'')<>'',1,0) as a2,pw.description ")
                ->from("access_order_package_detail pd ")
                ->join("access_order_pieces p ", "pd.id_order_pieces = p.id_access_order_pieces")
                ->join("pro_wood_sheet pw", "pw.code = p.code_sheet_ax", "left")
                ->where("id_order_package", $id_order_package)
                ->where("p.print", 1)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadDetailPack2($id_order_package) {
        $result = $this->db->select("p.piece,p.code_sheet,p.code_sheet_ax,p.weight,p.caliber,p.`long`,p.longF,p.width,p.widthF,pd.quantity_pieces,p.quantity,if(ifnull(code_canto_l1,'')<>'',1,0) as l1, if(ifnull(code_canto_l2,'')<>'',1,0) as l2,if(ifnull(code_canto_a1,'')<>'',1,0) as a1, if(ifnull(code_canto_a2,'')<>'',1,0) as a2,pw.description ")
                ->from("access_order_package_detail pd ")
                ->join("access_order_pieces p ", "pd.id_order_pieces = p.id_access_order_pieces")
                ->join("pro_wood_sheet pw", "pw.code = p.code_sheet_ax", "left")
                ->where("id_order_package", $id_order_package)
                ->where("p.print", 1)
                ->group_by("p.code_sheet_ax")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function insert_pro_wood($code,$ITEMNAME,$format,$id_pro_sheet_area){
        $rs = $this->db->select("*")
                ->from("pro_wood_sheet")
                ->where("code", $code)
                ->get();

        $reg = $rs->row();
        
        if(count($reg) > 0){
            return "0";
        }else{
            $data = array(
                "code"              => $code,
                "description"       => $ITEMNAME,
                "format"            => $format,
                "waste"             => "1.1",
                "id_pro_sheet_area" => $id_pro_sheet_area
            );

            $rs = $this->db->insert("pro_wood_sheet", $data);
            return $this->db->insert_id();
        }
    }
    
    function get_pro_sheet_area(){
        $rs = $this->db->select("*")
                ->from("pro_sheet_area")
                ->get();

        return $rs->result();
    }

    // -------------------------------------------------   ENTREGA DE INSUMOS ----------------------------------------------------------------

    function ListDeliverySupplies() {

        $rs = $this->db->select("ep.id_delivery_supplies,ep.date, p.`order`,p.`client`,e.description ")
                ->from("pro_delivery_supplies ep")
                ->join("access_order p", "ep.`order` = p.`order`")
                ->join("sys_status e", "ep.`status` = e.id_status")
                ->order_by("ep.id_delivery_supplies", "desc")
                ->get();

        return $rs->result();
    }

    function ListOrderIncompleteSupplies() {

        $rs = $this->db->select("`order`,sum(quantity_packets) as qt1,  sum(delivered_quantity) as qt2")
                ->from("access_order_package_supplies")
                ->group_by("`order`")
                ->having("qt1 > qt2")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }
    
    function get_pro_delivery_supplies_detail($order,$id_delivery){
        $query = ("SELECT *, SUM(AO.quantity_packaged) AS quantity_pq FROM pro_delivery_supplies P INNER JOIN pro_delivery_supplies_detail PD "
                . " ON P.id_delivery_supplies = PD.id_delivery_supplies INNER JOIN access_order_package_supplies A ON P.`order` = A.`order` "
                . " AND PD.id_order_package_supplies = A.id_order_package_supplies INNER JOIN access_order_package_supplies_detail AO "
                . " ON A.id_order_package_supplies = AO.access_order_package_supplies WHERE P.`order` = $order  "
                . "AND P.id_delivery_supplies = $id_delivery GROUP BY AO.access_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_pro_delivery_supplies_detail1($order){
        $query = ("SELECT *, SUM(AO.quantity_packaged) AS quantity_pq FROM pro_delivery_supplies P INNER JOIN pro_delivery_supplies_detail PD "
                . " ON P.id_delivery_supplies = PD.id_delivery_supplies INNER JOIN access_order_package_supplies A ON P.`order` = A.`order` "
                . " AND PD.id_order_package_supplies = A.id_order_package_supplies INNER JOIN access_order_package_supplies_detail AO "
                . " ON A.id_order_package_supplies = AO.access_order_package_supplies WHERE P.`order` = $order  "
                . " GROUP BY AO.access_order_package_supplies");
        $result = $this->db->query($query);
        return $result->result();
    }

    function CreateDeliverySupplies() {

        $rs = $this->db->select("`order`,sum(quantity_packets) as qt1,  sum(delivered_quantity) as qt2")
                ->from("access_order_package_supplies")
                ->where("access_order_package_supplies.`order`", $this->order)
                ->group_by("access_order_package_supplies.`order`")
                ->having("qt1 > qt2")
                ->get();

        $reg = $rs->row();

        if ($rs->num_rows() <= 0) {
            $array = array("res" => "zero", "id" => "La order " . $this->order . " No tiene paquetes pendientes ");
//        }else if($reg->status == 1){
//            $array = array("res"=>"open","id"=>"La order ".$this->order." Tiene una entrega Pendiente ");
        } else {
            $data = array(
                "modified_by" => $this->session->IdUser,
                "`order`" => $this->order,
                "date" => date("Y-m-d H:i:s")
            );

            $rs = $this->db->insert("pro_delivery_supplies", $data);

            if ($rs) {
                $array["res"] = "OK";
                $array["id"] = $this->db->insert_id();
            } else {
                $array = array("res" => $this->db->last_query(), "id" => "");
            }
        }
        return $array;
    }

    function InfoDeliverySupplies($id_delivery) {
        $rs = $this->db->select("pro_delivery_supplies.*,access_order.`client`,sys_status.description")
                ->from("pro_delivery_supplies")
                ->join("access_order ", " pro_delivery_supplies.`order` = access_order.`order`")
                ->join("sys_status", "pro_delivery_supplies.`status` = sys_status.id_status")
                ->where("id_delivery_supplies", $id_delivery)
                ->get();

        return $rs->row();
    }

    function ListSuppliesDispatch($order) {

        $rs = $this->db->select("pp.id_order_package_supplies,i.code as codeax,i.name,pp.quantity_supplies,pp.number_pack,tp.code,pp.quantity_packets,pp.delivered_quantity,(pp.quantity_packets-pp.delivered_quantity) as balance, pp.quantity_per_package,pp.type_package")
                ->from("access_order_package_supplies  pp")
                ->join("access_order_package_supplies_detail pd", "pp.id_order_package_supplies = pd.access_order_package_supplies")
                ->join("pro_supplies i ", " pd.id_supplies = i.id_supplies")
                ->join("access_type_package tp ", " pp.type_package = tp.id_type_package")
                ->where("pp.`order`", $order)
                ->order_by("pd.id_supplies,pp.type_package,pp.number_pack")
                ->get();

        return $rs->result();
    }

    function ListDeliberyDetailDispatch($id_delivery) {
        $rs = $this->db->select("d.id_delivery_supplies_detail,i.code as codeax,i.name,tp.code,d.quantity,d.id_order_package_supplies,p.quantity_supplies,p.type_package")
                ->from("pro_delivery_supplies_detail d")
                ->join("access_order_package_supplies p", " d.id_order_package_supplies = p.id_order_package_supplies")
                ->join("access_order_package_supplies_detail pd", "p.id_order_package_supplies = pd.access_order_package_supplies")
                ->join("pro_supplies i ", " pd.id_supplies = i.id_supplies")
                ->join("access_type_package tp", "p.type_package = tp.id_type_package")
                ->where("d.id_delivery_supplies", $id_delivery)
                ->order_by("i.code")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }

    function AddPackToDeliverySupplies($array = false) {

        if ($array) {
            $this->id_order_package_supplies = $array['id_order_package_supplies'];
            $this->delivery = $array['delivery'];
            $this->quantity = $array['quantity'];
        }

        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,delivered_quantity ,(quantity_packets - delivered_quantity) as balance,quantity_supplies")
                        ->from("access_order_package_supplies p")
                        ->where("id_order_package_supplies", $this->id_order_package_supplies)
                        ->get()->row();
        
        if ($reg->balance > 0) {

            $data = array("id_delivery_supplies" => $this->delivery, "quantity" => $this->quantity, "id_order_package_supplies" => $this->id_order_package_supplies);
            $rs = $this->db->insert("pro_delivery_supplies_detail", $data);

            if ($rs) {

                $array["id"] = $this->db->insert_id();

                $new_delivered_quantity = $reg->delivered_quantity + $this->quantity;

                $data = array("delivered_quantity" => $new_delivered_quantity);
                $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
                $rs = $this->db->update("access_order_package_supplies", $data);


                $array["res"] = "OK";
                $array["delivered_quantity"] = $new_delivered_quantity;
                $array["balance"] = $reg->balance - $this->quantity;
                $array["und"] = $reg->quantity_supplies;
            } else {
                $array = array("res" => $this->db->last_query(), "id" => "");
            }
        } else {
            $array = array("res" => "El paquete no tiene saldo disponible, por favor actualice el navegador", "id" => "");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $array;
    }

    function UpdateDetailDeliverySupplies($array = false) {

        if ($array) {
            $this->id_delivery_supplies_detail = $array['id_delivery_supplies_detail'];
            $this->id_order_package_supplies = $array['id_order_package_supplies'];
            $this->quantity = $array['quantity'];
        }

        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,quantity,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                ->from("pro_delivery_supplies_detail d")
                ->join("access_order_package_supplies p", "d.id_order_package_supplies = p.id_order_package_supplies")
                ->where("id_delivery_supplies_detail", $this->id_delivery_supplies_detail)
                ->get();

        $rowDelivery = $reg->row();

        if ($this->quantity > 0) {

            $delivered_quantity = $rowDelivery->delivered_quantity - $rowDelivery->quantity;
            $new_balance = $rowDelivery->quantity_packets - $delivered_quantity;


            $this->quantity = ($this->quantity > $new_balance) ? $new_balance : $this->quantity;

            $data = array("quantity" => $this->quantity);

            $this->db->where("id_delivery_supplies_detail", $this->id_delivery_supplies_detail);
            $rs = $this->db->update("pro_delivery_supplies_detail", $data);

            if ($rs) {

                $new_quantity = $delivered_quantity + $this->quantity;

                $data = array("delivered_quantity" => $new_quantity);
                $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
                $rs = $this->db->update("access_order_package_supplies", $data);

                $new_balance = $rowDelivery->quantity_packets - $new_quantity;

                $array = array("res" => "OK", "quantity" => $this->quantity, "balance" => $new_balance, "delivered_quantity" => $new_quantity);
            } else {
                $array = array("res" => "Error " . $this->db->last_query());
            }
        } else {
            $array = array("res" => "OK", "quantity" => $rowDelivery->quantity, "balance" => $rowDelivery->balance, "delivered_quantity" => $rowDelivery->delivered_quantity);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        return $array;
    }

    function AddAllPackSuppliesToDelivery() {

        $rs = $this->db->select("p.id_order_package_supplies, `order`, quantity_packets , delivered_quantity, (quantity_packets - delivered_quantity) as balance,d.id_delivery_supplies_detail,d.id_delivery_supplies")
                ->from("access_order_package_supplies p")
                ->join("pro_delivery_supplies_detail d ", "d.id_order_package_supplies = p.id_order_package_supplies and d.id_delivery_supplies = " . $this->delivery . " ", "left")
                ->where("p.`order`", $this->order)
                //->where("d.id_delivery_supplies", $this->delivery)
                ->where("(quantity_packets - delivered_quantity) > 0")
                ->get();
        //echo $this->db->last_query();
        return $rs->result();
    }
    
    function DeleteSuppliesDeliveryAll(){

        $reg = $this->db->select("*")
                ->from("pro_delivery_supplies P")
                ->join("pro_delivery_supplies_detail PD", "P.id_delivery_supplies = PD.id_delivery_supplies")
                ->join("access_order_package_supplies A", "P.`order` = A.`order` AND PD.id_order_package_supplies = A.id_order_package_supplies")
                ->where("P.`order`", $this->order)
                ->where("P.id_delivery_supplies", $this->delivery)
                ->get();

        $rowDelivery = $reg->result();
        
        foreach ($rowDelivery as $t):
            $this->db->where("id_delivery_supplies_detail", $t->id_delivery_supplies_detail);
            $this->db->delete("pro_delivery_supplies_detail");

            $data = array("delivered_quantity" => 0);
            $this->db->where("id_order_package_supplies", $t->id_order_package_supplies);
            $rs = $this->db->update("access_order_package_supplies", $data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $array = array("res" => $this->db->last_query());
            } else {
                $this->db->trans_commit();

                $array["res"] = "OK";
                $array["delivered_quantity"] = 0;
                $array["balance"] = 1;
            }
        endforeach;

        return $array;
    }

    function DeleteSuppliesDelivery() {
        $this->db->trans_begin();

        $reg = $this->db->select("quantity_packets,quantity,delivered_quantity ,(quantity_packets - delivered_quantity) as balance")
                ->from("pro_delivery_supplies_detail d")
                ->join("access_order_package_supplies p", "d.id_order_package_supplies = p.id_order_package_supplies")
                ->where("id_delivery_supplies_detail", $this->id_delivery_supplies_detail)
                ->get();

        $rowDelivery = $reg->row();

        $new_delivered_quantity = $rowDelivery->delivered_quantity - $rowDelivery->quantity;
        $new_balance = $rowDelivery->balance + $rowDelivery->quantity;

        $this->db->where("id_delivery_supplies_detail", $this->id_delivery_supplies_detail);
        $this->db->delete("pro_delivery_supplies_detail");

        $data = array("delivered_quantity" => $new_delivered_quantity);
        $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
        $rs = $this->db->update("access_order_package_supplies", $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $array = array("res" => $this->db->last_query());
        } else {
            $this->db->trans_commit();

            $array["res"] = "OK";
            $array["delivered_quantity"] = $new_delivered_quantity;
            $array["balance"] = $new_balance;
        }


        return $array;
    }

    function DeliverSupplies() {
        $data = array("`status`" => 13, "date_deliver" => date("Y-m-d H:i:s"), "delivered_by" => $this->session->IdUser);

        $this->db->where("id_delivery_supplies", $this->delivery);
        $rs = $this->db->update("pro_delivery_supplies", $data);

        $res = ($rs) ? "OK" : "Error " . $this->db->last_query();

        return array("res" => $res, "date" => date("Y-m-d H:i:s"));
    }

    function ApproveDeliverSupplies() {
        $data = array("`status`" => $this->status, "date_received" => date("Y-m-d H:i:s"), "received_by" => $this->session->IdUser, "observation" => $this->observation);

        $this->db->where("id_delivery_supplies", $this->delivery);
        $rs = $this->db->update("pro_delivery_supplies", $data);

        $res = ($rs) ? "OK" : "Error " . $this->db->last_query();

        return array("res" => $res, "date" => date("Y-m-d H:i:s"));
    }

    function MaxNumberPack($id_order_supplies) {
        $reg = $this->db->select("max(number_pack)+1 as number_pack")
                ->from("access_order_package_supplies")
                ->where("id_order_supplies", $id_order_supplies)
                ->group_by("id_order_supplies")
                ->get();

        return $reg->row()->number_pack;
    }

    function DeleteTagsPack($order) {
        $this->db->where("`order`", $order);
        $this->db->delete("pro_tags_package");
    }

    function CreateTagsPackSD($data) {

        $rs = $this->db->insert("pro_tags_package", $data);
        if ($rs) {
            return "OK";
        } else {
            return "Error " . $this->db->last_query();
        }
    }

    function SplitPackSupplies() {
        $reg = $this->db->select("(p.quantity_packets - p.delivered_quantity) as balance,p.*,i.name,i.code")
                ->from("access_order_package_supplies p")
                ->join("pro_supplies i", "p.id_supplies = i.id_supplies")
                ->where("p.id_order_package_supplies", $this->id_order_package_supplies)
                ->get();

        $row = $reg->row();

        if ($row->balance > 0) {
            $this->db->trans_begin();

            $info = $this->InfoOrder();

            $this->db->where("`order`", $this->order);
            $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
            $this->db->delete("pro_tags_supplies");

            $this->new_number_pack = $this->MaxNumberPack($row->id_order_supplies);

            $tags['supplies'] = $row->name;
            $tags['code'] = $row->code;
            $tags['project'] = $info->project;
            $tags['client'] = $info->client;
            $tags['order'] = $info->order;
            $tags['type'] = $info->type;
            $tags['id_supplies'] = $row->id_supplies;

            if ($row->type_package == 1) { //PRINCIPAL
                $this->new_quantity_packets = $row->quantity_packets - 1;
                $this->new_quantity_supplies = (($row->quantity_supplies / $row->quantity_packets) * $this->new_quantity_packets);
                $data = array("quantity_packets" => $this->new_quantity_packets, "quantity_supplies" => $this->new_quantity_supplies);

                $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
                $this->db->update("access_order_package_supplies", $data);

                $tags['quantity'] = ($this->new_quantity_supplies / $this->new_quantity_packets);
                $tags['id_order_package_supplies'] = $this->id_order_package_supplies;
                for ($index = 1; $index <= $this->new_quantity_packets; $index++) {
                    $this->db->insert("pro_tags_supplies", $tags);
                }

                $data = array("id_order_supplies" => $row->id_order_supplies, "id_supplies" => $row->id_supplies, "number_pack" => $this->new_number_pack,
                    "`order`" => $row->order, "type_package" => 6, "quantity_per_package" => $row->quantity_per_package, "quantity_packets" => 1,
                    "quantity_total_supplies" => $row->quantity_total_supplies, "quantity_supplies" => $this->quantity, "weight_per_package"=>($row->weight_per_package/$row->quantity_per_package) * $this->quantity);

                $this->db->insert("access_order_package_supplies", $data);

                $tags['quantity'] = $this->quantity;
                $tags['id_order_package_supplies'] = $this->db->insert_id();

                $this->db->insert("pro_tags_supplies", $tags);


                $this->new_number_pack++;

                $data = array("id_order_supplies" => $row->id_order_supplies, "id_supplies" => $row->id_supplies, "number_pack" => $this->new_number_pack,
                    "`order`" => $row->order, "type_package" => 6, "quantity_per_package" => $row->quantity_per_package, "quantity_packets" => 1,
                    "quantity_total_supplies" => $row->quantity_total_supplies, "quantity_supplies" => $row->quantity_per_package - $this->quantity, "weight_per_package"=>($row->weight_per_package/$row->quantity_per_package) * ($row->quantity_per_package - $this->quantity));

                $this->db->insert("access_order_package_supplies", $data);

                $tags['quantity'] = $row->quantity_per_package - $this->quantity;
                $tags['id_order_package_supplies'] = $this->db->insert_id();

                $this->db->insert("pro_tags_supplies", $tags);
            } else { // EXTRA
                $this->new_quantity_supplies = ($row->quantity_supplies - $this->quantity);
                $data = array("quantity_packets" => 1, "quantity_supplies" => $this->new_quantity_supplies);

                $this->db->where("id_order_package_supplies", $this->id_order_package_supplies);
                $this->db->update("access_order_package_supplies", $data);

                $tags['quantity'] = $this->new_quantity_supplies;
                $tags['id_order_package_supplies'] = $this->id_order_package_supplies;

                $this->db->insert("pro_tags_supplies", $tags);

                $data = array("id_order_supplies" => $row->id_order_supplies, "id_supplies" => $row->id_supplies, "number_pack" => $this->new_number_pack, "`order`" => $row->order, "type_package" => 6, "quantity_per_package" => $row->quantity_per_package, "quantity_packets" => 1, "quantity_total_supplies" => $row->quantity_total_supplies, "quantity_supplies" => $this->quantity,"weight_per_package"=>($row->weight_per_package/$row->quantity_per_package) * $this->quantity);
                $this->db->insert("access_order_package_supplies", $data);

                $tags['quantity'] = $this->quantity;
                $tags['id_order_package_supplies'] = $this->db->insert_id();

                $this->db->insert("pro_tags_supplies", $tags);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $array = array("res" => "Error " . $this->db->last_query());
            } else {
                $this->db->trans_commit();
                $array = array("res" => "OK");
            }
        } else {
            $array = array("res" => "El paquete no tiene saldo disponible, por favor actualice el navegador");
        }

        return $array;
    }

    function DeliverySupplies($order) {

        $rs = $this->db->select("id_delivery_supplies,s.hex")
                ->from("pro_delivery_supplies p")
                ->join("sys_status s", "p.`status` = s.id_status")
                ->where("p.`order`", $order)
                ->order_by("id_delivery_supplies")
                ->get();

        return $rs->result();
    }

    function DeliveryPackageSupplies($id_delivery_supplies, $id_order_package_supplies) {

        $rs = $this->db->select("p.*,d.quantity_supplies")
                ->from("pro_delivery_supplies_detail p")
                ->join("access_order_package_supplies d ", " p.id_order_package_supplies = d.id_order_package_supplies")
                ->where("p.id_delivery_supplies", $id_delivery_supplies)
                ->where("p.id_order_package_supplies", $id_order_package_supplies)
                ->get();

        return $rs->row();
    }
    
    function loadPiecesAdd(){
        $result = $this->db->select("*")
                ->from("access_order_package_addpiece")
                ->where("id_order_package",$this->input->post("id_order_package"))
                ->where("order",$this->input->post("order"))
                ->get();
        return $result->result();
    }
    
    function DeletePieceToPack(){
        
        $result = $this->db->select("*")
                ->from("access_order_package_addpiece")
                ->where("id_order_package_addpiece",$this->id_order_package_addpiece)
                ->get();
        
            $row = $result->row();

            if($result){
                
                $res = $this->db->select("*")
                    ->from("access_order_package")
                    ->where("id_order_package",$this->id_order_package)
                    ->get();
            
                $reg = $res->row();
                $newWeight = $reg->weight - $row->weight;
                $data = array("weight"=> $newWeight);

                $this->db->where("id_order_package",$this->id_order_package);
                $this->db->update("access_order_package",$data);
                
                $this->db->where("id_order_package_addpiece",$this->id_order_package_addpiece);
                $result = $this->db->delete("access_order_package_addpiece");
                
                return array("res"=>"OK","peso"=>$newWeight);
            }else{
                return array("res"=>"Error :".$this->db->last_query());
            }

    }
    
    function AddPieceToPack(){
        $data['long'] = $this->largo;
        $data['width'] = $this->ancho;
        $data['caliber'] = $this->calibre;
        $data['weight'] = $this->peso;
        $data['order'] = $this->order;
        $data['id_order_package'] = $this->id_order_package;
        
        $result = $this->db->insert("access_order_package_addpiece",$data);
        
        if($result){
            
            $res = $this->db->select("*")
                    ->from("access_order_package")
                    ->where("id_order_package",$this->id_order_package)
                    ->get();
            
            $reg = $res->row();
            
            $data = array("weight"=> $reg->weight + $this->peso);
            
            $this->db->where("id_order_package",$this->id_order_package);
            $this->db->update("access_order_package",$data);
            
            return "OK";
        }else{
            return "Error :".$this->db->last_query();
        }
    }
    
    function ListRequestReverse(){
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail d")
                ->join("dis_request_sd s","d.id_request_sd = s.id_request_sd")
                ->where("d.id_order_package",$this->id_order_package)
                ->where("s.id_status <> 14 ")
                ->group_by("d.id_request_sd")
                ->get(); 
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function ReversePackDispatch(){
        $res = $this->db->select("dis_request_sd_detail.*,dis_request_sd.weight as weight_total,dis_request_sd.quantity_packages as quantity_total")
                ->from("dis_request_sd_detail")
                ->join("dis_request_sd","dis_request_sd_detail.id_request_sd = dis_request_sd.id_request_sd")
                ->where("dis_request_sd_detail.id_request_sd",$this->request)
                ->where("id_order_package",$this->id_order_package)
                ->get();
        $row = $res->row();
        
        $this->db->where("id_request_detail",$row->id_request_detail);
        if(($row->quantity_packets - $this->quantity) > 0){
            $new_quantity = $row->quantity_packets - $this->quantity;
            $new_weight = ($row->weight/$row->quantity_packets) * $new_quantity;
            
            $data = array("quantity_packets"=>$new_quantity,
                "weight"=>$new_weight);
            $this->db->update("dis_request_sd_detail",$data);
            
            
//            dis_request_sd_subdetail_package
            
            if($row->weight_total > 0){
                $new_weight_total = $row->weight_total - ($row->weight - $new_weight);
                $new_quantity_total = $row->quantity_total - $this->quantity;
                $this->db->where("id_request_sd",$this->request);
                $this->db->update("dis_request_sd",array("weight"=> $new_weight_total,"quantity_packages"=>$new_quantity_total));
            }
            
            //descontar los despachados de la cabecera del paquete
            $res_pack = $this->db->select("*")
                    ->from("access_order_package")
                    ->where("id_order_package",$this->id_order_package)
                    ->where("order",$this->order)
                    ->get();
            
            $reg = $res_pack->row();
            $data = array(
                "quantity_dispatch"=> $reg->quantity_dispatch - $this->quantity
            );
            $this->db->where("id_order_package",$this->id_order_package);
            $this->db->update("access_order_package",$data);
            
        }else{
            $this->db->delete("dis_request_sd_detail");
            
//            $data = array(
//                "quantity_dispatch"=> $reg->quantity_dispatch - $this->quantity
//            );
//            $this->db->where("id_order_package",$this->id_order_package);
//            $this->db->update("access_order_package",$data);
        }
    }
    
    function ReversePackDelivery(){
        //descontar los despachados de la cabecera del paquete
        $res_pack = $this->db->select("*")
                ->from("access_order_package")
                ->where("id_order_package",$this->id_order_package)
                ->where("order",$this->order)
                ->get();
        $reg = $res_pack->row();
        
        $res = $this->db->select("d.*")
                ->from("pro_delivery_package_detail d")
                ->join("pro_delivery_package e","d.id_delivery_package = e.id_delivery_package")
                ->where("d.id_order_package",$this->id_order_package)
                ->where("d.id_delivery_package",$this->delivery)
                ->get();
        $row = $res->row();
        $new_quantity = 0;
        $this->db->where("id_delivery_package_detail",$row->id_delivery_package_detail);
        if(($row->quantity - $this->quantity) > 0){
            $new_quantity = $row->quantity - $this->quantity;
            $data = array("quantity" =>$new_quantity);
            $this->db->update("pro_delivery_package_detail",$data);
            
            //descontar los entregados de la cabecera del paquete
            $res_pack = $this->db->select("*")
                    ->from("access_order_package")
                    ->where("id_order_package",$this->id_order_package)
                    ->where("order",$this->order)
                    ->get();
            
            $reg2 = $res_pack->row();
            //echo $reg2->delivered_quantity ." - ". $this->quantity;
            $data = array(
                "delivered_quantity"=> ($reg2->delivered_quantity - $this->quantity)
            );
            $this->db->where("id_order_package",$this->id_order_package);
            $this->db->update("access_order_package",$data);

            $array["delivered_quantity"] = ($reg2->delivered_quantity - $this->quantity);
            
        }else{
            $this->db->delete("pro_delivery_package_detail");
            
            $data = array(
                "delivered_quantity" => 0
            );
            $this->db->where("id_order_package",$this->id_order_package);
            $this->db->update("access_order_package",$data);

            $array["delivered_quantity"] = 0;
        }

        $array["res"] = "OK";
        return $array;
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_Dispatch extends VS_Model {

    public function __construct() {
        parent::__construct();
        
        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListRequest(){
        $result = $this->db->select("p.*,s.description")
                ->from("dis_request_sd p")
                ->join("sys_status s", "p.`id_status` = s.id_status")
                ->order_by("date","desc")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function CreateRequestSD(){
        $data = array("`id_status`"=>1);
        $rs = $this->db->insert("dis_request_sd",$data);
        
        if ($rs) {
            $array["id"] = $this->db->insert_id();
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }
        return $array;
        
    }
    
    function OrderAvailableSD(){
        $result = $this->db->select("*")
                ->from("view_order_available_for_dispatchSD")
                ->group_by("`order`")
                ->order_by("`order`")
                ->get();
        return $result->result();
    }
     
    function ListPackSDAvailable($order){
        $result = $this->db->select("*")
                ->from("view_package_available_for_dispatchsd")
                ->where("`order`",$order)
                ->order_by("balance_dispatch","desc")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function ListPackSDAvailable2($order){
        $result = $this->db->select("*")
                ->from("view_package_available_for_dispatchsd")
                ->where("`order`",$order)
                ->group_by("id_forniture")
                ->order_by("balance_dispatch","desc")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function ListSuppliesAvailable($order){
        $result = $this->db->select("*")
                ->from("access_order_package_supplies a")
                ->join("pro_delivery_supplies_detail p", "a.id_order_package_supplies = p.id_order_package_supplies")
                ->where("a.`order`",$order)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function ListPackSDAvailablexfurniture($id_forniture,$order){
        $result = $this->db->select("*")
                ->from("view_package_available_for_dispatchsd")
                ->where("`order`",$order)
                ->where("id_forniture",$id_forniture)
                ->get();
        return $result->result();
    }
     
    function ListPackSDAvailableSupplies($order){
        $result = $this->db->select("*")
                ->from("view_package_available_supplies_for_dispatch")
                ->where("`order`",$order)
                ->order_by("balance_dispatch","desc")
                ->get();
        return $result->result();
    }
    
    function get_weight($id_order_package_supplies,$order){
        $query = ("SELECT A.id_order_package_supplies,P.name,P.code,AO.quantity_packaged,P.weight_per_supplies FROM "
                . " access_order_package_supplies_detail AO INNER JOIN access_order_package_supplies A "
                . "ON AO.access_order_package_supplies = A.id_order_package_supplies INNER JOIN pro_supplies P "
                . "ON AO.id_supplies = P.id_supplies WHERE A.id_order_package_supplies = $id_order_package_supplies AND A.`order` = $order");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function ListPackSDAvailableSupplies2($order){
        $result = $this->db->select("*")
                ->from("pro_delivery_supplies p")
                ->join("pro_delivery_supplies_detail pd", "p.id_delivery_supplies = pd.id_delivery_supplies")
                ->join("access_order_package_supplies a", "pd.id_order_package_supplies = a.id_order_package_supplies")
                
                ->where("p.`order`",$order)
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_data_header(){
        $result = $this->db->select("*")
                ->from("access_order_package_supplies p")
                ->where("p.`order`",$this->order)
                ->where("p.id_order_package_supplies", $this->id_order_package_supplies)
                ->get();
        return $result->result();
    }
    
    function get_data_detail(){
        $query = ("SELECT *,AO.quantity_packaged AS qp FROM access_order_package_supplies_detail AO INNER JOIN access_order_supplies AOS ON "
                . " AO.id_order_supplies = AOS.id_order_supplies INNER JOIN pro_supplies P ON AO.id_supplies = P.id_supplies "
                . " WHERE AOS.`order` = $this->order AND AO.access_order_package_supplies = $this->id_order_package_supplies");
        $result = $this->db->query($query);
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function InfoRequestSD($id){
        $result = $this->db->select("s.id_request_sd,s.driver,s.license_plate,s.dispatch_date,ifnull(sum(d.quantity_packets),0) as num_packets,ifnull(sum(if(d.`type` = 'Modulado',d.weight,0)),0)as total_weight_modulate,ifnull(sum(if(d.`type` = 'Insumos',d.weight,0)),0)as total_weight_supplies,s.id_status as status, "
                . " s.id_weight_vehicle, v.max_weight")
                ->from("dis_request_sd s")
                ->join("dis_request_sd_detail d","s.id_request_sd = d.id_request_sd","left")
                ->join("dis_weight_vehicle v","v.id_weight_vehicle = s.id_weight_vehicle","left")
                ->where("s.id_request_sd",$id)
                ->get();
        //echo $this->db->last_query();
        return $result->row();

    }
    
    function get_vehicle($id_vehicle){
        $result = $this->db->select("*")
                ->from("dis_weight_vehicle")
                ->where("id_weight_vehicle",$id_vehicle)
                ->get();
        
        return $result->row();
    }
    
    function LoadContainerSD($id,$type){
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail d")
                ->where("d.id_request_sd",$id)
                ->where("d.type",$type)
                ->order_by("id_request_detail","asc")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadContainerSD2($id,$type){
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail d")
                ->join("access_order_package_supplies a", "d.id_order_package = a.id_order_package_supplies")
                ->where("d.id_request_sd",$id)
                ->where("d.type",$type)
                ->order_by("id_request_detail","asc")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function get_data_supplies($id_request_sd,$order){
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_order_package",$id_request_sd)
                ->where("`order`",$order)
                ->get();

        $reg = $result->row();
    }
    
    function DeleteSuppliesRequestSD($id_request_detail){
        $this->db->trans_begin();
        
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_request_detail",$id_request_detail)
                ->get();
        
        $row = $result->row();
        
        $data = array(
            "quantity_dispatch" => "0"
        );
        
        $this->db->where("id_order_package_supplies", $row->id_order_package);
        $rs = $this->db->update("access_order_package_supplies", $data);
        
        
        //******************************************************************//
        $this->db->where("id_request_detail",$id_request_detail);
        $this->db->delete("dis_request_sd_detail");
        
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return "ERROR ".$this->db->last_query();
        }else{
            $this->db->trans_commit();
            return "OK";
        }
    }
            
    function DeletePackRequestSD($id_request_detail = false){
        
        if($id_request_detail){
            $this->id_request_detail = $id_request_detail;
        }
        
        $this->db->trans_begin();
        
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_request_detail",$this->id_request_detail)
                ->get();
        
        $row = $result->row();
        
        $this->db->where("id_request_detail",$this->id_request_detail);
        $this->db->delete("dis_request_sd_detail");
        
        if($this->type == "Modulado"){
            $result = $this->db->select("quantity_dispatch")
                    ->from("access_order_package")
                    ->where("id_order_package",$row->id_order_package)
                    ->get();

            $reg = $result->row();

            
            $this->db->where("id_order_package",$row->id_order_package);
            $this->db->update("access_order_package",array("quantity_dispatch"=>($reg->quantity_dispatch - $row->quantity_packets)));
        }else{
            $result = $this->db->select("quantity_dispatch")
                    ->from("access_order_package_supplies")
                    ->where("id_order_package_supplies",$row->id_order_package)
                    ->get();

            $reg = $result->row();


            $this->db->where("id_order_package_supplies",$row->id_order_package);
            $this->db->update("access_order_package_supplies",array("quantity_dispatch"=>($reg->quantity_dispatch - $row->quantity_packets)));
        }
        
            
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return "ERROR ".$this->db->last_query();
        }else{
            $this->db->trans_commit();
            return "OK";
        }
    }
    
    function AddPackSDToRequestGroup(){
        $this->db->trans_begin();
        
        $count = 0;
        foreach ($this->arrPack as $id_order_package){
            
            $result = $this->db->select("*")
                    ->from("dis_request_sd_detail")
                    ->where("id_order_package",$id_order_package)
                    ->where("id_request_sd",$this->request)
                    ->where("type",$this->type)
                    ->get();
            //echo $this->db->last_query();
            if($this->type == 'Modulado'){
                $rslt = $this->db->select("p.quantity_packets,p.quantity_dispatch,(p.delivered_quantity - p.quantity_dispatch) as balance_dispatch,(p.weight/p.quantity_packets) as weight,p.`order`,concat(m.item,' ',m.description) as description,concat(p.number_pack,' ',t.code) as pack,m.id_forniture ")
                        ->from("access_order_package p")
                        ->join("view_forniture_sd m","p.id_forniture = m.id_forniture")
                        ->join("access_type_package t","p.type_package = t.id_type_package","left")
                        ->where("p.id_order_package",$id_order_package)
                        ->get();
                //echo $this->db->last_query();
            }else{ // INSUMOS
                $rslt = $this->db->select("AO.*,P.*, A.`order`, A.quantity_dispatch, CONCAT( A.number_pack ,' ', ATP.code) AS pack_i, SUM(AO.quantity_packaged) AS qp, SUM(AO.quantity_packaged * P.weight_per_supplies) as total")
                        ->from("access_order_package_supplies_detail AO")
                        ->join("access_order_package_supplies A","AO.access_order_package_supplies = A.id_order_package_supplies")
                        ->join("access_type_package ATP","A.type_package = ATP.id_type_package")
                        ->join("access_order_supplies AOS","AO.id_order_supplies = AOS.id_order_supplies")
                        ->join("pro_supplies P","AO.id_supplies = P.id_supplies")
                        ->where("AOS.`order`",$this->order[$count])
                        ->where("AO.access_order_package_supplies",$id_order_package)
                        ->group_by("AO.access_order_package_supplies")
                        ->get();
                //echo $this->db->last_query();
                $count++;
            }
            $row = $rslt->row();
            
            if($result->num_rows() > 0){
            
                $reg = $result->row();
                $this->quantity = $reg->quantity_packets + $row->balance_dispatch;
                //echo $reg->quantity_packets ." - ". $row->balance_dispatch;
                if($this->quantity > 0){
                    $data = array(
                        "quantity_packets" =>$this->quantity,
                        "weight" =>$row->weight*$this->quantity,
                    );
                    $this->db->where("id_request_detail",$reg->id_request_detail);
                    $rs = $this->db->update("dis_request_sd_detail",$data);
                    $this->old_quantity = $reg->quantity_packets;
                }
            }else{
                
                
                //$this->quantity = $row->quantity_dispatch;
                //echo $this->quantity;
                if($this->quantity > 0){
                    if($this->type == 'Modulado'){
                        $this->quantity = $row->balance_dispatch;
                        $data = array(
                            "id_request_sd"=>$this->request,
                            "id_order_package"=>$id_order_package,
                            "quantity_packets"=>$this->quantity,
                            "weight"=>$row->weight * $this->quantity,
                            "name"=>$row->description,
                            "pack"=>$row->pack,
                            "type"=>$this->type,    
                            "id_forniture"=>$row->id_forniture,
                            "`order`"=>$row->order
                        );
                    }else{//Insumo
                        $data = array(
                            "id_request_sd" => $this->request,
                            "`order`"       => $row->order,
                            "pack"          => $row->pack_i,
                            "id_order_package"  => $row->access_order_package_supplies,
                            "quantity_packets"  => "1" ,
                            "weight"        => $row->total,
                            "type"          => "Insumos"
                        );
                    }
                    $rs = $this->db->insert("dis_request_sd_detail",$data);
                    $this->old_quantity = 0;
                }
            }
            
            if($this->quantity > 0){
                if($rs){
                    if($this->type == 'Modulado'){
                        $this->db->where("id_order_package",$id_order_package);
                        $this->db->update("access_order_package",array("quantity_dispatch"=>($row->quantity_dispatch - $this->old_quantity)+$this->quantity));
                    }else{
                        $this->db->where("id_order_package_supplies",$id_order_package);
                        $this->db->update("access_order_package_supplies",array("quantity_dispatch"=>($row->quantity_dispatch - $this->old_quantity)+$this->quantity));
                    }
                }
            }
            
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("res" => "ERROR ".$this->db->last_query());
        } else {
            $this->db->trans_commit();
            return array("res" => "OK");
        }
    }
    
    function AddPackSDToRequest(){
        
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_order_package",$this->id_order_package)
                ->where("id_request_sd",$this->request)
                ->where("type",$this->type)
                ->get();
        
        
        
        if($result->num_rows() > 0){
            
            $reg = $result->row();
            $this->quantity = $reg->quantity_packets + $this->quantity;
            if($this->quantity > 0){
                $data = array(
                    "quantity_packets"  => $this->quantity,
                    "weight"            => $this->weight*$this->quantity,
                );
                $this->db->where("id_request_detail",$reg->id_request_detail);
                $rs = $this->db->update("dis_request_sd_detail",$data);
                $this->old_quantity = $reg->quantity_packets;
                $array["new"] = "FALSE";
                $array['id'] = $reg->id_request_detail;
            }
        }else{
            if($this->quantity > 0){
                $data = array(
                    "id_request_sd"=>$this->request,
                    "id_order_package"=>$this->id_order_package,
                    "quantity_packets"=>$this->quantity,
                    "weight"=>$this->weight*$this->quantity,
                    "name"=>$this->name,
                    "pack"=>$this->pack,
                    "type"=>$this->type,
                    "id_forniture"=>$this->id_forniture,
                    "`order`"=>$this->order
                );
                $rs = $this->db->insert("dis_request_sd_detail",$data);
                $array['id'] = $this->db->insert_id();
                $this->old_quantity = 0;
                $array["new"] = "TRUE";
            }
        }
        
        
        
        if($this->quantity > 0){
            if ($rs) {
                $array["res"] = "OK";
                if($this->type == 'Modulado'){
                    $result = $this->db->select("quantity_dispatch")
                            ->from("access_order_package")
                            ->where("id_order_package",$this->id_order_package)
                            ->get();

                    $row = $result->row();

                    $this->db->where("id_order_package",$this->id_order_package);
                    $this->db->update("access_order_package",array("quantity_dispatch"=>($row->quantity_dispatch - $this->old_quantity)+$this->quantity));
                }else{
                    $result = $this->db->select("quantity_dispatch")
                            ->from("access_order_package_supplies")
                            ->where("id_order_package_supplies",$this->id_order_package)
                            ->get();

                    $row = $result->row();

                    $this->db->where("id_order_package_supplies",$this->id_order_package);
                    $this->db->update("access_order_package_supplies",array("quantity_dispatch"=>($row->quantity_dispatch - $this->old_quantity)+$this->quantity));
                }
            } else {
                $array = array("res" => $this->db->last_query());
            }
        }else{
            $array["res"] = "OK";
        }
        return $array;
    }
    
    function AddItemGroup(){
        
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_order_package",$this->id_order_package)
                ->where("id_request_sd",$this->request)
                ->where("type",$this->type)
                ->get();
        
        if($result->num_rows() > 0){
            $reg = $result->row();
            //$this->quantity = $reg->quantity_packets + $this->quantity
            $this->quantity = $this->quantity;
            if($this->quantity > 0){
                $data = array(
                    "quantity_packets"=>$this->quantity,
                    "weight"=>$this->weight,
                );
                $this->db->where("id_request_detail",$reg->id_request_detail);
                $rs = $this->db->update("dis_request_sd_detail",$data);
                $this->old_quantity = $reg->quantity_packets;
                $array["new"] = "FALSE";
                $array['id'] = $reg->id_request_detail;
            }
        }else{
            if($this->quantity > 0){
                $data = array(
                    "id_request_sd"=>$this->request,
                    "id_order_package"=>$this->id_order_package,
                    "quantity_packets"=>$this->quantity,
                    "weight"=>$this->weight,
                    "name"=>$this->name,
                    "pack"=>$this->pack,
                    "type"=>$this->type,
                    "id_forniture"=>$this->id_forniture,
                    "`order`"=>$this->order
                );
                $rs = $this->db->insert("dis_request_sd_detail",$data);
                $array['id'] = $this->db->insert_id();
                $this->old_quantity = 0;
                $array["new"] = "TRUE";
            }
        }
        
        if($this->quantity > 0){
            if ($rs) {
                $array["res"] = "OK";
                if($this->type == 'Modulado'){
                    $result = $this->db->select("quantity_dispatch")
                            ->from("access_order_package")
                            ->where("id_order_package",$this->id_order_package)
                            ->get();

                    $row = $result->row();

                    $this->db->where("id_order_package",$this->id_order_package);
                    $this->db->update("access_order_package",array("quantity_dispatch"=>($row->quantity_dispatch - $this->old_quantity)+$this->quantity));
                }
            } else {
                $array = array("res" => $this->db->last_query());
            }
        }else{
            $array["res"] = "OK";
        }
        return $array;
    }
    
    function AddItemGroupSupplies(){
        $this->db->trans_begin();
        
        $data = array(
            'quantity_dispatch' => '1'
        );
        $this->db->where("id_order_package_supplies",$this->id_package_supplies);
        $rs = $this->db->update("access_order_package_supplies",$data);
            
        $query = ("SELECT * FROM dis_request_sd_detail D WHERE D.id_request_sd = $this->request AND D.`order` = $this->order "
                . " AND D.id_order_package = $this->id_package_supplies");
        $result = $this->db->query($query);
        if(count($result->result()) > 0 ){
            foreach ($result->result() as $val){
                $data = array(
                    '`order`' => $this->order,
                    'id_request_sd' => $this->request
                );
                $this->db->where("id_request_detail",$val->id_request_detail);
                $rs = $this->db->update("dis_request_sd_detail",$data);
                
                $array['id'] = $val->id_request_detail;
                $this->old_quantity = 0;
                $array["new"] = "UPDATE";
            }
        }else{
            $rslt = $this->db->select("AO.*,P.*,CONCAT( A.number_pack,' ', ATP.code) AS pack_i, SUM(AO.quantity_packaged) AS qp, SUM(AO.quantity_packaged * P.weight_per_supplies) as total")
            ->from("access_order_package_supplies_detail AO")
            ->join("access_order_package_supplies A","AO.access_order_package_supplies = A.id_order_package_supplies")
            ->join("access_type_package ATP","A.type_package = ATP.id_type_package")
            ->join("access_order_supplies AOS","AO.id_order_supplies = AOS.id_order_supplies")
            ->join("pro_supplies P","AO.id_supplies = P.id_supplies")
            ->where("AOS.`order`",$this->order)
            ->where("AO.access_order_package_supplies",$this->id_package_supplies)
            ->group_by("AO.access_order_package_supplies")
            ->get();
            $row = $rslt->row();

            $data = array(
                "id_request_sd" => $this->request,
                "`order`"       => $this->order,
                "pack"          => $row->pack_i,
                "id_order_package"  => $row->access_order_package_supplies,
                "quantity_packets"  => "1" ,
                "weight"        => $row->total,
                "type"          => "Insumos"
            );

            $rs = $this->db->insert("dis_request_sd_detail",$data);
            $array['id'] = $this->db->insert_id();
            $this->old_quantity = 0;
            $array["new"] = "TRUE";
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return $array['error'] = "ERROR ".$this->db->last_query();
        }else{
            $this->db->trans_commit();
            $array["res"] = "OK";
            return $array;
        }
    }
    
    function get_data_remission(){
        $query = ("SELECT * FROM dis_remission R WHERE R.id_request_sd = $this->id_request GROUP BY R.`order`");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_supplies_p($order){
        $query = ("SELECT * FROM access_order_package_supplies A INNER JOIN pro_delivery_supplies_detail P ON "
                . " A.id_order_package_supplies = P.id_order_package_supplies WHERE A.`order` = $order AND A.quantity_dispatch = 0");
        $result = $this->db->query($query);
        return $result->result();
    }
            
    function UpdateRequestSD(){
        $data = array(
            $this->field=>$this->value,
            "modified_by" => $this->session->IdUser,
            "last_update" => date("Y-m-d H:i:s")
        );
        $this->db->where("id_request_sd",$this->request);
        $rs = $this->db->update("dis_request_sd",$data);
        
        if ($rs) {
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }
        return $array;
    }
    
    function UpdateRequestSD2(){
        $data = array(
            "driver"=>$this->driver,
            "license_plate" => $this->value,
            "id_weight_vehicle" => $this->vehicle,
            "modified_by" => $this->session->IdUser,
            "last_update" => date("Y-m-d H:i:s")
        );
        $this->db->where("id_request_sd",$this->request);
        $rs = $this->db->update("dis_request_sd",$data);
        
        if ($rs) {
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }
        return $array;
    }
    
    function CreateRequisition(){
        
        $this->db->trans_begin();
        
        $result = $this->db->select("`order`")
                ->from("dis_request_sd_detail")
                ->where("id_request_sd",$this->request)
                ->group_by("`order`")
                ->get();
        
        $this->date = date("Y-m-d H:i:s");
        $reqs = array();
        
        foreach ($result->result() as $o) {
            $info = $this->M_Dispatch->InfoOrderAll($o->order);
            
            $data = array(
                "id_request_sd"=>$this->request,
                "type_order"=>$info->type,
                "`order`"=>$info->order,
                "client"=>$info->client,
                "project"=>$info->project,
                "modified_by"=>$this->session->IdUser,
                "last_update"=>$this->date
            );

            $this->db->insert("dis_remission",$data);
            $this->remission = $this->db->insert_id();
            
            $data2 = array(
                "id_request_sd"=>$this->request,
            );
            $this->db->insert("ws_message_movil",$data2);
            $ws = $this->db->insert_id();
            
            $reqs[] = $this->remission;
            
            $array = array("id_weight_vehicle"=>$this->id_vehicle);
            $this->db->where("id_request_sd",$this->request);
            $this->db->update("dis_request_sd",$array);
            
            $array = array("id_remission"=>$this->remission);
            $this->db->where("id_request_sd",$this->request);
            $this->db->where("`order`",$o->order);
            $this->db->update("dis_request_sd_detail",$array);
        
            $result2 = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("`order`",$o->order)
                ->where("id_request_sd",$this->request)
                ->get();
            foreach ($result2->result() as $o2){
                $result3 = $this->db->select("*")
                ->from("dis_request_sd_subdetail_package")
                ->where("`order`",$o2->order)
                ->where("id_forniture",$o2->id_forniture)
                ->get();
                $cont = 0;
                foreach ($result3->result() as $o3){
                    if($cont < $o2->quantity_packets && $o3->id_request_detail == '0'){
                        $array = array(
                            "id_request_detail" => $o2->id_request_detail,
                            "id_request_sd"     => $o2->id_request_sd
                        );
                        $this->db->where("id_request_detail_package",$o3->id_request_detail_package);
                        //$this->db->where("`order`",$o->order);
                        $this->db->update("dis_request_sd_subdetail_package",$array);
                        $cont++;
                    }
                }
                
                $result4 = $this->db->select("*")
                ->from("dis_request_sd_subdetail_package")
                ->where("`order`",$o2->order)
                ->where("id_order_package_supplies",$o2->id_order_package)
                ->get();
                $cont2 = 0; // contador de paquetes
                foreach ($result4->result() as $o4){
                    if($cont2 < $o2->quantity_packets && $o4->id_request_detail == '0'){
                        $array = array(
                            "id_request_detail" => $o2->id_request_detail,
                            "id_request_sd"     => $o2->id_request_sd
                        );
                        $this->db->where("id_request_detail_package",$o4->id_request_detail_package);
                        //$this->db->where("`order`",$o->order);
                        $this->db->update("dis_request_sd_subdetail_package",$array);
                        //echo $o3->id_request_detail_package."-";
                        $cont2++;
                    }
                }
            }
        }
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array("res" => "ERROR ".$this->db->last_query());
        } else {
            $this->db->trans_commit();
            return array("res" => "OK","reqs" => $reqs);
        }
        
    }
    
    function UpdateStateRequest($status, $requisition = false){
        $this->date = date("Y-m-d H:i:s");
        $data = array(
            "modified_by" => $this->session->IdUser, 
            "last_update" => $this->date,
            "id_status"=>$status
        );
        
        if($requisition){
            $data['weight'] = $this->weight;
            $data['weightI'] = $this->weightI;
            $data['weight_supplies'] = $this->weight_supplies;
        }
        
        $this->db->where("id_request_sd",$this->request);
        
        $rs = $this->db->update("dis_request_sd",$data);
        
        if ($rs) {
            $array["res"] = "OK";
        } else {
            $array = array("res" => $this->db->last_query());
        }
        return $array;
    }
    
    function LoadHeaderRequisition($remission){
        $result = $this->db->select("*")
                ->from("dis_remission")
                ->where("id_remission",$remission)
                ->get();
        return $result->row();
    }
    
    function LoadDataRequisition($id_request_sd){
        $result = $this->db->select("*")
                ->from("dis_request_sd")
                ->where("id_request_sd",$id_request_sd)
                ->get();
        return $result->row();
    }
    
    function LoadDetailRequisition($id_request_sd,$type){
        $result = $this->db->select("*")
                ->from("dis_request_sd_detail")
                ->where("id_request_sd",$id_request_sd)
                ->where("type",$type)
                ->order_by("name")
                ->order_by("pack")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadDetailRequisition2($id_order_package_supplies,$order){
        $query = ("SELECT A.access_order_package_supplies,P.name,P.code,A.quantity_packaged,P.weight_per_supplies FROM access_order_package_supplies_detail A INNER JOIN "
                . " access_order_package_supplies AO ON A.access_order_package_supplies = AO.id_order_package_supplies INNER JOIN "
                . " pro_supplies P ON A.id_supplies = P.id_supplies WHERE A.access_order_package_supplies = $id_order_package_supplies "
                . " AND AO.`order` = $order ");
        $result = $this->db->query($query);
        return $result->result();
    }
    
    function get_vehicles(){
        $result = $this->db->select("*")
                ->from("dis_weight_vehicle")
                ->get();

        return $result->result();
    }
}

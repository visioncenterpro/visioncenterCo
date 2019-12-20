<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Acknow extends VS_Model {

    public function __construct() {
        parent::__construct();

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListHeaderAck($order) {
        $result = $this->db->select("*")
                ->from("sys_import_salestable")
                ->where("order", $order)
                ->get();

        return $result->row();
    }

    function ListAcknowledgement($id = false) {

        if ($id):
            $this->db->where("id_import_salestable", $id);
        endif;

        $result = $this->db->select("*")
                ->from("sys_import_salestable")
                ->order_by("id_import_salestable", "desc")
                ->get();

        if ($id):
            return $result->row_array();
        else:
            return $result->result();
        endif;
    }

    function ListAdIronWorksAll($idorder) {

        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("id_import_salestable", $idorder)
                ->where("external", 1)
                ->get();
        //$result->db->last_query();
        return $result->result();
    }

    function ListAdIronWorksItem($Id, $idorder) {

        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("highart", $Id)
                ->where("id_import_salestable", $idorder)
                ->where("type", "AM")
                ->get();

        return $result->result();
    }

    function ListDetailsAck($idorder) {

        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("id_import_salestable", $idorder)
                ->get();

        return $result->result();
    }

    function ChargedColumns() {
        $result = $this->db->select("`COLUMN_NAME`")
                ->from("`INFORMATION_SCHEMA`.`COLUMNS`")
                ->where("`TABLE_NAME`='sys_import_salestable' and `COLUMN_NAME` not in ('id_import_salestable','id_import_salestable','modified_by','last_update','status','id_proadmin')")
                ->where("TABLE_SCHEMA = 'vision'")
                ->get();
        return $result->result();
    }

    function ChargedColumnsDetails() {
        $result = $this->db->select("`COLUMN_NAME`")
                ->from("`INFORMATION_SCHEMA`.`COLUMNS`")
                ->where("`TABLE_NAME`='sys_import_salesline' and `COLUMN_NAME` not in ('id_import_salestable','id_import_salesline','proadmin','status')")
                ->where("TABLE_SCHEMA = 'vision'")
                ->get();
        return $result->result();
    }

    function LoadDetailsAcknowledgement($id, $highart) {
//        if($highart != ""){
//            where("highart", $highart);
//        }
        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("id_import_salestable", $id)
                //->where("highart", $highart)
                ->where("type", "AO")
                ->where("sys_import_salesline.status <> 3")
                ->get();
        //echo $this->db->last_query()
        return $result->result();
    }

    function LoadDetailsAckvsidImos($id, $external) {
        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("highart", $id)
                ->where("external", $external)
                ->get();
        return $result->result();
    }

    function LoadDetailInfo($id) {
        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("id_import_salesline", $id)
                ->get();
        return $result->row_array();
    }

    function ValidateItemOrder($id_import, $name) {

        $itemsResult = $this->ListOrderItemImosAll($name);
        $items = array();
        foreach ($itemsResult as $t) {
            $nameItem = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : $t->CPID)));
            $nameItem = ($nameItem == $t->CPID . $t->DEPTH) ? "PN" : $nameItem;

            if ($nameItem == 'PN') {
                //$this->db->where("concat(code,code1,code_esp)", $nameItem);
            } else {
                $this->db->where("CONCAT(code,code1,if(code_esp = '','','_'),code_esp) = '$nameItem' ");
                $data = array("highart" => $t->ID, "type" => "M");
                $this->db->where("id_import_salestable", $id_import);
                $this->db->where("highart is null");
                $this->db->update("sys_import_salesline", $data);
            }
        }

        $result = $this->db->select("*")
                ->from("sys_import_salesline")
                ->where("id_import_salestable", $id_import)
                ->where("highart is null ")
                ->get();

        $status = ($result->num_rows() > 0) ? 10 : 9; //incompleto/completo

        $this->db->where("id_import_salestable", $id_import);
        $this->db->update("sys_import_salestable", array("status" => $status));


        return array("status" => $status, "data" => $itemsResult);
    }

    function ValidateItemImport() {

        foreach ($this->array_body as $a) {
            $data = array("type" => $a[1]);
            if ($a[1] == "AO") { //ES UN ADICIONAL PARA LA ORDER
                $data['highart'] = NULL;
            } else { //ES UN ADICIONAL PARA UN MUEBLE DE LA ORDER
                if ($a[2] != "") {
                    $data['highart'] = $a[2];
                } else {
                    $data['highart'] = NULL;
                }
            }

            $this->db->where("id_import_salesline", $a[0]);

            $result = $this->db->update("sys_import_salesline", $data);
        }

        $res = ($result) ? "OK" : "Error" . $this->db->last_query();

        return $res;
    }

}

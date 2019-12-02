<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Order extends VS_Model {

    public function __construct() {
        parent::__construct();

        $this->ix = $this->load->database("ImosIX", TRUE);

        foreach ($_POST as $clave => $valor):
            $this->$clave = $valor;
        endforeach;
    }

    function ListOrderImosAll($order = false) {
        
        if($order){
            $this->ix->where("NAME", $order);
        }
        
        $result = $this->ix->select("*")
                ->from("PROADMIN")
                ->where("TYPE", 173)
                ->order_by("DATECREATE desc")
                ->get();
        
        if($order){
            return $result->row();
        }else{
            return $result->result();
        }
        
    }

    function ListOrderItemImos($id, $name) {
        $result = $this->ix->select("*")
                ->from("IDBINFO")
                ->where("TYPE", 2)
                ->where("ORDERID", $name)
                ->where("id", $id)
                ->order_by("GRPPOS")
                ->get();
        return $result->result();
    }

    function ListfittingsItemImosAll($name) {
        $result = $this->ix->select("*")
                ->from("IDBINFO")
                ->where("TYPE", 2)
                ->where("ORDERID", $name)
                ->order_by("GRPPOS")
                ->get();
        return $result->result();
    }
    
    function UpdateComments(){
        //print_r($this->comment);
        $comment = $this->comment;
        $find = array("'",'"');
        $remplace = array('-','-');
        $val = str_replace($find, $remplace, $comment);
        
        $data = array("TEXT1"=> $val);
        
        $this->ix->where("ORDERID",$this->order);
        $this->ix->where("ID",$this->idbgpl);
        
        $result = $this->ix->update("IDBGPL",$data);
        //echo $this->ix->last_query();
        return ($result)?"OK":"Error : ".$this->ix->last_query();
        
    }

    function ListPiecesALL($id, $order) {
        $result = $this->ix->select("ProductivoImosIX.dbo.Cants(ORDERID,ID) as cantos,IDGRPS,ID,ORDERIDGPRS,ORDERID,TYPGRPS,JAYM_IMOSTYP.IDPIEZA,JAYM_IMOSTYP.NAMEIMOS,JAYM_IMOSTYP.NAME,FWIDTH,FLENG,AREA,WEIGHT,BARCODE,RENDERPMAT,MATNAME,FTHK,JaymIdbGRPS_GPLI_INFO.TEXT1,JaymIdbGRPS_GPLI_INFO.TEXT2")
                ->from("JaymIdbGRPS_GPLI_INFO")
                ->join("JAYM_IMOSTYP", "JaymIdbGRPS_GPLI_INFO.TYP = JAYM_IMOSTYP.IDTYPIMOS","LEFT")
                ->where("ORDERIDGPRS", $order)
                ->where("HIGHARTIDGPRS", $id)
                ->order_by("NCNO")
                ->get();
        //echo $this->ix->last_query();
        return $result->result();
    }

    function ListPiecesAddALL($id,$order) {
        $result = $this->db->select("imos_pieces_line.*,imos_type_pieces.name")
                ->from("imos_pieces_line")
                ->join("imos_type_pieces","imos_type_pieces.id_type_pieces = imos_pieces_line.type","left")
                ->where("id_salesline",$id)
                ->where("order",$order)
                ->where("status <> 3")
                ->get();
        
        return $result->result();
    }

    function ListTypePiece() {
        $result = $this->db->select("*")
                ->from("imos_type_pieces")
                ->get();
        
        return $result->result();
    }

    function ListConsSheet($order) {
        $result = $this->ix->select("JaymIdbGRPS_GPLI_INFO.HIGHARTIDGPRS,JaymIdbGRPS_GPLI_INFO.ID,MATNAME,(FLENG/1000)*(FWIDTH/1000) AS MT2,AREA,WEIGHT,MATID,FLENG,FWIDTH")
                ->from("JaymIdbGRPS_GPLI_INFO")
                ->where("JaymIdbGRPS_GPLI_INFO.ORDERIDGPRS", $order)
                ->where("MATNAME <> ''")
                ->order_by("MATNAME")
                ->get();
        //echo $this->db->last_query();
        return $result->result();
    }
    
    function LoadSheet($sheet){
        $result = $this->db->select("*")
                ->from("pro_wood_sheet")
                ->join("pro_sheet_area","pro_wood_sheet.format = pro_sheet_area.format","left")
                ->where("code",trim($sheet))
                ->get();
        //echo $this->db->last_query();
        return ($result->num_rows()>0)?$result->row():0;
    }

    function UpdateIDSheet(){
    	$query = $this->db->select("*")
    			->from("pro_wood_sheet")
    			->get();
    	foreach ($query->result() as $key => $value) {
    		if($value->id_pro_sheet_area == ""){
    			$result = $this->db->select("*")
    			->from("pro_sheet_area")
    			->where("format",$value->format)
    			->get();
    			echo count($result->result());
    			if (count($result->result()) > 0) {
					$data_r = $result->row();
					print_r($data_r);
					$data = array(
						'id_pro_sheet_area' => $data_r->id_pro_shet_area
					);
    				$this->db->where("id_wood_sheet",$value->id_wood_sheet);
        			$miwa = $this->db->update("pro_wood_sheet",$data);
    			}
    		}
    	}
    }

    function UpdateIDSheet_waste(){
    	$query = $this->db->select("*")
    			->from("pro_wood_sheet")
    			->get();
    	foreach ($query->result() as $key => $value) {
    		if($value->id_caliber == "" && $value->waste != ""){
    			$result = $this->db->select("*")
    			->from("pro_sheet_caliber")
    			->where("caliber",$value->waste)
    			->get();
    			echo count($result->result());
    			if (count($result->result()) > 0) {
					$data_r = $result->row();
					print_r($data_r);
					$data = array(
						'id_caliber' => $data_r->id_caliber
					);
    				$this->db->where("id_wood_sheet",$value->id_wood_sheet);
        			$miwa = $this->db->update("pro_wood_sheet",$data);
    			}
    		}
    	}
    }
    
    function ListConsCanto($order) {
        $result = $this->ix->select("PRFNAME,PRFID,RENDERP,(CONTLEN/1000) AS CONTLEN")
                ->from("IDBPRF")
                ->where("ORDERID", $order)
                ->where("RENDERP <> 'NO_RENDER'")
                ->where("PRFNAME <> 'No Edge Application'")
                ->get();
        //echo $this->ix->last_query();
        return $result->result();
    }

    function ListConsCantoxName($order,$PRFNAME) {
        $result = $this->ix->select("PRFNAME,PRFID,RENDERP,(CONTLEN/1000) AS CONTLEN")
                ->from("IDBPRF")
                ->where("ORDERID", $order)
                ->where("PRFNAME", $PRFNAME)
                ->where("RENDERP <> 'NO_RENDER'")
                ->where("PRFNAME <> 'No Edge Application'")
                ->get();
        //echo $this->ix->last_query();
        return $result->result();
    }

    function ListEdgesAll() {
        $result = $this->ix->select("*")
                ->from("JaymIdbEdge")
                ->where("ORDERIDGPRS", $order)
                ->where("HIGHARTIDGPRS", $id)
                ->order_by("NCNO")
                ->get();

        return $result->result();
    }

    function ChargedBarcode() {

        $result = $this->ix->query("select ISNULL(CAMNCNOINFO.CNC_NAME,IDBGPL.BARCODE) AS CNC_NAME from IDBGPL
        LEFT JOIN CAMPARTINFO ON IDBGPL.ORDERID = CAMPARTINFO.ORDERID AND CAMPARTINFO.NCNO = IDBGPL.NCNO COLLATE Latin1_General_CS_AS  AND IDBGPL.ID = ".$this->input->post("idbgpl")."
        LEFT JOIN CAMNCNOINFO ON CAMNCNOINFO.PARTINFOID = CAMPARTINFO.PARTINFOID where IDBGPL.ORDERID = '" . $this->input->post("order") . "' AND IDBGPL.ID = ".$this->input->post("idbgpl"));
        //echo $this->ix->last_query();
        return $result->result_array();
    }

    function ListIronWorksALL($id, $order) {
        $result = $this->ix->query("SELECT ROUND(CASE dbo.IDBPURCH.LENGTH WHEN 0 THEN COUNT(dbo.IDBPURCH.CONID) ELSE (dbo.IDBPURCH.LENGTH * 1.2 * COUNT(dbo.IDBPURCH.CONID))/1000 END ,3)AS PURCHCNT,
        dbo.PROADMIN.ID AS PROADMIN_ID, dbo.IDBPURCH.ARTICLE_ID AS CONID, 
        dbo.IDBPURCH.ORDER_ID AS PURCHORDER, dbo.IDBPURCH.TEXT_SHORT, dbo.IDBPURCH.SUPPLIER, dbo.IDBPURCH.LENGTH, dbo.IDBPURCH.ARTICLE_ID, 
        dbo.IDBPURCH.COST_1, dbo.IDBGRPS.ORDERID, dbo.IDBGRPS.HIGHARTID, dbo.PROADMIN.NAME,
        (dbo.IDBPURCH.COST_1*COUNT(dbo.IDBPURCH.CONID)) AS TOTAL
        FROM         dbo.IDBPURCH INNER JOIN
        dbo.IDBGRPS ON dbo.IDBPURCH.ID = dbo.IDBGRPS.ID AND dbo.IDBPURCH.ORDERID = dbo.IDBGRPS.ORDERID AND 
        dbo.IDBPURCH.DIFFTYPE = dbo.IDBGRPS.DIFFTYPE INNER JOIN
        dbo.PROADMIN ON dbo.IDBGRPS.ORDERID = dbo.PROADMIN.NAME
        WHERE     (dbo.IDBGRPS.HIGHARTID IN (SELECT DISTINCT HIGHARTID FROM          dbo.IDBGRPS AS IDBGRPS_1 WHERE      (ID = dbo.IDBPURCH.ID))) AND (dbo.IDBPURCH.BOM_FLAG = 1) 
        AND IDBGRPS.HIGHARTID='$id' 
        GROUP BY    dbo.PROADMIN.ID,dbo.PROADMIN.NAME, dbo.IDBGRPS.ORDERID,dbo.IDBPURCH.ORDER_ID, dbo.IDBPURCH.ARTICLE_ID, dbo.IDBGRPS.HIGHARTID, 
          dbo.IDBPURCH.SUPPLIER, dbo.IDBPURCH.COST_1,dbo.IDBPURCH.TEXT_SHORT, dbo.IDBPURCH.LENGTH
        HAVING      (dbo.PROADMIN.NAME = '$order')
        UNION ALL
        SELECT     ROUND(CASE dbo.IDBSPP.LENGTH WHEN 0 THEN COUNT(dbo.IDBSPP.CONID) ELSE (dbo.IDBSPP.LENGTH * 1.2 * COUNT(dbo.IDBSPP.CONID))/1000 END ,3)AS PURCHCNT,
        dbo.PROADMIN.ID AS PROADMIN_ID, dbo.IDBSPP.ARTICLE_ID AS CONID, dbo.IDBSPP.ORDER_ID AS PURCHORDER, 
        dbo.IDBSPP.TEXT_SHORT AS PURCHTEXT, dbo.IDBSPP.SUPPLIER AS PURCHSUPPLIER, dbo.IDBSPP.LENGTH, dbo.IDBSPP.ARTICLE_ID AS PURCHARTICLEID, 
        dbo.IDBSPP.COST_1 AS PURCHCOST, dbo.IDBGRPS.ORDERID AS PURCH_ORDERID, dbo.IDBGRPS.HIGHARTID AS PURCH_HIGHARTID, dbo.PROADMIN.NAME,
        (dbo.IDBSPP.COST_1*COUNT(dbo.IDBSPP.CONID)) AS TOTAL
        FROM         dbo.IDBGRPS INNER JOIN
        dbo.IDBSPP ON dbo.IDBGRPS.ID = dbo.IDBSPP.ID AND dbo.IDBGRPS.ORDERID = dbo.IDBSPP.ORDERID AND 
        dbo.IDBGRPS.DIFFTYPE = dbo.IDBSPP.DIFFTYPE INNER JOIN
        dbo.PROADMIN ON dbo.IDBGRPS.ORDERID = dbo.PROADMIN.NAME
        WHERE     (dbo.IDBGRPS.HIGHARTID IN (SELECT DISTINCT HIGHARTID FROM          dbo.IDBGRPS AS IDBGRPS_1 WHERE      (ID = dbo.IDBSPP.ID))) AND (dbo.IDBSPP.BOM_FLAG = 1) 
        AND IDBGRPS.HIGHARTID='$id'
        GROUP BY    dbo.PROADMIN.ID,dbo.PROADMIN.NAME, dbo.IDBGRPS.ORDERID,dbo.IDBSPP.ORDER_ID,dbo.IDBSPP.ARTICLE_ID,dbo.IDBGRPS.HIGHARTID,
        dbo.IDBSPP.SUPPLIER,dbo.IDBSPP.COST_1,dbo.IDBSPP.TEXT_SHORT, dbo.IDBSPP.LENGTH
        HAVING      (dbo.PROADMIN.NAME =  '$order')");
        //echo $this->ix->last_query();
        return $result->result();
    }
    
    function Get_Sum_Ironwork($order){
        $result = $this->ix->query(" SELECT CONID,sum(PURCHCNT) AS PURCHCNT FROM Jaym_View_ListBom_1 WHERE ORDERID = '$order' "
                . " GROUP BY PROADMIN_ID,CONID "
                . " UNION ALL "
                . " SELECT CONID,sum(PURCHCNT) AS PURCHCNT FROM Jaym_View_ListBom_2 WHERE ORDERID = '$order' GROUP BY PROADMIN_ID,CONID");
        //echo $this->ax->last_query();
        return $result->result();
    }
    function AddNewItem(){

        if($this->type == "P"){
            $data = array("height"=>$this->height,"width"=>$this->width,"depth"=>$this->depth,"typepiece"=>$this->typepiece);
        }
        $data['order'] = $this->order;
        $data['type'] = $this->type;
        $data['code'] = $this->code;
        if($this->type == "E"){
            $data['qty'] = "1";
            $data['weight'] = (empty($this->weight_c))?0:$this->weight_c;
            $data['volume'] = $this->qty;
        }else{
            $data['qty'] = $this->qty;
            $data['weight'] = (empty($this->weight))?0:$this->weight;
        }
        $data['modified_by'] = $this->session->IdUser;
        $data['last_update'] = date("Y-m-d H:i:s");
        
        $result = $this->db->insert("imos_salesline",$data);
        
        return ($result)?$this->db->insert_id():"Error : ".$this->db->last_query();
        
    }
    
    function ListOrderItem($name){
        $result = $this->db->select("*")
                ->from("imos_salesline")
                ->where("order",$name)
                ->where("status",1)
                ->get();
        return $result->result();
    }
    
    function ListOrderPiecesAditionals($name){
        
        $result = $this->db->select("imos_salesline.*,concat(name, ' (',name_imos,')') AS description")
        ->from("imos_salesline")
        ->join("imos_type_pieces","id_type_pieces = typepiece","left")
        ->where("`order`",$name)
        ->where("type",'P')
        ->where("`status` <> 3")
        ->get();
        //echo $this->db->last_query();
        return array("result"=>$result->result(), "count"=>$result->num_rows());
    }
    
    function ListOrderItemImosAditionals($name){
        $name2 = str_replace('_', '-', $name);
        
        $result = $this->db->query("SELECT code,'' AS description,qty,'ADICIONAL' as aditional
        FROM imos_salesline  
        WHERE `order` = '$name' and type = 'H' and `status` <> 3
        UNION
        SELECT code,description,qty,'ACKNOWLEDGMENT' as aditional
        FROM sys_import_salesline l
        JOIN sys_import_salestable s on l.id_import_salestable = s.id_import_salestable
        WHERE s.`order` = '$name2' and l.`type` = 'AO' and l.`status` <> 3 ");
        //echo $this->db->last_query();
        return array("result"=>$result->result(), "count"=>$result->num_rows());
    }
    
    function LoadDetailsItem($id_salesline){
        $result = $this->db->select("*")
                ->from("imos_salesline")
                ->where("id_salesline",$id_salesline)
                ->where("status",1)
                ->get();
        return $result->row();
    }
    
    function UpdateDetailsItem($id_salesline){
        $data = array("code"=>$this->code,
            "weight"=>(empty($this->weight))?0:$this->weight,
            "qty"=>$this->qty,
            "typepiece"=>$this->typepiece,
            "modified_by"=>$this->session->IdUser,
            "last_update"=>date("Y-m-d H:i:s")
        );
        
        if($this->type == "P"){
            $data['height'] = $this->height;
            $data['width'] = $this->width;
            $data['depth'] = $this->depth;
        }
        
        $this->db->where("id_salesline",$id_salesline);
        
        $result = $this->db->update("imos_salesline",$data);
        return ($result)?"OK":"Error : ".$this->db->last_query();
    }
    
    function DeleteDetailsItem(){
        
        $this->db->where("id_salesline",$this->id_salesline);
        
        $result = $this->db->update("imos_salesline",array("status"=>3,"modified_by"=>$this->session->IdUser,"last_update"=>date("Y-m-d H:i:s")));
        
        return ($result)?"OK":"Error : ".$this->db->last_query();
    }
    
    function DeleteDetailsPiece(){
        if($this->table=="sys_import_salesline"){
            $this->db->where("id_import_salesline",$this->id);
            $result = $this->db->update("sys_import_salesline",array("status"=>3,"modified_by"=>$this->session->IdUser,"last_update"=>date("Y-m-d H:i:s")));
        }else{
            $this->db->where("id_aditional_line",$this->id);
            $result = $this->db->update("imos_aditional_line",array("status"=>3,"modified_by"=>$this->session->IdUser,"last_update"=>date("Y-m-d H:i:s")));
        }
        return ($result)?"OK":"Error : ".$this->db->last_query();
    }
    
    function AddPiece(){
        $_POST['modified_by'] = $this->session->IdUser;
        $_POST['last_update'] = date("Y-m-d H:i:s");
        $result = $this->db->insert("imos_pieces_line",$_POST);
        return ($result)?$this->db->insert_id():"Error : ".$this->db->last_query();
    }
    
    function AddAditional(){
        $_POST['modified_by'] = $this->session->IdUser;
        $_POST['last_update'] = date("Y-m-d H:i:s");
        
        $descAX = $this->ChargedCodeAXiron($this->code);
        $_POST['description'] = strtoupper((!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : "(Crear En AX)");
        $_POST['unity']  = (empty($descAX)) ? '' : $descAX->UNITID;
        
        $result = $this->db->insert("imos_aditional_line",$_POST);
        
        $_POST['id'] = 0;
        if($result){
            $_POST['id'] = $this->db->insert_id();
        }
        
        
        return ($result)?$_POST:"Error : ".$this->db->last_query();
    }
    
    function UpdatePiece(){
        $_POST['modified_by'] = $this->session->IdUser;
        $_POST['last_update'] = date("Y-m-d H:i:s");
        
        $this->db->where("id_pieces_line",$this->input->post("id_piece"));
        
        unset($_POST['id_piece']);
        
        $result = $this->db->update("imos_pieces_line",$_POST);
        return ($result)?"OK":"Error : ".$this->db->last_query();
    }
    
    function UpdateAditional(){
        
        $key = ($this->table == "sys_import_salesline")?"id_import_salesline":"id_aditional_line";
        
        $result = $this->db->select("*")
                ->from($this->table)
                ->where($key, $this->id_table)
                ->get();
        
        $_POST['modified_by'] = $this->session->IdUser;
        $_POST['last_update'] = date("Y-m-d H:i:s");
        
        $this->db->where($key,$this->id_table);
        
        unset($_POST['id_table']);
        unset($_POST['table']);
        unset($_POST['id_import_salestable']);
        if($this->table == "sys_import_salesline"){
            unset($_POST['order']);
        }
        
        
        $descAX = $this->ChargedCodeAXiron($this->code);
        $_POST['description'] = strtoupper((!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : "(Crear En AX)");
        $_POST['unity']  = (empty($descAX)) ? '' : $descAX->UNITID;
        
        
        $result = $this->db->update($this->table,$_POST);
        
        $_POST["res"] = $this->db->last_query();
        if($result){
            $_POST["res"] = "OK";
        }
        
        return $_POST;
    }
    
    function DetailsPiece() {
        
        $result = $this->db->select("imos_pieces_line.*,imos_type_pieces.name")
                ->from("imos_pieces_line")
                ->join("imos_type_pieces","imos_type_pieces.id_type_pieces = imos_pieces_line.type","left")
                ->where("id_pieces_line", $this->id)
                ->get();
        
        return $result->row_array();
    }
    
    function DetailsAditional() {
        
        $key = ($this->table == "sys_import_salesline")?"id_import_salesline":"id_aditional_line";
        
        $result = $this->db->select("*")
                ->from($this->table)
                ->where($key, $this->id)
                ->get();
        
        return $result->row_array();
    }
    
    function LoadImosAditional($id,$order){
        $result = $this->db->select("*")
                ->from("imos_aditional_line")
                ->where("highart", $id)
                ->where("order", $order)
                ->where("status <> 3")
                ->get();
        
        return $result->result();
    }
    
    function GenerateTagsOrder(){
        
        $this->db->empty_table("imos_tags_order");
        
        $orders = implode ("','" ,$this->arrayGeneral);

        $result = $this->ix->select("ProductivoImosIX.dbo.Cants(ORDERID,ID) as CANTOS,IDGRPS,ID,ORDERIDGPRS,
        NAME,CWIDTH,CLENG,FWIDTH,FLENG,AREA,WEIGHT,BARCODE,RENDERPMAT,MATNAME,NCNO,
        CPID_IDBINFO as FORNITURE")
                ->from("JaymIdbGRPS_GPLI_INFO")
                ->join("JAYM_IMOSTYP","JaymIdbGRPS_GPLI_INFO.TYP = JAYM_IMOSTYP.IDTYPIMOS","left")
                ->where("ORDERIDGPRS in ('$orders')")
                ->get();
           
        return $result->result();
    }
    
    function SaveTags($data){
        $result = $this->db->insert("imos_tags_order",$data);
        return ($result)?"OK":"Error ".$this->db->last_query();
    }
    

    function LoadSheetOrders(){
        $orders = implode ("','" ,$this->arrayGeneral);

        $result = $this->ix->select("MATNAME")
                ->from("JaymIdbGRPS_GPLI_INFO")
                ->join("JAYM_IMOSTYP","JaymIdbGRPS_GPLI_INFO.TYP = JAYM_IMOSTYP.IDTYPIMOS","left")
                ->where("ORDERIDGPRS in ('$orders')")
                ->where("MATNAME <> ''")
                ->group_by("MATNAME")
                ->get();
        return array("res"=>($result)?"OK":"Error ".$this->ix->last_query(),"dato"=>$result->result());
    }
    
    function LoadCants($order,$id){
        
        $result = $this->ix->select("IDBPRF.PRFNO, PRFNAME,PRFTHKFIN")
                ->from("IDBPRF")
                ->where("ORDERID",$order)
                ->where("ID",$id)
                ->where("PRFNAME NOT LIKE 'No Edge Application'")
                ->group_by("IDBPRF.PRFNO,PRFNAME,PRFTHKFIN")
                ->get();

        return $result->result_array();
    }
}

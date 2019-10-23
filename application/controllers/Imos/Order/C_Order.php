<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Order extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $modelos = array("Imos/Order/M_Order", "Imos/Acknow/M_Acknow");
        $this->load->model($modelos);
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $fields['orders'] = $this->M_Order->ListOrderImosAll();
        $data['table'] = $this->load->view("Imos/Order/V_Table_Order", $fields, true);
        $this->load->view('Imos/Order/V_List_Order', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function ListItems($name, $id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $fields['btns'] = $this->load->view("Imos/Order/V_Order_Buttons", null, true);

        $fields['items'] = $this->M_Order->ListOrderItemImosAll($name);
        $fields['itemsAdd'] = $this->M_Order->ListOrderItem($name);
        $data['name'] = $name;
        $fields['id'] = $id;
        
        $fields['ack'] = $this->ListAck($name);
        
        $data['typePiece'] = $this->M_Order->ListTypePiece();
        
        $data['table'] = $this->load->view("Imos/Order/V_Table_Order_Item", $fields, true);
        $this->load->view('Imos/Order/V_List_Order_Item', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function ShowDetailsItem($id, $order, $cpid, $idProadmin, $nameid, $med, $pos) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['name'] = $order;
        $data['id'] = $id;
        $data['cpid'] = $cpid;
        $data['nameid'] = $nameid;
        $data['idProadmin'] = $idProadmin;
        $data['med'] = $med;
        $data['pos'] = $pos;

        $data['typePiece'] = $this->M_Order->ListTypePiece();
        $data['PiecesRecord'] = $this->M_Order->ListPiecesALL($id, $order);
        $data['PiecesAdd'] = $this->M_Order->ListPiecesAddALL($id,$order);
        $data['cantos'] = $this->M_Order->ChargedCantoAXAll();
        $data['sheet'] = $this->M_Order->ChargedSheedAXAll();
        $IronRecord = $this->M_Order->ListIronWorksALL($id, $order);

        $idack = $this->M_Acknow->ListHeaderAck(str_replace("_", "-", $order));
        $data['AdIronRecord'] = array();

        $data['AdAditional'] = $this->M_Order->LoadImosAditional($id,$order);
        if (is_object($idack)) {
            $data['AdIronRecord'] = $this->M_Acknow->LoadDetailsAcknowledgement($idack->id_import_salestable, $id);
        }

        $data['iron'] = "";

        foreach ($IronRecord as $t) :
            $descAX = $this->M_Order->ChargedCodeAXiron($t->ARTICLE_ID);
            $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $t->TEXT_SHORT . " (Crear En AX)";
            $und = (empty($descAX)) ? '' : $descAX->UNITID;
            $class = (!empty($descAX->ITEMNAME)) ? "" : "bg-danger";
            $data['iron'] .= "<tr class='$class' >";
            $data['iron'] .= "<td >" . $t->ARTICLE_ID . "</td>";
            $data['iron'] .= "<td >" . strtoupper($desc) . "</td>";
            $data['iron'] .= "<td style='text-align:center'>" . $t->PURCHCNT . "</td>";
            $data['iron'] .= "<td style='text-align:center'>" . $und . "</td>";
            $data['iron'] .= "<td ></td>";
            $data['iron'] .= "</tr>";
        endforeach;

        $data['btns'] = $this->load->view("Imos/Order/V_Order_Buttons", null, true);

        $data['pieces'] = $this->load->view('Imos/Order/V_Table_Tab_Pieces', $data, true);
        $data['iron'] = $this->load->view('Imos/Order/V_Table_Tab_Ironworks', $data, true);
        

        $this->load->view('Imos/Order/V_Order_Item_Details', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, BARCODE39_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function UpdateComments(){
        $result = $this->M_Order->UpdateComments();
        echo json_encode(array("res"=>$result));
    }
    
    function pb(){
        $simp = "'";
        $dob = '*';
        echo str_replace($simp, $dob, " 'prueba' ");
    }
    function ChargedBarcode() {
        $result = $this->M_Order->ChargedBarcode();
        echo json_encode($result);
    }
    
    function ListAck($name){
        
        $row = $this->M_Acknow->ListHeaderAck(str_replace("_", "-", $name));
        $html = "";
        if ($row) {
            $itemImos = $this->M_Acknow->ValidateItemOrder($row->id_import_salestable, $name);
            $itemImport = $this->M_Acknow->ListDetailsAck($row->id_import_salestable);
            $html = $this->load->view("Imos/Order/V_Order_Table_Association", array("itemImport" => $itemImport, "itemImos" => $itemImos['data']), true);
        }
        return $html;
    }

    function ValidateAck() {
        $row = $this->M_Acknow->ListHeaderAck(str_replace("_", "-", $this->input->post('name')));
        $html = "";
        if ($row) {
            if ($row->status == 9) {
                $res = "COMPLETE";
            } else {
                $itemImos = $this->M_Acknow->ValidateItemOrder($row->id_import_salestable, $this->input->post('name'));
                if ($itemImos['status'] == 9) {
                    $res = "COMPLETE";
                } else {
                    $itemImport = $this->M_Acknow->ListDetailsAck($row->id_import_salestable);
                    $html = $this->load->view("Imos/Order/V_Order_Table_Association", array("itemImport" => $itemImport, "itemImos" => $itemImos['data']), true);
                    $res = "VALIDATE";
                }
            }
        } else {
            $res = "EMPTY";
        }

        echo json_encode(array("res" => $res, "table" => $html));
    }

    function ValidateItemImport() {
        $result = $this->M_Acknow->ValidateItemImport();
        echo json_encode(array("res" => $result));
    }
    
    function AddNewItem(){
        $result = $this->M_Order->AddNewItem();
        echo json_encode(array("res" => ($result > 0)?"OK":$result, "id"=>$result ));
    }
    
    function AddPiece(){
        $result = $this->M_Order->AddPiece();
        echo json_encode(array("res" => ($result > 0)?"OK":$result, "id"=>$result ));
    }
    
    function AddAditional(){
        $result = $this->M_Order->AddAditional();
        echo json_encode(array("res" => ($result['id'] > 0)?"OK":$result, "id"=>$result['id'], "description"=>$result['description'], "und"=>$result['unity'] )); 
    }
    
    function DetailsPiece(){
        $result = $this->M_Order->DetailsPiece();
        echo json_encode(array("res" => $result )); 
    }
    
    function DetailsAditional(){
        $result = $this->M_Order->DetailsAditional();
        echo json_encode(array("res" => $result )); 
    }

    function UpdatePiece(){
        $result = $this->M_Order->UpdatePiece();
        echo json_encode(array("res" => $result));
    }

    function UpdateAditional(){
        $result = $this->M_Order->UpdateAditional();
        echo json_encode(array("res" => $result['res'], "description"=>$result['description'], "und"=>$result['unity'] )); 
    }
    
    function LoadDetailsItem(){
        $result = $this->M_Order->LoadDetailsItem($this->input->post("id_salesline"));
        echo json_encode(array("res" => $result )); 
    }
    
    function UpdateDetailsItem(){
        $result = $this->M_Order->UpdateDetailsItem($this->input->post("id_salesline"));
        echo json_encode(array("res" => $result )); 
    }
    
    function DeleteDetailsItem(){
        $result = $this->M_Order->DeleteDetailsItem();
        echo json_encode(array("res" => $result )); 
    }
    
    function DeleteDetailsPiece(){
        $result = $this->M_Order->DeleteDetailsPiece();
        echo json_encode(array("res" => $result)); 
    }
    
    function GenerateTagsOrder(){
        $array = $this->M_Order->GenerateTagsOrder();
        
        $arrayCantos = array();
        foreach ($array as $t) {
            $ref = (empty($t->IDPIEZA))?"":$t->IDPIEZA."-".$t->FLENG."X".$t->FWIDTH;
            
//            $arrayCantos = explode(";",$t->CANTOS);
//            $arrayGeneral = array(0=>0,1=>0,2=>0,3=>0);
//            $suma_cantos = 0;
//            if(!empty($t->CANTOS)){
//                foreach ($arrayCantos as $a):
//                    $arrayCanto = explode("-",$a);
//                    $arrayGeneral[$arrayCanto[0]-1] = 1;//$arrayCanto[1];
//                    $suma_cantos += 1;
//                endforeach;
//            }
            
            /***********************   CANTOS   ***********************/
            $cants = $this->M_Order->LoadCants($t->ORDERIDGPRS,$t->ID);
            $a1 = 0;
            $l1 = 0;
            $a2 = 0;
            $l2 = 0;
            
            
            foreach ($cants as $c) {
                if(count($c)>0){
                    $arrayCantos[$c['PRFNAME']] = $c['PRFTHKFIN'];
                    if($c['PRFNO'] == 1){
                        $a1 = 1;
                    }elseif($c['PRFNO'] == 2){
                        $l1 = 1;
                    }elseif($c['PRFNO'] == 3){
                        $a2 = 1;
                    }elseif($c['PRFNO'] == 4){
                        $l2 = 1;
                    }
                }
            }
            /***********************  END CANTOS   ***********************/
            
            /***********************   BARCODE   ***********************/
            $_POST['idbgpl'] = $t->ID;
            $_POST['order'] = $t->ORDERIDGPRS;
          
            $codes = $this->M_Order->ChargedBarcode();
            
            if (!empty($codes[0]['CNC_NAME'])) {
                $code1 = str_replace("_", "-", $codes[0]['CNC_NAME']);
            } else {
                $code1 = NULL;
            }
            if (!empty($codes[1]['CNC_NAME'])) {
                $code2 = str_replace("_", "-", $codes[1]['CNC_NAME']);
            } else {
                $code2 = NULL;
            }
            /***********************  END BARCODE   ***********************/
            
            $lengF  = $t->FLENG;
            $widthF = $t->FWIDTH;
            $sheet = $t->MATNAME;
            $qt = 6; //CANTIDAD DE PIEZAS
            $data = array(
                "reference"=>$ref,
                "forniture"=>$t->FORNITURE,
                "order"=>$t->ORDERIDGPRS,
                "cwidth"=>$t->CWIDTH,
                "cleng"=>$t->CLENG,
                "fwidth"=>$widthF,
                "fleng"=>$lengF,
                "sheet"=>$sheet,
                "a1"=>$a1,
                "l1"=>$l1,
                "a2"=>$a2,
                "l2"=>$l2,
                "veta"=>0,
                "veta"=>0,
                "veta"=>0,
                "type"=>'N',
                "barcode1"=>$code1,
                "barcode2"=>$code2,
                "codeqr"=>$t->ORDERIDGPRS,
                "quantity"=>$qt,
                "type_tags"=>""
            );
            
            $cnt = $this->input->post("cnt");
            $type_generation = $this->input->post("type_generation");
            $array = $this->input->post("array_body");
            
           
            if($type_generation == "D"){
                if($lengF == 50 || $widthF == 50){
                    $data["type_tags"] = "D";
                }else if($this->EachArray($array,$sheet) == "D"){
                    if( (($lengF*2)>250) && (($widthF*2)>250) && ($qt > $cnt) && ((($lengF*2)<1200) || (($widthF*2)<1200)) && ($suma_cantos > 0 && $suma_cantos < 4)){
                        $data["type_tags"] = "D";
                    }else if(($qt > $cnt && $lengF<250 && (($lengF*2)>250) && $suma_cantos == 4) || ($qt > $cnt && $widthF<250 && (($widthF*2)>250) && $suma_cantos == 4) ){
                        $data["type_tags"] = "D";
                    }
                }
            }
            
            var_dump($data);
//            var_dump($arrayCantos);
            
     
        }
        
        
//        echo json_encode(array("res" => "OK")); 
    }
    
    function EachArray($array,$sheet){
        $type = "";
        foreach ($array as $v) {
           if($v[0] == $sheet){
               $type = $v[1];
           }
           break;
        }
        return $type;
    }
    
    function LoadSheetOrders(){
        $result = $this->M_Order->LoadSheetOrders();
        
        $table = $this->load->view("Imos/Order/V_Table_Sheet_Tags", $result, true);
        
        echo json_encode(array("res"=>$result["res"],"tabla"=>$table)); 
    }
}

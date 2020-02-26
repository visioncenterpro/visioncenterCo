<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Dispatch_La extends Controller {

    public function __construct() {
        parent::__construct();
        $var = $this->router->fetch_method();
        if($var == "request_cargo" || $var == "report_supervisory" || $var == "PdfRequest" || $var == "request_cargo_form1" || $var == "PdfRequisition"){
            $f =1;
        }else{
            $this->ValidateSession();
        }
        // if($var != "report_supervisory" || $var != "request_cargo"){
        //     $this->ValidateSession();
        // }
        $this->load->model("Dispatch/M_Dispatch");
    }

    function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['rows'] = $this->M_Dispatch->ListRequest();
        $rili = $this->M_Dispatch->ListRequest();
        foreach ($rili as $key => $value) {
            $vali = $this->M_Dispatch->get_data_remission_ini($value->id_request_sd);
            if(count($vali) > 0){
                $data['orders'][$value->id_request_sd] = $this->M_Dispatch->get_data_remission_ini($value->id_request_sd);
            }else{
                $data['orders'][$value->id_request_sd] = $this->M_Dispatch->get_data_remission_ini2($value->id_request_sd);
            }
        }
        $data['table'] = $this->load->view('Dispatch/Request/V_Table_Request',$data,true);
        
        $this->load->view('Dispatch/Request/V_Panel',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function Show_Packages($order) {
        
        $data['head'] = $this->M_Dispatch->LoadHeaderOrder($order);
        
        $this->load->view("Dispatch/Pack/Pdf/V_Head_Pack",$data);
        
        $forniture = $this->M_Dispatch->LoadFornitureOrder($order);
      
        foreach ($forniture as $m):
            
            $data['name'] = $m->description;
            $data['item'] = $m->item;
            $data['colorPdf'] = $m->colored;
            
            $data['packages'] = $this->M_Dispatch->LoadPackages($order,$m->id_forniture);
            
            $this->load->view("Dispatch/Pack/Pdf/V_Body_Pack",$data);
        endforeach;
        
        
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Pack");
    }
    
    
    function get_data_remission(){
        $get_data = $this->M_Dispatch->get_data_remission();
        if(count($get_data) > 0){
            echo json_encode($get_data);
        }else{
            $get_data = $this->M_Dispatch->get_data_remission2();
            echo json_encode($get_data);
        }
        
    }
    
    function InfoRequestDispatchSD($id){
        //$count_arr=array();
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['request'] = $this->M_Dispatch->InfoRequestSD($id);
        $data['vehicles'] = $this->M_Dispatch->get_vehicles();
        $data['request_weight'] = $this->M_Dispatch->get_Request_weightxid_request($id);
        $data['vali_request_w'] = 0;
        $data['status'] = 0;
        if(count($data['request_weight']) > 0){
            $data['status'] = $data['request_weight']->id_status;
            $data['vali_request_w'] = 1;
            if($data['request_weight']->id_status == 15 || $data['request_weight']->id_status == 16){
                $data['vali_request_w'] = 2;
            }
        }
        
        $content = $this->M_Dispatch->LoadContainerSDESP($id,'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($id,'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);
        
        
        $row = $this->M_Dispatch->OrderAvailableSD();
        $count_arr['supplies'] = array();
        $count_arr['modulate'][] = array();
        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista, no quitar!
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',
            array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, 
            "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;
        
        $data['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS, "validation" => $count_arr),true);
        
        $this->load->view('Dispatch/Request/Modulated/V_Info',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS,ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function get_report_supervisory(){
        $resulPack = $this->M_Dispatch->LoadHeaderPack($this->input->post('id_request_sd'));
        echo json_encode($resulPack);
    }

    function report_supervisory($id_request_sd){
        $resulPack = $this->M_Dispatch->LoadHeaderPack($id_request_sd);
        $total_tags = 1;
        $count_pb = 1;
        $this->load->view("Dispatch/Pack/Pdf/header_packs_limit");
        foreach ($resulPack as $r):
            $up = true;
            //echo $r->id_order_package;
            $ticket = 1;
            $data = array(
                "ItemQr" => $r->id_order_package,
                "client" => $r->client,
                "driver" => $r->driver,
                "license_plate" => $r->license_plate,
                "id_request_sd" => $id_request_sd,
                "type"   => $r->type,
                "quantity_packets" => $r->quantity_packets,
                "forniture" => $r->description,
                "start" => $r->number_pack,
                "pack"  => $this->M_Dispatch->MaxPack($id_request_sd, $r->id_forniture, $r->type_package),
                "color" => '' //$this->M_Dispatch->Colorforniture($order, $r->id_forniture)
            );
            $data['new'] = true;
            $data['quantity_packets'] = $r->quantity_packets;
  

            $data["ticket"] = $ticket++;
            $data["count"] = $total_tags;
            $data['count_pb'] = $count_pb;
            $this->load->view("Dispatch/Pack/Pdf/content_packs_report", $data);

        
            $total_tags++;
            //}// end for

            if ($up) {
                // $total_tags++;
            }
            $count_pb = $count_pb + $r->quantity_packets;
        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack3");
    }
    
    function get_data_goBack(){
        $data = array(
            'type' => $this->input->post('type'),
            'id_delivery_detail' => $this->input->post('id_delivery_package_detail')
        );
        if($this->input->post('type') == 'M'){
            $data['data'] = $this->M_Dispatch->get_data_goBack();
            $data['content'] = $this->load->view('Dispatch/Request/Modulated/content_goBack',$data,true);
        }else{
            $data['data'] = $this->M_Dispatch->get_data_goBackSupplies();
            $data['content'] = $this->load->view('Dispatch/Request/Modulated/content_goBackSupplies',$data,true);
        }
        echo json_encode($data);
    }

    function goBack_Package(){
        $data = $this->M_Dispatch->goBack_Package();
        echo json_encode($data);
    }

    function request_cargo_form1(){ // formulario de control de cargue
        // $array['menus'] = $this->M_Main->ListMenu();

        // $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
         $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
         $this->load->view('Template/V_Header2', $Header);

        $data['remissions']     = $this->M_Dispatch->get_data_remission_all();
        $data['data_request']   = $this->M_Dispatch->get_data_request();
        $data['table']          = $this->load->view('Dispatch/Request/V_Table_Request_Cargo',$data,true);
        $data['content_modal']  = $this->load->view('Dispatch/Request/Content_Modal',$data,true);
        $this->load->view('Dispatch/Request/V_Panel_request_cargo',$data);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js']     = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function request_cargo_form(){ // formulario de control de cargue
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header2', $Header);

        $data['remissions']     = $this->M_Dispatch->get_data_remission_all();
        $data['data_request']   = $this->M_Dispatch->get_data_request();
        $data['table']          = $this->load->view('Dispatch/Request/V_Table_Request_Cargo',$data,true);
        $data['content_modal']  = $this->load->view('Dispatch/Request/Content_Modal',$data,true);
        $this->load->view('Dispatch/Request/V_Panel_request_cargo_La',$data);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js']     = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function create_request_cargo(){

        $data['id'] = $this->M_Dispatch->create_request_cargo();
        $array_id = $this->input->post('array_id');
        $array_sd = $this->input->post('array_sds');
        for ($i=0; $i < count($array_id); $i++) {
            $data['detail'] = $this->M_Dispatch->create_request_cargo_detail($array_id[$i],$data['id'],$array_sd[$i]);
        }
        echo json_encode($data);
    }

    function modal_add_data(){
        $array_id = $this->input->post('array_id');
        $data['data_request']   = $this->M_Dispatch->get_data_requestXid($array_id);
        $data['content_modal']  = $this->load->view('Dispatch/Request/Content_Modal',$data,true);
        echo json_encode($data);
    }

    function data_truck(){
        $array_id = $this->input->post('id_request_sd');
        //for ($i=0; $i < count($array_id); $i++) {
            $data = $this->M_Dispatch->get_data_trunk($array_id);
        //}
        echo json_encode($data);
    }

    function get_request_cargo(){
        $data = $this->M_Dispatch->get_request_cargoXsd($this->input->post('id_request_sd'));
        echo json_encode($data);
    }

    function request_cargo($id_request_cargo){
        $get_request_cargo = $this->M_Dispatch->get_request_cargo($id_request_cargo);
        $get_request_cargo_detail = $this->M_Dispatch->get_request_cargo_detail($id_request_cargo);
        $data = array();
        $client = array();
        $client2 = array();
        $data_vali = array();
        foreach ($get_request_cargo_detail as $key => $value) {
            $data['content'][] = $this->M_Dispatch->LoadContainerXremission($value->id_remission);
            $vali = $this->M_Dispatch->LoadContainerXremission($value->id_remission);
            foreach ($vali as $key => $value) {
                if (!array_search($value->client, $client)) {
                    $get_data = $this->M_Dispatch->dis_remissionXclient($value->client);
                    foreach ($get_data as $key => $value2) {
                        $data_vali[$value->client][] = $value2->id_request_sd;
                    }
                    $client2[] = $value->client;
                }
                $client[] = $value->client;
            }
        }
        $data['client'] = $client2;
        $data['content2'] = $data_vali;
        $data['data_cargue'] = $get_request_cargo;
        $data['head'] = $this->M_Dispatch->LoadDataHeaderCargo($get_request_cargo->id_data_header);

        $this->load->view('Dispatch/Request/Pdf/V_Head_Cargo', $data);
        $this->load->view('Dispatch/Request/pdf/V_Container_Cargo', $data);

        //$this->load->view('Dispatch/Request/pdf/V_Table_Total',$data);
    }

    // Created by Ivan Contreras 27/03/2019
    function get_vehicle(){
        $id_vehicle = $this->input->post('id_vehicle');
        $data = $this->M_Dispatch->get_vehicle($id_vehicle);
        echo json_encode($data);
    }
    
    function get_data_detail(){
        $data['header'] = $this->M_Dispatch->get_data_header();
        foreach ($data['header'] as $value) {
            $detail = $this->M_Dispatch->get_data_detail();
            if (count($detail) > 0){
                $data['res'] = "OK";
                $data['number_pack'] = $value->number_pack;
                $data['table'] = $this->load->view('Dispatch/Request/Modulated/V_Table_Detail_Suppliies',array('detail' => $detail), true);
            }else{
                $data['res'] = "error";
            }
        }
        echo json_encode($data);
    }
    
    function CreateRequestSD(){
        $rs = $this->M_Dispatch->CreateRequestSD();
        echo json_encode($rs);
    }
    
    
    function AddPackSDToRequest(){
        $rs = $this->M_Dispatch->AddPackSDToRequest();
        if($rs['res'] == "OK"){
            $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
            $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
            $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
            $rs['num_packets'] = $row->num_packets;
        }
        echo json_encode($rs);
    }
    
    function AddPackSDToRequestGroup(){
        $rs = $this->M_Dispatch->AddPackSDToRequestGroup();
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
         
        echo json_encode($rs);
    }
    
    function AddItemGroup(){
        $rs = $this->M_Dispatch->AddItemGroup();
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
           
        echo json_encode($rs);
    }
    
    function AddItemGroupSupplies(){
        $rs = $this->M_Dispatch->AddItemGroupSupplies();
        
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);
        
        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
        
        echo json_encode($rs);
    }
    
    function DeleteAllPackRequestSD(){
        $result = $this->M_Dispatch->LoadContainerSDESP($this->input->post('request'),$this->input->post('type'));
        
        
        foreach ($result as $value) {
            $rs['res'] = $this->M_Dispatch->DeletePackRequestSD($value->id_request_detail);
        }
        
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
            
        echo json_encode($rs);
    }
    
    function DeleteSuppliesRequestSD(){
        $rs['res'] = $this->M_Dispatch->DeleteSuppliesRequestSD($this->input->post('id_request_detail'));
        
        
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
            
        echo json_encode($rs);
    }
    
    function DeleteAllSuppliesRequestSD(){
        $result = $this->M_Dispatch->LoadContainerSD($this->input->post('request'),'Insumos');
        
        
        foreach ($result as $value) {
            $rs['res'] = $this->M_Dispatch->DeletePackRequestSD($value->id_request_detail);
        }
        
        $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
        $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
        $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
        $rs['num_packets'] = $row->num_packets;

        $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
        $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

        $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
        $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);

        $row = $this->M_Dispatch->OrderAvailableSD();

        $tab_pane = "";
        foreach ($row as $v):
            $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
            $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
            $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
            $val_f = array();
            foreach ($furnitures as $f){
                $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                foreach ($val as $vf) {
                    //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                    if($vf->quantity_packets == $vf->quantity_dispatch){
                        $val_f2 = 1;
                    }else{
                        $val_f2 = 0;
                        break;
                    }
                }
                $val_f[] = $val_f2;
            }
            $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
            $count = 0;
            foreach ($packs_available as $key => $value) {
                $count = $count + $value->balance_dispatch;
            }
            $weight_p = array();
            $qd = 2; // estado sin cargar insumos para vista
            foreach ($packs_available_supplies as $value) {
                $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                $weightc = 0;
                foreach ($get_weight as $valuew) {
                    $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                }
                $weight_p[] = $weightc;
            }
            foreach ($packs_available_supplies as $value) {
                $qd = $value->quantity_dispatch;
                if($qd == 0){
                    break;
                }
            }
            $count_arr['supplies'][] = $qd;
            $count_arr['modulate'][] = $count;
            $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
        endforeach;

        $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);
            
        echo json_encode($rs);
    }
    
    function DeletePackRequestSD(){
        $rs['res'] = $this->M_Dispatch->DeletePackRequestSD();
        if($rs['res'] == "OK"){
            $row = $this->M_Dispatch->InfoRequestSD($this->input->post("request"));
            $rs['total_weight_modulate'] = round($row->total_weight_modulate,4);
            $rs['total_weight_supplies'] = round($row->total_weight_supplies,4);
            $rs['num_packets'] = $row->num_packets;
            
            $content = $this->M_Dispatch->LoadContainerSDESP($this->input->post("request"),'Modulado');
            $container = $this->load->view('Dispatch/Request/Modulated/V_Container_PackSD',array("content"=>$content),true);

            $contentS = $this->M_Dispatch->LoadContainerSD2($this->input->post("request"),'Insumos');
            $containerS = $this->load->view('Dispatch/Request/Supplies/V_Container_Supplies',array("content"=>$contentS),true);
            
            $row = $this->M_Dispatch->OrderAvailableSD();

            $tab_pane = "";
            foreach ($row as $v):
                $suppliesP = $this->M_Dispatch->get_supplies_p($v->order);
                $packs_available = $this->M_Dispatch->ListPackSDAvailable($v->order);
                $furnitures = $this->M_Dispatch->ListPackSDAvailable2($v->order);
                $val_f = array();
                foreach ($furnitures as $f){
                    $val = $this->M_Dispatch->ListPackSDAvailablexfurniture($f->id_forniture,$v->order);
                    foreach ($val as $vf) {
                        //echo $vf->quantity_packets ."==". $vf->quantity_dispatch."-";
                        if($vf->quantity_packets == $vf->quantity_dispatch){
                            $val_f2 = 1;
                        }else{
                            $val_f2 = 0;
                            break;
                        }
                    }
                    $val_f[] = $val_f2;
                }
                $packs_available_supplies = $this->M_Dispatch->ListPackSDAvailableSupplies2($v->order);
                $count = 0;
                foreach ($packs_available as $key => $value) {
                    $count = $count + $value->balance_dispatch;
                }
                $weight_p = array();
                $qd = 2; // estado sin cargar insumos para vista
                foreach ($packs_available_supplies as $value) {
                    $get_weight = $this->M_Dispatch->get_weight($value->id_order_package_supplies,$v->order);
                    $weightc = 0;
                    foreach ($get_weight as $valuew) {
                        $weightc = $weightc + ($valuew->quantity_packaged * $valuew->weight_per_supplies);
                    }
                    $weight_p[] = $weightc;
                }
                foreach ($packs_available_supplies as $value) {
                    $qd = $value->quantity_dispatch;
                    if($qd == 0){
                        break;
                    }
                }
                $count_arr['supplies'][] = $qd;
                $count_arr['modulate'][] = $count;
                $tab_pane .= $this->load->view('Dispatch/Request/Modulated/V_Div_Tab',array("order"=>$v->order,"packs"=>$packs_available, "supplies"=>$packs_available_supplies, "furnitures" => $furnitures,"val_f" => $val_f, "weight_p" => $weight_p, "suppliesP" => $suppliesP),true);
            endforeach;

            $rs['tabs'] = $this->load->view('Dispatch/Request/Modulated/V_Tabs',array("orders"=>$row,"tab_pane"=>$tab_pane, "content"=>$container, "contentS"=>$containerS,"validation" => $count_arr),true);

        }
        echo json_encode($rs);
    }
    
    function UpdateRequestSD(){
        $rs = $this->M_Dispatch->UpdateRequestSD();
        echo json_encode($rs);
    }
    
    function UpdateRequestSD2(){
        $rs = $this->M_Dispatch->UpdateRequestSD2();
        echo json_encode($rs);
    }
    
    function CreateRequisition(){
        $rs = $this->M_Dispatch->CreateRequisition();
        if($rs["res"] == "OK"){
            $this->M_Dispatch->UpdateStateRequest(17, true);
        }
        echo json_encode($rs);
    }

    function Request_weight(){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['request'] = $this->M_Dispatch->get_request_weight();
        $this->load->view('Dispatch/Request/V_Panel_Request_Weight',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js']     = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function Create_Request_weight(){
        $vali = $this->M_Dispatch->get_Request_weightxid_request2($this->input->post('request'));
        if(count($vali) > 0){
            foreach ($vali as $key => $value) {
                if($value->id_status == "1"){
                    $data = "already";
                }else{
                    $data = $this->M_Dispatch->Update_Request_weight();
                }
            }
        }else{
            $data = $this->M_Dispatch->Create_Request_weight();
        }
        echo json_encode($data);
    }

    function data_request_weight(){
        $data['data'] = $this->M_Dispatch->data_request_weight();
        $data['content'] = $this->load->view("Dispatch/Request/Content_modal_Request_weight",$data, true);
        echo json_encode($data);
    }

    function response_request_weight(){
        $data = $this->M_Dispatch->response_request_weight();
        echo json_encode($data);
    }
    
    function PdfRequest($id_request_sd){
        $data['head'] = $this->M_Dispatch->InfoRequestSD($id_request_sd);
        $this->load->view("Dispatch/Request/Pdf/V_Head_Request",$data);
        
        $content = $this->M_Dispatch->LoadContainerSD($id_request_sd,'Modulado');
        $this->load->view('Dispatch/Request/pdf/V_Container_Modulate',array("content"=>$content));
        
        $contentS = $this->M_Dispatch->LoadContainerSD($id_request_sd,'Insumo');
        $this->load->view('Dispatch/Request/pdf/V_Container_Supplies',array("content"=>$contentS));
        
        $this->load->view('Dispatch/Request/pdf/V_Table_Total',$data);
        
    }
    
    function PdfRequisition($remission,$id_request_sd){

        $data['head'] = $this->M_Dispatch->LoadHeaderRequisition($remission);
        $data['head2'] = $this->M_Dispatch->LoadDataRequisition($id_request_sd);
        $this->load->view("Dispatch/Request/Pdf/V_Head_Remission",$data);
        
        $det = $this->M_Dispatch->LoadDetailRequisition($id_request_sd,"Modulado");
        $Table = "";
        if(count($det)){
            $sw = false;
            $oldForniture = "";
            $array = array("Tpacks"=>0,"Tweight"=>0);
            foreach ($det as $v) :
                
                if($v->name != $oldForniture && $oldForniture != ""){
                    $this->load->view("Dispatch/Request/Pdf/V_Detail_Modulate", array("detail"=>$Table,"total"=>$array));
                    $Table = "";
                    $array = array("Tpacks"=>0,"Tweight"=>0);
                }
                
                $Table .= '<tr nobr="true">';
                if (!$sw || $v->name != $oldForniture):
                    $color = $this->M_Dispatch->Colorforniture($v->order, $v->id_forniture);
                    $Table .= '<td rowspan ="1" style="text-align:center;background-color:'.$color.';font-size: 11px; color: white;">' . $v->name . '</td>';
                    $sw = true;
                else:
                    $Table .= '<td style="border-color: #000; border:none"></td>';
                endif;
                $array['Tpacks'] += $v->quantity_packets;
                $array['Tweight'] += $v->weight;
                $Table .= '<td style="text-align:center;">'.$v->pack.'</td>';
                $Table .= '<td style="text-align:center;">'.$v->quantity_packets.'</td>';
                $Table .= '<td style="text-align:right;">'.round($v->weight,6).'</td>';
                $Table .= '</tr">';
                
                $oldForniture = $v->name;
            endforeach;
            $this->load->view("Dispatch/Request/Pdf/V_Detail_Modulate", array("detail"=>$Table,"total"=>$array));
        }
        
        $det = $this->M_Dispatch->LoadDetailRequisition($id_request_sd,"Insumos");
        $arr_supplies = array();
        foreach ($det as $valued) {
            $arr_supplies[] = $this->M_Dispatch->LoadDetailRequisition2($valued->id_order_package,$valued->order);
        }
        if(count($det)){
            $this->load->view("Dispatch/Request/Pdf/V_Detail_Supplies", array("detail"=>$det, "supplies" => $arr_supplies));
        }
        
        $this->load->view("Dispatch/Request/Pdf/V_Footer_Remission");
    }

    
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Request extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Maintenance/Request/M_Request");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        
        foreach ($this->M_Request->LoadButtonPermissions("Mantenimiento") as $btn) {
            $data[$btn->name] = $btn->name;
        }
        
        $data['request'] = $this->M_Request->ListRequestAll();
        $data['table'] = $this->load->view('Maintenance/Request/V_Table_Request',$data,true);
        $this->load->view('Maintenance/Request/V_List_Request',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function ManageMmto() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SELECT2_CSS, SWEETALERT_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['maquinas'] = $this->M_Request->ListMachine();
        $data['damage'] = $this->M_Request->ListTypeDamageLoc();
        $data['area'] = $this->M_Request->ListAreaAll();
        
        $this->load->view('Maintenance/Request/V_Create_Request',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SELECT2_JS, SWEETALERT_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function InfoRequestMmto($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SELECT2_CSS, SWEETALERT_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['maquinas'] = $this->M_Request->ListMachine();
        $data['damageLoc'] = $this->M_Request->ListTypeDamageLoc();
        $data['damageMac'] = $this->M_Request->ListTypeDamageMachine();
        $data['area'] = $this->M_Request->ListAreaAll();
        $data['aux'] = $this->M_Request->ListAuxManintenance();
        $data['record'] = $this->M_Request->LoadRequest($id);
        
        $this->load->view('Maintenance/Request/V_Update_Request',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SELECT2_JS, SWEETALERT_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function CreateRequest(){
        $result = $this->M_Request->CreateRequest();
        echo json_encode(array("res"=>$result));
    }
    
    function UpdateRequest(){
        $result = $this->M_Request->UpdateRequest();
        echo json_encode(array("res"=>$result));
    }
    
    function UpdateFieldRequest(){
        $result = $this->M_Request->UpdateFieldRequest();
        echo json_encode(array("res"=>$result));
    }
    
    function DeleteRequest(){
        $result = $this->M_Request->DeleteRequest();
        
        $table ="";
        if($result == "OK"){
            $data['request'] = $this->M_Request->ListRequestAll();
            $table = $this->load->view('Maintenance/Request/V_Table_Request',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
}


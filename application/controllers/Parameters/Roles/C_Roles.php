<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Roles extends Controller {

    public function __construct() {
    parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Roles/M_Rol");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $data['roles'] = $this->M_Rol->ListRolAll();
        $data['status'] = $this->M_Rol->ListStatusAll();
        $data['table'] = $this->load->view('Parameters/Roles/V_Table_Rol',$data,true);
        $this->load->view('Parameters/Roles/V_List_Rol',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function UpdateRol(){
        $result = $this->M_Rol->UpdateRol();
        $table ="";
        if($result == "OK"){
            $data['roles'] = $this->M_Rol->ListRolAll();
            $table = $this->load->view('Parameters/Roles/V_Table_Rol',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function CreateRol(){
        $result = $this->M_Rol->CreateRol();
        $table ="";
        if($result == "OK"){
            $data['roles'] = $this->M_Rol->ListRolAll();
            $table = $this->load->view('Parameters/Roles/V_Table_Rol',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function DeleteRol(){
        $result = $this->M_Rol->DeleteRol();
        $table ="";
        if($result == "OK"){
            $data['roles'] = $this->M_Rol->ListRolAll();
            $table = $this->load->view('Parameters/Roles/V_Table_Rol',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }

}

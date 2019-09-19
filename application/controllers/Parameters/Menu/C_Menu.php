<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Menu extends Controller { 
        
    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Menu/M_Menu");
    }


    public function index(){
        $array['menus'] = $this->M_Main->ListMenu(); 
        
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu',$array,true);
        $Header['array_css'] = array(DATATABLES_CSS,SWEETALERT_CSS);
        $this->load->view('Template/V_Header',$Header);
        
        $data['menus'] = $this->M_Menu->ListMenuAll();
        $data['status'] = $this->M_Menu->ListStatusAll();
        $data['icons'] = $this->M_Menu->LoadIcons();
        $data['type_menu'] = $this->M_Menu->ListTypeMenuAll();
        
        $data['table'] = $this->load->view('Parameters/Menu/V_Table_Menu',$data,true);
        $this->load->view('Parameters/Menu/V_List_Menu',$data);
        
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs',null,true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer',$Footer);
    }
    
    
    function LoadFathers(){
        $fathers = $this->M_Menu->LoadFathers();
        echo json_encode(array("datos"=>$fathers));
    }
    
    function UpdateMenu(){
        $result = $this->M_Menu->UpdateMenu();
        echo $result;
    }
    
    function CreateMenu(){
        $result = $this->M_Menu->CreateMenu();
        $table ="";
        if($result == "OK"){
            $data['menus'] = $this->M_Menu->ListMenuAll();
            $table = $this->load->view('Parameters/Menu/V_Table_Menu',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function DeleteMenu(){
        $result = $this->M_Menu->DeleteMenu();
        $table ="";
        if($result == "OK"){
            $data['menus'] = $this->M_Menu->ListMenuAll();
            $table = $this->load->view('Parameters/Menu/V_Table_Menu',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
   
}

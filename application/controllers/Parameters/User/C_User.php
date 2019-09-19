<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_User extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/User/M_User");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS,ALERTIFY_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['user'] = $this->M_User->ListUser();
        $data['rol'] = $this->M_User->ListRolAll();
        
        $data['table'] = $this->load->view('Parameters/User/V_Table_User', $data, true);
        $this->load->view('Parameters/User/V_List_User', $data);
      

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS,ALERTIFY_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function CreateUser(){
    $result = $this->M_User->CreateUser();
        $table ="";
        if($result == "OK"){
            $data['user'] = $this->M_User->ListUser();
            $table = $this->load->view('Parameters/User/V_Table_User',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));    
        
    }
    
    function ValidaCorreo(){                
       $result = $this->M_User->ValidaCorreo();      
        echo json_encode(array("res"=>$result));  
    }
    
    function DeleteUser(){
        $result = $this->M_User->DeleteUser();
        $table ="";
        if($result == "OK"){
           $data['user'] = $this->M_User->ListUser();
            $table = $this->load->view('Parameters/User/V_Table_User',$data,true);
        }
        echo json_encode(array("res"=>$result,"tabla"=>$table));
    }
    
    function InfoUser($id){
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);

        $data['id'] = $id;
        $this->load->view('Parameters/User/InfoUser', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
       
   } 

}

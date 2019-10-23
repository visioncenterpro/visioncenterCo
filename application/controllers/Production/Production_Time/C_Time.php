<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Time extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Production/Production_Time/M_Time");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, TIMEPICKER_CSS, DATEPICKER_CSS, SELECT2_CSS,ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);

        
        $data['Machine'] = $this->M_Time->ListMachine();
        $data['Stop_Machine'] = $this->M_Time->ListStop_Machine();
        $data['Estado'] = $this->M_Time->ListEstado();
        $data['productivity'] = $this->M_Time->ListProductivity();
        
        $this->load->view('Production/Production_Time/V_Panel_Time', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, TIMEPICKER_JS, DATEPICKER_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function CreateTime() {
        $result = $this->M_Time->CreateTime();
        echo json_encode(array("res" => $result));
    }
    
 function ListRegister() {
       $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, TIMEPICKER_CSS, DATEPICKER_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['hour'] = $this->M_Time->ListHours();
        $data['Machine'] = $this->M_Time->ListMachine();
        $data['Stop_Machine'] = $this->M_Time->ListStop_Machine();
        $data['Estado'] = $this->M_Time->ListEstado();
        
        $data['register'] = $this->M_Time->ListRegister();
        
        $data['table'] = $this->load->view('Production/Production_Time/V_Table_Time', $data, true);
        $this->load->view('Production/Production_Time/V_Panel_Time', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, TIMEPICKER_JS, DATEPICKER_JS, SELECT2_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function date_register(){
        $data['register'] = $this->M_Time->ListRegisterWhere();
        $data['hour'] = $this->M_Time->ListHours();
        $data['table'] = $this->load->view('Production/Production_Time/V_Table_Time', $data, true);  
        echo json_encode($data);
    }
    
        function DeleteDay() {
        
        $result=$this->M_Time->DeleteDay(); 
        $table = "";
        if ($result == "OK") {
            $data['register'] = $this->M_Time->ListRegisterWhereDelete();
            $data['table'] = $this->load->view('Production/Production_Time/V_Table_Workforce', $data, true); 
        }
        echo json_encode($data);        
    }
      function date_Consult() {
        $result = $this->M_Time->date_Consult();
        echo json_encode(array("res" => $result));
    }
}

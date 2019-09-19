<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Workforce extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Production/Production_Time/M_Workforce");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, TIMEPICKER_CSS, DATEPICKER_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['Stop_Machine'] = $this->M_Workforce->ListStop_Machine();
        
        $data['Estado'] = $this->M_Workforce->ListEstado();
        $data['No_Machine'] = $this->M_Workforce->ListNo_Machine();
        

        $this->load->view('Production/Production_Time/V_Workforce', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, TIMEPICKER_JS, DATEPICKER_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
      function date_register(){
        $data['register'] = $this->M_Workforce->ListRegisterWhere();
        $data['hour'] = $this->M_Workforce->ListHours();
        $data['table'] = $this->load->view('Production/Production_Time/V_Table_Workforce', $data, true); 
       
        echo json_encode($data);
        
    }
     function Creaworkforce() {
        $result = $this->M_Workforce->Creaworkforce();
        echo json_encode(array("res" => $result));
    }
    
    function DeleteDay() {
        
        $result=$this->M_Workforce->DeleteDay(); 
        $table = "";
        if ($result == "OK") {
            $data['register'] = $this->M_Workforce->ListRegisterWhereDelete();
           
            $data['table'] = $this->load->view('Production/Production_Time/V_Table_Workforce', $data, true); 
        }
        echo json_encode($data);        
    }

}

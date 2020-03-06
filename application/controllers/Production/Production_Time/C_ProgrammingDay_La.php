<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_ProgrammingDay_La extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->ValidateSession();
        $this->load->model("Production/Production_Time/M_ProgrammingDay");
    }

    public function index() {
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, TIMEPICKER_CSS, DATEPICKER_CSS, SELECT2_CSS,ICHECK_CSS_RED);
        $this->load->view('Template/V_Header2', $Header);


        $this->load->view('Production/Production_Time/V_ProgrammingDay_La');

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, TIMEPICKER_JS, DATEPICKER_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function Createprogrammingday() {
        $result = $this->M_ProgrammingDay->Createprogrammingday();
        echo json_encode(array("res" => $result));
    }
    
    function valideprogrammingday(){
        $result = $this->M_ProgrammingDay->valideprogrammingday();
        echo json_encode(array("res" => $result));
        
    }
    
      function updateProgrammingDay() {
        $result = $this->M_ProgrammingDay->updateProgrammingDay();
        echo json_encode(array("res" => $result));
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Budgets_La extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->ValidateSession();
        $this->load->model("Production/Production_Time/M_Budgets");
    }

    public function index() {
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, ALERTIFY_CSS, TIMEPICKER_CSS, DATEPICKER_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header2', $Header);


        $this->load->view('Production/Production_Time/V_Budgets');

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, ALERTIFY_JS, TIMEPICKER_JS, DATEPICKER_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function CreBudgets() {
        $result = $this->M_Budgets->CreBudgets();
        echo json_encode(array("res" => $result));
    }

    function validateBudgets() {
        $result = $this->M_Budgets->validateBudgets();
        echo json_encode(array("res" => $result));
    }
    function watch_Budgets() {        
        $oldDate = $this->input->post("dayOpen");
        $arr = explode('-', $oldDate);
        
        $end = $arr[0] . "-" . $arr[1] . "-" . date("d", (mktime(0, 0, 0, $arr[1] + 1, 1, $arr[0]) - 1));
        $NotWorking = $result = $this->M_Budgets->LoadDayNotWorking($end);
      
        
        $result=$this->getDiasHabiles($arr[1], $arr[0], $NotWorking );

        $result2 = $this->M_Budgets->validateMonth();
        echo json_encode(array("days" => $result['count'],"Datos" => $result2));
    }
     function updateBudgets() {
        $result = $this->M_Budgets->updateBudgets();
        echo json_encode(array("res" => $result));
    }

}

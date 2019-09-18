<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Days extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Days/M_Days");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS,FULL_CALENDAR_CSS,DATEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $this->load->view('Parameters/Days/V_Days');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS,MOMENT,FULL_CALENDAR_JS,DATEPICKER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ListDayNonWorking(){
        $response = $this->M_Days->ListDayCalendarAll(1);
        $days = array();
        foreach ($response as $v) :
            $days[] = array("title" => $v->description, "start" => $v->day);
        endforeach;
        echo json_encode($days);
    }
    
    function AddDayCalendar() {
        $result = $this->M_Days->AddDayCalendar();
        echo json_encode(array("res" => $result));
    }

    function DeleteDayCalendar() {
        $result = $this->M_Days->DeleteDayCalendar();
        echo json_encode(array("res" => $result));
    }

}


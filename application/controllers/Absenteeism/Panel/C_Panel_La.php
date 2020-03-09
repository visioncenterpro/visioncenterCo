<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Panel_La extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->ValidateSession();
        $this->load->model("Absenteeism/Panel/M_Panel");
    }

    public function index() {
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, DATEPICKER_CSS, TIMEPICKER_CSS,ALERTIFY_CSS);
        $this->load->view('Template/V_Header2', $Header);


        $data['person'] = $this->M_Panel->ListPersonAll();
        $data['indicators'] = $this->load->view("Absenteeism/Panel/V_Indicators_La", $this->M_Panel->CountIndicators(), true);

        $d['indicators'] = $this->M_Panel->CountSubIndicator();
        $data['subindicators'] = $this->load->view("Absenteeism/Panel/V_Sub_Indicators", $d, true);

        $this->load->view('Absenteeism/Panel/V_Panel_La', $data);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, DATEPICKER_JS, TIMEPICKER_JS,ALERTIFY_JS);
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function createabsent() {
        $result = $this->M_Panel->createabsent();
        $html = "";

        if ($result = "OK") {
            $html = $this->load->view("Absenteeism/Panel/V_Indicators", $this->M_Panel->CountIndicators(), true);
        }
        echo json_encode(array("res" => $result, "ind" => $html));
    }

    function Createnovelty() {
        $result = $this->M_Panel->Createnovelty();
        $html = "";

        if ($result = "OK") {
            $html = $this->load->view("Absenteeism/Panel/V_Indicators", $this->M_Panel->CountIndicators(), true);
        }
        echo json_encode(array("res" => $result, "ind" => $html));
    }

    function LoadDetailProg() {
        
       
       $data['datos'] = $this->M_Panel->ModalDetailProg();
       $html = $this->load->view("Absenteeism/Panel/V_Table_Area_Detail",$data,true);
       
       echo json_encode(array("table" => $html));
    }

}

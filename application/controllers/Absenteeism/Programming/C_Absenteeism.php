<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Absenteeism extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Absenteeism/Programming/M_Absenteeism");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['ausentismo'] = $this->M_Absenteeism->ListAbsenteeismAll();


        $data['table'] = $this->load->view('Absenteeism/Programming/V_Table_Absenteeism', $data, true);
        $this->load->view('Absenteeism/Programming/V_Absenteeism', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
      public function ReportNews() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['ausentismo'] = $this->M_Absenteeism->ListAbsenteeismAllReport();
        
        $data['table'] = $this->load->view('Absenteeism/Programming/V_Table_Absenteeism_News', $data, true);
        $this->load->view('Absenteeism/Programming/V_Absenteeism_Report', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function UpdateRH() {
        $currentDir = dirname(__FILE__);
        $uploadDirectory = "/../../../public/evidence/";
        $file = $_FILES['evidencia']['name'];
        $fileTmp = $_FILES['evidencia']['tmp_name'];
        $uploadPath = $currentDir . $uploadDirectory . basename($file);
        $didUpload = move_uploaded_file($fileTmp, $uploadPath);

        $result = $this->M_Absenteeism->UpdateRH($file);
        $table = "";
        if ($result == "OK") {
            $data['ausentismo'] = $this->M_Absenteeism->ListAbsenteeismAll();            
            $table = $this->load->view('Absenteeism/Programming/V_Table_Absenteeism', $data, true);  
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
       
    }
}   
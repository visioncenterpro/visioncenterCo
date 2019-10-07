<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Sheets extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Imos/Sheets/M_Sheets");
    }
    
    public function index(){
        
        // carga el menu y el css
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        // carga la vista principal
        $data['sheets'] = $this->M_Sheets->get_sheets_all();
        $data['formats'] = $this->M_Sheets->get_formats();
        $data['calibers'] = $this->M_Sheets->get_calibers();
        $data['table'] = $this->load->view('Imos/Sheets/V_table_sheets', $data, true);
        $this->load->view('Imos/Sheets/V_panel_sheets', $data);
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer); 
    }
    
    public function save_sheet(){
        $validation = $this->M_Sheets->get_sheet();
        if(count($validation) > 0){
            $data['rs'] = "RE";
        }else{
            $data['rs'] = $this->M_Sheets->save_sheet();
            $data['sheets'] = $this->M_Sheets->get_sheets_all();
            $data['table'] = $this->load->view('Imos/Sheets/V_table_sheets', $data, true);
        }
        echo json_encode($data);
    }
    
    public function get_data_edit(){
        $data['sheet'] = $this->M_Sheets->get_sheet_id();
        echo json_encode($data);
    }
    
    public function update_sheet(){
        $validation = $this->M_Sheets->get_sheet();
        if(count($validation) > 0){
            $data['rs'] = $this->M_Sheets->update_sheet2();
            $data['sheets'] = $this->M_Sheets->get_sheets_all();
            $data['table'] = $this->load->view('Imos/Sheets/V_table_sheets', $data, true);
        }else{
            $data['rs'] = $this->M_Sheets->update_sheet();
            $data['sheets'] = $this->M_Sheets->get_sheets_all();
            $data['table'] = $this->load->view('Imos/Sheets/V_table_sheets', $data, true);
        }
        echo json_encode($data);
    }
    
    function sync_sheet_data(){
        $data = $this->M_Sheets->sync_sheet_data();
        echo json_encode($data);
    }
}
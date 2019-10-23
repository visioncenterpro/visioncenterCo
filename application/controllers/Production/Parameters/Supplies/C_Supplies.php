<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Supplies extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Production/Parameters/Supplies/M_Supplies");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, ALERTIFY_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $array['types'] = $this->M_Supplies->getTypeSupplies();
        $array['units'] = $this->M_Supplies->getUnitSupplies();
        $typeSupplies['typeSupplies'] = $this->load->view('Production/Parameters/Supplies/V_Type_Supplies', $array, TRUE);
        $typeSupplies['modal'] = $this->load->view('Production/Parameters/Supplies/V_Modal', $array, TRUE);
        $this->load->view('Production/Parameters/Supplies/V_Panel', $typeSupplies);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, ALERTIFY_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function getSuppliesByFilter() {
        $data['rows'] = $this->M_Supplies->getSuppliesByFilter();
        $table['table'] = $this->load->view('Production/Parameters/Supplies/V_Table_Supplies', $data, TRUE);
        echo json_encode($table);
    }
    
    public function createSupply() {
        $result = $this->M_Supplies->createSupply();        
        echo json_encode(array("res" => $result));
    }
    
    public function updateSupply() {
        $id = $this->input->post('id_supply');
        $result = $this->M_Supplies->updateSupply();
        echo json_encode(array("res" => $result, "id" => $id));
    }

}


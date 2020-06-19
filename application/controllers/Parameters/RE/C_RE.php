<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_RE extends Controller {

    public function __construct() {
    parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/RE/M_RE");
    }


    public function index(){
    	$array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        // carga la vista principal
        $this->load->view('Parameters/RE/V_List_RE');
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function RE_ORDER(){

    	$vali = $this->M_RE->get_remissions();
    	foreach ($vali as $key => $value) {

    		if (isset($value->id_request_sd)) {
    			if (count($this->M_RE->get_data_dis_cargue($value->id_request_sd)) > 0) {
	    			$delete = $this->M_RE->delete_data_dis_cargue($value->id_request_sd);
	    		}
	    		
	    		if(count($this->M_RE->get_data_dis_weight($value->id_request_sd)) > 0){
	    			$delete2 = $this->M_RE->delete_data_dis_weight($value->id_request_sd);
	    		}
    		}
    		
    	}
    	
    	$data['first'] = $this->M_RE->RE_ORDER();
    	echo json_encode($data);
    }

}

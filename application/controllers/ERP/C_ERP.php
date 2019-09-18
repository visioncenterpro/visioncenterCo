<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_ERP extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        //$this->load->Model("Production/Delivery/M_Delivery");
    }
    
    public function list_materials(){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $this->load->view('ERP/V_Panel_list');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Innovation extends Controller {
        
    public function __construct() {
        parent::__construct();
        $this->session->set_userdata('id_rol', 1);
        $this->ValidateSession();
        $this->load->model("Innovation/M_SalesImos");
        
    }
    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $this->load->view('Innovation/V_List');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    
    
}
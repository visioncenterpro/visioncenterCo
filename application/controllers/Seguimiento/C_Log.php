<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Log extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->library('log_library');
        $this->load->model("Log/M_Log");
    }
    
    public function index(){
        // carga el menu y el css
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        // carga la vista principal
        $data['users'] = $this->M_Log->get_users();
        $data['table'] = $this->load->view('Log/V_Table_Log',$data,true);
        $this->load->view('Log/V_List_Log',$data);
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function datos(){
        $id_user = $this->input->post('user');
        $get_data = $this->M_Log->get_user_id($id_user);
        foreach ($get_data as $key => $value) {
            $ip = $value->ip;
        }
        $log_date = $this->input->post('fecha');
        
        $data = $this->log_library->get_file($ip.'/log-'. $log_date . '.php');
        echo json_encode($data);
    }
}
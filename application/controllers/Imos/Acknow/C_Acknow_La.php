<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Acknow_La extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->ValidateSession();
        $this->load->model("Imos/Acknow/M_Acknow");
    }

    public function index() {
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header2', $Header);
        
        $data['ack'] = $this->M_Acknow->ListAcknowledgement();
        
        $array['table'] = $this->load->view('Imos/Acknow/V_Table_Acknow', $data, true);
        $this->load->view('Imos/Acknow/V_List_Acknow_La',$array);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        
        $this->load->view('Template/V_Footer2', $Footer);
    }
    
    function ShowDetailsAck($id){
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header2', $Header);
        
        //Load data the database
        $data['fields'] = $this->M_Acknow->ChargedColumns();
        $data['values'] = $this->M_Acknow->ListAcknowledgement($id);
        $data['detail'] = $this->M_Acknow->LoadDetailsAcknowledgement($id,0);
        $data['addata_detail'] = $this->M_Acknow->LoadDetailsAcknowledgement($id,1);

        $data['table'] = $this->load->view('Imos/Acknow/V_Detail_Ack',$data,true);
        
        $data['detail_aditional'] = $this->load->view('Imos/Acknow/V_TabAdDeatail_Ack',$data,true);
        
        $this->load->view('Imos/Acknow/V_Acknowledgement',$data);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer2', $Footer);
    }
    
    function LoadDetailInfo(){
        $data['fields'] = $this->M_Acknow->ChargedColumnsDetails();
        $data['values'] = $this->M_Acknow->LoadDetailInfo($this->input->post("id"));
        $modal = $this->load->view('Imos/Acknow/V_Modal_Detail',$data,true);
        echo $modal;
    }

}


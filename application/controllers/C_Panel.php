<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Panel extends Controller {
        
    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
    }

    public function index(){
        $array['menus'] = $this->M_Main->ListMenu(); 
        
        $data['menu'] = $this->load->view('Template/Menu/V_Menu',$array,true);
        
        $this->load->view('Template/V_Header',$data);
        
        $this->load->view('Template/V_Body');
        
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs',null,true);
        $this->load->view('Template/V_Footer',$Footer);
    }
    
    function UpdatePreferences(){
        $this->M_Main->UpdatePreferences();
    }
   
}

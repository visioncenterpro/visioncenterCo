<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Delivery_Dispatch extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Dispatch/Delivery/M_Delivery_Dispatch");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $all = $this->M_Delivery_Dispatch->SelectDelivery(false,false);
        $data['rows'] = $this->M_Delivery_Dispatch->ListarDelivery($this->input->get('start'),$this->input->get('length'),'all','all');
        $data['table'] = $this->load->view('Dispatch/Delivery/V_Table_Delivery_Dispatch',$data,true);
        
        $data['type'] = $this->M_Delivery_Dispatch->Load_Type_Delivery();
        $data['all'] = $all['num'];
        $this->load->view('Dispatch/Delivery/V_Search',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function ListarDelivery($id_delivery,$type){
        $rows = $this->M_Delivery_Dispatch->ListarDelivery($this->input->get('start'), $this->input->get("length"), $id_delivery,$type);
        $all = $this->M_Delivery_Dispatch->SelectDelivery($id_delivery,$type);
        $array = array();
        foreach ($rows['result'] as $v) {
            $array[] = array($v->type, $v->id, $v->date, $v->order, $v->client, '<span class="label label-' . $v->color . '">' . $v->description . '</span>', '<button class="btn btn-block btn-primary btn-xs" onclick="window.location.href = \' '.base_url().'Production/Delivery/C_Delivery/'.$v->view.'/'.$v->id.'/'.$v->order.'/Dispatch \'"><span class="fa fa-sign-in" aria-hidden="true"></span></button>');
        }

        echo json_encode(array('draw' => $this->input->get("draw"), 'recordsFiltered' => $all['num'], 'datos' => $array));
    }
    
    function SearchDelivery(){
        $delivery = $this->M_Delivery_Dispatch->SearchDelivery();

        $data['table'] = "";
        if(count($delivery) > 0){
            $data['table'] = $this->load->view('Dispatch/Delivery/V_Table_Delivery', $delivery, true);
        }
        
        echo json_encode(array("table"=>$data['table']));
    }

}


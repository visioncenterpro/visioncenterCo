<?php
// Created Ivan Contreras 27/03/2019
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Monitoreo extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Monitoreo/M_Monitoreo");
    }
    
    public function index(){
        //print_r($this->CI->input->ip_address());
        // carga el menu y el css
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        // carga la vista principal
        $data['data'] = $this->M_Monitoreo->get_orders();
        
        $this->load->view('Monitoreo/principal',$data);
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, PROGRESS_BAR, SELECT2, CHARTJS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function get_pending(){
        $orden = $this->input->post('orden');
        $request = $this->input->post('solicitud');
        $get_pendientes = array();
        $get_order_request = $this->M_Monitoreo->get_orders_request($request);
        foreach ($get_order_request as $value) {
            $data_pendientes = $this->M_Monitoreo->get_pending($value->order,$request);
            foreach ($data_pendientes as $valuep) {
                $get_pendientes[] = $valuep;
            }
        }
        echo json_encode($get_pendientes);
    }
    
    public function get_pending2(){
        $orden = $this->input->post('orden');
        $request = $this->input->post('solicitud');
        $get_pendientes = array();
        $get_order_request = $this->M_Monitoreo->get_orders_request($request);
        foreach ($get_order_request as $value) {
            $data_pendientes = $this->M_Monitoreo->get_pending2($value->order,$request);
            foreach ($data_pendientes as $valuep) {
                $get_pendientes[] = $valuep;
            }
        }
        echo json_encode($get_pendientes);
    }
    
    public function get_data(){
        $orden = $this->input->post('orden');
        $request = $this->input->post('solicitud');
        $get_datos = array();
        $get_order_request = $this->M_Monitoreo->get_orders_request($request);
        foreach ($get_order_request as $value) {
            $var_datos = $this->M_Monitoreo->get_data($value->order,$request);
            foreach ($var_datos as $valued) {
                $get_datos[] = $valued;
            }
        }
        echo json_encode($get_datos);
    }
    
    public function prueba(){
        // carga el menu y el css
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $this->load->view('Monitoreo/prueba');
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function get_packages(){
        $request = $this->input->post('solicitud');
        $get_orders = $this->M_Monitoreo->get_orders_request($request);
        //print_r($get_orders);
        foreach ($get_orders as $key => $valueo) {
            $cont = 0;
            $cont2 = 0;
            $valip = $this->M_Monitoreo->get_packages_m($request,$valueo->order);
            foreach ($valip as $valued) {
                $get_data[] = array(
                    'name' => $valued->name,
                    'packet_sum'    => $valued->packet_sum,
                    'total_weight'  => round($valued->total_weight,4),
                );
            }
            //print_r($this->M_Monitoreo->get_packages_m($request,$valueo->order));
            $get_data2 = $this->M_Monitoreo->get_sd_detail_m($valueo->order,$request);
            foreach ($get_data2 as $value) {
                $cont = 0;
                $cont2 = 0;
                $get_data3 = $this->M_Monitoreo->get_forniture($valueo->order,$request,$value->id_forniture);
                foreach ($get_data3 as $key2 => $value2) {
                    if($value2->id_status == '18'){
                        $cont++;
                        $cont2++; //= $cont2 + $value2->quantity_packets;
                    }
                }

                $arreglo['modulate'][] = array(
                    'cargados'          => $cont,
                    'forniture'         => $value->id_forniture,
                    'total_paquetes'    => $value->quantity_packets,
                    'paquetes_resta'    => $cont2
                );
            }
            $getsupplies = $this->M_Monitoreo->get_supplies_detail($valueo->order,$request);
            foreach ($getsupplies as $valueS){
                //echo $valueS->order;
                $data_supplies = $this->M_Monitoreo->get_supplies($valueS->order, $valueS->id_order_package);
                $total_q = 0;
                $weigh_t = 0;
                $pack = "";
                foreach ($data_supplies as $valued) {
                    $pack = $valued->number_pack." ".$valued->L_code;
                    $total_q = $total_q + $valued->quantity_packaged;
                    $weigh_t = $weigh_t + ($valued->quantity_packaged * $valued->weight_per_supplies);
                }
                $data_dis_supplies = $this->M_Monitoreo->data_dis_supplies($valueS->order, $valueS->id_order_package);
                foreach ($data_dis_supplies as $value_dis) {
                    switch ($value_dis->id_status) {
                        case 17:
                            $packet_status = 0;
                            break;
                        case 18:
                            $packet_status = 1;
                            break;
                        case 19:
                            $packet_status = 0;
                            break;
                        case 20:
                            $packet_status = 0;
                            break;
                        default:
                            break;
                    }
                }
                
                $arreglo['supplies'][] = array(
                    'pack'              => $pack,
                    'quantity_total'    => $total_q,
                    'weight_total'      => round($weigh_t,4),
                    'packet_quantity'   => $packet_status
                );
            }
        }
        echo json_encode(array($get_data,$get_data2,$arreglo));
    }
    
    public function get_sd_detail(){
        $order = $this->input->post('order');
        $request = $this->input->post('solicitud');
        $get_data = $this->M_Monitoreo->get_sd_detail($order,$request);
        echo json_encode($get_data);
    }
    
    public function get_weight_trunk(){
        $order = $this->input->post('orden');
        $request = $this->input->post('solicitud');
        $get_order_request = $this->M_Monitoreo->get_orders_request($request);
        foreach ($get_order_request as $value) {
            $data_trunk = $this->M_Monitoreo->get_weight_trunk($value->order,$request);
            foreach ($data_trunk as $valuet) {
                $get_trunk[] = $valuet;
            }
            $data_detail = $this->M_Monitoreo->get_detail($value->order,$request);
            foreach ($data_detail as $valued) {
                $get_detail[] = $valued;
            }
        }
        $get_data_trunk = $this->M_Monitoreo->get_data_trunk($request);
        $array = array($get_trunk,$get_detail,$get_data_trunk);
        echo json_encode($array);
    }
}
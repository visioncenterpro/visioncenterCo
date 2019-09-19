<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Program extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        
        $this->load->model("Maintenance/Program/M_Program");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS,FULL_CALENDAR_CSS,DATEPICKER_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        $result = $this->M_Program->LoadMachineArea();
        $array = array();
        $arrayAreas = array();
        foreach ($result as $v) {
            if(!in_array($v->descarea, $arrayAreas)){
                $arrayAreas[] = $v->descarea;
            }
            $array[$v->descarea][] = array("id_machine"=>$v->id_machine,"description"=>$v->description);
        }
        $data['machines'] = $array;
        $data['area'] = $arrayAreas;
        $this->load->view('Maintenance/Program/V_Program',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS,MOMENT,FULL_CALENDAR_JS,DATEPICKER_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    
    function CreateMaintenancePreventive(){
        $result = $this->M_Program->CreateRequestPreventive();
        echo json_encode(array("res"=>$result));
    }
    
    function ListDayPreventiveMaintenance(){
        
        $resp = $this->M_Program->ListDayPreventiveMaintenance();
        $days = array();
        
        foreach ($resp as $v) :
            $this->delete = 0;
            switch ($v->status) {
                case 3: //delete
                    $this->Color = '#a8acaa'; //gray
                    break;
                case 7://start
                    $this->Color = '#00c0ef'; //info
                    break;
                case 8://end
                    $this->Color = '#00a65a'; //green
                    break;
                default:
                    $this->Color = '#0073b7'; //primary
                    $this->delete = 1;
                    break;
            }
            if($v->expiration == 1 && !in_array($v->status, array("3","8")) ){
                $this->Color = '#f56954'; //red
            }
            
            $days[] = array("title" => $v->description, "start" => $v->maintenance_date,"backgroundColor"=>$this->Color,"borderColor"=>$this->Color, "id" => $v->id_request_preventive, "day"=>"","delete"=>$this->delete);
        endforeach;

        echo json_encode($days);
    }

    function DeleteRequestCalendar(){
        $result = $this->M_Program->DeleteRequestCalendar();
        echo json_encode(array("res"=>$result));
    }
    
    function ListRequestAll(){
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
       
        $this->load->view('Template/V_Body');

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
}


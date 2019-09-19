<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Programming extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Absenteeism/Programming/M_Programming");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['seccion'] = $this->M_Programming->ListSeccionAll();
        $data['equipos'] = $this->M_Programming->ListTeamAll();
        $data['tiporoll'] = $this->M_Programming->ListTypeRollAll();
        $data['programacion'] = $this->M_Programming->ListProgrammmingAll();


        $data['table'] = $this->load->view('Absenteeism/Programming/V_Table_Programming', $data, true);
        $this->load->view('Absenteeism/Programming/V_Programming', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function DeleteProgramming() {
        $result = $this->M_Programming->DeleteProgramming();
        $table = "";
        if ($result == "OK") {
            $data['programacion'] = $this->M_Programming->ListProgrammmingAll();
            $table = $this->load->view('Absenteeism/Programming/V_Table_Programming', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function CreateUser() {
        $result = $this->M_Programming->CreateUser();
        $table = "";
        if ($result == "OK") {
            $data['programacion'] = $this->M_Programming->ListProgrammmingAll();
            $table = $this->load->view('Absenteeism/Programming/V_Table_Programming', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function Infoperson($id_users) {

        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['seccion'] = $this->M_Programming->ListSeccionAll();
        $data['equipos'] = $this->M_Programming->ListTeamAll();
        $data['tiporoll'] = $this->M_Programming->ListTypeRollAll();
        $data['turno'] = $this->M_Programming->ListworkshiftAll();
        $data['programacion'] = $this->M_Programming->ListProgrammming($id_users);
        $data['id_users'] = $id_users;

        $this->load->view('Absenteeism/Programming/V_Infoperson', $data);
        //$data['table'] = $this->load->view('Absenteeism/Programming/V_Table_Programming', $data, true);
        //$this->load->view('Absenteeism/Programming/V_Programming', $data);
        
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }
      function UpdatePerson() {
        $result = $this->M_Programming->UpdatePerson();
        echo json_encode(array("res" => $result));
    }

}

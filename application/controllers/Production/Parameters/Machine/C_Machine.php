<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Machine extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Production/Parameters/Machine/M_Machine");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['maquinas'] = $this->M_Machine->ListMachineAll();

        $this->load->view('Template/V_Body', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function ManageMachine() {
        $array['menus'] = $this->M_Main->ListMenu();
        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_RED);
        $this->load->view('Template/V_Header', $Header);
        $data['status'] = $this->M_Machine->ListStatusAll();
        $data['area'] = $this->M_Machine->ListAreaAll();
        $data['functions'] = $this->M_Machine->ListFunctionsMachine();
        $data['User_Machine'] = $this->M_Machine->ListUserMachine();
        
        $this->load->view('Production/Parameters/Machine/V_Create_Machines', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    public function ListMachine() {
        $array['menus'] = $this->M_Main->ListMenu();


        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        $data['status'] = $this->M_Machine->ListStatusAll();
        $data['area'] = $this->M_Machine->ListAreaAll();
        $data['machine'] = $this->M_Machine->ListMachineAll();

        foreach ($this->M_Machine->LoadButtonPermissions("Maquina") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $data['table'] = $this->load->view('Production/Parameters/Machine/V_Table_Machines', $data, true);
        $this->load->view('Production/Parameters/Machine/V_List_Machine', $data);
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function ListTypeDamageAll() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, DATATABLES_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['types'] = $this->M_Machine->ListTypeDamageAll();
        $data['status'] = $this->M_Machine->ListStatusAll();
        $data['table'] = $this->load->view('Production/Parameters/Machine/V_Table_Damage', $data, true);
        $this->load->view('Production/Parameters/Machine/V_List_Damage', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, DATATABLES_JS, DATATABLES_JS_B);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function UpdateTypeDamage() {
        $result = $this->M_Machine->UpdateTypeDamage();
        $table = "";
        if ($result == "OK") {
            $data['types'] = $this->M_Machine->ListTypeDamageAll();
            $table = $this->load->view('Production/Parameters/Machine/V_Table_Damage', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function CreateTypeDamage() {
        $result = $this->M_Machine->CreateTypeDamage();
        $table = "";
        if ($result == "OK") {
            $data['types'] = $this->M_Machine->ListTypeDamageAll();
            $table = $this->load->view('Production/Parameters/Machine/V_Table_Damage', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function DeleteTypeDamage() {
        $result = $this->M_Machine->DeleteTypeDamage();
        $table = "";
        if ($result == "OK") {
            $data['types'] = $this->M_Machine->ListTypeDamageAll();
            $table = $this->load->view('Production/Parameters/Machine/V_Table_Damage', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function CreateMachine() {
        $result = $this->M_Machine->CreateMachine();
        echo json_encode(array("res" => $result));
    }

    function DeleteMachine() {
        $result = $this->M_Machine->DeleteMachine();
        $table = "";
        if ($result == "OK") {
            foreach ($this->M_Machine->LoadButtonPermissions("Maquina") as $btn) {
                $data[$btn->name] = $btn->name;
            }
            $data['machine'] = $this->M_Machine->ListMachineAll();
            $table = $this->load->view('Production/Parameters/Machine/V_Table_Machines', $data, true);
        }
        echo json_encode(array("res" => $result, "tabla" => $table));
    }

    function UpdateMachine() {
        $result = $this->M_Machine->UpdateMachine();
        echo json_encode(array("res" => $result));
    }

    function InfoMachine($id) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);

        $data['status'] = $this->M_Machine->ListStatusAll();
        $data['area'] = $this->M_Machine->ListAreaAll();
        $data['machine'] = $this->M_Machine->ListMachineAll();
        $data['machine'] = $this->M_Machine->ListMachine($id);
        $data['functions'] = $this->M_Machine->ListFunctionsMachineAll($id);
        $data['User_Machine'] = $this->M_Machine->ListUserMachineAll($id);
        $data['id'] = $id;
        $this->load->view('Production/Parameters/Machine/V_Update_Machine', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $this->load->view('Template/V_Footer', $Footer);
    }

    function UpdateUserMachine() {
        $result = $this->M_Machine->UpdateUserMachine();
        echo json_encode(array("res" => $result));
    }

    function UpdateAuxMachine() {
        $result = $this->M_Machine->UpdateAuxMachine();
        echo json_encode(array("res" => $result));
    }

}

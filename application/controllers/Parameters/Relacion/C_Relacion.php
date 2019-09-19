<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Relacion extends Controller {

    public function __construct() {
    parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Relacion/M_Relacion");
    }
    
    public function index(){
        // carga el menu y el css
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);
        
        // carga la vista principal
        $data['relaciones'] = $this->M_Relacion->List_Rol_Menu();
        $data['list_menu'] = $this->M_Relacion->List_Menu();
        $data['list_rol']  = $this->M_Relacion->List_Rol();
        $data['table'] = $this->load->view('Parameters/Relacion/V_Table_Relacion',$data,true);
        $this->load->view('Parameters/Relacion/V_List_Relacion',$data);
        
        // carga el footer y los js
        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    public function create(){
        $menu = $this->input->post('menu');
        $rol = $this->input->post('rol');
        for($i = 0; $i < count($menu); $i++){
            $validate = $this->M_Relacion->get_relacion($menu[$i],$rol);
            if(count($validate) == 0){
                $insert = $this->M_Relacion->insert_relacion($menu[$i],$rol);
            }else{
                echo "ya existe";
            }
        }
    }
    
    public function getData(){
        $id_relacion = $this->input->post('id_relacion');
        $getData = $this->M_Relacion->get_roles_menu($id_relacion);
        echo json_encode($getData);
    }
    
    public function Update(){
        $id_relacion = $this->input->post('id_relacion');
        $menu = $this->input->post('menu');
        $rol = $this->input->post('rol');
        for($i = 0; $i < count($menu); $i++){
            $validate = $this->M_Relacion->get_relacion($menu[$i],$rol);
            if(count($validate) == 0){
                $update = $this->M_Relacion->Update_relacion($id_relacion,$menu[$i],$rol);
                echo 'update';
            }else{
                echo 'no hace falta';
            }
        }
    }
    
    public function Delete(){
        $id_relacion = $this->input->post('id_relacion');
        $delete = $this->M_Relacion->Delete_relacion($id_relacion);
        print_r($delete);
    }
   
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Import extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Imos/Acknow/M_Import");
    }

    public function index() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, TREE_CSS);
        $this->load->view('Template/V_Header', $Header);

        $recordDetail['tbody'] = array();
        $data['tabInfo'] = $this->load->view('Imos/Acknow/Tab/V_Tab_Info', null, true);
        $data['tabStyle'] = $this->load->view('Imos/Acknow/Tab/V_Tab_Style', null, true);
        $data['tabDetail'] = $this->load->view('Imos/Acknow/Tab/V_Tab_Detail', $recordDetail, true);

        $this->load->view('Imos/Acknow/V_Import', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, TREE_JS, TREE_JS2);
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function vali_saveack(){
        $arrayDetail = json_decode($_POST['detail']);
        $val_empty = 0;
        $array_exception = array(
            array('type' => '#N/A', 'description' => 'valor no disponible en la formula o función'),
            array('type' => '#¡NULO!', 'description' => 'rango en la funcion, incorrecto'),
            array('type' => '#¡VALOR!', 'description' => 'se espera tipo de datos diferente en la funcion'),
            array('type' => '#¡DIV/0!', 'description' => 'division entre 0'),
            array('type' => '#¡REF!', 'description' => 'celda no se encuentra'),
            array('type' => '#¿NOMBRE?', 'description' => 'nombre de formula no valido')
        );
        foreach ($arrayDetail as $value) {
            //echo $value[13];
            //for ($i = 0; $i <= count($arrayDetail); $i++){
                //if($value[10] == "" || $value[13] == "" || $value[14] == "" || $value[15] == ""){
                    foreach ($array_exception as $valueE) {
                        if($value[10] == $valueE['type'] || $value[13] == $valueE['type'] || $value[14] == $valueE['type'] || $value[15] == $valueE['type']){
                            $val_empty = 1;
                            break;
                        }
                    }
                //}
            //}
            //print_r($value);
        }
        //echo $val_empty;
        $vali_ack = $this->M_Import->get_ack($_POST['order']);
        if(count($vali_ack) > 0){
            echo json_encode(array('rs' => 'true', 'data' => $vali_ack, 'val_empty' => $val_empty));
        }else{
            echo json_encode(array('rs' => 'false', 'val_empty' => $val_empty));
        }
    }

    function SaveAck() {
        $result = $this->M_Import->SaveAck();
        $tabDetail = "";
        if ($result == "OK"):
            $recordDetail['tbody'] = array();
            $tabDetail = $this->load->view('Imos/Acknow/Tab/V_Tab_Detail', $recordDetail, true);
        endif;
        echo json_encode(array("res" => $result, "detail" => $tabDetail));
    }
    
    function UpdateAck() {
        $result = $this->M_Import->UpdateAck();
        $tabDetail = "";
        if ($result == "OK"):
            $recordDetail['tbody'] = array();
            $tabDetail = $this->load->view('Imos/Acknow/Tab/V_Tab_Detail', $recordDetail, true);
        endif;
        echo json_encode(array("res" => $result, "detail" => $tabDetail));
    }

    function Readfile($process = 4) {
        require_once(dirname(__FILE__) . '/../../../includes/phpexcel/Classes/PHPExcel.php');

        $folder = $this->input->post('folder');
        $dir = $this->input->post('dir');
       
        $error = "";
        
        $array = scandir($dir);
        for ($i = 0; $i < count($array); $i++) {
            $posName = strpos($array[$i], "Acknowledgment");
            $posFormat = strpos($array[$i], "xlsx");
            
            if ($posName !== false && $posFormat !== false) {
                $file = $dir . $array[$i];
                $error = "";
                break;
            }
            
        }
        

 
        if ($error == "" && isset($file)) {
            if (file_exists(NETWORK_UNIT_ACK)) {
                if (file_exists($file)) {

                    $Reader = PHPExcel_IOFactory::createReaderForFile($file);
                    $Reader->setReadDataOnly(true);
                    $objXLS = $Reader->load($file);
                    
                    $page = $objXLS->getSheetByName("FormatoACK");
                    $sheet1 = empty($page)?$objXLS->getSheetByName("Formato ACK"):$page;

                    $ResulParameters = $this->M_Import->ParametersFile($process);
                    $ResultCell = $this->M_Import->ConfigCell($process);
                    $ResultCellDet = $this->M_Import->ConfigCellDet($process);
                    
                    $info = array();
                    foreach ($ResultCell as $cell) {
                        
                        $code = trim($sheet1->getCell($cell->row)->getValue());
                        //print_r(trim($sheet1->getCell($cell->row)->getValue())." - ".$cell->row." / ");
                        if (strstr($code, '=') == true) { //validar si es formulado
                            $code = trim($sheet1->getCell($cell->row)->getOldCalculatedValue());
                            if ($code == "#N/A") {
                                //$error .= $cell->row .",";
                                //$detail[$cell->field] = "#N/A";
                            }
                        }
                        
                        if ($cell->type_field == 9) {
                            $timestamp = PHPExcel_Shared_Date::ExcelToPHP($code);
                            //$timestamp = PHPExcel_Style_NumberFormat::toFormattedString($code,PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                            //print_r($timestamp);
                            $info[$cell->field] = date("Y-m-d", $timestamp);
                        } else {
                            $info[$cell->field] = trim($code);
                        }
                    }
                    //exit;
                    $array_exception = array(
                        array('type' => '#N/A', 'description' => 'valor no disponible en la formula o función'),
                        array('type' => '#¡NULO!', 'description' => 'rango en la funcion, incorrecto'),
                        array('type' => '#¡VALOR!', 'description' => 'se espera tipo de datos diferente en la funcion'),
                        array('type' => '#¡DIV/0!', 'description' => 'division entre 0'),
                        array('type' => '#¡REF!', 'description' => 'celda no se encuentra'),
                        array('type' => '#¿NOMBRE?', 'description' => 'nombre de formula no valido'));
                    $recordDetail['tbody'] = array();
                    $star = $ResulParameters->second_table_start;
                    $keyValidateEnd = $ResulParameters->details_key;

                    $loop = true;
                    $item = 1;
                    while ($loop) {
                        $detail = array();
                        foreach ($ResultCellDet as $cell) {
                            if ($cell->type_field == 9) {
                                //$timestamp = PHPExcel_Style_NumberFormat::toFormattedString($sheet1->getCell($cell->row . $star)->getValue(),PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                                $timestamp = PHPExcel_Shared_Date::ExcelToPHP($sheet1->getCell($cell->row . $star)->getValue());
                                $detail[$cell->field] = date("Y-m-d", $timestamp);
                            } else {
                                
                                $code = trim($sheet1->getCell($cell->row . $star)->getValue());
                                $detail[$cell->field] = $code;
                                if (strstr($code, '=') == true) { //validar si es formulado
                                    $code = trim($sheet1->getCell($cell->row . $star)->getOldCalculatedValue());
                                    $detail[$cell->field] = $code;
                                    foreach ($array_exception as $valueE) {
                                        if($code == $valueE['type']){
                                            //print_r($code." - ".$valueE['type']);
                                            //$detail[$cell->field] = $valueE['description'];
                                            $detail[$cell->field] = $valueE['type'];
                                            break;
                                        }
                                    }
                                    
//                                    if ($code == "#N/A") {
//                                        $error .= $cell->row . $star . ",";
//                                        $detail[$cell->field] = "#N/A";
//                                    }
                                }
                                
                            }
                        }
                        $recordDetail['tbody'][] = $detail;
                        $star++;
                        $item++;
                        $loop = ($sheet1->getCell($keyValidateEnd . $star)->getValue() == '') ? false : true;
                    }
                    //exit;
                    $HtmlDetail = $this->load->view("Imos/Acknow/Tab/V_Tab_Detail", $recordDetail, true);

                    $array = Array('msg' => "OK", 'info' => $info, 'detail' => $HtmlDetail, 'item' => $item, 'error' => $error);
                } else {
                    $array = Array('msg' => "La order $folder no tienen el archivo Acknowledgment (xlsx)!");
                }
            } else {
                $array = Array('msg' => "La Unidad De Red (" . NETWORK_UNIT_ACK . ") No Esta Conectada, Comunicalo A Sistemas");
            }
        }else{
            $array = Array('msg' => "No Existe un Acknowledgment(xlsx) valido en esta ubicacion");
        }
        echo json_encode($array);
    }

}

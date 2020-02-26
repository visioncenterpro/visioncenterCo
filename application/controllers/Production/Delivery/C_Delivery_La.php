<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Delivery_La extends Controller {

    public function __construct() {
        parent::__construct();
        //$this->ValidateSession();
        $this->load->Model("Production/Delivery/M_Delivery");
    }

    function Enlist_Supplies() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['orders'] = $this->M_Delivery->get_orders_supplies();
        $this->load->view('Production/Delivery/Supplies/Enlist/V_Panel_Enlist',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function Enlist_Supplies_Pendings(){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['orders'] = $this->M_Delivery->get_orders_supplies();
        $this->load->view('Production/Delivery/Supplies/Enlist/V_Panel_Enlist_Pendings',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }
    
    function Enlist_Packets_Pending(){
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['orders'] = $this->M_Delivery->get_orders();
        $this->load->view('Production/Delivery/Supplies/Enlist/V_Panel_Enlist_Modulated_Pendings',$data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function Enlist_PackageSD() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS, ICHECK_CSS_BLUE);
        $this->load->view('Template/V_Header', $Header);
        
        $data['orders'] = $this->M_Delivery->get_orders();
        $this->load->view('Production/Delivery/PackageSD/Enlist/V_Panel_Enlist', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS, ICHECK_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function SearchOrder() {

        $rs = $this->M_Delivery->SearchOrderSupplies(true);

        if ($rs['res'] == "OK" && count($rs['record']) > 0) {
            $rs['packs'] = $this->M_Delivery->InfoPackSupplies_RE($this->input->post("order"));
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }

        echo json_encode($rs);
    }
    
    function SearchOrder2() {
        //$rs = $this->M_Delivery->SearchOrderSupplies(true);
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        $rs['record_deleted'] = $this->M_Delivery->searchOrderSupplies_deleted($this->input->post("order"));
        //if ($rs['res'] == "OK" && count($rs['record']) > 0) {
        if(count($rs['record'])>0){
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $rs['vali_pack'][] = $this->M_Delivery->get_items_supplies($this->input->post("order"),$value->id_order_package_supplies,$value->number_pack);
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table_deleted'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Deleted",$rs,true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        
        echo json_encode($rs);
    }
    
    function search_modulated_pending(){
        $rs['orders'] = $this->input->post('array_order');
        $rs['tabs'] = "";
        $rs['table'] = "";
        for($i = 0; $i < count($rs['orders']); $i++){
           $rs['order'] = $rs['orders'][$i];
           $rs['index'] = $i;
           $rs['order_validation'][] = $rs['orders'][$i];
           $rs['packets'] = $this->M_Delivery->LoadContentPendintOrderPack($rs['orders'][$i]);
           $rs['off'] = $this->M_Delivery->InfoPackSD($rs['orders'][$i]);
           $rs['data_order'] = $this->M_Delivery->data_order($rs['orders'][$i]);
           $rs['tabs'] .= $this->load->view("Production/Delivery/Supplies/Enlist/V_Tabs_Modulated_Pending", $rs, true);
           $rs['table'] .= $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Modulated_Pending", $rs, true);
        }
        
        echo json_encode($rs);
    }
    
    function search_supplies_pending(){
        $rs['orders'] = $this->input->post('array_order');
        $rs['tabs'] = "";
        $rs['table'] = "";
        for($i = 0; $i < count($rs['orders']); $i++){
            if(isset($array)){
                unset($array);
            }
            $rs['order'] = $rs['orders'][$i];
            $rs['order_validation'][] = $rs['orders'][$i];
            $rs['supplies'] = $this->M_Delivery->get_order_suppliesxorder($rs['orders'][$i]);
            $rs['record'] = $this->M_Delivery->searchOrderSuppliesPending($rs['orders'][$i]);
            $rs['data_order'] = $this->M_Delivery->data_order($rs['orders'][$i]);
            $data_packs = $this->M_Delivery->packs_quantity($rs['orders'][$i]);
            if(count($data_packs) > 0){
                foreach ($data_packs as $valuep) {
                    $rs['packs'] = $valuep->packs;
                }
            }else{
                $rs['packs'] = 0;
            }
            
            if(count($rs['supplies'])>0){
                $rs['res'] = "OK";
                $rs['rows'] = count($rs['record']);
                $rs['order'] = $rs['orders'][$i];
                //$rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack_Pending', $rs, true);
                $vali = [];
                foreach ($rs['record'] as $value) {
                    $vali['id_supplies'][] = $value->id_supplies;
                    $vali['quantity_packaged'][] = $value->quantity_packaged;
                }
                //print_r($vali);
                $count = 0;
                foreach ($rs['supplies'] as $key => $value) {
                    //echo $value->id_supplies."--".$vali['id_supplies'][$count];
                    if(isset($vali['quantity_packaged'][$count]) && $vali['quantity_packaged'][$count] == $value->quantity && $vali['id_supplies'][$count] == $value->id_supplies){
                        $array['quantity_packaged'][] = $vali['quantity_packaged'][$count];
                        $array['quantity_pending'][] = $value->quantity - $vali['quantity_packaged'][$count];
                        $count++;
                    }else{
                        $array['code'][] = $value->code;
                        $array['name'][] = $value->name;
                        if(isset($vali['quantity_packaged'][$count]) && $vali['id_supplies'][$count] == $value->id_supplies){
                            //echo $vali['id_supplies'][$count]." - ". $value->id_supplies."<br>";
                            $array['quantity_packaged'][] = $vali['quantity_packaged'][$count];
                            $array['quantity_pending'][] = $value->quantity - $vali['quantity_packaged'][$count];
                            $count++;
                        }else{
                            $array['quantity_packaged'][] = 0;
                            $array['quantity_pending'][] = $value->quantity;
                        }
                    }
                }
                $rs['data'] = $array;
                $rs['index'] = $i;
                $rs['tabs'] .= $this->load->view("Production/Delivery/Supplies/Enlist/V_Tabs_Supplies_Pending", $rs, true);
                $rs['table'] .= $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies_Pending", $rs, true);
            }
        }
        
        echo json_encode($rs);
    }
    
    function Pending_Report($order){
        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $data['content'] = $this->M_Delivery->LoadContentPendintOrderPack($order);
        $this->load->view("Production/Delivery/pdf/V_Content_Detail_Pack", $data);
    }
    
    function excel_one(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte Insumo Pendientes');
        
        // HEADER
        $gdImage = imagecreatefromjpeg(URL_IMAGE.$this->session->company);
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(50);
        $objDrawing->setWidth(110);
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        $objDrawing->setCoordinates('A1');
        $this->excel->getActiveSheet()->mergeCells('A1:B3');
        
        $this->excel->getActiveSheet()->setCellValue('C1', 'Reporte Insumo Pendientes');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('C1:F1');
        $this->excel->getActiveSheet()->getStyle('C1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha de reporte: '.date("Y-m-d"));
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('D2:F2');
        $this->excel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('D3', 'Versión: 01');
        $this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('D3:F3');
        $this->excel->getActiveSheet()->getStyle('D3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle("A1:F3")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000')
                    )
                )
            )
        );
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        // TITLE
        $this->excel->getActiveSheet()->setCellValue('A5', 'Order');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Codigo');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Descripción');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Cantidad');
        $this->excel->getActiveSheet()->setCellValue('E5', 'Entregado');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Saldo');
        
        // DATA
        //$array_order = array('20216','20223','20227');
        $array_order = $this->input->post('order');
        $count_cell = 6;
        for($i = 0; $i < 2; $i++){
            if(isset($array)){
                unset($array);
            }
            $rs['supplies'] = $this->M_Delivery->get_order_suppliesxorder($array_order);
            $rs['record'] = $this->M_Delivery->searchOrderSuppliesPending($array_order);
            $rs['data_order'] = $this->M_Delivery->data_order($array_order);
            $data_packs = $this->M_Delivery->packs_quantity($array_order);
            if(count($data_packs) > 0){
                foreach ($data_packs as $valuep) {
                    $rs['packs'] = $valuep->packs;
                }
            }else{
                $rs['packs'] = 0;
            }
            
            if(count($rs['supplies'])>0){
                //$rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack_Pending', $rs, true);
                $vali = [];
                foreach ($rs['record'] as $value) {
                    $vali['id_supplies'][] = $value->id_supplies;
                    $vali['quantity_packaged'][] = $value->quantity_packaged;
                }
                //print_r($vali);
                $count = 0;
                
                foreach ($rs['supplies'] as $key => $value) {
                    $this->excel->getActiveSheet()->setCellValue('A'.$count_cell, $array_order);
                    $this->excel->getActiveSheet()->setCellValue('B'.$count_cell, $value->code);
                    $this->excel->getActiveSheet()->setCellValue('C'.$count_cell,$value->name);
                    $this->excel->getActiveSheet()->setCellValue('D'.$count_cell,$value->quantity);
                    
                    if(isset($vali['quantity_packaged'][$count]) && $vali['quantity_packaged'][$count] == $value->quantity && $vali['id_supplies'][$count] == $value->id_supplies){
                        
                        $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $vali['quantity_packaged'][$count]);
                        $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity - $vali['quantity_packaged'][$count]);
                        $count++;
                    }else{
                        $array['code'][] = $value->code;
                        $array['name'][] = $value->name;
                        
                        if(isset($vali['quantity_packaged'][$count]) && $vali['id_supplies'][$count] == $value->id_supplies){
                            $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $vali['quantity_packaged'][$count]);
                            $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity - $vali['quantity_packaged'][$count]);
                            $count++;
                        }else{
                            $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, 0);
                            $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity);
                        }
                    }
                    
                    $count_cell++;
                }
            }
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteInsumosPendientes.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $opResult = array(
            'status' => 1,
            'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );
        echo json_encode($opResult);
    }
    
    function excel_one_m(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte Insumo Pendientes');
        
        // HEADER
        $gdImage = imagecreatefromjpeg(URL_IMAGE.$this->session->company);
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(50);
        $objDrawing->setWidth(110);
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        $objDrawing->setCoordinates('A1');
        $this->excel->getActiveSheet()->mergeCells('A1:B3');
        
        $this->excel->getActiveSheet()->setCellValue('C1', 'Reporte Modulados Pendientes');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('C1:G1');
        $this->excel->getActiveSheet()->getStyle('C1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('C2', 'Fecha de reporte: '.date("Y-m-d"));
        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('C2:G2');
        $this->excel->getActiveSheet()->getStyle('C2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('C3', 'Versión: 01');
        $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('C3:G3');
        $this->excel->getActiveSheet()->getStyle('C3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle("A1:G3")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000')
                    )
                )
            )
        );
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        // TITLE
        $this->excel->getActiveSheet()->setCellValue('A5', 'Order');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Item');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Descripción');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Pack');
        $this->excel->getActiveSheet()->setCellValue('E5', 'Cantidad total');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Cantidad empacada');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Total pendiente');
        
        // DATA
        $array_order = $this->input->post('order');
        $count_cell = 6;

        $data = $this->M_Delivery->LoadContentPendintOrderPack($array_order);
        foreach ($data as $value) {
            $this->excel->getActiveSheet()->setCellValue('A'.$count_cell, $array_order);
            $this->excel->getActiveSheet()->setCellValue('B'.$count_cell, $value->item);
            $this->excel->getActiveSheet()->setCellValue('C'.$count_cell, $value->description);
            $this->excel->getActiveSheet()->setCellValue('D'.$count_cell, $value->number_pack."".$value->code);
            $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $value->quantity_packets);
            $this->excel->getActiveSheet()->setCellValue('F'.$count_cell, $value->delivered_quantity);
            $this->excel->getActiveSheet()->setCellValue('G'.$count_cell, $value->quantity_packets - $value->delivered_quantity);
            $count_cell++;
        }
        
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteModuladosPendientes.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $opResult = array(
            'status' => 1,
            'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );
        echo json_encode($opResult);
    }
    
    function excel_m(){
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte Insumo Pendientes');
        
        // HEADER
        $gdImage = imagecreatefromjpeg(URL_IMAGE.$this->session->company);
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(50);
        $objDrawing->setWidth(110);
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        $objDrawing->setCoordinates('A1');
        $this->excel->getActiveSheet()->mergeCells('A1:B3');
        
        $this->excel->getActiveSheet()->setCellValue('C1', 'Reporte Modulados Pendientes');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('C1:G1');
        $this->excel->getActiveSheet()->getStyle('C1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('C2', 'Fecha de reporte: '.date("Y-m-d"));
        $this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('C2:G2');
        $this->excel->getActiveSheet()->getStyle('C2:G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('C3', 'Versión: 01');
        $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('C3:G3');
        $this->excel->getActiveSheet()->getStyle('C3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle("A1:G3")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000')
                    )
                )
            )
        );
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        // TITLE
        $this->excel->getActiveSheet()->setCellValue('A5', 'Order');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Item');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Descripción');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Pack');
        $this->excel->getActiveSheet()->setCellValue('E5', 'Cantidad total');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Cantidad empacada');
        $this->excel->getActiveSheet()->setCellValue('G5', 'Total pendiente');
        
        // DATA
        $array_order = $this->input->post('array_order');
        $count_cell = 6;
        for($i = 0; $i < count($array_order); $i++){
            $data = $this->M_Delivery->LoadContentPendintOrderPack($array_order[$i]);
            foreach ($data as $value) {
                $this->excel->getActiveSheet()->setCellValue('A'.$count_cell, $array_order[$i]);
                $this->excel->getActiveSheet()->setCellValue('B'.$count_cell, $value->item);
                $this->excel->getActiveSheet()->setCellValue('C'.$count_cell, $value->description);
                $this->excel->getActiveSheet()->setCellValue('D'.$count_cell, $value->number_pack."".$value->code);
                $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $value->quantity_packets);
                $this->excel->getActiveSheet()->setCellValue('F'.$count_cell, $value->delivered_quantity);
                $this->excel->getActiveSheet()->setCellValue('G'.$count_cell, $value->quantity_packets - $value->delivered_quantity);
                $count_cell++;
            }
        }
        
        
        $sheet = $this->excel->getActiveSheet();
        
        // Add new sheet 
        $objWorkSheet = $this->excel->createSheet(1); //Setting index when creating
        
        //Write cells
        $objWorkSheet->setCellValue('A1', 'ITEM')
           ->setCellValue('B1', 'DESCRIPCIÓN')
           ->setCellValue('C1', 'PACK')
           ->setCellValue('D1', 'CANTIDAD')     
           ->setCellValue('E1', 'CANTIDAD EMPACADA')
           ->setCellValue('F1', 'SALDO');

        // Rename sheet 
        
        
        $delimiter = implode(",", $array_order);
        $dt = $this->M_Delivery->data_order_package($delimiter);
        $array_supplies = "";
        foreach ($dt as $value) {
            $array_supplies['id_supplies'][] = $value->id_supplies;
            $array_supplies['total_s'][] = $value->total;
        }
        $dt2 = $this->M_Delivery->data_order_supplies2($delimiter);
        $count = 2;
        $count2 = 0;
        foreach ($dt2 as $key => $value2) {
            //Write cells
            $d = 0;
            $e = $value2->total;
            for($i = 0; $i < count($array_supplies['id_supplies']); $i++){
                if($array_supplies['id_supplies'][$i] == $value2->id_supplies){
                    $d = $array_supplies['total_s'][$i];
                    $e = $value2->total - $array_supplies['total_s'][$i];
                }
            }
            $objWorkSheet->setCellValue('A'.$count, $value2->code)
               ->setCellValue('B'.$count, $value2->name)
               ->setCellValue('C'.$count, $value2->total)
               
               //
               ->setCellValue('D'.$count, $d)
               ->setCellValue('E'.$count, $e);

            // Rename sheet 
            $count++;
        }
        $objWorkSheet->setTitle("Relación");
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet2 = $this->excel->getActiveSheet();
            $cellIterator = $sheet2->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet2->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteModuladosPendientes.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $opResult = array(
            'status' => 1,
            'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );
        echo json_encode($opResult);
    }
    
    function excel(){
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte Insumo Pendientes');
        
        // HEADER
        $gdImage = imagecreatefromjpeg(URL_IMAGE.$this->session->company);
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(50);
        $objDrawing->setWidth(110);
        $objDrawing->setWorksheet($this->excel->getActiveSheet());
        $objDrawing->setCoordinates('A1');
        $this->excel->getActiveSheet()->mergeCells('A1:B3');
        
        $this->excel->getActiveSheet()->setCellValue('C1', 'Reporte Insumo Pendientes');
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('C1:F1');
        $this->excel->getActiveSheet()->getStyle('C1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('D2', 'Fecha de reporte: '.date("Y-m-d"));
        $this->excel->getActiveSheet()->getStyle('D2')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('D2:F2');
        $this->excel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValue('D3', 'Versión: 01');
        $this->excel->getActiveSheet()->getStyle('D3')->getFont()->setSize(9);
        $this->excel->getActiveSheet()->mergeCells('D3:F3');
        $this->excel->getActiveSheet()->getStyle('D3:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->getStyle("A1:F3")->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000')
                    )
                )
            )
        );
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet = $this->excel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        // TITLE
        $this->excel->getActiveSheet()->setCellValue('A5', 'Order');
        $this->excel->getActiveSheet()->setCellValue('B5', 'Codigo');
        $this->excel->getActiveSheet()->setCellValue('C5', 'Descripción');
        $this->excel->getActiveSheet()->setCellValue('D5', 'Cantidad');
        $this->excel->getActiveSheet()->setCellValue('E5', 'Entregado');
        $this->excel->getActiveSheet()->setCellValue('F5', 'Saldo');
        
        // DATA
        //$array_order = array('20216','20223','20227');
        $array_order = $this->input->post('array_order');
        $count_cell = 6;
        for($i = 0; $i < count($array_order); $i++){
            if(isset($array)){
                unset($array);
            }
            $rs['supplies'] = $this->M_Delivery->get_order_suppliesxorder($array_order[$i]);
            $rs['record'] = $this->M_Delivery->searchOrderSuppliesPending($array_order[$i]);
            $rs['data_order'] = $this->M_Delivery->data_order($array_order[$i]);
            $data_packs = $this->M_Delivery->packs_quantity($array_order[$i]);
            if(count($data_packs) > 0){
                foreach ($data_packs as $valuep) {
                    $rs['packs'] = $valuep->packs;
                }
            }else{
                $rs['packs'] = 0;
            }
            
            if(count($rs['supplies'])>0){
                //$rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack_Pending', $rs, true);
                $vali = [];
                foreach ($rs['record'] as $value) {
                    $vali['id_supplies'][] = $value->id_supplies;
                    $vali['quantity_packaged'][] = $value->quantity_packaged;
                }
                //print_r($vali);
                $count = 0;
                
                foreach ($rs['supplies'] as $key => $value) {
                    $this->excel->getActiveSheet()->setCellValue('A'.$count_cell, $array_order[$i]);
                    $this->excel->getActiveSheet()->setCellValue('B'.$count_cell, $value->code);
                    $this->excel->getActiveSheet()->setCellValue('C'.$count_cell,$value->name);
                    $this->excel->getActiveSheet()->setCellValue('D'.$count_cell,$value->quantity);
                    
                    if(isset($vali['quantity_packaged'][$count]) && $vali['quantity_packaged'][$count] == $value->quantity && $vali['id_supplies'][$count] == $value->id_supplies){
                        
                        $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $vali['quantity_packaged'][$count]);
                        $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity - $vali['quantity_packaged'][$count]);
                        $count++;
                    }else{
                        $array['code'][] = $value->code;
                        $array['name'][] = $value->name;
                        
                        if(isset($vali['quantity_packaged'][$count]) && $vali['id_supplies'][$count] == $value->id_supplies){
                            
                            $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, $vali['quantity_packaged'][$count]);
                            $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity - $vali['quantity_packaged'][$count]);
                            $count++;
                        }else{
                            
                            $this->excel->getActiveSheet()->setCellValue('E'.$count_cell, 0);
                            $this->excel->getActiveSheet()->setCellValue('F'.$count_cell,$value->quantity);
                        }
                    }
                    
                    $count_cell++;
                }
            }
        }
        
        
        $sheet = $this->excel->getActiveSheet();
        
        // Add new sheet 
        $objWorkSheet = $this->excel->createSheet(1); //Setting index when creating
        
        //Write cells
        $objWorkSheet->setCellValue('A1', 'CODE')
           ->setCellValue('B1', 'NOMBRE')
           ->setCellValue('C1', 'CANTIDAD TOTAL')
           ->setCellValue('D1', 'CANTIDAD EMPACADA')
           ->setCellValue('E1', 'SALDO');

        // Rename sheet 
        
        
        $delimiter = implode(",", $array_order);
        $dt = $this->M_Delivery->data_order_supplies($delimiter);
        $array_supplies = "";
        foreach ($dt as $value) {
            $array_supplies['id_supplies'][] = $value->id_supplies;
            $array_supplies['total_s'][] = $value->total;
        }
        $dt2 = $this->M_Delivery->data_order_supplies2($delimiter);
        $count = 2;
        $count2 = 0;
        foreach ($dt2 as $key => $value2) {
            //Write cells
            $d = 0;
            $e = $value2->total;
            for($i = 0; $i < count($array_supplies['id_supplies']); $i++){
                if($array_supplies['id_supplies'][$i] == $value2->id_supplies){
                    $d = $array_supplies['total_s'][$i];
                    $e = $value2->total - $array_supplies['total_s'][$i];
                }
            }
            $objWorkSheet->setCellValue('A'.$count, $value2->code)
               ->setCellValue('B'.$count, $value2->name)
               ->setCellValue('C'.$count, $value2->total)
               
               //
               ->setCellValue('D'.$count, $d)
               ->setCellValue('E'.$count, $e);

            // Rename sheet 
            $count++;
        }
        $objWorkSheet->setTitle("Relación");
        
        // Auto size
        foreach ($this->excel->getWorksheetIterator() as $worksheet) {

            $this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));

            $sheet2 = $this->excel->getActiveSheet();
            $cellIterator = $sheet2->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            /** @var PHPExcel_Cell $cell */
            foreach ($cellIterator as $cell) {
                $sheet2->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ReporteInsumosPendientes.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        ob_end_clean();

        $opResult = array(
            'status' => 1,
            'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
        );
        echo json_encode($opResult);
        //$objWriter->save('php://output');
    }
    
    function Pending_Report_Supplies($order){

        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $this->load->view("Production/Delivery/pdf/V_Head_Detail_Pack_Supplies_Pending", $data);
        
        $data['content'] = $this->M_Delivery->LoadContentPendintOrder($order);
        foreach ($data['content'] as $valuec) {
            $data['id_supplies'][] = $valuec->id_supplies;
            $data['total'][] = $valuec->total;
        }
        $data['order_supplies'] = $this->M_Delivery->get_order_suppliesxorder($order);
        foreach ($data['order_supplies'] as $key => $value) {
            if(isset($data['id_supplies'][$key]) && $data['id_supplies'][$key] == $value->id_supplies && $data['total'][$key] == $value->quantity){
                
            }else{
                $packed = $this->M_Delivery->get_quantity_packaged($order,$value->id_order_supplies);
                if(count($packed) > 0){
                    $countp = 0;
                    foreach ($packed as $valuep) {
                        $countp = $countp + $valuep->quantity_packaged;
                    }
                    $data['packed'] = $countp;
                }else{
                    $data['packed'] = 0;
                }
                $array['val'] = $value;
                $array['packed'] = $data['packed'];
                $data['content'] = $this->load->view("Production/Delivery/pdf/V_Content_Detail_Pack_Supplies_Pending", $array,true);
                $this->load->view("Production/Delivery/pdf/V_Content_Detail_Pack_Supplies_Pending2", $data);
            }
        }
        
    }

    function get_data_add(){
        $order = $this->input->post('order');
        $vali_number = $this->M_Delivery->get_number_pack_order($order);
        if(count($vali_number) > 0){
            $data['number'] = $vali_number;
            $data['res_number'] = true;
        }else{
            $data['number'] = 1;
            $data['res_number'] = false;
        }
        $data['supplies'] = $this->M_Delivery->get_data_manual($order);
        foreach ($data['supplies'] as $key => $value) {
            //echo $value->id_order_supplies.'  ';
            $res = $this->M_Delivery->get_supplies_detail_modal($value->id_order_supplies);
            if(count($res)>0){
                foreach ($res as $value) {
                    $data['quantity_packaged'][] = $value->quantity_packaged;
                } 
            }else{
                $data['quantity_packaged'][] = 0;
            }
        }
        $data['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
        $data['iss'] = 0;
        foreach ($data['packs'] as $value) {
            $data['vali_pack'][] = $this->M_Delivery->get_items_supplies($this->input->post("order"),$value->id_order_package_supplies,$value->number_pack);
            for($i = 0; $i < count($data['vali_pack']); $i++){
                if($data['vali_pack'][$i]->total_pack == 0){
                    $data['iss'] = 1;
                    break;
                }
            }
        }
        $data['empty_p'] = $this->M_Delivery->get_empty_packs($this->input->post("order"));
        $data['order'] = $order;
        $data['number_pack'] = $this->input->post('number_pack');
        $data['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_add',$data, true);
        echo json_encode($data);
    }
    
    function get_data_manual(){
        $order = $this->input->post('order');
        $vali_number = $this->M_Delivery->get_number_pack_order($order);
        if(count($vali_number) > 0){
            $data['number'] = $vali_number;
            $data['res_number'] = true;
        }else{
            $data['number'] = 1;
            $data['res_number'] = false;
        }
        $data['supplies'] = $this->M_Delivery->get_data_manual($order);
        foreach ($data['supplies'] as $key => $value) {
            //echo $value->id_order_supplies.'  ';
            $res = $this->M_Delivery->get_supplies_detail_modal($value->id_order_supplies);
            if(count($res)>0){
                foreach ($res as $value) {
                    $data['quantity_packaged'][] = $value->quantity_packaged;
                } 
            }else{
                $data['quantity_packaged'][] = 0;
            }
        }
        $data['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
        $data['iss'] = 0;
        foreach ($data['packs'] as $value) {
            $data['vali_pack'][] = $this->M_Delivery->get_items_supplies($this->input->post("order"),$value->id_order_package_supplies,$value->number_pack);
            for($i = 0; $i < count($data['vali_pack']); $i++){
                if($data['vali_pack'][$i]->total_pack == 0){
                    $data['iss'] = 1;
                    break;
                }
            }
        }
        $data['empty_p'] = $this->M_Delivery->get_empty_packs($this->input->post("order"));
        $data['order'] = $order;
        $data['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Manual',$data, true);
        echo json_encode($data);
    }

    function data_new_item(){
        $data['order'] = $this->input->post('order');
        $data['unity'] = $this->M_Delivery->get_unity();
        $data['type_supplies'] = $this->M_Delivery->get_type_supplies();
        $data['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_New_Item',$data, true);
        echo json_encode($data);
    }

    function get_data_add_to_order(){
        $data['order'] = $this->input->post('order');
        $data['supplies_all'] = $this->M_Delivery->data_supplies_all();
        $data['supplies'] = $this->M_Delivery->get_data_manual($this->input->post('order'));
        $data['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_To_Order',$data, true);
        echo json_encode($data);
    }

    function Add_new_to_order(){
        $vali = $this->Vali_AX_Supplies($this->input->post('id_supplies'));
        if(count($vali) > 0){
            $vali2 = $this->M_Delivery->data_suppliesxSupplies($this->input->post('id_supplies'));
            if(count($vali2)>0){
                $data['vali'] = "error";
            }else{
                $data = $this->M_Delivery->Add_new_to_order();
            }
        }else{
            $data = array("res" => "error_vali");
        }
        echo json_encode($data);
    }

    function Replace_to_order(){
        $vali = $this->Vali_AX_Supplies($this->input->post('supplies'));
        if(count($vali) > 0){
            $vali2 = $this->M_Delivery->data_suppliesxSupplies($this->input->post('supplies'));
            if(count($vali2)>0){
                $data['vali'] = "error";
            }else{
                $data = $this->M_Delivery->Replace_to_order();
            }
        }else{
            $data = array("res" => "error_vali");
        }
        echo json_encode($data);
    }

    function Detail_replaced(){
        $order_supplies = $this->M_Delivery->get_order_supplies();
        foreach ($order_supplies as $key => $value){
            $data['old'] = $this->M_Delivery->Detail_replaced($value->replaced_supplies);
            $data['new'] = $this->M_Delivery->Detail_replaced($this->input->post('id_order_supplies'));
        }
        $data['content'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Detail_Replaced',$data, true);
        echo json_encode($data);
    }

    function Delete_to_order(){
        $data = $this->M_Delivery->Delete_to_order();
        echo json_encode($data);
    }

    function save_new_item(){
        $vali_ini = $this->M_Delivery->GetReference($this->input->post('code'));
        if(count($vali_ini) == 0){
            $data['vali'] = "error_vali";
        }else{
            $vali = $this->M_Delivery->get_suppliesXcode();
            if(count($vali) > 0){
                $data['vali'] = "error";
            }else{
                $data['vali'] = "ok";
                $data['data'] = $this->M_Delivery->save_new_item();
            }
        }
        echo json_encode($data);
    }

    function Vali_AX_Supplies($id_supplies){
        $vali = array();
        $data = $this->M_Delivery->get_suppliesXid($id_supplies);
        foreach ($data as $key => $value) {
            $vali = $this->M_Delivery->GetReference($value->code);
        }
        return $vali;
    }

    function data_synchronize(){
        $data['order'] = $this->input->post('order');
        $data['content'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Content_Synchronize',$data, true);
        echo json_encode($data);
    }

    function synchronize_items_ax(){
        $data = $this->M_Delivery->GetReferenceType($this->input->post('date'),$this->input->post('date2'));
        foreach($data as $key => $value){
            $supplies = $this->M_Delivery->get_suppliesXcodeParam($value->Referencia);
            if(count($supplies) == 0){
                $unity = $this->M_Delivery->get_unitxDes($value->BOMUNITID);
                if(count($unity) == 0){
                    $id_unit = 16;
                }else{
                    $id_unit = $unity->id_unit;
                }
                $data['insert'][] = $this->M_Delivery->save_supplies($value,$id_unit);
            }
        }
        echo json_encode($data);
    }
    
    function pb(){
        //echo phpinfo(); 
        echo isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
    }
    
    function get_data_edit(){
        $rs['supplies'] = $this->M_Delivery->get_data_edit();
        $rs['header'] = $this->M_Delivery->get_data_header();
        $validation = $this->M_Delivery->get_data_manual($this->input->post('order'));
        foreach ($validation as $key => $value) {
            $rs['weight_per_supplies'][] = $value->weight_per_supplies;
            $res = $this->M_Delivery->get_supplies_detail2($this->input->post('id_order_package_supplies'),$value->id_order_supplies,0,$this->input->post('order'));
            $val = 0;
            $res2 = $this->M_Delivery->get_supplies_detail21($this->input->post('id_order_package_supplies'),$value->id_order_supplies,0,$this->input->post('order'));
            if(count($res)>0){
                $count_total = 0;
                foreach ($res as $value) {
                    
                    if($this->input->post('id_order_package_supplies') == $value->access_order_package_supplies){
                        $val = 1;
                        $rs['quantity_packaged'][] = $value->quantity_packaged;
                    }
                }
                foreach ($res2 as $value21) {
                    $count_total = $count_total + $value21->quantity_packaged;
                }
                //echo $count_total."---";
                if(isset($val) && $val == 1){
                    $rs['quantity_total'][] = $count_total;
                }
            }else{
                //$rs['quantity_packaged'][] = "no hay datos";
            }
        }
        //print_r($rs['quantity_packaged']);
        $rs['type'] = $this->input->post('type');
        $rs['order'] = $this->input->post('order');
        $rs['number_pack'] = $this->input->post('number_pack');
        
        $rs['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Edit_Manual',$rs, true);
        
        echo json_encode($rs);
    }
    
    function validation_header(){
        echo json_encode($this->M_Delivery->update_header());
    }
    function validation_header_RE(){
        $rs['update'] = $this->M_Delivery->update_h();
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $var = $this->input->post('positionpb');
            $rs['pos'] = 0;
            if(isset($var)){
                $rs['pos'] = $this->input->post('positionpb');
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        echo json_encode($rs);
    }
    
    function Update_Packed(){
        if (in_array("0", $this->input->post('array_quantity_edit'))){
            $update_header = $this->M_Delivery->update_header2();
        }else{
            $update_header = $this->M_Delivery->update_header();
        }
        $get_id = $this->M_Delivery->get_package_supplies_pack();
        foreach ($get_id as $key => $value) {
            $id = $value->id_order_package_supplies;
        }
        $pack_total = $this->input->post('pack_total');
        $array_order_supplies = $this->input->post('array_order_supplies');
        $array_id_supplies = $this->input->post('array_id_supplies');
        $rs = array();
        $array_check = $this->input->post('array_check');
        $array_quantity_edit = $this->input->post('array_quantity_edit');
        for ($i = 0; $i < count($pack_total); $i++){
            if($array_check[$i] == "true"){
                //echo '-g-';
                $rs['sum'][] = $this->M_Delivery->Update_Packed_Detail($id,$array_order_supplies[$i],$array_id_supplies[$i],$pack_total[$i],$array_quantity_edit[$i]);
                $rs['data2'][] = $this->M_Delivery->get_supplies_detail_sum($array_order_supplies[$i]);
                $pb = $this->M_Delivery->get_supplies_detail2($id,$array_order_supplies[$i],$this->input->post('number_pack'),$this->input->post('order'));
                if(count($pb) > 0){
                    $rs['data'][] = $pb;
                }else{
                    $rs['data'][] = array(array('quantity_packaged' => 0));
                }
                //$rs['data'][] = $this->M_Delivery->get_supplies_detail2($id,$array_order_supplies[$i],$this->input->post('number_pack'),$this->input->post('order'));
            }else{
                $rs['data'][] = array(array('quantity_packaged' => 0));
            }
        }
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        $this->M_Delivery->data_dis_table($this->input->post("order"));
        echo json_encode($rs);
    }
    
    function Add_Packed(){
        $id = $this->M_Delivery->Add_Packed();
        $pack_total = $this->input->post('pack_total');
        $array_order_supplies = $this->input->post('array_order_supplies');
        $array_id_supplies = $this->input->post('array_id_supplies');
        $array_check = $this->input->post('array_check');
        for ($i = 0; $i < count($pack_total); $i++){
            if($array_check[$i] == "true"){
                $rs['sum'][] = $this->M_Delivery->Add_Packed_Detail($id,$array_order_supplies[$i],$array_id_supplies[$i],$pack_total[$i]);
                $res = $this->M_Delivery->get_supplies_detail3($id,$array_order_supplies[$i],$this->input->post('package_number'),$this->input->post('order'));
                if(count($res)>0){
                    $rs['data'][] = $res;
                }else{
                    $rs['data'][] = $this->M_Delivery->get_total_quantityxsupplies($array_order_supplies[$i],$this->input->post('order'));
                }
                
            }else{
                $rs['data'][] = array(array('quantity_packaged' => 0));
            }
        }
        $rs['total'][] = $this->M_Delivery->get_total_quantity_packet();
        
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        
        $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
        $rs['iss'] = 0;
        foreach ($rs['packs'] as $value) {
            $rs['vali_pack'][] = $this->M_Delivery->get_items_supplies($this->input->post("order"),$value->id_order_package_supplies,$value->number_pack);
            for($i = 0; $i < count($rs['vali_pack']); $i++){
                if($rs['vali_pack'][$i]->total_pack == 0){
                    $rs['iss'] = 1;
                    break;
                }
            }
        }
        echo json_encode($rs);
    }
    
    function Go_Back_Pack(){
        $rs['delete'] = $this->M_Delivery->delete_packed_detail();
        $rs['data'] = $this->M_Delivery->get_order_supplies();
        $rs['data2'] = $this->M_Delivery->get_supplies_detail_sum($this->input->post('id_order_supplies'));
        
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
            $rs['count'] = $this->input->post('count');
            $rs['pq'] = $this->M_Delivery->last_pack($this->input->post("order"));
        }
        echo json_encode($rs);
    }
    
    function Go_Back_Pack_Edit(){
        //$rs['edit'] = $this->M_Delivery->update_header();
        $rs['delete'] = $this->M_Delivery->delete_packed_detail();
        //$rs['update'] = $this->M_Delivery->update_h();
        $rs['data'] = $this->M_Delivery->get_order_supplies();
        $rs['data2'] = $this->M_Delivery->get_supplies_detail_sum($this->input->post('id_order_supplies'));
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $var = $this->input->post('positionpb');
            $rs['pos'] = 0;
            if(isset($var)){
                $rs['pos'] = $this->input->post('positionpb');
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        
        echo json_encode($rs);
    }
    
    function validation_supplies(){
        $this->M_Delivery->validation_supplies2($this->input->post('order'));
        $rs['dis_table'] = $this->M_Delivery->data_dis_table($this->input->post('order'));
        $rs['record'] = $this->M_Delivery->searchOrderSupplies2($this->input->post("order"));
        if(count($rs['record'])>0){
            $data_q = $this->M_Delivery->total_order_supplies($this->input->post("order"));
            $total = 0;
            foreach ($data_q as $valueq) {
                $total = $total + round($valueq->quantity);
            }
            foreach ($rs['record'] as $valuer) {
                $data2 = $this->M_Delivery->get_quantity_supplies($this->input->post("order"),$valuer->id_order_supplies,$valuer->id_supplies);
                $countr = 0;
                foreach ($data2 as $value2) {
                    $countr = $countr + $value2->quantity_packaged;
                }
                $rs['delivered'][] = $countr;
            }
            $rs['total_quantity'] = $total;
            $rs['res'] = "OK";
            $rs['rows'] = count($rs['record']);
            $rs['packs'] = $this->M_Delivery->get_order_package_supplies($this->input->post("order"));
            foreach ($rs['packs'] as $value) {
                $data = $this->M_Delivery->get_data_weight($this->input->post("order"),$value->id_order_package_supplies);
                $cont = 0;
                foreach ($data as $valued) {
                    $cont = $cont + $valued->total;
                }
                $rs['weight'][] = $cont;
            }
            $rs['order'] = $this->input->post('order');
            $rs['table_pack'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies", $rs, true);
        }
        echo json_encode($rs);
    }
    
    function PDF_supplies($order){
        $rs['supplies'] = $this->M_Delivery->get_supplies($order);
        $rs['details'] = $this->M_Delivery->SearchOrderSupplies2($order);
        $this->load->view('Production/Delivery/pdf/v_head_pdf_supplies',$rs);
    }

    function Report_Deleted($order){
        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $this->load->view("Production/Delivery/pdf/V_Head_Detail_Pack_Supplies_Deleted", $data);
        
        $data['content'] = $this->M_Delivery->LoadContentPendintOrder($order);
        foreach ($data['content'] as $valuec) {
            $data['id_supplies'][] = $valuec->id_supplies;
            $data['total'][] = $valuec->total;
        }
        $data['order_supplies'] = $this->M_Delivery->get_order_suppliesxorder2($order);
        $data['content'] = "";
        $data['rp'] = ""; //replaced
        $data['del'] = ""; //deleted
        foreach ($data['order_supplies'] as $key => $value) {
            if(isset($data['id_supplies'][$key]) && $data['id_supplies'][$key] == $value->id_supplies && $data['total'][$key] == $value->quantity){
                
            }else{
                $packed = $this->M_Delivery->get_quantity_packaged($order,$value->id_order_supplies);
                if(count($packed) > 0){
                    $countp = 0;
                    foreach ($packed as $valuep) {
                        $countp = $countp + $valuep->quantity_packaged;
                    }
                    $data['packed'] = $countp;
                }else{
                    $data['packed'] = 0;
                }
                if($value->replaced_supplies != 0 && $value->id_status == 2){
                    $old = $this->M_Delivery->data_suppliesxSuppliesParam($value->replaced_supplies,$value->order);  
                    if(isset($old->id_supplies)){
                        $code = $old->code;
                        $name = $old->name;
                        $quantity = $old->quantity;
                        $obs = $old->observation_replaced;
                    }else{
                        $code = "";
                        $name = "";
                        $quantity = "";
                        $obs = "";
                    }
                    $data['rp'] .= '<tr>
                                        <td>'.$value->code.'</td>
                                        <td>'.$value->name.'</td>
                                        <td style="text-align: center;">'.$value->quantity.'</td>
                                        <td>'.$code.'</td>
                                        <td>'.$name.'</td>
                                        <td style="text-align: center;">'.$quantity.'</td>
                                        <td style="text-align: center;">'.$obs.'</td>
                                    </tr>';
                }else{
                    if($value->replaced_supplies == 0 && $value->id_status == 2){
                        $data['del'] .= '<tr>
                                            <td>'.$value->code.'</td>
                                            <td>'.$value->name.'</td>
                                            <td style="text-align: center;">'.$value->quantity.'</td>
                                         </tr>';
                    }
                }
                
                $array['val'] = $value;
                $array['packed'] = $data['packed'];
                //$data['content'] .= $this->load->view("Production/Delivery/pdf/V_Content_Detail_Pack_Supplies_Deleted", $array,true);
            }
        }
        $this->load->view("Production/Delivery/pdf/V_Content_Detail_Pack_Supplies_Deleted", $data);
    }

    function SearchOrderPackSD() {

        $rs = $this->M_Delivery->SearchOrderPackSD();

        if ($rs['res'] == "OK" && count($rs['record']) > 0) {
            $rs['packs'] = $this->M_Delivery->InfoPackSD($this->input->post("order"));
            $rs['table_pack'] = $this->load->view('Production/Delivery/PackageSD/Enlist/V_Table_Pack', $rs, true);
            $rs['table'] = $this->load->view("Production/Delivery/PackageSD/Enlist/V_Table_Pieces", $rs, true);
        }

        echo json_encode($rs);
    }

    function UpdateOrderSupplies() {
        $rs = $this->M_Delivery->UpdateOrderSupplies();
        echo json_encode($rs);
    }

    function GenerateRangeTag() {
        $total_packs = $this->M_Delivery->CountPackSD();
        $table = "";
        if ($total_packs > 0) {
            $data['buttons'] = ceil($total_packs / MAX_NUM_PACK);
            $table = $this->load->view("Production/Delivery/PackageSD/Enlist/V_Relation_Pieces", $data, true);
            $res = "OK";
        } else {
            $res = "EL pedido no tiene paquetes generados";
        }

        echo json_encode(array("res" => $res, "table" => $table));
    }

    function GenerateRangeTag2() {
        $total_packs = $this->M_Delivery->CountPackSD();
        $table = "";
        if ($total_packs > 0) {
            $data['buttons'] = ceil($total_packs / MAX_NUM_PACK);
            $table = $this->load->view("Production/Delivery/PackageSD/Enlist/V_Relation_Pieces2", $data, true);
            $res = "OK";
        } else {
            $res = "EL pedido no tiene paquetes generados";
        }

        echo json_encode(array("res" => $res, "table" => $table));
    }

    function CalculateWeightPackSD() {
        $result = $this->M_Delivery->WeightForPackSD();

        $table = "";
        $rs['packs'] = "";
        if ($result == "OK") {
            $rs['packs'] = $this->M_Delivery->InfoPackSD($this->input->post("order"));
            $table = $this->load->view('Production/Delivery/PackageSD/Enlist/V_Table_Pack', $rs, true);
        }

        echo json_encode(array("res" => $result, "table" => $table, "data" => $rs['packs']));
    }

    function PrintPack($order, $min, $max) {
        $resulPack = $this->M_Delivery->LoadHeaderPack2($order, $min, $max);

        foreach ($resulPack as $r):
            $data = array(
                "ItemQr" => $r->id_order_package,
                "client" => $r->client,
                "project" => $r->project,
                "order" => $order,
                "type" => $r->type,
                "quantity_packets" => $r->quantity_total,
                "forniture" => $r->description,
                "start" => $r->number_pack,
                "pack" => $this->M_Delivery->MaxPack($order, $r->id_forniture, $r->type_package),
                "color" => $this->M_Delivery->Colorforniture($order, $r->id_forniture)
            );
            $data['new'] = true;
            $data["ticket"] = $r->number;
            $data["count"] = $r->quantity_total;
            $this->load->view("Dispatch/Pack/Pdf/V_Head_Detail_Pack", $data);

            if ($data['new']) {
                $data['new'] = false;
                $up = false;
                $resultDet = $this->M_Delivery->LoadDetailPack($r->id_order_package);

                $d['body'] = "";
                $total = 0;
                $t_weight = 0;
                foreach ($resultDet as $t) :
                    $w_unit = ($t->weight / $t->quantity) * $t->quantity_pieces;
                    $t_weight += $w_unit;
                    $desc = $t->code_sheet_ax;
                    $total += $t->quantity_pieces;
                    $d['body'] .= '<tr>
                                <td style="text-align: center">' . $t->piece . '</td>
                                <td>' . $t->description . '</td>
                                <td style="text-align: center">' . $t->caliber . '</td>
                                <td style="text-align:center">' . $t->long . '</td>
                                <td style="text-align:center">' . $t->width . '</td>
                                <td style="text-align:center">' . $t->quantity_pieces . '</td>
                                <td style="text-align:center">' . round($w_unit, 2) . '</td>
                                <td></td>
                                <td style="text-align:center">' . $t->l1 . '</td>
                                <td style="text-align:center">' . $t->l2 . '</td>
                                <td style="text-align:center">' . $t->a1 . '</td>
                                <td style="text-align:center">' . $t->a2 . '</td>
                            </tr>';
                endforeach;

                $d['body'] .= '<tr>
                            <td style="text-align: center" colspan="5">TOTAL CANTIDAD DE PIEZAS</td>
                            <td style="text-align: center">' . $total . '</td>
                            <td style="text-align: center">' . round($t_weight, 2) . '</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center" colspan="6">PESO INTEGRAL (' . (PORCENT_WEIGHT * 100) . '%)</td>
                            <td style="text-align: center">' . round($t_weight + ($t_weight * PORCENT_WEIGHT), 2) . '</td>
                            <td colspan="5"></td>
                        </tr>';
            }
            $this->load->view("Dispatch/Pack/Pdf/V_Body_Detail_Pack", $d);


        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack");
    }

    function GeneratePacksSD($order, $min, $max) {

        $resulPack = $this->M_Delivery->LoadHeaderPack($order);

        $total_tags = 1;
        foreach ($resulPack as $r):
            $up = true;

            $ticket = 1;
            $data = array(
                "ItemQr" => $r->id_order_package,
                "client" => $r->client,
                "project" => $r->project,
                "order" => $order,
                "type" => $r->type,
                "quantity_packets" => $r->quantity_packets,
                "forniture" => $r->description,
                "start" => $r->number_pack,
                "pack" => $this->M_Delivery->MaxPack($order, $r->id_forniture, $r->type_package),
                "color" => $this->M_Delivery->Colorforniture($order, $r->id_forniture)
            );

            $data['new'] = true;
            for ($i = 1; $i <= $r->quantity_packets; $i++) {

                if ($total_tags >= $min && $total_tags <= $max) {

                    $data["ticket"] = $ticket++;
                    $data["count"] = $total_tags;
                    $this->load->view("Dispatch/Pack/Pdf/V_Head_Detail_Pack", $data);

                    if ($data['new']) {
                        $data['new'] = false;
                        $up = false;
                        $resultDet = $this->M_Delivery->LoadDetailPack($r->id_order_package);

                        $d['body'] = "";
                        $total = 0;
                        $t_weight = 0;
                        foreach ($resultDet as $t) :
                            $w_unit = ($t->weight / $t->quantity) * $t->quantity_pieces;
                            $t_weight += $w_unit;
                            $desc = $t->code_sheet_ax;
                            $total += $t->quantity_pieces;
                            $d['body'] .= '<tr>
                                <td style="text-align: center">' . $t->piece . '</td>
                                <td>' . $t->description . '</td>
                                <td style="text-align: center">' . $t->caliber . '</td>
                                <td style="text-align:center">' . $t->long . '</td>
                                <td style="text-align:center">' . $t->width . '</td>
                                <td style="text-align:center">' . $t->quantity_pieces . '</td>
                                <td style="text-align:center">' . round($w_unit, 2) . '</td>
                                <td></td>
                                <td style="text-align:center">' . $t->l1 . '</td>
                                <td style="text-align:center">' . $t->l2 . '</td>
                                <td style="text-align:center">' . $t->a1 . '</td>
                                <td style="text-align:center">' . $t->a2 . '</td>
                            </tr>';
                        endforeach;

                        $d['body'] .= '<tr>
                            <td style="text-align: center" colspan="5">TOTAL CANTIDAD DE PIEZAS</td>
                            <td style="text-align: center">' . $total . '</td>
                            <td style="text-align: center">' . round($t_weight, 2) . '</td>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center" colspan="6">PESO INTEGRAL (' . (PORCENT_WEIGHT * 100) . '%)</td>
                            <td style="text-align: center">' . round($t_weight + ($t_weight * PORCENT_WEIGHT), 2) . '</td>
                            <td colspan="5"></td>
                        </tr>';
                    }
                    $this->load->view("Dispatch/Pack/Pdf/V_Body_Detail_Pack", $d);
                }
                $total_tags++;
            }

            if ($up) {
                // $total_tags++;
            }
        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack");
    }

    function GeneratePacksSD2($order, $min, $max) {

        $resulPack = $this->M_Delivery->LoadHeaderPack($order);

        $total_tags = 1;
        $this->load->view("Dispatch/Pack/Pdf/header_packs_limit");
        foreach ($resulPack as $r):
            $up = true;
            //echo $r->id_order_package;
            $ticket = 1;
            $data = array(
                "ItemQr" => $r->id_order_package,
                "client" => $r->client,
                "project" => $r->project,
                "order" => $order,
                "type" => $r->type,
                "quantity_packets" => $r->quantity_packets,
                "forniture" => $r->description,
                "start" => $r->number_pack,
                "pack" => $this->M_Delivery->MaxPack($order, $r->id_forniture, $r->type_package),
                "color" => $this->M_Delivery->Colorforniture($order, $r->id_forniture)
            );
            $data['new'] = true;
            $data['quantity_packets'] = $r->quantity_packets;
            //for ($i = 1; $i <= $r->quantity_packets; $i++) {

            if ($total_tags >= $min && $total_tags <= $max) {

                $data["ticket"] = $ticket++;
                $data["count"] = $total_tags;
                $this->load->view("Dispatch/Pack/Pdf/content_packs_limit", $data);

                //$d['body'] = "";
                //$this->load->view("Dispatch/Pack/Pdf/V_Body_Detail_Pack2", $d);
            }
            $total_tags++;
            //}// end for

            if ($up) {
                // $total_tags++;
            }
        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack2");
    }
    
    function GeneratePacksSDSupplies($order) {

        $resulPack = $this->M_Delivery->LoadHeaderPackSupplies($order);

        $total_tags = 1;
        //$this->load->view("Dispatch/Pack/pdf/header_packs_limit");
        foreach ($resulPack as $r):
            $up = true;
            $ticket = 1;
            $dt = $this->M_Delivery->data_supplies($order,$r->id_order_package_supplies);
            foreach ($dt as $valuedt) {
                $get_qr = $this->M_Delivery->get_data_dis($order,$r->id_order_package_supplies);
                foreach ($get_qr as $valueqr) {
                    $codeqr = $valueqr->codeqr;
                }
                $data = array(
                    "ItemQr" => $codeqr,
                    "client" => $valuedt->client,
                    "project" => $valuedt->project,
                    "order" => $order,
                    "type" => $valuedt->type,
                    "quantity_packets" => $valuedt->quantity_packets,
                    //"supplies" => $r->description,
                    "start" => $valuedt->number_pack,
                    "end" => $this->M_Delivery->Count_packs($order)
                );
            }
            $data['new'] = true;
            $this->load->view("Production/Delivery/Pdf/V_Head_Detail_Pack_Supplies", $data);
            $data['detail'] = $this->M_Delivery->detail_supplies($order,$r->id_order_package_supplies);
            $data['quantity_packets'] = $valuedt->quantity_packets;


            //if ($total_tags >= $min && $total_tags <= $max) {

                $data["ticket"] = $ticket++;
                $data["count"] = $total_tags;
                $this->load->view("Production/Delivery/pdf/content_packs_supplies", $data);

                //$d['body'] = "";
                //$this->load->view("Dispatch/Pack/Pdf/V_Body_Detail_Pack2", $d);
            //}
            $total_tags++;


        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack2");
    }
    
    function GeneratePacksSupplies2($order, $min, $max) {

        $resulPack = $this->M_Delivery->LoadHeaderPackSupplies($order);

        $total_tags = 1;
        $this->load->view("Dispatch/Pack/Pdf/header_packs_limit_supplies");
        foreach ($resulPack as $r):
            $up = true;
            $ticket = 1;
            $dt = $this->M_Delivery->data_supplies($order,$r->id_order_package_supplies);
            foreach ($dt as $valuedt) {
                $get_qr = $this->M_Delivery->get_data_dis($order,$r->id_order_package_supplies);
                foreach ($get_qr as $valueqr) {
                    $codeqr = $valueqr->codeqr;
                }
                $data = array(
                    "ItemQr" => $codeqr,
                    "client" => $valuedt->client,
                    "project" => $valuedt->project,
                    "order" => $order,
                    "type" => $valuedt->type,
                    "quantity_packets" => $valuedt->quantity_packets,
                    "start" => $valuedt->number_pack,
                    "end" => $this->M_Delivery->Count_packs($order)
                );
            }
            $data['new'] = true;
            $data['quantity_packets'] = $r->quantity_packets;

            if ($total_tags >= $min && $total_tags <= $max) {

                $data["ticket"] = $ticket++;
                $data["count"] = $total_tags;
                $this->load->view("Dispatch/Pack/Pdf/content_packs_limit_supplies", $data);
                
            }
            $total_tags++;

        endforeach;
        $this->load->view("Dispatch/Pack/Pdf/V_Footer_Detail_Pack_Supplies");
    }

    function GeneratePacks() {

        $delivery = $this->M_Delivery->DeliverySuppliesCount($this->input->post("order"));

        if (count($delivery) <= 0) {

            $without_weight = $this->M_Delivery->SuppliesOrderWeight($this->input->post("order"));

            if ($without_weight['res'] == "OK") {

                $this->M_Delivery->Delete_Packs_And_Tags_Supplies();
                $supplies = $this->M_Delivery->SearchOrderSupplies(false);
                $info = $this->M_Delivery->InfoOrder();

                foreach ($supplies['record'] as $t) {

                    $this->qt_total = $t->quantity;
                    $this->ppal = 0;
                    $this->ext = 0;

                    for ($i = $t->quantity_per_package; $i <= $t->quantity; $i += $t->quantity_per_package) {
                        $this->ppal += 1;
                        $this->qt_total -= $t->quantity_per_package;
                    }

                    $data = array("id_order_supplies" => $t->id_order_supplies, "id_supplies" => $t->id_supplies, "`order`" => $this->input->post("order"), "quantity_total_supplies" => $t->quantity);
                    $tags = array();

                    $tags['supplies'] = $t->name;
                    $tags['code'] = $t->code;
                    $tags['project'] = $info->project;
                    $tags['client'] = $info->client;
                    $tags['order'] = $info->order;
                    $tags['type'] = $info->type;
                    $tags['id_supplies'] = $t->id_supplies;


                    if ($this->ppal > 0) {
                        $data["number_pack"] = 1;
                        $data["type_package"] = 1;
                        $data["quantity_packets"] = $this->ppal;
                        $data["quantity_per_package"] = $t->quantity_per_package;
                        $data["quantity_supplies"] = ($this->ppal * $t->quantity_per_package);
                        $data['weight_per_package'] = $t->weight_per_package;
                        $tags['quantity'] = $t->quantity_per_package;


                        $rs = $this->M_Delivery->CreatePackSupplies($data, $tags);
                    }

                    if ($this->qt_total > 0) {
                        $this->ext = 1;
                    }

                    if ($this->ext > 0) {
                        $data["number_pack"] = 2;
                        $data["type_package"] = 6;
                        $data["quantity_packets"] = $this->ext;
                        $data["quantity_per_package"] = ($this->ext * $t->quantity_per_package);
                        $data["quantity_supplies"] = $this->qt_total;
                        $data['weight_per_package'] = ($t->weight_per_package / $t->quantity_per_package) * $this->qt_total;
                        $tags['quantity'] = $this->qt_total;

                        $rs = $this->M_Delivery->CreatePackSupplies($data, $tags);
                    }

                    $rs['packs'] = $this->M_Delivery->InfoPackSupplies_RE($this->input->post("order"));
                    $rs['table'] = $this->load->view('Production/Delivery/Supplies/Enlist/V_Table_Pack', $rs, true);
                }
            } else {
                $rs['res'] = "WEIGHT";
                $rs['supplies'] = $this->load->view("Production/Delivery/Supplies/Enlist/V_Table_Supplies_Weight", $without_weight, true);
            }
        } else {
            $rs['res'] = "EL PEDIDO YA TIENE ENTREGAS CREADAS";
        }
        echo json_encode($rs);
    }

    function UpdateWeightSupplies() {
        $rs = $this->M_Delivery->UpdateWeightSupplies();
        echo json_encode($rs);
    }

    function Print_Enlist($order) {
        $this->load->model("Dispatch/M_Delivery");

        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $data['packs'] = $this->M_Delivery->InfoPackSupplies_RE($order);

        $this->load->view("Production/Delivery/Supplies/Enlist/Pdf/V_Head_Enlist", $data);
        $this->load->view("Production/Delivery/Supplies/Enlist/Pdf/V_Body_Enlist", $data);
    }

    function Print_Tags($order) {
        $data['packs'] = $this->M_Delivery->InfoTagsSupplies($order);
        $this->load->view("Production/Delivery/Supplies/Enlist/Pdf/V_Tags", $data);
    }

    function Generate_Resumen($order) {
        $this->load->model("Dispatch/M_Delivery");

        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $this->load->view("Production/Delivery/PackageSD/Enlist/Pdf/V_Head_Resumen", $data);

        $forniture = $this->M_Delivery->LoadFornitureOrder($order);
        $area = $this->M_Delivery->get_pro_sheet_area();
        
        foreach ($forniture as $v) :
            $data['forniture'] = $v;
            $this->load->view("Production/Delivery/PackageSD/Enlist/Pdf/V_Head_Forniture", $data);

            $data['packages'] = $this->M_Delivery->LoadPackages($order, $v->id_forniture);
            foreach ($data['packages'] as $v) :
                $data['quantity_packets'] = $v->quantity_packets;
                $data['number_pack'] = $v->number_pack;
                $data['vali'] = $this->M_Delivery->LoadDetailPack2($v->id_order_package);
                foreach ($data['vali'] as $valued) {
                    if($valued->description == ""){
                        $vali = $this->M_Delivery->GetReference($valued->code_sheet_ax);
                        foreach ($area as $valuea) {
                            //print_r($valuea);
                            $id_pro_sheet_area = "";
                            $format = "";
                            foreach ($vali as $valuev) {
                                $string = $valuev->ITEMNAME;
                                $referencia = $valuev->Referencia;
                            }
                            $find = $valuea->format;
                            $finder = str_replace(".", ",", $find);
                            $pos = strpos($string, $finder);
                            if($pos != ""){
                                $id_pro_sheet_area = $valuea->id_pro_shet_area;
                                $format = $valuea->format;
                                break;
                            }else{
                                $pos2 = strpos($string, $find);
                                if($pos2 != ""){
                                    $id_pro_sheet_area = $valuea->id_pro_shet_area;
                                    $format = $valuea->format;
                                    break;
                                }
                            }
                        }
                        $insert_data = $this->M_Delivery->insert_pro_wood($referencia,$string,$format,$id_pro_sheet_area);
                    }
                }
                $data['detail'] = $this->M_Delivery->LoadDetailPack($v->id_order_package);
                $this->load->view("Production/Delivery/PackageSD/Enlist/Pdf/V_Body_Packs", $data);
            endforeach;
        endforeach;
    }

    // -------------------------------------------------   ENTREGA DE PAQUETES SD ----------------------------------------------------------------

    function Delivery_SD_Packages() { 
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['rows'] = $this->M_Delivery->ListDeliveryPackageSD();
        $data['table'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Delivery', $data, true);

        $data['orders'] = $this->M_Delivery->ListOrderIncomplete();

        $this->load->view('Production/Delivery/PackageSD/V_Panel_Package', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function CreateDeliveryPackage() {
        $rs = $this->M_Delivery->CreateDeliveryPackage();
        echo json_encode($rs);
    }

    function InfoDeliveryPackage($id_delivery, $order, $view) {
        //$array['menus'] = $this->M_Main->ListMenu();

        //$Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header2', $Header);

        $data["info"] = $this->M_Delivery->InfoDeliveryPackage($id_delivery);
        $data['view'] = $view;
        $data['delivery'] = $id_delivery;
        $data['order'] = $order;
        $d['furniture'] = $this->M_Delivery->Listfurniture($order);
        $d['list'] = $this->M_Delivery->ListPackDetail($order);
        $d['detail'] = $this->M_Delivery->ListeliberyDetail($id_delivery);
        $d['delivery'] = $id_delivery;
        if ($view == "Delivery") {
            foreach ($this->M_Delivery->LoadButtonPermissions("Entrega") as $btn) {
                $d[$btn->name] = $btn->name;
            }
            
            $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        } else {
            $data['tables'] = $this->load->view('Dispatch/Delivery/V_Table_Package', $d, true);
        }

        foreach ($this->M_Delivery->LoadButtonPermissions("Despacho") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $this->load->view('Production/Delivery/PackageSD/V_Panel_Detail_Package_La', $data);

        //$Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS,DATATABLES_JS_B,SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer2', $Footer);
    }

    function ListRequestReverse() {
        $res = $this->M_Delivery->ListRequestReverse();
        echo json_encode(array("res" => $res));
    }

    function ReversePack() {
        $this->db->trans_begin();
        if (!empty($this->input->post('request'))) {
            //$this->M_Delivery->ReversePackDispatch();
        }
        $tables = "";
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $res = "ERROR " . $this->db->last_query();
        } else {
            $this->db->trans_commit();
            $res = "OK";
            //$data['rs'] = $this->M_Delivery->AddPackToDelivery2();
            $data['rs'] = $this->M_Delivery->ReversePackDelivery();
            $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
            $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
            $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('delivery'));
            $d['delivery'] = $this->input->post('delivery');
            
            foreach ($this->M_Delivery->LoadButtonPermissions("Entrega") as $btn) {
                $d[$btn->name] = $btn->name;
            }
            //$data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
            $data['tables'] = $this->load->view('Dispatch/Delivery/V_Table_Package', $d, true);

            //$tables = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        }
        echo json_encode($data);
    }

    function AddAllPackToDelivery() {
        $result = $this->M_Delivery->AddAllPackToDelivery();

        foreach ($result as $t) {

            $array = array();
            $array['id_order_package'] = $t->id_order_package;
            //echo $t->id_delivery_package_detail;
            if (empty($t->id_delivery_package_detail)) { //IS NEW
                $array['delivery'] = $this->input->post("delivery");
                $array['quantity'] = $t->balance;

                $rs = $this->M_Delivery->AddPackToDelivery($array);
            } else { // IS OLD "UPDATE"
                $array['id_delivery_package_detail'] = $t->id_delivery_package_detail;
                $array['quantity'] = $t->quantity_packets + 1;

                $rs = $this->M_Delivery->UpdateDetailDelivery($array);
            }
        }

        if (count($result)) {
            $id_delivery = $array['delivery'];
            $order = $this->input->post("order");
            $d['furniture'] = $this->M_Delivery->Listfurniture($order);
            $d['list'] = $this->M_Delivery->ListPackDetail($order);
            $d['detail'] = $this->M_Delivery->ListeliberyDetail($id_delivery);
            $d['delivery'] = $this->input->post('delivery');
            $data['res'] = "OK";
            $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        } else {
            $data['res'] = "";
        }
        echo json_encode($data);
    }
    
    // Created Ivan Contreras 03/04/2019
    function Add_furniture(){
        $result = $this->M_Delivery->add_furniture();
        echo json_encode("OK");
    }
    
    function Add_furniture_table(){
        $id_delivery = $this->input->post('delivery');
        $order = $this->input->post('order');
        $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
        $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
        $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('delivery'));
        $d['delivery'] = $this->input->post('delivery');
        $data['res'] = "OK";

        $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        
        echo json_encode($data);
    }
    
    function update_data_furniture(){
        $furniture = $this->input->post('furniture');
        $order = $this->input->post('order');
        $get_data = $this->M_Delivery->get_data_furniture($order,$furniture);
        $delivered = array();
        foreach ($get_data as $key => $value) {
            $delivered[] = $value->delivered_quantity;
        }
        $min_value = min($delivered);
        $uncompleted = 0;
        $packets_empty = 0;
        foreach ($get_data as $key => $value2) {
            if($value2->delivered_quantity == "0"){
                $uncompleted ++;
            }
            $packets_empty = $value2->quantity_packets - max($delivered);
        }
        if($uncompleted > 0){
            $packets = 0;
            $uncompleted_packets = 0;
        }else{
            $packets = $min_value;
            $uncompleted_packets = max($delivered) - min($delivered);
        }
        foreach ($get_data as $key => $value3) {
            $update_data = $this->M_Delivery->update_data_furniture($value3->id_order_package,$packets);
        }
        echo json_encode(array('completed' => $packets,'uncompleted' => $uncompleted_packets, 'packets_empty' => $packets_empty, 'array' => $delivered));
    }
    
    // *********************************************************

    function AddPackToDelivery() {
        $data['rs'] = $this->M_Delivery->AddPackToDelivery();
        $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
        $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
        $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('delivery'));
        $d['delivery'] = $this->input->post('delivery');
        $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        
        echo json_encode($data);
    }
    
    function AddPackToDelivery2() {
        $data['rs'] = $this->M_Delivery->AddPackToDelivery();
        $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
        $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
        $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('id_delivery'));
        $d['delivery'] = $this->input->post('id_delivery');
        $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        
        echo json_encode($data);
    }

    function DeletePackToDelivery() {
        $data['rs'] = $this->M_Delivery->DeletePackToDelivery();
        $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
        $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
        $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('id_delivery'));
        $d['delivery'] = $this->input->post('id_delivery');
        $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
       
        echo json_encode($data);
    }

    function RemoveAllPackToDelivery() {
        $rows = $this->M_Delivery->ListeliberyDetail($this->input->post('delivery'));

        foreach ($rows as $value) {
            $rs = $this->M_Delivery->DeletePackToDelivery($value->id_delivery_package_detail, $value->id_order_package);
        }
        if ($rs) {
            $d['furniture'] = $this->M_Delivery->Listfurniture($this->input->post('order'));
            $d['list'] = $this->M_Delivery->ListPackDetail($this->input->post('order'));
            $d['detail'] = $this->M_Delivery->ListeliberyDetail($this->input->post('delivery'));
            $d['delivery'] = $this->input->post('delivery');

            foreach ($this->M_Delivery->LoadButtonPermissions("Entrega") as $btn) {
                $d[$btn->name] = $btn->name;
            }
            $data['res'] = "OK";
            $data['tables'] = $this->load->view('Production/Delivery/PackageSD/V_Table_Package', $d, true);
        } else {
            $data['res'] = "ERROR SQL";
        }
        echo json_encode($data);
    }

    function UpdateDetailDelivery() {
        $rs = $this->M_Delivery->UpdateDetailDelivery();
        echo json_encode($rs);
    }

    function DeliverPacksSD() {
        $rs = $this->M_Delivery->DeliverPacksSD();
        echo json_encode($rs);
    }

    function ApproveDeliverPack() {
        $rs = $this->M_Delivery->ApproveDeliverPack();
        echo json_encode($rs);
    }

    function Print_Deliver_PacksSD($order, $No) {
        $this->load->model("Dispatch/M_Delivery");

        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $data['No'] = $No;
        $this->load->view("Production/Delivery/Pdf/V_Head_Deliver", $data);

        $forniture = $this->M_Delivery->LoadFornitureOrder($order);
        $deliverys = $this->M_Delivery->Delivery($order);

        foreach ($forniture as $m):

            $name = $m->description;
            $item = $m->item;
            $colorPdf = $m->colored;
            $packages = $this->M_Delivery->LoadPackages($order, $m->id_forniture);

            $sw = false;
            $arrayTable[1] = '';
            foreach ($packages as $paq) :

                $arrayTable[1] .= '<tr nobr="true">';
                if (!$sw):
                    $arrayTable[1] .= '<td rowspan ="1" style="text-align:center;">' . $item . '</td>';
                    $arrayTable[1] .= '<td rowspan ="1" style="text-align:center;background-color:' . $colorPdf . '">' . $name . '</td>';

                    $count = 0;
                    $arrayTable[0] = "";
                    foreach ($deliverys as $value) {
                        $arrayTable[0] .= '<td width="4%" style="text-align: center;background-color: ' . $value->hex . ';"><b>N&deg; ' . $value->id_delivery_package . '</b></td>';
                        $count++;
                    }
                    for ($i = $count; $i < 11; $i++) {
                        $arrayTable[0] .= '<td width="4%" style="text-align: center"><b></b></td>';
                    }
                    $arrayTable[0] .= '<td width="5%" style="text-align: center"><b>TOTAL</b></td>';

                    $sw = true;
                else:
                    $arrayTable[1] .= '<td style="border-color: #000; border:none"></td>';
                    $arrayTable[1] .= '<td style="border-color: #000; border:none"></td>';
                endif;

                $arrayTable[1] .= '<td  style="text-align:center;">' . $paq->number_pack . '</td>';
                $arrayTable[1] .= '<td  style="text-align:center;">' . $paq->code . '</td>';
                $arrayTable[1] .= '<td class="qty" style="text-align:center;">' . $paq->quantity_packets . '</td>';

                $count = 0;
                $sum = 0;
                $countRow = 1;
                foreach ($deliverys as $value) {
                    $dpack = $this->M_Delivery->DeliveryPackage($value->id_delivery_package, $paq->id_order_package);
                    if (count($dpack) > 0) {
                        $arrayTable[1] .= '<td width="4%" class="delivery d-' . $countRow . '" style="text-align: center;"><b>' . $dpack->quantity . '</b></td>';
                        $sum += $dpack->quantity;
                    } else {
                        $arrayTable[1] .= '<td width="4%" style="text-align: center;"></td>';
                    }
                    $count++;
                    $countRow++;
                }
                for ($i = $count; $i < 11; $i++) {
                    $arrayTable[1] .= '<td width="4%" style="text-align: center"><b></b></td>';
                }
                $arrayTable[1] .= '<td width="5%" style="text-align: center"><b class="qtyTotal">' . $sum . '</b></td>';

                $arrayTable[1] .= '</tr>';
            endforeach;



            $data['deliver'] = $arrayTable;

            $this->load->view("Production/Delivery/Pdf/V_Body_Deliver", $data);
        endforeach;


        $this->load->view("Production/Delivery/Pdf/V_Footer_Deliver");
    }

    // -------------------------------------------------   ENTREGA DE INSUMOS ----------------------------------------------------------------

    function Delivery_SD_Supplies() {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS, SELECT2_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data['rows'] = $this->M_Delivery->ListDeliverySupplies();
        $data['table'] = $this->load->view('Production/Delivery/Supplies/V_Table_Delivery', $data, true);
        $data['orders'] = $this->M_Delivery->ListOrderIncompleteSupplies();
        $this->load->view('Production/Delivery/Supplies/V_Panel_Supplies', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS, SELECT2_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function CreateDeliverySupplies() {
        $rs = $this->M_Delivery->CreateDeliverySupplies();
        echo json_encode($rs);
    }

    function InfoDeliverySupplies($id_delivery, $order, $view) {
        $array['menus'] = $this->M_Main->ListMenu();

        $Header['menu'] = $this->load->view('Template/Menu/V_Menu', $array, true);
        $Header['array_css'] = array(DATATABLES_CSS, SWEETALERT_CSS);
        $this->load->view('Template/V_Header', $Header);

        $data["info"] = $this->M_Delivery->InfoDeliverySupplies($id_delivery);

        $data['delivery'] = $id_delivery;
        $data['order'] = $order;
        $d['order'] = $order;
        $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
        //$d['detail'] = $this->M_Delivery->ListDeliberyDetailDispatch($id_delivery);
        $d['detail'] = $this->M_Delivery->get_pro_delivery_supplies_detail($order,$id_delivery);
        $d['headers'] = $this->M_Delivery->get_order_package_supplies2($order);
        $data['empty_p'] = $this->M_Delivery->get_empty_packs($order);
        
        if ($view == "Delivery") {
            $data['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        } else {
            $data['tables'] = $this->load->view('Dispatch/Delivery/V_Table_Supplies', $d, true);
        }


        foreach ($this->M_Delivery->LoadButtonPermissions("Despacho") as $btn) {
            $data[$btn->name] = $btn->name;
        }

        $this->load->view('Production/Delivery/Supplies/V_Panel_Detail_Supplies', $data);

        $Footer['sidebar_tabs'] = $this->load->view('Template/V_sidebar_tabs', null, true);
        $Footer['array_js'] = array(DATATABLES_JS, DATATABLES_JS_B, SWEETALERT_JS);
        $Footer["btn_datatable"] = BTN_DATATABLE_JS;
        $this->load->view('Template/V_Footer', $Footer);
    }

    function AddPackToDeliverySupplies() {
        $rs = $this->M_Delivery->AddPackToDeliverySupplies();
        $order = $this->input->post('order');
        $delivery = $this->input->post("delivery");
        $d['order'] = $order;
        $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
        $d['detail'] = $this->M_Delivery->get_pro_delivery_supplies_detail($order,$delivery);
        $d['headers'] = $this->M_Delivery->get_order_package_supplies2($order);
        $rs['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        echo json_encode($rs);
    }

    function UpdateDetailDeliverySupplies() {
        $rs = $this->M_Delivery->UpdateDetailDeliverySupplies();
        echo json_encode($rs);
    }

    function AddAllSuppliesToDelivery() {
        $result = $this->M_Delivery->AddAllPackSuppliesToDelivery();

        foreach ($result as $t) {

            $array = array();
            $array['id_order_package_supplies'] = $t->id_order_package_supplies;

            if (empty($t->id_delivery_supplies_detail)) { //IS NEW
                $array['delivery'] = $this->input->post("delivery");
                $array['quantity'] = $t->balance;

                $rs = $this->M_Delivery->AddPackToDeliverySupplies($array);
            } else { // IS OLD "UPDATE" 
                $array['id_delivery_supplies_detail'] = $t->id_delivery_supplies_detail;
                $array['quantity'] = $t->quantity_packets + 1;
                
                $rs = $this->M_Delivery->UpdateDetailDeliverySupplies($array);
            }
        }

        if (count($result)) {
            $id_delivery = $array['delivery'];
            $order = $this->input->post("order");
            $delivery = $this->input->post("delivery");
            $data['res'] = "OK";
            $d['order'] = $order;
            $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
            $d['detail'] = $this->M_Delivery->get_pro_delivery_supplies_detail($order,$delivery);
            $d['headers'] = $this->M_Delivery->get_order_package_supplies2($order);
            $data['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        } else {
            $data['res'] = "";
        }
        echo json_encode($data);
    }
    
    function DeleteSuppliesDeliveryAll(){
        $rs = $this->M_Delivery->DeleteSuppliesDeliveryAll();
        $order = $this->input->post('order');
        $delivery = $this->input->post("delivery");
        $d['order'] = $order;
        $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
        $d['detail'] = $this->M_Delivery->get_pro_delivery_supplies_detail($order,$delivery);
        $d['headers'] = $this->M_Delivery->get_order_package_supplies2($order);
        $rs['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        echo json_encode($rs);
    }

    function DeleteSuppliesDelivery() {
        $rs = $this->M_Delivery->DeleteSuppliesDelivery();
        $order = $this->input->post('order');
        $delivery = $this->input->post("delivery");
        $d['order'] = $order;
        $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
        $d['detail'] = $this->M_Delivery->get_pro_delivery_supplies_detail($order,$delivery);
        $d['headers'] = $this->M_Delivery->get_order_package_supplies2($order);
        $rs['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        echo json_encode($rs);
    }

    function DeliverSupplies() {
        $rs = $this->M_Delivery->DeliverSupplies();
        echo json_encode($rs);
    }

    function ApproveDeliverSupplies() {
        $rs = $this->M_Delivery->ApproveDeliverSupplies();
        echo json_encode($rs);
    }

    function SplitPackSupplies() {
//        exit();
        $rs = $this->M_Delivery->SplitPackSupplies();

        $data['res'] = $rs['res'];

        if ($rs["res"] == "OK") {
            $id_delivery = $this->input->post("delivery");
            $order = $this->input->post("order");
            $d['list'] = $this->M_Delivery->ListSuppliesDispatch($order);
            $d['detail'] = $this->M_Delivery->ListDeliberyDetailDispatch($id_delivery);

            $data['tables'] = $this->load->view('Production/Delivery/Supplies/V_Table_Supplies', $d, true);
        }

        echo json_encode($data);
    }

    function Print_Deliver_Supplies($order, $No) {
        $this->load->model("Dispatch/M_Delivery");

        $data['head'] = $this->M_Delivery->LoadHeaderOrder($order);
        $data['No'] = $No;
        $this->load->view("Production/Delivery/Pdf/V_Head_Deliver_Supplies", $data);

        $deliverys = $this->M_Delivery->DeliverySupplies($order);
        $packages = $this->M_Delivery->LoadPackagesSuppliesIni($order);

        $sw = false;
        $arrayTable[1] = '';
        $arrayTable['packs'] = 0;
        foreach ($packages as $paq) :
            $arrayTable[1] .=  '<tr>
                        <td colspan="2" style="font-size: 8px; "><center>PAQUETE (CAJA) '.$paq->number_pack.'</center></td>
                        <td colspan="1" style="font-size: 8px; "><center>T/U/P: '. (($paq->type_package == 1) ? $paq->quantity_per_package : $paq->quantity_supplies) . '</center></td>
                        <td colspan="19" style="font-size: 8px; "><center></center></td>
                    </tr>';
            
            $detail = $this->M_Delivery->LoadPackagesSupplies2($paq->id_order_package_supplies);
            foreach ($detail as $valued) {
                
                $arrayTable[1] .= '<tr>';
                $arrayTable[1] .= '<td style="text-align:center;">' . $valued->code . '</td>';
                $arrayTable[1] .= '<td>' . $valued->name . '</td>';
                if (!$sw):
                    $count = 0;
                    $arrayTable[0] = "";
                    foreach ($deliverys as $value) {
                        $arrayTable[0] .= '<td colspan="2" width="6%" style="border-right: 2px solid #212121;text-align: center;background-color: ' . $value->hex . ';"><b>N&deg; ' . $value->id_delivery_supplies . '</b></td>';
                        $count++;
                    }
                    for ($i = $count; $i < 9; $i++) {
                        $arrayTable[0] .= '<td colspan="2" width="6%" style="border-right: 2px solid #212121;"><b></b></td>';
                    }
                    $sw = true;
                endif;

                $arrayTable[1] .= '<td style="text-align:center;">' . $valued->quantity_packaged . '</td>';
                $arrayTable[1] .= '<td class="qty" style="text-align:center;"></td>';
                //$arrayTable[1] .= '<td  style="text-align:center;">' . (($paq->type_package == 1) ? $paq->quantity_per_package : $paq->quantity_supplies) . '</td>';
                //$arrayTable[1] .= '<td class="qty" style="text-align:center;">' . $valued->quantity_t . '</td>';
//                $arrayTable[1] .= '<td class="qty" style="text-align:center;"></td>';
                //$arrayTable[1] .= '<td style="border: none;" colspan="1"></td>';
                
                $count = 0;
                $sum = 0;
                $countRow = 1;
                foreach ($deliverys as $value) {
                    $dpack = $this->M_Delivery->DeliveryPackageSupplies($value->id_delivery_supplies, $paq->id_order_package_supplies);
                    if (count($dpack) > 0) {
                        $arrayTable[1] .= '<td width="4%" class="delivery d-' . $countRow . '" style="text-align: center;"><b>' . $dpack->quantity . '</b></td>';
                        $arrayTable[1] .= '<td width="4%" class="delivery u-' . $countRow . '" style="text-align: center;"><b>' . $valued->quantity_packaged . '</b></td>';
                        //$arrayTable[1] .= '<td width="4%" class="delivery u-' . $countRow . '" style="text-align: center;"><b>' . (($paq->type_package == 1) ? $paq->quantity_per_package * $dpack->quantity : $paq->quantity_supplies) . '</b></td>';
                        $sum += $dpack->quantity;
                    } else {
                        $arrayTable[1] .= '<td width="4%" style="text-align: center;"></td><td width="4%" style="text-align: center;"></td>';
                    }
                    $count++;
                    $countRow++;
                }
                for ($i = $count; $i < 9; $i++) {
                    $arrayTable[1] .= '<td width="4%" style="text-align: center"><b></b></td><td width="4%" style="text-align: center"><b></b></td>';
                }
                

                $arrayTable[1] .= '</tr>';
                $arrayTable['packs'] += $valued->quantity_packaged;
            }
            $count2 = 0;
            $countRow2 = 1;
            foreach ($deliverys as $value) {
                $dpack = $this->M_Delivery->DeliveryPackageSupplies($value->id_delivery_supplies, $paq->id_order_package_supplies);
                if (count($dpack) > 0) {
                    $arrayTable[1] .= '<input type="hidden" class="delivery d-h-' . $countRow2 . '" value="' . $dpack->quantity . '" />';
                    $arrayTable[1] .= '<input type="hidden" class="delivery u-h-' . $countRow2 . '" value="' . (($paq->type_package == 1) ? $paq->quantity_per_package * $dpack->quantity : $paq->quantity_supplies) . '" />';
                }
                $count2++;
                $countRow2++;
            }
        endforeach;
//
        $data['deliver'] = $arrayTable;
//
        $this->load->view("Production/Delivery/Pdf/V_Body_Deliver_Supplies", $data);
        $this->load->view("Production/Delivery/Pdf/V_Footer_Deliver_Supplies");
    }

    // -------------------------------------------------   ENTREGA DE MUEBLES ME ----------------------------------------------------------------

    function Delivery_Standard_Furniture() {
        
    }

    function AddPieceToPack() {
        $result = $this->M_Delivery->AddPieceToPack();
        echo json_encode(array("res" => "OK"));
    }

    function CharguePieceToPack() {
        $result = $this->M_Delivery->loadPiecesAdd();
        echo json_encode($result);
    }

    function DeletePieceToPack() {
        $result = $this->M_Delivery->DeletePieceToPack();
        echo json_encode($result);
    }

}

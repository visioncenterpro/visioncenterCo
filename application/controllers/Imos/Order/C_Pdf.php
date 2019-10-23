<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Pdf extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $modelos = array("Imos/Order/M_Order", "Imos/Acknow/M_Acknow");
        $this->load->model($modelos);
        require_once(dirname(__FILE__) . '/../../../includes/tcpdf/tcpdf.php');
    }

    function IronWorksAll($order) {
        $data['order'] = $order;
        $data['title'] = "LISTADO DE HERRAJES DEL PEDIDO POR MUEBLE";

        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $data['Header'] = $this->M_Order->ListOrderImosAll($order);
        $this->load->view("Imos/Order/Pdf/V_Order_Head", $data);

        $items = $this->M_Order->ListOrderItemImosAll($order);
        //print_r($items);
        $d['consolidate'] = array();
        foreach ($items as $t) :
            $nameid = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : $t->CPID)));
            $nameid = ($nameid == 'PN') ? $t->CPID . $t->DEPTH : $nameid;
            $data['article'] = $nameid;
            $data['position'] = $t->POSSTR;
            $data['med'] = $t->HEIGHT . "x" . $t->WIDTH. "x" . $t->DEPTH;

            $d = $this->CreateBodyIronWorks($t->ID, $order, $d['consolidate']);

            if (is_object($data['HeaderRecord'])) {
                $idsales = $data['HeaderRecord']->id_import_salestable;
                $d = $this->CreateBodyIronWorksAck($t->ID, $idsales, $d);
            }

            if ($d['sum'] > 0):
                $this->load->view("Imos/Order/Pdf/V_Ironworks", array("data"=>$d,"info"=>$data));
            endif;
        endforeach;

        $ad = $this->M_Order->ListOrderItemImosAditionals($order);
        $array = $d['consolidate'];
        if ($ad['count'] > 0) {
            $item = 1;
            $sum = 0;
            $ad['sum'] = '0';
            $ad['html'] = "";
            
            foreach ($ad['result'] as $r) :
                $descAX = $this->M_Order->ChargedCodeAXiron($r->code);
                $desc = strtoupper((!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $r->description . "(Crear En AX)");
                $und = (empty($descAX)) ? '' : $descAX->UNITID;

                $ad['html'] .= '<tr>
                    <td style="text-align: center">' . $item++ . '</td>
                    <td style="text-align: center">' . $r->code . '</td>
                    <td>' . $desc . '</td>
                    <td style="text-align: center">' . $r->qty . '</td>
                    <td style="text-align: center">' . $und . '</td>
                </tr>';

                $ad['sum'] += $r->qty;
                if (array_key_exists($r->code, $array)) {
                    $array[$r->code]["qty"] += $r->qty;
                } else {
                    $array[$r->code] = array("desc" => $desc, "uni" => $und, "qty" => $r->qty);
                }

            endforeach;
            $this->load->view("Imos/Order/Pdf/V_Ironworks_Order", $ad);
        }
        //CONSOLIDADO TOTAL DEL PEDIDO
        $item = 1;
        $c['tbody'] = "";
        $c['sum'] = 0;
        $c['consolidado'] = true;
        foreach ($array as $key => $i) {
            $c['tbody'] .= '<tr>
                    <td style="text-align: center">' . $item++ . '</td>
                    <td style="text-align: center">' . $key . '</td>
                    <td>' . $i['desc'] . '</td>
                    <td style="text-align: center">' . $i['qty'] . '</td>
                    <td style="text-align: center">' . $i['uni'] . '</td>
                </tr>';
            $c['sum'] += $i['qty'];
        }

        $this->load->view("Imos/Order/Pdf/V_Ironworks", array("data"=>$c));
    }

    function IronWorks($id, $order, $cpid, $idProadmin, $article, $med, $pos) {
        $data['id'] = $id;
        $data['order'] = $order;
        $data['cpid'] = $cpid;
        $data['article'] = $article;
        $data['position'] = $pos;
        $data['med'] = $med;
        $data['title'] = "LISTADO DE HERRAJES";

        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $data['Header'] = $this->M_Order->ListOrderImosAll($order);
        $this->load->view("Imos/Order/Pdf/V_Order_Head", $data);


        $d = $this->CreateBodyIronWorks($id, $order, array());

        if (is_object($data['HeaderRecord'])) {
            $idsales = $data['HeaderRecord']->id_import_salestable;
            $d = $this->CreateBodyIronWorksAck($id, $idsales, $d);
        }
        if ($d['sum'] > 0):
            $this->load->view("Imos/Order/Pdf/V_Ironworks", array("data"=>$d,"info"=>$data));
        endif;
    }

    function PiecesAll($order) {

        $d['title'] = "LISTADO DE PIEZAS DEL PEDIDO POR MUEBLE";
        $d['order'] = $order;

        $d['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $d['Header'] = $this->M_Order->ListOrderImosAll($order);
        $items = $this->M_Order->ListOrderItemImosAll($order);
        foreach ($items as $i) :
            $nameid = (!empty($i->INFO1) ? $i->INFO1 : (!empty($i->INFO2) ? $i->INFO2 : (!empty($i->INFO3) ? $i->INFO3 : $i->CPID)));
            $nameid = ($nameid == 'PN') ? $i->CPID . $i->DEPTH : $nameid;

            $d['article'] = $nameid;
            $d['position'] = $i->POSSTR;
            $d['med'] = $i->HEIGHT . "x" . $i->WIDTH. "x" . $i->DEPTH;
            $d['id'] = $i->ID;
            $d['cpid'] = $i->CPID;

            $d['tbody'] = $this->CreateBodyPieces($i->ID, $order);
            $this->load->view("Imos/Order/Pdf/V_Pieces", $d);

            $d['AdAditional'] = $this->M_Order->ListPiecesAddALL($i->ID, $order);

            $this->load->view("Imos/Order/Pdf/V_Pieces_Aditional", $d);

        endforeach;
        
        $ad = $this->M_Order->ListOrderPiecesAditionals($order);
        if ($ad['count'] > 0) {
            $item = 1;
            $sum = 0;
            $ad['sum'] = '0';
            $ad['html'] = "";
            
            foreach ($ad['result'] as $r) :
                
                $descAX = $this->M_Order->ChargedCodeAXiron($r->code);
                $desc = strtoupper((!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $r->description);
             
                
                $ad['html'] .= '<tr>
                    <td style="text-align: center">' . $item++ . '</td>
                    <td style="text-align: center">' . $r->code . '</td>
                    <td>' . $desc . '</td>
                    <td style="text-align: center">' . $r->qty . '</td>
                    <td style="text-align: center">' . $r->height . '</td>
                    <td style="text-align: center">' . $r->width . '</td>
                    <td style="text-align: center">' . $r->depth . '</td>
                </tr>
                <tr>';

                $ad['sum'] += $r->qty;

            endforeach;
            $this->load->view("Imos/Order/Pdf/V_Pieces_Order", $ad);
        }

        $this->load->view("Imos/Order/Pdf/V_Footer");
    }

    function Pieces($id, $order, $cpid, $idProadmin, $article, $med,$pos) {

        $d['id'] = $id;
        $d['order'] = $order;
        $d['cpid'] = $cpid;
        $d['article'] = $article;
        $d['position'] = $pos;
        $d['med'] = $med;
        $d['title'] = "LISTADO DE PIEZAS";

        $d['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $d['Header'] = $this->M_Order->ListOrderImosAll($order);

        $d['tbody'] = $this->CreateBodyPieces($id, $order);
        $this->load->view("Imos/Order/Pdf/V_Pieces", $d);

        $d['AdAditional'] = $this->M_Order->ListPiecesAddALL($id, $order);

        $this->load->view("Imos/Order/Pdf/V_Pieces_Aditional", $d);

        $this->load->view("Imos/Order/Pdf/V_Footer");
    }

    function CreateBodyPieces($id, $order) {

        $PiecesRecord = $this->M_Order->ListPiecesALL($id, $order);

        $tbody = "";
       
        foreach ($PiecesRecord as $t):

            $arrayCantos = explode(";", $t->cantos);
            $arrayGeneral = array(" 1 : N/A ", " 2 : N/A ", " 3 : N/A ", " 4 : N/A ");
            if (!empty($t->cantos)) {
                foreach ($arrayCantos as $a):
                    $arrayCanto = explode("-", $a);
                    $arrayGeneral[$arrayCanto[0] - 1] = " " . $arrayCanto[0] . " : " . $arrayCanto[1] . " ";
                endforeach;
            }
            $canto = "$arrayGeneral[0]<br />$arrayGeneral[1]<br />$arrayGeneral[2]<br />$arrayGeneral[3]";
            $img = SERVER_IMOS . "/$order/BITMAPS/$t->ID.png";
            $_POST['idbgpl'] = $t->ID;
            $_POST['order'] = $order;
            $codes = $this->M_Order->ChargedBarcode();

            if (!empty($codes[0]['CNC_NAME'])) {
                $code1 = str_replace("_", "-", $codes[0]['CNC_NAME']);
            } else {
                $code1 = "";
            }
            if (!empty($codes[1]['CNC_NAME'])) {
                $code2 = str_replace("_", "-", $codes[1]['CNC_NAME']);
            } else {
                $code2 = "";
            }

            $reference = empty($t->IDPIEZA) ? "" : $t->IDPIEZA . '-' . $t->FLENG . 'X' . $t->FWIDTH;
            $tbody .= '<tr>
                <td style="text-align: center">' . $reference . '</td>
                <td style="">' . $t->NAME . '</td>
                <td style="">' . $t->RENDERPMAT . '</td>
                <td style="text-align: center">' . $t->MATNAME . '</td>
                <td >' . $canto . '</td>
                <td style="text-align: center"><img style="height: 50px;" src="' . $img . '" /></td>
                <td style="text-align: center">' . $t->FLENG . '</td>
                <td style="text-align: center">' . $t->FWIDTH . '</td>
                <td style="text-align: center">' . $t->FTHK . '</td>
                <td style="text-align: center">' . round($t->WEIGHT, 2) . '</td>
                <td style="text-align: center">' . round($t->AREA, 2) . '</td>
                <td style="text-align: center"><img style="max-height: 50px;" id="bar-' . $code1 . '" class="barcode" code="' . $code1 . '" /></td>
                <td style="text-align: center"><img style="max-height: 50px;" id="bar-' . $code2 . '" class="barcode" code="' . $code2 . '" /></td>
                <td>'. $t->TEXT1 . '</td>
            </tr>';
            
        endforeach;
        return $tbody;
    }

    function CreateBodyIronWorks($id, $order, $array) {
        $IronRecord = $this->M_Order->ListIronWorksALL($id, $order);
        $item = 1;
        $sum = 0;
        $tbody = "";

        foreach ($IronRecord as $t) :

            $descAX = $this->M_Order->ChargedCodeAXiron($t->ARTICLE_ID);
            $desc = strtoupper((!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $t->TEXT_SHORT . " (Crear En AX)");
            $und = (empty($descAX)) ? '' : $descAX->UNITID;

            $tbody .= "<tr>
                        <td  style='text-align:center'>" . $item . "</td>
                        <td  style='text-align:center'>" . $t->ARTICLE_ID . "</td>
                        <td>" . $desc . "</td>
                        <td style='text-align:center'>" . $t->PURCHCNT . "</td>
                        <td style='text-align:center'>" . $und . "</td>
                     </tr>";
            $item++;
            $sum += $t->PURCHCNT;

            if (array_key_exists($t->ARTICLE_ID, $array)) {
                $array[$t->ARTICLE_ID]["qty"] += $t->PURCHCNT;
            } else {
                $array[$t->ARTICLE_ID] = array("desc" => $desc, "uni" => $und, "qty" => $t->PURCHCNT);
            }

        endforeach;

        $AdAditional = $this->M_Order->LoadImosAditional($id, $order);

        foreach ($AdAditional as $i) :
            $desc = strtoupper("Adic Add." . $i->description);

            $tbody .= "<tr>
                        <td  style='text-align:center'>" . $item . "</td>
                        <td  style='text-align:center'>" . $i->code . "</td>
                        <td>" . $desc . "</td>
                        <td style='text-align:center'>" . $i->qty . "</td>
                        <td style='text-align:center'>" . $i->unity . "</td>
                     </tr>";
            $item++;
            $sum += $i->qty;

            if (array_key_exists($i->code, $array)) {
                $array[$i->code]["qty"] += $i->qty;
            } else {
                $array[$i->code] = array("desc" => $desc, "uni" => $i->unity, "qty" => $i->qty);
            }

        endforeach;

        return array("tbody" => $tbody, "sum" => $sum, "item" => $item, "consolidate" => $array);
    }

    function CreateBodyIronWorksAck($id, $idsales, $d) {
        $item = $d['item'];
        $sum = $d['sum'];
        $tbody = $d['tbody'];
        $AdIronRecord = $this->M_Acknow->ListAdIronWorksItem($id, $idsales);
        $array = $d['consolidate'];
        foreach ($AdIronRecord as $t) :

            $descAX = $this->M_Order->ChargedCodeAXiron($t->code);
            $desc = strtoupper((!empty($descAX->ITEMNAME)) ? "Adic Ack." . $descAX->ITEMNAME : "Adic Ack." . $t->description . "(Crear En AX)");
            $und = (empty($descAX)) ? '' : $descAX->UNITID;


            $tbody .= "<tr>
                        <td  style='text-align:center'>" . $item . "</td>
                        <td  style='text-align:center'>" . $t->code . "</td>
                        <td>" . $desc . "</td>
                        <td style='text-align:center'>" . $t->qty . "</td>
                        <td style='text-align:center'>" . $und . "</td>
                     </tr>";

            $item++;
            $sum += $t->qty;

            if (array_key_exists($t->code, $array)) {
                $array[$t->code]["qty"] += $t->qty;
            } else {
                $array[$t->code] = array("desc" => $desc, "uni" => $und, "qty" => $t->qty);
            }

        endforeach;

        return array("tbody" => $tbody, "sum" => $sum, "item" => $item, "consolidate" => $array);
    }

    function ConsolidateSheet($order) {
        $data['order'] = $order;
        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $data['Header'] = $this->M_Order->ListOrderImosAll($order);
        $sheets = $this->M_Order->ListConsSheet($order);
//        var_dump($sheets
        //print_r($sheets);
        $data['html'] = "";
        $data['html2'] = "";
        $error = array();
        $push = array();
        $count = 0;
        $val = "";
        
        foreach ($sheets as $value):
            //print_r($value);
//            $data['html2'] .= '<tr>
//                    <td style="text-align: center" >' . $value->MATNAME . '</td>
//                    <td style="text-align: center">'.$value->MT2.'</td> 
//                    <td style="text-align: center">'.$value->WEIGHT.'</td>    
//                </tr>';
//            echo '<br><br>';
            $row = $this->M_Order->LoadSheet($value->MATNAME);
            if(is_object($row)){
                
                $mts = $value->MT2;
                $wst = $mts * $row->waste;
                $mts_sheet = $wst/$row->area;
                
                //$count = $wst;
                if($val == $value->MATNAME){
                    $count = $count + $wst;
                }else{
                    $count = $wst;
                }
                $val = $value->MATNAME;
                
                if(array_key_exists($value->MATNAME, $push)){
                    $push[$value->MATNAME]['mts_sheet'] += $mts_sheet;
                    $push[$value->MATNAME]['wst'] = $count;
                }else{
                    $push[$value->MATNAME] = array("format"=>$row->format,"wst"=>$count,"mts_sheet"=>$mts_sheet);
                }

                if(empty($row->waste)){
                    $error[$value->MATNAME] = "NO TIENE DESPERDICIO ASOCIADO";
                }
            }else{
                $error[$value->MATNAME] = "NO EXISTE EN LA BASE DE DATOS";
            }
        endforeach;
        

            foreach ($error as $key  =>$msg) {
                $data['html'] .= '<tr>
                    <td style="text-align: center" >' . $key . '</td>
                    <td style="text-align: center" colspan="3">'.$msg.'</td>
                </tr>';
            }

            $total = 0;
            foreach ($push as $key => $value) :
                $data['html'] .= '<tr>
                    <td style="text-align: center">' . $key . '</td>
                    <td style="text-align: center">' . $value['format'] . '</td>
                    <td style="text-align: center">' . number_format($value['wst'],4,'.',',') . '</td>
                    <td style="text-align: center">' . number_format($value['mts_sheet'],4,'.',',') . '</td> 
                </tr>';
                $total += $value['mts_sheet']; 
            endforeach;
            $data['html'] .= '<tr>
                    <td style="text-align: right" colspan="3"><b>TOTAL</b></td>
                    <td style="text-align: center" >'.number_format($total,4,'.',',').'</td>
                </tr>';
       
        $this->load->view("Imos/Order/Pdf/V_Cons_Sheet", $data);
        
    }

    function ConsolidateCanto($order) {
        $data['order'] = $order;
        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $data['Header'] = $this->M_Order->ListOrderImosAll($order);
        $cantos = $this->M_Order->ListConsCanto($order);

        //$desp = 0.02;
        $desp = 0.06; // cambio pd bogota
        $array = array();
        foreach ($cantos as $c) :
            if (array_key_exists($c->PRFNAME, $array)) {
                $array[$c->PRFNAME]["mtr"] += $c->CONTLEN;
                $array[$c->PRFNAME]["total"] += ($c->CONTLEN + DESP);
            } else {
                $descAX = $this->M_Order->ChargedCodeAXiron($c->PRFNAME);
                $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $c->PRFNAME . "(Crear En AX)";

                $array[$c->PRFNAME] = array("desc" => $desc, "mtr" => $c->CONTLEN, "total" => ($c->CONTLEN + DESP));
            }
        endforeach;

        $data['desp'] = $desp;
        $data['array'] = $array;

        $this->load->view("Imos/Order/Pdf/V_Cons_Canto", $data);
    }
    function ConsolidateSheet2($order) {
        $data['order'] = $order;
        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));

        $sheets = $this->M_Order->ListConsSheet($order);

        $data['html'] = '<table><tr>
                    <th style="text-align: center">MATERIAL</th>
                    <!--<th style="text-align: center" width="54%">DESCRIPCION</th>-->
                    <th style="text-align: center">LARGO</th>
                    <th style="text-align: center">ANCHO</th>
                    <th style="text-align: center">FORMATO</th>
                    <th style="text-align: center">% Desp</th>
                    <th style="text-align: center">MEDIDAS M^2</th>
                    <th style="text-align: center">DESPERDICIO</th>
                    <th style="text-align: center">M^2 LAMINA</th>
                </tr>';
        $error = array();
       
        foreach ($sheets as $value):

            $row = $this->M_Order->LoadSheet($value->MATNAME);
            if(is_object($row)){
                $data['html'] .= '<tr>
                    <td style="text-align: center">' . $value->MATNAME . '</td>
                    <td style="text-align: center">' . $value->FLENG . '</td>
                    <td style="text-align: center">' . $value->FWIDTH . '</td>
                    <td style="text-align: center">' . $row->format . '</td>
                    <td style="text-align: center">' . $row->waste . '</td>
                    <td style="text-align: center">' . number_format($value->MT2,4,'.',',') . '</td>
                    <td style="text-align: center">' . number_format($value->MT2 * $row->waste,4,'.',',') . '</td>
                    <td style="text-align: center">' . number_format(($value->MT2 * $row->waste)/$row->area,4,'.',',') . '</td>
                </tr>';
                
                if(empty($row->waste)){
                    $error[$value->MATNAME] = "NO TIENE DESPERDICIO ASOCIADO";
                }
            }else{
                $error[$value->MATNAME] = "NO EXISTE EN LA BASE DE DATOS";
            }
        endforeach;
        
        if(count($error)>0){
            $data['html'] = "";
            foreach ($error as $key  =>$msg) {
                $data['html'] .= '<tr>
                    <td style="text-align: center" >' . $key . '</td>
                    <td style="text-align: center" colspan="3">'.$msg.'</td>
                </tr>';
            }
        }
       
        $this->load->view("Imos/Order/Pdf/V_Cons_Sheet", $data);
        
    }
    

    function Pieces2($id, $order, $cpid, $idProadmin, $article) {
        setlocale(LC_TIME, "spanish");
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetMargins(5, 3, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('dejavusans', '', 6);

        $pdf->AddPage();
        $pdf->Image(URL_IMAGE.$this->session->company, 235, 17, 50, 20, 'jpg', '', 'C', true, 150, '', false, false, 0, false, false, false);
        $data['id'] = $id;
        $data['order'] = $order;
        $data['cpid'] = $cpid;
        $data['article'] = $article;
        $data['title'] = "Listado de Piezas";
        $PiecesRecord = $this->M_Order->ListPiecesALL($id, $order);

        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));

        $cab = $this->load->view("Imos/Order/Pdf/V_Order_Head", $data, true);
        $det = $this->load->view("Imos/Order/Pdf/V_Order_Detail", $data, true);
        $images = $this->load->view("Imos/Order/Pdf/V_Order_Img", $data, true);


        $html = $cab . $det . $images;
        $style = array(
            'position' => '',
            'align' => '',
            'stretch' => true,
            'fitwidth' => false,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );


        $pdf->SetFillColor(222, 222, 222);
        $pdf->writeHTML($html, false, true, true);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(24, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, 'TIPO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, 'ACABADO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, 'LAMINA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(22, 5, 'CANTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, 'IMG', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'ALTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'ANCHO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'CALIBRE', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'PESO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(16, 5, 'AREA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(32, 5, 'COD. BARRA 1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(33, 5, 'COD. BARRA 2', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 8);
        foreach ($PiecesRecord as $t) :

            $arrayCantos = explode(";", $t->cantos);
            $arrayGeneral = array(" 1 : N/A ", " 2 : N/A ", " 3 : N/A ", " 4 : N/A ");
            if (!empty($t->cantos)) {
                foreach ($arrayCantos as $a):
                    $arrayCanto = explode("-", $a);
                    $arrayGeneral[$arrayCanto[0] - 1] = " " . $arrayCanto[0] . " : " . $arrayCanto[1] . " ";
                endforeach;
            }
            $canto = "$arrayGeneral[0]<br />$arrayGeneral[1]<br />$arrayGeneral[2]<br />$arrayGeneral[3]";
            $img = SERVER_IMOS . "/$order/BITMAPS/$t->ID.png";

            $_POST['idbgpl'] = $t->ID;
            $_POST['order'] = $order;
            $codes = $this->M_Order->ChargedBarcode();


            $pdf->MultiCell(24, 16, (empty($t->IDPIEZA)) ? "" : $t->IDPIEZA . "-" . $t->FLENG . "X" . $t->FWIDTH, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(20, 16, $t->NAME, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(30, 16, $t->RENDERPMAT, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(20, 16, $t->MATNAME, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->writeHTMLCell(22, 16, $pdf->GetX(), $pdf->GetY(), $canto, 1, 0, 0, true, 'M', true);
            $pdf->Image($img, $pdf->GetX(), $pdf->GetY(), 30, 16, 'png', '', 'C', true, 150, '', false, false, 1, false, false, false);
            $pdf->MultiCell(30, 16, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(15, 16, $t->FLENG, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(15, 16, $t->FWIDTH, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(15, 16, $t->FTHK, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(15, 16, round($t->WEIGHT, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            $pdf->MultiCell(16, 16, round($t->AREA, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');

            if (!empty($codes[0]['CNC_NAME'])) {
                $pdf->write1DBarcode(str_replace("_", "-", $codes[0]['CNC_NAME']), 'C39', $pdf->GetX(), $pdf->GetY(), 32, 16, 0.4, $style, 'T');
            } else {
                $pdf->MultiCell(32, 16, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
            }
            if (!empty($codes[1]['CNC_NAME'])) {
                $pdf->write1DBarcode(str_replace("_", "-", $codes[1]['CNC_NAME']), 'C39', $pdf->GetX(), $pdf->GetY(), 33, 16, 0.4, $style, 'N');
            } else {
                $pdf->MultiCell(33, 16, "", 1, 'C', 0, 1, '', '', true, 0, false, true, 16, 'M');
            }

            $pdf->MultiCell(287, 5, "Comentarios " . $t->IDPIEZA . "-" . $t->FLENG . "X" . $t->FWIDTH . " :", 1, 'L', 0, 1, '', '', true, 0, false, true, 5, 'T');

            if ($pdf->GetY() >= 173) {//174
                $pdf->AddPage();
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(24, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'TIPO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'ACABADO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'LAMINA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(22, 5, 'CANTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'IMG', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, 'ALTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, 'ANCHO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, 'CALIBRE', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, 'PESO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(16, 5, 'AREA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(32, 5, 'COD. BARRA 1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(33, 5, 'COD. BARRA 2', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 8);
            }
        endforeach;
        $pdf->ln();
        if ($pdf->GetY() >= 173) {
            $pdf->AddPage();
        }
        $AdAditional = $this->M_Order->LoadImosAditional($id, $order);
        $AdIronRecord = array();
        if (is_object($data['HeaderRecord'])) {
            $AdIronRecord = $this->M_Acknow->LoadDetailsAcknowledgement($data['HeaderRecord']->id_import_salestable, $id);
        }


        if (count($AdAditional) > 0 || count($AdIronRecord) > 0) {
            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->MultiCell(287, 10, "PIEZAS ADICIONALES", 1, 'C', 0, 1, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 5, 'CODIGO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(100, 5, 'DESCRIPCION', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(50, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(29, 5, 'ALTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(29, 5, 'ANCHO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(29, 5, 'PROFUNDIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 8);

            foreach ($AdAditional as $t) :
                $pdf->MultiCell(50, 5, $t->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(100, 5, $t->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(50, 5, $t->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->height, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->width, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->depth, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
            endforeach;
            foreach ($AdIronRecord as $t) :
                $pdf->MultiCell(50, 5, $t->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(100, 5, $t->description, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(50, 5, $t->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->height, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->width, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(29, 5, $t->depth, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
            endforeach;
        }
        $pdf->SetTitle("Piezas " . $article);
        $pdf->Output($order . '.pdf', 'I');
    }

    function PiecesAll2($order) {
        setlocale(LC_TIME, "spanish");
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetMargins(5, 3, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('dejavusans', '', 6);

        $pdf->AddPage();
        $pdf->Image(URL_IMAGE.$this->session->company, 235, 17, 50, 20, 'jpg', '', 'C', true, 150, '', false, false, 0, false, false, false);
        $data['order'] = $order;
        $data['title'] = "Listado de Piezas por Pedido por Mueble";

        $style = array(
            'position' => '',
            'align' => '',
            'stretch' => true,
            'fitwidth' => false,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $cab = $this->load->view("Imos/Order/Pdf/V_Order_Head", $data, true);

        $items = $this->M_Order->ListOrderItemImosAll($order);

        $pdf->SetFillColor(222, 222, 222);
        $pdf->writeHTML($cab, false, true, true);

        foreach ($items as $i) :
            $nameid = (!empty($i->INFO1) ? $i->INFO1 : (!empty($i->INFO2) ? $i->INFO2 : (!empty($i->INFO3) ? $i->INFO3 : $i->CPID)));
            $nameid = ($nameid == 'PN') ? $i->CPID . $i->DEPTH : $nameid;

            $data['id'] = $i->ID;
            $data['cpid'] = $i->CPID;

            if ($pdf->GetY() >= 80) {
                $pdf->AddPage();
            }
            $html = $this->load->view("Imos/Order/Pdf/V_Order_Detail", array("article" => $nameid), true);
            $html .= $this->load->view("Imos/Order/Pdf/V_Order_Img", $data, true);
            $pdf->writeHTML($html, false, true, true);

            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->MultiCell(24, 5, 'COD AX' . $pdf->GetY(), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, 'TIPO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, 'ACABADO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, 'LAMINA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(22, 5, 'CANTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, 'IMG', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, 'ALTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, 'ANCHO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, 'CALIBRE', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, 'PESO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(16, 5, 'AREA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(32, 5, 'COD. BARRA 1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(33, 5, 'COD. BARRA 2', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
            $pdf->SetFont('helvetica', '', 8);

            $PiecesRecord = $this->M_Order->ListPiecesALL($i->ID, $order);

            foreach ($PiecesRecord as $t) :

                $arrayCantos = explode(";", $t->cantos);
                $arrayGeneral = array(" 1 : N/A ", " 2 : N/A ", " 3 : N/A ", " 4 : N/A ");
                if (!empty($t->cantos)) {
                    foreach ($arrayCantos as $a):
                        $arrayCanto = explode("-", $a);
                        $arrayGeneral[$arrayCanto[0] - 1] = " " . $arrayCanto[0] . " : " . $arrayCanto[1] . " ";
                    endforeach;
                }
                $canto = "$arrayGeneral[0]<br />$arrayGeneral[1]<br />$arrayGeneral[2]<br />$arrayGeneral[3]";
                $img = SERVER_IMOS . "/$order/BITMAPS/$t->ID.png";

                $_POST['idbgpl'] = $t->ID;
                $_POST['order'] = $order;
                $codes = $this->M_Order->ChargedBarcode();


                $pdf->MultiCell(24, 16, (empty($t->IDPIEZA)) ? "" : $t->IDPIEZA . "-" . $t->FLENG . "X" . $t->FWIDTH, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(20, 16, $t->NAME, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(30, 16, $t->RENDERPMAT, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(20, 16, $t->MATNAME, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->writeHTMLCell(22, 16, $pdf->GetX(), $pdf->GetY(), $canto, 1, 0, 0, true, 'M', true);
                $pdf->Image($img, $pdf->GetX(), $pdf->GetY(), 30, 16, 'png', '', 'C', true, 150, '', false, false, 1, false, false, false);
                $pdf->MultiCell(30, 16, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(15, 16, $t->FLENG, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(15, 16, $t->FWIDTH, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(15, 16, $t->FTHK, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(15, 16, round($t->WEIGHT, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                $pdf->MultiCell(16, 16, round($t->AREA, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');

                if (!empty($codes[0]['CNC_NAME'])) {
                    $pdf->write1DBarcode(str_replace("_", "-", $codes[0]['CNC_NAME']), 'C39', $pdf->GetX(), $pdf->GetY(), 32, 16, 0.4, $style, 'T');
                } else {
                    $pdf->MultiCell(32, 16, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
                }
                if (!empty($codes[1]['CNC_NAME'])) {
                    $pdf->write1DBarcode(str_replace("_", "-", $codes[1]['CNC_NAME']), 'C39', $pdf->GetX(), $pdf->GetY(), 33, 16, 0.4, $style, 'N');
                } else {
                    $pdf->MultiCell(33, 16, "", 1, 'C', 0, 1, '', '', true, 0, false, true, 16, 'M');
                }

                $pdf->MultiCell(287, 5, "Comentarios " . $t->IDPIEZA . "-" . $t->FLENG . "X" . $t->FWIDTH . " :", 1, 'L', 0, 1, '', '', true, 0, false, true, 5, 'T');

                if ($pdf->GetY() >= 173) {//174
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->MultiCell(24, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'TIPO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(30, 5, 'ACABADO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'LAMINA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(22, 5, 'CANTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(30, 5, 'IMG', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, 'ALTO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, 'ANCHO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, 'CALIBRE', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, 'PESO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(16, 5, 'AREA', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(32, 5, 'COD. BARRA 1', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(33, 5, 'COD. BARRA 2', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 8);
                }
            endforeach;

        endforeach;

        $pdf->SetTitle("Pedido Piezas " . $order);
        $pdf->Output($order . '.pdf', 'I');
    }

    function IronWorks2($id, $order, $cpid, $idProadmin, $article) {
        setlocale(LC_TIME, "spanish");
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetMargins(5, 3, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('dejavusans', '', 6);

        $pdf->AddPage();
        $pdf->Image(URL_IMAGE.$this->session->company, 235, 17, 50, 20, 'jpg', '', 'C', true, 150, '', false, false, 0, false, false, false);
        $data['id'] = $id;
        $data['order'] = $order;
        $data['cpid'] = $cpid;
        $data['title'] = "Listado de Herrajes del pedido por Mueble";
        $data['article'] = $article;


        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));

        $cab = $this->load->view("Imos/Order/Pdf/V_Order_Head", $data, true);
        $det = $this->load->view("Imos/Order/Pdf/V_Order_Detail", $data, true);
        $html = $cab . $det;
        $pdf->SetFillColor(222, 222, 222);
        $pdf->writeHTML($html, false, true, true);

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');

        $IronRecord = $this->M_Order->ListIronWorksALL($id, $order);


        $pdf->SetFont('helvetica', '', 8);
        $item = 1;
        $sum = 0;
        foreach ($IronRecord as $t) :

            $descAX = $this->M_Order->ChargedCodeAXiron($t->ARTICLE_ID);
            $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $t->TEXT_SHORT . " (Crear En AX)";
            $und = (empty($descAX)) ? '' : $descAX->UNITID;

            $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(25, 5, $t->ARTICLE_ID, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, $t->PURCHCNT, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
            $item++;
            $sum += $t->PURCHCNT;
            if ($pdf->GetY() >= 270) {
                $pdf->AddPage();
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 8);
            }
        endforeach;

        if (is_object($data['HeaderRecord'])) {
            $idsales = $data['HeaderRecord']->id_import_salestable;
            $AdIronRecord = $this->M_Acknow->ListAdIronWorksItem($id, $idsales);
            //loop find Iron Aditional Table
            foreach ($AdIronRecord as $t) :

                $descAX = $this->M_Order->ChargedCodeAXiron($t->code);
                $desc = (!empty($descAX->ITEMNAME)) ? "Adic." . $descAX->ITEMNAME : "Adic." . $t->description . "(Crear En AX)";
                $und = (empty($descAX)) ? '' : $descAX->UNITID;

                $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(25, 5, $t->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(20, 5, $t->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
                $item++;
                $sum += $t->qty;
                if ($pdf->GetY() >= 270) {
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 8);
                }

            endforeach;
        }

        $AdAditional = $this->M_Order->LoadImosAditional($id, $order);

        foreach ($AdAditional as $i) :
            $desc = "Adic." . $i->description;
            $und = "";

            $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(25, 5, $i->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, $i->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
            $item++;
            $sum += $i->qty;
            if ($pdf->GetY() >= 270) {
                $pdf->AddPage();
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                $pdf->SetFont('helvetica', '', 8);
            }

        endforeach;


        $pdf->MultiCell(160, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
        $pdf->MultiCell(20, 5, round($sum, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
        $pdf->MultiCell(20, 5, '', 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');

        $pdf->SetTitle("Herrajes " . $article);
        $pdf->Output($order . '.pdf', 'I');
    }

    function IronWorksAll2($order) {
        setlocale(LC_TIME, "spanish");
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetMargins(5, 3, 5);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('dejavusans', '', 6);

        $pdf->AddPage();
        $pdf->Image(URL_IMAGE.$this->session->company, 235, 17, 50, 20, 'jpg', '', 'C', true, 150, '', false, false, 0, false, false, false);
        $data['title'] = "Listado de Herrajes del Pedido por Mueble";
        $data['order'] = $order;

        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $cab = $this->load->view("Imos/Order/Pdf/V_Order_Head", $data, true);

        $items = $this->M_Order->ListOrderItemImosAll($order);

        $pdf->SetFillColor(222, 222, 222);
        $pdf->writeHTML($cab, false, true, true);

        foreach ($items as $t) :
            $nameid = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : ($t->CPID == 'PN') ? $t->CPID . $t->DEPTH : $t->CPID)));
            $nameid = ($nameid == 'PN') ? $t->CPID . $t->DEPTH : $nameid;
            if ($pdf->GetY() >= 260) {
                $pdf->AddPage();
            }
            $html = $this->load->view("Imos/Order/Pdf/V_Order_Detail", array("article" => $nameid), true);

            $pdf->writeHTML($html, false, true, true);

            $pdf->SetFont('helvetica', 'B', 8);
            $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');

            $IronRecord = $this->M_Order->ListIronWorksALL($t->ID, $order);

            $pdf->SetFont('helvetica', '', 8);
            $item = 1;
            $sum = 0;
            foreach ($IronRecord as $i) :

                $descAX = $this->M_Order->ChargedCodeAXiron($i->ARTICLE_ID);
                $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $i->TEXT_SHORT . " (Crear En AX)";
                $und = (empty($descAX)) ? '' : $descAX->UNITID;

                $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(25, 5, $i->ARTICLE_ID, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(20, 5, $i->PURCHCNT, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
                $item++;
                $sum += $i->PURCHCNT;
                if ($pdf->GetY() >= 270) {
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 8);
                }
            endforeach;

            $AdAditional = $this->M_Order->LoadImosAditional($t->ID, $order);

            if (is_object($data['HeaderRecord'])) {
                $AdIronRecord = $this->M_Acknow->ListAdIronWorksItem($t->ID, $data['HeaderRecord']->id_import_salestable);
                //loop find Iron Aditional Table
                if ($pdf->GetY() >= 270) {
                    $pdf->AddPage();
                    $pdf->SetFont('helvetica', 'B', 8);
                    $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX ADICIONAL', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                    $pdf->SetFont('helvetica', '', 8);
                }
                foreach ($AdIronRecord as $i) :

                    $descAX = $this->M_Order->ChargedCodeAXiron($i->code);
                    $desc = (!empty($descAX->ITEMNAME)) ? "Adic." . $descAX->ITEMNAME : "Adic." . $i->description . "(Crear En AX)";
                    $und = (empty($descAX)) ? '' : $descAX->UNITID;

                    $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(25, 5, $i->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(20, 5, $i->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
                    $item++;
                    $sum += $i->qty;
                    if ($pdf->GetY() >= 270) {
                        $pdf->AddPage();
                        $pdf->SetFont('helvetica', 'B', 8);
                        $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                        $pdf->SetFont('helvetica', '', 8);
                    }

                endforeach;

                foreach ($AdAditional as $i) :

                    //$descAX = $this->M_Order->ChargedCodeAXiron($i->code);
//                    $desc = (!empty($descAX->ITEMNAME)) ? "Adic." . $descAX->ITEMNAME : "Adic." . $i->description . "(Crear En AX)";
//                    $und = (empty($descAX)) ? '' : $descAX->UNITID;
                    $desc = "Adic." . $i->description;
                    $und = "";

                    $pdf->MultiCell(10, 5, $item, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(25, 5, $i->code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(125, 5, strtoupper($desc), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(20, 5, $i->qty, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
                    $pdf->MultiCell(20, 5, $und, 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
                    $item++;
                    $sum += $i->qty;
                    if ($pdf->GetY() >= 270) {
                        $pdf->AddPage();
                        $pdf->SetFont('helvetica', 'B', 8);
                        $pdf->MultiCell(10, 5, 'NO', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, 'COD AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(125, 5, 'DESCRIPCIÓN AX', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, 'CANTIDAD', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, 'UNIDAD', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
                        $pdf->SetFont('helvetica', '', 8);
                    }

                endforeach;
            }
            $pdf->MultiCell(160, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, round($sum, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M', true);
            $pdf->MultiCell(20, 5, '', 1, 'C', 0, 1, '', '', true, 0, false, true, 5, 'M');
        endforeach;



        $pdf->SetTitle("Consolidado De Herrajes");
        $pdf->Output($order . '.pdf', 'I');
    }
    
    function ConsolidatedTotal($order){
        $data['order'] = $order;
        $data['title'] = "LISTADO DE MATERIALES DEL PEDIDO";
        $data['HeaderRecord'] = $this->M_Acknow->ListHeaderAck(str_replace('_', '-', $order));
        $data['Header'] = $this->M_Order->ListOrderImosAll($order);
        $this->load->view("Imos/Order/Pdf/V_Order_Head", $data);
        
        //herrajes
        $items = $this->M_Order->ListOrderItemImosAll($order);
        
        $d['consolidate'] = array();
        foreach ($items as $t) :
            
            $nameid = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : $t->CPID)));
            $nameid = ($nameid == 'PN') ? $t->CPID . $t->DEPTH : $nameid;
            $data['article'] = $nameid;
            $data['position'] = $t->POSSTR;
            $data['med'] = $t->HEIGHT . "x" . $t->WIDTH. "x" . $t->DEPTH;
            $d = $this->CreateBodyIronWorks($t->ID, $order, $d['consolidate']);
            
        endforeach;
        $array = $d['consolidate'];
        //var_dump($d['consolidate']);
        
        
        $item = 1;
        $c['tbody'] = "";
        $c['sum'] = 0;
        $c['consolidado'] = true;
        $c['tbody'] = '<tr> 
                <td colspan="5" style="text-align:center;background-color: #e4e4e4;">HERRAJES</td>
            <tr/>';
        foreach ($array as $key => $i) {
            $c['tbody'] .= '<tr>
                    <td style="text-align: center">' . $item++ . '</td>
                    <td style="text-align: center">' . $key . '</td>
                    <td>' . $i['desc'] . '</td>
                    <td style="text-align: center">' . $i['qty'] . '</td>
                    <td style="text-align: center">' . $i['uni'] . '</td>
                </tr>';
            $c['sum'] += $i['qty'];
        }
        $c['tbody'] .= '<tr style="background-color: #e4e4e4;"><th style="text-align: right;" colspan="3">Total Herrajes</th><th>'.$c['sum'].'</th><th></th></tr>';
        //**************************
        
        
        //laminas
        $push = array();
        $count = 0;
        $val = "";
        $sheets = $this->M_Order->ListConsSheet($order);
        //print_r($sheets);
        foreach ($sheets as $key => $value) {
            $row = $this->M_Order->LoadSheet($value->MATNAME);
            if(is_object($row)){
                
                $mts = $value->MT2;
                $wst = $mts * $row->waste;
                $mts_sheet = $wst/$row->area;
                
                //$count = $wst;
                if($val == $value->MATNAME){
                    $count = $count + $wst;
                }else{
                    $count = $wst;
                }
                $val = $value->MATNAME;
                
                if(array_key_exists($value->MATNAME, $push)){
                    $push[$value->MATNAME]['mts_sheet'] += $mts_sheet;
                    $push[$value->MATNAME]['wst'] = $count;
                }else{
                    $push[$value->MATNAME] = array("code" => $row->code,"description" => $row->description,"format"=>$row->format,"wst"=>$count,"mts_sheet"=>$mts_sheet);
                }
            }else{
                $error[$value->MATNAME] = "NO EXISTE EN LA BASE DE DATOS";
            }
        }
        
        $c['tbody'] .= '<tr>
                <td colspan="5" style="text-align:center;background-color: #e4e4e4;">LÁMINAS</td>
            <tr/>';
        $total_l = 0;
        foreach ($push as $key => $value) :
            $c['tbody'] .= '<tr>
                <td style="text-align:center">'.$item++.'</td>
                <td style="text-align:center">'. $value['code'].'</td>
                <td>' . $value['description'] . '</td>
                <td style="text-align: center">'. number_format($value['mts_sheet'],4,'.',',') .'</td>
                <td style="text-align: center">Lam</td>
            </tr>';
            $total_l = $total_l + $value['mts_sheet'];
        endforeach;
        $c['tbody'] .= '<tr style="background-color: #e4e4e4;"><th style="text-align: right;" colspan="3">Total Láminas</th><th>'.number_format((float)$total_l , 4, '.', '').'</th><th></th></tr>';
        
        
        //cantos
        $cantos = $this->M_Order->ListConsCanto($order);
        
        $total_c = 0;
        $desp = 0.06; // cambio pd bogota
        $array_c = array();
        foreach ($cantos as $ca) :
            if (array_key_exists($ca->PRFNAME, $array_c)) {
                //print_r($array_c[$ca->PRFNAME]["mtr"]."<br>");
                //$array_c[$ca->PRFNAME]["mtr"] += $ca->CONTLEN;
                $array_c[$ca->PRFNAME]["total"] += ($ca->CONTLEN + DESP);
            } else {
                $descAX = $this->M_Order->ChargedCodeAXiron($ca->PRFNAME);
                $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $ca->PRFNAME . "(Crear En AX)";
                $array_c[$ca->PRFNAME] = array("desc" => $desc, "mtr" => $ca->CONTLEN, "total" => ($ca->CONTLEN + DESP));
            }
        endforeach;
        
        $c['tbody'] .= '<tr>
                <td colspan="5" style="text-align:center;background-color: #e4e4e4;">CANTOS</td>
            <tr/>';
        foreach ($array_c as $key => $value):
            $c['tbody'] .= '<tr>
                <td style="text-align:center">'.$item++.'</td>
                <td style="text-align:center">'. $key.'</td>
                <td>' . $value['desc'] . '</td>
                <td style="text-align: center">' .number_format((float)$value['total'] , 2, '.', ','). '</td>
                <td style="text-align: center">MTS</td>
            </tr>';
        $total_c = $total_c + $value['total'];
        endforeach;
        $c['tbody'] .= '<tr style="background-color: #e4e4e4;"><th style="text-align: right;" colspan="3">Total Cantos</th><th>'.number_format((float)$total_c , 2, '.', '').'</th><th></th></tr>';
        
        //print_r($array);
        
        $this->load->view("Imos/Order/Pdf/V_Consolidate_Total", array("data"=>$c));
        //$this->load->view("Imos/Order/Pdf/V_Consolidate_Total", $ad);
    }
    
    function validate_LMAT(){
        $order = $this->input->post('name');
        //echo $order;
        $items = $this->M_Order->ListOrderItemImosAll($order);
        $ironwork = $this->M_Order->Get_Sum_Ironwork($order);
        //print_r($items);
        
        //lamina
        $push = array();
        $code = array();
        $count = 0;
        $val = "";
        $vali = 0;
        $sheets = $this->M_Order->ListConsSheet($order);
        foreach ($sheets as $key => $value) {
            $row = $this->M_Order->LoadSheet($value->MATNAME);
            if(!is_object($row)){
                $vali = 1;
                break;
            }
        }
        
        // canto
        $cantos = $this->M_Order->ListConsCanto($order);
        
        $code_c = array();
        $total_c = 0;
        $desp = 0.02;
        $array_c = array();
        foreach ($cantos as $ca) :
            if (!array_key_exists($ca->PRFNAME, $array_c)) {
                //$array_c[$ca->PRFNAME]["mtr"] += $ca->CONTLEN;
                $descAX = $this->M_Order->ChargedCodeAXiron($ca->PRFNAME);
                $vali = (!empty($descAX->ITEMNAME)) ? 0 : 1;
                break;
            }
        endforeach;

        echo json_encode($vali);
    }
    
    function ExportLMAT(){
        $order = $this->input->get('name');
        //echo $order;
        $items = $this->M_Order->ListOrderItemImosAll($order);
        $ironwork = $this->M_Order->Get_Sum_Ironwork($order);
        //print_r($items);
        // herraje
        $d['consolidate'] = array();
        foreach ($items as $key => $t) :
            $nameid = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : $t->CPID)));
            $nameid = ($nameid == 'PN') ? $t->CPID . $t->DEPTH : $nameid;
            $data[$key]['article'] = $nameid;
            $data[$key]['position'] = $t->POSSTR;
            $data[$key]['med'] = $t->HEIGHT . "x" . $t->WIDTH. "x" . $t->DEPTH;
            
            //$d = $this->CreateBodyIronWorks($t->ID, $order, $d['consolidate']);
        endforeach;
        
        //lamina
        $push = array();
        $code = array();
        $count = 0;
        $val = "";
        $sheets = $this->M_Order->ListConsSheet($order);
        foreach ($sheets as $key => $value) {
            $row = $this->M_Order->LoadSheet($value->MATNAME);
            if(is_object($row)){
                
                $mts = $value->MT2;
                $wst = $mts * $row->waste;
                $mts_sheet = $wst/$row->area;
                
                //$count = $wst;
                if($val == $value->MATNAME){
                    $count = $count + $wst;
                }else{
                    $count = $wst;
                }
                $val = $value->MATNAME;
                
                if(array_key_exists($value->MATNAME, $push)){
                    $push[$value->MATNAME]['mts_sheet'] += $mts_sheet;
                    $push[$value->MATNAME]['wst'] = $count;
                }else{
                    $code[] = $value->MATNAME;
                    $push[$value->MATNAME] = array("code" => $row->code,"description" => $row->description,"format"=>$row->format,"wst"=>$count,"mts_sheet"=>$mts_sheet);
                }
            }else{
                $error[$value->MATNAME] = "NO EXISTE EN LA BASE DE DATOS";
                //return false;
            }
        }
        
        // canto
        $cantos = $this->M_Order->ListConsCanto($order);
        
        $code_c = array();
        $total_c = 0;
        $desp = 0.02;
        $array_c = array();
        foreach ($cantos as $ca) :
            if (array_key_exists($ca->PRFNAME, $array_c)) {
                $array_c[$ca->PRFNAME]["mtr"] += ($ca->CONTLEN + DESP);
            } else {
                $code_c[] = $ca->PRFNAME;
                $descAX = $this->M_Order->ChargedCodeAXiron($ca->PRFNAME);
                $desc = (!empty($descAX->ITEMNAME)) ? $descAX->ITEMNAME : $ca->PRFNAME . "(Crear En AX)";
                $array_c[$ca->PRFNAME] = array("code" => $ca->PRFNAME,"desc" => $desc, "mtr" => ($ca->CONTLEN + DESP));
                //return false;
            }
        endforeach;
        
        //print_r($cantos);exit;
        
        $this->load->library('excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Lmat_'.str_replace("_","-",$order));

        // TITLE
        $this->excel->getActiveSheet()->setCellValue('A1', 'H');
        $this->excel->getActiveSheet()->setCellValue('B1', str_replace("_","-",$order));
        $this->excel->getActiveSheet()->setCellValue('C1', 'ZCON308');
        $this->excel->getActiveSheet()->setCellValue('D1', '13-jun-17');
        $this->excel->getActiveSheet()->setCellValue('E1', '13-jun-17');
        $this->excel->getActiveSheet()->setCellValue('F1', '13-jun-17');
        $this->excel->getActiveSheet()->setCellValue('G1', 'LEGACY (Doral/Glossy/S2005-Y50R) White');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Apto 201 Modelo Tipo 2 Tag 95x9');
        $this->excel->getActiveSheet()->setCellValue('I1', '79137943');
        $this->excel->getActiveSheet()->setCellValue('J1', '79137943');
        $this->excel->getActiveSheet()->setCellValue('R1', '1');
        $res = 12 - strlen($order);
            $zero = "";
            for($r = 0; $r < $res; $r++){
                $zero  .= "0";
            }
            $this->excel->getActiveSheet()->setCellValue('T1', "LM".$zero.str_replace("_","-",$order)."_14660");
        
        // DATA
        $count_data = 2;
        $count_item = 0;
        foreach ($ironwork as $key => $value) {
            $count_item++;
            $this->excel->getActiveSheet()->setCellValue('A'.$count_data, 'L');
            $this->excel->getActiveSheet()->setCellValue('B'.$count_data, str_replace("_","-",$order));
            $this->excel->getActiveSheet()->setCellValue('K'.($count_data+1), $count_item);
            $this->excel->getActiveSheet()->setCellValue('L'.($count_data+1), '0'); // 0 = articulo
            $this->excel->getActiveSheet()->setCellValue('M'.($count_data+1), $value->CONID);
            $this->excel->getActiveSheet()->setCellValue('R'.($count_data+1), $value->PURCHCNT);
            $this->excel->getActiveSheet()->setCellValue('S'.($count_data+1), '0');
            
            $res = 12 - strlen($order);
            $zero = "";
            for($r = 0; $r < $res; $r++){
                $zero  .= "0";
            }
            $this->excel->getActiveSheet()->setCellValue('T'.($count_data+1), "LM".$zero.str_replace("_","-",$order)."_14660");
            
            //$count_data++;
            
            if($count_data == 2){
                $this->excel->getActiveSheet()->setCellValue('A'.$count_data, 'LQ');
                
                $this->excel->getActiveSheet()->setCellValue('K'.$count_data, '1');
                $this->excel->getActiveSheet()->setCellValue('P'.$count_data, 'PDT');
                $this->excel->getActiveSheet()->setCellValue('R'.$count_data, '1');
                $this->excel->getActiveSheet()->setCellValue('S'.$count_data, '0');
                //$this->excel->getActiveSheet()->setCellValue('T'.$count_data, '');
            }
            $count_data++;
        }
        
        
        for ($i = 0; $i < count($push); $i++){
            $count_item++;
            $this->excel->getActiveSheet()->setCellValue('A'.$count_data, 'L');
            $this->excel->getActiveSheet()->setCellValue('B'.$count_data, str_replace("_","-",$order));
            $this->excel->getActiveSheet()->setCellValue('K'.($count_data+1), $count_item);
            $this->excel->getActiveSheet()->setCellValue('L'.($count_data+1), '0'); // 0 = articulo
            $this->excel->getActiveSheet()->setCellValue('M'.($count_data+1), $push[$code[$i]]['code']);
            $this->excel->getActiveSheet()->setCellValue('R'.($count_data+1), number_format((float)$push[$code[$i]]['mts_sheet'] , 4, '.', ''));
            $this->excel->getActiveSheet()->setCellValue('S'.($count_data+1), '0');
            
            $res = 12 - strlen($order);
            $zero = "";
            for($r = 0; $r < $res; $r++){
                $zero  .= "0";
            }
            $this->excel->getActiveSheet()->setCellValue('T'.($count_data+1), "LM".$zero.str_replace("_","-",$order)."_14660");
      
            $count_data++;
        }
        
        for ($e = 0; $e < count($array_c); $e++){
            $count_item++;
            $this->excel->getActiveSheet()->setCellValue('A'.$count_data, 'L');
            $this->excel->getActiveSheet()->setCellValue('B'.$count_data, str_replace("_","-",$order));
            $this->excel->getActiveSheet()->setCellValue('K'.($count_data+1), $count_item);
            $this->excel->getActiveSheet()->setCellValue('L'.($count_data+1), '0'); // 0 = articulo
            $this->excel->getActiveSheet()->setCellValue('M'.($count_data+1), $array_c[$code_c[$e]]['code']);
            $this->excel->getActiveSheet()->setCellValue('R'.($count_data+1), number_format((float)$array_c[$code_c[$e]]['mtr'] , 4, '.', ''));
            $this->excel->getActiveSheet()->setCellValue('S'.($count_data+1), '0');
            
            $res = 12 - strlen($order);
            $zero = "";
            for($r = 0; $r < $res; $r++){
                $zero  .= "0";
            }
            $this->excel->getActiveSheet()->setCellValue('T'.($count_data+1), "LM".$zero.str_replace("_","-",$order)."_14660");
            
            $count_data++;
        }
        
        $this->excel->getActiveSheet()->setCellValue('A'.$count_data, 'L');
        $this->excel->getActiveSheet()->setCellValue('B'.$count_data, str_replace("_","-",$order));
        
        //header("Content-Type: text/html;charset=utf-8");
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment;filename="'.str_replace("_","-",$order).'.csv"; charset=UTF-8');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
        $objWriter->setSheetIndex(0);   // Select which sheet.
        $objWriter->setDelimiter(';');  // Define delimiter
        $objWriter->setEnclosure('');   // Define enclosure
        $objWriter->setLineEnding("\r\n");
        
        //$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); //xls
        // Forzamos a la descarga
        ob_start();
        $objWriter->save("php://output");
        $xlsData = ob_get_contents();
        return $xlsData;
        ob_end_clean();
        
        //return $xlsData;
        
        
//        $opResult = array(
//            'status' => 1,
//            'data'  =>"data:application/vnd.ms-excel charset=UTF-8;base64,".base64_encode(mb_convert_encoding($xlsData, 'UTF-16LE', 'UTF-8')),
//            'order' => str_replace("_","-",$order),
//            'obj' => $xlsData
//        );
        //echo json_encode($opResult);
        
        /// VisionCenter/Imos/Order/C_Pdf/ExportLMAT?name=8700314_20
        
        
        //<a href="dominio/VisionCenter/Imos/Order/C_Pdf/ExportLMAT?name=8700314_20" class="btn btn-defoult">Lmat</a>
    }

}

<?php

$conn_access = odbc_connect("PlantaServidorGeneral", "", "");

$Mysqlivision = new mysqli('localhost', 'root', '', 'vision');
if (!$Mysqlivision) {
    $res =  "Error: No se pudo conectar a MySQL." . PHP_EOL;
    $res .=  "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    CreateJson($res);
    exit;
}

$MysqliSipcom = new mysqli('192.168.0.18', 'visioncenter', '123456789', 'cotizaciones');
if (!$MysqliSipcom) {
    $res =  "Error: No se pudo conectar a MySQL." . PHP_EOL;
    $res .=  "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    CreateJson($res);
    exit;
}

$res =  "OK";

switch ($_GET['option']) {
    
    case "Pedidos":

    	$pedido = $_GET['pedido'];
		$IdSolicitud = "";
		$SqlPedido = "SELECT Solicitudes.IdSolicitud, Solicitudes.Solicitud, Solicitudes.TipoPedido,[TipoPedido]&[Solicitud] as pedido
		FROM Solicitudes
		where [TipoPedido]&[Solicitud] = '".$pedido."' ";

		$result = odbc_exec($conn_access, $SqlPedido);
		while ($sol = odbc_fetch_array($result)){
			$IdSolicitud = $sol['IdSolicitud'];
		}
		if(empty($IdSolicitud)){
			$res =  "El pedido no existe en la base de access";
            CreateJson($res);
			exit();
		}

		$order = substr($pedido, 2);

        $Mysqlivision->query("Delete from `access_order` where CONCAT(`type`,`order`) = '".$pedido."'  ;");

        $SqlSolicitudes = "SELECT Clientes.Cliente, Solicitudes.*,IIf([CódigoDestino]='30309012','SD','ME') as line
        FROM Solicitudes INNER JOIN Clientes ON Solicitudes.IdCliente = Clientes.IdCliente WHERE (((Solicitudes.IdSolicitud) = ".$IdSolicitud." )) ORDER BY IdSolicitud";
        
        
        $result = odbc_exec($conn_access, $SqlSolicitudes);
        while ($fila = odbc_fetch_array($result)) {
            $date = new DateTime($fila['FechaSolicitud']);
            $empaque = empty($fila['IdFormaEmpaque']) ? 0 : $fila['IdFormaEmpaque'];
            $dimension = ($fila['IdLáminaDimensión'] == "") ? 0 : $fila['IdLáminaDimensión'];
            $idcliente = ($fila['IdCliente'] == "") ? 0 : $fila['IdCliente'];
            $cliente = ($fila['Cliente'] == "") ? 0 : $fila['Cliente'];

            $execute = $Mysqlivision->query("INSERT INTO access_order (`order`,`type`,`date`,id_client,client,project,destination,sheet_format,type_of_packaging,reference,line) "
                    . "values ('" . $fila['Solicitud'] . "','" . $fila['TipoPedido'] . "','" . $date->format('Y-m-d') . "',"
                    . " " . $idcliente . ",'".$cliente."','" . $fila['Proyecto'] . "','" . $fila['CódigoDestino'] . "','" . $dimension . "'"
                    . "," . $empaque . ",'".$fila['ObservacionesMuebles']."','".$fila['line']."') ");

            if (!$execute) {
                printf("%s\n", $Mysqlivision->info);
            }
        }
        
        $array_colores = array('cornflowerblue','coral','greenyellow','crimson','lightgray','lightseagreen'
                                    ,'yellow','yellowgreen','violet','skyblue','sienna','#f3220a;'
                                    ,'peru','#cc9b9b','#7db198','#a096dc','#fde96b','#ff00d7'
                                    ,'#80ded0','#f39c12','#ffe0b0;','#2d8e38;','#00000087;','#ffffff;','#c8bbea;','25','26','27','28','29','30','31','32');
        
        $Mysqlivision->query("Delete from `access_order_pieces` where id_order_item in (select a.id_access_order_item from access_order_item a where  a.`order` = '".$order."') ;");
        $Mysqlivision->query("Delete from `access_order_item` where `order` = '".$order."' ;");
        $Mysqlivision->query("Delete from `access_order_supplies` where `order` = '".$order."' ;");
        $Mysqlivision->query("Delete from access_order_package_detail  where id_order_package in (select id_order_package from access_order_package where `order` = '".$order."')  ;");
		$Mysqlivision->query("Delete from access_order_package where `order` = '".$order."'  ;");

        $SqlItem = "SELECT Solicitudes.Solicitud, SolicitudSubMuebles.IdMueble, SolicitudSubMuebles.CantidadMueblesSolicitada, SolicitudSubMuebles.IdLáminaDimensión, SolicitudSubMuebles.Especificaciones
                    FROM Solicitudes INNER JOIN SolicitudSubMuebles ON Solicitudes.IdSolicitud = SolicitudSubMuebles.IdSolicitud WHERE (((Solicitudes.IdSolicitud) = ".$IdSolicitud.")) ORDER BY Solicitudes.Solicitud,SolicitudSubMuebles.IdMueble ";

        $result = odbc_exec($conn_access, $SqlItem);
        $old_sol = 0;
        while ($fila = odbc_fetch_array($result)) {

            $cantidad = ($fila['CantidadMueblesSolicitada'] == "") ? 0 : $fila['CantidadMueblesSolicitada'];
            $dimension = ($fila['IdLáminaDimensión'] == "") ? 0 : $fila['IdLáminaDimensión'];
            
            if($old_sol == $fila['Solicitud']){
                $icolor++;
            }else{
                $old_sol = $fila['Solicitud'];
                $icolor = 0;
            }

            $color_pdf = $array_colores[$icolor];
            
            
            
            $Mysqlivision->query("INSERT INTO access_order_item (`order`, id_forniture,type_forniture, quantity, sheet_format, specification, color) 
            VALUES ('" . $fila['Solicitud'] . "', " . $fila['IdMueble'] . ",'ME', " . $cantidad . ", " . $dimension . ", '" . $fila['Especificaciones'] . "', '".$color_pdf."');");
        }

        $SqlItemSD = "SELECT SolicitudSubMueblesSD.IdSolicitudMuebleSD, SolicitudSubMueblesSD.IdSolicitud, SolicitudSubMueblesSD.ItemNo, SolicitudSubMueblesSD.CantidadSolicitada, SolicitudSubMueblesSD.Mueble, SolicitudSubMueblesSD.IdMuebleDesarrollo, Solicitudes.Solicitud
                    FROM Solicitudes INNER JOIN (SolicitudSubMueblesSD INNER JOIN MueblesSD ON SolicitudSubMueblesSD.IdMuebleDesarrollo = MueblesSD.IdMuebleDesarrollo) ON Solicitudes.IdSolicitud = SolicitudSubMueblesSD.IdSolicitud WHERE (((Solicitudes.IdSolicitud) = ".$IdSolicitud.")) order by Solicitudes.Solicitud, SolicitudSubMueblesSD.ItemNo";
        
        $result = odbc_exec($conn_access, $SqlItemSD);
        $old_sol = 0;
        while ($fila = odbc_fetch_array($result)) {
            
            $cantidad = ($fila['CantidadSolicitada'] == "")?0:$fila['CantidadSolicitada'];
             
            if($old_sol == $fila['Solicitud']){
                $icolor++;
            }else{
                $old_sol = $fila['Solicitud'];
                $icolor = 0;
            }

            $resfor = $Mysqlivision->query("select * from access_forniture where id_forniture = " . $fila['IdMuebleDesarrollo']);
            if($resfor->num_rows <= 0){

	            $resultMueble = $MysqliSipcom->query("select * from muebles m left join colores c on m.pinta1 = c.idcolores where idmuebles = " . $fila['IdMuebleDesarrollo']);
	            $row0 = mysqli_fetch_row($resultMueble);
	           
	            $Mysqlivision->query("INSERT INTO access_forniture (id_forniture,type_forniture,item,description,development,destination,observation,`line`,
	            sheet_format, color) VALUES (" . $row0[0] . ", 'SD'," . $row0[11] . ",'" . $row0[14] . "', '" . $row0[14] . "', '30309012','" . $row0[9] . "', '5'," . $row0[30] . ",'" . $row0[39] . "');");

            }

            $color_pdf = $array_colores[$icolor];
            
            $Mysqlivision->query("INSERT INTO access_order_item (`order`, id_forniture,type_forniture, quantity,color) 
            VALUES ('" . $fila['Solicitud'] . "', " . $fila['IdMuebleDesarrollo'] . ",'SD', " . $cantidad . ",'".$color_pdf."');");
            
            $id_access_order_item = $Mysqlivision->insert_id;
            
            
            $piezasAccess = "SELECT SolicitudSDSubPiezas.IdSolicitudMuebleSD, select_MsLaminas_AX.idInsumoERP, SolicitudSDSubPiezas.Pieza, 
                SolicitudSDSubPiezas.CantidadPiezas, SolicitudSDSubPiezas.CódigoLáminaInterno, SolicitudSDSubPiezas.LargoPieza, SolicitudSDSubPiezas.AnchoPieza, 
                SolicitudSDSubPiezas.Obs, SolicitudSDSubPiezas.ParteCantoL1, SolicitudSDSubPiezas.ParteCantoL2, SolicitudSDSubPiezas.ParteCantoA1, 
                SolicitudSDSubPiezas.ParteCantoA2, SolicitudSDSubPiezas.CantoCurvoLargo1, SolicitudSDSubPiezas.CantoCurvoLargo2, SolicitudSDSubPiezas.CantoCurvoAncho1,
                SolicitudSDSubPiezas.CantoCurvoAncho2, SolicitudSDSubPiezas.Veta, SolicitudSDSubPiezas.PlanoMaquinado, SolicitudSDSubPiezas.CarasPintadas, 
                SolicitudSDSubPiezas.NoImprimir, SolicitudSDSubPiezas.Vidrio, SolicitudSDSubPiezas.ReferenciaCantos, SolicitudSDSubPiezas.PuertasEnsambladas, 
                SolicitudSDSubPiezas.EsNuevaPieza, SolicitudSDSubPiezas.CodArticuloAX, MSLáminasInterno.CódigoCalibre
            FROM (SolicitudSDSubPiezas LEFT JOIN select_MsLaminas_AX ON SolicitudSDSubPiezas.CódigoLáminaInterno = select_MsLaminas_AX.CódigoLáminaInterno) LEFT JOIN MSLáminasInterno ON SolicitudSDSubPiezas.CódigoLáminaInterno = MSLáminasInterno.CódigoLáminaInterno
			WHERE (((SolicitudSDSubPiezas.IdSolicitudMuebleSD)=".$fila['IdSolicitudMuebleSD']."));";

            $resultPz = odbc_exec($conn_access, $piezasAccess);
            $array_cantos = array();
            while ($row = odbc_fetch_array($resultPz)) {
                $qtyP = ($row['CantidadPiezas'] == "")?0:$row['CantidadPiezas'];
                $longP = ($row['LargoPieza'] == "")?0:$row['LargoPieza'];
                $widthP = ($row['AnchoPieza'] == "")?0:$row['AnchoPieza'];
                $cal = $row['CódigoCalibre'];

                $l1 = NULL;
                $calibre1 = 0;
                if($row['ParteCantoL1'] != ""){
                	$l1 = $row['ParteCantoL1'];
                	if(array_key_exists($l1, $array_cantos)){
	                	$calibre1 = $array_cantos[$l1];
	                }else{
	                	$calibre1 = consultar_canto($row['ParteCantoL1']);
	                	$array_cantos[$l1] = $calibre1;
					}
                }

                $l2 = NULL;
                $calibre2 = 0;
                if($row['ParteCantoL2'] != ""){
                	$l2 = $row['ParteCantoL2'];
                	if(array_key_exists($l2, $array_cantos)){
	                	$calibre2 = $array_cantos[$l2];
	                }else{
	                	$calibre2 = consultar_canto($row['ParteCantoL2']);
	                	$array_cantos[$l2] = $calibre2;
					}
                }

            	$a1 = NULL;
                $calibre3 = 0;
                if($row['ParteCantoA1'] != ""){
                	$a1 = $row['ParteCantoA1'];
                	if(array_key_exists($a1, $array_cantos)){
	                	$calibre3 = $array_cantos[$a1];
	                }else{
	                	$calibre3 = consultar_canto($row['ParteCantoA1']);
	                	$array_cantos[$a1] = $calibre3;
					}
                }

                $a2 = NULL;
                $calibre4 = 0;
                if($row['ParteCantoA2'] != ""){
                	$a2 = $row['ParteCantoA2'];
                	if(array_key_exists($a2, $array_cantos)){
	                	$calibre4 = $array_cantos[$a2];
	                }else{
	                	$calibre4 = consultar_canto($row['ParteCantoA2']);
	                	$array_cantos[$a2] = $calibre4;
					}
                }

                $longF = floor($longP + $calibre3 + $calibre4);
                $widthF = floor($widthP + $calibre1 + $calibre2);
                $print = ($row['NoImprimir'] == 0)?1:0;

                //consultando el calibre del canto 
                

                $w = (($longF/1000) * ($widthF/1000) * ($cal/1000) * $qtyP * 680);

                //$w_total = ($w/1000);


                $execute = $Mysqlivision->query("INSERT INTO `access_order_pieces` (`id_order_item`, `piece`, `quantity`,caliber,code_sheet,code_sheet_ax, `long`, `width`,longF,widthF,weight, `code_canto_l1`, `code_canto_l2`, 
                    `code_canto_a1`, `code_canto_a2`, `curved_l1`, `curved_l2`, `curved_a1`, `curved_a2`, `veta`, `machining`, `reference_canto`, 
                    `observation`,delicate,`print`,assembled_door) VALUES ($id_access_order_item, '".$row['Pieza']."', ".$qtyP.",".$cal.",'".$row['CódigoLáminaInterno']."','".$row['idInsumoERP']."', ".$longP.", ".$widthP.",".$longF.",".$widthF.",".round($w,6).",'".$l1."', '".$l2."', '".$a1."', '".$a2."', 
                     ".$row['CantoCurvoLargo1'].", ".$row['CantoCurvoLargo2'].", ".$row['CantoCurvoAncho1'].", ".$row['CantoCurvoAncho2'].", ".$row['Veta'].", 
                    '".$row['PlanoMaquinado']."', '".$row['ReferenciaCantos']."', '".$row['Obs']."',".$row['Vidrio'].",".$print.",".$row['PuertasEnsambladas'].");");
                
            }

            
        }
    	
    	$InsumosAccess = "SELECT Solicitudes.Solicitud, SolicitudSubInsumos.IdInsumo, SolicitudSubInsumos.CantidadInsumoSolicitada, Solicitudes.IdSolicitud
		FROM Solicitudes INNER JOIN SolicitudSubInsumos ON Solicitudes.IdSolicitud = SolicitudSubInsumos.IdSolicitud
		GROUP BY Solicitudes.Solicitud, SolicitudSubInsumos.IdInsumo, SolicitudSubInsumos.CantidadInsumoSolicitada, Solicitudes.IdSolicitud
		HAVING (((Solicitudes.IdSolicitud) = ".$IdSolicitud."))
		ORDER BY Solicitudes.Solicitud;";

		$resultIn = odbc_exec($conn_access, $InsumosAccess);
        while ($row = odbc_fetch_array($resultIn)) {
        	$Mysqlivision->query("INSERT INTO `access_order_supplies` (`order`,id_supplies,quantity) VALUES ('".$row['Solicitud']."',".$row['IdInsumo'].",
        		".$row['CantidadInsumoSolicitada'].") ");
        }

    	break;

    case "Muebles":
    
        $Mysqlivision->query("TRUNCATE `access_forniture`;");
        
        //muebles SD
        $mueblesSD = "SELECT IdMuebleDesarrollo FROM MueblesSD";

        $result = odbc_exec($conn_access, $mueblesSD);
        while ($fila = odbc_fetch_array($result)) {
            
            $resultMueble = $MysqliSipcom->query("select * from muebles m left join colores c on m.pinta1 = c.idcolores where idmuebles = " . $fila['IdMuebleDesarrollo']);
            $row = mysqli_fetch_row($resultMueble);
           
            $Mysqlivision->query("INSERT INTO access_forniture (id_forniture,type_forniture,item,description,development,destination,observation,`line`,
            sheet_format, color) VALUES (" . $row[0] . ", 'SD'," . $row[11] . ",'" . $row[14] . "', '" . $row[14] . "', '30309012','" . $row[9] . "', '5'," . $row[30] . ",'" . $row[39] . "');");
          
        }
        
        // muebles ME
        $SqlItem = "SELECT Mueble.IdMueble, Mueble.CódigoCliente, Mueble.Versión, Mueble.DescripciónMueble, Mueble.DescripciónDesarrollo, Mueble.CódigoDestino, Mueble.Observaciones, Mueble.IdClienteME, Mueble.IdLinea, Mueble.IdLáminaDimensión, Mueble.Pinta
                    FROM Mueble order by Mueble.IdMueble";

        $result = odbc_exec($conn_access, $SqlItem);
       
        while ($fila = odbc_fetch_array($result)) {
            $version = ($fila['Versión'] == "") ? 0 : $fila['Versión'];
            $idcliente = ($fila['IdClienteME'] == "") ? 0 : $fila['IdClienteME'];
            $linea = ($fila['IdLinea'] == "") ? 0 : $fila['IdLinea'];
            $dimension = ($fila['IdLáminaDimensión'] == "") ? 0 : $fila['IdLáminaDimensión'];

            
            
            $Mysqlivision->query("INSERT INTO access_forniture (id_forniture,type_forniture,code_client,`version`,description,development,destination,observation,id_client,`line`,
                    sheet_format, color) VALUES (" . $fila['IdMueble'] . ", 'ME','" . $fila['CódigoCliente'] . "', " . $version . ", '" . $fila['DescripciónMueble'] . "', '" . $fila['DescripciónDesarrollo'] . "', '" . $fila['CódigoDestino'] . "', '" . $fila['Observaciones'] . "', " . $idcliente . ", " . $linea . ", " . $dimension . ",'" . $fila['Pinta'] . "');");
        }

        break;

	case "LAMINASAX":

        $result = $MysqliSipcom->query("select * from view_laminas_ax ");
        while ($row = mysqli_fetch_array($result)) {
            $Sql = "update MSLáminas set idInsumoERP = '".$row[1]."' where CódigoLáminaInterno = '".$row[0]."' ";
            odbc_exec($conn_access, $Sql);
        } 
        
        break;
    case "color":
        $array_colores = array('cornflowerblue','coral','greenyellow','crimson','lightgray','lightseagreen'
                                    ,'yellow','yellowgreen','violet','skyblue','sienna','#f3220a;'
                                    ,'peru','#cc9b9b','#7db198','#a096dc','#fde96b','#ff00d7'
                                    ,'#80ded0','#f39c12','#ffe0b0;','#2d8e38;','#00000087;','#ffffff;','#c8bbea;');
       
        foreach ($array_colores as $i) {          
            $res =  "<div style='width:200px;background-color:".$i."' >Mueble (".$i.")</div>";
        }
        
        break;

    default:
        break;
}



$MysqliSipcom->close();
$Mysqlivision->close();

//echo json_encode(array("Result" => $res));
CreateJson($res);


function CreateJson($res){
    echo json_encode(array("Result" => $res));
    $fp = fopen('results.json', 'w');
    fwrite($fp, json_encode(array("Result" => $res)));
    fclose($fp);
}

function consultar_canto($canto){
	$conn_access = odbc_connect("PlantaServidorGeneral", "", "");

	$SqlPedido = "SELECT DimensionCAnto
	FROM Insumos
	where idInsumoERP = '".$canto."' ";

	$result = odbc_exec($conn_access, $SqlPedido);
	while ($sol = odbc_fetch_array($result)){
		$DimensionCanto =  str_replace(",", ".", $sol['DimensionCAnto']);
	}

	return $DimensionCanto;
}

?> 
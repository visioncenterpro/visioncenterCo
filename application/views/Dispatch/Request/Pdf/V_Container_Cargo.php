<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <thead>
        <tr style="background-color: #e4e4e4;">
            <th style="text-align:center">PRODUCTO</th>
            <th style="text-align:center">CANTIDAD</th>
            <th style="text-align:center">EMPAQUE</th>
            <th style="text-align:center">SERVICIO AL CLIENTE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $quantity_packages = 0;
        $id_request_sd = 0;
        for ($i=0; $i < count($content); $i++) {
            foreach ($content[$i] as $key => $value) {
                if($value->id_request_sd != $id_request_sd){
                    $quantity_packages = $quantity_packages + $value->quantity_packages; 
                }
                $id_request_sd = $value->id_request_sd;
            } 
        } ?>
        <tr>
            <td>MUEBLES Y REPISAS</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>COMPLEMENTOS</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>OTROS</td>
            <td style="text-align: center;"><?= $quantity_packages?> Paquetes</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>TOTAL PIEZAS</td>
            <td style="text-align: center;"><?= $quantity_packages?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <thead>
        <tr style="background-color: #e4e4e4;">
            <th style="text-align:center; width: 298px">CLIENTE</th>
            <th style="text-align:center">FACTURAS</th>
            <th style="text-align:center; width: 50px;">REMISIONES</th>
            <th style="text-align:center; width: 50px;"> ##### </th>
        </tr>
    </thead>
    <tbody> <!--  -->
        <?php 
        for ($e=0; $e < count($client); $e++) { ?>
                <tr>
                    <td style="padding: 1%; text-align: center;"> <?= $client[$e] ?></td>
                    <td style="text-align: center;"> CNT-<?= implode(",", $content2[$client[$e]]) ?></td>
                    <td></td>
                    <td></td>
                </tr>
                
            <?php 
        } ?>
    </tbody>
</table>

<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <tbody>
        <tr>
            <td style="padding: 1%; font-weight: bold;">PESO VACIO:</td>
            <td style="font-weight: bold;">PESO LLENO:</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold;">OBSERVACIONES</td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 1%; font-size: 11px; text-align: center;"><?= $data_cargue->observation ?></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 1%; text-align: center; font-size: 12px;">Nota: Este documento hace constancia del recibido a satisfacción de la mercancia despachada en cuanto a cantidades relacionadas en facturas y remisiones, embalaje y forma adecuada del cargue.</td>
        </tr>
    </tbody>
</table>

<table cellpadding="3" width="100%" style="font-size: 6pt;margin-top: 22px; page-break-inside:avoid;">
    <tbody>
        <tr>
            <td style="padding: 1%; font-weight: bold;">FIRMA CONDUCTOR</td>
            <td style="font-weight: bold;">FIRMA DESPACHADOR</td>
            <td style="font-weight: bold;">FIRMA SEGURIDAD</td>
        </tr>
    </tbody>
</table>

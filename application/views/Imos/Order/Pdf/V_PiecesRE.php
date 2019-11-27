<style>
    body {
        height: 27.94cm;
        width: 21.59cm;
        margin-left: auto;
        margin-right: auto;
    }
    table {
        border-collapse: collapse;
        border:none;
    }
    table td, table th {
        border: 1px solid black;
        color: #333;
    }
    @media print {
        body {
            height: 27.94cm;
            width: 21.59cm;
            margin-auto: auto;
            margin-right: auto;
            font-family: sans-serif;
        }
        td.nombre{
            vertical-align: text-top;
        }
        tr {
            page-break-inside:avoid; page-break-after:auto
        }
        table {
            page-break-inside:avoid; page-break-after:auto
        }
        .no-print, .no-print *{
            display: none !important;
        }
    }
</style>
<table cellpadding="3" style="width:100%; font-size: 7pt; ">
    <tr>
        <th colspan="14">
            <table cellpadding="4" width="100%" style=" border:none;font-size: 8pt; ">
                <tr>
                    <td rowspan="2" width="7%" ><img src="<?= URL_IMAGE.$this->session->company ?>"  width="150"></td>
                    <td colspan="2" style="width:93%; text-align: center"><?= $title ?></td>
                </tr>
                <tr>
                    <td style="width:400px;text-align: center;">ORDER <b><?= $order ?></b></td>
                    <td style="text-align: center;">VERSION 01</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center; font-size: 9pt;background-color: #e7771d; "></td>
                </tr>
                <tr>
                    <td colspan="2">Empleado:&nbsp;&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->person_in_charge : $Header->EMPLOYEE ?></td>
                    <td>Fecha Entrega:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->required_date : $Header->DELIVERY_DATE ?></td>
                </tr>
                <tr>
                    <td colspan="2">Cliente Final:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer : "" ?></td>
                    <td>Nombre pedido:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer . " " . $HeaderRecord->apto : $Header->CUSTOMER ?>  </td>
                </tr>
            </table>
        </th>
    </tr>
    <!-- <tr>
        <th colspan="14">
            <table style="border:none;width:100%; font-size: 9pt; margin-top: 5px;text-align: center;">
                <tr>
                    <th  style="width:18%;border: none;" >Nombre Del Articulo</th><td style="border: none;"><?= $article ?></td>
                    <td  style="width:15%;border: none;"><b>N&deg; Pos</b></td><td style="border: none;width:10%"><?= $position ?></td>
                    <td  style="width:15%;border: none;"><b>Medidas</b></td><td  style="border: none;width:18%"><?= $med ?></td>
                </tr>
            </table>
        </th>
    </tr>
    <tr>
        <th colspan="14">
            <table style="border:none;width:100%">
                <tr>
                    <td style="width:50%; text-align: center;" ><b>Perspectiva</b></td>
                    <td style="width:50%; text-align: center;" ><b>Explosión</b></td>
                </tr>
                <tr>
                    <td  style="width:50%; text-align: center; ">
                        <img src="<?= SERVER_IMOS ?>/<?= $order ?>/<?= $id ?>_<?= $cpid ?>/PERSP.png" style="max-width: 200px;">
                    </td>
                    <td  style="width:50%; text-align: center;">
                        <img src="<?= SERVER_IMOS ?>/<?= $order ?>/<?= $id ?>_<?= $cpid ?>/EXPLOS_DR.png" style="max-width: 200px;">
                    </td>
                </tr>
            </table>
        </th>
    </tr> -->
    <tr style="background-color: #e4e4e4;">
        <th style="text-align: center">REF</th>
        <th style="text-align: center">COD MUEBLE</th>
        <th style="text-align: center">REF IMOS</th>
        <th style="text-align: center">COD AX</th>
        <th style="text-align: center">TIPO</th>
        <th style="text-align: center">ACABADO</th>
        <th style="text-align: center">LAMINA</th>
        <th style="text-align: center;min-width: 52px;">CANTO</th>
        <!-- <th style="text-align: center">IMG</th> -->
        <th style="text-align: center">ALTO</th>
        <th style="text-align: center">ANCHO</th>
        <th style="text-align: center">CAL</th>
        <th style="text-align: center">PESO</th>
        <th style="text-align: center">AREA</th>
        <!-- <th style="text-align: center">COD. BARRA 1</th>
        <th style="text-align: center">COD. BARRA 2</th> -->
        <th style="text-align: center">COMENTARIO</th>
    </tr>
    <?= $tbody; ?>
</table>
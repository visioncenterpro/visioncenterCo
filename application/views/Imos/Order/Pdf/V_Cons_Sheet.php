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
<!--<table cellpadding="3"  width="100%" style="font-size: 7pt;">
    <tr>
        <th style="text-align: center">MATERIAL</th>
        <th style="text-align: center">MT2</th>
        <th style="text-align: center">WEIGHT</th>
    </tr>
</table>
<BR><BR>-->
<table style="border: none; " width="100%">
    <tr style="border: none; ">
        <td style="border: none; ">
            <table cellpadding="4" width="100%" style="font-size: 8pt; ">
                <tr>
                    <td rowspan="2" width="7%" ><img src="<?= URL_IMAGE.$this->session->company ?>"  width="150"></td>
                    <td colspan="2" style="width:93%; text-align: center">CONSOLIDADO DE LAMINAS</td>
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
                    <td style="min-width: 130px">Fecha Entrega:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->required_date : $Header->DELIVERY_DATE ?></td>
                </tr>
                <tr>
                    <td colspan="2">Cliente Final:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer : "" ?></td>
                    <td>Nombre pedido:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer . " " . $HeaderRecord->apto : $Header->CUSTOMER ?>  </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="border: none; ">
        <td style="border: none; ">
            <table cellpadding="3"  width="100%" style="font-size: 7pt;">
                <tr>
                    <th style="text-align: center">MATERIAL</th>
                    <th style="text-align: center">FORMATO</th>
                    <th style="text-align: center">DESPERDICIO</th>
<!--                    <th style="text-align: center">M^2 LAMINA + DESPERDICIO</th>-->
                    <th style="text-align: center">CONSOLIDADO DE LAMINAS</th>
                </tr>
                <?= $html ?>
            </table>
        </td>
    </tr>
</table>
<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">





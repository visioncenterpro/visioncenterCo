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
<table cellpadding="4" width="100%" style="font-size: 8pt; ">
    <tr>
        <td rowspan="2" width="7%" ><img src="<?= URL_IMAGE.$this->session->company ?>"  width="150"></td>
        <td colspan="2" style="width:93%; text-align: center"><?=$title?></td>
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

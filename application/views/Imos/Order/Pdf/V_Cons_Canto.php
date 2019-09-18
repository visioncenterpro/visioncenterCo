<style>
    body {
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-weight: 400;
        font-size: 14px;
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

<table style="border: none; " width="100%">
    <tr style="border: none; ">
        <td style="border: none; ">
            <table cellpadding="4" width="100%" style="font-size: 8pt; ">
                <tr>
                    <td rowspan="2" width="7%" ><img src="<?= URL_IMAGE.$this->session->company ?>"  width="150"></td>
                    <td colspan="3" style="width:93%; text-align: center">CONSOLIDADO DE CANTOS</td>
                </tr>
                <tr>
                    <td style="width:400px;text-align: center;">ORDER <b><?= $order ?></b></td>
                    <td style="text-align: center;">Desperdicio : <?= $desp ?></td>
                    <td style="text-align: center;">V.01</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center; font-size: 9pt;background-color: #e7771d; "></td>
                </tr>
                <tr>
                    <td colspan="2">Empleado:&nbsp;&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->person_in_charge : $Header->EMPLOYEE ?></td>
                    <td colspan="2" style="min-width: 130px">Fecha Entrega:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->required_date : $Header->DELIVERY_DATE ?></td>
                </tr>
                <tr>
                    <td colspan="2">Cliente Final:&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer : "" ?></td>
                    <td colspan="2">Nombre pedido:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= (is_object($HeaderRecord)) ? $HeaderRecord->end_customer . " " . $HeaderRecord->apto : $Header->CUSTOMER ?>  </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="border: none; ">
        <td style="border: none; ">
            <table cellpadding="3"  width="100%" style="font-size: 7pt;">
                <tr>
                    <th style="text-align: center" width="26%">CANTO</th>
                    <th style="text-align: center" width="34%">DESCRIPCION</th>
                    <th style="text-align: center" width="20%">MTS</th>
                    <th style="text-align: center" width="20%">MTS + DESPERDICIO</th>
                </tr>
                <?php
                $sum1 = 0;
                $sum2 = 0;
                foreach ($array as $key => $value):
                    $sum1 += round($value['mtr'], 2);
                    $sum2 += round($value['total'], 2);
                    ?>
                    <tr>
                        <td style="text-align: center"><?= $key ?></td>
                        <td><?= str_replace("_", " ", $value['desc']) ?></td>
                        <td style="text-align: right"><?= number_format($value['mtr'], 2, '.', ',') ?></td>
                        <td style="text-align: right"><?= number_format($value['total'], 2, '.', ',') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="text-align: right" colspan="2"><b>Total</b></td>
                    <td style="text-align: right"><b><?= number_format($sum1, 2, '.', ',') ?></b></td>
                    <td style="text-align: right"><b><?= number_format($sum2, 2, '.', ',') ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br class="no-print"><hr class="no-print" style="border:1px dashed; width:100%;" /><br class="no-print">





<style>
    body {
        height: 21cm;
        width: 25cm;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
        margin:auto;
        font-family: sans-serif;
    }
    table {
        border-collapse: collapse;
        border:none;
    }
    table td, table th {
        border: 1px solid black;
    }

    @media print {
        body {
            height: 21.59cm;
            width: 27.94cm;
            /* to centre page on screen*/
            margin-left: auto;
            margin-right: auto;
            margin:auto;
            font-family: sans-serif;
        }

        tr {
            page-break-inside:avoid; page-break-after:auto
        }
    }
</style>

<table  cellpadding="3" width="100%" style="font-size: 7pt; page-break-inside:avoid;">
    <tr>
        <td rowspan="3" width="4%"><img src="<?= URL_IMAGE.$this->session->company ?>MILESTONE.jpg" width="140px" height="60px" /></td>
        <td colspan="3" style="text-align: center;"><h3>SOLICITUD DE DESPACHO</h3></td>
        <td style="text-align: center;color: red;font-size: 20">CNT <?= $head->id_request_sd ?></td>
    </tr>
    <tr>
        <td colspan="2">CONDUCTOR:&nbsp;&nbsp; <?= $head->driver ?></td>
        <td>PLACA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $head->license_plate ?></td>
        <td>FECHA <?= date("Y-m-d") ?></td>


    </tr>
<!--    <tr>
        <td style="width: 100px">FECHA <?= date("Y-m-d") ?></td>
        <td>PLACA:</td>
        <td>CONDUCTOR:</td>
        <td style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
    </tr>-->
</table>


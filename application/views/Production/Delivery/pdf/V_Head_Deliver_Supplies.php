<style>
    body {
        height: 21cm;
        width: 29.7cm;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
        font-family: sans-serif;
    }
    div.sheet {
        page-break-after: always;
    }

    table {
        border-collapse: collapse;
        border:none;
    }
    table td, table th {
        border: 1px solid black;
    }
    hr {
        height: 1px;
        border: 0;
        background-color: black;
    }


    @media print {
        body {
            height: 21cm;
            width: 29.7cm;
            /* to centre page on screen*/
            margin-left: auto;
            margin-right: auto;
            font-family: sans-serif;
        }

        div.sheet {
            page-break-after: always;
        }

        td.nombre{
            vertical-align: text-top;
        }

        tr {
            page-break-inside:avoid; page-break-after:auto
        }
        td{ page-break-inside:avoid; page-break-after:auto }
    }
</style>

<table  cellpadding="3" width="100%" style="font-size: 7pt; page-break-inside:avoid;">
    <tr>
        <td rowspan="3" width="4%"><img src="<?= URL_IMAGE.$this->session->company ?>" width="140px" height="60px" /></td>
        <td colspan="4" style="text-align: center;"><h3>ENTREGA INTERNA DE INSUMOS DE PRODUCCI&Oacute;N A DESPACHO</h3></td>
    </tr>
    <tr>
        <td colspan="2">CLIENTE:&nbsp;&nbsp; <?= $head->client ?></td>
        <td>OBRA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $head->project ?></td>
        <td>PEDIDO <?= $head->type ?>-<?= $head->order ?></td>


    </tr>
    <tr>
        <td style="width: 100px">FECHA <?= date("Y-m-d") ?></td>
        <td>CODIGO:&nbsp;&nbsp; VA-05</td>
        <td><b>ENTREGA N&deg; <?= $No ?></b></td>
        <td style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
    </tr>
</table>
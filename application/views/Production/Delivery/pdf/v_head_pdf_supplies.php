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
            width: 100%;
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

<?php foreach ($supplies as $key => $value) { ?>
    <table  cellpadding="3" width="100%" style="font-size: 8pt; page-break-inside:avoid;">
        <tr>
            <td rowspan="3" width="4%"><img src="<?= URL_IMAGE.$this->session->company ?>" width="140px" height="60px" /></td>
            <td colspan="4" style="text-align: center;"><h3>REPORTE ALISTAMIENTO DE INSUMOS</h3></td>
        </tr>
        <tr>
            <td colspan="2">CLIENTE:&nbsp;&nbsp; <?= $value->client ?></td>
            <td>OBRA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $value->project ?></td>
            <td>PEDIDO <?= $value->type ?>-<?= $value->order ?></td>


        </tr>
        <tr>
<!--            <td style="width: 100px">FECHA <?= date("Y-m-d") ?></td>-->
            <td>CODIGO:&nbsp;&nbsp; VA-05</td>
            <td><b>ENTREGA N&deg;</b></td>
            <td style="width: 90px">VERSION:&nbsp;&nbsp; 01</td>
        </tr>
    </table>
<?php }  ?>

<table cellpadding="4" style="font-size: 7px;" width="100%" id="tabla">
    <tr>
        <td colspan="100" style="text-align: center;"><b></b></td>
    </tr>
    <tr style="background-color: #e4e4e4; margin-top: 5%;">
        <td width="17%" style="font-size: 10px; text-align: center;">INSUMO</td>
        <td width="3%" style="font-size: 10px; text-align: center;">CANTIDAD TOTAL</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
        <td width="1%" style="font-size: 10px; text-align: center;">CANT EMPACADA</td>
        <td width="1%" style="font-size: 10px; text-align: center;">PAQ.</td>
    </tr>
    
    <?php foreach ($details as $d){
        if($d->exclude != 1 && $d->id_status == 1){
    ?>
    <tr>
        <td style="font-size: 10px; text-align: left; vertical-align: bottom"><?=$d->name?></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"><?=$d->quantity?></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
        <td style="font-size: 10px; text-align: center; vertical-align: bottom"></td>
    </tr>
    <?php } 
        } ?>
    
</table>

<table cellpadding="4" width="100%" style="margin-top:5%;">
    <tr>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 1:</td>
        <td></td>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 2:</td>
        <td></td>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 3:</td>
        <td></td>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 4:</td>
        <td></td>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 5:</td>
        <td></td>
        <td style="font-size: 10px; width: 10%; text-align: center;">PESO TOTAL PAQ. 6:</td>
        <td></td>
    </tr>
</table>
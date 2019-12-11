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

<?php foreach ($content as $key => $value) { 
    $date = new DateTime($value->start_time);
    $dateEnd = new DateTime($value->end_time);
?>
<table  cellpadding="3" width="100%" style="font-size: 7pt; page-break-inside:avoid;">
    <tr>
        <td width="4%"><img src="<?= URL_IMAGE.$this->session->company ?>" width="140px" height="60px" /></td>
        <td colspan="4" style="text-align: center;"><h3>CONTROL DE CARGUE</h3></td>
        <td style="text-align: center;font-size: 10">Código: F DES 01 02 <br/> Fecha: <?=date("Y-m-d");?> <br/> Edición: 2.1</td>
    </tr>
    <tr>
        <td colspan="5">FECHA: <?= $value->dispatch_date?></td>
        <td style="text-align: center; font-weight: bold;">CONSECUTIVO ##</td>
    </tr>
    <tr>
        <td colspan="8">PLACA:  <?= $value->license_plate; ?></td>
    </tr>
    <tr>
        <td colspan="5">CONDUCTOR: <?= $value->driver; ?></td>
        <td>CEL:</td>
    </tr>
    <tr>
        <td colspan="8">DESTINO:</td>
    </tr>
    <tr>
        <td colspan="8">TIPO VEHICULO: <?= $value->description ?></td>
    </tr>
    <tr>
        <td colspan="4">HORA INICIO: <?= $date->format('H:i:s')?></td>
        <td colspan="4">HORA FIN: <?= $dateEnd->format('H:i:s')?></td>
    </tr>
</table>
<?php } ?>
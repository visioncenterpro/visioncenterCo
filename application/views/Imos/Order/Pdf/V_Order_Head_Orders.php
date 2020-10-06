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
        <?php if(isset($this->session->company)){ ?>
            <td rowspan="3" width="4%"><img src="<?= URL_IMAGE.$this->session->company ?>" width="140px" height="60px" /></td>
        <?php }else{ ?>
            <td rowspan="3" width="4%"><img src="<?= URL_IMAGE ?>MILESTONE.jpg" width="140px" height="60px" /></td>
        <?php } ?>
        <td colspan="2" style="width:93%; text-align: center"><?=$title?></td>
    </tr>
    <tr>
        <td style="width:400px;text-align: center;">ORDER <b>
        <?php for($i=0; $i < count($order); $i++){
            echo $order[$i].", ";
        } ?></b></td>
        <td style="text-align: center;">VERSION 01</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center; font-size: 9pt;background-color: #e7771d; "></td>
    </tr>
    <tr>
        <td colspan="2">Empleados:&nbsp;&nbsp;&nbsp; <?php for($i=0; $i < count($HeaderRecord); $i++){if(is_object($HeaderRecord[$i])){ echo $HeaderRecord[$i]->person_in_charge.", "; } else{ echo $Header[$i]->EMPLOYEE.", "; } } ?></td>
        <td style="min-width: 130px">Fecha Entrega:&nbsp;&nbsp; <?php for($i=0; $i < count($HeaderRecord); $i++){ if(is_object($HeaderRecord[$i])){echo  $HeaderRecord[$i]->required_date.", ";}else{echo $Header[$i]->DELIVERY_DATE.", "; }} ?></td>
    </tr>
    <tr>
        <td colspan="2">Cliente Final:&nbsp;&nbsp; <?php for($i=0; $i < count($HeaderRecord); $i++){ if(is_object($HeaderRecord[$i])){ echo $HeaderRecord[$i]->end_customer.", "; }else{echo "";} }?></td>
        <td>Nombre pedidos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php for($i=0; $i < count($HeaderRecord); $i++){ if(is_object($HeaderRecord[$i])){ echo $HeaderRecord[$i]->end_customer . " " . $HeaderRecord[$i]->apto.", "; }else{ echo $Header[$i]->CUSTOMER.", ";}  }?>  </td>
    </tr>
</table>

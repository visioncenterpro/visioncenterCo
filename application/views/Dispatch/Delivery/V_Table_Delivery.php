<table id="table_delivery" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="max-width:15px"></th>
            <th style="max-width:79px;text-align:center">ENTREGA N&deg;</th>
            <th style="text-align:center;max-width:90px;">CREACION</th>
            <th style="text-align:center;max-width:79px;">ORDER</th>
            <th>CLIENTE</th>
            <th style="text-align:center;max-width:79px;">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td ><button class="btn btn-block btn-primary btn-xs" onclick="window.location.href = '<?= base_url() ?>Production/Delivery/C_Delivery/<?=$this->input->post("view")?>/<?=$id?>/<?=$order?>/Dispatch'"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>
            <td style="text-align:center"><?=$id?></td>
            <td style="text-align:center"><?=$date?></td>
            <td style="text-align:center"><?=$order?></td>
            <td><?=$client?></td>
            <td style="text-align:center"><?=$description?></td>
        </tr>
    </tbody>
</table>

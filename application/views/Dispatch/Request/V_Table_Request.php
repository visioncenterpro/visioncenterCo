<table id="table_request" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center;max-width:15px"></th>
            <th style="text-align:center;max-width:15px"></th>
            <th style="text-align:center;max-width:15px"></th>
            <th style="text-align:center">NUMERO</th>
            <th style="text-align:center">FECHA</th>
            <th style="text-align:center">ESTADO</th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach ($rows as $t) : ?>
            <tr>
                <td style="width:15px"><button class="btn btn-block btn-primary btn-xs" onclick="window.location.href = '<?= base_url() ?>Dispatch/C_Dispatch/InfoRequestDispatchSD/<?=$t->id_request_sd?>'"><span class="fa fa-sign-in" aria-hidden="true"></span></button></td>
                <td style="text-align:center"><button class="btn btn-block btn-primary btn-xs" onclick="window.open('<?= base_url() ?>Dispatch/C_Dispatch/PdfRequest/<?=$t->id_request_sd?>', '_blank');"><span class="fa fa-print" aria-hidden="true"></span></button></td>
                <td style="text-align:center"><button class="btn btn-block btn-primary btn-xs" onclick="info('<?=$t->id_request_sd?>')"><span class="fa fa-eye" aria-hidden="true"></span></button></td>
                <td style="text-align:center"><?=$t->id_request_sd?></td>
                <td style="text-align:center"><?=$t->date?></td>
                <td style="text-align:center"><?=$t->description?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


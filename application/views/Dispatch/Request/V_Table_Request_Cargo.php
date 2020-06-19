<table id="table_request" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <!-- <th style="text-align:center"><input type="checkbox" id="all" onclick="allF()"></th> -->
            <th style="text-align:center"># ID CARGUE</th>
            <th style="text-align:center">OBSERVACIÓN</th>
            <th style="text-align:center">FECHA CREACION</th>
            <th style="text-align:center">ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach ($request as $r) : ?>
            <tr>
                <!-- <td style="text-align:center"><input type="checkbox" id="remissions" value="<?= $r->id_remission ?>"><input type="hidden" id="requests_sd" value="<?= $r->id_request_sd?>"></td> -->
                <td style="text-align:center"><?=$r->id_request_cargue?></td>
                <td style="text-align:center"><?=$r->observation?></td>
                <td style="text-align:center"><?=$r->date_create?></td>
                <td style="text-align:center"><button class="btn btn-primary" title="detalle" onclick="detail(<?=$r->id_request_cargue?>)"><i class="fa fa-search "></i></button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


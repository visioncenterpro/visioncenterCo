<table id="table_request" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th style="text-align:center">REMISION</th>
            <th style="text-align:center">CLIENTE</th>
            <th style="text-align:center">PROYECTO</th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach ($remissions as $r) : ?>
            <tr>
                <td style="text-align:center"><?=$r->id_remission?></td>
                <td style="text-align:center"><?=$t->client?></td>
                <td style="text-align:center"><?=$t->project?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


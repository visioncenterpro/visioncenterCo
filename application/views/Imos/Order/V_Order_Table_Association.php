<table class="table table-bordered table-striped table-condensed" id="table-asoc">
    <thead>
        <tr>
            <th>Code</th>
            <th>Code1</th>
            <th>Code_Esp</th>
            <th>Depth</th>
            <th>Qty</th>
            <th>Tipo Item</th>
            <th>Item Imos</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemImport as $v) : ?>
        <tr id="asoc-<?= $v->id_import_salesline ?>">
                <td><?= $v->code ?></td>
                <td><?= $v->code1 ?></td>
                <td><?= $v->code_esp ?></td>
                <td><?= $v->depth ?></td>
                <td><?= $v->qty ?></td>
                <td style="text-align: center;">
                    <select  class="form-control input-sm" id="type-<?= $v->id_import_salesline ?>" onchange="UpdataItemImport(<?= $v->id_import_salestable ?>,<?= $v->id_import_salesline ?>)">
                        <option value='AO' <?=($v->type == "AO")?"selected":"" ?>>ADICIONAL ORDER</option>
                        <option value='AM' <?=($v->type == "AM")?"selected":"" ?>>ADICIONAL MUEBLE</option>
                        <option value='M' <?=($v->type == "M")?"selected":"" ?>>MUEBLE</option>
                    </select>
                </td>
                <td style="text-align: center;">
                    <select class="form-control input-sm" <?=($v->type == "AO")?"disabled":"" ?> id="highart-<?= $v->id_import_salesline ?>"  onchange="UpdataItemImport(<?= $v->id_import_salestable ?>,<?= $v->id_import_salesline ?>)">
                        <option value=''>. . .<option>
                            <?php
                            foreach ($itemImos as $t) :
                                $nameItem = (!empty($t->INFO1) ? $t->INFO1 : (!empty($t->INFO2) ? $t->INFO2 : (!empty($t->INFO3) ? $t->INFO3 : $t->CPID)));
                                $nameItem = ($nameItem == 'PN') ? $t->CPID . $t->DEPTH : $nameItem;
                                ?>

                            <option value="<?= $t->ID ?>" <?= ($t->ID == $v->highart) ? "selected" : "" ?> ><?= $nameItem . " (" . $t->POSSTR . ")" ?></option>

                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

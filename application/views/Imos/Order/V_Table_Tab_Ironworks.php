<table id="table_iron" class="table table-bordered table-striped table-condensed ">
    <thead>
        <tr>
            <th>Codigo AX</th>
            <th>Descripcion AX</th>
            <th>Cantidad</th>
            <th>Und. AX</th>
            <th style="min-width:50px"></th>
        </tr>
    </thead>
    <tbody>
        <?=$iron?>
        <?php foreach ($AdIronRecord as $t) :?>
        <tr id="ac-<?=$t->id_import_salesline?>">
            <td id="code-ac-<?=$t->id_import_salesline?>"><?=$t->code?></td>
            <td id="desc-ac-<?=$t->id_import_salesline?>">(ACK) <?=$t->description?></td>
            <td id="qty-ac-<?=$t->id_import_salesline?>" style="text-align:center"><?=$t->qty?></td>
            <td id="uni-ac-<?=$t->id_import_salesline?>" style="text-align:center"><?=$t->unity?></td>
            <td>
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="DetailsAditional(<?=$t->id_import_salesline?>,'sys_import_salesline',<?=$t->id_import_salestable?>)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteAditional(<?= $t->id_import_salesline ?>,'sys_import_salesline')"><i class="fa fa-trash"></i></button>
            </td>     
        </tr>
       <?php endforeach;?>
       <?php foreach ($AdAditional as $t) :?>
        <tr id="ad-<?=$t->id_aditional_line?>">
            <td id="code-ad-<?=$t->id_aditional_line?>"><?=$t->code?></td>
            <td id="desc-ad-<?=$t->id_aditional_line?>">(ADD) <?=$t->description?></td>
            <td id="qty-ad-<?=$t->id_aditional_line?>" style="text-align:center"><?=$t->qty?></td>
            <td id="uni-ad-<?=$t->id_aditional_line?>" style="text-align:center"><?=$t->unity?></td>
            <td >
                <button type="button"  class="btn btn-info btn-xs btn-tabla" onclick="DetailsAditional(<?=$t->id_aditional_line?>,'imos_aditional_line',0)"><i class="fa fa-search"></i></button>
                <button type="button"  class="btn btn-danger btn-xs btn-tabla" onclick="DeleteAditional(<?= $t->id_aditional_line ?>,'imos_aditional_line')"><i class="fa fa-trash"></i></button>
            </td>     
        </tr>
       <?php endforeach;?>
    </tbody>
</table>
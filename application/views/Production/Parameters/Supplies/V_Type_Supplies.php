<div class="row">
    <div class="form-group col-md-2">
        <label>Tipo</label>
        <select id="type_supply" class="form-control input-sm">
            <option value="">. . .</option>
            <?php foreach ($types as $type) : ?>
                <option value="<?= $type->id_type_supplies ?>"><?= $type->description ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label>Código AX</label>
        <input id="code_supply" type="text" name="code_supply" class="form-control input-sm" maxlength="20">
    </div>
    <div class="form-group col-md-2">
        <label>Pedido</label>
        <input id="code_order" type="text" name="code_order" class="form-control input-sm" maxlength="100">
    </div>
    
    <div class="form-group col-md-4" style="margin-top: 25px">
        <a id="btn_consult_supplies" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0"><span><i class="fa  fa-search"></i> Consultar</span></a>
        <a id="btn_open_create" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="1"><span><i class="fa  fa-plus-square"></i> Crear</span></a>
    </div>
</div>


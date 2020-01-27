<div class="form-group">
    <label>Código</label>
    <input type="text" class="form-control" id="code">
</div>
<div class="form-group">
    <label>Nombre</label>
    <input type="text" class="form-control" id="name">
</div>
<div class="form-group">
    <label>Unidad</label>
    <select class="form-control" id="unity">
        <?php foreach ($unity as $key => $value) { ?>
            <option value="<?= $value->id_unit?>"><?= $value->description?> (<?= $value->code?>)</option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label>Tipo</label>
    <select class="form-control" id="type">
        <?php foreach ($type_supplies as $key => $value) { ?>
            <option value="<?= $value->id_type_supplies?>"><?= $value->description?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label> Cantidad por paquete </label>
    <input type="number" class="form-control" min="1" id="cnt_pq" />
</div>
<div class="form-group">
    <label> Peso unitario </label>
    <input type="number" class="form-control" min="1" id="weight_unt" />
</div>
<div class="form-group">
    <label> Observación </label>
    <textarea class="form-control" id="observation"></textarea>
</div>
<input type="hidden" id="order_new" value="<?= $order ?>" />
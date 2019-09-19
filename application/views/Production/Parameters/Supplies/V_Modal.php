<div class="modal fade" id="modal-supply">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Insumos</h4>
            </div>
            <form role="form" id="form" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id='id_supply' value="0">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Tipo</label>
                            <select name="type" id="type" class="form-control input-sm required">
                                <option value="">. . .</option>
                                <?php foreach ($types as $type) : ?>
                                    <option value="<?= $type->id_type_supplies ?>"><?= $type->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Unidad</label>
                            <select name="unit" id="unit" class="form-control input-sm required">
                                <option value="">. . .</option>
                                <?php foreach ($units as $unit) : ?>
                                    <option value="<?= $unit->id_unit ?>"><?= $unit->description ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Nombre</label>
                            <input type='text' name="name" id='name' class='form-control input-sm'>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Codigo AX</label>
                            <input type='text' name="code" id='code' class='form-control input-sm'>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Cantidad por Paquete</label>
                            <input type='text' name="quantityPerPackage" id='quantityPerPackage' class='form-control input-sm' onkeypress="return acceptNumberAndOncePoint(event, 'quantityPerPackage');">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Peso por paquete</label>
                            <input type='text' name="weightPerPackage" id='weightPerPackage' class='form-control input-sm' onkeypress="return acceptNumberAndOncePoint(event, 'weightPerPackage');">
                        </div>
                        <div class="form-group col-md-4" style="display: none">
                            <label>Dimensión</label>
                            <input type='text' id='dimension' class='form-control input-sm'>
                        </div>
                    </div>
                </div>
            </form>            
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-" data-dismiss="modal">CANCELAR</button>               
                <button id="btnUpdateModal" type="button" class="btn btn-primary pull-right" onclick="update()">ACTUALIZAR</button>
                <button id="btnCreateModal" type="button" class="btn btn-primary pull-right" onclick="create()">REGISTRAR</button>
            </div>
        </div>
    </div>
</div>
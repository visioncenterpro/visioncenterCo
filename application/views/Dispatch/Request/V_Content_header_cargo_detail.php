<div class="row">
    <div class="col-md-4">
        
            <label>Conductor</label>
            <div class="form-group row">
                
                <div class="col-sm-10">
                    <input type="hidden" id="type" value="1">
                        <select class="form-control selc" id="driver" onchange="license_plate()">
                            <option value="0">/--/</option>
                        <?php for ($i=0; $i < count($data_driver); $i++) {
                                foreach ($data_driver[$i] as $key => $value) { ?>
                                    <option value="<?=$value->id_request_sd?>"><?=$value->driver?></option>
                        <?php    }
                            } ?>
                        </select>

                        <input type="text" class="form-control inp" id="driver" style="display: none;">

                </div>
                <div class="col-sm-2"><button class="btn btn-success" id="edit" onclick="edit()"><span class="fa fa-edit" aria-hidden="true"></span></button></div>
            </div>
        
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Placa</label>
            <input type="text" class="form-control" id="license_plate">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Tipo de vehiculo</label>
            <select class="form-control" id="type_vehicle">
                <?php for ($i=0; $i < count($type_v); $i++) {
                        foreach ($type_v[$i] as $key => $value) { ?>
                            <option value="<?=$value->id_weight_vehicle?>"><?=$value->description?></option>
                <?php    }
                    } ?>
            </select>
        </div>
    </div>
</div>
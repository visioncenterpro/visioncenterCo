<div class="form-group">
	<label>Conductor</label>
	<select class="form-control" id="driver" onchange="type_truck()">
		<?php foreach ($data_request as $key => $value) {
			//if ($value->driver != "Pendiente") { ?>
				<option value="<?= $value->id_request_sd?>"><?= $value->driver?></option>
		<?php //} 
			 } ?>
	</select>
</div>
<div class="form-group">
	<label>Tipo Camión</label>
	<input type="text" class="form-control" id="type_truck" placeholder="Tipo de Camión" disabled="disabled">
</div>
<div class="form-group">
	<label>Placa</label>
	<input type="text" class="form-control" id="license_plate" placeholder="Placa" disabled="disabled">
</div>
<div class="form-group">
	<label>Hora Inicio</label>
	<input type="text" class="form-control" id="start_time" placeholder="Hora Inicio" disabled="disabled">
</div>
<div class="form-group">
	<label>Hora Fín</label>
	<input type="text" class="form-control" id="end_time" placeholder="Hora Fín" disabled="disabled">
</div>
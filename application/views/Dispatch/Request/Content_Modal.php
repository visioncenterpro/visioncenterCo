<div class="form-group">
	<label>Placa</label>
	<!-- <input type="text" class="form-control" id="license_plate" placeholder="Placa" disabled="disabled"> -->
	<select class="form-control" id="license_plate" onchange="type_truck()">
		<?php foreach ($data_request as $key => $value) { ?>
			<option value="<?= $value->id_request_sd?>"><?= $value->license_plate?></option>
		<?php } ?>
	</select>
	<br/>
	<input type="text" class="form-control" id="add_license2" placeholder="Agregar Placa">
</div>
<div class="form-group">
	<label>Conductor</label>
	<input type="text" class="form-control" id="driver" disabled="disabled">
</div>
<div class="form-group">
	<label>Tipo Camión</label>
	<input type="text" class="form-control" id="type_truck" placeholder="Tipo de Camión" disabled="disabled">
</div>
<div class="form-group">
	<label>Hora Inicio</label>
	<input type="text" class="form-control" id="start_time" placeholder="Hora Inicio" disabled="disabled">
</div>
<div class="form-group">
	<label>Hora Fín</label>
	<input type="text" class="form-control" id="end_time" placeholder="Hora Fín" disabled="disabled">
</div>
<div class="form-group">
	<label>Observaciones</label>
	<textarea class="form-control" id="observation"></textarea>
</div>
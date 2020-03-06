<div class="content-wrapper">
    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Infomacion de Maquinas</h1>
                        <button type="button" class="btn btn-default  pull-right" onclick="UpdateMachine(<?= $machine->id_machine ?>)" ><i class="fa fa-fw fa-refresh"></i> ACTUALIZAR</button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form role="form" id="form" method="POST" enctype="multipart/form-data">

                                <div class="col-md-4">  
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <input type="text"  value="<?= $machine->description ?>" name="descripcion" class="form-control required" id="descripcion"  />
                                    </div>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group register">
                                        <label for="code">Codigo</label>
                                        <select name="code" class="form-control select2 required" id="code">
                                            <option value="" selected="">. . .</option>
                                            <option value="MPR" <?= ($machine->code == "MPR") ? "selected" : "" ?> >MPR</option>
                                            <option value="MAP" <?= ($machine->code == "MAP") ? "selected" : "" ?> >MAP</option>                                       
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">   
                                    <div class="form-group">
                                        <label>Marca</label>
                                        <input name="brand" value="<?= $machine->brand ?>"type="text" class="form-control  required" id="brand" placeholder="Marca Maquina">
                                    </div>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group">
                                        <label>Modelo</label>
                                        <input name="model" value="<?= $machine->model ?>"type="text" class="form-control  required" id="model" placeholder="Model Maquina">
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label>Area</label>
                                        <select name="area" class="form-control select2 required" id="area">
                                            <option value="">. . .</option>                                    
                                            <?php foreach ($programacion as $e) : ?>
                                                <option value="<?= $e->id_area ?>" <?= $e->description ?></option>
                                            <?php endforeach; ?>
                                        </select>                                 
                                    </div>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select name="status" class="form-control select2 required" id="status">
                                            <option value="">. . .</option>                                    
                                            <?php foreach ($status as $e) : ?>
                                                <option value="<?= $e->id_status ?>" <?= ($machine->status == $e->id_status) ? "selected" : "" ?> ><?= $e->description ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">                                        
                                        <div class="col-md-6">
                                            <div class="pre-scrollable">
                                                <div class="box box-default">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Funciones</h3>
                                                    </div>
                                                    <div class="box-body no-padding">
                                                        <table class="table table-condensed">
                                                            <tr>
                                                                <th>Funciones</th>
                                                                <th>Asignar</th>
                                                            </tr>
                                                            <?php foreach ($functions as $f) : ?>
                                                                <tr>
                                                                    <td><?= $f->description ?></td>
                                                                    <td><input type="checkbox" value="<?= $f->id_function ?>" class="functions" <?= (!empty($f->id_machine)) ? "checked" : "" ?>  ></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>         
                                        <div class="col-md-6">                                           
                                            <div class="box box-default">
                                                <div class="box-header">
                                                    <h3 class="box-title">Auxiliar Mantenimiento</h3>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Auxiliar</th>
                                                            <th>Asignar</th>
                                                        </tr>
                                                        <?php foreach ($User_Machine as $u): ?>
                                                            <tr>
                                                                <td><?= strtoupper($u->name) ?></td>
                                                                <td><input type="checkbox" class="users" value="<?= $u->id_users ?>"  <?= (!empty($u->id_machine)) ? "checked" : "" ?>  ></td>
                                                            </tr>
                                                        <?php endforeach; ?>                                     
                                                    </table>
                                                </div>
                                            </div>                                          
                                        </div> 
                                    </div> 
                                </div>      
                            </form>
                        </div> 
                    </div> 
                    <div class="modal-footer">

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script>
    $(function () {

        $('.select2').select2();

        $('.functions').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        }).on('ifChanged', function (e) {
            var isChecked = e.currentTarget.checked;
            if (isChecked == true) {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateUserMachine", {id_machine: <?= $id ?>, id_function: this.value, option: "insert"}, function (data) {
                    if (data.res == "OK") {
                        swal({title: 'Exito!', text: "Funcion Insertada", type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });
            } else {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateUserMachine", {id_machine: <?= $id ?>, id_function: this.value, option: "delete"}, function (data) {
                    if (data.res == "OK") {
                        swal({title: 'Exito!', text: "Funcion Eliminada", type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });
            }
        });

        $('.users').iCheck({
            checkboxClass: 'icheckbox_minimal-blue'
        }).on('ifChanged', function (e) {
            var isChecked = e.currentTarget.checked;
            if (isChecked == true) {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateAuxMachine", {id_machine: <?= $id ?>, id_user: this.value, option: "insert"}, function (data) {
                    if (data.res == "OK") {
                        swal({title: 'Exito!', text: "Auxiliar Asignado", type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });
            } else {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateAuxMachine", {id_machine: <?= $id ?>, id_user: this.value, option: "delete"}, function (data) {
                    if (data.res == "OK") {
                        swal({title: 'Exito!', text: "Auxiliar Eliminado", type: 'success'});
                    } else {
                        swal({title: 'Error!', text: data, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });
            }
        });

    });


    function UpdateMachine(id_machine) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_machine", id_machine);
        $.ajax({
            url: "<?= base_url() ?>Production/Parameters/Machine/C_Machine_La/UpdateMachine",
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                if (obj.res == "OK") {
                    swal({
                        title: 'Operacion Exitosa!',
                        text: "Registro Actualizado.",
                        type: 'success'
                    });
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            if(error.status == 200){
                RedirectLogin();
            }else{
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }


</script>
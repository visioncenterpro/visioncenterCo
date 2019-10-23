<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Crear Maquinas</h3>
                <button class="btn btn-default  pull-right" onclick="CreateMachine()"><i class="fa fa-fw fa-save"></i> Guardar</button>
            </div>
            <div class="box-body"> 
                <form role="form" id="form" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row"> 
                            <div class="col-md-4">  
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <input name="description" type="text" class="form-control required" id="description" placeholder="Descripcion Maquina">
                                </div>
                            </div>                           
                            <div class="col-md-2"> 
                                <div class="form-group">
                                    <label>Codigo</label>
                                    <select name="code" class="form-control select2 required" id="code">
                                        <option value="" selected="">. . .</option>
                                        <option value="MPR">MPR</option>
                                        <option value="MAP">MAP</option>                                       
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">  
                                <div class="form-group">
                                    <label>Marca</label>
                                    <input name="brand" type="text" class="form-control  required" id="brand" placeholder="Marca Maquina">
                                </div>
                            </div>
                            <div class="col-md-2">  
                                <div class="form-group">
                                    <label>Modelo</label>
                                    <input name="model" type="text" class="form-control  required" id="model" placeholder="Model Maquina">
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label>Area</label>
                                    <select name="area" class="form-control select2 required" id="area">
                                        <option value="">. . .</option>                                    
                                        <?php foreach ($area as $e) : ?>
                                            <option value="<?= $e->id_pro_area ?>"><?= $e->description ?></option>
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
                                            <option value="<?= $e->id_status ?>"><?= $e->description ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">                            
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
                                                        <td><input type="checkbox" class="functions" idfuncion="<?= $f->id_function ?>" ></td>
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
                                            <?php foreach ($User_Machine as $u) : ?>
                                                <tr>
                                                    <td><?= $u->name ?></td>
                                                    <td><input type="checkbox" class="users" iduser="<?= $u->id_users ?>"  ></td>
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

            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>

</div>

<script>
    $(function () {
        $('.select2').select2();

        $('.functions').iCheck({
            checkboxClass: 'icheckbox_minimal-red'
        }).on('ifChanged', function (e) {
            var isChecked = e.currentTarget.checked;
            //console.log(this.value)
        });
        $('.users').iCheck({
            checkboxClass: 'icheckbox_minimal-red'
        }).on('ifChanged', function (e) {
            var isChecked = e.currentTarget.checked;
            //console.log(this.value)
        })
    });

    function CreateMachine() {
        var error = false;
        var count = 0;
        var countU = 0;
        $(".required").each(function () {
            if (!ValidateInput($(this).attr("id"))) {
                error = true;
            }
        });

        if (!error) {

            var arreglo = [];

            $(".functions").each(function () {
                var id = $(this).attr("idfuncion");
                if ($(this).prop("checked")) {
                    arreglo.push(id);
                    count++;
                }
                if (count <= 0) {
                    swal({title: 'error!', text: "Debe digitar la funcion de la maquina", type: 'error'});
                }
            });

            var arregloUser = [];
            $(".users").each(function () {
                var id = $(this).attr("iduser");
                if ($(this).prop("checked")) {
                    arregloUser.push(id);
                    countU++;
                }
                if (countU <= 0) {
                    swal({title: 'error!', text: "Debe digitar el auxiliar de mantenimiento", type: 'error'});
                }
            });
            if (count > 0 && countU > 0) {
                var formData = new FormData($('#form')[0]);
                formData.append("function", arreglo);
                formData.append("users", arregloUser);
                $.ajax({
                    url: "<?= base_url() ?>Production/Parameters/Machine/C_Machine/CreateMachine",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.res == "OK") {
                            swal({
                                title: 'Operacion Exitosa!',
                                text: "El registro ha sido creado.",
                                type: 'success'
                            });
                            $('#form')[0].reset();
                            $(".select2").val("").trigger("change")
                            $('.users').prop('checked',false).iCheck('update');
                            $('.functions').prop('checked',false).iCheck('update'); 
                            
                            
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
        } else {
            swal({title: 'error!', text: "Debe digitar los campos", type: 'error'});
        }
    }


</script>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Maquinas</h3>

            </div>
            <div class="box-body">
                <div class="col-md-12" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<div id="machine_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog ">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">DATOS MAQUINA</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" name="descripcion" class="form-control required" id="descripcion"  />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group register">
                                <label for="code">Codigo</label>
                                <select name="code" class="form-control select2 required" id="code">
                                    <option value="" selected="">. . .</option>
                                    <option value="MPR">MPR</option>
                                    <option value="MAP">MAP</option>                                       
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label>Marca</label>
                                <input name="brand" type="text" class="form-control  required" id="brand" placeholder="Marca Maquina">
                            </div>
                        </div>
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label>Modelo</label>
                                <input name="model" type="text" class="form-control  required" id="model" placeholder="Model Maquina">
                            </div>
                        </div>
                        <div class="col-md-6"> 
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
                        <div class="col-md-6"> 
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
                    </form>
                </div> 
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">CANCELAR</button>               
                <button type="button" class="btn btn-primary update" >ACTUALIZAR</button>
            </div>
        </div>
    </div>
</div>        
<script>
    $(function () {
        $('#tabla_Machine').DataTable();
    });

    function Delete(id_machine, titulo) {
        swal({
            title: 'Esta seguro de eliminar la maquina ' + titulo + '!',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar!'
        }).then((result) => {
            if (result) {
                $.post("<?= base_url() ?>Production/Parameters/Machine/C_Machine/DeleteMachine", {id_machine: id_machine}, function (data) {
                    if (data.res == "OK") {
                        swal('Operacion Exitosa!', 'El registro ha sido eliminado.', 'success').then((result) => {
                            $("#content-table").html(data.tabla);
                            $('#tabla_Machine').DataTable();
                        });
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
        }).catch(swal.noop)
    }


    function Update(id_machine) {

        window.location = '<?= base_url(); ?>Production/Parameters/Machine/C_Machine/InfoMachine/' + id_machine;

    }
    function UpdateMachine(id_machine) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_machine", id_machine);
        $.ajax({
            url: "<?= base_url() ?>Production/Parameters/Machine/C_Machine/UpdateMachine",
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
                    })

                    $("#content-table").html(obj.tabla);
                    $('#tabla_Machine').DataTable();
                    $("#machine_form").modal("hide");

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
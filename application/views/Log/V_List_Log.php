<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Seguimiento LOG</h3>
            </div>
            <div class="box-body">
                <div class="col col-md-6">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" class="form-control" id="fecha">
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select class="form-control" id="user">
                            <?php foreach ($users as $key => $value) { ?>
                            <option value="<?= $value->id_users ?>"><?= $value->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col col-md-6">
                    <button class="btn btn-primary" onclick="buscar()">Enviar</button>
                    <br><br>
                </div>
                
                <div class="col-md" id="content-table">
                    <?= $table ?>
                </div>
            </div>
            <div class="box-footer">

            </div>
        </div>
    </section>
</div>

<script>
    var cont = 0;
    function buscar(){
        cont++;
        var fecha = $("#fecha").val();
        var user = $("#user").val();
        if(fecha == ""){
            swal(
                'Atención!',
                'Ingrese todos los campos',
                'error'
            )
        }else{
            $.ajax({
                url:  "<?= base_url()?>Seguimiento/C_Log/datos",
                type: 'POST',
                data: {fecha:fecha,user:user},
                success: function(data){
                    var datos = JSON.parse(data);
                    if(datos == null){
                        swal(
                            'Error',
                            'No se encontraron datos',
                            'error'
                          )
                    }else{
                        var array = [];
                        for (var i = 0; i < datos['level'].length; i++){
                           array.push([datos['level'][i],datos['time'][i],datos['message'][i]]);
                        }
                        if(cont > 1){
                            //$('#example').DataTable.destroy();
                            $('#example').DataTable().clear();
                            $('#example').DataTable().destroy();
                        }
                        $('#example').DataTable( {
                            data: array,
                            columns: [
                                { title: "Tipo" },
                                { title: "Fecha" },
                                { title: "Acción" }
                            ]
                        } );
                    }
                }
            });
        }
    }
</script>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Ausentismos  || 
                        <small>Listado Ausentismo - lideres - cuadradores - aux - recuperadores  </small></h3>
            </div>
            <div class="box-body">
                <section class="content">
                    <div class="box">
                        
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-12" id="content-table">
                                    <?= $table ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">

                        </div>
                    </div>
                </section>
            </div>

        </div>
    </section>
</div>
<div id="menu_form"  class="modal fade" tabindex="-1" role="dialog"   >
    <div class="modal-dialog modal-lg">
        <div class="modal-content box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">ACTUALIZAR INFORMACION DE NOVEDADES</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form role="form" id="form" method="POST" enctype="multipart/form-data">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Cedula </label>
                                <input type="text" name="identification" class="form-control required" id="identification" placeholder="Nombres"  disabled/>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Nombres </label>
                                <input type="text" name="name" class="form-control required" id="name" placeholder="Nombres"  disabled/>
                            </div>
                        </div>                       
                        <div class="col-md-4">
                            <div class="form-group register">
                                <label for="tipo">Tipo</label>
                                <input type="text" name="tipo" class="form-control required" id="tipo" placeholder="Nombres" disabled />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="evidencia">Importar Evidencia </label>
                                <input type="file" id="evidencia" name="evidencia">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observacion</label>
                                <textarea class="form-control" rows="3" placeholder="Observacion ..." id="textobsrh" name="textobsrh"></textarea>
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

        CreateDataTable("table_register", false, false, true, true, true);
        // $(".dt-buttons").append('<label style="margin-left: 5px;"><a onclick="Create()" class="btn btn-default btn-sm buttons-excel buttons-html5" tabindex="0" aria-controls="tabla_user" href="#"><span><i class="fa fa-user-plus"></i> Crear</span></a></label>');

    });
    function Update(id_absenteeism) {
        $("#form")[0].reset();
        $("#identification").val($("#identification" + id_absenteeism).text());
        //$("#status").val($("#status" + id_roles).attr("val"));
        $("#name").val($("#name" + id_absenteeism).text());
        $("#tipo").val($("#tipo" + id_absenteeism).text());
        $(".update").show();
        $("#menu_form").modal("show");
        $(".update").attr("onclick", "UpdateRH(" + id_absenteeism + ")");
    }

    function UpdateRH(id_absenteeism) {
        var formData = new FormData($('#form')[0]);
        formData.append("id_absenteeism", id_absenteeism);
        $.ajax({
            url: "<?= base_url() ?>Absenteeism/Programming/C_Absenteeism_La/UpdateRH",
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
                    }).then((result) => {
                        $("#content-table").html(obj.tabla);
                        // CreateDataTable("tabla_ausentismo", false, false, true, true, true);
                        $("#menu_form").modal("hide");
                    });
                } else {
                    swal({title: 'Error!', text: obj.res, type: 'error'});
                }
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function (error) {
            if (error.status == 200) {
                RedirectLogin();
            } else {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }


//    function evidence(id) {
//      var ajaxOptions = {
//    		url: '<?= base_url() ?>application/public/evidece' + id;
//     }
//    }

	function evidence(id) {
    	var ajaxOptions = {
    		url: '<?= base_url() ?>application/public/evidece/' + id
        };
        
        var res = $.ajax(ajaxOptions);
        
        function onAjaxDone(data) {
          
        		location.href = '<?= base_url() ?>application/public/evidece/' + id;
        }
        
        function onAjaxFail() {
        	alert('No Encuentra Archivo');
        }
        
        res
        	.done(onAjaxDone)
            .fail(onAjaxFail)
        ;
    }
    
	function onDownloadLinkClick(e) {
    	e.preventDefault();
        var $this = $(this);
        var id = $this.data('id');
        downloadLink(id);
    }
    
	$('.download-link').on('click', onDownloadLinkClick);

</script>
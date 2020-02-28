<style>
    #print-img{border: 1px solid #e0d7d7;}
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
    th{text-align: center;}
    .modal-dialog{width: 60%;}
    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
        border: 0px solid #f4f4f4;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Order Imos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $table ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog" style="width:300px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Parametrizar Etiquetas</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Cantidad Minima De Piezas</label>
                            <input type="number" class="form-control" id="quantity" value="5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="quantity">Generacion Estandar</label>
                            <select class="form-control" id="type" >
                                <option value="">. . .</option>
                                <option value="D">DOBLE</option>
                                <option value="S">SIMPLE</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="table-sheet">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-default pull-right" id="btn-tags2" >Generar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var order, idorder;
    var arrayGeneral = [];

    $(document).ready(function () {
        TableData("table_order");
        //$("#table_order_wrapper >.row >.col-sm-6:eq(0)").append('<label style="margin-left: 5px;"><button type="button" class="btn btn-default btn-sm " id="btn-tags"><i class="fa  fa-tags"></i> Generar Etiquetas</button></label>');


//        $('#table_order tbody').on('click', 'tr', function () {
//            if ($(this).hasClass('selected')) {
//                $(this).removeClass('selected');
//
//                var index = arrayGeneral.indexOf($(this).attr("id"));
//                if (index > -1) {
//                    arrayGeneral.splice(index, 1);
//                }
//            } else {
//                arrayGeneral.push($(this).attr("id"))
//                $(this).addClass('selected');
//            }
//        });

        $('#btn-tags').click(function () {
            if (arrayGeneral.length > 0) {
                $.post("<?= base_url() ?>Imos/Order/C_Order_La/LoadSheetOrders", {arrayGeneral: arrayGeneral}, function (data) {
                    if (data.res == "OK") {
                        $("#table-sheet").html(data.tabla);
                        $("#modal").modal("show");
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });

            } else {
                swal({title: 'Error!', text: "Debe seleccionar al menos una order", type: 'error'});
            }
        });


        $('#btn-tags2').click(function () {
            if (ValidateInput("quantity")) {
                
                var cnt = $("#quantity").val();
                var type_generation = $("#type").val();
                var array_body = [];
                $("#table_sheet tbody tr").each(function () {
                    var array_body_hijo = [];
                    var lam = $(this).attr("id");
                    array_body_hijo.push(lam);
                    array_body_hijo.push($(".lam-"+lam).val());


                    array_body.push(array_body_hijo);
                });
                
                $("#modal").modal("hide");
                $.post("<?= base_url() ?>Imos/Order/C_Order_La/GenerateTagsOrder", {arrayGeneral: arrayGeneral,cnt:cnt,type_generation:type_generation,array_body:array_body}, function (data) {
                    if (data.res == "OK") {
                        swal({title: 'Exito!', text: "Etiquetas Generadas!", type: 'success'});
                        $('tr.selected').removeClass('selected');
                        arrayGeneral = [];
                    } else {
                        swal({title: 'Error!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
            }
        });

    });

    function ListItems(name, id) {
        order = name;
        idorder = id;
//        $.post("<?= base_url() ?>Imos/Order/C_Order/ValidateAck", {name: name, id: id}, function (data) {
//            if (data.res == "COMPLETE" || data.res == "EMPTY") {
        location.href = "<?= base_url() ?>Imos/Order/C_Order_La/ListItems/" + name + "/" + id;
//            } else if (data.res == "VALIDATE") {
//                $(".modal-body").html(data.table);
//
//                $('input[type="checkbox"]').iCheck({
//                    checkboxClass: 'icheckbox_minimal-blue'
//                }).on('ifChanged', function (e) {
//                    var isChecked = e.currentTarget.checked;
//                    if (isChecked == true) {
//                        var external = 1;
//                    } else {
//                        var external = 0;
//                    }
//                    UpdataItemImport(0, this.value, 'external', external);
//                });
//
//                $("#modal").modal("show");
//            } else if (data.res == "EMPTY") {
//                //swal({title: 'Error!', text: "Aun no ha sido creado o importado el Acknowledgement para la order " + name, type: 'error'});
//            }
//        }, 'json').fail(function (error) {
//            if(error.status == 200){
//                RedirectLogin();
//            }else{
//                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
//            }
//        });
    }

    function ShowImg(url) {
        $("#print-img").html('<img src="' + url + '" class="" style="max-width: 100%;">');
    }
</script>
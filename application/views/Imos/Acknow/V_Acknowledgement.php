<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Acknowledgement N&deg; <?= $values['order'] ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">Info General</a></li>
                                <li><a href="#tab_2" data-toggle="tab">Muebles</a></li>
                                <li><a href="#tab_3" data-toggle="tab">Herrajes</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <?php
                                        $styleA = "";
                                        $styleB = "";
                                        foreach ($fields as $v) :

                                            $title = str_replace("_", " ", ucwords($v->COLUMN_NAME, "_"));

                                            if (strpos($title, 'Style A') === false) {
                                                if (strpos($title, 'Style B') === false) {
                                                    ?>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="<?= $v->COLUMN_NAME ?>"><?= $title ?></label>
                                                            <input type="text" class="form-control  input-sm" id="<?= $v->COLUMN_NAME ?>" value="<?= $values[$v->COLUMN_NAME] ?>">
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                    $styleB .= '<div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="' . $v->COLUMN_NAME . '">' . $title . '</label>
                                                                        <input type="text" class="form-control  input-sm" id="' . $v->COLUMN_NAME . '" value="' . $values[$v->COLUMN_NAME] . '">
                                                                    </div>
                                                                </div>';
                                                }
                                            } else {
                                                $styleA .= '<div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="' . $v->COLUMN_NAME . '">' . $title . '</label>
                                                                    <input type="text" class="form-control  input-sm" id="' . $v->COLUMN_NAME . '" value="' . $values[$v->COLUMN_NAME] . '">
                                                                </div>
                                                            </div>';
                                            }
                                        endforeach;
                                        ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="box box-primary direct-chat ">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Style A</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row" >
                                                        <?=$styleA?>
                                                    </div>
                                                </div>
                                                <div class="box-footer"></div>
                                            </div> 
                                        </div>
                                        <div class="col-md-6">
                                            <div class="box box-warning direct-chat ">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Style B</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row" >
                                                        <?=$styleB?>
                                                    </div>
                                                </div>
                                                <div class="box-footer"></div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $table ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $detail_aditional ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary pull-right" id="update">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        CreateTable("table_detail");
        CreateTable("Adtable_detail");
    });

    function CreateTable(idTable) {
        var table = $('#' + idTable).DataTable({
            scrollY: "500px",
            paging: false,
            fixedHeader: true,
            sScrollX: true,
            order: [[1, 'asc']],
            scrollX: true,
            "bScrollCollapse": true
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            table.columns.adjust();
        });
    }

    function ShowModal(id, name) {
        $.post("<?= base_url() ?>Imos/Acknow/C_Acknow/LoadDetailInfo", {id: id}, function (data) {
            $(".modal-title").html(name);
            $(".modal-body").html(data);
            $("#update").attr("onclick", "UpdateDetail(" + id + ")")
            $("#modal-detail").modal("show");
        }).fail(function (error) {
            if(error.status == 200){
                RedirectLogin();
            }else{
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }

    function UpdateDetail(id) {

    }
</script>
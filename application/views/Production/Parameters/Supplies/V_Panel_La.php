<div class="content-wrapper">
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Parametrización de Insumos</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" >
                        <?= $typeSupplies; ?>
                    </div>
                    <div class="col-md-12" id="table_with_supplies">

                    </div>
                </div>
            </div>            

        </div>
    </section>
</div>

<?= $modal; ?>

<script>
    $(document).keypress(function (e) {
        if (e.which == 13) {
            $("#btn_consult_supplies").click();
            return false;
        }
    });
    $(document).ready(function () {
        
        $("#btn_consult_supplies").click(function () {
            var typeSupplySelected = $("#type_supply").val();
            var codeSupply = $("#code_supply").val();
            var codeOrder = $("#code_order").val();
            $.post(
                    "<?= base_url() ?>Production/Parameters/Supplies/C_Supplies_La/getSuppliesByFilter",
                    {typeSupplySelected: typeSupplySelected,
                        codeSupply: codeSupply,
                        codeOrder: codeOrder},
                    function (data) {
                        $("#table_with_supplies").html(data.table);
                        TableData("table_supplies", false, false, false);
                    }, 'json').fail(function (error) {
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            });
        });
        
        $("#btn_open_create").click(function(){
            openModalCreate();
        });
        
        $("#type").change(function(){
            var type = $("#type").val();
            $("#dimension").parent().css('display', 
                (type === '<?= GROUP_CANTO ?>') ? 'block' : 'none');
        });
        
    });
    
    function openModalCreate() {
        clearVisualElements();
        $('#dimension').parent().css('display', 'none');
        $('#btnUpdateModal').css('display', 'none');
        $('#btnCreateModal').css('display', 'block');
        $('#modal-supply').modal('show');
    }
    
    function create() {
        var name = $('#name').val();
        var code = $('#code').val();
        var quantityPerPackage = $('#quantityPerPackage').val();
        var weightPerPackage = $('#weightPerPackage').val();
        var dimension = $('#dimension').val();
        var unit = $('#unit').val();
        var type = $('#type').val();
        
        if (validatefield()) {
        
            $.post(
                "<?= base_url() ?>Production/Parameters/Supplies/C_Supplies_La/createSupply",
                {
                    name : name,
                    code : code,
                    quantityPerPackage : quantityPerPackage,
                    weightPerPackage : weightPerPackage,
                    dimension : dimension,
                    unit : unit,
                    type : type,
                },
                function (data) {
                    if (data.res == "OK") {
                        var id = data.id;
                        alertify.success("Registro creado.");
                        $('#modal-supply').modal('hide');

                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
        }
        
    }
    
    function openModalUpdate(idSupply) {
        clearVisualElements();
        $('#dimension').parent().css('display', 'none');
        $('#id_supply').val(idSupply);
        $('#name').val($('.name-'+idSupply).text());
        $('#code').val($('.code-'+idSupply).text());
        $('#quantityPerPackage').val($('.quantity-'+idSupply).text());
        $('#weightPerPackage').val($('.weight-'+idSupply).text());
        
        var idTypeSupply = $('.code_type-'+idSupply).attr('code_type');
        if (idTypeSupply === '<?= GROUP_CANTO ?>') {
            $('#dimension').val($('.dimension-'+idSupply).text());
            $('#dimension').parent().css('display', 'block');
        }
        $('#unit').val($('.code_unit-'+idSupply).attr('code_unit'));
        $('#type').val($('.code_type-'+idSupply).attr('code_type'));
        
        $('#btnCreateModal').css('display', 'none');
        $('#btnUpdateModal').css('display', 'block');
        
        $('#modal-supply').modal('show');
    }
    
    function update() {
        var id_supply = $('#id_supply').val();
        var name = $('#name').val();
        var code = $('#code').val();
        var quantityPerPackage = $('#quantityPerPackage').val();
        var weightPerPackage = $('#weightPerPackage').val();
        var dimension = $('#dimension').val();
        var unit = $('#unit').val();
        var type = $('#type').val();
        
        if (validatefield()) {
        
            $.post(
                "<?= base_url() ?>Production/Parameters/Supplies/C_Supplies_La/updateSupply",
                {
                    id_supply : id_supply,
                    name : name,
                    code : code,
                    quantityPerPackage : quantityPerPackage,
                    weightPerPackage : weightPerPackage,
                    dimension : dimension,
                    unit : unit,
                    type : type
                },
                function (data) {
                    if (data.res == "OK") {
                        
                        alertify.success("Registro Actualizado.");
                        $('.name-'+id_supply).text($('#name').val());
                        $('.code-'+id_supply).text($('#code').val());
                        $('.quantity-'+id_supply).text($('#quantityPerPackage').val());
                        $('.weight-'+id_supply).text($('#weightPerPackage').val());
                        
                        if ($('#weightPerPackage').val() !== "" && $('#weightPerPackage').val() !== "0") {
                            $('.weight-'+id_supply).removeClass('bg-danger');
                            $('.weight-'+id_supply).addClass('bg-success');
                        } else {
                            $('.weight-'+id_supply).removeClass('bg-success');
                            $('.weight-'+id_supply).addClass('bg-danger');
                        }                        
                        
                        $('.dimension-'+id_supply).text($('#dimension').val());
                        $('.code_unit-'+id_supply).text($('#unit option:selected').text());
                        $('.code_unit-'+id_supply).attr('code_unit', $('#unit').val());
                        $('.code_type-'+id_supply).text($('#type option:selected').text());
                        $('.code_type-'+id_supply).attr('code_type', $('#type').val());
                        $('#modal-supply').modal('hide');

                    } else {
                        swal({title: 'Error!', text: obj.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                });
        }
    }
    
    function clearVisualElements() {
        $('#type').val("");
        $('#unit').val("");
        $('#type').parent().removeClass('has-error');
        $('#unit').parent().removeClass('has-error');
        $('#name').val("");
        $('#code').val("");
        $('#quantityPerPackage').val("");
        $('#weightPerPackage').val("");
        $('#dimension').val("");
    }
    
    var nav4 = window.Event ? true : false;
    
    function acceptNumberAndOncePoint(event, name) //Sólo números y SÓLO 1 punto decimal
    {	
            // Punto = 46
            var key = nav4 ? event.which : event.keyCode;
            cadena=document.getElementById(name).value;
            if(cadena.indexOf('.')==-1)
            {return (key <= 13 || (key >= 48 && key <= 57) || key == 46);}
            else
            {return (key <= 13 || (key >= 48 && key <= 57));}

    }
    
    
</script>
<?php
// $serverName = "192.168.0.3, 1434"; //serverName\instanceName
// $connectionInfo = array( "Database"=>"AX2009MODPROD", "UID"=>"visionselect", "PWD"=>"vision20182018");
// $conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Conexión establecida.<br />";
// }else{
//      echo "Conexión no se pudo establecer.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

//$con = new mysqli('192.168.0.6','desarrollo','123456789');
//if(!$con) { echo "Cannot connect to the database ";die();}
//mysqli_select_db($con,'vision');
//$result=$con->query('show tables');
//while($tables = $result->fetch_array()) {
 //       foreach ($tables as $key => $value) {
   //      mysqli_query($con,"ALTER TABLE $value CONVERT TO CHARACTER SET utf8 COLLATE utf8_spanish_ci");
   //}}
//echo "The collation of your database has been successfully changed!";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>JS Bin</title>
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/Ionicons/css/ionicons.min.css">
	        <link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/css/custom.css">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/sweetalert/sweetalert2.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="http://192.168.5.209/VisionCenter/dist/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="http://192.168.5.209/VisionCenter/dist/jquery/jquery.js"></script>
</head>
<body>

	<div class="content-wrapper" id="app">
	    <section class="content">
	        <div class="row">
	            <div class="col-md-12">
	                <div class="box box-primary">
	                    <div class="box-header with-border">
	                        <h3 class="box-title">Formulario</h3>
	                    </div>
	                    <div class="box-body">
	                        <ul class="nav nav-tabs">
	                            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
	                            <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
	                            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
	                        </ul>
	                        <form class="form-pb">
	                            <div class="tab-content">
	                                
	                                <div id="home" class="tab-pane fade in active">
	                                    <br><br>
	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="box box-primary">
	                                            <div class="box-header with-border">
	                                                <h3 class="box-title">Datos de la construcción</h3>
	                                            </div>
	                                            <div class="box-body">
	                                                <br>
	                                                    <div class="row">
	                                                        <div class="col-md-6">
	                                                            <div class="form-group">
	                                                                <label>id_project_construccion</label>
	                                                                <input type="text" v-model="newProject.id_project_construccion" name="id_project_construccion" class="form-control" placeholder="id project construccion" />
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>id_stage_construction</label>
	                                                                <input type="text" v-model="newProject.id_stage_construction"  name="id_stage_construction" class="form-control" placeholder="id_stage_construction" />
	                                                            </div>  
	                                                        </div>
	                                                        <div class="col-md-6">
	                                                            <div class="form-group">
	                                                                <label>id_stage_project_construction</label>
	                                                                <input type="text" v-model="newProject.id_stage_project_construction" name="id_stage_project_construction" class="form-control" placeholder="id_stage_project_construction" />
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>id_construction_legal</label>
	                                                                <input type="text" v-model="newProject.id_construction_legal" name="id_construction_legal" class="form-control" placeholder="id_construction_legal" />
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                    
	                                                    <div class="form-group">
	                                                        <label>visioncenter_projects_censuscol</label>
	                                                        <input type="text" v-model="newProject.visioncenter_projects_censuscol" name="visioncenter_projects_censuscol" class="form-control" placeholder="visioncenter_projects_censuscol" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>Nombre Construcción</label>
	                                                        <input type="text" v-model="newProject.name_construction" name="name_construction" class="form-control" placeholder="name_construction" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>Nombre Proyecto</label>
	                                                        <input type="text" v-model="newProject.project_name_construction" name="project_name_construction" class="form-control" placeholder="project_name_construction" />
	                                                    </div>
	                                                    
	                                            </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                            <div class="box-header with-border">
	                                                <h3 class="box-title">Datos de la construcción</h3>
	                                            </div>
	                                            <div class="box-body">
	                                                    <div class="form-group">
	                                                        <label>Direccion</label>
	                                                        <input type="text" name="address_construction" v-model="newProject.address_construction" class="form-control" placeholder="address_construction" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>pending_cast_units</label>
	                                                        <input type="text" v-model="newProject.pending_cast_units" name="pending_cast_units" class="form-control" placeholder="pending_cast_units" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>zone_sub_census</label>
	                                                        <input type="text" v-model="newProject.zone_sub_census" name="zone_sub_census" class="form-control" placeholder="zone_sub_census" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>address_name_construction</label>
	                                                        <input type="text" v-model="newProject.address_name_construction" name="address_name_construction" class="form-control" placeholder="address_name_construction" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>construction_source</label>
	                                                        <input type="text" v-model="newProject.construction_source" name="construction_source" class="form-control" placeholder="construction_source" />
	                                                    </div>
	                                                    
	                                            </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                                <div class="box-header with-border">
	                                                    <h3 class="box-title">Datos de la construcción</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    
	                                                        <div class="form-group">
	                                                            <label>stratum_construction</label>
	                                                            <input type="text" v-model="newProject.stratum_construction" name="stratum_construction" class="form-control" placeholder="stratum_construction" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Ciudad</label>
	                                                            <input type="text" v-model="newProject.city_construction" name="city_construction" class="form-control" placeholder="city_construction" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Telefono 1</label>
	                                                            <input type="text" v-model="newProject.phone1_construction" name="phone1_construction" class="form-control" placeholder="phone1_construction" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Telefono 2</label>
	                                                            <input type="text" v-model="newProject.phone2_construction" name="phone2_construction" class="form-control" placeholder="phone2_construction" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>status_stage_construction</label>
	                                                            <input type="text" v-model="newProject.status_stage_construction" name="status_stage_construction" class="form-control" placeholder="status_stage_construction" />
	                                                        </div>
	                                                    
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>

	                                <div id="menu1" class="tab-pane fade">
	                                    <br><br>
	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="box box-primary">
	                                                <div class="box-header with-border">
	                                                    <h3 class="box-title"> Fechas </h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    <div class="row">
	                                                        <div class="col-md-4">
	                                                            <div class="form-group">
	                                                                <label>Nombre fase construccion</label>
	                                                                <input type="text" v-model="newProject.stage_name_construction" name="stage_name_construction" class="form-control"  placeholder="stage_name_construction" />
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Date census - {{newProject.date_census}}</label>
	                                                                <datepicker v-model="newProject.date_census"></datepicker>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>date_asign_crm</label>
	                                                                <datepicker v-model="newProject.date_asign_crm"></datepicker>
	                                                            </div>
	                                                        </div>

	                                                        <div class="col-md-4">
	                                                            <div class="form-group">
	                                                                <label>Fecha Facturación 1</label>
	                                                                <datepicker v-model="newProject.date_invoice_1"></datepicker>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Fecha Facturación 2</label>
	                                                                <datepicker v-model="newProject.date_invoice_2"></datepicker>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Fecha Facturación 3</label>
	                                                                <datepicker v-model="newProject.date_invoice_3"></datepicker>
	                                                            </div>
	                                                        </div>
	                                                        
	                                                        <div class="col-md-4">
	                                                            <div class="form-group">
	                                                                <label>date_quotation_census</label>
	                                                                <datepicker v-model="newProject.date_quotation_census"></datepicker>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>Fecha Cierre Final</label>
	                                                                <datepicker v-model="newProject.date_final_closing"></datepicker>
	                                                            </div>
	                                                            <div class="form-group">
	                                                                <label>date_owner_delivery</label>
	                                                                <datepicker v-model="newProject.date_owner_delivery"></datepicker>
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                    <div class="row">
	                                                        <div class="col-md-12">
	                                                            <div class="form-group">
	                                                                <label>name_contact_construction</label>
	                                                                <input type="text" v-model="newProject.name_contact_construction" name="name_contact_construction" class="form-control" placeholder="name_contact_construction" />
	                                                            </div>
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                                <div class="box-header with-border">
	                                                    <h3 class="box-title">Cantidad Muebles</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    
	                                                        <div class="form-group">
	                                                            <label>stage_qty_units</label>
	                                                            <input type="number" v-model="newProject.stage_qty_units" name="stage_qty_units" class="form-control" placeholder="stage_qty_units" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Cocinas</label>
	                                                            <input type="number" v-model="newProject.qty_kitchen" class="form-control" name="qty_kitchen" placeholder="qty_kitchen" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Armarios</label>
	                                                            <input type="number" v-model="newProject.qty_closet_vest" class="form-control" name="qty_closet_vest" placeholder="qty_closet_vest" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Tocadores</label>
	                                                            <input type="number" v-model="newProject.qty_vanities" class="form-control" name="qty_vanities" placeholder="qty_vanities"/> 
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>Marcos Puertas</label>
	                                                            <input type="number" v-model="newProject.qty_doors_frames" class="form-control" name="qty_doors_frames" placeholder="qty_doors_frames" />
	                                                        </div>
	                                                    
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                                <div class="box-header with-border">
	                                                    <h3 class="box-title">Datos construccion</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    
	                                                        <div class="form-group">
	                                                            <label>qty_others</label>
	                                                            <input type="number" v-model="newProject.qty_others" name="qty_others" class="form-control" placeholder="qty_others" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>total_potential_units</label>
	                                                            <input type="text" v-model="newProject.total_potential_units" name="total_potential_units" class="form-control" placeholder="total_potential_units" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>value_kitchen</label>
	                                                            <input type="number" v-model="newProject.value_kitchen" name="value_kitchen" class="form-control" placeholder="value_kitchen" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>value_closet_vest</label>
	                                                            <input type="number" v-model="newProject.value_closet_vest" name="value_closet_vest" class="form-control" placeholder="value_closet_vest" />
	                                                        </div>
	                                                        <div class="form-group">
	                                                            <label>value_vanities</label>
	                                                            <input type="number" v-model="newProject.value_vanities" name="value_vanities" class="form-control" placeholder="value_vanities" />
	                                                        </div>
	                                                    
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                </div>
	                                <div id="menu2" class="tab-pane fade">
	                                    <br>
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                                <div class="box-header">
	                                                    <h3 class="box-title">Datos construccion</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    <div class="form-group">
	                                                        <label>porc_sales_sellern</label>
	                                                        <input type="text" v-model="newProject.porc_sales_sellern" name="porc_sales_sellern" class="form-control" placeholder="porc_sales_sellern" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>value_doors_frames</label>
	                                                        <input type="number" v-model="newProject.value_doors_frames" name="value_doors_frames" class="form-control" placeholder="value_doors_frames" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>value_others</label>
	                                                        <input type="number" v-model="newProject.value_others" name="value_others" class="form-control" placeholder="value_others" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>total_invoice_census</label>
	                                                        <input type="text" v-model="newProject.total_invoice_census" name="total_invoice_census" class="form-control" placeholder="total_invoice_census" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>status_record</label>
	                                                        <input type="text" v-model="newProject.status_record" name="status_record" class="form-control" placeholder="status_record" />
	                                                    </div>  
	                                                </div>
	                                            </div>
	                                        </div>

	                                        <div class="col-md-6">
	                                            <div class="box box-primary">
	                                                <div class="box-header">
	                                                    <h3 class="box-title">Datos construccion</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                    <div class="form-group">
	                                                        <label>Latitud Construcción</label>
	                                                        <input type="number" v-model="newProject.latitude_construction" name="latitude_construction" class="form-control" placeholder="latitude_construction" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>Longitud Construcción</label>
	                                                        <input type="number" v-model="newProject.longitude_construction" name="longitude_construction" class="form-control" placeholder="longitude_construction" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>type_record_info</label>
	                                                        <input type="text" v-model="newProject.type_record_info" name="type_record_info" class="form-control" placeholder="type_record_info" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>status_crm</label>
	                                                        <input type="text" v-model="newProject.status_crm" name="status_crm" class="form-control" placeholder="status_crm" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>asesor_crm</label>
	                                                        <input type="text" v-model="newProject.asesor_crm" name="asesor_crm" class="form-control" placeholder="asesor_crm" />
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>

	                                    </div>
	                                    <div class="row">
	                                        <div class="col-md-12">
	                                            <div class="box box-primary">
	                                                <div class="box-header">
	                                                    <h3 class="box-title">Datos construccion</h3>
	                                                </div>
	                                                <div class="box-body">
	                                                	<div class="form-group">
	                                                        <label>last_update</label>
	                                                        <input type="text" v-model="newProject.last_update" name="last_update" class="form-control" placeholder="last_update" />
	                                                    </div>  
	                                                    <div class="form-group">
	                                                        <label>modified_by</label>
	                                                        <input type="text" v-model="newProject.modified_by" name="modified_by" class="form-control" placeholder="modified_by" />
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>is_active</label>
	                                                        <select class="form-control" v-model="newProject.is_active">
	                                                        	<option value="1">SI</option>
	                                                        	<option value="2">NO</option>
	                                                        </select>
	                                                        <!--<input type="text" v-model="newProject.is_active" name="is_active" class="form-control" placeholder="is_active" />-->
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>is_commited</label>
	                                                        <select class="form-control" v-model="newProject.is_commited">
	                                                        	<option value="1">SI</option>
	                                                        	<option value="2">NO</option>
	                                                        </select>
	                                                        <!--<input type="text" v-model="newProject.is_commited" name="is_commited" class="form-control" placeholder="is_commited" />-->
	                                                    </div>
	                                                    <div class="form-group">
	                                                        <label>is_closed</label>
	                                                        <select class="form-control" v-model="newProject.is_closed">
	                                                        	<option value="1">SI</option>
	                                                        	<option value="2">NO</option>
	                                                        </select>
	                                                        <!--<input type="text" v-model="newProject.is_closed" name="is_closed" class="form-control" placeholder="is_closed" />-->
	                                                    </div>  
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    
	                                </div>
	                                
	                            </div>
	                        </form>
	                    </div>
	                    <div class="box-footer">
	                        <button class="btn btn-primary" type="button" v-on:click="save()">Guardar</button>
	                        <button class="btn btn-danger" type="button">Cancelar</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	        
	    </section>
	</div>

</body>

<!-- VueJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://192.168.5.209/VisionCenter/dist/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="http://192.168.5.209/VisionCenter/dist/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="http://192.168.5.209/VisionCenter/dist/jquery-ui/jquery-ui.min.js"></script>
<!-- FastClick -->
<script src="http://192.168.5.209/VisionCenter/dist/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="http://192.168.5.209/VisionCenter/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="http://192.168.5.209/VisionCenter/dist/js/demo.js"></script>

<script src="http://192.168.5.209/VisionCenter/dist/js/jquery.blockUI.js"></script>

<script src="http://192.168.5.209/VisionCenter/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script> 
	Vue.component('datepicker', {
        template: '<input type="text" class="form-control pull-right" autocomplete="off">',
        mounted: function() {
            const self = this;
	        $(this.$el).datepicker({
	            autoclose: true,
	            startView: 'years',
	        }).on('changeDate', function(e) {
	            self.$emit('input', e.format('yyyy-mm-dd'));
	        });
        },
        destroyed: function () {
            $(this.$el).datepicker('destroy');
        }
    });

	var app = new Vue({
		el: '#app',
		data: {
			newProject:{
				id_project_construccion: '',
	            id_stage_construction: '',
	            id_stage_project_construction: '',
	            date_census: '',
	            visioncenter_projects_censuscol: '',
	            name_construction: '',
	            project_name_construction: '',
	            id_construction_legal: '',
	            address_construction: '',
	            pending_cast_units: '',
	            zone_sub_census: '',
	            address_name_construction:'',
	            construction_source: '',
	            stratum_construction: '',
	            city_construction: '',
	            phone1_construction: '',
	            phone2_construction: '',
	            status_stage_construction: '',
	            stage_name_construction: '',
	            stage_qty_units: '',
	            name_contact_construction: '',
	            porc_sales_seller: '',
	            latitude_construction: '',
	            longitude_construction: '',
	            date_invoice_1: '',
	            date_invoice_2: '',
	            date_invoice_3: '',
	            date_final_closing: '',
	            date_owner_delivery: '',
	            date_quotation_census: '',
	            porc_sales_sellern: '',
	            qty_kitchen: '',
	            qty_closet_vest: '',
	            qty_vanities: '',
	            qty_doors_frames: '',
	            qty_others: '',
	            total_potential_units: '',
	            value_kitchen: '',
	            value_closet_vest: '',
	            value_vanities: '',
	            value_doors_frames: '',
	            value_others: '',
	            total_invoice_census: '',
	            status_record: '',
	            type_record_info: '',
	            status_crm: '',
	            asesor_crm: '',
	            date_asign_crm: '',
	            last_update: '',
	            modified_by: '',
	            is_active: '',
	            is_commited: '',
	            is_closed: ''
			}
            
		},
		methods: {
		    save: function(){
		    	var array = document.querySelectorAll(".form-pb input");
		        var array_date = document.querySelectorAll("input[type=date]");
		        var vali = 0;
		        //console.log(this.newProject);
		        array.forEach(function(element){
		        	//console.log(element.name);
		            //this.newProject[element.name] = element.value;
		            if (element.value == "") {
		                element.style = "border-color: red";
		                vali = 1;
		            }else{
		                element.style = "border-color: #d2d6de";
		            }
		        });
		        array_date.forEach(function(element){
		            if (element.value == "") {
		                vali = 1;
		            }
		        });

		        if (vali == 1) {
		            swal({title: 'error!', text: 'Ingrese todos los campos al formulario', type: 'error'});
		        }else{
		            axios.post('http://192.168.0.116:8000/api/projects/createProject', {
		                newProject: this.newProject
		            }).then(function (response) {
		                console.log(response);
		            }).catch(function (error) {
		                console.log(error);
		            });

		            console.log(json_array_arr);
		        }
		    }
		},
		computed: {
        
    	},
	})
	
</script>
</html>
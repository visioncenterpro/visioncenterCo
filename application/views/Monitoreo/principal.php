<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monitoreo de carga</h3>
                    </div>
                    <div class="box-body">
                        <!--<div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Solicitud" id="solicitud">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary" id="buscar">Buscar</button>
                                </div>
                            </div>
                        </div>-->
                        <table id="tabla_monitoreo" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Solicitud</th>
                                    <th>Proyecto</th>
                                    <th>Orden</th>
                                    <th>Cliente</th>
                                    <th>Ver estado de carga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $key => $value) { ?>
                                <tr>
                                    <td style="cursor:pointer;" onclick="detail_order('<?php echo $value->order; ?>','<?php echo $value->id_request_sd;?>')"><?= $value->id_request_sd?></td>
                                    <td><?= $value->project?></td>
                                    <td><?= $value->order?></td>
                                    <td><?= $value->client?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" aria-label="Left Align" onclick="monitoreo('<?=$value->order?>','<?=$value->id_request_sd?>')">
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                        </button>
                                    </td>
                                </tr> 
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Total carga</h3>
                    </div>
                    <div class="box-body">
                        
                        <div class="content-canvas">
                            <canvas id="myChart"><span>Contar</span></canvas>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Peso Total</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-4" id="peso">
                            <h1 id="number">0</h1>
                            <h3>Peso Total (Kg)</h3>
                        </div>
                        <div class="col-md-4" id="peso">
                            <h1 id="number2">0</h1>
                            <h3>Pendientes por cargar</h3>
                        </div>
                        <div class="col-md-4" id="peso">
                            <h1 id="number3">0</h1>
                            <h3>Paquetes revertidos</h3>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Total camión cargado</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="opact"></div>
                            <img src="<?= base_url() ?>/dist/img/truck.png" width="100%" class="track"></img>
                            <div id="progressid"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="container" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="box-footer" style="text-align: center;">
                        <div class="col-md-12">
                            <label id="description_v">description - </label>
                            <label id="weight_v">peso - </label>
                        
                            <label id="driver_v">driver - </label>
                            <label id="license_v">license_plate</label>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monitoreo</h3>
                    </div>
                    <div class="box-body">
                        <div class="content-canvas">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </div>
            </div>
        </div>
        
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_mueble" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Detalle Muebles de la solicitud #<label id="lbl_orden"></label></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <label>Modulados</label>
          <table id="myTable" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>Mueble</th>
                    <th>Total paquetes</th>
                    <th>Peso Total (kg)</th>
                    <th>Porcentaje cargado</th>
                </tr>
            </thead>
          </table>
          <hr>
          <label>Insumos</label>
          <table id="myTable2" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Total paquetes</th>
                    <th>Peso Total (kg)</th>
                    <th>Porcentaje cargado</th>
                </tr>
            </thead>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
        $("#tabla_monitoreo").DataTable();
        
        $("#buscar").click(function(){
            var solicitud = $("#solicitud").val();
            if(solicitud == ""){
                swal({
                    type: 'error',
                    title: 'Atención',
                    text: 'Campo Vacio'
                });
            }
        });
        
    });
    
    var cont_porcentaje = 0;
    var barc;
    var progress;
    var cont;
    var time;
    var myDoughnutChart;
    var bar;
    function monitoreo(orden,solicitud){
        cont_porcentaje++;
        // plug para texto centrado
        Chart.pluginService.register({
            beforeDraw: function (chart) {
              if (chart.config.options.elements.center) {
                //Get ctx from string
                var ctx = chart.chart.ctx;

                //Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
                //Start with a base font of 30px
                ctx.font = "30px " + fontStyle;

                //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(30 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight);

                //Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse+"px " + fontStyle;
                ctx.fillStyle = color;

                //Draw text in center
                ctx.fillText(txt, centerX, centerY);
              }
            }
        });
        // END plug para texto centrado
        if(cont_porcentaje > 1){
            barc.destroy();
            progress.destroy();
            clearInterval(cont);
            myDoughnutChart.destroy();
            bar.destroy();
        }
        
        var ctx = document.getElementById("myChart");
        myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Cargados","Pendientes"],
                datasets: [{
                    data: [0, 1],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                        
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255,99,132,1)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                legend: {
                    display: false
                },
                elements: {
                    center: {
                    text: '0%',
                    color: '#36A2EB', //Default black
                    fontStyle: 'Helvetica', //Default Arial
                    sidePadding: 15 //Default 20 (as a percentage)
                  }
                }
            }
        });
        var ctx2 = document.getElementById("myChart2");
        bar = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ["Pendientes", "Cargados", "En Proceso", "Revertidos"],
                datasets: [{
                    data: [0, 0, 0, 0],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        
        barc = new ProgressBar.Circle(container, {
            color: '#aaa',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 4,
            trailWidth: 1,
            easing: 'easeInOut',
            duration: 1000,
            text: {
              autoStyleContainer: false,
            },
            from: { color: '#d7ecfb', width: 1 },
            to: { color: '#5d79e4', width: 4 },
            // Set default step function for all animate calls
            step: function(state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                // porcentaje del camion lleno
                var value = Math.round(circle.value() * 100)+"%";
                if (value === 0) {
                  circle.setText('');
                } else {
                  circle.setText(value);
                }
            }
        });
        barc.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
        barc.text.style.fontSize = '6rem';
        
        
        progress = new ProgressBar.Line(progressid, {
            strokeWidth: 4,
            easing: 'easeInOut',
            duration: 1400,
            color: '#FFEA82',
            trailColor: '#eee',
            trailWidth: 1,
            svgStyle: {width: '100%', height: '100%'},
            from: {color: '#FFEA82'},
            to: {color: '#ED6A5A'},
            step: (state, progress) => {
                progress.path.setAttribute('stroke', state.color);
            }
        });
        
        var porcentaje_donut = 0;
        var data = 0;
        var data2 = 0;
        var n = 0;
        var l = document.getElementById("number");
        var timerInterval;
        swal({
            title: 'Por favor espere',
            html: 'Se están cargando <strong></strong> los datos.',
            timer: 2000,
            //confirmButtonText: 'Look up',0
           // showLoaderOnConfirm: true,
            //preConfirm: () => {
            //  swal.showLoading(),
             // timerInterval = setInterval(() => {
            //    swal.showLoading();
            //    swal.getContent().querySelector('strong')
            //      .textContent = swal.getTimerLeft();
            //  }, 1000);
           // },
            onBeforeOpen: () => {
              swal.showLoading(),
              timerInterval = setInterval(() => {
                swal.showLoading();
                swal.getContent().querySelector('strong')
                  .textContent = swal.getTimerLeft();
              }, 100);
            },
            onClose: () => {
              clearInterval(timerInterval);
            }
        }).then((result) => {
            if (
              // Read more about handling dismissals
              result.dismiss === swal.DismissReason.timer
            ) {
              console.log('I was closed by the timer');
            }
        });
        time = 5000;
        cont = window.setInterval(function(){
        // l.innerHTML = n;
        n++;
        data++;
        data2++;
        
        // total camión cargado
        $.ajax({
            url:  "<?= base_url()?>Monitoreo/C_Monitoreo/get_weight_trunk",
            type: 'POST',
            data: {orden:orden,solicitud:solicitud},
            success: function(data){
                var datos = JSON.parse(data);
                $("#driver_v").text(datos[2]['driver']+' - ');
                $("#license_v").text(datos[2]['license_plate']);
                $("#description_v").text(datos[2]['description']+' - ');
                $("#weight_v").text(datos[2]['max_weight'] + 'KG - ');
                
                var contador = 0;
                var cantidad = 0;
                var peso = 0;
                var peso_camion = 0;
                datos[1].forEach(function(element) {
                    cantidad++;
                    if(element.id_status != "17"){
                        contador++;
                        peso = parseInt(peso) + parseInt(element.weight_package);
                    }
                });
                datos[0].forEach(function(element) {
                    peso_camion = element.weight_estimate_trunk;
                });
                var porcentaje_camion = ( 100 * parseInt(peso) / parseInt(peso_camion) )  / 100;
                var resta = 100 - Math.round(100 * parseInt(peso) / parseInt(peso_camion)); // total invertido para img del camión
                var procentajecss = resta+"%"; // porcentaje invertido para img del camión
                var porcentaje = contador / 1000;
                var porcentajeProgress = parseInt(resta) / 100;
                $(".opact").css("width", procentajecss);
                // linea para llenar el circulo - camión
                barc.animate(porcentaje_camion);  // Number from 0.0 to 1.0
                
                // linea para llenar el progress bar
                progress.animate(porcentajeProgress);  // Number from 0.0 to 1.0
                
                // detiene la ejecucion
                if(porcentaje > 1 || porcentaje > 1.0){
                    barc.text.style.color = "#f52f2f";
                    barc.from = "#f52f2f";
                    barc.to = "#f52f2f";
                    swal({
                        type: 'error',
                        title: 'Atención',
                        text: 'El camión ha excedido su carga',
                        timer: 15000
                    });
                    clearInterval(cont);
                }
            }
        });
        // END total camión cargado

         // total peso cargado
        $.ajax({
            url:  "<?= base_url()?>Monitoreo/C_Monitoreo/get_data",
            type: 'POST',
            data: {orden:orden,solicitud:solicitud},
            success: function(data){
                var datos = JSON.parse(data);
                var peso = 0; //pendientes por cargar
                var resultado = 0;
                var revertidos = 0;
                datos.forEach(function(element) {
                    
                    if(element['id_status'] != 20){
                       resultado = parseFloat(resultado) + parseFloat(element['weight_package']);
                    }
                    if(element['id_status'] == 20){
                       revertidos = parseFloat(revertidos) + parseFloat(element['weight_package']);
                    }
                    peso = parseFloat(resultado) - parseFloat(revertidos);

                });
                document.getElementById('number').innerHTML = Math.round(peso);
                $('#number').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 1000,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            }
        });
        // END total peso cargado

        // total de pendientes por cargar
        $.ajax({
            url:  "<?= base_url()?>Monitoreo/C_Monitoreo/get_pending2",
            type: 'POST',
            data: {orden:orden,solicitud:solicitud},
            success: function(data){
                var datos = JSON.parse(data);
                var pendientes = 0; //pendientes por cargar
                var resultado = 0;
                var revertidos = 0;
                var cargados = 0;
                var total_donut = 0;
                datos.forEach(function(element) {
                    total_donut = parseInt(total_donut) + parseInt(element['total']);
                    if(element['id_status'] != 20){
                        resultado = parseInt(resultado) + parseInt(element['total']);
                    }
                    if(element['id_status'] == 18){
                        cargados = parseInt(cargados) + parseInt(element['total']);
                    }
                    if(element['id_status'] == 20){
                        revertidos = parseInt(revertidos) + parseInt(element['total']);
                    }
                    pendientes = parseInt(resultado) - (parseInt(revertidos) + parseInt(cargados));
                    switch(element['id_status']) {
                        case '17':
                            bar.data.datasets[0].data[0] = pendientes;
                            break;
                        case '18':
                            bar.data.datasets[0].data[1] = cargados;
                            break;
                        case '19':
                            bar.data.datasets[0].data[2] = element['total'];
                            break;
                        case '20':
                            bar.data.datasets[0].data[3] = revertidos;
                            break;
                        default:
                        // code block
                    }
                });
                bar.update();

            // chart donnat
            pendientes_donut = parseInt(resultado) + parseInt(revertidos);
            if(cargados > 0){
                myDoughnutChart.data.datasets[0].data[0] = cargados;
                myDoughnutChart.data.datasets[0].data[1] = parseInt(total_donut) - parseInt(cargados);
                // calcula porcentaje
                porcentaje_donut = (100 * parseInt(cargados))/total_donut;
                myDoughnutChart.options = {
                    elements: {
                        center: {
                            text: parseInt(porcentaje_donut)+'%',
                            color: '#36A2EB',
                            fontStyle: 'Helvetica',
                            sidePadding: 15 //Default 20 (as a percentage)
                        }
                    }
                };
                myDoughnutChart.update();
            }

            document.getElementById('number2').innerHTML = Math.round(parseInt(total_donut) - parseInt(cargados) - parseInt(revertidos));
            $('#number2').each(function () {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                   duration: 1000,
                   easing: 'swing',
                   step: function (now) {
                       $(this).text(Math.ceil(now));
                   }
                });
            });
            }
        });
        // END pendientes por cargar

        // pequetes revertidos
        $.ajax({
            url:  "<?= base_url()?>Monitoreo/C_Monitoreo/get_pending",
            type: 'POST',
            data: {orden:orden,solicitud:solicitud},
            success: function(data){
                var datos = JSON.parse(data);
                var paquetes_revertidos = 0;

                datos.forEach(function(element) {
                    if(element['id_status'] == 20){
                        paquetes_revertidos = parseInt(paquetes_revertidos) + parseInt(element['total']);
                    }
                });
                document.getElementById('number3').innerHTML = paquetes_revertidos;
                $('#number3').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).text()
                    }, {
                        duration: 1000,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
            }
        });
        // END paquetes revertidos

        if(porcentaje_donut == 100){
            swal({
                type: 'success',
                title: 'Exito!',
                text: 'Carga Completada',
                timer: 15000,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    console.log("down by law");
                }else{
                    console.log("down by law");
                }
            });
            //bar.update();
            clearInterval(cont);
        }
        },time);
    }
    
    
    function detail_order(order,solicitud){
        $.ajax({
            url:  '<?= base_url('Monitoreo/C_Monitoreo/get_packages') ?>',
            type: 'POST',
            data: {order:order,solicitud:solicitud},
            success: function(data){
                var dato = JSON.parse(data);
                var cont = 0;
                dato[0].forEach(function(element) {
                    element['percent'] = (100 * parseInt(dato[2]['modulate'][cont]['paquetes_resta'])) / parseInt(dato[2]['modulate'][cont]['total_paquetes'])+"%";
                    cont++;
                });
                
                $("#myTable").DataTable({
                    data:dato[0],
                    columns: [
                        { data: 'name' },
                        { data: 'packet_sum' },
                        { data: 'total_weight' },
                        { data: 'percent' }
                    ],
                    destroy: true // para evitar errores al volver a llamar la función
                });
                
                var cont2 = 0;
                dato[2]['supplies'].forEach(function(element) {
                    element['percent'] = (100 * parseInt(dato[2]['supplies'][cont2]['packet_quantity']) / parseInt(1) )+"%";
                    cont2++;
                });
                
                $("#myTable2").DataTable({
                    data:dato[2]['supplies'],
                    columns: [
                        { data: 'pack' },
                        { data: 'quantity_total' },
                        { data: 'weight_total' },
                        { data: 'percent' }
                    ],
                    destroy: true // para evitar errores al volver a llamar la función dataTable
                });
                $("#lbl_orden").text(solicitud);
            }
        });
        $("#modal_mueble").modal("show");
    }
   
</script>
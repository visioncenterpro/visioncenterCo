<?php
$months = array("1" => "Enero", "2" => "Febrero", "3" => "Marzo", "4" => "Abril", "5" => "Mayo", "6" => "Junio", "7" => "Julio", "8" => "Agosto", "9" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
?>
<style>
    .fc-event {
        position: relative;
        display: -webkit-box;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border" style="    BACKGROUND-COLOR: #3c8dbc;color: white;">
                        <h4 class="box-title">Agregar día no habil</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <hr>
                        <button  type="button" id="my-button" onclick="Agegar_festivo()" class="btn btn-primary ">Agregar</button>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
    $(function () {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        /* initialize the external events
         -----------------------------------------------------------------*/
        function init_events(ele) {
            ele.each(function () {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                }

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject)

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                })

            })
        }

        init_events($('#external-events div.external-event'))

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        CreateCalendar();
    });
    
    function CreateCalendar(){
        var date = new Date()
        var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
       
        $('#calendar').fullCalendar({
//            header: {
//                center: 'title'
//            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            eventRender: function (event, element) {
                element.append("<span class='closeon' onclick='DeleteDay(" + '"' + event.start._i + '"' + ")' style='cursor:pointer'><b> &nbsp;&nbsp; X</b></span>");
                element.find(".closeon").click(function () {
                    $('#calendar').fullCalendar('removeEvents', event._id);
                });
            },
            eventSources: [
                {
                    url: "<?= base_url() ?>/Parameters/Days/C_Days/ListDayNonWorking",
                    type: 'POST',
                    error: function () {
                        alert('there was an error while fetching events!');
                    },
                    color: '#f56954', // a non-ajax option
                    textColor: '#fff' // a non-ajax option
                }

            ],
            editable: false,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject')

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject)

                // assign it the date that was reported
                copiedEventObject.start = date
                copiedEventObject.allDay = allDay
                copiedEventObject.backgroundColor = $(this).css('background-color')
                copiedEventObject.borderColor = $(this).css('border-color')

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            }
        });
    }

    function Agegar_festivo() {
        if ($("#datepicker").val() != "") {
            var fecha = $("#datepicker").val();
            $("#datepicker").val("");
            $.post("<?= base_url() ?>/Parameters/Days/C_Days/AddDayCalendar", {datepicker: fecha}, function (data) {
                if (data.res == "OK") {
                    swal({title: 'Operacion Exitosa!', text: "Registro Insertado", type: 'success'});
                    $('#calendar').fullCalendar('destroy');
                    CreateCalendar();
                } else {
                    swal({title: 'Error!', text: data.res, type: 'error'});
                }
            }, 'json').fail(function (error) {
                if(error.status == 200){
                    RedirectLogin();
                }else{
                    swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                }
            });
        }
    }

    function DeleteDay(fecha) {
        $.post("<?= base_url() ?>/Parameters/Days/C_Days/DeleteDayCalendar", {day: fecha}, function (data) {
            if (data.res == "OK") {
                swal({title: 'Operacion Exitosa!', text: "Registro Eliminado", type: 'success'});
            } else {
                swal({title: 'Error!', text: data.res, type: 'error'});
            }
        }, 'json').fail(function (error) {
            if(error.status == 200){
                RedirectLogin();
            }else{
                swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
            }
        });
    }
</script>
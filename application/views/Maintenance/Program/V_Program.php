<style>
    .fc-event {
        position: relative;
        display: -webkit-box;
    }
    .box-title{
        font-size: 14px !important;
    }
    .colors{
        padding: 5px 10px;
        font-weight: bold;
        margin-bottom: 4px;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        text-shadow: 0 1px 1px rgba(0,0,0,0.1);
        border-radius: 3px;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <?php //var_dump($machines); ?>
                    <?php foreach ($area as $a) : ?>
                        <div class="col-md-6">
                            <div class="box box-primary collapsed-box ">
                                <div class="box-header with-border">
                                    <h5 class="box-title"><?= $a ?></h5>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div id="external-events">
                                        <?php foreach ($machines[$a] as $key => $value) : ?>
                                            <div class="external-event bg-primary" id="<?= $value['id_machine'] ?>"><?= $value['description'] ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h4 class="box-title">Descripcion</h4>
                            </div>
                            <div class="box-body">
                                <!-- the events -->
                                <div id="external-events">
                                    <div class="colors bg-green" >Finalizada</div>
                                    <div class="colors bg-aqua " style="position: relative;">Iniciada</div>
                                    <div class="colors bg-light-blue" style="position: relative;">Creada</div>
                                    <div class="colors bg-red" style="position: relative;">Vencida</div>
                                    <div class="colors bg-gray-active" style="position: relative;">Eliminada</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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

    function CreateCalendar() {
        var date = new Date()
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();

        $('#calendar').fullCalendar({
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            eventRender: function (event, element) {
                console.log(event);
                if (event.delete == 1) {
                    element.append("<span class='closeon' onclick='DeleteRequest(" + '"' + event.id + '"' + "," + '"' + event.day + '"' + ")' style='cursor:pointer'><b> &nbsp;&nbsp; X</b></span>");
                    element.find(".closeon").click(function () {
                        $('#calendar').fullCalendar('removeEvents', event._id);
                    });
                }


            },
            eventSources: [
                {
                    url: "<?= base_url() ?>Maintenance/Program/C_Program/ListDayPreventiveMaintenance",
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

                var myNewDate = new Date(date._d); // new Date(theDate);
                myNewDate.setDate(myNewDate.getDate() + 1);

                var day = myNewDate.getDate(),
                        mont = myNewDate.getMonth() + 1,
                        year = myNewDate.getFullYear();

                if (day < 10) {
                    day = '0' + day
                }
                if (mont < 10) {
                    mont = '0' + mont
                }
                var today = year + '-' + mont + '-' + day;

                var originalEventObject = $(this).data('eventObject');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject)

                // assign it the date that was reported
                copiedEventObject.id = "new" + $(this).attr("id");
                copiedEventObject.delete = 1;
                copiedEventObject.day = today;
                copiedEventObject.start = date
                copiedEventObject.allDay = allDay
                copiedEventObject.backgroundColor = $(this).css('background-color')
                copiedEventObject.borderColor = $(this).css('border-color')

                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                $.post("<?= base_url() ?>Maintenance/Program/C_Program/CreateMaintenancePreventive", {date: today, id_machine: $(this).attr("id")}, function (data) {
                    if (data.res != "OK") {
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: data.res, type: 'error'});
                    }
                }, 'json').fail(function (error) {
                    if(error.status == 200){
                        RedirectLogin();
                    }else{
                        swal({title: 'Error Toma un screem y envialo a sistemas!', text: error.responseText, type: 'error'});
                    }
                });

            }
        });
    }


    function DeleteRequest(id, day) {
        $.post("<?= base_url() ?>Maintenance/Program/C_Program/DeleteRequestCalendar", {id: id, day: day}, function (data) {
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
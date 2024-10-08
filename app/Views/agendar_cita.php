<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

<div id="loader" class="modal fade show" style="display: none; padding-left: 0px; z-index: 999999999;">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="d-flex ht-300 pos-relative align-items-center">
            <div class="sk-chasing-dots">
                <div class="sk-child sk-dot1 bg-red-800"></div>
                <div class="sk-child sk-dot2 bg-green-800"></div>
            </div>
        </div>
    </div>
</div>

<section class="agendar-cita mg-b-220 mg-t-90">
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center mt-5">Escoge el día y la hora</h3>
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>

<div id="modal_cita" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Agendar cita</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-20">
                <form id="form_cita">
                    <div class="form-group">
                        <label class="form-control-label">Fecha y hora: </label>
                        <input id="fechaH" class="form-control" type="text" name="fecha" value="" placeholder="" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Nombre paciente: </label>
                        <input id="autoComplete" class="form-control" type="text" name="paciente" style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Comentarios: <span class="tx-danger"></span></label>
                        <textarea rows="3" id="comentarios" class="form-control" placeholder="Comentarios de la cita"></textarea>
                    </div>

                    <div class="form-group">
                        <input id="id_paciente" class="form-control" type="hidden" name="id_paciente">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button id="send_cita" type="button" class="btn btn-teal pd-x-20"><i class="fa fa-check-circle-o fa-lg mr-1" aria-hidden="true"></i>Aceptar</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times-circle fa-lg mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--Modal alert -->
<div id="modal_alert" class="modal fade">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Agendar cita</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-lg">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas agendar esta cita?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer las acciones una vez confirmada la cita</p>
                </div><!-- card -->
            </div>

            <div class="modal-footer">
                <button id="agendar_cita" type="button" class="btn btn-teal  pd-x-20"><i class="fa fa-check-circle-o mr-1" aria-hidden="true"></i>Aceptar</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times-circle mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<style>
    .fc-scrollgrid .fc-timegrid-slot:hover td {
  background-color: red;
}
</style>

<script>
    //get_fechas();
    calendario();
    autoComplete_input();

    $(document).on('click', '#agendar_cita', function(e) {
        console.log("Hola");
        e.preventDefault();
        let url = `${BASE_URL}Api/Pacientes/Agendar_cita/add_cita`;
        let FORMDATA = new FormData($(this)[0]);
        let form = $('#form_cita');
        let modal = $('#modal_cita');
        send(url, FORMDATA, dataTable, modal, form);
        $("#modal_alert")..modal('toggle');
    });
    

    function calendario(result) {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                locale: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            selectable: true,
            dateClick: function (info) {
                var date = info.dateStr;
                var view = calendar.view.type;
                var hoy = calendar.getDate();
                var hoy2 = new Date(hoy).toLocaleString();

                var fecha = Date.parse(info.dateStr)
                var fecha2 = new Date(fecha).toLocaleString();

                date2 = new Date(hoy);
                year = date2.getFullYear();
                month = date2.getMonth()+1;
                dt = date2.getDate();

                if (dt < 10) {
                    dt = '0' + dt;
                }
                if (month < 10) {
                    month = '0' + month;
                }

                const actual = year+'-' + month + '-'+dt;
                
                if(info.dateStr > actual  ){
                    switch (view) {
                        case 'dayGridMonth':
                            calendar.changeView('timeGridDay', date);
                        break;
    
                        case 'timeGridWeek':
                            calendar.changeView('timeGridDay', date);
                        break;
    
                        case 'timeGridDay':
                            var fecha = Date.parse(info.dateStr)
                            var fecha2 = new Date(fecha).toLocaleString();
                            $('#fechaH').val(fecha2);
                            $('#modal_cita').modal();
                        break;
                    }
                } else{
                    Toastify({
                        text: "No se puede crear la cita",
                        duration: 5000,
                        className: "info",
                        avatar : BASE_URL + "../../assets/img/advertencia.png",
                        style: {
                            background: "linear-gradient(to right, #0370b8, #0FB6FB)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                }  
                
            },
        });
        calendar.setOption('locale', 'es');

        $.each(result, function (index, value) {
            calendar.addEvent({
                title: "OCUPADO",
                start: value.date_schedule,
                allDay: false,
                color: '#ff9f89'
    
            });
    
        });
        calendar.render();
    
    }

    //FUNCION PARA EL INPUT DE AUTOCOMPLETE
    function autoComplete_input() {
        const autoCompleteJS = new autoComplete({
            placeHolder: "Buscar paciente...",
            threshold: 2,
            diacritics: true,
            data: {
            src: async (query) => {
                try {
                    const source = await fetch(`${BASE_URL}Api/Pacientes/Registro_paciente/readPacientes/${query}`);
                    const data = await source.json(); 
                    return data;
                } catch (error) {
                    return error;
                }
            },
                keys: ["nombre", "tel_cel"],
            },

            resultsList: {
                tag: "ul",
                id: "autoComplete_list",
                class: "results_list",
                destination: "#autoComplete",
                position: "afterend",
                maxResults: 100,
                noResults: true,
                element: (list, data) => {
                    if(!data.results.length){
                    $('#actualizar').hide();
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}". Agregue los datos del paciente para continuar.</span> 
                    <br><br>
                    <div class="pd-x-20">
                        <button id="agregar" type="submit" class="btn btn-success pd-x-20 float-right"><i class="fa fa-plus" aria-hidden="true"></i> AGREGAR PACIENTE</button>
                    </div>`;
                    list.appendChild(message);
                    } else {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    list.appendChild(message);
                    }
                    list.setAttribute("data-parent", "food-list");
                },
            },
            
            resultItem: {
            highlight: true,
                element: (item, data) => {
                    
                    item.innerHTML = `
                    <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; color: black !important; font-size: 1.2rem !important">
                    ${data.match}
                    </span>
                    
                    <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; color: black !important; text-transform: uppercase; font-size: 1rem !important" color: rgba(0,0,0,.2);">
                    ${data.value.tel_cel}
                    </span>`;
                    $('#actualizar').show();
                },
            },

            events: {
                input: {
                    selection: (event) => {
                        $("#autoComplete").val(event.detail.selection.value.nombre)
                        $("#id_paciente").val(event.detail.selection.value.id)
                    }
                }
            }
        });
    }
</script>
/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 29 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: Las citas médicas y tomas de muestra de laoratorio que estan esperando por ser atendidas */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA
var dataTable = $('#crm_pendientes').DataTable({
    order: [[1, 'asc']],
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: {},
        type:'post'
    },

    columns: [
        { 
            data: 'c_date',
            render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            }
        },
        { 
            data: 'id',
            render: function(data, type, row, meta) {
                return `<a  href="${BASE_URL}OrdenServicio/Pendientes/imprimir/${row.id}" target="_blank">${data}</a>` 
            }
        },
        { 
            data: 'convenio',
            render: function(data, type, row, meta) {
                if(data == null){
                    return `NINGUNO`
                } else {
                    return `${data}`
                }
            }
        },
        { 
            data: 'cliente' 
        },
        { 
            data: 'id', 
            render: function(data, type, row, meta) {
                if(row.consultas_medicas > 0 && row.laboratorio == 0){
                    return `<button id="${data}" class="btn btn-success cita-medica solid pd-x-20 btn-circle btn-sm mr-2" title="Autorizar cita"><i class="fa fa-medkit fa-2x" aria-hidden="true"></i></button>`
                } else if (row.consultas_medicas == 0 && row.laboratorio > 0){
                    return `<button id="${data}" class="btn btn-teal tomar-muestra solid pd-x-20 btn-circle btn-sm mr-2" title="Pasar a tomar muestra"><i class="fa fa-flask fa-2x" aria-hidden="true"></i></button>`
                } else {
                    return `<button id="${data}" class="btn btn-success cita-medica solid pd-x-20 btn-circle btn-sm mr-2" title="Autorizar cita"><i class="fa fa-medkit fa-2x" aria-hidden="true"></i></button>
                    <button id="${data}" class="btn btn-teal tomar-muestra solid pd-x-20 btn-circle btn-sm mr-2" title="Pasar a tomar muestra"><i class="fa fa-flask fa-2x" aria-hidden="true"></i></button>`
                }
               
            } 
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
}); 

$(document).on('click', '.tomar-muestra', function(){
    $('#loader').toggle();
    let id = parseFloat($(this).attr('id'));
    const URL = `${BASE_URL}${CONTROLADOR}/showLab`;
    
    $.ajax({
        url: URL,
        method: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if(data != ""){
                $("#muestrasPendientes").children().remove();
                $("#name_lab").children().remove();
                $(data).each(function (i, v) {
                    let questions = `<div class="row justify-content-center mg-t-30">
                        <div class="col-8 row align-items-center">
                            <h6>${v.insumo}</h6>
                        </div>
                        <div class="col-4 row justify-content-center">
                            <button type="button" id="${v.id}" title="Pasar a tomar muestra" class="btn-md btn-circle btn-success aceptar-toma"><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
                        </div>
                    </div>`;
          
                    $("#muestrasPendientes").append(questions);
                });

                $("#name_lab").append(`<span>${data[0]['paciente']}</span>`);
            }
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
    $('#modal_aceptar').modal('toggle');
});

let cita_medica = $(document).on('click', '.cita-medica', function(){
    $('#loader').toggle();
    let id = $(this).attr('id');
    const URL = `${BASE_URL}${CONTROLADOR}/showCitas`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if(data != ""){
                $("#citasPendientes").children().remove();
                $("#name_cita").children().remove();
                $(data).each(function (i, v) {
                    let variable = parseFloat(v.status_lab);
                    switch(variable){
                        case 200:
                            var status_op =  `<h6 class="text-warning">${v.status_name}</h6>`;
                            var status_cancel = ``;
                        break;
                        case 201:
                            var status_op =  `<h6 class="text-success">${v.status_name}</h6>`;
                            var status_cancel = `<button type="button" id="${v.id}" title="Aceptar cita" class="btn-md btn-circle btn-success aceptar-consulta"><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>`;
                        break;
                        case 202:
                            var status_op =  `<h6 class="text-danger">${v.status_name}</h6>`;
                            var status_cancel = `<button type="button" id="${v.id}" title="Reasignar cita" class="btn-md btn-circle btn-warning reasignar"><i class="fa fa-clock-o fa-2x" aria-hidden="true"></i></button>`;
                        break;
                    }
                    let questions = `<div class="row justify-content-center mg-t-30" style="width: 480px;">
                        <div class="col-5 row align-items-center justify-content-center">
                            <h6>${v.insumo}</h6>
                        </div>
                        <div class="col-5 row align-items-center justify-content-center">
                            ${status_op}
                        </div>
                        <div class="col-2 row justify-content-center">
                            ${status_cancel}
                        </div>
                    </div>`;
          
                    $("#citasPendientes").append(questions);
                });
                $("#name_cita").append(`<span>${data[0]['paciente']}</span>`);
            }
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
    $('#modal_aceptar_cita').modal('toggle');
});

/* ACEPTAR PASAR A TOMAR MUESTRA*/
$(document).on('click', '.aceptar-toma', function () {
    $('#loader').toggle();
   
    let id = $(this).attr('id');

    const FORMDATA = new FormData();

    FORMDATA.append("id", id);
    FORMDATA.append("status_lab", 101);


    const URL = `${BASE_URL}${CONTROLADOR}/status_lab`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                reloadData();
                $('#modal_aceptar').modal('toggle');
                $('#loader').toggle();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/* ACEPTAR CONSULTA MÉDICA */
$(document).on('click', '.aceptar-consulta', function () {
    $('#loader').toggle();
    
    let id = $(this).attr('id');
    const FORMDATA = new FormData();

    FORMDATA.append("id", id);
    FORMDATA.append("status_lab", 203);

    const URL = `${BASE_URL}${CONTROLADOR}/status_lab`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                reloadData();
                $('#modal_aceptar_cita').modal('toggle');
                $('#loader').toggle();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/* ACEPTAR CONSULTA MÉDICA */
$(document).on('click', '.reasignar', function () {
    location.href = `${BASE_URL}OrdenServicio/CitasRechazadas`
});

/*RECARGA DE AJAX DE LA TABLA*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}
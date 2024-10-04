
/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 25 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: El médico podrá visualizar todas las citas que tenga agendadas en una sola tabla, donde podrá ver el status 
en el que se encuentra cada cita */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA CITAS ACEPTADAS
var dataTableAceptadas = $('#crm_citas_aceptadas').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readAppointmentAccept`,
        data: {},
        type:'post'
    },

    columns: [
        { 
            data: 'fecha',
            render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            }
        },
        { 
            data: 'hora',
            render: function(data, type, row, meta) {
                let hora = `${row.fecha} ${data}`
                return moment(hora).format('HH:mm');
            }
        },
        { 
            data: 'status_name',
            render: function(data, type, row, meta) {
                let status = parseFloat(`${row.status_lab}`);
                switch(status){
                    case 200:
                        return `<h6 class="text-warning">${data}</h6>`;
                    break;
                    case 201:
                        return `<h6 class="text-success">${data}</h6>`;
                    break;
                    case 203:
                        return `<h6 class="text-primary">${data}</h6>`;
                    break;
                    default:
                        return `<h6 class="text-danger">${data}</h6>`;
                    break;
                }
            }
        },
        { 
            data: 'paciente'
        },
        { 
            data: 'consultorio'
        },
        { 
            data: 'status_lab',
            render: function(data, type, row, meta) {
                let status = parseFloat(`${data}`);
                if(status == 200){
                    return `<div class="d-flex justify-content-center"><button id="${row.id}" data-index="${row.id_cotization_x_product}" title="Aceptar cita" class="btn btn-success aceptar solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
                    <button id="${row.id}" data-index="${row.id_cotization_x_product}" title="Rechazar cita" class="btn btn-danger rechazar solid pd-x-20 btn-circle btn-sm"><i class="fa fa-times fa-2x" aria-hidden="true"></i></button></div>`;
                } else {
                    return ``;
                }
            }
        },
        { 
            data: 'id_paciente',
            render: function(data, type, row, meta) {
                let status = parseFloat(`${row.status_lab}`);
                if(status == 203){
                    return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Operativo/Nota_medica/index/${row.id_cita}/${row.id_paciente}/${row.id_doctor}"><button title="Agregar nota médica" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-medkit fa-2x" aria-hidden="true"></i></button></a></div>`;
                } else {
                    return ``;
                }
            }
        },
        { 
            data: 'id_paciente',
            render: function(data, type, row, meta) {
                let status = parseFloat(`${row.status_lab}`);
                if(status == 201 || status == 203){
                    return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Operativo/Historial_citas/index/${row.id_paciente}"><button title="Ver citas anteriores" class="btn btn-primary solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
                } else {
                    return ``;
                }
            }
        },
        { 
            data: 'id_paciente', 
            render: function(data, type, row, meta) {
                let status = parseFloat(`${row.status_lab}`);
                if(status == 201 || status == 203){
                    return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Operativo/HistoriaClinica/index/${data}"><button title="Ver historial clinico" class="btn btn-purple solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-pencil-square-o fa-2x ml-1" aria-hidden="true"></i></button></a></div>`;
                } else {
                    return ``;
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

/* ACEPTAR CITA */
$(document).on('click', '.aceptar', function(){
    let id = $(this).attr('id');
    let id_cot_x_prod = $(this).data('index');
    $("#id_aceptar").val(id);
    $("#id_cot_x_prod_aceptar").val(id_cot_x_prod);
    $("#myModal").modal('show');
});

$(document).on('submit', '#formAccept', function () {
    $('#loader').toggle();
    $('#myModal').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/acceptAppointment`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                //notification library
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                reloadDataAceptadas();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                $('#updateModal').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: "../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

/* RECHAZAR CITA */
$(document).on('click', '.rechazar', function(){
    let id = $(this).attr('id');
    let id_cot_x_prod = $(this).data('index');
    $("#id_rechazar").val(id);
    $("#id_cot_x_prod_rechazar").val(id_cot_x_prod);
    $("#modal_delete").modal('show');
});

$(document).on('submit', '#formReject', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/rejectAppointment`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                //notification library
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                reloadDataAceptadas();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                $('#updateModal').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: "../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

//RELOAD datatable aceptadas
function reloadDataAceptadas() {
    $('#loader').toggle();
    dataTableAceptadas.ajax.reload();
    $('#loader').toggle();
}

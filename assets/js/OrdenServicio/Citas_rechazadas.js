/* Desarrollador: Airam Vargas
Fecha de creacion: 25 - 08 - 2023
Fecha de Ultima Actualizacion: 28 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: Se manejara una tabla de las citas que hayan sido canceladas/rechazadas por los médicos
para que puedan ser reasignadas en otro horario */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA DE CITAS RECHAZADAS POR UN MÉDICO
var dataTableRechazadas = $('#crm_citas_rechazadas').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
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
            data: 'paciente'
        },
        { 
            data: 'telefono'
        },
        { 
            data: 'medico'
        },
        { 
            data: 'consultorio'
        },
        { 
            data: 'id',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><button style="cursor: pointer;" id="${row.id_cita}" data-index=${row.id_cotizacion} class="btn btn-warning agenda-upd solid pd-x-20 btn-circle btn-sm mr-2" title="Editar cita"><i class="fa fa-calendar-check-o fa-2x" aria-hidden="true"></i></button></div>`;
            }
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//RELOAD datatable aceptadas
function reloadData() {
    $('#loader').toggle();
    dataTableRechazadas.ajax.reload();
    $('#loader').toggle();
}

//horas medico update
$("#select-medicos").on("change", function () {
    $('#loader').toggle();
    let id_user = $(this).val();
    let fecha = $("#fecha-upd").val();
    let horas = $("#select-horas");
    if (fecha.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una fecha", imagen);
        $(this).val("");
        $('#loader').toggle();
    } else {
        getHoras(id_user, fecha, horas);

    }
});

//consultorios update

//SELECCIÓN DE FECHA DE BUSQUEDA POR MEDICO
$("#select-horas").on("change", function () {
    $('#loader').toggle();
    let hora = $(this).val();
    let fecha = $("#fecha-upd").val();
    let consultorio = $("#consultorio_upd");
    if (hora.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una hora", imagen);
        $(this).val("");
    } else {
        getConsultorios(hora, fecha, consultorio);
    }
});

//NOTIFICACION DE ERROR
function notificacion(mensaje, imagen) {
    Toastify({
        text: mensaje,
        duration: 3000,
        className: "info",
        avatar: imagen,
        style: {
            background: "linear-gradient(to right, #f90303, #fe5602)",
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();
}

//BUSQUEDA POR HORA
$(document).on('click', '#btn_hora', function () {
    document.getElementById("formHoras").reset();
    $('#loader').toggle();
    $('#formCita select').attr("disabled", 'disabled');
    $('#formCita input').attr('disabled', 'disabled');
    $('#formCita').hide();
    $('#formHoras select').prop("disabled", false);
    $('#formHoras input').prop("disabled", false);
    $('#formHoras').show();
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/getHorasunity`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id_cotizacion: id_cotizacion
        },
        dataType: 'json',
        success: function (data) {
            let horas = $("#cita-horas");
            horas.empty();
            horas.append(`<option  value=""> SELECCIONA HORA </option>`);
            $(data).each(function (i, v) {
                horas.append(`<option value="${v}"> ${v}</option>`);
            });
            $('#loader').toggle();
        },
    })
});


//BOTON DE BUSQUEDA POR MEDICO
$(document).on('click', '#btn_medico', function () {
    document.getElementById("formCita").reset();
    $('#loader').toggle();
    $('#formHoras select').attr("disabled", 'disabled');
    $('#formHoras input').attr('disabled', 'disabled');
    $('#formHoras').hide();
    //fomulario de citas por medico
    $('#formCita select').prop("disabled", false);
    $('#formCita input').prop("disabled", false);
    $('#formCita').show();
    $('#loader').toggle();

});


//SELECT DE BUSQUEDA DE HORAS QUE NO TRAE MEDICOS Y CONSULTORIOS
$("#cita-horas").on("change", function () {
    $('#loader').toggle();
    let id_cita = $('#id-cita').val();
    let fechahora = $('#fecha-hora').val();
    let consultorio = $("#consultorio-horas");
    let doctor = $('#doctor');
    let hora = $(this).val()
    if (fechahora.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una fecha", imagen);
        $(this).val("");
        $('#loader').toggle();
    } else {
        searchHoras(id_cita, fechahora, consultorio, doctor, hora);

    }
});

//OBTENEMOS LAS HORAS POR FECHA 
function searchHoras(id_cita, fechahora, consultorio, doctor, hora) {
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/hourlySearch`;
    let id_cotizacion = $("#id_cotizacion").val();
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id_cita: id_cita,
            fecha: fechahora,
            id_cotizacion: id_cotizacion,
            hora: hora
        },
        dataType: 'json',
        success: function (data) {
            doctor.empty();doctor
            doctor.append(`<option  value=""> SELECCIONA MEDICO</option>`);
            $(data['medicos']).each(function (i, v) {
                doctor.append(`<option value="${v.usuario}"> ${v.medico}</option>`);
            });

            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data['consultorios']).each(function (i, v) {
                consultorio.append(`<option value="${v.id_consultorio}"> ${v.consultorio}</option>`);
            });
            $('#loader').toggle();
        },
    });
}


//boton click 
$(document).on('click', '#btn-doctor', function () {
    $('#loader').toggle();
    let cita = $("#id-cita").val();
    $('#formHorasupd select').attr("disabled", 'disabled');
    $('#formHorasupd input').attr('disabled', 'disabled');
    $('#formHorasupd').hide();
    //fomulario de citas por medico
    $('#formCitaupd select').prop("disabled", false);
    $('#formCitaupd input').prop("disabled", false);
    $('#formCitaupd').show();
    getCitaupdate(cita, false);
});

//formulario de busqueda por horas
$(document).on('submit', '#formHoras', function () {
    $('#loader').toggle();
    $('#myModal').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cotizacion', id_cotizacion);
    FORMDATA.append('id_cita', $('#id-cita').val());
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/updateCita`;
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
                reloadData();
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

//ACTUALIZAR CITAS 
$(document).on('click', '.agenda-upd', function () {
    $('#loader').toggle();
    let cita = $(this).attr('id');
    let id_cotizacion = $(this).data('index');
    let bolean = true;
    $("#id-cita").val(cita);
    $("#id_cotizacion").val(id_cotizacion);
    getCitaupdate(cita, bolean);
});

//traemos los datos de la cita para actalizar

function getCitaupdate(cita, bolean) {
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/getCita`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id: cita,
        },
        dataType: 'json',
        success: function (data) {
            // medicos diponibles
            let medicos = $("#select-medicos");
            medicos.empty();
            medicos.append(`<option  value=""> SELECCIONA MEDICO </option>`);
            $(data['medicos']).each(function (i, v) {
                medicos.append(`<option  value="${v.user_id}"> ${v.nombre}</option>`);
            });

            //horas del medico 
            let horas = $("#select-horas");
            horas.empty();
            horas.append(`<option  value=""> SELECCIONA HORA </option>`);
            $(data['horas']).each(function (i, v) {
                horas.append(`<option value="${v.tiempo}"> ${v.tiempo}</option>`);
            });

            //consultorios disponibles
            let consultorio = $("#consultorio_upd");
            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data['consultorios']).each(function (i, v) {
                consultorio.append(`<option value="${v.id_consultorio}"> ${v.consultorio}</option>`);
            });

            $('#fecha-upd').val(data['citas'].fecha);
            $('#select-medicos').val(data['citas'].id_doctor);
            $('#select-horas').val(data['citas'].hora);
            $('#consultorio_upd').val(data['citas'].id_consultorio);
            $("#id-cita").val(data['citas'].id);
            $('#loader').toggle();

            if (bolean) {
                $('#cita-upd').modal('toggle');
            }
        },
    })
}

//funciones generales de busqueda por medico
function getHoras(id_user, fecha, horas) {
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/getHoras`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id_user: id_user,
            fecha: fecha
        },
        dataType: 'json',
        success: function (data) {
            horas.empty();
            horas.append(`<option  value=""> SELECCIONA HORA </option>`);
            $(data).each(function (i, v) {
                horas.append(`<option value="${v.tiempo}"> ${v.tiempo}</option>`);
            });
            $('#loader').toggle();
        },
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
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion(mensaje, imagen)
    });
}

//obtenemos consultorios
function getConsultorios(hora, fecha, consultorio) {
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/getConsultorios`;
    let id_cotizacion = $("#id_cotizacion").val();
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            hora: hora,
            fecha: fecha,
            id_cotizacion: id_cotizacion
        },
        dataType: 'json',
        success: function (data) {
            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data).each(function (i, v) {
                consultorio.append(`<option   value="${v.id_consultorio}"> ${v.consultorio}</option>`);
            });
            $('#loader').toggle();
        },
    });
}

//update cita
$(document).on('submit', '#formCitaupd', function () {
    $('#loader').toggle();
    $('#cita-upd').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cotizacion', $('#id_cotizacion').val());
    FORMDATA.append('id_cita', $('#id-cita').val());
    const URL = `${BASE_URL}${CONTROLADOR}/updateAgenda`;
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
                reloadData();
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
                $('#cita-upd').modal('toggle');
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

//btn update busqueda por hora 
$(document).on('click', '#btn_hora_upd', function () {
    $('#loader').toggle();

    let cita = $('#id-cita').val();
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/searchGethoras`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id: cita
        },
        dataType: 'json',
        success: function (data) {
            // medicos diponibles
            let medicos = $("#doctor-upd");
            medicos.empty();
            medicos.append(`<option  value=""> SELECCIONA MEDICO </option>`);
            $(data['medicos']).each(function (i, v) {
                medicos.append(`<option  value="${v.usuario}"> ${v.medico}</option>`);
            });

            //horas del medico 
            let horas = $("#cita-horas-upd");
            horas.empty();
            horas.append(`<option  value=""> SELECCIONA HORA </option>`);
            $(data['horas']).each(function (i, v) {
                horas.append(`<option value="${v}"> ${v}</option>`);
            });

            //consultorios disponibles
            let consultorio = $("#consultorio-horas-upd");
            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data['consultorios']).each(function (i, v) {
                consultorio.append(`<option value="${v.id_consultorio}"> ${v.consultorio}</option>`);
            });

            $('#fecha-hora-upd').val(data['citas'].fecha);
            $('#doctor-upd').val(data['citas'].id_doctor);
            $('#cita-horas-upd').val(data['citas'].hora);
            $('#consultorio-horas-upd').val(data['citas'].id_consultorio);
            $("#id-cita").val(data['citas'].id);
            $('#formCitaupd select').attr("disabled", 'disabled');
            $('#formCitaupd input').attr('disabled', 'disabled');
            $('#formCitaupd').hide();
            $('#formHorasupd select').prop("disabled", false);
            $('#formHorasupd input').prop("disabled", false);
            $('#formHorasupd').show();
            $('#loader').toggle();
        },
    })
});

//update busqueda por horas 
//SELECT DE BUSQUEDA DE HORAS QUE NO TRAE MEDICOS Y CONSULTORIOS
$("#cita-horas-upd").on("change", function () {
    $('#loader').toggle();
    let id_cita = $('#id-cita').val();
    //alert(id_cita);
    let fechahora = $('#fecha-upd').val();
    let consultorio = $("#consultorio-horas-upd");
    let doctor = $('#doctor-upd');
    let hora = $(this).val()
    if (fechahora.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una fecha", imagen);
        $(this).val("");
        $('#loader').toggle();
    } else {
        searchHoras(id_cita, fechahora, consultorio, doctor, hora);
    }
});

//update por horas
$(document).on('submit', '#formHorasupd', function () {
    $('#loader').toggle();
    $('#cita-upd').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cotizacion', id_cotizacion);
    FORMDATA.append('id_cita', $('#id-cita').val());
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/updateAgenda`;
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
                reloadData();
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
                $('#cita-upd').modal('toggle');
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


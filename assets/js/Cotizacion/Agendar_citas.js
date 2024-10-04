/* BTN CONTINUAR A PAGAR*/
$(document).on('click', '#continuar', function () {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/validateCita`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: { id: id_cotizacion },
        dataType: 'json',
        success: function (data) {
            if (data) {
                location.href = `${BASE_URL}Cotizaciones/generar_compra/${id_cotizacion}`;
                $('#loader').toggle();
            } else {
                $('#loader').toggle();
                let imagen = BASE_URL + "../../assets/img/cancelar.png"
                notificacion("Faltan consultas por agendar", imagen);
            }
        },
    });
});

/* BTN CANCELAR */
$(document).on('click', '#cancelar', function () {
    location.href = `${BASE_URL}Cotizaciones`;
});

var dataTable = $('#datatable').DataTable({
    paging: false,
    "info": false,
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/agenda`,
        data: { id: id_cotizacion },
        type: "post",
    },

    columns: [
        {
            data: 'producto',

        },
        {
            data: 'preparation',
            render: function (data, type, row, meta) {
                return row.id_category == "1" ?  `${row.preparation}` : `${row.description}`
            }
        },
        {
            data: 'cita',
            render: function (data, type, row, meta) {
                return data == "1" ? '<p>SI</p>' : '<p>NO</p>';
            }

        },
        {
            data: 'NAME',
            render: function (data, type, row, meta) {
                return data == null ? '<p>SIN MÉDICO</p>' : '<p>' + row.NAME + " " + row.F_LAST_NAME + '</p>';
            }
        },

        {
            data: 'consultorio',
            render: function (data, type, row, meta) {
                return data == null ? '<p>SIN CONSULTORIO</p>' : '<p>' + data + '</p>';
            }
        },
        {
            data: "cita",
            render: function (data, type, row, meta) {
                //Agregar cita
                return data == 1 && row.fecha == null && row.id_category == 3 ? '<button style="cursor: pointer;" id="' + row.id + '" class="btn btn-primary agenda-citas solid pd-x-20 btn-circle btn-sm mr-2" title="Agendar Cita"><i class="fa fa-calendar-times-o fa-2x" aria-hidden="true"></i></button>' : " "
                    //editar cita
                    + data == 1 && row.fecha != null && row.id_category == 3 ? '<button style="cursor: pointer;" id="' + row.id + '" class="btn btn-warning agenda-upd solid pd-x-20 btn-circle btn-sm mr-2" title="Editar cita"><i class="fa fa-calendar-check-o fa-2x" aria-hidden="true"></i></button>' : ""
                        //agregar cita de laboratorio
                        + row.id_category == 1 && data == 1 && row.fecha == null ? '<button style="cursor: pointer;" id="' + row.id + '" class="btn btn-teal agenda-lab solid pd-x-20 btn-circle btn-sm mr-2" title="Agendar Laboratorio"><i class="fa fa-flask fa-2x" aria-hidden="true"></i></button>' : " "
                        //editar boton de laborastorio
                        + row.id_category == 1 && data == 1 && row.fecha !=null ? '<button style="cursor: pointer;" id="' + row.id + '" class="btn btn-indigo agenda-lab-upd solid pd-x-20 btn-circle btn-sm mr-2" title="Editar Agendar Laboratorio"><i class="fa fa-flask fa-2x" aria-hidden="true"></i></button>' : " "

            }
        },
    ],
    "columnDefs": [{
        className: "text-justify space",
        "targets": [1],
    },
    ],

    //order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});

//BOTON DE LA TABLA QUE ABRE EL MODAL 
$(document).on('click', '.agenda-citas', function () {
    $('#loader').toggle();
    let cita = $(this).attr('id');
    $('#id-cita').val(cita);
    let url = `${BASE_URL}${CONTROLADOR}/getConsultorio`;
    $.ajax({
        url: url,
        data: {
            id: cita,
            id_cotizacion: id_cotizacion
        },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (data) {
            var select = $(".medico");
            select.empty();
            select.append(`<option  value=""> SELECCIONA MEDICO </option>`);
            $(data['medicos']).each(function (i, v) {
                select.append(`<option   value="${v.user_id}"> ${v.nombre}</option>`);
            });
            $('#myModal').modal('toggle');
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

//GUARDADO DE CITA
$(document).on('submit', '#formCita', function () {
    $('#loader').toggle();
    $('#myModal').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cotizacion', id_cotizacion);
    const URL = `${BASE_URL}${CONTROLADOR}/updateCita`;
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
                document.getElementById("formCita").reset();
                document.getElementById("formHoras").reset();
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

//CAMBIO DE FECHA BUSQUEDA POR MEDICO//
$("#fecha-cita").on("change", function () {
    let fecha = $(this).val();
    if (fecha.length == 0) {
    } else {
        $(".medico").val("");
        let horas = $("#horas");
        horas.empty();
    }
});

//CAMBIO DE MEDICO BUSQUEDA POR MEDICO//
$(".medico").on("change", function () {
    $('#loader').toggle();
    let id_user = $(this).val();
    let fecha = $("#fecha-cita").val();
    let horas = $("#horas");
    if (fecha.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una fecha", imagen);
        $(this).val("");
        $('#loader').toggle();
    } else {
        getHoras(id_user, fecha, horas);

    }
});

//SELECCIÓN DE FECHA DE BUSQUEDA POR MEDICO
$("#horas").on("change", function () {
    $('#loader').toggle();
    let hora = $(this).val();
    let fecha = $("#fecha-cita").val();
    let consultorio = $(".consultorio");
    if (hora.length == 0) {
        let imagen = BASE_URL + "../../assets/img/cancelar.png"
        notificacion("seleciona una hora", imagen);
        $(this).val("");
    } else {
        getConsultorios(hora, fecha, consultorio);
    }
});



//update form
//CAMBIO DE FECHA BUSQUEDA POR MEDICO//
$("#fecha-upd").on("change", function () {
    let fecha = $(this).val();
    if (fecha.length == 0) {
    } else {
        $(".medico").val("");
        let horas = $("#select-horas");
        horas.empty();
    }
});

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
    const URL = `${BASE_URL}${CONTROLADOR}/getHorasunity`;
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
    const URL = `${BASE_URL}${CONTROLADOR}/hourlySearch`;
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
    const URL = `${BASE_URL}${CONTROLADOR}/updateCita`;
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

//BOTON DE CITA DE LABORATORIO 

$(document).on('click', '.agenda-lab', function () {
    $('#loader').toggle();
    let cita = $(this).attr('id');
    $('#id-cita-lab').val(cita);
    const URL = `${BASE_URL}${CONTROLADOR}/getContorioslab`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id_cotizacion: id_cotizacion,
        },
        dataType: 'json',
        success: function (data) {
            let consultorio = $(".consultorio-lab");
            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data).each(function (i, v) {
                consultorio.append(`<option value="${v.id}"> ${v.consultorio}</option>`);
            });
            $('#modal-lab').modal('toggle');
            $('#loader').toggle();
        },
    })
});

//AGREGAR CITA DE LABORATORIO 

$(document).on('submit', '#formCitalab', function () {
    $('#loader').toggle();
    $('#modal-lab').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cotizacion', id_cotizacion);
    const URL = `${BASE_URL}${CONTROLADOR}/createLab`;
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
                $('#modal-lab').modal('toggle');
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
    let bolean = true;
    $("#id-cita").val(cita);
    getCitaupdate(cita, bolean);
});

//traemos los datos de la cita para actalizar

function getCitaupdate(cita, bolean) {
    const URL = `${BASE_URL}${CONTROLADOR}/getCita`;
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
    const URL = `${BASE_URL}${CONTROLADOR}/getHoras`;
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
    return false;
}

//obtenemos consultorios
function getConsultorios(hora, fecha, consultorio) {
    const URL = `${BASE_URL}${CONTROLADOR}/getConsultorios`;
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
    FORMDATA.append('id_cotizacion', id_cotizacion);
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
    const URL = `${BASE_URL}${CONTROLADOR}/searchGethoras`;
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
    alert(id_cita);
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

//trae los datos de la cita a actualizar
$(document).on('click', '.agenda-lab-upd', function () {
    $('#loader').toggle();
    let cita = $(this).attr('id');
    const URL = `${BASE_URL}${CONTROLADOR}/getLabcitas`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: {
            id: cita,
        },
        dataType: 'json',
        success: function (data) {
            console.log(data)
            let consultorio = $(".consultorio-lab_upd");
            consultorio.empty();
            consultorio.append(`<option  value=""> SELECCIONA CONSULTORIO </option>`);
            $(data['consultorios']).each(function (i, v) {
                consultorio.append(`<option value="${v.id}"> ${v.consultorio}</option>`);
            });
            $('#fecha-cita-upd').val(data['citas'].fecha);
            $('#id_upd_cita').val(data['citas'].id);
            $(".consultorio-lab_upd").val(data['citas'].id_consultorio);
            $('#modal-lab-edit').modal('toggle');
            $('#loader').toggle();
        },
    }) 
});

//actualizar cita de laboratorio 
$(document).on('submit', '#formCitalabupd', function () {
    $('#loader').toggle();
    $('#modal-lab-edit').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/updateLaboratorio`;
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
                $('#modal-lab-edit').modal('toggle');
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














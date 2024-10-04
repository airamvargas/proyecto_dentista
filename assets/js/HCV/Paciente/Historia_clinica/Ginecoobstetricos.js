$("#gine").on("click", function () {
    $("#id_ginecoob").val(id_paciente);
    readGine();
    reloadDataGine();
    readEnfTS();
});

//Datatable ets
let dataGine = $('#table_ets').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Ginecoobstetricos/readEts`,
        data: {id_paciente : id_paciente},
        type: "post",
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'enfermedad'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                    '" data-toggle="modal" data-target="#modal_delete_ets" class="ml-1 btn btn btn-danger btn_ets btn-circle btn-sm pd-x-20" title="Eliminar enfermedad"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
});
$("#table_ets_info").remove();

//RELOAD datatable
function reloadDataGine() {
    $('#loader').toggle();
    dataGine.ajax.reload();
    $('#loader').toggle();
}

$(document).on('submit', '#form_gine', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($("#form_gine")[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Ginecoobstetricos/create`

    $.ajax({
        url: URL,
        type: "POST",
        data: FORMDATA,
        dataType: "json",
        success: function (data) {
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $("#loader").toggle();
                Toastify({
                text: data.msg,
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/correcto.png",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                offset: {
                    x: 50, 
                    y: 90, 
                },
                }).showToast();
            } else {
                $("#loader").toggle();
                Toastify({
                text: data.msg,
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/cancelar.png",
                style: {
                    background: "linear-gradient(to right, #f90303, #fe5602)",
                },
                offset: {
                    x: 50, 
                    y: 90,
                },
                }).showToast();
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loader").toggle();
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
        avatar: BASE_URL + "../../assets/img/cancelar.png",
        style: {
            background: "linear-gradient(to right, #f90303, #fe5602)",
        },
        offset: {
            x: 50, 
            y: 90, 
        },
        }).showToast();
    });
    return false;
});

//Obtener datos gine del usuario
function readGine() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Ginecoobstetricos/readGine`;
    $.ajax({
        url: url,
        method: 'POST',
        data: {id_paciente : id_paciente},
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                $('#menarca').val(data[0].menarca);
                $('#inicio_sexual').val(data[0].inicio_de_vida_sexual);
                $('#ciclo').val(data[0].tipo_de_ciclo);
                $('#num_embarazos').val(data[0].numero_de_embarazos);
                $('#partos').val(data[0].numero_de_partos);
                $('#cesareas').val(data[0].numero_de_cesareas);
                $('#num_abortos').val(data[0].numeros_de_abortos);
                $('#lactancia').val(data[0].ha_dado_lactancia);
                $('#menopausia').val(data[0].edad_inicio_menopausia);
                $('#num_parejas').val(data[0].numeros_parejas_sexuales);
            }
            $('#loader').toggle();
            
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

//AGREGAR ETS
$(document).on('click', '#agregarETS', function(){
    if($("#trans_sex").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let enfermedad = $('#trans_sex').val();
        
        FORMDATA.append("enfermedad", enfermedad);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Ginecoobstetricos/createEts`
    
        $.ajax({
            url: URL,
            type: "POST",
            data: FORMDATA,
            dataType: "json",
            success: function (data) {
                //Si el estatus es 200 fue conpletado el proceso
                if (data.status == 200) {
                $("#loader").toggle();
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, 
                            y: 90, 
                        },
                    }).showToast();
                    reloadDataGine();
                } else {
                    $("#loader").toggle();
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/cancelar.png",
                        style: {
                            background: "linear-gradient(to right, #f90303, #fe5602)",
                        },
                        offset: {
                            x: 50, 
                            y: 90,
                        },
                    }).showToast();
                }
            },
            cache: false,
            contentType: false,
            processData: false,
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $("#loader").toggle();
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
                avatar: BASE_URL + "../../assets/img/cancelar.png",
                style: {
                    background: "linear-gradient(to right, #f90303, #fe5602)",
                },
                offset: {
                    x: 50, 
                    y: 90, 
                },
            }).showToast();
        });
        return false;
    } else {
        Toastify({
            text: "Selecciona una enfermedad",
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, 
                y: 90, 
            },
        }).showToast();
    }
    
});
//ELIMINAR ETS
$(document).on('click', '.btn_ets', function() {
    let id_butona = $(this).attr('id');
    $('#in_ets').val(id_butona);    
});

$(document).on('submit', '#delete_form_ets', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Ginecoobstetricos/deleteEts`

    $.ajax({
        url: URL,
        type: "POST",
        data: FORMDATA,
        dataType: "json",
        success: function (data) {
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
            $("#loader").toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, 
                        y: 90, 
                    },
                }).showToast();
                $('#modal_delete_ets').modal('toggle');
                reloadDataGine();
            } else {
                $("#loader").toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, 
                        y: 90,
                    },
                }).showToast();
                $("#modal_delete_ets").modal("toggle");
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loader").toggle();
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
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, 
                y: 90, 
            },
        }).showToast();
    });
    return false;
});

//Listado de ets
function readEnfTS() {
    const URL = `${BASE_URL}Api/Catalogos/Diseases/readEts`;
    var select = $("#trans_sex");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">Selecciona</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.common_name}"> ${v.common_name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

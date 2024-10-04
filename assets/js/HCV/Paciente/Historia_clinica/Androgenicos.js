$("#andro").on("click", function () {
    $("#id_androgenicos").val(id_paciente);
    readAndrogenicos();
    readEnfermedades();
});

//Datatable ets
let dataAndrogenicos = $('#crm_ets_andro').DataTable({
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
                    '" class="ml-1 btn btn btn-danger del-ets-andro btn-circle btn-sm pd-x-20" title="Eliminar enfermedad"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
});
$("#crm_ets_andro_info").remove();

$(document).on('submit', '#form_androgenicos', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($("#form_androgenicos")[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Androgenicos/create`

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

//Obtener datos androgenicos del usuario
function readAndrogenicos() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Androgenicos/read`;
    $.ajax({
        url: url,
        method: 'POST',
        data: {id_paciente : id_paciente},
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                $('#ansexual').val(data[0].inicio_de_vida_sexual);
                $('#annumero-parejas').val(data[0].numero_parejas_sexuales);
            }
            $('#loader').toggle();
            
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

//AGREGAR ETS
$(document).on('click', '#addETS', function(){
    if($("#trans_sex_andro").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let enfermedad = $('#trans_sex_andro').val();
        
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
                    reloadDataAndro()
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
$(document).on('click', '.del-ets-andro', function() {
    let id_butona = $(this).attr('id');
    $('#ets_andro').val(id_butona);    
    $('#delete_ets').modal('toggle');
});

$(document).on('submit', '#delete_ets', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Androgenicos/deleteEts`

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
                $('#delete_ets').modal('toggle');
                reloadDataAndro();
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
                $("#delete_ets").modal("toggle");
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
function readEnfermedades() {
    const URL = `${BASE_URL}Api/Catalogos/Diseases/readEts`;
    var select = $("#trans_sex_andro");
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

//RELOAD datatable
function reloadDataAndro() {
    $('#loader').toggle();
    dataAndrogenicos.ajax.reload();
    $('#loader').toggle();
}




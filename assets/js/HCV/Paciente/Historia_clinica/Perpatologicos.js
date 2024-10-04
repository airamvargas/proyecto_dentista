$("#tab_pat").on("click", function () {
    $('#loader').toggle();
    $("#id_patologicos").val(id_paciente);
    readPatologicos();
    readAlergias();
    readProcedimientos();
    readInfectocontagiosas();
    readEnfermedadesInfancia();
    readEnfermedadesBase();
    $('#loader').toggle();
});

$(document).on('change', '#enfermedades_base', function() {
    ID_ENFERMDAD = $(this).val();
    document.getElementById('autoComplete').value = "";
    autoCompleteInput();
});

//Tabla de alergias
let dataAlergias = $('#crm_alergias').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showAlergias`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'name'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" class="ml-1 btn btn btn-danger del-alergia btn-circle btn-sm pd-x-20" title="Eliminar alergia"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_alergias_info").remove(); 

//Tabla de procedimientos
let dataProcedimientos = $('#crm_cirugias').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showCirugias`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'name'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" class="ml-1 btn btn btn-danger del-procedimiento btn-circle btn-sm pd-x-20" title="Eliminar cirugia"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_cirugias_info").remove(); 

//Tabla de infectocontagiosas
let dataInfecto = $('#crm_infectocontagiosas').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showInfecto`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'name'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" class="ml-1 btn btn btn-danger del-infecto btn-circle btn-sm pd-x-20" title="Eliminar enfermedad"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_infectocontagiosas_info").remove(); 

//Tabla de enfermedades infancia
let dataInfancia = $('#crm_infancia').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showInfancia`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'name'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" class="ml-1 btn btn btn-danger del-infancia btn-circle btn-sm pd-x-20" title="Eliminar enfermedad"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_infancia_info").remove(); 

//Tabla de enfermedades infancia
let dataEnfermedadesBase = $('#crm_enfermedadesBase').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showBase`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'enfermedad'
        },
        {
            data: 'grupo'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" class="ml-1 btn btn btn-danger del-base btn-circle btn-sm pd-x-20" title="Eliminar enfermedad"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_enfermedadesBase_info").remove(); 

$(document).on('submit', '#form_perpatologicos', function () {
    $('#loader').toggle();
        var FORMDATA = new FormData($(this)[0]);

        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/create`
    
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
                    document.getElementById('alergia').value = "";
                    reloadAlergias()
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

//Obtener todos los datos de patologicos que se 
function readPatologicos() {
    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/read`;
    $.ajax({
        url: URL,
        method: 'POST',
        data: {id_paciente : id_paciente},
        dataType: 'json',
        success: function (data) {
            if(data != ""){
                $("#transfusion").val(data[0]['transfusion']);
                $("#des_trans").val(data[0]['desc_transfusion']);
                $("#accidente").val(data[0]['fractura_esguince_luxacion']);
                $("#des_accidente").val(data[0]['desc_fractura']);
                $("#periodicidad").val(data[0]['cantidad_consumo']);

                const sustancia = data[0]['consumo_sustancias']
                switch (sustancia) {
                    case "Ninguna":
                        document.querySelector('#ninguna').checked = true;
                    break;
                    case "Tabaco":
                        document.querySelector('#tabaco').checked = true;
                    break;
    
                    default:
                        document.querySelector('#otro').checked = true;
                        $('#des_susutancias').val(sustancia);
                    break;
                }
            }
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Listado de alergias
function readAlergias() {
    const URL = `${BASE_URL}Api/Catalogos/Diseases/readAlergias`;
    var select = $("#alergia");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">SELECCIONA UNA OPCIÓN</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.id}"> ${v.common_name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Listado de procedimientos/intervenciones
function readProcedimientos() {
    const URL = `${BASE_URL}Api/Catalogos/Procedimientos/readProcedimientosSel`;
    var select = $("#procedimiento");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">SELECCIONA UNA OPCIÓN</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.id}"> ${v.common_name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Listado de enfermedades infectocontagiosas
function readInfectocontagiosas(){
    const URL = `${BASE_URL}Api/Catalogos/Diseases/readInfectocontagiosas`;
    var select = $("#infecto");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">SELECCIONA UNA OPCIÓN</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.id}"> ${v.common_name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Listado de enfermedades de la infancia
function readEnfermedadesInfancia(){
    const URL = `${BASE_URL}Api/Catalogos/Diseases/readEnfermedadesInfancia`;
    var select = $("#tipica");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">SELECCIONA UNA OPCIÓN</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.id}"> ${v.common_name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Listado de enfermedades base
function readEnfermedadesBase() {
    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/readBase`;
    var select = $("#enfermedades_base");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            select.empty();
            select.append(`<option value="">SELECCIONA UNA OPCIÓN</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.CAPITULO}"> ${v.CAPITULO}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

function autoCompleteInput() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "Buscar enfermedad...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
            try {
                const source = await fetch(`${BASE_URL}Searchs/Rest_search/readEnfermedades/${query}/${ID_ENFERMDAD}`);
                const data = await source.json(); 
                return data;
            
            } catch (error) {
                return error;
            }
            },
            keys: ["NOMBRE", "PHONE_NUMBER"],
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
                message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}".</span>`;
                list.appendChild(message);
            }
            list.setAttribute("data-parent", "food-list");
            },
        },
        
        resultItem: {
            highlight: true,
            element: (item, data) => {
            
            item.innerHTML = `
            <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
            ${data.match}
            </span>`;
            },
        },
    
        events: {
            input: {
                selection: (event) => {
                    $("#autoComplete").val(event.detail.selection.value.NOMBRE);
                    $("#id_enfermedad").val(event.detail.selection.value.ID);                    
                }
            }
        }
    });
    
}

//Agregar alergias
$(document).on('click', '#addAlergia', function () {
    if($("#alergia").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let alergia = $('#alergia').val();

        FORMDATA.append("id_cat_alergia", alergia);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/createAlergia`
    
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
                    document.getElementById('alergia').value = "";
                    reloadAlergias()
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
    }else {
        Toastify({
            text: "Seleccionar una alergia",
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

//Eliminar alergia
$(document).on('click', '.del-alergia', function() {
    let id_butona = $(this).attr('id');
    $('#input_alergias').val(id_butona);    
    $('#modal_delete_alergias').modal('toggle');
});

$(document).on('submit', '#delete_alergias', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/deleteAlergia`

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
                $('#modal_delete_alergias').modal('toggle');
                reloadAlergias();
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
                $("#modal_delete_alergias").modal("toggle");
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

//Agregar cirugias/procedimientos
$(document).on('click', '#agregarIntervencion', function () {
    if($("#procedimiento").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let cirugia = $('#procedimiento').val();

        FORMDATA.append("id_cat_procedimiento", cirugia);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/createProcedimiento`
    
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
                    document.getElementById('procedimiento').value = "";
                    reloadCirugias()
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
    }else {
        Toastify({
            text: "Seleccionar un procedimiento o cirugía",
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

//Eliminar cirugia/procedimiento
$(document).on('click', '.del-procedimiento', function() {
    let id_butona = $(this).attr('id');
    $('#input_cirugias').val(id_butona);    
    $('#modal_delete_cirugias').modal('toggle');
});

$(document).on('submit', '#delete_cirugias', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/deleteProcedimiento`

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
                $('#modal_delete_cirugias').modal('toggle');
                reloadCirugias();
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
                $("#modal_delete_cirugias").modal("toggle");
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

//Agregar enfermedades infectocontagiosas
$(document).on('click', '#agregarInfecto', function () {
    if($("#infecto").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let enfermedad = $('#infecto').val();

        FORMDATA.append("id_cat_disease", enfermedad);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/createInfecto`
    
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
                    document.getElementById('infecto').value = "";
                    reloadEnfermedades()
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
    }else {
        Toastify({
            text: "Seleccionar una enfermedad infectocontagiosa",
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

//Eliminar enfermedad infecto
$(document).on('click', '.del-infecto ', function() {
    let id_butona = $(this).attr('id');
    $('#input_infectados').val(id_butona);    
    $('#modal_delete_infectados').modal('toggle');
});

$(document).on('submit', '#delete_infectados', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/deleteEnfermedad`

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
                $('#modal_delete_infectados').modal('toggle');
                reloadEnfermedades();
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
                $("#modal_delete_infectados").modal("toggle");
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

//Agregar enfermedades de la infancia
$(document).on('click', '#agregarInfancia', function () {
    if($("#tipica").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let enfermedad = $('#tipica').val();

        FORMDATA.append("id_cat_disease", enfermedad);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/createInfancia`
    
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
                    document.getElementById('tipica').value = "";
                    reloadInfancia()
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
    }else {
        Toastify({
            text: "Seleccionar un procedimiento o cirugía",
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

//Eliminar enfermedad infancia
$(document).on('click', '.del-infancia ', function() {
    let id_butona = $(this).attr('id');
    $('#input_infancia').val(id_butona);    
    $('#modal_delete_infancia').modal('toggle');
});

$(document).on('submit', '#delete_infancia', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/deleteInfancia`

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
                $('#modal_delete_infancia').modal('toggle');
                reloadInfancia();
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
                $("#modal_delete_infancia").modal("toggle");
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

//Agregar enfermedades base
$(document).on('click', '#agregarBase', function () {
    if($("#id_enfermedad").val() != ""){
        $('#loader').toggle();
        var FORMDATA = new FormData();
    
        let enfermedad = $('#id_enfermedad').val();
        let grupo = $("#enfermedades_base").val();

        FORMDATA.append("id_cat_disease", enfermedad);
        FORMDATA.append('grupo', grupo);
        FORMDATA.append('user_id', id_paciente);
    
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/createBase`
    
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
                    document.getElementById('enfermedades_base').value = "";
                    document.getElementById('id_enfermedad').value = "";
                    document.getElementById('autoComplete').value = "";
                    reloadBase();
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
    }else {
        Toastify({
            text: "Selecciona una enfermedad base",
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

//Eliminar enfermedad base
$(document).on('click', '.del-base', function() {
    let id_butona = $(this).attr('id');
    $('#input_base').val(id_butona);    
    $('#modal_delete_base').modal('toggle');
});

$(document).on('submit', '#delete_base', function(){
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/deleteBase`

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
                $('#modal_delete_base').modal('toggle');
                reloadBase();
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
                $("#modal_delete_base").modal("toggle");
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


//RELOAD PARA DATATABLES
function reloadAlergias() {
    $('#loader').toggle();
    dataAlergias.ajax.reload();
    $('#loader').toggle();
}

function reloadCirugias() {
    $('#loader').toggle();
    dataProcedimientos.ajax.reload();
    $('#loader').toggle();
}

function reloadEnfermedades() {
    $('#loader').toggle();
    dataInfecto.ajax.reload();
    $('#loader').toggle();
}

function reloadInfancia() {
    $('#loader').toggle();
    dataInfancia.ajax.reload();
    $('#loader').toggle();
}

function reloadBase() {
    $('#loader').toggle();
    dataEnfermedadesBase.ajax.reload();
    $('#loader').toggle();
}
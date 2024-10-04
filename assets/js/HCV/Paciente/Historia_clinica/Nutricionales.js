$(document).ready(function () {
    document.getElementById("Nutricionales").click();
});

$("#tab_nutri").on("click", function () {
    $(".suplemento").hide();
    $("#id_nutricionales").val(id_paciente);
    readNutricionales();
    FormAliments();
    get_id_alimento();
    sendFormDel_Alimentos();
});

$(document).on('change', '#suplemento', function(){
    valor = $(this).val();
    if(valor == "Si"){
        $(".suplemento").show();
    } else{
        $(".suplemento").hide();
    }
});

//DATOS NUTRICIONALES - GUARDAR
$(document).on('submit', '#form_nutricional', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($("#form_nutricional")[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Nutricionales/create`

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
                $("#modal_patalogicos").modal("toggle");
                document.getElementById('guardar_nutricionales').disable = false;
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

function readNutricionales() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Nutricionales/read`;

    $.ajax({
        url: url,
        method: 'POST',
        data : {id_paciente : id_paciente},
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                $('#alimentacion').val(data[0].tipo_comida);
                $('#num_comidas').val(data[0].num_comidas_dia);
                $('#realizas').val(data[0].comida_en_casa);
                $('#alcohol').val(data[0].consumo_alcohol);
                $('#num_copas').val(data[0].num_copas);
                $('#suplemento').val(data[0].suplemento);
                $('#tipoSuplemnto').val(data[0].s_descripcion);
                const bebida = data[0].tipo_de_bebida
                switch (bebida) {
                    case "Destilados":
                        document.querySelector('#destilados').checked = true;
                    break;
                    case "Fermentados":
                        document.querySelector('#fermentados').checked = true;
                    break;
    
                    case "Fortificados":
                        document.querySelector('#fortificados').checked = true;
                    break;
    
                    default:
                        document.querySelector('#otros').checked = true;
                        $('#otro2').val(bebida);
                    break;
                }
            }
            $('#loader').toggle();
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

let dataAlimento = $('#tb_alimentos').DataTable({
    ajax: {
        url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Nutricionales/readAliments`,
        data: {id_paciente : id_paciente},
        type:'post'
    },
    searching: false,
    paging: false,
    columns: [
        {
            data: 'alimento'
        },
        {
            data: 'cantidad'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
                '" data-toggle="modal" data-target="#modal_delete_alimentos" class="ml-1 btn btn btn-danger btn_al btn-circle btn-sm pd-x-20" title="Eliminar alimento"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#tb_alimentos_info").remove(); 

//RELOAD TABLA DE ALIMENTOS
function reloadDataAlimentos() {
    $('#loader').toggle();
    dataAlimento.ajax.reload();
    $('#loader').toggle();
}

//AGREGAR ALIMENTOS ALIMENTOS
function FormAliments(){
    $(document).on('click', '#agregarAlimento', function(){
        $('#loader').toggle();
        document.getElementById('agregarAlimento').disabled = true;
        var FORMDATA = new FormData();
    
        let alimento = $('#aliment').val();
        let cantidad = $('#consumo-alimentos').val();

        if(alimento != "" && cantidad != ""){
            FORMDATA.append("alimento", alimento);
            FORMDATA.append("cantidad", cantidad);
            FORMDATA.append('user_id', id_paciente);
        
            const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Nutricionales/createAliment`
        
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
                        document.getElementById('agregarAlimento').disabled = false;
                        reloadDataAlimentos();
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
                        document.getElementById('agregarAlimento').disabled = false;
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
            $('#loader').toggle();
            Toastify({
                text: "Seleccionar un alimento y cantidad",
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
            document.getElementById('agregarAlimento').disabled = false;
        }
    });
}

function get_id_alimento() {
    $(document).on('click', '.btn_al', function() {
        let id_butona = $(this).attr('id');
        $('#del_alimento').val(id_butona);
    });
}

//BORRAR ALIMENTO
function sendFormDel_Alimentos() {
    $(document).on('submit', '#delete_form_alimentos', function() {
        $("#loader").toggle();
        var FORMDATA = new FormData($(this)[0]);
        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Nutricionales/deleteAliment`;
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
                    $('#modal_delete_alimentos').modal('toggle');
                    reloadDataAlimentos();
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
                    $("#modal_delete_alimentos").modal("toggle");
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
}
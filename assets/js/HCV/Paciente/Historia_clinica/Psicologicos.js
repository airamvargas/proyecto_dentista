$(document).ready(function () {
    document.getElementById("Psicologicos").click();
});

$("#psico").on("click", function () {
    $("#id_psicologicos").val(id_paciente);
    readPsicologicos();
    createPsicologicos();
});

//Obtener datos psicologicos
function readPsicologicos() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Psicologicos/read`;

    $.ajax({
        url: url,
        method: 'POST',
        data: {id_paciente : id_paciente},
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                $('#ps_intervenciones').val(data[0].ha_tenido_intervenciones);
                $('#tratamiento').val(data[0].ha_tenido_tratamiento_previo);
                $('#continuacion').val(data[0].actualmente_continua_tratamiento);
                $('#des_tratamiento').val(data[0].desc_tratamiento);
                $('#sesion-psicologica').val(data[0].considera_atencion_psicologia);
            }
            $('#loader').toggle();
            
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

function createPsicologicos(){
    $(document).on('submit', '#form_psicologicos', function () {
        $('#loader').toggle();
        var FORMDATA = new FormData($("#form_psicologicos")[0]);

        const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Psicologicos/create`

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
}
$("#peri").on("click", function () {
    $("#id_perinatales").val(id_paciente);
    readPerinatales();
});

$(document).on('submit', '#form_perinatales', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($("#form_perinatales")[0]);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perinatales/create`

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
function readPerinatales() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perinatales/read`;
    $.ajax({
        url: url,
        method: 'POST',
        data: {id_paciente : id_paciente},
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                $('#embarazo').val(data[0].no_embarazo_del_nino);
                $('#complicaciones').val(data[0].complicaciones_en_embarazo);
                $('#com_embarazo').val(data[0].desc_complicaciones);
                $('#nacimiento').val(data[0].tipo_nacimiento);
                $('#edad_madre').val(data[0].edad_de_la_madre_al_nacimiento);
                $('#complicacion_nacimiento').val(data[0].presento_alguna_complicacion_al_nacimiento);
                $('#des_complicacion').val(data[0].desc_complicacion_al_nacimiento);
                $('#semanas').val(data[0].semanas_gestacion_al_nacer);
                $('#alimentacion_bebe').val(data[0].alimentacion_al_nacer);
                $('#alimentacion_des').val(data[0].desc_otra_alimentacion);
                $('#apgar').val(data[0].calificacion_de_apgar);
                $('#silverman').val(data[0].calificacion_de_silverman);
                $('#reanimacion').val(data[0].amerito_reanimacion);
                $('#estancia').val(data[0].amerito_incubadora);
            }
            $('#loader').toggle();
            
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

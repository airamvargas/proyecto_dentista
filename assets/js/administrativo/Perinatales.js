//alert(id_paciente);
perinitales();

function perinitales() {

    const url = BASE_URL+'/Administrativo/Rest_Perinatales';

    nutricionales = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(nutricionales),
        success: function(data) {
            //console.log(data);
            $('#embarazo').val(data[0].No_embarazo_del_niño);
            $('#complicaciones').val(data[0].Complicaciones_en_embarazo);
            $('#com_embarazo').val(data[0].Desc_complicaciones);
            $('#nacimiento').val(data[0].Tipo_nacimiento);
            $('#madre').val(data[0].Edad_de_la_madre_al_nacimiento);
            $('#complicacion_nacimiento').val(data[0].Presento_alguna_complicacion_al_nacimiento);
            $('#com_nacimiento').val(data[0].Desc_complicacion_al_nacimiento);
            $('#semanas').val(data[0].Semanas_gestacion_al_nacer);
            $('#alimentacion-bebe').val(data[0].Alimentacion_al_nacer);
            $('#alimentacion-des').val(data[0].Desc_otra_alimentacion);
            $('#apgar').val(data[0].Calificacion_de_apgar);
            $('#silverman').val(data[0].Calificacion_de_silverman);
            $('#reanimacion').val(data[0].Amerito_reanimacion); 
            $('#estancia').val(data[0].Amerito_incubadora);  
            $('#id_peri').val(data[0].Id);  

            
            
        },
        error: function(error) {
           // alert('hubo un error al enviar los datos');
        }
    });

}

$(document).on('click', '#guardar_perinatales', function() {
    if ($("#embarazo").val().length < 1) {
        $('#modal_perinatales').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_perinatales').modal('toggle');
        var url_str =  BASE_URL+'/Administrativo/Rest_Perinatales/update_peri';
        var periForm = $("#form_perinatales").serializeArray();
        var loginFormObject = {};

        $.each(periForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataservi();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    }
});







get_psico();

function get_psico() {

    const url = BASE_URL+'/Administrativo/Rest_Psicologicos';

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
            $('#ps_intervenciones').val(data[0].Ha_tenido_intervenciones);
            $('#tratamiento').val(data[0].Ha_tenido_tratamiento_previo);
            $('#continuacion').val(data[0].Actualmente_continua_tratamiento);
            $('#des_tratamiento').val(data[0].Desc_tratamiento);
            $('#sesion-psicologica').val(data[0].Considera_atencion_psicologia);
            $('#id_psico').val(data[0].Id);
           
    
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}

///ACTUALIZACION PSCOLOGICOS///

$(document).on('click', '#guardar_psicologicos', function() {
   /*  if ($("#intervenciones").val().length < 1) {
        $('#modal_psicologicos').modal('toggle');
        alert('selecciona todos los campos');

    } else { */
        $('#loader').toggle();
        $('#modal_psicologicos').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_Psicologicos/update_psico';
        var periForm = $("#form_psicologicos").serializeArray();
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

   // }
});


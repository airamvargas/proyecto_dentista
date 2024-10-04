var id;
var id_medico;

evento_checks();
evento_checks_operativo();
showUpdateModal();
sendUpdateModal();
get_id();

function get_id() {
    $(document).on('click', '.btn-cancel', function() {
        let id_buton = $(this).attr('id');
       // alert(id_buton);
        $('#id_delete').val(id_buton);

    });
}

$(document).on('click', '#btn-cancel-cita', function() {
    $('#loader').toggle();
    let cita_id = $('#id_delete').val();
    let url = BASE_URL + 'Administrativo/Rest_visitas/cancelar_cita';
    let data = {
        id_cita:cita_id
    }

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data:JSON.stringify(data),
        success: function(response) {
            console.log(response);
            if (response.status == 200) {
                $('#loader').toggle();
                $('#success').text(response.messages.success);
                $('#succes-alert').show();
                reloadData();
                setTimeout(function() {
                    $('#succes-alert').hide();
                }, 3000);
            } else {
                $('#error-alert').text("ocurrio un error intentalo de nuevo");
                $('#error-alert').show();

            }
            $('#modal_delete').modal('toggle');
        }
    });
   
 

});






function btn_asignar() {
    /* $('.btn_asignar').on('click',function(){
             let id_pati=$(this).attr('id');
             $('#id_patient').val(id_pati);
             $("#model_operativo").modal('show');
         });*/
    $(document).on('click', '.btn_asignar', function() {
        let id_pati = $(this).attr('id');
        $('#id_patient').val(id_pati);
        $('#id_visita').val(id_pati);
        let id_doctor = $(this).data('index');
        let id_paciente = $(this).data('paciente');
        $('#medicotb').val(id_doctor);
        $('#id_paciente').val(id_paciente);
        $("#model_operativo").modal('show');
    })
}



//function btn_actualizar() {
$(document).on('click', '.btn_update', function() {
    $('#modal_update').modal('show');

    $('.hora').val("");
    var horas = $("#horas");
    horas.empty();
    id = $(this).attr('id');
    id_medico = $(this).data('index');
    $('#id_user').val(id);
});


$(document).on('click', '#btn-horas', function() {
    let date = $("#hor-d").val();

    if (date.length == 0) {
        alert("selecciona una fecha");

    } else {
        let url = BASE_URL + 'Administrativo/Visitas/get_ajax_visitas';
        var horas = $("#horas");
        horas.empty();


        console.log("yes");
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                fecha: date,
                id_doctor: id_medico
            },
            success: function(response) {
                console.log(response);

                horas.append('<option  value="">' + "Seleccione Hora" + '</option>');
                $(response).each(function(i, v) {
                    horas.append('<option  value="' + v + '">' + v + '</option>');
                });

            }
        });

    }








});



function evento_checks() {
    $(document).on('click', '.evento', function() {
        $('#loader').toggle();
        let id_cita = $(this).attr('id');
        let valor = $(this).prop("checked")


        //Cambio a pagado
        let data = {
            id_cita: id_cita,
            valor: valor
        };

        let url = BASE_URL + 'Administrativo/Rest_visitas/update_pago_paciente';

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(data),
            success: function(result) {

                if (result.status == 200) {
                    $('#loader').toggle();
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadData();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error-alert').text("ocurrio un error intentalo de nuevo");
                    $('#error-alert').show();

                }

            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        });

    });
}

function evento_checks_operativo() {
    $(document).on('click', '.evento-operativo', function() {
        $('#loader').toggle();
        let id_cita = $(this).attr('id');
        let valor = $(this).prop("checked");


        //Cambio a pagado
        let data = {
            id_cita: id_cita,
            valor: valor
        };

        let url = BASE_URL + 'Administrativo/Rest_visitas/update_pago_operativo';



        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(data),
            success: function(result) {

                if (result.status == 200) {
                    $('#loader').toggle();
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadData();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error-alert').text("ocurrio un error intentalo de nuevo");
                    $('#error-alert').show();

                }

            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        });

    });
}

/////////DATA PRECIO///////////

function showUpdateModal() {
    $(document).on('click', '.btn-update', function() {
        //alert("di un click");
        let url_str = BASE_URL + 'Administrativo/Rest_visitas/get_precio';
        $('#loader').toggle();
        let id_buton = $(this).attr('id');
        $('#id_upd').val(id_buton);
        let json = {
            id: id_buton
        };
        let objson = JSON.stringify(json);
        $.ajax({
            url: url_str,
            data: objson,
            method: 'post', //en este caso
            dataType: 'json',
            success: function(success) {
                //console.log(response);
                $('#id_visita_precio').val(success[0].id);
                $('#precio-visita').val(success[0].cost);
                $('#loader').toggle();
                $('#modal_update_cita').modal('show');

            },
            error: function(xhr, text_status) {
                $('#loader').toggle();
            }
        });
    });
}

/////////UPDATE PRECIO//////////


function sendUpdateModal() {
    $(document).on('click', '#submit_form_upd', function() {
        $('#loader').toggle();
        let url_str = BASE_URL + 'Administrativo/Rest_visitas/update_precio';
        var loginForm = $("#update_form").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
            }
        );
        // send ajax
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
                    reloadData();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_update_cita').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_update_cita').modal('toggle');
            }
        })
    });
}


function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}
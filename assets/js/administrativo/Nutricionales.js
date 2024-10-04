
get_nutricionales();
sendFormDel_Alimentos();
get_id_alimento();

function get_nutricionales() {

    const url = BASE_URL+'/Administrativo/Rest_Nutricionales';

    nutricionales = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(nutricionales),
        success: function(data) {
            console.log(data);
            $('#comida').val(data[0].tipo_comida);
            $('#tiempo').val(data[0].N_comidas_dia);
            $('#realizas').val(data[0].Comida_en_casa);
            $('#alchol').val(data[0].Consumo_alcohol);
            $('#cuantas').val(data[0].N_copas);
            $('#suplemento').val(data[0].Suplemento);
            $('#desuplemnto').val(data[0].s_descripcion);
            $('#id_nutricional').val(data[0].Id);
            const bebida = data[0].Tipo_de_bebida;

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
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}

//ACTUALIZAR NUTRICIONAL//

$(document).on('click', '#guardar_nutricionales', function() {
    if ($("#alimentacion").val().length < 1) {
        //$('#modal_servicios').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_nutricionales').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_Nutricionales/update_nutricional';
        var serviciosForm = $("#form_nutricional").serializeArray();
        var loginFormObject = {};

        $.each(serviciosForm, function(i, v) {
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
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
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

//ALIMENTOS//
let dataTablealimento = $('#alimento').DataTable({
    'ajax' : {
        'url' :  BASE_URL+'/Administrativo/Rest_Nutricionales/get_alimentos',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 

    columns: [
        {
            data: 'alimento'
        },
        {
            data: 'numero'
        },
        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_alimentos" class="ml-1 btn btn btn-danger btn_al btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

//CREAR ALIMENTOS//
$(document).on('click', '#guardar_alimentos', function() {
    if ($("#consumo-alimentos").val().length < 1) {
        $('#modal_alimentos').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_alimentos').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_Nutricionales/Crear_alimento';
        var alimentosForm = $("#form_nutricional").serializeArray();
        var loginFormObject = {};

        $.each(alimentosForm, function(i, v) {
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
                    reloadDataAlimentos();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
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

function reloadDataAlimentos() {
    $('#loader').toggle();
    dataTablealimento.ajax.reload();
    $('#loader').toggle();
}

//BORRAR ALIMENTO//
function sendFormDel_Alimentos() {
    $(document).on('click', '#borrar_alimentos', function() {
        $('#loader').toggle();
        var url_str = BASE_URL+'/Administrativo/Rest_Nutricionales/delete_alimento';
        var Form = $("#delete_form_alimentos").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataAlimentos();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_alimentos').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_alimentos').modal('toggle');
            }
        })
    });
}

function get_id_alimento() {
    $(document).on('click', '.btn_al', function() {
        let id_butona = $(this).attr('id');
        $('#al').val(id_butona);

    });
}

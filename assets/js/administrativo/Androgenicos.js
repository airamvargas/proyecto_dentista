get_cat_adrogenicos();
get_androgenicos();
get_id_etsh();
sendFormDel_Etsh();



function get_androgenicos() {

    const url = BASE_URL + '/Administrativo/Rest_Androgenicos';

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
            $('#ansexual').val(data[0].Inicio_de_vida_sexual);
            $('#annumero-parejas').val(data[0].Numero_parejas_sexuales);
            $('#id_andro').val(data[0].Id);
        },
        error: function(error) {
            //  alert('hubo un error al enviar los datos');
        }
    });

}


function get_cat_adrogenicos() {
    //alert("dentro de la funcion");
    const enfermedad = BASE_URL + '/Hcv_Rest_Androgenicos/get_cat';
    var enfermedades = $("#trasex");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.nombre_comun + '">' + v.nombre_comun + '</option>');
            })
        },
        error: function(error) {
            // alert('hubo un error al enviar los datos');
        }
    });
}




//guardar ets//
$(document).on('click', '#guardar_ets_h', function() {
    /*    if ($("#sel_etsa").val().length < 1) {
           $('#modal_ets_h').modal('toggle');
           alert('selecciona todos los campos');

       } else { */
    $('#loader').toggle();
    $('#modal_ets_h').modal('toggle');
    var url_str = BASE_URL + '/Administrativo/Rest_Androgenicos/create_ets';
    var androForm = $("#form_androgenicos").serializeArray();
    var loginFormObject = {};

    $.each(androForm, function(i, v) {
        loginFormObject[v.name] = v.value;
    });

    $.ajax({
        url: url_str, // url where to submit the request
        type: "POST", // type of action POST || GET
        dataType: 'JSON', // data type
        data: JSON.stringify(loginFormObject), // post data || get data
        success: function(result) {
            //console.log(result);
            if (result.status == 200) {
                $('#success').text(result.messages.success);
                $('#succes-alert').show();
                reloadDataetsh();
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
    //}
});


//////tabla//
let dataTabletsh = $('#table_ets_h').DataTable({
    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Ginecoobstetricos/get_ets',
        'data': { 'id_paciente': id_paciente },
        'type': 'post',

    },
    columns: [
        {
            data: 'Enfermedad'
        },
        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_ets_h" class="ml-1 btn btn btn-danger btn_ets_h btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
        
    ],
    "bPaginate": false,
    "searching": false,
});


function reloadDataetsh() {
    $('#loader').toggle();
    dataTabletsh.ajax.reload();
    $('#loader').toggle();
}

////borrar ets//
function sendFormDel_Etsh() {
    $(document).on('click', '#borrar_etsh', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Androgenicos/delete_ets';
        var Form = $("#delete_form_etsh").serializeArray();
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
                    //console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataetsh();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_ets_h').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_ets_h').modal('toggle');
            }
        })
    });
}

function get_id_etsh() {
    $(document).on('click', '.btn_ets_h', function() {
        let id_butona = $(this).attr('id');
        $('#in_etsh').val(id_butona);

    });
}


//guardar androgenicos//
$(document).on('click', '#guardar_andro', function() {
    /*   if ($("#sexual").val().length < 1) {
          //$('#modal_servicios').modal('toggle');
          alert('selecciona todos los campos');

      } else { */
    $('#loader').toggle();
    $('#modal_andro').modal('toggle');
    var url_str = BASE_URL + '/Administrativo/Rest_Androgenicos/update_androgenico';
    var androForm = $("#form_androgenicos").serializeArray();
    var loginFormObject = {};

    $.each(androForm, function(i, v) {
        loginFormObject[v.name] = v.value;
    });

    $.ajax({
        url: url_str, // url where to submit the request
        type: "POST", // type of action POST || GET
        dataType: 'JSON', // data type
        data: JSON.stringify(loginFormObject), // post data || get data
        success: function(result) {
            //console.log(result);
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

    //}
});
//alert(id_paciente);
get_efermedades();
get_id();
sendFormDel();

function get_efermedades() {
    //alert("dentro de la funcion");
    const enfermedad = BASE_URL + '/Hcv_Rest_Heredado/get_Enfermedades';
    var enfermedades = $("#enfermedad");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            const ch = data['data'];
            $(ch).each(function (i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.id + '">' + v.nombre_comun + '</option>');
            })
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


var dataTable = $('#heredado').DataTable({

    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Heredadofamiliares',
        'data': {
            'id_paciente': id_paciente
        },
        'type': 'post',

    },
    columns: [

        {
            data: 'rama'
        },

        {
            data: 'parentesco'
        },

        {
            data: 'nombre_comun'
        },


        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button type="button" id="' + row.id + '" data-toggle="modal" data-target="#modal_delete" class="ml-1 btn btn btn-danger eliminar btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },

    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});


$(document).on('click', '#agregar', function () {
    $('#modal_alert').modal('toggle');

});



//CREAR HEREDO FAMILIARES 
$(document).on('click', '#guardar', function () {
    if ($("#enfermedad").val().length < 1) {
        $('#modal_alert').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_alert').modal('toggle');
        $('#id_user').val(id_paciente);
        var url_str = BASE_URL + '/Administrativo/Rest_Heredadofamiliares/create';
        var heredadoForm = $("#enfermedades").serializeArray();
        var loginFormObject = {};

        $.each(heredadoForm, function (i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function (result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadData();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function (xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });
    }
});



//recarga la datatabla
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

function get_id() {
    $(document).on('click', '.eliminar', function () {
        let id_buton = $(this).attr('id');
        $('#id_delete').val(id_buton);
    });
}

//BORAR HERODO FAMILIARES//
function sendFormDel() {
    $(document).on('click', '#submit_form_del', function () {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Heredadofamiliares/delete_heredo';
        var Form = $("#delete_form").serializeArray();
        var FormObject = {};
        $.each(Form,
            function (i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function (result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadData();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete').modal('toggle');
            },
            error: function (xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        })
    });
}
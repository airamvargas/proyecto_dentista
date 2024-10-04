//alert(id_paciente);
$('.id_user').val(id_paciente);
get_nopat();
sendFormDel_Animales();
get_id_animal();
get_id_servicio();
sendFormDel_Servicios();

function get_nopat() {

    const no_pat = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos';

    nopat = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: no_pat,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(nopat),
        success: function(data) {
            //console.log(data);
            $('#talla').val(data[0].Talla);
            $('#peso').val(data[0].Peso);
            $('#tatuajes').val(data[0].Tatuajes);
            $('#perforacion').val(data[0].Piercing);
            $('#tuber').val(data[0].tuberculosi);
            $('#humo').val(data[0].humo_lena);
            $('#id_update').val(data[0].Id);
            $('#casa').val(data[0].Casa_propia);
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}

//Actualizar personales no patologicos//
$(document).on('click', '#guardar_patologicos', function() {
    if ($("#talla").val().length < 1) {
        //$('#modal_servicios').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        //$('#loader').toggle();
        $('#modal_patalogicos').modal('toggle');
        var url_str = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/update_per';
        var serviciosForm = $("#no_patogenos").serializeArray();
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
                //console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    $('#loader').toggle();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                    $('#loader').toggle();
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


///////ANIMALES//////

$(document).on('click', '#btnanimales', function() {
    $('#modal_animales').modal('toggle');

});


//mandar formulario animales
$(document).on('click', '#guardar_animales', function() {
    if ($("#animales").val().length < 1) {
        $('#modal_animales').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_animales').modal('toggle');
        var url_str = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/Create_animales';
        var animalesForm = $("#no_patogenos").serializeArray();
        var loginFormObject = {};

        $.each(animalesForm, function(i, v) {
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
                    reloadDatanimales();
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

let dataTableanimal = $('#pat_animales').DataTable({
    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/get_animales',
        'data': { 'id_paciente': id_paciente },
        'type': 'post',

    },

    columns: [

        {
            data: 'Name'
        },

        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_animales" class="ml-1 btn btn btn-danger anim btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});





function reloadDatanimales() {
    $('#loader').toggle();
    dataTableanimal.ajax.reload();
    $('#loader').toggle();
}

//BORRAR ANIMALES//
function get_id_animal() {
    $(document).on('click', '.anim', function() {
        let id_butona = $(this).attr('id');
        $('#animal').val(id_butona);

    });
}

function sendFormDel_Animales() {
    $(document).on('click', '#del_animales', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/delete_animales';
        var Form = $("#delete_form_animales").serializeArray();
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
                    reloadDatanimales();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_animales').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_animales').modal('toggle');
            }
        })
    });
}


///////SERVICIOS//////
let dataTableservicios = $('#pat_servicios').DataTable({
    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/get_servicios',
        'data': { 'id_paciente': id_paciente },
        'type': 'post',

    },

    columns: [{
            data: 'Servicios'
        },
        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_servicios" class="ml-1 btn peligro-irreversible servicios btnborder pd-x-20" style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

function reloadDataservi() {
    $('#loader').toggle();
    dataTableservicios.ajax.reload();
    $('#loader').toggle();
}


//CREAR SERVICIO//
$(document).on('click', '#btn_servicios', function() {
    $('#modal_servicios').modal('toggle');

});

/////////Agregar Servicio/////////

$(document).on('click', '#guardar_servicios', function() {
    if ($("#servicios").val().length < 1) {
        $('#modal_servicios').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_servicios').modal('toggle');
        var url_str = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/create_servicio';
        var serviciosForm = $("#no_patogenos").serializeArray();
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
                //console.log(result);
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


///borrar servicio//

function get_id_servicio() {
    $(document).on('click', '.servicios', function() {
        let id_butona = $(this).attr('id');
        $('#servicio').val(id_butona);

    });
}

function sendFormDel_Servicios() {
    $(document).on('click', '#del_servicio', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Personales_no_patologicos/delete_servicio';
        var Form = $("#delete_form_servicios").serializeArray();
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
                    // console.log(result);
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
                $('#modal_delete_servicios').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_servicios').modal('toggle');
            }
        })
    });
}
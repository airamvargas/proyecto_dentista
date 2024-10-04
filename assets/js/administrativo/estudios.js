sendCreateModal();
sendFormDel();
get_id();
showUpdateModal();
sendUpdateModal();
get_tipo_sector();
get_tipo_membresia();

//created



//Llenado de la base de datos 
var dataTable = $('#datatable1').DataTable({
    ajax: BASE_URL + '/Administrativo/Rest_Estudios',

    columns: [
        {
            data: 'nombre'
        },
        {
            data: 'preparacion'
        },
        {
            data: 'description'
        },
        {
            data: 'name'
        },{
            data: 'precio'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button id="' + row.id + '"" class="btn btn-warning btn-update btn-radio pd-x-20"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i> ACTUALIZAR</button>' +
                    '<button id="' + row.id + '" data-toggle="modal" data-target="#modal_delete" class="btn btn-danger btn-radio pd-x-20 ml-1 "><i class="fa fa-trash-o fa-lg" aria-hidden="true"></i> ELIMINAR</button>'


            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

function get_tipo_sector() {
    const sector =  BASE_URL+ '/Administrativo/Rest_Estudios/lista_sectores';
    var sectores = $(".sectores");
    console.log(sectores);
    $.ajax({
        url: sector,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
			sectores.append('<option  value=" ">' + "Seleccione sector"+ '</option>');
		
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                sectores.append('<option  value="' + v.id + '">' + v.description + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

function get_tipo_membresia() {
    const membresia =  BASE_URL+ '/Administrativo/Rest_Estudios/lista_membresias';
    var membresias = $(".membresias");
    $.ajax({
        url: membresia,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
			membresias.append('<option  value=" ">' + "Seleccione membresia"+ '</option>');
		
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                membresias.append('<option  value="' + v.id + '">' + v.description + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

function sendCreateModal() {
    $(document).on('click', '#submit_form_estudios', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Estudios/create_estudios';
        var loginForm = $("#created_form").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'JSON',
            data: JSON.stringify(loginFormObject),
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadData();
                    $('#add-nombre').val("");
                    $('#add-preparacion').val("");
                    $('#add-cita').val("");
                    $('#add-sector').val("");
                    $('#add-membresia').val("");
                    $('#add-precio').val("");
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
        })
    });
}

function sendFormDel() {
    $(document).on('click', '#submit_form_del', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_Estudios/delete_estudio';
        var Form = $("#delete_form").serializeArray();
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
                    reloadData();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        })
    });
}

function get_id() {
    $(document).on('click', '.btn-danger', function() {
        let id_buton = $(this).attr('id');
        $('#id_delete').val(id_buton);

    });
}

function showUpdateModal() {
    $(document).on('click', '.btn-update', function() {
        var url_str = BASE_URL + '/Administrativo/Rest_Estudios/get_estudio';
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
                console.log("dentro de la funcion");
                console.log(success);
                $('#upd_nombre').val(success[0].nombre);
                $('#upd_preparacion').val(success[0].preparacion);
                $('#upd_sector').val(success[0].sector_id);
                $('#upd_membresia').val(success[0].membresia_id);
                $('#upd_precio').val(success[0].precio);
                $('#id_estudio').val(success[0].id_estudio);
                $('#id_membresia_x_estudio').val(success[0].id_membresia_x_estudio);
                $('#modal_update').modal('show');
            },
            error: function(xhr, text_status) {
                $('#loader').toggle();
            }
        });
    });
}

function sendUpdateModal() {
    $(document).on('click', '#submit_form_upd', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + 'Administrativo/Rest_Estudios/update_estudio';
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
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_update').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_update').modal('toggle');
            }
        })
    });
}
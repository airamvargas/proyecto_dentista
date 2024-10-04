console.log(id_paciente);

var dataTable = $('#datatable1').DataTable({
    ajax: {
        url: BASE_URL + 'Operativo/Hcv_Rest_Get_Citas',
        data: {
            'id_paciente': id_paciente
        },
        type: 'post'
    },

    columns: [{
            data: "id",
            render: function (data, type, row, meta) {
                return '<p class="">' + data + '</p>'
            }
        },
        //{ data: 'date_time' },
        {
            data: "date_time",
            render: function (data, type, row, meta) {
                var now = new Date(data)
                return '<span class="d-none">' + data + '</span>' + now.toLocaleDateString();
            }
        },
        {
            data: "date_time",
            render: function (data, type, row, meta) {
                var now = new Date(data)
                return now.toLocaleTimeString();
            }
        },

        {
            data: 'NAME',
            render: function (data, type, row, meta) {
                return row.NAME + " " + row.F_LAST_NAME + " " + row.S_LAST_NAME;

            }
        },
        {
            data: 'type',
            render: function (data, type, row, meta) {
                var tipo = 'Sin Asignar'
                switch (true) {
                    case (data == 0):
                        tipo = 'Medicina'
                        break;
                    case (data == 1):
                        tipo = 'Psicologia'
                        break;
                    case (data == 2):
                        tipo = 'Nutricion'
                        break;
                    case (data == 3):
                        tipo = 'Fisioterapia'
                        break;
                    case (data == 4):
                        tipo = 'Especialidad'
                        break;
                    default:
                        tipo = 'No se'
                        break;
                }
                return tipo
            }
        },

        {
            data: 'tipo_cita'
        },

        {
            data: 'status',
            render: function (data, type, row, meta) {
                var status = 'Sin Asignar'
                switch (true) {
                    case (data == 0):
                        status = 'Sin Asignar'
                        break;
                    case (data == 1):
                        status = 'Asignado Sin Confirmar'
                        break;
                    case (data == 2):
                        status = 'Pendiente de confirmar'
                        break;
                    case (data == 3):
                        status = 'Confirmado'
                        break;
                    case (data == 5):
                        status = 'Cancelada'
                        break;
                    default:
                        status = 'Sin Asignar'
                        break;
                }
                return status
            }
        },
        {
            data: 'cost'
        },

        {
            data: 'status',
            render: function (data, type, row, meta) {
                return data != 3 ?
                    `<button id="` + row.id + `" data-toggle="modal" data-target="#modal_asignar" class="btn btn-warning pd-x-20 btn_update"><i class="fa fa-pencil" aria-hidden="true"></i></button>` :
                    data == 3 ?
                    '<p style="font-weight: bold; color:#1caf9a; ">Confirmado</p>' :
                    'default'

            }
            /*  data: "id" , render : function ( data, type, row, meta ) {
            return `<button id="`+ row.id +`" data-toggle="modal" data-target="#modal_asignar" class="btn btn btn-info pd-x-20 btn_update">Actualizar</button>`
            <i class="fa fa-pencil" aria-hidden="true"></i>
        } */
        },
        {
            data: 'status',
            render: function (data, type, row, meta) {
                return data != 3 ?
                    `<button id="` + row.id + `" data-toggle="modal" data-target="#modal_delete" class="ml-1 btn btn btn-danger delete pd-x-20"><i class="fa fa-times-circle" aria-hidden="true"></i></button>` :
                    data == 3 ?
                    '<p style="font-weight: bold; color:#1caf9a; ">Confirmado</p>' :
                    'default'

            }
            /*    data: "id" , render : function ( data, type, row, meta ) {
                   return `<button id="`+ row.id +`" data-toggle="modal" data-target="" class="ml-1 btn btn btn-danger delete">Cancelar cita</button>`
                   <i class="fa fa-times-circle" aria-hidden="true"></i>
               } */
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<a href="' + BASE_URL + 'Paciente/Nota_Medica/index/' + data + '" ><button id="' + row.id + '"" class="btn btn btn-primary btncolor pd-x-20"><i class="fa fa-eye" aria-hidden="true"></i></button></a>'
                //VER
            }
        }

    ],
    initComplete: function (settings, json) {

        $('.delete').on('click', function () {
            let id_buton = $(this).attr('id');
            $('#id_cita').val(id_buton);
            $('#modal_delete').modal('toggle');
        })

        $('.btn_update').on('click', function () {
            // alert("Hola mundo");
            let url = BASE_URL + 'Administrativo/Visitas/get_ajax_visitas';
            let id = $(this).attr('id');
            let cp = {
                id: id
            }
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: cp,
                success: function (response) {
                    console.log(response);
                    //alert(response[0].TIMEONLY);
                    $('#old_time').val(response[0].TIMEONLY);
                    $('#date').val(response[0].DATEONLY);

                    $('#id_user').val(response[0].ID);
                    $('#modal_update').modal('show');

                }
            });
        });


    },

    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});



$(document).on('click', '#update_cita', function () {
    // if($("#horas").val().length < 1)  {
    if ($("#date").val().length < 1) {
        alert('selecciona una fecha');
    } else {
        var url_str = BASE_URL + 'Administrativo/Rest_Pacientes_Cita/update_cita';
        var androForm = $("#form_update").serializeArray();
        var loginFormObject = {};

        $.each(androForm, function (i, v) {
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
                    reload();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                //$('#loader').toggle();
                $('#modal_update').modal('toggle');

            },
            error: function (xhr, text_status) {
                //console.log(xhr, text_status);
                //$('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_update').modal('toggle');
            }
        });

    }
    /* }else{
        alert('selecciona una hora');   
    } */
});


function reload() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}


$(document).on('click', '#borrar_cita', function () {
    let id = $('#id_cita').val();

    id_cita = {
        'id': id
    }
    
    $.ajax({
        url: BASE_URL + 'Administrativo/Rest_Pacientes_Cita/delete_cita', // url where to submit the request
        type: "POST", // type of action POST || GET
        dataType: 'JSON', // data type
        data: JSON.stringify(id_cita), // post data || get data
        success: function (result) {
            console.log(result);
            if (result.status == 200) {
                $('#success').text(result.messages.success);
                $('#succes-alert').show();
                reload();
            } else {
                $('#error').text(result.error);
                $('#error-alert').show();
            }
            //$('#loader').toggle();
            $('#modal_delete').modal('toggle');

        },
        error: function (xhr, text_status) {
            //console.log(xhr, text_status);
            //$('#loader').toggle();
            $('#error-alert').show();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
            $('#modal_delete').modal('toggle');
        }
    });




});
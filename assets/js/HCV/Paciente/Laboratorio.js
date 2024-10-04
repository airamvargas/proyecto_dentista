cargando();
const id_cita = citas[0].id;
//alert(grupo);
get_id();



function cargando() {
    $('#loader').toggle();
    $('#consulta-total').text(citas[0].cost + " " + "MXN");
    const url = BASE_URL + '/paciente/Rest_Laboratorio/index/' + citas[0].patient_id;
    var estudios = $("#estudios");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#loader').toggle();
            console.log(data);
            //estudios.append('<option  value="">' + "SELECCIONA TIPO DE CITA" + '</option>');
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                estudios.append('<option data-index="' + v.precio + '"  value="' + v.estudios_id + '">' + v.nombre + " " + "$" + v.precio + '</option>');
            })
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

}

$('#send-form').on('click', function() {
    let estudio = $("#estudios").val();
    let precio_estudio = $('#estudios').children('option:selected').data('index');
    //alert(precio_estudio);
    if (estudio == "") {
        alert("Debes de seleccionar un estudio para continuar");
    } else {
        $('#loader').toggle();

        let data_lab = {
            id_cita: id_cita,
            id_estudio: estudio,
            precio: precio_estudio,
            id_paciente: citas[0].patient_id
        };

        const url = BASE_URL + 'Paciente/Rest_Laboratorio/crear';

        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(data_lab),
            success: function(result) {
                if (result.status == 200) {
                    $('#loader').toggle();
                    $('#consulta-total').text(result.precio.precio_cita + " " + "MXN");
                    reload()
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);

                } else {
                    $('#error-alert').text("ocurrio un error intentalo de nuevo");
                    $('#error-alert').show();
                }

            },
            error: function(xhr, resp, text) {
               // console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                //$('#modal_delete').modal('toggle');
            }
        });
    }
});


let dataProcedimientos = $('#tbprocedimientos').DataTable({
    'ajax': {
        'url': BASE_URL + '/paciente/Rest_Laboratorio/tb',
        'data': {
            'id_cita': id_cita
        },
        'type': 'post',
    },
    columns: [{
            data: 'nombre'
        },
        {
            data: 'precio'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.id + '" data-toggle="modal" data-target="#delete_procedimiento" class="ml-1 btn btn btn-danger btn_proc btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});


function reload() {
    $('#loader').toggle();
    dataProcedimientos.ajax.reload();
    $('#loader').toggle();
}


function get_id() {
    $(document).on('click', '.btn_proc', function() {
        let id_buton = $(this).attr('id');
        //alert(id_buton);
        $('#id_procedimiento').val(id_buton);

    });
}


$('#btn_delete_pro').on('click', function() {
    let id_intermedio = $("#id_procedimiento").val();
    $('#loader').toggle();

    let data = {
        id_cita: id_cita,
        id_estudio: id_intermedio
    };

    var url_procedimiento = BASE_URL + 'paciente/Rest_Laboratorio/borrar';

    $.ajax({
        url: url_procedimiento,
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(data),
        success: function(result) {

            if (result.status == 200) {
                $('#loader').toggle();
                $('#delete_procedimiento').modal('toggle');
                $('#consulta-total').text(result.precio.precio_cita + " " + "MXN");
                reload()
                $('#success').text(result.messages.success);
                $('#succes-alert').show();
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


///////////LIBERAR//////////

$('#send').on('click', function() {
    $('#modal_alert').modal('toggle');
    $('#loader').toggle();
    let data = {
        id_cita: id_cita
    }
    const url = BASE_URL + '/paciente/Rest_Laboratorio/cerrar_estudio';

    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(data),
        success: function(result) {

            switch (result.status) {
                case 200:
                    $('#loader').toggle();
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                    location.href = BASE_URL + "/Inicio";

                    break;


                case 201:
                    $('#loader').toggle();
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    setTimeout(function() {
                        $('#succes-alert').hide();
                    }, 3000);
                    location.href = BASE_URL + "Administrativo/Visitas";
                    break;

                case 400:
                    $('#loader').toggle();
                    Toastify({
                        text: result.messages.success,
                        duration: 3000,
                        className: "dangerColor",
                        avatar: "../../../../../assets/img/logop.png",
                        style: {
                            background: "linear-gradient(to right, #fb0909, #ec0d0d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                    break;
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



$('#send-liberar').on('click', function() {
    $('#modal_alert').modal('toggle');


});


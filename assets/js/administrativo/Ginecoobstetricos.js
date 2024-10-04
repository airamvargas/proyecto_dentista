//alert(id_paciente);
get_cat_adrogenicos();
get_gine();
sendFormDel_Ets();
get_id_ets();


//TABLA DE ETS//
let dataTabletsgine = $('#table-ets').DataTable({
    'ajax' : {
        'url' :  BASE_URL+'/Administrativo/Rest_Ginecoobstetricos/get_ets',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 

    columns: [
        {
            data: 'Enfermedad'
        },
        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_ets" class="ml-1 btn btn btn-danger btn_ets btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },        
    ],
    "bPaginate": false,
    "searching": false,
});


function get_gine() {

    const url = BASE_URL+'/Administrativo/Rest_Ginecoobstetricos';

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
            $('#menarca').val(data[0].Menarca);
            $('#inicio_sexual').val(data[0].Inicio_de_vida_sexual);
            $('#ciclo').val(data[0].Tipo_de_ciclo);
            $('#embarazos').val(data[0].Numero_de_embarazos);
            $('#partos').val(data[0].Numero_de_partos);
            $('#cesareas').val(data[0].Numero_de_cesareas);
            $('#abortos').val(data[0].Numeros_de_abortos);
            $('#lactancia').val(data[0].Ha_dado_lactancia);
            $('#menopausia').val(data[0].Edad_inicio_menopausia);
            $('#parejas').val(data[0].Numeros_parejas_sexuales);
            $('#id_gine').val(data[0].Id);   
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}


//select de enfermedades de transmision sexual//


function get_cat_adrogenicos() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Hcv_Rest_Androgenicos/get_cat';
    var enfermedades = $("#trasex_sex");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.nombre_comun + '">' + v.nombre_comun + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//GUARGAR ets//

$(document).on('click', '#guardar_ets', function() {
    if ($("#trasex_sex").val().length < 1) {
        $('#modal_ets').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_ets').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_Ginecoobstetricos/create_ets';
        var gineForm = $("#form_gine").serializeArray();
        var loginFormObject = {};

        $.each(gineForm, function(i, v) {
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
                    reloadDataets();
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


///guardar gine//

$(document).on('click', '#guardar_gine', function() {
    if ($("#menarca").val().length < 1) {
        //$('#modal_servicios').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_gine').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_Ginecoobstetricos/update_ginebastricos';
        var gineForm = $("#form_gine").serializeArray();
        var loginFormObject = {};

        $.each(gineForm, function(i, v) {
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


function reloadDataets() {
    $('#loader').toggle();
    dataTabletsgine.ajax.reload();
    $('#loader').toggle();
}


////////get id//////
function get_id_ets() {
    $(document).on('click', '.btn_ets', function() {
        let id_butona = $(this).attr('id');
        $('#in_ets').val(id_butona);

    });
}


function sendFormDel_Ets() {
    $(document).on('click', '#borrar_ets', function() {
        $('#loader').toggle();
        var url_str =  BASE_URL+'/Administrativo/Rest_Ginecoobstetricos/delete_ets';
        var Form = $("#delete_form_ets").serializeArray();
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
                    reloadDataets();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_ets').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_ets').modal('toggle');
            }
        })
    });
} 
get_rechazar_cita();
sendFormRechazar_cita();
sendFormAceptar_cita();
get_aceptar_cita();



$(document).on('click', '.btn-danger', function() {
    let id = $(this).attr('id');
    $('#id_delete').val(id);
    $('#modal_delete').modal('show');
})




$('.alert .close').on('click', function(e) {
    $(this).parent().hide();
});

function reloadData() {
    $('#loader').toggle();
    sendFormDel.ajax.reload();
    $('#loader').toggle();
}

// Datepicker
$('.fc-datepicker').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true
});

$('#datepickerNoOfMonths').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    numberOfMonths: 2
});




$(document).ready(function() {
    $('#genero').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#othergender').show();
        } else {
            $('#othergender').hide();
        }
    })
});

$(document).ready(function() {
    $('#info').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#otherinfo').show();
        } else {
            $('#otherinfo').hide();
        }
    })
});

$(document).ready(function() {
    let Checked = null;
    //The class name can vary
    for (let CheckBox of document.getElementsByClassName('check')) {
        CheckBox.onclick = function() {
            if (Checked != null) {
                Checked.checked = false;
                Checked = CheckBox;
            }
            Checked = CheckBox;
        }
    }
});


///TABLA OPERATIVO///

var dataTable = $('#operativo').DataTable({
    ajax: BASE_URL + '/Hcv_Rest_Operativo_principal/laboratorio',

    columns: [
        {
            data: 'id'
        },

        {
            data: 'Fecha'
        },

        {
            data: 'Hora'
        },
        {
            data: 'tipo_cita'
        },

        {
            data: 'user_name'
        },



        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button data-index ="' + row.tipo_cita + '" type="button" id="' + row.id + '" data-toggle="modal" data-target="" class="ml-1 btn btn-teal acep_cita btnborder pd-x-20"><i class="fa fa-check-circle-o fa-lg mr-1" aria-hidden="true"></i>ACEPTAR</button>'
            }
        },

        {
            data: "status",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.id + '" data-toggle="modal" data-target="#modal_rechazar_cita" class="ml-1 btn btn-danger rechazar btnborder pd-x-20"><i class="fa fa-times-circle fa-lg mr-1" aria-hidden="true"></i>RECHAZAR</button>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});


function get_rechazar_cita() {
    $(document).on('click', '.rechazar', function() {
        let id_buton = $(this).attr('id');
        $('#input_rechazar').val(id_buton);

    });
}

function get_aceptar_cita() {
    $(document).on('click', '.acep_cita', function() {
        let id_buton = $(this).attr('id');
        $('#input_aceptar').val(id_buton);
        var consulta = $(this).data('index');
        $('#consulta').val(consulta);

        if (consulta == "VIRTUAL") {
            $('#link').show();
            $('#lb-link').show();
        } else {
            $('#link').hide();
            $('#lb-link').hide();
        }
        $('#modal_aceptar_cita').modal('toggle');
    });
}

function reloadDataCita() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

function reloadCitas() {
    $('#loader').toggle();
    dataTablecitas.ajax.reload();
    $('#loader').toggle();
}

$(document).on('click', '#aceptar_cita', function() {
    $('#modal_aceptar_cita').modal('toggle');
    $('#alert_aceptar_cita').modal('toggle');
});


//RECHAZAR CITA //

function sendFormRechazar_cita() {
    $(document).on('click', '#rechazar_cita', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Hcv_Rest_Operativo_principal/Rechazar_cita';
        var Form = $("#rechazar_form_cita").serializeArray();
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
                    reloadDataCita();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_rechazar_cita').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_rechazar_cita').modal('toggle');
            }
        })
    });
}



//aceptar cita//
function sendFormAceptar_cita() {
    $(document).on('click', '#guardar_cita', function() {
        //$('#loader').toggle();
        let consulta = $('#consulta').val();
        if (consulta === "VIRTUAL") {
            let link = $('#link').val();
            if (link === "") {
                $('#loader').toggle();
                alert("rellana el campo de link");
                $('#modal_aceptar_cita').modal('toggle');
                $('#alert_aceptar_cita').modal('toggle');
            } else {
                $('#alert_aceptar_cita').modal('toggle');
                $('#loader').toggle();
                var url_str = BASE_URL + '/Hcv_Rest_Operativo_principal/Aceptar_cita';
                var Form = $("#aceptar_form_cita").serializeArray();
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
                            $('#loader').toggle();
                            console.log(result);
                            $('#success').text(result.messages.success);
                            $('#succes-alert').show();
                            reloadDataCita();
                            reloadCitas();
                        } else {
                            $('#error').text(result.error);
                            $('#error-alert').show();
                        }
                        $('#loader').toggle();
                        $('#alert_aceptar_cita').modal('toggle');
                    },
                    error: function(xhr, resp, text) {
                        //console.log(xhr, resp, text);
                        $('#loader').toggle();
                        $('#error-alert').show();
                        $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                        $('#alert_aceptar_cita').modal('toggle');
                    }
                })
            }
        } else {
            $('#loader').toggle();
            var url_str = BASE_URL + '/Hcv_Rest_Operativo_principal/Aceptar_cita';
            var Form = $("#aceptar_form_cita").serializeArray();
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
                        reloadDataCita();
                        reloadCitas();
                    } else {
                        $('#error').text(result.error);
                        $('#error-alert').show();
                    }
                    $('#loader').toggle();
                    $('#alert_aceptar_cita').modal('toggle');
                },
                error: function(xhr, resp, text) {
                    //console.log(xhr, resp, text);
                    $('#loader').toggle();
                    $('#error-alert').show();
                    $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                    $('#alert_aceptar_cita').modal('toggle');
                }
            })

        }


    });
}


var dataTablecitas = $('#tb_citas').DataTable({
    ajax: BASE_URL + '/Hcv_Rest_Operativo_principal/get_citas_laboratorio',
    "order": [
        [2, "desc"]
    ],

    columns: [{
            data: "id",
            render: function(data, type, row, meta) {
                return row.id

            }
        },

        {
            data: 'Fecha'
        },

        {
            data: 'Hora'
        },

        {
            data: 'NAME',
            render: function(data, type, row, meta) {
                return row.NAME + " " + row.F_LAST_NAME;

            }
        },

        {
            data: 'tipo_cita',
            render: function(data, type, row, meta) {
                return data == "VIRTUAL" ?
                    '<a href="' + row.link + '" target="_blank"><button type="button" class="ml-1 btn btn btn-purple rechazar btnborder pd-x-20"><i class="fa fa-users" aria-hidden="true"></i></button></a>' :
                    data
            }
        },

        /*  {
                data: 'cost',
                render: function(data, type, row, meta) {
                    return '<p>'+"$"+data+" "+" MXN" + '</p>'
                }
            },
 */


        /*  {
             data: "id",
             render: function(data, type, row, meta) {
                 return '<a href="<?= base_url() . "/Hcv_Historia_Clinica_Operativo/index/" ?>' + row.patient_id + '"> <button type="button" id="' + row.patient_id + '" data-toggle="modal" data-target="" class="ml-1 btn btn btn-primary rechazar btnborder pd-x-20"><i class="fa fa-folder-open"></button></a>'

             }
         }, */



        /*  {
             data: "id",
             render: function(data, type, row, meta) {
                 return '<a href="<?= base_url() . "/Hcv_Nota_Historia_Medica/index/" ?>' + row.patient_id + '/' + row.id + '"> <button type="button" id="' + row.patient_id + '" data-toggle="modal" data-target="" class="ml-1 btn btn btn-primary rechazar btnborder pd-x-20"><i class="fa fa-folder-open"></button></a>'

             }
         }, */
        {
            data: "status",
            render: function(data, type, row, meta) {
                return '<a href=" ' + BASE_URL + '/Administrativo/Pruebas_laboratorio/index/' + row.id + '"> <button type="button" id="' + row.id + '" data-toggle="modal" data-target="" class="ml-1 btn btn btn-success rechazar btnborder pd-x-20"><i class="fa fa-medkit"></button></a>'

                // return '<button type="button" id="'+ row.id +'" data-toggle="modal" data-target="" class="ml-1 btn btn btn-purple rechazar btnborder pd-x-20"><i class="fa fa-plus-circle"></i>ggg</button>'
            }
        },

        {
            data: "patient_id",
            render: function(data, type, row, meta) {
                return '<a href=" ' + BASE_URL + '/Operativo/Hcv_Localizacion/index/' + row.patient_id + '"> <button type="button" id="' + row.patient_id + '" data-toggle="modal" data-target="" class="ml-1 btn btn-teal rechazar btnborder pd-x-20"><i class="fa fa-map-marker"></i></button></a>'
            }
        },

        {
            data: 'observation'
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
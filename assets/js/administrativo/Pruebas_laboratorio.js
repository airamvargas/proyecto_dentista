$('#id_cita').val(id_cita);
var dataTable = $('#tbSolicitud').DataTable({
    ajax: BASE_URL + 'Administrativo/Rest_pruebas_lab/index/' + id_cita,

    columns: [{
        data: 'nombre'
    },
    {
        data: 'preparacion'
    },

    ],

    "searching": false,
    "dom": 'rtip',
    "paging": false

});

get_sel_estudio();


//SELECT ESTUDIOS//

function get_sel_estudio() {
    const estudios = BASE_URL + 'Administrativo/Rest_pruebas_lab/index/' + id_cita;
    var select = $('#studio');
    $.ajax({
        url: estudios,
        method: 'GET',
        dataType: 'json',
        success: function (data) {

            const ch = data['data'];
            $(ch).each(function (i, v) {
                console.log(data);
                $(select).append('<option  value="' + v.nombre + '" >' + v.nombre + '</option>');
            })

        },
        error: function (error) {
            // alert('hubo un error al enviar los datos');
        }
    });
}

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

//formulario


$(document).on('submit', '#form-archivos', function () {
    var formData = new FormData($(this)[0]);
    //document.getElementById("d_bancarios").click();
    const url = `${BASE_URL}Administrativo/Rest_pruebas_lab/pruebas`;

    //AJAX.
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                reloadData();
                document.getElementById('form-archivos').reset();
                
                Toastify({
                    text: data.messages.success,
                    duration: 3000,
                    className: "info",
                    // avatar: "../../assets/img/logop.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();

                $('#defaultOpen').attr('disabled', true);
                document.getElementById("d_bancarios").click();

            } else {
                Toastify({
                    text: data.messages.success,
                    duration: 3000,
                    className: "info",
                    // avatar: "../../assets/img/logop.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;

});



//tabla archivos//


var dataTable_files  = $('#datatable1').DataTable({
    ajax: BASE_URL + 'Administrativo/Rest_pruebas_lab/get_files/' + id_cita,

    columns: [{
        data: 'descripcion'
    },
    {
        data: 'name_foto',
        render: function(data, type, row, meta) {
            return '<a target="_blank" href="' + BASE_URL + '../../assets/img/' +row.id_folio + '-'+ row.id_patient+  '-'+ data +'" >' + '<i class="fa fa-file fa-3x" aria-hidden="true"></i>' + '</a>';
        }
    },
    {
        data: "id",
        render: function(data, type, row, meta) {
            return '<button id="' + row.id + '" data-toggle="modal" data-target="#modal_delete" class="btn btn-el btn-danger btnborder pd-x-20 ml-1 "><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'


        }
    },

    ],

    "searching": false,
    "dom": 'rtip',
    "paging": false

});

function reloadData() {
    $('#loader').toggle();
    dataTable_files.ajax.reload();
    $('#loader').toggle();
}

get_id();


function get_id() {
    $(document).on('click', '.btn-el', function() {
        let id_buton = $(this).attr('id');
        $('#id_delete').val(id_buton);

    });
}

sendFormDel();


function sendFormDel() {
    $(document).on('click', '#submit_form_del', function() {
       // $('#loader').toggle();
        var url_str = BASE_URL + '/Administrativo/Rest_pruebas_lab/delete_file';
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
            success: function(data) {
                if (data.status == 200) {
                    $('#modal_delete').modal('toggle');
                    reloadData();
                    Toastify({
                        text: data.messages.success,
                        duration: 3000,
                        className: "info",
                        // avatar: "../../assets/img/logop.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
    
                    }).showToast();
                } else {
                    Toastify({
                        text: data.messages.success,
                        duration: 3000,
                        className: "info",
                        // avatar: "../../assets/img/logop.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
    
                    }).showToast();
                }
                $('#loader').toggle();
               
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

//Terminar cita//

$('#terminar').on('click', function() {
    const url = `${BASE_URL}Administrativo/Rest_pruebas_lab/validar`;
    let data = {
        id_cita: id_cita,
    };
   
    $.ajax({
        url: url,
        type: "POST",
        dataType: 'json',
        data: JSON.stringify(data) ,
        success: function(result) {
            console.log(result);
          if(result){
            $('#show_success_modal').modal('toggle');

          }else{
            $('#show_error_modal').modal('toggle');
          }
        },
        error: function(xhr, resp, text) {
          
           $('#loader').toggle();
            $('#error-alert').show();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO'); 
           // $('#modal_delete').modal('toggle');
        }
    })

});


$('#terminar-cita').on('click', function() {
    var url_str = `${BASE_URL}Hcv_Nota_Medica/update_cita`;
    let data = {
        id_cita: id_cita,
    };
    console.log(data);
    $.ajax({
        url: url_str,
        type: "POST",
        dataType: 'json',
        data: data,
        success: function(result) {
            if (result.status == 200) {
                $('#success').text(result.msg);
                $('#succes-alert').show();
                location.href = BASE_URL + "Administrativo/Laboratorio";
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
    })

});


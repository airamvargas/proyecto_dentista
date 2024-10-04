
$(document).on('click', '#evidencia', function(){
    var evidencia = document.getElementById('descripcion');
    if(evidencia){
        $(".id_doctor").val(id_doctor);
        $(".id_patient").val(id_paciente);
        $(".id_folio").val(id_cita);
    }
});

//Datatable evidencias
var dataEvidencias = $('#crm_evidencias').DataTable({
    ajax: {
      url: `${BASE_URL}Api/HCV/Operativo/Nota_medica/showEvidencias`,
      data: {id_cita : id_cita},
      type: "POST",
    },
    lengthMenu: [
      [10, 25, 50, 100, 999999],
      ["10", "25", "50", "100", "Mostrar todo"],
    ],
    searching: false,
    paging: false,
    columns: [        
      {
        data: 'name_foto'
      },
      {
        data: 'descripcion'
      },
      {
        data: "name_foto",
        render: function(data, type, row, meta) {
          return `<div class="d-flex justify-content-center"><a href="${BASE_URL}../uploads/paciente/nota_medica/${data}" target="_blank"><button type="button" class="ml-1 btn btn btn-primary btn-circle btn-sm pd-x-20" title="Ver archivo"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`
        }
      },
      {
        data: "id",
        render: function(data, type, row, meta) {
            if(row.approved == 3){
                return ''
            } else {
                return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id + '"class="ml-1 btn btn btn-danger delete btn-circle btn-sm pd-x-20" title="Eliminar procedimiento"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
         
        }
      },
    ],
    language: {
      searchPlaceholder: 'Buscar...',
      sSearch: '',
      lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_evidencias_info").remove();

//FOTO DE PERFIL DE FICHA DE IDENTIFICACION DEL PACIENTE
$(document).on('change', '#evidencia', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var archivo = $(this)[0].files[0];

    if (filesCount === 1) {
        var reader = new FileReader();
        reader.readAsDataURL(archivo);
        var fileName = $(this).val().split('\\').pop();
        textbox.text(fileName);
        
    } else {
        textbox.text(filesCount + ' files selected');
    }
});

//Agregar una nueva evidencia
$(document).on('submit','#formEvidencias', function(){
    $('#loader').toggle();

    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/insertEvidencia`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("formEvidencias").reset();
                $("#file-msg").text('Arrastra el archivo aquí');
                reloadDataEvidencias();
                $('#loader').toggle();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;
                case 252:
                mensaje = "El tipo de archivo no es permitido";
                break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

//Obtener id de evidencia para eliminar
$(document).on('click', '.delete', function(){
    let id_evidencia = $(this).attr('id');
    $('#id_evidencia').val(id_evidencia);
    $("#modal_delete_evidencia").modal('toggle');
});

//Eliminar una evidencia
$(document).on('submit','#formDelEvidencia', function(){
    $('#loader').toggle();
    
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/deleteEvidencia`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $("#modal_delete_evidencia").modal('toggle');
                reloadDataEvidencias();
                $('#loader').toggle();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

//RELOAD datatable aceptadas
function reloadDataEvidencias() {
    $('#loader').toggle();
    dataEvidencias.ajax.reload();
    $('#loader').toggle();
}
/* Desarrollador: Airam Vargas
Fecha de creacion: 11 - octubre - 2023
Fecha de Ultima Actualizacion: 18 - 04 - 2024
Actualizo: Airam V. Vargas Lopez
Perfil: Capturista de resultados
Descripcion: Lista de las muestras que ya pueden capturarse sus resultados */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA
var dataTable = $('#crm_muestras_capturas').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: {},
        type:'post'
    },

    columns: [
        { 
            data: 'fecha',
            render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            }
        },
        { 
            data: 'unidad'
        },
        { 
            data: 'codigo'
        },
        { 
            data: 'estudio'
        },
        { 
            data: 'paciente'
        },
        { 
            data: 'id', 
            render: function(data, type, row, meta) {
                if(row.status_lab == 109){
                    return `<button data-cita="${data}" data-paciente="${row.id_user_client}" class="btn btn-success capturar solid pd-x-20 btn-circle btn-sm mr-2" title="Capturar los resultados"><i class="fa fa-list-alt fa-2x" aria-hidden="true"></i></button>
                    <button data-cita="${data}" data-paciente="${row.id_user_client}" class="btn btn-primary subir solid pd-x-20 btn-circle btn-sm mr-2" title="Subir archivo"><i class="fa fa-upload fa-2x" aria-hidden="true"></i></button>`
                } else {
                    return ``;
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

//ARCHIVO QUE SE VA A SUBIR
$(document).on('change', '#file_documento', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_documento").files[0];

    if (ext == "pdf") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato jpeg, png o jpg",
            duration: 3000,
            className: "info",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, 
                y: 90 
            },
        }).showToast();
    }
});

$(document).on('click', '.capturar', function() {
    let id_cita = $(this).data('cita');
    let id_paciente = $(this).data('paciente');
    window.open(`${BASE_URL}Resultados/Captura/datos/${id_cita}/${id_paciente}`, '_blank'); 
});

$(document).on('click', '.subir', function() {
    let id_cita = $(this).data('cita');
    let id_paciente = $(this).data('paciente');
    $("#id_paciente").val(id_paciente);
    $("#id_cita").val(id_cita);
    $('#subir_documento').modal('show');
});

//Enviar archivo de resultados
$(document).on('submit', '#formSubir', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Resultados/Captura/subirArchivo`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#subir_documento");
    let form = $("#formSubir");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//Envio de formulario POST 
let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form) : notificacion(response.msg, false)
    }).catch(err => alert(err));
}
 
//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }

    if (reload) {
        reload.ajax.reload();
    }

    if (modal) {
        $(modal.selector).modal('toggle');
    }

    if (form) {
        $(form.selector).trigger("reset");

    }

    Toastify({
        text: mensaje,
        duration: 3000,
        className: "info",
        avatar: imagen,
        style: {
            background: background
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();

    if(ref){
        setTimeout(() => {
            window.location.href = BASE_URL+ref;
        }, "1000");
    }
    $('#loader').toggle();
}


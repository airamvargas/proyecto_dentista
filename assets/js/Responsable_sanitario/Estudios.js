


// TABLA DE ESTUDIOS
dataTable = $("#datatable").DataTable({
    ajax: {
        url: BASE_URL + "Api/Responsable_sanitario/Muestras",
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: "id",
        },
        {
            data: "paciente"
        },
        {
            data: "estudio",
        },
        {
            data: "tipo_muestra",
        },
        {
            data: "unidad_negocio",

        },
        {
            data: "codigo",

        },

        {
            data: "fecha",
            render: function (data, type, row, meta) {
                return moment(data).format('L');    
            }
        },

        {
            data: "status_lab",
            render: function (data, type, row, meta) {
                status_lab = row.status_lab == null ? 0 : parseFloat(row.status_lab)
                bandera = row.bandera == null ? 0 : parseFloat(row.bandera);
                console.log(status_lab)
                switch (true) {
                    case (status_lab == 109 && bandera == 0):
                        return `<a href="${BASE_URL}Responsable_sanitario/Muestras/Resultados/${row.id}/${row.id_paciente}"><button title="Captura de resultados" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-text fa-2x" aria-hidden="true"></i></button></a> <button data-cita="${row.id}" data-paciente="${row.id_paciente}" class="btn btn-primary subir solid pd-x-20 btn-circle btn-sm mr-2" title="Subir archivo"><i class="fa fa-upload fa-2x" aria-hidden="true"></i></button>`;
                    
                    case (status_lab == 110 && bandera == 1):
                        return `<div class="d-flex justify-content-center"><button id="${row.id}" title="Reabrir Estudio" class="btn btn-dark btn-block re-open solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i></button>
                        <a target="_blank" href="${BASE_URL}Resultados/Resultados_pdf/imprimir/${row.id}"><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>`;

                    case (status_lab == 104):
                        return `<button id="${row.id}" title="Finalizar Estudio" class="btn btn-success acept solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-check fa-2x" aria-hidden="true"></i></button>
                        <a href="${BASE_URL}Responsable_sanitario/Muestras/Edit_results/${row.id}"><button title="Ver Resultados" class="btn btn-purple update solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a>`;
                    
                    case (status_lab == 110 && bandera == 2):
                        return `<div class="d-flex justify-content-center"><button id="${row.id}" title="Reabrir Estudio" class="btn btn-dark btn-block re-open solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i></button>
                        <a target="_blank" href="${BASE_URL}../../public/uploads/resultados/${row.documento}" download><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a>
                        <button id="${row.id}" data-paciente="${row.id_paciente}" title="Eliminar archivo" class="btn btn-danger btn-block eliminar-archivo solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button></div>`;

                    case (status_lab == 110 && bandera == 0):
                        return `<div class="d-flex justify-content-center"><button id="${row.id}" title="Reabrir Estudio" class="btn btn-dark btn-block re-open solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i></button>
                        <a target="_blank" href="${BASE_URL}Resultados/Resultados_pdf/imprimir/${row.id}"><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>`;

                }
            }
        },
    ],
    columnDefs: [
        {
            className: "text-justify space",
            targets: [7],
        },
    ],
    language: {
        searchPlaceholder: "Buscar...",
        sSearch: "",
        lengthMenu: "_MENU_ Filas por página",
    },
});

//boton del datable reopen
$(document).on('click', '.re-open', function () {
    let id = $(this).attr('id');
    $('#modal_abrir').modal('toggle');
    $("#id_citas").val(id);

});

//Reabrir estudio envio de formulario

$(document).on('submit', '#formDelete', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/reOpen`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $('#modal_abrir');
    send(url,FORMDATA,dataTable,modal,false,false);

});

$(document).on('click', '.acept', function () {
    let id = $(this).attr('id');
    $('#modal_acept').modal('toggle');
    $("#id_acept").val(id);
});

//aprobar cita
$(document).on('submit', '#formAcept', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/aprobar`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $('#modal_acept');
    send(url,FORMDATA,dataTable,modal,false,false);

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
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/subirArchivo`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#subir_documento");
    let form = $("#formSubir");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//Eliminar documento
$(document).on('click', '.eliminar-archivo', function() {
    let id_cita = $(this).attr('id');
    let id_paciente = $(this).data('paciente');
    $("#id_pacientedel").val(id_paciente);
    $("#id_delete").val(id_cita);
    $('#eliminar_documento').modal('show');
});

//Eliminar archivo de resultados
$(document).on('submit', '#formEliminarDoc', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/eliminarArchivo`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#eliminar_documento");
    let form = $("#formEliminarDoc");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

$(document).on('click', '#agregar_btn', function(){
    $("#modal_create").modal('toggle');
});
  
$(document).on('submit', '#registroPaciente', function(e) {
    e.preventDefault();
    //document.getElementById('btn_eliminar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Registro_paciente/registro_paciente`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#registroPaciente');
    let modal = $('#modal_create');
    send(url, FORMDATA, dataTable, modal, form);
});

/* TABLA DE PACIENTES */
var dataTable = $('#datatable').DataTable({

    ajax: {
        url: BASE_URL + '/Api/Pacientes/Registro_paciente/read',
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: 'nombre',
        },
        {
            data: 'f_nacimiento',
            render: function (data, type, row, meta) {
                return moment(data).format("DD-MMM-YYYY");
            }
        },
        {
            data: 'f_nacimiento',
            render: function (data, type, row, meta) {
                return moment(data).toNow(true); 
            }
        },
        {
            data: 'tel_casa',
        },
        {
            data: 'tel_cel',
        },
        {
            data: 'direccion',
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}Pacientes/Historia_clinica/index/${data}"><button title="Editar condiciones" class="btn btn-otro-circle up solid pd-x-20 btn-circle btn-sm" data-toggle="modal" data-target="#updateModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a></div>`
            }
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}Pacientes/Detalle_consultas/index/${data}"><button title="Ver detalle de citas" class="btn btn-primary up solid pd-x-20 btn-circle btn-sm" data-toggle="modal" data-target="#updateModal"><i class="fa fa-eye" aria-hidden="true"></i></button></a></div>`
            }
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"> <button id="' + data + '"" title="Editar condiciones" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" data-toggle="modal" data-target="#updateModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm" title="Eliminar condiciones" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//EDITAR DATOS 
$(document).on('click', '.up', function(){
    $('#loader').toggle();
    const url = `${BASE_URL}/Api/Pacientes/Registro_paciente/updatePaciente`;
    let id_paciente = $(this).attr('id');
    console.log(id_paciente);

    $.ajax({
        url: url,
        data: { id: id_paciente },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            $('#nombre').val(success[0].nombre);
            $('#sex').val(success[0].sex);
            $('#f_nacimiento').val(success[0].f_nacimiento);
            $('#lugar_nac').val(success[0].lugar_nac);
            $('#tel_casa').val(success[0].tel_casa);
            $('#tel_celular').val(success[0].tel_cel);
            $('#direccion').val(success[0].direccion);
            $('#id_update').val(id_paciente);
            $('#modal_update').modal('show');
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

$(document).on('submit', '#updatePaciente', function(e) {
    e.preventDefault();
    //document.getElementById('btn_eliminar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Registro_paciente/actualizar`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#updatePaciente');
    let modal = $('#modal_update');
    send(url, FORMDATA, dataTable, modal, form);
});

//ELIMINAR PACIENTE
$(document).on('click', '.delete', function(){
    let id_paciente = $(this).attr('id');
    $('#modal_delete').modal('show');
    $("#id_delete").val(id_paciente);
});

$(document).on('submit', '#eliminarPaciente', function(e) {
    e.preventDefault();
    //document.getElementById('btn_eliminar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Registro_paciente/eliminar`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#eliminarPaciente');
    let modal = $('#modal_delete');
    send(url, FORMDATA, dataTable, modal, form);
});


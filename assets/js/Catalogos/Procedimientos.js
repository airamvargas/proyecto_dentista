$(document).on('submit', '#formProcedimiento', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Catalogos/Procedimientos/add_procedimiento`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#formProcedimiento');
    let modal = $('#myModal');
    send(url, FORMDATA, procedimientos, modal, form);
});

/* TABLA DE PACIENTES */
var procedimientos = $('#procedimientos').DataTable({

    ajax: {
        url: BASE_URL + '/Api/Catalogos/Procedimientos/read',
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
            data: 'observaciones',
        },
        {
            data: 'precio',
            render: function(data, tyoe, row, meta){
                return currency(data, { separator: ',', symbol: '$' }).format();
            }
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"> <button id="' + data + '" title="Editar condiciones" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-pencil" aria-hidden="true"></i></button>' +
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

/* BOTON DE EDITAR, OBTENER ID Y DATOS */
$(document).on('click', '.up', function() {
    let id = $(this).attr('id');
    let url =  `${BASE_URL}/Api/Catalogos/Procedimientos/readProcedimientoUp`;

    $.ajax({
        url: url,
        data: { id: id},
        method: 'post',
        dataType: 'json',
        success: function(success) {
            $("#nombre_proc").val(success[0].nombre	);
            $("#precio").val(success[0].precio	);
            $("#observacion").val(success[0].observaciones);
            $("#id_update").val(success[0].id);
            $('#updateModal').modal('show');
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

$(document).on('submit', '#formUpdate', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Catalogos/Procedimientos/update_`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#formUpdate');
    let modal = $('#updateModal');
    send(url, FORMDATA, procedimientos, modal, form);
});

//BTN DELETE
$(document).on('click', '.delete', function(){
    let producto = $(this).attr('id');
    $("#id_delete").val(producto);
    $('#modal_delete').modal('toggle');
});

$(document).on('submit', '#formDelete', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Catalogos/Procedimientos/delete_`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#formDelete');
    let modal = $('#modal_delete');
    send(url, FORMDATA, procedimientos, modal, form);
});
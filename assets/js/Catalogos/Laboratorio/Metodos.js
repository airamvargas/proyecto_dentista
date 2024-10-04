/*
Desarrollador: Airam Valeria Vargas López
Fecha Creacion: 07 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administracion
Descripcion: Catalogo de métodos que pueden utilizarse
*/

//datos del datatable
var dataTable = $('#crm_methods').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/`,
        data: {},
        type: "post",
    },

    columns: [
        {
            data: 'id',

        },
        {
            data: 'name',

        },
        {
            data: 'description'
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },
    ],

    "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
        },
        { className: "wrapbox", "targets": [ 1 ] },
        { className: "wrapbox", "targets": [ 2 ] },
      ], 

    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});

//obtenemos los datospara editar campos
$(document).on('click', '.update', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readMethod`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            var keys = Object.keys(success[0]);
            keys.forEach(element => {
                $('#' + element).val(success[0][element]);
            });
            $('#loader').toggle();
            $('#updateModal').modal('show');
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});
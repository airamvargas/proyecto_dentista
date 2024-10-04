var dataTable = $('#crm_categoria_estudios').DataTable({
    order: [[0, 'asc']],

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readCategory`,
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'id',
        },
        {
            data: 'name',
        },
        { 
            data: 'description',
        },

        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button id="' + data + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },

    ],
    "columnDefs": [
    {
      "targets": [0],
      "visible": false,
      "searchable": false
    },
    { className: "wrapbox", "targets": [ 2 ] },
  ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* OBTENER DATOS DE EXAMEN*/
$(document).on('click', '.update', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readExam`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $('#nameCategory').val(success[0].name); 
            $('#description').val(success[0].description);
            $('#idCategory').val(success[0].id); 
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});
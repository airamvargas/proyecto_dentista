/*TABLA DE CATEGORIAS*/

var dataTable = $('#tb_categoria').DataTable({

    ajax: {
        url:BASE_URL + '/Api/Catalogos/Categorias/read',
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [{
            data: 'name',
        } ,
        { 
            data: 'description',
        },

        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex flex-column flex-md-row justify-content-center"><button id="' + data + '" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2 mt-sm-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2 mt-sm-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },

    ],
    "columnDefs": [
        
        { className: "wrapbox", "targets": [ 1 ] },
        
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* OBTENER DATOS DE CATEGORIAS*/
$(document).on('click', '.up', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/Catalogos/Categorias/readCategoria`;
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
/*TABLA DE PADECIMIENTOS CRONICOS*/

var dataTable = $('#tb_categoria').DataTable({

    ajax: {
        url:BASE_URL + '/Api/Catalogos/ChronicDesseases/read',
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
            data: 'description'
        },

        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20"><i class="fa fa-pencil" aria-hidden="true"></i> EDITAR</button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 "><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },

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
    const url = `${BASE_URL}Api/Catalogos/ChronicDesseases/readChronicDesseases`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $('#nameChronicDessease').val(success[0].name); 
            $('#description').val(success[0].description);
            $('#idChronicDessease').val(success[0].id); 
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});
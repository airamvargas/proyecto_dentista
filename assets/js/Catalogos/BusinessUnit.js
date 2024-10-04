/*TABLA DE UNIDAD DE NEGOCIO*/

var dataTable = $('#tb_categoria').DataTable({

    ajax: {
        url:BASE_URL + '/Api/Catalogos/BusinessUnit/read',
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
            data: 'start_time'
        },
        { 
            data: 'final_hour'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button id="' + data + '"" class="btn btn-primary add solid pd-x-20 btn-circle btn-sm mr-2" title="Agregar productos"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>' + 
                '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },

    ],
    "columnDefs": [
        { className: "wrapbox", "targets": [ 0 ] },
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
    const url = `${BASE_URL}Api/Catalogos/BusinessUnit/readBusinessUnit`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $('#nameBusinessUnit').val(success[0].name); 
            $('#description').val(success[0].description);
            $('#hora_inicio').val(success[0].start_time);
            $('#hora_fin').val(success[0].final_hour);
            $('#idBusinessUnit').val(success[0].id); 
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

/* BTN AGREGAR PEODUCTOS */
$(document).on('click', '.add', function() {
    let id = $(this).attr('id');
    location.href = `${BASE_URL}Catalogos/BusinessUnit/add_products/${id}`;
});
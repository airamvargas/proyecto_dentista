//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLAS DE CLIENTES 

var dataTable = $('#datatable1').DataTable({

    ajax: BASE_URL + 'Administrador/Clientes/getClientes',

    columns: [
        {
            data: "created_at",
            render: function(data, type, row, meta) {
                return moment(data).format("DD/MM/YY");
            }
        },

       // {data: 'created_at'},
        {data: 'business_name'},
        {
            data: 'razon_social',
            render: function(data, type, row, meta) {
                return '<p class="text-left" id="' + row.razon_social + '">' + row.razon_social + '</p>'
            }
        },
        {data: 'name'},
        {data: 'numero_serie'},
        {data: 'model'},
        {data: 'ability'},
        {data: 'price',
        render: function (data, type, row, meta) {
            return '<p>' + currency(data).format() + '</p>'
        }
    },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<a href="'+BASE_URL+'Administrador/Imagenes_avance/imagenes/'+data+'">  <button id="' + data + '"" class="btn btn-primary up solid pd-x-20"><i class="fa fa-picture-o" aria-hidden="true"></i> VER IMAGENES</button></a>';
            }
        },
        

    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    lengthMenu: [
        [50, 10, 25, 100, 999999],
        ["50", "10", "25", "100", "Mostrar todo"],
      ],

    //delete cotization 
    
});

//get id
$(document).on('click', '.delete', function() {
    let product = $(this).attr('id');
    $('#modal_delete').modal('toggle');
    $("#id_delete").val(product);

});






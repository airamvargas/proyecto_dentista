
getWaytopay();

function getWaytopay(){

    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/getWaytopay`;
    var select = $(".forma-pago");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
                select.append(`<option  value=""> SELECCIONA FORMA DE PAGO </option>`);
                $(data).each(function (i, v) {
                    select.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
                });
                $('#loader').toggle();

            }else{
                $('#loader').toggle();
                Swal.fire({
                    icon: 'error',
                    title: 'No se encontraron unidades de negocio',
                    //text: 'Agrege una unidad negocio',
                    html: '<a href="'+BASE_URL+'Catalogos/Waytopay">AGREGAR FORMA DE PAGO</a>',
                    showConfirmButton: false,
                  });
            }
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}








/*TBLA JQUERY*/
var dataTable = $('#datatable').DataTable({

    ajax: {
        // url:BASE_URL + '/Catalogos/Categorias/read',
        url: `${BASE_URL}${CONTROLADOR}/read`,
        data: {},
        type: "post",
    },


    columns: [
        {
            data: 'id',
        },

        {
            data: 'forma_pago',

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
                return '<button title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },

    ],
    "columnDefs": [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ], 
    order: [[0, 'desc']],
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});


/* get data modal update*/
$(document).on('click', '.up', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readwaytopay`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            // return index
            var keys = Object.keys(success[0]);
            //console.log(keys);
            keys.forEach(element => {
                console.log(element);
                $('#' + element).val(success[0][element]);
            });
            $('#loader').toggle();
            $('#updateModal').modal('show');


            /*   $('#name').val(success[0].name);
              $('#description').val(success[0].description);
              $('#id').val(success[0].id);
              $('#updateModal').modal('show'); */
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});
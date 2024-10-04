/* 
Desarrollador: Jesus Esteban Sanchez Alcantara
Fecha Creacion: 8-septiembre-2023
Fecha de Ultima Actualizacion: 8-septiembre-2023
Perfil: Administracion
Descripcion: Catalogo de unidades de medicion 
*/

//TABLA DE UNIDADES
var dataTable = $('#tb_unidades').DataTable({
    ajax: {
        url:BASE_URL + '/Api/Catalogos/Laboratorio/Unidades_medicion/read',
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: 'name',
        } ,
        { 
            data: 'prefix',
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },
    ],
    "columnDefs": [{
        className: "text-justify space wrapbox",     
        "targets": [1],
      },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

// OBTENER DATOS DE MUESTRAS A PONERLOS EN EL MODAL DE EDITAR
$(document).on('click', '.up', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/Catalogos/Laboratorio/Unidades_medicion/getMedicion`;
    let unidad = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: unidad },
        method: 'post', 
        dataType: 'json',
        success: function(success) {
            $('#upd_nombre').val(success[0].name); 
            $('#upd_prefijo').val(success[0].prefix);
            $('#idUnidad').val(success[0].id); 
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});




// Shorthand for $( document ).ready()



/*TBLA JQUERY*/
var dataTable = $('#datatable').DataTable({

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/read`,
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
            data: 'active',
            render: function(data,type,row,meta){
                return data == 1 ? `<p>Activo</p>` :  `<p>Desactivado</p>`

            }
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<a href="'+BASE_URL+'Administrador/Access/index/'+data+'"><button  title="Agregar Accessos"  class="btn btn-success  solid pd-x-20 btn-circle btn-sm"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>' + " "+
                '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
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
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});


/* get data modal update*/
$(document).on('click', '.up', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readGroups`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            // return index
            var keys = Object.keys(success[0]);
            keys.forEach(element => {
                console.log(element);
                $('#' + element).val(success[0][element]);
            });
            $('#loader').toggle();
            $('#updateModal').modal('show');
            //character = "cho";
           
            //$('input[type="search"]').val("cho").jQuery.event.trigger({ type : 'keypress', which : character.charCodeAt(0) }); 


            //$('input[type="search"]').trigger({ type : 'keypress', which : character.charCodeAt(0) });
            //$('input[type="search"]').val("cho");
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

/* function simulateKeyPress(character) { 
    jQuery.event.trigger({ type : 'keypress', which : character.charCodeAt(0) }); 
  } 
 */



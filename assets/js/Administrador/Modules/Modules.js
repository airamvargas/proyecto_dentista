

// Shorthand for $( document ).ready()
getGrupos();

function getGrupos() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/getGrupos`;
    var select = $(".id_group_module");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#loader').toggle();
            select.append(`<option  value=""> SELECCIONA UN MODULO </option>`);
            $(data).each(function (i, v) {
                select.append(`<option  value="${v.id}" title="${v.description}"> ${v.name}</option>`);
            })

        },
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;

        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: "../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
}

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
            data: 'grupo',

        },
        {
            data: 'name',

        },
        {
            data: 'description'
        },
        {
            data: 'controller'
        },
        {
            data: 'active',
            render: function(data,type,row,meta){
                return data == 1 ? `<p>Activo</p>` :  `<p>Desactivado</p>`

            }
        },

        {
            data: 'phase',
            render: function(data,type,row,meta){
                return data == 1 ? `<p>Activo</p>` :  `<p>Desactivado</p>`

            }
        },

        {
            data: 'show_in_menu',
            render: function(data,type,row,meta){
                return data == 1 ? `<p>Sí</p>` :  `<p>No</p>`

            }
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
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
    const url = `${BASE_URL}${CONTROLADOR}/readModules`;
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



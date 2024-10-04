
showModules();

function showModules() {
    const URL = `${BASE_URL}${CONTROLADOR}/readModules`;
    var modules = $(".modules");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data)
            modules.append(`<option value=" ">SELECCIONA MODULO</option>`);
            $(data).each(function (i, v) {
                modules.append(`<option value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}





/*TBLA JQUERY*/
var dataTable = $('#datatable').DataTable({

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}`,
        data: { id: id },
        type: "post",
    },

    columns: [
        {
            data: 'rol',

        },
        {
            data: 'Category',

        },
        {
            data: 'name',

        },
        {
            data: 'create_a',
            render: function (data, type, row, meta) {
                return data == "0" ? '<i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color: red;"></i>' :
                    '<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: green;"></i>'
            }
        },
        {
            data: 'read_a',
            render: function (data, type, row, meta) {
                return data == "0" ? '<i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color: red;"></i>' :
                    '<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: green;"></i>'
            }
        },
        {
            data: 'update_a',
            render: function (data, type, row, meta) {
                return data == "0" ? '<i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color: red;"></i>' :
                    '<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: green;"></i>'
            }
        },
        {
            data: 'delete_a',
            render: function (data, type, row, meta) {
                return data == "0" ? '<i class="fa fa-times-circle fa-2x" aria-hidden="true" style="color: red;"></i>' :
                    '<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: green;"></i>'
            }
        },


        {
            data: "id_module",
            render: function (data, type, row, meta) {
                return '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },
    ],
    /* 
        "columnDefs": [
            {
              "targets": [0],
              "visible": false,
              "searchable": false
            }
          ],  */

    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});


$(document).on('click', '.up', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/read`;
    let id_module = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id, id_module:id_module },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            // return index
            success[0].create_a === "1" ? $("#crear").prop("checked", true) : $("#crear").prop("checked", false);
            success[0].read_a === "1" ? $("#leer").prop("checked", true) : $("#leer").prop("checked", false);
            success[0].update_a === "1" ? $("#actualizar_").prop("checked", true) : $("#actualizar_").prop("checked", false);
            success[0].delete_a === "1" ? $("#eliminar_").prop("checked", true) : $("#eliminar_").prop("checked", false);
            $('#id_module').val(success[0].id_module);
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



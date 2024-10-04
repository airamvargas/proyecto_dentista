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
            data: 'NOMBRE',

        },
        {
            data: 'common_name'
        },
        {
            data: 'name'
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button title="EDITAR" id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' + " "+
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm "><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
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
    scrollX: true,
    responsive: false,
    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$( "#btn-add" ).click(function() {
    $(".create-searup").removeAttr("id");
    $(".create-sear").attr('id', 'autoComplete');
    $(".id_c10").val("");
    autoComplete_();
});


/* get data modal update*/
$(document).on('click', '.up', function () {
    $('#loader').toggle();
    $(".create-sear").removeAttr("id");
    $(".create-searup").attr('id', 'autoComplete');
    autoComplete_();
    const url = `${BASE_URL}${CONTROLADOR}/readDisease`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post',
        dataType: 'json',
        success: function (success) {
            $('#common_name').val(success[0].common_name);
            $('.id_c10').val(success[0].id_c10);
            $('.tipo').val(success[0].id_cat_illness_type);
            $('.create-searup').val(success[0].NOMBRE);
            $('#id').val(success[0].id);
            $('#updateModal').modal('show'); 
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});








get_IllnessType();
function get_IllnessType() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/redIllnessType`;
    var select = $(".tipo");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#loader').toggle();
            select.append(`<option  value=""> SELECCIONA UNA CATEGORIA </option>`);
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

function autoComplete_(){


const autoCompleteJS = new autoComplete({
    placeHolder: "Busca enfermedad ...",
    threshold: 2,
    diacritics: true,
    data: {
        src: async (query) => {
            try {
                const source = await fetch(`${BASE_URL}${CONTROLADOR}/getC10/${query}`);
                const data = await source.json();
                return data;

            } catch (error) {
                return error;
            }
        },
        keys: ["NOMBRE", "ID"],
    },

    resultsList: {
        tag: "ul",
        id: "autoComplete_list",
        class: "results_list",
        destination: "#autoComplete",
        position: "afterend",
        maxResults: 100,
        noResults: true,
        element: (list, data) => {
            if(!data.results.length){
                const message = document.createElement("div");
                message.setAttribute("class", "no_result");
                message.innerHTML = `<span>Ningún resultado para "${data.query}"</span>`;
                list.appendChild(message);
            }
            list.setAttribute("data-parent", "food-list");
        },
    },

    resultItem: {
        highlight: true,
        element: (item, data) => {
            item.innerHTML = `
            <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
            ${data.match}
          </span>
            
        <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
      </span>`;
        },

    },
    events: {
        input: {
            selection: (event) => {
                $("#autoComplete").val(event.detail.selection.value.NOMBRE);
                $(".id_c10").val(event.detail.selection.value.ID);
                $(".common").val(event.detail.selection.value.NOMBRE);
            }
        }
    }
});

}
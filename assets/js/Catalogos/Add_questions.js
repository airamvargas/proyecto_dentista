/* Desarrollador: Giovanni Zavala Cortes
Fecha de creacion:30/08/2023
Fecha de Ultima Actualizacion: 30/08/2023 
Perfil: Administrador
Descripcion: Catalogo de asignacion de preguntas al estudio */


autoComplete_input();

//Auto complete por preguntas
function autoComplete_input() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "Buscar preguntas...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(`${BASE_URL}Searchs/Rest_search/readQuestions/${query}`);
                    const data = await source.json();
                    return data;

                } catch (error) {
                    return error;
                }
            },
            keys: ["question"],
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
                if (!data.results.length) {
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}".</span> `;
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
                </span>`;
            },

        },

        events: {
            input: {
                selection: (event) => {
                    console.log(event.detail.selection);
                    $("#autoComplete").val(event.detail.selection.value.question);
                    $("#id_question").val(event.detail.selection.value.id);
                    //$("#id_study").val(id_study);
                }
            }
        }
    });
}

//DATATABLE
dataTable = $('#datatb').DataTable({
    ajax: {
        url: `${BASE_URL}Api/Catalogos/Add_questions`,
        data: { 'id': id_study },
        type: "post",
    },

    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'name',
        },
        {
            data: 'question',
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },

    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$("#autoComplete").on("keyup", function () {
    $('#id_question').val("");
});

$(document).on('click', '#terminar', function() {
    $('#loader').toggle();
    location.href = `${BASE_URL}Catalogos/Estudios`;
    $('#loader').toggle();
});

//FOMULARIO CREATE 
$(document).on('submit', '#form_add', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let id = $('#id_question').val();
    if (id.length <= 0) {
        notificacion("SELECIONA UNA PREGUNTA", false)
    } else {
        let url = `${BASE_URL}Api/Catalogos/Add_questions/create`;
        let FORMDATA = new FormData($(this)[0])
        let modal = $('#myModal');
        let form = $('#form_add');
        send(url, FORMDATA, dataTable, modal, form);
    }
});

//MANDAMOS EL ID AL FORM PARA ELIMINAR 
$(document).on('click', '.delete ', function () {
    let id = $(this).attr('id');
    $('#id_delete').val(id);
    $('#modal_delete').modal('show');
});

//ELIMINACION DE LA PREGUNTA
$(document).on('submit', '#form_delete_question', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Catalogos/Add_questions/deleteQuestion`;
    let FORMDATA = new FormData($(this)[0])
    let modal = $('#modal_delete');
    send(url, FORMDATA, dataTable, modal);
});

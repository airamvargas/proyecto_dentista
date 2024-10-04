get_groups();
autoComplete_input();


//OBTENER VALOR DEL SELECT DE CATEGORIA
$(document).on('change', '.categoria', function(){
    ID_CAT = $(this).val();
});

var dataTable = $('#crm_studies_x_packet').DataTable({

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: {'id_packet' : id_packet},
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
            data: 'packet', 
        },
        {
            data: 'study', 
        },
        {
            data: 'category_lab', 
        },
        {
            data: 'preparation', 
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
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

//$("#crm_studies_x_packet_info").hide();

/* BTN REGRESAR*/
$(document).on('click', '#terminar', function () {
    location.href = `${BASE_URL}Catalogos/Paquetes`;
});

/*ADD PRODUCTS*/
$(document).on('submit', '#form_add', function () {
    $('#myModal').modal('toggle');
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/insert_study`
    
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("form_add").reset();
                reloadData();
            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#myModal').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
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
            avatar: "../../../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

/*DELETE*/
$(document).on('submit', '#form_delete_study', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/delete_study`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 200) {
                $('#loader').toggle();
                //notification library
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                reloadData();
            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();
                $('#modal_delete').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
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
            avatar: "../../../../..//assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

//OBTENER GRUPOS O AREAS PARA SELECT
function get_groups(){
    const url = `${BASE_URL}Api/Catalogos/Grupos_estudios/get_groups`;
    var grupos = $(".categoria");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            grupos.append(`<option  value=""> SELECCIONA UN GRUPO</option>`);
            $(data).each(function(i, v) {
                grupos.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//FUNCION PARA EL INPUT DE AUTOCOMPLETE
function autoComplete_input() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "Buscar estudio...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(`${BASE_URL}Searchs/Rest_search/readStudies/${query}/${ID_CAT}`);
                    const data = await source.json();
                    return data;
                    
                } catch (error) {
                    return error;
                }
            },
            keys: ["study"],
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
                    $("#autoComplete").val(event.detail.selection.value.study);
                    $("#id_study").val(event.detail.selection.value.id_product);
                    $("#id_packet ").val(id_packet);
                }
            }
        }
    });
}
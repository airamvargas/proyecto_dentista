readCategorias();
autoComplete_input();

const input = document.getElementById("autoComplete");

//OBTENER VALOR DEL SELECT DE CATEGORIA DE PRODUCTOS
$(document).on('change', '.categoria', function(){
    ID_CAT = $(this).val();
});

var dataTable = $('#crm_products_x_unit').DataTable({

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: {'id_unidad' : id_unidad},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'unidad', 
        },
        {
            data: 'categoria', 
        },
        { 
            data: 'producto'
        },
        { 
            data: 'price', 
            render: function(data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format()
            }
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="row  justify-content-center">'+ '<button id="' + data + '" data-unit="'+id_unidad+'" data-index="'+row.id_product+'" class="btn btn-primary price solid pd-x-20 btn-circle btn-sm mr-2" title="Asignar precio"><i class="fa fa-usd fa-2x" aria-hidden="true"></i></button>' +'<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>' +
                '</div>'
            }
        },

    ],
   
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*ADD PRODUCTS*/
$(document).on('submit', '#form_add', function () {
    $('#myModal').modal('toggle');
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/create_product`
    
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
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
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
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
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
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
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
$(document).on('submit', '#form_delete_product', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/delete_product`;
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
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
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
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
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
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
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

/* DEFINIR PRECIO */
$(document).on('click', '.price', function() {
    $('#loader').toggle()
    let id = $(this).attr('id');
    let product = $(this).data('index');
    let unit = id_unidad
    const url = `${BASE_URL}${CONTROLADOR}/sumStudies`;
    $('#id_price').val(id); 
    $.ajax({
        url: url,
        data: { id: id, product: product, unit: unit},
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $("#n_producto").children().remove();
            $("#texto-precio").children().remove();
            if(success[0]['name']){
                $("#n_producto").append(`<span>${success[0]['name']}</span>`);
            } else{
                $("#texto-precio").append(`<h6>SUMA TOTAL POR PRECIO DE CADA ESTUDIO: ${currency(success[0]['suma'], { symbol: "$", separator: "," }).format()}</h6>`);
                $("#n_producto").append(`<span>${success[0]['packet']}</span>`);
            }
            $("#price_fij").val(currency(success[0]['price'], { symbol: "", separator: "," }).format());
            $('#modal_price').modal('show');
            $('#loader').toggle(); 
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

/*ASIGNAR PRECIO*/
$(document).on('submit', '#form_price', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/updatePrice`
    
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
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#modal_price').modal('toggle');
                document.getElementById("form_price").reset();
                reloadData();
            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/correcto.png`,
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
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
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

//Cambiar el precio a formato currency
$(document).on('change', "#precio", function(){
    let precio = parseFloat($(this).val());
    //console.log()
    $("#precio").val(currency(precio, { symbol: "", separator: "" }).format());
});

$(document).on('change', "#price_fij", function(){
    let precio = parseFloat($(this).val());
    //console.log()
    $("#price_fij").val(currency(precio, { symbol: "", separator: "" }).format());
});

//BOTON PARA DESCARGAR CSV
$(document).on('click', '#down_csv', function(){
    const url = `${BASE_URL}${CONTROLADOR}/down_csv/${id_unidad}`;
   
    //AJAX.
    $.ajax({
        url: url,
        type: 'POST',
        success: function(result) {
            const blob = new Blob(["\uFEFF"+result], { type: 'text/csv; charset=utf-8' });
            const downloadUrl = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = downloadUrl;
            a.download = "Productos_x_unidad.csv";
            document.body.appendChild(a);
            a.click(); 
        }
        
    });
    return false;
});


//FUNCION PARA EL INPUT DE AUTOCOMPLETE
function autoComplete_input() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "Buscar producto...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(`${BASE_URL}Searchs/Rest_search/readProductsCategoria/${query}/${ID_CAT}`);
                    const data = await source.json();
                    return data;
                    
                } catch (error) {
                    return error;
                }
            },
            keys: ["name"],
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
                    $("#autoComplete").val(event.detail.selection.value.name);
                    $("#id_product").val(event.detail.selection.value.id);
                    $("#id_unidad").val(id_unidad);
                }
            }
        }
    });
}

//OBTENER LAS CATEGORIAS DE PRODUCTO
function readCategorias() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/Products/readCategoria`;
    var empresas = $(".categoria");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            empresas.append(`<option  value=""> SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}
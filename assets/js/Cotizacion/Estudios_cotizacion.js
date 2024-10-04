//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

$("#div_unit").hide();
readConvenios();
readCategorias();

const selector = document.getElementById("categoria");
const convenio = document.getElementById("beneficio");
const input = document.getElementById("autoComplete");
const unidad = document.getElementById("unidad");

$("#id_cotization").val(id_cotizacion);
$("#cliente").append(`<span>${name_user}</span>`);

if (id_group == 6) {
    obtenerUnidad();
    $("#div_unit").show();
    $(document).on('change', '#unidad', function () {
        UNIDAD = unidad.value;
        input.value = "";
        document.getElementById("precio").value = "";
        document.getElementById("precio_convenio").value = "";
        document.getElementById("precio_final").value = "";
    });

} else {
    $("#div_unit").hide();
    UNIDAD = 0;
}

$(document).on('change', '#categoria', function () {
    ID_CAT = selector.value;
    input.value = "";
    document.getElementById("precio").value = "";
    document.getElementById("precio_convenio").value = "";
    document.getElementById("precio_final").value = "";
});

$(document).on('change', '#cantidad', function(){
    precio = $("#precio_final").val();
    newPrice = precio.replace("$", "");
    newPrice2 = newPrice.replace(",", "");
    cantidad = parseFloat($(this).val());
    priceFinal = parseFloat(newPrice2) * cantidad;
    $("#precio_final").val(currency(priceFinal, { symbol: "$", separator: "," }).format())
});

$(document).on('change', '#beneficio', function () {
    $('#loader').toggle();
    ID_CONV = convenio.value;
    const FORMDATA = new FormData();
    FORMDATA.append("id_delete_all", id_cotizacion);

    const URL = `${BASE_URL}${CONTROLADOR}/delete_all`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                if (data.msg == 210) {
                    $('#loader').toggle();
                } else {
                    //notification library
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: "../../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    $('#loader').toggle();
                }

                reloadData();
                input.value = "";
                document.getElementById("precio").value = "";
                document.getElementById("precio_convenio").value = "";
                document.getElementById("precio_final").value = "";

            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();
                $('#delete_productos').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

const autoCompleteJS = new autoComplete({
    placeHolder: "Buscar producto...",
    threshold: 2,
    diacritics: true,
    data: {
        src: async (query) => {
            try {
                const source = await fetch(`${BASE_URL}Searchs/Rest_search/readProductsCotization/${query}/${ID_CAT}/${ID_CONV}/${UNIDAD}`);
                const data = await source.json();
                return data;

            } catch (error) {
                return error;
            }
        },
        keys: ["name", "price"],
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
            ${data.match} - $${data.value.price}
            </span>`;
        },

    },

    events: {
        input: {
            selection: (event) => {
                $('#loader').toggle();
                var tabla = event.detail.selection.value.name_table;
                if (tabla == "cat_packets") {
                    let id_packet = event.detail.selection.value.id_product;
                    const url = `${BASE_URL}Api/Catalogos/Paquetes/show`;

                    $.ajax({
                        url: url,
                        data: { id_packet: id_packet },
                        method: 'post', //en este caso
                        dataType: 'json',
                        success: function (success) {
                            $("#incluye").children().remove();
                            incluye = `<h5 class="ml-4">Incluye: </h5>
                            <ul id="ul_incl"></ul>`
                            $("#incluye").append(incluye);
                            $(success['data']).each(function (i, v) {
                                let studies = `<li>${v.study}</li>`;
                                $("#ul_incl").append(studies);
                            });
                        },
                        error: function (xhr, text_status) {
                            $('#loader').toggle();
                        }
                    });
                } else {
                    $("#incluye").children().remove();
                }
                var precioR = event.detail.selection.value.price;
                $("#autoComplete").val(event.detail.selection.value.name);
                $("#id_product").val(event.detail.selection.value.id);
                $("#precio").val(currency(precioR, { symbol: "$", separator: "," }).format());
                var id_condicion = event.detail.selection.value.tipo_condicion;
                let precio_fin = parseFloat(precioR) - parseFloat(precioR);
                
                switch (id_condicion) {
                    case "5": //PORCENTUAL
                        let precio_final = event.detail.selection.value.price * ((100 - event.detail.selection.value.valor_condicion) / 100);
                        $("#precio_convenio").val(event.detail.selection.value.valor_condicion + "%");
                        $("#precio_final").val(currency(precio_final, { symbol: "$", separator: "," }).format());
                        break;
                    case "6": //BOLSA DE EFECTIVO 
                        $("#precio_convenio").val("BOLSA EFECTIVO");
                        $("#precio_final").val(currency(precio_fin, { symbol: "$", separator: "," }).format());
                        break;
                    case "7": //CANTIDAD/GRATIS
                        $("#precio_convenio").val("GRATUITO");
                        $("#precio_final").val(currency(precio_fin, { symbol: "$", separator: "," }).format());
                        break;
                    case "11": //PRECIO FIJO
                        $("#precio_convenio").val("PRECIO FIJO");
                        $("#precio_final").val(currency(event.detail.selection.value.precio_convenio, { symbol: "$", separator: "," }).format());
                    break;
                    default:
                        $("#precio_convenio").val("--");
                        $("#precio_final").val(currency(precioR, { symbol: "$", separator: "," }).format());
                }
                $('#loader').toggle();
            }
        }
    }
});

/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_estudios').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readCotizationxProducts`,
        data: { 'id': id_cotizacion },
        type: "post",
    },
    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [{
        data: 'name',

    },
    {
        data: 'id',
        render: function (data, type, row, meta) {
            if (row.product_des == null && row.study_des == null) {
                return row.packet_des
            } else if (row.product_des == null && row.packet_des == null) {
                return row.study_des
            } else {
                return row.product_des
            }
        }
    },
    {
        data: 'price',
        render: function (data, type, row, meta) {
            return currency(data, { symbol: "$", separator: "," }).format();
        }
    },
    {
        data: 'cantidad'
    },
    {
        data: "id",
        render: function (data, type, row, meta) {
            return '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'

        }
    },
    ],
    ordering: false,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$("#crm_estudios_info").hide();

/*AGREGAR ESTUDIOS A LA COTIZACION */
$(document).on('submit', '#insert_cotization', function () {
    //$('#loader').toggle();
    var formData = new FormData();

    let precio = $('#precio_final').val();
    let id_producto = $('#id_product').val();
    let cantidad = $('#cantidad').val();
    let unidad = $('#unidad').val();

    formData.append("precio", precio);
    formData.append("id_cat_products", id_producto);
    formData.append("id_cotization", id_cotizacion);
    formData.append('id_conventions', ID_CONV);
    formData.append('cantidad', cantidad);
    formData.append('unidad', unidad);

    const URL = `${BASE_URL}${CONTROLADOR}/createCotzationProduct`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
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
                document.getElementById('autoComplete').value = "";
                document.getElementById('precio').value = "";
                document.getElementById('precio_convenio').value = "";
                document.getElementById('precio_final').value = "";
                document.getElementById("agregar").disabled = false;
                reloadData();
                //$('#loader').toggle();

            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("form-update").disabled = false;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/* BTN CANCELAR */
$(document).on('click', '#cancelar', function () {
    let url = `${BASE_URL}${CONTROLADOR}/terminarCotizacion`;
    let FORMDATA = new FormData()
    FORMDATA.append('id', id_cotizacion);
    fetch(url, {
        method: "POST",
        body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if(response.status == 200){
                location.href = `${BASE_URL}Cotizaciones`;
            }
            $("#loader").toggle();
    }).catch(err => alert(err))
    
});

/* BTN CONTINUAR AGENDAR CITAS  */
$(document).on('click', '#continuar', function () {
    let total = $("#total_precio").val();

    if (total == "") {
        Toastify({
            text: "Para continuar debes agregar por lo menos un producto/servicio",
            duration: 3000,
            className: "info",
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    } else {
        location.href = `${BASE_URL}Cotizaciones/agendar_citas/${id_cotizacion}`;
    }
});

/* BTN ENVIAR CORREO */
$(document).on('click', '#enviar', function () {
    $('#loader').toggle();
    let total = $("#total_precio").val();
    if (total == "") {
        Toastify({
            text: "No hay datos para enviar",
            duration: 3000,
            className: "info",
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
        $('#loader').toggle();
    } else {
        const URL = `${BASE_URL}${CONTROLADOR}/enviar`
        $.ajax({
            url: URL,
            method: 'POST',
            data: { id_cotizacion: id_cotizacion },
            dataType: 'json',
            success: function (data) {
                if (data.status == 200) {
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
                    $('#loader').toggle();

                } else {
                    $('#modal_correo').modal('toggle');
                    $("#id_correo").val(id_cotizacion);
                    $('#loader').toggle();
                }
            },
            error: function (error) {
                //alert('hubo un error al enviar los datos');
            }
        });
    }
});

/* MODAL ENVIAR CORREO */
$(document).on('submit', '#formCorreo', function () {
    $('#loader').toggle();
    document.getElementById("sendCorreo").disabled = true;
    var formData = new FormData($(this)[0]);

    const URL = `${BASE_URL}${CONTROLADOR}/sendCotizacion`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
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
                document.getElementById("formCorreo").reset();
                document.getElementById("sendCorreo").disabled = false;
                $('#modal_correo').modal('toggle');
                $('#loader').toggle();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: `${BASE_URL}../../assets/img/cancelar.png`,
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("form-update").disabled = false;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/* BTN IMPRIMIR */
$(document).on('click', '#imprimir', function () {
    $('#loader').toggle();
    let total = $("#total_precio").val();
    if (total == "") {
        Toastify({
            text: "No hay datos",
            duration: 3000,
            className: "info",
            avatar: `${BASE_URL}../../assets/img/cancelar.png`,
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
        $('#loader').toggle();
    } else {
        const url_cita = `${BASE_URL}/Cotizaciones/imprimir`;
        detalles = document.getElementById("propiedad_id");
        detalles.setAttribute("action", url_cita);
        document.getElementById("propiedad_id").submit();
        $('#loader').toggle();
        
    }
});

//OBTENER LAS CATEGORIAS DE PRODUCTO
function readCategorias() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/Products/readCategoria`;
    var empresas = $(".categoria");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            empresas.append(`<option  value=""> SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//OBTENER LOS CONVENIOS
function readConvenios() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/Convenios/readConvenios`;
    var empresas = $(".convenio");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });

            if (id_convenio != "") {
                $("#beneficio").val(id_convenio)
                ID_CONV = id_convenio;
            }
            get_total();
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

/*RECARGA DE AJAX DE LA TABLA*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $("#incluye").children().remove();
    get_total();
    $('#loader').toggle();
}

/* OBTENER PRECIO TOTAL */
function get_total() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/get_total`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: { id_cotizacion: id_cotizacion },
        dataType: 'json',
        success: function (data) {
            $("#total").children().remove();
            total = `<span>${currency(data[0]['total'], { symbol: "$", separator: "," }).format()}</span>`
            $("#total").append(total);
            $("#total_precio").val(data[0]['total']);
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//Unidad de negocio en donde se realizara la prueba
function obtenerUnidad() {
    const URL = `${BASE_URL}Api/Catalogos/BusinessUnit/readBusiness`;
    var disc = $(".unidad");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una unidad de negocio</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}
get_categorias();
$(".convenios").remove();

// CAMBIAR ID DE LOS FORM
$(".formCreate").removeAttr('id');
$(".formUpdate").removeAttr('id');
$(".formDelete").removeAttr('id');

$(".formCreate").attr('id', 'add_product');
$(".formUpdate").attr('id', 'update_product');
$(".formDelete").attr('id', 'delete_product');



const input = document.getElementById("autoComplete");

//OBTENER VALOR DEL SELECT DE CATEGORIA DE PRODUCTOS
$(document).on('change', '.categoria', function(){
    ID_CAT = $(this).val();
    $(".update_producto").val("");
    input.value = "";
});

//BTN ASIGNAR PRODUCTO, REVOMER EL ATTR ID 
$(document).on('click', '#add-producto', function() {
    $('.update_producto').removeAttr('id');
    $('.universidad').attr('id', 'autoComplete');
    autoComplete_input();
});

/*AGREGA UN NUEVO PRODUCTO*/
$(document).on('submit', '#add_product', function () {
    $('#loader').toggle();
    var formData = new FormData();

    let id_product = $('#id_product').val();
    let precio_convenio = $('#precioConvenio').val();

    formData.append("id_product", id_product);
    formData.append("convenio", id_convenio);
    formData.append("precio_convenio", precio_convenio);

    const URL = `${BASE_URL}Api/Catalogos/ConveniosProductos/create`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data.status == 200) {
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
                document.getElementById("add_product").reset();
                $('#myModal').modal('hide');
                reloadData();
                $('#loader').toggle();

            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/* BOTON DE EDITAR, OBTENER ID Y DATOS */
$(document).on('click', '.update', function() {
    let id = $(this).attr('id');
    let url =  `${BASE_URL}Api/Catalogos/ConveniosProductos/readProductsUpdate`;
    $('.universidad').removeAttr('id');
    $('.update_producto').attr('id', 'autoComplete');
    autoComplete_input();
    $.ajax({
        url: url,
        data: { id: id},
        method: 'post',
        dataType: 'json',
        success: function(success) {
            $("#categoria_update").val(success[0].id_category);
            $(".update_producto").val(success[0].producto);
            $("#id_product_updadte").val(success[0].id_cat_products);
            $("#id_update").val(success[0].id);
            $("#precio_convenio").val(success[0].precio_convenio);
            $('#updateModal').modal('show');
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

/*ACTUALIZAR UN PRODUCTO*/
$(document).on('submit', '#update_product', function () {
    $('#loader').toggle();
    var formData = new FormData();

    let id_product = $('#id_product_updadte').val();
    let id_up = $("#id_update").val();
    let precio_convenio = $("#precio_convenio").val();

    formData.append("id_product_update", id_product);
    formData.append("convenio", id_convenio);
    formData.append("id_update", id_up);
    formData.append("precio_convenio", precio_convenio);

    const URL = `${BASE_URL}Api/Catalogos/ConveniosProductos/update_`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data.status == 200) {
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
                document.getElementById("update_product").reset();
                $('#updateModal').modal('hide');
                reloadData();
                $('#loader').toggle();

            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/*DELETE*/
$(document).on('submit', '#delete_product', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Catalogos/ConveniosProductos/delete_`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                //notification library
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("delete_product").reset();
                reloadData();
                $('#loader').toggle();

            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
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
    return false;
});

//Boton para abrir modal de subir archivo csv
$(document).on('click', '#subir_archivo', function(e) {
    $("#div_archivo").show();
    $('#lista').children().remove();
    let input = $("#file_archivo");
    let textbox = input.prev();
    textbox.text("Arrastra el archivo aquí");
    $("#subir_btn").removeAttr('disabled');
    $('#modal_archivo').modal('toggle');
});

/* SUBIR ARCHIVO PARA ACTUALIZAR */
$(document).on('submit', '#formSubir', function(e) {
    e.preventDefault();
    let url = `${BASE_URL}${CONTROLADOR}/subirArchivo`;
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_convenio', id_convenio);
    let form = $('#formSubir');
    let modal = $('#modal_archivo');
    send(url, FORMDATA, dataTable, modal, form);
});


//archivo csv que se va a subir
$(document).on('change', '#file_archivo', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_archivo").files[0];

    if (ext == "csv") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato csv",
            duration: 3000,
            className: "info",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, 
                y: 90 
            },
        }).showToast();
    }
});

//OBTENER LAS CATEGORIAS DE PRODUCTO
function get_categorias() {
    const url = `${BASE_URL}Api/Catalogos/Products/readCategoria`;
    var empresas = $(".categoria");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            empresas.append(`<option  value=""> SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

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
                    $("#id_product_updadte").val(event.detail.selection.value.id);
                }
            }
        }
    });
}

let send = (url, data, reload, modal, form, ref) => {
    $('#loader').toggle();
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err)).then(response => {
        errores = response.errores;
        respuesta = response.status;
        if(errores.length > 0){
            $("#div_archivo").hide();
            $('#lista').children().remove();
            $("#subir_btn").attr('disabled', 'disabled');
            let mensaje = ` <h5 style="color: red;">DATOS QUE NO COINCIDEN</h5>
            <small class="form-text text-muted">Los datos en los siguientes id's no coinciden con la información guardada, verificar información</small><br>`;
            $('#lista').append(mensaje);
            errores.forEach((v, i) => {
                let inputs = `<li>${v}</li>`
                console.log(inputs)
                $('#lista').append(inputs);
            });
            
            respuesta['status'] == 200 ? notificacion(respuesta['msg'] , true, reload, modal, form, ref) : notificacion(respuesta['msg'] , false)
        } else {
            respuesta['status'] == 200 ? notificacion(respuesta['msg'] , true, reload, modal, form, ref) : notificacion(respuesta['msg'] , false);
            let input = $("#file_archivo");
            let textbox = input.prev();
            textbox.text("Arrastra el archivo aquí");
        }
        
    }).catch(err => alert(err))
}

//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
    //console.log(ref);
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }

    if (reload) {
        reload.ajax.reload();
    }

    if (modal) {
        $(modal.selector).modal('toggle');
    }

    if (form) {
        $(form.selector).trigger("reset");

    }

    Toastify({
        text: mensaje,
        duration: 3000,
        className: "info",
        avatar: imagen,
        style: {
            background: background
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();
    
    if (ref) {
        setTimeout(() => {
            window.location.href = BASE_URL + ref;
        }, "1000");
    }

    $('#loader').toggle();
}
$("#disciplina").hide();

get_categorias();
get_disciplinas();

$(document).on('change', '.file-input', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();

    if (ext == "png" || "jpg" || "jpeg") {
        if (filesCount == 1) {
            var reader = new FileReader();
            //reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
            reader.onloadend = function() {
                document.getElementById("img").src = reader.result;
            }
        } else {
            textbox.text(filesCount + ' files selected');
        }

    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe ser una imagen",
            duration: 3000,
            className: "info",
            // avatar: "../../assets/img/logop.png",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    }
});

$(".costo").on('change', function() {
    let costo = $(this).val();
    let consto_curr = currency(costo, { symbol: "", separator: "," }).format();
    $(this).val(consto_curr);
});

$(".cancelar").on('click', function() {
    document.getElementById("formProducto").reset();
    document.getElementById("formUpdate").reset();
    $(".file-message").text("Sin archivo seleccionado");
});

/* FORM: AGREGAR NUEVO PRODUCTO*/
$(document).on('submit', '#formProducto', function() {
    //$('#loader').toggle();
    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}${CONTROLADOR}/create`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
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
                $('#myModal').modal('toggle');
                document.getElementById("formProducto").reset();
                $("#disciplina").hide();
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
                $('#myModal').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

$(document).on('change', '#update_Categoria', function(){
    var id_category = parseFloat($(this).val());

    switch (id_category) {
        case 1:
            $("#disciplina_up").hide();
            $(".disciplina").removeAttr('required');
        break;

        case 3:
            get_disciplinas();
            $("#disciplina_up").show();
            $(".disciplina").attr('required', 'required');
        break;
    
        default:
            $("#disciplina_up").hide();
            $(".disciplina").removeAttr('required');
        break;
    }
   
});

$(document).on('click', '.update', function() {
    $('#loader').toggle();
    
    let product = $(this).data('index');

    let url =  `${BASE_URL}${CONTROLADOR}/readUpdate`;
    $.ajax({
        url: url,
        data: { id: product},
        method: 'post',
        dataType: 'json',
        success: function(success) {
            document.getElementById("formUpdate").reset();
            $(".file-message").text("Sin archivo seleccionado");
            $("#update_Categoria").val(success[0].id_category);
            $("#update_nombre").val(success[0].producto);
            $("#update_stock").val(success[0].stock);
            $("#update_descripcion").val(success[0].description);
            if(success[0].media_path == ""){
                let html = '';
                html += `<img id="img" src="${BASE_URL}../../public/Products/default.png" class="img-thumbnail" style="width: 30%;"/>`
                $('#imagen').html(html);
            } else {
                let html = '';
                html += `<img id="img" src="${BASE_URL}../../public/Products/${success[0].media_path}" class="img-thumbnail" style="width: 30%;"/>`
                $('#imagen').html(html);
            }
            $("#updateCita").val(success[0].cita);
            $("#id_producto").val(success[0].id_product);
            $("#id_insumo").val(success[0].id);
            $("#name_img").val(success[0].media_path);
            $("#update_disciplina").val(success[0].id_discipline);
            if(success[0].id_category == "3"){
                $("#disciplina_up").show();
            }else {
                $("#disciplina_up").hide();
                $(".disciplina").removeAttr('required');
            }
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

/*TABLA DE PRODUCTOS*/
var dataTable = $('#crm_productos').DataTable({
    processing: true, 
    serverSide: true,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ], 
    ajax: {
        url:`${BASE_URL}${CONTROLADOR}/read`,
        data: {},
        type: "post",
    },
    
    columns: [
        {
            data: 'media_path',
            render: function(data, type, row, meta) {
                return data == '' ? `<img style="width:80px; height: 80px;" 
                src="${BASE_URL}../../public/Products/default.png" 
                class="img-fluid" />` : `<img class="rounded" style="width:80px; 
                height: 80px;" src="${BASE_URL}../../public/Products/${data}" class="img-fluid"/>`
            }
        },
        {
            data: 'categoria'
        },
        {
            data: 'producto'
        },
        {
            data: 'description'
        },
        {
            data: 'stock'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return `<button id="${data}" data-index="${row.id_product}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>` +
                `<button id="${data}"  data-index="${row.id_product}" class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>`
            }
        }
    ],
    ordering: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    initComplete: function(settings, json) {
        $('#data-alumnos thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#crm_productos thead');
        var api = this.api();
        api
            .columns()
            .eq(0)
            .each(function(colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq(
                    $(api.column(colIdx).header()).index()
                );
                var title = $(cell).text();
                $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

                // On every keypress in this input
                $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                    .off('keyup change')
                    .on('keyup change', function(e) {
                        e.stopPropagation();
                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr =
                            '({search})'; //$(this).parents('th').find('select').val();
                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search(

                                this.value
                            )
                            .draw();

                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
            });
            quitaClase();

            function quitaClase() {
                $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
            }

    },
});

/*OBTENEMOS ID DEL PRODUCTO*/
$(document).on('click', '.delete', function() {
    let product = $(this).data('index');
    let insumo = $(this).attr('id');
    $("#id_delete").val(product);
    $("#id_delete_insumo").val(insumo);
    $('#modal_delete').modal('toggle');

});

/*ELINIMAR PRODUCTO*/
$(document).on('submit', '#delete_form', function() {
    $('#loader').toggle();
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}${CONTROLADOR}/delete_`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
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
                $('#modal_delete').modal('toggle');
                reloadData();
                $("#disciplina").hide();
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
                $('#modal_delete').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

//Cambio en la categoria del producto, dependen los nuevos campos
$(document).on('change', '.categoria', function() {
    var id_category = parseFloat($(this).val());

    switch (id_category) {
        case 1:
            $("#disciplina").hide();
            $(".disciplina").removeAttr('required');
        break;

        case 3:
            get_disciplinas();
            $("#disciplina").show();
            $(".disciplina").attr('required', 'required');
        break;
    
        default:
            $("#disciplina").hide();
            $(".disciplina").removeAttr('required');
        break;
    }
});

//OBTENER LA CATEGORIA DE LOSPRODUCTOS
function get_categorias(){
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readCategoria`;
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
            $('#loader').toggle();
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

//OBTENER LA DISCIPLINA DE LAS CONSULTAS
function get_disciplinas(){
    $('#loader').toggle();
    $(".disciplina").empty();
    const url = `${BASE_URL}${CONTROLADOR}/readDisciplina`;
    var empresas = $(".disciplina");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $(".disciplina").empty();
            empresas.append(`<option  value=""> SELECCIONA UNA DISCIPLINA</option>`);
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
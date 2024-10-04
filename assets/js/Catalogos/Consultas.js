get_categorias();
get_disciplinas();

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
                document.getElementById('nombre').value = "";
                get_disciplinas();
                document.getElementById('descripcion').value = "";
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
            $("#update_Categoria").val(success[0].id_category);
            $("#update_nombre").val(success[0].producto);
            $("#update_descripcion").val(success[0].description);
            $("#updateCita").val(success[0].cita);
            $("#id_producto").val(success[0].id_product);
            $("#id_insumo").val(success[0].id);
            $("#update_disciplina").val(success[0].id_discipline);
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
            data: 'categoria'
        },
        {
            data: 'producto'
        },
        {
            data: 'description'
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
            empresas.append(`<option  value=""SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            empresas.val("3");
            empresas.attr('disabled', 'disabled');
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
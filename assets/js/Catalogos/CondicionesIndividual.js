/* TABLA DE CONDICIONES DE CONVENIOS */
var dataTable = $('#tb_convenios').DataTable({

    ajax: {
        url: BASE_URL + '/Api/Catalogos/CondicionesIndividual/read',
        data: {id:id_cond},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: 'nombre_convenio',
            render: function(data, type, row, meta) {
                return '<p class="text-uppercase">' + data + '</p>'
            }  
        },
        {
            data: 'unidad_negocio',
        },
        {
            data: 'nombre_producto',
        },
        {
            data: 'nombre_condicion',
        },
        {
            data: 'value',
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"> <button id="' + data + '"" title="Editar condiciones" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" data-toggle="modal" data-target="#updateModal"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar condiciones" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*Visualizacion de datos de las condiciones de convenio en el modal*/
$(document).on('click', '.up', function () {
    const URL = `${BASE_URL}${CONTROLADOR}/readCondicionesConvenio`;
    let convenio = $(this).attr('id');

    $.ajax({
        url: URL,
        data: {
            id: convenio
        },
        method: 'post',
        dataType: 'json',
        success: function (success) {
            $('#condconv').val(convenio);
            $('#tipo_convenio').val(success[0].id_cat_conventions);
            $('#tipo_negocio').val(success[0].id_cat_company_client);
            $('#tipo_categoria').val(success[0].id_category);
            $('#tipo_condicion').val(success[0].id_cat_condition_type);
            $('#valor').val(success[0].value);
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});


//TIPO DE CONVENIO A ASIGNAR
getConvenios();
function getConvenios() {
    const URL = `${BASE_URL}${CONTROLADOR}/getConvenios`;
    var convenio = $(".convenios");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            convenio.append(`<option value="">SELECCIONA CONVENIO</option>`);
            $(data).each(function (i, v) {
                convenio.append(`<option title="${v.description}" value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('hubo un error al enviar los datos');
        }
    });
} 

//TIPO DE UNIDAD DE NEGOCIO A ASIGNAR
getUnidades();
function getUnidades() {
    const URL = `${BASE_URL}${CONTROLADOR}/getUnidad`;
    var unidad = $(".negocio");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            unidad.append(`<option value="">SELECCIONA UNIDAD DE NEGOCIO</option>`);
            $(data).each(function (i, v) {
                unidad.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('hubo un error al enviar los datos');
        }
    });
} 

//TIPO DE CATEGORIA A ASIGNAR
getCategoria();
function getCategoria() {
    const URL = `${BASE_URL}${CONTROLADOR}/getCategorias`;
    var category = $(".categorias");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            category.append(`<option value="">SELECCIONA CATEGORIA</option>`);
            $(data).each(function (i, v) {
                category.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('hubo un error al enviar los datos');
        }
    });
} 

//TIPO DE CONDICION A ASIGNAR
getTipoCondicion();
function getTipoCondicion() {
    const URL = `${BASE_URL}${CONTROLADOR}/getConditionType`;
    var condiciones = $(".condicion");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            condiciones.append(`<option value="">SELECCIONA TIPO DE CONDICION</option>`);
            $(data).each(function (i, v) {
                condiciones.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            alert('hubo un error al enviar los datos');
        }
    });
} 


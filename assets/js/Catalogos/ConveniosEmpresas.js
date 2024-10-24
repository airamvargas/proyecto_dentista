moment.locale('es');

/* TABLA DE CONVENIOS QUE TIENE UNA EMPRESA */
var dataTable = $('#tb_convenios_empresa').DataTable({
    ajax: {
        url: `${BASE_URL}Api/Catalogos/ConveniosEmpresas/read`,
        data: {id:id},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: 'name',
            render: function(data, type, row, meta) {
                return '<p class="text-uppercase">' + data + '</p>'
            }  
        },
        {
            data: 'status',
            render: function (data, type, row, meta) {
                return data == 0 ? 
                `<p class="text-uppercase" id="` + row.id + `">Inactivo</p>` :
                `<p class="text-uppercase" id="` + row.id + `">Activo</p>`
            }
        },
        {
            data: 'date_start',
            render: function(data, type, row, meta) {
                return moment(data).format('DD/MM/YYYY')
            }
        },
        {
            data: 'date_finish',
            render: function(data, type, row, meta) {
                return moment(data).format('DD/MM/YYYY')
            }
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"> <a href="'+BASE_URL+'Catalogos/ConveniosProducto/add_products/'+data+'"> <button id="' + data + '"" class="btn btn-purple up solid pd-x-20 btn-circle btn-sm mr-2" title="Agregar producto"><i class="ionicons ion-bag fa-2x"></i></button></a>' + 
                '<button id="' + data + '" class="btn btn-primary solid pd-x-20 btn-circle btn-sm mr-2 agregar-condiciones" title="Agregar condiciones" data-index="' + row.id + '" data-nombre="' + row.name + '"><i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i></button>' + 
                '<a href="'+BASE_URL+'Catalogos/CondicionesIndividual/individual/'+data+'"> <button id="' + data + '"" class="btn btn-teal up solid pd-x-20 btn-circle btn-sm mr-2" title="Ver condiciones"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a>' + 
                '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar convenio" data-toggle="modal" data-target="#updateModal"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar convenio" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*VISUALIZACION DE LOS DATOS DEL CONVENIO DE DICHA EMPRESA*/
$(document).on('click', '.up', function () {
    const URL = `${BASE_URL}${CONTROLADOR}/readConvenioEmpresa`;
    let convenio = $(this).attr('id');
    
    $.ajax({
        url: URL,
        data: {
            id: convenio
        },
        method: 'post',
        dataType: 'json',
        success: function (success) {
            $('#id').val(convenio);
            $('#empr').val(success[0].id_cat_company_client);
            $('#nomb').val(success[0].name);
            $('#estatus').val(success[0].status);
            $('#fecha_i').val(success[0].date_start);
            $('#fecha_f').val(success[0].date_finish);
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

//Id del convenio creado para ponerle condiciones
$(document).on('click', '.agregar-condiciones', function() {
    ind_convenio = $(this).data('index'); 
    console.log(ind_convenio);
    convenio_name = $(this).data('nombre'); 
    $('#modal_add_condiciones').modal('toggle');
    $("#convenioid").val(ind_convenio);
    $("#nom_convenio").val(convenio_name);
});

//TIPO DE UNIDAD DE NEGOCIO A ASIGNAR
getUnidades();
function getUnidades() {
    const URL = `${BASE_URL}Api/Catalogos/CondicionesConvenios/getUnidad`;
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
    const URL = `${BASE_URL}Api/Catalogos/CondicionesConvenios/getCategorias`;
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
    const URL = `${BASE_URL}Api/Catalogos/CondicionesConvenios/getConditionType`;
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

/* GUARDAR DATOS DE LAS CONDICIONES DEL CONVENIO */
$(document).on('submit', '#formCreateCondiconvenio', function () {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Catalogos/CondicionesConvenios/create`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();
                $('#modal_add_condiciones').modal('toggle');
                location.href = `${BASE_URL}Catalogos/CondicionesIndividual/individual/${ind_convenio}`;
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();
                $('#modal_add_condiciones').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});
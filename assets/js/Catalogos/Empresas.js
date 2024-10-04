nombre = ""; //nombre a pasar en el buscador del datatable

// TABLA DE EMPRESAS CLIENTE
empresa(nombre);
function empresa(nombre){ 
    dataTable = $('#tb_empresa').DataTable({
        "search": {
           "search": nombre //nombre de la empresa registrado
        },
        "destroy": true,
        ajax: {
            url:`${BASE_URL}${CONTROLADOR}/read`,
            data: {},
            type: "post",
        },
        lengthMenu: [
            [10, 25, 50, 100, 999999],
            ["10", "25", "50", "100", "Mostrar todo"],
        ],    
        columns: [            
            {
                data: 'name',  
            },
            { 
                data: 'rfc',               
            },
            { 
                data: 'trade_name'
            },
            { 
                data: 'regimen_fiscal'
            },
            { 
                data: 'email'
            },
            { 
                data: 'tel_contac'
            },
            { 
                data: 'fiscal_address'
            },
            {
                data: "id",
                render: function(data, type, row, meta) {
                    return '<div class="d-flex justify-content-center"><button id="' + data + '"" class="btn btn-primary solid pd-x-20 agregar-convenio btn-circle btn-sm mr-2" title="Agregar convenio" data-index="' + row.id + '" data-nombre="' + row.name + '"><i class="fa fa-handshake-o fa-2x"></i></button>' + 
                    '<a href="'+BASE_URL+'Catalogos/ConveniosEmpresas/convenios/'+ data +'"> <button id="' + data + '"" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2" title="Ver convenios"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a>' + 
                    '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar empresa" data-toggle="modal" data-target="#updateModal"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar empresa" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o fa-lg fa-2x" aria-hidden="true"></i></button></div>'
                }
            },
        ],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        }
    });
}

// GUARDAR EMPRESAS CLIENTE 
$(document).on('submit', '#formCreateEmpresa', function() {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/create`;
    
    $.ajax({
        url: URL,
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function(data) {
            if (data.status == 200) {
                nombre = data.nombre; //nombre a mostrar en el buscador
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
                $('#modal_create').modal('toggle');
                document.getElementById("formCreateEmpresa").reset();
                empresa(nombre); //nombre de empresa insertada
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
                $('#modal_create').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

//VISUALIZACION DE LOS DATOS DE LA EMPRESA PUESTOS EN EL MODAL
$(document).on('click', '.up', function() {
    const URL = `${BASE_URL}${CONTROLADOR}/readEmpresas`;
    let empresa = $(this).attr('id');

    $.ajax({
        url: URL,
        data: { id: empresa },
        method: 'post', 
        dataType: 'json',
        success: function(success) {
            $('#idemp').val(empresa); 
            $('#nom').val(success[0].name); 
            $('#rfc').val(success[0].rfc);
            $('#razon').val(success[0].trade_name); 
            $('#regimen').val(success[0].id_cat_fiscal_regime);
            $('#correo').val(success[0].email);
            $('#telefono').val(success[0].tel_contac);
            $('#domicilio').val(success[0].fiscal_address);           
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//REGIMEN FISCAL EN EL CUAL SE VA A ASIGNAR A LA EMPRESA
getRegimen();

function getRegimen() {
    const URL = `${BASE_URL}${CONTROLADOR}/getRegimenes`;
    var regimen = $(".regimenes");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            regimen.append(`<option value="">SELECCIONA UN REGIMEN </option>`);
            $(data).each(function(i, v) {
                regimen.append(`<option title="${v.description}" value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function(error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//ID DE LA EMPRESA CREADA PARA CREARLE UN CONVENIO
$(document).on('click', '.agregar-convenio', function() {
    business_client = $(this).data('index'); 
    business_name = $(this).data('nombre'); 
    $('#modal_empresa_convenio').modal('toggle');
    $("#empresaid").val(business_client);
    $("#nom_business").val(business_name);
});

// GUARDAR CONVENIO DE UNA EMPRESA 
$(document).on('submit', '#formEmpresaConvenio', function () {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Catalogos/Convenios/create`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: form_data,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            
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

                $('#modal_empresa_convenio').modal('toggle');
                location.href = `${BASE_URL}Catalogos/ConveniosEmpresas/convenios/${business_client}`; 
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();

                $('#modal_empresa_convenio').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});
//archivos
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


/*SELECT DE EMPRESAS*/
get_empresas();

function get_empresas() {
    const url = `${BASE_URL}Proveedores/getEmpresas`;
    var empresas = $(".empresas");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONA EMPRESA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.business_name}</option>`);
            })

        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


/*TABLA DE PROVEEDORES*/


var dataTable = $('#datatable1').DataTable({
    "bAutoWidth": false,
    ajax: {
        url: BASE_URL + '/Proveedores/tableProveedores',
        data: {},
        type: "post",
    },

    lengthMenu: [
        [100, 10, 25, 50, 999999],
        ["100", "10", "25", "50", "Mostrar todo"],
      ],

    columns: [{
            data: 'logo',
            render: function(data, type, row, meta) {
                return data == '' ? '<img style="width:80px; height: 80px;" src="../../../../writable/uploads/Mattes/Arrendador/default.png" class="img-fluid" />' : '<img class="rounded" style="width:80px; height: 80px;" src="../../public/images/logos/' + data + ' " class="img-fluid" />'
            }
        },
        {
            data: 'name_proveedor'
            /* render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */
        },
        {
            data: 'empresa'
            /* render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */
        },

        {
            data: 'Marca'
            /* render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */
        },
        {
            data: 'embark'
           /*  render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */

        },
        {
            data: 'contact'
           /*  render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */

        },
        {
            data: 'phone'

        },
        {
            data: 'email'

        },
        {
            data: 'id_proveedor',
            render: function(data, type, row, meta) {
                return '<a href="' + BASE_URL + 'Proveedores/ProveedorDetalle/' + data +
                    '" ><button class="btn btn-info solid"><i class="fa fa-bitbucket " aria-hidden="true" ></i> PRODUCTOS</button></a>'
            }

        },
        {
            data: "id_proveedor",
            render: function(data, type, row, meta) {
                return '<div class="d-flex"><button id="' + data + '"" class="btn btn-warning up solid pd-x-20"><i class="fa fa-pencil fa-lg mr-1" aria-hidden="true"></i>EDITAR</button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 "><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button></div>'


            }
        },


    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});


/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

/*GUARDAR PROVEEDOR*/
$(document).on('submit', '#Nprovedor', function() {
    $('#myModal').modal('toggle');
    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Proveedores/agregar`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();


                document.getElementById("Nprovedor").reset();
                reloadData();


                //  document.getElementById("ubicacion").submit();

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
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();

                //$('#modaldemo3').modal('toggle');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});


//OBTENER DATOS PROVEEDOR//

$(document).on('click', '.up', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}Proveedores/Actualizar`;
    let idproveedor = $(this).attr('id');
    document.getElementById("actualizar").reset();

    $.ajax({
        url: url,
        data: { id_proveedor: idproveedor },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            console.log(success);
            $("#comercial").val(success[0].name_proveedor);
            $("#marca").val(success[0].Marca);
            $("#puerto").val(success[0].embark);
            $("#contacto").val(success[0].contact);
            $("#tel").val(success[0].phone);
            $("#correo").val(success[0].email);
            $("#empresas_upd").val(success[0].business_id);
            $("#id_proveedor").val(success[0].id_proveedor);
            $("#img").val(success[0].logo);
            let html = '';
            html += '<img src="../../public/images/logos/' + success[0].logo + '" class="img-thumbnail" style="width: 30%;"/>'
            $('#imagen').html(html);
            $('#loader').toggle();

            $('#updateModal').modal('show');
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

/*ACTUALIZACION DE PROVEEDOR*/

$(document).on('submit', '#actualizar', function() {
    // console.log("di un click");
    const formData = new FormData($(this)[0]);
    const url_srt = `${BASE_URL}Proveedores/Adatos`;

    $.ajax({
        url: url_srt,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();

                $('#updateModal').modal('toggle');
                document.getElementById("actualizar").reset();
                reloadData();


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
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();

                $('#updateModal').modal('toggle');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

/*ONTENEMPOS ID DEL  PROVEEDOR*/

$(document).on('click', '.delete', function() {
    let idproveedor = $(this).attr('id');
    $('#modal_delete').modal('toggle');
    $("#id_delete").val(idproveedor);

});

/*ELINIMAR PROVEEDOR*/
$(document).on('submit', '#delete_form', function() {
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Proveedores/Delete`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../assets/img/correcto.png",
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
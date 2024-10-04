let this_js_script = $('#ruta'); // or better regexp to get the file name..
const CONTROLADOR = this_js_script.attr('data-my_var_1');

/* TABLA DE CONVENIOS GENERAL CON TODAS LAS EMPRESAS*/
var dataTable = $('#tb_adminmedicos').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/read`,
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [        
        {
            data: 'foto',
            render: function (data, type, row, meta) {
                return (data == '') || (data == null) ? `<img style="width:70px; height: 70px;" class="img-fluid rounded-circle" src="${BASE_URL}../../public/uploads/default.png" >` : `<img style="width:70px; height: 70px;" src="${BASE_URL}../uploads/medico/fotos/` + data + ' " class="img-fluid rounded-circle" />'
            }
        },
        {
            data: 'nombre',
        },
        {
            data: 'nombre_grupo',
        }, 
        {
            data: 'correo',
        },
        {
            data: 'PHONE_NUMBER',
        },       
        {       
            data: "id",
            render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><a href="'+BASE_URL+'HCV/Administrativo/Ficha_Identificacion_Operativo/updateOperativo/'+data+'"> <button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar médico"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button></a>' +
                '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar medico" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        }, 
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*RELOAD DATATABLE */
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

/*GET ID ATTIBUTE BUTTON*/
$(document).on('click', '.delete', function () {
    let product = $(this).attr('id');
    $('#modal_delete').modal('toggle');
    $("#id_delete").val(product);

});

/*DELETE*/
$(document).on('submit', '#formDelete', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/delete_`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                $('#loader').toggle();
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
                        x: 50, 
                        y: 90 
                    },
                }).showToast();
                reloadData();
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
                        x: 50, 
                        y: 90 
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
                x: 50, 
                y: 90 
            },
        }).showToast();
    });
    return false;
});
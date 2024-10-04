/* Desarrollador: Jesús Esteban Sánchez Alcántara
Fecha Creacion: 11 - octubre -2023
Fecha de Ultima Actualizacion: 
Perfil: Recoleccion
Descripcion: Catalogo de empresas recolectoras */

//Empresas recolectoras a mostrar en el datatable
var dataTable = $('#crm_processing_company').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/`,
        data: {},
        type: "post",
    },
    columns: [
        {
            data: 'id',
        },
        {
            data: 'name',
        },
        {
            data: 'description'
        },
       /*  {
            data: 'type',
            render: function(data, type, row, meta) {
                return valor = row.type == 1 ? 'Interna' : 'Externa'; 
            }
        },    */
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<a href="'+BASE_URL+'Recolectoras/Empresas/userBusiness/'+row.id_user+'"><button  title="Ver usuarios" id="' + data + '"" class="btn btn-primary  solid pd-x-20 btn-circle btn-sm ml-1"><i class="fa fa-users fa-2x" aria-hidden="true"></i></button></a>'+ 
                '<button  title="EDITAR" id="' + data + '"" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-1"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
                    
            }
        },
    ],
    "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
        },
        { className: "wrapbox", "targets": [ 1 ] },
        { className: "wrapbox", "targets": [ 2 ] },
      ], 

    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});

//Datos para mostrar en el modal de editar epresas recolectoras
$(document).on('click', '.update', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readCompany`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            console.log(success);
            var keys = Object.keys(success[0]);
            keys.forEach(element => {
                $('#' + element).val(success[0][element]);
            });
            $('#loader').toggle();
            $('#updateModal').modal('show');
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//Agregar nuevos usuarios a la empresa
$(document).on('click', '.usuarios', function () {
    let id = $(this).attr('id');
    $("#id_empresa").val(id);
    grupos();
    $('#model_usuarios').modal('show');
});






let send = (url, data, reload, modal, form, ref) => {
    $('#loader').toggle();
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form, ref) : notificacion(response.msg, false)
    }).catch(err => alert(err))
}

//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
    console.log(ref);
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

passwd();

function passwd() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
}
    

//
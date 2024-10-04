/*Desarrollador: 
Fecha de creacion: 
Fecha de Ultima Actualizacion: 20-03-2024
Actualizo: Airam V. Vargas
Perfil: Back Office
Descripcion:  JS de los usuarios de empresas recolectoras */ 

var dataTable = $('#datatable').DataTable({
    ajax: BASE_URL + 'Api/Recolectoras/Empresas/getUsers/'+id_user,
    columns: [
        {
            data:'id_user'
        }, 
        {
            data: 'photo',
            render: function (data, type, row, meta) {
                return data == "" ? `<img style="width:70px; height: 70px;" src='${BASE_URL}../../assets/img/default.png' class="img-fluid" />` : `<img style="width:70px; height: 70px;" src="${BASE_URL}../../public/images/${data} " class="img-fluid" />`
            }
        },
        {
            data: 'user_name'
        },
        {
            data: 'email'
        },
        {
            data: 'grupo',
        },
        { 
            data: 'phone'
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                return '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  data-user="'+row.id_user+'" class="btn btn-danger delete-user solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
            }
        },
    ],
    "columnDefs": [
        {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
        }
      ], 

    order: [[0, 'desc']],
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
});

//Enviar datos para agregar un nuevo usuario
$(document).on('submit', '#insertUsers', function(e){
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/insertUser`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#model_usuarios");
    let form = $("#insertUsers");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//Obtener id del usuario para obtener datos para editar
$(document).on('click', '.up', function(){
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/showUser`;
    let id = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $("#nombreUp").val(success[0]['name'])
            $("#apellido_ap").val(success[0]['first_name'])
            $("#apellido_am").val(success[0]['second_name'])
            $("#telefono").val(success[0]['phone'])
            $("#email").val(success[0]['email'])
            $("#id_group_update").val(success[0]['id_group'])
            $("#id_update").val(success[0]['id'])
            $("#id_update_user").val(success[0]['id_user'])
            $("#name_photo").val(success[0]['photo'])
            foto = success[0]['photo'];
            if(foto == "" || foto == null){
                $("#imagen_perfil").children().remove();
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png" style="width: 20%">`;
                $("#imagen_perfil").append(photo);
            } else {
                $("#imagen_perfil").children().remove();
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../../public/images/${foto}" style="width: 20%">`;
                $("#imagen_perfil").append(photo);
            }
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//Enviar actualizacion de los datos del usuario
$(document).on('submit', '#updateUsuarios', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/updateUser`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#updateModal");
    let form = $("#updateUsuarios");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//Obtener id del usuario para eliminar
$(document).on('click', '.delete-user', function(){
    let id = $(this).attr('id');
    let id_user = $(this).data('user');
    $("#id_delete").val(id);
    $("#id_delete_user").val(id_user);
    $("#modal_delete_user").modal('toggle');
});

//Enviar datos para eliminar usuario
$(document).on('submit', '#formDeleteUsers', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/deleteUser`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $("#modal_delete_user");
    let form = $("#formDeleteUsers");
    send(url, FORMDATA, dataTable, modal, form, false);
});

//file agregar usuario
$(document).on('change', '#file-user', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop().toLowerCase();
    var archivo = document.getElementById("file-user").files[0];

    if ((ext == "png") || (ext == "jpg") || (ext == "jpeg") ) {
        if (filesCount === 1) {

            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
            reader.onloadend = function() {
                document.getElementById("file").src = reader.result;
            }
        } else {
            textbox.text(filesCount + ' files selected');
        }

    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe ser un formato de imagen PNG,JPG,JPEG",
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

//file editar usuario
$(document).on('change', '#file_user_update', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop().toLowerCase();
    var archivo = document.getElementById("file_user_update").files[0];

    if ((ext == "png") || (ext == "jpg") || (ext == "jpeg") ) {
        if (filesCount === 1) {

            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
            reader.onloadend = function() {
                document.getElementById("img-user").src = reader.result;
            }
        } else {
            textbox.text(filesCount + ' files selected');
        }

    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe ser un formato de imagen PNG,JPG,JPEG",
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

//Envio de formulario POST 
let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form) : notificacion(response.msg, false)
    }).catch(err => alert(err));
}
 
//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
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

    if(ref){
        setTimeout(() => {
            window.location.href = BASE_URL+ref;
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

//grupos 
let grupos = () => {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/getGroups`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            select =  $(".group");
            select.append(`<option  value=""> SELECCIONA UN GRUPO</option>`);
            $(response).each(function(i, v) {
                select.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
        $('#loader').toggle();
    }).catch(err => alert(err));
}
grupos();

/*
Desarrollador:
Fecha de creacion:
Fecha de Ultima Actualizacion: 07 - noviembre - 2023 por Airam Vargas
Perfil: Administrador
Descripcion: Cátalogo de tipos de analitos  */

//Elegir que tipo de usuario se quiere dar de alta en el sistema
$(document).on('change', '#tipo_usuario', function(){
    val = parseFloat($(this).val());
    switch(val){
        case 1:
            $("#datosUsuarios").show();
            $("#medicos").addClass('d-none');
            $("#recolectora").addClass('d-none');
        break;
        case 2:
            $("#datosUsuarios").hide();
            $("#medicos").removeClass('d-none');
            $("#recolectora").addClass('d-none');
        break;
        case 3:
            $("#recolectora").removeClass('d-none');
            $("#medicos").addClass('d-none');
            $("#datosUsuarios").hide();
        break;
    }
});

//Boton agregar personal
$("#usuarios_personal").on('click', function(){
    $("#tipo_usuario").val("");
    $("#medicos").addClass('d-none');
    $("#personal").addClass('d-none');
    $("#recolectora").addClass('d-none');
    $('#modal_select').modal('toggle');
    $('#myModal').modal('toggle');
});

//file
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

$(document).on('change', '#update-file-user', function() {
    // alert("dentro");
 
     var filesCount = $(this)[0].files.length;
     var textbox = $(this).prev();
     var ext = $(this).val().split('.').pop().toLowerCase();
     var archivo = document.getElementById("update-file-user").files[0];
 
 
     if ((ext == "png") || (ext == "jpg") || (ext == "jpeg") ) {
         if (filesCount === 1) {
 
             var reader = new FileReader();
             reader.readAsDataURL(archivo);
             var fileName = $(this).val().split('\\').pop();
             textbox.text(fileName);
             reader.onloadend = function() {
                 document.getElementById("up-img").src = reader.result;
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

//inicializacion de la funcion
getGrupos();

//obtenemos los grupos y los conlocamos dentro un select
function getGrupos() {
    const url = `${BASE_URL}${CONTROLADOR}/showGroup`;
    var select = $(".id_group");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            //const ch = data['data'];
            select.append(`<option  value=""> SELECCIONA GRUPO </option>`);
            $(data).each(function (i, v) {
                select.append(`<option title="${v.description}"  value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//iniciamos la la funcion getunidad
getUnidad();
//obtenemos de base los datos de unidad de negocio
function getUnidad() {
    const url = `${BASE_URL}${CONTROLADOR}/showBussiness`;
    var select = $(".id_cat_business_unit");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            //const ch = data['data'];
            select.append(`<option  value=""> SELECCIONA UNIDAD DE NEGOCIO </option>`);
            $(data).each(function (i, v) {
                select.append(`<option title="${v.description}" value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}

/* $('.id_group').on('change', function(){
    group = $(this).val();
    if(group == 6){
        $(".unit_div").hide();
        $(".id_cat_business_unit").attr('disabled', 'disabled');
    } else {
        $(".unit_div").show();
        $(".id_cat_business_unit").removeAttr('disabled')
        $(".id_cat_business_unit").attr('required', 'required'); 
    }
    
}); */

//validacion de grupos
/* $("#id_group").on("change", function () {
    let grupo = $(this).val();
   // alert(grupo);
    if((grupo == "1") || (grupo == "2") || (grupo == "10")){
       $('.id_cat_business_unit').hide();
       $('#unilab').hide();
    }else{
        $('.id_cat_business_unit').val("");
        $('.id_cat_business_unit').show();
        $('#unilab').show();

    }

}); */



var dataTable = $('#datatable').DataTable({
    ajax: BASE_URL + 'Api/Administrador/Usuarios',
    columns: [
        {
               data:'id_user'
   
        }, 

        {
            data: 'photo',
            render: function (data, type, row, meta) {
                return data == '' ? '<img style="width:70px; height: 70px;" src="../../images/default_user.png" class="img-fluid" />' : '<img style="width:70px; height: 70px;" src="../../../public/images/' + data + ' " class="img-fluid" />'
            }
        },
        {
            data: 'user_name',
            render: function(data, type, row, meta) {
                return `<p> ${row.empleado} ${row.first_name} ${row.second_name} </p>`
            } 
        },
        {
            data: 'email',
            /* render: function(data, type, row, meta) {
                return `<p> ${data.charAt(0).toUpperCase()+data.slice(1).toLowerCase()}  </p>`
            } */
        },

        {
            data: 'grupo',
           
        },


        { data: 'phone' },

        { data: 'name' },


        {
            data: "id_user",
            render: function (data, type, row, meta) {
                return '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'


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

// //GUARDAR USUARIO 

// $(document).on('submit', '#formUsuario', function () {

//     var formData = new FormData($(this)[0]);
//     const url = `${BASE_URL}/Administrador/Usuarios/save_user`;

//     $.ajax({
//         url: url,
//         type: 'POST',
//         data: formData,
//         dataType: 'json',
//         success: function (data) {
//             console.log(data);
//             if (data.status == 200) {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../../assets/img/correcto.png",
//                     style: {
//                         background: "linear-gradient(to right, #00b09b, #96c93d)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();
//                 $('#myModal').modal('toggle');
//                 // document.getElementById("formProducto").reset();
//                 reloadData();

//             } else {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../assets/img/cancelar.png",
//                     style: {
//                         background: "linear-gradient(to right, #f26504, #f90a24)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();

//                 $('#myModal').modal('toggle');
//             }

//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//     return false;
// });


// function reloadData() {
//     $('#loader').toggle();
//     dataTable.ajax.reload();
//     $('#loader').toggle();
// }

// //OBTENEMOS LOS DATOS

$(document).on('click', '.up', function () {
    const url = `${BASE_URL}${CONTROLADOR}/readUser`;
    let usuario = $(this).attr('id');

    //$('#update-myModal').modal('show');
    // document.getElementById("actualizar").reset();

    $.ajax({
        url: url,
        data: { id: usuario },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            console.log(success);
            $('#user-grupo').val(success[0].id_group);
            $('#nombre').val(success[0].empleado);
            $('#ap-paterno').val(success[0].first_name);
            $('#ap-materno').val(success[0].second_name);
            $('#telefono').val(success[0].phone);
            $('#email-upd').val(success[0].email);
            $('#password_upd').val(success[0].password);
            $('#id_user').val(success[0].id_user);
            $('#upd-id').val(success[0].id);
            $('#unidad').val(success[0].id_cat_business_unit);
            $('#id_identity').val(success[0].id_identity)
            $('#upd-name-foto').val(success[0].photo);
            let html = '';
            html += '<img id="up-img" src="../../../public/images/' + success[0].photo + '" class="img-thumbnail" style="width: 30%;"/>'
            $('#imagen').html(html);
            $('#updateModal').modal('show');


        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

// //ACTUALIZAR USUARIO//

// $(document).on('submit', '#formUpdateUsuario', function () {

//     var formData = new FormData($(this)[0]);
//     const url = `${BASE_URL}/Administrador/Usuarios/update_user`;

//     $.ajax({
//         url: url,
//         type: 'POST',
//         data: formData,
//         dataType: 'json',
//         success: function (data) {
//             console.log(data);
//             if (data.status == 200) {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../../assets/img/correcto.png",
//                     style: {
//                         background: "linear-gradient(to right, #00b09b, #96c93d)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();
//                 $('#update-myModal').modal('toggle');
//                 // document.getElementById("formProducto").reset();
//                 reloadData();

//             } else {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../assets/img/cancelar.png",
//                     style: {
//                         background: "linear-gradient(to right, #f26504, #f90a24)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();

//                 $('#update-myModal').modal('toggle');
//             }

//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//     return false;
// });


// //DELETE USUARIO

// $(document).on('click', '.delete', function () {
//     let id = $(this).attr('id');
//     $('#modal_delete').modal('toggle');
//     $("#id_delete").val(id);

// });

// $(document).on('submit', '#delete_form', function () {
//     const formData = new FormData($(this)[0]);
//     const url = `${BASE_URL}/Administrador/Usuarios/delete_user`;

//     $.ajax({
//         url: url,
//         type: 'POST',
//         data: formData,
//         dataType: 'json',
//         success: function (data) {
//             console.log(data);
//             if (data.status == 200) {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../assets/img/correcto.png",
//                     style: {
//                         background: "linear-gradient(to right, #00b09b, #96c93d)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();

//                 $('#modal_delete').modal('toggle');
//                 reloadData();


//             } else {
//                 Toastify({
//                     text: data.msg,
//                     duration: 3000,
//                     className: "info",
//                     avatar: "../../assets/img/cancelar.png",
//                     style: {
//                         background: "linear-gradient(to right, #f26504, #f90a24)",
//                     },
//                     offset: {
//                         x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
//                         y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
//                     },

//                 }).showToast();
//                 $('#modal_delete').modal('toggle');
//             }

//         },
//         cache: false,
//         contentType: false,
//         processData: false
//     });
//     return false;


// });




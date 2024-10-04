showDatos();

//FOTO DE PERFIL DE FICHA DE IDENTIFICACION DEL USUARIO
$(document).on('change', '#file_user-img', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_user-img").files[0];

    if (ext == "jpeg" || "png" || "jpg") {
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
            text: "El archivo debe tener formato jpeg, png o jpg",
            duration: 3000,
            className: "info",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, 
                y: 90 
            },
        }).showToast();
    }
});

/*CREATE UNIDAD DE NEGOCIO DE OPERATIVO*/
$(document).on("submit", "#updateDatos", function () {
    $("#loader").toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/update`;
    $.ajax({
        url: URL,
        type: "POST",
        data: FORMDATA,
        dataType: "json",
        success: function (data) {
            console.log(data);
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $("#loader").toggle();
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
                        y: 90, 
                    },
                }).showToast();
                document.getElementById("updateDatos").reset();
                showDatos();
            } else {
                $("#loader").toggle();
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
                        y: 90, 
                    },
                }).showToast();
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loader").toggle();
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
                y: 90, 
            },
        }).showToast();
    });
    return false;
});

//Obtener datos del usuario
function showDatos() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/show`;
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if(data != ""){
                if(data[0].unidad){
                    unidad = data[0].unidad;
                } else {
                    unidad = "SIN UNIDAD ASIGNADA";
                }
                var foto = data[0].photo;
                if (foto == null || foto == "") {
                    $("#imagen_perfil").children().remove();
                    let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png">`;
                    $("#imagen_perfil").append(photo);
                } else {
                    $("#imagen_perfil").children().remove();
                    let pathphoto = `${BASE_URL}../images`;
                    let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${pathphoto}/${foto}">`;
                    $("#imagen_perfil").append(photo);
                }
                $('#nombre').val(data[0].name);
                $('#f_apellido').val(data[0].first_name);
                $('#s_apellido').val(data[0].second_name);
                $('#telefono').val(data[0].phone);
                $('#correo').val(data[0].email);
                $('#unidad_negocio').val(unidad);
                $('#codigo').val(data[0].code);
            }
            $('#loader').toggle();
            
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });
}

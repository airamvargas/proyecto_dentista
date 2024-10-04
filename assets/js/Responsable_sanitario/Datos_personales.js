//funcion de inicio
$(document).ready(function () {
    //$('body').css("overflow" ,"hidden")
    //promesa para carga asincrona
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(obtenerGrupo()).catch(err => alert(err))
        .then(getUSer()).catch(err => alert(err))
});

//Obtener los datos del responsable sanitario 
let getUSer = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Personales`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            var foto = response[0]['FILE_USER'];
            var ine = response[0]['FILE_INE'];
            var firma = response[0]['signature'];
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

            if (ine == null || ine == "") {
                $("#down_ine").removeAttr('href');
                $("#file_ine_medico").attr('required')
            }  else {
                const url_ine = `${BASE_URL}../public/uploads/medico/ine/${ine}`;
                ine_down = document.getElementById("down_ine");
                ine_down.setAttribute("href", url_ine);
                $("#file_ine_medico").removeAttr('required');
            }

            if (firma == null || firma == "") {
                $("#file_firma").attr('required')
            }  else {
                $("#file_firma").removeAttr('required');
            }

            $("#identity").val(response[0]['ID']);
            $("#name_photo").val(response[0]['FILE_USER']);
            $("#name_firma").val(response[0]['signature']);
            $("#id_user").val(response[0]['user_id']);
            $("#correo").val(response[0]['email']);
            $("#nombre").val(response[0]['NAME']);
            $("#F_LAST_NAME").val(response[0]['F_LAST_NAME']);
            $("#S_LAST_NAME").val(response[0]['S_LAST_NAME']);
            $("#fecha").val(response[0]['BIRTHDATE']);
            $("#PHONE_NUMBER").val(response[0]['PHONE_NUMBER']);
            $("#descrip").val(response[0]['DESC_PERSONAL']);
            $("#cp_search").val(response[0]['CP']);
            $("#id_original").val(response[0]['CAT_CP_ID']);
            $("#delegacion").val(response[0]['delegacion']);
            $("#estado").val(response[0]['estado']);
            $("#colonia").val(response[0]['colonia']);
            $("#street").val(response[0]['STREET_NUMBER']);
            $("#latitud").val(response[0]['LATITUD']);
            $("#longitud").val(response[0]['LONGITUD']);
            $("#group").val(response[0]['id_group']);
            $("#fcedula").val(response[0]['NUMBER_PROFESSIONAL_CERTIFICATE']);
            $("#hora_entrada").val(response[0]['entry_time']);
            $("#hora_salida").val(response[0]['departure_time']);
            $("#cedulaespe").val(response[0]['NUMBER_SPECIALTY_CERTIFICATE']);
            $("#autoComplete").val(response[0]['formacion']);
            $("#id_especial").val(response[0]['especialidad_id']);
            $("#codigo").val(response[0]['code']);
            $('#loader').toggle();
    }).catch(err => alert(err));
}

//Envio de formulario POST 
let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true) : notificacion(response.msg, false)
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

//ARCHIVO DE LA FIRMA DEL RESPONSABLE
$(document).on('change', '#file_firma', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_firma").files[0];

    if (ext == "png") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato png",
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

//ARCHIVO DE LA INE
$(document).on('change', '#file_ine_medico', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_ine_medico").files[0];

    if (ext == "jpeg" || "png" || "jpg") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato png, jpg o jpeg",
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

//Enviar actualizacion de los datos del responsable
$(document).on('submit', '#formUpdate_Resp', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Personales/updateResp`;
    let FORMDATA = new FormData($(this)[0]);
    send(url, FORMDATA);
});



//Grupo medico al cual va a pertenecer el operativo
function obtenerGrupo() {
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/getGroup`;
    var disc = $(".grupo");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`); 
            });
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}


$(document).on('submit', '#form_actualizar', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Generales/Recuperar_password/change_password`
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json', 
        success: function (data) {
            console.log(data);
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                document.getElementById("form_actualizar").reset();
                location.href = `${BASE_URL}`
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
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#myModal').modal('toggle');
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
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    }); 
    return false;
});

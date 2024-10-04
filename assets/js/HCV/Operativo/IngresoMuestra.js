obtenerUnidad();



$("#business_unit").on('change', function(){
    id_unit = $("#business_unit").val();
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/Laboratorio/Consultorio/readRooms`;
    var consultorio = $("#consultorio");
    $.ajax({
        url: URL,
        method: 'POST',
        data: {id: id_unit},
        dataType: 'json',
        success: function (data) {
            console.log("aqui");
            console.log(data);
            consultorio.empty();
            consultorio.append(`<option value="">Selecciona un consultorio</option>`);
            $(data).each(function (i, v) {
                consultorio.append(`<option value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
});

/* GUARDA DATOS DE LA PESTAÑA DE DIAGNOSTICO NUTRICIONAL */
$(document).on('submit', '#ingresoMuestras', function () {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/primerIngreso`;

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
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();
                location.href = `${BASE_URL}HCV/Operativo/TomarMuestras`
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();                
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

//Grupo medico el cual va a pertenecer el operativo
function obtenerUnidad() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/BusinessUnit/readBusiness`;
    var disc = $("#unidad_negocio");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una unidad de negocio</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Unidades de negocio que selecciona el tomador de muestra al iniciar sesion
let unidadTomador = () =>{
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Catalogos/BusinessUnit/readBusiness`;
    var unit = $("#business_unit");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            unit.append(`<option value="">Selecciona una unidad de negocio</option>`);
            $(data).each(function (i, v) {
                unit.append(`<option value="${v.id_business_unit}"> ${v.unidad_negocio}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}
unidadTomador();
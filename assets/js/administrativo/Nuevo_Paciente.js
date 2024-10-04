//VALIDAR FORMULARIO//

get_paises();
initMap();
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

//validar formulario 
const formulario = document.getElementById('ficha_paciente');
const inputs = document.querySelectorAll('#ficha_paciente input');

const expresiones = {
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    password: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/
}

const campos = {
    correo: false,
    password: false
}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "correo":
            validarCampo(expresiones.correo, e.target, 'correo');
            break;
        case "password":
            validarCampo(expresiones.password, e.target, 'password');
            break;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
        campos[campo] = true;
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
        document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
        campos[campo] = false;
    }
}


$("#autocomplete").keyup(function() {
    $('#latitud').val('');
    $('#longitud').val('');
});

//mapa//
function initMap(lat, lng) {
    console.log("soy la latitud" + lat);
    var marker;
    let map;

    if (lat == null && lng == null) {
        var myLatLng = {
            lat: 19.398894572801836,
            lng: -99.15639584258695
        };

    } else {
        var myLatLng = {
            lat: lat,
            lng: lng
        };

    }
    map = new google.maps.Map(document.getElementById("map"), {
        center: myLatLng,
        zoom: 13,
    });

    const input = document.getElementById("autocomplete");

    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        draggable: true,
        title: "Ubicacion"

    });


    google.maps.event.addListener(marker, "dragend", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        getReverseGeocodingData(lat, lng);

    });

    function getReverseGeocodingData(lat, lng) {
        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'latLng': latlng
        }, (results, status) => {
            if (status !== google.maps.GeocoderStatus.OK) {
                alert(status);
            }
            // This is checking to see if the Geoeode Status is OK before proceeding
            if (status == google.maps.GeocoderStatus.OK) {
                console.log("resultados" + results);
                address = results[0].formatted_address;
                $('#autocomplete').val(address);
                $('#latitud').val(lat);
                $('#longitud').val(lng);
                // inicio = $('#autocomplete').val()
            }
        });
    }

}

//buscar btn//
$(document).on('click', '#submit_form_busqueda', function() {

    if ($("#autocomplete").val().length < 1) {
        alert("La direccion es obligatoria");
        $("#autocomplete").focus();
        return false;
    } else {
        $('#loader').toggle();
        var url_str = BASE_URL + 'Operativo/Hcv_Rest_Identificacion/data_mapa';
        var loginForm = $("#ficha_paciente").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
            }
        );
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                //console.log(result);
                $('#loader').toggle();
                $('#autocomplete').val(result.formattedAddress);
                inicio = $('#autocomplete').val();
                lng = result.longitude;
                lat = result.latitude,
                    console.log("longitud" + lng);
                $('#latitud').val(lat);
                $('#longitud').val(lng);
                initMap(lat, lng);
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
            }
        })
    }
});



function get_paises() {
    $.getJSON("../../../assets/js/general/countrys.json", function(json) {
        var paises = $("#nacionalidad");
        $(json).each(function(i, v) { // indice, valor
            paises.append('<option  value="' + v.name + '">' + v.name + '</option>');
        })
    });
}

function get_formacion(id_formacion) {
    const url = BASE_URL + 'Administrativo/Hcv_Rest_Paciente/get_formacion';

    formacion = {
        id_formacion: id_formacion
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(formacion),
        success: function(data) {
            console.log(data);
            $('#formacion').val(data[0].ACADEMIC_FORMATION);
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

}




$("#submit_ficha").on("click", function() {
    $('#loader').toggle();
    //console.log("aqui");
    //console.log(campos.correo);
    var form = $("#ficha_paciente");
    var formData = new FormData(form[0]);

    let nombre = $('#nombre').val();
    let latitud = $('#latitud').val();
    let apellido = $("#apellido").val();
    let s_apellido = $("#segundo_apellido").val();
    let fecha = $("#fecha").val();
    let cp = $("#cp_search").val();
    let telefono = $('#telefono').val();


    const val_nombre = validar(nombre);
    const val_apellido = validar(apellido);
    const val_s_apellido = validar(s_apellido);
    const val_fecha = validar(fecha);
    const val_cp = validar(cp);
    const val_telefono = validar(telefono);
    const val_direccion = validar(latitud);


    if (val_nombre && val_apellido && val_fecha && val_cp && val_telefono && campos.correo) {
        if(val_direccion){
            $.ajax({
                url: BASE_URL + 'Administrativo/Rest_Nuevo_Paciente',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    $('#loader').toggle();
                    console.log(data)

                    switch (data.status) {
                        case 200:
                            location.href = BASE_URL + "/Administrativo/Pacientes_cita";
                            break;
                        case 201:
                            alert(data.messages.success);
                            break;
                        case 400:
                            alert(data.messages.warning)
                            break;

                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }else{
            alert("Debes de buscar tu dirección con el marcador del mapa");
        }

    } else {
        alert("Faltan campos por llenar");

    }


});


function validar(valor) {
    if (valor != "") {
        return true;
    } else {
        return false;
    }
}
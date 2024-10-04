//VALIDAR FORMULARIO//

get_paises();
initMap();


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
                            console.log("resultados"+results);
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
        var url_str = BASE_URL +'Operativo/Hcv_Rest_Identificacion/data_mapa';
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
                console.log("longitud"+lng);
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



$("#submit_ficha").on("click", function () {
    $('#loader').toggle();
    var form = $("#ficha_paciente");
    var formData = new FormData(form[0]);

    let nombre = $('#nombre').val();
    let apellido = $("#apellido").val();
    let fecha = $("#fecha").val();
    //let cp = $("#cp_search").val();
    let telefono = $('#telefono').val();
    let correo = $('#correo').val();
    const val_correo = validar_correo(correo);
    const val_nombre = validar(nombre);
    const val_apellido = validar(apellido);
    const val_fecha = validar(fecha);
    const val_telefono = validar(telefono);

    if(val_correo){
        if(val_nombre && val_apellido && val_fecha  && val_telefono && val_correo){
            $.ajax({
                url: BASE_URL + '/Operativo/Hcv_Rest_Paciente',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#loader').toggle();
                    console.log(data)
                    if(data.status == 200){
                        location.href = BASE_URL + "Hcv_Pacientes";
                    }else{
                        alert(data.messages)
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
    
        }else{
            alert("llena todos los campos requeridos");
    
        }

    }else{
        alert("Correo invalido");
    }

});


function validar(valor){
    if(valor != ""){
        return true;
    }else{
        return false;
    }
}

function validar_correo(correo){
    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    if (emailRegex.test(correo)) {
        return true;
      } else {
       return false;
      }



}

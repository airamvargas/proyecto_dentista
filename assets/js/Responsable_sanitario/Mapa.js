//Valores de latitud y longitud en el mapa 
$("#autocomplete").keyup(function() {
    $('#latitud').val('');
    $('#longitud').val('');
});

//Busqueda en el mapa de la direccion ingresada
$(document).on('click', '#submit_form_busqueda', function(e) {
    e.preventDefault();
    if ($("#autocomplete").val().length < 1) {
        //alert("La direccion es obligatoria");
        Toastify({
            text: "La dirección es obligatoria",
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
        $("#autocomplete").focus();
        return false;
    } else {
        $('#loader').toggle();
        var url_str = `${BASE_URL}/Api/HCV/Operativo/Hcv_Rest_Identificacion/data_mapa`;
        var loginForm = $(".calle").val();
        var loginFormObject = {
            "STREET": loginForm
        };
        /* $.each(loginForm,
                function(i, v) {
                    loginFormObject[v.name] = v.value;
                }
            );*/
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
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
                $('#loader').toggle();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
            }
        })
    }
});

initMap();
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
academic();
search();
map();
get_data_direccion();
ojito();

$('#disciplina').val(disciplina);

function ojito() {
    $("#show_hide_password a").on('click', function (event) {
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


function search() {

    $("#cp_search").keyup(function () {
        console.log('Uno 2');
        var search2 = document.getElementById("cp_search").value;
        let searchresult2 = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Hcv_Rest_Cp/index';
        var cp = {
            "search": search2,
            "limit": "20",
            "offset": "0"

        };
        if (search2 != "") {
            let colonia;
            let alcaldia;
            let estado;
            let id;
            let info;

            $.ajax({
                url: url_str,
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(cp),
                success: function (response) {
                    info = response.data;
                    var len = info.length;
                    $("#cpResult").empty();
                    for (var i = 0; i < len; i++) {
                        id = info[i].ID;
                        var cp = info[i].CP;
                        colonia = info[i].ASENTAMIENTO;
                        alcaldia = info[i].MUNICIPIO;
                        estado = info[i].ESTADO;
                        allinfo = info[i];
                        $("#cpResult").append("<li value='" + id + "'>" + cp + ", " + colonia + "</li>");
                    }

                    // binding click event to li
                    $("#cpResult li").bind("click", function () {
                        var value = $(this).text();
                        var id2 = this.value
                        $("#cp_search").val(value);
                        console.log(info);
                        console.log(id2)
                        $("#cpResult").empty();
                        var len = info.length;
                        for (var i = 0; i < len; i++) {
                            if (info[i].ID == id2) {
                                $("#colonia").val(info[i].ASENTAMIENTO);
                                $("#delegacion").val(info[i].MUNICIPIO);
                                $("#estado").val(info[i].ESTADO);
                                $('#cp_id').val(info[i].CP);
                                console.log(info[i])
                            }
                        }
                    });
                }
            });
        }
    });
}

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


    google.maps.event.addListener(marker, "dragend", function (event) {
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
                console.log(results);
                address = results[0].formatted_address;
                $('#calle').val(address);
                // inicio = $('#autocomplete').val()
                $('#LATITUD').val(lat);
                $('#LONGITUD').val(lng);
            }
        });
    }

}

$(document).on('click', '#submit_form_busqueda', function () {

    if ($("#calle").val().length < 1) {
        alert("La direccion es obligatoria");
        $("#calle").focus();
        return false;
    } else {
        $('#loader').toggle();
        var url_str = BASE_URL + '/Operativo/Hcv_Rest_Identificacion/data_mapa';
        var loginForm = $("#ficha_update").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function (i, v) {
                loginFormObject[v.name] = v.value;
            }
        );
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function (result) {
                //console.log(result);
                $('#loader').toggle();
                $('#calle').val(result.formattedAddress);
                inicio = $('#calle').val();
                lng = result.longitude;
                lat = result.latitude,
                    $('#LATITUD').val(lat);
                $('#LONGITUD').val(lng);
                initMap(lat, lng);
            },
            error: function (xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
            }
        })
    }
});


function map() {
    let lat = $('#LATITUD').val();
    let lon = $('#LONGITUD').val();

    initMap(parseFloat(lat), parseFloat(lon));


}


function academic() {

    $("#academic").keyup(function () {

        var url_str = BASE_URL + '/Hcv_Rest_Academic/get_academic_update';
        console.log('Uno 2');
        var search2 = document.getElementById("academic").value;
        let searchresult2 = document.getElementById("searchResult");
        var cp = {
            "search": search2,
            "limit": "10",
            "offset": "0"

        };
        if (search2 != "") {
            let colonia;
            let alcaldia;
            let estado;
            let id;
            let info;

            $.ajax({
                url: url_str,
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(cp),
                success: function (response) {
                    info = response.data;
                    var len = info.length;
                    $("#cpResult").empty();
                    for (var i = 0; i < len; i++) {
                        id = info[i].ID;

                        let academic_name = info[i].ACADEMIC_FORMATION;
                        $("#cpResultAcademic").append("<li value='" + id + "'>" + academic_name + "</li>");
                    }

                    // binding click event to li
                    $("#cpResultAcademic li").bind("click", function () {
                        var value = $(this).text();
                        var id2 = this.value
                        $("#academic").val(value);
                        console.log(info);
                        console.log(id2)
                        $("#cpResultAcademic").empty();


                    });
                }
            });
        }
    });
}


function get_data_direccion() {
    var url_str = BASE_URL + 'Administrativo/Rest_operativos/get_cp_data';
    let id_cp = $('#cp_search').val();
    var cp = {
        id_cp

    };
    $.ajax({
        url: url_str,
        type: 'POST',
        dataType: 'json',
        data: cp,
        success: function (response) {
            console.log(response.data[0].CP);
            $('#cp_search').val(response.data[0].CP);
            $('#delegacion').val(response.data[0].MUNICIPIO);
            $('#estado').val(response.data[0].ESTADO);
            $('#colonia').val(response.data[0].ASENTAMIENTO);
        }
    });
}
/* if(tipo === "1"){
    $('#postal').hide();
    $('#del').hide();
    $('#est').hide();
    $('#col').hide();
    $('#cp_id').val("0");
   
   
}else{
    $('#postal').show();
    $('#del').show();
    $('#est').show();
    $('#col').show();

}
  */
initMap();
get_paises();
get_estados();
get_identy();
passwd();
//get_sector();

/* var switchStatus = false;
$("#verificado").val(switchStatus)
$("#verificado").on('change', function() {
    if ($(this).is(':checked')) {
        switchStatus = $(this).is(':checked');
        $("#verificado").val(switchStatus)

       // alert(switchStatus);// To verify
    }
    else {
       switchStatus = $(this).is(':checked');
       $("#verificado").val(switchStatus)
    }
});
 */



$(document).ready(function() {





});


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
    password: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/
}

const campos = {
    password: false
}

const validarFormulario = (e) => {
    switch (e.target.name) {
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

    const input = document.getElementById("calle");

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
                console.log(results);
                address = results[0].formatted_address;
                $('#calle').val(address);
                $('#latitud').val(lat);
                $('#longitud').val(lng);
                // inicio = $('#autocomplete').val()
            }
        });
    }

}


function get_paises() {
    $.getJSON("../../../../../assets/js/general/countrys.json", function(json) {
        var paises = $("#nacionalidad");
        $(json).each(function(i, v) { // indice, valor
            paises.append('<option  value="' + v.name + '">' + v.name + '</option>');
        })
    });
}


$(document).ready(function() {
    $("#religion").keyup(function() {
        var search = document.getElementById("religion").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Operativo/Hcv_Rest_Paciente/get_religiones';
        var language = {
            "search": search,
            "limit": "10",
            "offset": "0"

        };
        console.log(language);
        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(language),
            success: function(response) {
                let info = response.data;
                console.log(info);
                var len = info.length;
                $("#searchResult").empty();
                for (var i = 0; i < len; i++) {
                    var id = info[i].ID;
                    var name = info[i].RELIGION;
                    console.log("searchResult")
                    $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");

                }

                // binding click event to li
                $("#searchResult li").bind("click", function() {
                    var value = $(this).text();
                    var id = this.value;
                    $("#religion").val(value);
                    $('#id_religion').val(id)
                    $("#searchResult").empty();
                });
            }
        });
    });
});

//get_paises();
// get_religiones();

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$("#especial").keyup(function() {

    var searchresult = document.getElementById("esResult");
    var especialidad = $('#especial').val();
    var url_str = BASE_URL + '/Operativo/Hcv_Rest_Paciente/get_academic';
    var language = {
        "especialidad": especialidad,
        "limit": "20",
        "offset": "0"

    };
    $.ajax({
        url: url_str,
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(language),
        success: function(response) {
            let info = response.data;
            console.log(info);
            var len = info.length;
            $("#esResult").empty();
            for (var i = 0; i < len; i++) {
                var id = info[i].ID;
                var name = info[i].ACADEMIC_FORMATION;

                console.log("searchResult")
                $("#esResult").append("<li value='" + id + "'>" + name + "</li>");

            }

            // binding click event to li
            $("#esResult li").bind("click", function() {
                var value = $(this).text();
                var id = this.value;
                $("#especial").val(value);
                $("#id_academic").val(id);
                $("#esResult").empty();
            });
        }
    });
});



$(document).ready(function() {
    $("#pepe").keyup(function() {
        var search = document.getElementById("pepe").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Hcv_Rest_Indigenous_l';
        var language = {
            "search": search,
            "limit": "10",
            "offset": "0"

        };
        console.log(language);
        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(language),
            success: function(response) {
                let info = response.data;
                console.log(info);
                var len = info.length;
                $("#searchResult").empty();
                for (var i = 0; i < len; i++) {
                    var id = info[i].ID;
                    var name = info[i].SCIENTIFIC_NAME;
                    console.log("searchResult")

                    $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");

                }

                // binding click event to li
                $("#searchResult li").bind("click", function() {
                    var value = $(this).text();
                    $("#pepe").val(value);
                    $("#searchResult").empty();
                });
            }
        });
    });
});


$(document).ready(function() {
    $("#cp_search").keyup(function() {
        var search2 = document.getElementById("cp_search").value;
        let searchresult2 = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Hcv_Rest_Cp';
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
                success: function(response) {
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
                    $("#cpResult li").bind("click", function() {
                        var value = $(this).text();
                        var id2 = this.value
                        $("#cp_search").val(value);

                        ///////////VAMOS A MANDAR ID CP PARA REGRESAR COBERTURA Y TIPO DE MEMBRESIA/////

                        var url_cp = BASE_URL + "/Administrativo/Rest_Alta_Rsm";

                        const ajax = {
                            id_cp: id2
                        }

                        $.ajax({
                            url: url_cp,
                            type: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(ajax),
                            success: function(response) {
                                console.log(response);
                                var array = response.length;
                                let membresia = $('#membresia');
                                if (array === 0) {
                                    membresia.empty();
                                    membresia.append('<option  value="">Selecciona Membresia</option>');
                                    membresia.append('<option  value="1">' + "Sin membresia" + '</option>');
                                    $('#cobertura').val("Sin cobertura");
                                    $('#sector').val("sin sector");


                                } else {
                                    membresia.empty();
                                    membresia.append('<option  value="">Selecciona Membresia</option>');
                                    $(response).each(function(i, v) { // indice, valor
                                        console.log("valor" + v.id);
                                        membresia.append('<option  value="' + v.id_membresia + '">' + v.name + '</option>');
                                    });
                                    $('#cobertura').val("Con cobertura");
                                    $('#sector').val(response[0].id_hcv_cat_sector);
                                }
                            }

                        });


                        console.log(info);
                        console.log(id2)
                        $("#cpResult").empty();
                        var len = info.length;
                        for (var i = 0; i < len; i++) {
                            if (info[i].ID == id2) {
                                $("#colonia").val(info[i].ASENTAMIENTO);
                                $("#delegacion").val(info[i].MUNICIPIO);
                                $("#estado").val(info[i].ESTADO);
                                $('#cp_id').val(info[i].ID);
                                console.log(info[i])
                            }
                        }
                    });
                }
            });
        }
    });
});

$(document).on('click', '.btn-danger', function() {
    let id = $(this).attr('id');
    $('#id_delete').val(id);
    $('#modal_delete').modal('show');
})




$('.alert .close').on('click', function(e) {
    $(this).parent().hide();
});

function reloadData() {
    $('#loader').toggle();
    sendFormDel.ajax.reload();
    $('#loader').toggle();
}

// Datepicker
/*  $('.fc-datepicker').datepicker({
     showOtherMonths: true,
     selectOtherMonths: true
 });

 $('#datepickerNoOfMonths').datepicker({
     showOtherMonths: true,
     selectOtherMonths: true,
     numberOfMonths: 2
 }); */


$(document).ready(function() {
    $('#genero').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#othergender').show();
        } else {
            $('#othergender').hide();
        }
    })
});

$(document).ready(function() {
    $('#info').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#otherinfo').show();
        } else {
            $('#otherinfo').hide();
        }
    })
});

$(document).ready(function() {
    let Checked = null;
    //The class name can vary
    for (let CheckBox of document.getElementsByClassName('check')) {
        CheckBox.onclick = function() {
            if (Checked != null) {
                Checked.checked = false;
                Checked = CheckBox;
            }
            Checked = CheckBox;
        }
    }
});



//estados

$("#nacionalidad").change(function() {
    let nacionalidad = $('#nacionalidad').val();
    let estados = $('#estados');

    //alert(nacionalidad);

    if (nacionalidad != "Mexico") {
        estados.empty();
        estados.append('<option  value="">Selecciona lugar de nacimiento</option>');
        estados.append('<option  value="NE">' + "NE" + '</option>');

    } else {
        const ruta = BASE_URL + "/Operativo/Hcv_Rest_Paciente/get_estados";

        $.ajax({
            type: "GET",
            url: ruta,
            dataType: "JSON",
            success: function(data) {
                estados.empty();
                estados.append('<option  value="">Selecciona lugar de nacimiento</option>');
                $(data).each(function(i, v) { // indice, valor
                    console.log("valor" + v);
                    estados.append('<option  value="' + v.state + '">' + v.state + '</option>');
                });
            },
            error: function() {
                alert("Hubo un erro al obtener los datos");
            }

        })

    }
});

function get_estados() {
    let estado = $('#estados');
    if (lugar != "Mexico") {
        estado.empty();
        estado.append('<option  value="">Selecciona lugar de nacimiento</option>');
        estado.append('<option  value="NE">' + "NE" + '</option>');

    } else {
        const ruta = BASE_URL + "/Operativo/Hcv_Rest_Paciente/get_estados";

        $.ajax({
            async: false,
            type: "GET",
            url: ruta,
            dataType: "JSON",
            success: function(data) {

                estado.empty();
                estado.append('<option  value="">Selecciona lugar de nacimiento</option>');
                $(data).each(function(i, v) { // indice, valor
                    console.log("valor" + v);
                    estado.append('<option  value="' + v.state + '">' + v.state + '</option>');
                });

                $('#estados').val(data[0].BIRTHPLACE);
            },
            error: function() {
                alert("Hubo un erro al obtener los datos");
            }

        });

    }

}


function get_identy() {
    $('#loader').toggle();

    const url = BASE_URL + '/Operativo/Hcv_Rest_Paciente/get_identy';

    paciente = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(paciente),
        success: function(data) {
            console.log(data);
            $('#loader').toggle();
            $('#contraseña').val(data[0].password);
            $('#user').val(data[0].id);
            $('#correo').val(data[0].email);
            $('#update_password').val(data[0].password);
            $('#nacionalidad').val(data[0].COUNTRY);
            $('#estados').val(data[0].BIRTHPLACE);
            $('#curp').val(data[0].CURP);
            $('#nombre').val(data[0].NAME);
            $('#apellido').val(data[0].F_LAST_NAME);
            $('#se_apellido').val(data[0].S_LAST_NAME);
            $('#fecha').val(data[0].BIRTHDATE);
            $('#sexo').val(data[0].SEX);
            $('#calle').val(data[0].street_other);
            $('#latitud').val(data[0].LATITUD);
            $('#longitud').val(data[0].LONGITUD);
            $('#telefono').val(data[0].PHONE_NUMBER);
            $('#genero').val(data[0].ID_CAT_GENDER_IDENTITY);
            $('#other').val(data[0].other_gender);
            $('#especial').val(data[0].ID_CAT_ACADEMIC);
            $('#trabajo').val(data[0].JOB);
            $('#id_identy').val(data[0].ID);
            $('#civil').val(data[0].ID_CAT_MARITAL_STATUS);
            $('#tiene').val(data[0].membresia);
            $('#id_religion').val(data[0].ID_CAT_RELIGION);
            comunidad = data[0].ANSWER_INDIGENOUS_COMUNITY;
            if (comunidad === "Si") {
                $("#val-si").prop('checked', true);

            } else {
                $("#val-no").prop('checked', true);
            }
            $('#pepe').val(data[0].ANSWER_INDIGENOUS_LENGUAGE);
            $('#info').val(data[0].ID_CAT_TUTOR);
            $('#tutor').val(data[0].ANSWER_OTHER_TUTOR);
            $('#path').val(data[0].PATH);
            $('#delegacion').val(data[0].ID_CAT_MUNICIPALITY);
            $('#estado').val(data[0].ID_CAT_STATE_OF_RESIDENCE);
            $('#colonia').val(data[0].ID_CAT_TOWN);
            $('#cp_id').val(data[0].ID_ZIP_CODE);
            $('#fecha-vigencia').val(data[0].vigencia_membresia);
            $('#verify').val(data[0].verified);
            let info = data[0].ID_CAT_TUTOR;

            if (info === "otro") {
                $('#otherinfo').show();

            } else {
                $('#otherinfo').hide();

            }

            if (tipo == "1") {
                $('#rms').show();

            } else {
                $('#rms').hide();
            }

            let imagen = data[0].PATH;

            if (imagen === "") {
                let html = '';
                html += '<img style = "width: 100%;" src="../../../../../writable/uploads/profile/default.jpg" class="rounded-circle"/>'
                $('#imagen').html(html);
            } else {
                let html = '';
                html += '<img style = "width: 100%;" src="../../../../../writable/uploads/profile/' + imagen + '" class="rounded-circle"/>'
                $('#imagen').html(html);
            }

            let id_cp = data[0].ID_ZIP_CODE;
            let id_membresia = data[0].id_cat_membresia;

            var lng = parseFloat(data[0].LONGITUD);
            var lat = parseFloat(data[0].LATITUD);
            let id_religion = data[0].ID_CAT_RELIGION;
            initMap(lat, lng);
            buscar_Cp(id_cp);
            get_sector(id_cp, id_membresia);
            get_religion(id_religion);
            //get_formacion(id_formacion);
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

}

function buscar_Cp(cp) {
    const url = BASE_URL + '/Operativo/Hcv_Rest_Paciente/get_cp';

    cp = {
        id_cp: cp
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(cp),
        success: function(data) {
            $('#cp_search').val(data[0].CP);
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });


}

function get_religion(id_religion) {
    const url = BASE_URL + 'Administrativo/Rest_update_ficha/get_religion';

    religion = {
        id_religion: id_religion
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(religion),
        success: function(data) {
            console.log(data);
            $('#religion').val(data[0].RELIGION);
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

}

function get_formacion(id_formacion) {
    const url = BASE_URL + 'Administrativo/Rest_update_ficha/get_formacion';

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
    //alert("di un click");

    let rsm = $('#toggle').prop('checked');

    if (rsm) {

        $('#loader').toggle();
        var form = $("#ficha_paciente");
        var formData = new FormData(form[0]);
        let nombre = $('#nombre').val();
        let apellido = $("#apellido").val();
        let fecha = $("#fecha").val();
        let cp = $("#cp_id").val();
        let telefono = $('#telefono').val();

        const val_nombre = validar(nombre);
        const val_apellido = validar(apellido);
        const val_fecha = validar(fecha);
        const val_cp = validar_local_cp(cp);
        const val_telefono = validar(telefono);

        if (campos.password && val_cp) {
            if (val_nombre && val_apellido && val_fecha && val_telefono && campos.password && val_cp) {
                $.ajax({
                    url: BASE_URL + '/Administrativo/Rest_update_ficha/update_paciente',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        $('#loader').toggle();
                        console.log(data)
                        if (data.status == 200) {
                            $('#success').text(data.messages.success);
                            $('#succes-alert').toggle();
                            location.href = BASE_URL + "Administrativo/Pacientes_cita";

                        } else {
                            alert(data.messages)
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            } else {
                alert("llena todos los campos requeridos");
                $('#loader').toggle();

            }

        } else {
            alert("EL usuario debe contener una constraseña y un codigo postal");
            $('#loader').toggle();
        }


    } else {
        //alert("no es local");
        $('#loader').toggle();
        var form = $("#ficha_paciente");
        var formData = new FormData(form[0]);
        let nombre = $('#nombre').val();
        let apellido = $("#apellido").val();
        let fecha = $("#fecha").val();
        let cp = $("#cp_id").val();
        let telefono = $('#telefono').val();


        const val_nombre = validar(nombre);
        const val_apellido = validar(apellido);
        const val_fecha = validar(fecha);
        const val_cp = validar(cp);
        const val_telefono = validar(telefono);


        if (val_nombre && val_apellido && val_fecha && val_telefono) {
            $.ajax({
                url: BASE_URL + '/Administrativo/Rest_update_ficha/update_paciente',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    $('#loader').toggle();
                    console.log(data)
                    if (data.status == 200) {
                        $('#success').text(data.messages.success);
                        $('#succes-alert').toggle();
                        location.href = BASE_URL + "Administrativo/Pacientes_cita";

                    } else {
                        alert(data.messages)
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        } else {
            alert("llena todos los campos requeridos");
            $('#loader').toggle();

        }



    }

});


function validar(valor) {
    if (valor != "") {
        return true;
    } else {
        return false;
    }
}

function validar_local_cp(codigo) {
    if (codigo == 0 || codigo == "") {
        return false;
    } else {
        return true;
    }
}



$(document).on('click', '#submit_form_busqueda', function() {

    if ($("#calle").val().length < 1) {
        alert("La direccion es obligatoria");
        $("#calle").focus();
        return false;
    } else {
        $('#loader').toggle();
        var url_str = BASE_URL + "/Operativo/Hcv_Rest_Identificacion/data_mapa";
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
                $('#calle').val(result.formattedAddress);
                inicio = $('#calle').val();
                lng = result.longitude;
                lat = result.latitude;

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


function get_sector(id_cp, id_membresia) {


    const url = BASE_URL + 'Administrativo/Rest_update_ficha';

    sector = {
        id_cp: id_cp
    }

    $.ajax({
        url: url, // url where to submit the request
        type: "POST", // type of action POST || GET
        dataType: 'JSON', // data type
        data: JSON.stringify(sector), // post data || get data
        success: function(result) {


            if (result.status == "210") {
                let membresia = $('#membresia');
                membresia.empty();
                /*  membresia.append('<option  value="">Selecciona Membresia</option>'); */
                membresia.append('<option  value="1">Sin Membresia</option>');
                /*    membresia.append('<option  value="NE">' + "NA" + '</option>'); */
                $('#cobertura').val("Sin cobertura");

            } else {
                $('#sector').val(result[0].sector);
                var array = result.length;
                let membresia = $('#membresia');

                if (array === 0) {

                    membresia.empty();
                    /*   membresia.append('<option  value="">Selecciona Membresia</option>'); */
                    membresia.append('<option  value="1">Sin Membresia</option>');
                    membresia.append('<option  value="NE">' + "NA" + '</option>');
                    $('#cobertura').val("Sin cobertura");

                } else {

                    membresia.empty();
                    /*  membresia.append('<option  value="">Selecciona Membresia</option>'); */
                    membresia.append('<option  value="1">Sin Membresia</option>');
                    $(result).each(function(i, v) { // indice, valor
                        console.log("valor" + v.id);
                        membresia.append('<option  value="' + v.id_membresia + '">' + v.name + '</option>');
                    });
                    $('#cobertura').val("Con cobertura");

                    get_membresia(id_membresia);

                }

            }

        },
        error: function(xhr, text_status) {
            //console.log(xhr, text_status);
            //$('#loader').toggle();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
        }
    })




}

function get_membresia(id_membresia) {
    $('#membresia').val(id_membresia);


}
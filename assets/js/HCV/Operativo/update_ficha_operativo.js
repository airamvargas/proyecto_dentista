update_ficha();
data_academic();
sendFormNew();
initMap();

$("#calle").keyup(function() {
    $('#latitud').val('');
    $('#longitud').val('');

});

////ARCHIVOS///
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


///especialidad///
$("#especial").keyup(function() {
    
    var searchresult = document.getElementById("esResult");

    var especialidad = $('#especial').val();
    var url_str = BASE_URL + "/Operativo/Hcv_Rest_Identificacion/get_especialidad";
        var language = {
            "especialidad": especialidad,
            "limit": "10",
            "offset": "0"

        };
        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(language),
            success: function(response) {
                console.log(response)
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
                    $("#especial").val(value);
                    $("#esResult").empty(); 
                });
            }
        }); 
});


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

$(document).on('click', '#submit_form_busqueda', function() {

    if ($("#calle").val().length < 1) {
        alert("La direccion es obligatoria");
        $("#calle").focus();
        return false;
    } else {
        $('#loader').toggle();
        var url_str = BASE_URL + "HCV/Operativo/Hcv_Rest_Identificacion/data_mapa";
        var loginForm = $("#ficha_update").serializeArray();
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


function data_academic() {
    var url_str = BASE_URL + "/Hcv_Rest_Academic";

    $.ajax({
        url: url_str,
        type: "GET",
        dataType: 'json',
        success: function(result) {
            if (result.status == 200) {

                $('#success').text(result);
                $('#succes-alert').show();
                //reloadData();

                let id = result.data
                let data_length = id.length

                let academico = document.getElementById("academico")

                console.log(academico)

                for (i = 0; i <= data_length; i++) {


                    var option = document.createElement("option");
                    option.innerHTML = id[i].ACADEMIC_FORMATION;
                    option.value = id[i].ID;
                    academico.appendChild(option);
                }

            } else {
                $('#error').text(result.error);
                $('#error-alert').show();
            }
            //$('#loader').toggle();

        },
        error: function(xhr, resp, text) {
            console.log(xhr, resp, text);
            $('#loader').toggle();
            $('#error-alert').show();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

        }
    })

}

$(document).ready(function() {

    $("#pepe").keyup(function() {
        var search = document.getElementById("pepe").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = BASE_URL + "/Hcv_Rest_Indigenous_L";
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
        var url_str = BASE_URL + "/Hcv_Rest_Cp";
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


function sendFormNew() {
    $(document).on('click', '#submit_ficha', function() {
        var url_str = BASE_URL + "/Hcv_Rest_Identity/create";
        var loginForm = $("#ficha_description").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
                console.log(loginFormObject)
            }
        );
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'json', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();

                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }

            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        })
    });
}

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


update_ficha();

const formulario = document.getElementById('ficha_update');
const inputs = document.querySelectorAll('#ficha_update input');

const expresiones = {
	//usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
	segundo_apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // 4 a 12 digitos.
    descripcion: /^[a-zA-ZÀ-ÿ\s]{1,60}$/,
    //cp: /^[a-zA-Z0-9\_\-]{4,16}$/,
    calle: /^[a-zA-ZÀ-ÿ\s-.-0-9\S-,-#]{4,200}$/,
    cedula: /^\d{7,8}$/,
    c_especialidad: /^\d{7}$/,
	//correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{10}$/ // 7 a 14 numeros.
}

const campos = {
	nombre: false,
	apellido: false,
	segundo_apellido: false,
	telefono: false,
    descripcion: false,
    //cp:false,
    calle: false,
    cedula: false,
    c_especialidad:false,
    //telefono: false,
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "NAME":
			validarCampo(expresiones.nombre, e.target, 'NAME');
		break;
		case "F_LAST_NAME":
			validarCampo(expresiones.apellido, e.target, 'F_LAST_NAME');
		break;
		case "S_LAST_NAME":
			validarCampo(expresiones.segundo_apellido, e.target, 'S_LAST_NAME');
		break;
		/* case "BIRTHDATE":
            validarCampo(expresiones.fecha, e.target, 'BIRTHDATE');
			
		break; */
		case "descrip":
			validarCampo(expresiones.descripcion, e.target, 'descrip');
		break;
		/* case "ZIP_CODE":
			validarCampo(expresiones.cp, e.target, 'ZIP_CODE');
		break; */
        case "STREET":
			validarCampo(expresiones.calle, e.target, 'STREET');
		break;
        case "fcedula":
			validarCampo(expresiones.cedula, e.target, 'fcedula');
		break;
        case "cedulaespe":
			validarCampo(expresiones.c_especialidad, e.target, 'cedulaespe');
		break;
        case "PHONE_NUMBER":
			validarCampo(expresiones.telefono, e.target, 'PHONE_NUMBER');
		break;
       
	} 
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
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

function update_ficha() {
    $('#loader').toggle();
    let json = {
        id: idmedico
    };
    let url = BASE_URL + 'Operativo/Hcv_Rest_Identificacion/get_medico';
    let objson = JSON.stringify(json);
    console.log(objson);
    $.ajax({
        url: url,
        data: objson,
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {

            console.log(success);
            $('#first_name').val(success[0].NAME);
            $('#last_name').val(success[0].F_LAST_NAME);
            $('#s_name').val(success[0].S_LAST_NAME);
            $('#birthdate').val(success[0].BIRTHDATE);
            $('#des_personal').val(success[0].DESC_PERSONAL);
            $('#cp_search').val(success[0].CP);
            $('#delegacion').val(success[0].MUNICIPIO);
            $('#estado').val(success[0].ESTADO);
            $('#colonia').val(success[0].ASENTAMIENTO);
            $('#calle').val(success[0].STREET_NUMBER);
            $('#telfono').val(success[0].PHONE_NUMBER);
            $('#file_name_pro').val(success[0].FILE_USER);
            $('#file_name_cedula').val(success[0].FILE_PROFESSIONAL_CERTIFICATE);
            $('#file_name_especialidad').val(success[0].FILE_SPECIALTY);
            $('#file_name_ine').val(success[0].FILE_INE);
            $('#cp_id').val(success[0].CAT_CP_ID);
            $('#id_operativo').val(success[0].ID);
            $('#especial').val(success[0].SPECIALTY);
            $('#disciplina').val(success[0].DISCIPLINE);
            $('#codigo').val(data[0].code);

            var longitud = parseFloat(success[0].LONGITUD);
            var latitud =  parseFloat(success[0].LATITUD);

            $('#latitud').val(latitud);
            $('#longitud').val(longitud);

            initMap(latitud,longitud);
        
            let imagen = success[0].FILE_USER;
            let ine = success[0].FILE_INE.toString();
          
            if(ine != ""){
                let html = '';
                html += '<button id="arc" type="button" class="btn btn-indigo" data-index="'+ine+'" style="border-radius: 10px;"> VER INE </button>'
                $('#archivo').html(html);

                $("#arc").on("click" ,function(){
                    var archivo = $(this).data('index');
                    let url = '../../../../writable/uploads/operativo/'+archivo+'';
                    window.open(url, "INE", "width=300, height=200");
                });
            }

            if(imagen === ""){
                let html = '';
                html += '<img style = "width: 100%;" src="../../../../writable/uploads/profile/default.jpeg" class="rounded-circle"/>'
                $('#imagen').html(html);

            }else{
                let html = '';
                html += '<img style = "width: 100%;" src="../../../../writable/uploads/operativo/' + success[0].FILE_USER + '" class="rounded-circle"/>'
                $('#imagen').html(html);
            }
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

}


/////////////UPDATE FORMULARIO OPERATIVO////////
$("#btn_actualizar").on("click", function () {
    $('#loader').toggle();
    var form = $("#ficha_update");
    var formData = new FormData(form[0]);

    $.ajax({
        url: BASE_URL + 'Operativo/Hcv_Rest_Identificacion/operativo_update',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            $('#loader').toggle();
            console.log(data)
            if (data.status == 200) {
                //alert("echo");
                $('#success').text(data.messages.success);
                $('#succes-alert').show();
                location.href = BASE_URL + "Operativo/Hcv_operativo_principal";
            } else {
                //alert(data.messages)
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


//ejemplos de js es6//
//NODE JS//

//DECALARAR UNA FUNCION DE FLECHA
const x = (x, y) => x * y;
let total = x(10,20);
console.log(total);

//RECORRER UNA ARREGLO CON FOR ARRAYNEW ONTIENE LOS VALORES
const array = [1,2,3,4];
for(let arraynew of array){
   // console.log(array);
}

//CREACION DE MAP DE OBJETOS 
const apples = {name: 'Apples'};
const bananas = {name: 'Bananas'};
const oranges = {name: 'Oranges'};

const fruits = new Map();

fruits.set(apples, {precio:500});
fruits.set(bananas, 300);
fruits.set(oranges, 200)

for(let arraynew2 of fruits){
    for(let valores of arraynew2){
        console.log(valores.name);
    }
}

//metodo set para agregar array//



const letters = new Set();
letters.add({letra:"a"});
letters.add("b");
letters.add("c");

console.log(letters);

class Car {
    constructor(name, year) {
      this.name = name;
      this.year = year;
    }
}

class Car2021 {
    constructor(color){
       this.color;
    }
} 

const myCar = new Car("Ford", 2014);
const carnew = new Car2021("color");

console.log(carnew);










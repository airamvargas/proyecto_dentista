//FOTO DE PERFIL DE FICHA DE IDENTIFICACION DEL PACIENTE
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

data_academic();
initMap();
//sendFormNew();

/*Validacion de un codigo postal valido*/
/* document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("paciente_insert").addEventListener('submit', validarFormulario);
}); */

function validarFormulario(evento) {
    evento.preventDefault();
    var id_cp = document.getElementById('id_original').value;
    console.log(id_cp);
    if (id_cp == 0 || id_cp == '') {
        alert('Código postal inválido.');
        return;
    }
    this.submit();
}

$("#cp_search").keyup(function() {
    $("#id_original").val('');
});

//Select con el catalogo de nacionalidades
nacionalidad();
function nacionalidad() {
    $("#nacionalidad").change(function() {
        let nacionalidad = $('#nacionalidad').val();
        let estados = $('#birthplace');

        if (nacionalidad != "México") {
            estados.empty();
            estados.append('<option  value="">Selecciona lugar de nacimiento</option>');
            estados.append('<option  value="NE">' + "NE" + '</option>');
        } else {
            const ruta = BASE_URL + "/Operativo/Hcv_Rest_Paciente/get_estados";
            console.log(ruta);
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
}

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
        var url_str = `${BASE_URL}/Operativo/Hcv_Rest_Identificacion/data_mapa`;
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
//Aqui termina lo del mapa

//Predictivo con el catalogo de formacion academica
data_academic();
function data_academic() {
    var url_str = `${BASE_URL}Hcv_Rest_Academic`;
    $.ajax({
        url: url_str,
        type: "GET",
        dataType: 'json',
        success: function(result) {
            if (result.status == 200) {
                $('#success').text(result);
                $('#succes-alert').show();
                //reloadData();
                let id = result.data;
                let data_length = id.length;
                let academico = document.getElementById("academico");
                for (i = 0; i < data_length; i++) {
                    var option = document.createElement("option");
                    option.innerHTML = id[i].ACADEMIC_FORMATION;
                    option.value = id[i].ID;
                    academico.appendChild(option);                    
                }
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
        }
    })
}

//Predictivo con el catalogo de lenguas indigenas
$("#pepe").keyup(function() {
    var search = document.getElementById("pepe").value;
    console.log('si es este: ' + search);
    var searchresult = document.getElementById("searchResult");
    var url_str = BASE_URL + "/Hcv_Rest_Indigenous_l";
    var language = {
        "search": search,
        "limit": "10",
        "offset": "0"
    };
    $.ajax({
        url: url_str,
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(language),
        success: function(response) {
            let info = response.data;
            var len = info.length;
            $("#searchResult").empty();
            for (var i = 0; i < len; i++) {
                var id = info[i].ID;
                var name = info[i].SCIENTIFIC_NAME;
                $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");
            }
            // binding click event to li
            $("#searchResult li").bind("click", function() {
                var value = $(this).text();
                $("#pepe").val(value);
                $('#id_lengua').val(id);
                $("#searchResult").empty();
            });
        }
    });
});

// Predictivo con el catalogo de códigos postales
$("#cp_search").keyup(function() {
    var search2 = document.getElementById("cp_search").value;
    let searchresult2 = document.getElementById("searchResult");
    var url_str = `${BASE_URL}/Hcv_Rest_Cp`;
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
                    estado = info[i].CIUDAD;
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
                    $('#id_original').val(id2);
                    var len = info.length;
                    for (var i = 0; i < len; i++) {
                        if (info[i].ID == id2) {
                            $("#colonia").val(info[i].ASENTAMIENTO);
                            $("#delegacion").val(info[i].MUNICIPIO);
                            $("#estado").val(info[i].CIUDAD);
                            console.log(info[i])
                        }
                    }
                });
            }
        });
    }
});

// Input que se abre en caso de que seleccione otro genero en select identidad
genero();
function genero(){
    $('#genero').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#othergender').show();
        } else {
            $('#othergender').hide();
        }
    });
}

info();
function info() {
    $('#info').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#otherinfo').show();
        } else {
            $('#otherinfo').hide();
        }
    });
}

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

// PREDICTIVO CON EL CATALOGO DE RELIGIONES
religion();
function religion() {
    $("#religion").keyup(function() {
        var search = document.getElementById("religion").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = `${BASE_URL}/HCV/Operativo/Hcv_Rest_Paciente/get_religiones`;
        var language = {
            "search": search,
            "limit": "10",
            "offset": "0"
        };
        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(language),
            success: function(response) {
                let info = response.data;
                var len = info.length;
                $("#searchResult").empty();
                for (var i = 0; i < len; i++) {
                    var id = info[i].ID;
                    var name = info[i].RELIGION;
                    $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");
                }
                // binding click event to li
                $("#searchResult li").bind("click", function() {
                    var value = $(this).text();
                    var id = this.value;
                    $("#religion").val(value);
                    $('#id_religion').val(id);
                    $("#searchResult").empty();
                });
            }
        });
    });
}

/* countries();
function countries(){
    $.getJSON("../../assets/js/general/countrys.json", function(json) {
        var paises = $("#nacionalidad");
        $(json).each(function(i, v) { // indice, valor
            paises.append('<option  value="' + v.name + '">' + v.name + '</option>');
        })

    });
}  */

// PREDICTIVO CON EL CATALOGO DE FORMACION ACADEMICA
$("#academico").keyup(function() {
    var search2 = document.getElementById("academico").value;
    let searchresult2 = document.getElementById("searchResult");
    var url_str = BASE_URL + "/Hcv_Rest_Academic/get_academic_update";
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
            success: function(response) {
                info = response.data;
                var len = info.length;
                $("#cpResultAcademic").empty();
                for (var i = 0; i < len; i++) {
                    id = info[i].ID;
                    academic_form = info[i].ACADEMIC_FORMATION;
                    $("#cpResultAcademic").append("<li value='" + id + "'>" + academic_form + "</li>");
                }

                // binding click event to li
                $("#cpResultAcademic li").bind("click", function() {
                    var value = $(this).text();
                    var id2 = this.value
                    $("#id_cat_academic").val(value);
                    console.log(info);
                    console.log(id2)
                    $("#cpResultAcademic").empty();
                    var len = info.length;
                    for (var i = 0; i < len; i++) {
                        if (info[i].ID == id2) {
                            $("#academico").val(info[i].ACADEMIC_FORMATION);
                            $('#id_academic').val(id2);
                            console.log(info[i])
                        }
                    }
                });
            }
        });
    }
});

//Ver que no quite el mapa
//const input = document.getElementById("autoComplete");

//BTN ASIGNAR PRODUCTO, REVOMER EL ATTR ID 
/* $(document).on('click', '#add-producto', function() {
    $('.update_producto').removeAttr('id');
    $('.universidad').attr('id', 'autoComplete');
    autoComplete_input();
}); */

//FUNCION PARA EL INPUT DE AUTOCOMPLETE
function autoComplete_input() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "LENGUA INDIGENA...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
                try {
                    //const source = await fetch(`${BASE_URL}Hcv_Rest_Indigenous_l`);
                    const source = await fetch(`${BASE_URL}Hcv_Rest_Indigenous_l/index/${query}`);
                    const data = await source.json();
                    return data;
                    
                } catch (error) {
                    return error;
                }
            },
            keys: ["name"],
        },    
        resultsList: {
            tag: "ul",
            id: "autoComplete_list",
            class: "results_list",
            destination: "#autoComplete",
            position: "afterend",
            maxResults: 100,
            noResults: true,
            element: (list, data) => {
                if(!data.results.length){
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}".</span> `;
                    list.appendChild(message);
                }
                list.setAttribute("data-parent", "food-list");
            },
        },        
        resultItem: {
            highlight: true,
            element: (item, data) => {
                item.innerHTML = `
                <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                ${data.match}
                </span>`;
            },    
        },    
        events: {
            input: {
                selection: (event) => {
                    $("#autoComplete").val(event.detail.selection.value.name);
                    /* $("#id_product").val(event.detail.selection.value.id);
                    $("#id_product_updadte").val(event.detail.selection.value.id); */
                }
            }
        }
    });
}

// GUARDAR FICHA DE IDENTIFICACION DEL PACIENTE
$(document).on('submit', '#formCreate', function () {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Pacientes/Ficha_paciente/create`;

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
                    avatar: "../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();
                
                location.href = `${BASE_URL}Paciente/Inicio`;
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../assets/img/cancelar.png",
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

//var countrys = true;
/*$("#countrys").on("click", function () {
    if(countrys){
        console.log('no se cargo');
        $.getJSON("../../assets/js/general/countrys.json").done(function(data) {
            data.forEach(country => {
                $("#countrys").append('<option value="' + country.name + '">' + country.name + '</option>');
            });
            countrys = false;
        }).fail(function(data) {
            console.log('no results found');
        });
    }else{
        console.log('ya se cargo');
    }
});*/







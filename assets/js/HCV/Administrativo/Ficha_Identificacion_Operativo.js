let this_js_script = $('#ruta'); 
const CONTROLADOR = this_js_script.attr('data-my_var_1');

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

//FOTO DE PERFIL DEL INE DEL OPERATIVO 
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
            reader.onloadend = function() {
                document.getElementById("down_ine").src = reader.result;
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

//Grupo medico al cual va a pertenecer el operativo
obtenerGrupo();
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
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
} 

// Si escoge la opcion de tomador de muestra sale el select de las areas en las que puede estar
categoria();
function categoria(){
    $('#group').change(function(e) {
        if (($(this).val() === "7")) {
            $('#category').show();
        } else { //en caso contrario oculta input de categoria
            $('#category').hide();
        }
    });
}

// Si escoge en grupo medico la opcion de medico muestra input de disciplina
disc();
function disc(){
    $('#group').change(function(e) {
        if ($(this).val() === "8") {
            $('#discipline').show();
        } else { //en caso contrario oculta input de disciplina
            $('#discipline').hide();
        }
    });
} 

// Si escoge en grupo medico la opcion de medico muestra input de laboratorio
laboratory();
function laboratory(){
    $('#group').change(function(e) {
        if ($(this).val() === "9") {
            $('#laboratorio').show();
        } else { //en caso contrario oculta input de disciplina
            $('#laboratorio').hide();
        }
    });
} 

//Disciplina a la cual pertenece el operativo
obtenerDisciplina();
function obtenerDisciplina() {
    
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/getDisciplina`;
    var disc = $(".disciplina");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`); 
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
} 

//Categoria de laboratorio
obtenerLaboratorio();
function obtenerLaboratorio() {
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/getLaboratorio`;
    var disc = $(".laboratory");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`); 
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
} 

//Categoria de laboratorio al escoger la opcion de tomador de muestra
obtenerCategoria();
function obtenerCategoria() {
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/getCatLab`;
    var disc = $(".catlab");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`); 
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
} 

//Unidad de negocio a la cual va a pertenecer el operativo
obtenerUnidad();
function obtenerUnidad() {
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/getBusinessUnit`;
    var disc = $(".unidad");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            disc.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                disc.append(`<option value="${v.id}"> ${v.name}</option>`); 
            })
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
} 

const autoCompleteJS = new autoComplete({
    placeHolder: "Buscar disciplina...",
    threshold: 2,
    diacritics: true,
    data: {
      src: async (query) => {
        try {
          const source = await fetch(`${BASE_URL}Api/HCV/Operativo/Hcv_Rest_Identificacion/get_especialidad/${query}`);
          const data = await source.json(); 
          return data;
        
        } catch (error) {
          return error;
        }
      },
      keys: ["ACADEMIC_FORMATION", "ID"],
    },

    resultsList: {
      tag: "ul",
      id: "autoComplete_list",
      class: "results_list",
      destination: "#autoComplete",
      position: "afterend",
      maxResults: 70,
      noResults: true,
      element: (list, data) => {
        if(!data.results.length){
          $('#actualizar').hide();
          const message = document.createElement("div");
          message.setAttribute("class", "no_result");
          message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}"</span> 
          <br><br> `;
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
          $(".no_result").hide();
          let id_especialidad = event.detail.selection.value.ID;
          $("#autoComplete").val(event.detail.selection.value.ACADEMIC_FORMATION);
          $("#id_especial").val(id_especialidad);
        }
      }
    }
});

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
//Aqui termina lo del mapa

// Predictivo con el catalogo de códigos postales
$("#cp_search").keyup(function() {
    var search2 = document.getElementById("cp_search").value;
    let searchresult2 = document.getElementById("searchResult");
    var url_str = `${BASE_URL}/Api/HCV/Hcv_Rest_Cp`;
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

//Funcion para ver u ocultar contraseña del operativo
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

/* Clonacion del input de unidad de negocio */
// cache elements
var clone = $(".clone");
var addBtn = $("#clone-add");
var removeBtn = $(".clone-remove");
removeBtn.first().hide();
var cloneContainer = $(".cloneContainer");

// event to clone element // give unique id
addBtn.on("click", function() {
   var id = generateID();
   clone
      .clone()
      .appendTo(cloneContainer)
      .attr("data-id", id)
      .find(".clone-remove")
      .attr("data-id", id)
      .show();
});

// Unique ID generator
function generateID() {
    var numRand = Math.floor(Math.random() * 101);
    var dateRand = Math.floor(Date.now() / numRand);
    var result = dateRand.toString().substring(2, 8);
    return result;
 }

// event to remove element
cloneContainer.on("click", ".clone-remove", function() {
   var btnID = $(this).attr("data-id");
   $(".clone[data-id=" + btnID + "]").remove();
});

/* Clonacion del input de area del tomador de muestra */
// cache elements
var cloneTomador = $(".clone-tomador");
var addBtnTomador = $("#clone-area");
var removeBtnTomador = $(".clone-delete");
removeBtnTomador.first().hide();
var cloneArea = $(".cloneArea");

// event to clone element // give unique id
addBtnTomador.on("click", function() {
   var idArea = generateID2();
   cloneTomador
      .clone()
      .appendTo(cloneArea)
      .attr("data-id", idArea)
      .find(".clone-delete")
      .attr("data-id", idArea)
      .show();
});

// Unique ID generator
function generateID2() {
    var numRand = Math.floor(Math.random() * 101);
    var dateRand = Math.floor(Date.now() / numRand);
    var result = dateRand.toString().substring(2, 8);
    return result;
 }

// event to remove element
cloneArea.on("click", ".clone-delete", function() {
   var btnIDTomador = $(this).attr("data-id");
   $(".clone-tomador[data-id=" + btnIDTomador + "]").remove();
});



// GUARDAR FICHA DE IDENTIFICACION DEL DOCTOR
$(document).on('submit', '#formCreateFO', function () {
    var form_data = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/HCV/Administrativo/Ficha_operativo/create`;

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
                    avatar: "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },
                }).showToast();
                location.href = `${BASE_URL}HCV/Administrativo/Principal_Operativo`;
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

/*RELOAD DATATABLE */
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}


country();
$('#othergender').hide();
religion();
readPaciente();

// Input que se abre en caso de que seleccione otro genero en select identidad
$('#genero').change(function(e) {
    if ($(this).val() == "Otro") {
        $('#othergender').show();
    } else {
        $('#othergender').hide();
    }
});

/*CREATE UNIDAD DE NEGOCIO DE OPERATIVO*/
$(document).on("submit", "#formUpdate", function () {
    $("#loader").toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/update_`;
    $.ajax({
        url: URL,
        type: "POST",
        data: FORMDATA,
        dataType: "json",
        success: function (data) {
            console.log(data);
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $("#loader").toggle();
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
                        y: 90, 
                    },
                }).showToast();
                document.getElementById("formUpdate").reset();
                readPaciente();
            } else {
                $("#loader").toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, 
                        y: 90, 
                    },
                }).showToast();
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loader").toggle();
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
                x: 50,
                y: 90, 
            },
        }).showToast();
    });
    return false;
});

//Select con el catalogo de nacionalidades
$("#nacionalidad").change(function() {
    let nacionalidad = $('#nacionalidad').val();
    let estados = $('#birthplace');

    if (nacionalidad != "Mexico") {
        estados.empty();
        estados.append('<option  value="">Selecciona lugar de nacimiento</option>');
        estados.append('<option  value="NE">' + "NE" + '</option>');
    } else {
        const ruta = BASE_URL + "HCV/Operativo/Hcv_Rest_Paciente/get_estados";
        $.ajax({
            type: "GET",
            url: ruta,
            dataType: "JSON",
            success: function(data) {
                estados.empty();
                estados.append('<option  value="">Selecciona lugar de nacimiento</option>');
                $(data).each(function(i, v) { // indice, valor
                    estados.append('<option  value="' + v.state + '">' + v.state + '</option>');
                });
            },
            error: function() {
                alert("Hubo un erro al obtener los datos");
            }
        })
    }
}); 
  

//OBTENER NACIONALIDADES
function country(){
    $.getJSON(`${BASE_URL}/../../../assets/js/country.json`, function(json) {
        for (let i = 0; i < json.length; i++) {
            $("#nacionalidad").append("<option value='" + json[i].country + "'>" + json[i].country + "</option>");
        }
    });
}
  
// DATOS DE LA FICHA DE IDENTIFICACION DEL OPERATIVO
function readPaciente() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/readPacient`;
    $.ajax({
        url: URL,
        method: "post",
        dataType: "json",
        success: function (success) {
            $("#group").prop('disabled', 'disabled');
            var foto = success[0].PATH;
            //;
            if (foto == null || foto == "") {
                $("#photo-profile").children().remove();
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png">`;
                $("#photo-profile").append(photo);
            } else {
                $("#photo-profile").children().remove();
                let pathphoto = `${BASE_URL}../uploads/paciente/fotos`;
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${pathphoto}/${foto}">`;
                $("#photo-profile").append(photo);
            }
            $("#id_user").val(success[0].ID_USER);
            $("#id").val(success[0].ID);
            $("#id_identity").val(success[0].ID);
            $("#nombre").val(success[0].NAME);
            $("#f_last_name").val(success[0].F_LAST_NAME);
            $("#s_last_name").val(success[0].S_LAST_NAME);
            $("#birthdate").val(success[0].BIRTHDATE);
            $("#sex").val(success[0].SEX);
            $("#nacionalidad").val(success[0].ID_CAT_NATIONALITY);
            if (success[0].ID_CAT_NATIONALITY != "Mexico") {
                $("#birthplace").empty();
                $("#birthplace").append('<option  value="">Selecciona lugar de nacimiento</option>');
                $("#birthplace").append('<option  value="NE">' + "NE" + '</option>');
              
            } else {
                const ruta = BASE_URL + "HCV/Operativo/Hcv_Rest_Paciente/get_estados";
                $.ajax({
                    type: "GET",
                    url: ruta,
                    dataType: "JSON",
                    success: function(data) {
                        //$("#birthplace").empty();
                        $("#birthplace").append('<option  value="">Selecciona lugar de nacimiento</option>');
                        $(data).each(function(i, v) { // indice, valor
                            $("#birthplace").append('<option  value="' + v.state + '">' + v.state + '</option>');
                        });
                        $("#birthplace").val(success[0].BIRTHPLACE);
                        
                    },
                    error: function() {
                        alert("Hubo un erro al obtener los datos");
                    }
                });
            }
            $("#curp").val(success[0].CURP);
            $("#phone_number").val(success[0].PHONE_NUMBER);
            $("#cp_search").val(success[0].CP);
            $("#id_original").val(success[0].ID_ZIP_CODE);
            $("#delegacion").val(success[0].ID_CAT_MUNICIPALITY);
            $("#birthplace").val(success[0].BIRTHPLACE);
            $("#estado").val(success[0].ID_CAT_STATE_OF_RESIDENCE);
            $("#colonia").val(success[0].ID_CAT_TOWN);
            $("#autocomplete").val(success[0].street_other);
            $("#latitud").val(success[0].LATITUD);
            $("#longitud").val(success[0].LONGITUD);
            $("#academico").val(success[0].nom_especialidad);
            $("#id_academic").val(success[0].ID_CAT_ACADEMIC);
            $("#job").val(success[0].JOB);
            $("#cat_marital_status").val(success[0].ID_CAT_MARITAL_STATUS);
            $("#genero").val(success[0].ID_CAT_GENDER_IDENTITY);
            if(success[0].ID_CAT_GENDER_IDENTITY == "Otro"){
                $('#othergender').show();
                $('#othergender').val(success[0].other_gender)
            } else {
                $('#othergender').hide();
            }
            $("#otro_genero").val(success[0].other_gender);
            $("#religion").val(success[0].religion);
            $("#id_religion").val(success[0].ID_CAT_RELIGION);
            $("#id_lengua").val(success[0].ID_CAT_INDIGENOUS_LENGUAGE);
            $("#lenguas").val(success[0].lengua);
            
            comunidad  =  success[0].ANSWER_INDIGENOUS_COMUNITY;
            if(comunidad === "Si"){
                $("#si").prop("checked", true);
            }else{
                $("#no").prop("checked", true);
            }
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $("#loader").toggle();
        },
    });
}

// PREDICTIVO CON EL CATALOGO DE RELIGIONES
function religion() {
    $("#religion").keyup(function() {
        var search = document.getElementById("religion").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = `${BASE_URL}${CONTROLADOR}/get_religion`;
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
                let info = response;
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

//Predictivo con el catalogo de lenguas indigenas
$("#lenguas").keyup(function() {
    var search = document.getElementById("lenguas").value;
    console.log('si es este: ' + search);
    var searchresult = document.getElementById("searchResultR");
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
            $("#searchResultR").empty();
            for (var i = 0; i < len; i++) {
                var id = info[i].ID;
                var name = info[i].SCIENTIFIC_NAME;
                $("#searchResultR").append("<li value='" + id + "'>" + name + "</li>");
            }
            // binding click event to li
            $("#searchResultR li").bind("click", function() {
                var value = $(this).text();
                $("#lenguas").val(value);
                $('#id_lengua').val(id);
                $("#searchResultR").empty();
            });
        }
    });
});


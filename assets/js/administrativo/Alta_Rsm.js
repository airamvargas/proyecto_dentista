
get_paises();
mandarform();
$(document).ready(function() {
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
});

//validar formulario 
const formulario = document.getElementById('ficha_description');
const inputs = document.querySelectorAll('#ficha_description input');

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


function get_paises() {
    $.getJSON("../../../../../assets/js/general/countrys.json", function(json) {
        var paises = $("#nacionalidad");
        $(json).each(function(i, v) { // indice, valor
            paises.append('<option  value="' + v.name + '">' + v.name + '</option>');
        })
    });
}


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

                        ///////////VAMOS A MANDAR ID CP PARA REGRESAR COBERTURA Y TIPO DE MEMBRESIA/////

                        var url_cp = BASE_URL + "/Administrativo/Rest_Alta_Rsm";

                        const ajax = {
                            id_cp:id2

                        }

                        $.ajax({
                            url: url_cp,
                            type: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(ajax),
                            success: function(response) {
                                var array = response.length;
                                let membresia = $('#membresia');
                                if(array === 0){
                                    membresia.empty();
                                    membresia.append('<option  value="">Selecciona Membresia</option>');
                                    membresia.append('<option  value="NE">' + "NA" + '</option>');
                                    $('#cobertura').val("Sin cobertura");

                                }else{
                                    membresia.empty();
                                    membresia.append('<option  value="">Selecciona Membresia</option>');
                                    $(response).each(function(i, v) { // indice, valor
                                        console.log("valor"+v.id);
                                        membresia.append('<option  value="' + v.id_membresia + '">' + v.name + '</option>');
                                    }); 
                                    $('#cobertura').val("Con cobertura");
                                }
                            }
                        
                        });
                        //console.log(info);
                        console.log("este es el id"+id2)
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

function mandarform() {
    $(document).on('click', '#submit_membresia', function() {
        let membresia = $('#membresia').val();

        if(membresia < 1){
            alert("selecciona membresia");
        }else{
            let cobertura = $('#cobertura').val();
            if(cobertura === "Sin cobertura"){
                alert("no hay cobertura para esta zona")
            }else{
                let id_cp = $('#cp_id').val();
                let fecha = $('#fecha').val();
                const val_id_cp = validar(id_cp);
                const val_fecha = validar(fecha);

                console.log(val_fecha);

               

                if(val_id_cp !=true){
                    alrert("selecciona un codigo postal");
                }
                if(campos.correo && campos.password && val_fecha){
                $('#loader').toggle();
                var url_str = BASE_URL + '/Administrativo/Rest_Alta_Rsm/user_x_membresia';
                var loginForm = $("#ficha_description").serializeArray();
                var loginFormObject = {};
                $.each(loginForm,
                    function(i, v) {
                        loginFormObject[v.name] = v.value;
                    }
                );
                $.ajax({
                    url: url_str, 
                    type: "POST", 
                    dataType: 'JSON', 
                    data: JSON.stringify(loginFormObject), 
                    success: function(result) {
                        console.log(result);
                        if (result.status == 200) {
                            $('#success').text(result.messages.success);
                            $('#succes-alert').show();
                            location.href = BASE_URL + "Administrativo/Pacientes_cita";
                        } else {
                            $('#error').text(result.error);
                            $('#error-alert').show();
                        }
                        $('#loader').toggle();
                        $('#modal_created').modal('toggle');
                    },
                    error: function(xhr, text_status) {
                        //console.log(xhr, text_status);
                        $('#loader').toggle();
                        $('#error-alert').show();
                        $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                        $('#modal_created').modal('toggle');
                    }
                })   
                    
                }else{
                    alert("llena todos los campos");
                }
            }
        } 
      
    });
}


function validar(valor){
    if(valor != ""){
        return true;
    }else{
        return false;
    }
}
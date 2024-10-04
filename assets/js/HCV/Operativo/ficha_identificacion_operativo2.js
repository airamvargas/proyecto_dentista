//VALIDAR FORMULARIO//
const formulario = document.getElementById('ficha_operativo');
const inputs = document.querySelectorAll('#ficha_operativo input');
passwd();

function passwd() {
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

const expresiones = {
	//usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    password: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/,
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
    apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/,
	segundo_apellido: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // 4 a 12 digitos.
    descripcion: /^[a-zA-ZÀ-ÿ\s]{1,60}$/,
    calle: /^[a-zA-ZÀ-ÿ\s-.-0-9\S-,-#]{4,200}$/,
    cedula: /^\d{8}$/,
    c_especialidad: /^\d{7}$/,
	telefono: /^\d{10}$/ // 7 a 14 numeros.
}

const campos = {
    correo: false,
    password: false,
	nombre: false,
	apellido: false,
	segundo_apellido: false,
	telefono: false,
    descripcion: false,
    calle: false,
    cedula: false,
    c_especialidad:false,
}

const validarFormulario = (e) => {
	switch (e.target.name) {
        case "correo":
            validarCampo(expresiones.correo, e.target, 'correo');
        break;
        case "password":
            validarCampo(expresiones.password, e.target, 'password');
        break;
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
    console.log(campos['NAME']);
    console.log(campos['correo']);
    console.log(campos['password']);
}


//SEND FORMULARIO//
$("#foperativo").on("click", function () {
    $('#loader').toggle();
    var form = $("#ficha_operativo");   
    var formData = new FormData(form[0]);
    var codigo = $('#cp_search').val();
    var fecha = $('#fecha').val();
    var especilidad = $('#especial').val();
    var latitud = $('#longitud').val();
    
    const validar_direccion = validar(latitud);
    const val_codigo = validar(codigo);
    const val_fecha = validar(fecha);
    const val_especialidad = validar(especilidad);

    
    if(validar_direccion === true){
        if(campos.NAME && campos.F_LAST_NAME && campos.S_LAST_NAME && campos.descrip && campos.STREET && campos.fcedula && campos.cedulaespe && campos.PHONE_NUMBER && val_codigo  && val_fecha && val_especialidad && campos.correo && campos.password){

            $.ajax({
                url: BASE_URL + 'Operativo/Hcv_Rest_Identificacion2',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#loader').toggle();
                    console.log(data)
                    if (data.status == 200) {
                        $('#success').text(data.messages.success);
                        $('#succes-alert').show();
                        location.href = BASE_URL + "Administrativo/Operativo";
                    } else {
                        alert(data.messages.warning);
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            }); 
        }else{
            alert("Rellena todos los campos");

        } 
    }else{
        alert("busca direccion en el mapa");
    }        


});
    

function validar(valor){
    if(valor != ""){
        return true;
    }else{
        return false;
    }
}






































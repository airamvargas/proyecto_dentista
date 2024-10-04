/* Desarrollador: Giovanni Zavala Cortes
Fecha de creacion:28/08/2023
Fecha de Ultima Actualizacion: 30/08/2023 
Perfil: General
Descripcion: peticiones por fetch envio de formularios */


//mensaje: valor de string del mensaje
//flag: valor true y false para la imagen
//reload: valor de la varible de la tabla de lo contrario false
//modal: id del nombre del modal de lo contrario false
//form: id del formulario de lo contrario false
//ref: redireccion de url de lo contrario false


//Envio de formulario
let send = (url, data, reload, modal, form, ref) =>
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form, ref) : notificacion(response.msg, false)
        }).catch(err => alert(err))


//ejemplo peticion get 
let getData = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getIndicaciones/${id_folio}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            return response;
        }).catch(err => alert(err))
}

//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
    console.log(ref);
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }

    if (reload) {
        reload.ajax.reload();
    }

    if (modal) {
        $(modal.selector).modal('toggle');
    }

    if (form) {
        $(form.selector).trigger("reset");

    }

    Toastify({
        text: mensaje,
        duration: 3000,
        className: "info",
        avatar: imagen,
        style: {
            background: background
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();
    
    if (ref) {
        setTimeout(() => {
            window.location.href = BASE_URL + ref;
        }, "1000");
    }

    $('#loader').toggle();
}
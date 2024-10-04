//FORMATO EN ESPAÑOL FECHA
moment.locale("es");
$("#btn-aceptar").hide();
getTomas();
setInterval(getTomas, 20000);

function getTomas(){
    $('#loader').toggle();
    
    const URL = `${BASE_URL}${CONTROLADOR}/showMuestras`;
    
    $.ajax({
        url: URL,
        method: 'POST',
        dataType: 'json',
        success: function (data) {
            $("#muestrasPendientes").children().remove();
            if(data != ""){
                $(data).each(function (i, v) {
                    let muestras = `<div class="card bd-0 mg-t-20">
                        <div class="card-header card-header-default bg-purple">
                            <h6>Paciente: ${v.paciente}</h6>
                        </div>
                        <div class="card-body bd bd-t-0 rounded-bottom">
                            <p><b>Servicio</b>: <span>${v.estudio}</span></p>
                            <p><b>Categoría</b>: <span>${v.category_lab}</span></p>
                            <p><b>Hora liberación</b>: <span>${moment(v.updated_at).format("HH:mm")}</span></p>
                            <div class="float-right">
                                <button id="${v.id}" type="button" title="Ver estudios" class="btn btn-primary ver-info solid pd-x-20"><i class="fa fa-eye" aria-hidden="true"></i> Ver</button>
                            </div>
                            
                        </div>
                    </div>`;
                    $("#muestrasPendientes").append(muestras);
                });
            }
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

/* BOTON DE VER INFORMACION */
$(document).on('click', '.ver-info', function(){
    $('#loader').toggle();
    let id = $(this).attr('id');
    const URL = `${BASE_URL}${CONTROLADOR}/showStudies`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            if(data != ""){
                $("#infoMuestras").children().remove();
                $(data).each(function (i, v) {
                    let infoMuestras = `<div class="row mg-t-30 justify-content-center">
                    <div class="col-2 text-right">
                            <input type="checkbox" id="${v.id}" name="id_cita[]" value="${v.id}" checked>
                        </div>
                        <div class="col-5 text-center">
                            <p>${v.estudio}</p>
                        </div>
                        <div class="col-5 text-justify">
                            <p>${v.preparacion}</p>
                        </div>
                        
                    </div>
                    <hr>`;
                    $("#infoMuestras").append(infoMuestras);
                });
                document.getElementById("formMuestras").reset();
                $("#id_cot_prod").val(id);
                $("#btn-aceptar").show();
            }
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
});

/* BOTON ACEPTAR */
$(document).on('submit', '#formMuestras', function () {
    $('#loader').toggle();
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/aceptarMuestra`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                console.log(data.data);
                $('#loader').toggle();
                location.href = `${BASE_URL}HCV/Operativo/TomarMuestras/questions`;
                //notification library
                Toastify({ 
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $("#btn-aceptar").hide();
                //document.getElementById("formMuestras").reset();
                $("#muestrasPendientes").children().remove();
                $("#infoMuestras").children().remove();
                getTomas();
                
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
            } 
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
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
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

/* BOTON CANCELAR */
$(document).on('click', '#cancelarMuestra', function(){
    getTomas();
    $("#infoMuestras").children().remove();
    $("#btn-aceptar").hide();
});
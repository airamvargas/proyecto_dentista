//variables globales
id_paciente = $('#id_paciente').val();
id_folio = $('#id_folio').val();
id_doctor = $('#id_doctor').val();
id_cita = id_folio;

//botones del menu superior




//funcion de inicio
$(document).ready(function () {
    //$('body').css("overflow" ,"hidden")
    //promesa para carga asincrona
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(getvitales()).catch(err => alert(err))
        .then(table()).catch(err => alert(err))
});

//evento click para las pestala de sinnos vitales
$(document).on('click', '#defaultOpen', function () {
    getvitales();
});

//eliminar enfermedades
$(document).on('click', '.delete-enf ', function () {
    let id_btn = $(this).attr('id');
    $("#id_delete2").val(id_btn);
    $('#modal_delete2').modal('toggle');
});

// form delete enfermedad de tabla
$(document).on('submit', '#formDelete', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/deleteDiagnostic`;
    let FORMDATA = new FormData($(this)[0]);
    let id_form = $('#formDelete');
    let modal = $('#modal_delete2');
    send(url, FORMDATA, dataTable, modal);
});

//formulario de nota
$(document).on('submit', '#form-nota', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_paciente', $('#id_paciente').val());
    FORMDATA.append('id_folio', $('#id_folio').val());
    send(url, FORMDATA, false);
});

//formulario de signos
$(document).on('submit', '#signos_vitales', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/createSignos`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_paciente', id_paciente);
    FORMDATA.append('id_folio', id_folio);
    send(url, FORMDATA, false);

});

//fomulario de disnostico
$(document).on('submit', '#form-diagnostico', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let enfermedad = $('#cie').val();


    if (enfermedad.length > 0) {
        let url = `${BASE_URL}Api/NotasMedicas/Nota_general/createDiagostic`;
        let FORMDATA = new FormData($(this)[0])
        FORMDATA.append('id_paciente', id_paciente);
        FORMDATA.append('id_folio', id_folio);
        let id_form = $('#form-diagnostico');
        send(url, FORMDATA, dataTable, false, id_form);
    } else {
        let mensaje = "selecione una enfermedad";
        notificacion(mensaje, false, false);
    }
});


//get de la nota medica
let getvitales = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getNota/${id_folio}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if (response['nota'].length > 0) {
                $('#nota_general').val(response['nota'][0].nota);
            }
            if (response['signos'].length > 0) {
                $('#fc').val(response['signos'][0].FC);
                $('#fr').val(response['signos'][0].FR);
                $('#temp').val(response['signos'][0].FR);
                $('#satO2').val(response['signos'][0].satO2);
                $('#mg_dl').val(response['signos'][0].mg_dl);
                $('#peso').val(response['signos'][0].peso);
                $('#talla').val(response['signos'][0].talla);
                $('#ta').val(response['signos'][0].TA);
                $('#ta2').val(response['signos'][0].TA2);

            }
            $('#loader').toggle();
        }).catch(err => alert(err))
}

//Envio de formulario POST 
let send = (url, data, reload, modal, form, ref) => 
 fetch(url, {
    method: "POST",
    body: data,
}).then(response => response.json()).catch(err => alert(err))
    .then(response => {
        response.status == 200 ? notificacion(response.msg, true, reload, modal, form,ref) : notificacion(response.msg, false)
    }).catch(err => alert(err))


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

    //console.log(ref);

    if(ref){
        setTimeout(() => {
            window.location.href = BASE_URL+ref;
          }, "1000");
    }

    $('#loader').toggle();
}

//AUTO COMPLETE ENFERMEDADES
const autoCompleteJS = new autoComplete({
    placeHolder: "Busca enfermedad ...",
    threshold: 2,
    diacritics: true,
    data: {
        src: async (query) => {
            try {
                const source = await fetch(`${BASE_URL}/Api/Catalogos/Diseases/getC10/${query}`);
                const data = await source.json();
                return data;

            } catch (error) {
                return error;
            }
        },
        keys: ["NOMBRE", "ID"],
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
            if (!data.results.length) {
                const message = document.createElement("div");
                message.setAttribute("class", "no_result");
                message.innerHTML = `<span>Ningún resultado para "${data.query}"</span>`;
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
          </span>
            
        <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
      </span>`;
        },

    },
    events: {
        input: {
            selection: (event) => {
                $("#autoComplete").val(event.detail.selection.value.NOMBRE);
                $(".id_c10").val(event.detail.selection.value.ID);
                $("#common").val(event.detail.selection.value.NOMBRE);
            }
        }
    }
});




//tabla de diagnosticos
let table = () => {
    dataTable = $('#datatable').DataTable({
        paging: false,
        "info": false,
        "searching": false,
        ajax: {
            url: `${BASE_URL}/Api/NotasMedicas/Nota_general/getDiagnostic/${id_folio}`,
        },

        columns: [
            {
                data: 'enfermedad',

            },
            {
                data: 'fecha',

            },
            {
                data: 'time',

            },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete-enf solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
                }
            },
        ],

        order: [[0, 'desc']],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        responsive: true
    });
}

//medicamentos e indicaciones 

$(document).on('submit', '#medicament', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/createReceta`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_paciente', id_paciente);
    FORMDATA.append('id_folio', id_folio);
    let id_form = $('#medicament');
    send(url, FORMDATA, receta, false, id_form);

});

//evento click para las pestaña indicaciones
$(document).on('click', '#medicamento', function () {
    $('#loader').toggle();
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 5000);
    })
    promise.then(recetatb()).catch(err => alert(err))
        .then(indicaciones()).catch()
        .then($('#loader').toggle()).catch(err => alert(err))

});

//clik del boton de la tabla de medicamentos
$(document).on('click', '.delete-medic', function () {
    let id_btn = $(this).attr('id');
    $("#id_medica").val(id_btn);
    $('#modalmedicamento').modal('toggle');
});

//ELIMINAR MEDICAMENTO
$(document).on('submit', '#formmedicamento', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/deleteMedicamento`;
    let FORMDATA = new FormData($(this)[0])
    let modal = $('#modalmedicamento');
    send(url, FORMDATA, receta, modal, false);

});

//indicaciones secundarias
$(document).on('submit', '#form-second', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/createIdicaciones`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_paciente', id_paciente);
    FORMDATA.append('id_folio', id_folio);
    send(url, FORMDATA, false, false, false);

});

//PDF POR CORREO 
$(document).on('submit', '#form-correo', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/sendPdf`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_paciente', id_paciente);
    FORMDATA.append('id_folio', id_folio);
    FORMDATA.append('id_medico', id_doctor);
    send(url, FORMDATA, false, false, false);

});


let indicaciones = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getIndicaciones/${id_folio}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if (response.length > 0) {
                $('#indicaciones-sec').val(response[0].indicaciones_secundarias);
                $('#id_recet').val(response[0].id);
            }
            $('#loader').toggle();
        }).catch(err => alert(err))
}

let recetatb = () => {
    receta = $('#receta').DataTable({
        "bDestroy": true,
        paging: false,
        "info": false,
        "searching": false,
        ajax: {
            url: `${BASE_URL}/Api/NotasMedicas/Nota_general/getReceta/${id_folio}`,
        },

        columns: [
            {
                data: 'medicamento',

            },
            {
                data: 'presentacion',

            },
            {
                data: 'indicaciones',

            },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger delete-medic solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
                }
            },
        ],

        order: [[0, 'desc']],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        responsive: true
    });
}

//procedimientos
$(document).on('click', '#procedimientos', function () {
    $('#loader').toggle();
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 5000);
    })
    promise.then(procedimientos()).catch(err => alert(err))
    .then(procedimientotb()).catch()
    /*.then($('#loader').toggle()).catch(err => alert(err)) */
});

//agregar procedimiento
$(document).on('submit', '#form-procedimientos', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/creteCita`;
    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_folio', id_folio);
    send(url, FORMDATA, procedimiento, false, false);
});

//DELETE PROCEDIMIENTO
$(document).on('click', '.btn-proc', function () {
    let id_btn = $(this).attr('id');
    $("#id_prodimiento").val(id_btn);
    $('#modalproce').modal('toggle');
}); 

$(document).on('submit', '#form-procedi', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/deleteProcedimiento`;
    let FORMDATA = new FormData($(this)[0])
    let modal = $('#modalproce');
    send(url, FORMDATA, procedimiento, modal, false);
});
 

let procedimientos = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getProdimientos`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            let select_proce = $('.proce');
            $(select_proce).empty()
            select_proce.append(`<option  value=""> SELECCIONA UN PROCEDIMIENTO</option>`);
            $(response).each(function (i, v) {
                select_proce.append(`<option  value="${v.id}"> ${v.commun_name}</option>`);
            })
            $('#loader').toggle();
        }).catch(err => alert(err), $('#loader').toggle())
}

//tabla prodecimientos
let procedimientotb = () => {
    procedimiento = $('#tbprocedimientos').DataTable({
        "bDestroy": true,
        paging: false,
        "info": false,
        "searching": false,
        ajax: {
            url: `${BASE_URL}/Api/NotasMedicas/Nota_general/getMini/${id_folio}`,
        },

        columns: [
            {
                data: 'name_procedimiento',

            },
           
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return '<button title="ELIMINAR" id="' + data + '"  class="btn btn-danger btn-proc  solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
                }
            },
        ],
        order: [[0, 'desc']],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        responsive: true
    });
}

//boton terminar cita
$(document).on('click', '#terminar', function () {
    $('#id_terminar').val(id_folio);
    $('#modalfinish').modal('toggle');
}); 



$(document).on('submit', '#form-terminar', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/finishCita`;
    let FORMDATA = new FormData($(this)[0])
    let modal = $('#modalfinish');
    let ref = "/HCV/Operativo/Citas";
    send(url, FORMDATA, false, modal, false, ref);
});
 









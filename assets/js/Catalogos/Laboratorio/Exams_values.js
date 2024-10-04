/* Desarrollador: Airam Vargas
Fecha de creacion: 11 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administrador
Descripcion: Cátalogo de valores de un analito, según genero y edad */

$("#id_exam").val(id_exam)

async function fetchSelects() {
    let url_gender = `${BASE_URL}${CONTROLADOR}/getGenders`;
    //let url_ranges = `${BASE_URL}Api/Catalogos/Laboratorio/Age_range`;
    
    try {
        const [genderResponse, rangesResponse] = await Promise.all([
            fetch(url_gender),
            //fetch(url_ranges)
        ]);
            
        const genders = await genderResponse.json();
        //const ranges = await rangesResponse.json();

        return genders;
    } catch (error){
        console.log (error);
    }
} 

fetchSelects().then((genders) => {
    var generos = $(".genero");
    generos.append(`<option  value="">SELECCIONA UNA OPCIÓN</option>`);
    $(genders).each(function(i, v) {
        generos.append(`<option  value="${v.id}"> ${v.name}</option>`);
    });

    /*var rango = $(".rangos");
    rango.append(`<option  value="">SELECCIONA UNA OPCIÓN</option>`);
    $(ranges['data']).each(function(i, v) {
        rango.append(`<option  value="${v.id}"> ${v.min} -  ${v.max}</option>`);
    });*/
});

var dataTable = $('#crm_ranges_exam').DataTable({
    order: [[0, 'asc']],
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/showRanges`,
        data: {id_exam : id_exam},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'id',
        },
        {
            data: 'genero',
        },
        /*{
            data: 'rango',
        },*/
        {
            data: 'edad_minima',
        },
        {
            data: 'edad_maxima',
        },
        { 
            data: 'operator',
        },
        {
            data: 'min',
        },
        {
            data: 'max',
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center">
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"  ></i></button>
                    <button id="${data}"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>`
            }
        },
    ],
    "columnDefs": [
        {
        "targets": [0],
        "visible": false,
        "searchable": false
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
});

/* INSERTAR RANGO X ANALITO */
$(document).on('submit', '#formCreateRange', function (e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/createRange`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $("#formCreateRange");
    let modal = $('#myModal');
    send(url, FORMDATA, dataTable, modal, form);
    
});

/* BOTON UPDATE DATOS */
$(document).on('click', '.update', function() {
    var id = $(this).attr('id');
    let url = `${BASE_URL}${CONTROLADOR}/getValues/${id}`;
    getValores(url);
});

/* ELIMINAR RANGO X ANALITO */
$(document).on('submit', '#formUpdateRange', function (e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/updateRange`;
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_exam', id_exam);
    let modal = $('#updateModal');
    send(url, FORMDATA, dataTable, modal);
    
});

/* ELIMINAR RANGO X ANALITO */
$(document).on('submit', '#formDeleteRange', function (e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/deleteRange`;
    let FORMDATA = new FormData($(this)[0]);
    let modal = $('#modal_delete');
    send(url, FORMDATA, dataTable, modal);
    
});

//Envio de formulario
let send = (url, data, reload, modal, form, ref) =>
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form, ref) : notificacion(response.msg, false)
        }).catch(err => alert(err))

let getValores = (url) => {
    $('#loader').toggle();
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            console.log(response);
            $("#id_gender").val(response[0].id_gender);
            //$("#id_age_range").val(response[0].id_age_range);
            $("#edad_minima").val(response[0].edad_minima);
            $("#edad_maxima").val(response[0].edad_maxima);
            $("#min").val(response[0].min);
            $("#max").val(response[0].max);
            $('#operator').val(response[0]['operator']);
            $("#id_update").val(response[0].id);
            $("#updateModal").modal('toggle');
            //console.log(response);
        
            $('#loader').toggle(); 
            //return response;
            //console.log(response[0].id_gender);
        }).catch(err => alert(err));
   
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
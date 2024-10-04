id_paciente = $('#id_paciente').val();
id_folio = $('#id_folio').val();
id_cita = id_folio;

$(document).ready(function () {
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(getvitales()).catch(err => alert(err))
        .then(table()).catch(err => alert(err))
});

$(document).on('click', '#defaultOpen', function () {
    getvitales();
});




let getvitales = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getNota/${id_folio}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            console.log(response);
            $('#text-nota').text(response['nota'][0].nota);
            $('#fc').text(response['signos'][0].FC);
            $('#fr').text(response['signos'][0].FR);
            $('#temp').text(response['signos'][0].FR + " " + "°C");
            $('#satO2').text(response['signos'][0].satO2 + " " + "%");
            $('#mg_dl').text(response['signos'][0].mg_dl + " " + "mg/dl");
            $('#peso').text(response['signos'][0].peso + " " + "Kg");
            $('#talla').text(response['signos'][0].talla + " " + "cm");
            $('#tension').text(response['signos'][0].TA + "/" + response['signos'][0].TA2)
            $('#loader').toggle();
        }).catch(err => alert(err))
}

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
                render: function (data, type, row, meta) {
                    return moment(data).format("DD/MM/YY")

                }


            },
            {
                data: 'time',

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

///////////////////EVIDENCIAS///////////////

$(document).on('click', '#evidencia', function () {
    $('#loader').toggle();
    evidencias();

});

let evidencias = () => {
    var dataEvidencias = $('#crm_evidencias').DataTable({
        "bDestroy": true,
        ajax: {
            url: `${BASE_URL}Api/HCV/Operativo/Nota_medica/showEvidencias`,
            data: { id_cita: id_cita },
            type: "POST",
        },
        lengthMenu: [
            [10, 25, 50, 100, 999999],
            ["10", "25", "50", "100", "Mostrar todo"],
        ],
        searching: false,
        paging: false,
        columns: [
            {
                data: 'name_foto'
            },
            {
                data: 'descripcion'
            },
            {
                data: "name_foto",
                render: function (data, type, row, meta) {
                    return `<div class="d-flex justify-content-center"><a href="${BASE_URL}../uploads/paciente/nota_medica/${data}" target="_blank"><button type="button" class="ml-1 btn btn btn-primary btn-circle btn-sm pd-x-20" title="Ver archivo"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`
                }
            },

        ],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        }
    });
    $('#loader').toggle();

}

///////////////////MEDICAMENTOS//////////////////

$(document).on('click', '#medicamento', function () {
    $('#loader').toggle();
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(recetatb()).catch(err => alert(err))
        .then(indicaciones()).catch()
        .then($('#loader').toggle()).catch(err => alert(err))

});

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

let indicaciones = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/NotasMedicas/Nota_general/getIndicaciones/${id_folio}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            console.log(response);
            if (response.length > 0) {
                $('#indicaciones-sec').text(response[0].indicaciones_secundarias);
            }
            $('#loader').toggle();
        }).catch(err => alert(err))
}


////////////////////////PROCEDIMIENTOS//////////////////////

$(document).on('click', '#procedimientos', function () {
   // $('#loader').toggle();
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(procedimientotb()).catch(err => alert(err))
    .then($('#loader').toggle()).catch(err => alert(err)) 
    
});

//tabla prodecimientos
let procedimientotb = () => {
    $('#loader').toggle();
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







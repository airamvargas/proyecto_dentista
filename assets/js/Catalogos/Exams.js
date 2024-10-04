/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 08 - 09 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Cátalogo de tipos de analitos */

async function fetchSelects() {
    let url_methods = `${BASE_URL}Api/Catalogos/Laboratorio/Metodos/getMethods`;
    let url_unit = `${BASE_URL}Api/Catalogos/Laboratorio/Unidades_medicion/read`;
    let url_grouper = `${BASE_URL}Api/Catalogos/Laboratorio/Agrupador/read`;

    try {
        const [methodsResponse, unitResponse, grouperResponse] = await Promise.all([
            fetch(url_methods),
            fetch(url_unit),
            fetch(url_grouper)
        ]);

        const methods = await methodsResponse.json();
        const units = await unitResponse.json();
        const groupers = await grouperResponse.json();

        return [methods, units, groupers];
    } catch (error) {
        console.log(error);
    }
}

fetchSelects().then(([methods, units, groupers]) => {
    var metodos = $(".metodo");
    metodos.append(`<option  value="">SELECCIONA UN MÉTODO</option>`);
    $(methods).each(function (i, v) {
        metodos.append(`<option  value="${v.id}"> ${v.name}</option>`);
    });

    var unit = $(".unidad");
    unit.append(`<option  value="">SELECCIONA UNIDAD DE MEDIDA</option>`);
    $(units['data']).each(function (i, v) {
        unit.append(`<option  value="${v.id}"> ${v.prefix}</option>`);
    });

    var agrupador = $(".agrupador");
    agrupador.append(`<option  value="">SELECCIONA UN AGRUPADOR</option>`);
    $(groupers['data']).each(function (i, v) {
        agrupador.append(`<option  value="${v.id}"> ${v.name}</option>`);
    });
});

var dataTable = $('#crm_exams').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'asc']],
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readExams`,
        data: {},
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
            data: 'name',
        },
        {
            data: 'description',
        },
        {
            data: 'metodo',
        },
        {
            data: 'unidad',
        },
        {
            data: 'referencia',
            render: function (data, type, row, meta) {
                if (data == "") {
                    return `-`
                } else {
                    return `${data}`
                }
            }
        },
        {
            data: 'resultado',
            render: function (data, type, row, meta) {

                switch (data) {
                    case "1":
                        return "<p>NÚMERICO</p>"
                    case "2":
                        return "<p>TEXTO</p>"
                    case "3":
                        return "<p>CERRADO</p>"
                    default:
                        return "-"
                   
                }               
            }
        },
        {
            data: 'agrupador',
            render: function (data, type, row, meta) {
                if (data == null) {
                    return `-`
                } else {
                    return `${data}`
                }
            }
        },
        {
            data: "id",
            render: function (data, type, row, meta) {
                switch (row.resultado) {
                    case "1":
                        return `<div class="d-flex justify-content-center"><a href="${BASE_URL}Catalogos/Exams/values/${data}"><button id="${data}" class="btn btn-primary rangos solid pd-x-20 btn-circle btn-sm" title="Agregar rangos de valores"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"  ></i></button>
                    <button id="${data}"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>`
                    case "2":
                        return `<div class="d-flex justify-content-center"><a href="${BASE_URL}Catalogos/Exams/values/${data}"><button id="${data}" class="btn btn-primary rangos solid pd-x-20 btn-circle btn-sm" title="Agregar rangos de valores"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"  ></i></button>
                    <button id="${data}"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>`
                    case "3":
                        return `<div class="d-flex justify-content-center"><a href="${BASE_URL}Catalogos/Exams/values/${data}"><button id="${data}" class="btn btn-primary rangos solid pd-x-20 btn-circle btn-sm" title="Agregar rangos de valores"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"  ></i></button>
                    <button id="${data}"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>`
                    default:
                        return `<div class="d-flex justify-content-center">
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm ml-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"  ></i></button>
                    <button id="${data}"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm ml-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>`
                   
                }                
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
    initComplete: function (settings, json) {
        var api = this.api();
        api
            .columns()
            .eq(0)
            .each(function (colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq(
                    $(api.column(colIdx).header()).index()
                );
                var title = $(cell).text();
                $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

                // On every keypress in this input
                $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                    .off('keyup change')
                    .on('keyup change', function (e) {
                        e.stopPropagation();
                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr =
                            '({search})'; //$(this).parents('th').find('select').val();
                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search(

                                this.value
                            )
                            .draw();

                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
            });
        quitaClase();

        function quitaClase() {
            $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
        }

    },
});

/* OBTENER DATOS DE EXAMEN*/
$(document).on('click', '.update', function () {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readExam`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (success) {
            $('#nameCategory').val(success[0].name);
            $('#description').val(success[0].description);
            $('#id_crm_cat_methods').val(success[0].id_crm_cat_methods);
            $('#id_crm_cat_measurement_units').val(success[0].id_crm_cat_measurement_units);
            $('#reference_value').val(success[0].reference_value);
            $('#result').val(success[0].result);
            $('#id_agrupador').val(success[0].id_agrupador);
            $('#id_update').val(success[0].id);
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

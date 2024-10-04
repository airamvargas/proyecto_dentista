/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 22 - 08 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Se agrego tipo de muestra, contenedor y volumen en las datos del estudio */

$(document).ready(function() {
    $("#div_duracion").hide();
    get_groups();
    get_categorias();
    get_containers();
    get_muestras();

    if(id_group == "2"){
        tabla_backOffice();
    } else {
        tabla_laboratorio();
        $("#costo").hide();
        $("#costoUpdate").hide();
        $(".recons").removeClass('col-lg-4').addClass('col-lg-6');
        $("#costo_proceso").removeAttr('required');
        $("#costoProceso_update").removeAttr('required');
    }
});

//Se el listado de todos los estudios existentes para BO
let tabla_backOffice = () => {
    var dataTable_bo = $('#crm_studies').DataTable({
        processing: true, 
        serverSide: true, 
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: `${BASE_URL}${CONTROLADOR}/readStudies`,
            data: {},
            type: "post",
        },
        lengthMenu: [
            [10, 25, 50, 100, 999999],
            ["10", "25", "50", "100", "Mostrar todo"],
        ],
    
        columns: [
            {
                data: 'study',
            },
            {
                data: 'category',
            },
            {
                data: 'duration',
                render: function(data, type, row, meta) {
                    if(row.cita == 0){
                        return `NO REQUERIDO`
                    } else {
                        switch (data) {
                            case "15":
                                return `${data} minutos`
                            break;
                            case "30":
                                return `${data} minutos`
                            break;
                            case "45":
                                return ` ${data} minutos`
                            break;
                            default:
                                return `1 hora`
                            break;
                        }
                    }
                }
            },
            {
                data: 'muestra',
            },
            {
                data: 'contenedor',
            },
            {
                data: 'volumen',
            },
            { 
                data: 'preparation',
            },
            { 
                data: 'dias_entrega',
            },
            { 
                data: 'dias_proceso',
            },
            { 
                data: 'tiempo_entrega',
            },
            { 
                data: 'muestra',
            },
            {
                data: "id",
                render: function(data, type, row, meta) {
                    return '<div class="d-flex flex-column flex-md-row justify-content-center col-sm-12"><a href="'+BASE_URL+'Catalogos/Estudios/add_exams/'+data+'"><button class="btn btn-purple add solid pd-x-20 btn-circle btn-sm mr-2 mr-sm-2 mt-sm-2" title="Agregar analitos"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>' +
                    '<a href="'+BASE_URL+'Catalogos/Estudios/addQuestions/'+data+'"><button class="btn btn-teal add solid pd-x-20 btn-circle btn-sm mr-2 mr-sm-2 mt-sm-2" title="Agregar preguntas"><i class="fa fa-question fa-2x" aria-hidden="true"></i></button></a>'+
                    '<button id="' + row.id_product + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-sm-2 mt-sm-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + row.id_product + '"  data-index = "'+data+'" class="btn btn-danger delete-insum solid pd-x-20 btn-circle btn-sm mr-sm-3 mt-sm-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
                }
            },
    
        ],
        "columnDefs": [
            { className: "wrapbox", "targets": [ 0 ] },
            { className: "wrapbox", "targets": [ 1 ] },
            { className: "wrapbox", "targets": [ 2 ] },
            { className: "wrapbox", "targets": [ 3 ] },
            { className: "wrapbox", "targets": [ 4 ] },
            { className: "wrapbox", "targets": [ 5 ] },
            { className: "wrapbox text-justify", "targets": [ 6 ] },
            { className: "wrapbox", "targets": [ 7 ] },
            { className: "wrapbox", "targets": [ 8 ] },
            { className: "wrapbox", "targets": [ 9 ] }
        ],
        ordering: true,
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        initComplete: function(settings, json) {
            $('#crm_studies thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#crm_studies thead');
            var api = this.api();
            api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');
    
                    // On every keypress in this input
                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function(e) {
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
}

//Se el listado de todos los estudios existentes para laboratorio
let tabla_laboratorio = () => {
    var dataTable_lab = $('#crm_studies').DataTable({
        processing: true, 
        serverSide: true, 
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: `${BASE_URL}${CONTROLADOR}/readStudies`,
            data: {},
            type: "post",
        },
        lengthMenu: [
            [10, 25, 50, 100, 999999],
            ["10", "25", "50", "100", "Mostrar todo"],
        ],
    
        columns: [
            {
                data: 'study',
            },
            {
                data: 'category',
            },
            {
                data: 'duration',
                render: function(data, type, row, meta) {
                    if(row.cita == 0){
                        return `NO REQUERIDO`
                    } else {
                        switch (data) {
                            case "15":
                                return `${data} minutos`
                            break;
                            case "30":
                                return `${data} minutos`
                            break;
                            case "45":
                                return ` ${data} minutos`
                            break;
                            default:
                                return `1 hora`
                            break;
                        }
                    }
                }
            },
            {
                data: 'muestra',
            },
            {
                data: 'contenedor',
            },
            {
                data: 'volumen',
            },
            { 
                data: 'preparation',
            },
            { 
                data: 'dias_entrega',
            },
            { 
                data: 'dias_proceso',
            },
            { 
                data: 'tiempo_entrega',
            },
            { 
                data: 'muestra',
            },
            {
                data: "id",
                render: function(data, type, row, meta) {
                    return '<div class="d-flex flex-column flex-md-row justify-content-center col-sm-12"><a href="'+BASE_URL+'Catalogos/Estudios/add_exams/'+data+'"><button class="btn btn-purple add solid pd-x-20 btn-circle btn-sm mr-2 mr-sm-2 mt-sm-2" title="Agregar analitos"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>' +
                    '<a href="'+BASE_URL+'Catalogos/Estudios/addQuestions/'+data+'"><button class="btn btn-teal add solid pd-x-20 btn-circle btn-sm mr-2 mr-sm-2 mt-sm-2" title="Agregar preguntas"><i class="fa fa-question fa-2x" aria-hidden="true"></i></button></a>'+
                    '<button id="' + row.id_product + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-sm-2 mt-sm-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + row.id_product + '"  data-index = "'+data+'" class="btn btn-danger delete-insum solid pd-x-20 btn-circle btn-sm mr-sm-3 mt-sm-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
                }
            },
    
        ],
        "columnDefs": [
            { className: "wrapbox", "targets": [ 0 ] },
            { className: "wrapbox", "targets": [ 1 ] },
            { className: "wrapbox", "targets": [ 2 ] },
            { className: "wrapbox", "targets": [ 3 ] },
            { className: "wrapbox", "targets": [ 4 ] },
            { className: "wrapbox", "targets": [ 5 ] },
            { className: "wrapbox text-justify", "targets": [ 6 ] },
            { className: "wrapbox", "targets": [ 7 ] },
            { className: "wrapbox", "targets": [ 8 ] },
            { className: "wrapbox", "targets": [ 9 ] },
            {
                "targets": [ 10 ],
                "visible": false,
                "searchable": false
            },
        ],
        ordering: true,
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        initComplete: function(settings, json) {
            $('#crm_studies thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#crm_studies thead');
            var api = this.api();
            api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');
    
                    // On every keypress in this input
                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function(e) {
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
}

//FORMATO CURRENCY EN LOS INPUT DE PRECIO
$(document).on('change', '#precio', function(){
    let costo = $(this).val();
    let consto_curr = currency(costo, { symbol: "", separator: "," }).format();
    $(this).val(consto_curr);
});

$(document).on('change', '#price', function(){
    let costo = $(this).val();
    let consto_curr = currency(costo, { symbol: "", separator: "," }).format();
    $(this).val(consto_curr);
});

/* OBTENER DATOS DEL ESTUDIO*/
$(document).on('click', '.update', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readStudy`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $('#name').val(success[0].study); 
            $('#update_Categoria').val(success[0].id_category); 
            $('#category').val(success[0].id_category_lab); 
            $('#prescription').val(success[0].preparation);
            $('#id_type_sample').val(success[0].id_muestra);
            $('#id_container').val(success[0].id_container);
            $('#updateVolumen').val(success[0].sample_volume);
            $('#updateLabels').val(success[0].n_labels);
            $('#dias_entrega').val(success[0].dias_entrega);
            $('#dias_proceso').val(success[0].dias_proceso);
            $('#tiempo_entrega').val(success[0].tiempo_entrega);
            $('#id_update').val(success[0].id_product); 
            $('#id_insumup').val(success[0].id);
            $("#updateCita").val(success[0].cita);
            if(success[0].cita == 0){
                //$("#updateVolumen").parent().parent().removeClass('col-lg-4').addClass('col-lg-6');
                $("#updateCita").parent().parent().removeClass('col-lg-4').addClass('col-lg-6');
                $("#duracion_update").removeAttr('required');
                $("#div_update").hide();
            } else {
                //$("#updateVolumen").parent().parent().removeClass('col-lg-6').addClass('col-lg-4');
                //$("#updateCita").parent().parent().removeClass('col-lg-6').addClass('col-lg-4');
                $("#duracion_update").val(success[0].duration);
                $("#duracion_update").attr('required', 'required');
                $("#div_update").show();
            }
            const url_examenes = `${BASE_URL}Catalogos/Estudios/add_exams/${success[0].id}`;
            examenes = document.getElementById("ver-examenes");
            examenes.setAttribute("href", url_examenes);
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//BTN DELETE
$(document).on('click', '.delete-insum', function(){
    let producto = $(this).attr('id');
    let insumo = $(this).data('index');

    $("#id_delete").val(producto);
    $("#id_insumodel").val(insumo);
    $('#modal_delete').modal('toggle');
});

/* Si se requiere cita se agrega campo de duración de la cita */
$(document).on('change', '#cita', function() {
    var cita = parseFloat($(this).val());
    if(cita != 0){
        $("#div_duracion").show();
        $("#duracion").attr('required', 'required');
    } else {
        $("#div_duracion").hide();
        $("#duracion").removeAttr('required');
    }
   
});

$(document).on('change', '#updateCita', function() {
    var cita = parseFloat($(this).val());
    $("#duracion_update").val("")
    if(cita != 0){
        $("#div_update").show();
        $("#duracion_update").attr('required', 'required');
    } else {
        $("#div_update").hide();
        $("#duracion_update").removeAttr('required');
    }
   
});

//OBTENER GRUPOS O AREAS PARA SELECT
function get_groups(){
    const url = `${BASE_URL}Api/Catalogos/Grupos_estudios/get_groups`;
    var grupos = $(".grupos");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            grupos.append(`<option  value=""> SELECCIONA UN GRUPO</option>`);
            $(data).each(function(i, v) {
                grupos.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//OBTENER CATEGORIA
function get_categorias() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/Catalogos/Products/readCategoria`;
    var empresas = $(".categoria");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            empresas.append(`<option  value="">SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//OBTENER CONTENEDORES
function get_containers(){
    const url = `${BASE_URL}Api/Catalogos/Laboratorio/Contenedores/getContainers`;
    var contenedores = $(".contenedores");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            contenedores.append(`<option  value="">SELECCIONA UN CONTENEDOR</option>`);
            $(data).each(function(i, v) {
                contenedores.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//OBTENER CONTENEDORES
function get_muestras(){
    const url = `${BASE_URL}Api/Catalogos/Laboratorio/Muestras/read`;
    var contenedores = $(".muestras");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            contenedores.append(`<option  value="">SELECCIONA UN TIPO DE MUESTRA</option>`);
            $(data['data']).each(function(i, v) {
                contenedores.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}
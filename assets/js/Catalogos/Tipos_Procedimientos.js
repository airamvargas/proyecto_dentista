const input = document.getElementById("autoComplete");

readArea();

// Datatable tipos de procedimientos
var dataTable = $('#crm_procedimientos').DataTable({
    order: [[0, 'desc']],
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readProcedimientos`,
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: 'name_hcv_specialtytype',
        },        
        {
            data: 'commun_name',
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex flex-column flex-md-row justify-content-center col-sm-12">' +
                '<button id="' + data + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-sm-2 mt-sm-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                '<button id="' + data + '" class="btn btn-danger delete-proc solid pd-x-20 btn-circle btn-sm mr-sm-3 mt-sm-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//Select del catalogo de areas (nutricional, psicologico, odonto)
function readArea() {
    const URL = `${BASE_URL}Api/Catalogos/Tipo_Procedimientos/readAreaProcedimientos`;
  
    var select = $(".area");
    $.ajax({
        url: URL,
        method: "GET",
        dataType: "json",
        success: function (data) {
            select.empty();
            select.append(`<option value="">Selecciona una opción</option>`);
            $(data).each(function (i, v) {
                select.append(`<option value="${v.id}" data-index="${v.name}"> ${v.name}</option>`);
            });
        },
        error: function (error) {
            alert("Hubo un error al enviar los datos");
        },
    });
}

// Funcion para guardar el nombre del select de catalogo de areas
$(document).on('change', '#select_area', function(){
    let name_specialty = $("#select_area").children("option:selected").data("index");
    $("#id_name_speciality").val(name_specialty);
}); 

$(document).on('change', '#upd_select_area', function(){
    let name_specialty = $("#upd_select_area").children("option:selected").data("index");
    $("#upd_name_speciality").val(name_specialty);
}); 

//BTN DELETE
$(document).on('click', '.delete-proc', function(){
    let producto = $(this).attr('id');
    $("#id_delete").val(producto);
    $('#modal_delete').modal('toggle');
});

/* BOTON DE EDITAR, OBTENER ID Y DATOS */
$(document).on('click', '.update', function() {
    let id = $(this).attr('id');
    let url =  `${BASE_URL}${CONTROLADOR}/readProcedimientoUp`;
    $('.input-proc').removeAttr('id');
    $('.update_procedimiento').attr('id', 'autoComplete');
    autoComplete_input();

    $.ajax({
        url: url,
        data: { id: id},
        method: 'post',
        dataType: 'json',
        success: function(success) {
            $("#upd_name_speciality").val(success[0].name_hcv_specialtytype);
            $("#upd_select_area").val(success[0].id_hcv_specialtytype);
            
            $(".update_procedimiento").val(success[0].name_hcv_cat_procedimientos);
            $("#comun_update").val(success[0].commun_name);

            $("#id_update").val(success[0].id);
            $('#updateModal').modal('show');
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//OBTENER VALOR DEL SELECT DE CATEGORIA DE PRODUCTOS
$(document).on('change', '.area', function(){
    ID_TYPE = $(this).val();
    input.value = "";
    $(".update_procedimiento").val("");
}); 

//BTN NUEVO PROCEDIMIENTO, REVOMER EL ATTR ID 
 $(document).on('click', '#new_proc', function() {
    $('.update_procedimiento').removeAttr('id');
    $('.input-proc').attr('id', 'autoComplete');
    autoComplete_input();
}); 

//FUNCION PARA EL INPUT DE AUTOCOMPLETE
function autoComplete_input() {
    const autoCompleteJS = new autoComplete({
        placeHolder: "Buscar procedimiento...",
        threshold: 2,
        diacritics: true,
        data: {
            src: async (query) => {
                try {
                    const source = await fetch(`${BASE_URL}Searchs/Rest_search/readProcedimientosEspecificos/${query}`);
                    const data = await source.json();
                    return data;
                    
                } catch (error) {
                    return error;
                }
            },
            keys: ["PRO_NOMBRE"],
        },
    
        resultsList: {
            tag: "ul",
            id: "autoComplete_list",
            class: "results_list",
            destination: "#autoComplete",
            position: "afterend",
            maxResults: 30,
            noResults: true,
            element: (list, data) => {
                if(!data.results.length){
                    const message = document.createElement("div");
                    message.setAttribute("class", "no_result");
                    message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}".</span> `;
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
                </span>`;
            },
    
        },    
        events: {
            input: {
                selection: (event) => {
                    $("#autoComplete").val(event.detail.selection.value.PRO_NOMBRE);
                    $("#nombre_comun").val(event.detail.selection.value.PRO_NOMBRE);
                    $("#comun_update").val(event.detail.selection.value.PRO_NOMBRE);
                    $("#id_procedimiento").val(event.detail.selection.value.id);
                    $("#procedimiento_update").val(event.detail.selection.value.id);
                }
            }
        }
    });
}


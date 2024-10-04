let this_js_script = $('#ruta'); // or better regexp to get the file name..
const CONTROLADOR = this_js_script.attr('data-my_var_1');

/* TABLA DE DATOS CLINICOS DE NUTRICION PARA EL PACIENTE*/
var dataTable = $('#tb_nutricion').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readNutricion`,
        data: {id_paciente: id_paciente},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [        
        {
            data: 'cintura',
        },
        {
            data: 'cadera',
        },
        {
            data: 'pantorrilla',
        },
        {
            data: 'grasa_corporal',
        },
        {
            data: 'grasa_visceral',
        },       
        {
            data: 'agua_corporal',
        },       
        {
            data: 'tasa_metabolica',
        },       
        {
            data: 'edad_metabolica',
        },       
        {
            data: 'id_folio',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_nutricion/${row.id_folio}" target="_blank" style="cursor: pointer;"><button title="Ver nota médica" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2" style="cursor: pointer;"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
            }            
        }, 
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* TABLA DE DATOS DE PSICOLOGIA PARA EL PACIENTE*/
var dataPsico = $('#tb_psicologia').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readPsicologia`,
        data: {id_paciente: id_paciente},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [ 
        {
            data: 'tecnica',
        },
        {
            data: 'tipo_abordaje',
        },
        {
            data: 'estado_emocional',
        },
        {
            data: 'objectivo_consulta',
        },        
        {
            data: 'id_folio',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_psicologia/${row.id_folio}" target="_blank" ><button title="Ver nota médica" style="cursor: pointer;" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
            }  
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* TABLA DE DATOS DE SIGNOS MEDICOS PARA EL PACIENTE*/
var dataSignos = $('#tb_signos').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readSignos`,
        data: {id_paciente: id_paciente},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [ 
        {
            data: 'FC',
        },
        {
            data: 'FR',
        },
        {
            data: 'temp',
        },
        {
            data: 'TA',
        },        
        {
            data: 'satO2',
        }, 
        {
            data: 'mg_dl',
        }, 
        {
            data: 'peso',
        }, 
        {
            data: 'talla',
        },          
        {
            data: 'id_folio',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Paciente/Historial_registro/general/${row.id_folio}" target="_blank" ><button title="Ver nota médica" style="cursor: pointer;" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
            }
        }, 
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* TABLA DE DATOS DE DATOS ODONTOLOGICOS DEL PACIENTE*/
var dataOdonto = $('#tb_odonto').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readOdontologia`,
        data: {id_paciente: id_paciente},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [ 
        {
            data: 'marcha',
        },
        {
            data: 'mov_anormales',
        },
        {
            data: 'facies',
        },
        {
            data: 'complexion',
        },        
        {
            data: 'posicion',
        }, 
        {
            data: 'cuidado_personal',
        },
        {
            data: 'id_folio',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_odontologia/${row.id_folio}" target="_blank" ><button title="Ver nota médica" style="cursor: pointer;" class="btn btn-teal solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
            }
        }, 
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*RELOAD DATATABLE */
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

function reloadDataPsico() {
    $('#loader').toggle();
    dataPsico.ajax.reload();
    $('#loader').toggle();
}

var dataProcedimientos = $("#crm_procedimientos").DataTable({
    ajax: {
      url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showCirugias`,
      data: { id_paciente: id_paciente },
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
        data: "name",
      },
    ],
    language: {
      searchPlaceholder: "Buscar...",
      sSearch: "",
      lengthMenu: "_MENU_ Filas por página",
    },
  });
  $("#crm_procedimientos_info").remove();
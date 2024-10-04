/* Desarrollador: Airam Vargas
Fecha de creacion: 22 - 03 - 2024
Fecha de Ultima Actualizacion:
Actulizo:
Perfil: Recepcionista
Descripcion: JS del listado de resultados de laboratorio por paciente */

//CONTROLADOR
let this_js_script = $('#ruta'); // or better regexp to get the file name..
const CONTROLADOR = this_js_script.attr('data-my_var_1');

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA DE CITAS RECHAZADAS POR UN MÉDICO
let tabla = (orden_servicio, fecha, nombre) => {
  //
    $("#tabla_resultados").removeClass('d-none')
    var dataTableRes = $('#resultados').DataTable({
        ajax: {
            url: `${BASE_URL}${CONTROLADOR}/showTable`,
            data: {orden_servicio: orden_servicio, fecha: fecha, nombre : nombre},
            type:'post'
        },
        destroy: true,
    
        columns: [
            { 
                data: 'orden_servicio'
            },
            { 
                data: 'fecha',
                render: function(data, type, row, meta) {
                    return moment(data).format("DD-MM-YYYY");
                }
            },
            { 
                data: 'paciente'
            },
            { 
                data: 'status_name'
            },
            { 
                data: 'id_cita',
                render: function(data, type, row, meta) {
                    bandera = row.bandera == null ? 0 : parseFloat(row.bandera);
                    status_lab = parseFloat(row.status_lab);
                    switch(true){
                        case status_lab == 110 && bandera == 1:
                            return `<div class="d-flex justify-content-center">
                            <a target="_blank" href="${BASE_URL}Resultados/Resultados_pdf/imprimir/${data}"><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>`; 
                        case (status_lab == 110 && bandera == 2):
                            return `<div class="d-flex justify-content-center"><a target="_blank" href="${BASE_URL}../../public/uploads/resultados/${row.documento}" download><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>`;
                        default:
                            return ``
                    }
                }
            }
        ],
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        }
    });
    $('#loader').toggle();
}

$(document).on('click', '#orden', function(){
    formNombre = $("#busquedaNombre");
    $("#div1").removeClass('d-none');
    $("#div2").addClass('d-none');
    $("#orden_servicio").attr('required', 'required')
    $("#nombre").removeAttr('required', 'required')
    $("#fecha").removeAttr('required', 'required')
    $("#div_btn_busqueda").removeClass('d-none');
    
});

$(document).on('click', "#nombre", function(){
    formOrden = $("#busquedaOrden");
    $("#div2").removeClass('d-none');
    $("#div1").addClass('d-none');
    $("#orden_servicio").removeAttr('required', 'required')
    $("#paciente_name").attr('required', 'required')
    $("#fecha").attr('required', 'required')
    $("#div_btn_busqueda").removeClass('d-none'); 
});

//Enviar datos para busqueda por orden de servicio
$(document).on('submit', '#busquedaOrden', function(e){
    e.preventDefault();
    $('#loader').toggle();
    //let url = `${BASE_URL}${CONTROLADOR}/busquedaOrden`;
    orden_servicio = $("#orden_servicio").val();
    fecha = "";
    nombre = "";
    $('#resultados').DataTable().clear();
    tabla(orden_servicio, fecha, nombre);
});

//Enviar datos para busqueda por nombre y fecha
$(document).on('submit', '#busquedaNombre', function(e){
    e.preventDefault();
    $('#loader').toggle();
    orden_servicio = ""
    fecha = $("#fecha").val();;
    nombre = $("#paciente_name").val();
    $('#resultados').DataTable().clear();
    tabla(orden_servicio, fecha, nombre);
});

//RELOAD datatable aceptadas
function reloadData() {
    $('#loader').toggle();
    dataTableRes.ajax.reload();
    $('#loader').toggle();
}

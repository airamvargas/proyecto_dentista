/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 14 de noviembre de 2023
Fecha de Ultima Actualizacion: 14 de novimebre de 2023
Perfil: Paciente
Descripcion: Descarga de resultados */ 

// TABLA DE ESTUDIOS
dataTable = $("#crm_resultados").DataTable({
    ajax: {
        url: BASE_URL + "Api/Resultados/Resultados_paciente/show",
        data: {'id_cotizacion' : id_cotizacion},
        type: "post",
    },
    searching: false,
    paging: false,
    
    columns: [
        {
            data: "fecha",
            render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            }
        },
        {
            data: "producto"
        },
        
        {
            data: "id",
            render: function (data, type, row, meta) {
                bandera = row.bandera == null ? 0 : parseFloat(row.bandera);
                boton = bandera == 2 ? `<div class="d-flex justify-content-center"><a target="_blank" href="${BASE_URL}../../public/uploads/resultados/${row.documento}" download="${row.id}_${row.producto}"><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>` : `<div class="d-flex justify-content-center">
                <a target="_blank" href="${BASE_URL}Resultados/Resultados_pdf/imprimir/${row.id}" download="${row.id}_${row.producto}"><button title="Ver pdf" class="btn btn-teal  solid pd-x-20 btn-circle btn-sm"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a></div>`
                return boton;
            } 

        }
    ],
    language: {
        searchPlaceholder: "Buscar...",
        sSearch: "",
        lengthMenu: "_MENU_ Filas por página",
    },
});

$("#crm_resultados_info").hide();
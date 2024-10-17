/* TABLA DE PACIENTES */
var procedimientos = $('#citas_programadas').DataTable({
  ajax: {
    url: BASE_URL + '/Api/Pacientes/Agendar_cita/get_citas',
    type: "post",
  },
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  columns: [
    {
      data: 'nombre',
    },
    {
      data: 'observaciones',
    },
    {
      data: 'precio',
      render: function(data, tyoe, row, meta){
        return currency(data, { separator: ',', symbol: '$' }).format();
      }
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return '<div class="d-flex justify-content-center"> <button id="' + data + '" title="Editar condiciones" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-pencil" aria-hidden="true"></i></button>' +
        '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm" title="Eliminar condiciones" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button></div>'
      }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});

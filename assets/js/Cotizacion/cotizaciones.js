//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_cotizaciones').DataTable({
  order: [[0, 'desc']],
  ajax: {
    url: `${BASE_URL}${CONTROLADOR}/readCotizations`,
    data: {},
    type: "post",
  },

  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],

  columns: [
    {
      data: 'id'
    },
    {
      data: 'c_date',
      render: function(data, type, row, meta) {
        return moment(data).format("DD/MM/YY");
      }
    
    },
    { 
      data: 'vendedor'
    },
    { 
      data: 'cliente'
    },
    { 
      data: 'convenio', 
      render: function(data, type, row, meta) {
        if(data == null){
          return `NINGUNO`
        } else {
          return `${data}`
        }
      }
    },
    { 
      data: 'productos'
    },
    { 
      data: 'total',
      render: function (data, type, row, meta) {
        return currency(data, { symbol: "$", separator: "," }).format();
      }
    },
    {
      data: "id",
      render: function(data, type, row, meta) {
        return '<a href="'+BASE_URL+'Cotizaciones/ordenServicio/'+data+'"> <button class="btn btn-primary detalles solid pd-x-20 btn-circle btn-sm mr-2" title="Ver detalles"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a>' +
        '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
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
  }
});





//////////////////////sparklines/////////////////////////
sumVentasDays();
weekSumVentas();
sumVentasMonth();
sumVentasYears();


function sumVentasDays() {
  let url = BASE_URL + 'Api/Back_office/Dashboard/VentasXDia';
  //$('#loader').toggle();
  $.ajax({
    url: url,
    type: "POST",
    dataType: 'json',
    //data: JSON.stringify(data),
    success: function (data) {
      let ventas = data[0].total_dia;
      let pruebas = data[0].total_pruenas
      let pacientes = data[0].total_pacientes;

      days = ventas == null ? 0 : ventas;
      var totales = pruebas == null ? 0 : pruebas;
      $('#ventas_days').append(days);
      $('#num_pruebas').append(totales);
      $('#num_pacientes').append(pacientes);
    },
  });
}

function weekSumVentas() {
  let url = BASE_URL + 'Api/Back_office/Dashboard/VentasXweek';
  $.ajax({
    url: url,
    type: "POST",
    dataType: 'json',
    //data: JSON.stringify(data),
    success: function (data) {
      let ventas = data[0].total_semana;
      let pruebas = data[0].total_pruebas
      let pacientes = data[0].total_pacientes;

      week = ventas == null ? 0 : ventas;
      var totales = pruebas == null ? 0 : pruebas;
      var total_pacientes = pacientes == null ? 0 : pacientes;
      $('#vweek_ventas').append(week);
      $('#vweek_pruebas').append(totales);
      $('#vweek_pacientes').append(total_pacientes);
    },
  });
}

function sumVentasMonth() {
  let url = BASE_URL + 'Api/Back_office/Dashboard/VentasXMonth';
  $.ajax({
    url: url,
    type: "POST",
    dataType: 'json',
    success: function (data) {
      let ventas = data[0].total_mes;
      let pruebas = data[0].total_pruebas
      let pacientes = data[0].total_pacientes;

      month = ventas == null ? 0 : ventas;
      var totales = pruebas == null ? 0 : pruebas;
      var total_pacientes = pacientes == null ? 0 : pacientes;
      $('#month_ventas').append(month);
      $('#month_pruebas').append(totales);
      $('#month_pacientes').append(total_pacientes);
    },
  });
}

function sumVentasYears() {
  let url = BASE_URL + 'Api/Back_office/Dashboard/VentasXYear';
  $.ajax({
    url: url,
    type: "POST",
    dataType: 'json',
    success: function (data) {
      let ventas = data[0].total_anual;
      let pruebas = data[0].pruebas_anual
      let pacientes = data[0].pacientes_anual;

      year = ventas == null ? 0 : ventas;
      var totales = pruebas == null ? 0 : pruebas;
      var total_pacientes = pacientes == null ? 0 : pacientes;
      $('#year_ventas').append(year);
      $('#year_pruebas').append(totales);
      $('#year_pacientes').append(total_pacientes);
    },
  });
}

'use strict';
$('.sparkline1').sparkline('html', {
  type: 'bar',
  barWidth: 5,
  height: 50,
  barColor: '#0083CD',
  chartRangeMin: 0,
  chartRangeMax: 10
});

$('.sparkline2').sparkline('html', {
  type: 'bar',
  barWidth: 5,
  height: 50,
  barColor: '#fff',
  lineColor: 'rgba(255,255,255,0.5)',
  chartRangeMin: 0,
  chartRangeMax: 10
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////GRAFICAS/////////////////////////////
let barChart; // Variable global para la gráfica de barras
let pieChart; // Variable global para la gráfica de pastel

$(document).ready(function () {
  $('#loader').toggle();
  $('#div_tablas').hide();
  const fechaActual = new Date();
  const dia = String(fechaActual.getDate()).padStart(2, '0');
  const mes = String(fechaActual.getMonth() + 1).padStart(2, '0');
  const año = fechaActual.getFullYear();
  const fechaFormateada = `${año}-${mes}-${dia}`;
  $('#min').val(fechaFormateada);
  $('#max').val(fechaFormateada);

  const tipo = $('#datos').val();
  const busqueda = $('#tipo_dato').val();

  busquedaGrafica(busqueda, function (url) {
    console.log("URL del servicio:", url);
    sendData(url, function (response) {
      loadGraficas(response);
      console.log('Éxito:', response);
    });
  });
});

function busquedaGrafica(busqueda, callback) {
  let url;
  switch (busqueda) {
    case '2':
      url = BASE_URL + 'Api/Back_office/Dashboard/graficaPastelProductos';
      break;
    case '3':
      url = BASE_URL + 'Api/Back_office/Dashboard/graficaPastelConvenios';
      break;
    default:
      url = BASE_URL + 'Api/Back_office/Dashboard/graficaPastelUnidades';
      break;
  }
  callback(url);
}


function sendData(url, callback) {
  const fecha_inicial = $('#min').val();
  const fecha_final = $('#max').val();
  const datos = {
    fecha_inicial: fecha_inicial,
    fecha_final: fecha_final
  };
  $.ajax({
    url: url,
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify(datos),
    success: function (response) {
      callback(response);
    },
    error: function (error) {
      console.error('Error:', error);
    }
  });
}

function loadGraficas(response) {
  var names_grafica = [];
  var total_show = [];

  response.forEach(element => {
    names_grafica.push(element['producto']);
    total_show.push(element['total_precio']);
  });

  grafica_bar(names_grafica, total_show);
  graficaPastel(names_grafica, total_show);
}


//GRAFICA DE BARRAS
function grafica_bar(names_grafica, total_show) {
  if (barChart) {
    barChart.destroy(); // Destruir la gráfica existente si existe
  }

  let grafica_barras = `<div class="col-xl-8 mg-t-20 mg-xl-t-0">
      <div class="card pd-20 pd-sm-25 mg-t-40">
          <canvas id="myChart" width="800" height="800"></canvas>
      </div>
  </div>`;
  $("#graficaBarras").html(grafica_barras); // Usar html() en lugar de append() para reemplazar el contenido
  const ctx = document.getElementById('myChart').getContext('2d');
  barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: names_grafica,
      datasets: [{
        label: "DATOS",
        data: total_show,
        backgroundColor: [
          "#4169E1", "#9ACD32", "#EE82EE", "#40E0D0", "#B0C4DE", "#98FB98", "#DB7093", "#BA55D3", "#87CEFA", "#00FF7F"
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  $('#loader').toggle();
}

//GRAFICA DE PASTEL
function graficaPastel(names_grafica, total_show) {
  if (pieChart) {
    pieChart.destroy(); // Destruir la gráfica existente si existe
  }

  let grafica_pastel = `<div class="col-xl-8 mg-t-20 mg-xl-t-0">
      <div class="card pd-20 pd-sm-25 mg-t-40">
          <canvas id="myPieGraph" height="200"></canvas>
      </div>
  </div>`;
  $("#graficaPastel").html(grafica_pastel); // Usar html() en lugar de append() para reemplazar el contenido
  const pieCtx = document.getElementById('myPieGraph').getContext('2d');
  pieChart = new Chart(pieCtx, {
    plugins: [ChartDataLabels],
    type: 'pie',
    data: {
      labels: names_grafica,
      datasets: [{
        data: total_show,
        backgroundColor: [
          "#4169E1", "#9ACD32", "#EE82EE", "#40E0D0", "#B0C4DE", "#98FB98", "#DB7093", "#BA55D3", "#87CEFA", "#00FF7F"
        ],
        hoverOffset: 10,
      }],
    },
    options: {
      plugins: {
        datalabels: {
          color: "weight",
          font: {
            family: '"Times New Roman", Times, serif',
            size: "10",
            weight: "bold",
          },
        }
      }
    }
  });
}

//VALIDACION DE FECHA A SOLO 31 DIAS
function ajustarFechaFinal() {
  const fechaInicio = new Date($('#min').val());
  const fechaFinal = new Date($('#max').val());
  const fechaInicioMas30Dias = new Date(fechaInicio);
  fechaInicioMas30Dias.setDate(fechaInicioMas30Dias.getDate() + 31);

  if (fechaFinal > fechaInicioMas30Dias) {
    alert('La fecha final no puede ser mayor a 30 días después de la fecha de inicio.');
    $('#max').val(fechaInicioMas30Dias.toISOString().split('T')[0]);
    $('#loader').toggle();
  } else {
    const busqueda = $('#tipo_dato').val();
    busquedaGrafica(busqueda, function (url) {
      console.log("URL del servicio:", url);
      sendData(url, function (response) {
        loadGraficas(response);
        console.log('Éxito:', response);
      });
    });
  }
}

////////////////////////////////////EVENTOS//////////////////////////////////////

$('#max').change(function () {
  let type = $('#datos').val();
  if (type == 1) {
    $('#loader').toggle();
    ajustarFechaFinal();

  } else {
    $('#loader').toggle();
    const fechaInicio = new Date($('#min').val());
    const fechaFinal = new Date($('#max').val());
    const fechaInicioMas30Dias = new Date(fechaInicio);
    fechaInicioMas30Dias.setDate(fechaInicioMas30Dias.getDate() + 31);

    if (fechaFinal > fechaInicioMas30Dias) {
      alert('La fecha final no puede ser mayor a 31 días después de la fecha de inicio.');
      $('#max').val(fechaInicioMas30Dias.toISOString().split('T')[0]);
      $('#loader').toggle();
    }else{
      toggleView(type)
    }

  }
});


//select datos por
$('#tipo_dato').change(function () {
  let type = $('#datos').val();
  if (type == 1) {
    $('#loader').toggle();
    ajustarFechaFinal();

  } else {
    toggleView(type)
  }
});

$('#datos').change(function () {
  const viewType = $(this).val();
  toggleView(viewType);
});




////////////////////////////TABLAS //////////////////////////////////

let currentTable = null;
function toggleView(viewType) {
  if (viewType === "1") {
    $('#loader').toggle();
    $('#div_graficas').show();
    $('#div_tablas').hide();
    ajustarFechaFinal();
    // Lógica para cargar la gráfica
  } else if (viewType === "2") {
    $('#div_graficas').hide();
    $('#div_tablas').show();
    const dataType = $('#tipo_dato').val();
    toggleTable(dataType);
  }
}

function toggleTable(dataType) {
  if (currentTable) {
    currentTable.clear().destroy(); // Destruir la tabla actual si existe
    $('.filters').remove(); // Eliminar los filtros clonados
  }
  $('.table').hide(); // Ocultar todas las tablas
  $(`#tabla${dataType}`).show(); // Mostrar la tabla seleccionada

  switch (dataType) {
    case '1':
      currentTable = tableUnidad(`#tabla${dataType}`);
      break;
    case '2':
      currentTable = tableProducto(`#tabla${dataType}`);
      break;
    case '3':
      currentTable = tableProducto(`#tabla${dataType}`);
      break;
    // case '4':
    //   currentTable = initializeDataTable4(`#tabla${dataType}`);
    //   break;
  }
}

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
  let min = $("#min").val();
  let max = $("#max").val();
});

function tableUnidad(selector) {
  return $(selector).DataTable({
    //scrollX: true,
    processing: true,
    serverSide: true,
    order: [
      [0, 'asc']
    ],
    lengthMenu: [
      [10, 25, 50, 100, 999999],
      ["10", "25", "50", "100", "Mostrar todo"],
    ],
    dom: 'Blfrtip',
    buttons: [
      'excel'
    ],
    ajax: {
      url: `${BASE_URL}Api/Back_office/Reportes/readVentas`,
      type: "post",
      data: function (d) {
        d.minDate = $('#min').val();
        d.maxDate = $('#max').val();
      },
    },
    columns: [
      { data: 'id_cotizacion' },
      {
        data: 'fecha',
        render: function (data, type, row, meta) {
          return moment(data).format("YYYY-MM-DD");
        }
      },
      { data: 'unidad' },
      {
        data: 'convenio',
        render: function (data, type, row, meta) {
          return data == null ? '-' : data;
        }
      },
      {
        data: 'company',
        render: function (data, type, row, meta) {
          return data == "SIN EMPRESA" ? '-' : data;
        }
      },
      { data: 'paciente' },
      { data: 'forma_pago' },
      { data: 'tipo_pago' },
      {
        data: 'monto_pago',
        render: function (data, type, row, meta) {
          return currency(data, { symbol: "$", separator: "," }).format();
        }
      },
      {
        data: 'monto_pagado',
        render: function (data, type, row, meta) {
          let total = data == null ? 0 : parseFloat(row.monto_pago) - parseFloat(data);
          return currency(total, { symbol: "$", separator: "," }).format();
        }
      },
      {
        data: 'num_caja',
        render: function (data, type, row, meta) {
          return data > 0 ? data : '-';
        }
      },
      {
        data: "id_cotizacion",
        render: function (data, type, row, meta) {
          return `<div class="row justify-content-center"><a href="${BASE_URL}/Back_office/ReporteVentas/detalles/index/${data}" target="_blank"><button class="btn btn-primary detalles solid pd-x-20 btn-circle btn-sm mr-2" title="Ver detalles"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
        }
      },
    ],
    ordering: true,
    language: {
      searchPlaceholder: 'Buscar...',
      sSearch: '',
      lengthMenu: '_MENU_ Filas por página',
    },
    initComplete: function (settings, json) {
      $(selector + ' thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo(selector + ' thead');
      var api = this.api();
      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
          var title = $(cell).text();
          $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

          $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
            .off('keyup change')
            .on('keyup change', function (e) {
              e.stopPropagation();
              $(this).attr('title', $(this).val());
              var cursorPosition = this.selectionStart;
              api
                .column(colIdx)
                .search(this.value)
                .draw();
              $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
            });
        });
      quitaClase();

      function quitaClase() {
        $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
      }
    },
  });
}

function tableProducto(selector) {
  return $(selector).DataTable({
    processing: true,
    serverSide: true,
    order: [
      [0, 'asc']
    ],
    lengthMenu: [
      [10, 25, 50, 100, 999999],
      ["10", "25", "50", "100", "Mostrar todo"],
    ],
    dom: 'Blfrtip',
    buttons: [
      'excel'
    ],
    ajax: {
      url: `${BASE_URL}Api/Back_office/Reportes/reporteProductos`,
      type: "post",
      data: function (d) {
        d.minDate = $('#min').val();
        d.maxDate = $('#max').val();
      },
    },
    columns: [
      { data: 'id_cotizacion' },
      {
        data: 'fecha',
        render: function (data, type, row, meta) {
          return moment(data).format("YYYY-MM-DD");
        }
      },
      { data: 'unidad' },
      {
        data: 'convenio',
        render: function (data, type, row, meta) {
          return data == null ? '-' : data;
        }
      },
      { data: 'paciente' },
      {
        data: 'area_lab',
        render: function (data, type, row, meta) {
          if (row.name_table == 'cat_packets' || row.name_table == 'cat_products') {
            return row.categoria;
          } else {
            return row.area_lab;
          }
        }
      },
      { data: 'producto' },
      {
        data: 'price',
        render: function (data, type, row, meta) {
          return currency(data, { symbol: "", separator: "," }).format();
        }
      }
    ],
    ordering: true,
    language: {
      searchPlaceholder: 'Buscar...',
      sSearch: '',
      lengthMenu: '_MENU_ Filas por página',
    },
    initComplete: function (settings, json) {
      $(selector + ' thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo(selector + ' thead');
      var api = this.api();
      api
        .columns()
        .eq(0)
        .each(function (colIdx) {
          var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
          var title = $(cell).text();
          $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

          $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
            .off('keyup change')
            .on('keyup change', function (e) {
              e.stopPropagation();
              $(this).attr('title', $(this).val());
              var cursorPosition = this.selectionStart;
              api
                .column(colIdx)
                .search(this.value)
                .draw();
              $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
            });
        });
      quitaClase();

      function quitaClase() {
        $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
      }
    },
  });
}

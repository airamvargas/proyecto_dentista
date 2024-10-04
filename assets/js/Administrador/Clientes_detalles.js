//FORMATO EN ESPAÑOL FECHA
moment.locale("es");
get_detalles();
$(".guardar").attr('id', id_cotization_x_product);

$(document).on('submit', '#delete_form', function() {
  var formData = new FormData($(this)[0]);
  const url = `${BASE_URL}Administrador/Clientes/delete_doc`;

  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },

        }).showToast();

        window.location.reload();

      } else {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },

        }).showToast();
      }

    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});

$('.guardar').on('click', function () {
  let id = $(this).attr('id');
  let notes = $('#notes').val();
  if(notes == ""){
    Toastify({
      text: "NO HAY NOTAS PARA GUARDAR",
      duration: 3000,
      className: "info",
      // avatar: "../../assets/img/logop.png",
      style: {
        background: "linear-gradient(to right, #ee0c0c, #df8e13)",
      },
      offset: {
        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
      },

    }).showToast();
  } else {
    $(this).attr('disable', 'true');
    $('#loader').toggle();
  
    let data = {
      id : id,
      notes: notes
    };
    
    var url_notes = `${BASE_URL}Administrador/Clientes/insert_notes`;
  
    $.ajax({
      url: url_notes,
      type: "POST",
      dataType: 'json',
      data: JSON.stringify(data),
      success: function(result) {
        if (result.status == 200) {
          Toastify({
            text: result.messages.success,
            duration: 3000,
            className: "info",
            // avatar: "../../assets/img/logop.png",
            style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
  
          }).showToast();
          $('#loader').toggle();
          $(this).attr('disable', 'false');
  
        } else {
          Toastify({
            text: "HUBO UN ERROR. INTENTE DE NUEVO",
            duration: 5000,
            className: "info",
            //avatar : "../../../../../assets/icons/advertencia.png",
            style: {
              background: "linear-gradient(to right, #ee0c0c, #e63838)",
            },
            offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            }
          }).showToast();
          $('#loader').toggle();
          $(this).attr('disable', 'false');
        }
      },
      error: function(xhr, resp, text) {
        console.log(xhr, resp, text);
        $('#loader').toggle();
        $('#error-alert').show();
        $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
      }
    });
  }
  
});

var datapagos = $("#pagos-recibidos").DataTable({
  order: [[0, 'desc']],
  ajax: {
    url: `${BASE_URL}/Administrador/Clientes/pagos_cliente`,
    data: {'id' : id_cotization_x_product},
    type: "post",
  },
  searching: false,
  paging: false,

  lengthMenu: [
    [25, 10, 50, 100, 999999],
    ["25", "10", "50", "100", "Mostrar todo"],
  ],

  columns: [
    {
      data: "id",
    },
    {
      data: "date",
      render: function (data, type, row, meta) {
        return moment(data).format("DD/MM/YY");
      }
    },
    {
      data: "uds",
      render: function (data, type, row, meta) {
        return currency(data, {symbol: "", separator: ","}).format();
      }
    },
    {
      data: "tc"
    },
    {
      data: "pesos", 
      render: function (data, type, row, meta) {
        return currency(data, {symbol: "", separator: ","}).format();
      }
      
    },
    {
      data: "porciento"
    },
    {
      data: "banco"
    },
    {
      data: "proof_of_payment",
      render: function (data, type, row, meta) {
        return  data != " "  ?'<a href="../../../../Pagos/Comprobante/' + data + '" target="_blank">' + '<button type="button" class="  mg-b-10" data-dismiss="modal"><img src="../../../../../assets/img/Pdf-removebg-preview.png"  width="40px">' + '</button>' + '</a>'
        : " "
    }
    },
    {
      data: 'invoice_receipt',
      render: function (data, type, row, meta) {
        return  data != " "  ? '<a href="../../../../Pagos/Facturas/' + data + '" target="_blank">' + '<button type="button" class="  mg-b-10" data-dismiss="modal"><img src="../../../../../assets/img/Pdf-removebg-preview.png"  width="40px">' + '</button>' + '</a>'
        : " "
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
  responsive: true,
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: '_MENU_ Filas por página',
  },
});

$("#pagos-recibidos_info").hide();

var pagos_extranjero = $("#pagos-extranjero").DataTable({
  order: [[0, 'desc']],
  ajax: {
    url: `${BASE_URL}/Administrador/Clientes/pagos_cliente_extranjero`,
    data: {'id' : id_cotization_x_product},
    type: "post",
  },
  searching: false,
  paging: false,

  lengthMenu: [
    [25, 10, 50, 100, 999999],
    ["25", "10", "50", "100", "Mostrar todo"],
  ],

  columns: [
    {
      data: "id",
    },
    {
      data: "fecha",
      render: function (data, type, row, meta) {
        return moment(data).format("DD/MM/YY");
      }
    },
    {
      data: "banco"
    },
    {
      data: "usd",
      render: function (data, type, row, meta) {
        return currency(data, {symbol: "", separator: ","}).format();
      }
    },
    {
      data: "tipo_cambio"
    },
    {
      data: "pesos",
      render: function (data, type, row, meta) {
        return currency(data, {symbol: "", separator: ","}).format();
      }
    },
    {
      data: "proveedor_name"
    },
    {
      data: "porciento"
    },
    {
      data: "pdf",
      render: function(data, type, row, meta) {
        return `<i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
        <a href="${BASE_URL}/../../Pagos_extranjero/${data}" target="_blank">Ver archivo </a> `
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
  responsive: true,
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: '_MENU_ Filas por página',
  },
});
$("#pagos-extranjero_info").hide();

$(document).on('submit', '#form-generales', function() {
  var formData = new FormData($(this)[0]);
  const url = `${BASE_URL}/Administrador/Clientes/actualizar_datos`;

  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },

        }).showToast();

      } else {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
            background: "linear-gradient(to right, #ff0000, #96c93d)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },

        }).showToast();
      }

    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});

function get_detalles() {
  $('#loader').toggle();
  const url = `${BASE_URL}/Administrador/Clientes/get_detalles`;
  $.ajax({
    url: url,
    type: 'POST',
    data: { 'id': id_cotization, 'id_cotization_product' : id_cotization_x_product},
    dataType: 'json',
    success: function (data) {
      get_type_docs();
      const path = `${BASE_URL}../../public/images`
      $(".empresa-cliente").append(data['generales'][0]['empresa_cliente']);
      $(".resumen").attr('id', data['generales'][0]['id_cotization']);
      $(".edo-cuenta").attr('id', data['generales'][0]['id_cotization']);
      let fecha = moment(data['generales'][0]['date_create']).format("DD/MM/YY");
      let fecha_append = `<span style="font-weight: lighter;">${fecha}</span>`;
      $(".fecha").append(fecha_append);
      if(data['generales'][0]['id_status'] == null){
        let status_append = `<span style="font-weight: lighter; font-style: italic;">SIN STATUS</span>`;
        $(".etapa").append(status_append);
      } else {
        let status_append = `<span class="status">${data['generales'][0]['status_etapa']}</span>`;
        $(".etapa").append(status_append);
      }
      let photo = `<img id="img-1" class=" w-50" src="${path}/${data['generales'][0]['media_path']}" alt="First slide"></img>`
      $(".photo").append(photo);
      $("#nombre").val(data['generales'][0]['razon_social']);
      $("#contacto").val(data['generales'][0]['contacto']);
      $("#correo").val(data['generales'][0]['email']);
      $("#telefono").val(data['generales'][0]['phone']);
      $("#rfc").val(data['generales'][0]['rfc']);
      $("#dom_fiscal").val(data['generales'][0]['domicilio_fiscal']);
      $("#dom_entrega").val(data['generales'][0]['domocilio_entrega']);
      $("#id_cliente").val(data['generales'][0]['id_user_client']);
      $("#empresa").val(data['generales'][0]['empresa']);
      $("#maquina").val(data['generales'][0]['maquina']);
      $("#serie").val(data['generales'][0]['serie']);
      $("#modelo").val(data['generales'][0]['model']);
      $("#capacidad").val(data['generales'][0]['ability']);
      $("#num_serie").val(data['generales'][0]['numero_serie']);
      $("#voltaje").val(data['generales'][0]['volatje']);
      if(data['notes'] != ""){
        $("#notes").val(data['notes'][0]['nota']);
      }
      $("#dias_fab").val(data['generales'][0]['dias_fabricacion']);
      $("#dias_ent").val(data['generales'][0]['dias_entrega']);
      $("#cost_china").val(currency(data['generales'][0]['costo_china'], {symbol: "", separator: ","}).format());
      $("#precio_venta").val(currency(data['generales'][0]['price'], {symbol: "", separator: ","}).format());
      $(data['pagos']).each(function (i, v) {
        
        let inputs =  `<div class="row mg-lg-t-10 mg-sm-t-0 order-1" id="d_pagos">
          <input placeholder="" type="text" name="porcent[]" id="porcent" class="col-sm-2 form-control mg-t-10 text-center" value="${v.porciento}" readonly>
          <input placeholder="" type="text" name="mont[]" id="monto" class="col-sm-2 form-control mg-t-10 ml-1 text-center" value="${currency(v.monto, {symbol: "", separator: ","}).format()}" readonly>
          <input placeholder="" type="text" name="iva[]" id="iva" class="col-sm-2 form-control mg-t-10 ml-1 text-center" value="${v.iva}" readonly>
          <input placeholder="" name="tot[]" id="total" class="col-sm-2 form-control mg-t-10 ml-1 text-center" value="${currency(v.total, {symbol: "", separator: ","}).format()}" readonly>
          <input placeholder="" type="text" name="concept[]" id="concepto" class="col-sm-2 form-control mg-t-10 ml-1 text-center" value="${v.concepto}" readonly>
        </div>`;
        $(".pagos-div").append(inputs);
      });
      let total = `<div class="row mg-lg-t-10 mg-sm-t-0 order-1" id="d_pagos">
        <div class="col-sm-2 mg-t-10"></div>
        <div class="col-sm-2 mg-t-10"></div>
        <div class="col-sm-2 mg-t-10 text-right"><p class="sum-total">TOTAL</p></div>
        <input placeholder="" type="text" id="sum_total" name="sum_total" class="col-sm-2 form-control mg-t-10 total" value="${currency(data['sumas'][0]['total_pagos'], {symbol: "", separator: ","}).format()}" readonly style="margin-left: 12px;">
      </div>`;
      $(".pagos-div").append(total);
      $("#usd_pagos").val(currency(data['sumas'][0]['usd_pagos'], {symbol: "", separator: ","}).format());
      $("#pesos_pagos").val(currency(data['sumas'][0]['pesos_pagos'], {symbol: "", separator: ","}).format());
      if(data['sumas'][0]['porciento_pagos'] == null) {
        $("#porciento_pagos").val('0%');
      } else {
        $("#porciento_pagos").val(data['sumas'][0]['porciento_pagos']+'%');
      }
      $("#usd_extranjero").val(currency(data['sumas'][0]['usd_extranjero'], {symbol: "", separator: ","}).format());
      $("#pesos_extranjero").val(currency(data['sumas'][0]['pesos_extranjero'], {symbol: "", separator: ","}).format());
      $("#id_cotizacion_product").val(id_cotization_x_product);
      $("#id_cotizacion").val(id_cotization);
      $('#loader').toggle();
    },
  });
}

function get_type_docs(){
  $('#loader').toggle();
  const empresas = `${BASE_URL}/Administrador/Clientes/get_type_docs`;
  var select = $(".select2");
  $.ajax({
    url: empresas,
    method: "GET",
    dataType: "json",
    success: function (data) {
      const ch = data;
      $(ch).each(function (i, v) {
        select.append(
          '<option  value="' + v.id + '" >' + v.name + "</option>"
        );
      });
      $('#loader').toggle();
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
}


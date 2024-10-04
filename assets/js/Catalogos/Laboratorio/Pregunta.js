/*
Desarrollador: Jesus Esteban Sanchez Alcantara
Actualizado: Giovanni Zavala
Fecha Creacion: 16-agosto-2023
Fecha de Ultima Actualizacion: 20-septiembre-2023
Perfil: Administracion
Descripcion: Catalogo de preguntas
*/

// TABLA DE PREGUNTAS
dataTable = $("#tb_preguntas").DataTable({
  ajax: {
    url: BASE_URL + "/Api/Catalogos/Laboratorio/Preguntas/read",
    data: {},
    type: "post",
  },
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  columns: [
    {
      data: "question",
    },
    {
      data: "type_name",
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return row[0].values == null ? '<p>'+" "+'</p>' : '<p>'+row[0].values+'</p>'
       
      }
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<button id="' +
          data +
          '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
          '<button id="' +
          data +
          '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
        );
      },
    },
  ],
  columnDefs: [
    {
      className: "text-justify space",
      targets: [1],
    },
  ],
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: "_MENU_ Filas por página",
  },
});

//boton agregar otro valor update
$(document).on("click", "#clone-add-checkbox", function () {
  let html_input = `<div class="row align-items-center">
                        <div class="form-group col-11">
                            <input class="form-control" name="values[]" required>
                            <input type="hidden" class="form-control" name="ids[]"  value="0">
                        </div>
                        <div class="col-1">
                            <button id="0" type="button" class="delete-value btn btn-danger btn-circle btn-md" title="Borrar">
                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>`;
  $("#updateClone").append(html_input);
});

//actualizacion de la pregunta
$(document).on('submit', '#formQuestions', function (evt) {
  $("#loader").toggle();
    console.log(evt);
    evt.preventDefault();
    //$('#loader').toggle();
    let url = `${BASE_URL}Api/Catalogos/Laboratorio/Preguntas/updateQuestion`;
    let FORMDATA = new FormData($(this)[0])
    send(url, FORMDATA); 

});

//Envio de formulario POST 
let send = (url, data) =>
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
    .then(response => {
        if(response.status == 200){
            Toastify({
                text: response.msg,
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/correcto.png",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();
            $('#updateModal').modal('toggle');
            $('#loader').toggle();
            dataTable.ajax.reload();
        }else{
            Toastify({
                text: response.msg,
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/cancelar.png",
                style: {
                    background: "linear-gradient(to right, #f90303, #fe5602)",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();
            $('#updateModal').modal('toggle');
        }
        //response.status == 200 ? notificacion(response.msg, true, reload, modal, form,ref) : notificacion(response.msg, false)
    }).catch(err => alert(err))


//boton delete td
    $(document).on("click", ".delete-value", function () {
        let id_value = $(this).attr("id");
        if(id_value == "0"){
            var padre = $(this).parent().parent().remove();
        }else{
            $('#delete_check').val(id_value)
            $("#modal_checkbox").modal("toggle");
        } 
    })
    



// OBTENER DATOS DE PREGUNTAS A MOSTRAR EN EL MODAL
$(document).on("click", ".up", function () {
  $("#loader").toggle();
  const url = `${BASE_URL}Api/Catalogos/Laboratorio/Preguntas/getPregunta`;
  let pregunta = $(this).attr("id");
  //Checkbox update
  $.ajax({
    url: url,
    data: { id: pregunta },
    method: "post", //en este caso
    dataType: "json",
    success: function (success) {
      console.log(success);

      $("#updateClone").children().remove();
      $("#question").val(success['questions'][0].question);
      let respuesta = success['questions'][0].type + "|" + success['questions'][0].type_name;
      $("#type").val(respuesta);
      $("#checkbox_question").val(success['questions'][0].id_pregunta);
      const long = success['values'].length;
      
      if ((respuesta == "3|Checkbox") || (respuesta == "2|Selección") ) {
        $("#checkbox_update").removeClass("d-none");
        if(long >0){
          $(success['values']).each(function (i, v) {
            let html_input = `<div class="row align-items-center" id="div${v.id}">
                          <div class="form-group col-11">
                              <input class="form-control" id="name" name="values[]"  value="${v.name}">
                              <input type="hidden" class="form-control" name="ids[]"  value="${v.id}">
                          </div>
                          <div class="col-1">
                              <button type="button" id="${v.id}" class="delete-value btn btn-danger btn-circle btn-md" title="Borrar">
                                  <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                              </button>
                          </div>
                      </div>`;
            $("#updateClone").append(html_input);
          });
        }
      } else {
        $("#checkbox_update").addClass("d-none");
      } 

      
      $("#updateModal").modal("show");
      $("#loader").toggle(); 
    },
    error: function (xhr, text_status) {
      $("#loader").toggle();
    },
  });
});

// Funcion que muestra otros inputs si se escoge la opcion de checkbox
showCheckbox();
function showCheckbox() {
  $("#opcion").change(function (e) {
    if (($(this).val() == "3|Checkbox") || ($(this).val() == "2|Selección")) {
      $("#checkbox").addClass("d-block");
    } else {
      //en caso contrario oculta input de disciplina
      $("#checkbox").removeClass("d-block");
    }
  });
}

// Funcion que cambia de texto dependiendo lo escogido en el select
let appendOption = () => {
  $("#opcion").change(function (e) {
    if (($(this).val() == "3|Checkbox")) {
      var valor = document.querySelector('#app');
      valor.innerHTML = "CHECKBOX";
    } else if(($(this).val() == "2|Selección")){
      var valor = document.querySelector('#app');
      valor.innerHTML = "selector";
    }else{
      valor.append("");
    }
  });
}
appendOption();


showCheckboxUpd();
function showCheckboxUpd() {
  $("#type").change(function (e) {
    if (($(this).val() == "3|Checkbox") || ($(this).val() == "2|Selección")) {
      $("#checkbox_update").removeClass("d-none");
    } else {
      $("#checkbox_update").addClass("d-none");
    }
  });
}

// Clonacion del input de nombre de checkbox al hacer el create
// cache elements
var clone = $(".clone");
var addBtn = $("#clone-add");
var removeBtn = $(".clone-remove");
removeBtn.first().hide();
var cloneContainer = $(".cloneContainer");

// event to clone element // give unique id
addBtn.on("click", function () {
  var id = generateID();
  clone
    .clone()
    .appendTo(cloneContainer)
    .attr("data-id", id)
    .find(".clone-remove")
    .attr("data-id", id)
    .show();
});

// Unique ID generator
function generateID() {
  var numRand = Math.floor(Math.random() * 101);
  var dateRand = Math.floor(Date.now() / numRand);
  var result = dateRand.toString().substring(2, 8);
  return result;
}

// event to remove element
cloneContainer.on("click", ".clone-remove", function () {
  var btnID = $(this).attr("data-id");
  $(".clone[data-id=" + btnID + "]").remove();
});

// Clonacion del input de nombre de checkbox al hacer el update
var cloneCheckbox = $("#clone_update");
var addBtnCheckbox = $("#clone-add-checkbox");
var removeBtnCheckbox = $(".delete-clone");
removeBtnCheckbox.first().hide();
var cloneContainerCheckbox = $(".containerCkeckbox");

// event to clone element // give unique id
addBtnCheckbox.on("click", function () {
  var id_upd = generateID2();
  cloneCheckbox
    .clone()
    .appendTo(cloneContainerCheckbox)
    .attr("data-id", id_upd)
    .find(".delete-clone")
    .attr("data-id", id_upd)
    .show();
});

// Unique ID generator
function generateID2() {
  var numRand2 = Math.floor(Math.random() * 101);
  var dateRand2 = Math.floor(Date.now() / numRand2);
  var result2 = dateRand2.toString().substring(2, 8);
  return result2;
}

//DELETE CHECKBOX
$(document).on("submit", "#formValues", function (evt) {
    evt.preventDefault();
    var id = $('#delete_check').val();
   const FORMDATA = new FormData($(this)[0]);
    const url = `${BASE_URL}Api/Catalogos/Laboratorio/Preguntas/deleteValue`;
    //ajax
    fetch(url, {
        method: "POST",
        body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
      .then(response => {
          if(response.status == 200){
              Toastify({
                  text: response.msg,
                  duration: 3000,
                  className: "info",
                  avatar: BASE_URL + "../../assets/img/correcto.png",
                  style: {
                      background: "linear-gradient(to right, #00b09b, #96c93d)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },
              }).showToast();
              $('#div'+id).remove();
              $("#modal_checkbox").modal("toggle");
             
            
          }else{
              Toastify({
                  text: response.msg,
                  duration: 3000,
                  className: "info",
                  avatar: BASE_URL + "../../assets/img/cancelar.png",
                  style: {
                      background: "linear-gradient(to right, #f90303, #fe5602)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },
              }).showToast();
              $("#modal_checkbox").modal("toggle");
          }
          //response.status == 200 ? notificacion(response.msg, true, reload, modal, form,ref) : notificacion(response.msg, false)
      }).catch(err => alert(err))  
});

$(document).ready(function () {
  getData();
});

function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}

let getData = () => {
  $("#loader").toggle();
  let url = `${BASE_URL}Api/HCV/Operativo/Preguntas/getMuestra`;
  fetch(url)
    .then((response) => response.json())
    .catch((err) => alert(err))
    .then((response) => {
      $("#elementos").children().remove();
      const colores = Array(
        "bg-primary",
        "bg-success",
        "bg-warning",
        "bg-danger",
        "bg-info",
        "bg-indigo",
        "bg-purple",
        "bg-pink",
        "bg-orange"
      );
      response.forEach((element, index) => {
       
        let card = `<div class="col-md-4 mg-t-20 nover">
                <div class="card rounded-0">
                    <div class="card-header card-header-default bg-primary">
                      Estudio: ${element.name}
                    </div>
                    <div class="card-body bd bd-t-0">
                      <h5>Datos</h5>
                      <p class="mg-b-0"><b>Paciente :</b> <span>${element.paciente}</span></p>
                      <p class="mg-b-0"><b>Médico :</b> <span>${element.medico}</span></p>
                      <hr>
                      <h5>Requerimiento</h5>
                      <p class="mg-b-0"><b>Contenedor :</b> <span>${element.contenedor}</span></p>
                      <p class="mg-b-0"><b>Etiquetas :</b> <span>${element.n_labels}</span></p>
                      <hr>
                      <h5>Preparación</h5>
                      <p class="mg-b-0">${element.preparation}</p>
                      <br>
                      <div id="" class="col-12 botones">
                        <button id="imprimir" class="btn btn-primary active btn-block mg-b-10 codigo" data-cita="${element.id_cita}">Imprimir etiqueta</button>
                        <button id="finalizar" class="btn btn-success active btn-block mg-b-10 finalizar" data-cita="${element.id_cita}">Finalizar</button>
                      </div>                          
                    </div>
                </div>
        </div>`;
        $("#elementos").append(card);
       
      });
      $("#loader").toggle();
    })
    .catch((err) => alert(err));
};

/* BOTÓN PARA IMPRIMIR */
$(document).on('click', '.codigo', function() {
  let id = $(this).data('cita');
  window.open(`${BASE_URL}/HCV/Operativo/TomarMuestras/imprimir_etiqueta/${id}`, '_blank'); 
});

/* BOTÓN FINALIZAR */
$(document).on('click', '.finalizar', function() {
  let id = $(this).data('cita');
  $('#id_cita').val(id);
  $('#modal_finalizar ').modal('toggle');
  var parent = $(this).parent();
  finalizar(parent);
});

//Formulario incidencia para reimprimir
let finalizar = (parent) => {
  $(document).on('submit', '#form_finalizar', function (evt) {
    evt.preventDefault();
    $("#loader").toggle();
    let url = `${BASE_URL}Api/HCV/Operativo/TomarMuestras/finalizar`
    let FORMDATA = new FormData($(this)[0]);
  
    $('#modal_finalizar').modal('toggle');
    fetch(url, {
      method: "POST",
      body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
      .then(response => {
        parent.children().remove();
        if(response.count == 0){
          location.href = `${BASE_URL}HCV/Operativo/TomarMuestras`;
        }
        $("#loader").toggle();
    }).catch(err => alert(err))
  });

}




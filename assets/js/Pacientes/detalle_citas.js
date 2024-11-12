//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

let getDatos = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Consulta/getNombreHist/${id_paciente}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
      .then(response => {
        console.log(response);
        $("#n_paciente").append(`<h3 class="text-left">Paciente: ${response[0]['nombre']}</h3>`)
        $("#div_edad").append(`<h3 class="text-center">Edad: ${moment(response[0]['f_nacimiento']).toNow(true)}</h3>`)
        $('#loader').toggle();
      }).catch(err => alert(err));
}

getDatos();
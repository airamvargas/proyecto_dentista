let getData = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Consulta/getNombre/${id_cita}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            console.log(response);
            $("#n_paciente").append(`<h3 class="text-left">Paciente: ${response[0]['paciente']}</h3>`)
            $("#div_folio").append(`<h3 class="text-center">Folio: ${response[0]['id']}</h3>`)
            $('#loader').toggle();
        }).catch(err => alert(err))
}

getData();
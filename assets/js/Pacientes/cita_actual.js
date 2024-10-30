let getData = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Consulta/getNombre/${id_cita}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            return response;
        }).catch(err => alert(err))
}

getData();
notas ? $('#tab-nota').show() : $('#tab-nota').hide();
if (genero == "Hombre") {
    $('#gine').hide();
    $('#peri').hide();

} 
if (genero == "Mujer") {
    $('#andro').hide();
    $('#peri').hide();

}
if (edad < 5) {
    $('#peri').show();
    $('#gine').hide();
    $('#andro').hide();
}

if(grupo != 4) {
    readPaciente();
}

//carpetas
function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();

//Obtener datos del paciente
function readPaciente() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/readPaciente`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: {id_paciente: id_paciente},
        dataType: 'json',
        success: function (data) {
            let namePaciente = `<span>Paciente: ${data['nombre']}</span>`;
            $("#nombre_paciente").append(namePaciente);
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}


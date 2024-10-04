/* Desarrollador: Airam V. Vargas Lopez
Fecha de creacion: 17/10/2013
Fecha de Ultima Actualizacion: 
Perfil: General
Descripcion: Visualizar el código de verifiacación de los usuarios */

$(document).on('click', '#ver', function(){
    input = document.getElementById('codigo');
    if(input.type == "text"){
        input.type = "password";
    } else {
        input.type = "text";
        setTimeout(() => {
            input.type = "password";
        }, "30000");
    }
});
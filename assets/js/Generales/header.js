
let getUser = () => {
    let url = `${BASE_URL}Api/Generales/Getusuario/`;
    fetch(url).then(response => response.json()).catch(err => (err))
    .then(response => {
        if(response.lengh > 0){
            if(response[0]['FILE_USER'] !== undefined){
                response[0]['FILE_USER'] == "" ?  imagen = `${BASE_URL}`+"../uploads/default.png" : imagen =`${BASE_URL}`+"../uploads/medico/fotos/"+response[0]['FILE_USER'];
                $("#img-profile").attr("src",imagen);
            }

            if(response[0]['photo'] !== undefined){
                response[0]['photo'] == "" ?  imagen = `${BASE_URL}`+"../uploads/default.png" : imagen =`${BASE_URL}`+"../images/"+photo[0]['FILE_USER'];
                $("#img-profile").attr("src",imagen);
            }

            if(response[0]['PATH'] !== undefined){
                response[0]['PATH'] == null ?  imagen = `${BASE_URL}`+"../uploads/default.png" : imagen =`${BASE_URL}`+"../uploads/paciente/fotos/"+photo[0]['PATH'];
                $("#img-profile").attr("src",imagen);
            }

        }else{
            let imagen = `${BASE_URL}`+"../uploads/default.png"
            $("#img-profile").attr("src",imagen);
        }



        /*response[0]['FILE_USER'] == "" ?  imagen = `${BASE_URL}`+"../uploads/default.png" : imagen =`${BASE_URL}`+"../uploads/medico/fotos/"+response[0]['FILE_USER'];
        $("#img-profile").attr("src",imagen);*/
       
    }).catch(err =>(err));
   
}




$(document).ready(function() {
    getUser();
});





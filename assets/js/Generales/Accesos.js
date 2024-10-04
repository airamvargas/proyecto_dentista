
$.ajax({
    type: "GET",
    url: BASE_URL + '/Generales/Generales',
    cache: false,
    success: function (data) {
       var grupo = data;
       if(grupo == 1){
        //$('.btnbtn-delete').attr('disabled','disabled');
        }else{
            $('.btnbtn-delete').attr('disabled','disabled');
        } 
    }
});
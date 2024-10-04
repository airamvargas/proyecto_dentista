 $(".btn_insert").on('click', function() {
     $('#modal_insert').modal('show');
 });

 $('.btn_close_modal').on('click', function() {

     $("#modal_insert").modal('hide');
 });
 $(".btn_update").on('click', function() {
     $('#modal_update').modal('show');
 });

 $('.btn_close_modal').on('click', function() {

     $("#modal_update").modal('hide');
 });

 sendUpdateModal();
 //////


 //Aqui es cuando se ingresa boton de mostar
 $("#cp_search").keyup(function() {


     let search2 = $('#cp_search').val();

     var url_str = BASE_URL + "/Administrativo/Custom/get_cp";

     var cp = {
         "search": search2,
         "limit": "20",
         "offset": "0"

     };
     if (search2 != "") {


         $.ajax({
             url: url_str,
             type: 'POST',
             dataType: 'json',
             data: JSON.stringify(cp),
             success: function(response) {
                 console.log(response);
                 info = response.data;
                 var len = info.length;
                 $(".cpResult").empty();
                 for (var i = 0; i < len; i++) {
                     id = info[i].ID;
                     let cp = info[i].CP;
                     let asen = info[i].ASENTAMIENTO;
                     $(".cpResult").append("<li value='" + id + "'>" + cp + " " + asen + "</li>");
                 }

                 // binding click event to li
                 $(".cpResult li").bind("click", function() {
                     var value = $(this).text();
                     var id2 = $(this).val();
                     console.log(id2);
                     $("#cp_search").val(value);
                     $("#id_cp").val(id2);
                     //  console.log(info);
                     // console.log(id2)
                     $(".cpResult").empty();
                     var len = info.length;
                     for (var i = 0; i < len; i++) {
                         if (info[i].id == id2) {
                             $("#cp_search").val(value);



                         }
                     }
                 });
             }
         });
     }
 });
 /////////////////
 $(".btn_update").on('click', function() {

     // alert('Actualizacion');
     var search2 = $(this).attr('id');
     console.log(search2);
     var url_str = BASE_URL + "/Administrativo/Custom/get_cobertura";

     var cp = {
         "id": search2

     };
     console.log(cp);
     if (search2 != "") {


         $.ajax({
             url: url_str,
             type: 'POST',
             dataType: 'json',
             data: JSON.stringify(cp),
             success: function(response) {
                 console.log(response);
                 /* $('#cp_search2').val(response.data.id_hcv_cat_cp);
                 $('#sector').val(response.data.id_hcv_cat_sector); */
                 $('#cp_nombre').val(response[0].CP);
                 $('#id_cp2').val(response[0].id_hcv_cat_cp);
                 $('#sector_actualizar').val(response[0].id_hcv_cat_sector);

                 $('#id').val(response[0].id);

                 $('#modal_update').modal('show');
             }
         });
     }
 });

 function sendUpdateModal() {
    $(document).on('click', '#submit_form_upd', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + 'Administrativo/Custom/update_cobertura';
        var loginForm = $("#update_form").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
            }
        );
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    location.reload();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_update').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_update').modal('toggle');
            }
        })
    });
}

 $(".btn_delete").on('click', function () {
    var search2 = $(this).attr('id');
    $("#id_cobertura_delete").val(search2);
    $('#modal_delete').modal('show');
});

 $("#cp_nombre").keyup(function() {


    let search2 = $('#cp_nombre').val();

    var url_str = BASE_URL + "/Administrativo/Custom/get_cp";

    var cp = {
        "search": search2,
        "limit": "20",
        "offset": "0"

    };
    if (search2 != "") {


        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(cp),
            success: function(response) {
                console.log(response);
                info = response.data;
                var len = info.length;
                $(".cpResult").empty();
                for (var i = 0; i < len; i++) {
                    id = info[i].ID;
                    let cp = info[i].CP;
                    let asen = info[i].ASENTAMIENTO;
                    $(".cpResult").append("<li value='" + id + "'>" + cp + " " + asen + "</li>");
                }

                // binding click event to li
                $(".cpResult li").bind("click", function() {
                    var value = $(this).text();
                    var id2 = $(this).val();
                    console.log(id2);
                    $("#cp_search2").val(value);
                    $("#id_cp2").val(id2);
                    //  console.log(info);
                    // console.log(id2)
                    $(".cpResult").empty();
                    var len = info.length;
                    for (var i = 0; i < len; i++) {
                        if (info[i].id == id2) {
                            $("#cp_search2").val(value);



                        }
                    }
                });
            }
        });
    }
});

 //////
 $("#cp_search2").keyup(function() {


     let search2 = $('#cp_search2').val();

     var url_str = BASE_URL + "/Administrativo/Custom/get_cp";

     var cp = {
         "search": search2,
         "limit": "20",
         "offset": "0"

     };
     if (search2 != "") {


         $.ajax({
             url: url_str,
             type: 'POST',
             dataType: 'json',
             data: JSON.stringify(cp),
             success: function(response) {
                 console.log(response);
                 info = response.data;
                 var len = info.length;
                 $(".cpResult").empty();
                 for (var i = 0; i < len; i++) {
                     id = info[i].ID;
                     let cp = info[i].CP;
                     let asen = info[i].ASENTAMIENTO;
                     $(".cpResult").append("<li value='" + id + "'>" + cp + " " + asen + "</li>");
                 }

                 // binding click event to li
                 $(".cpResult li").bind("click", function() {
                     var value = $(this).text();
                     var id2 = $(this).val();
                     console.log(id2);
                     $("#cp_search2").val(value);
                     $("#id_cp2").val(id2);
                     //  console.log(info);
                     // console.log(id2)
                     $(".cpResult").empty();
                     var len = info.length;
                     for (var i = 0; i < len; i++) {
                         if (info[i].id == id2) {
                             $("#cp_search2").val(value);



                         }
                     }
                 });
             }
         });
     }
 });



 var dataTable = $('#datatable1').DataTable({
     language: {
         searchPlaceholder: 'Buscar...',
         sSearch: '',
         lengthMenu: '_MENU_ Filas por página',
     }
 });
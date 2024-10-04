 //Aqui es cuando se ingresaboton de mostar
 $(".btn_update").on('click', function () {


     var search2 = $(this).attr('id');

     var url_str = BASE_URL + "/Administrativo/Membresia/get_member";

     var cp = {
         "id": search2

     };
     if (search2 != "") {
         $.ajax({
             url: url_str,
             type: 'POST',
             dataType: 'json',
             data: JSON.stringify(cp),
             success: function (response) {
                 console.log(response);
                 $('#name_sector').val(response.data.name);
                 $('#description_sector').val(response.data.description);
                 $('#id_sector').val(response.data.id);
                 $('#update_modal').modal('show');
             }
         });
     }
 });



 $(".btn_delete").on('click', function () {


     var search2 = $(this).attr('id');

     $("#id_sector_delete").val(search2);
     $('#modal_delete').modal('show');


 });


 $(".btn_insert").on('click', function () {

     $('#insert_modal').modal('show');


 });



 var dataTable = $('#datatable1').DataTable({
     language: {
         searchPlaceholder: 'Buscar...',
         sSearch: '',
         lengthMenu: '_MENU_ Filas por página',
     }
 });
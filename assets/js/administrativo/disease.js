
 //Aqui es cuando se ingresaboton de mostar
        $(".btn_update").on('click',function() {

           // alert('Actualizacion');
                    var search2 = $(this).attr('id');

                    var url_str = BASE_URL+"/Administrativo/Disease/get_dis";

                    var cp = {
                        "id":search2

                    };
                    if (search2 != "") {


                        $.ajax({
                            url: url_str,
                            type: 'POST',
                            dataType: 'json',
                            data: JSON.stringify(cp),
                            success: function(response) {
                                console.log(response);
                                $('#scientific_name').val(response.data.SCIENTIFIC_NAME);
                                $('#common_names').val(response.data.COMMON_NAMES);
                                $('#description').val(response.data.DESCRIPTION);
                                $('#short_description').val(response.data.SHORT_DESCRIPTION);
                                $('#id_sick').val(response.data.ID);
                                $('#update_modal').modal('show');
                            }
                        });
                    }
                });



 $(".btn_delete").on('click',function() {


                    var search2 = $(this).attr('id');

                    $("#id_sector_delete").val(search2);
                    $('#modal_delete').modal('show');


                });


 $(".btn_insert").on('click',function() {

                    $('#insert_modal').modal('show');


                });


 var dataTable = $('#datatable1').DataTable({
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
    }
});
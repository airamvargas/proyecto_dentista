 $("#select_cat_cp").on('change',function(){
        let id=$("#select_cat_cp option:selected").val();
       // alert(id);
        var url_str = BASE_URL+"/Administrativo/Membresia/get_sector";

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
                                $('#name_sector').val(response.data.name);
                                $('#description_sector').val(response.data.description);
                                $('#id_sector').val(response.data.id);
                                $('#update_modal').modal('show');
                            }
                        });
                    }
    });
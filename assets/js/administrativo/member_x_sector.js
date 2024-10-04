

get_tipo_cita();


function get_tipo_cita() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_Tipo_cita';
    var citas = $(".citas");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
			citas.append('<option  value=" ">' + "SELECCIONA TIPO DE CITA"+ '</option>');
		
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                citas.append('<option  value="' + v.id + '">' + v.tipo_cita + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}



$('.btn_insert').on('click',function(){
	$('#insert_modal').modal('show');
});


 $(".btn_delete").on('click',function() {
	var search2 = $(this).attr('id');
    $("#id_sector_delete").val(search2);
    $('#modal_delete').modal('show');


});

           


$('.btn_update').on('click',function(){
	var search2 = $(this).attr('id');

	var url_str = BASE_URL+"/Administrativo/Membresia/get_member_x_sector";

	var cp = {
		"id":search2

	};
	$.ajax({
		url: url_str,
		type: 'POST',
		dataType: 'json',
		data: JSON.stringify(cp),
		success: function(response) {
			console.log(response);
			console.log(response.data.precio);
		$("#select_sector_update option[value='"+response.data.id_hcv_cat_sector+"']").attr("selected", true);
		$("#select_member_update option[value='"+response.data.id_hcv_cat_membresia+"']").attr("selected", true);
		$("#precio_update").val(response.data.precio);
		$("#id").val(response.data.id);
		}
	});
	$('#update_modal').modal('show');
});





var dataTable = $('#datatable1').DataTable({
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
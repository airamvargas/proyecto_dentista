//    getSucursal();


// //    $('#btn_new_product').on('click',function(){
// //         $('#modaldemo1').modal('show');
// //     })

/* <th class="wd-10p">FOLIO DE <?=getTag("routes")?></th>
<th class="wd-10p">IDENTIFICADOR</th>
<th class="wd-10p">FECHA DE CREACION</th>
<th class="wd-10p">FECHA DE EJECUCION</th>
<th class="wd-10p">ESTATUS</th> */

// A $( document ).ready() block.
    $( document ).ready(function() {
        var dataTable = $('#route_table').DataTable({
            ajax: BASE_URL + 'Logistica/Rutas',
            "order": [[ 3, "desc" ]],
            columns: [
                { data: 'id' },
                { data: 'executed_at' },
                { data: 'status' , render : function ( data, type, row, meta ) {
                    switch (true) {
                        case data == 0:
                            return "PENDIENTE"
                            break;
                        case data == 1:
                            return "EN TRANSITO"
                            break;
                        case data == 2:
                            return "TERMINADA"
                            break;
                        default:
                            return "INDEFINIDO"
                            break
                    }
                    }
                },
                { data: "id" , render : function ( data, type, row, meta ) {
                    switch (true) {
                        case row.status == 0:
                                return `<button data-index="`+row.id+`" class=\"liberar btn btn-success mg-r-10\">LIBERAR</button> 
                                        <button data-index="`+row.id+`" class=\"actualizar btn btn-indigo  mg-r-10\">ACTUALIZAR</button>
                                        <button data-index="`+row.id+`" class=\"descartar btn btn-danger\">DESCARTAR</button>`;
                            break;
                        case row.status == 1:
                                return `<button data-index="`+row.id+`" class=\"detalles btn btn-info\">DETALLES</button>`;
                            break;
                        default:
                            return "<button class=\"btn\">VER</button>"
                            break;
                    }
                    }
                },
            ],
            responsive: true,
            language: {
                searchPlaceholder: 'Buscar...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('click', '.liberar', function() {
            $('#loader').toggle();
            var url_str = base_url + 'Api/Rutas/update_status';
            $.ajax({
                url: url_str,
                data: {
                    'index': $(this).data('index')
                }, //capturo array     
                method: 'post', //en este caso
                dataType: 'json',
                success: function(result , textStatus , xhr) {
                    if(xhr.status == 200){
                        reloadData()
                        $('#loader').toggle();
                        alert(result.message);
                    }
                },
                error: function(xhr, text_status) {
                    alert('No pudo conectar con el servicio de rutas');
                    $('#loader').toggle();
                }
            });
        })

        $(document).on('click', '.actualizar', function() {
            window.location.href = base_url + '/BO_rutas/actualizar/' + $(this).data('index');
        })

        $(document).on('click', '.descartar', function() {
            $('#loader').toggle();
            var url_str = base_url + 'Api/Rutas/discard';
            $.ajax({
                url: url_str,
                data: {
                    'index': $(this).data('index')
                }, //capturo array     
                method: 'post', //en este caso
                dataType: 'json',
                success: function(result , textStatus , xhr) {
                    if(xhr.status == 200){
                        reloadData()
                        $('#loader').toggle();
                        alert(result.message);
                    }
                },
                error: function(xhr, text_status) {
                    alert('No pudo conectar con el servicio de rutas');
                    $('#loader').toggle();
                }
            });
        })

        $(document).on('click', '.detalles', function() {
            window.location.href = base_url + 'BO_rutas/detalles/' + $(this).data('index');
        })

        function reloadData(){
            $('#loader').toggle();
            dataTable.ajax.reload();
            $('#loader').toggle();
        }



        // reloadData();
    });
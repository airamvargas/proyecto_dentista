<script src="../../assets/lib/jquery/jquery.js"></script>
<link href="../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../assets/lib/select2/css/select2.min.css" rel="stylesheet">

<div class="sl-mainpanel">
  <div class="sl-pagebody">
    <div class="card pd-10 pd-sm-20">
      <div class="sl-page-title">
        <div class="col-md-3">
          <h5 class="mt-3">Módulos</h5>
        </div>
        <div class="col-md-3">
          <p><button class="btn btn-success" id="btn-insert"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Nuevo módulo</button></p>
        </div>
      </div><!-- sl-page-title -->
      <div class="">
        <table id="datatable1" class="table table-responsive modulos" style="width: 100%;">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Controlador</th>
              <th>Phase</th>
              <th>Active</th>
              <th>Mostrar</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($modules as $key) : ?>
              <tr>
                <td><?php echo $key->id; ?></td>
                <td><?php echo $key->name; ?></td>
                <td><?php echo $key->description; ?></td>
                <td><?php echo $key->controller; ?></td>
                <td><?php echo $key->phase; ?></td>
                <td><?php echo $key->active; ?></td>
                <td><?php echo $key->show_in_menu; ?></td>
                <td>
                  <div class="d-flex">
                    <button class="btn-update btn btn-warning mr-1" id="<?php echo $key->id; ?>"><i class="fa fa-pencil mr-1" aria-hidden="true"></i>Actualizar</button>
                    <button class="btn-delete btn btn-danger" id="<?php echo $key->id; ?>"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                  </div>
                </td>

              </tr>
            <?php endforeach; ?>


          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div><!-- card -->

    <p class="tx-11 tx-uppercase tx-spacing-2 mg-t-40 mg-b-10 tx-gray-600">Javascript Code</p>
    <pre><code class="javascript pd-20"></code></pre>

    <!--MODAL INSERTAR-->
    <div id="insertar" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header bg-success pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Nuevo módulo</h6>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="<?php echo base_url() . '/Modules/insert_module' ?>">
            <div class="modal-body pd-25">
              <div class="row container">
                <label>Nombre del módulo: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nombre del Modulo:" required>
              </div>
              <div class="row container mt-3">
                <label>Descripcion:<span class="tx-danger">*</span></label>
                <textarea rows="2" class="form-control" name="description" placeholder="Descripcion del Modulo:" required></textarea>
              </div>

              <div class="row container mt-3">
                <label>Controlador<span class="tx-danger">*</span></label>
                <input type="text" class="form-control" name="controller" placeholder="Controlador:" required>
              </div>

              <div class="row container mt-3">
                <label class="form-control-label">Selecciona categoría: <span class="tx-danger">*</span></label>
                <select id="empleado" name="id_group" class="form-control select2" data-placeholder="Choose country" required>
                  <option value="" name="id_group">Selecciona Categoria</option>
                  <?php
                  /* var_dump($group); */
                  foreach ($group as $key) {
                    echo ('<option  value="' . $key->id . '" name="id_group">' . $key->name . '</option>');
                  }
                  ?>
                </select>
              </div><!-- col-4 -->

              <div class="row container">
                <div class="col-12 px-0 mt-3 form-group mg-b-0-force">
                  <label class="form-control-label">Visible en el menu: <span class="tx-danger">*</span></label>
                  <select name="visible" class="form-control select2" data-placeholder="Selecciona" required>
                    <option value="">Selecciona</option>
                    <option value="1">Visible</option>
                    <option value="0">No Visible</option>
                  </select>
                </div>
              </div><!-- col-4 -->
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pd-x-20"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Agregar módulo</button>
              <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>

          </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <!--MODAL update-->
    <div id="update" class="modal fade">
      <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header bg-warning pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Actualizar módulo</h6>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="<?php echo base_url() . '/Modules/update_module' ?>">
            <div class="modal-body pd-25">
            <p class="mg-b-20 mg-sm-b-30">Edite el campo que quiere actualizar.</p>

              <label class="mt-3">Nombre del módulo</label>
              <input type="text" class="form-control" name="name" id="name_update" placeholder="Nombre del Modulo:">

              <label class="mt-3">Descripción del módulo</label>
              <textarea rows="2" class="form-control" name="description" id="description_update" placeholder="Descripcion del Modulo:"></textarea>

              <div class="col-12 px-0 mt-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Selecciona Categoria: <span class="tx-danger">*</span></label>
                  <select id="category" name="id_group" class="form-control select2" data-placeholder="Choose country" required>
                    <option value="" name="user">Selecciona Categoria</option>
                    <?php
                    foreach ($group as $key) {
                      echo ('<option  value="' . $key->id . '" name="user">' . $key->name . '</option>');
                    }
                    ?>
                  </select>

                  </select>
                </div>
              </div><!-- col-4 -->


              <div class="col-12 px-0 mt-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Visible en el menu: <span class="tx-danger">*</span></label>
                  <select id="mySelect" name="visible" class="form-control select2" data-placeholder="Selecciona" required>

                  </select>
                </div>
              </div><!-- col-4 -->

              <div class="col-12 px-0 mt-3">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Activo: <span class="tx-danger">*</span></label>
                  <select id="activo" name="activo" class="form-control select2" data-placeholder="Selecciona" required>

                  </select>
                </div>
              </div><!-- col-4 -->


              <input type="hidden" name="id_update" id="id_update">
              <div class="modal-footer">
                <button type="submit" class="btn btn-warning pd-x-20"><i class="fa fa-pencil mr-1" aria-hidden="true"></i>Actualizar módulo</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->



  <!--Modal delete-->
  <div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content bd-0 tx-14">
        <div class="modal-header bg-danger pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar módulo.</h6>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="<?php echo base_url() . '/Modules/delete_module' ?>">
          <div class="modal-body pd-20">
            <p class="mg-b-5">¿Deseas eliminar estos datos?</p>
            <input type="hidden" name="id_delete" id="id_delete">
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
            <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
          </div>
        </form>
      </div>
    </div><!-- modal-dialog -->
  </div><!-- modal -->


  <script src="../../assets/lib/datatables/jquery.dataTables.js"></script>
  <script src="../../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
  <script src="../../assets/lib/select2/js/select2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.btn-update').on('click', function() {
        let id_buton = $(this).attr('id');
        let json = {
          id: id_buton
        };
        $.ajax({
          url: '<?php echo base_url() . '/Modules/get_data_json' ?>',
          type: "POST",
          data: json,
          dataType: "JSON",
          success: function(success) {
            console.log(success);
            $('#name_update').val(success[0].name);
            $('#description_update').val(success[0].description);
            $('#id_update').val(id_buton);
            $('#category').val(success[0].idgroup);


            let valor = success[0].show_in_menu;
            var opnombre;
            let activo = success[0].active;

            if (valor === "1") {
              var opnombre = "Visible";

              $('#mySelect option').remove();
              $('#mySelect').append($('<option>', {
                value: success[0].show_in_menu,
                text: opnombre
              }));

              $('#mySelect').append($('<option>', {
                value: 0,
                text: "No Visible"
              }));


            } else {

              var opnombre = "No Visible";
              $('#mySelect option').remove();
              $('#mySelect').append($('<option>', {
                value: success[0].show_in_menu,
                text: opnombre
              }));

              $('#mySelect').append($('<option>', {
                value: 1,
                text: "Visible"
              }));

            }

            ////////// select activo//////

            if (activo === "1") {
              var selectname = "Activo";

              $('#activo option').remove();
              $('#activo').append($('<option>', {
                value: activo,
                text: selectname
              }));

              $('#activo').append($('<option>', {
                value: 0,
                text: "No Activo"
              }));


            } else {

              var selectname = "No Activo";
              $('#activo option').remove();
              $('#activo').append($('<option>', {
                value: activo,
                text: selectname
              }));

              $('#activo').append($('<option>', {
                value: 1,
                text: "Activo"
              }));

            }

          }

        }); //AJAX

        $('#update').modal('show');
      });

      // muestra el modal de agregar

      $('#btn-insert').on('click', function() {

        $('#insertar').modal('show');
      })

      //funcion para eliminar dato de la tabla 

      $('.btn-delete').on('click', function() {
        $('#modal_delete').modal('show');
        let id = $(this).attr('id');
        $('#id_delete').val(id);
      })


    }); //Ready function



    $('#datatable1').DataTable({
      language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
      }
    });
  </script>
<div id="loader" class="modal fade show" style=" padding-left: 0px; z-index: 999999999;">
  <div class="modal-dialog modal-dialog-vertical-center" role="document">
    <div class="d-flex ht-300 pos-relative align-items-center">
      <div class="sk-chasing-dots">
        <div class="sk-child sk-dot1 bg-red-800"></div>
        <div class="sk-child sk-dot2 bg-green-800"></div>
      </div>
    </div>
  </div>
</div>

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <div class="sl-pagebody">
    <div class="card pd-20 pd-sm-40">

      <div class="sl-page-title">
        <h5 class="text-uppercase"><?= $title ?></h5>
        <p><?= $description ?></p>
      </div><!-- sl-page-title -->

      <div class="col-md-3 pl-0">
        <a href="<?php echo base_url() . '/Cotizaciones/busqueda' ?>" class="btn btn-success"> <i class="fa fa-plus mr-1" 
          aria-hidden="true"></i>Nueva cotización
        </a><br><br>
      </div>

      <div class="">
        <table id="crm_cotizaciones" class="table display table-responsive 
        product_list nowrap" style="width: 100%;">
          <thead>
            <tr>
              <th class="wd-15p text-center"></th>
              <th class="wd-15p text-center">FECHA</th>
              <th class="wd-15p text-center">NOMBRE VENDEDOR</th>
              <th class="wd-15p text-center">NOMBRE PACIENTE</th>
              <th class="wd-15p text-center">CONVENIO</th>
              <th class="wd-15p text-center">PRODUCTO(S)</th>
              <th class="wd-15p text-center">TOTAL</th>
              <th class="wd-15p text-center">ACCIONES</th>
            </tr>
          </thead>
          <tbody class="text-center">
          </tbody>
        </table>
      </div><!-- table-wrapper -->
    </div>
  </div>
</div>

<!--ELIMINAR COTIZACION-->
<div id="modal_delete" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bd-0 tx-14">
      <div class="modal-header bg-danger pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR <?= $title ?></h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="formDelete">
        <div class="pd-80 pd-sm-80 form-layout form-layout-4">
          <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
          <br>
          <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
          <input type="hidden" name="id_delete" id="id_delete">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger btn btn-delete pd-x-20"><i class="fa fa-trash mr-1"
          aria-hidden="true"></i>Eliminar</button>
          <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
          class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
        </div>
      </form>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<form method="POST" id="detalles" class="mb-200">
  <input type="hidden" name="id_cotizacion" id="id_cotizacion">
  <input type="hidden" name="id_usuario" id="id_usuario">
  <input type="hidden" name="id_convenio" id="id_convenio">
</form> 


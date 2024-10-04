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


<div class="sl-mainpanel">
  <div class="sl-pagebody">
    <div class="card pd-20 pd-sm-40">
      <div class="sl-page-title">
        <h5 class="text-uppercase"><?= $title ?></h5>
        <p><?= $description ?></p>
      </div><!-- sl-page-title -->

      <div class="mg-t-20 text-right">
        <h4 id="total">TOTAL A PAGAR: </h4>
      </div>

      <div class="pd-20 pd-sm-20 form-layout form-layout-4">
        <form id="insert_pago">
          <div class="row justify-content-center">
            <div class="form-group mg-b-0 col-xl-4 col-lg-4 col-md-4 mg-b-20">
              <label class="form-control-label mg-b-10">Forma de pago:</label>
              <select id="forma_pago" class="form-control bd-radius formas" name="forma_pago" required></select>
            </div>

            <div class="form-group mg-b-0 col-xl-4 col-lg-4 col-md-4 mg-b-20" id="tipo-pago">
              <label class="form-control-label mg-b-10">Tipo de pago:</label>
              <select id="tipo_pago" class="form-control bd-radius tipo" name="tipo_pago" required></select>
            </div>

            <div class="form-group mg-b-0 col-xl-4 col-lg-4 col-md-4 mg-b-20">
              <div class="row">
                <label class="form-control-label mg-b-10 col-xl-7 col-lg-7 col-md-7">Monto de pago: </label> 
                <div class="col-xl-5 col-lg-5 col-md-5">
                  <span class="float-right"><input id="check-total"  type="checkbox" checked>Total</span>
                </div>
                
              </div>
              <input type="text" name="cantidad" id="cantidad" class="form-control bd-radius" required>
              <input type="hidden" id="restante">
            </div>
            
          </div>
          <div class="row justify-content-center">
            <div class="form-group mg-b-0 col-xl-3 col-lg-4 col-md-4 mg-b-20 efectivo">
              <label class="form-control-label mg-b-10">Monto recibido:</label>
              <input type="text" name="recibido" id="recibido" class="form-control bd-radius">
            </div>
            <div class="form-group mg-b-0 col-xl-3 col-lg-4 col-md-4 mg-b-20 efectivo">
              <label class="form-control-label mg-b-10">Cambio a devolver:</label>
              <input type="text" name="cambio" id="cambio" class="form-control bd-radius" readonly>
            </div>
            <div class="form-group mg-b-0 col-xl-3 col-lg-4 col-md-4 mg-md-t-40 mg-lg-t-20 mg-t-20 text-center">
              <button id="agregar" type="submit" class="btn btn-purple float-center"><i class="fa fa-plus-circle" aria-hidden="true"></i> AGREGAR PAGO</button>
            </div>
          </div>
        </form>
        
      </div>
    </div>
    <div id="estudios" class="pd-20 pd-sm-20">
      <div class="mg-b-20">
        <h5>PAGOS REALIZADOS</h5>
      </div>
      
      <div class="">
        <table id="crm_pagos" class="table display table-responsive 
        product_list nowrap" style="width: 100%;">
          <thead>
            <tr>
              <th class="wd-15p text-center">FORMA DE PAGO</th>
              <th class="wd-15p text-center">TIPO DE PAGO</th>
              <th class="wd-15p text-center">CANTIDAD</th>
              <th class="wd-15p text-center">ACCIONES</th>
            </tr>
          </thead>
          <tbody class="text-center"></tbody>
        </table>
      </div><!-- table-wrapper -->

      <div class="mg-t-40">
        <div class="justify-content-center">
          <button id="terminar" type="button" class="btn btn-success pd-x-20 ml-2 float-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> CONTINUAR</button>
          <!-- <button id="" type="button" class="btn btn-warning pd-x-20 ml-2 float-right"><i class="fa fa-clock-o" aria-hidden="true"></i> DEJAR PENDIENTE</button>  -->
        </div>   
      </div>            
            
    </div>
  </div>
</div>

<!-- ACTUALIZAR PAGO-->
<div id="updateModal" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header bg-warning pd-x-20">
          <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR PAGO</h6>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <form id="form_update" enctype="multipart/form-data">
        <div class="pd-20">
          <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Datos de la asignación del producto</h6>
            <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
            <div class="form-layout">
              <div class="row">
                <div class="form-group mg-b-0 col-lg-12 mg-b-20">
                  <label class="form-control-label mg-b-10">Forma de pago:</label>
                  <select id="forma_update" class="form-control bd-radius formas" name="forma_pago"></select>
                </div>

                <div class="form-group mg-b-0 col-lg-12 mg-b-20">
                  <label class="form-control-label mg-b-10">Tipo de pago:</label>
                  <select id="tipo_update" class="form-control bd-radius tipo" name="tipo_pago"></select>
                </div>

                <div class="form-group mg-b-0 col-lg-12 mg-b-20">
                  <label class="form-control-label mg-b-10">Monto de pago:</label>
                  <input type="text" name="cantidad_update" id="cantidad_update" class="form-control bd-radius" required>
                  <input type="hidden" name="id_update" id="id_update">
                </div>
              </div>
              <div class="modal-footer">
                <button id="update-btn" type="submit" class="btn btn-warning pd-x-20">GUARDAR</button>
                <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
        
      </form>
    </div>
  </div><!-- modal-dialog -->
</div>

<!--ELIMINAR PAGO-->
<div id="modal_delete" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bd-0 tx-14">
      <div class="modal-header bg-danger pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR PAGO</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form_delete">
        <div class="pd-80 pd-sm-80 form-layout form-layout-4">
          <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
          <br>
          <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
          <input type="hidden" name="id_delete" id="id_delete">
        </div>
        <div class="modal-footer justify-content-center">
          <button id="delete-btn" type="submit" class="btn btn-danger btn btn-delete pd-x-20"><i class="fa fa-trash mr-1"
            aria-hidden="true"></i>Eliminar</button>
          <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
        </div>
      </form>
    </div>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<!--Abrir caja-->
<div id="modal_caja" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ABRIR CAJA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formBox" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">ABRIR CAJA</h6>
                        <p>Rellena los campos</p>
                        <div class="row mg-b-25">
                            <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                                <label class="form-control-label">MONTO INICIAL: <span class="tx-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon tx-size-sm lh-2">$</span>
                                    <input type="text" class="form-control" name="monto">
                                    <!--  <span class="input-group-addon tx-size-sm lh-2">.00</span> -->
                                </div>
                            </div><!-- col-sm-4 -->
                            <div class="col-lg-12 pd-20 ">
                                <div class="form-group">
                                    <label class="form-control-label">CODIGO DE AUTORIZACIÓN: <span class="tx-danger">*</span></label>
                                    <input id="name" class="form-control" type="password" name="code" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pd-x-20">Agregar</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<script>
  let id_cotizacion = <?php echo json_encode($id_cotizacion); ?>;
  TOTAL = <?php echo json_encode($total_precio); ?>;
</script>
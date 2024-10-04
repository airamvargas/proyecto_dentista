<!--LOADER-->
<div id="loader" class="modal fade show" style="display: none; padding-left: 0px;">
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
        <h5 class="text-dark text-uppercase"><?= $title ?></h5>
        <p><?= $description ?></p>
      </div>
      <div>
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#modal_create">
          <i class="fa fa-plus mr-1" aria-hidden="true"></i>Nueva Empresa
        </button>
      </div>
      <div class="table-responsive">
        <table id="tb_empresa" class="table table-hover table-striped" style="width: 100%;">
          <thead>
            <tr>
              <th class="wd-15p">Empresa</th>
              <th class="wd-20p">RFC</th>
              <th class="wd-10p">Razón social</th>
              <th class="wd-10p">Régimen fiscal</th>
              <th class="wd-15p">Correo</th>
              <th class="wd-20p">Teléfono</th>
              <th class="wd-10p">Domicilio fiscal</th>
              <th class="wd-10p">Acción</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA CREAR EMPRESA -->
<div id="modal_create" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
    <div class="modal-content bd-0 tx-14">
      <div class="modal-header bg-success pd-y-20 pd-x-25">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Nueva empresa</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="pd-20">
        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Datos de la empresa</h6>
          <p class="mg-b-20 mg-sm-b-30">Llenar todos los campos</p>

          <form id="formCreateEmpresa" method="POST" enctype="multipart/form-data">
            <div class="form-layout">
              <div class="row mg-b-25">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                    <input class="form-control text-uppercase" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" name="nombre" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RFC: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="rfc" minlength="12" maxlength="13" pattern="^([a-zA-ZñÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([a-zA-Z\d]{3})" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RAZÓN SOCIAL: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" name="razon" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RÉGIMEN FISCAL: <span class="tx-danger">*</span></label>
                    <select class='form-control regimenes' name='regimen' autocomplete="off" required></select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">CORREO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="email" name="correo" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">TELÉFONO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="tel" name="telefono" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">DOMICILIO FISCAL: <span class="tx-danger">*</span></label>
                    <textarea class="form-control" type="text" name="direccion_fiscal" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ-z0-9\s]+" minlength="10" maxlength="60" autocomplete="off" required></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pd-x-20"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Agregar</button>
              <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA EDITAR EMPRESA -->
<div id="updateModal" class="modal fade">
  <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
    <div class="modal-content bd-0 tx-14">
      <div class="modal-header bg-warning pd-y-20 pd-x-25">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Editar datos</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="pd-20">
        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Datos de la empresa</h6>
          <p class="mg-b-20 mg-sm-b-30">Edite el campo que quiere actualizar.</p>

          <form id="formUpdate" method="POST" enctype="multipart/form-data">
            <div class="form-layout">
              <div class="row mg-b-25">
                <input class="form-control" type="hidden" id="idemp" name="id" autocomplete="off" required>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">NOMBRE: </label>
                    <input class="form-control text-uppercase" id="nom" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" name="upd_nombre" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RFC: <span class="tx-danger">*</span></label>
                    <input id="rfc" class="form-control" type="text" pattern="^([a-zA-ZñÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([a-zA-Z\d]{3})" minlength="12" maxlength="13" name="upd_rfc" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RAZÓN SOCIAL: <span class="tx-danger">*</span></label>
                    <input id="razon" class="form-control" type="text" name="upd_razon" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">RÉGIMEN FISCAL: <span class="tx-danger">*</span></label>
                    <select id="regimen" class='form-control regimenes' name='upd_regimen' autocomplete="off" required></select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">CORREO: <span class="tx-danger">*</span></label>
                    <input id="correo" class="form-control" type="email" name="upd_correo" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">TELÉFONO: <span class="tx-danger">*</span></label>
                    <input id="telefono" class="form-control" type="tel" name="upd_tel" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="form-control-label">DOMICILIO FISCAL: <span class="tx-danger">*</span></label>
                    <textarea class="form-control" id="domicilio" type="text" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9\s]+" minlength="10" maxlength="60" name="upd_domicilio" autocomplete="off"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-warning pd-x-20">
                <i class="fa fa-pencil mr-1" aria-hidden="true"></i>Editar
              </button>
              <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">
                <i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA ELIMINAR EMPRESA -->
<div id="modal_delete" class="modal fade">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content bd-0 tx-14">
      <div class="modal-header bg-danger pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar empresa</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formDelete" method="POST" enctype="multipart/form-data">
        <div class="modal-body pd-20">
          <p class="mg-b-5">¿Desea eliminar estos datos? </p>
          <input class="form-control" id="id_delete" name="id_delete" type="hidden">
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
          <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL PARA AGREGAR CONVENIO A UNA EMPRESA DADA DE ALTA -->
<div id="modal_empresa_convenio" class="modal fade">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content tx-size-sm">
      <div class="modal-header bg-primary pd-x-20">
        <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR CONVENIO</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="formEmpresaConvenio" enctype="multipart/form-data">
        <div class="pd-20">
          <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title">Datos del convenio</h6>
            <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
            <div class="form-layout">
              <div class="row mg-b-25">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">EMPRESA: <span class="tx-danger">*</span></label>
                    <input class="form-control text-uppercase" id="nom_business" type="text" name="nombre" disabled>
                    <input class="form-control" type="hidden" id="empresaid" name="empresa">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">NOMBRE DEL CONVENIO: <span class="tx-danger">*</span></label>
                    <input class="form-control text-uppercase" type="text" name="nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ-z0-9\s]+" minlength="3" maxlength="50" required>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">ESTATUS: <span class="tx-danger">*</span></label>
                    <select name="estatus">
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">FECHA DE INICIO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="fecha_inicio" required>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="form-control-label">FECHA DE TERMINO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="fecha_fin" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary pd-x-20 text-white">
            <i class="fa fa-floppy-o mr-1" aria-hidden="true"></i>
            Agregar
          </button>
          <button type="button" class="btn btn btn-secondary pd-x-20" data-dismiss="modal">
            <i class="fa fa-times mr-1" aria-hidden="true"></i>
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
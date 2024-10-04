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


<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->
            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Abrir <?= $title ?></a><br><br>
            </div>
            <div class="">
                <table id="datatable" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">CAJA</th>
                            <th class="wd-15p text-center">encargado</th>
                            <th class="wd-15p text-center">fecha</th>
                            <th class="wd-15p text-center">hora</th>
                            <th class="wd-15p text-center">autorizado</th>
                            <th class="wd-15p text-center">estado</th>
                            <th class="wd-15p text-center">movimiento</th>
                            <th class="wd-15p text-center">monto inicial</th>
                            <th class="wd-15p text-center">monto final</th>
                            <th class="wd-15p text-center">monto cierre</th>
                            <th class="wd-15p text-center">diferencia</th>
                            <!--   <th class="wd-15p text-center">autorizado</th> -->
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

<!-- MODAL CREATE -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ABRIR Caja</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
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
                                    <label class="form-control-label">CÓDIGO: <span class="tx-danger">*</span></label>
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

<!--MODAL UPDATE-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la <?= $title ?></h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="row mg-b-25">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                    <select class="form-control unidad" name="id_business_unit" id="id_business_unit" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                    <input id="name" class="form-control" type="text" name="name" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="30" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                    <textarea id="description" rows="2" class="form-control" name="description" pattern="^[a-zA-Z0-9 ]*$+" minlength="5" maxlength="50" required></textarea>
                                    <!-- <input class="form-control" type="text" name="description" required> -->
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">HORARIO INICAL: <span class="tx-danger">*</span></label>
                                    <input id="start_time" type="time" class="form-control" name="start_time" required>
                                    <!-- <input class="form-control" type="text" name="description" required> -->
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">HORARIO TERMINO: <span class="tx-danger">*</span></label>
                                    <input id="end_time" type="time" class="form-control" name="end_time" required>
                                    <input id="id" class="form-control" type="hidden" name="id" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">GUARDAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--MODAL CERER CAJA-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">CERRAR CAJA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class=" pd-20">
                    <!--   <b><p class="mg-b-5 text-center" style="color: red;">¿DESEAS CERRA LA CAJA ? </p></b> -->
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label">TIPO DE CIERRE: <span class="tx-danger">*</span></label>
                        <select id="cierre" class="form-control" name="status" required>
                            <option value="">SELECCIONA UNA OPCIÓN</option>
                            <option value="2">CERRAR CAJA</option>
                            <option value="3">ARQUEO</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label">SUMA ACUMULADA ACTUAL: <span class="tx-danger">*</span></label>
                        <input id="monto-total" class="form-control" type="text" name="code" autocomplete="off" required disabled>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label">INGRESA MONTO: <span class="tx-danger">*</span></label>
                        <input pattern="^[0-9]+[.,]{1,1}\[0]{2,2}$" id="monto-intro" class="form-control" type="text" name="final" autocomplete="off" title="ingresa monto positivo" required>
                    </div>
                </div>

                <input id="monto-restante" class="form-control" type="hidden" name="resta" autocomplete="off" required>

                <!--   <div class="col-lg-12">
                    <div class="form-group">
                    <label class="form-control-label" id="titulo"><span class="tx-danger"></span></label><br>
                        <b><output id="salida"></output></b>
                    </div>
                </div> -->

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label">CODIGO DE AUTORIZACIÓN: <span class="tx-danger">*</span></label>
                        <input id="name" class="form-control" type="password" name="code" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="btn-close" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i id="icon-cierre" class="fa fa-lock mr-1" aria-hidden="true"></i>CERRAR CAJA</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
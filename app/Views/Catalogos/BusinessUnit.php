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
                <p><?= $description ?> </p>
            </div><!-- sl-page-title -->

            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                        aria-hidden="true"></i>NUEVA UNIDAD DE NEGOCIO</a><br><br>
            </div>


            <div class="">
                <table id="tb_categoria" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">DESCRIPCIÓN</th>
                            <th class="wd-15p text-center">HORA DE INICIO</th>
                            <th class="wd-15p text-center">HORA DE TERMINO</th>
                            <th class="wd-15p text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>



<!-- CREAR UNIDAD DE NEGOCIO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR NUEVA UNIDAD DE NEGOCIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la unidad de negocio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                        <input pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="50" autocomplete="off" class="form-control" type="text" name="nombre" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="260" autocomplete="off" rows="2" class="form-control"  name="description" required></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">HORARIO DE ATENCIÓN <span class="tx-danger">*</span></label>
                                        <div class="d-flex">
                                            <div class="col-6 pl-0">
                                                <label class="form-control-label">INICIO</label>
                                                <input autocomplete="off" class="form-control mr-2" type="time" name="start_time" required>
                                            </div>
                                            <div class="col-6 pr-0">
                                                <label class="form-control-label">TERMINO</label>
                                                <input autocomplete="off" class="form-control" type="time" name="final_hour" required>
                                            </div>
                                        </div>
                                    </div>
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

<!-- ACTUALIZAR UNIDAD DE NEGOCIO-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">DETALLES DE LA UNIDAD DE NEGOCIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la unidad de negocio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                              
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                        <input pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="50" autocomplete="off" class="form-control" type="text" id="nameBusinessUnit" name="nombre" required >
                                        <input class="form-control" type="hidden" id="idBusinessUnit" name="id" required >
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="260" autocomplete="off" rows="2" class="form-control" id="description" name="description" required></textarea>       
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">HORARIO DE ATENCIÓN <span class="tx-danger">*</span></label>
                                        <div class="d-flex">
                                            <div class="col-6 pl-0">
                                                <label class="form-control-label">INICIO</label>
                                                <input id="hora_inicio" 
                                                autocomplete="off" class="form-control mr-2" type="time" name="start_time" required>
                                            </div>
                                            <div class="col-6 pr-0">
                                                <label class="form-control-label">TERMINO</label>
                                                <input id="hora_fin" autocomplete="off" class="form-control" type="time" name="final_hour" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">ACTUALIZAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar Unidad de Negocio</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar esta unidad de negocio? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
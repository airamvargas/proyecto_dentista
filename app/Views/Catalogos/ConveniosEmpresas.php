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
                <h5 class="text-dark text-uppercase"><?=$title; ?></h5>
                <p><?=$description; ?></h6>
            </div>
            <div class="col-md-3 pl-0">
                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-plus mr-1" aria-hidden="true"></i>AGREGAR CONVENIO
                </button>
            </div>
           
            <div class="table-responsive">
                <table id="tb_convenios_empresa" class="table table-hover table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">Nombre del convenio</th>
                            <th class="wd-15p text-center">Estatus</th>
                            <th class="wd-15p text-center">Fecha de inicio</th>
                            <th class="wd-15p text-center">Fecha de termino</th>
                            <th class="wd-15p text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA CREAR CONVENIO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR CONVENIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del convenio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span class="tx-danger">*</span></label>
                                        <input class="form-control text-uppercase" type="text"  value="<?=$nombre;?>"  disabled> 
                                        <input type="hidden" class='form-control text-uppercase' value="<?=$id;?>" name="empresa">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL CONVENIO: <span class="tx-danger">*</span></label>
                                        <input class="form-control text-uppercase" type="text" name="nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ-z0-9\s]+" minlength="3" maxlength="50" autocomplete="off" required>
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
                    <button type="submit" class="btn btn-success pd-x-20 text-white">
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

<!-- MODAL PARA ACTUALIZAR CONVENIO -->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ACTUALIZAR CONVENIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <input class="form-control" type="hidden" id="id" name="id" required>
                        <h6 class="card-body-title">Datos del convenio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span class="tx-danger">*</span></label>
                                        <input class="form-control text-uppercase" id="" type="text" value="<?=$nombre;?>"  disabled> 
                                        <input type="hidden" class='form-control text-uppercase' id="empr" value="<?=$id;?>" name="upd_empresa">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL CONVENIO:<span class="tx-danger">*</span></label>
                                        <input class="form-control text-uppercase" id="nomb" type="text" name="upd_nombre" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">ESTATUS: <span class="tx-danger">*</span></label>
                                        <select id="estatus" name="upd_estatus">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE INICIO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" id="fecha_i" name="upd_fecha_inicio" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE TERMINO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" id="fecha_f" name="upd_fecha_fin" required>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">
                        <i class="fa fa-pencil mr-1" aria-hidden="true"></i>
                        Editar
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

<!-- MODAL PARA ELIMINAR CONVENIO-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar convenio</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formDelete" method="POST" enctype="multipart/form-data">
                <div class="pd-20">
                    <p class="mg-b-5">¿Desea eliminar este convenio? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20">
                        <i class="fa fa-trash mr-1" aria-hidden="true"></i>
                        Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">
                        <i class="fa fa-times mr-1" aria-hidden="true"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA CREAR CONDICIONES DE CONVENIO -->
<div id="modal_add_condiciones" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-primary pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR CONDICIÓN DE CONVENIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formCreateCondiconvenio" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de las condiciones</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL CONVENIO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="hidden" id="convenioid" name="convenio"> 
                                        <input class='form-control text-uppercase' id="nom_convenio" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                        <select class='form-control negocio' name='unidad_negocio' required></select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DE PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class='form-control categorias' name='categoria' required></select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">TIPO DE CONDICIÓN: <span class="tx-danger">*</span></label>
                                        <select class='form-control condicion' name='tipo_condicion' required></select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="valor" required>
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


<script>
    let id = <?= json_encode($id); ?>;
</script>
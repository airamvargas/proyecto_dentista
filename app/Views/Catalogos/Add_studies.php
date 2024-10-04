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
        <div class="pd-20 pd-sm-40">

            <div class="sl-page-title">
                <h5><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->

            <div class="col-md-3 col-lg-12 pl-0">
                <button type="button" id="add-producto" href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                aria-hidden="true"></i>AGREGAR ESTUDIO</button> 
                
                <button id="terminar" type="button" class="btn btn-secondary pd-x-20 ml-3"><i class="fa fa-arrow-left" aria-hidden="true"></i> REGRESAR</button>
            </div>


            <div class="mg-t-20">
                <table id="crm_studies_x_packet" class="table display table-responsive product_list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">PAQUETE</th>
                            <th class="wd-15p text-center">ESTUDIO</th>
                            <th class="wd-15p text-center">ÁREA DE LABORATORIO</th>
                            <th class="wd-15p text-center">PREPARACIÓN</th>
                            <th class="wd-15p text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div><!-- table-wrapper -->

            <div class="mg-t-40">
                 
            </div>
        </div>
    </div>
</div>

<!-- INSERTAR ESTUDIO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold"><?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Estudio que pertece al paquete</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                    <label class="form-control-label">GRUPO O ÁREA: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="id_category" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL ESTUDIO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input minlength="5" maxlength="50" type="text" id="autoComplete" class="form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                                        <input type="hidden" name="id_study" id="id_study" class="form-control">
                                        <input type="hidden" name="id_packet" id="id_packet" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="form-asignar" type="submit" class="btn btn-success pd-x-20">Agregar</button>
                            <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--ELIMINAR ESTUDIO-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR ESTUDIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_delete_study">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
    let id_packet = <?php echo json_encode($id_packet); ?>;
</script>
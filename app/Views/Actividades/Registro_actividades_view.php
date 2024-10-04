<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>

<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

<style>
    table.dataTable thead th, 
    table.dataTable thead td,
    #datatable1 tbody th, 
    table.dataTable tbody td {
        text-align: center !important;
    }
</style>

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <!-- sl-page-title -->
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?=$title?></h5>
                <p><?=$description?></p>
            </div>
            <div>
                <button id="agregar-estado" class="btn btn-success pd-x-20" data-toggle="modal" data-target="#modal_agregar"><i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</button>
                <br><br>
            </div>

            <div class="tab-content">
                <table id="actividades-table" class="display table table-responsive " style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">FOTO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">RUBRO</th>
                            <th scope="col">EMPRESA</th>
                            <th scope="col">ACTIVIDAD</th>
                            <th scope="col">RESPONSABLE</th>
                            <th scope="col">CONCLUIDA</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div><!-- table-wrapper -->
        </div><!-- card -->
    </div>
</div>

<div id="modal_agregar" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header btn-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">AGREGAR NUEVO</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-agregar" method="POST" enctype="multipart/form-data" action="<?php echo base_url() . '/Actividades/Registro_actividades/insert_activity' ?>">
                <div class="pd-25">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <p class="mg-b-20 mg-sm-b-30">Inserte por favor los siguientes campos.</p>
                        <div class="row">
                            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <label>Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <label>Rubro</label>
                                <select class='form-control rubro' name='rubro' id='rubro' required>
                                    <option value=''>Desplegar opciones</option>
                                    <option value='VENTAS'>VENTAS</option>
                                    <option value='LOGISTICA'>LOGISTICA</option>
                                    <option value='CONTABILIDAD'>CONTABILIDAD</option>
                                    <option value='OTROS'>OTROS</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Empresa</label>
                                <select class='form-control empresa' name='empresa' id='empresa' required>
                                    <option value=''>Desplegar lista de empresas</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Actividad</label>
                                <input type="text" name="actividad" id="actividad" class="form-control" required>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Responsable</label>
                                <select class='form-control responsable' name='responsable' id='responsable' required>
                                    <option value=''>Desplegar opciones</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Concluida</label>
                                <select class='form-control' name='concluida' id='concluida' required>
                                    <option value=''>Desplegar opciones</option>
                                    <option value='SI'>SI</option>
                                    <option value='NO'>NO</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success pd-x-20">Aceptar</button>            
                    <button onclick="mostrar()" type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modal_update" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header btn-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">ACTUALIZAR ACTIVIDAD</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-update" method="POST" enctype="multipart/form-data" action="<?php echo base_url() . '/Actividades/Registro_actividades/update_activity' ?>">
            <div class="pd-25">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <p class="mg-b-20 mg-sm-b-30">Inserte por favor los siguientes campos.</p>
                        <div class="row">
                            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <label>Fecha</label>
                                <input type="date" name="fecha_update" id="fecha_update" class="form-control" required>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                                <label>Rubro</label>
                                <select class='form-control rubro' name='rubro_update' id='rubro_update' required>
                                    <option value=''>Desplegar opciones</option>
                                    <option value='VENTAS'>VENTAS</option>
                                    <option value='LOGISTICA'>LOGISTICA</option>
                                    <option value='CONTABILIDAD'>CONTABILIDAD</option>
                                    <option value='OTROS'>OTROS</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Empresa</label>
                                <select class='form-control empresa' name='empresa_update' id='empresa_update' required>
                                    <option value=''>Desplegar lista de empresas</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Actividad</label>
                                <input type="text" name="actividad_update" id="actividad_update" class="form-control" required>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Responsable</label>
                                <select class='form-control responsable' name='responsable_update' id='responsable_update' required>
                                    <option value=''>Desplegar opciones</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mg-t-10 mg-sm-t-20">
                                <label>Concluida</label>
                                <select class='form-control' name='concluida_update' id='concluida_update' required>
                                    <option value=''>Desplegar opciones</option>
                                    <option value='SI'>SI</option>
                                    <option value='NO'>NO</option>
                                </select>
                                <input type="hidden" name="id_update" id="id_update">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-warning pd-x-20">Aceptar</button>            
                    <button onclick="mostrar()" type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header btn-danger pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar actividad</h6>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="<?php echo base_url() . '/Actividades/Registro_actividades/delete_activity' ?>">
            <div class="modal-body pd-20">
              <p class="mg-b-5">¿Deseas eliminar este registro? </p>
              <input type="hidden" name="id_delete" id="id_delete">
            </div>
            <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-danger pd-x-20 btnbtn-delete"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
              <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<!-- Desarrollador: Airam V. Vargas Lopez
Fecha de creacion: 22 - 03 - 2024
Fecha de Ultima Actualizacion: 03 - 04 - 2024
Actualizo: Airam V. Vargas Lopez
Perfil: Recepcionista
Descripcion: Busqueda de resultados de laboratorio -->


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
            <div class="mb-3 d-flex" >
                <div class="mr-2">
                    <button id="orden" type="button" class="btn btn-primary pd-x-20 float-right">BÚSQUEDA POR ORDEN DE SERVICIO</button>
                </div>
                <div>
                    <button id="nombre" type="button" class="btn btn-teal pd-x-20 ml-2 float-right">Búsqueda por nombre</button>
                </div>
            </div>
            <div class="row col-12 mg-b-30">
                <div id="div1" class="row d-none">
                    <form id="busquedaOrden" class="ml-3">
                        <div class="row">
                            <div class="row col-lg-10 col-sm-12">
                                <label class="col-sm-12 form-control-label"># ORDEN DE SERVICIO: <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                    <input type="number" class="form-control input-busquedas" name="orden_servicio" id="orden_servicio" maxlength="10">
                                </div>
                            </div><!-- row -->
                            <div class="row justify-content-center align-content-center mg-t-20 col-2">
                                <div>
                                    <button id="btn_orden_busqueda" type="submit" class="btn btn-primary solid pd-x-20 btn-circle btn-md"><i class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="div2" class="row d-none">
                    <form id="busquedaNombre" class="ml-3">
                        <div class="row">
                            <div class="row col-lg-5 col-sm-12">
                                <label class="col-sm-12 form-control-label">NOMBRE DEL PACIENTE: <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                    <input type="text" class="form-control input-busquedas" name="nombre" id="paciente_name" maxlength="100">
                                </div>
                            </div><!-- row -->
                            <div class="row col-lg-5 col-sm-12">
                                <label class="col-sm-12 form-control-label">FECHA ORDEN DE SERVICIO: <span class="tx-danger">*</span></label>
                                <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                    <input type="date" class="form-control input-busquedas" name="fecha" id="fecha" maxlength="100">
                                </div>
                            </div><!-- row -->
                            <div class="row justify-content-center align-content-center mg-t-20 col-2">
                                <div>
                                    <button id="btn_nombre_busqueda" type="submit" class="btn btn-teal solid pd-x-20 btn-circle btn-md"><i class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                
            </div>

            <div id="tabla_resultados" class="d-none">
                <table id="resultados" class="table display table-responsive tablas_reportes" style="display: block; width: 100%; background-color: transparent;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center"># Orden de servicio</th>
                            <th class="wd-15p text-center">Fecha</th>
                            <th class="wd-15p text-center">Cliente</th>
                            <th class="wd-15p text-center">Status</th>
                            <th class="wd-15p text-center">Imprimir</th>
                        </tr>
                    </thead>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>
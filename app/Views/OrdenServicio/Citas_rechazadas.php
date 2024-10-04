<!-- Desarrollador: Airam Vargas
Fecha de creacion: 25 - 08 - 2023
Fecha de Ultima Actualizacion: 28 - 08 - 2023 Airam Vargas
Perfil: Recepcionista
Descripcion: Se manejara una tabla de las citas que hayan sido canceladas/rechazadas por los médicos
para que puedan ser reasignadas en otro horario 
 -->
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
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->

            <div class="mg-t-20">
                <table id="crm_citas_rechazadas" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                        <th class="wd-15p text-center">FECHA</th>
                            <th class="wd-15p text-center">HORA</th>
                            <th class="wd-15p text-center">PACIENTE</th>
                            <th class="wd-15p text-center">TELÉFONO</th>
                            <th class="wd-15p text-center">MÉDICO</th>
                            <th class="wd-15p text-center">CONSULTORIO</th>
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

<!--EDITAR CITA -->
<div id="cita-upd" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">REAGENDAR CITA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <nav class="navbar navbar-light bg-light">
                <button style="cursor: pointer;" id="btn-doctor" class="btn btn-primary" type="button">Busqueda por medico <i class="fa fa-user-md fa-lg" aria-hidden="true"></i>
                </button>
                <button style="cursor: pointer;" id="btn_hora_upd" class="btn btn-primary" type="button">Busqueda por hora <i class="fa fa-clock-o fa-lg" aria-hidden="true"></i></button>
            </nav>
            <form id="formCitaupd" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">AGENDAR CITA</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA: <span class="tx-danger">*</span></label><br>
                                        <input type="date" id="fecha-upd" name="fecha" class="form__input" placeholder=" " required min=<?php $hoy = date("Y-m-d");
                                                                                                                                            echo $hoy; ?>>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="b-medico">
                                    <div class="form-group">
                                        <label class="form-control-label">MEDICO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="medico" id="select-medicos" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="h">
                                    <div class="form-group">
                                        <label class="form-control-label">HORARIO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="horario" id="select-horas" required>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="id-cita" name="id_cita">
                                <input type="hidden" id="id_cotizacion" name="id_cotizacion">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Consultorio: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="consultorio" id="consultorio_upd" required>
                                        </select>
                                    </div>
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

            <form id="formHorasupd" enctype="multipart/form-data" style="display: none;">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">AGENDAR CITA</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA: <span class="tx-danger">*</span></label><br>
                                        <input type="date" id="fecha-hora-upd" name="fecha" class="form__input" placeholder=" " required min=<?php $hoy = date("Y-m-d");
                                                                                                                                            echo $hoy; ?>>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="b-horas">
                                    <div class="form-group">
                                        <label class="form-control-label">HORARIO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="horario" id="cita-horas-upd" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12" id="b-medico">
                                    <div class="form-group">
                                        <label class="form-control-label">MEDICO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="medico" id="doctor-upd" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Consultorio: <span class="tx-danger">*</span></label>
                                        <select class="form-control consultorio-horas" name="consultorio" id="consultorio-horas-upd" required>
                                        </select>
                                    </div>
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

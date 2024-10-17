<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

<div id="loader" class="modal fade show">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="d-flex ht-300 pos-relative align-items-center">
            <div class="sk-chasing-dots">
                <div class="sk-child sk-dot1 bg-red-800"></div>
                <div class="sk-child sk-dot2 bg-green-800"></div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row col-12 justify-content-center">
        <div class="col-8 mt-4">
            <h1 class="text-center">CLINICA DENTAL - LA VIGA</h1>
        </div>
    </div>

    <div class="">
        <table id="citas_programadas" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-15p text-center">Fecha</th>
                    <th class="wd-15p text-center">Hora</th>
                    <th class="wd-15p text-center">Paciente</th>
                    <th class="wd-15p text-center">Observaciones</th>
                    <th class="wd-15p text-center">ACCIONES</th>
                </tr>
            </thead>
        </table>
    </div><!-- table-wrapper -->
</div>

<!-- MODAL PARA EDITAR DATOS -->
<div id="modal_reasignar" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-edit pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold"> ACTUALIZAR CITA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-20">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">Datos de la cita</h6>
                    <p class="mg-b-20 mg-sm-b-30">Llenar todos los campos</p>
                    <form id="updateCitas" method="POST" enctype="multipart/form-data">
                        <div class="form-layout">
							<div class="mg-t-20">
								<label class="form-control-label">Fecha: </label>
								<div class="mg-sm-t-0">
									<input id="fechaH" class="form-control" type="date" name="fecha" required>
								</div>
							</div>
							<div class="mg-t-20">
								<label class="form-control-label">Horas disponibles: </label>
								<div class="mg-sm-t-0">
									<select id="horasdisp" class="form-control" type="date" name="horasdisp" required>
										<option value="">Seleccione una hora</option>
									</select>
								</div>
							</div>
							<div class="mg-t-20">
								<label class="form-control-label">Comentarios: <span class="tx-danger"></span></label>
								<div class="mg-sm-t-0">
									<textarea rows="3" id="comentarios" name="comentarios" class="form-control" placeholder="Comentarios de la cita"></textarea>
								</div>
							</div>
							<input id="id_reasignar" class="form-control" type="hidden" name="id_reasignar" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-edit pd-x-20"><i class="fa fa-plus mr-1" aria-hidden="true"></i>ACTUALIZAR</button>
                            <button type="button" class="btn btn-cancelar pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Model eliminar paciente-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR CITA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="eliminarPaciente" class="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
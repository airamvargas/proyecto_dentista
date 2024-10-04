<!-- Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 29 - 08 - 2023
Perfil: Recepcionista
Descripcion: Se agrego el nombre del paciente al momento de liberar citas médicas o muestras de laboratorio -->

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
                <table id="crm_pendientes" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">FECHA</th>
                            <th class="wd-15p text-center"># SOLICITUD</th>
                            <th class="wd-15p text-center">Beneficio</th>
                            <th class="wd-15p text-center">PACIENTE</th>
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

<!--PASAR A TOMAR MUESTRA-->
<div id="modal_aceptar" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">PASAR A TOMAR MUESTRA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-60 pd-sm-60 form-layout form-layout-4">
                <h5 id="name_lab" class="text-center mg-b-20">PACIENTE: </h5>
                <h6 style="text-align:center;">¿Deseas pasar a toma de muestra alguna prueba?</h6>
                <br>
                <p style="color:red; text-align:center;">No se podrá cambiar la acción una vez realizada.</p>
                <div id="muestrasPendientes"></div>
            </div>
            
            <!-- <div class="modal-footer justify-content-center">
                <button id="btn-aceptar" type="submit" class="btn btn-success btnbtn-delete pd-x-20"><i class="fa fa-check" aria-hidden="true"></i> Aceptar</button>
                <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Cancelar</button>
            </div> -->
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--AUTORIZAR CITA MEDICA-->
<div id="modal_aceptar_cita" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AUTORIZAR CONSULTA MÉDICA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-60 pd-sm-60 form-layout form-layout-4">
                <h5 id="name_cita" class="text-center mg-b-20">PACIENTE: </h5>
                <h6 style="text-align:center;">¿Deseas autorizar la(s) consulta(s) médica(s)?</h6>
                <br>
                <p style="color:red; text-align:center;">No se podrá cambiar la acción una vez realizada.</p>
                <div id="citasPendientes"></div>
            </div>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->
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
        <div id="n_paciente" class="col-8 mt-5"></div>
        <div id="div_folio" class="col-4 mt-5"></div>
    </div>

    <div class="pd-20 pd-sm-20 form-layout form-layout-4">
                
        <div class="row">
            <div class="form-group mg-b-0 col-lg-8">
                <label class="form-control-label mg-b-10">Tratamiento a realizar: 
                <span class="tx-danger">*</span>
                </label>
                <input type="text" name="n_trat" id="autoComplete" class="mg-t-10 form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
            </div>

            <div class="form-group mg-b-0 col-lg-4">
            <button id="agregar" type="submit" class="btn btn-purple"><i class="fa fa-plus-circle" aria-hidden="true"></i> AGREGAR PRODUCTO</button>
            </div>
        </div>
    </div>
</div>

<script>
    let id_paciente = <?php echo json_encode($id_paciente); ?>;
    let id_cita = <?php echo json_encode($id_cita); ?>;
</script>
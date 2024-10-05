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

<div class="container-fluid">
    <div class="row col-12 justify-content-center">
        <div class="col-8 mt-4">
            <h1 class="text-center">Citas anteriores</h1>
        </div>
    </div>

    <div class="pd-20 pd-sm-20 form-layout form-layout-4 ml-5 mr-5">
        <div class="row justify-content-center">
            <div class="form-group mg-b-0 col-lg-12">
                <label id="nombrePaciente" class="form-control-label mg-b-10">Paciente: Airam Vargas</label>
            </div>
        </div>
        
    </div>
</div>

<script>
    let id_paciente = <?php echo json_encode($id_paciente); ?>;
</script>
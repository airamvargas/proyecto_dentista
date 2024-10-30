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
</div>

<script>
    let id_paciente = <?php echo json_encode($id_paciente); ?>;
    let id_cita = <?php echo json_encode($id_cita); ?>;
</script>
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

<div class="container-fluid">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">

            <div class="sl-page-title">
                <h5 class="text-uppercase title-text"><?= $title ?></h5>
                <p><?= $description ?></p>
                <!--  <p class="mg-b-20 mg-sm-b-30">Catálogo de productos</p> -->
            </div><!-- sl-page-title -->

            <div class="pd-20 pd-sm-20 form-layout form-layout-4">
                <div class="row justify-content-center">
                    <div class="form-group mg-b-0 col-lg-8">
                        <label class="form-control-label mg-b-10">Ingrese nombre del paciente: 
                            <span class="tx-danger">*</span>
                        </label>
                        <input type="text" name="nombre_user" id="autoComplete" class="mg-t-10 form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important; border-radius: 10px !important;">
                    </div>

                    <div class="col-2 form-group mg-b-0">
                        <button id="agregar_btn" type="button" class="btn btn-agregar pd-x-20"> <i class="fa fa-plus" aria-hidden="true"></i> AGREGAR PACIENTE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
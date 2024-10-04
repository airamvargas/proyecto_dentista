<script src="../../../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

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


<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h2 class="text-uppercase"><?php echo ($name) ?></h2>
                <button id="upload" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i> SUBIR FOTOS</button>
            </div>
            <div class="col-12" style="border: 2px solid #ccc; border-radius: 10px; background-color: #fbf5f5;">
                <h5 class=" mt-4" style="border-bottom: 2px solid #0866C6;">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    FOTOS AVANCE CHINA
                </h5>
                <div class="row col-12 china text-center mt-4">
                    <!-- <div class="col-2 ">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div> 
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div> -->

                </div>
            </div>

            <div class="col-12 mt-5 " style="border: 2px solid #ccc; border-radius: 10px; background-color: #fbf5f5;">
                <h5 class="mt-4" style="border-bottom: 2px solid #1CAF9A;">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    FOTOS EMPAQUE
                </h5>
                <div class="row col-12 empaque text-center mt-4">
                     <!--  <div class="col-2 ">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div> --> 

                </div>
            </div>

            <div class="col-12 mt-5" style="border: 2px solid #ccc; border-radius: 10px; background-color: #fbf5f5;">
                <h5 class="mt-4" style="border-bottom: 2px solid #2b333e;">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    FOTOS PLACA
                </h5>
                <div class="row col-12 placa text-center mt-4">
                    <!-- <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>  -->

                </div>
            </div>

            <div class="col-12 mt-5" style="border: 2px solid #ccc; border-radius: 10px; background-color: #fbf5f5;">
                <h5 class="mt-4" style="border-bottom: 2px solid #c2f52e;">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    FOTOS REVISIÓN ADUANDAS
                </h5>
                <div class="row col-12 aduanas text-center mt-4">
                    <!--  <div class="col-2 ">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>  -->

                </div>
            </div>

            <div class="col-12 mt-5" style="border: 2px solid #ccc; border-radius: 10px; background-color: #fbf5f5;">
                <h5 class="mt-4" style="border-bottom: 2px solid #85dc02;">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    FOTOS ENTREGA CLIENTE                    
                </h5>
                <div class="row col-12 cliente text-center mt-4">
                    <!--  <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>
                    <div class="col-2">
                        <img class="img-thumbnail" src="http://localhost/solimaq/assets/img/img1.jpg" alt="">
                    </div>  -->

                </div>
            </div>





        </div>
    </div>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR IMAGENES DE AVANCE</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--  <form id="formPago" enctype="multipart/form-data"> -->
            <div class="pd-20">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">IMAGENES DE AVANCE</h6>
                    <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                    <div class="form-layout">
                        <div class="row mg-b-25">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">SECCIÓN: <span><span class="tx-danger">*</span></label>
                                    <select class="form-control seccion" name="seccion" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">IMAGENES <span class="tx-danger">*</span></label>
                                    <label class="custom-file">
                                        <input multiple type="file" id="file" class="custom-file-input" name="comprobante" required accept=".jpg, .png , .jpge">
                                        <span class="custom-file-control custom-file-label"></span>
                                    </label>
                                </div>
                            </div><!-- col-4 -->

                            <div class="col-12 row imagenes-prev">


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="send_form" type="submit" class="btn btn-success pd-x-20">Agregar</button>
                <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
            </div>
            <!--   </form> -->
        </div>
    </div><!-- modal-dialog -->
</div>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" data-dismiss="modal">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img src="" class="imagepreview" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <div class="col-xs-12">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar Imagen</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="delete_form">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar esta imagen? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20 btnbtn-delete"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->






<script src="../../../assets/lib/datatables/jquery.dataTables.js"></script>
<script src="../../../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
<script src="../../../assets/lib/select2/js/select2.min.js"></script>

<script>
    let id_cotizacion = <?php echo json_encode($id); ?>;
</script>
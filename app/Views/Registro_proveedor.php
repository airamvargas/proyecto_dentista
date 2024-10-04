

<section class="registro">
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 mt-5">
                <form id="form_registro" enctype="multipart/form-data">
                    <h3 style="color: #384250 !important;"><?= $description;?></h3>
                    <hr>

                    <input type="hidden" value="<?php echo $id_group?>" name="grupo">
                    <div id="datos-generales">
                        <h4 class="col-12 mb-3" style="color: #384250 !important;">
                            <span class="fa-stack h5 mb-0">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-tasks fa-stack-1x fa-inverse mt-2"></i>
                            </span>
                            Datos generales
                        </h4>
                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="razon">Razón social</label>
                                <input type="text" class="form-control" name="r_social" id="razon" placeholder="*Razón social" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="100" title="Solo se permiten letras" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="nombre">Nombre comercial</label>
                                <input type="text" id="nombre" class="form-control" name="nombre_comercial" placeholder="*Nombre comercial" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" title="Solo se permiten letras" required>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-lg-6">
                                <label for="rfc">R.F.C</label>
                                <input type="text" id="rfc" class="form-control" name="rfc_proveedor" placeholder="*RFC" pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))([A-Z\d]{3})" minlength="12" maxlength="13" title="Formato incorrecto" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="product">Producto o servicio</label>
                                <input type="text" id="product" class="form-control" name="producto" placeholder="*Producto o servicio" required>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-lg-6">
                                <label for="web">Página web</label>
                                <input type="text" id="web" class="form-control" name="pagina" placeholder="*Página web" required>
                            </div>
                        </div>
                    </div>

                    <div id="datos-contacto">
                        <h4 class="col-12 mb-3" style="color: #384250 !important;">
                            <span class="fa-stack h5 mb-0">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-user mt-2 fa-stack-1x fa-inverse"></i>
                            </span>
                            Datos de contacto
                        </h4>
                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="nombre">Nombre de contacto principal</label>
                                <input type="text" id="nombre" class="form-control" name="nombre_contrato" placeholder="*Nombre de contacto principal" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="100" title="Solo se permiten letras" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tel">Teléfono fijo</label>
                                <input type="tel" id="tel" class="form-control" name="tel_fijo" placeholder="*Teléfono fijo" pattern="^[0-9]+" minlength="10" maxlength="10"
                                title="Solo se permiten números" required>
                            </div>
                        </div>
                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="cel">Teléfono movil</label>
                                <input type="tel" id="cel" class="form-control" name="tel_movil" placeholder="*Teléfono movil" pattern="^[0-9]+" minlength="10" maxlength="10"
                                title="Solo se permiten números" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="mail">Email</label>
                                <input type="email" id="mail" class="form-control" name="correo" placeholder="*Email" required>
                            </div>
                        </div>

                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="street">Calle</label>
                                <input type="text" id="street" class="form-control" name="calle" placeholder="*Calle" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="ext">Exterior</label>
                                <input type="text" id="ext" class="form-control" name="exterior" placeholder="*Exterior" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="int">Interior</label>
                                <input type="text" id="int" class="form-control" name="interior" placeholder="*Interior" required>
                            </div>
                        </div>
                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="col">Colonia o municipio</label>
                                <input type="text" id="col" class="form-control" name="colonia" placeholder="*Colonia o municipio" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="cp">C.P.</label>
                                <input type="text" id="cp" class="form-control" name="cod_p" placeholder="*C.P." minlength="5" maxlength="5" required>
                            </div>
                        </div>
                        <div class="d-lg-flex">
                            <div class="form-group col-lg-6">
                                <label for="ciudad">Ciudad</label>
                                <input type="text" id="ciudad" class="form-control" name="city" placeholder="*Ciudad" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="estado">Estado</label>
                                <input type="text" id="estado" class="form-control" name="edo" placeholder="*Estado" required>
                            </div>
                        </div>
                    </div>

                    <div id="datos_bancarios">
                        <h4 class="col-12 mb-3" style="color: #384250 !important;">
                            <span class="fa-stack h5 mb-0">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-university mt-2 fa-stack-1x fa-inverse"></i>
                            </span>
                            Datos bancarios
                        </h4>
                        <div class="d-flex">
                            <div class="form-group col-lg-6">
                                <label for="bank">Banco</label>
                                <input type="text" id="bank" class="form-control" name="banco" placeholder="*Banco" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="no_cta">Número de cuenta</label>
                                <input type="number" id="no_cta" class="form-control" name="num_cuenta" placeholder="*Número de cuenta" pattern="^[0-9]+"  
                                title="Solo se permiten números" required>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="form-group col-lg-6">
                                <label for="cla">Clabe</label>
                                <input type="number" id="cla" class="form-control" name="clabe" placeholder="*Clabe" pattern="^[0-9]+" minlength="18" maxlength="18" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="mon">Moneda</label>
                                <input type="text" id="mon" class="form-control" name="moneda" placeholder="*Moneda" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-right mb-4">
                        <button type="submit" class="btn btn-primary mr-1">Enviar</button>
                        <button class="btn btn-secondary">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
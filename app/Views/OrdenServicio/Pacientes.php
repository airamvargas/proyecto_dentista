<!-- Desarrollador: Airam Vargas
Fecha de creacion: 22 - 07 - 2024
Fecha de Ultima Actualizacion: 
Perfil: Recepcionista
Descripcion: Listado de pacientes -->

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
                <table id="crm_pacientes" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">Nombre</th>
                            <th class="wd-15p text-center">Fecha de nacimiento</th>
                            <th class="wd-15p text-center">Sexo</th>
                            <th class="wd-15p text-center">Correo</th>
                            <th class="wd-15p text-center">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>
<!--LOADER-->
<div id="loader" class="modal fade show" style="display: none; padding-left: 0px;">
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
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->
            <div class="">
                <table id="datatable" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">N° COTIZACIÓN</th>
                            <th class="wd-15p text-center">CAJA</th>
                            <th class="wd-15p text-center">forma de pago</th>
                            <th class="wd-15p text-center">cantidad</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-center"></th>
                            <th class="text-center">Total:</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>
<input id="box" type="hidden" value=<?= $box ?>>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
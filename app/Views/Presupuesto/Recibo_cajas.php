<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Recibo de caja</title>
    <link rel="stylesheet" href="../assets/css/style_pdf.css" media="all" />
</head>



<style>
    #miID table,
    #miID th,
    #miID td {
        /*border: 1px solid;*/
        padding: 3px
    }
</style>


<body>
    <?php
    $fecha = date('d/m/Y', strtotime($caja[0]->date_start));
    ?>

    <header class="clearfix">
        <div id="">
            <img src="../assets/img/<?php echo $logo; ?>" style="width: 20%;">
        </div>
    </header>

    <div>
        <b>Fecha:</b> <?= date("d/m/Y") ?><br><b>Recepcionista:</b> <?= $caja[0]->recepcionista ?><br><b>Autorización apertura de caja:</b> <?= $caja[0]->gerente ?><br><b>Autorización de cierre de caja:</b> <?= $caja[0]->name_cierre ?><br><b>
            Estatus caja: </b><?= $caja[0]->name_status ?>

    </div>
    <br>
    <br>

    <h2 style="text-align: center;">Reporte de caja N° <?= $caja[0]->id ?></h2>
    <hr>
    <br>
    <br>

    <table id="miID">
        <tr>
            <th nowrap="nowrap">Fecha</th>
            <th nowrap="nowrap">N° Cotizacion</th>
            <th nowrap="nowrap">Movimiento</th>
            <th nowrap="nowrap">Monto</th>
        </tr>
        <tr>
            <td style="text-align: center;">
                <?= $fecha ?>
            </td>
            <td style="text-align: center;">
            </td>
            <td style="text-align: center;">
                Apertura de caja
            </td>
            <td style="text-align: center;">
                <?= "$" . number_format($caja[0]->starting_amount, 2, '.', ',') ?>
            </td>
        </tr>
        <?php
        $white = "background-color: white;";
        $suma_recepcionista = 0;


        foreach ($pagos as $pago) {
            $suma_recepcionista += $pago['amount'];
            echo "<tr style='$white'>";
            echo '<td style="text-align: center;">' . date('d/m/Y', strtotime($pago['created_at'])) . '</td>';
            echo '<td style="text-align: center;">' . $pago['id_cotization'] . '</td>';
            echo '<td style="text-align: center;">' . "<p>Cobro</p>" . '</td>';
            echo '<td style="text-align: center;">' . "$" . number_format($pago['amount'], 2, '.', ',') . '</td>';
            echo ('</tr>');
        }

        $total = $caja[0]->starting_amount + $suma_recepcionista;
        $restante = $caja[0]->final_amount - $total;
        $texto = $caja[0]->name_status;
        $texto = strtolower($texto);
        $texto = ucfirst($texto);
        ?>

        <tr>
            <td colspan="4"><br><br></td>
        </tr>

        <tr style="background-color: gray !important;">
            <td style="text-align: center;">
                <?= $fecha ?>
            </td>
            <td style="text-align: center;">
            </td>
            <td style="text-align: center;">
                <b>Total de abonos</b>


            </td>
            <td style="text-align: center;">
                <b><?= "$" . number_format($total, 2, '.', ','); ?></b>
            </td>
        </tr>

        <tr style="background-color: gray !important;">
            <td style="text-align: center;">
                <?= $fecha ?>
            </td>
            <td style="text-align: center;">
            </td>
            <td style="text-align: center;">
                <b><?= $texto ?></b>
            </td>
            <td style="text-align: center;">
                <b><?= "$" . number_format($caja[0]->final_amount, 2, '.', ','); ?></b>
            </td>
        </tr>

        <tr style="background-color: gray !important;">
            <td style="text-align: center;">
                <?= $fecha ?>
            </td>
            <td style="text-align: center;">
            </td>
            <td style="text-align: center;">
                <b>Direfencia</b>
            </td>
            <td style="text-align: center;">
                <?php
                if ($restante >= 0) {
                    echo ("<b style=\"color:green\">" . "$" . number_format($restante, 2, '.', ',') . "</b>");
                } else {
                    echo ("<b style=\"color:red\">" . "$" . number_format($restante, 2, '.', ',') . "</b>");
                }
                ?>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table style="table-layout: fixed; width: 100%;">
        <tr>
            <td style="text-align: center; width: 50%;" nowrap="nowrap">
                <br>
                <br>
                <hr> <!-- Esta es la línea para la firma -->
                <b>Firma</b>
                <br>
                <br>
                <b>Recepcionista</b>
                <br>
                <?= $caja[0]->recepcionista ?>

            </td>
            <td style="text-align: center; width: 50%;">
                <br>
                <br>
                <hr> <!-- Esta es la línea para la firma -->
                <b>Firma</b>
                <br>
                <br>
                <b>Recibe</b>
                <br>
                <br>
                <br>
            </td>
        </tr>
    </table>
</body>

</html>
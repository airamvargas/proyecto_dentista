     <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Lista de cotizaciones</title>
    <link rel="stylesheet" href="../assets/css/style_pdf.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../assets/img/logo_b.jpg">
      </div>
      <h1>Lista de cotizaciones</h1>
      <div id="company" class="clearfix">
        <div>SOLIMAQ</div>

      </div>
      <div id="project">

      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
                                  <th class="wd-15p">Vendedor</th>
                                  <th class="wd-15p">Clientes</th>
                                  <th class="wd-15p">Detalles</th>
                                  <th class="wd-15p">Ver pdf</th>
                                  <th class="wd-15p">Enviar email</th>

                              </tr>
        </thead>
        <tbody>

         <?php $number=0;  foreach($vendor as $key):?>
                              <tr style="background: #ccccff;">

                                  <td><?php echo $key['user_name'];?></td>
                                  <td> <?php echo $client[$number]['name'];?></td>
                                  <td><a href="<?php echo base_url().'/Cotizacion_products/detalles/'.$key['id'];?>">Productos</a></td>
                                  <td><a href="<?php echo base_url().'/Cotizacion_products/report_view/'.$key['id'];?>">Ver comprobante</a></td>
                                  <td><a href="<?php echo base_url().'/Email/index/'.$key['id'];?>">Email</a></td>

                                    </tr>
                              <?php $number++; endforeach;?>

        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">Webcorp. Derechos reservado</div>
      </div>
    </main>
    <footer>
      Facturation was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>






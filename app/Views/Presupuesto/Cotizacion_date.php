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
         <h1>Lista de cotizaciones por fecha</h1>
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
             <th scope="col">Fecha</th>
              <th scope="col">Vendedor</th>
              <th scope="col">Empresa venta</th>
              <th scope="col">Nombre Cliente</th>
              <th scope="col">Empresa Cliente</th>
              <th scope="col">Correo</th>
              <th scope="col">Telefono</th>
              <th scope="col">Maquina</th>
              <th scope="col">Modelo</th>
              <th scope="col">Precio venta</th>
             </tr>
           </thead>
           <tbody>

             <?php foreach ($date as $key) : ?>
               <tr style="background: #ccccff;">
                 <td><?php echo $key->c_date; ?></td>
                 <td><?php echo $key->user_name; ?></td>
                 <td><?php echo $key->empresa; ?></td>
                 <td><?php echo $key->empresa_cliente; ?></td>
                 <td><?php echo $key->name; ?></td>
                 <td><?php echo $key->email; ?></td>
                 <td><?php echo $key->phone; ?></td>
                 <td><?php echo $key->maquina; ?></td>
                 <td><?php echo $key->model; ?></td>
                 <td><?php echo $key->price; ?></td>
               </tr>
             <?php endforeach; ?>

           </tbody>
         </table>
       <!--   <div id="notices">
           <div>NOTICE:</div>
           <div class="notice">Webcorp. Derechos reservado</div>
         </div> -->
       </main>
       <footer>
        <!--  Facturation was created on a computer and is valid without the signature and seal. -->
       </footer>
     </body>

     </html>
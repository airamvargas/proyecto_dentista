
<html>
<head>
<style type="text/css">
	table th{
		width: 250px;
	}

</style>
</head>
<body>

<table>
	<thead>
		<tr>
			<th>Titulo</th>
			<th></th>
			
			<td>DATOS TECNICOS</td>
		</tr>
		
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td>No.</td>
			

		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Fecha:</td>
			

		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Vendedor:<?php echo $vendor[0]['user_name']; ?></td>
			

		</tr>
	</tbody>
</table>



<table>
	<thead>
		<tr>
			<td>GRUPO TOROSSI</td>
			<td></td>
			<td></td>
		</tr>
		
	</thead>
	<tbody>
		<tr>
			<td>SR. FRANCISCO JARA</td>
			<td></td>
			<td></td>
			

		</tr>
		<tr>
			<td>CIUDAD: SAN LUIS POTOSI</td>
			<td></td>
			<td></td>
			

		</tr>
		<tr>
			<td>TEL. <?php echo $address_client[0]->phone; ?></td>
			<td></td>
			<td></td>
			

		</tr>
		<tr>
			<td>EMAIL: <?php echo $address_client[0]->email; ?></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>



<br>

<!--Texto-->
<table>
	<thead>
		<tr>
			<td>Estimado señor <?php echo $address_client[0]->name; ?>:</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 100%;">Por medio de la presente tenemos el gusto de enviar a usted las especificaciones técnicas y parámetros de producción correspondientes al siguiente equipo:</td>
		</tr>
	</tbody>
</table>


<!--Imagen del producto-->

<br>

<table>
	<thead>
		<tr>
			<th></th>
			<th>MOLINO SERIE EN / ALTA PRODUCCION MOD. EN-700</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr id="ancho_imagen">
			<td></td>
			<td><img src=<?php echo path_file.'/ficha_tecnica/ri_2.png'?> ></td>
			<td></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>SOLIMQA PROYECTOS DE RECICLAJE SA DE CV</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>CONCEPCION BEISTEGUI 1402</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>COL. DEL VALLE</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>DEL. BENITO JUAREZ</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>C.P. 03020</td>
			<td></td>
			<td></td>
		</tr>
		
	</tfoot>
</table>







</body>
</html>

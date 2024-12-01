<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/


	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idCliente = (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$idOpcion = 1;
	$esEscritura = false;

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}
?>

<table class="cc">
	<thead>
		<tr>
			<th>Contacto</th>
			<th>Teléfono</th>
			<th>Extensión</th>
			<th>Correo</th>
			<th>Tipo de Contacto</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody class="tablapequena">
		<?php
			$qry = "CALL `redefectiva`.`SP_LOAD_CONTACTOS_GENERAL`($idCliente, 0, 2);";
			$res = $RBD->query($qry);
				if(!$RBD->error()){
					if(mysqli_num_rows($res)>0){
						while($row = mysqli_fetch_assoc($res)){
							$nombreCompleto = $row['nombreCompleto'];
							$nombre = $row['nombreContacto'];
							$apellidoPaterno = $row['apPaternoContacto'];
							$apellidoMaterno = $row['apMaternoContacto'];
							if(!preg_match('!!u', $nombreCompleto)){ $nombreCompleto = utf8_encode($nombreCompleto);}
							if(!preg_match('!!u', $nombre)){$nombre = utf8_encode($nombre);}
							if(!preg_match('!!u', $apellidoPaterno)){$apellidoPaterno = utf8_encode($apellidoPaterno);}
							if(!preg_match('!!u', $apellidoMaterno)){$apellidoMaterno = utf8_encode($apellidoMaterno);}
							echo "<tr>";
							echo "<td class='tdtablita'>".$nombreCompleto."</td>";
							$tel="";
							$row['telefono1'] = str_replace("-", "", $row['telefono1']);
							$telefono = str_split($row['telefono1']);
							$longitudTelefono = strlen($row['telefono1']);
							$contador = 0;
							$contador2 = 0;
							
							foreach ( $telefono as $t ) {
								$contador++;
								$contador2++;
								$tel .= $t;
								if ( $contador == 2 ) {
									if ( $contador2 <= ($longitudTelefono-1) ) {
										$contador = 0;
										$tel .= "-";
									}
								}
							}
							echo "<td class='tdtablita'>".$tel."</td>";							
							//echo "<td class='tdtablita'>".$row['telefono1']."</td>";
							echo "<td class='tdtablita' align='right'>".$row['extTelefono1']."</td>";
							echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
							echo "<td class='tdtablita'>".utf8_encode($row['descTipoContacto'])."</td>";
							echo "<td class='tdtablita'>";
							if($esEscritura){
								echo "
									<a href='#' onclick='eliminarContacto(".$idCliente.", ".$row['idContacto'].",2)''>
									<img src='../../../img/delete2.png'>
								</a>";


								if($esEscritura){
									echo "<a href='#contactos' data-toggle='modal'
										onclick=\"EditarContactos('$row[idContacto]',
										'".$nombre."',
										'".$apellidoPaterno."',
										'".$apellidoMaterno."',
										'".utf8_encode($row['idcTipoContacto'])."',
										'".$tel."',
										'".$row['correoContacto']."',
										'".$row['extTelefono1']."',event)\">
										<img src='../../../img/edit2.png'>
										</a>";
								}
							}
							
							echo "</td>";
							echo "</tr>";
						}
					}
					else{
						echo "<tr><td colspan='6'>No hay informaci&oacute;n para mostrar.</td></tr>";
					}
				}
				else{
					echo "<tr><td colspan='6'>No es posible mostrar la informaci&oacute;n.</td></tr>";
				}
			?>
	</tbody>
</table>
<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.inc.php");
	include("../../obj/XMLPreCorresponsal.php");

	$idCorresponsal = (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : 0;

	$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
	$oCorresponsal->load($idCorresponsal);

?>

<table class="tablanueva" style="margin-top:12px;">
	<thead class="theadtablita">
		<tr>
			<th class="theadtablitauno">Contacto</th>
			<th class="theadtablita">Teléfono</th>
			<th class="theadtablita">Extensión</th>
			<th class="theadtablita">Correo</th>
			<th class="theadtablita">Tipo de Contacto</th>
			<th class="theadtablita">Acciones</th>
		</tr>
	</thead>
	<tbody class="tablapequena">
		<?php
			$tipoContacto	= 0;
			$categoria		= (!empty($_POST["categoria"]))? $_POST["categoria"] : 3;

			$query = "CALL `prealta`.`SP_LOAD_PRECONTACTOS_GENERAL`($idCorresponsal, $tipoContacto, $categoria)";

			$emptyRow = "<tr>
				<td class='tdtablita'>&nbsp;</td>
				<td class='tdtablita'>&nbsp;</td>
				<td class='tdtablita'>&nbsp;</td>
				<td class='tdtablita'>&nbsp;</td>
				<td class='tdtablita'>&nbsp;</td>
				<td class='tdtablita'>&nbsp;</td></tr>";

			$sql = $RBD->query($query);

			if(!$RBD->error()){
				if(mysqli_num_rows($sql) > 0){
					while($row = mysqli_fetch_assoc($sql)){
						echo "<tr>";
							echo "<td class='tdtablita'>".((!preg_match("!!u", $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto'])."</td>";
							echo "<td class='tdtablita'>".$row['telefono1']."</td>";
							echo "<td class='tdtablita'>".$row['extTelefono1']."</td>";
							echo "<td class='tdtablita'>".$row['correoContacto']."</td>";
							echo "<td class='tdtablita'>".((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto'])."</td>";
							echo "<td class='tdtablita'>";
							if($row["subcadena"] == 0){
								echo "<a href='#' onclick='bandedcont3 = 1;EditarPreContacto($row[idCorresponsalContacto],0,2)' data-toggle=\"tooltip\" data-placement=\"left\" title=\"Editar\">
										<i class='fa fa-pencil'></i>
									</a>";
							}
							echo "&nbsp";
							echo "<a href='#' onclick='EliminarPreContactoCorresponsal($row[idCorresponsalContacto])'>
										<i class='fa fa-times'></i>
									</a>
								</td>";
						echo "</tr>";
					}
				}
				else{
					echo $emptyRow;
				}
			}
			else{
				echo $emptyRow;
			}
		?>
	</tbody>
</table>
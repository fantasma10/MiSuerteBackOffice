<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$idCadena	= (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;
	$idCliente	= (!empty($_POST['idCliente']))? $_POST['idCliente'] : 0;

	$idOpcion = 1;
	$esEscritura = false;

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}


	$q = "CALL `redefectiva`.`SP_GET_CUENTAS`($idCadena, $idCliente, -1, -1, '');";
	$sql = $RBD->query($q);
	if(!$RBD->error()){
		if(mysqli_num_rows($sql) > 0){
			while($row = mysqli_fetch_assoc($sql)){
				$beneficiario = $row['Beneficiario'];
				if ( !preg_match('!!u', $beneficiario) ) {
					$beneficiario = utf8_encode($beneficiario);
				}
				echo "<tr>";
				echo "<td class='tdtablita'>".$row['tipoMovimiento']."</td>";
				echo "<td class='tdtablita'>".$row['tipoDePago']."</td>";
				echo "<td class='tdtablita'>".$row['Destino']."</td>";
				echo "<td class='tdtablita'>".$row['CLABE']."</td>";
				echo "<td class='tdtablita'>".$row['nombreBanco']."</td>";
				echo "<td class='tdtablita'>".$beneficiario."</td>";
				echo "<td class='tdtablita'>".$row['RFC']."</td>";
				echo "<td class='tdtablita'>".$row['Correo']."</td>";
				if ( $esEscritura ) {
					echo "<td class='tdtablita'><img src='../../../img/delete.png' onclick='eliminarConfiguracionCuenta(".$row['idConfiguracion'].")'></td>";
				} else {
					echo "<td class='tdtablita'></td>";
				}
				echo "</tr>";
			}
		}
		else{
			echo "<tr><td colspan='9' class='tdtablita'>No hay informaci&oacute;n para mostrar.</td></tr>";
		}
	}
	else{
		echo "<tr><td colspan='9' class='tdtablita'>No es posible mostrar la informaci&oacute;n.</td></tr>";
	}
?>
<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	global $RBD;

	$idTipoMovimiento = (isset($_POST["idTipoMovimiento"]))? $_POST["idTipoMovimiento"] : -1;

	$sql = $RBD->query("CALL `redefectiva`.`SP_GET_TIPOINSTRUCCION`($idTipoMovimiento)");

	if(!$RBD->error()){
		echo "<select id='ddlInstruccion'  class='form-control m-bot15'>";

			if(mysqli_num_rows($sql) > 0){
				echo "<option value='-1'>Todos</option>";
				while($row = mysqli_fetch_assoc($sql)){
					echo "<option value='".$row["idTipoInstruccion"]."'>".$row["descripcicon"]."</option>";
				}
			}
			else{
				"<option value'-2'>Seleccione</option>";
			}

		echo "</select>";
	}
	else{
		echo "No ha sido posible Cargar la información";
	}

?>
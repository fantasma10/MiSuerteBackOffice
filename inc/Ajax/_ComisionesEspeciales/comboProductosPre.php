<?php
	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");


	$idGrupo		= (!empty($_POST['idGrupo']))? $_POST['idGrupo'] : -1;
	$idVersion		= (!empty($_POST['idVersion']))? $_POST['idVersion'] : -1;
	$idCadena		= (!empty($_POST['idCadena']))? $_POST['idCadena'] : -1;
	$idSubCadena		= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$idCorresponsal		= (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : -1;
?>
<select class="form-control m-bot15" id="ddlProducto">
	<option value='-1'>Seleccione un Producto</option>
	<?php
		$sql = $RBD->query("CALL `prealta`.`SP_LOAD_LISTA_PRODUCTOS`($idVersion, $idCadena, $idSubCadena, $idCorresponsal);");
		echo "<pre>"; echo var_dump($RBD->error()); echo "</pre>";
		while($row = mysqli_fetch_assoc($sql)){
			echo "<option value='".$row['idProducto']."'>".$row['descProducto']."</option>";
		}
	?>
</select>
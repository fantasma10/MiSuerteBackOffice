<?php
	include("../../config.inc.php");
	
	$idCadena 		= (isset($_POST["idCadena"]) AND $_POST["idCadena"] != "")? $_POST["idCadena"] : -1;
	$idSubCadena	= (isset($_POST["idSubCadena"]) AND $_POST["idSubCadena"] != "")? $_POST["idSubCadena"] : -1;
	$idCorresponsal	= (isset($_POST["idCorresponsal"]) AND $_POST["idCorresponsal"] != "")? $_POST["idCorresponsal"] : -1;
	$str			= (!empty($_POST["text"]))? $_POST["text"] : "";
	$categoria		= (!empty($_POST["categoria"]))? $_POST["categoria"] : 0;
	$idEstatus		= (isset($_POST["idEstatus"]) && $_POST['idEstatus'] > -1)? $_POST["idEstatus"] : -1;

	if($categoria > 0){
		$str = utf8_decode($str);
		$query = "CALL `redefectiva`.`SP_BUSCAR_CLIENTES`('$str', $categoria, $idCadena, $idSubCadena, $idCorresponsal, $idEstatus)";
		//var_dump("query: $query");
		try{
			$sql = $RBD->query($query);
		}catch(PDOException $e){
			echo "Error : ".$e->getMessage();
		}

		if(!$RBD->error()){
			$array = array();
			while($row = mysqli_fetch_assoc($sql)){
				$array[] = array(
					"idCadena"				=> $row["idCadena"],
					"idSubCadena"			=> $row["idSubCadena"],
					"idCorresponsal"		=> $row["idCorresponsal"],
					"esSubcadena"			=> $row["esSubcadena"],
					"nombreCadena"			=> utf8_encode($row["nombreCadena"]),
					"nombreSubCadena"		=> utf8_encode($row["nombreSubCadena"]),
					"nombreCorresponsal"	=> utf8_encode($row["nombreCorresponsal"]),
					"label"					=> utf8_encode($row["label"])
				);
			}
			echo json_encode($array);
		}else{
			echo "Ha ocurrido un error en la consulta ".$RBD->error();
		}
	}else{
		//echo "--------------------";
	}
?>
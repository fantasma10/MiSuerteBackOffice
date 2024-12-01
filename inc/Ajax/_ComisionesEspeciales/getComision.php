<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");


	$idGrupo		= (!empty($_POST['idGrupo']))? $_POST['idGrupo'] : -1;
	$idVersion		= (!empty($_POST['idVersion']))? $_POST['idVersion'] : -1;
	$idCadena		= (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;
	$idSubCadena	= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$idPrioridad	= (!empty($_POST['idPrioridad']))? $_POST['idPrioridad'] : -1;
	$idProducto		= (!empty($_POST['idProducto']))? $_POST['idProducto'] : -1;
	$idPermiso		= (!empty($_POST['idPermiso']))? $_POST['idPermiso'] : -1;

	/* Busca permisos de 'niveles' superiores, por ejemplo si se buscan permisos para una subcadena, se buscarán en las cadenas,
	si se buscan permisos para un corresponsal se buscarán en las subcadenas y cadenas */
	
	if($idPermiso == -1){
		$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_PERMISOS`($idCadena, $idSubCadena, $idVersion, $idProducto, $idPrioridad);");
	}
	else{
		$sql = $RBD->query("CALL `prealta`.`SP_BUSCA_PREPERMISOS`($idPermiso)");
	}


	if(!$RBD->error()){
		$numFilas = mysqli_num_rows($sql);
		if($numFilas > 0){
			/* si el numero de filas es igual a 1 se utilizan los permisos encontrados */
			if($numFilas == 1){
				$row = mysqli_fetch_assoc($sql);

			}/* si es mayor a uno, deben tomarse los de la prioridad más baja, ya que eso equivale al nivel mas alto */
			else{
				while($res = mysqli_fetch_assoc($sql)){
					$row = $res;
				}
			}
			$arrResp = array(
				'showMsg'	=> 0,
				'data'		=> $row
			);
		}/* si no se encontraron permisos en la tabla de los permisos de cadenas y subcadenas, se buscan los permisos del grupo */
		else{
			$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_PERMISOS_GRUPO`($idGrupo, $idVersion, $idProducto)");
			if(mysqli_num_rows($sql) > 0){
				$row = mysqli_fetch_assoc($sql);
				$arrResp = array(
					'showMsg'	=> 0,
					'data'		=> $row
				);
			}
			else{
				$sql = $RBD->query("CALL `redefectiva`.`SP_BUSCA_PERMISOS`(-1, -1, $idVersion, $idProducto, 0);");
				if(mysqli_num_rows($sql) > 0){
					$row = mysqli_fetch_assoc($sql);
					$arrResp = array(
						'showMsg'	=> 0,
						'data'		=> $row
					);
				}
				else{
					$arrData = array(
						'idPermiso'				=> 0,
						'idTipoPermiso'			=> 0,
						'idRuta'				=> 0.000,
						'idProducto'			=> 0.000,
						'perComCorresponsal'	=> 0.000,
						'impComCorresponsal'	=> 0.000,
						'perComGrupo'			=> 0.000,
						'impComGrupo'			=> 0.000,
						'perComCliente'			=> 0.000,
						'impComCliente'			=> 0.000,
						'perComEspecial'		=> 0.000,
						'impComEspecial'		=> 0.000,
						'perCostoPermiso'		=> 0.000,
						'impCostoPermiso'		=> 0.000,
						'impMaxPermiso'			=> 0.000,
						'impMinPermiso'			=> 0.000,
						'idEstatusPermiso'		=> 0.000,
						'idProducto'			=> $idProducto,
						'idPrioridad'			=> $idPrioridad
					);
					$arrResp = array(
						'showMsg'	=> 0,
						'msg'		=> 'No se encontraron Permisos de Default',
						'data'		=> $arrData);
				}
			}
		}
	}
	else{
		$arrResp = array(
			'showMsg'	=> 1,
			'msg'		=> 'Error General',
			'errmsg'	=> $RBD->error()
		);
	}

	echo json_encode($arrResp);
?>
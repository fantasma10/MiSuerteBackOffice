<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	/*
	**	Guarda las 'pre' comisiones, son las comisiones que se asignan antes de que la subcadena o corresponsal se autoricen
	*/

	$idCadena			= (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;
	$idSubCadena		= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : -1;
	$idCorresponsal		= (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : -1;
	$idGrupo			= (!empty($_POST['idGrupo']))? $_POST['idGrupo'] : -1;
	$idVersion			= (!empty($_POST['idVersion']))? $_POST['idVersion'] : -1;
	$idProducto			= (!empty($_POST['idProducto']))? $_POST['idProducto'] : -1;
	$perComCliente		= (!empty($_POST['perComCliente']))? $_POST['perComCliente']/100 : 0;
	$perComCorresponsal	= (!empty($_POST['perComCorresponsal']))? $_POST['perComCorresponsal']/100 : 0;
	$perComEspecial		= (!empty($_POST['perComEspecial']))? $_POST['perComEspecial']/100 : 0;
	$impComCliente		= (!empty($_POST['impComCliente']))? $_POST['impComCliente'] : 0;
	$impComCorresponsal	= (!empty($_POST['impComCorresponsal']))? $_POST['impComCorresponsal'] : 0;
	$impComEspecial		= (!empty($_POST['impComEspecial']))? $_POST['impComEspecial'] : 0;
	$impMaxPermiso		= (!empty($_POST['impMaxPermiso']))? $_POST['impMaxPermiso'] : 0;
	$impMinPermiso		= (!empty($_POST['impMinPermiso']))? $_POST['impMinPermiso'] : 0;
	$idTipoPermiso		= (!empty($_POST['idTipoPermiso']))? $_POST['idTipoPermiso'] : 0;
	$prioridad			= (!empty($_POST['prioridad']))? $_POST['prioridad'] : -1;
	$idPermiso			= (!empty($_POST['idPermiso']))? $_POST['idPermiso'] : -1;

	$idEmpleado = $_SESSION['idU'];

	$sql = $RBD->query("CALL `redefectiva`.`SP_GET_RUTA`($idProducto)");
	$res = mysqli_fetch_assoc($sql);
	$idRuta = $res['idRuta'];

	if($idRuta == null || empty($idRuta)){
		echo json_encode(
			array(
				'showMsg'	=> 1,
				'msg'		=> 'El Producto no Cuenta con un Ruta Configurada'
			)
		);
		return false;
	}

	if($idPermiso == -1 OR $idPermiso == 0){
		/*echo "CALL `prealta`.`SP_INSERT_PRE_COMISIONES`($idCadena, $idSubCadena, $idCorresponsal, $idVersion, $idTipoPermiso, $idRuta, $idProducto, $prioridad,
						$perComCorresponsal, $impComCorresponsal, 0, 0, $perComCliente, $impComCliente, $perComEspecial, $impComEspecial,
						0, 0, $impMaxPermiso, $impMinPermiso, 0, $idEmpleado)";*/
		$sql = $WBD->query("CALL `prealta`.`SP_INSERT_PRE_COMISIONES`($idCadena, $idSubCadena, $idCorresponsal, $idVersion, $idTipoPermiso, $idRuta, $idProducto, $prioridad,
						$perComCorresponsal, $impComCorresponsal, 0, 0, $perComCliente, $impComCliente, $perComEspecial, $impComEspecial,
						0, 0, $impMaxPermiso, $impMinPermiso, 0, $idEmpleado)");
	}
	else{
		$sql = $WBD->query("CALL `prealta`.`SP_UPDATE_PRE_COMISIONES`($idTipoPermiso, $idRuta,
						$perComCorresponsal, $impComCorresponsal, $perComCliente, $impComCliente, $perComEspecial, $impComEspecial,
						$impMaxPermiso, $impMinPermiso, $idEmpleado, $idPermiso)");
	}

	$res = mysqli_fetch_assoc($sql);

	if(!$WBD->error()){
		if($res['insertados'] >= 1){
			$array = array('showMsg' => 0, 'msg' => 'Operación Exitosa', 'errmsg' => '');
		}
		else{
			$array = array('showMsg' => 1, 'msg' => 'Error General');
		}
	}
	else{
		$array = array('showMsg' => 1, 'msg' => 'Error General', 'errmsg' => $WBD->error());
	}

	echo json_encode($array);

?>
<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$idCorte		= (isset($_POST['idReembolso']))? $_POST['idReembolso'] : 0;
	$cadena			= (isset($_POST['cadena']))? $_POST['cadena']:-1;
	$subcadena		= (isset($_POST['subcadena']))? $_POST['subcadena']:-1;
	$corresponsal	= (isset($_POST['corresponsal']))? $_POST['corresponsal']:-1;
	$importe		= (isset($_POST['importe']))? str_replace(array("\$", ","), '', $_POST['importe']):'';
	$fecha			= (isset($_POST['fecha']))? $_POST['fecha']:'';
	$descripcion	= (isset($_POST['descripcion']))? substr(strip_tags($_POST['descripcion']), 0, 45) : '';

	$nocuenta	= "";
	$forelo		= 0;

	if(($cadena != '' || $subcadena != '' || $corresponsal != '') && $importe != ''  && $fecha != '' && $descripcion != ''){
		$idEmpleado = $_SESSION['idU'];

		if($idCorte <= 0){
			$query = "CALL `data_contable`.`SP_REEMBOLSO_CREAR`($cadena, $subcadena, $corresponsal, $importe, '$fecha', '$descripcion', $idEmpleado);";

			$sql = $WBD->query($query);

			if(!$WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$arrRes = array(
					'showMsg'	=> ($res['codigo'] > 0)? 1 : 0,
					'msg'		=> (!preg_match('!!u', $res['msg']))? utf8_encode($res['msg']) : $res['msg'],
					'errmsg'	=> ($res['codigo'] > 0)? $res['codigo'].' '.$res['errmsg'] : ''
				);
			}
			else{
				$arrRes = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ha ocurrido un Error al Crear el Reembolso',
					'errmsg'	=> $WBD->error()
				);	
			}
		}
		else{
			$query = "CALL `data_contable`.`SP_REEMBOLSO_UPDATE`('$idCorte', '$cadena', '$subcadena', '$corresponsal', '$importe', '$fecha', '$descripcion', '$idEmpleado');";

			$sql = $WBD->query($query);

			if(!$WBD->error()){
				$res = mysqli_fetch_assoc($sql);
				$arrRes = array(
					'showMsg'	=> ($res['codigo'] > 0)? 1 : 0,
					'msg'		=> (!preg_match('!!u', $res['msg']))? utf8_encode($res['msg']) : $res['msg'],
					'errmsg'	=> $res['codigo'].' '.$res['msg']
				);
			}
			else{
				$arrRes = array(
					'showMsg'	=> 1,
					'msg'		=> 'Ha ocurrido un Error al Crear el Reembolso',
					'errmsg'	=> $WBD->error()
				);	
			}
		}

		echo json_encode($arrRes);
	//OBTENGO EL NUM DE CUENTA Y FORELO DEL CORRESPONSAL
		
/*        $sql = "SELECT D.`numeroCuenta`,C.`FORELO` FROM `redefectiva`.`dat_corresponsal` as D INNER JOIN `redefectiva`.`ops_cuenta` as C on D.`numeroCuenta` = C.`numCuenta` WHERE D.`idCadena` = $cadena AND D.`idSubCadena` = $subcadena AND D.`idCorresponsal` =  $corresponsal; ";
		$res =  $RBD->query($sql);
		if($RBD->error() == ''){
			if($res != '' && mysqli_num_rows($res) > 0){
				$r = mysqli_fetch_array($res);
				$nocuenta = $r[0];
				$forelo = $r[1];
				
				//SI EL IMPORTE ES MENOR AL FORELO DEL CORRESPONSAL SE REALIZA LA OPERACION
				
				if($forelo >= $importe){
					
					//INSERTO LA AUTORIZACION
					
					$sql = "INSERT INTO `data_contable`.`dat_autorizacion` (`idEstatus`,`idEmpleado`,`idFactura`,`idTipoAutorizacion`,`idInstruccion`,`idAutorizador`,`importeOriginal`,`importesolicitado`,`importeDiferencia`,`descripcion`,`detalle`,`fechaRegistro`,`fechaProcesamiento`)
					VALUES(1,".$_SESSION['idU'].",0,0,0,0,$importe,$importe,0,'','',NOW(),NOW());";
		
					$RBD->query($sql);
					if($RBD->error() == ''){
						
						//OBTENGO EL ID QUE INSERTE EN LA AUTORIZACION E INSERTO EN CORTE
						
						$idautorizacion = mysqli_insert_id($RBD->LINK);
						
						$sql = "INSERT INTO `data_contable`.`dat_corte_reembolso`(`idEstatus`,`idEmpleado`,`idInstruccion`,`idAutorizacion`,`numCuenta`,`fechaPago`,`fechaReembolso`,`importe`,`iva`,`importeTotal`,`descripcion`,`tipoReembolso`,`fechaRegistro`,`fechaProcesamiento`)
					VALUES (1,".$_SESSION['idU'].",0,$idautorizacion,'$nocuenta',NOW(),'$fecha',$importe,0,$importe,'$descripcion',1,NOW(),NOW())";
						
						$RBD->query($sql);
						if($RBD->error() == ''){
							echo "Se creó el Reembolso, favor de esperar su Autorización";
						}else{
							echo "No se pudo Insertar el Corte: ".$RBD->error();
						}
					}else{
						echo "No se pudo Insertar la Autorizacion: ".$RBD->error();
					}
				}else{
					echo "<span style='font-weight:bold;font-size:19px;color:red;'>No tiene el forelo suficiente para realizar el reembolso</span>";
				}
			}else{
				echo "|Lo Sentimos Pero No Se Encontraron Resultados";
			}
		}else{
			echo "No se pudo Obtener Num de Cuenta y Forelo: ".$RBD->error();
		}
}else{
	echo "Favor De Ingresar Los Datos Para La Operacion";*/
	}

?>
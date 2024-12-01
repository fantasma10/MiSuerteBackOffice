<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../../config.inc.php");
	include("../../session.ajax.inc.php");


	$importe		= (!empty($_POST['importe']))? $_POST['importe'] : '';
	$banco			= (!empty($_POST['banco']))? $_POST['banco'] : '';
	$numeroCuenta	= (!empty($_POST['numeroCuenta']))? $_POST['numeroCuenta'] : '';
	$aut			= (!empty($_POST['aut']))? $_POST['aut'] : '';
	$fecha			= (!empty($_POST['fecha']))? $_POST['fecha'] : '';
	$idSubCadena	= (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : 0;
	$idCorresponsal	= (!empty($_POST['idCorresponsal']))? $_POST['idCorresponsal'] : 0;
	$ref			= (!empty($_POST['ref']))? $_POST['ref'] : '';
	$archivo		= $_FILES['archivo'];
	$idEmpleado		= $_SESSION['idU'];

	$sql = $RBD->query("SELECT COUNT(idRegistro) AS n FROM `data_contable`.`dat_banco_mov` WHERE referencia = '$ref'");
	$res = mysqli_fetch_assoc($sql);
	$n = $res['n']+1;

	$idRegistro		= $n.date("md").$banco.$idSubCadena.$idCorresponsal;

	if($idCorresponsal > 0){
		$action = '../../../_Clientes/Corresponsal/Autorizar.php';
	}
	else{
		$action = '../../../_Clientes/SubCadena/Autorizar.php';
	}

	if(!empty($_POST['reenviar'])){
		echo "<form method='post' action='".$action."' id='formRegresa'>
			<input type='hidden' name='idSubCadena' value='".$idSubCadena."'>
			<input type='hidden' name='idCorresponsal' value='".$idCorresponsal."'>
		</form>";
	}

	$continuar = true;

	$extension = end(explode(".", strtolower($_FILES['archivo']['name'])));
	$exts = array('pdf', 'jpg', 'jpeg');
	if(!in_array($extension, $exts)){
		$continuar = false;
		if(empty($_POST['reenviar'])){
			echo json_encode(array(
				'showMsg'	=> 1,
				'msg'		=> 'Las Extensiones válidas son : .jpg y .pdf',
				'errmsg'	=> '',
			));
			exit();
		}
		else{
			echo "<script>
				alert('Las Extensiones v\u00E1lidas son : .jpg y .pdf');
				document.getElementById('formRegresa').submit();
			</script>";
			/*exit();
			return false;*/
		}
	}

	if($continuar){
	    $sql = $WBD->query("CALL `data_contable`.`SP_BANCO_REGISTRAMOV`('$idRegistro', 1, 1, $banco, 1, '$numeroCuenta', $importe, '$ref', '', '$aut', '$fecha')");
	    if(!$WBD->error()){
	    	$res = mysqli_fetch_assoc($sql);
	    	//echo "<pre>"; echo var_dump($res); echo "</pre>";
	    	$idMov = $res['idRegistro'];

			$directorio		= "../../../archivos/Comprobantes/";
			$size			= $_FILES['archivo']['size'];
			$nombre			= $_FILES['archivo']['name'];
			$tmpname		= $_FILES['archivo']['tmp_name'];
			$time			= date("Y-m-d H:i:s");

			$nombreencriptado = "FichaDePago_".$idSubCadena."_".$idCorresponsal."_".$idMov.".".$extension;

			$ruta = $directorio.$nombreencriptado;

			if(round(($size/1024)) <= 2000){
			    if(move_uploaded_file($tmpname, $ruta)) {
			        $sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension', {$_SESSION['idU']});";
					$result = $WBD->SP($sql);
			        if($WBD->error() == ''){
						if ( $result->num_rows > 0 ) {
							list( $id ) = $result->fetch_array();

							$sql = "CALL `data_contable`.`SP_CREATE_RELACION_ARCHIVOMOV`($idSubCadena, $idCorresponsal, $idMov, $id, $idEmpleado)";
							$s = $WBD->query($sql);
							if($WBD->error()){
								if(empty($_POST['reenviar'])){
									echo json_encode(array(
										'showMsg'	=> 1,
										'msg'		=> 'Error',
										'errmsg'	=> $WBD->error()
									));
									exit();
								}
								else{
									/*echo json_encode(array(
										'showMsg'	=> 1,
										'msg'		=> 'Error',
										'errmsg'	=> $WBD->error()
									));*/
									echo "<script>
										alert('Error al guardar el Archivo');
										document.getElementById('formRegresa').submit();
									</script>";
									exit();
								}
							}

							$band = true;
						} else {
							$band = false;
						}
			        }else{
			            $band = false;
			        }
			    }
			    else{
			       $band = false;
			    }
			}
			else{
			    $bandtam = true;
			}
	    }
	    else{
	    	if(empty($_POST['reenviar'])){
	    		echo json_encode(
		   			array(
		    			'showMsg'	=> 1,
		    			'msg'		=> 'Error',
		    			'errmsg'	=> $WBD->error(),
		    			'idMov'		=> $idMov
		    		)
		    	);
		    	exit();
			}
			else{
				echo json_encode(
		   			array(
		    			'showMsg'	=> 1,
		    			'msg'		=> 'Error',
		    			'errmsg'	=> $WBD->error(),
		    		)
		    	);
				echo "<script>
					alert('Error General');
					document.getElementById('formRegresa').submit();
				</script>";
				exit();
			}
	    }
	}


    if(empty($_POST['reenviar'])){
		echo json_encode(
			array(
				'showMsg'	=> 0,
				'msg'		=> 'Operacion Exitosa',
				'idMov'		=> $idMov
			)
		);
	}
	else{
		echo "<script>
				alert('Operaci\u00F3n Exitosa');
				document.getElementById('formRegresa').submit();
			</script>";
	}

?>
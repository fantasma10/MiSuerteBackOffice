<?php

	/*error_reporting(E_ALL);
	ini_set('display_errors', 1);*/

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Afiliaci&oacute;n Express";
	$subsubmenuTitulo = "Consulta";
	$tipoDePagina = "Mixto";
	$idOpcion = 62;

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

	$idSucursal = (!empty($_GET['idSucursal']))? $_GET['idSucursal'] : 0;
	$RBD2 = $RBD;
	
	$S = new AfiliacionSucursal2($RBD2, $WBD, $LOG);

	$sql1 = $RBD->query("SELECT idCliente FROM `afiliacion`.`dat_sucursal` WHERE idSucursal = $idSucursal");
	$res = mysqli_fetch_assoc($sql1);
	$idCliente = $res['idCliente'];

	// verificar si es de un cliente ya creado o de un cliente de afiliacion
	$sql2 = $RBD->query("SELECT `idCliente`, `idSubCadena`, `FecRegistro`, `idEstatus` FROM `afiliacion`.`dat_sucursal` AS S WHERE `idSucursal` = $idSucursal AND `idEstatus` != 3");
	$res = mysqli_fetch_assoc($sql2);
	$idEstatusSucursal = $res['idEstatus'];
	
	if($res['idSubCadena'] != 0){
		$idSubCadena = $res['idSubCadena'];
		//echo "CALL `redefectiva`.`SP_CLIENTE_DATOS`($idSubCadena);";
		$sqlN = $RBD->query("CALL `redefectiva`.`SP_CLIENTE_DATOS`($idSubCadena);");
		$result = mysqli_fetch_assoc($sqlN);

		$idCliente = $res['idSubCadena'];
		$S->loadClienteReal($idCliente);
		//var_dump($S->SUCURSALES);
		if($result['idCliente'] == 0){
			$esSubCadena = 1;
		}
		else{
			$esSubCadena = 0;
		}

		if($idCliente > 0){
			$CLIENTE = new Cliente($RBD, $WBD, $LOG);
			$CLIENTE->load($idCliente);
			$sql = $RBD->query("CALL `afiliacion`.`SP_COSTO_FIND`($CLIENTE->ID_COSTO, $CLIENTE->ID_NIVEL)");
			//var_dump("CALL `afiliacion`.`SP_COSTO_FIND`($CLIENTE->ID_COSTO, $CLIENTE->ID_NIVEL)");
			$res = mysqli_fetch_assoc($sql);
			$minimoPuntos = $res['minimoPuntos'];
			$maximoPuntos = $res['maximoPuntos'];
			$nombreNivel	= (!preg_match("!!u", $CLIENTE->NOMBRE_NIVEL))? utf8_encode($CLIENTE->NOMBRE_NIVEL) : $CLIENTE->NOMBRE_NIVEL;
			$idTipoForelo	= $CLIENTE->ID_TIPO_FORELO;

			if($minimoPuntos == 0 && $maximoPuntos == 0){
				$saldoPago = 0;
			}else{
				$costo = $res['Afiliacion']; 
				$saldoPago		= $result['saldo'] - $costo;
				$estatus		= "Pago Pendiente \$".number_format($costo, 2);
			}
		}
		else{
			$saldoPago = 0;
			$idTipoForelo	= 1;
			$nombreNivel	= "Sin Nivel";
			$estatus		= "FORELO \$".number_format($result['saldo']);
		}
		$nombrecliente	= (!preg_match("!!u", $result['nombreCliente']))? utf8_encode($result['nombreCliente']) : $result['nombreCliente'];

		$sucursal = $S->getSucursal($idSucursal);
		$contactos = $S->getContactos($idSucursal);

		$_COMPLETO = ($S->completoSucursal($idSucursal) == 0)? TRUE : FALSE;

		$_REAL = TRUE;
	}
	else{
		$S->load($idCliente);
		$sucursal = $S->getSucursal($idSucursal);

		$contactos = $S->getContactos($idSucursal);

		$_COMPLETO = ($S->completoSucursal($idSucursal) == 0)? TRUE : FALSE;


		$_REAL = FALSE;
		$CLIENTE = new AfiliacionCliente($RBD, $WBD, $LOG);
		$CLIENTE->load($res['idCliente']);
		$nombrecliente	= $CLIENTE->NOMBRE_COMPLETO_CLIENTE;
		$estatus		= "Pago Pendiente \$".number_format($CLIENTE->COSTO, 2);
		$fechaRegistro	= $res['FecRegistro'];
		$nombreNivel	=  (!preg_match("!!u", $CLIENTE->NOMBRENIVEL))? utf8_encode($CLIENTE->NOMBRENIVEL) : $CLIENTE->NOMBRENIVEL;
	}
?>

<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!--Favicon-->
			<link rel="shortcut icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
			<link rel="icon" href="<?php echo $PATHRAIZ;?>/img/favicon.ico" type="image/x-icon">
			<title>.::Mi Red::.Nuevo Usuario</title>
			<!-- Núcleo BOOTSTRAP -->
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
			<!--ASSETS-->
			<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
			<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
			<!-- ESTILOS MI RED -->
			<link href="<?php echo $PATHRAIZ;?>/css/miredgen.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/css/style-responsive.css" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/css/datepicker.css" />
			<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
			<![endif]-->
		</head>
		<!--Include Cuerpo, Contenedor y Cabecera-->
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
		<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->

			<section id="main-content">
				<section class="wrapper site-min-height">
					<div class="row">
						<div class="col-lg-12">
							<!--Panel Principal-->
							<div class="panelrgb">
								<div class="titulorgb-prealta">
									<span><i class="fa fa-users"></i></span>
									<h3>Consulta de Sucursales</h3>
									<span class="rev-combo pull-right">Afiliación<br>Express</span>
								</div>

								<div class="panel">
									<div class="jumbotron">
										<div class="container">
											<h2><?php echo $sucursal['NombreSucursal']; ?></h2>
			 								
			 								<div class="row">
												<div class="col-xs-5">
													<div class="info">
														<div class="titulo">Cliente</div>
														<div class="regimen"><?php echo $nombrecliente;?></div>
													</div>
												</div>
			
												<div class="col-xs-3">
													<div class="info">
														<div class="titulo">Estatus</div>
														<div class="regimen"><?php echo $estatus;?></div>
													</div>
												</div>
			
												<div class="col-xs-2">
													<div class="info">
														<div class="titulo">Fecha de Afiliación</div>
														<div class="regimen">
															<?php
																$f = date_create($fechaRegistro);
																echo date_format($f, "Y-m-d");
															?>
														</div>
													</div>
												</div>

												<div class="col-xs-2">
													<div class="info">
														<div class="titulo">Nivel Expediente</div>
														<div class="regimen"><?php echo $nombreNivel;?></div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="panel-body">
										<div class="well">
											<ul>
												<li>
													<!--a href="formnew5.php?idSucursal=<?php echo $idSucursal;?>&idCliente=<?php echo $idCliente?>"><i class="fa fa-book"></i> Información General</a-->
													<form id="formGenerales" action="formnew5.php?idSucursal=<?php echo $idSucursal;?>&idCliente=<?php echo $idCliente;?>" method="post">
														<input type="hidden" name="consultaSucursal" value="true">
														<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
														<input type="hidden" name="esSubcadena" value="<?php echo $esSubCadena;?>">
														<input type="hidden" name="idSucursal" value="<?php echo $idSucursal;?>">
														<input type="hidden" name="vieneDeNuevaSucursal" value="<?php echo ($_REAL == TRUE)? 1 : 0;?>">
														<a href="#" onClick="formSubmit('formGenerales')"><i class="fa fa-book"></i> Información General</a>
														<?php echo ($_COMPLETO)? "<i class='fa fa-check-square-o pull-right'></i>" : "<i class='fa fa-square-o pull-right'></i>"?>
													</form>
												</li>
												<li>
													<!--a href="formnew7.php"><i class="fa fa-folder"></i> Referencia Bancaria</a-->
													<form id="formReferencia" action="Resumen.php?idSubCadena?=<?php echo $idCliente?>&idCliente=<?php echo $idCliente?>" method="post">
														<input type="hidden" name="consultaSucursal" value="true">
														<input type="hidden" name="idCliente" value="<?php echo $idCliente;?>">
														<input type="hidden" name="esSubcadena" value="<?php echo $esSubCadena;?>">
														<input type="hidden" name="idSucursal" value="<?php echo $idSucursal;?>">
														<input type="hidden" name="vieneDeNuevaSucursal" value="<?php echo ($_REAL == TRUE)? 1 : 0;?>">
														<a href="#" onClick="formSubmit('formReferencia')"><i class="fa fa-bank"></i> Referencia Bancaria</a>
														<!--i class="fa fa-square-o pull-right" id="iReferencia"></i-->
													</form>
												</li>
											</ul>
										</div>
									</div>
									<div class="panel-body">
										<?php
											//echo $_REAL." | ";
											//echo $_COMPLETO." | ";
											//echo $idEstatusSucursal." | ";
											//echo $saldoPago." | ";
											//echo $idTipoForelo." | ";
											/*echo "REAL: $_REAL";
											echo "COMPLETO: $_COMPLETO";
											echo "idEstatusSucursal: $idEstatusSucursal";
											echo "saldoPago: $saldoPago";
											echo "idTipoForelo: $idTipoForelo";*/
											if($_REAL == true && $_COMPLETO == true && $idEstatusSucursal == 0){ ?>
												<a href="#" onClick="crearSucursal(<?php echo $idSucursal;?>);"><button class="btn btn-xs btn-info pull-left">Crear</button></a>
										<?php } ?>
										<a href="ConsultaSucursal.php"><button class="btn btn-xs btn-info pull-right">Regresar</button></a>
									</div>
								</div>

							</div>
						</div>
					</div>
				</section>
			</section>

<!--*.JS Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             

<script>
	BASE_PATH = "<?php echo $PATHRAIZ;?>";
	function crearSucursal(idSucursal){
		if(idSucursal != undefined){
			$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/crearSucursal.php",
				{
					idSucursal : idSucursal
				},
				function(response){

					if(showMsg(response)){
						alert(response.msg);
					}

					window.location = "ConsultaSucursal.php";
				},
				"json"
			);
		}
	}
</script>

</body>
</html>
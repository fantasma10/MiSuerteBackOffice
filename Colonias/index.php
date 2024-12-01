<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../inc/config.inc.php");
	include("../inc/session.inc.php");

	require $_SERVER['DOCUMENT_ROOT']."/inc/PhpExcel/Classes/PhpExcel.php";

	$bError = false;

	$dFechaHoraInicio	= '';
	$dFechaHoraFinal	= '';
	if(!empty($_FILES['sArchivo']) && !empty($_POST['bSubmit'])){

		$size = $_FILES['sArchivo']['size']/1000;

		if($size>30000){
			$bError = true;
			$sMensaje = "El archivo que intenta subir contiene demasiada informaci&oacute;n.";
		}

		if(!$bError){
			$dFechaHoraInicio = date('Y-m-d H:i:s');

			$sArchivo			= $_FILES['sArchivo'];

			$sName				= $_FILES['sArchivo']['tmp_name'];
			$oExcelFileReader	= new ExcelFileReaderColonias();
			$oExcelFileReader->set_file($sArchivo);
			$oExcelFileReader->setORdb($oRdb);
			$oExcelFileReader->setOWdb($oWdb);

			$arrRes = $oExcelFileReader->initReader();

			if($arrRes['bExito'] == false){
				echo json_encode($arrRes); exit();
			}

			$resultado = $oExcelFileReader->validarColonias();		
			
			if(!$resultado['bExito']){
				$bError = true;

				$sMensaje = $resultado['sMensaje'];
			}
			else{
				$nUpdates = count($resultado['updates']);
				$nInserts = count($resultado['inserts']);
			}
		}
	}

	$idOpcion		= 187;
	$tipoDePagina	= "Mixto";
	$esEscritura	= false;

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location:../error.php");
		exit();
	}

	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$PATHRAIZ	= "https://".$_SERVER['HTTP_HOST'];
	$BASE_PATH	= $PATHRAIZ;

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $BASE_PATH;?>/img/favicon.ico" type="image/x-icon">
	<title>.::Mi Red::.Colonias</title>
	<!-- Núcleo BOOTSTRAP -->
	<link rel="stylesheet" href="<?php echo $BASE_PATH;?>/css/themes/base/jquery.ui.all.css" />

	<link href="<?php echo $BASE_PATH;?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/bootstrap-reset.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/style-autocomplete.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/jquery.alerts.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/jquery.powertip.css" rel="stylesheet">
	<!--ASSETS-->
	<link href="<?php echo $BASE_PATH;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo $BASE_PATH;?>/assets/opensans/open.css" rel="stylesheet" />
	<!-- ESTILOS MI RED -->
	<link href="<?php echo $BASE_PATH;?>/css/miredgen.css" rel="stylesheet">
	<link href="<?php echo $BASE_PATH;?>/css/style-responsive.css" rel="stylesheet" />

	<link rel="stylesheet" type="text/css" href="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo $PATHRAIZ?>/assets/data-tables/DT_bootstrap.css" />

	<style>
		.align-right{
			text-align : right;
		}

		.list-inline{
			font-size:12px;
		}
	</style>

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Contenido Principal del Sitio-->
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="panel panelrgb">
			<div class="titulorgb-prealta">
				<span><i class="fa fa-book"></i></span>
				<h3>Colonias</h3>
				<span class="rev-combo pull-right">Colonias<br/>&nbsp;</span>
			</div>
			<div class="panel-body">
				<h3>Selecci&oacute;n de Archivo</h3>
				<div class="well">
					<form name="form_subir_colonias" method="post" action="" enctype="multipart/form-data">
						<div class="row">
							<div class="col-xs-12">
								<label>1.- Seleccione el Archivo.</label><br/>
								<label>2.- Haga clic en el bot&oacute;n "Subir".</label><br/>
								<label>3.- Espere a que el Sistema le muestre los querys que deber&aacute; ejecutar.</label>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">
								<div class="form-group">
									<label>Archivo</label>
									<input type="file" name="sArchivo">
									<input type="hidden" name="bSubmit" value="true">
								</div>
							</div>

							<?php
								if($esEscritura){
							?>
							<div class="col-xs-3">
								<button type="submit" onclick="onclickbtnsubir();" class="btn btn-sm btn-default pull-right" style="margin-top:20px;" id="btnNuevo">Subir</button>
							</div>
							<?php
								}
							?>
						</div>
					</form>
				</div>

				<h3>Resultado</h3>
				<div class="well">
					<?php

							$sQuerys = '';
							if(!empty($_POST['bSubmit']) && !$bError){

								if($nUpdates > 0 || $nInserts > 0){
					?>
					<div class="col-xs-12">
						<button type="button" id="btnCopiar" class="btn btn-sm btn-default pull-left">Copiar Resultado</button>
						<br/>
					</div>
					<div class="col-xs-12">
						<?php

								}

								echo "<br/><h4> Archivo Subido: ".$_FILES['sArchivo']['name']."</h4><br/>";
								$nTotal = $nUpdates + $nInserts;
								echo "<h4>Total de Cambios: ".$nTotal."</h4>";
								echo "<h4>UPDATES : ".$nUpdates." </h4>";
								echo "<h4>INSERTS : ".$nInserts." </h4>";
								echo "<br/><br/><br/>";

								if($nUpdates > 0 || $nInserts > 0){
									echo "/* UPDATES ".$nUpdates." */<br/>";
									echo "<code style='width:100%;overflow:auto;display:block;max-height:700px;'>";
									$arr_updates = implode(';<br/>', $resultado['updates']);

									echo utf8_encode($arr_updates);
									if($nUpdates > 0){
										echo ";";
									}
									echo "</code>";

									echo "<br/>";
									echo "<br/>";
									echo "/* INSERTS ".$nInserts." */<br/>";

									echo "<code style='width:100%;overflow:auto;display:block;max-height:700px;'>";
									$arr_inserts = implode('<br/>', $resultado['inserts']);

									echo utf8_encode($arr_inserts);
									echo "</code>";

									$dFechaHoraFinal = date('Y-m-d H:i:s');


									echo "<br/>";
									echo "<br/>";
									echo "Inicio ".$dFechaHoraInicio;
									echo "<br/>";
									echo "Final ".$dFechaHoraFinal;
									echo "<br/>";
									echo "<br/>";

									if($nUpdates > 0){
										$sQuerys = utf8_encode($arr_updates);
										$sQuerys.= ';<br/>';
									}
									if($nInserts > 0){
										$sQuerys.= utf8_encode($arr_inserts);
									}

									$sQuerys = preg_replace("/<br\/>/", "\n", $sQuerys);
								?>

									<textarea id="txtInputCopiar"><?php echo $sQuerys;?></textarea>
								<?php

								}
							}

							if($bError){
								echo $sMensaje;
							}



						?>

					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<!--*.JS Generales-->
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo $BASE_PATH;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/respond.min.js" ></script>
<script type="text/javascript" src="<?php echo $BASE_PATH;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Generales-->
<script src="<?php echo $BASE_PATH;?>/inc/js/common-scripts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/common-custom-scripts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo $BASE_PATH;?>/inc/input-mask/input-mask.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.autocomplete.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo $BASE_PATH;?>/inc/js/jquery.powertip-1.2.0/jquery.powertip.js"></script>

<!--Cierre del Sitio-->
<script type="text/javascript">
	var BASE_PATH = "<?php echo $BASE_PATH;?>";
	function onclickbtnsubir(){
		showSpinner();
	}

	$(document).ready(function($) {
		$('#btnCopiar').on('click', function(e){
			$('#txtInputCopiar').select();
			document.execCommand("copy");
		});
	});
</script>
</body>
</html>
<?php
	$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];


	include($PATH_PRINCIPAL."/inc/config.inc.php");
	include($PATH_PRINCIPAL."/inc/session.inc.php");

	$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

	$submenuTitulo		= "Mi Suerte";
	$subsubmenuTitulo	= "Juegos";

	$tipoDePagina = "mixto";
	$idOpcion = 162;

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: $PATHRAIZ/error.php");
		exit();
	}
	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	function acentos($word){
		return (!preg_match('!!u', $word))? utf8_encode($word) : $word;
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
		<title>.::Mi Red::.Carga de Juegos</title>
		<!-- Núcleo BOOTSTRAP -->
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $PATHRAIZ;?>/css/bootstrap-reset.css" rel="stylesheet">
		<!--ASSETS-->
		<link href="<?php echo $PATHRAIZ;?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/opensans/open.css" rel="stylesheet" />
		<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
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
	<?php include($PATH_PRINCIPAL."/inc/cabecera2.php"); ?>
		<!--Fin de la Cabecera-->
		<!--Inicio del Menú Vertical-->
		<!--Función "Include" del Menú-->
	<?php include($PATH_PRINCIPAL."/inc/menu.php"); ?>
		<!--Final del Menú Vertical-->
		<!--Contenido Principal del Sitio-->
		<section id="main-content">
			<section class="wrapper site-min-height">
				<div class="row">
					<div class="col-lg-12">
						<!--Panel Principal-->
						<div class="panelrgb">
							<div class="titulorgb-prealta">
								<span><i class="fa fa-upload"></i></span>
								<h3>Carga de Juegos</h3><span class="rev-combo pull-right">Carga<br>de Juegos</span>
							</div>
							<div class="panel">
								<div class="panel-body">
									<div class="well"> 
									<div class="form-group col-xs-12" id="contenedor">
									<div class="row">
									<input type="hidden" id="juego" name="juego" value="0">
										<form method="post" enctype="multipart/form-data">
										
										
										
            							<div class="form-group col-xs-6" style="margin-top:16px;">
            								
            								<label for="progol" style="float: right" class="btn btn-success">
    											<img src="../../STORAGE/progol/PROGOL-REVANCHA.png">					
											</label>
            								<input type="file" class="btn btn-success" style="display: none;" id="progol">
            							</div>
            						
        								</form>


        								<form method="post" enctype="multipart/form-data">
										
            							<div class="form-group col-xs-6" style="margin-top:16px;">
            								<label for="xgol" class="btn btn-success">
    											<img src="../../STORAGE/progol/PROGOL-MEDIA.png">					
											</label>
            								<input type="file" style="display: none;" class="btn btn-success" id="xgol">
     
            							</div>
        								</form>
        							</div>
        								
									</div>
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
		<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
							<!--Generales-->
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo $PATHRAIZ;?>/misuerte/js/cargaJuegos.js"></script>
		<script>
								BASE_PATH		= "<?php echo $PATHRAIZ;?>";
								ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";
								ES_ESCRITURA	= "<?php echo $esEscritura;?>";
		</script>
	</body>
	<style type="text/css">
		.prueba{
			width:100%!important;
		}

		.mensaje{
			width:100%!important;
		}

		#td{
			width: 30% !important;
		}

	</style>
</html>



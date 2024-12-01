<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

	$submenuTitulo = "Clientes";
	$subsubmenuTitulo = "Consulta";
	$tipoDePagina = "Mixto";
	$idOpcion = 1;

	if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
		header("Location: ../../../error.php");
		exit();
	}

	$esEscritura = false;
	if(esLecturayEscrituraOpcion($idOpcion)){
		$esEscritura = true;
	}

	$PATHRAIZ = "https://". $_SERVER['HTTP_HOST'];

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
			<title>.::Mi Red::.</title>
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

			<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet">
			<link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet">
			<link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css">

			<style>

				#divRESParent{
					display : none;
				}

				#emergente{
					height: 100%;
					background-color: #fff;
					position:fixed;
					left:0;
					right:0;
					top:0;
					z-index: 1000;
					visibility: hidden;
				}
				.ui-autocomplete-loading {
					background: white url('../../img/loadAJAX.gif') right center no-repeat;
				}
				.ui-autocomplete {
					max-height: 190px;
					overflow-y: auto;
					overflow-x: hidden;
					font-size: 12px;
				}
			</style>

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
		</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/cabecera.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical-->
<!--Función "Include" del Menú-->
<?php include($_SERVER['DOCUMENT_ROOT']."/inc/menu.php"); ?>
<!--Final del Menú Vertical-->
<!--Contenido Principal del Sitio-->

<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-xs-12">

				<?php include("../inc/formPase.php"); ?> 

				<!--Panel Principal-->
				<div class="panelrgb">
					<div class="titulorgb-prealta">
						<span><i class="fa fa-users"></i></span>
						<h3>Consulta</h3><span class="rev-combo pull-right">Menú<br>Consulta</span>
					</div>

					<div class="panel">

					<div class="jumbotron">
						<div class="container">
							<h2>Consulta de Clientes</h2>
							<p>Seleccione el elemento que desea buscar, y llene los campos de b&uacute;squeda.</p>
						</div>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-3">
								<a href="#" tag="cadena" onClick="clickCadena();">
									<img id="imgcadena" tag="cadena" src="<?php echo $PATHRAIZ;?>/img/cadena.png">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="#" tag="subcadena" onClick="clickSubCadena();">
									<img id="imgsubcadena" tag="subcadena" src="<?php echo $PATHRAIZ;?>/img/subcadena_1.png">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="#"  tag="cliente"  onclick="clickCliente();">
									<img id="imgcliente" tag="cliente" src="<?php echo $PATHRAIZ;?>/img/cliente.png">
								</a>
							</div>
							<div class="col-xs-3">
								<a href="#"  tag="sucursal" onClick="clickCorresponsal();">
									<img id="imgsucursal" tag="sucursal" src="<?php echo $PATHRAIZ;?>/img/sucursal.png">
								</a>
							</div>
						</div>

						<!-- Busqueda para la Cadena -->
						<div class="well" style="margin-top:30px;display:none;" id="busquedaCadena">
							<form class="form-horizontal">
								<div class="form-group">
									<label class="control-label">Cadena:</label>
									<br/>
										<input type="text" class="form-control m-bot15 col-xs-6" placeholder="ID o Nombre de la Cadena" id="cadena">
										<input type="hidden" id="cadenaID" value="" /> 
										<!--input type="text" class="form-control " placeholder="ID o Nombre de la Cadena"-->
									</div>
                                 
                                 
									<button type="button" style="margin-top:30px; "onClick="BuscaCadena1();" class="btn btn-guardar pull-right">Buscar</button>
								
							</form>
						</div>
                        
	
						<!-- Busqueda de la SubCadena -->
						<div class="well" style="margin-top:30px;display:none" id="busquedaSubCadena">
							<form class="form-horizontal">                                      
								<div class="form-group">
									<label class="col-xs-1 control-label">Cadena:</label>
									<div class="col-xs-3">
	                      				<input type="hidden" id="cadena2ID" value="" />
										<input class="form-control m-bot15" type="text" id="cadena2" placeholder="ID o Nombre de la Cadena">
									</div>
									<div class="col-xs-2">
										<button type="button"  onclick="BuscaSubCadena22();" class="btn btn-guardar">Buscar&nbsp;<i class="fa fa-search"></i></button>
									</div>

									<label class="col-xs-1 control-label">Subcadena:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" id="subcadena" placeholder="ID o Nombre de la Subcadena">
	                    				<input type="hidden" id="subcadenaID" value="" />
									</div>

									<div class="col-xs-1">
										<button class="btn btn-guardar" type="button"  onclick="BuscaSubCadena1();">Buscar&nbsp;<i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
						</div>

						<!-- Busqueda de Cliente -->
						<div class="well" style="margin-top:30px;display:none;" id="busquedaCliente">
							<form class="" name="formBusquedaCliente" method="post" action="SubCadena/ListadoCliente.php" id="formBusquedaCliente">
								<div class="form-group col-xs-4">
                                    <label class=" control-label">Cliente: </label>
                                    <input type="hidden" name="idCliente" id="idCliente" value="0">
                                    <input class="form-control m-bot15" type="text" id="txtCliente" placeholder="ID o Nombre del Cliente">
                                </div>
                                <div class="form-group col-xs-4">
                                    <label class=" control-label">RFC: </label>
                                    <input class="form-control m-bot15" type="text" placeholder="RFC del Cliente" id="txtRFCCliente">
                                </div>
                                <div class="form-group col-xs-3">
                                    <label class=" control-label">Cta Contable: </label>
                                    <input class="form-control m-bot15" type="text" placeholder="Cta Contable" id="txtCuenta">
                                </div>
                                <div class="form-group col-xs-1">
										<a href="#" style="margin-top:20px" class="btn btn-guardar" onClick="buscarCliente();">Buscar&nbsp;<i class="fa fa-search"></i></a>
									</div>
								<!-- <div class="form-group">
									<label class="col-xs-1 control-label">Cliente:</label><br>
									<div class="col-xs-3">
										<input type="hidden" name="idCliente" id="idCliente" value="0">
										<input class="form-control m-bot15" type="text" id="txtCliente" placeholder="ID o Nombre del Cliente">
									</div>

									<label class="col-xs-1 control-label">RFC:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" placeholder="RFC del Cliente" id="txtRFCCliente">
									</div>

									<label class="col-xs-1 control-label">CTA-CONTABLE:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" placeholder="RFC del Cliente" id="txtRFCCliente">
									</div>

									<div class="col-xs-2">
										<a href="#" class="btn btn-guardar" onClick="buscarCliente();">Buscar&nbsp;<i class="fa fa-search"></i></a>
									</div>
								</div> -->
							</form>
						</div>

						<!-- Busqueda de Corresponsal / Sucursal -->
						<div class="well" style="margin-top:30px;display:none;" id="busquedaCorresponsal">
							<form class="form-horizontal">                                      
								<div class="form-group">
									<label class="col-xs-1 control-label">Cadena:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" id="idCadena" placeholder="ID o Nombre de Cadena">
	                      				<input type="hidden" id="ddlCad" value="-1"/>
									</div>

									<label class="col-xs-1 control-label">Cliente:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" id="idSub" placeholder="ID o Nombre de Cliente">
										<input type="hidden" id="ddlSub" value="-1"/>
									</div>

									<label class="col-xs-1 control-label" style="padding-left: 0px;">Corresponsal:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" type="text" id="idCor" placeholder="Nombre del Corresponsal">
										<input type="hidden" id="ddlCorresponsal" value="-1" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-xs-1 control-label">Teléfono:</label>
									<div class="col-xs-3">
										<input class="form-control m-bot15" id="txtTel" type="text" placeholder="Teléfono del Corresponsal"  id="txtTel">
									</div>
								</div>

								<div class="form-group">
									<input type="hidden" class="form-control" placeholder="" id="cPais">
									<input type="hidden" id="ddlPais" value="164">

									<label class="col-xs-1 control-label">Estado:</label>
									<input type="hidden" id="txtcp">
									<div class="col-xs-3" id="divEdo">
										<select class="form-control m-bot15" id="ddlEstado">
											<option value="-2" selected = "selected">Seleccione</option>
										</select>
									</div>

									<label class="col-xs-1 control-label">Ciudad:</label>
									<div class="col-xs-3" id="divCd">
										<select class="form-control m-bot15" id="ddlMunicipio">
											<option value="-2" selected = "selected">Seleccione</option>
										</select>
									</div>


									<label class="col-xs-1 control-label">Colonia:</label>
									<div class="col-xs-3" id="divCol">
										<select class="form-control m-bot15" id="ddlColonia">
											<option value="-2" selected = "selected">Seleccione</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-xs-2 pull-right">
										<button type="button" onClick="BuscaCorresponsales();" class="btn btn-guardar pull-right">Buscar&nbsp;<i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
						</div>

						<div class="panel-body" id="divRESParent">
							<div id="divRES" class="adv-table">
							</div><!--divRES-->
							<!-- class="col-lg-3 col-lg-offset-3"-->
							<div id="emergente"  class="col-md-9 col-md-offset-2">
								<img alt='Cargando...' src='../img/cargando3.gif' id='imgcargando' />
							</div>
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
<script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Cierre del Sitio-->                             

<script src="../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../assets/data-tables/DT_bootstrap.js"></script>
<!--Script-->
<script src="../inc/js/_PrealtasDataTablesEditables.js"></script>
<script src="../inc/js/RE.js" type="text/javascript"></script>
<script src="../inc/js/_Clientes.js" type="text/javascript"></script>
<script src="../inc/js/MenuConsulta.js" type="text/javascript"></script>
<script src="../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>    
<link rel="stylesheet" href="../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />

<script>

$(":input").bind('paste', function(){return false;});

$(function(){
	$("a[tag]").on('click', function(){
		var targ = $(event.target);
		$("img[tag]").attr('style', '');
		$(targ).attr('style', 'opacity:0.6;');
	});
});


</script>

</body>
</html>
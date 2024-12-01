<?php
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];

include($PATH_PRINCIPAL."/inc/config.inc.php");
include($PATH_PRINCIPAL."/inc/session.inc.php");
$PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

$submenuTitulo = "Usuarios";
$subsubmenuTitulo = "Editar";

$idUsuario = (isset($_GET["id"]))?($_GET["id"]):(-1);

if ( $idUsuario <= 0 ) {
	header("Location: Listado.php");
	exit();
}

$tipoDePagina = "Escritura";
$idOpcion = 29;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( $_SESSION['MiSuerte'] ) {
	$idPortal = 1;
}

$oUsuarios = new Usuarios ( $RBD, $WBD );
$oUsuarios->load ( $idUsuario, $idPortal );
$oPermisos = new Permisos ( $RBD, $WBD );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META http-equiv="Content-Type" content="text/html; charset="Windows-1252">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <title>Usuario Detalle</title>
    <!--Favicon-->
<link rel="icon" href="../../../img/favicon.ico" type="image/x-icon">
<!-- Núcleo BOOTSTRAP -->
<link rel="stylesheet" href="../../../css/themes/base/jquery.ui.all.css" />

<link href="../../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../../css/bootstrap-reset.css" rel="stylesheet">
<link href="../../../css/style-autocomplete.css" rel="stylesheet">
<link href="../../../css/jquery.alerts.css" rel="stylesheet">
<link href="../../../css/jquery.powertip.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../../css/miredgen.css" rel="stylesheet">
<link href="../../../css/style-responsive.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="../../../assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="<?php echo $PATHRAIZ?>/assets/data-tables/DT_bootstrap.css" />

    <link href="../../../css/bootstrap.css" rel="stylesheet">
    <link href="../../../css/tm_docs.css" rel="stylesheet">
    <!-- <link href="../../../css/RE-CSS.css" rel="stylesheet" type="text/css" /> -->
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
	<link href="../../../css/themes/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
  	<style>
		.ui-tabs-vertical { width: 100%; }
		.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 15%; }
		.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
		.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
		.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
		.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float:left; width: 85%;}
		.submenu { background-color: #D3D6FF; }
    </style>
	<link href="../../../css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("../../../inc/cabecera2.php"); ?>
<?php include("../../../inc/menu.php"); ?>
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="panel panelrgb">
            <div class="titulorgb-prealta">
                <span><i class="fa fa-users"></i></span>
                <h3>Usuario Detalle</h3>
                <span class="rev-combo pull-right">Usuario<br/>Detalle</span>
            </div>
            <div class="panel-body">
	            <a href="Listado.php">Regresar</a>

				<div id="tabs">
				    <ul>
				        <li><a href="#Datos-Generales" style="width:100%;display:block;">Datos Generales</a></li>
				        <?php
							$resultado = NULL;
							$resultado = $oPermisos->getMenu($idPortal);
							if ( $resultado != NULL ) {
								$menus = $resultado['data'];
								$tabs = "";
								for ( $i = 0; $i < count($menus['id']); $i++ ) {
									$tabs .= "<li><a style=\"width:100%;display:block;\" href=\"#m-{$menus['id'][$i]}\">".htmlentities($menus['nombre'][$i])."</a></li>";
								}
								echo $tabs;
							}
						?>
				    </ul>
				    <div id="Datos-Generales">
				        <h3 style="margin:0px;font-family:Arial;color:#35659d;">Datos Generales</h3>
				        <br/>
				        <table>
				            <tr>
				        		<td width="100" align="center">
				        			<input type="radio" id="cbActivo"
										<?php if($oUsuarios->getStatus() == 0){ echo 'checked="checked"'; }?> name="rdbStatus" />
				        			<label for="cbActivo"><strong id="lbl">Activo</strong></label>
				        		</td>
				        		<td width="100" align="center">
				        			<input type="radio" id="cbInactivo"
										<?php if($oUsuarios->getStatus() == 1){ echo 'checked="checked"'; }?> name="rdbStatus" />
				        			<label for="cbInactivo"><strong id="lbl">Inactivo</strong></label>
				        		</td>
				        	</tr>
				            <tr>
				            	<td colspan="3"><div class="separador" style="float:left; width:96%; margin-left:2%"></div></td>
				            </tr>
				        </table>
				        <table style="padding-left:5.5em;text-align:justify;">
				        	<tr>
				                <td width="200"><strong>Id</strong></td>
				                <td width="20">&nbsp;</td>
				                <td width="200"><?php echo $oUsuarios->getIdUsuario(); ?>
				                <input type="hidden" id="txtId" name="txtId" value="<?php echo $oUsuarios->getIdUsuario(); ?>" />
				                </td>
				            </tr>
				            <tr>
				                <td><strong>Nombre</strong></td>
				                <td>&nbsp;</td>
				                <td><?php echo utf8_decode($oUsuarios->getNombreUsuario()); ?></td>
				            </tr>
				          	<tr>
				            	<td><strong>Apellido Paterno</strong></td>
				            	<td>&nbsp;</td>
				            	<td><?php echo utf8_encode($oUsuarios->getPaternoUsuario()); ?></td>
				          	</tr>
				            <tr>
				                <td><strong>Apellido Materno</strong></td>
				                <td>&nbsp;</td>
				                <td>
				                <input type="text" id="txtApellidoM" name="txtApellidoM"
				                	value="<?php echo utf8_encode($oUsuarios->getMaternoUsuario()); ?>" class="textfield"/>
				                </td>
				            </tr>
				            <tr>
				                <td><strong>Correo</strong></td>
				                <td>&nbsp;</td>
				                <td><?php echo $oUsuarios->getcorreo(); ?></td>
				            </tr>
				            <tr>
				            	<td><strong>Tipo de Perfil</strong></td>
				                <td>&nbsp;</td>
				                <td>
				                	<?php
										//echo $idPortal;
										$idPerfil =   $oUsuarios->getidPerfil();
										$resultado = NULL;
										$sql = "SELECT `idPerfil`, `nombre`												
												FROM `data_acceso`.`cat_perfil`
												WHERE `idPortal` = $idPortal
												AND `idEstatus` = 0;";
										//$resultado = $RBD->query($sql);
										$resultado = $MRDB->query($sql);

										//echo var_dump($oUsuarios);
										//$idPerfil= 1;

										if ( $resultado != NULL ) {
											$lista = "<select id='ddlTipo' style='width:100%' class='textfield'>";
											if ( $idPerfil == -1 ) {
												$lista .= "<option value='-1' selected='selected'>Sin Perfil</option>";
											} else {
												$lista .= "<option value='-1'>Sin Perfil</option>";
											}
											while ( $r = mysqli_fetch_array($resultado) ) {
												if ( $r['idPerfil'] == $idPerfil )
													$lista.="<option value='".$r['idPerfil']."' selected='selected'>".$r['nombre']."</option>";
												else
													$lista.="<option value='".$r['idPerfil']."'>".htmlentities($r['nombre'])."</option>";
											}
											$d.="</select>";
											echo $lista;
										}
										$resultado->free();
									?>
				                <input type="hidden" id="txtIdPerfil" name="txtIdPerfil" value="<?php echo $oUsuarios->getidPerfil(); ?>" />
				                </td>
				            </tr>
				        </table>
				    </div>
				    <?php
						$resultado_opciones = NULL;
						$resultado_permisos = NULL;
						$resultado_opciones = $oPermisos->getOpciones($idPortal);
						$resultado_permisos = $oPermisos->getPermisos($idUsuario, $idPerfil, $idPortal);
						if ( $resultado_opciones != NULL && $resultado_permisos != NULL ) {
							$opciones = $resultado_opciones['data'];
							//var_dump($opciones['opcion'][42]);
							$opcionIndex = 0;
							if ( $resultado_permisos['codigoRespuesta'] == 0 ) {
								$permisos = $resultado_permisos['data'];
							} else if ( $resultado_permisos['codigoRespuesta'] == 1 ) {
								$permisos = -500;
							}
							//$permisos = $resultado_permisos['data'];
							if ( $opciones != NULL ) {
								for ( $menuIndex = 0; $menuIndex < count($menus['id']); $menuIndex++ ) {
									$menuContenido = "<div id=\"m-{$menus['id'][$menuIndex]}\">";

									$menuContenido .= "<h3 style=\"margin:0px;color:#35659d;font-family:Arial\">Seleccione los permisos del men&uacute; {$menus['nombre'][$menuIndex]}</h3>";
									$menuContenido .= "<div class=\"separador\" style=\"float:left; width:96%; margin-left:2%\"></div>";
									$menuContenido .= "<table align=\"center\" class=\"opciones\" cellspacing=\"0\" style=\"table-layout:fixed;\">";
									$menuContenido .= "<thead>";
									$menuContenido .= "<tr style=\"background-color:#6897cc;color:white;\">";
									$menuContenido .= "<th style=\"border-bottom-width:0px;\">Opciones</th>";
									$menuContenido .= "<th style=\"border-bottom-width:0px;\">Lectura</th>";
									$menuContenido .= "<th style=\"border-bottom-width:0px;\">Escritura</th>";
									$menuContenido .= "<th style=\"border-bottom-width:0px;\">Bloqueado</th>";
									$menuContenido .= "</thead>";
									$menuContenido .= "</tr>";
									$menuContenido .= "</thead>";
									$menuContenido .= "<tbody>";
									while ( $opciones['idMenu'][$opcionIndex] == $menus['id'][$menuIndex] ) {
										$idSubmenu = $opciones['idSubmenu'][$opcionIndex];
										if ( $idSubmenu != -1 ) {
											$menuContenido .= "<tr>";
											$menuContenido .= "<td style=\"padding-left:2.7em;text-align:justify;\">
																<strong>".htmlentities($opciones['submenu'][$opcionIndex])."</strong></td>";
											$menuContenido .= "<td></td>";
											$menuContenido .= "<td></td>";
											$menuContenido .= "<td></td>";
											$menuContenido .= "</tr>";
											while ( $opciones['idSubmenu'][$opcionIndex] == $idSubmenu ) {
												if ( $idSubmenu == 2 ) {
													//echo $opcionIndex." ";
													//echo $opciones['opcion'][$opcionIndex];
												}
												$esLectura = "";
												$esEscritura = "";
												$esBloqueado = "";
												if ( esSoloLecturaOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
													$esLectura = "checked=\"checked\"";
												} else if ( esLecturayEscrituraOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
													$esEscritura = "checked=\"checked\"";
												} else if ( estaBloqueadoOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
													$esBloqueado = "checked=\"checked\"";
												}
												$menuContenido .= "<tr>";
												$menuContenido .= "<td style=\"padding-left:4em;text-align:justify;\">".htmlentities($opciones['opcion'][$opcionIndex])."</td>";
												$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-lectura\"
																		name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																		class=\"opcion\"  $esLectura /></td>";
												$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-escritura\"
																		name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																		class=\"opcion\" $esEscritura /></td>";
												$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-bloqueado\"
																		name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																		class=\"opcion\" $esBloqueado /></td>";
												$menuContenido .= "</tr>";
												$opcionIndex++;
											}
											$opcionIndex_temp = $opcionIndex;
											$opcionIndex_temp++;
										} else if ( $idSubmenu == -1 ) {
											$esLectura = "";
											$esEscritura = "";
											$esBloqueado = "";
											if ( esSoloLecturaOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
												$esLectura = "checked=\"checked\"";
											} else if ( esLecturayEscrituraOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
												$esEscritura = "checked=\"checked\"";
											} else if ( estaBloqueadoOpcion($opciones['idOpcion'][$opcionIndex], $permisos) ) {
												$esBloqueado = "checked=\"checked\"";
											}
											$menuContenido .= "<tr>";
											$menuContenido .= "<td style=\"padding-left:2.7em;text-align:justify;\">".htmlentities($opciones['opcion'][$opcionIndex])."</td>";
											$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-lectura\"
																	name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																	class=\"opcion\" $esLectura /></td>";
											$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-escritura\"
																	name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																	class=\"opcion\" $esEscritura /></td>";
											$menuContenido .= "<td><input type=\"radio\" id=\"op-{$opciones['idOpcion'][$opcionIndex]}-bloqueado\"
																	name=\"op-{$opciones['idOpcion'][$opcionIndex]}-permiso\"
																	class=\"opcion\" $esBloqueado /></td>";
											$menuContenido .= "</tr>";
											$opcionIndex++;
										}
									}
									$menuContenido .= "</tbody>";
									$menuContenido .= "</table>";
									$menuContenido .= "</div>";
									echo $menuContenido;
								}
							}
						}
					?>
				</div>

                <div class="row">
                    <button type="button" onclick="UpdateUsuario(<?php echo "$idPortal"; ?>)" class="btn btn-guardar pull-right">Guardar</i></button>
                </div>
	            <div id="divRES" class="divRES centrar"></div>
	        </div>
	    </div>
	</section>
</section>

<div id='emergente'>
	<img alt='Cargando...' src='../../../img/cargando3.gif' id='imgcargando' />
</div>

<script src="../../../inc/js/jquery.js"></script>
<script src="../../../inc/js/bootstrap.min.js"></script>
<script src="../../../inc/js/jquery-1.9.1.js" type="text/javascript"></script>
<script src="../../../inc/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="../../../inc/js/_Admin.js" type="text/javascript"></script>
<!--<script type="text/javascript" language="javascript" src="../../../inc/js/jquery.dataTables.min.js"></script>-->
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<script src="../../../inc/js/RE.js" type="text/javascript"></script>
	<script>
		$(function() {
			$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
			$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
			$( '.opciones' ).dataTable({
				"aLengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
				"iDisplayLength": -1,
				"bSort": false,
				"bFilter": false,
				"bInfo": false,
				"bPaginate": false
			});
			var opcionesOriginales = $( '.opcion:checked' );
			$( '#ddlTipo' ).change(function() {
				var idPerfilOriginal = $( '#txtIdPerfil' ).val();
				var idPerfilSeleccionado = $( '#ddlTipo' ).val();
				if ( idPerfilSeleccionado != idPerfilOriginal ) {
					$( '.opcion' ).removeAttr('checked');
				} else {
					opcionesOriginales.each(function(){
						var id = $(this).attr('id');
						$(this).prop('checked', true);
					});
				}
			});
		});
	</script>

<script class="include" type="text/javascript" src="../../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../../inc/js/respond.min.js" ></script>
<!--<script type="text/javascript" src="../../../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>-->
<!--Generales-->
<script src="../../../inc/js/common-scripts.js"></script>
<script src="../../../inc/js/common-custom-scripts.js"></script>
<script type="text/javascript">
	BASE_PATH = '<?php echo $PATHRAIZ;?>';
</script>
</body>

</html>
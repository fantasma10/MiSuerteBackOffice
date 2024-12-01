<?php 
/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreSubCadena.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="SubCadena";

$idSubCadena = (isset($_GET['id'])) ? $_GET['id'] : -1;
if(!isset($_SESSION['idPreSubCadena']) && $idSubCadena == -1){
   header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}else if(isset($_SESSION['idPreSubCadena']) && $idSubCadena == -1){
    $idSubCadena = $_SESSION['idPreSubCadena'];
}
$oSubcadena = new XMLPreSubCad($RBD,$WBD);
$oSubcadena->load($idSubCadena);

if($oSubcadena->getExiste()){
    $_SESSION['idPreSubCadena'] = $idSubCadena;//si existe la pre-cadena guardamos el valor en session
} else {
    header('Location: ../../index.php');//redireccionar no existe la pre-cadena
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Pre Alta de Sub Cadena</title>
<!-- Núcleo BOOTSTRAP -->
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../../css/miredgen.css" rel="stylesheet">
<link href="../../css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" href="../../css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" />
<style>
	.ui-autocomplete {
		max-height: 190px;
		overflow-y: auto;
		overflow-x: hidden;
		font-size: 12px;
	}	
</style>
<script src="../../inc/js/jquery.js"></script>
<script src="../../inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
<script src="../../inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script src="../../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreSubCadena.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		if ( $("#txtNombreCadena").length ) {
			$("#txtNombreCadena").autocomplete({
				source: function( request, respond ) {
					$.post( "../../inc/Ajax/AutoCadenaNom.php", { "cadena": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#txtNombreCadena").val(ui.item.nombre);
					return false;
				},
				select: function( event, ui ) {
					$("#cadenaID").val(ui.item.idCadena);
					//alert("idGrupo: " + ui.item.idGrupo);
					$("#ddlGrupo").val(ui.item.idGrupo);
					$("#ddlGrupo").prop("disabled", true);
					VerificarGrlsSub();
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + item.nombre + "</a>" )
				.appendTo( ul );
			};
		}	
	});
</script>
<!--Cierre del Sitio--> 
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<!--Include Cuerpo, Contenedor y Cabecera-->
<?php include("../../inc/cabecera2.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Menú Vertical---->
<!--Función "Include" del Menú-->
<?php include("../../inc/menu.php"); ?>
<!--Final del Menú Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Función Include del Contenido Principal-->
<?php include("../../inc/main.php"); ?>
<!--Inicio del Contenido-->
<section class="panel">
  <div class="titulorgb-prealta">
<span><i class="fa fa-file-o"></i></span>
<h3><?php echo $oSubcadena->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Sub Cadena</span></div>
<div class="panel-body">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px; margin-top:20px;">
                    <tbody><tr>
                     <td align="center" valign="middle">&nbsp;</td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(0, existenCambios)">
                        	<img src="../../img/h.png" id="home">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(1, existenCambios)">
                        	<img src="../../img/1a.png" id="paso1Actual">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(2, existenCambios)">
                        	<img src="../../img/2.png" id="paso2">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(3, existenCambios)">
                        	<img src="../../img/3.png" id="paso3">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(4, existenCambios)">
                        	<img src="../../img/4.png" id="paso4">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(5, existenCambios)">
                        	<img src="../../img/5.png" id="paso5">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(6, existenCambios)">
                        	<img src="../../img/6.png" id="paso6">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(7, existenCambios)">
                       		<img src="../../img/7.png" id="paso7">
                        </a>
                      </td>
                      <td align="center" valign="middle">
                      	<a href="#" onClick="CambioPagina(8, existenCambios)">
                        	<img src="../../img/r.png" id="resumen">
                        </a>
                      </td>
                      <td align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </tbody></table>
<div class="legend-big"><i class="fa fa-book"></i> Datos Generales</div>
<!--Forma-->
<form class="form-horizontal">
<div class="form-group">  
<label class="col-lg-1 control-label">*Cadena:</label>
<div class="col-lg-3">
<input type="text" class="form-control" id="txtNombreCadena"
onKeyPress="VerificarGrlsSub();"
onkeyup="VerificarGrlsSub();" value="<?php
if ( !preg_match('!!u', $oSubcadena->getNombreCadena()) ) {
	echo trim(utf8_encode($oSubcadena->getNombreCadena()));
} else {
	echo trim($oSubcadena->getNombreCadena());
}
?>" placeholder="" maxlength="100">
<input type="hidden" id="cadenaID" value="<?php echo ($oSubcadena->getIdCadena() >= 0)? $oSubcadena->getIdCadena() : ''; ?>" />
</div>
</div>

<div class="form-group"> 
<label class="col-lg-1 control-label">*Grupo:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" id="ddlGrupo" onChange="VerificarGrlsSub();" disabled>
    <option value="-1">Sin Grupo</option>
    <?php
        $idGrupo = $oSubcadena->getIdGrupo();
		$sql = "CALL `redefectiva`.`SP_LOAD_GRUPOS`();";
        $res = $RBD->SP($sql);
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                while($r = mysqli_fetch_array($res)){
					if ( !preg_match('!!u', $r[1]) ) {
						//el string no es utf-8
						$r[1] = utf8_encode($r[1]);
					}					
					if ( $r[0] == $idGrupo ) {
                    	echo "<option value='$r[0]' selected=\"selected\">$r[1]</option>";
					} else {
						echo "<option value='$r[0]'>$r[1]</option>";
					}
                }
            }
        }
    ?>
</select>
</div>

<label class="col-lg-1 control-label">*Referencia:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" id="ddlReferencia" onChange="VerificarGrlsSub();">
    <option value="-1">Seleccione una Referencia</option>
	<?php
        $idReferencia = $oSubcadena->getIdReferencia();
		$sql = "CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();";
        $res = $RBD->SP($sql);
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                while($r = mysqli_fetch_array($res)){
					if ( !preg_match('!!u', $r[1]) ) {
						//el string no es utf-8
						$r[1] = utf8_encode($r[1]);
					}
					if ( $idReferencia != "" && isset($idReferencia) ) {					
						if ( $idReferencia == $r[0] ) {
							echo "<option value='$r[0]' selected=\"selected\">$r[1]</option>";
						} else {
							echo "<option value='$r[0]'>$r[1]</option>";
						}
					} else {
						if ( $r[0] == 1 ) {
							echo "<option value='$r[0]' selected=\"selected\">$r[1]</option>";
						} else {
							echo "<option value='$r[0]'>$r[1]</option>";
						}
					}
                }
            }
        }
    ?>
</select>
</div>
</div>

<div class="form-group"> 
<label class="col-lg-1 control-label">Teléfono:</label>
<div class="col-lg-3">
<input type="text" class="form-control" id="txttel1"
value="<?php echo $oSubcadena->getTel1() != '' ? $oSubcadena->getTel1() : ''; ?>"
onkeyup="validaTelefono2(event,'txttel1');VerificarGrlsSub();"
onfocus="RellenarTelefono()"
onkeypress="return validaTelefono1(event,'txttel1');VerificarGrlsSub();" maxlength="15"
placeholder="">
</div>

<label class="col-lg-1 control-label">Correo:</label>
<div class="col-lg-3">
<input type="text" class="form-control" id="txtmail"
value="<?php echo $oSubcadena->getCorreo(); ?>" onKeyPress="VerificarGrlsSub();"
onKeyUp="VerificarGrlsSub();" placeholder="" maxlength="100">
</div>
</div>
</form>
<br>
<!--Botón-->
   <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
<button type="button" class="btn btn-success" id="guardarCambios"
style="margin-top:10px;" disabled onClick="EditarGrlsPreSubCadena()">
Guardar
</button> 
</div>
<!--Botónes-->

<div class="col-lg-12 col-sm-12 col-xs-12">

<div class="pull-left">
<a href="#" onClick="CambioPagina(0, existenCambios);">
	<img src="../../img/atras.png" id="atras">
</a>
</div>                              


<div class="pull-right">
<a href="#" onClick="CambioPagina(2, existenCambios);">
	<img src="../../img/adelante.png" id="adelante">
</a>
</div>                               
</div>
<!--Cierre-->
</div>
</div>
</section>
</section>
<!--*.JS Generales-->
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/bootstrap.min.js"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>                           
</body>
</html>
<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");
include("../../inc/obj/XMLPreCorresponsal.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo ="Corresponsal";

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

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
<title>.::Mi Red::. Pre Alta de Corresponsal</title>
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
<!--Generales-->
<script src="../../inc/js/RE.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaScriptsComunes.js" type="text/javascript"></script>
<script src="../../inc/js/_PrealtaPreCorresponsal.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
		if ( $("#txtNombreCadena").length ) {
			$("#txtNombreCadena").autocomplete({
				source: function( request, respond ) {
					$.post( "../../inc/Ajax/AutoCadenaNomPreCorresponsal.php", { "cadena": request.term },
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
					$("#txtNombreSubCadena").prop("disabled", false);
					$("#ddlGrupo").val(ui.item.idGrupo);
					$("#ddlGrupo").prop("disabled", true);
					//VerificarGrlsSub();
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
<script>
	$(document).ready(function() {
		var cadena = $("#cadenaID").val();
		cadena = cadena.split("-");
		var cadenaID = cadena[0];
		var subcadena = $("#subcadenaID").val();
		subcadena = subcadena.split("-");
		var subcadenaID = subcadena[0];
		if ( cadenaID != null && cadenaID != "" && subcadenaID != null && subcadenaID != "" ) {
			desplegarVersiones(cadenaID, subcadenaID, subcadena[1]);		
		}
		if ( $("#txtNombreSubCadena").length ) {
			$("#txtNombreSubCadena").autocomplete({
				source: function( request, respond ) {
					cadenaID = $("#cadenaID").val();
					$.post( "../../inc/Ajax/AutoSubCadenaNom.php", { "subcadena": request.term, "cadenaID": cadenaID },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#txtNombreSubCadena").val(ui.item.nombre);
					return false;
				},
				select: function( event, ui ) {
					$("#subcadenaID").val(ui.item.idSubCadena);
					//VerificarGrlsSub();
					cadena = $("#cadenaID").val();
					cadena = cadena.split("-");
					cadenaID = cadena[0];
					subcadena = $("#subcadenaID").val();
					subcadena = subcadena.split("-");
					subcadenaID = subcadena[0];
					if ( cadenaID != null && cadenaID != "" && subcadenaID != null && subcadenaID != "" ) {
						desplegarVersiones(cadenaID, subcadenaID, subcadena[1]);		
					}
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
<h3><?php echo $oCorresponsal->getNombre(); ?></h3><span class="rev-combo pull-right">Pre Alta<br>Corresponsal</span></div>
                          
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
<input type="text" id="txtNombreCadena" class="form-control" placeholder=""
maxlength="50"
onkeypress="ocultarVersion();validarCamposGenerales();"
onkeyup="ocultarVersion();validarCamposGenerales();"
value="<?php
$nombreCadena = $oCorresponsal->getNombreCadena();
if ( !preg_match('!!u', $nombreCadena) ) {
	//no es utf-8
	$nombreCadena = utf8_encode($nombreCadena);
}
echo $nombreCadena;
?>">
<input type="hidden" id="cadenaID" value="<?php echo ($oCorresponsal->getIdCadena() >= 0)? $oCorresponsal->getIdCadena() : ''; ?>" />
</div>

<label class="col-lg-1 control-label">*SubCadena:</label>
<div class="col-lg-3">
<input type="text" id="txtNombreSubCadena" class="form-control" placeholder=""
maxlength="50"
onkeypress="ocultarVersion();validarCamposGenerales();"
onkeyup="ocultarVersion();validarCamposGenerales();"
value="<?php
$nombreSubCadena = $oCorresponsal->getNombreSubCadena();
if ( !preg_match('!!u', $nombreSubCadena) ) {
	//no es utf-8
	$nombreSubCadena = utf8_encode($nombreSubCadena);
}
echo $nombreSubCadena;
?>"
<?php
	if ( $oCorresponsal->getIdCadena() <= 0 || $oCorresponsal->getIdCadena() == '' ) {
		echo "disabled";
	}
?>>
<input type="hidden" id="subcadenaID" value="<?php echo ($oCorresponsal->getIdSubCadena() >= 0)? $oCorresponsal->getIdSubCadena()."-".$oCorresponsal->getTipoSubCadena() : ''; ?>" />
</div>
</div>
</form>


<form class="form-horizontal">
<div class="form-group"> 
<label class="col-lg-1 control-label">*Grupo:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" name="ddlGrupo" id="ddlGrupo"
onchange="validarCamposGenerales();" disabled>
<option value="-1">Selecciona un Grupo</option>
<?php
	$z = $oCorresponsal->getIdGrupo();
	$sql = "CALL `redefectiva`.`SP_LOAD_GRUPOS`();";
	$res = $RBD->SP($sql);
	if($RBD->error() == ''){
		if($res != '' && mysqli_num_rows($res) > 0){
			while($r = mysqli_fetch_array($res)){
				if ( !preg_match('!!u', $r[1]) ) {
					//no es utf-8
					$r[1] = utf8_encode($r[1]);
				}			
				if($z == $r[0])
					echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
				else
					echo "<option value='$r[0]' >$r[1]</option>";
			}
		}
	}
	else{
		echo $RBD->error();
	}
?>
</select>
</div>

<label class="col-lg-1 control-label">*Referencia:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" name="ddlReferencia" id="ddlReferencia"
onchange="validarCamposGenerales();">
<option value="-1">Seleccione una Referencia</option>
<?php
    $z = $oCorresponsal->getIdReferencia();
    $sql = "CALL `redefectiva`.`SP_LOAD_REFERENCIAS`();";
    $res = $RBD->SP($sql);
    if($RBD->error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            while($r = mysqli_fetch_array($res)){
				if ( !preg_match('!!u', $r[1]) ) {
					//no es utf-8
					$r[1] = utf8_encode($r[1]);
				}		
                if ( $z != "" && isset($z) ) {
					if($z == $r[0])
						echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
					else
						echo "<option value='$r[0]' >$r[1]</option>";
				} else {
					if ($r[0] == 1)
						echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
					else
						echo "<option value='$r[0]' >$r[1]</option>";
				}
            }
        }
    }
?>
</select>
</div>
</div>



<div id="versiones">
</div>

<div class="form-group">  
<label class="col-lg-1 control-label">*Giro:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" id="ddlGiro" onChange="validarCamposGenerales();">
<option value="-1">Seleccione un Giro</option>
<?php
$z = $oCorresponsal->getIdGiro();
$sql = "CALL `redefectiva`.`SP_LOAD_GIROS`();";
$res = $RBD->query($sql);
if($RBD->error() == ''){
    if($res != '' && mysqli_num_rows($res) > 0){
        $sel = "";
        
        while($r = mysqli_fetch_array($res)){
			if ( !preg_match('!!u', $r[1]) ) {
				//no es utf-8
				$r[1] = utf8_encode($r[1]);
			}
            if($z == $r[0])
                echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
            else
                echo "<option value='$r[0]' >$r[1]</option>";
        }
    }
}
?>
</select>
</div>

<label class="col-lg-1 control-label">No.Sucursal:</label>
<div class="col-lg-3">
<input type="text" name="txtNumSucursal" id="txtNumSucursal"
maxlength="15"
class="form-control" placeholder=""
value="<?php echo $oCorresponsal->getNumSucu();?>"
onkeypress="validarCamposGenerales();"
onkeyup="validarCamposGenerales();">
</div>

<label class="col-lg-1 control-label">Nombre Sucursal:</label>
<div class="col-lg-3">
<input type="text" class="form-control" placeholder=""
onkeypress="validarCamposGenerales();"
onkeyup="validarCamposGenerales();"
maxlength="20"
name="txtNomSucursal" id="txtNomSucursal"
value="<?php echo $oCorresponsal->getNomSucu();?>">
</div>
</div>

<div class="form-group">  
<label class="col-lg-1 control-label">*Tel&eacute;fono:</label>
<div class="col-lg-3">
<input type="text" name="txttel1" id="txttel1"
class="form-control" placeholder=""
onkeyup="validaTelefono2(event,'txttel1');validarCamposGenerales();"
onkeypress="validarCamposGenerales();return validaTelefono1(event,'txttel1');"
onfocus="RellenarTelefono()"
value="<?php echo ($oCorresponsal->getTel1() != "")?$oCorresponsal->getTel1():""; ?>"
maxlength="15">
</div>

<label class="col-lg-1 control-label">*Correo:</label>
<div class="col-lg-3">
<input type="text" name="txtmail" id="txtmail"
onkeypress="validarCamposGenerales();"
onkeyup="validarCamposGenerales();"
maxlength="100"
class="form-control" placeholder=""
value="<?php echo $oCorresponsal->getCorreo();?>">
</div>
</div>

<div class="form-group"> 
<label class="col-lg-1 control-label">*IVA:</label>
<div class="col-lg-3">
<select class="form-control m-bot15" name="ddlIva" id="ddlIva"
onchange="validarCamposGenerales();">
    <option value="-1">Seleccione un IVA</option>
    <?php
    $z = $oCorresponsal->getIva();
    $sql = "CALL `redefectiva`.`SP_LOAD_IVA`();";
    $res = $RBD->query($sql);
    if($RBD->error() == ''){
    if($res != '' && mysqli_num_rows($res) > 0){
        $sel = "";
        
        while($r = mysqli_fetch_array($res)){
            if($z == $r[0])
                echo "<option value='$r[0]' selected='selected' >$r[1]</option>";
            else
                echo "<option value='$r[0]' >$r[1]</option>";
        }
    }
    }                                     
    ?>
</select>
</div>
</div>
</form>
<!--button class="btn btn-medio" type="button" onClick="EditarGrlsPreCorresponsal()"
id="guardarCambios" disabled>
	Guardar
</button>
<div class="prealta-footer">
<button class="btn btn-default" type="button"
onClick="CambioPagina(2, false)">
	Siguiente
</button>
<button class="btn btn-success" type="button"
onClick="CambioPagina(0, false)">
	Anterior
</button>
<!--Botón-->

 <div class="col-lg-10 col-lg-offset-5 col-xs-10 col-sm-offset-5 col-xs-10 col-xs-offset-5" style="display:inline-block;">
			<button type="button" class="btn btn-success" id="guardarCambios" onClick="EditarGrlsPreCorresponsal()" style="margin-top:10px;" disabled>
				Guardar
			</button> 
			</div>

<!--Botón-->
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="pull-left">
				<a href="#" onClick="CambioPagina(0, false);">
			    	<img src="../../img/atras.png" id="atras">
			    </a>
			</div>

			

			<div class="pull-right">
				<a href="#" onClick="CambioPagina(2, false);">
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
<script src="../../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../../inc/js/jquery.scrollTo.min.js"></script>
<script src="../../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../../inc/js/respond.min.js" ></script>
<!--Generales-->
<script src="../../inc/js/common-scripts.js"></script>
<!--Cierre del Sitio-->                             
</body>
</html>
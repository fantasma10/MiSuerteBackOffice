<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");
$incr = $_POST['idincr'];

include("catalogos.php");
$submenuTitulo = "Pre-Alta";

$idOpcion = 129;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}
    
$idPerfil = $_SESSION['idPerfil'];
$usuario = $_SESSION['idU'];

$pais = $_POST['pais'];
$regimens = $_POST['regimen'];
$est = $_POST['estatus'];
	
?>

<!DOCTYPE html>
<html lang="es">
    <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Favicon-->
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
<title>.::Mi Red::. Clientes Registrados</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!--<link href="../css/style-autocomplete.css" rel="stylesheet">    -->
<link href="../css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">      
<!--<link href="../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />
<!--Estilos �nicos-->

<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
<link href="../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />  
        
     
  
    <link href="./css/bootstrap.css" rel="stylesheet">
    
   <!--<link href="./css/icons.css" rel="stylesheet">-->
  <link href="./css/material-design-iconic-font.css" rel="stylesheet">
  <link href="./css/table-responsive.css" rel="stylesheet">
    <link href="./js/toastmessage/src/main/resources/css/jquery.toastmessage.css" rel="stylesheet">
        
       <script >
            var est = <?php echo $est; ?>;
            var incre = <?php echo $incr; ?>; 
            var idpaisvar = <?php echo $pais; ?> ;
            var idregimenvar = <?php echo $regimens; ?> ;
            var usr = <?php echo $usuario; ?>
      
        </script>  
        
    <script src="./js/jquery-2.1.1.min.js" ></script>
     <!-- <script src="./js/jquery.autocomplete.js" ></script> -->
       <script src="../css/ui/jquery.ui.core.js"></script>
<script src="../css/ui/jquery.ui.widget.js"></script>
<script src="../css/ui/jquery.ui.position.js"></script>
<script src="../css/ui/jquery.ui.menu.js"></script>
   
    <script src="./js/ui/jquery.ui.autocomplete.js"></script> 
       
    <script src="./js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>
    
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
       
     <script src="./js/nuevoclienteSolicitud.js" ></script>
        
        
    
        
    </head>
<?php include("../inc/cabecera.php"); ?>
<!--Fin de la Cabecera-->
<!--Inicio del Men� Vertical---->
<!--Funci�n "Include" del Men�-->
<?php include("../inc/menu.php"); ?>
<!--Final del Men� Vertical----->
<!--Final de Barra Vertical Izquierda-->
<!--Contenido Principal del Sitio-->
<!--Funci�n Include del Contenido Principal-->
<?php include("../inc/main.php"); ?>
   <style>
       .mayusculas{
           text-transform: uppercase;
       } 
       .btn1{
           margin-top: 15px;
       }
       .btn2{display: none}
       #div-representanteLegal{display: none}
       .btnfin{margin:5px; display:none}
       #pdfvisor{
           display:none;
           height: 100%;
           width: 100%;
           position:fixed;
           background-color: rgba(255, 255, 255, 0.55);
           z-index: 1500;
       }
       #divpdf{
           
           height:80%;
           width:70%;
            
           margin-left:8%; 
            
         background-color:#e6e6e8;       
       }
       #divclosepdf{
         width:70%;
          margin-left:8%; 
           text-align: right;
       }
       #closepdf{
           color:red;
           font-size:20px;
           font-weight: bold;
           cursor: pointer;
           
       }
       
       .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
        border-bottom:none;
       }
       
       table thead {border:0px;}
       
       th {    background-size: contain;}
    .montos{width:70px; }
    
    	.ui-autocomplete-loading {
			background: white url('../img/loadAJAX.gif') right center no-repeat;
		}
    .ui-autocomplete {
			max-height	: 190px;
			overflow-y	: auto;
			overflow-x	: hidden;
			font-size	: 12px;
			background-color: white;
			color:black,
		}
       .ui-helper-hidden-accessible{
	       display:none;
	       }
	   .ui-menu-item{font-color:black}    
   </style> 
<?php include('./application/views/clientes/afiliacionexpress/modulos/Comisiones.php'); ?>
    <div id="pdfvisor">
        <div id="divclosepdf" ><span id="closepdf" title="Cerrar PDF">X</span></div>
        <div id="divpdf">
            
            <object id="pdfdata" data="" type="application/pdf" width="100%" height="100%"></object>
            
        </div>
    </div>
<section class="panel">    
  <div id="content" class="page-content clearfix">
	<div class="contentwrappers">
		<!--Content wrapper-->
		<div class="heading">
			<!--  .heading-->
            <a href="./registroCliente.php"><button type="button">Regresar</button></a> 
		
		</div> 
		    
			<form name="datosGenerales" id="formDatosGenerales">
                
                <div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				  <div class="panel-heading">
					<h4 class="panel-title">Datos Generales</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				 </div> 
				<div class="panel-body">  
					<div class="row ">
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">R.F.C.<span class="asterisco">*</span></label>
								<input type="text" class="form-controls" placeholder="MAHY670331HJI" disabled="" name="sRFC" id="txtRFC">
							</div>
						</div> 
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">Regimen Fiscal <span class="asterisco">*</span></label>
								<select class="form-control"   disabled=""  name="nIdRegimen" id="cmbRegimen"> 
									<option value="-1">--</option>
                                    <?php echo $regimen; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Cadena</label>
								<input type="text" class="form-control" name="sCadena" id="txtSCadena">
								<input type="hidden" name="nIdCadena" id="txtIdCadena">
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Socio</label>
								<select class="form-control" name="nIdSocio" id="cmbSocio">
									<option value="-1">--</option>
                                    <?php echo $socio; ?>
								</select>
							</div>
						</div>
					</div>
                        
					<?php 
                    
                     
						if($regimens == 1){
							include('./application/views/clientes/afiliacionexpress/modulos/datosgenerales_fisico.php');
						}
						if($regimens == 2){
							include('./application/views/clientes/afiliacionexpress/modulos/datosgenerales_moral.php');
						}
                    
					?>

					<div class="row">
						<div class="col-xs-2">
							<div class="form-group">
								<label class="">Teléfono<span class="asterisco">*</span></label>
								<input type="text" class="form-control" name="sTelefono" id="txtTelefono" placeholder="(00) 00-00-00-00">
							</div>
						</div> 
						<div class="col-xs-4">
							<div class="form-group">
								<label class="">Correo Electrónico</label>
								<input type="text" class="form-control" name="sEmail" id="txtEmail" placeholder="usuario@dominio.xyz">
							</div>
						</div> 
						<div class="col-xs-6">
							<div class="form-group">
								<label class="">Ejecutivo de Cuenta <span class="asterisco">*</span></label>
								<select class="has-error form-control" name="nIdEjecutivoCuenta" id="cmbEjecutivoCuenta">
									<option value="-1">--</option> 
                                    <?php echo $ejecutivo; ?>
								</select>
							</div>
						</div>
					</div>
					<?php
                    
                    
						if($pais == 164){
							include('./application/views/clientes/afiliacionexpress/modulos/datosgenerales_direccionnacional.php');
						}
						else {
							
                            include('./application/views/clientes/afiliacionexpress/modulos/datosgenerales_direccionextranjera.php');
						}
					?>
					<div class="row">
						<div class="col-xs-4"> 
							<label class="">R.F.C. <span class="asterisco">*</span></label><br>
							<input type="file" class="" style="display:inline-block;" name="sFileRFC" id="txtFileRFC" idtipodoc="2">
                            <input type="button" id="btnFileRfc" value="Ver Documento">
                            <br>
							<input type="hidden" class="" name="nIdDocRFC" id="txtIdDocRFC" idtipodoc="2"><br>
							<span class="help-text"></span>
						</div>
						<div class="col-xs-4"> 
                            <label class="">Comprobante Domicilio <span class="asterisco">*</span></label><br>
							<input type="file" class="" style="display:inline-block;" name="sFileComprobanteDomicilio" id="sFileComprobanteDomicilio" idtipodoc="1">
                            <input type="button" id="btnFileCompDom" value="Ver Documento">
                            <br>
							<input type="hidden" class="" name="nIdDocDomicilio" id="txtIdDocDomicilio" idtipodoc="1"><br>
							<span class="help-text"></span>
						</div>
					</div>
				</div>
                </div>    
			</form>
		</div>

		<?php
           
      if($regimens == 1){
				include('./application/views/clientes/afiliacionexpress/modulos/InformacionEspecial_Fisico.php');
			}
			else if($regimens == 2){
				include('./application/views/clientes/afiliacionexpress/modulos/InformacionEspecial_Moral.php');
			}
		
            include('./application/views/clientes/afiliacionexpress/modulos/Configuracion.php');
            include('./application/views/clientes/afiliacionexpress/modulos/Liquidacion.php');
            include('./application/views/clientes/afiliacionexpress/modulos/PaqueteComercial.php');
            include('./application/views/clientes/afiliacionexpress/modulos/DatosBancarios.php');
            include('./application/views/clientes/afiliacionexpress/modulos/Contactos.php');
            include('./application/views/clientes/afiliacionexpress/modulos/RepresentanteLegal.php');
		?>
		<button type="button" class="btn btn-primary btn-sm pull-right btnfin btnini" id="btnGuardarSolicitud">Guardar Solicitud</button>
      <button type="button" class="btn btn-primary btn-sm pull-right btnfin btnini" id="btnEliminarSolicitud">Eliminar Solicitud</button>
      <button type="button" class="btn btn-primary btn-sm pull-right btnfin" id="btnAutorizarSolicitud">Autorizar Solicitud</button>
      <button type="button" class="btn btn-primary btn-sm pull-right btnfin" id="btnValidarSolicitud">Validar Solicitud</button>
            
       	</div>     
	</div>
</div>

     
    </section>   
</div>
</div>
</section>
</section>                             
</body>
</html>
    </body>
</html>    

<!--*.JS Generales-->

<script src="../inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../inc/js/jquery.scrollTo.min.js"></script>
<script src="../inc/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="../inc/js/respond.min.js" ></script>
<script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
<!--Fechas-->

<script type="text/javascript" src="../assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!--Generales-->
<script src="../inc/js/common-scripts.js"></script>

<!--Tabla-->
<script src="../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../assets/data-tables/DT_bootstrap.js"></script>
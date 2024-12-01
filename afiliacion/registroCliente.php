

<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");


    
    include ('./application/models/Cat_pais.php');
    include ('./application/models/Cat_regimen.php');
  

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
<title>.::Mi Red::. Prospectos Registrados</title>
<!-- N�cleo BOOTSTRAP -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="../assets/opensans/open.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="../css/miredgen.css" rel="stylesheet">
<link href="../css/style-responsive.css" rel="stylesheet" />
<!--Estilos �nicos-->
<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" href="../assets/data-tables/DT_bootstrap.css" />
<link href="../assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="../assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    
    
    
      <!--<link href="./css/main.css" rel="stylesheet">-->
    <link href="./css/bootstrap.css" rel="stylesheet">
   <!--<link href="./css/icons.css" rel="stylesheet">-->
  <link href="./css/material-design-iconic-font.css" rel="stylesheet">
  <link href="./css/table-responsive.css" rel="stylesheet">
    <link href="./js/toastmessage/src/main/resources/css/jquery.toastmessage.css" rel="stylesheet">
    
      <script >
           
            var usr = <?php echo $usuario; ?>
       
        </script> 
      <script src="./js/jquery-2.1.1.min.js" ></script>
     <!--<script src="./js/jquery.dcjqaccordion.2.7.js" ></script>-->
    <script src="./js/jquery.mask.min.js" ></script>
     <script src="./js/common-scripts.js" ></script>
     <script src="./js/nuevocliente.js" ></script>
    <script src="./js/toastmessage/src/main/javascript/jquery.toastmessage.js" ></script>

<!--Cierre del Sitio-->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
    <style>
        div.botones{
            height:30px;
            width:80px;
            background-color: dodgerblue;
            color:white;
            display:inline-flex;
            margin: 10px;
            font-family: Verdana;
            cursor:pointer; 
        }
        p.pbtn{
            margin:5px 0px 10px 15px;
        }
        div.botones:hover{
            background-color: #0e3860;
        
        }
        div#pop1{
            height:100%;
            width:100%;
            position:fixed;
            z-index:100;
            background-color:rgba(173, 173, 250, 0.33);
            display: none;
        }
        p.popsley{
            color:darkred;
            font-family: Verdana;
            font-weight: bold;
            font-size:20px;
           
        }
        section#pannel1{
            
            display:none
        }
        span#nuevospn{
             cursor:pointer;
            background-color:#4474d0;   
            color:white;
        }
        span#nuevospn:hover{
             
            background-color:#a7c2f5;   
            color:#072e50;
        }
    </style>    
    
    <div id="pop1" >
        <center>
        <div style="height:200px;width:600px;background-color:white;margin-top:150px">
            <div style="height:150px">
                <div style="height:50px"></div>
                <p class="popsley">¿Desea Eliminar el Registro de este Prospecto?</p>
            </div>
            <div style="width:100%; background-color:#a7b7fc;">
                <center>
                    <div type="button" class="botones" id="btncan" ><p class="pbtn">Cancelar</p></div>
                    <div type="button" class="botones" id="btnarc" ><p class="pbtn">Eliminar</p></div>
                </center>    
            </div>
        
        </div>
        </center>
    </div>
<!--Include Cuerpo, Contenedor y Cabecera-->
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
<section class="panel" id="pannel1">
    <div id="content" class="page-content clearfix">
        <div class="contentwrappers">
            <form name="formBack" id="formModUno">
			<!--Content wrapper-->
		
			
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				<div class="panel-heading">
					<h4 class="panel-title">Registro de Prospecto</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-2">
							<div class="form-group">
								<label>País</label>
								<select class="form-control" id="cmbPais" name="nIdPais">
									<option value="-1">--</option>
                                    <option value="164">México</option>
                                    <option value="68">Estados Unidos</option>
                                    <?php //echo $htmlPais; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-2"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>Regimen Fiscal</label>
								<select class="form-control" id="cmbRegimen">
									<option value="-1">--</option>
                                    <?php echo $htmlRegimen; ?>
								</select>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-rfc">
								<label>R.F.C.</label>
								<input class="form-control mex" id="txtRFC" maxlength="13" name="sRFC"/>
							</div>
						</div>
						
						<div class="col-xs-4">
							<div class="form-group">
								<label>Correo</label>
								<input class="form-control" id="txtEmail" maxlength="150" name="sEmail"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Teléfono</label>
								<input class="form-control" id="txtTelefono" maxlength="" placeholder="(00) 00-00-00-00" name="sTelefono"/>
							</div>
						</div>
					</div>
					<div class="row"> 
						<div class="col-xs-3">
							<div class="form-group">
								<label>Nombre (s)</label>
								<input class="form-control nombre" id="txtNombre" maxlength="50" name="sNombre"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Apellido Paterno</label>
								<input class="form-control nombre" id="txtPaterno" maxlength="50" name="sPaterno"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Apellido Materno</label>
								<input class="form-control nombre" id="txtMaterno" maxlength="50" name="sMaterno"/>
							</div>
						</div>
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs " style="margin-top: 17px;margin-left: 2px;" id="btnRegistraCliente">Registrar</a>
						</div> 
						
					</div> 
                    <div class="row" style="width:100%;float:right  " > 
						
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs editar" style="margin-top: 17px;margin-left: 2px;" id="btnGuardaCliente">Guardar</a>
						</div> 
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs editar" style="margin-top: 17px;margin-left: 2px;" id="btnReenviaCorreo">Reenviar Mail</a>
                        </div> 
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs editar" style="margin-top: 17px;margin-left: 2px;" id="btnArchivarCte">Eliminar</a>
                        </div> 
                        <div class="col-xs-2 mt15"> 
							<a href="#" class="btn btn-info btn-xs editar" style="margin-top: 17px;margin-left: 2px;" id="btnNuevoCte">Nuevo</a>
                        </div> 
					</div> 
				</div>
			</div>

			<input type="hidden" class="form-control" name="backUrl" value="<?php //echo base_url();?>index.php/clientes/afiliacionexpress/cliente"/>
			<input type="hidden" class="form-control" name="nIdRegimen"/>
                <input type="hidden"  class="form-control" name="idincr" id="idincr"/> 
                <input type="hidden" class="form-control" name="txtmail" id="txtmail"/> 
                <input type="hidden" class="form-control" name="txtnomcom" id="txtnomcom"/> 
                <input type="hidden" class="form-control" name="txtcodval" id="txtcodval"/> 
	          
            </form>
        </div>
    
    </div>

</section>


<section class="panel">
<div class="titulorgb-prealta">
<span><i class="fa fa-search"></i></span>
<h3>Prospectos Registrados</h3><span id="nuevospn" class="rev-combo pull-right">Nuevo<br>Registro</span></div>
<div class="panel-bodys">
                                    <!--Inicio de Tabla Cadena-->
                                    <div class="adv-table">
                                    <table class="display table table-bordered table-striped" id="presubcadenas">
                                      <thead>
                                      <tr>
                                          <th>RFC</th>
                                          <th>Nombre</th>
                               
                                          <th>Correo Verificado</th>
                                       
                                       <th>Solicitud Enviada</th>
                                      
                                          <th>Editar</th>
                                      
                                          
                                      </tr>
                                      </thead>
                                      
                                      <tbody>
                                      <tr class="gradeA">
                                          <td> </td>
                                          <td> </td>
                                         
                                          <td width="120px" align="center"> </td>
                                      
                                          
                                         
                                          <td width="120px"> </td>
                                          <td width="120px"> </td>
                                         
                                        
                                      </tr>
                                      <tr class="gradeA">
                                        <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                          <td> </td>
                                         
                                       
                                        
                                      </tr>
                                      <tr class="gradeA">
                                            <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                        <td> </td>
                                        
                                     
                                      </tr>
                                      <tr class="gradeA">
                                           <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                         <td> </td>
                                          
                                      </tr>
                                      <tr class="gradeA">
                                       <td> </td>
                                          <td> </td>
                                         
                                          <td> </td>
                                      
                                          <td> </td>
                                         <td> </td>
                                        
                                      </tr>
                                      </tbody>
                          </table>

</div>
<!--Cierre Contenido-->
</div>
</section>    
<!--Cierre Main-->
</div>
</div>
</section>
</section>                             
</body>
</html>


<!--*.JS Generales-->
<!--<script src="../inc/js/jquery.js"></script>-->
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
<!--<script src="../inc/js/advanced-form-components.js"></script>-->
<!--Tabla-->
<script src="../assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script src="../assets/data-tables/DT_bootstrap.js"></script>
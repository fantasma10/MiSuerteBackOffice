<?php

  error_reporting(0);
  ini_set('display_errors', 0);

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");
if(!empty($_POST['consultaAfiliacion'])){
    $idOpcion = 61;
    $ESCONSULTA = true;
    $ESCONSULTASUCURSAL  = false;
  }
  else if(!empty($_POST['consultaSucursal'])){
    $idOpcion = 61;
    $ESCONSULTA = false;
    $ESCONSULTASUCURSAL  = true;
  }
  else{
    $idOpcion = 60;
    $ESCONSULTA = false;
    $ESCONSULTASUCURSAL  = false;
  }
$tipoDePagina = "Mixto";
if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
  header("Location: ../../../error.php");
  exit();
}
$submenuTitulo = "Nuevo Cliente";
$directorio = $_SERVER['HTTP_HOST'];
$PATHRAIZ = "https://".$directorio;
$idCliente = ( isset($_GET["idCliente"]) )? $_GET["idCliente"] : -500;
$idSucursal = (!empty($_POST['idSucursal']))? $_POST['idSucursal'] : 0;
$esEscritura = false;
if ( esLecturayEscrituraOpcion($idOpcion) ) {
  $esEscritura = true;
}
$esSubcadena = ( isset($_POST["esSubcadena"]) )? $_POST["esSubcadena"] : NULL;
$vieneDeNuevaSucursal = ( isset($_POST["vieneDeNuevaSucursal"]) )? $_POST["vieneDeNuevaSucursal"] : 0;
if ( empty($_POST["vieneDeNuevaSucursal"]) ) {
  $vieneDeNuevaSucursal = ( isset($_GET["ns"]) )? $_GET["ns"] : 0;
  $esSubcadena = ( isset($_GET["ns2"]) )? $_GET["ns2"] : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo $PATHRAIZ?>/img/favicon.ico" type="image/x-icon">
    <title>.::Mi Red::.Nueva Sucursal</title>
    <!-- Núcleo BOOTSTRAP -->
    <link rel="stylesheet" href="<?php echo $PATHRAIZ?>/css/themes/base/jquery.ui.all.css" />
    <link href="<?php echo $PATHRAIZ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--ASSETS-->
    <link href="<?php echo $PATHRAIZ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ?>/assets/opensans/open.css" rel="stylesheet" />
    <!-- ESTILOS MI RED -->
    <link href="<?php echo $PATHRAIZ?>/css/miredgen.css" rel="stylesheet">
    <link href="<?php echo $PATHRAIZ?>/css/style-responsive.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $PATHRAIZ?>/assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <style>
      .ocultarSeccion {
        display: none;
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
      .confCuenta{
        display: none;
        }
    .noesconsulta, .esconsulta, .esconsultas{
    display:  none;
    }
    </style>
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
        <div class="col-xs-12">
          <!--Panel Principal-->
          <div class="panelrgb">
            <div class="titulorgb-prealta">
              <span><i class="fa fa-users"></i></span>
            <h3>Afiliación Express</h3><span class="rev-combo pull-right">Afiliación<br>Express</span></div>
            <div class="panel">
              <div class="jumbotron">
                <div class="container">
                  <h2>Alta de Sucursales</h2>
                  <p>Llene los datos de la sucursal.</p>
                </div>
              </div>
              <div class="panel-body">
                <!--<div class="cliente-activo">
                  <span><i class="fa fa-user"></i> Cliente </span>
                  <h3 id="encabezadoCliente"></h3>
                </div>-->
                <div class="row">
                  <div class="col-xs-6">
                    <div class="cliente-activo">
                      <span><i class="fa fa-user"></i> Cliente</span>
                      <h3 id="encabezadoCliente"></h3>
                    </div>
                  </div>
                  
                  <div class="col-xs-6">
                    <div class="cliente-activo">
                      <span class="ocultarSeccion" id="textoFamilias"><i class="fa fa-shopping-cart"></i> Familias</span>
                      <h4 class="ocultarSeccion" id="encabezadoFamilias"></h4>
                    </div>
                  </div>
                </div>
                
                <div class="well">
                  <div class="titulosexpress-first">Datos Generales</div>
                  
                  <form class="form-horizontal" name="formGenerales" id="formGenerales">
                    <input type="hidden" name="idDireccion" id="idDireccion" value="0" />
                    <input type="hidden" name="origen" id="origen" value="1" />
                     <div class="form-group col-xs-8" style="margin-right:16px;">
                      <label class="control-label">Nombre de Sucursal:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="nombreCorresponsal" id="nombreCorresponsal">
                      </div>
                      
                      <div class="form-group col-xs-4">
                      <label class="control-label">Giro:</label>
                      <br/>
                        <select class="form-control m-bot15" name="idGiro" id="cmbGiro">
                        </select>
                      </div>
                      
                    
                     <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">País:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="txtPais" id="txtPais" value="M&eacute;xico">
                        <input type="hidden" class="form-control m-bot15" name="idPais" id="idPais" value="164">
                      </div>
                   
                   <div class="form-group col-xs-4">
                   </div>
                   
                   <div class="form-group col-xs-4">
                   </div>
                   
                    
                     <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Calle:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="calleDireccion" id="calleDireccion">
                      </div>
                      
                      
                       <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Número Interior:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="numeroIntDireccion" id="numeroIntDireccion">
                      </div>
                      
                       <div class="form-group col-xs-4">
                      <label class="control-label">Número Exterior:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="numeroExtDireccion" id="numeroExtDireccion">
                      </div>
                                       
                     <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Código Postal:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="cpDireccion" id="txtCP">
                        <input type="hidden" class="form-control m-bot15" name="idLocalidad" id="idLocalidad">
                      </div>
                      
                      <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Colonia:</label>
                      <br/>
                        <select class="form-control m-bot15" name="idcColonia" id="cmbColonia">
                          <option value="-1">Seleccione</option>
                        </select>
                    </div>
                    
                    
                     <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Estado:</label>
                      <br/>
                        <select class="form-control m-bot15" name="idcEntidad" id="cmbEstado" disabled>
                          <option value="-1">Seleccione</option>
                        </select>
                      </div>
                      
                      <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Ciudad:</label>
                      <br/>
                        <select class="form-control m-bot15" name="idcMunicipio" id="cmbMunicipio" disabled>
                          <option value="-1">Seleccione</option>
                        </select>
                      </div>
                    
                      <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Teléfono:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="telefono" id="txtTelefono" onKeyUp="validaTelefono2A(event,'txtTelefono')" onKeyPress="return validaTelefono1A(event,'txtTelefono')" value="">
                      </div>                   
                  </form>
                 </div>
                
                
                
                <div class="well">
                  <div class="titulosexpress-first">Contacto</div>
                  <form class="form-horizontal" name="formContacto" id="formContacto">
                    
                    <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Nombre(s):</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="nombreContacto" id="txtNombreContacto">
                      </div>
                      
                      <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Apellido Paterno:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="apellidoPaternoContacto" id="txtApellidoPaternoContacto">
                      </div>
                      
                      <div class="form-group col-xs-4">
                      <label class="control-label">Apellido Materno:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="apellidoMaternoContacto" id="txtApellidoMaternoContacto">
                      </div>
                    
                    <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Teléfono:</label>
                      <br/>
                        <!--<input type="text" class="form-control m-bot15" name="telefonoContacto" id="txtTelefonoContacto">-->
                        <input type="text" class="form-control m-bot15" name="telefonoContacto" id="txtTelefonoContacto" onKeyUp="validaTelefono2A(event,'txtTelefonoContacto')" onKeyPress="return validaTelefono1A(event,'txtTelefonoContacto')" value="">
                      </div>
                      
                      <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Extensión:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="extension" id="txtExtension">
                      </div>
                      
                      <div class="form-group col-xs-4">
                      <label class="control-label">Correo:</label>
                      <br/>
                        <input type="text" class="form-control m-bot15" name="correo" id="txtCorreo">
                      </div>
                   
                    
                    <div class="form-group col-xs-4" style="margin-right:16px;">
                      <label class="control-label">Tipo de Contacto:</label>
                      <br/>
                        <select class="form-control m-bot15" name="tipoContacto" id="cmbTipoContacto">
                        </select>
                      </div>
                      
                      <div class="form-group col-xs-4">
                      </div>
                      
                      <div class="form-group col-xs-4">
                      </div>
                      
                      <div class="col-xs-12 row pull-left" style="margin-top:20px;">
                        <a href="#" id="agregarContacto">Agregar Contacto</a>
                      </div>
                  
                    
                    
                  </form>
                </div>
                
                <table class="express ocultarSeccion" id="infoContactos">
                  <thead>
                    <tr>
                      <th class="first">Contacto</th>
                      <th class="">Teléfono</th>
                      <th class="">Extensión</th>
                      <th class="">Correo</th>
                      <th class="">Tipo de Contacto</th>
                      <th class="">Editar</th>
                      <th class="last">Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--<tr>
                      <td>Nombre de Contacto</td>
                      <td class="tdder">818030292</td>
                      <td class="tdder">117</td>
                      <td>nombredecorreo@correo.com.mx</td>
                      <td>Administración</td>
                      <td><i class="fa fa-pencil"></i></td>
                      <td><i class="fa fa-times"></i></td>
                    </tr>-->
                  </tbody>
                </table>
                
                
                
                
                <div class="well ocultarSeccion" id="seccionFORELO">
                  <!--<div class="titulosexpress-first"><i class="fa fa-dollar"></i> Comisiones y Reembolsos</div>
                  
                  <form class="form-horizontal" name="formFORELO" id="formFORELO">
                    
                    
                    <div class="form-group  margen">
                      <label class="col-xs-3 control-label">Liquidación de Comisiones:</label>
                      <div class="col-xs-3">
                        <select class="form-control m-bot15">
                          <option>FORELO</option>
                          <option>Cuenta Bancaria</option>
                        </select>
                      </div>
                      
                      <label class="col-xs-3 control-label">Reembolsos:</label>
                      <div class="col-xs-3">
                        <select class="form-control m-bot15">
                          <option>FORELO</option>
                          <option>Cuenta Bancaria</option>
                        </select>
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <label class="col-xs-3 control-label">CLABE:</label>
                      <div class="col-xs-3">
                        <input class="form-control m-bot15" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-xs-3 control-label">Banco:</label>
                      <div class="col-xs-3">
                        <input class="form-control m-bot15" type="text">
                      </div>
                      
                      
                      <label class="col-xs-3 control-label">Cuenta:</label>
                      <div class="col-xs-3">
                        <input class="form-control m-bot15" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-xs-3 control-label">Beneficiario:</label>
                      <div class="col-xs-3">
                        <input class="form-control m-bot15" type="text">
                      </div>
                      
                      
                      <label class="col-xs-3 control-label">Descripción:</label>
                      <div class="col-xs-3">
                        <input class="form-control m-bot15" type="text">
                      </div>
                    </div>
                  </form>-->
                  
                  
                </div>
                <!--<div class="well">
                  <div class="titulosexpress-first"><i class="fa fa-folder"></i> Documentación</div>
                  <form class="form-horizontal" method="post" action="<?php //echo $PATHRAIZ; ?>/inc/Ajax/_Afiliaciones/subirDocumentacion.php" name="formDocumentacion" id="formDocumentacion" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="col-xs-3 control-label">Comprobante de Domicilio:</label>
                      <div class="col-xs-3">
                        <input type="file" name="comprobanteDomicilio" id="docComprobanteDomicilio">
                        
                      </div>
                      
                      <label class="col-xs-3 control-label">Carátula de Banco:</label>
                      <div class="col-xs-2">
                        <input type="file" name="caratulaBanco" id="docCaratulaBanco">
                        
                      </div>
                    </div>
                    
                  </form>
                  
                </div>--><div class="row"><div class="col-xs-12">
                <form name="formAgregarSucursal" id="formAgregarSucursal" action="" method="get">
                  <button type="button" class="btn btn-xs btn-info pull-right boton_guardar" style="margin-bottom:20px;" id="guardarSucursal">
                  Agregar Sucursal
                  </button>
                </form>
              </div></div>
              
              <div class="adv-table ocultarSeccion" id="sucursalesInfo">
              </div>
              
              
              <div class="row">
                <div class="col-xs-12" id="divBtns">
                  <a href="#" class="btn btn-xs btn-info pull-left noesconsulta" id="anteriorPagina">Anterior</a>
                  <form class="form-horizontal" id="formSiguiente" method="post">
                    <input type="hidden" name="idCliente" id="idCliente">
                    <input type="hidden" name="esSubcadena" id="esSubcadena" value="<?php echo $esSubcadena; ?>">
                    <input type="hidden" name="vieneDeNuevaSucursal" id="vieneDeNuevaSucursal" value="<?php echo $vieneDeNuevaSucursal; ?>">
                    <a class="btn btn-xs btn-info pull-right noesconsulta" id="siguientePagina">Siguiente</a>
                  </form>
                  <a href="Cliente.php?idCliente=<?php echo $idCliente;?>" class="esconsulta">
                    <a class="esconsulta" href="Cliente.php?idCliente=<?php echo $idCliente;?>"><button class="btn btn-xs btn-info pull-left"> Regresar</button></a>
                  </a>
                  <a class="esconsultas" href="Sucursal.php?idSucursal=<?php echo $idSucursal;?>"><button class="btn btn-xs btn-info pull-left"> Regresar</button></a>

                </div>
                <form id="formRegresar" action="formnew5.php?idSucursal=<?php echo $idSucursal;?>&idCliente=<?php echo $idCliente?>" method="post">
                  <input type="hidden" name="consultaAfiliacion" value="<?php echo $_POST['consultaAfiliacion']?>">
                  <input type="hidden" name="consultaSucursal" value="<?php echo $_POST['consultaSucursal']?>">
                  <input type="hidden" name="idCliente" value="<?php echo $_POST['idCliente']?>">
                  <input type="hidden" name="esSubcadena" value="<?php echo $_POST['esSubcadena']?>">
                  <input type="hidden" name="idSucursal" value="<?php echo $_POST['idSucursal']?>">
                  <input type="hidden" name="vieneDeNuevaSucursal" value="<?php echo $_POST['vieneDeNuevaSucursal']?>">
                </form>
              </div>
            </div>
          </div>
        </section>
      </section>
      <!--*.JS Generales-->
      <script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/jquery-ui-1.10.4.custom.min.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/bootstrap.min.js"></script>
      <script class="include" type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.scrollTo.min.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/respond.min.js" ></script>
      <!--Generales-->
      <script src="<?php echo $PATHRAIZ;?>/inc/js/common-scripts.js"></script>
      <!--Elector de Fecha-->
      <script type="text/javascript" src="<?php echo $PATHRAIZ;?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js" type="text/javascript"></script>
      <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/advanced-form-components.js"></script>
      <!--Cierre del Sitio-->
      <script type="text/javascript" src="<?php echo $PATHRAIZ;?>/inc/js/_AfiliacionesAltaSucursales2.js"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
      <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.putcursoratend.js" type="text/javascript"></script>
      <script src="<?php echo $PATHRAIZ;?>/inc/js/RE.js" type="text/javascript"></script>
      <script>
        $(function(){
			BASE_PATH   = "<?php echo $PATHRAIZ;?>";
			ID_PERFIL   = "<?php echo $_SESSION['idPerfil'];?>";
			ES_ESCRITURA  = "<?php echo $esEscritura;?>";
			ID_AFILIACION = "<?php echo $idCliente;?>";
      		ES_CONSULTA   = "<?php echo $ESCONSULTA;?>";
      		ES_CONSULTA_SUC = "<?php echo $ESCONSULTASUCURSAL;?>";
      		ES_SUBCADENA = "<?php echo $esSubcadena; ?>";
      		VIENE_DE_NUEVA_SUCURSAL = <?php echo $vieneDeNuevaSucursal; ?>;

      		ns  = "<?php echo $_GET['ns']?>";
      		ns2 = "<?php echo $_GET['ns2']?>";

      		var idAfiliacionParam = getParametro("idCliente");
      		if ( !VIENE_DE_NUEVA_SUCURSAL ) {
      			if ( idAfiliacionParam ) {
      				idAfiliacion = idAfiliacionParam;
      				var idSucursalParam = getParametro("idSucursal");
      				var idSucursal = "vacio";
					if ( idSucursalParam && idSucursalParam != 0 ) {
      					idSucursal = idSucursalParam;
      					initDatosGeneralesSucursal();
      					setTimeout(function(){
      						editarSucursal( idSucursal );
      						estadoGuardarSucursal = 1;
      						idSucursalContactoSeleccionada = idSucursal;
      						$("#guardarSucursal").html("Editar Sucursal");
      					}, 1000);
      				}
      				cargarAfiliacion(idAfiliacion);
      				cargarFamiliasClienteNoReal(idAfiliacionParam);
      			} else {
      				idAfiliacion = 0;
      			}
      		} else {
      			if ( idAfiliacionParam ) {
      				idAfiliacion = idAfiliacionParam;
      				var idSucursalParam = getParametro("idSucursal");
      				var idSucursal = "vacio";
					if ( idSucursalParam && idSucursalParam != 0 && idSucursalParam != "null" ) {
      					idSucursal = idSucursalParam;
      					initDatosGeneralesSucursal();
      					setTimeout(function(){
      						editarSucursal( idSucursal );
      						estadoGuardarSucursal = 1;
      						idSucursalContactoSeleccionada = idSucursal;
      						$("#guardarSucursal").html("Editar Sucursal");
      					}, 1000);
      				}					
      				cargarDatosCliente(idAfiliacionParam);
      				cargarFamiliasCliente(idAfiliacionParam);
					if ( ES_CONSULTA == true ) {
						cargarSucursales( idAfiliacion );
					}					
					if ( ES_CONSULTA_SUC == false ) {
						cargarSucursales( idAfiliacion );
					}
      				$("#sucursalesInfo").attr("class", "adv-table");
      				$("#textoFamilias").attr("class", "");
      				$("#encabezadoFamilias").attr("class", "");
      				$("#anteriorPagina").html("Regresar");
      			}
      		}
      		initComponents();
      		initDatosGeneralesSucursal();
      });
      </script>
    </body>
  </html>
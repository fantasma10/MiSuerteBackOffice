<?php
    $PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
    define('URL', 'http' . ((intval($_SERVER['SERVER_PORT']) == 443)?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/');

    include($PATH_PRINCIPAL."/inc/config.inc.php");
    include($PATH_PRINCIPAL."/inc/session.inc.php");
    $PATHRAIZ = "https://".$_SERVER['HTTP_HOST'];

    $submenuTitulo = "Contabilidad";
    $subsubmenuTitulo = "Comisiones";
    $tipoDePagina = "Lectura";
    $idOpcion = 261;
    $hoy = date("Y-m-d");
    $mesPasado = date("Y-m-d", strtotime('-1 month'));
    if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
        header("Location: " . URL ."error.php");
        exit();
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
<title>.::Mi Red::.Reporte Proveedores</title>
<!-- Núcleo BOOTSTRAP -->
<link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL ?>css/bootstrap-reset.css" rel="stylesheet">
<!--ASSETS-->
<link href="<?php echo URL ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href="<?php echo URL ?>assets/opensans/open.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<!-- ESTILOS MI RED -->
<link href="<?php echo URL ?>css/miredgen.css" rel="stylesheet">
<link href="<?php echo URL ?>css/style-responsive.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo URL ?>assets/bootstrap-datepicker/css/datepicker.css" />
<link href="<?php echo URL ?>css/themes/mired-theme/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link href="<?php echo $PATHRAIZ;?>/css/jquery.alerts.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<style type="text/css">
    .nav li a {
        background:#0c9ba0;
        color:#FFF;
        display:block;
        border:1px solid;
        padding:10px 12px;
        }
    .nav li a:hover {
    background:#0fbfc6;
    }
</style>
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
                <span><i class="fa fa-search"></i></span>
                <h3>Ususarios PayNau</h3><span class="rev-combo pull-right">Consulta<br>de Proveedores</span>
            </div>

            <div class="panel">
                <div class="panel-body">
                    <div style="margin-bottom: 25px;"> 
                        <ul class="nav nav-tabs nav-justified" style="padding: 0;margin: 0;background-color:#0c9ba0; color: #FFF; border:1px solid; " id="nav-items">
                            <li class="nav-item active">
                              <a class="nav-link active show"  data-toggle="tab" id="listaProveedores" href="#tab1" data-target="#tab1" role="tab" aria-selected="true">Proveedores</a> 
                            </li>
                            <li class="nav-item">
                              <a class="nav-link"  data-toggle="tab" id="datosProveedor" href="#tab2" data-target="#tab2" role="tab" aria-selected="false">Datos Proveedor</a> 
                            </li>
                            <li class="nav-item">
                              <a class="nav-link"  data-toggle="tab" id="miEmpresa" href="#tab3" data-target="#tab3" role="tab" aria-selected="false">Datos Empresas</a> 
                            </li>
                        </ul>
                    </div>
                    
    				<div class="tab-content">  
                        <div class="tab-pane active" id="tab1"> 
                            
                            <div class="well">
                                <div class="row ">
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Fecha Inicial</label>
                                            <input type="hidden" id="fecha" value="2021-10-18" class="form-control">
                                            <input type="text" onpaste="return false;" id="p_dFechaInicio" class="form-control m-bot15" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $mesPasado; ?>" onkeypress="return validaFecha(event,'p_dFechaInicio')" onkeyup="validaFecha2(event,'p_dFechaInicio')">
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Fecha Final</label>
                                            <input type="hidden" id="fecha" value="2021-10-18" class="form-control">
                                            <input type="text" onpaste="return false;" id="p_dFechaFin" class="form-control m-bot15" data-date-format="yyyy-mm-dd" maxlength="10" value="<?php echo $hoy; ?>" onkeypress="return validaFecha(event,'p_dFechaFin')" onkeyup="validaFecha2(event,'p_dFechaFin')">
                                        </div>
                                    </div>
                                    
                                    <div class="col-4">
                                        <button id="btnReporteUsuario" class="btn btn-xs btn-info"  style="margin:20px;">
                                            <i class="fa fa-file-excel-o"></i> Reporte Usuarios
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="gridbox" class="adv-table table-responsive" >
                                <table id="data" class="display table table-bordered table-striped" style=" width: auto;">
                                    <thead>
                                        <tr>
                                            <th id="thId">ID</th>
                                            <th id="thRFC">RFC</th>
                                            <th id="thRazonSocial">Razón Social</th>
                                            <th id="thNombre">Nombre Comercial</th>
                                            <th id="thCorreo">Correo</th>
                                            <th id="thTelefono">Teléfono</th>
                                            <th id="thCuenta">Cuenta CLABE</th>
                                            <th id="thDetalles">Detalles</th>
                                        </tr>
                                    </thead>    
                                    <tbody >

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab2"> 
                            <div style="margin-bottom: 0px;"> 
                                <ul class="nav nav-tabs nav-justified" style="padding: 0;margin: 0;background-color:#0c9ba0; color: #FFF; border:1px solid; font-size: medium; " id="nav-items">
                                    <li class="nav-item active">
                                      <a class="nav-link active show"  data-toggle="tab" id="miProveedor" href="#subtab1" data-target="#subtab1" role="tab" aria-selected="true">Proveedor</a> 
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link"  data-toggle="tab" id="misOrdenes" href="#subtab2" data-target="#subtab2" role="tab" aria-selected="false">Ordenes</a> 
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link"  data-toggle="tab" id="misMovimientos" href="#subtab3" data-target="#subtab3" role="tab" aria-selected="false">Movimientos</a> 
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link"  data-toggle="tab" id="miEstadoCuenta" href="#subtab4" data-target="#subtab4" role="tab" aria-selected="false">Estado de cuenta</a> 
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link"  data-toggle="tab" id="misClientes" href="#subtab5" data-target="#subtab5" role="tab" aria-selected="false">Clientes</a> 
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content"> 
                                <div class="tab-pane active" id="subtab1"> 
                                    <div class="well">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div class="profile-tile profile-tile-inlined" aling="center">
                                                    <a class="profile-tile-box faded" href="javascript:;" id="aLogotipo">
                                                        <div class="pt-new-icon">
                                                            <i class="os-icon os-icon-plus"></i>
                                                        </div>
                                                        <div class="pt-user-name">
                                                            Agrega tu
                                                            <br> Logotipo
                                                        </div>
                                                    </a>
                                                    <img src="<?php echo $BASE_URL;?>/img/user.png" id="imgLogotipoProv" style="margin-left: 30px; width: 65%;"/>
                                                    <input type="file" name="sLogotipo" id="fLogotipo" style="display:none;"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 m-t-10">
                                                <h5 class="nombre" id="span-sNombreComercial">Nombre Comercial del Negocio</h5>
                                                <h5 class="subtitulos" id="span-sRazonSocial">Razón Social S.A. de C.V.</h5>
                                                <button class="btn btn-sm btn-primary m-t-20" id="btnGuardar" style="display:none;">Guardar</button>
                                                <!-- <button class="btn btn-sm btn-secondary m-t-25" style="margin-left:0;" id="btnEditar">Editar</button> -->

                                                    <div style="color: #0c9ba0;"><h3 id="span-nIdNivel">Nivel 1</h3></div>
                                                
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <table class="level">
                                                    <!-- <tr>
                                                        <td><h3 id="span-nIdNivel">Nivel 1</h3></td>
                                                    </tr> -->
                                                    <!-- <tr>
                                                        <td><a href="<?php echo $BASE_URL;?>/Paynau/soporte/mesaControl.php/">Cambiar Nivel</a></td>
                                                    </tr> -->
                                                </table>
                                            </div>
                                        </div>
                                        <div class="d-block m-t-30">
                                            <div style="margin-bottom: 25px;" class="row" >
                                                <div class="col-md-8">
                                                    <h4 style="margin-top: 25px;"><span><i class="fa fa-address-card-o"></i></span> Datos Generales</h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <div id="activaCuenta" style="margin-top: 25px; text-align: right; font-size: medium;"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Nombre Comercial<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Ingresa tu Nombre Comercial" type="text" value=""  name="sNombreComercial" id="txtSNombreComercial" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">R.F.C. <span class="alerta" disabled>*</span></label>
                                                        <input type="text" class="form-control" value=""  name="sRFC" id="txtSRFC" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Regimen Fiscal <span class="alerta" disabled>*</span></label>
                                                        <select class="form-control"  name="nIdRegimen" id="cmbRegimen" disabled>
                                                            <option>Persona Física</option>
                                                            <option>Persona Moral</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block blockmoral">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Correo Electrónico<span class="alerta">*</span></label>
                                                        <input class="form-control" value="" type="text"  name="sCorreo" id="txtSCorreo" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captura tu Número de Teléfono fijo" type="text" value=""  name="sTelefono" id="txtSTelefono" disabled>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Razón Social<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="sRazonSocial" id="txtSRazonSocial">
                                                    </div>
                                                </div> -->
                                                
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Nombre Contacto<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="sNombreContacto" id="txtSNombreContacto">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="">Celular</label>
                                                        <input class="form-control" placeholder="Captura tu Número de Celular" type="text"   name="sCelular" id="txtSCelular">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Giro<span class="alerta">*</span></label>
                                                        <select class="form-control"  name="nIdGiro" id="cmbGiro">
                                                            <option>Mercadotecnia y Publicidad</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div> -->
                                        </div>
                                        <div class="d-none blockfisica">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Nombre<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="sNombre" id="txtSNombre" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="">Apellido Paterno<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="sApellidoPaterno" id="txtSApellidoPaterno" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="">Apellido Materno</label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="txtSApellidoMaterno" id="txtSApellidoMaterno" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="">Teléfono<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captuta tu Número de Teléfono fijo " type="text" value="" name="sTelefono1" id="txtSTelefono1" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="form-group">
                                                        <label for="">Celular</label>
                                                        <input class="form-control" placeholder="Captura tu Número de Celular" value="" type="text"  name="sCelular" id="txtSCelular1" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Correo Electrónico<span class="alerta">*</span></label>
                                                        <input class="form-control" value="" type="text"  name="sCorreo1" id="txtSCorreo1" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block m-t-20">
                                            <div style="margin-bottom: 25px;" >
                                                <h4><span><i class="fa fa-building"></i></span> Dirección</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">Calle<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captura tu calle" type="text" value=""  name="sCalle" id="txtSCalle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="">No. Exterior<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captura tu número exterior" type="text" value=""  name="sNumeroExterior" id="txtSNumeroExterior" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="">No. Interior</label>
                                                        <input class="form-control" placeholder="Captura tu número interior" type="text" value=""  name="sNumeroInterior" id="txtSNumeroInterior" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="">C.P.<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captura tu Código Postal" type="text" value=""  name="sCodigoPostal" id="txtSCodigoPostal" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Colonia<span class="alerta">*</span></label>
                                                        <select class="form-control"  name="nIdColonia" id="cmbColonia" disabled>
                                                            <option>--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Estado<span class="alerta">*</span></label>
                                                        <select class="form-control"  name="nIdEstado" id="cmbEstado" disabled>
                                                            <option>--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Ciudad<span class="alerta">*</span></label>
                                                        <select class="form-control"  name="nIdCiudad" id="cmbCiudad" disabled>
                                                            <option>--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block m-t-20">
                                            <div style="margin-top: 25px;">
                                                <h4><span><i class="fa fa-credit-card"></i></span> Datos Bancarios</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">Banco<span class="alerta">*</span></label>
                                                        <select class="form-control"  id="cmbBanco" disabled>
                                                            <option>--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">CLABE Interbancaria<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="Captura tu CLABE" type="text" value=""  name="sCLABE" id="txtSCLABE" onkeyup="validarBanco();" onkeypress="validarBanco();" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 d-none">
                                                    <div class="form-group">
                                                        <label for="">Número de Tarjeta<span class="alerta">*</span></label>
                                                        <input class="form-control" placeholder="" type="text" value=""  name="sTarjeta" id="txtSTarjeta" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!--                                        <div id="activaCuenta" style="margin-top: 25px; text-align: right; font-size: medium;"></div>  -->
                                    </div>
                                    <div id="sEmpresas" style="display: none;">
                                        <div style="margin-top: 25px;">
                                            <h4><span><i class="fa fa-building"></i></span> Mis Empresas</h4>
                                        </div>
                                        <div id="gridbox2" class="adv-table table-responsive" >
                                            <table id="dataEmpresas" class="display table table-bordered table-striped" style=" width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>RFC</th>
                                                        <th>Razon Social</th>
                                                        <th>Nombre</th>
                                                        <th>Correo</th>
                                                        <th>Telefono</th>
                                                        <th>Detalles</th>
                                                    </tr>
                                                </thead>    
                                                <tbody >

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="subtab2"> 
                                    <div class="d-block blockmoral" style="margin-top: 20px;">
                                        <div class="row" style="padding-left: 40px;">
                                            <div class="col-lg-5 col-md-5">
                                                
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicial</label>
                                                        <input type="text" class="form-control" id="p_dFechaInicioO" name="p_dFechaInicioO" maxlength="10" value="<?php echo $mesPasado; ?>"/>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control" id="p_dFechaFinO" name="p_dFechaFinO" maxlength="10" value="<?php echo $hoy; ?>"/>
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-info" id="btnBuscarO" style="margin-top:20px;" type="button"> Buscar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tablaOrdenes" class="adv-table table-responsive" >
                                        <!-- <table id="dataOrdenes" class="display table table-bordered table-striped" style=" width: auto;">
                                            <thead>
                                                <tr>
                                                    <th id="thCuenta">ID</th>
                                                    <th id="thDetalles">Status</th>
                                                    <th id="thId">Cliente</th>
                                                    <th id="thRFC">Concepto</th>
                                                    <th id="thRazonSocial">Vigencia</th>
                                                    <th id="thNombre">Monto Orden</th>
                                                    <th id="thCorreo">Saldo Orden</th>
                                                    
                                                    <th id="thDetalles">Correo</th>
                                                    <th id="thDetalles">Referencia</th>
                                                    <th id="thDetalles">Detalles</th>
                                                </tr>
                                            </thead>
                                              
                                            <tbody >

                                            </tbody>
                                        </table> -->
                                    </div>
                                </div>
                                <div class="tab-pane " id="subtab3"> 
                                    <div class="d-block blockmoral" style="margin-top: 20px;">
                                        <div class="row" style="padding-left: 40px;">
                                            <div class="col-lg-5 col-md-5">
                                                
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicial</label>
                                                        <input type="text" class="form-control" id="p_dFechaInicioM" name="p_dFechaInicioM" maxlength="10" value="<?php echo $mesPasado; ?>"/>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control" id="p_dFechaFinM" name="p_dFechaFinM" maxlength="10" value="<?php echo $hoy; ?>"/>
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-info" id="btnBuscarM" style="margin-top:20px;" type="button"> Buscar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="gridboxExport" class="adv-table table-responsive">
                                    <div id="tablaOrdenes" class="adv-table table-responsive" >
                                        <table id="dataClientes" class="display table table-bordered table-striped" style=" width: auto;">
                                            <thead>
                                                <tr>
                                                    <th id="thDetalles">No de Orden</th>
                                                    <th id="thId">Refencia</th>
                                                    <th id="thCuenta">Cliente</th>
                                                    <th id="thRFC">Concepto</th>
                                                    <th id="thRazonSocial">Estatus</th>
                                                    <th id="thNombre">Fecha Registro</th>
                                                    <th id="thCorreo">Monto de la orden</th>
                                                    <th id="thDetalles">Pendiente por pagar</th>
                                                    <th id="thDetalles">Detalle</th>
                                                </tr>
                                            </thead>
                                              
                                            <tbody >

                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    <h4 id="titulo" style="display: none">Detalle de Operaciones</h4>
                                    <div class="" id="detalleMovimientos" style="display: none;">

                                        <div id="gridbox" class="adv-table table-responsive">
                                            <table id="tblGridBox2" class="display table table-bordered table-striped" style=" width: 100%; display:none;">
                                                <thead>
                                                    <tr>
                                                            <th id="">Id Movimiento</th>
                                                            <th id="">Refencia</th>
                                                            <th id="">Abono</th>
                                                            <th id="">Metodo de pago</th>
                                                            <th id="">Fecha de pago</th>
                                                            <th id="">Hora</th>
                                                    </tr>   
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                </div>
                                <div class="tab-pane " id="subtab4"> 
                                <!--<h2>4</h2>-->
                                <div class="d-block blockmoral" style="margin-top: 20px;">
                                        <div class="row" style="padding-left: 40px;">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <label for="">Saldo actual disponible<span class="alerta">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <div class="form-group">
                                                                <input class="form-control" value="" type="text"  name="sCorreo" id="nSaldoActual">
                                                            </div>
                                                        </div>
                                                </div>
                                                
                                                <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <label for="">Saldo pendiente<span class="alerta">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <div class="form-group">
                                                                <input class="form-control" value="" type="text"  name="sCorreo" id="nSaldoPendiente">
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <label for="">Saldo despues de aplicar<span class="alerta">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-8 col-sm-3">
                                                            <div class="form-group">
                                                                <input class="form-control" value="" type="text"  name="sCorreo" id="nSaldoFinal">
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7">
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Inicial</label>
                                                        <input type="text" class="form-control" id="p_dFechaInicio" name="p_dFechaInicio" maxlength="10" value="<?php echo $mesPasado; ?>"/>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label>Fecha Final</label>
                                                        <input type="text" class="form-control" id="p_dFechaFin" name="p_dFechaFin" maxlength="10" value="<?php echo $hoy; ?>"/>
                                                        
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <button class="btn btn-xs btn-info" id="btnBuscar" style="margin-top:20px;" type="button"> Buscar </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="gridboxExport" class="adv-table table-responsive">
                                    <div id="tablaEstadoCuenta" class="adv-table table-responsive" >
                                        <table id="dataEstadoCuenta" class="display table table-bordered table-striped" style=" width: auto;">
                                            <thead>
                                                <tr>
                                                    <th id="thId">Id movimiento</th>
                                                    <th id="thId">fecha movimiento</th>
                                                    <th id="thCuenta">Descripcion</th>
                                                    <th id="thRFC">Estado</th>
                                                    <th id="thRazonSocial">Saldo inicial</th>
                                                    <th id="thNombre">Abono</th>
                                                    <th id="thCorreo">Cargo</th>
                                                    <th id="thDetalles">Saldo final</th>
                                                </tr>
                                            </thead>
                                              
                                            <tbody >

                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="subtab5"> 
                                    <div id="gridboxExport" class="adv-table table-responsive">
                                    <div class="col-md-3 col-lg-3 col-xl-2 col-sm-3 pull-right">
                                                            <div class="form-group">
                                                                <input class="form-control btn btn-default" value="Agregar" type="button"  name="btnAgregarCliente" id="btnAgregarCliente">
                                                            </div>
                                                        </div>
                                    <div id="tablaDatosCliente" class="adv-table table-responsive" >
                                        <table id="dataDatosCliente" class="display table table-bordered table-striped" style=" width: 100% !important;">
                                            <thead>
                                                <tr>
                                                    <th id="thNombre">Nombre</th>
                                                    <th id="thCorreo">Correo</th>
                                                    <th id="thTelefono">Telefono</th>
                                                    <th id="thEditar">Editar</th>
                                                    <th id="thEliminar">Eliminar</th>
                                                </tr>
                                            </thead>
                                              
                                            <tbody >

                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-------------------------------- Mis Empresas ------------------------------------------------->
                        <div class="tab-pane " id="tab3"> 

                                <div class ="well">
                                    <div class="d-block m-t-20">
                                        <div style="margin-top: 25px;">
                                            <h4><span><i class="fa fa-building"></i></span> Datos Generales</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">R.F.C.<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaRFC" id="empresaRFC" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Nombre / Razón Social
                                                        <span class="alerta">*</span>
                                                    </label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaRazonSocial" id="empresaRazonSocial" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 d-none">
                                                <div class="form-group">
                                                    <label for="">Nombre Comercial<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaNombreComercial" id="empresaNombreComercial" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Regimen Fiscal<span class="alerta">*</span></label>
                                                    <select class="form-control" id="empresaRegimenFiscal" disabled>
                                                        <option value="1">Persona Fisica</option>
                                                        <option value="2">Persona Moral</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Nombre / Razón Social<span class="alerta">*</span></label>
                                                    <select class="form-control" id="empresaActividaFiscal" disabled>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block m-t-20">
                                        <div style="margin-top: 25px;">
                                            <h4><span><i class="fa fa-address-card"></i></span> Dirección</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Calle<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaCalle" id="empresaCalle" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Numero Ext<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaNumeroExterior" id="empresaNumeroExterior" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 d-none">
                                                <div class="form-group">
                                                    <label for="">Numero Int<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaNumeroInterno" id="empresaNumeroInterno" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Codigo Postal<span class="alerta">*</span></label>
                                                    <input class="form-control" placeholder="" type="text" value=""  name="empresaCodigoPostal" id="empresaCodigoPostal" >
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Colonia<span class="alerta">*</span></label>
                                                    <select class="form-control" id="empresaColonia" >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Ciudad<span class="alerta">*</span></label>
                                                   <select class="form-control" id="empresaCiudad" >
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label for="">Estado<span class="alerta">*</span></label>
                                                    <select class="form-control" id="empresaEstado" >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="nIdProveedor" name="nIdProveedor" value="0">
                                    <input type="hidden" id="empresaEmpresa" name="empresaEmpresa" value="0">
                                    <input type="hidden" id="empresaEmpresaFacturacion" name="empresaEmpresaFacturacion">
                                </div>
                                <!-- <div class="well" style="align-content: right">
                                    <button type="button" class="btn btn-secondary" id="btnEmpresaCancelar">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btnEditarEmpresa">Guardar</button>
                                </div> -->
                                <div class="row" id="sLineasNegocio" style="display: none;">
                                    <div class="col-lg-12">
                                        <div style="margin-top: 25px;">
                                            <h4><span><i class="fa fa-building"></i></span> Lineas de negocio</h4>
                                        </div>
                                        <div id="gridboxLineas" class="adv-table table-responsive" >
                                            <table id="dataLineas" class="display table table-bordered table-striped" style=" width: auto;">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Serie</th>
                                                        <th>Folio Inicial</th>
                                                        <th>Folio Actual</th>
                                                        <!-- <th>Eliminar</th> -->
                                                    </tr>
                                                </thead>    
                                                <tbody >

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal" id="modalDetalleOrden" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detalle de la orden</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                        <div class="legmed">
                            <i class="fa fa-dollar"></i> Registro de Pago
                            <div class="row" id="sDetalleOrden" >
                                <div class="col-lg-12">
                                    <div style="margin-top: 25px;">
                                        <h4><span><i class="fa fa-building"></i></span> Detalle de la orden</h4>
                                    </div>
                                    <div id="gridboxPagos" class="adv-table table-responsive" >
                                        <table id="dataDetallePagoOrden" class="display table table-bordered table-striped" style=" width: auto;">
                                            <thead>
                                                <tr>
                                                    <th>No.Orden</th>
                                                    <th>No.Pago</th>
                                                    <th>Estatus</th>
                                                    <th>Tipo</th>
                                                    <th>Monto</th>
                                                    <th>Abono</th>
                                                    <th>Saldo</th>
                                                    <th>Fecha Vigencia</th>
                                                    <th>Fecha envio</th>
                                                    <th>Fecha Pago</th>
                                                </tr>
                                            </thead>    
                                            <tbody >

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>

            <div id="modalEditarCliente" class="modal fade col-xs-12" data-keyboard="false" role="dialog">
                <div class="modal-dialog" style="width:80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="titulo-modal"><i class="fa fa-lightbulb-o " style="font-size:18px"></i> ientes</span>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">                
                            <div class="row">
                                <div class="panel with-nav-tabs panel-default" style="box-shadow: none;">
                                      <div class="panel-heading">
                                          <ul class="nav nav-tabs">
                                           </ul>
                                       </div>
                                      <div class="panel-body" style="width:50%; margin:0 auto">
                                            
                                          <!--contenido-->
                                          
                                      </div>
                                </div>
                            </div>
                          </div>             

                        <div class="modal-footer">
                            <input type="hidden" id="nTipo" name="nTipo">
                            <button type="button" class="btn btn-default" id="btnOpcionCliente"></button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
<script>
	BASE_PATH		= "<?php echo $PATHRAIZ;?>";
	ID_PERFIL		= "<?php echo $_SESSION['idPerfil'];?>";

			
</script>

<!--*.JS Generales-->
<script src="<?php echo URL ?>inc/js/jquery.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/js/jquery.alerts.js"></script>
<script src="<?php echo URL ?>inc/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo URL ?>inc/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo URL ?>inc/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo URL ?>inc/js/respond.min.js" ></script>
<script src="<?php echo URL ?>inc/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<!--Generales-->
<script src="<?php echo URL ?>inc/js/jquery.numeric.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/jquery.alphanum.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/common-scripts.js"></script>
<script src="<?php echo URL ?>/inc/js/common-custom-scripts.js"></script>
<script src="<?php echo URL ?>inc/js/RE.js" type="text/javascript"></script>
<script src="<?php echo URL ?>inc/js/_Reportes2.js" type="text/javascript"></script>
<script src="<?php echo $PATHRAIZ;?>/paynau/js/soporte/reporteProveedores.js?<?php echo rand() ?>"></script>
<script src="<?php echo $PATHRAIZ;?>/paynau/js/soporte/ordenesProveedores.js?<?php echo rand() ?>"></script>
<script src="<?php echo $PATHRAIZ;?>/paynau/js/accounting.js"></script>
<script src="<?php echo URL ?>inc/js/jquery.fileDownload-master/src/Scripts/jquery.fileDownload.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.js"></script>
<!--Elector de Fecha-->
<script type="text/javascript" src="<?php echo URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $PATHRAIZ;?>/inc/input-mask/input-mask.js"></script>
<!--Cierre del Sitio-->
<script type="text/javascript">
    var BASE_URL = '<?php echo URL  ?>';
			$(document).ready(function() {
				initView();
			});
		</script>
</body>
</html>


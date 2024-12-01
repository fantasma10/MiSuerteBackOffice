<?php
session_start();
$PATH_PRINCIPAL = $_SERVER['DOCUMENT_ROOT'];
$usuario_logueado = $_SESSION['idU'];
include($PATH_PRINCIPAL . "/inc/config.inc.php");
include($PATH_PRINCIPAL . "/inc/session.inc.php");
$PATHRAIZ = "https://" . $_SERVER['HTTP_HOST'];
$submenuTitulo = "Tipo de comercio";
$subsubmenuTitulo = "Tipo Comercio";
$tipoDePagina = "mixto";
$idOpcion = 281;
$parametro_proveedor = $_POST["txtidProveedor"];
if (!desplegarPagina($idOpcion, $tipoDePagina)) {
    header("Location: $PATHRAIZ/error.php");
    exit();
}
$esEscritura = false;
if (esLecturayEscrituraOpcion($idOpcion)) {
    $esEscritura = true;
}
$hoy = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Favicon-->
        <link rel="shortcut icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo $PATHRAIZ; ?>/img/favicon.ico" type="image/x-icon">
        <title>.::Mi Red::.Configuración de comisionista</title>
        <!-- Núcleo BOOTSTRAP -->
        <!-- <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap.min.css" rel="stylesheet"> -->
        <!--<link href="<?php echo $PATHRAIZ; ?>/css/bootstrap3.min.css" rel="stylesheet">-->
        <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap3.min.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ; ?>/css/bootstrap-reset.css" rel="stylesheet">
        <!--ASSETS-->
        <link href="<?php echo $PATHRAIZ; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/opensans/open.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/css/jquery.alerts.css" rel="stylesheet">
        <!-- ESTILOS MI RED -->
        <link href="<?php echo $PATHRAIZ; ?>/css/miredgen.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ; ?>/css/style-responsive.css" rel="stylesheet" />
        <link href="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" />
        <!-- Autocomplete -->
        <link href="<?php echo $PATHRAIZ; ?>/css/themes/base/jquery.ui.autocomplete.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet">
        <link href="<?php echo $PATHRAIZ;?>/assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $PATHRAIZ;?>/assets/data-tables/DT_bootstrap.css">
        <style type="text/css">
            .inhabilitar{
                background-color: #d9534f!important;
                border-color: #d9534f!important;
                margin-left: 10px;
                color: #FFFFFF;
            }
            .disabledbutton {
                pointer-events: none;
                opacity: 0.4;
            }

            td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

            .theadSelected{
                background-color: #FFF !important;
                user-select: none;
            }
            .selected {
                background-color: #01c6c4;
                color: #FFF;
                user-select: none;
            }

            .dataTables_length{
                display: none;
            }
            .dataTables_filter{
                display: none;
            }
        </style>
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
                background: white url('../../../img/loadAJAX.gif') right center no-repeat;
            }
            .ui-autocomplete {
                max-height: 190px;
                overflow-y: auto;
                overflow-x: hidden;
                font-size: 12px;
            }
            </style>
    </head>
    <!--Include Cuerpo, Contenedor y Cabecera-->
    <?php include($PATH_PRINCIPAL . "/inc/cabecera2.php"); ?>
    <!--Inicio del Menú Vertical-->
    <!--Función "Include" del Menú-->
    <?php include($PATH_PRINCIPAL . "/inc/menu.php"); ?>
    <!--Final del Menú Vertical-->
    <!--Contenido Principal del Sitio-->
    
    <input type="hidden" name="nIdusuarioRE" id="nIdusuarioRE" value="<?php echo $usuario_logueado ;?>">
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panelrgb">
                        <div class="titulorgb-prealta">
                            <span><i class="fa fa-user"></i></span>
                            <h3>Configuración de Comisionista</h3>
                            <span class="rev-combo pull-right"></span>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="wizard">
                                <div class="row">
                                    <div class="form-group col-xs-3" >   
                                        <label for="txtId" class="control-label">Comisionista:</label>
                                        <input class="form-control" type="text" id="sComisionista" name="sComisionista" placeholder=""   >
                                    </div>
                                    <div class="form-group col-xs-3" style="">
                                        <input type="radio" class="custom-control-input" name="nIdTipoUsuario" id="customRadio1" value="1" checked="checked" onclick="" >
                                        <label class="custom-control-label" for="customRadio1"  onclick=""  >con Crédito</label> 
                                        <input type="radio" class="custom-control-input" name="nIdTipoUsuario" id="customRadio2" value="0" checked="checked" onclick="" >
                                        <label class="custom-control-label" for="customRadio1"  onclick=""  >sin Crédito</label>
                                    </div>
                                    <div class="form-group col-xs-3">
                                    </div>
                                    <!--
                                    <div class="form-group col-xs-3">
                                        <input type="radio" class="custom-control-input" name="nIdTipoUsuario" id="customRadio2" value="0"  onclick="" >
                                        <label class="custom-control-label" for="customRadio2" onclick="" >Prepago</label> 
                                    </div>-->
                                    <div class="form-group col-xs-3">
                                        <button type="button"   onclick="foreloscomisionista();"  class="btn btn-primary btn-block">Buscar</button>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="form-group col-xs-6" style="text-align: left;"> 
                                            <a href="#" data-toggle="modal" data-target="#DataNotificarCreditoAbierto" onclick="datosUsuarioNotifica();" >Si es crédito abierto, notificar a...</a>
                                        </div>
                                        <div class="form-group col-xs-6" style="text-align: right;"> 
                                            <a href="#" data-toggle="modal" data-target="#Datautorizadores" >Autorizadores</a>
                                        </div>
                                    </div>
                                    <div id="" class="" style="width: 100%; display: inline-block;">
                                        <table id="data" border="0" cellspacing="0" cellpadding="0" class="tablesorter tasktable">
                                            <thead>
                                                <tr>
                                                    <td class="cabecera" >ID Corresponsal: Razón Social ó Nombre Comisionista</td>
                                                    <!--<td class="cabecera" >Prep. / Crédito</td>-->
                                                    <td class="cabecera" >Desp. en Gráfico</td>
                                                    <td class="cabecera" >Abierto / Limitado</td>  
                                                    <td class="cabecera" >Editar</td>                       
                                                </tr>
                                            </thead>
                                            <tbody id ="tbodyConfiguracionComisionista">
                                                <tr class="even">
                                                    <td></td>
                                                    <!--<td></td>-->
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/input-mask/input-mask.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script> -->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/bootstrap.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script> -->
    <script class="include" type="text/javascript" src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/respond.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alphanum.js" type="text/javascript"></script>
    <!--Generales-->
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.tablesorter.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/common-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ ?>/inc/js/common-custom-scripts.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/RE.js" type="text/javascript"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/data-tables/DT_bootstrap.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.alerts.js"></script>
    <!--<script src="<?php echo $PATHRAIZ; ?>/paycash/ajax/pdfobject.js"></script>-->
    <!--Autocomplete -->
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.core.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.position.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo $PATHRAIZ; ?>/css/ui/jquery.ui.autocomplete.js"></script>	
    <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/codigo_postal.js"></script>-->
    <!--<script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/js/consulta.js"></script>-->
    <script src="<?php echo $PATHRAIZ ?>/mis_pagos/cuponera/js/accounting.js"></script> 
    <script src="<?php echo $PATHRAIZ; ?>/inc/js/jquery.inputmask.bundle.js"></script>
    <script type="text/javascript">
        BASE_PATH = "<?php echo $PATHRAIZ; ?>";     
    </script>
    <script src="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/js/bootstrap-select.min.js"></script>
    <link href="<?php echo $PATHRAIZ; ?>/_Proveedores/proveedor/estilos/css/bootstrap-select.min.css" rel="stylesheet">    
    

<?php
        $oRdb->setSDatabase('redefectiva');
        $oRdb->setSStoredProcedure('sp_select_gestion_creditoAbiertoNotificar_AQUIMP');   // ok 21-Jun-2022
        $param = array();
        $oRdb->setParams($param);      
        $result2 = $oRdb->execute();
        $usuariosSoporte =  ($oRdb->fetchAll());
        $oRdb->closeStmt();

        for($i=0; $i<count($usuariosSoporte); $i++){
            $oRAMP->setSDatabase('aquimispagos');
            $oRAMP->setSStoredProcedure('sp_select_cfg_tipo_credito_notificacion'); // ok 21-Jun-2022
            $param = array(   
                array(
                        'name'  => 'ckNIdUsuarioRE',
                        'type'  => 'i',
                        'value' => $usuariosSoporte[$i]['idUsuario']
                    )   
                );
            $oRAMP->setParams($param);      
            $result3 = $oRAMP->execute();  
            if($result3['nCodigo']=='2031'){
                echo "error";
                $oRAMP->closeStmt();
                continue;
            }
            $usuariosSoporteB = ($oRAMP->fetchAll());
            $usuariosSoporte[$i]['sCorreo'] = $usuariosSoporteB[0]['sCorreo'];
            $usuariosSoporte[$i]['nTelefono'] = $usuariosSoporteB[0]['nTelefono'];
            $oRAMP->closeStmt();
        }

        $oRAMP->setSDatabase('aquimispagos');
        $oRAMP->setSStoredProcedure('sp_select_gestion_creditoLimitadoAutorizantes');   
        $param = array();
        $oRAMP->setParams($param);      
        $result2 = $oRAMP->execute();
        $usuariosAutorizantes =  ($oRAMP->fetchAll());
        $oRAMP->closeStmt();      

?>
<?php   foreach ( ($usuariosSoporte) as $key) {
            if ($key['nTelefono']>0) { ?>
                <script type="text/javascript">
                    $( document ).ready(function() {
                        $('#notifidUsuario option[value="<?php echo $key['idUsuario'];?>"]').attr("selected",true);
                        datosUsuarioNotifica();
                    });        
                </script>                
<?php               
            }
        }
?>
        <div class="modal fade" id="DataNotificarCreditoAbierto" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content"> 
                    <div class="modal-header">
                          <span  style="background-color:transparent; border:none; ">Notificar para Crédito Abierto</span>
                            <button type="button" class="close" data-dismiss="modal" title="Cerrar">×</button>
                            <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"  > 
                                <span >El siguiente es el responsable de mantener los saldos de comercios con crédito "Abierto" y es a quien debe enviarse mensaje cuando el saldo del FORELO esté en el límite inferior.</span>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating"> 
                                    <h4><strong>Quien solicita crédito para:</strong></h4>
                                    <select class="form-control" onchange="datosUsuarioNotifica();" id="notifidUsuario" name="notifidUsuario">
                                        <option value="">Seleccione</option>
                                        <?php foreach ( ($usuariosSoporte) as $keys) {  ?>
                                            <option value="<?php echo $keys['idUsuario'];?>" data-nombre="<?php echo $keys['nombre'];?>" data-apellidoPaterno="<?php echo $keys['apellidoPaterno'];?>" data-apellidoMaterno="<?php echo $keys['apellidoMaterno'];?>" data-email="<?php echo $keys['email'];?>"  data-correo="<?php echo $keys['sCorreo'];?>"  data-telefono="<?php echo $keys['nTelefono'];?>" ><?php echo $keys['nombre']." ".$keys['apellidoPaterno']." ".$keys['apellidoMaterno'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control m-bot15" id="notifnombre" name="notifnombre" readonly="readonly" > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control m-bot15" id="notifapellidoPaterno" name="notifapellidoPaterno" readonly="readonly" > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control m-bot15" id="notifapellidoMaterno" name="notifapellidoMaterno" readonly="readonly" > 
                                </div>
                            </div>


                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Correo electrónico Red Efectiva</label>
                                    <input type="text" class="form-control m-bot15" id="notifCorreoRedEfect" name="notifCorreoRedEfect"  readonly="readonly"> 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Correo electrónico Personal</label>
                                    <input type="text" class="form-control m-bot15" id="notifCorreoPersonal" name="notifCorreoPersonal"  > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>*Teléfono Móvil</label>
                                    <input type="text" class="form-control m-bot15" id="notifTelefono" name="notifTelefono" maxlength="10" pattern="[0-9]+" > 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style=" color: red; "> 
                                <span >* Es muy importante que el teléfono corresponda a un móvil, ya que se va a enviar SMS para notificar.</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="submit"  class="btn btn-primary btn-block " data-dismiss="modal" onclick="resetdatosUsuarioNotifica();" >Cancelar</button>
                                </div>
                            </div> 
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="submit" class="btn btn-primary btn-block" id="BtnCreditoAbiertoNotificar" onclick="formValidaRegistro();" >Actualizar</button>                           
                                </div>
                            </div> 
                        </div>                         
                    </div> 
                </div>
            </div>
        </div>
<input type="hidden" id="hsNombre0" name="" value='<?php echo $usuariosAutorizantes[0]['sNombre'];?>'>
<input type="hidden" id="hsApellidoPaterno0" name="" value='<?php echo $usuariosAutorizantes[0]['sApellidoPaterno'];?>'>
<input type="hidden" id="hsApellidoMaterno0" name="" value='<?php echo $usuariosAutorizantes[0]['sApellidoMaterno'];?>'>
<input type="hidden" id="hsCorreo0" name="" value='<?php echo $usuariosAutorizantes[0]['sCorreo'];?>'>
<input type="hidden" id="hnTelefono0" name="" value='<?php echo $usuariosAutorizantes[0]['nTelefono'];?>'>


<input type="hidden" id="hsNombre1" name="" value='<?php echo $usuariosAutorizantes[1]['sNombre'];?>'>
<input type="hidden" id="hsApellidoPaterno1" name="" value='<?php echo $usuariosAutorizantes[1]['sApellidoPaterno'];?>'>
<input type="hidden" id="hsApellidoMaterno1" name="" value='<?php echo $usuariosAutorizantes[1]['sApellidoMaterno'];?>'>
<input type="hidden" id="hsCorreo1" name="" value='<?php echo $usuariosAutorizantes[1]['sCorreo'];?>'>
<input type="hidden" id="hnTelefono1" name="" value='<?php echo $usuariosAutorizantes[1]['nTelefono'];?>'>


<input type="hidden" id="hsNombre2" name="" value='<?php echo $usuariosAutorizantes[2]['sNombre'];?>'>
<input type="hidden" id="hsApellidoPaterno2" name="" value='<?php echo $usuariosAutorizantes[2]['sApellidoPaterno'];?>'>
<input type="hidden" id="hsApellidoMaterno2" name="" value='<?php echo $usuariosAutorizantes[2]['sApellidoMaterno'];?>'>
<input type="hidden" id="hsCorreo2" name="" value='<?php echo $usuariosAutorizantes[2]['sCorreo'];?>'>
<input type="hidden" id="hnTelefono2" name="" value='<?php echo $usuariosAutorizantes[2]['nTelefono'];?>'>


        <div class="modal fade" id="Datautorizadores" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content"> 
                    <div class="modal-header">
                          <span  style="background-color:transparent; border:none; ">Autorizador de Crédito</span>
                            <button type="button" class="close" data-dismiss="modal" title="Cerrar">×</button>
                            <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;"> 
                                <span >Los siguientes son las personas que tienen la autoridad para autorizar una petición de crédito para abonar a FORELO de comercio.</span>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <h4><strong>Autorizador 1</strong></h4>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control m-bot15" id="nombres1" name="nombres[1]"  value="<?php echo $usuariosAutorizantes[0]['sNombre'];?>"  > 
                                    <input type="hidden" class="form-control m-bot15" id="hnIdTipoCreditoNoticacion1" name="hnIdTipoCreditoNoticacion[1]" value='<?php echo $usuariosAutorizantes[0]['nIdTipoCreditoNoticacion'];?>'>
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosP1" name="apellidosP[1]"  value="<?php echo $usuariosAutorizantes[0]['sApellidoPaterno'];?>"  > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosM1" name="apellidosM[1]"  value="<?php echo $usuariosAutorizantes[0]['sApellidoMaterno'];?>"  > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Correo electrónico</label>
                                    <input type="text" class="form-control m-bot15" id="correos1" name="correos[1]"  value="<?php echo $usuariosAutorizantes[0]['sCorreo'];?>"  > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Teléfono Móvil</label>
                                    <input type="text" class="form-control m-bot15 TELEFONOS " id="telefonos1" name="telefonos[1]" maxlength="10"  value="<?php echo $usuariosAutorizantes[0]['nTelefono'];?>"  > 
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <h4><strong>Autorizador 2</strong></h4>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control m-bot15" id="nombres2" name="nombres[2]"  value="<?php echo $usuariosAutorizantes[1]['sNombre'];?>" > 
                                    <input type="hidden" class="form-control m-bot15" id="hnIdTipoCreditoNoticacion2" name="hnIdTipoCreditoNoticacion[2]" value='<?php echo $usuariosAutorizantes[1]['nIdTipoCreditoNoticacion'];?>'>
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosP2" name="apellidosP[2]"  value="<?php echo $usuariosAutorizantes[1]['sApellidoPaterno'];?>" > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosM2" name="apellidosM[2]"  value="<?php echo $usuariosAutorizantes[1]['sApellidoMaterno'];?>" > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Correo electrónico</label>
                                    <input type="text" class="form-control m-bot15" id="correos2" name="correos[2]"  value="<?php echo $usuariosAutorizantes[1]['sCorreo'];?>" > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Teléfono Móvil</label>
                                    <input type="text" class="form-control m-bot15 TELEFONOS " id="telefonos2" name="telefonos[2]" maxlength="10"  value="<?php echo $usuariosAutorizantes[1]['nTelefono'];?>" > 
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <h4><strong>Autorizador 3</strong></h4>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre(s)</label>
                                    <input type="text" class="form-control m-bot15" id="nombres3" name="nombres[3]"  value="<?php echo $usuariosAutorizantes[2]['sNombre'];?>" > 
                                    <input type="hidden" class="form-control m-bot15" id="hnIdTipoCreditoNoticacion3" name="hnIdTipoCreditoNoticacion[3]" value='<?php echo $usuariosAutorizantes[2]['nIdTipoCreditoNoticacion'];?>'>
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosP3" name="apellidosP[3]"  value="<?php echo $usuariosAutorizantes[2]['sApellidoPaterno'];?>" > 
                                </div>
                            </div>
                            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"> 
                                <div class="form-group form-floating"> 
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control m-bot15" id="apellidosM3" name="apellidosM[3]"  value="<?php echo $usuariosAutorizantes[2]['sApellidoMaterno'];?>" > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Correo electrónico</label>
                                    <input type="text" class="form-control m-bot15" id="correos3" name="correos[3]"  value="<?php echo $usuariosAutorizantes[2]['sCorreo'];?>" > 
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2"> 
                                <div class="form-group form-floating"> 
                                    <label>Teléfono Móvil</label>
                                    <input type="text" class="form-control m-bot15 TELEFONOS " id="telefonos3" name="telefonos[3]" maxlength="10"  value="<?php echo $usuariosAutorizantes[2]['nTelefono'];?>" > 
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="button" onclick="ResetConfiguracionAut();"  class="btn btn-primary btn-block " data-dismiss="modal"  >Cancelar</button>
                                </div>
                            </div> 
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="submit" class="btn btn-primary btn-block" id="BtnCredito" onclick="formValidaRegistroAutorizadores();" >Actualizar</button>                           
                                    <input type="hidden" id="hRespuestaCorreo" value="0"/>
                                </div>
                            </div> 
                        </div>

                    </div> 
                </div>
            </div>
        </div>



        <div class="modal fade" id="Editar" tabindex="-1" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content"> 
                    <div class="modal-header">
                          <span  style="background-color:transparent; border:none; ">Configura Comisionista</span>
                            <button type="button" class="close" data-dismiss="modal" title="Cerrar">×</button>
                            <h4 class="modal-title"></h4>
                    </div>

                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre del Comisionista</label>
                                    <input type="text" class="form-control m-bot15" id="sNombreComisionista" name="sNombreComisionista" > 
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating"> 
                                    <label>Nombre de la Cadena</label>
                                    <input type="text" class="form-control m-bot15" id="sNombreCadena" name="sNombreCadena" > 
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating"> 
                                    <label>Tipo de Persona</label>
                                    <input type="text" class="form-control m-bot15" id="TipoPerso" name="TipoPerso" > 
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> 
                                <div class="form-group form-floating"> 
                                    <label>Tipo de Crédito</label>
                                    <input type="text" class="form-control m-bot15" id="sIdTipoCredito" name="sIdTipoCredito" > 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;">
                                <span><strong id="TipoPerso">Física/Moral</strong></span>
                            </div> -->
                            <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;">
                                <span><strong id="sIdTipoCredito">Crédito/Prepago</strong></span>
                            </div> -->
                        </div>


                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;">
                                <span><strong>¿Desplegar en Gráfico de FORELO?</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!-- </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;"> -->
                                <label class="custom-control-label" for="despGraficos1"><strong>Si</strong></label>
                                <input type="radio" class="custom-control-input" name="despGrafico" id="despGraficos1" value="1">                                
                            <!-- </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;"> -->
                                <label class="custom-control-label" for="despGraficos2"><strong>No</strong></label>
                                <input type="radio" class="custom-control-input" name="despGrafico" id="despGraficos2" value="0">                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;">
                                <span><strong>¿El crédito es de tipo Abierto?</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <!-- </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;"> -->
                                <label class="custom-control-label" for="tipocreditoa1"><strong>Si</strong></label>
                                <input type="radio" class="custom-control-input" name="tipocredito" id="tipocreditoa1" value="1">                                
                            <!-- </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="text-align: center;"> -->
                                <label class="custom-control-label" for="tipocreditoa2"><strong>No</strong></label>
                                <input type="radio" class="custom-control-input" name="tipocredito" id="tipocreditoa2" value="2">                                
                            </div>
                        </div>
                        <input type="hidden" name="hnIdCadena" id="hnIdCadena">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="submit"  class="btn btn-primary btn-block " data-dismiss="modal"  >Cancelar</button>
                                </div>
                            </div> 
                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6"> 
                                <div class="form-group form-floating"> 
                                    <button type="submit" class="btn btn-primary btn-block" id="BtnCredito" onclick="configuraComisionista();" >Actualizar</button>                           
                                </div>
                            </div> 
                        </div>

                         
                    </div> 
                </div>
            </div>
        </div>


</body>
</html>
<script src="<?php echo $PATHRAIZ; ?>/amp/foreloscomisionista/js/configuracionComisionistas.js?v=<?php echo(rand()); ?>"></script>

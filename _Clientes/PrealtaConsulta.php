<?php 
include("../inc/config.inc.php");
include("../inc/session.inc.php");
//include("../inc/menuFunctions.php");

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo = "Consultar";
$idOpcion = 2;
$tipoDePagina = "Mixto";
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <META http-equiv="Content-Type" content="text/html; charset=Windows-1252">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <meta charset="UTF-8">
    <title>Consulta Cliente</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/tm_docs.css" rel="stylesheet">
    <link href="../css/RE-CSS.css" rel="stylesheet" type="text/css" />
    <link href="../css/style.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="../css/themes/mired-prealtas-theme/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" href="../css/demos.css" />
    <link href="../css/css.css" rel="stylesheet" type="text/css" />
    <style>
		.contenido-centrado { text-align: center; }
		.anchoAvance { width: 30px; }
		#precadenas th { text-align: center; }
		.dataTableNombre { text-align: left; }
		.dataTableAvance { text-align: left; padding-left: 1%; }
		#presubcadenas th { text-align: center; }
		#precorresponsales th { text-align: center; }	
		.elementos { float: left; }
		.search-box { float: right; }
	</style>
    <script language="JavaScript">
		function goToPage(a) {
			window.location.href="Consulta.php?id=" + a;
		}	
    </script>
    <script src="../inc/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="../inc/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
    <script src="../inc/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../inc/js/RE.js" type="text/javascript"></script>
    <?php if ( $esEscritura ) { ?>
    <script src="../inc/js/PrealtasDataTablesEditables.js"></script>
    <?php } else { ?>
    <script src="../inc/js/PrealtasDataTablesNoEditables.js"></script>
    <?php } ?>
    <script src="../inc/js/_Clientes.js" type="text/javascript"></script>
    <script src="../inc/js/jquery.numeric.js" type="text/javascript"></script>
    <script src="../inc/js/jquery.alphanum.js" type="text/javascript"></script>
</head>

<body>
<?php include("../inc/menu.php"); ?>

<div class="Re-Content">	
    <br />
	<?php include("../inc/submenu.php"); ?>
    
    <br />
    <br />
    <div class="cuadro_contenido">
        <div class="sombra_superior"></div>
        <div class="area_contenido" style="padding:20px 20px 20px 20px; width:100%; float:left;">
	    <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
              <td width="80%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td width="8%" align="left" valign="top"><img src="../../img/btn_cadena1.png" width="68" height="68" /></td>
                  <td width="92%" align="left" valign="top">
                  <table id="precadenas" width="100%" border="0"
                  cellpadding="<?php echo (!$esEscritura)? "2" : "0" ?>" cellspacing="<?php echo (!$esEscritura)? "1" : "0"; ?>">
                  	<thead>
                    	<tr>
                        	<th>Nombre</th>
                            <th>% de Avance</th>
                            <?php if ( $esEscritura ) { ?>
                            <th>Revisar</th>
                            <?php } ?>
                            <th></th>
                            <?php if ( $esEscritura ) { ?>
                            <th></th>
                            <th>Autorizar</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table></td>
                </tr>
		<tr>
		    <td colspan="2">
			</td>
		  </tr>
              </table></td>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
          </tr>
            <tr>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
              <td width="80%" align="center" valign="middle">&nbsp;</td>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
              <td width="80%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td width="8%" align="left" valign="top"><img src=".././img/btn_subcadena1.png" width="68" height="68" /></td>
                  <td width="92%" align="left" valign="top">
		    	  <table id="presubcadenas" width="100%" border="0"
                  cellpadding="<?php echo (!$esEscritura)? "2" : "0" ?>" cellspacing="<?php echo (!$esEscritura)? "1" : "0" ?>">
                  	<thead>
                    	<tr>
                        	<th>Nombre</th>
                            <th>% de Avance</th>
                            <?php if ( $esEscritura ) { ?>
                            <th>Revisar</th>
                            <?php } ?>
                            <th></th>
                            <?php if ( $esEscritura ) { ?>
                            <th></th>
                            <th>Autorizar</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>                  	   
                  </table>
                  </td>
                </tr>
		<td colspan="2">
		</td>
		  </tr>
              </table></td>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td width="8%" align="left" valign="top"><img src="../../img/btn_corresponsal1.png" width="68" height="68" /></td>
                  <td width="92%" align="left" valign="top">
                  <table id="precorresponsales" width="100%" border="0"
                  cellpadding="<?php echo (!$esEscritura)? "2" : "0" ?>" cellspacing="<?php echo (!$esEscritura)? "1" : "0" ?>">
                  	<thead>
                    	<tr>
                        	<th>Nombre</th>
                            <th>% de Avance</th>
                            <?php if ( $esEscritura ) { ?>
                            <th>Revisar</th>
                            <?php } ?>
                            <th></th>
                            <?php if ( $esEscritura ) { ?>
                            <th></th>
                            <th>Autorizar</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>		    
                  </table>
                  </td>
                </tr>
		<tr><td colspan="2">
		</td>
		  </tr>
              </table>
		</td>
              <td align="center" valign="middle">&nbsp;</td>
            </tr>
	    
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">&nbsp;</td>
            </tr>
	    
          </table>
        </div>
        <div class="sombra_inferior" style="float:left; margin-top:0px;"></div>
    </div>
</div>

<div id='emergente'>
	<img alt='Cargando...' src='../img/cargando3.gif' id='imgcargando' />
</div>

<script>window.setTimeout("AutoCadena()",100);</script>
<script>window.setTimeout("AutoCorresponsal()",250);</script>
<script>window.setTimeout("AutoCorresponsalTel()",350);</script>

</body>
	<?php $RBD->close(); ?>
</html>

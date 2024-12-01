<?php 
include("../../inc/config.inc.php");
include("../../inc/session.inc.php");

$idOpcion = 2;
$tipoDePagina = "Mixto";

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

$submenuTitulo = "Pre-Alta";
$subsubmenuTitulo = "Consultar";
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <META http-equiv="Content-Type" content="text/html; charset=Windows-1252">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
    <meta charset="UTF-8">
    <title>Consulta Cliente</title>
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/tm_docs.css" rel="stylesheet">
    <link href="../../css/RE-CSS.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    
    <script src="../../inc/js/jquery.cookie.js" type="text/javascript"></script>
    
    <script src="../../inc/js/jquery.js" type="text/javascript"></script>
    <script src="../../inc/js/RE.js" type="text/javascript"></script>
    <script src="../../inc/js/_Clientes.js" type="text/javascript"></script>
    
    <script src="../../inc/js/jquery.tablesorter.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css" />
	<script src="../../css/ui/jquery.ui.core.js"></script>
    <script src="../../css/ui/jquery.ui.widget.js"></script>
    <script src="../../css/ui/jquery.ui.position.js"></script>
    <script src="../../css/ui/jquery.ui.menu.js"></script>
    <script src="../../css/ui/jquery.ui.autocomplete.js"></script>
    <link rel="stylesheet" href="../../css/demos.css" />
    
    <link href="../../css/css.css" rel="stylesheet" type="text/css" />

</head>

<body>
<?php include("../../inc/menu.php") ?>

<div class="Re-Content">	
    <br />
	<?php include("../../inc/submenu.php") ?>
    
    <br />
    <br />
    <div class="cuadro_contenido">
        <div class="sombra_superior"></div>
        <div class="area_contenido" style="padding:20px 20px 20px 20px; width:100%; float:left;">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
              <td width="80%" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td align="center" valign="middle"><img src="../../img/btn_corresponsal1.png" width="68" height="68" /><br/>
                    <span class="texto_botones">
                    Corresponsal</span></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="6">
                    <tr>
                      <td width="6%" align="center" valign="middle">&nbsp;</td>
                      <td width="31%" align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="6">
                            <tr>
                              <td align="center" valign="bottom">Nombre
                                <label><br />
                                  <input type="text" name="txtNombrePreCorr" id="txtNombrePreCorr" />
                                  </label>
                              </td>
                              <td align="center" valign="bottom"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image21','','../../img/btn_busqueda2.png',1)" onclick="BuscaPreCorresponsal1()"><img src="../../img/btn_busqueda1.png" alt="" name="Image21" width="30" height="30" border="0" class="boton_busqueda" id="Image21" /></a></td>
                            </tr>
                                            </table></td>
                      <td width="31%" align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="6">
                        <tr>
                          <td align="center" valign="bottom">Cadena
                            <br />
                              <input type="text" name="txtNombreCadena" id="txtNombreCadena" />
                              
                          </td>
                          <td align="center" valign="bottom"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','../../img/btn_busqueda2.png',1)" onclick="BuscaPreCorresponsal2()"><img src="../../img/btn_busqueda1.png" alt="" name="Image1" width="30" height="30" border="0" class="boton_busqueda" id="Image1" /></a></td>
                        </tr>
                      </table></td>
                      <td width="29%" align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="6">
                        <tr>
                          <td align="center" valign="bottom">SubCadena
                            <label><br />
                              <input type="text" name="txtPreSubCorr" id="txtPreSubCorr" />
                              </label>
                          </td>
                          <td align="center" valign="bottom"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image22','','../../img/btn_busqueda2.png',1)" onclick="BuscaPreCorresponsal3()"><img src="../../img/btn_busqueda1.png" alt="" name="Image22" width="30" height="30" border="0" class="boton_busqueda" id="Image22" /></a></td>
                        </tr>
                      </table></td>
                      <td width="3%" align="center" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><div class="separador"></div></td>
                </tr>

              </table></td>
              <td width="10%" align="center" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <td align="center" valign="middle">
              	<div id="divRES"></div>
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
	<img alt='Cargando...' src='../../img/cargando3.gif' id='imgcargando' />
</div>

<script>window.setTimeout("AutoCadena2()",100);</script>
<script>window.setTimeout("AutoPreCorresponsal()",250);</script>
<script>window.setTimeout("AutoPreSubCorr()",350);</script>
<script>window.setTimeout("BuscarPreCorresponsal()",400);</script>

</body>
	<?php $RBD->close(); ?>
</html>

<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

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

$id = (isset($_POST['idCadena'])) ? $_POST['idCadena'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$AND = "";
if($id != ''){
    $AND.= " AND P.`idCadena` = $id ";
}
if($nombre != ''){
    $AND.= " AND P.`nombre` = '$nombre' ";
}


?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro2">
    <tr>
      <td align="center" valign="top">
          <?php
            //ESTAS TRES VARIABLES SON NECESARIAS PARA MOSTRAR LA PAGINACION DEL ARCHIVO paginanavegacion.php
              $cant = 20;
              $sqlcount = "SELECT COUNT(`idPreClave`)
                      FROM `redefectiva`.`dat_presubcadena` as P
                      INNER JOIN `redefectiva`.`dat_cadena` as C on C.`idCadena` = P.`idCadena` 
                      WHERE `idEstatus` = 1 $AND ;";
              $funcion = "BuscaPreSubCadena";
              //NECESARIO INCLUIR PARA LA PAGINACION
              include("../actualpaginacion.php");
          
              $sql = "SELECT `idPreClave`,C.`nombreCadena`,P.`bRevisado`,P.`nombre`,P.`porcentajePrealta`
                      FROM `redefectiva`.`dat_presubcadena` as P
                      INNER JOIN `redefectiva`.`dat_cadena` as C on C.`idCadena` = P.`idCadena` 
                      WHERE `idEstatus` = 1 $AND LIMIT $actual,$cant;";
              $res = $RBD->query($sql);
              ?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="31%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Nombre</span></td>
          <td width="29%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Cadena</span></td>
          <td width="12%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">% de Avance</span></td>
          <td width="9%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Revisi&oacute;n</span></td>
          <td width="5%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
          <td width="5%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
          <td width="9%" align="center" valign="middle"class="renglon1_tabla">Autorizar</td>
        </tr>
        <?php
          if($RBD->error() == ''){
              $class = "";
              $band = true;
              if($res != '' && mysqli_num_rows($res) > 0){
                  while(list($id,$nombrecadena,$brevisado,$nombre,$porcentaje) = mysqli_fetch_array($res)){ $class = ($band) ? "renglon1_tabla" : "renglon2_tabla"; $band = !$band; ?>
                      <tr >
                          <td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo $nombre; ?></td>
                          <td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo $nombrecadena; ?></td>
                          <td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo $porcentaje; ?></td>
                          <td align="center" valign="middle" class='<?php echo $class; ?>'>
                          <?php if ($esEscritura) { ?>
                          <img src="<?php echo ($porcentaje < 100) ? "../../img/ico_revision1.png" : "../../img/ico_revision2.png" ; ?>" width="15" height="15" />
                          <?php } ?>
                          </td>
                          <td align="center" valign="middle" class='<?php echo $class; ?>'>
                          <?php if ($esEscritura) { ?>
                          <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image210-<?php echo $id."1"; ?>','','../../img/btn_ico_editar2.png',1)"><img src="../../img/btn_ico_editar1.png" name="Image210-<?php echo $id."1"; ?>" width="23" height="23" border="0" id="Image210-<?php echo $id."1"; ?>" /></a>
                          <?php } ?>
                          </td>
                          <td align="center" valign="middle" class='<?php echo $class; ?>'>
                          <?php if ($esEscritura) { ?>
                          <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image32-<?php echo $id."1"; ?>','','../../img/btn_eliminar2.png',1)"><img src="../../img/btn_eliminar1.png" name="Image32-<?php echo $id."1"; ?>" width="22" height="22" border="0" id="Image32-<?php echo $id."1"; ?>" /></a>
                          <?php } ?>
                          </td>
                          <td align="center" valign="middle">
						  <?php if ($esEscritura) { ?>
						  <?php if($porcentaje == 100 && $brevisado == 0){ ?> <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image122-<?php echo $id."1"; ?>','','../../img/btn_ico_autorizar2.png',1)"><img src="../../img/btn_ico_autorizar1.png" name="Image122-<?php echo $id."1"; ?>" width="22" height="22" border="0" id="Image122-<?php echo $id."1"; ?>" /></a> <?php }} ?></td>
                        </tr>
                  <?php }
              }
          }
        ?>
</table>
          
</table>
          
          
          
          
          <?php
//NECESARIO INCLUIR PARA LA PAGINACION
        echo "<table align='center'><tr><td>";
        include("../paginanavegacion.php");
        echo "</td></tr></table>";
?>
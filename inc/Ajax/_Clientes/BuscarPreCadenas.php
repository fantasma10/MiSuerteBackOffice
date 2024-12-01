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

?>

<table width="70%" border="2" cellpadding="0" cellspacing="0" class="recuadro2">
    <tr>
      <td align="center" valign="top">
        <?php
        
        
        //ESTAS TRES VARIABLES SON NECESARIAS PARA MOSTRAR LA PAGINACION DEL ARCHIVO paginanavegacion.php
        $cant = 20;
        $sqlcount = "SELECT COUNT(`idPreClave`)
                FROM `redefectiva`.`dat_precadena`
		WHERE `idEstatus` = 1;";
        $funcion = "BuscarPreCadenas";
        //NECESARIO INCLUIR PARA LA PAGINACION
        include("../actualpaginacion.php");
        
        $sql = "SELECT `idPreClave`,`bRevisado`,`nombre`,`porcentajePrealta`
                FROM `redefectiva`.`dat_precadena`
		WHERE `idEstatus` = 1 LIMIT $actual,$cant;";
        $res = $RBD->query($sql);
        
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="43%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Nombre</span></td>
            <td width="16%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">% de Avance</span></td>
            <td width="15%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Revisar</span></td>
            <td width="8%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
            <td width="8%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
            <td width="10%" align="center" valign="middle"class="renglon1_tabla">Autorizar</td>
          </tr>
          
          <?php
            if($RBD->error() == ''){
                $class = "";
                $band = true;
                if($res != '' && mysqli_num_rows($res) > 0){
                    while(list($id,$brevisado,$nombre,$porcentaje) = mysqli_fetch_array($res)){ $class = ($band) ? "renglon1_tabla" : "renglon2_tabla"; $band = !$band; ?>
                        <tr >
                            <td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo $nombre; ?></td>
                            <td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo $porcentaje; ?></td>
                            <td align="center" valign="middle" class='<?php echo $class; ?>'>
                            <?php if ($esEscritura) { ?>
                            <img onclick="window.location.href='../Cadena/Aut1.php?id=<?php echo $id; ?>';" src="<?php echo ($brevisado == 0) ? "../../img/ico_revision2.png" : "../../img/ico_revision1.png" ; ?>" width="15" height="15" />
                            <?php } ?>
                            </td>
                            <td align="center" valign="middle" class='<?php echo $class; ?>'>
                            <?php if ($esEscritura) { ?>
			    <a href="#" onclick="window.location.href='../Cadena/Crear.php?id=<?php echo $id; ?>';" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image210-<?php echo $id."0"; ?>','','../../img/btn_ico_editar2.png',1)"><img src="../../img/btn_ico_editar1.png" name="Image210-<?php echo $id."0"; ?>" width="22" height="22" border="0" id="Image210-<?php echo $id."0"; ?>" /></a>
               				<?php } ?>
			    			</td>
                            <td align="center" valign="middle" class='<?php echo $class; ?>'>
                            <?php if ($esEscritura) { ?>
                            <a href="#" onclick="EliminarPreCadena(<?php echo $id ?>)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image32-<?php echo $id."0"; ?>','','../../img/btn_eliminar2.png',1)"><img src="../../img/btn_eliminar1.png" name="Image32-<?php echo $id."0"; ?>" width="22" height="22" border="0" id="Image32-<?php echo $id."0"; ?>" /></a>
                            <?php } ?>
                            </td>
                            <td align="center" valign="middle">
							<?php if ($esEscritura) { ?>
							<?php if($porcentaje == 100 && $brevisado == 0){ ?> <a href="#" onclick="window.location.href='../Cadena/Aut2.php?id=<?php echo $id; ?>';" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image122-<?php echo $id."0"; ?>','','../../img/btn_ico_autorizar2.png',1)"><img src="../../img/btn_ico_autorizar1.png" name="Image122-<?php echo $id."0"; ?>" width="22" height="22" border="0" id="Image122-<?php echo $id."0"; ?>" /></a> <?php } ?>
                            <?php } ?>
                            </td>
                          </tr>
                    <?php }
                }
            }
          ?>
          <tr>
        </table>
        
      </td>
    </tr>
</table>
<?php
//NECESARIO INCLUIR PARA LA PAGINACION
        echo "<table align='center'><tr><td>";
        include("../paginanavegacion.php");
        echo "</td></tr></table>";
?>
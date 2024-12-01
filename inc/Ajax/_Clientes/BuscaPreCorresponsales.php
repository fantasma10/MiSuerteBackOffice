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

$band = true;

$idpre		= (isset($_POST['idPreClave']))?$_POST['idPreClave']:'';
$idcad		= (isset($_POST['idCadena']))?$_POST['idCadena']:'';
$subcad		= (isset($_POST['nombreSub']))?$_POST['nombreSub']:'';

$idPermiso = (isset($_SESSION['Permisos']['Tipo'][9]))?$_SESSION['Permisos']['Tipo'][9]:1;/*necesario para la autorizacion*/

$AND = "";
if($idpre != "")
	$AND = " AND P.`idPreClave` = ".$idpre;
	
if($idcad != "")
	$AND = " AND P.`idCadena` = ".$idcad;

if($subcad != "")
	$AND = " AND P.`nombreSubcadena` = '".$subcad."'";

 //ESTAS TRES VARIABLES SON NECESARIAS PARA MOSTRAR LA PAGINACION DEL ARCHIVO paginanavegacion.php
    $cant = 20;
    $sqlcount = "SELECT COUNT(`idPreClave`)
	    FROM `redefectiva`.`dat_precorresponsal` as P
	INNER JOIN `redefectiva`.`dat_cadena` as C on C.`idCadena` = P.`idCadena`
	WHERE P.`idEstatus` = 1 $AND ;";
    $funcion = "BuscarPreCorresponsal";
    //NECESARIO INCLUIR PARA LA PAGINACION
    include("../actualpaginacion.php");
	

$sql = "SELECT `idPreClave`,C.`nombreCadena`,P.`nombreSubCadena`,P.`bRevisado`,P.`nombre`,P.`porcentajePrealta`
	FROM `redefectiva`.`dat_precorresponsal` as P
	INNER JOIN `redefectiva`.`dat_cadena` as C on C.`idCadena` = P.`idCadena`
	WHERE P.`idEstatus` = 1
	$AND LIMIT $actual,$cant ;";
	
$res = $RBD->query($sql);
	?>
	<table width="100%">
    <tr>
      <td align="left" valign="middle" class="subtitulo_contenido">Pendientes Pre-Alta</td>
    </tr>
    <tr>
    <td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="recuadro2">
      <tr>
        <td width="23%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Nombre</span></td>
        <td width="23%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Cadena</span></td>
        <td width="23%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">SubCadena</span></td>
        <td width="8%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">% de Avance</span></td>
        <td width="8%" align="center" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Revisar</span></td>
        <td width="4%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
        <td width="4%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</td>
        <?php if($idPermiso ==0){  /*necesario para la autoriacion*/?> 
        <td width="7%" align="center" valign="middle"class="renglon1_tabla">Autorizar</td>
        <?php } ?>
      </tr>
  <?php
	if($RBD->error() == ''){
	$class = "";
	$band = true;
	if($res != '' && mysqli_num_rows($res) > 0){
		while(list($id,$nombrecadena,$nombresubcadena,$brevisado,$nombre,$porcentaje) = mysqli_fetch_array($res)){ $class = ($band) ? "renglon1_tabla" : "renglon2_tabla"; $band = !$band; ?>
		<tr >
			<td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo utf8_encode($nombre); ?></td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo utf8_encode($nombrecadena); ?></td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo utf8_encode($nombresubcadena); ?></td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'><?php echo utf8_encode($porcentaje); ?></td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'>
            <?php if ($esEscritura) { ?>
            <img onclick="window.location.href='../Corresponsal/Aut1.php?id=<?php echo $id; ?>';" src="<?php echo ($brevisado == 0) ? "../../img/ico_revision2.png" : "../../img/ico_revision1.png" ; ?>" width="15" height="15" />
            <?php } ?>
            </td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'><a href="#" onclick="window.location='../Corresponsal/Crear.php?id=<?php echo $id; ?>'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image210-<?php echo $id."2"; ?>','','../../img/btn_ico_editar2.png',1)">
            <?php if ($esEscritura) { ?>
            <img src="../../img/btn_ico_editar1.png" name="Image210-<?php echo $id."2"; ?>" width="23" height="23" border="0" id="Image210-<?php echo $id."2"; ?>" /></a>
            <?php } ?>
            </td>
			<td align="center" valign="middle" class='<?php echo $class; ?>'>
            <?php if ($esEscritura) { ?>
            <a href="#" onclick="EliminarPreCorresponsal(<?php echo $id; ?>);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image32-<?php echo $id."2"; ?>','','../../img/btn_eliminar2.png',1)"><img src="../../img/btn_eliminar1.png" name="Image32-<?php echo $id."2"; ?>" width="22" height="22" border="0" id="Image32-<?php echo $id."2"; ?>" /></a>
            <?php } ?>
            </td>
			
            <?php/* if($idPermiso ==0){*/ /*necesario para la autorizacion*/?>
            <td align="center" valign="middle">
			<?php if ($esEscritura) { ?>
			<?php if($porcentaje == 100 && $brevisado == 0){ ?> <a href="#" onclick="window.location.href='../Corresponsal/Aut5.php?id=<?php echo $id; ?>'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image122-<?php echo $id."2"; ?>','','../../img/btn_ico_autorizar2.png',1)"><img src="../../img/btn_ico_autorizar1.png" name="Image122-<?php echo $id."2"; ?>" width="22" height="22" border="0" id="Image122-<?php echo $id."2"; ?>" /></a> <?php } ?>
            <?php } ?>
            </td>
            
            <?php/* } */?>
		  </tr>
		<?php }
	}
	}
  ?>
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
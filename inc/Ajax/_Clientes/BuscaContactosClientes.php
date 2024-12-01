<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$tipoCliente	= (isset($_POST['tipoCliente']))?$_POST['tipoCliente']: -1;
$idValor		= (isset($_POST['idValor']))?$_POST['idValor']: -2;


$FROM ="";		$WHERE = "";		$AND = "";
if($tipoCliente == 1){
	$FROM = "`inf_cadenacontacto` AS inf";
	$WHERE = "inf.`idCadena` = ".$idValor;
	$AND = " AND inf.`idEstatusCadCont` = 0;";
}

if($tipoCliente == 2){
	$FROM = "`inf_subcadenacontacto` AS inf";
	$WHERE = "inf.`idSubCadena` = ".$idValor;
	$AND = " AND inf.`idEstatusSubCadCont` = 0";
}
	
if($tipoCliente == 3){
	$FROM = "`inf_corresponsalcontacto` AS inf";
	$WHERE = "inf.`idCorresponsal` = ".$idValor;
	$AND = " AND inf.`idEstatusCorCont` = 0";
}

if($tipoCliente > -1){
	
global $RBD;

$qry = "SELECT inf.`idContacto`,dat.`nombreContacto` ,dat.`apPaternoContacto`,
            dat.`apMaternoContacto`, cat.`descTipoContacto`, dat.`correoContacto`, dat.`telefono1`
            FROM $FROM
            LEFT JOIN `dat_contacto` AS dat
            ON inf.`idContacto` = dat.`idContacto`
            LEFT JOIN `cat_tipocontacto` AS cat
            ON dat.`idcTipoContacto` = cat.`idTipoContacto`
            WHERE $WHERE
            AND dat.`idcTipoContacto` = 6
            AND dat.`idEstatusContacto` = 0
            $AND
        ";

 $qry2 = "SELECT inf.`idContacto`,dat.`nombreContacto` ,dat.`apPaternoContacto`,
            dat.`apMaternoContacto`, cat.`descTipoContacto`, dat.`correoContacto`, dat.`telefono1`, dat.`idcTipoContacto`
            FROM $FROM
            LEFT JOIN `dat_contacto` AS dat
            ON inf.`idContacto` = dat.`idContacto`
            LEFT JOIN `cat_tipocontacto` AS cat
            ON dat.`idcTipoContacto` = cat.`idTipoContacto`
            WHERE $WHERE
            AND dat.`idcTipoContacto` != 6
            AND dat.`idEstatusContacto` = 0
            $AND
        ";
?>

	<table width="69%" border="0" cellpadding="3" cellspacing="0" class="borde_tabla_contactos">
      <tr>
        <td align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
        <td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tipo de Contacto</span></td>
        <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo</span></td>
        <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tel&eacute;fono</span></td>
        <td width="10%" align="center" valign="middle" class="borde_tabla_contactos_titulos1">&nbsp;</td>
      </tr>
      <?php 
            
            $res = $RBD->query($qry);
            if($res != NULL || $res != ""){
				while($contactResponsa = mysqli_fetch_array($res)){
                
        ?>
        <tr>
          <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_int_responsable">
              <?php echo ($res != NULL)? $contactResponsa[1].' '.$contactResponsa[2].' '.$contactResponsa[3]:""?>
          </td>
          <td width="31%" align="center" valign="middle" class="borde_tabla_contactos_int_responsable">
              <?php echo ($res != NULL)? utf8_encode($contactResponsa[4]):""?>
          </td>
          <td width="24%" align="center" valign="middle" class="borde_tabla_contactos_int_responsable">
              <?php echo ($res != NULL)? utf8_encode($contactResponsa[5]):""?>
          </td>
          <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_int_responsable">
              <?php echo ($res != NULL)? utf8_encode($contactResponsa[6]):""?>
          </td>
          <td width="10%" align="center" valign="middle" class="borde_tabla_contactos_int_responsable2">						
            <table border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image24-<?php echo $contactResponsa[0]; ?>','','../../img/btn_ico_editar2.png',1)" onclick="EditarContactos('<?php echo $contactResponsa[0]; ?>','<?php echo $contactResponsa[1]; ?>','<?php echo $contactResponsa[2]; ?>','<?php echo $contactResponsa[3]; ?>','6','<?php echo $contactResponsa[6]; ?>','<?php echo $contactResponsa[5]; ?>',event)"><img src="../../img/btn_ico_editar1.png" name="Image24-<?php echo $contactResponsa[0]; ?>" width="23" height="23" border="0" id="Image24-<?php echo $contactResponsa[0]; ?>" /></a></td>
                <td align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image33-<?php echo $contactResponsa[0]; ?>','','../../img/btn_borrar2.png',1)" onclick="DeleteContactos(<?php echo $idValor; ?>,<?php echo $contactResponsa[0]; ?>,<?php echo $tipoCliente; ?>)"><img src="../../img/btn_borrar1.png" name="Image33-<?php echo $contactResponsa[0]; ?>" width="23" height="23" border="0" id="Image33-<?php echo $contactResponsa[0]; ?>" /></a></td>
              </tr>
            </table>
          </td>
        </tr>
        
        <?php 
        }}
           
            $res = $RBD->query($qry2);
            if($res != NULL){
                 while($rContac = mysqli_fetch_array($res)){
        ?>
            <tr>
              <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_int">
                  <?php echo $rContac[1].' '.$rContac[2].' '.$rContac[3]; ?>
              </td>
              <td width="31%" align="center" valign="middle" class="borde_tabla_contactos_int">
                  <?php echo utf8_encode($rContac[4]); ?>
              </td>
              <td width="24%" align="center" valign="middle" class="borde_tabla_contactos_int">
                  <?php echo utf8_encode($rContac[5]); ?>
              </td>
              <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_int">
                  <?php echo utf8_encode($rContac[6]); ?>
              </td>
              <td width="10%" align="center" valign="middle" class="borde_tabla_contactos_int2">						
                <table border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image240-<?php echo $rContac[0]; ?>','','../../img/btn_ico_editar2.png',1)" onclick="EditarContactos('<?php echo $rContac[0]; ?>','<?php echo $rContac[1]; ?>','<?php echo $rContac[2]; ?>','<?php echo $rContac[3]; ?>','<?php echo $rContac[7]; ?>','<?php echo $rContac[6]; ?>','<?php echo $rContac[5]; ?>',event)"><img src="../../img/btn_ico_editar1.png" name="Image240-<?php echo $rContac[0]; ?>" width="23" height="23" border="0" id="Image240-<?php echo $rContac[0]; ?>" /></a></td>
                    <td align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image330-<?php echo $rContac[0]; ?>','','../../img/btn_borrar2.png',1)" onclick="DeleteContactos(<?php echo $idValor; ?>,<?php echo $rContac[0]; ?>,<?php echo $tipoCliente; ?>)"><img src="../../img/btn_borrar1.png" name="Image330-<?php echo $rContac[0]; ?>" width="23" height="23" border="0" id="Image330-<?php echo $rContac[0]; ?>" /></a></td>
                  </tr>
                </table>
              </td>
            </tr>
        <?php											
                 }
            }
        ?>
  </table>




<?php }else{ ?>
    <table align="center">
        <tr align="left">
            <td>
                <label class="NoRows">No se envio ningun tipo de Cliente.. (cadena, subcadena o corresponal)</label>
            </td>
        </tr>
    </table>
<?php }?>
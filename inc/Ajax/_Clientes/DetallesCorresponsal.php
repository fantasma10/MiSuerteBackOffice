<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");

$HidCor = $_POST['hidCorresponsal'];
$oCorresponsal = new Corresponsal($RBD, $WBD);
$oCorresponsal->load($HidCor);

$tipoDePagina = "Mixto";
$idOpcion = 1;
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../main.php"); 
    exit(); 	
}

if ( esLecturayEscrituraOpcion($idOpcion) ) {
	$esEscritura = true;
}

?>

<div class="detalle_2">
<br/>

	<div class="recuadro_contenido_detalle2">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="6">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" valign="top"><div class="cuadro_id"><span class="texto_bold">ID Corresponsal:</span> <?php echo $oCorresponsal->getId(); ?></div></td>
        <td align="left" valign="top" class="texto_bold">&nbsp;</td>
        <td align="left" valign="top" class="texto_bold">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="texto_bold">&nbsp;</td>
        <td align="left" valign="top" class="texto_bold">&nbsp;</td>
        <td align="left" valign="top" class="texto_bold">&nbsp;</td>
      </tr>
      <tr>
        <td width="34%" align="left" valign="top" class="texto_bold">Nombre:</td>
        <td width="28%" align="left" valign="top" class="texto_bold">1er. Tel&eacute;fono:</td>
        <td width="38%" align="left" valign="top" class="texto_bold">2er. Tel&eacute;fono:</td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php  echo utf8_encode($oCorresponsal->getNombreCor()); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getTel1(); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getTel2(); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="texto_bold">Fax:</td>
        <td align="left" valign="top" class="texto_bold">Correo:</td>
        <td align="left" valign="top" class="texto_bold">Fecha de Vencimiento:</td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getFax(); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getMail(); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getFechaVencimiento(); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top"><span class="texto_bold">Fecha de Alta:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Fecha 1a. Operaci&oacute;n:</span></td>
        <td align="left" valign="top"><span class="texto_bold">No. de Sucursal Propia:</span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getFechaAlta(); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getFechaOperacion();  ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getNumeroCor(); ?></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top"><div class="separador"></div></td>
        </tr>
      <tr>
        <td align="left" valign="top" class="texto_bold">Giro:</td>
        <td align="left" valign="top"><span class="texto_bold">Referencia:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Estatus:</span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php  echo utf8_encode($oCorresponsal->getNombreGiro()); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getNombreReferencia(); ?></td>
        <td align="left" valign="top"><?php  echo $oCorresponsal->getStatus(); ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top"><span class="texto_bold">Corresponsal Bancario de:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Usuario de Alta:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Contrato:</span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><a href="#" class="liga_descarga_archivos"><?php echo utf8_encode($oCorresponsal->getNombreBanco());  ?></a></td>
        <td align="left" valign="top"><?php  echo utf8_encode($oCorresponsal->getNombreUsuarioAlta()); ?></td>
        <td align="left" valign="top"><a href="#" class="liga_descarga_archivos" 
        <?php if( $oCorresponsal->getNumContrato() != "No tiene"){ ?>
        onclick="goContratos(<?php echo $oCorresponsal->getNumContrato(); ?>)"
        <?php } ?>
        ><?php echo $oCorresponsal->getNumContrato(); ?></a></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top"><span class="texto_bold">Ejecutivo de Cuenta:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Ejecutivo de Venta:</span></td>
        <td align="left" valign="top"><span class="texto_bold">Representante Legal:</span></td>
      </tr>
      <tr>
        <td align="left" valign="top"><?php echo utf8_encode($oCorresponsal->getNombreEjecutivoCuenta()); ?></td>
        <td align="left" valign="top"><?php echo utf8_encode($oCorresponsal->getNombreEjecutivoVenta()); ?></td>
        <td align="left" valign="top"><a href="#" class="liga_descarga_archivos" 
        <?php if( $oCorresponsal->getIdRepLegal() != "No tiene"){ ?>
        onclick="goRepreLegal(<?php echo utf8_encode($oCorresponsal->getIdRepLegal());  ?>)"
        <?php } ?>
        ><?php echo $oCorresponsal->getNombreRepLegal();  ?></a></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top"><div class="separador"></div></td>
        </tr>
      <tr>
        <td align="left" valign="top" ><span class="texto_bold">Direcci&oacute;n:</span></td>
        <td align="left" valign="top" >&nbsp;</td>
        <td align="left" valign="top" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">
        <?php
			echo utf8_encode($oCorresponsal->getDireccion()." ".$oCorresponsal->getDirNExt()." ".$oCorresponsal->getDirNInt());
		?>
        <br />
        <?php
			echo utf8_encode("Col. ".$oCorresponsal->getColonia()." C.P. ".$oCorresponsal->getCodigoPostal());
		?>
        <br />
        <?php
			echo utf8_encode($oCorresponsal->getMunicipio().", ".$oCorresponsal->getEstado().", ".$oCorresponsal->getPais());
		?>
        </td>
        </tr>
      <tr>
        <td colspan="3" align="left" valign="top"><div class="separador"></div></td>
        </tr>
      <tr>
        <td align="left" valign="top"><span class="subtitulo_detalle">Lista de Contactos</span></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>

      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" valign="middle">
        
        <table width="90%" border="0" cellpadding="6" cellspacing="0" class="borde_tabla_contactos">
          <tr>
            <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
            <td width="31%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tipo de Contacto</span></td>
            <td width="24%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo</span></td>
            <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos1"><span class="texto_bold">Tel&eacute;fono</span></td>
          </tr>
          <?php 
			$qry = "CALL redefectiva.`SP_LOAD_CONTACTOS_GENERAL`($HidCor, 0, 3);";
			$res = $RBD->query($qry);
			if($res != NULL || $res != ""){
        $cont = 0;
				while($contactResponsa = mysqli_fetch_array($res)){
          if($cont%2 == 0){
            $cls = "borde_tabla_contactos_int_responsable";
          }
          else{
            $cls="borde_tabla_contactos_int";
          }
          $cont++;
				
		?>
		<tr>
      <td width="23%" align="center" valign="middle" class="<?php echo $cls;?>">
        <?php echo ($res != NULL)?($contactResponsa["nombreCompleto"]):""?>
      </td>
      <td width="31%" align="center" valign="middle" class="<?php echo $cls;?>">
        <?php echo ($res != NULL)?utf8_encode($contactResponsa["descTipoContacto"]):""?>
      </td>
      <td width="24%" align="center" valign="middle" class="<?php echo $cls;?>">
        <?php echo ($res != NULL)?$contactResponsa["correoContacto"]:""?>
      </td>
      <td width="22%" align="center" valign="middle" class="<?php echo $cls;?>">
        <?php echo ($res != NULL)?$contactResponsa["telefono1"]:""?>
      </td>
    </tr>
		
		<?php 
		}}
		?>
        </table>
        
        </td>
      </tr>


      <tr>
        <td colspan="3" align="left" valign="top"><div class="separador"></div></td>
      </tr>
      <tr>
        <td align="left" valign="top"><span class="subtitulo_detalle">Horario</span></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" valign="top">
            <?php
                echo $oCorresponsal->getHorario();
            ?>
        </td>
        </tr>

    </table></td>
  </tr>
</table>

  </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="18%" align="center" valign="middle"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','../../img/btn_continuar2.png',1)"></a></td>
        <td align="center" valign="middle">
        <?php if ($esEscritura) { ?>
        <a href="#" onclick="irAEditar();" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','../../img/btn_editar2.png',1)"><img src="../../img/btn_editar1.png" name="Image2" width="79" height="31" border="0" id="Image2" /></a>
        <?php } ?>
        </td>
        <td width="18%" align="center" valign="middle">&nbsp;</td>
      </tr>
    </table>

</div>
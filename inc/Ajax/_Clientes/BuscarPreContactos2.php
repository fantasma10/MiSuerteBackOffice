<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
?>
<table width="100%" height="50px" border="0" cellpadding="3" cellspacing="0" class="borde_tabla_contactos">
    <tr style="height: 30px;">
      <td align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
      <td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tel&eacute;fono</span></td>
      <td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Extensi&oacute;n</span></td>
      <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo Electr&oacute;nico</span></td>
      <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos2" style="border-right:none;"><span class="texto_bold">Tipo de Contacto</span></td>
    </tr>
    <?php
		$sql = "CALL `prealta`.`SP_LOAD_PRECADENA`({$_SESSION['idPreCadena']});";
        $res =  $RBD->query($sql);
        $AND = "";
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $r = mysqli_fetch_array($res);
                $xml = simplexml_load_string($r[0]);
                $band = false;
                foreach($xml->Contactos->Contacto as $cont){
                    if($band == false && $cont != ''){
                        $AND.=" AND I.`idCadenaContacto` = $cont ";
                        $band = true;
                    }
                    else if($band)
                        $AND.=" OR I.`idCadenaContacto` = $cont ";
                    
                }
                
                if($AND != ''){
                    $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRECADENA`('$AND');";
					$Result = $RBD->SP($sql);
                    if($RBD->error() == ''){
                        if($Result != '' && mysqli_num_rows($Result) > 0){
                            $i = 0;
                            while(list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result)){?>
                            <tr <?php if($tipo == 6){ echo 'class="borde_tabla_contactos_int_responsable"';} ?>  style="height:30px;" >
                              <td align="center" valign="middle"><?php echo $nombre." ".$paterno." ".$materno; ?></td>
                              <td width="16%" align="center" valign="middle"><?php echo $telefono; ?></td>
                              <td width="16%" align="center" valign="middle"><?php echo $ext; ?></td>
                              <td width="23%" align="center" valign="middle"><?php echo $correo; ?></td>
                              <td width="22%" align="center" valign="middle"><?php echo utf8_encode($desc); ?></td>
                            </tr>
                           <?php $i++; }
                        }
                    }
                    
                }else{
                    ?>
                    
                    <tr style="height: 30px"><td colspan="6"></td></tr>
                    <tr style="height: 30px"><td colspan="6"></td></tr>
                    <tr style="height: 30px"><td colspan="6"></td></tr>
                    <tr style="height: 30px"><td colspan="6"></td></tr>
                <?php }
                
            }
        }
    
    ?>
  </table>
<?php ?>
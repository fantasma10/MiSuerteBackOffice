<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
?>
<table width="100%" height="50px" border="0" cellpadding="3" cellspacing="0" class="borde_tabla_contactos">
    <tr style="height: 30px">
      <td align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Contacto</span></td>
      <td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tel&eacute;fono</span></td>
      <td width="16%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Extensi&oacute;n</span></td>
      <td width="23%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Correo Electr&oacute;nico</span></td>
      <td width="22%" align="center" valign="middle" class="borde_tabla_contactos_titulos2"><span class="texto_bold">Tipo de Contacto</span></td>
      <td width="10%" align="center" valign="middle" class="borde_tabla_contactos_titulos1"><span class="texto_bold">Acciones</span></td>
    </tr>
    <?php
        $sql = "SELECT CONVERT(`XML` USING utf8)
            FROM `redefectiva`.`dat_precorresponsal`
            WHERE `idPreClave` = ".$_SESSION['idPreCorresponsal']." ;";
            
        $res =  $RBD->query($sql);
        $AND = "";
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $r = mysqli_fetch_array($res);
                $xml = simplexml_load_string($r[0]);
                
                $band = false;
                
                foreach($xml->Contactos->Contacto as $cont){
                    if($band == false && $cont != ''){
                        $AND.=" AND I.`idCorresponsalContacto` = $cont ";
                        $band = true;
                    }
                    else if($band)
                        $AND.=" OR I.`idCorresponsalContacto` = $cont ";
                    
                }
                
                if($AND != ''){
                    
                    $sql = "SELECT I.`idCorresponsalContacto`,I.`idcTipoContacto`,P.`idContacto`,P.`nombreContacto`,P.`apPaternoContacto`,P.`apMaternoContacto`,P.`telefono1`,P.`extTelefono1`,P.`correoContacto`,C.`descTipoContacto`
                        FROM `redefectiva`.`dat_precontacto` as P
                        INNER JOIN `redefectiva`.`inf_precorresponsalcontacto` as I on I.`idContacto` = P.`idContacto`
                        INNER JOIN `redefectiva`.`cat_tipocontacto` as C on C.`idTipoContacto` = I.`idcTipoContacto`
                        WHERE `idEstatusCorCont` = 0 $AND ORDER BY I.`idcTipoContacto` DESC ;";
                    $Result = $RBD->query($sql);
                    if($RBD->error() == ''){
                        if($Result != '' && mysqli_num_rows($Result) > 0){
                            $i = 0;
                            while(list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result)){?>
                            <tr <?php if($tipo == 6){ echo 'class="borde_tabla_contactos_int_responsable"';} ?>  style="height:30px;" >
                              <td align="center" valign="middle" ><?php echo $nombre." ".$paterno." ".$materno; ?></td>
                              <td width="16%" align="center" valign="middle" ><?php echo $telefono; ?></td>
                              <td width="16%" align="center" valign="middle" ><?php echo $ext; ?></td>
                              <td width="23%" align="center" valign="middle" ><?php echo $correo; ?></td>
                              <td width="22%" align="center" valign="middle" ><?php echo utf8_encode($desc); ?></td>
                              <td width="10%" align="center" valign="middle" style="border-right: none;"><table border="0" cellspacing="0" cellpadding="3">
                                  <tr>
                                    <td align="center" valign="middle">
                                        <a href="#" onclick="bandedcont3 = 1;EditarPreContacto(<?php echo $infid; ?>,0,2)" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','../../img/btn_ico_editar1.png',1)"><img src="../../img/btn_ico_editar1.png" name="Image3" width="23" height="23" border="0" id="Image3" /></a>
                                        </td>
                                    <td align="center" valign="middle"><a href="#" onclick="EliminarPreContactoCorresponsal(<?php echo $infid; ?>);" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','../../img/btn_borrar2.png',1)"><img src="../../img/btn_borrar1.png" name="Image26" width="23" height="23" border="0" id="Image26" /></a></td>
                                  </tr>
                              </table></td>
                            </tr>
                           <?php $i++; }
                        }
                    }
                    
                    
                    
                    
                }else{
                    ?>
                    
                    <tr style="height: 30px"><td colspan="6" ></td></tr>
                    <tr style="height: 30px"><td colspan="6" ></td></tr>
                    <tr style="height: 30px"><td colspan="6" ></td></tr>
                    <tr style="height: 30px"><td colspan="6" ></td></tr>
                     
                <?php }
                
            }
        }
    
    ?>
  </table>
<?php  ?>
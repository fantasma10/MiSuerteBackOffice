<html>
<?php
        
include ('../../../inc/config.inc.php');

$idsuc = $_POST['idsuc'];


	$mensaje= ''; ?>
    
    	<table width="100%" class="table-bordered table-striped table-condensed table-hover mt5" id="tbl-contactos">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Teléfono Móvil</th>
					<th>Correo</th>
					<th>Descripción</th>
					<th>Tipo de Contacto</th>
					<th class="hidess" id="thacciones">Acciones</th>
				</tr>
                </thead>
             
<?php
            $sQuery = "CALL `afiliacion`.`SP_SUCURSAL_CARGAR_CONTACTOS`('$idsuc');";
	        $resultcontactos = $WBD->query($sQuery);
    
            while($contacts  = mysqli_fetch_array($resultcontactos)){  ?>
                
                
       <tr><td><?php echo utf8_encode($contacts['sNombreContacto']); ?>&nbsp;<?php echo utf8_encode($contacts['sPaternoContacto']); ?>&nbsp;<?php echo      utf8_encode($contacts['sMaternoContacto']); ?></td>
					<td align="right" class="">
						<?php echo $contacts['sTelefonoContacto'] ?> Ext <?php echo $contacts['sExtensionContacto']; ?>
					</td>
					<td align="right"><?php echo $contacts['sTelefonoMovilContacto']; ?></td>
					<td align="right"><?php echo $contacts['sEmailContacto']; ?></td>
					<td align="right"><?php echo $contacts['sDescripcionContacto']; ?></td>
					<td align="right"><?php echo utf8_encode($contacts['sTipoContacto']); ?></td>
					<td align="center" class="hidess" id="tdacciones">
						<button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='eliminarcontacto(<?php echo $contacts['nIdContacto'];?>)' style="background-color:red">Eliminar</button>
						<button class="btn btn-xs btn-primary btnEditar" id="btneditar" 
                                onclick='llenaedicion(
                                                      <?php echo $contacts['nIdContacto'];?>,
                                                     "<?php echo $contacts['sNombreContacto'];?>",
                                                     "<?php echo $contacts['sPaternoContacto'];?>",
                                                     "<?php echo $contacts['sMaternoContacto'];?>",
                                                     "<?php echo $contacts['sTelefonoContacto'];?>",
                                                     "<?php echo $contacts['sExtensionContacto'];?>",
                                                     "<?php echo $contacts['sTelefonoMovilContacto'];?>",
                                                     "<?php echo $contacts['sEmailContacto'];?>",
                                                     "<?php echo $contacts['sDescripcionContacto'];?>"
                                         
                                                                                                 )'>Editar</button>
						<input type="hidden" name="nIdContacto" value="<?php echo $contacts['nIdContacto']; ?>"/>
					</td>
				</tr>
                
 
           <?php  } ?>
            
            
            </table>
            <?php


//mysqli_close($conn);

?>

</html>
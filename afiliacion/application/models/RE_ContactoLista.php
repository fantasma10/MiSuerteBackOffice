<html>
<?php
        
include ('../../../inc/config.inc.php');

$incr = $_POST['increm'];

 
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
					<th class="hidess">Acciones</th>
				</tr>
                </thead>
             
<?php
            $sQuery = "CALL `afiliacion`.`SP_LOAD_PROSPECTOSCONTACTOSLISTA`($incr);";
	        $resultcontactos = $WBD->query($sQuery);
    
            while($contacts  = mysqli_fetch_array($resultcontactos)){ ?>
                
                
       <tr><td><?php echo utf8_encode($contacts['sNombreContacto']); ?>&nbsp;<?php echo utf8_encode($contacts['sPaternoContacto']); ?>&nbsp;<?php echo      utf8_encode($contacts['sMaternoContacto']); ?></td>
					<td align="right" class="">
						<?php echo $contacts['sTelefono'] ?> Ext <?php echo $contacts['sExtTelefono']; ?>
					</td>
					<td align="right"><?php echo $contacts['sCelular']; ?></td>
					<td align="right"><?php echo $contacts['sEmailContacto']; ?></td>
					<td align="right"><?php echo $contacts['sDescripcionContacto']; ?></td>
					<td align="right"><?php echo utf8_encode($contacts['descTipoContacto']); ?></td>
					<td align="center" class="hidess">
						<button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='eliminarcontacto(<?php echo $contacts['nIdContacto'];?>)' style="background-color:red">Eliminar</button>
						<button class="btn btn-xs btn-primary btnEditar" id="btneditar" onclick='llenaedicion(<?php echo $contacts['nIdContacto'];?>)'>Editar</button>
						<input type="hidden" name="nIdContacto" value="<?php echo $contacts['nIdContacto']; ?>"/>
					</td>
				</tr>
                
 
           <?php  } ?>
            
            
            </table>
            <?php


//mysqli_close($conn);

?>

</html>
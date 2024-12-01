<html>
<?php
        
include ('../../../inc/config.inc.php');

$idsuc = $_POST['suc'];

 
	$mensaje= ''; ?>
    
    	<table width="96%" class="table-bordered table-striped table-condensed table-hover mt5" id="tbl-contactos">
			<thead>
				<tr>
					<th>ID</th>
					<th>N&uacute;mero</th>
					<th>C&oacute;digo</th>
					<th>Activo</th>
					<th>Habilitado</th>
					<th>Fecha Activaci&oacute;n</th>
					<th>&Uacute;ltimo Acceso</th>
					<th class="hidess">Acciones</th>
				</tr>
                </thead>
              
<?php
            $sQuery = "CALL `afiliacion`.`SP_SELECT_EQUIPOS_SUCURSAL`($idsuc);";
	        $result = $WBD->query($sQuery);
    
            while($equipos  = mysqli_fetch_array($result)){ ?>
                
                
       <tr>
       				<td width="100px">
       					<?php echo $equipos['idEquipo']; ?>
       				</td>
					<td align="center" class="" width="100px">
						<?php echo $equipos['numEquipo'] ?>
					</td>
					<td align="center"><?php echo $equipos['codActivacion']; ?></td>
					<td align="center" width="100px"><?php  if($equipos['equipoActivo']== 1){echo 'SI';}ELSE{ echo 'NO';}; ?></td>
					<td align="center" width="100px"><?php  if($equipos['equipoHabilitado'] == 1){echo 'SI';}else{echo 'NO';}; ?></td>
					<td align="center" width="100px"><?php echo $equipos['fecact']; ?></td>
					<td align="center" width="100px"><?php echo $equipos['fecult']; ?></td>
					<td align="center" class="hidess">
                        <?php if($equipos['equipoHabilitado'] == 1 && $equipos['equipoActivo']== 0){?>
						<button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='eliminarequipo(<?php echo $equipos['idEquipo'];?>)' style="background-color:red; width:80px">Eliminar</button>
                        <?php }else if($equipos['equipoHabilitado'] == 1 && $equipos['equipoActivo']== 1){?>
                      
                        <button class="btn btn-xs btn-primary btnEliminar" id="btnsusp" style="width:80px;background-color:#0e3860" onclick='suspenderequipo(<?php echo $equipos['idEquipo'];?>)' style="">Deshabilitar</button>
                        
                        <?php }else if($equipos['equipoHabilitado'] == 0 ){ ?>
                        
                        <button class="btn btn-xs btn-primary btnEliminar" id="btnsusp" style="width:80px" onclick='archivarequipo(<?php echo $equipos['idEquipo'];?>)' style="">Archivar</button>
                        
                        <?php } ?>
					</td>
				</tr>
                
 
           <?php  } ?>
            
            
            </table>
            <?php




?>

</html>
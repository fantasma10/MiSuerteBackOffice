<html>
<?php
        
include ('../../../inc/config.inc.php');

$idsuc = $_POST['suc'];

 
	$mensaje= ''; ?>
    
    	<table width="96%" class="table-bordered table-striped table-condensed table-hover mt5" id="tbl-contactos">
			<thead>
				<tr>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Estatus</th>
					<th>&Uacute;ltimo Acceso</th>
					<th>Baja</th>
					<th>Contrase&ntilde;a</th>
					<th>Sesi&oacute;n</th>
					
				</tr>
                </thead>
             
<?php
            $sQuery = "CALL afiliacion.SP_SELECT_OPERADORES_LISTA($idsuc);";
	        $result = $WBD->query($sQuery);
    
            while($operador  = mysqli_fetch_array($result)){ ?>
                
                
       <tr>
       				<td  align="center" width="100px"><?php echo $operador['idUsuario']; ?></td>
					<td align="center"  width=""><?php echo $operador['numOperador']; ?></td>
					<td align="center" width="100px"><?php if($operador['idEstatus']){echo 'Activo';}else{echo 'Cacelado';} ?></td>
                    <td align="center" width="200px"><?php echo $operador['accesoOperador']; ?></td>
					<td align="center" width="100px">
                        <?php if($operador['idEstatus']){?>
                        <button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='eliminaroperador(<?php echo $operador['idOperador'];?>)' style="background-color:red; width:80px">Eliminar</button>
                        <?php }else{ echo 'Cancelado';}?>
                    </td>
					<td align="center" width="100px"><button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='reestablecersesion(<?php echo $operador['idOperador'];?>,<?php echo $operador['idEstatus']; ?>)' style="background-color:#0e3860; width:80px">Reiniciar</button></td>
					<td align="center" width="100px">
                        
                        <?php if($operador['equipoLogin'] == 0){ 
               
                                    if($operador['countIntentos'] >=5){?>
                        
                                        <button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='reestablecersesion(<?php echo $operador['idOperador'];?>,<?php echo $operador['idEstatus']; ?>)' style="width:80px">Reestablecer</button>
                                    <?php }else{
                                        echo 'Sin Sesi&oacute;n';
                                        } 
                                }else{ 
                                    if($operador['countIntentos'] >=5){?>
                        
                                        <button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='reestablecersesion(<?php echo $operador['idOperador'];?>,<?php echo $operador['idEstatus']; ?>)' style="width:80px">Reestablecer</button>
                                    <?php }else{ 
                                                if($operador['MINUTE(tiempoSession - now())'] > 4){ ?>
                                                       <button class="btn btn-xs btn-primary btnEliminar" id="btneliminar" onclick='desbloquaroperador(<?php echo $operador['idOperador'];?>)' style="width:80px">Desbloquear</button>
                                              <?php  }else{ 
                                                    
                                                    echo 'En Sesi&oacute;n';
                                                    
                                                                         
                  
                                                } 
                                        }
                                
                            }
                        ?>
                    </td>
				
     </tr>
                
 
           <?php  } ?>
            
            
            </table>
            <?php




?>

</html>
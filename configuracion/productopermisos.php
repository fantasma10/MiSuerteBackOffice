
<?php
        
include ('../inc/config.inc.php');

$producto = $_POST['prod'];


$mensaje = '';
?>


<table width="100%" class="table-bordered table-striped table-condensed table-hover " id="tbl-contactos">
			<thead >
				<tr style="height:20px">
                    <th>Version</th>
					<th >Familia</th>
					<th>Producto/servicio</th>
                    
                                        
					<th width="63px">$ Ruta Producto</th>
					<th width="63px">% Ruta Producto</th>
                    
					<th width="63px">$ Permiso Usuario</th>
				   <th width="63px">% Permiso Usuario</th>
                    
                    <th width="63px">$ Ruta Comercio</th>
					<th width="63px">% Ruta Comercio</th>
				
					<th width="63px">$ Permiso Comercio</th>
					<th width="63px">% Permiso Comercio</th>
                    <th width="80px">Estatus</th>
                    <th width="50px">editar</th>
                
                    
					
				</tr>
                </thead>
                <tbody>
<?php
	$sQuery = "CALL redefectiva.SP_SELECT_PERMISOS_POR_PRODUCTO('$producto');";
$resultVersion = $WBD->query( $sQuery );
 while($version  = mysqli_fetch_array($resultVersion)){  
     
     $idPermiso     = $version['idPermiso']; 
     $familia       = utf8_encode($version['descFamilia']);
     $versi         = utf8_encode($version['nombreVersion']);
     $producto      = utf8_encode($version['descProducto']);
     $impProducto   = $version['rimpcomprod'];
     $porProducto   = $version['rporcomprod'] * 100 .' %';
     $impCliente    = $version['impComCliente'];
     $porCliente    = $version['perComCliente']*100 .' %';
     $impCorrRuta   = $version['rimpcomcorr'];
     $perCorrRuta   = $version['rpercomcorr']*100 .' %';                    
     $impCorrPer    = $version['pimpcomcorr'];
     $perCorrPer    = $version['pporcomcorr']*100 .' %';       
     $Estatus       = utf8_encode($version['Estatus']);
     ?>
                    
<tr>
             <td><?php echo $versi; ?></td>
            <td><?php echo $familia; ?></td>
            <td><?php echo $producto; ?></td>
           
            <td align="right"><?php echo $impProducto; ?></td>
            <td align="right"><?php echo $porProducto; ?></td>
            <td align="right"><?php echo $impCliente; ?></td>
            <td align="right"><?php echo $porCliente; ?></td>
            <td align="right"><?php echo $impCorrRuta; ?></td>
            <td align="right"><?php echo $perCorrRuta; ?></td>
            <td align="right"><?php echo $impCorrPer; ?></td>
            <td align="right"><?php echo $perCorrPer; ?></td>
            <td align="center"><?php echo $Estatus; ?></td>
            <td align="center"><img src="../img/edit.png" title="Editar Permiso" onclick="editapermiso(<?php echo $idPermiso; ?>)"/></td>
          
    
    
   </tr>
<?php } ?>
                    
    </tbody>   
</table>


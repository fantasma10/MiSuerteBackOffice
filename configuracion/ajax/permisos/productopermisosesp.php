
<?php
        
include ('../../../inc/config.inc.php');

$producto = $_POST['prod'];
$cadena = $_POST['cadenat'];
$cliente = $_POST['clientet'];
$sucursal = $_POST['sucursalt'];


$mensaje = '';



/*$dats = array(
    
"producto"=>$producto,
 "cadena"=>$cadena,
 "cliente"=> $cliente,
 "sucursal"=> $sucursal

);

echo json_encode($dats);*/

?>


<table width="100%" class="table-bordered table-striped table-condensed table-hover " id="tbl-contactos">
			<thead >
				<tr style="height:20px">
                    <th width="40px">ID Prod.</th>
                    <th>Version</th>
					<th >Familia</th>
					
                    <th width="42px">ID Cad.</th>
                    <th width="42px">ID Cte.</th>
                    <th width="46px">ID Suc.</th>
                    
                                        
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
	$sQuery = "CALL redefectiva.SP_SELECT_PERMISOS_POR_PRODUCTO_SUC('$producto','$cadena','$cliente','$sucursal');";
    $resultVersion = $WBD->query( $sQuery );
    while($version  = mysqli_fetch_array($resultVersion)){  

     $idPermiso     = $version['idPermiso']; 
     $familia       = utf8_encode($version['descFamilia']);
     $versi         = utf8_encode($version['nombreVersion']);
     $idproducto    = $version['idProducto'];
     $idcadena      = $version['idCadena'];
     $idcliente     = $version['idSubCadena'];
     $idsucursal    = $version['idCorresponsal'];    
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
            <td><?php echo $idproducto; ?></td>
            <td><?php echo $versi; ?></td>
            <td><?php echo $familia; ?></td>
            
            <td align="right"><?php echo $idcadena; ?></td>
            <td align="right"><?php echo $idcliente; ?></td>
            <td align="right"><?php echo $idsucursal; ?></td>
    
            <td align="right"><?php echo $impProducto; ?></td>
            
            <td align="right"><?php echo $porProducto; ?></td>
            <td align="right"><?php echo $impCliente; ?></td>
            <td align="right"><?php echo $porCliente; ?></td>
            <td align="right"><?php echo $impCorrRuta; ?></td>
            <td align="right"><?php echo $perCorrRuta; ?></td>
            <td align="right"><?php echo $impCorrPer; ?></td>
            <td align="right"><?php echo $perCorrPer; ?></td>
            <td align="center"><?php echo $Estatus; ?></td>
            <td align="center"><img src="../img/edit.png" title="Editar Permiso" onclick="loadedicion(<?php echo $idPermiso; ?>,<?php echo $idproducto; ?>)"/></td>
          
    
    
   </tr>
<?php } ?>
                    
    </tbody>   
</table>


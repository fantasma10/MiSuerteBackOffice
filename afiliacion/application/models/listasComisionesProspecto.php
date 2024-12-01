
<?php
        
include ('../../../inc/config.inc.php');


$rfc = $_POST['rfc'];


$mensaje = '';
?>

<table width="100%" class="table-bordered table-striped table-condensed table-hover mt5" id="tbl-contactos">
			<thead >
				<tr style="">
					<th >Familia</th>
					<th>Producto/servicio</th>
                    
					<th width="70px">$ Ruta Producto</th>
					<th width="70px">% Ruta Producto</th>
                    
					<th width="70px">$ Permiso Usuario</th>
				   <th width="70px">% Permiso Usuario</th>
                    
                    <th width="70px">$ Ruta Comercio</th>
					<th width="70px">% Ruta Comercio</th>
				
					<th width="70px">$ Permiso Comercio</th>
					<th width="70px">% Permiso Comercio</th>
                    <th width="70px" hidden></th>
                    <th width="70px"></th>
                    
					
				</tr>
                </thead>
                <tbody>
<?php
	$sQuery = "CALL afiliacion.SP_SELECT_LISTA_COMISIONES_PROSPECTO('$rfc');";
$resultVersion = $WBD->query( $sQuery );
 while($version  = mysqli_fetch_array($resultVersion)){  
     
    $idPermiso = $version['nIdPermiso']; 
  $familia = utf8_encode($version['descFamilia']);
  $producto =   utf8_encode($version['descProducto']);
$impProducto = $version['rimpcomprod'];
$porProducto = $version['rporcomprod'] * 100 .' %';
$impCliente = $version['nImpComUsuario'];
$porCliente = $version['nPerComUsuario']*100 .' %';
$impCorrRuta = $version['rimpcomcorr'];
$perCorrRuta = $version['rpercomcorr']*100 .' %';                    
 $impCorrPer = $version['pimpcomcorr'];
$perCorrPer = $version['pporcomcorr']*100 .' %';       
     
     ?>
                    
<tr>
   
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
     <td align="right" hidden>
    
    
    <button class="btn btn-xs btn-primary btnEditar" id="btneditarcoms" style="height:18px" onclick='editarcompros(<?php echo $idPermiso; ?>)'>Editar</button>
    
    
    </td>
    
    <td align="right">
    
    
    <button class="btn btn-xs btn-primary btnEditar" id="btneditarcomi" style="height:18px;background-color:#be0707;border-color:#be0707," onclick='eliminarcomision(<?php echo $idPermiso; ?>)'>Eliminar</button>
    
    
    </td>
    
    
   </tr>
<?php } ?>
                    
    </tbody>   
</table>


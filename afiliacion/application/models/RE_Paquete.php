<?php
        
//include ('../../inc/config.inc.php');



$tbl_paquetes = '';
	
	$sQuery = "CALL `afiliacion`.`SP_PAQUETE_LISTA`();";
$resultPaquetes = $WBD->query( $sQuery );
 while($paquete  = mysqli_fetch_array($resultPaquetes)){
         	$tbl_paquetes .= '<tr>';
		$tbl_paquetes .= '<td>';
		$tbl_paquetes .= utf8_encode($paquete['sNombre']);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nInscripcionCliente'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nAfiliacionSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nRentaSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nAnualSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= number_format($paquete['nLimiteSucursales'],0);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="center">';
		$tbl_paquetes .= '<button class="btn btn-xs btn-primary selecciona-paquete" onclick="copiapaqutes('.$paquete['nIdPaquete'].','.$paquete['nInscripcionCliente'].','.$paquete['nAfiliacionSucursal'].','.$paquete['nRentaSucursal'].','.$paquete['nAnualSucursal'].','.$paquete['nLimiteSucursales'].','.$paquete['dFechaInicio'].','.$paquete['dFechaFin'].','.$paquete['bPromocion'].')">Agregar</button>';
		$tbl_paquetes .= '<input type="hidden" name="nIdPaqueteLista" value="'.$paquete['nIdPaquete'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="bPromocion" value="'.$paquete['bPromocion'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="dFechaInicio" value="'.$paquete['dFechaInicio'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="dFechaFin" value="'.$paquete['dFechaFin'].'"/>';
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '</tr>';
               
             $listaPaquetes[]= $paquete;
 }




	    /*    $resultPaquetes = mysqli_query($rconn,"CALL `afiliacion`.`SP_PAQUETE_LISTA`()");
           while( $paquete  = mysqli_fetch_array($resultPaquetes,MYSQLI_ASSOC)){
               
          	$tbl_paquetes .= '<tr>';
		$tbl_paquetes .= '<td>';
		$tbl_paquetes .= $paquete['sNombre'];
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nInscripcionCliente'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nAfiliacionSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nRentaSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= "\$".number_format($paquete['nAnualSucursal'],2);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="right">';
		$tbl_paquetes .= number_format($paquete['nLimiteSucursales'],0);
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '<td align="center">';
		$tbl_paquetes .= '<button class="btn btn-xs btn-primary selecciona-paquete" onclick="copiapaqutes('.$paquete['nIdPaquete'].','.$paquete['nInscripcionCliente'].','.$paquete['nAfiliacionSucursal'].','.$paquete['nRentaSucursal'].','.$paquete['nAnualSucursal'].','.$paquete['nLimiteSucursales'].','.$paquete['dFechaInicio'].','.$paquete['dFechaFin'].','.$paquete['bPromocion'].')">Agregar</button>';
		$tbl_paquetes .= '<input type="hidden" name="nIdPaqueteLista" value="'.$paquete['nIdPaquete'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="bPromocion" value="'.$paquete['bPromocion'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="dFechaInicio" value="'.$paquete['dFechaInicio'].'"/>';
		$tbl_paquetes .= '<input type="hidden" name="dFechaFin" value="'.$paquete['dFechaFin'].'"/>';
		$tbl_paquetes .= '</td>';
		$tbl_paquetes .= '</tr>';
               
             $listaPaquetes[]= $paquete;
             
           }*/

// date('Y-m-d', strtotime('-1 day'))
	//foreach ($listaPaquetes as $key => $paquete){
	
	//}

//echo $listaPaquetes;

	 $listaPaquetes = json_encode($listaPaquetes);
//mysqli_close($rconn);

?>


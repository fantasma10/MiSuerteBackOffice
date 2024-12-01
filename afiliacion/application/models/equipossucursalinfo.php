<?php
        

include ('../../../inc/config.inc.php');

     $idsucursal = $_POST['sucursal'];
     
$sQuery = "CALL afiliacion.SP_SELECT_EQUIPO_CORRESPONSALINFO($idsucursal);";

//echo $sQuery;
	  $result = $WBD->query($sQuery);
      
$sucursal  = mysqli_fetch_array($result);
      
$var1 = $sucursal['sucursalinfo'];
$nombre = $sucursal['nombrecorresponsal'];
      
$data = array("code" => $var1, "nombre" => $nombre );
      
echo json_encode($data);
        
 
?>



<?php
        
include ('../../../inc/config.inc.php');

$idop = $_POST['op'];

 $sQuery = "CALL afiliacion.SP_UPDATE_OPERADOR_SESSION('$idop');";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
    
      $operador  = mysqli_fetch_array($result);
      $var1 = $operador['code'];
      $data = array("cod" => $var1 );
         
      echo json_encode($data);
         

?>
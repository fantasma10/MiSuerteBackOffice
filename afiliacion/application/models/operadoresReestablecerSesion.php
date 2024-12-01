<?php
        
include ('../../../inc/config.inc.php');

$idpp = $_POST['op'];
$estat = $_POST['estatus'];
$pwdC = '12345';
$pwdC = md5($pwdC);



 $sQuery = "CALL afiliacion.SP_UPDATE_OPERADOR_RESET_SESION('$idpp','$pwdC','$estat');";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
    
      $operador  = mysqli_fetch_array($result);
      $var1 = $operador['code'];
      $data = array("cod" => $var1 );
         
      echo json_encode($data);
         

?>
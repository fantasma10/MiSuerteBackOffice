<?php
        
include ('../../../inc/config.inc.php');

$idpp = $_POST['op'];
$pwdC = '12345';
$pwdC = md5($pwdC);

 $sQuery = "CALL afiliacion.SP_UPDATE_OPERADOR_PASSWORD('$idpp','$pwdC');";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
    
      $operador  = mysqli_fetch_array($result);
      $var1 = $operador['code'];
      $data = array("cod" => $var1 );
         
      echo json_encode($data);
         

?>
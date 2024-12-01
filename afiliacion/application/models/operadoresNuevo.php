<?php
        
include ('../../../inc/config.inc.php');

$idsuc = $_POST['suc'];
 $sQuery = "CALL data_webpos.SPE_ALTAOPERADOR('$idsuc','1');";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
    
      $operador  = mysqli_fetch_array($result);
      $var1 = $operador['@TRACE'];
      $idop = $operador['@IDOPER'];
      $data = array("cod" => $var1, "opnom" => $idop );
         
         
      echo json_encode($data);
         

?>
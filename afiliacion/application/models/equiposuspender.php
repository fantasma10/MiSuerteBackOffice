<?php
        
include ('../../../inc/config.inc.php');

     $idequipo = $_POST['equipo'];
     
     $sQuery = "CALL afiliacion.SP_UPDATE_EQUIPO_SUSPENDER($idequipo);";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
      $equipos  = mysqli_fetch_array($result);
      $var1 = $equipos['code'];
      $data = array("code" => $var1 );
      echo json_encode($data);
         
?>

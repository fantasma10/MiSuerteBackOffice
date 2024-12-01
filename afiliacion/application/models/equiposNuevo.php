<?php
        
include ('../../../inc/config.inc.php');

$idsuc = $_POST['suc'];

function generate_uuid() {
    return sprintf( '%05x-%05x-%05x-%05x',
        mt_rand( 0, 0xfffff ), mt_rand( 0, 0xfffff ),
        mt_rand( 0, 0xfffff ),
        mt_rand( 0, 0x0C2ff ) | 0x4000,
        mt_rand( 0, 0x3ffff ) | 0x8000,
        mt_rand( 0, 0x2Afff ), mt_rand( 0, 0xffD3f ), mt_rand( 0, 0xff4Bf )
    );

}

$CODACT = generate_uuid();

$CODACT = strtoupper($CODACT);
	
	
       $sQuery = "CALL data_webpos.SPE_ADDEQUIPO($idsuc,'1','$CODACT');";
//echo $sQuery;
	  $result = $WBD->query($sQuery);
    
      $equipos  = mysqli_fetch_array($result);
      $var1 = $equipos['@TRACE'];
      
         
       $data = array("cod" => $var1 );
         
         
      echo json_encode($data);
         




?>

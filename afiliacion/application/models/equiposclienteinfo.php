<?php
        

include ('../../../inc/config.inc.php');

     $idCliente = $_POST['cliente'];
 
     $sQuery = "CALL afiliacion.SP_SELECT_EQUIPO_CLIENTEINFO($idCliente);";
    //echo $sQuery;
	  $result = $WBD->query($sQuery);
      
$cliente  = mysqli_fetch_array($result);
      
$var1 = $cliente['cteinfo'];
$mail = $cliente['Correo'];
      
$data = array("code" => $var1,"mail" => $mail );
      
echo json_encode($data);
        
 
?>

    

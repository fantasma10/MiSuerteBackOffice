<?php
        
//include ('../../inc/config.inc.php');


$nIdTipoCliente = -1;
$html_tipoacceso	= '';





$sQuery = "CALL `nautilus`.`SP_CARGA_TIPO_ACCESO`('$nIdTipoCliente');";
$resultAcceso = $RBD->query( $sQuery );
 while($acceso  = mysqli_fetch_array($resultAcceso)){
 $lista_tipoacceso[] = $acceso;
 }
	

	       

					$num_tipoacceso		= count($lista_tipoacceso);

					for($i=0; $i<$num_tipoacceso; $i++){
						$tipoacceso	= $lista_tipoacceso[$i];
						$clase		= ($i == $num_tipoacceso-1)? "" : "mr10";

						$html_tipoacceso .= '<label style="text-transform: uppercase;" class="'.$clase.'"><input name="nIdTipoAcceso" type="checkbox" value="'.$tipoacceso['idTipoAcceso'].'" >'.strtoupper(utf8_encode($tipoacceso['descTipoAcceso'])).'</label>';
					}



?>

	   	
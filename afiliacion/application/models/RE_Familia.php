<?php
        
//include ('../../inc/config.inc.php');

	$sQuery = "CALL redefectiva.SP_CAT_FAMILIA();";
$resultFamilia = $RBD->query( $sQuery );
 while($familia  = mysqli_fetch_array($resultFamilia)){
  $lista_familias[] = $familia;
 }	

 
	

	       
$html_familias	= '';
					$num_familias	= count($lista_familias);

					for($i=0; $i<$num_familias; $i++){
						$familia	= $lista_familias[$i];
						$clase		= ($i == $num_familias-1)? "" : "mr5";

						$html_familias .= '<label style="text-transform: uppercase;" class="'.$clase.'"><input type="checkbox" name="nIdFamilia" id="nIdFamilia" value="'.$familia['idFamilia'].'" class="families ro" onclick="familiasarray(this,'.$familia['idFamilia'].')">'.strtoupper(utf8_encode($familia['descFamilia'])).'</label>';
					}
					
 /*$resultFamilia = mysqli_query($rconn,"CALL redefectiva.SP_CAT_FAMILIA()");
            while($familia  = mysqli_fetch_array($resultFamilia,MYSQLI_ASSOC)){
             $lista_familias[] = $familia;
             }
mysqli_close($rconn);*/




?>
	
	
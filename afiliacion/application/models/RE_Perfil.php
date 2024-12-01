<?php
        
//include ('../../inc/config.inc.php');

	$sQuery = "CALL `afiliacion`.SP_PERFILES_LISTA();";
$resultPerfil = $WBD->query( $sQuery );
 while($perfil  = mysqli_fetch_array($resultPerfil)){
 $lista_perfil[] = $perfil;
 }	

       
$html_perfil	= '';
					$num_perfiles	= count($lista_perfil);

					for($i=0; $i<$num_perfiles; $i++){
						$perfil	= $lista_perfil[$i];
						$clase	= "";

						$html_perfil .= '<label style="text-transform: uppercase;" class="'.$clase.' "><input type="radio" name="nIdPerfil" value="'.$perfil['nIdPerfil'].'" class="ro">'.strtoupper(utf8_encode($perfil['sNombrePerfil'])).'</label>';
					}
 /*$resultPerfil = mysqli_query($rconn,"CALL `afiliacion`.sp_perfiles_lista()");
            while($perfil  = mysqli_fetch_array($resultPerfil,MYSQLI_ASSOC)){
             $lista_perfil[] = $perfil;
             }				
mysqli_close($rconn);*/

?>
	



<?php
        
//include ('../../inc/config.inc.php');

$htmlSocio = '';

$idGrupo = -2;
$RFCsoc = '';
	
$sQuery = "CALL `redefectiva`.`SP_GRUPO_LOAD`('$idGrupo', '$RFCsoc');";
$resultSocio = $RBD->query( $sQuery );
 while($socio  = mysqli_fetch_array($resultSocio)){
    $htmlSocio .= '<option value="'.$socio['idGrupo'].'">'.utf8_encode($socio['nombreGrupo']).'</option>';
 }


	       /* $resultSocio = mysqli_query($conn,"CALL `redefectiva`.`SP_GRUPO_LOAD`('$idGrupo', '$RFCsoc')");
            while($socio  = mysqli_fetch_array($resultSocio,MYSQLI_ASSOC)){
             $htmlSocio .= '<option value="'.$socio['idGrupo'].'">'.utf8_encode($socio['nombreGrupo']).'</option>';
             }


mysqli_close($conn);*/

?>



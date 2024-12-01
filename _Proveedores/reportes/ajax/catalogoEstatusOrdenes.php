
<?php
        
           // include ('../../../inc/config.inc.php');
            
            $estatushtml = '';

            $sQuery = "CALL ".$_SESSION['db'].".sp_select_estatus_ordenesdepago();";
	        $resultestatus = $RBD->query($sQuery);
    
            while($rechs  = mysqli_fetch_array($resultestatus)){ 
                
                $idEstatus  =  $rechs['nIdEstatus'];
                $nombreEstatus = $rechs['sNombreEstatus'];
                $estatushtml .=     '<option value="'.$idEstatus.'">'.utf8_encode($nombreEstatus).'</option>';
                } 

?>

<?php
        
//include ('../../inc/config.inc.php');

$sQuery = "CALL redefectiva.SP_CAT_FAMILIA();";
$resultFamilia = $RBD->query( $sQuery );
$dataFamilias = array();
while($familia  = mysqli_fetch_array($resultFamilia)){
    $lista_familias[] = $familia;
}	
	       
$html_familias = '';
$num_familias = count($lista_familias);

for($i=0; $i<$num_familias; $i++){
	$familia = $lista_familias[$i];
	$clase = ($i == $num_familias-1)? "" : "mr5";
	$html_familias .= '
        <div class="form-check col-xs-4">
            <input type="checkbox" 
                name="nIdFamilia" 
                id="nIdFamilia'.$familia['idFamilia'].'" 
                value="'.$familia['idFamilia'].'" 
                class="families ro" 
                onclick="addFamiliasArray(this,'.$familia['idFamilia'].')">'
        .strtoupper(utf8_encode(' '.$familia['descFamilia'])).
        '</label>
            <label style="text-transform: uppercase;" class="'.$clase.'">
        </div>';
    $dataFamilias[] = array('key' => $familia['idFamilia'], 'value' => utf8_encode($familia['descFamilia']));
}
					
?>
	
	
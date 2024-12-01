<?php
        
include ('../../../inc/config.inc.php');

$idfam = $_POST['idfamilia'];

$html_servicio	= '<div class="row">';

	$sQuery = "CALL redefectiva.SP_SELECT_SERVICIO_POR_FAMILIA('$idfam');";
$resultServicio = $RBD->query( $sQuery );
  while($servicio  = mysqli_fetch_array($resultServicio)){
      
        
      
     	$html_servicio .= '<div class="col-xs-3"><label ><input type="checkbox" name="ckservicio" id="nIdServicio" value="'.$servicio['idTranType'].'" class="families" onclick="serviciosasarray(this,this.value)">'.strtoupper(utf8_encode($servicio['descTranType'])).'</label></div>';
     
     
 }	

$html_servicio	.= '</div>';
	       
echo	$html_servicio;	

?>
	
	
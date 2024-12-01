<?php
        
//include ('../../inc/config.inc.php');

$nIdTipoCliente = -1;
$html_tipoacceso = '';
$dataTipoaccesso = array();

$sQuery = "CALL `nautilus`.`SP_CARGA_TIPO_ACCESO`('$nIdTipoCliente');";
$resultAcceso = $RBD->query( $sQuery );
while($acceso  = mysqli_fetch_array($resultAcceso)){
    $lista_tipoacceso[] = $acceso;
}
	
$num_tipoacceso	= count($lista_tipoacceso);

for($i=0; $i<$num_tipoacceso; $i++){
    $tipoacceso	= $lista_tipoacceso[$i];
    $clase = ($i == $num_tipoacceso-1) ? "" : "mr10";

    $html_tipoacceso .= '
        <div class="form-group col-xs-4">
            <input name="nIdTipoAcceso" id="nIdTipoAcceso" type="radio" value="'.$tipoacceso['idTipoAcceso'].'" >
            <label style="text-transform: uppercase;" class="'.$clase.'">'
                .strtoupper(utf8_encode(' '.$tipoacceso['descTipoAcceso'])).
            '</label>
        </div>';
    $dataTipoaccesso[] = array('key' => $tipoacceso['idTipoAcceso'], 'value' => $tipoacceso['descTipoAcceso']);
}

?>


<!-- <div class="form-group col-xs-4">
                                <label class=" control-label"><input type="radio" onclick="validarProveedor();" name="tipoacceso" id="acceso1" value="0" /> DLL</label>
                            </div> -->
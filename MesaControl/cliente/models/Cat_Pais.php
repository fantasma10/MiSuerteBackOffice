
<?php
    $htmlPais = '';
    $orden = '';
    $dataPais = array();
    $sQuery = "CALL `redefectiva`.`SP_PAISES_NACIONALIDAD_LISTA`(0);";
    $reslt = $RBD->query( $sQuery );
    while($pais = mysqli_fetch_array($reslt)){
        $htmlPais .= '<option value="'.$pais['idPais'].'" '.($pais['clave'] == 'MX' ? 'selected' : '').'>'.utf8_encode($pais['nombre']).'</option>';
        $dataPais[] = array('key' => $pais['idPais'], 'value' => utf8_encode($pais['nombre']));
    }
?>
         
            
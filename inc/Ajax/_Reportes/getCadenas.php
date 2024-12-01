<?php
    include("../../config.inc.php");

    $cadena = isset($_POST['cadena'])? $_POST['cadena'] : NULL;
    $json['predeterminado'] = $cadena;

    if ( isset($cadena) )
    {
        $cadena = utf8_decode($cadena);
        $SQL = "CALL `redefectiva`.`SP_FIND_CADENAS`('$cadena');";
        $result = $RBD->SP($SQL);

        if ( $RBD->error() == '' )
        {
            $cadenas = array();
            while ( $cadena = $result->fetch_assoc() )
            {
                $cadenas[] = array(
                    'valor' => $cadena['idCadena'], 'texto' => utf8_encode($cadena['nombreCadena'])
                );
            }

            $json['datos'] = $cadenas;


            echo json_encode( $json );
        }
    }
?>

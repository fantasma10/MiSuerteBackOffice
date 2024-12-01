<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$id = (isset($_POST['id'])) ? $_POST['id'] : -1;


if ( $id > -1 ) {   
	$sql = "CALL `prealta`.`SP_LOAD_PRESUBCADENACONTACTOS`($id)";    
    $res = $RBD->SP($sql);
    if ( $RBD->error() == '' ) {
        if ( $res != '' && mysqli_num_rows($res) > 0 ) {
            list( $tipo, $id, $nombre, $paterno, $materno, $telefono, $ext, $correo ) = mysqli_fetch_array( $res );
            if ( !preg_match('!!u', $nombre) ) {
				//no es utf-8
				$nombre = utf8_encode($nombre);
			}
            if ( !preg_match('!!u', $paterno) ) {
				//no es utf-8
				$paterno = utf8_encode($paterno);
			}
            if ( !preg_match('!!u', $materno) ) {
				//no es utf-8
				$materno = utf8_encode($materno);
			}
            if ( !preg_match('!!u', $telefono) ) {
				//no es utf-8
				$telefono = utf8_encode($telefono);
			}
            if ( !preg_match('!!u', $ext) ) {
				//no es utf-8
				$ext = utf8_encode($ext);
			}
            if ( !preg_match('!!u', $correo) ) {
				//no es utf-8
				$correo = utf8_encode($correo);
			}															
			echo "$nombre,$paterno,$materno,$telefono,$ext,$correo,$tipo";
        }
    } else {
        echo "Error al realizar la consulta: ".$RBD->error();
    }
}


?>
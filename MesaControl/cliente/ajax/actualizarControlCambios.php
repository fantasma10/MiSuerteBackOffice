<?php
include($_SERVER['DOCUMENT_ROOT'] . "/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/session.ajax.inc.php");

$tipo_actualizacion     = $_POST["tipo_actualizacion_control_cambios"]; // 1 = Actualizar, 2 = Insertar
$seccion                = $_POST["seccion"];
$data_seccion           = $_POST["dataSeccion"];
$cliente                = $_POST["nIdCliente"];
$nIdActualizacion       = $_POST["nIdActualizacion"];
$tipo                   = $_POST["tipo"]; // 1 = secciones, 2 = status
$bRevision              = $_POST["bRevisionSecciones"];
$usuario                = ($bRevision == 0) ? $_SESSION["idU"] : 'null';
$usuario_autorizador    = ($bRevision == 2) ? $_SESSION["idU"] : 'null';

switch ($tipo){
    case 1: // Actualizacion de secciones
        foreach($data_seccion as $i => $data){
            $sSeccion[$data['fieldName']]  = $data['fieldData'];
        }
        $sSeccion   = json_encode($sSeccion);
        $sSeccion   = str_replace('"{', "{", $sSeccion);
        $sSeccion   = str_replace('}"', "}", $sSeccion);
        $sSeccion   = utf8_encode($sSeccion);
        switch ($tipo_actualizacion){
            case 1:
                $aux        = array(
                    0 => ($seccion == 'sSeccion1') ? $sSeccion : '{}',
                    1 => ($seccion == 'sSeccion2') ? $sSeccion : '{}',
                    2 => ($seccion == 'sSeccion3') ? $sSeccion : '{}',
                    3 => ($seccion == 'sSeccion4') ? $sSeccion : '{}',
                    4 => ($seccion == 'sSeccion5') ? $sSeccion : '{}',
                    5 => ($seccion == 'sSeccion6') ? $sSeccion : '{}',
                    6 => ($seccion == 'sSeccion7') ? $sSeccion : '{}',
                    7 => ($seccion == 'sSeccion8') ? $sSeccion : '{}',
                );
                $query      = "CALL redefectiva.sp_insert_formulario_actualizaciones(
                    $cliente,
                    NULL,
                    '$aux[0]',
                    '$aux[1]',
                    '$aux[2]',
                    '$aux[3]',
                    '$aux[4]',
                    '$aux[5]',
                    '$aux[6]',
                    '$aux[7]',
                    '0',
                    $usuario
                )";
            break;
            case 2:
                $sSeccion = "'$sSeccion'";
                $sSeccion = str_replace('"{', '{', $sSeccion);
                $sSeccion = str_replace('}"', '}', $sSeccion);
                $sSeccion   = utf8_encode($sSeccion);
                $aux = array(
                    0 => ($seccion == 'sSeccion1') ? $sSeccion : 'null',
                    1 => ($seccion == 'sSeccion2') ? $sSeccion : 'null',
                    2 => ($seccion == 'sSeccion3') ? $sSeccion : 'null',
                    3 => ($seccion == 'sSeccion4') ? $sSeccion : 'null',
                    4 => ($seccion == 'sSeccion5') ? $sSeccion : 'null',
                    5 => ($seccion == 'sSeccion6') ? $sSeccion : 'null',
                    6 => ($seccion == 'sSeccion7') ? $sSeccion : 'null',
                    7 => ($seccion == 'sSeccion8') ? $sSeccion : 'null',
                );
                $query ="CALL redefectiva.sp_update_cfg_formulario_actualizaciones(
                    $nIdActualizacion,
                    0,
                    0,
                    $aux[0],
                    $aux[1],
                    $aux[2],
                    $aux[3],
                    $aux[4],
                    $aux[5],
                    $aux[6],
                    $aux[7],
                    $bRevision,
                    $usuario,
                    $usuario_autorizador
                )";
            break;
            default:
                $query = "SELECT 1 AS code, 'No se ha definido el tipo de actualizacion' AS msg";
            break;

        }
    break;
    case 2: // Definicipon de status de control de cambios (bRevision)
        $query      = "CALL redefectiva.sp_update_cfg_formulario_actualizaciones(".$nIdActualizacion.", ".$cliente.", null, null, null, null, null, null, null, null, null, ".$bRevision.", NULL, $usuario)";
    break;
    default:
        $query = "SELECT 1 AS code, 'No se ha definido el tipo de actualizacion' AS msg";
    break;

}

$sql        = $WBD->query($query);
$row        = mysqli_fetch_assoc($sql);
$code       = $row["code"];
$mensaje    = $row["msg"];

$response = array(
    "nCodigo"			=> $code,
    "sMensaje"			=> $mensaje,
    "query"				=> $query,
    'data'				=> $sSeccion,
    'tipo'				=> $tipo_actualizacion,
    'respuesta'         => $row,
    "sql"				=> $tipo_actualizacion,
    "post"				=> $_POST,
);

print json_encode($response);

?>
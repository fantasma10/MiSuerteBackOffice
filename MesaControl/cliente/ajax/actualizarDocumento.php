<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/lib/SubirArchivo.php");

$valid_extensions = array('pdf');

// define('STORAGE_FOLDER_RE','G:/DESARROLLO/wwwroot/D_mired.redefectiva.net/STORAGE/Multipagos/DOCUMENTOS');
$pathUpload = STORAGE_FOLDER_RE;
$pathSave = '/STORAGE/Multipagos/DOCUMENTOS/';
/* var_dump($pathUpload, $pathSave);die; //*/

$cargado = 1;
$idDocumento = 0;
$mensaje = 'ok';
$estatus= "";

$nIdTipoDoc	= $_POST['nIdTipoDoc'];
$nIdCliente = $_POST['nIdCliente'];
$rfc = $_POST['rfc'];

if($_FILES['sFile']) {
    $img = $_FILES['sFile']['name'];
    $tmp = $_FILES['sFile']['tmp_name'];

    switch ($nIdTipoDoc) {
        case 1:
            $abreviatura="ACTACONST";
            break;
        case 2:
            $abreviatura="RFC";
            break;
        case 3:
            $abreviatura="DOMICILIO";
            break;
        case 4:
            $abreviatura="PODER";
            break;
        case 5:
            $abreviatura="REPLID";
            break;
        case 6:
            $abreviatura="CONTRATO";
            break;
        case 7:
            $abreviatura="ADENDO1";
            break;
        case 8:
            $abreviatura="ADENDO2";
            break;
        case 9:
            $abreviatura="ADENDO3";
            break;
        case 10:
            $abreviatura="ID";
            break;
        case 11:
            $abreviatura="CTABANC";
            break;
        case 12:
            $abreviatura="ACTVSAT";
            break;
        default:
            break;
    }

    $STR = $abreviatura;
    $sTipoDoc   = str_pad($nIdTipoDoc, 3, '0', STR_PAD_LEFT);
    $file_name  = $rfc.'_'.$sTipoDoc.'_'.$STR.'.PDF';

    /*
    $sQuery1 = "CALL redefectiva.sp_insert_cliente_documento('$nIdCliente', '$nIdTipoDoc', '**file**', '**path**');";
    $subirArchivo = new SubirArchivo($WBD,'15','pdf');
    $dir = $subirArchivo->limpiarTexto($rfc);
    $pathFile = $pathSave.$dir;
    die;
    //*/

    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    $rutaNC = strtr( $rfc, $unwanted_array );
    $dir = str_replace(' ' , '', $rutaNC . '/');

    if(!is_dir($pathUpload.$dir)){
        mkdir($pathUpload.$dir, '0777', true);
    }

    if(in_array($ext, $valid_extensions)) {
        $file_name = strtr( $file_name, $unwanted_array );
        $file_name = str_replace(' ' , '', $file_name);
        if(copy($tmp, $pathUpload.$dir.'/'.$file_name)){
            $estatus=1;
            $mensaje="Archivo Cargado Correctamente";

            $pathFile = $pathSave.$dir;
            $sQuery1 = "CALL redefectiva.sp_insert_cliente_documento('$nIdCliente', '$nIdTipoDoc', '$file_name', '$pathFile');";
            $resultdocs = $WBD->query($sQuery1);
            $DATS = mysqli_fetch_array($resultdocs);
            $idDocumento = $DATS['nIdDocumento'];

        }else{
            $estatus=2;
            $mensaje="ERROR: No se pudo cargar el archivo $file_name, verifique los permisos";
        }
    } else {
        $mensaje="Archivo Invalido";
        $estatus=3;
    }
}

$jsong = json_encode(array(
  "estatus" =>$estatus,
  "mensaje"=>$mensaje,
  "url"=>$pathSave.$dir.$file_name,
  "idDoc"=>$idDocumento
));

echo $jsong;

?>
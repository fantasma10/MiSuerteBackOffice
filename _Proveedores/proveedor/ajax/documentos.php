    <?php
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    $valid_extensions = array('pdf');
    $path = '../documentos/';
    $cargado = 1;
    $idDocumento = 0;
    $mensaje = 'ok';
    $nIdTipoDoc = $_POST['nIdTipoDoc'];
    $rfc = strtoupper($_POST['rfc']);
    $usuario = $_POST['usr'];
    $estatus="";
    if($_FILES['sFile']){
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
        default:
            break;
    }  
    $STR = $abreviatura;
    $sTipoDoc   = str_pad($nIdTipoDoc, 3, '0', STR_PAD_LEFT);
    $file_name  = $rfc.'_'.$sTipoDoc.'.PDF';


    // $file_name  = $rfc.'_'.$sTipoDoc.'_'.$STR.'.PDF';
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        if(!is_dir($path)){
            mkdir($path, '0777', true);
        }
        if(in_array($ext, $valid_extensions)){ 
            if(copy($tmp,$path.$file_name)){
                $estatus=1;
                $mensaje="Archivo Cargado Correctamente";
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
  "url"=>$path.$file_name,
  "IdTipoDoc"=>$nIdTipoDoc,
));
echo $jsong;
?>
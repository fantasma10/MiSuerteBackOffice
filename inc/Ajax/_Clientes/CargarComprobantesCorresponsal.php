<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$hfiscal = (isset($_POST['hfiscal'])) ? $_POST['hfiscal'] : 0;

$band = false;
$bandtam = true;

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);
$oCorresponsal->setID($_SESSION['idPreCorresponsal']);

if ( $hfiscal == 0 ) {
	if ( $_FILES['fudomicilio']['error'] != 0 && $_FILES['fucabanco']['error'] != 0 ) {
		header('Location: ../../../_Clientes/Corresponsal/Crear5.php');
	}
} else {
	if ( $_FILES['fudomicilio']['error'] != 0 && $_FILES['fucabanco']['error'] != 0 ) {
		header('Location: ../../../_Clientes/Corresponsal/Crear5.php');
	}
}

//Comprobante Domicilio
if(isset($_FILES['fudomicilio']) && $_FILES['fudomicilio']['name'] != ''){
    $RUTACOMPROBANTES = "../../../archivos/Comprobantes/";
	$size  = $_FILES['fudomicilio']['size'];
    $nombre = $_FILES['fudomicilio']['name'];
    $tmpname = $_FILES['fudomicilio']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fudomicilio']['name']));
    $nombreencriptado = md5($_FILES['fudomicilio']['name'].$time."1").".".$extension[1];
    $ruta = $RUTACOMPROBANTES.md5($_FILES['fudomicilio']['name'].$time."1").".".$extension[1];

    if(round(($size/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
            $sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
			$result = $WBD->SP($sql);
			if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oCorresponsal->setDDomicilio($id);
					if($hfiscal == 1){
						$oCorresponsal->setDFiscal($id);
					}
					$band = true;
				} else {
					$band = false;
				}
            }else{
                $band = false;
            }
        }else {
           $band = false;
        }
    }else{
        $bandtam = true;
    }
}

//Comprobante Caratula Banco
if(isset($_FILES['fucabanco']) && $_FILES['fucabanco']['name'] != ''){
    $RUTACOMPROBANTES = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fucabanco']['size'];
    $nombre = $_FILES['fucabanco']['name'];
    $tmpname = $_FILES['fucabanco']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fucabanco']['name']));
    $nombreencriptado = md5($_FILES['fucabanco']['name'].$time."2").".".$extension[1];
    $ruta = $RUTACOMPROBANTES.md5($_FILES['fucabanco']['name'].$time."2").".".$extension[1];
    
    if(round(($_FILES['fucabanco']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
            $result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oCorresponsal->setDBanco($id);
					$band = true;
				} else {
					$band = false;
				}
            }else{
                $band = false;
            }
        }else {
           $band = false;
        }
    }else{
        $bandtam = true;
    }
}

if($band){
    $oCorresponsal->setPreRevisadoCargos(false);
    $oCorresponsal->setPreRevisadoBancos(false);
    $oCorresponsal->setPreRevisadoVersion(false);
    $oCorresponsal->setPreRevisadoDocumentacion(false);
    $oCorresponsal->setPreRevisadoGenerales(false);
    $oCorresponsal->setPreRevisadoDireccion(false);
    $oCorresponsal->setPreRevisadoContactos(false);
    $oCorresponsal->setPreRevisadoCuenta(false);
    $oCorresponsal->setRevisadoCargos(false);
    $oCorresponsal->setRevisadoBancos(false);
    $oCorresponsal->setRevisadoVersion(false);
    $oCorresponsal->setRevisadoDocumentacion(false);
    $oCorresponsal->setRevisadoGenerales(false);
    $oCorresponsal->setRevisadoDireccion(false);
    $oCorresponsal->setRevisadoContactos(false);
    $oCorresponsal->setRevisadoEjecutivos(false);
    $oCorresponsal->setRevisadoCuenta(false);
    $oCorresponsal->setRevisadoContrato(false);
    $oCorresponsal->setRevisadoForelo(false);
    if($oCorresponsal->GuardarXML())
        header('Location: ../../../_Clientes/Corresponsal/Crear5.php?v=""');
    else
        header('Location: ../../../_Clientes/Corresponsal/Crear5.php');
}
if(!$bandtam)
    header('Location: ../../../_Clientes/Corresponsal/Crear5.php?r=""');

?>
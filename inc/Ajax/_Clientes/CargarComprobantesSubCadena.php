<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$band = false;
$bandtam = true;

$oSubcadena = new XMLPreSubCad($RBD,$WBD);
$oSubcadena->load($_SESSION['idPreSubCadena']);
$oSubcadena->setID($_SESSION['idPreSubCadena']);

$mismaDireccionPaso2 = isset($_POST['mismaDireccionPaso2'])? $_POST['mismaDireccionPaso2'] : -500;

if ( $_FILES['fudomicilio']['error'] != 0 && $_FILES['fucabanco']['error'] != 0
	&& $_FILES['fursocial']['error'] != 0 && $_FILES['fuactacons']['error'] != 0
	&& $_FILES['fupoderes']['error'] != 0 && $_FILES['fuidenrep']['error'] != 0
	&& $_FILES['fudomiciliofiscal']['error'] != 0 ) {
	header('Location: ../../../_Clientes/SubCadena/Crear7.php');
}

//Comprobante Domicilio
if(isset($_FILES['fudomicilio']) && $_FILES['fudomicilio']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fudomicilio']['size'];
    $nombre = $_FILES['fudomicilio']['name'];
    $tmpname = $_FILES['fudomicilio']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fudomicilio']['name']));
    $nombreencriptado = md5($_FILES['fudomicilio']['name'].$time."1").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fudomicilio']['name'].$time."1").".".$extension[1];
	//var_dump("ruta: $ruta");
    if(round(($size/1024)) <= 2000){
		if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
			$result = $WBD->SP($sql);
			if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDDomicilio($id);
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

//Comprobante Domicilio
if(isset($_FILES['fudomiciliofiscal']) && $_FILES['fudomiciliofiscal']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fudomiciliofiscal']['size'];
    $nombre = $_FILES['fudomiciliofiscal']['name'];
    $tmpname = $_FILES['fudomiciliofiscal']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fudomiciliofiscal']['name']));
    $nombreencriptado = md5($_FILES['fudomiciliofiscal']['name'].$time."1").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fudomiciliofiscal']['name'].$time."1").".".$extension[1];
    
    if(round(($size/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
            $sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
			$result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDFiscal($id);
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
} else {
	if ( $mismaDireccionPaso2 == -500 ) {
		if ( $oSubcadena->getDFiscal() == '' ) {
			$oSubcadena->setDFiscal('');
		}
	} else {
		$idComprobanteDomicilio = $oSubcadena->getDDomicilio();
		$oSubcadena->setDFiscal($idComprobanteDomicilio);			
	}
}

//Comprobante Caratula Banco
if(isset($_FILES['fucabanco']) && $_FILES['fucabanco']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fucabanco']['size'];
    $nombre = $_FILES['fucabanco']['name'];
    $tmpname = $_FILES['fucabanco']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fucabanco']['name']));
    $nombreencriptado = md5($_FILES['fucabanco']['name'].$time."2").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fucabanco']['name'].$time."2").".".$extension[1];
    
    if(round(($_FILES['fucabanco']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
            $result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDBanco($id);
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

//Comprobante Identificacion Representante Legal
if(isset($_FILES['fuidenrep']) && $_FILES['fuidenrep']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fuidenrep']['size'];
    $nombre = $_FILES['fuidenrep']['name'];
    $tmpname = $_FILES['fuidenrep']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fuidenrep']['name']));
    $nombreencriptado = md5($_FILES['fuidenrep']['name'].$time."3").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fuidenrep']['name'].$time."3").".".$extension[1];
    
    if(round(($_FILES['fuidenrep']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
            $result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDRepLegal($id);
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

//Comprobante RFC Razon Social
if(isset($_FILES['fursocial']) && $_FILES['fursocial']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fursocial']['size'];
    $nombre = $_FILES['fursocial']['name'];
    $tmpname = $_FILES['fursocial']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fursocial']['name']));
    $nombreencriptado = md5($_FILES['fursocial']['name'].$time."4").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fursocial']['name'].$time."4").".".$extension[1];
    
    if(round(($_FILES['fursocial']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
            $result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDRSocial($id);
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

//Comprobante Acta Constitutiva
if(isset($_FILES['fuactacons']) && $_FILES['fuactacons']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fuactacons']['size'];
    $nombre = $_FILES['fuactacons']['name'];
    $tmpname = $_FILES['fuactacons']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fuactacons']['name']));
    $nombreencriptado = md5($_FILES['fuactacons']['name'].$time."5").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fuactacons']['name'].$time."5").".".$extension[1];
    
    if(round(($_FILES['fuactacons']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
            $sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
			$result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDAConstitutiva($id);
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

//Comprobante Poderes
if(isset($_FILES['fupoderes']) && $_FILES['fupoderes']['name'] != ''){
    $directorio = "../../../archivos/Comprobantes/";
    $size  = $_FILES['fupoderes']['size'];
    $nombre = $_FILES['fupoderes']['name'];
    $tmpname = $_FILES['fupoderes']['tmp_name'];
    $time = date("Y-m-d H:i:s");
    $extension = explode(".", strtolower($_FILES['fupoderes']['name']));
    $nombreencriptado = md5($_FILES['fupoderes']['name'].$time."6").".".$extension[1];
    $ruta = $directorio.md5($_FILES['fupoderes']['name'].$time."6").".".$extension[1];
    
    if(round(($_FILES['fupoderes']['size']/1024)) <= 2000){
        if(move_uploaded_file($tmpname, $ruta)) {
			$sql = "CALL `prealta`.`SP_GUARDAR_ARCHIVO`('$nombre', '$nombreencriptado', '$ruta', '$size', '$extension[1]', {$_SESSION['idU']});";
            $result = $WBD->SP($sql);
            if($WBD->error() == ''){
				if ( $result->num_rows > 0 ) {
					list( $id ) = $result->fetch_array();
					$oSubcadena->setDPoderes($id);
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
	$oSubcadena->setPreRevisadoVersion(false);
    $oSubcadena->setPreRevisadoCargos(false);
    $oSubcadena->setPreRevisadoGenerales(false);
    $oSubcadena->setPreRevisadoDireccion(false);
    $oSubcadena->setPreRevisadoContactos(false);
    $oSubcadena->setPreRevisadoEjecutivos(false);
    $oSubcadena->setPreRevisadoDocumentacion(false);
    $oSubcadena->setPreRevisadoCuenta(false);
    $oSubcadena->setPreRevisadoContrato(false);
    $oSubcadena->setRevisadoCargos(false);
    $oSubcadena->setRevisadoDocumentacion(false);
    $oSubcadena->setRevisadoGenerales(false);
    $oSubcadena->setRevisadoDireccion(false);
    $oSubcadena->setRevisadoContactos(false);
    $oSubcadena->setRevisadoEjecutivos(false);
    $oSubcadena->setRevisadoCuenta(false);
    $oSubcadena->setRevisadoVersion(false);
    $oSubcadena->setRevisadoContrato(false);
    $oSubcadena->setRevisadoForelo(false);

    if($oSubcadena->GuardarXML()){
        $oSubcadena->CalcularPorcentaje();
        header('Location: ../../../_Clientes/SubCadena/Crear7.php?v=""');
    } else {
        header('Location: ../../../_Clientes/SubCadena/Crear7.php');
	}
}

if(!$bandtam){
    header('Location: ../../../_Clientes/SubCadena/Crear7.php?r=""');
}

?>
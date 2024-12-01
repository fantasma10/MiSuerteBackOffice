<?php	
$id = (isset($_GET['id'])) ? $_GET['id'] : "";
$tipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : "";
$file = "";
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");
if($id != '' && $tipo != ''){
	$oSubCadena = new XMLPreSubCad($RBD,$WBD);
	$oSubCadena->load($_SESSION['idPreSubCadena']);
	$file = "../../../archivos/Comprobantes/";
	echo "...".$file."...";
	switch($tipo){
		case 0:$file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 1: $file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 2: $file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 3: $file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 4: $file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 5: $file.= $oSubCadena->getNombreDocumento($id);
			break;
		case 6: $file.= $oSubCadena->getNombreDocumento($id);
	}
	echo $file;
	
	if(file_exists($file)) {
	  header('Content-Description: File Transfer');
	  header('Content-Type: application/octet-stream');
	  header('Content-Disposition: attachment; filename='.basename($file));
	  header('Content-Transfer-Encoding: binary');
	  header('Expires: 0');
	  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	  header('Pragma: public');
	  header('Content-Length: '.filesize($file));
	  ob_clean();
	  flush();
	  readfile($file);
	  die();
	  exit;
	}else{
		echo "No se encontro el archivo";
	}
}
?>
<?php	
$id = (isset($_GET['id'])) ? $_GET['id'] : "";
$tipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : "";
$file = "";
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");
if($id != '' && $tipo != ''){
	$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
	$oCorresponsal->load($_SESSION['idPreCorresponsal']);
	$file = "../../../archivos/Comprobantes/";
	echo "...".$file."...";
	switch($tipo){
		case 0:$file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 1: $file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 2: $file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 3: $file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 4: $file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 5: $file.= $oCorresponsal->getNombreDocumento($id);
			break;
		case 6: $file.= $oCorresponsal->getNombreDocumento($id);
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
<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");


$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 0;




switch($tipo){


	case 1 :


	$fileElementName = 'progol';
	$myFile = $_FILES[$fileElementName]["tmp_name"];


	$dir = "../../../STORAGE/progol/*";


	$nombre = "Pgol";


	/*foreach(glob($dir."*.xml") as $file) {

		$url = $file;
		$archivo = basename($url);


		$extension = pathinfo($archivo, PATHINFO_EXTENSION);
		$nombre_base = basename($archivo, '.'.$extension);
		$porciones = explode("_", $nombre_base);


		if ($porciones[0] == $nombre) {
			$local_file = $url;
		}

	}*/



	$xml = new XMLReader();

	$xml->open($myFile);

	$xmls = simplexml_load_file($myFile);

	$assoc = xml2assoc($xml);

	$conteoInsercion = 0;
	$index = 0;

	$datos = array();

	foreach ($xmls->EventRecord as $listing)
	{

		$set_num = $listing[0]["set_num"];
		$event_num = $listing[0]["event_num"];
		$local = $listing[0]["local_name"];
		$visitor_name = $listing[0]["visitor_name"];
		$draw = $assoc[$nombre][0]["attributes"]["draw_num"];



		$datos[$index]["set_num"] = $set_num;
		$datos[$index]["event_num"] = $event_num;
		$datos[$index]["local_name"] = $local;
		$datos[$index]["visitor_name"] = $visitor_name;
		$datos[$index]["draw_num"] = $draw;
		$index++;


	}


	$xml->close();

	print json_encode($datos);


	break;




	case 2 :

$fileElementName = 'xgol';
$myFile = $_FILES[$fileElementName]["tmp_name"];

	$dir = "../../../STORAGE/progol/*";


	$nombre = "Xgol";


	/*foreach(glob($dir."*.xml") as $file) {

		$url = $file;
		$archivo = basename($url);


		$extension = pathinfo($archivo, PATHINFO_EXTENSION);
		$nombre_base = basename($archivo, '.'.$extension);
		$porciones = explode("_", $nombre_base);


		if ($porciones[0] == $nombre) {
			$local_file = $url;
		}

	}*/



	$xml = new XMLReader();

	$xml->open($myFile);

	$xmls = simplexml_load_file($myFile);

	$assoc = xml2assoc($xml);

	$conteoInsercion = 0;
	$index = 0;

	$datos = array();

	foreach ($xmls->EventRecord as $listing)
	{

		$set_num = $listing[0]["set_num"];
		$event_num = $listing[0]["event_num"];
		$local = $listing[0]["local_name"];
		$visitor_name = $listing[0]["visitor_name"];
		$draw = $assoc[$nombre][0]["attributes"]["draw_num"];



		$datos[$index]["set_num"] = $set_num;
		$datos[$index]["event_num"] = $event_num;
		$datos[$index]["local_name"] = $local;
		$datos[$index]["visitor_name"] = $visitor_name;
		$datos[$index]["draw_num"] = $draw;
		$index++;


	}


	$xml->close();

	print json_encode($datos);


	break;


	case 3 :

	$dir = "../../../STORAGE/progol/*";

	$juego  =+ (!empty($_POST["juego"]))? $_POST["juego"] : 0;



	if($juego == 1){
		$fileElementName = "progol";
		$nombre = "Pgol";
		$procedure = "sp_insert_juego_progol";	
	}else{
		$fileElementName = "xgol";
		$nombre = "Xgol";
		$procedure = "sp_insert_juego_progol_media";
	}



	$myFile = $_FILES[$fileElementName]["tmp_name"];



	/*foreach(glob($dir."*.xml") as $file) {

		$url = $file;
		$archivo = basename($url);


		$extension = pathinfo($archivo, PATHINFO_EXTENSION);
		$nombre_base = basename($archivo, '.'.$extension);
		$porciones = explode("_", $nombre_base);


		if ($porciones[0] == $nombre) {
			$local_file = $url;
		}

	}*/



	$xml = new XMLReader();

	$xml->open($myFile);

	$xmls = simplexml_load_file($myFile);

	$assoc = xml2assoc($xml);

	$conteoInsercion = 0;
	$index = 0;

	$datos = array();

	foreach ($xmls->EventRecord as $listing)
	{

		
		$set_num = $listing[0]["set_num"];
		$event_num = $listing[0]["event_num"];
		$local = $listing[0]["local_name"];
		$visitor_name = $listing[0]["visitor_name"];
		$draw = $assoc[$nombre][0]["attributes"]["draw_num"];



		$sql = $MWDB->query("CALL `pronosticos`.`$procedure`('$draw','$set_num','$event_num','$local','$visitor_name','0','$conteoInsercion')");



		if(!$MWDB->error()){
			while($row = mysqli_fetch_assoc($sql)){
															
				$insertados =+ $row["insertados"];
				$actualizados =+ $row["actualizados"];
				$inserciones = $inserciones + $insertados;
				$actualizaciones = $actualizaciones + $actualizados;
				$totalRegistros = $inserciones + $actualizaciones;
			}


		}else{
			echo json_encode(array(
		    	"showMessage"   => 1,
		    	"msg"           => "Ha ocurrido un Error, Inténtelo de Nuevo Más Tarde",
		    	"errmsg"        => $MWDB->error()
		    ));
		}


	}

	echo json_encode(array(
		    	"showMessage"   => 0,
		    	"msg"           => "Procedimiento Ejecutado con exito",
		    	"insertados"        => $inserciones,
		    	"actualizados"        => $actualizaciones,
		    	"total"        => $totalRegistros
		    ));


	$xml->close();

break;

}

function xml2assoc($xml) {
	$assoc = null;
	while($xml->read()){
		switch ($xml->nodeType) {
			case XMLReader::END_ELEMENT: return $assoc;
			case XMLReader::ELEMENT:
			$assoc[$xml->name] = array('value' => $xml->isEmptyElement ? '' : xml2assoc($xml));
			if($xml->hasAttributes){
				$el =& $assoc[$xml->name][count($assoc[$xml->name]) - 1];
				while($xml->moveToNextAttribute()) $el['attributes'][$xml->name] = utf8_decode($xml->value);
			}
			break;
			case XMLReader::TEXT:
			case XMLReader::CDATA: $assoc .= $xml->value;
		}
	}
	return $assoc;
}



?>
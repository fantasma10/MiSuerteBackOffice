<?php 

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
$ruta = $_SERVER['DOCUMENT_ROOT'].'\amp\anuncios\imagenes';





$obj = new guardar_conf_anuncio();

$sArchivo = $_FILES['imgAnuncio'];
$imageString = file_get_contents($sArchivo['tmp_name']);
   /*file_put_contents($ruta.'\/'.pathinfo($sArchivo['name'],PATHINFO_FILENAME).'.webp',$imageString);
   $rutaImagen = $ruta.'\/'.pathinfo($sArchivo['name'],PATHINFO_FILENAME).'.webp';
   $rutaAWS = 'aquimispagos/anuncios/'.pathinfo($sArchivo['name'],PATHINFO_FILENAME).'.webp';
	//$responseAWS = subirImagenAWS($_key_aquimispagos,$_secret_aquimispagos,$_region_aquimispagos,$bucket_aquimispagos,$rutaImagen,$rutaAWS);
	
      /* if (!file_exists($ruta)) {
            @mkdir($ruta, 0700, true);
       }*/


/*$obj->setoRAMP($oRAMP);
$obj->setsNombre($_POST['txtNombre']);
$obj->setsDescripcion($_POST['txtDescripcion']);
$obj->setUrlAws($responseAWS['url']);*/

$imagenComoBase64 = base64_encode($imageString);
$jsonData=array('case'=>1,
				'txtNombre'=>$_POST['txtNombre'],
				'txtDescripcion'=>$_POST['txtDescripcion'],
				'nombreImg'=>pathinfo($sArchivo['name'],PATHINFO_FILENAME),
				'ImgAnuncio'=>$imagenComoBase64 
			);

try{
$URL='http://10.10.1.213:8089/index.php/CargaAnuncioBackOffice';
//$URL='http://10.10.250.121:8088/index.php/CargaAnuncioBackOffice';
$ch = curl_init();

//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result['resultado'] = curl_exec ($ch);
$info = curl_getinfo($ch);
curl_close ($ch);
}catch(Exception $R){
	echo $R.'asdsa';
}
$result['resultado'] =(array) json_decode($result['resultado']);
$result['data'] = $result['resultado'] ;
$result['responseAWS'] = 0;
if(isset($result['resultado'][0]->ID))
  $result['responseAWS'] = 1;
/*$result=$obj->guardarAnuncio();*/
/*$result['responseAWS'] = $responseAWS['sMensajeWS'];*/

echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => $result
));

?>
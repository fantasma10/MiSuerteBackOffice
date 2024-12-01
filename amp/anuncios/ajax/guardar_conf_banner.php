<?php

class guardar_conf_banner{
    private $sNombre;
    private $sDescripcion;
    private $sUrlTemp;
    private $sUrlTemp2;
    private $sUrlTemp3;

    function setsNombre($sNombre){
        $this->sNombre=$sNombre;
    }
    function setsDescripcion($sDescripcion){
        $this->sDescripcion=$sDescripcion;
    }
    function setsUrlTemp($sUrlTemp){
        $this->sUrlTemp=$sUrlTemp;
    }   
    function setsUrlTemp2($sUrlTemp2){
        $this->sUrlTemp2=$sUrlTemp2;
    }   
    function setsUrlTemp3($sUrlTemp3){
        $this->sUrlTemp3=$sUrlTemp3;
    }

    function guardarBanner(){
       include($_SERVER['DOCUMENT_ROOT'] . "/inc/lib/s3/aws-autoloader.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");

       $ruta = $_SERVER['DOCUMENT_ROOT'].'\amp\anuncios\banners';
       if (!file_exists($ruta)) {
            @mkdir($ruta, 0700, true);
       }
        $sinExtension1 = pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME);
        $imageString = file_get_contents($this->sUrlTemp['tmp_name']);
        file_put_contents($ruta.'\/'.$sinExtension1.'.webp',$imageString);
        $rutaImagen = $ruta.'\/'.$sinExtension1.'.webp';
        $rutaAWS = 'aquimispagos/banners/'.$sinExtension1.'.webp';
        $responseAWS = subirImagenAWS($_key_aquimispagos,$_secret_aquimispagos,$_region_aquimispagos,$bucket_aquimispagos,$rutaImagen,$rutaAWS);

        $sinExtension2 = pathinfo($this->sUrlTemp2['name'],PATHINFO_FILENAME);
        $imageString2 = file_get_contents($this->sUrlTemp2['tmp_name']);
        file_put_contents($ruta.'\/'.$sinExtension2.'.webp',$imageString2);
        $rutaImagen = $ruta.'\/'.$sinExtension2.'.webp';
        $rutaAWS = 'aquimispagos/banners/'.$sinExtension2.'.webp';
        $responseAWS2 = subirImagenAWS($_key_aquimispagos,$_secret_aquimispagos,$_region_aquimispagos,$bucket_aquimispagos,$rutaImagen,$rutaAWS);

        $sinExtension3 = pathinfo($this->sUrlTemp3['name'],PATHINFO_FILENAME);
        $imageString3 = file_get_contents($this->sUrlTemp3['tmp_name']);
        file_put_contents($ruta.'\/'.$sinExtension3.'.webp',$imageString3);
        $rutaImagen = $ruta.'\/'.$sinExtension3.'.webp';
        $rutaAWS = 'aquimispagos/banners/'.$sinExtension3.'.webp';
        $responseAWS3 = subirImagenAWS($_key_aquimispagos,$_secret_aquimispagos,$_region_aquimispagos,$bucket_aquimispagos,$rutaImagen,$rutaAWS);


       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
        $param = array
        (   array(
                'name'  => 'sNombre',
                'type'  => 's',
                'value' => $this->sNombre),
            array(
                'name'  => 'p_sAnuncio1',
                'type'  => 's',
                'value' => $responseAWS['url']),    
            array(
                'name'  => 'p_sAnuncio2',
                'type'  => 's',
                'value' => $responseAWS2['url']),    
            array(
                'name'  => 'p_sAnuncio3',
                'type'  => 's',
                'value' => $responseAWS3['url'])  
        );
        $oRAMP->setSStoredProcedure('sp_insert_carrusel_banner');
        $oRAMP->setParams($param);
        $result2 = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();

         $ArrayRetorno['data'] = $data;
         $ArrayRetorno['responseAWS'] = $responseAWS['sMensajeWS'];
         $ArrayRetorno['responseAWS2'] = $responseAWS2['sMensajeWS'];
         $ArrayRetorno['responseAWS3'] = $responseAWS3['sMensajeWS'];

        return $ArrayRetorno;   
    }
  
}

$obj = new guardar_conf_banner();

$sArchivo = $_FILES['imgBanner'];
$sArchivo2 = $_FILES['imgBanner2'];
$sArchivo3 = $_FILES['imgBanner3'];
$obj->setsUrlTemp($sArchivo);
$obj->setsUrlTemp2($sArchivo2);
$obj->setsUrlTemp3($sArchivo3);
$obj->setsNombre($_POST['txtNombreBanner']);

$result=$obj->guardarBanner();

echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => $result
));
?>
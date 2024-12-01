<?php
use Aws\S3\S3Client; 

class guardar_conf_anuncio{
    private $sNombre;
    private $sDescripcion;
    private $sUrlTemp;
    private $sUrlAWS;

    function setsNombre($sNombre){
        $this->sNombre=$sNombre;
    }
    function setsDescripcion($sDescripcion){
        $this->sDescripcion=$sDescripcion;
    }
    function setsUrlTemp($sUrlTemp){
        $this->sUrlTemp=$sUrlTemp;
    }
    function setsUrlAWS($sUrlAWS){
        $this->sUrlAWS=$sUrlAWS;
    }

    function guardarAnuncio(){
       include($_SERVER['DOCUMENT_ROOT'] . "/inc/lib/s3/aws-autoloader.php");
       include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
       $ruta = $_SERVER['DOCUMENT_ROOT'].'\amp\anuncios\imagenes';
       
       $imageString = file_get_contents($this->sUrlTemp['tmp_name']);
       file_put_contents($ruta.'\/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp',$imageString);
       $rutaImagen = $ruta.'\/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp';
       $rutaAWS = 'aquimispagos/anuncios/'.pathinfo($this->sUrlTemp['name'],PATHINFO_FILENAME).'.webp';

        $urlpng = $rutaImagen;
      $nombreArchivo = $rutaAWS;
      /*AWS*/
      $s3       = null;
      $s3           = S3Client::factory(array(
      'credentials' => array(
        'key'         => $_key_aquimispagos,
        'secret'      => $_secret_aquimispagos
      ),
        'version'     => 'latest',
        'region'      => $_region_aquimispagos
      ));
      /*AWS*/
      $file = fopen($urlpng, 'rb');

      $object = $s3->upload(
      $bucket_aquimispagos, //bucket
      $nombreArchivo, //key, unique by each object
      $file,'public-read' //where is the file to upload?
      // ,'public-read'
      );
      $code = $object['@metadata']['statusCode'];
      $response['url'] = $object['ObjectURL'];
      fclose($file);
      if ($code  == 200) {
        //guardar direccion de la imagen
        $response['sMensajeWS'] = 1;
      }
      else{
        $response['sMensajeWS'] = 0;  
      }
      unlink($urlpng);



       if (!file_exists($ruta)) {
            @mkdir($ruta, 0700, true);
       }

       $oRAMP->setSDatabase('aquimispagos');
       $data=array();
        
                $param = array
                (   array(
                        'name'  => 'sNombre',
                        'type'  => 's',
                        'value' => $this->sNombre),
                    array(
                        'name'  => 'sDescripcion',
                        'type'  => 's',
                        'value' => $this->sDescripcion),
                    array(
                        'name'  => 'sPath',
                        'type'  => 's',
                        'value' => $responseAWS['url'])    
                );
                $oRAMP->setSStoredProcedure('sp_insert_anuncio');
                $oRAMP->setParams($param);
                $result2 = $oRAMP->execute();
                $data = $oRAMP->fetchAll();
                $oRAMP->closeStmt();
            
                 
                 $ArrayRetorno['data'] = $data[0]['ID'];
                 $ArrayRetorno['responseAWS'] = $responseAWS['sMensajeWS'];
                 $ArrayRetorno['url'] = $responseAWS['url'];
                 
                print_r($ArrayRetorno);
        return $ArrayRetorno;   
    }
  
}

$obj = new guardar_conf_anuncio();

$sArchivo = $_FILES['imgAnuncio'];
$obj->setsUrlTemp($sArchivo);
$obj->setsNombre($_POST['txtNombre']);
$obj->setsDescripcion($_POST['txtDescripcion']);


$result=$obj->guardarAnuncio();

echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => $result
));

?>
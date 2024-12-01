<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/factura/s3/aws-autoloader.php");
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


	$flag          = false;

	$UUID          = !empty($_POST['UUID'])? $_POST['UUID'] : '';
	$nombreArchivo = 'facturas_clientes/'.$UUID.'.PDF'; 
	
	$s3 = null;

    $s3 = S3Client::factory(array(
      'credentials' => array(
        'key'         => $_key,
        'secret'      => $_secret
      ),
      'version' => 'latest',
      'region'  => $_region
    ));

	$result        = $s3->doesObjectExist($bucket,$nombreArchivo);
	if($result)
	{ 
		$flag          = true;
		$cmd           = $s3->getCommand('GetObject', array(
							'Bucket'       => $bucket,
							'Key'          => $nombreArchivo
						));
		$request       = $s3->createPresignedRequest($cmd, '+20 minute');
		$objectUrl     = (string) $request->getUri();
	}
	// fclose($file);
	//unlink($link);
 
  $resultado = array(
    'bExito'  => $flag,
    'nCodigo' => 0,
    'sMensaje'  => 'Ok',
    'data'    => $objectUrl,
    'url' => $objectUrl,
    'UUID' => $UUID 
  );

  echo json_encode($resultado);
?>
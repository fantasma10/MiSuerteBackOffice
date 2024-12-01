<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/paycash/ajax/s3/aws-autoloader.php");
use Aws\S3\S3Client;

$data=array();

if ($_POST){
/* tipo:
1:Buscar proveedor*/

$tipo=$_POST['tipo'];
	 
	 if ($tipo==1){
		 $array_params = array(
			array(
				'name'	=> 'IdProveedor',
				'type'	=> 'i',
				'value'	=> $_POST['idproveedor']
			)
		);
	
		$oRdb->setSDatabase('paycash_one');
		$oRdb->setSStoredProcedure('sp_select_proveedor_ext');
		$oRdb->setParams($array_params);

		$result = $oRdb->execute();

		$data = $oRdb->fetchAll();
		$data =utf8ize($data);
	 }else if ($tipo==2){
		 $array_params = array(
			array(
				'name'	=> 'nIdDocumento',
				'type'	=> 'i',
				'value'	=> $_POST['nIdDocumento']
			)
		);
		
		$oRdb->setSDatabase('paycash_one');
		$oRdb->setSStoredProcedure('sp_select_documentos');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();
		$row = $oRdb->fetchAll();
		
		$s3       = null;
		$bucket   = 'paycash-storage';
		$_key     = 'AKIAJUVK33EOQCSN43PA';
		$_secret  = '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';
		$nombreArchivo=$row[0]['sDocumento'];
	
		$s3 = S3Client::factory(array(
			'credentials' => array(
			  'key'         => $_key,
			  'secret'      => $_secret
			),
			'version' => 'latest',
			'region'  => 'us-east-1'
		  ));
		  /*AWS*/
		$cmd = $s3->getCommand('GetObject', array(
			'Bucket' => $bucket,
			'Key'    => $nombreArchivo
		  ));
		$request = $s3->createPresignedRequest($cmd, '+50 minute');
		$presignedUrl = (string) $request->getUri();
	
		$data= array("ruta" => utf8ize($presignedUrl) );
	 }
		echo json_encode($data );
}
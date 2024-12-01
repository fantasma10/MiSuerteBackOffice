<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
include($_SERVER['DOCUMENT_ROOT']."/paycash/ajax/s3/aws-autoloader.php");
use Aws\S3\S3Client;

$data=array();

if ($_POST){
/* tipo:
	1.Buscar Premisor
	2.Autorizar Premisor
	3.Busca Documento Premisor
*/
	$tipo=$_POST['tipo'];
	
	if ($tipo==2){
		 
		$array_params = array(
			array(
				'name'	=> 'nIdPreemisor',
				'type'	=> 'i',
				'value'	=> $_POST["p_nIdPreemisor"]
			)
		);

		$oRdb->setSDatabase('paycash_preafiliacion');
		$oRdb->setSStoredProcedure('sp_procesa_autoriza_preemisor');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();
		if ( $result['nCodigo'] ==0){
			$data = $oRdb->fetchAll();
			$oRdb->closeStmt();
			$data =utf8ize($data);
			
			$nIdProveedor=$data[0]['nIdProveedor'];
			$sRfc = $data[0]['sRfc'];
			$sEmail = $data[0]['sEmail'];
			$sRazonSocial = $data[0]['sRazonSocial'];
			$sTelefono = $data[0]['sTelefono'];
			
			$sHost = "0";
			$date = date("Y-m-d h:i:s");
				
			$sTelefono = str_replace(array('(', ')', '-', ' '), '', $sTelefono);
			$date=date("Y-m-d h:i:s");
			$params = array(
						"type" => "merchant.partner.approved",
						"event_date" => $date,
						"merchant_partner_notification" => array(
							"taxid" => $sRfc,
							"email" => $sEmail,
							"name" => $sRazonSocial,
							"phone" => $sTelefono,
							"emisor" => $nIdProveedor,
							"host" => "0"
					));

			$data = json_encode($params);
			$url = "https://pruebas.junomx.com/TecSou.Banks.Web/Affiliation/notification";

			$array_headers = array(
						'Accept:application/json',
						'Content-Type:application/json',
						'PROVIDER:PAYCASH'
					);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $array_headers);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLINFO_HEADER_OUT, true);
					$response = curl_exec($ch);
			//loguear respuesta
			
			$array_params[]=array(
					'name'	=> 'sRespuesta',
					'type'	=> 's',
					'value'	=> $response
				);
				
			$oRdb->setSDatabase('paycash_preafiliacion');
			$oRdb->setSStoredProcedure('sp_insert_log');
			$oRdb->setParams($array_params);
			$result = $oRdb->execute();
		}
	}else if($tipo==3){
			 $array_params = array(
			array(
				'name'	=> 'nIdDocumento',
				'type'	=> 'i',
				'value'	=> $_POST['nIdDocumento']
			)
		);
		
		$oRdb->setSDatabase('paycash_preafiliacion');
		$oRdb->setSStoredProcedure('sp_select_documentos');
		$oRdb->setParams($array_params);
		$result = $oRdb->execute();
		$row = $oRdb->fetchAll();
		
		$s3       = null;
		$bucket   = 'paycash-storage';
		$_key     = 'AKIAJUVK33EOQCSN43PA';
		$_secret  = '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';
		$nombreArchivo=$row[0]['sNombreDocumento'];
	
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
	
}

echo json_encode($data );
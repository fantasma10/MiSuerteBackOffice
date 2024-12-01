<?php

include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

if ($_POST){
/* tipo:
1:Buscar de integrador
2:Buscar programacion integrador
3:Buscar documento integrador
4:Url documento
5:Guardar Documento
6:Buscar RFC
*/
	$tipo=$_POST['tipo'];
	 
	 if ($tipo==1){
		 $array_params = array(
			array(
				'name'	=> 'IdIntegrador',
				'type'	=> 'i',
				'value'	=> $_POST['idintegrador']
			)
		);
	
		$oRdb->setSDatabase('paycash_one');
		$oRdb->setSStoredProcedure('sp_select_integrador');
		$oRdb->setParams($array_params);

		$result = $oRdb->execute();

		$data = $oRdb->fetchAll();
		$data =utf8ize($data);
		 
	 } else if ($tipo==2){
		 $array_params = array(
			array(
				'name'	=> 'IdIntegrador',
				'type'	=> 'i',
				'value'	=> $_POST['idintegrador']
			)
		);
		
		//$oRdb->setBDebug(1);

		$oRdb->setSDatabase('paycash_one');
		$oRdb->setSStoredProcedure('sp_select_integrador_programacion');
		$oRdb->setParams($array_params);

		$result = $oRdb->execute();

		$data = $oRdb->fetchAll();
		$data =utf8ize($data);
	 } else if ($tipo==3){
		 	 $array_params = array(
			array(
				'name'	=> 'IdIntegrador',
				'type'	=> 'i',
				'value'	=> $_POST['idintegrador']
			)
		);
		
		//$oRdb->setBDebug(1);

		$oRdb->setSDatabase('paycash_one');
		$oRdb->setSStoredProcedure('sp_select_integrador_documentos');
		$oRdb->setParams($array_params);

		$result = $oRdb->execute();
		$row = $oRdb->fetchAll();
		$data=$row[0]['sIdDocumento'];
		echo $data;
		exit();
		
	 }else if ($tipo==4){
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
		
		$data= array("ruta" => utf8ize($row[0]['sRutaDocumento'].$row[0]['sDocumento']));
		 
	 }else if($tipo==5){
			$cargado = 1;
			$idDocumento = 0;
			$mensaje = 'ok';
			$nIdTipoDoc	= $_POST['p_nIdDocumento'];
			$sFile		= $_FILES['p_sDocumento'];
			$rfc = $_POST['p_sRFC'];
			$usuario = $_POST['usr'];
			$descript = $rfc;
			

			//include ('../repositorioTipoDocumentos.php');
			
			$array_params = array(
			array(
				'name'	=> 'nIdDocumento',
				'type'	=> 'i',
				'value'	=> $nIdTipoDoc
			)
			);
	
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_select_cat_documentos');
			$oRdb->setParams($array_params);

			$result = $oRdb->execute();
			if ( $result['nCodigo']==0){
			$row=$oRdb->fetchAll();
			$STR=strtoupper($row[0]['sNombreDocumento']);
			}
			$oRdb->closeStmt();
			$sTipoDoc	= str_pad($nIdTipoDoc, 3, '0', STR_PAD_LEFT);
			$file_name	= $rfc.'_'.$sTipoDoc.'_'.$STR.'.PDF';
			$dir = $RUTADOCUMENTOS.$rfc.'/';
			
			if(!is_dir($dir)){
			  mkdir($dir, '0777', true);
			}
			$result = copy( $sFile["tmp_name"],$dir.$file_name );
			
			if (!$result) {
			  $mensaje = "ERROR: No se pudo cargar el archivo $filename, verifique los permisos";
			} else {
			  $cargado = 0;
			}
			
			//if($cargado == 0){
				$params = array(
					array(
						'name'	=> 'nIdTipoDocumento',
						'type'	=> 'i',
						'value'	=> $nIdTipoDoc
					),
					array(
						'name'	=> 'sDocumento',
						'type'	=> 's',
						'value'	=> $file_name
					),
					array(
						'name'	=> 'sRutaDocumento',
						'type'	=> 's',
						'value'	=> $dir
					)
				);
				
				$oRdb->setSDatabase('paycash_one');
				$oRdb->setSStoredProcedure('sp_insert_documentos_integrador');
				$oRdb->setParams($params);

				$result = $oRdb->execute();
				

				if ( $result['nCodigo']==0){
					$idDocumento=$oRdb->lastInsertId();
				}
			//}
			$data = array(
					"cargado"=>$cargado,
					"nIdDocumento"=>$idDocumento,
					"mensaje"=>$mensaje);
			
	 }else if($tipo==6){
		 $array_params = array(
			array(
				'name'	=> 'rfc',
				'type'	=> 's',
				'value'	=> $_POST['rfc']
			)
			);
			$oRdb->setSDatabase('paycash_one');
			$oRdb->setSStoredProcedure('sp_select_integrador_rfc');
			$oRdb->setParams($array_params);

			$result = $oRdb->execute();

			$data = $oRdb->fetchAll();
	 }
		
	}
		//header('Content-Type: application/json');
		echo json_encode($data );
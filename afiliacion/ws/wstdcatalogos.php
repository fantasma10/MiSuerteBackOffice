  <?php  
        $HOSTWSTRANSFER		=         "https://sandbox-txservice.redefectiva.net/TDService/Server.asmx?WSDL";
        include "wstransferdirecto.class.php";
         
   
        
        	$arrayMeses = array(
	 	'1'		=> "Enero",
		'2'		=> "Febrero",
		'3'		=> "Marzo",
		'4'		=> "Abril",
		'5'		=> "Mayo",
		'6'		=> "Junio",
		'7'		=> "Julio",
		'8'		=> "Agosto",
		'9'		=> "Septiembre",
		'10'	=> "Octubre",
		'11'	=> "Noviembre",
		'12'	=> "Diciembre",
	);
	################################################
	# Conectar con WS que nos dara los parametros
	################################################

		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto = new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK = $oWsTransferDirecto->createClient();			
		}

		if(!isset($clientOK)){
			$clientOK = $oWsTransferDirecto->createClient();	
		}

		if($clientOK){
			$arrayParametros = array(
				'Encabezado'	=> array(
					'Comercio'		=> 1,
					'Corresponsal'	=> 438,
					'Codigo'		=> 'MQ4DE78H',
					'Caja'			=> 290,
					'CveOperador'	=> 'Operador 8'
				),
				
			);

			$result = $oWsTransferDirecto->TD_GetEnvioParameterList(array(
				'Request'	=> $arrayParametros
			));

			if($result['bExito'] == false || $result['nCodigo'] != 0){
				$showError	= true;
				$nCodigo	= $result['nCodigo'];
				$sMensaje	= $result['sMensaje'];
			}
			else{
				$oResultado = $result['oResultado'];
				$oParams	= $oResultado->TD_GetEnvioParameterListResult->RemesaParam;
				$oRemitente = (isset($oParams->Remitente))? $oParams->Remitente : null;
			}
		}
		else{
			$nCodigo	= 1;
			$sMensaje	= "No fue posible conectarse al Web Service de la siguiente URL: ".$HOSTWSTRANSFER;
			$showError	= true;
		}
##############################################################################################################
	# Buscar Lista de Generos
	##############################################################################################################
		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto = new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK			= $oWsTransferDirecto->createClient();			
		}

		$result = $oWsTransferDirecto->TD_GetGenreList(array(
			'Request' => $arrayParametros
		));

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			$showError	= true;
			$nCodigo	= $result['nCodigo'];
			$sMensaje	= $result['sMensaje'];
		}
		else{
			$oResultado			= $result['oResultado'];
			$resultadoGenero	= $oResultado->TD_GetGenreListResult->GenreList->GenreInfo;
		}

		$arrayGeneroLista = array();

		foreach($resultadoGenero as $objGenero){
			$arrayGeneroLista[] = array(
				'id'	=> $objGenero->id,
				'name'	=> $objGenero->name
			);
		}

	##############################################################################################################
	# Buscar lista de ocupaciones
	##############################################################################################################
		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto	= new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK			= $oWsTransferDirecto->createClient();			
		}

		$result = $oWsTransferDirecto->TD_GetOcupationList(array(
			'Request' => $arrayParametros
		));

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			$showError	= true;
			$nCodigo	= $result['nCodigo'];
			$sMensaje	= $result['sMensaje'];
		}
		else{
			$oResultado = $result['oResultado'];
			$resultadoOcupacion	= $oResultado->TD_GetOcupationListResult->OcupationList->OcupationInfo;
		}

		$htmlOcupacionOptions = "<option value='-1'></option>";
		foreach($resultadoOcupacion as $objOcupacion){
			$htmlOcupacionOptions .= "<option value='".$objOcupacion->id."'>".$objOcupacion->name."</option>";
		}

	##############################################################################################################
	# Buscar lista de paises y nacionalidades
	##############################################################################################################
		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto	= new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK			= $oWsTransferDirecto->createClient();			
		}

		$result = $oWsTransferDirecto->TD_GetCountryList(array(
			'Request' => $arrayParametros
		));

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			$showError	= true;
			$nCodigo	= $result['nCodigo'];
			$sMensaje	= $result['sMensaje'];
		}
		else{
			$oResultado			= $result['oResultado'];
			$resultadoCountry	= $oResultado->TD_GetCountryListResult->CountryList->CountryInfo;
		}

		$htmlNacionalidadOption = "";
		$htmlPaisOption			= "";
		$htmlPaisEmisionOption1	= "";

		foreach($resultadoCountry as $objCountry){
			$selected = "";
			if($objCountry->id == 164){
				$selected = "selected=selected";
			}
			$htmlNacionalidadOption .= "<option value='".$objCountry->id."' ".$selected.">".$objCountry->nationality."</option>";

			$selected = "";
			if($objCountry->id == 164){
				$selected = "selected=selected";
			}
			$htmlPaisOption			.= "<option value='".$objCountry->id."' ".$selected.">".$objCountry->name."</option>";
			$htmlPaisEmisionOption1 .= "<option value='".$objCountry->id."' ".$selected.">".$objCountry->name."</option>";
		}

	##############################################################################################################
	# Buscar Lista de Estados
	##############################################################################################################
		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto	= new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK			= $oWsTransferDirecto->createClient();			
		}

		$arrayParametros['CodigoPais'] = 164;
		$result = $oWsTransferDirecto->TD_GetStateList(array(
			'Request' => $arrayParametros
		));

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			$showError	= true;
			$nCodigo	= $result['nCodigo'];
			$sMensaje	= $result['sMensaje'];
		}
		else{
			$oResultado		= $result['oResultado'];
			$resultadoState	= $oResultado->TD_GetStateListResult->StateList->StateInfo;
		}

		$htmlStateOption			= "<option value='-1'></option>";
		$htmlStateEmisionOption1	= "";
		$htmlStateEmisionOption2	= "";

		foreach($resultadoState as $objState){
			$htmlStateOption		.= "<option value='".$objState->id."' ".$selected.">".$objState->name."</option>";
			$htmlStateEmisionOption1 .= "<option value='".$objState->id."' ".$selected.">".$objState->name."</option>";
			$htmlStateEmisionOption2 .= "<option value='".$objState->id."' ".$selected.">".$objState->name."</option>";
		}
		
        
        
    ##############################################################################################################
	# Buscar Lista de Identificaciones
	##############################################################################################################
		if(!isset($oWsTransferDirecto)){
			$oWsTransferDirecto	= new WSTransferDirecto($HOSTWSTRANSFER);
			$clientOK			= $oWsTransferDirecto->createClient();			
		}

		$arrayParametros['CodigoPais'] = 164;
		$result = $oWsTransferDirecto->TD_GetIdList(array(
			'Request' => $arrayParametros
		));
		#echo '<pre>'; var_dump($result); echo '</pre>';

		if($result['bExito'] == false || $result['nCodigo'] != 0){
			$showError	= true;
			$nCodigo	= $result['nCodigo'];
			$sMensaje	= $result['sMensaje'];
		}
		else{
			$oResultado		= $result['oResultado'];
			$resultadoId	= $oResultado->TD_GetIdListResult->IdList->IdInfo;
			#echo '<pre>'; var_dump($resultadoId); echo '</pre>';
		}

		$arrayIdLista = array();

		foreach($resultadoId as $objId){
			$arrayIdLista[] = array(
				'id'	=> $objId->id,
				'name'	=> $objId->name
			);
		}
        
        
        
        
        
        
        ?>
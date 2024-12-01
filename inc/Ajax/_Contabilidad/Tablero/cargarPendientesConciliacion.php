<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	$oRdb->setSDatabase('redefectiva');
	$oRdb->setSStoredProcedure('SP_SELECT_PENDIENTESCONCILIACION');
	$oRdb->setParams(array());
	$arrRes = $oRdb->execute();

	if($arrRes['bExito'] == false || $arrRes['nCodigo'] != 0){
		$arrData = array(
			'bExito'	=> false,
			'nCodigo'	=> 1,
			'sMensaje'	=> 'No ha sido posible cargar los datos'
		);
	}
	else{
		$arrRes = $oRdb->fetchAll();

		$html = "<h5><strong>Pendientes de Conciliaci&oacute;n</strong></h5><table style='font-size:13px;'><tbody>";
		foreach($arrRes as $el){
			$html .= "<tr>";
			$html .= "<td style='padding-right:5px;'>".$el['nombreBanco']."</td>";
			$html .= "<td align='right' style='font-weight:bold;font-size:16px;color:#e60000;'>".$el['num']."</td>";
			$html .= "</tr>";
		}
		$html .= "</tbody></table>";

		$arrRes['bExito']	= true;
		$arrRes['nCodigo']	= 0;
		$arrRes['html']		= $html;
	}


	echo json_encode($arrRes);
?>
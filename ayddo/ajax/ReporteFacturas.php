<?php
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

    $start              = (!empty($_POST["iDisplayStart"]))	? $_POST["iDisplayStart"]	: 0;
    $limit		= (!empty($_POST["iDisplayLength"]))	? 100	: 100;
    $sortCol		= (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1)	? $_POST['iSortCol_0']		: 0;
    $sortDir		= (!empty($_POST['sSortDir_0']))	? $_POST['sSortDir_0']		: 'ASC';
    $str		= (!empty($_POST['sSearch']))           ? $_POST['sSearch']		: '';

    $_nIdProveedor  = !empty($_POST["cmbClientes"]) ? $_POST["cmbClientes"] :0;
    $_nIdEstatus    = !empty($_POST["cmbEstatus"])  ? $_POST["cmbEstatus"]  :-1;
    $_dMes          = !empty($_POST["cmbMes"])      ? $_POST["cmbMes"]      :0;
    $_dYear         = !empty($_POST["cmbYear"])     ? $_POST["cmbYear"]     :0;

    if ($_SESSION) {    
        $oRDPN->setBDebug(1);
        $_nIdEstatus = ($_POST["cmbEstatus"] == 0 ? 0 : $_nIdEstatus);
	$oReporte = new PC_ReporteFacturas($_nIdProveedor,$_nIdEstatus,$_dMes,$_dYear,$oRDPN);
  	
  	
	$resultado = $oReporte->GetList($start,$limit);
        if(!$resultado['bExito'] || $resultado['nCodigo'] != 0 || $resultado['num_rows'] == 0){
		$aaData = array();
		$iTotal = 0;
	}
	else{
		$aaData = $resultado['data'];
		$iTotal = $resultado['found_rows'];
	}


	$output = array(
		"sEcho"					=> intval($_POST['sEcho']),
		"iTotalRecords"			=> $iTotal,
		"iTotalDisplayRecords"	=> $iTotal,
		"aaData"				=> utf8ize($aaData),
		"errmsg"				=> ''
	);

	echo json_encode($output);
    }
?>

<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

$data=array();

$nIdProveedor = (!empty($_POST['nIdProveedor'])) ? $_POST['nIdProveedor']   : 0;
$fechaIni     = (!empty($_POST['dFechaIni'])) ? $_POST['dFechaIni']         : '0000-00-00';
$fechaFin     = (!empty($_POST['dFechafin'])) ? $_POST['dFechafin']         : '0000-00-00';
$str          = (!empty($_POST['sSearch'])) ? $_POST['sSearch']       : '';
$sortCol      = (isset($_POST['iSortCol_0']) AND $_POST['iSortCol_0'] > -1) ? $_POST['iSortCol_0'] : 0;
$sortDir      = (!empty($_POST['sSortDir_0'])) ? $_POST['sSortDir_0']      : 0;
$start        = (!empty($_POST["iDisplayStart"])) ? $_POST["iDisplayStart"]   : 0;
$limit        = (!empty($_POST["iDisplayLength"])) ? $_POST["iDisplayLength"]    : 1000;

$tipo = $_POST['tipo'];


		$array_params = array(
	      array(
	        'name'    => 'nIdProveedor',
	        'value'   => $nIdProveedor,
	        'type'    => 'i'
	      ),
	      array(
	        'name'    => 'sBuscar',
	        'value'   => $str,
	        'type'    => 's'
	      ),
	      array(
	        'name'    => 'nSort',
	        'value'   => $sortCol,
	        'type'    => 'i'
	      ),
	      array(
	        'name'    => 'sSort',
	        'value'   => $sortDir,
	        'type'    => 's'
	      ),
	      array(
	        'name'    => 'nStart',
	        'value'   => $start,
	        'type'    => 'i'
	      ),
	      array(
	        'name'    => 'nLimit',
	        'value'   => $limit,
	        'type'    => 'i'
	      ),
	      array('name'    => 'dFechaInicio', 'value'   => $fechaIni, 'type'    => 's'),
	      array('name'    => 'dFechafinal', 'value'   => $fechaFin, 'type'    => 's')
	    );

                $oRDPN->setSDatabase('paycash_one');
		$oRDPN->setSStoredProcedure('sp_select_ordenes_proveedor_backoffice');
		$oRDPN->setParams($array_params);

		$result = $oRDPN->execute();

		$data = $oRDPN->fetchAll();
		$data =utf8ize($data);
		$oRDPN->closeStmt();
echo json_encode($data);
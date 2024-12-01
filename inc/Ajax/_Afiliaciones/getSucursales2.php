<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idAfiliacion	= (!empty($_REQUEST['idAfiliacion']))	? $_REQUEST['idAfiliacion']	: -1;
	$idCliente		= (!empty($_REQUEST['idAfiliacion']))		? $_REQUEST['idAfiliacion'] 		: -1;
	$idSubCadena	= (!empty($_REQUEST['idSubCadena']))		? $_REQUEST['idSubCadena'] 		: -1;

	$start	= (!empty($_REQUEST['iDisplayStart']))? $_REQUEST['iDisplayStart'] : 0;
	$limit	= (!empty($_REQUEST['iDisplayLength']))? $_REQUEST['iDisplayLength'] : 10;

	$colsort	= (isset($_REQUEST['iSortCol_0']) && $_REQUEST['iSortCol_0'] > -1)? $_REQUEST['iSortCol_0'] : 0;
	$ascdesc	= (!empty($_REQUEST['sSortDir_0']))? $_REQUEST['sSortDir_0'] : 0;
	$strToFind	= (!empty($_REQUEST['sSearch']))? utf8_decode($_REQUEST['sSearch']) : '';

	
	if($idSubCadena == -1){
		$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_INFO`($idCliente, $colsort, '$ascdesc', '$strToFind', $start, $limit, 0);";
	}
	else{
		$QUERY = "CALL `afiliacion`.`SP_SUCURSAL_INFO`($idSubCadena, $colsort, '$ascdesc', '$strToFind', $start, $limit, 1);";
	}

	$sql = $RBD->query($QUERY);

	$data = array();

	if ( !$RBD->error() ) {
		$fila = 0;
		while ( $row= mysqli_fetch_assoc($sql) ) {
			
			$calle = (!preg_match("!!u", $row['Calle']))? utf8_encode($row['Calle']) : $row['Calle'];
			$numeroInterior = (!preg_match("!!u", $row['NumInt']))? utf8_encode($row['NumInt']) : $row['NumInt'];
			$numeroExterior = (!preg_match("!!u", $row['NumExt']))? utf8_encode($row['NumExt']) : $row['NumExt'];
			$colonia = (!preg_match("!!u", $row['nombreColonia']))? utf8_encode($row['nombreColonia']) : $row['nombreColonia'];
			$codigoPostal = (!preg_match("!!u", $row['cpDireccion']))? utf8_encode($row['cpDireccion']) : $row['cpDireccion'];
			$municipio = (!preg_match("!!u", $row['nombreMunicipio']))? utf8_encode($row['nombreMunicipio']) : $row['nombreMunicipio'];
			$estado = (!preg_match("!!u", $row['nombreEntidad']))? utf8_encode($row['nombreEntidad']) : $row['nombreEntidad'];
			$pais = (!preg_match("!!u", $row['nombrePais']))? utf8_encode($row['nombrePais']) : $row['nombrePais'];
			
			$direccion = $calle." Num. Int. ".$numeroInterior." Num. Ext. ".$numeroExterior." Col. ".$colonia." C.P. ".$codigoPostal." ".$municipio.", ".$estado.", ".$pais;
			
			$tel="";
			$telefono = str_split($row['Telefono']);
			$longitudTelefono = strlen($row['Telefono']);
			$contador = 0;
			$contador2 = 0;

			foreach ( $telefono as $t ) {
				$contador++;
			//	$contador2++;
				$tel .= $t;
				if ( $contador == 2 ) {
					//if ( $contador2 < ($longitudTelefono-1) ) {
						$contador = 0;
						$tel .= "-";
					//}
				}
			}
			
			$tel = trim($tel, "-");
			$data[] = array(
				$row['idSucursal'],
				(!preg_match("!!u", $row['NombreSucursal'])) ? utf8_encode($row['NombreSucursal']) : $row['NombreSucursal'],
				$direccion,
				$tel,
				'<a href="Sucursal.php?idSucursal='.$row['idSucursal'].'">Ver</a>'
			);

			$fila++;
		}
		
		$iTotal = count($data);
		$error = "";
	} else {
		$error = $RBD->error();
		$iTotal = 0;
	}

	$iTotalDisplayRecords = ($iTotal < $limit)? $iTotal : $limit;
	$output = array(
		"sEcho"                 => intval($_GET['sEcho']),
		"iTotalRecords"         => $iTotal,
		"iTotalDisplayRecords"  => $iTotal,
		"aaData"                => $data,
		"errmsg"				=> $error
	);

	echo json_encode($output);

?>

<?php

	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

	$idProveedor		= (!empty($_POST['idProveedor']))? $_POST['idProveedor'] : 0;
	$idConfiguracion	= (!empty($_POST['idConfiguracion']))? $_POST['idConfiguracion'] : 0;
	$fecha1				= (!empty($_POST['fecha1']))? $_POST['fecha1'] : "0000-00-00";
	$fecha2				= (!empty($_POST['fecha2']))? $_POST['fecha2'] : "0000-00-00";

	$QUERY = "CALL `redefectiva`.`SP_LOAD_REPORTEPROVEEDORES2`('$fecha1', '$fecha2', '$idProveedor', '$idConfiguracion')";

	$sql = $RBD->query($QUERY);

	$data		= array();
	$totales	= array(
		0	=> 0,
		1	=> "",
		2	=> 0,
		3	=> 0,
		4	=> 0,
		5	=> 0,
		6	=> 0,
		7	=> 0,
		8	=> 0,
	);
	$errmsg		= "";

	if(!$RBD->error()){

		while($row = mysqli_fetch_assoc($sql)){
			//var_dump($row);
			$totales[0] += $row['numeroOperaciones'];
			$totales[2] += $row['IMPOP'];
			$totales[3] += $row['COMCLI'];
			$totales[4] += $row['SUBTOTAL'];
			$totales[5] += $row['IVA'];
			$totales[6] += $row['IMPTOTAL'];
			$totales[7] += $row['COMGANADA'];
			$totales[8] += $row['IMPNETO'];

			$data[] = array(
				number_format($row['numeroOperaciones']),
				$row['PROD'],
				"\$".number_format($row['IMPOP'], 2),
				"\$".number_format($row['COMCLI'], 2),
				"\$".number_format($row['SUBTOTAL'], 2),
				"\$".number_format($row['IVA'], 2),
				"\$".number_format($row['IMPTOTAL'], 2),
				"\$".number_format($row['COMGANADA'], 2),
				"\$".number_format($row['IMPNETO'], 2)
			);
		}

		foreach($totales AS $key => $val){
			if($key > 1){
				$totales[$key] = "\$".number_format($val, 2);
			}
		}
	}
	else{
		$errmsg = $RBD->error();
	}

	echo json_encode(array(
		'data'		=> array(
			'body'	=> $data,
			'footer'=> $totales
		),
		'errmsg'	=> $errmsg
	));

?>
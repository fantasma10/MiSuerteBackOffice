<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

	//$tipo  = (!empty($_POST["tipo"]))? $_POST["tipo"] : 1;
	//$tipo = (!empty($_POST["estatus"])) ? $_POST["estatus"] : 0;
	$tipo = 0;
	//var_dump($tipo);
	$search = "a";
	$start = 0;
	$limit = 0;
	$nSortCol = 0;
	$sSortDir = "a";
	$sql = "call SP_LOAD_USUARIOSDATATABLE($tipo,'$search',$start,$limit,$nSortCol,'$sSortDir')"; // solo importa el tipo, los demas parametros no deberia existir en el sp. 
	$result = $MRDB->query($sql);
	$Users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($Users);
	
	//var_dump($Users);

	switch ($tipo) {
		case 1:
			$nStart			= (!empty($_POST["iDisplayStart"]))? $_POST["iDisplayStart"]   : 0;
			$nLimit 		= (!empty($_POST["iDisplayLength"]))? $_POST["iDisplayLength"] : 10;
			$sSearch		= (!empty($_GET['sSearch']))? $_GET['sSearch'] : '';
			$nSortCol		= (!empty($_GET['iSortCol_0']))? $_GET['iSortCol_0'] : 0;
			$sSortDir		= (!empty($_GET['sSortDir_0']))? $_GET['sSortDir_0'] : 'asc';

			$array_params = array(
				array('name' => 'Ck_nIdEstatus', 'value' => $status, 'type' =>'i'),
				array('name' => 'Ck_sSearch', 'value' => $sSearch, 'type' =>'s'),
				array('name' => 'Ck_start', 'value' => $nStart, 'type' =>'i'),
				array('name' => 'Ck_limit', 'value' => $nLimit, 'type' =>'i'),
				array('name' => 'Ck_nSortCol', 'value' => $nSortCol, 'type' =>'i'),
				array('name' => 'Ck_sSortDir', 'value' => $sSortDir, 'type' =>'s'),
			);
			$MRDB->setSDatabase('redefectiva');
		    $MRDB->setSStoredProcedure('SP_LOAD_USUARIOSDATATABLE');
		    $MRDB->setParams($array_params);
		    $result = $MRDB->execute();
		   	
		   	if ($result['nCodigo'] ==0){
		    	$data = $MRDB->fetchAll();
		    	$datos = array();
		    	$index = 0;
				for($i=0;$i<count($data);$i++){
					$datos[$index]["idUsuario"] = $data[$i]["idUsuario"];
					$datos[$index]["idPerfil"] = $data[$i]["idPerfil"];
					$datos[$index]["email"] = utf8_encode($data[$i]["email"]);
					$datos[$index]["nombre"] = utf8_encode($data[$i]["nombre"]." ".$data[$i]["apellidoPaterno"]." ".$data[$i]["apellidoMaterno"]);
					$datos[$index]["nombrePerfil"] = utf8_encode($data[$i]["nombrePerfil"]);
					$index++;					
				}
				$MRDB->closeStmt();
				$totalDatos = $MRDB->foundRows();
				$MRDB->closeStmt();
		    }else{
		    	$datos = 0;
		    	$totalDatos = 0;
		    }		
		    $resultado = array(
			    "iTotalRecords"     => $totalDatos,
			    "iTotalDisplayRecords"  => $totalDatos,
			    "aaData"        => $datos,
			);
		    echo json_encode($resultado);
			break;
		
		default:
			# code...
			break;
	}
?>

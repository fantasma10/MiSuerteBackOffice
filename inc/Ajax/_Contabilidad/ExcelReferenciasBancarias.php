<?php

	include("../../../inc/config.inc.php");
	include("../../../inc/session.ajax.inc.php");

	$submenuTitulo = "Contabilidad";
	$subsubmenuTitulo = "Alta Referencias Bancarias";
	$idOpcion = 44;
	$tipoDePagina = "Mixto";
	$esEscritura = false;

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	$idCadena		= ($_POST["idCadena"] != "")? $_POST["idCadena"] : "";
	$idSubCadena	= ($_POST["idSubCadena"] != "")? $_POST["idSubCadena"] : "";
	$idCorresponsal = ($_POST["idCorresponsal"] != "")? $_POST["idCorresponsal"] : "";
	$start			= 0;
	$limit			= 10;

	$showCadena			= "";
	$showSubCadena		= "";
	$showCorresponsal	= "hidden";

	 if($idSubCadena == -1){
        $showSubCadena = "hidden";
      }

	if($idCorresponsal > 0){
		$showCadena			= "hidden";
		$showSubCadena		= "hidden";
		$showCorresponsal	= "";
	}

	$sDatos = '';

	/*
		Llamada al stored procedure
	*/

	$colspan = 2;
	if($showCadena != "hidden"){$colspan++;}
	if($showSubCadena != "hidden"){$colspan++;}
	if($showCorresponsal != "hidden"){$colspan = 3;}

	if($idCadena == 0){$idSubCadena=0;}

	$result = $RBD->query("call SP_LOAD_REFERENCIASBANCARIAS($idCadena, $idSubCadena, $idCorresponsal, $start , $limit)");

	/*
		Dibujar los encabezados de la Tabla
	*/
	$sDatos .= '
			<table border="0">
				<tr>
					<th colspan="'.$colspan.'">
						<strong><span style="font-size:16px;color:#990000;">Referencias Bancarias</span></strong>
					</th>
				</tr>
				<tr>';

	if($showCadena != "hidden"){
		$sDatos .= '<td align="center" '.$showCadena.'>Cadena</td>';
	}
	if($showSubCadena != "hidden"){
		$sDatos .= '<td align="center" '.$showSubCadena.'>SubCadena</td>';
	}
	if($showCorresponsal != "hidden"){
		$sDatos .= '<td align="center" '.$showCorresponsal.'>Corresponsal</td>';
	}
    	$sDatos .= '<td align="center">Cuenta Bancaria</td>
    				<td align="center">Referencia</td>
				</tr>
			<tr>
				<td colspan="'.$colspan.'" height="1" bgcolor="#000066"></td>
			</tr>';

	/*
		Recorrer el resultado del stored procedure e ir dibujando cada renglón
	*/
	while($row = mysqli_fetch_array($result)){

		$sDatos .= '<tr>';
		
		if($showCadena != "hidden"){
			$sDatos .= '<td align="center" '.$showCadena.'>'.$row["nombreCadena"].'</td>';
		}
		if($showSubCadena != "hidden"){
			$sDatos .= '<td align="center" '.$showSubCadena.'>'.$row["nombreSubCadena"].'</td>';
		}
		if($showCorresponsal != "hidden"){
			$sDatos .= '<td align="center" '.$showCorresponsal.'>'.$row["nombreCorresponsal"].'</td>';
		}
			$sDatos .= '<td align="center">'.$row["numCuenta"].'</td>
			<td align="center">'.$row["referencia"].'</td>
		</tr>';
	}
	/*
		Cerrar la tabla
	*/
	$sDatos .= '
			</table>';

	header("Content-type=application/x-msdownload");
	header("Content-disposition:attachment;filename=Referencias_Bancarias.xls");
	header("Pragma:no-cache");
	header("Expires:0");
	print "$sDatos";
?>
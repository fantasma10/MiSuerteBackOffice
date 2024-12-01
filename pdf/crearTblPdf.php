<?php
/*
	ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .CSV DESCARGABLE

	Este archivo se incluye en el archivo php desde el que queremos generar el excel,
	es para tablas genericas, se necesitan las siguientes variables

	$table = array(
		"mainHead"	=>	"TITULO"
		"headers"	=>	array("h1") cabeceras de las columnas
		"rows"		=>	arreglo con las filas retornadas por la consulta
		"indexes"	=>	nombres de los campos del query en el orden en que apareceran las columnas de izquierda a derecha
		"formats"	=>	formato con el que se quiere mostrar el valor en la celda, ej money
	);
*/

$filename = (!empty($arrTable["mainHead"]))? str_replace(" ", "_", $arrTable["mainHead"]) : "Reporte";


$colspanTitle = count($arrTable["headers"]);

/*
	Definir algunos estilos para headers
*/

$mainHeadStyle = 'style = color:#7e1214;font-weight:bold; font-size:40;';
$headerStyle = 'style = color:#124a7e;font-weight:bold; font-size:12px;';

	$tbl = '<style>
	    table {
			float:left;
			margin-top:100px;
			width:100%;
		}
		th{
			text-align:left;
			font-size:25px;
			float:left;
			background-color:#6897cc;
			color:#fff;
			border-bottom: solid 2px #fff;
		}
		td{
			text-align:left;
			font-size:22px;
			float:left;
			padding:20em;
		}
		tr{
			padding:10px;
		}
		tr.gray{
			background-color:#dfe9f4;
		}
		.divDividerX{
			margin: 0px auto 0px auto;
			padding: 0px 0px 0px 0px;
			width:100%; border-bottom:1px solid #BBB; border-top:1px solid #CCC; height:0px;
		}
	    </style>';

	$tbl .= "<table border=\"0\" align='center'>";
	/*
		Dibujar el Encabezado Principal del Reporte
	*/
		if(!empty($arrTable["mainHead"])){
			if(!empty($arrTable["filtersHead"]) && !empty($arrTable["filtersValue"])){
				$colspan = count($arrTable["filtersHead"]);
			}
			$tbl.= "<tr>";
				$tbl.= "<td style =\"padding-bottom:330px;text-align:center;color:#35659d;text-decoration: none; font-size:60px;font-face: Arial,Helvetica;\" colspan=\"3\">".utf8_encode($arrTable["mainHead"])."</td>";
			$tbl.= "</tr>";
			$tbl.= "<tr><td></td><td></td><td></td></tr>";
		}

		if(!empty($arrTable["filtersHead"]) && !empty($arrTable["filtersValue"])){

			$filtersHead = $arrTable["filtersHead"];
			$filtersValue = $arrTable["filtersValue"];

			
			$c = 0;
			$tds = 1;
			
			foreach($filtersHead as $fh){
				if($tds == 1){
					$tbl.= "<tr>";	
				}
				$dospuntos = ($fh != "")? ":" : "";
				if ( preg_match('!!u', $fh) ) {
					$fh = utf8_decode($fh);
				}
				if ( preg_match('!!u', $filtersValue[$c]) ) {
					$filtersValue[$c] = utf8_decode($filtersValue[$c]);
				}				
				$tbl.= "<td align=\"left\" style =\"padding:30px;text-align:left;font-size:30px;font-face:Arial Helvetica;\"><span style=\"font-weight:bold;\">".$fh."</span> ".$dospuntos." ".$filtersValue[$c]."</td>";
				if($tds == 3 || $c == count($filtersValue)-1){
					$tbl.= "</tr>";
					$tds = 0;
				}
				$c++;
				$tds++;
			}
			$tbl.="<tr><td></td><td></td><td></td></tr>";
		}
	$tbl.="</table>";	
	
	/*
		Dibujar los encabezados
	*/
	$tbl .= "<table border=\"0\" cellpadding='2' cellspacing='2' align='left' style=\"margin-top:50px;\">";
	
	if(!empty($arrTable["headers"])){

		
		$headers = $arrTable["headers"];
		$tbl.= "<tr>";
		$contw = 0;
		foreach($headers as $header){
			$tbl.= "<th style =\"padding-bottom:60px;\">".utf8_decode($header)."</th>";
			$contw++;
		}
		$tbl.= "</tr>";
	}

	/*
		Dibujar las filas
	*/
	if(!empty($arrTable["rows"])){
		$rows = $arrTable["rows"];
		/*
			validamos si fueron enviados los indexes
		*/
		if(!empty($arrTable["indexes"])){
			$indexes = $arrTable["indexes"];
		}

		$formats = array();
		if(!empty($arrTable["formats"])){
			$formats = $arrTable["formats"];
		}

		/*
			recorremos las filas
		*/
		$cont=0;
		$class = 'gray';
		$nrow = 0;
		foreach($rows as $row){
			
			if($nrow % 2 == 0){
				$class = '';
			}
			else{
				$class = 'gray';
			}
			$tbl.= "<tr class=\"$class\">";
			$nrow++;
			/*
				si los indexes fueron enviados, entonces recorremos el arreglo para extraer y mostrar la información de acuerdo al orden de los indices,
				en caso de que no hayan sido enviados los indices, entonces dibujamos cada elemento del arreglo contenido en $row
			*/
			if(!empty($indexes)){

				$contw = 0;
				foreach($indexes as $index){
					$value = ($formats[$cont] != "")? $formats[$cont]($row[$index]) : $row[$index];
					if ( !preg_match('!!u', $value) ) {
						$value = utf8_encode($value);
					}
					$tbl.= "<td style='padding:10px;' >".$value."</td>";
					$cont++;
					$contw++;
				}
				$cont = 0;
			}
			else{
				foreach($row as $cell){
					$tbl.= "<td style='padding:10px;' class=\"$class\">".$cell."</td>";
					$cont++;
				}
				$cont = 0;
			}
			$tbl.= "</tr>";
		}//foreach rows
	}//!empty rows
	
	$tbl .="</table>";

/*
	funciones de formato
*/
function money($float){
	if(is_numeric($float)){
		return "\$ ".number_format($float,2);
	}
	else{
		return $float;
	}
}
?>
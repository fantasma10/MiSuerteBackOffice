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

header("Content-Type: application/vnd.ms-excel"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=$filename.xls");


$colspanTitle = count($arrTable["headers"]);

/*
	Definir algunos estilos para headers
*/

$mainHeadStyle = 'style = color:#7e1214;font-weight:bold; font-size:14px;';
$headerStyle = 'style = color:#124a7e;font-weight:bold; font-size:12px;';

?>

	<table>

<?php
	/*
		Dibujar el Encabezado Principal del Reporte
	*/
	if(!empty($arrTable["mainHead"])){
		echo "<tr>";
			echo "<th $mainHeadStyle colspan=$colspanTitle>".utf8_decode($arrTable["mainHead"])."</th>";
		echo "</tr>";
		echo "<tr></tr>";
	}

	if(!empty($arrTable["filtersHead"]) && !empty($arrTable["filtersValue"])){

		$filtersHead = $arrTable["filtersHead"];
		$filtersValue = $arrTable["filtersValue"];

		$cols = $colspanTitle / count($filtersHead);

		echo "<tr>";
		foreach($filtersHead AS $fh){
			echo "<td colspan=$cols><b>".utf8_decode($fh)."<b></td>";
		}
		echo "</tr>";

		echo "<tr>";
		foreach($filtersValue AS $fv){
			echo "<td colspan=$cols>".utf8_decode($fv)."</td>";
		}
		echo "</tr>";
		echo "<tr></tr>";
	}

	/*
		Dibujar los encabezados
	*/
	if(!empty($arrTable["headers"])){

		$headers = $arrTable["headers"];
		echo "<tr>";
		foreach($headers AS $header){
			echo "<th $headerStyle>".utf8_decode($header)."</th>";
		}
		echo "</tr>";
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
		foreach($rows AS $row){
			echo "<tr>";
			/*
				si los indexes fueron enviados, entonces recorremos el arreglo para extraer y mostrar la información de acuerdo al orden de los indices,
				en caso de que no hayan sido enviados los indices, entonces dibujamos cada elemento del arreglo contenido en $row
			*/
			if(!empty($indexes)){
				foreach($indexes AS $index){
					$value = ($formats[$cont] != "")? $formats[$cont]($row[$index]) : $row[$index];
					echo "<td style='padding:10px;'>".utf8_decode($value)."</td>";
					$cont++;
				}
				$cont = 0;
			}
			else{
				foreach($row AS $cell){
					echo "<td style='padding:10px;'>".utf8_decode($cell)."</td>";
					$cont++;
				}
				$cont = 0;
			}
			echo "</tr>";
		}//foreach rows
	}//!empty rows
?>
	
	</table>

<?php

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
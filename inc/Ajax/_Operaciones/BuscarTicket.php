<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
include($_SERVER['DOCUMENT_ROOT']."/inc/session.ajax.inc.php");

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

$idPermiso 		= (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

$Folio			= !empty($_POST['Folio'])? $_POST['Folio']:0;
$Auto			= !empty($_POST['Auto'])? $_POST['Auto']:0;
$Ref			= !empty($_POST['Ref'])? $_POST['Ref']:0;
$fecIni			= !empty($_POST['fecIni'])? $_POST['fecIni']:0;
$fecFin			= !empty($_POST['fecFin'])? $_POST['fecFin']:0;
$idCorresponsal	= !empty($_POST['idCorresponsal'])? $_POST['idCorresponsal']:0;
$idEmisor		= !empty($_POST['idEmisor'])? $_POST['idEmisor']:0;
$idProveedor	= !empty($_POST['idProveedor'])? $_POST['idProveedor']:0;

global $RBD,$LOG;

$Folio = trim($Folio);
$Auto = trim($Auto);
$Ref = trim($Ref);

if(empty($Folio)){
	$Folio = 0;
}
if(empty($Auto)){
	$Auto = 0;
}
if(empty($Ref)){
	$Ref = 0;
}

//Estas tres variables son necesarias para mostrar la paginanacion descripcion el el archivo paginanavegacion.php
$cant = 20;
$funcion = "BuscaOperaciones";

include($_SERVER['DOCUMENT_ROOT']."/inc/Ajax/actualpaginacion.php");

$SQL = "SELECT SQL_CALC_FOUND_ROWS op.`idsOperacion`,
op.`fecAltaOperacion`, op.`importeOperacion` + `totComCliente` AS importeOperacion,
op.`idCorresponsal`, corr.`nombreCorresponsal`, op.`idProducto`,
prod.`descProducto`, op.`respuestaOperacion`, op.`referencia1Operacion`,
opweb.`idOperacion`, op.`idEmisor`, op.`idFamilia`,
op.`idCadena`, op.`idSubCadena`	
FROM `redefectiva`.`ops_operacion` AS op
INNER JOIN `redefectiva`.`dat_corresponsal` AS corr
ON corr.`idCorresponsal` = op.`idCorresponsal` AND corr.`idEstatusCorresponsal` = 0
INNER JOIN `redefectiva`.`dat_producto` AS prod
ON prod.`idProducto` = op.`idProducto`
INNER JOIN `data_webpos`.`aps_operacion` AS opweb
ON opweb.`idFolio` = op.`idsOperacion`
WHERE op.`fecAltaOperacion` BETWEEN '$fecIni' AND '$fecFin'
AND IF($Auto > 0, op.`autorizacionOperacion` = $Auto, 1)
AND IF($Folio > 0, op.`idsOperacion` = $Folio, 1)
AND IF($Ref > 0, op.`referencia1Operacion` = $Ref, 1)
AND IF($idCorresponsal > 0, op.`idCorresponsal` = $idCorresponsal, 1)
AND IF($idEmisor > 0, op.`idEmisor` = $idEmisor, 1)
AND IF($idProveedor > 0, op.`idProveedor` = $idProveedor, 1)
AND op.`idFamilia` NOT IN (3,7)
AND op.`idEstatusOperacion` = 0
ORDER BY op.`fecAltaOperacion`
DESC LIMIT $actual, $cant;";
//var_dump($SQL);
$sqlcount = "SELECT FOUND_ROWS();";
	
$Result = $RBD->query($SQL);
$band = true;
$clase = "";
if(!$RBD->error()){
	if(mysqli_num_rows($Result)){
	
		$RES = '<table id="ordertabla" class="tablesorter tasktable" border="0"  cellpadding="0" cellspacing="0" style="margin:0px auto;" aling="center">
				<thead>
				<tr>
				<th>Folio</th>
				<th>Fecha</th>
				<th>Importe</th>
				<th>Corresponsal</th>
				<th>Producto</th>
				<th>Codigo Res.</th>
				<th></th>
				<th></th>
				</tr>
				</thead><tbody>';
	
		while($row = mysqli_fetch_array($Result)){
			$id = $row["idsOperacion"];
			$respuestaOperacion = ($row["respuestaOperacion"] == 0)? "Exitosa" : "";
			$idProducto = $row["idProducto"];
			$idOperacion = $row["idsOperacion"];
			
			$clase = ($band)?"odd":"even";
			$band = !$band;
			$RES .= '<tr class="'.$clase.'" align="left">
			<td><div align="center">'.$row["idsOperacion"].'</div></td>
			<td><div align="center">'.$row["fecAltaOperacion"].'</div></td>
			<td><div align="left">$ '.number_format($row["importeOperacion"]).'</div></td>
			<td><div align="center">'.utf8_encode($row["nombreCorresponsal"]).'</div></td>
			<td><div align="center">'.utf8_encode($row["descProducto"]).'</div></td>
			<td><div align="center">'.utf8_encode($respuestaOperacion).'</div></td>';
			$RES .= '<td><div align="center"><a href="#Detalle" data-toggle="modal" onclick="BuscarOperacionVerPoPUp('.$id.')">Ver Operaci&oacute;n</a></div></td>';
			if ($row["idFamilia"] == 5) {
				if($row["idEmisor"] == 46 || $row["idEmisor"] == 47 || $row["idEmisor"] == 52){
					$RES .= '<td>';
					//$RES .= '<form id="pdf" method="post" target="_blank" action="TicketRemesasWU.php">';
					$RES .= '<form id="pdf$idOperacion" method="post" target="_blank" action="TicketRemesasWU.php">';
					$RES .= '<input type="hidden" name="idOperacion" value="'.$row["idOperacion"].'">';
					$RES .= '<button class="btn btn-xs btn-info pdf" style="margin-right:10px;">';
        			$RES .= '<i class="fa fa-file-pdf-o"></i> PDF';
        			$RES .= '</button>';
					$RES .= '</form>';
					$RES .= '</td>';
					//$RES .= '<td><a href="TicketRemesasWU.php?idOperacion='.$row["idOperacion"].'">Ver Ticket</a></td>';
				}else if ($row["idEmisor"] == 74){
					$RES .= '<td>';
					$RES .= '<form id="pdf$idOperacion" method="post" target="_blank" action="TicketRemesas.php" >';
					$RES .= '<input type="hidden" name="idOperacion" value="'.$row["idOperacion"].'">';
					$RES .= '<button class="btn btn-xs btn-info pdf" style="margin-right:10px;">';
        			$RES .= '<i class="fa fa-file-pdf-o"></i> PDF';
        			$RES .= '</button>';
					$RES .= '</form>';
					$RES .= '</td>';
					//$RES .= '<td><a href="TicketRemesas.php?idOperacion='.$row["idOperacion"].'">Ver Ticket</a></td>';
				}else{
					$RES .= '<td>';
					$RES .= '<form id="pdf'.$idOperacion.'" align="center" method="post" target="_blank" action="Ticket.php">';
					$RES .= '<input type="hidden" name="idOperacion" value="'.$row["idOperacion"].'">';
					$RES .= '<button type="button" class="btn btn-xs btn-info pdf" onClick="buscarProveedor('.$idOperacion.', '.$row["idProducto"].', '.$row["idCadena"].', '.$row["idSubCadena"].', '.$row["idCorresponsal"].');" style="margin-right:10px;">';
					//$RES .= '<button class="btn btn-xs btn-info pdf" onClick="$(this).parent(\'form\').submit();" style="margin-right:10px;">';
					$RES .= '<i class="fa fa-file-pdf-o"></i> PDF';
					$RES .= '</button>';
					$RES .= '</form>';
					$RES .= '</td>';
					//$RES .= '<td><a href="Ticket.php?idOperacion='.$row["idOperacion"].'">Ver Ticket</a></td>';
				}
			} else {
				$RES .= '<td>';
				$RES .= '<form id="pdf'.$idOperacion.'" align="center" method="post" target="_blank" action="Ticket.php">';
				$RES .= '<input type="hidden" name="idOperacion" value="'.$row["idOperacion"].'">';
				$RES .= '<button type="button" class="btn btn-xs btn-info pdf" onClick="buscarProveedor('.$idOperacion.', '.$row["idProducto"].', '.$row["idCadena"].', '.$row["idSubCadena"].', '.$row["idCorresponsal"].');" style="margin-right:10px;">';
				//$RES .= '<button class="btn btn-xs btn-info pdf" onClick="$(this).parent(\'form\').submit();" style="margin-right:10px;">';
				$RES .= '<i class="fa fa-file-pdf-o"></i> PDF';
				$RES .= '</button>';
				$RES .= '</form>';
				$RES .= '</td>';
				//$RES .= '<td><a href="Ticket.php?idOperacion='.$row["idOperacion"].'">Ver Ticket</a></td>';
			}
			$RES .= '</tr>';
		} 
		$RES .= '</tbody></table><br />';
	}else{
		$RES = "<span style='margin-left: 10px;'>Lo sentimos pero no se encontraron Operaciones</span>";
	}
}else{
	$RES = "<span style='margin-left: 10px;'>".$RBD->error()."</span>";
}

echo $RES;

echo "<table align='center'><tr><td>";
//necesario incluir para la paginacion
include($_SERVER['DOCUMENT_ROOT']."/inc/Ajax/paginanavegacion.php");
echo "</td></tr></table>";

?>
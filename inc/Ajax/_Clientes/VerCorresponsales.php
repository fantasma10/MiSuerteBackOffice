<?php

include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena 		= (isset($_REQUEST['idCadena']))?$_REQUEST['idCadena']:-2;
$subcadena		= (isset($_REQUEST['idSubcadena']))?$_REQUEST['idSubcadena']:-2;

$cantidad 		= (isset($_REQUEST['cantidad']))?$_REQUEST['cantidad']:"";
$nombre			= (isset($_REQUEST['nombreSub']))?$_REQUEST['nombreSub']:"";

$status			= (isset($_REQUEST['status']))?$_REQUEST['status']:0;


$cadena = (int)$cadena;
$subcadena = (int)$subcadena;

$res = $RBD->query("CALL `redefectiva`.`SP_LOAD_CORRESPONSALES`($cadena, $subcadena)");
/*if($RBD->error() != ""){
	echo $RBD->error();
}*/
if ( mysqli_num_rows($res) > 0 ) {

	if($_REQUEST["downloadExcel"]){
		header('Content-Description: File Transfer');
		header('Content-Type=application/x-msdownload');
		header('Content-disposition:attachment;filename=Corresponsales.xls');
		header("Pragma:no-cache");
		header("Set-Cookie: fileDownload=true; path=/");
	}

	$name = "'".$nombre."'";
	$d = '';
		if(empty($_REQUEST["downloadExcel"])){
			$d.='<div class="recuadro_contenido_detalle2">
				<div align="center"><span class="subtitulo_detalle"><br />
				'.$cantidad.'</span> Corresponsales -<span class="subtitulo_detalle"> '.($nombre).'</span><br />
				<br />';
			$d.='</div>
			<div align="center"><span class="subtitulo_detalle"><br /><a href="#" onclick="downloadExcelListaCorresponsales('.$cadena.', '.$subcadena.', '.$name.', '.$cantidad.')">Descargar a Excel</a></span><br />
			<br />
			</div>';
		}
		else{
			$lbl = "";
			if($cadena >= 0){
				$lbl = "Cadena : ";
			}
			if($subcadena >= 0){
				$lbl = "SubCadena : ";
			}
		}

		$d.='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		if(!empty($_REQUEST["downloadExcel"])){
			$d.= '<tr>
					<td colspan="2">
						<span style="font-weight:bold;font-size:25;">'.$lbl.utf8_decode($nombre).'</span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<span style="font-weight:bold;font-size:20;">Corresponsales : '.$cantidad.'</span>
					</td>
				</tr>';
		}
		$d.='<thead>
		  <th width="22%" align="center" valign="middle" class="encabezado_tabla" style="text-align:center;"><span class="texto_blanco_info">ID</span></th>
		  <th width="66%" align="left" valign="middle" class="encabezado_tabla"><span class="texto_blanco_info">Nombre del Corresponsal</span></th>
		  <th width="12%" align="center" valign="middle" class="encabezado_tabla">&nbsp;</th>
		</thead>    
	  <tbody>';
	while ( $r = mysqli_fetch_array($res) ) {

		if(empty($_REQUEST["downloadExcel"])){
			$res1 = utf8_encode($r[1]);
		}
		else{
			$res1 = $r[1];
		}
		$d .= "<tr>
		  <td align='center' valign='middle' class='renglon1_tabla'>$r[0]</td>
		  <td align='left' valign='middle' class='renglon1_tabla'>".$res1."</td>
		  <td align='center' valign='middle' class='renglon1_tabla'>";
		  	if(empty($_REQUEST["downloadExcel"])){
		  		$d.="<a href='#' onmouseout='MM_swapImgRestore()' onmouseover='MM_swapImage(\"Image$r[0]\",\"\",\"../../img/btn_detalle2.png\",1)' onclick='GoCorresponsal($r[0])'><img src='../../img/btn_detalle1.png' name='Image$r[0]' width='22' height='23' border='0' id='Image$r[0]' /></a>";
		  	}
		  $d."</td>
		</tr>";
	}	
	$d .= '</tbody></table></div>';	
	echo $d;
}

?>
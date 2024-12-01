<?php

include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idPermiso	= (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][0]:1;

$nombre 	= (isset($_POST['nombre']))?$_POST['nombre']:'';
$idcad		= (isset($_POST['idcad']))?$_POST['idcad']:'';


$AND = "";

if($nombre != '')
	$AND.=" AND `dat_subcadena`.`nombreSubCadena` LIKE '%$nombre%' ";	
if($idcad != '')
	$AND.=" AND `dat_subcadena`.`idCadena` = $idcad";


if(isset($_POST['status'])){
	$status = $_POST['status'];
	
	$sql = "SELECT `dat_subcadena`.`idSubCadena`,`dat_grupo`.`nombreGrupo`,`cat_giro`.`descGiro`,`dat_cadena`.`nombreCadena`,`nombreSubCadena` FROM `redefectiva`.`dat_subcadena` INNER JOIN `dat_grupo` USING(`idGrupo`) INNER JOIN `cat_giro` on `dat_subcadena`.`idcGiro` = `cat_giro`.`idGiro` INNER JOIN `dat_cadena` USING(`idCadena`) WHERE `idEstatusSubCadena` = ".$status." $AND;";
	
	$res = $RBD->query($sql);
	$band = true;
	$clase = "";
	if(mysqli_num_rows($res) > 0){				
		$d = "<table id='ordertabla' class='tablesorter' border='0'  cellpadding='0' cellspacing='1'>
			<thead>
				<tr>
					<th class='header headerSortDown'>Grupo</th>
					<th class='header'>Giro</th>
					<th class='header'>Cadena</th>
					<th class='header'>Nombre SubCadena</th>
				</tr>
			</thead>
			<tbody>";
		//while($r = mysqli_fetch_array($res)){
		while(list($id,$grupo,$giro,$cad,$nom)=mysqli_fetch_array($res)){
			$clase = ($band)?"odd":"even";
				$band = !$band;
			   $d .= "<tr class='".$clase."' align='left'>
					<td>".$grupo."</td>
					<td>".$giro."</td>
					<td>".$cad."</td>
					<td>".$nom."</td>";
					if($idPermiso == 0){
					$d.="<td><div align='center'><a href='Consulta.php?id=".$id."'>Editar</a></div></td>";
					$d.="<td><div align='center'><a onclick='
					EliminarActualizarCodigo(".$id.","; $x = ($status == 3)?"0":"3";  $d.=$x.")'>";
					$y = ($status == 3)?'Activar':'Eliminar';
				  	$d.=$y."</a></div></td>";
				}else{
					$d.="<td><div align='center'><a href='Consulta.php?id=".$id."'>Ver</a></div></td>";
				}
			$d.="</tr>";
		}	
		$d.="</tbody></table>";	
		echo $d;
	}
}
?>
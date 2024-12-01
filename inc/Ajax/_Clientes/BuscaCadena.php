<?php

include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idPermiso	= (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][0]:1;

$nombre		= (isset($_POST['nombre']))?$_POST['nombre']:'';
$giro		= (isset($_POST['giro']))?$_POST['giro']:'';

$AND = "";
if($nombre != '')
	$AND.=" AND `dat_cadena`.`nombreCadena` LIKE '%$nombre%' ";	
if($giro != '')
	$AND.=" AND `dat_cadena`.`idcGiro` = $giro ";
	
if(isset($_POST['status'])){
	$status = $_POST['status'];
	$sql = "SELECT `dat_cadena`.`idCadena`,`dat_grupo`.`nombreGrupo`,`cat_giro`.`descGiro`,`nombreCadena`,`email` FROM `redefectiva`.`dat_cadena` INNER JOIN `dat_grupo` USING(`idGrupo`) INNER JOIN `cat_giro` on `dat_cadena`.`idcGiro` = `cat_giro`.`idGiro` WHERE `idEstatusCadena` = ".$status." $AND;";
	
	$res = $RBD->query($sql);
	$band = true;
	$clase = "";
	if(mysqli_num_rows($res) > 0){				
	$d = "<table id='ordertabla' class='tablesorter' border='0'  cellpadding='0' cellspacing='1'>
			<thead>
				<tr>
					<th class='header headerSortDown'>Grupo</th>
					<th class='header'>Giro</th>
					<th class='header'>Nombre</th>
					<th class='header'>Email</th>
				</tr>
			</thead>
			<tbody>";
			//while($r = mysqli_fetch_array($res)){
			while(list($id,$grupo,$giro,$nom,$mail)=mysqli_fetch_array($res)){
				$clase = ($band)?"odd":"even";
				$band = !$band;
			   $d .= "<tr class='".$clase."' align='left'>
					<td>".$grupo."</td>
					<td>".$giro."</td>
					<td>".$nom."</td>
					<td>".$mail."</td>";
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
<?php

include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena 	= (isset($_POST['cadena']))?$_POST['cadena']:-2;
$subcadena		= (isset($_POST['subcadena']))?$_POST['subcadena']:-2;
$corresponsal		= (isset($_POST['corresponsal']))?$_POST['corresponsal']:-2;
$nombre = (isset($_POST['nombre']))?$_POST['nombre']:'';
$cadena = (int)$cadena;
$subcadena = (int)$subcadena;
$corresponsal = (int)$corresponsal;
$AND = "";
if($cadena > -2 && $subcadena > -2 && $corresponsal > -2){  
if($cadena > -1)
	$AND.=" AND `dat_corresponsal`.`idCadena` = $cadena ";	
if($subcadena > -1)
	$AND.=" AND `dat_corresponsal`.`idSubCadena` = $subcadena ";
if($corresponsal > -1 )
	$AND.=" AND `dat_corresponsal`.`idCorresponsal` = $corresponsal ";
}
if($nombre != '')
	$AND.= " AND `dat_corresponsal`.`nombreCorresponsal` LIKE '%".$nombre."%'";
if(isset($_POST['status'])){
	$status = $_POST['status'];
	
	$sql = "SELECT `dat_grupo`.`nombreGrupo`,`cat_giro`.`descGiro`,`dat_cadena`.`nombreCadena`,`dat_subcadena`.`nombreSubCadena`,`dat_corresponsal`.`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` INNER JOIN `dat_grupo` USING(`idGrupo`) INNER JOIN `cat_giro` on `dat_corresponsal`.`idcGiro` = `cat_giro`.`idGiro` INNER JOIN `dat_cadena` USING(`idCadena`) INNER JOIN `dat_subcadena` USING(`idSubCadena`) WHERE `idEstatusSubCadena` = ".$status." $AND;";
	
	
	$res = $RBD->query($sql);

if(mysqli_num_rows($res) > 0){				
	$d = "<table border='1'><thead><tr><th>Grupo</th><th>Giro</th><th>Cadena</th><th>Subcadena</th><th>Nombre Corresponsal</th></tr></thead><tbody>";
	while($r = mysqli_fetch_array($res)){
			$d.="<tr><td>".$r[0]."</td><td>".$r[1]."</td><td>".$r[2]."</td><td>".$r[3]."</td><td>".$r[4]."</td></tr>";
	}	
	$d.="</tbody></table>";	
	echo $d;
	}
}
?>
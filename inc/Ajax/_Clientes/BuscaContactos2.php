<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

if(!isset($_SESSION['Permisos'])){
	header("Location: ../../../logout.php"); 
    exit(); 
}

$idPermiso 	= (isset($_SESSION['Permisos']['Tipo'][0]))?$_SESSION['Permisos']['Tipo'][0]:1;

$id			= (isset($_POST['id']))?$_POST['id']: -2;
$correo		= (isset($_POST['correo']))?$_POST['correo']: -2;
$tel		= (isset($_POST['tel']))?$_POST['tel']: -2;

$tipo		= (isset($_POST['tipo']))?$_POST['tipo']: 1;

$status		= (isset($_POST['status']))?$_POST['status']:1;


$AND = "";
if($id > -2)
	$AND .= " AND `idContacto` = ".$id;
	
if( $tel > -2)
	$AND .= " AND `telefono1` = ".$tel;

if($correo > -2)
	$AND .= " AND `correoContacto` = ".$correo;

	
global $RBD;

	$RES = '<table id="ordertabla" class="tablesorter" border="0"  cellpadding="0" cellspacing="1">
	<thead>
		<tr>
		<th class="header headerSortDown">Nombre</th>
		<th class="header">Telefono</th>
		<th class="header">Correo</th>

		</tr>
	</thead><tbody>';
	   
$cant = 10;
$funcion = "BuscarAccesos";
$sqlcount = "SELECT  `idContacto`,`idcTipoContacto`,`nombreContacto`,`apPaternoContacto`,`apMaternoContacto`,`telefono1`,`correoContacto` 
				FROM  `redefectiva`.`dat_contacto` 
				WHERE  `idcTipoContacto` = $tipo
				$AND";

include("../actualpaginacion.php");


			$SQL = "SELECT  `idContacto`,`idcTipoContacto`,`nombreContacto`,`apPaternoContacto`,`apMaternoContacto`,`telefono1`,`correoContacto` 
					FROM  `dat_contacto` 
					WHERE  `idcTipoContacto` = $tipo
					$AND";	
			echo $SQL;						
			$Result = $RBD->query($SQL);

			while(list($id,$idTipo,$Nombre,$Apaterno,$Amaterno,$tel,$correo)=mysqli_fetch_array($Result))
			{
			   $RES .= '<tr>
					  <td><div align="left">'.$Nombre.' '.$Apaterno.' '.$Amaterno.'</div></td>
					  <td><div align="left">'.$tel.'</div></td>
					  <td><div align="left">'.$correo.'</div></td>';
				if($idPermiso == 0){
					$RES.='<td><div align="center"><a href="Editar.php?id='.$id.'">Editar</a></div></td>';
					$RES.='<td><div align="center"><a onclick="EliminarActualizarAcceso('.$id.','; $x = ($status == 2)?'0':'2';  $RES.=$x.')">';
					$y = ($status == 2)?'Activar':'Eliminar';
					$RES.=$y.'</a></div></td>';
				}else{
					$RES.='<td><div align="center"><a href="Consulta.php?id='.$id.'">Ver</a></div></td>';
				}

			  $RES.='</tr>';
			 } 
      $RES.='</tbody></table>';

echo $RES;	
echo "<table align='center'><tr><td>";

include("../paginanavegacion.php");
echo "</td></tr></table>";

?>
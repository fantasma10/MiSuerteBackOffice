<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$tipoDePagina = "Mixto";
$idOpcion = 29;
$esEscritura = false;

if ( !desplegarPagina($idOpcion, $tipoDePagina) ) {
	header("Location: ../../../error.php");
    exit();
}

if ( esLecturayEscrituraOpcion(29) ) {
	$esEscritura = true;
}

$status = ( isset($_POST['status']) ) ?$_POST['status'] : 1;

global $RBD;

$RES = '<table style="width:800px; margin:0px auto;" align="center">
  	   <tr>
       <td>
	   <br />
       <table id="ordertabla" border="0" cellspacing="0" cellpadding="0" class="tablesorter2" style="width:100%; margin:0px auto;" align="center"> 
	   <thead>
	   <th>Id</th>
	   <th>Tipo</th>
       <th>Correo</th>
       <th>Nombre</th>';
	   
if($esEscritura){
	$RES .= '<th></th><th></th>';
}

$RES .= '</thead>
         <tbody>';

//Estas tres variables son necesarias para mostrar la paginanacion descripcion el el archivo paginanavegacion.php
$cant = 20;
$funcion = "BuscarUsuarios";
/*$sqlcount = "SELECT COUNT(`idusuario`) FROM `data_acceso`.`in_usuarioad`
					WHERE `idEstatusUsuario` = $status 
					ORDER BY `idusuario` ASC;";*/
					
$sqlcount = "SELECT COUNT(`idUsuario`)
			 FROM `data_acceso`.`dat_usuario`
			 WHERE `idEstatus` = $status
			 ORDER BY `idUsuario` ASC;";
			 
//necesario incluir para la paginacion
include("../actualpaginacion.php");
     
$SQL = "SELECT USU.`idUsuario`,
		PER.`idPerfil`,
		USU.`email`,
		USU.`nombre`,
		USU.`apellidoPaterno`,
		USU.`apellidoMaterno`,
		PERFIL.`nombre`
		FROM `data_acceso`.`dat_usuario` as USU
		LEFT JOIN `data_acceso`.`inf_perfilesdelusuario` as PER
		ON ( USU.`idUsuario` = PER.`idUsuario` AND PER.`idPortal` = {$_SESSION['idPortal']} )
		LEFT JOIN `data_acceso`.`cat_perfil` PERFIL
		ON ( PERFIL.`idPerfil` = PER.`idPerfil` AND PERFIL.`idPortal` = {$_SESSION['idPortal']} )
		WHERE USU.`idEstatus` = $status
		ORDER BY USU.`idUsuario` ASC LIMIT $actual, $cant;";	 					

$Result = $RBD->query($SQL);

while( list($id,$idPer,$mail,$nom,$apeP,$apeM,$descPer) = mysqli_fetch_array($Result) ) {
		
	$RES .= '<tr class="HighlightableRow">
			 <td><div align="center">'.$id.'</div></td>
			 <td><div align="center">';
			 
	if( $descPer == NULL )
		$RES .= "Sin Perfil";
	else
		$RES .= $descPer;
		
	$RES .='</div></td>
			<td><div align="left">'.$mail.'</div></td>
			<td><div align="left">'.htmlentities($nom).' '.htmlentities($apeP).' '.htmlentities($apeM).'</div></td>';
	
	if( $esEscritura ) {
		$RES .= '<td><div align="center"><a href="Consulta.php?id='.$id.'">Editar</a></div></td>';
	}
	
	if( $esEscritura ) { 
		$RES .= '<td><div align="center"><a onclick="EliminarActualizarUsuario('.$id.','; $x = ( $status == 2 )? '0' : '2';
		$RES .= $x.')">';
		$y = ( $status == 2 )? 'Activar' : 'Eliminar';
		$RES .= $y.'</a></div></td>';
	}
		   
	$RES .= '</tr>';
}

$RES .= '</tbody></table>      
	  	<p>&nbsp;</p>
      	</td>
      	</tr>
      	</table>';
	  
//Codigo para la paginacion de los resultados
echo $RES;
echo "<table align='center'><tr><td>";
//necesario incluir para la paginacion
include("../paginanavegacion.php");
echo "</td></tr></table>";	 

?>

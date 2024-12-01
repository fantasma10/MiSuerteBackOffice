<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../inc/menuFunctions.php");

$status			= (isset($_POST['status']))?$_POST['status']:1;

global $RBD;

$esEscritura = false;

if ( esLecturayEscrituraOpcion(29) ) {
	$esEscritura = true;	
}

$RES ='<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="BorderShadow2 CornerRadius">
  <tr>
    <td>
		<br />
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
	        <td class="Titles">&nbsp;</td>
	    	<td class="Titles"><div align="center"> Id</div></td>
            <td class="Titles">&nbsp;</td>
        	<td class="Titles"><div align="center"> Correo</div></td>
        	<td class="Titles">&nbsp;</td>
           	<td class="Titles"><div align="center"> Nombre</div></td>
        	<td class="Titles">&nbsp;</td>
        </tr>
        <tr>
        	<td class="Titles" colspan="3">&nbsp;</td>
        </tr>
        <tr>
        	<td colspan="6" bgcolor="#000099"><img src="../../img/pixel.gif" alt="" width="1" height="1" /></td>
        </tr>
        <tr>
        	<td class="Titles" colspan="3">&nbsp;</td>
        </tr>';
		
//Estas tres variables son necesarias para mostrar la paginanacion descripcion el el archivo paginanavegacion.php
$cant = 20;
$funcion = "BuscarUsuarios";
$sqlcount = "SELECT COUNT(`dat_usuario`.`idUsuario`)
			 FROM `data_acceso`.`dat_usuario`
			 INNER JOIN `data_acceso`.`inf_gruposdelusuario` USING(`idUsuario`)
			 WHERE `dat_usuario`.`idEstatus` = $status
			 ORDER BY `idUsuario` ASC;";

//necesario incluir para la paginacion
include("../actualpaginacion.php");

$SQL = "SELECT `dat_usuario`.`idUsuario`,
		`dat_usuario`.`idPerfil`,
		`dat_usuario`.`email`,
		`dat_usuario`.`nombre`,
		`dat_usuario`.`apellidoPaterno`,
		`dat_usuario`.`apellidoMaterno` 
		FROM `data_acceso`.`dat_usuario` 
		INNER JOIN `data_acceso`.`inf_gruposdelusuario` USING(`idUsuario`)
		WHERE `dat_usuario`.`idEstatus` = $status
		ORDER BY `idUsuario` ASC LIMIT $actual, $cant;";
		
$Result = $RBD->query($SQL);
			
while( list($id,$idPer,$mail,$nom,$apeP,$apeM)=mysqli_fetch_array($Result) ) {	
	$RES .= '<tr class="HighlightableRow">
		    <td width="10">&nbsp;</td>
		    <td><div align="center">'.$id.'</div></td>
		    <td width="10">&nbsp;</td>
		    <td><div align="left">'.$mail.'</div></td>
		    <td width="10">&nbsp;</td>
		    <td><div align="left">'.htmlentities($nom).' '.htmlentities($apeP).' '.htmlentities($apeM).'</div></td>
		    <td>';
		  
	if( $esEscritura ) {
		$RES .= '<div align="center"><a href="Consulta.php?id='.$id.'">Editar</a></div>';
	}
	
	$RES .= '</td>
			 <td width="10">&nbsp;</td>
		     <td>';
			 
	if( $esEscritura ) { 
		$RES.='<div align="center"><a onclick="EliminarActualizarUsuario('.$id.',2)">Eliminar</a></div>';
	}
	
	$RES .= '</td>
			</tr>';
}
		  
$RES .= '</table>      
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
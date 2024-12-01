<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idPermiso = (isset($_SESSION['Permisos']['Tipo'][4]))?$_SESSION['Permisos']['Tipo'][4]:1;

global $RBD;

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
$sqlcount = "SELECT COUNT(`idUsuario`)
			 FROM `data_acceso`.`dat_usuario` 
			 WHERE `idEstatus` = 2 
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
		WHERE USU.`idEstatus` = 2
		ORDER BY USU.`idUsuario` ASC LIMIT $actual, $cant;";
					
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
		$RES.='<div align="center"><a href="Consulta.php?id='.$id.'">Editar</a></div>';
	}
				  
	$RES.='</td>
		   <td width="10">&nbsp;</td>
		   <td>';
			   
	if( $esEscritura ) { 
		$RES.='<div align="center"><a onclick="EliminarActualizarUsuario('.$id.',0)">Activar</a></div>';
	}
				  
	$RES.='</td>
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
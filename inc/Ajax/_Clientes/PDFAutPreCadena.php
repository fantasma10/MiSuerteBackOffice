<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .PDF **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");


$idOpcion = 2;
	$tipoDePagina = "Escritura";

	if(!desplegarPagina($idOpcion, $tipoDePagina)){
		header("Location: ../../../error.php");
		exit();
	}

	$submenuTitulo = "Pre-Alta";
	$subsubmenuTitulo ="Corresponsal";

	if(!isset($_SESSION['rec'])){
		$_SESSION['rec'] = true;
	}

	$idCadena = (!empty($_POST['idCadena']))? $_POST['idCadena'] : 0;

	if($idCadena == 0){
		header('Location: ../../../index.php');//redireccionar no existe la pre-cadena
	}
	else{
		$oCadena = new XMLPreCadena($RBD,$WBD);
		$oCadena->load($idCadena);

		if($oCadena->getExiste()){
			$_SESSION['idPreCadena'] = $idCadena;
		}
		else{
			echo "<pre>"; echo var_dump("<h2>No existe la PreCadena : $idCadena</h2>"); echo "</pre>";
			//header('Location: ../../index.php');//redireccionar no existe la pre-cadena
		}	
	}

$oCadena = new XMLPreCadena($RBD,$WBD);



$oCadena->load($idCadena);

$data='<table width="600px" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top" class="back_autorizacion">
			<table>
				<tr>
					<td align="left">
						<span style="color:#4d4d4d;font-size:39px;margin:20px;font-weight:bold;float:left;">ID:</span><span style="color:#061878;font-size:39px;"> '.$oCadena->getId().'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#4d4d4d;margin:20px 0px 20px 20px;font-size:39px;font-weight:bold;float:left">Cadena:</span> <span style="color:#061878;font-size:39px;"> '.$oCadena->getNombre().'</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top">
			<table border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td align="left" valign="bottom"><span style="color:#35659d;font-size:39px">Afiliaci&oacute;n y Cuotas</span></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="right" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top" colspan="3">
						<table width="100%" height="162" border="0" cellpadding="3" cellspacing="0" style="border: 1px solid #35659d;">
							<tr>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Concepto</span></td>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Importe</span></td>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Fecha de Inicio</span></td>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Observaciones</span></td>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Configuraci&oacute;n</span></td>
							</tr>';
						

				$oPreCargo = new PreCargo($LOG, $WBD, $RBD, null, null, $oCadena->getID(), 0, 0, 0, "", "", "", 0, 0, 0);
				$cargos = $oPreCargo->cargarTodos();
				$cuenta = count($cargos);

				$emptyRow = '<tr><td colspan="5"><span style="font-size:32px;">No hay informaci&oacute;n para mostrar</span></td></tr>';
				if($cuenta > 0){
					foreach($cargos AS $cargo){
						$cfg = ($cargo['Configuracion'] == 0)? 'Compartido' : 'Individual';

						$data.= '<tr>';
						$data.= '<td><span style="font-size:32px;border: 1px solid #35659d;">'.$cargo['nombreConcepto'].'</span></td>';
						$data.= '<td><span style="font-size:32px;border: 1px solid #35659d;">'.$cargo['importe'].'</span></td>';
						$data.= '<td><span style="font-size:32px;border: 1px solid #35659d;">'.$cargo['fechaInicio'].'</span></td>';
						$data.= '<td><span style="font-size:32px;border: 1px solid #35659d;">'.$cargo['observaciones'].'</span></td>';
						$data.= '<td><span style="font-size:32px;border: 1px solid #35659d;">'.$cfg.'</span></td>';
						$data.= '</tr>';
					}
				}
				else{
					$data.= $emptyRow;
				}
				$data.='</table>';
				$data.='</td>
					
				</tr>
				<tr>
					<td align="left" valign="bottom">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="right" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="bottom"><span style="color:#35659d;font-size:39px">Datos Generales</span></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="right" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td  align="left" valign="top" style="font-weight:bold;font-size:32px;">Grupo:</td>
					<td  align="left" valign="top" style="font-weight:bold;font-size:32px;">Referencia:</td>
					<td  align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreGrupo().'</span></td>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreReferencia().'</span></td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top" style="font-weight:bold;font-size:32px;">Tel&eacute;fono:</td>
					<td align="left" valign="top" style="font-weight:bold;font-size:32px;">Correo Electr&oacute;nico:</td>
					<td align="left" valign="top" style="font-weight:bold;font-size:32px;"></td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getTel1().'</span></td>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getCorreo().'</span></td>
					<td align="left" valign="top"><span style="font-size:32px;"></span></td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="color:#35659d;font-size:39px;">Direcci&oacute;n</span></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" align="left" valign="top">';
						if($oCadena->getCalle() != "")
							$data.='<span style="font-size:32px;">'.$oCadena->getCalle().'</span>';
						if($oCadena->getCalle() != "" && $oCadena->getNext() != "")    
							$data.= '<span style="font-size:32px;"> No. '.$oCadena->getNext().'</span>';
						if($oCadena->getCalle != "" && $oCadena->getNint() != "")
							$data.= '<span style="font-size:32px;"> No. Int.'.$oCadena->getNint().'</span><br />';;
						if($oCadena->getColonia() != "")
							$data.= '<br /><span style="font-size:32px;">Col. '.$oCadena->getNombreColonia().'</span>';
						if($oCadena->getCP() != "")
							$data.= '<span style="font-size:32px;"> C.P. '.$oCadena->getCP().'</span><br />';                        
						if($oCadena->getColonia() != "" && $oCadena->getNombreCiudad() != "")
							$data.= '<span style="font-size:32px;">'.$oCadena->getNombreCiudad().'</span>';
						if($oCadena->getNombreEstado() != "")
							$data.= '<span style="font-size:32px;">, '.$oCadena->getNombreEstado().'</span>';
						if($oCadena->getNombreEstado() != "" && $oCadena->getNombrePais())
							$data.= '<span style="font-size:32px;">, '.$oCadena->getNombrePais().'</span><br />';
					$data.='</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="color:#35659d;font-size:39px;">Contactos</span></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" align="center" valign="top">
						<table width="100%" height="162" border="0" cellpadding="3" cellspacing="0" style="border: 1px solid #35659d;">
							<tr>
								<td align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Contacto</span></td>
								<td  align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Tel&eacute;fono</span></td>
								<td  align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Extensi&oacute;n</span></td>
								<td  align="center" valign="middle" style="border: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Correo Electr&oacute;nico</span></td>
								<td  align="center" valign="middle" style="border: 1px solid #35659d;border-right:none;" ><span style="font-weight:bold;font-size:32px;">Tipo de Contacto</span></td>
							</tr>';
							$query = "CALL `redefectiva`.`SP_LOAD_PRECONTACTOS_GENERAL`($idCadena, 0, 1)";

							$emptyRow = '<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td></tr>';

							$sql = $RBD->query($query);

							if(!$RBD->error()){
								if(mysqli_num_rows($sql) > 0){
									while($row = mysqli_fetch_assoc($sql)){
										$data.= '<tr>';
										$data.= '<td style="border: 1px solid #35659d;"><span style="font-size:32px;">'.((!preg_match("!!u", $row['nombreCompleto']))? utf8_encode($row['nombreCompleto']) : $row['nombreCompleto']).'</span></td>';
										$data.= '<td style="border: 1px solid #35659d;"><span style="font-size:32px;">'.$row['telefono1'].'</span></td>';
										$data.= '<td align="center" valign="middle" style="border: 1px solid #35659d;"> <span style="font-size:32px;">'.$row['extTelefono1'].' </span></td>';
										$data.= '<td style="border: 1px solid #35659d;"><span style="font-size:32px;">'.$row['correoContacto'].'</span></td>';
										$data.= '<td style="border: 1px solid #35659d;"><span style="font-size:32px;">'.((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto']).'</span></td>';
										$data.= "</tr>";
									}
								}
								else{
									$data.= $emptyRow;
								}
							}
							else{
								$data.= $emptyRow;
							}
												
						$data.='</table>    
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="color:#35659d;font-size:39px;">Ejecutivos</span></td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="font-weight:bold;font-size:32px;">Ejecutivo de Cuenta:</span></td>
					<td align="left" valign="top"><span style="font-weight:bold;font-size:32px;">Ejecutivo de Venta:</span></td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreECuenta().'</span></td>
					<td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreEVenta().'</span></td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
</table>';

//codigo del departamento
$departamento = "DSI";
//tipo de documento
$tipodocumento = "IF";
//consecutivo del documento
$consecutivo = "01";
//Seccion
$seccion = "Reporte de Alta de Cadena";
include("../../../tcpdf/CrearPDF.php");


?>
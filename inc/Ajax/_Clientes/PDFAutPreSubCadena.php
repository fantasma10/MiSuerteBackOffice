<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .PDF **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreSubCadena.php");

$oSubCadena = new XMLPreSubCad($RBD,$WBD);

$idSubCadena = (!empty($_POST['idSubCadena']))? $_POST['idSubCadena'] : 0;

$oSubCadena->load($idSubCadena);


$data='<table width="" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="left" valign="top" class="back_autorizacion">
					<table>
						<tr>
							<td align="left">
								<span style="color:#4d4d4d;font-size:33px;margin:20px;font-weight:bold;float:left;">ID:</span><span style="color:#061878;font-size:33px;"> '.$oSubCadena->getId().'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;				
								<span style="color:#4d4d4d;margin:20px 0px 20px 20px;font-size:33px;font-weight:bold;float:left">SubCadena:</span> <span style="color:#061878;font-size:33px;"> '.$oSubCadena->getNombre().'  </span>
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
				  <td align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="2" cellspacing="0">

					 <tr>
						<td align="left" valign="bottom"><span style="color:#35659d;font-size:33px">Datos Generales</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="right" valign="top"></td>
					 </tr>
					 <tr>
						<td width="33%" align="left" valign="top" style="font-weight:bold;font-size:26px;">Cadena:</td>
						<td width="32%" align="left" valign="top" style="font-weight:bold;font-size:26px;"></td>
						<td width="35%" align="left" valign="top"><span style="font-weight:bold;font-size:26px;"></span></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNombreCadena().' </td>
						<td align="left" valign="top" style="font-size:26px;"> </td>
						<td align="left" valign="top" style="font-size:26px;">  </td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">Grupo:</td>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">Referencia:</td>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;"></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNombreGrupo().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNombreReferencia().' </td>
						<td align="left" valign="top" style="font-size:26px;">  </td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">Tel&eacute;fono:</td>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">Correo Electr&oacute;nico:</td>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getTel1().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCorreo().' </td>
						<td align="left" valign="top" style="font-size:26px;">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="color:#35659d;font-size:33px">Direcci&oacute;n</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;">';
							if($oSubCadena->getCalle() != '')
								$data.=$oSubCadena->getCalle();
							if($oSubCadena->getCalle() != '' && $oSubCadena->getNext() != '')
								$data.=' No '.$oSubCadena->getNext();
							if($oSubCadena->getCalle() != '' && $oSubCadena->getNint() != '')  
								$data.=' No. Int.'.$oSubCadena->getNint();  

							$data.='<br />';

							if($oSubCadena->getColonia() != '')
								$data.=' Col. '.$oSubCadena->getNombreColonia();
							if($oSubCadena->getCP() != '')
								$data.=' C.P. '.$oSubCadena->getCP();                    

							$data.='<br />';

							if($oSubCadena->getColonia() != '' && $oSubCadena->getCiudad() != '')
								$data.=$oSubCadena->getNombreCiudad();					
							if($oSubCadena->getEstado() != '')
								$data.=', '.$oSubCadena->getNombreEstado();
							if($oSubCadena->getEstado() != '' && $oSubCadena->getPais() != '')
								$data.=', '.$oSubCadena->getNombrePais();

							$data.='<br />';
							$data.='</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="color:#35659d;font-size:33px">Contactos</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td colspan="3" align="center" valign="top">
							<table width="100%" height="162" border="0" cellpadding="3" cellspacing="0" style="border: 1px solid #35659d;">
								<tr>
								  <td align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:26px;">Contacto</span></td>
								  <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:26px;">Tel&eacute;fono</span></td>
								  <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:26px;">Extensi&oacute;n</span></td>
								  <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:26px;">Correo Electr&oacute;nico</span></td>
								  <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;border-right:none;" ><span style="font-weight:bold;font-size:26px;">Tipo de Contacto</span></td>
								</tr>';
								$query = "CALL `redefectiva`.`SP_LOAD_PRECONTACTOS_GENERAL`($idSubCadena, 0, 2)";

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
													$data.= '<td><span style="font-size:26px;">'.((!preg_match("!!u", $row['nombreCompleto']))? $row["nombreCompleto"] : $row['nombreCompleto']).'</span></td>';
													$data.= '<td><span style="font-size:26px;">'.$row['telefono1'].'</span></td>';
													$data.= '<td><span style="font-size:26px;">'.$row['extTelefono1'].'</span></td>';
													$data.= '<td><span style="font-size:26px;">'.$row['correoContacto'].'</span></td>';
													$data.= '<td><span style="font-size:26px;">'.((!preg_match("!!u", $row['descTipoContacto']))? utf8_encode($row['descTipoContacto']) : $row['descTipoContacto']).'</span></td>';
													$data.= '</tr>';
												}
											}
											else{
												$data.= $emptyRow;
											}
										}
										else{
											$data.= $emptyRow;
										}
						  
					$fechaConstitucion = $oSubCadena->getCFConstitucion();
					if (isset($fechaConstitucion) && $fechaConstitucion != "") {
						$fechaConstitucion = date("Y-m-d", strtotime($fechaConstitucion));
					} else {
						$fechaConstitucion = "";
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
						<td align="left" valign="top"><span style="color:#35659d;font-size:33px">Documentos</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td colspan="3" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							 <td width="50%"><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
								  if($oSubCadena->getDDomicilio() != "")
									 $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  
								  $data.='</td>
								  <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>Comprobante de Domicilio</p></td>
								</tr>
							 </table></td>
							 <td width="50%"><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
									if($oSubCadena->getDFiscal() != "")
										  $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  $data.='</td>
								  <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>Comprobante de Domicilio Fiscal</p></td>
								</tr>
							 </table></td>
						  </tr>
						  <tr>
							 <td><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
									if($oSubCadena->getDRepLegal() != "")
										  $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  $data.='</td>
								  <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>Identificaci&oacute;n Representante Legal</p></td>
								</tr>
							 </table></td>
							 <td><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
									if($oSubCadena->getDRSocial() != "")
										  $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>RFC Raz&oacute;n Social</p></td>
								</tr>
							 </table></td>
						  </tr>
						  <tr>
							 <td><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
									if($oSubCadena->getDAConstitutiva() != "")
										  $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>Acta Constitutiva</p></td>
								</tr>
							 </table></td>
							 <td><table border="0" cellspacing="0" cellpadding="3">
								<tr>
								  <td align="center" valign="middle" width="10%">';
									if($oSubCadena->getDPoderes() != "")
									 $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
								  $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:26px;"><p>Poderes</p>                            </td>
								</tr>
							 </table></td>
						  </tr>
						</table></td>
						</tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="color:#35659d;font-size:33px">Cuenta</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-weight:bold;font-size:26px;">FORELO:</td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Descripci&oacute;n FORELO:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Referencia de Depósito:</span></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getFCantidad().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getFDescripcion().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getFReferencia().' </td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Banco:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">CLABE:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">No. de Cuenta:</span></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNombreBanco().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getClabe().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNumCuenta().' </td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Descripci&oacute;n de Cuenta:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Beneficiario:</span></td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. utf8_decode($oSubCadena->getDescripcion()).' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. utf8_decode($oSubCadena->getBeneficiario()).' </td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="color:#35659d;font-size:33px">Contrato</span></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Raz&oacute;n Social:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Fecha de Constituci&oacute;n:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Direcci&oacute;n Fiscal:</span></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCRSocial().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $fechaConstitucion.' </td>
						<td align="left" valign="top" style="font-size:26px;">';
								
								if($oSubCadena->getCCalle() != '')
									 $data.=$oSubCadena->getCCalle();
								if($oSubCadena->getCCalle() && $oSubCadena->getCNext() != '')
									 $data.=' No. '.$oSubCadena->getCNext();
								if($oSubCadena->getCCalle() && $oSubCadena->getCNint() != '')
									 $data.=' No. Int.'.$oSubCadena->getCNint();							
						
						$data.='</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"style="font-size:26px;">'.$oSubCadena->getCRfc().'</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top" style="font-size:26px;">';
						  if($oSubCadena->getCColonia() != ''&& $oSubCadena->getCColonia() > 0)
							$data.='Col. '.$oSubCadena->getCNombreColonia();
								if($oSubCadena->getCCP() != ''&& $oSubCadena->getCCP() > 0)
									 $data.=' C.P. '.$oSubCadena->getCCP();
						  
						$data.='</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;">'.$oSubCadena->getNombreCRegimen().'</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top" style="font-size:26px;">';
								
					if($oSubCadena->getCColonia() != '' && $oSubCadena->getCCiudad() != ''&& $oSubCadena->getCColonia() > 0)
								$data.=$oSubCadena->getNombreCCiudad();                        
					if($oSubCadena->getCEstado() != ''&& $oSubCadena->getCEstado() > 0)
								$data.=', '.$oSubCadena->getCNombreEstado();
						  if($oSubCadena->getCEstado() != '' && $oSubCadena->getCPais() != ''&& $oSubCadena->getCEstado() > 0)
								$data.=', '.$oSubCadena->getCNombrePais();
						  
						$data.='</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top" style="font-size:26px;">';  
						  
						$data.='</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Representante Legal:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">No. de Identificaci&oacute;n:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">Tipo de Identificaci&oacute;n:</span></td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCNombre()." ".$oSubCadena->getCPaterno()." ".$oSubCadena->getCMaterno().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCNumIden().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getNombreCRTipoIden().' </td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">RFC:</span></td>
						<td align="left" valign="top"><span style="font-weight:bold;font-size:26px;">CURP:</span></td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
					 <tr>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCRRfc().' </td>
						<td align="left" valign="top" style="font-size:26px;"> '. $oSubCadena->getCCurp().' </td>
						<td align="left" valign="top" style="font-size:26px;">';
						if($oSubCadena->getCFigura()){$data.=' Figura Pol&iacute;ticamente Expuesta';}$data.='</td>
					 </tr>
					 <tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top">&nbsp;</td>
					 </tr>
				  </table></td>
				</tr>
			 </table>';

//codigo del departamento
$departamento = "DSI";
//tipo de documento
$tipodocumento = "IF";
//consecutivo del documento
$consecutivo = "02";
//Seccion
$seccion = "Reporte de Alta de Subcadena";
include("../../../tcpdf/CrearPDF.php");

?>
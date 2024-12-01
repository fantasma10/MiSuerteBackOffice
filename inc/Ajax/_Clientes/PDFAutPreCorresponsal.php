<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .PDF **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCorresponsal.php");

$oCorresponsal = new XMLPreCorresponsal($RBD,$WBD);
$oCorresponsal->load($_SESSION['idPreCorresponsal']);

$data='<table width="" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="top" class="back_autorizacion">
              <table>
                <tr>
                    <td align="left">
                    <span style="color:#4d4d4d;font-size:33px;margin:0px;font-weight:bold;float:left;">ID:</span><span style="color:#061878;font-size:33px;"> '.$oCorresponsal->getId().'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					
					<span style="color:#4d4d4d;margin:0px 0px 0px 20px;font-size:33px;font-weight:bold;float:left">Corresponsal:</span> <span style="color:#061878;font-size:33px;"> '.$oCorresponsal->getNombre().'  </span>
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
                  <td width="33%" align="left" valign="top" style="font-weight:bold;font-size:24px;">Cadena:</td>
                  <td width="32%" align="left" valign="top" style="font-weight:bold;font-size:24px;">SubCadena:</td>
                  <td width="35%" align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Giro:</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreCadena().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. utf8_decode($oCorresponsal->getNombreSubCadena()).' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreGiro().' </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Grupo:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Tel&eacute;fono1:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Tel&eacute;fono 2:</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreGrupo().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getTel1().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getTel2().' </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Fax:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Correo Electr&oacute;nico:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Referencia:</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getFax().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCorreo().' </td>
                  <td align="left" valign="top" style="font-size:24px;">'.$oCorresponsal->getNombreReferencia().'</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">Versi&oacute;n:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">&nbsp;</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;">'.$oCorresponsal->getNombreVersion().'</td>
                  <td align="left" valign="top" style="font-size:24px;">&nbsp;</td>
                  <td align="left" valign="top" style="font-size:24px;">&nbsp;</td>
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
                  <td align="left" valign="top" style="font-size:24px;">';
                                
                    if($oCorresponsal->getCalle() != '')
                         $data.=$oCorresponsal->getCalle();
                    if($oCorresponsal->getCalle() != '' && $oCorresponsal->getNext() != '')
                        $data.=' No '.$oCorresponsal->getNext();
                    if($oCorresponsal->getCalle() != '' && $oCorresponsal->getNint() != '')
                        $data.=' No Int.'.$oCorresponsal->getNint();						
                        $data.='<br />';
                    
                    if($oCorresponsal->getColonia() != '')
                       $data.=' Col. '.$oCorresponsal->getCNombreColonia();
                    if($oCorresponsal->getCP() != '')
                        $data.=' C.P. '.$oCorresponsal->getCP();
                    
                        $data.='<br />';
                    
                    if($oCorresponsal->getColonia() != '' && $oCorresponsal->getCiudad() != '')
                       $data.=$oCorresponsal->getNombreCiudad();					
                    if($oCorresponsal->getEstado() != '')
                        $data.=', '.$oCorresponsal->getNombreEstado();
                    if($oCorresponsal->getEstado() != '' && $oCorresponsal->getPais() != '')
                        $data.=', '.$oCorresponsal->getNombrePais();
                    
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
                          <td align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:24px;">Contacto</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:24px;">Tel&eacute;fono</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:24px;">Correo Electr&oacute;nico</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;border-right:none;" ><span style="font-weight:bold;font-size:24px;">Tipo de Contacto</span></td>
                        </tr>';
                        $AND = "";
                        $contactos = $oCorresponsal->getContactos();
                        $band = false;
                        for($i = 0; $i < count($contactos);$i++){
                            if($band == false && $contactos[$i] != ""){
                                $AND.=' AND I.`idCorresponsalContacto` = '.$contactos[$i]->getInfId().' ';
                                $band = true;
                            }
                            else if($band)
                                $AND.=' OR I.`idCorresponsalContacto` = '.$contactos[$i]->getInfId().' ';
                        }
                        if($AND != ""){
                            $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRECORRESPONSAL`('$AND');";
							$Result = $RBD->SP($sql);
                            if($RBD->error() == ""){
                                if($Result != "" && mysqli_num_rows($Result) > 0){
                                    $i = 0;
                                    while(list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result)){
                                        $data.='<tr  ';if($tipo == 6){ $data.= 'style="border-right: 1px solid #35659d;background-color:#e5e5f5;"';} $data.=' >
                                          <td align="center" valign="middle" style="border-left: 1px solid #35659d;"><span style="font-size:24px;">'.$nombre.' '.$paterno.' '.$materno.'</span></td>
                                          <td align="center" valign="middle"> <span style="font-size:24px;">'.$telefono.' </span></td>
                                          <td align="center" valign="middle"> <span style="font-size:24px;">'.$correo.' </span></td>
                                          <td align="center" valign="middle" style="border-right: 1px solid #35659d;"><span style="font-size:24px;">'.$desc.'</span> </td>
                                        </tr>';
                                        $i++;
                                    }
                                }
                            }
                        }
                     
					$fechaConstitucion = $oCorresponsal->getCFConstitucion();
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
                          if($oCorresponsal->getDDomicilio() != "")
                            $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          
                          $data.='</td>
                          <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>Comprobante de Domicilio</p></td>
                        </tr>
                      </table></td>
                      <td width="50%"><table border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td align="center" valign="middle" width="10%">';
                           if($oCorresponsal->getDFiscal() != "")
                                $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          $data.='</td>
                          <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>Comprobante de Domicilio Fiscal</p></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td align="center" valign="middle" width="10%">';
                           if($oCorresponsal->getDRepLegal() != "")
                                $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          $data.='</td>
                          <td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>Identificaci&oacute;n Representante Legal</p></td>
                        </tr>
                      </table></td>
                      <td><table border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td align="center" valign="middle" width="10%">';
                           if($oCorresponsal->getDRSocial() != "")
                                $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>RFC Raz&oacute;n Social</p></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td align="center" valign="middle" width="10%">';
                           if($oCorresponsal->getDAConstitutiva() != "")
                                $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>Acta Constitutiva</p></td>
                        </tr>
                      </table></td>
                      <td><table border="0" cellspacing="0" cellpadding="3">
                        <tr>
                          <td align="center" valign="middle" width="10%">';
                           if($oCorresponsal->getDPoderes() != "")
                            $data.='<img src="../../../img/img_ok.png" alt="angulo" width="17" height="17" />';
                          $data.='</td><td align="left" valign="middle" width="90%" style="font-weight:bold;font-size:24px;"><p>Poderes</p>                            </td>
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
                  <td align="left" valign="top" style="font-weight:bold;font-size:24px;">FORELO:</td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Descripci&oacute;n FORELO:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Referencia de Depósito:</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getFCantidad().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getFDescripcion().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getFReferencia().' </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Banco:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">CLABE:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">No. de Cuenta:</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreBanco().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getClabe().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNumCuenta().' </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Descripci&oacute;n de Cuenta:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Beneficiario:</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. utf8_decode($oCorresponsal->getDescripcion()).' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. utf8_decode($oCorresponsal->getBeneficiario()).' </td>
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
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Raz&oacute;n Social:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Fecha de Constituci&oacute;n:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Direcci&oacute;n Fiscal:</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCRSocial().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $fechaConstitucion.' </td>
                  <td align="left" valign="top" style="font-size:24px;">';
                        
                        if($oCorresponsal->getCCalle() != '')
                            $data.=$oCorresponsal->getCCalle();
                        if($oCorresponsal->getCCalle() != '' && $oCorresponsal->getCNext() != '')
                            $data.=' No. '.$oCorresponsal->getCNext();
                        if($oCorresponsal->getCCalle() != '' && $oCorresponsal->getCNint() != '')
                            $data.=' No. Int.'.$oCorresponsal->getCNext();							
                  
                  $data.='</td>
                </tr>
                <tr>
                  <td align="left" valign="top"style="font-size:24px;">'.$oCorresponsal->getCRfc().'</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top" style="font-size:24px;">';
                    
                    if($oCorresponsal->getCColonia() != ''&& $oCorresponsal->getCColonia() > 0)
                        $data.='Col. '.$oCorresponsal->getCNombreColonia();
					if($oCorresponsal->getCCP() != ''&& $oCorresponsal->getCCP() > 0)
						$data.=' C.P. '.$oCorresponsal->getCCP();
                    
                  $data.='</td>
                </tr>
                <tr>
                  <td align="left" valign="top"style="font-size:24px;">'.$oCorresponsal->getNombreCRegimen().'</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top" style="font-size:24px;">';
                        
					if($oCorresponsal->getCColonia() != '' && $oCorresponsal->getCCiudad() != ''&& $oCorresponsal->getCColonia() > 0)
						$data.=$oCorresponsal->getNombreCCiudad();                        
					if($oCorresponsal->getCEstado() != ''&& $oCorresponsal->getCEstado() > 0)
						$data.=', '.$oCorresponsal->getCNombreEstado();
					if($oCorresponsal->getCEstado() != '' && $oCorresponsal->getCPais() != ''&& $oCorresponsal->getCEstado() > 0)
						$data.=', '.$oCorresponsal->getCNombrePais();
                    
                  $data.='</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top" style="font-size:24px;">';
                    
                  $data.='</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Representante Legal:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">No. de Identificaci&oacute;n:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Tipo de Identificaci&oacute;n:</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCNombre()." ".$oCorresponsal->getCPaterno()." ".$oCorresponsal->getCMaterno().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCNumIden().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreCRTipoIden().' </td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">RFC:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">CURP:</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCRRfc().' </td>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getCCurp().' </td>
                  <td align="left" valign="top" style="font-size:24px;">';
                  if($oCorresponsal->getCFigura()){$data.=' Figura Pol&iacute;ticamente Expuesta';}$data.='</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="color:#35659d;font-size:33px">Ejecutivos</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Ejecutivo de Venta:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:24px;">Ejecutivo de Cuenta:</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" style="font-size:24px;"> '. $oCorresponsal->getNombreEVenta().' </td>
                  <td align="left" valign="top" style="font-size:24px;" > '. $oCorresponsal->getNombreECuenta().' </td>
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
$consecutivo = "03";
//Seccion
$seccion = "Reporte de Alta de Corresponsal";
include("../../../tcpdf/CrearPDF.php");

?>

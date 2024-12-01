<?php
/*
********** ARCHIVO QUE ESPECIFICA LAS CABECERAS Y EL QUERY PARA CREAR EL ARCHIVO .PDF **********
*/
include("../../config.inc.php");
include("../../session.ajax.inc.php");
include("../../obj/XMLPreCadena.php");

$oCadena = new XMLPreCadena($RBD,$WBD);
$oCadena->load($_SESSION['idPreCadena']);

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
                  <td align="left" valign="top" style="font-weight:bold;font-size:32px;">Correo Electr&oacute;nico:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:32px;">Tel&eacute;fono:</td>
                  <td align="left" valign="top" style="font-weight:bold;font-size:32px;"></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getCorreo().'</span></td>
                  <td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getTel1().'</span></td>
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
                          <td align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Contacto</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Tel&eacute;fono</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;"><span style="font-weight:bold;font-size:32px;">Correo Electr&oacute;nico</span></td>
                          <td  align="center" valign="middle" style="border-bottom: 1px solid #35659d;border-right:none;" ><span style="font-weight:bold;font-size:32px;">Tipo de Contacto</span></td>
                        </tr>';
                        $AND = "";
                        $contactos = $oCadena->getContactos();
                        $band = false;
                        for($i = 0; $i < count($contactos);$i++){
                            if($band == false && $contactos[$i] != ""){
                                $AND.=' AND I.`idCadenaContacto` = '.$contactos[$i]->getInfId().' ';
                                $band = true;
                            }
                            else if($band)
                                $AND.=' OR I.`idCadenaContacto` = '.$contactos[$i]->getInfId().' ';
                        }
                        if($AND != ""){
							$sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRECADENA`('$AND');";
							$Result = $RBD->SP($sql);
							if($RBD->error() == ""){
								if($Result != "" && mysqli_num_rows($Result) > 0){
                                    $i = 0;
                                    while(list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result)){
										$data.='<tr  ';if($tipo == 6){ $data.= 'style="border-right: 1px solid #35659d;background-color:#e5e5f5;"';} $data.=' >
                                          <td align="center" valign="middle" style="border-left: 1px solid #35659d;"><span style="font-size:32px;">'.$nombre.' '.$paterno.' '.$materno.'</span></td>
                                          <td align="center" valign="middle"> <span style="font-size:32px;">'.$telefono.' </span></td>
                                          <td align="center" valign="middle"> <span style="font-size:32px;">'.$correo.' </span></td>
                                          <td align="center" valign="middle" style="border-right: 1px solid #35659d;"><span style="font-size:32px;">'.$desc.'</span> </td>
                                        </tr>';
                                        $i++;
                                    }
                                }
                            }
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
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:32px;">Ejecutivo de Venta:</span></td>
                  <td align="left" valign="top"><span style="font-weight:bold;font-size:32px;">Ejecutivo de Cuenta:</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreEVenta().'</span></td>
                  <td align="left" valign="top"><span style="font-size:32px;">'.$oCadena->getNombreECuenta().'</span></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>

              </table></td>
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
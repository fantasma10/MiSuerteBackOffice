<?php
ini_set("soap.wsdl_cache_enabled", "0");


class guardar_AutorizacionProspecto{
    private $nIdUsuario;
    private $nIdCorresponsal;
    private $numCuenta;
    function setsnIdUsuario($nIdUsuario){
        $this->nIdUsuario=$nIdUsuario;
    }
    function setnIdCorresponsal($nIdCorresponsal){
        $this->nIdCorresponsal=$nIdCorresponsal;
    }
    function numCuenta($numCuenta){
        $this->numCuenta = $numCuenta;
    }
    
    function datos_ProspectosAut(){
        include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
        include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");
        include($_SERVER['DOCUMENT_ROOT']."/inc/conexionWSRE.php");

        $oRAMP->setSDatabase('aquimispagos');
        $data=array();
        //$oRAMP->setSStoredProcedure('sp_insert_autorizacionfiscalizado');
        $param = array
                (   array(
                        'nIdUsuario'  => 'p_nIdUsuario',
                        'type'  => 'i',
                        'value' => $this->nIdUsuario)       
                );
        $oRAMP->setSStoredProcedure('sp_select_datos_fiscalizados');
        $oRAMP->setParams($param);
        $result = $oRAMP->execute();
        $data = $oRAMP->fetchAll();
        $oRAMP->closeStmt();
        $this->setnIdCorresponsal($data[0]['nIdCorresponsalRE']);
        $arrayParametrosCorresponsal= array(        
            'IdCorresponsal' => $this->nIdCorresponsal
        );  
        $respuesta =(array) $client->ObtenerCorresponsalPorId($arrayParametrosCorresponsal);
        $data[0]['nombreCorresponsal']= $respuesta['ObtenerCorresponsalPorIdResult']->Model->anyType->enc_value->NombreCorresponsal;
        $data[0]['numCuenta']= $respuesta['ObtenerCorresponsalPorIdResult']->Model->anyType->enc_value->NumeroCuenta;
        $this->numCuenta($data[0]['numCuenta']);
        $oRAMP->setSDatabase('aquimispagos');
        $data2=array();
        $param = array
                (   array(
                    'sNumeroCuenta'  => 'P_sNumCuenta',
                    'type'  => 's',
                    'value' => $this->numCuenta)       
                );
        $oRAMP->setSStoredProcedure('sp_select_forelo');
        $oRAMP->setParams($param);        
        $result2 = $oRAMP->execute();
        $data2 = $oRAMP->fetchAll();
        $oRAMP->closeStmt();
        $data[0]['sReferencia']=$data2[0]['sReferencia'];
        $data[0]['sReferenciaPayCash']=$data2[0]['sReferenciaPayCash'];
        $data[0]['RFC']=$data2[0]['sRfc'];
        $data[0]['saldoCuenta']=$data2[0]['dDepositado'];
        $usuarioRE= $data2[0]['nIdUsuario'];
        $arrayParametrosCorte= array(        
            'IdCorresponsal' => $this->nIdCorresponsal,
            'IdCadena' => $data[0]['nIdCadenaRE'],
            'IdSubCadena' => $data[0]['nIdSubCadenaRE'],
        );
        $respuestaCorte= (array) $client->ObtenerCortePorId($arrayParametrosCorte);
        $data[0]['codigo'] =  $respuestaCorte['ObtenerCortePorIdResult']->Model->anyType->enc_value->Codigo;
        $IdCliente =  $respuestaCorte['ObtenerCortePorIdResult']->Model->anyType->enc_value->IdCliente;
        $arrayParametrosRepresentanteLegal=array(
            "oLegalRepresentative"=>array(
                "IdRepLegal"=>0,
                "IdcTipoIdent"=>$data[0]['nIdTipoIdentificacionContacto'],
                "NombreRepreLegal"=>$data[0]['sNombreContacto'],
                "ApPRepreLegal"=>$data[0]['sApellidoPaternoContacto'],
                "ApMRepreLegal"=>$data[0]['sApellidoMaternoContacto'],
                "NumIdentificacion"=>$data[0]['sNumeroIdentificacionContacto'],
                "RFC"=>$data[0]['RFC'],
                "CURP"=>$data[0]['sCURP'],
                "FigPolitica"=>0,
                "FamPolitica"=>0,
                "IdUsuarioAlta"=>0,
                "FecAltaRepLegal"=>date('Y-m-d'),
                "FecMovRepLegal"=>0,
                "IdEmpleado"=>date('Y-m-d'),
                "IdEstatusRepLegal"=>0
            )
        );
        $respuestaRepresentanteLegal= (array) $client->AgregarRepresentanteLegal($arrayParametrosRepresentanteLegal);
        $IdRepLegal=$respuestaRepresentanteLegal['AgregarRepresentanteLegalResult']->Model->anyType->enc_value->LegalRepresentativeEntity->IdRepLegal;
        //contacto  21
        $arrayParametrosContacto=array(
            "oContact"=>array(
                "IdContacto"=>5447,
                "IdcTipoContacto"=>1,
                "NombreContacto"=>$data[0]['sNombreContacto'],
                "ApPaternoContacto"=>$data[0]['sApellidoPaternoContacto'],
                "ApMaternoContacto"=>$data[0]['sApellidoMaternoContacto'],
                "Telefono1"=>$data[0]['nTelefonoContacto'],
                "ExtTelefono1"=>0,
                "Eelefono2"=>$data[0]['nTelefonoContacto'],
                "ExtTelefono2"=>0,
                "Celular"=>$data[0]['nTelefonoContacto'],
                "CorreoContacto"=>$data[0]['sCorreoContacto'],
                "FecAltaContacto"=>date('Y-m-d'),
                "FecVigenciaContacto"=>0,
                "IdEstatusContacto"=>0,
                "FecMovContacto"=>0,
                "IdEmpleado"=>999
            )
        );
        $respuestaContacto= (array) $client->AgregarContacto($arrayParametrosContacto);
        $IdContacto=$respuestaContacto['AgregarContactoResult']->Model->anyType->enc_value->ContactEntity->IdContacto;
        //infsuvadena 5447, 5448
        $arrayParametrosSubcadenaContacto=array(
            "IdContacto"=>$IdContacto,
            "IdSubCadena"=>0
        );
        $respuestaSubcadenaContacto= (array) $client->AgregarSubCadenaContacto($arrayParametrosSubcadenaContacto);
        $IdSubCadenaContacto=$respuestaSubcadenaContacto['AgregarSubCadenaContactoResult']->Model->anyType->enc_value->SubChainContactEntity->IdSubCadenaContacto;
        //Direccion 632
        $arrayParametrosDireccion=array(
            "oDirection"=>array(
                "IdDireccion"=>0,
                "CalleDireccion"=>$data[0]['sCalle'],
                "NumeroIntDireccion"=>$data[0]['sNumInterior'],
                "NumeroExtDireccion"=>$data[0]['sNumExterior'],
                "IdPais"=>164,
                "IdEstado"=>$data[0]['nIdEstado'],
                "IdCiudad"=>$data[0]['nIdMunicipio'],
                "IdColonia"=>$data[0]['nIdColonia'],
                "CodigoPostal"=>$data[0]['nCodigoPostal'],
                "IdTipoDireccion"=>0,
                "IdEmpleado"=>999,
                "DescripcionDireccion"=>date('Y-m-d'),
                "IdLocalidad"=>0,
                "IdTipoLocal"=>0,
                "FecAltaDireccion"=>date('Y-m-d'),
                "FecVigenciaDireccion"=>date('Y-m-d'),
                "IdEstatusDireccion"=>0,
                "FecMovDireccion"=>date('Y-m-d'),
                "NombreEstado"=>utf8_decode($data[0]['sEstado']),
                "NombreMunicipio"=>$data[0]['sMunicipio'],
                "NombreColonia"=>$data[0]['sColonia']
            )
        );
        $respuestaDireccion= (array) $client->AgregarDireccion($arrayParametrosDireccion);
        $IdDireccion=$respuestaDireccion['AgregarDireccionResult']->Model->anyType->enc_value->DirectiontEntity->IdDireccion;
        //actualizacion cuenta bancaria
        $arrayParametrosConfCuenta=array(
            "oConfCtaBanco"=>array(
                "NumeroCuenta"=>$this->numCuenta,
                "RFC"=>$data[0]['RFC'],
                "Clave"=>$data[0]['sCLABE'],
                "Nombre"=>$data[0]['sNombre'],
                "ApellidoPaterno"=>$data[0]['sApellidoPaterno'],
                "ApellidoMaterno"=>$data[0]['sApellidoMaterno'],
                "Correo"=>$data[0]['sCorreo'],
            )
        );
        $respuestaConfCuenta= (array) $client->ActualizarCtaBanco($arrayParametrosConfCuenta);
        if($respuestaConfCuenta['ActualizarCtaBancoResult']->Messages->Message->Code == 0){
            $arrayParametrosCuenta=array(
                "NumCuenta"=>$this->numCuenta,
                "IdTipoLiqReembolso"=>2,
                "IdTipoLiqComision"=>2
            );
            $respuestaCuenta= (array) $client->ActualizarCuenta($arrayParametrosCuenta);
            if($respuestaConfCuenta['ActualizarCuentaResult']->Messages->Message->Code == 0){
                $arrayParametrosCliente=array(
                    "oClient"=>array(
                        "IdCliente"=>$IdCliente,
                        "Rfc"=>$data[0]['RFC'],
                        "RazonSocial"=>$data[0]['sRazonSocial'],
                        "Nombre"=>$data[0]['sNombre'],
                        "Paterno"=>$data[0]['sApellidoPaterno'],
                        "Materno"=>$data[0]['sApellidoMaterno'],
                        "Telefono"=>$data[0]['nTelefono'],
                        "Correo"=>$data[0]['sCorreo'],
                        "idDirFiscal"=>$IdDireccion,
                        "idRepLegal"=>$IdRepLegal,
                        "idVersion"=>1,
                        "idCosto"=>0,
                        "idGiro"=>21,
                        "idRegimen"=>$data[0]['idRegimen'],
                        "idExpediente"=>0,
                        "idTipoReembolso"=>1,
                        "idTipoComision"=>1,
                    )
                );
                $respuestaCliente= (array) $client->ActualizarCliente($arrayParametrosCliente);
                if($respuestaCliente['ActualizarClienteResult']->Messages->Message->Code == 0){
                    $oRAMP->setSDatabase('aquimispagos');
                    $dataActuaizacion=array();
                    $param = array
                            (   array(
                                    'nIdUsuario'  => 'CknIdUsuario',
                                    'type'  => 'i',
                                    'value' => $this->nIdUsuario),  
                                array(
                                    'nIdCadena'  => 'CknIdCadena',
                                    'type'  => 'i',
                                    'value' => $data[0]['nIdCadena']),  
                                array(
                                    'nIdRegimen'  => 'CknidRegimen',
                                    'type'  => 'i',
                                    'value' => $data[0]['idRegimen']),    
                        );
                    $oRAMP->setSStoredProcedure('sp_insert_autorizacion_fiscalizado');
                    $oRAMP->setParams($param);
                    $resultActualizacion = $oRAMP->execute();
                    $dataActuaizacion = $oRAMP->fetchAll();
                    $oRAMP->closeStmt();
                    if($dataActuaizacion[0]->idBitacora == 0){
                        
                    }
                }
            }

            
        }
        return $data;   
    } 
}

$obj = new guardar_AutorizacionProspecto();
$obj->setsnIdUsuario($_POST['nIdUsuario']);
$result=$obj->datos_ProspectosAut();



echo json_encode(array(
    'bExito'    => true,
    'nCodigo'   => 0,
    'sMensaje'  => 'Ok',
    'data'      => utf8ize($result)
));

?>
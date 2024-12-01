<?php
include ('../../../inc/config.inc.php');


$rfc = $_POST['rfc'];

			$sQueryDatosGenerales      = "CALL afiliacion.SP_CARGAR_DATOSGENERALES_PROSPECTO('$rfc');";
			 $resultDatosGenerales = $WBD->query($sQueryDatosGenerales);
            $generales  = mysqli_fetch_array($resultDatosGenerales);

//generales
                    $idacdena = $generales['nIdCadena'];
                    $nomcadena = utf8_encode($generales['nombreCadena']);
                    $idsocio = $generales['nIdSocio'];
                    $idgiro = $generales['nIdGiro'];
                    $nombre =  utf8_encode($generales['sNombre']);
                    $paterno = utf8_encode($generales['sPaterno']);
                    $materno =  utf8_encode($generales['sMaterno']);
                    $razonSoc = utf8_encode($generales['prsoc']);
                    $nomComer = utf8_encode($generales['sNombreComercial']);
                    $telefono = $generales['sTelefono'];
                    $correo = utf8_encode($generales['sEmail']);
                    $idejecutivo = $generales['nIdEjecutivoCuenta'];
                    $calle = utf8_encode($generales['sCalle']);
                    $exterior = $generales['nNumExterno'];
                    $interior = $generales['sNumInterno'];
                    $cp = $generales['nCodigoPostal'];
                    $idcolonia = $generales['nNumColonia'];
                    $colext = $generales['sNombreColonia'];
                    $monext = $generales['sNombreMunicipio'];
                    $edoext = $generales['sNombreEstado'];
                    



//bancario
                    $clabe = $generales['sCLABE'];
                    $idbanco = $generales['nIdBanco'];
                    $numcta = $generales['nNumCuenta'];
                    $benef = utf8_encode($generales['sBeneficiario']);
                    $descr = utf8_encode($generales['sDescripcion']);

//paquetes
                    $idpaquete = $generales['nIdPaquete'];
                    $inscte = $generales['nInscripcionCliente'];
                    $afisuc = $generales['nAfiliacionSucursal'];
                    $rentsuc = $generales['nRentaSucursal'];
                    $anualsuc = $generales['nAnualSucursal'];
                    $limitesuc = $generales['nLimiteSucursales'];
                    $inicio = $generales['dFechaInicio'];
                    $vencim = $generales['dFechaVencimiento'];
                    $promo = $generales['bPromocion'];



// info especial Fisico
                    $tipoid = $generales['nIdTipoIdentificacion'];
                    $idpaisnac = $generales['nIdPaisNacimiento'];
                    $idnacionalidad = $generales['nIdNacionalidad'];
                    $polexp1 = $generales['poliexp1'];
                    $fechanacim = $generales['dFecNacimiento'];
                    $CURP = $generales['sCURP'];
                    $NumIdentif = $generales['sNumeroIdentificacion'];

// info especial moral

                  $tiposoc = $generales['nIdTipoSociedad'];
                    $idActConsdoc = $generales['nIdDocActaConstitutiva'];
                    $fechaconst = $generales['dFechaConstitutiva'];
                    //$razonSocial = $generales['sRazonSocial'];
                    $polexp2 = $generales['poliexp2'];

// info configuracion

                    $familias = $generales['familias'];
                    $prefiles = 1;//$generales['perfil']; //deshabiliado hasta tener orden para esta configuracion
                    $acceso = $generales['accesos'];
                    $version = $generales['nIdVersion'];
//info liquidacion
                    $tiporeemb = $generales['nIdTipoReembolso'];
                    $tipocom = $generales['nIdTipoComision'];
                    $liqreemb = $generales['nIdLiquidacionReembolso'];
                    $liqcom = $generales['nIdLiquidacionComision'];


// info representante legal
                    $nombreRL = utf8_encode($generales['sNombreRepresentante']);
                    $paternoRL = utf8_encode($generales['sPaternoRepresentante']);
                    $maternoRL = utf8_encode($generales['sMaternoRepresentante']);
                    $fnacRL = $generales['fnacRL'];
                    $nacionalidadRL = $generales['idnacRL'];
                    $rfcRL = $generales['rfcRL'];
                    $curpRL = $generales['curpRL'];
                    $numidRL = $generales['numIdRl'];
                    $telefonoRL = $generales['telRL'];
                    $mailRL = utf8_encode($generales['mailRL']);
                    $idOcupacionRL = $generales['idOcupRl'];
                    $expuestoRL = $generales['expuertoRL'];
// direccion representante legal

                    $calleRL = utf8_encode($generales['calleRL']);
                    $nexternoRL = $generales['nexternoRL'];
                    $ninternoR = $generales['ninternoRL'];
                    $cpR = $generales['cpRL'];
                    $ncoloniaRL = $generales['ncoloniaRL'];

//referencia bancaria
                    $refbanc = $generales['sReferenciaBancaria'];

//documentos        
                    $docCompDom = $generales['nIdDocDomicilio'];
                    $docRFC = $generales['nIdDocRFC'];
                  
                    $docEdocta = $generales['nIdDocEstadoCuenta'];
                    $docIdRL = $generales['nIdDocIdentificacion'];
                    $docPoderRL = $generales['nIdDocPoder'];
                      

                    $datos = array(
                        "idcad" =>$idacdena,
                        "nomcad" =>$nomcadena,
                        "idsoc" =>$idsocio,
                        "idgiro" =>$idgiro,
                        "nombre" =>$nombre,
                        "paterno" =>$paterno,
                        "materno" =>$materno,
                        "razonSoc" =>$razonSoc,
                        "nomComer" =>$nomComer,
                        "telefono" =>$telefono,
                        "correo" =>$correo,
                        "ejecutivo" =>$idejecutivo,
                        "calle" =>$calle,
                        "externo" =>$exterior,
                        "interno" =>$interior,
                        "cp" =>$cp,
                        "colext" =>$colext,
                        "monext" =>$monext,
                        "edoext" =>$edoext,
                        
                        "numcolonia" =>$idcolonia,
                        "clabe" =>$clabe,
                        "banco" =>$idbanco,
                        "cuenta" =>$numcta,
                        "benefi" =>$benef,
                        "descrip" =>$descr,
                        
                     "idpaquete" =>$idpaquete,
                        "incripcion" =>$inscte,
                        "afiliacion" =>$afisuc,
                        "renta" =>$rentsuc,
                        "anual" =>$anualsuc,
                        "sucursales" =>$limitesuc,
                        "finicio" =>$inicio,
                        "fvencim" =>$vencim, 
                        "promo" =>$promo,
                        "version" => $version, 
                        
            // info epecial fisico            
                        "tipoid" =>$tipoid,
                        "idpaisnac" =>$idpaisnac,
                        "idnacion" =>$idnacionalidad,
                        "polexp1" =>$polexp1,
                        "fechanacim" =>$fechanacim,
                        "curp" =>$CURP,
                        "numidentif" =>$NumIdentif, 
                        
               //info especial moral         
                        "tiposoc" =>$tiposoc,
                        "actconst" =>$idActConsdoc,
                        "fechconst" =>$fechaconst,
                        "polexp2" =>$polexp2,
                     
                //info configuracion
                        "familias" =>$familias,
                        "perfil" =>$prefiles,
                        "accesos" =>$acceso,
                        
                        
                        
                //liquidacion
                        
                        "tiporeemb" =>$tiporeemb,
                        "tipocom" =>$tipocom,
                        "liqreemb" =>$liqreemb, 
                        "liqcom" =>$liqcom, 
                        
                        
                 // info represntante legal       
                        
                        "nombreRL" =>$nombreRL,
                        "paternoRL" =>$paternoRL,
                        "maternoRL" =>$maternoRL,
                        "fnacRL" =>$fnacRL,
                        "nacionalidadRL" =>$nacionalidadRL,
                        "rfcRL" =>$rfcRL,
                        "curpRL" =>$curpRL,
                        "numidRL" =>$numidRL,
                        "telefRL" =>$telefonoRL,
                        "mailRL" =>$mailRL,
                        "ocupacionRL" =>$idOcupacionRL,
                        "expuestoRL" =>$expuestoRL,
                //dir rep legal
                        "calleRL" =>$calleRL,
                        "nexternoRL" =>$nexternoRL,
                        "ninternoR" =>$ninternoR,
                        "cpR" =>$cpR,
                        "ncoloniaRL" =>$ncoloniaRL,
                        "refbanc" =>$refbanc,
                        
                //documentos
                        
                        "idcdom" =>$docCompDom,
                        "idrfc" =>$docRFC,
                        "idedocta" =>$docEdocta,
                       
                        "ididrl" =>$docIdRL,
                        "idpodrl" =>$docPoderRL
                        
                            
                    );


         $records = json_encode($datos);

//printf("Error: %s\n", mysqli_error($conn));
echo $records;
//mysqli_free_result($resultDatosGenerales);

//mysqli_close($rconn);

?>
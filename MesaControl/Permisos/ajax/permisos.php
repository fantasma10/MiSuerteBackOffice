<?php
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");

    $tipo  = (!empty($_POST["tipo"])) ? $_POST["tipo"] : 0;

    /**
     * case 2: Obtener la cadena, subcadena y corresponsales de un cliente
     * case 3: Listado de proveedores activos
     * case 5: Listado de todos los productos de un proveedor (Solo se muestran los productos que esten activos y tengan una ruta activa)
     * case 6: Listado de todos los permisos activos de un corresponsal o todos los corresponsales de un cliente
     * case 7: Insertar o actualizar los permisos
     * case 8: Autorizar los permisos 
     */

    switch ($tipo) {
        case 2:
            $nIdCliente = $_POST['idCliente'];
                    
            $array_params = array(array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' =>'i'));
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_cadena_subcadena_corresponsales');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $datos = array();
            $mensaje = 'No se puedo obtener la información de Cadenas, Subcadenas y Corresponsales';

            if ($result['nCodigo'] == 0) {
                $rows = $oRdb->fetchAll();
                $mensaje = 'No hay información de Cadenas, Subcadenas y Corresponsales';

                if (count($rows) > 0) {
                    $mensaje = 'Se obtuvo la información de Cadenas, Subcadenas y Corresponsales correctamente';
                    foreach ($rows as $key => $row) {
                        $datos[$key]['nIdCorresponsal'] = $row['nIdCorresponsal'];
                        $datos[$key]['sNombreCorresponsal'] = utf8_encode($row['sNombreCorresponsal']);
                        $datos[$key]['nIdCliente'] = $row['nIdCliente'];
                        $datos[$key]['nIdCadenaCliente'] = $row['nIdCadenaCliente'];
                        $datos[$key]['nIdSubCadenaCliente'] = $row['nIdSubCadenaCliente'];
                        $datos[$key]['nIdCadena'] = $row['nIdCadena'];
                        $datos[$key]['sNombreCadena'] = utf8_encode($row['sNombreCadena']);
                        $datos[$key]['nIdSubCadena'] = $row['nIdSubCadena'];
                        $datos[$key]['sNombreSubCadena'] = utf8_encode($row['sNombreSubCadena']);
                    }
                }
            } 

            echo json_encode(array(
                'bExito'    => $result['bExito'],
                'nCodigo'   => $result['nCodigo'],
                'data'      => $datos,
                'sMensaje'  => $mensaje
            ));
        break;
        case 3:
            $nIdCliente = (!empty($_POST['nIdCliente'])) ? $_POST['nIdCliente'] : 0;
            $estatus = 0;
            $array_params = array(array('name' => 'CknIdEstatusProveedor', 'value' => $estatus, 'type' =>'i'));
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_proveedor_por_estatus');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $datos = array();
            $mensaje = 'No se puedo obtener el listado de los Proveedores';

            if ($result['nCodigo'] == 0) {
                $rows = $oRdb->fetchAll();
                $mensaje = 'No hay información de Proveedores';
                
                if (count($rows) > 0) {
                    $mensaje = 'Se obtuvo el listado de Proveedores correctamente';

                    foreach ($rows as $key => $row) {
                        $datos[] = array(
                            'nIdProveedor' => $row['idProveedor'],
                            'sNombreProveedor' => utf8_encode($row['nombreProveedor'])
                        );

                        // Obtenemos el index del proveedor de Altan
                        if ($row['idProveedor'] == 111) {
                            $indexProveedorAltan = $key;
                        }
                    }
                }

                // Validamos que el id del cliente que recibimos como parametro sea igual a 2168 (walmar innovation)
                // si es igual solo obtenemos la informacion del proveedor Altan
                // si no es igual quitamos del listado de proveedores el proveedor Altan
                if ($nIdCliente == 2168) {
                    $datos = array_slice($datos, $indexProveedorAltan, 1);
                } else {
                    array_splice($datos, $indexProveedorAltan, 1);
                }
            }

            echo json_encode(array(
                'bExito'    => $result['bExito'],
                'nCodigo'   => $result['nCodigo'],
                'data'      => $datos,
                'sMensaje'  => $mensaje
            ));
        break;
        case 5:
            $nIdProveedor = $_POST['idProveedor'];

            $array_params = array(
                array('name' => 'CknIdProveedor', 'value' => $nIdProveedor, 'type' =>'i'),
            );

            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_proveedor_productos');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $datos = array();
            if ($result['nCodigo'] == 0) {
                $rows = $oRdb->fetchAll();

                if (count($rows) > 0) {
                    foreach ($rows as $key => $row) {
                        $nombreProductoYRuta = $row['sDescProducto']." (". $row['sDescRuta'].")";
                        $datos[$key]['nIdProducto'] = $row['nIdProducto'];
                        $datos[$key]['sDescProducto'] = utf8_encode($nombreProductoYRuta);
                        $datos[$key]['sNombreProveedor'] = utf8_encode($row['sNombreProveedor']);
                        $datos[$key]['nIdRuta'] = $row['nIdRuta'];
                        $datos[$key]['sDescRuta'] = utf8_encode($row['sDescRuta']);
                        $datos[$key]['nPerComClienteMaxima'] = $row['nPerComClienteMaxima'];
                        $datos[$key]['nImpComClienteMaxima'] = $row['nImpComClienteMaxima'];
                        $datos[$key]['nPerComCorresponsalMaxima'] = $row['nPerComCorresponsalMaxima'];
                        $datos[$key]['nImpComCorresponsalMaxima'] = $row['nImpComCorresponsalMaxima'];
                        $datos[$key]['sDescFamilia'] = $row['sDescFamilia'];
                        $datos[$key]['nPerMargen'] = $row['nPerMargen'];
                        $datos[$key]['nImpMargen'] = $row['nImpMargen'];
                        $datos[$key]['nPerComisionProducto'] = $row['nPerComisionProducto'];
                        $datos[$key]['nImpComisionProducto'] = $row['nImpComisionProducto'];
                        $datos[$key]['nPerPagoProveedor'] = $row['nPerPagoProveedor'];
                        $datos[$key]['nImpPagoProveedor'] = $row['nImpPagoProveedor'];
                        $datos[$key]['sDescFamilia'] = $row['sDescFamilia'];
                    }
                }

		        $oRdb->closeStmt();
                $iTotal = $oRdb->foundRows();
		        $oRdb->closeStmt();
                $mensaje = '';
            } else {
                $iTotal = 0;
                $mensaje = 'Error al obtener la informacion de Permisos.';
            } 
            
            echo json_encode(array(
                'bExito'    => $result['bExito'],
                'nCodigo'   => $result['nCodigo'],
                'data'      => $datos,
                'sMensaje'  => $mensaje
            ));
        break;
        case 6:
            $nIdCliente = $_POST['idCliente'];
            $nIdCadena = $_POST['idCadena'];
            $nIdSubCadena = $_POST['idSubCadena'];
            $nIdCorresponsal = $_POST['idCorresponsal'];
            $nIdProveedor = $_POST['idProveedor'];
            $sRole = $_POST['role'];

            $array_params = array(
                array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' =>'i'),
                array('name' => 'CknIdCadena', 'value' => $nIdCadena, 'type' =>'i'),
                array('name' => 'CknIdSubCadena', 'value' => $nIdSubCadena, 'type' =>'i'),
                array('name' => 'CknIdCorresponsal', 'value' => $nIdCorresponsal, 'type' =>'i'),
                array('name' => 'CknIdProveedor', 'value' => $nIdProveedor, 'type' =>'i')
            );
            $oRdb->setSDatabase('redefectiva');
            $oRdb->setSStoredProcedure('sp_select_permisos');
            $oRdb->setParams($array_params);
            $result = $oRdb->execute();

            $datos = array();
            $mensaje = 'No se puedo obtener la información de Permisos';

            if ($result['nCodigo'] == 0) {
                $rows = $oRdb->fetchAll();
                $mensaje = 'No hay información de Permisos';

                if (count($rows) > 0) {
                    $mensaje = 'Se obtuvo la información de Permisos correctamente';
                    foreach ($rows as $key => $row) {
                        $datos[$key]['nIdPermiso'] = $row['idPermiso'];
                        $datos[$key]['nIdCadena'] = $row['idCadena'];
                        $datos[$key]['nIdSubCadena'] = $row['idSubCadena'];
                        $datos[$key]['nIdCorresponsal'] = $row['idCorresponsal'];
                        $datos[$key]['nIdProducto'] = $row['idProducto'];
                        
                        $datos[$key]['nIdPermisoValidacion'] = $row['nIdPermisoValidacion'];
                        if (!is_null($row['nIdPermisoValidacion']) && $sRole != 'lector') {
                            $datos[$key]['nIdRuta'] = $row['nIdRuta'];
                            $datos[$key]['nPerComCorresponsal'] = $row['nPerComCorresponsal'];
                            $datos[$key]['nImpComCorresponsal'] = $row['nImpComCorresponsal'];
                            $datos[$key]['nPerComCliente'] = $row['nPerComCliente'];
                            $datos[$key]['nImpComCliente'] = $row['nImpComCliente'];
                            $datos[$key]['nPerComEspecial'] = $row['nPerComEspecial'];
                            $datos[$key]['nImpComEspecial'] = $row['nImpComEspecial'];
                            $datos[$key]['nPerComFrente'] = $row['nPerComFrenteOPV'];
                            $datos[$key]['nImpComFrente'] = $row['nImpComFrenteOPV'];
                            $datos[$key]['nPerComCadenaFactura'] = $row['nPerComCadenaFacturaOPV'];
                            $datos[$key]['nImpComCadenaFactura'] = $row['nImpComCadenaFacturaOPV'];
                            $datos[$key]['nIdEstatusPermiso'] = $row['nIdEstatusPermiso'];
                            $datos[$key]['nTipoComision'] = $row['nTipoComisionOPV'];
                            $datos[$key]['nImpRed'] = $row['nImpRedOPV'];
                            $datos[$key]['nPerRed'] = $row['nPerRedOPV'];
                            $datos[$key]['nSeleccionado'] = ($row['nIdEstatusPermiso'] != 3) ? 1 : 0;
                            
                            $datos[$key]['bCambioIdRuta'] = ($row['idRuta'] != $row['nIdRuta']);
                            $cambioTipoComision = ($row['nTipoComisionOP'] != $row['nTipoComisionOPV']);

                            // Detectamos si hubo cambios en las comisiones
                            if ($row['bEsNuevo'] == 1 && $row['nIdEstatusPermiso'] == 1) {
                                $datos[$key]['bCambio']['tipoComision'] = $cambioTipoComision;
                                $datos[$key]['bCambio']['comisionUsuario'] = true;
                                $datos[$key]['bCambio']['comisionEspecial'] = true;
                                $datos[$key]['bCambio']['comisionFrente'] = true;
                                $datos[$key]['bCambio']['comisionCadena'] = true;
                                $datos[$key]['bCambio']['comisionCadenaFactura'] = true;
                                $datos[$key]['bCambio']['comisionRedFactura'] = true;
                            } else {
                                $datos[$key]['bCambio']['tipoComision'] = $cambioTipoComision;
                                $datos[$key]['bCambio']['comisionUsuario'] = (($row['impComCliente'] != $row['nImpComCliente']) || ($row['perComCliente'] != $row['nPerComCliente']));
                                $datos[$key]['bCambio']['comisionEspecial'] = (($row['impComEspecial'] != $row['nImpComEspecial']) || ($row['perComEspecial'] != $row['nPerComEspecial']));
                                $datos[$key]['bCambio']['comisionFrente'] = (($row['nImpComFrenteOP'] != $row['nImpComFrenteOPV']) || ($row['nPerComFrenteOP'] != $row['nPerComFrenteOPV']));
                                $datos[$key]['bCambio']['comisionCadena'] = (($row['impComCorresponsal'] != $row['nImpComCorresponsal']) || ($row['perComCorresponsal'] != $row['nPerComCorresponsal']));
                                $datos[$key]['bCambio']['comisionCadenaFactura'] = (($row['nImpComCadenaFacturaOP'] != $row['nImpComCadenaFacturaOPV']) || ($row['nPerComCadenaFacturaOP'] != $row['nPerComCadenaFacturaOPV']));
                                $datos[$key]['bCambio']['comisionRedFactura'] = (($row['nImpRedOP'] != $row['nImpRedOPV']) || ($row['nPerRedOP'] != $row['nPerRedOPV']));
                            }
                        } else {
                            $datos[$key]['nIdRuta'] = $row['idRuta'];
                            $datos[$key]['nPerComCorresponsal'] = $row['perComCorresponsal'];
                            $datos[$key]['nImpComCorresponsal'] = $row['impComCorresponsal'];
                            $datos[$key]['nPerComCliente'] = $row['perComCliente'];
                            $datos[$key]['nImpComCliente'] = $row['impComCliente'];
                            $datos[$key]['nPerComEspecial'] = $row['perComEspecial'];
                            $datos[$key]['nImpComEspecial'] = $row['impComEspecial'];
                            $datos[$key]['nPerComFrente'] = $row['nPerComFrenteOP'];
                            $datos[$key]['nImpComFrente'] = $row['nImpComFrenteOP'];
                            $datos[$key]['nPerComCadenaFactura'] = $row['nPerComCadenaFacturaOP'];
                            $datos[$key]['nImpComCadenaFactura'] = $row['nImpComCadenaFacturaOP'];
                            $datos[$key]['nIdEstatusPermiso'] = $row['idEstatusPermiso'];
                            $datos[$key]['nTipoComision'] = $row['nTipoComisionOP'];
                            $datos[$key]['nImpRed'] = $row['nImpRedOP'];
                            $datos[$key]['nPerRed'] = $row['nPerRedOP'];
                            $datos[$key]['nSeleccionado'] = ($row['idEstatusPermiso'] != 3) ? 1 : 0;

                            // $datos[$key]['bCambio']['IdRuta'] = false;
                            $datos[$key]['bCambio']['tipoComision'] = false;
                            $datos[$key]['bCambio']['comisionUsuario'] = false;
                            $datos[$key]['bCambio']['comisionEspecial'] = false;
                            $datos[$key]['bCambio']['comisionFrente'] = false;
                            $datos[$key]['bCambio']['comisionCadena'] = false;
                            $datos[$key]['bCambio']['comisionCadenaFactura'] = false;
                            $datos[$key]['bCambio']['comisionRedFactura'] = false;
                        }
                    }
                }
            } 

            echo json_encode(array(
                'bExito'    => $result['bExito'],
                'nCodigo'   => $result['nCodigo'],
                'data'      => $datos,
                'sMensaje'  => $mensaje,
                'aaaa'  => $result
            ));
        break;
        case 7:
		    $nIdUsuario = $_SESSION["idU"];
            $nIdCliente = $_POST['nIdCliente'];
            $permisos = $_POST['permisos'];
            $datos = array();
            $sqls = array();

            foreach ($permisos as $key => $permiso) {
                if ($permiso['nSeleccionado'] == 1) {
                    $nTipoComision = $permiso['nTipoComision'];

                    if ($nTipoComision == 0) {
                        // Comision tipo importe
                        $nComisionUsuario = $permiso['nImpComCliente'];
                        $nComisionEspecial = $permiso['nImpComEspecial'];
                        $nComisionCadena = $permiso['nImpComCorresponsal'];
                        $nComisionFrente = $permiso['nImpComFrente'];
                        $nComisionCadenaFactura = $permiso['nImpComCadenaFactura'];
                        $nComisionRed = $permiso['nImpRed'];
                    } else {
                        // Comision tipo porcentaje
                        $nComisionUsuario = $permiso['nPerComCliente'];
                        $nComisionEspecial = $permiso['nPerComEspecial'];
                        $nComisionCadena = $permiso['nPerComCorresponsal'];
                        $nComisionFrente = $permiso['nPerComFrente'];
                        $nComisionCadenaFactura = $permiso['nPerComCadenaFactura'];
                        $nComisionRed = $permiso['nPerRed'];
                    }

                    if ($permiso['nIdPermiso'] == '') {
                        $idFevPermiso = date('Y-m-d');
                        $idFsvPermiso = DateTime::createFromFormat('Y-m-d', $idFevPermiso);
                        $idFsvPermiso->modify('+50 years');
                        $idFsvPermiso = $idFsvPermiso->format('Y-m-d');       

                        $nPerComGrupo = 0;
                        $nImpComGrupo = 0;
                        $nPerCostoPermiso = 0;
                        $nImpCostoPermiso = 0;

                        $array_params = array(
                            array('name' => 'CknIdEmpleado', 'value' => $nIdUsuario, 'type' =>'i'),
                            array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' =>'i'),
                            array('name' => 'CknIdCadena', 'value' => $permiso['nIdCadena'], 'type' =>'i'),
                            array('name' => 'CknIdSubCadena', 'value' => $permiso['nIdSubCadena'], 'type' =>'i'),
                            array('name' => 'CknIdCorresponsal', 'value' => $permiso['nIdCorresponsal'], 'type' =>'i'),
                            array('name' => 'CknIdRuta', 'value' => $permiso['nIdRuta'], 'type' =>'i'),
                            array('name' => 'CknIdProducto', 'value' => $permiso['nIdProducto'], 'type' =>'i'),
                            array('name' => 'CkdIdFevPermiso', 'value' => $idFevPermiso, 'type' =>'s'),
                            array('name' => 'CkdIdFsvPermiso', 'value' => $idFsvPermiso, 'type' =>'s'),
                            array('name' => 'CknPerComGrupo', 'value' => $nPerComGrupo, 'type' =>'d'),
                            array('name' => 'CknImpComGrupo', 'value' => $nImpComGrupo, 'type' =>'d'),
                            array('name' => 'CknPerCostoPermiso', 'value' => $nPerCostoPermiso, 'type' =>'d'),
                            array('name' => 'CknImpCostoPermiso', 'value' => $nImpCostoPermiso, 'type' =>'d'),
                            array('name' => 'CknTipoComision', 'value' => $nTipoComision, 'type' =>'i'),
                            array('name' => 'CknComisionUsuario', 'value' => $nComisionUsuario, 'type' =>'d'),
                            array('name' => 'CknComisionEspecial', 'value' => $nComisionEspecial, 'type' =>'d'),
                            array('name' => 'CknComisionCadena', 'value' => $nComisionCadena, 'type' =>'d'),
                            array('name' => 'CknComisionFrente', 'value' => $nComisionFrente, 'type' =>'d'),
                            array('name' => 'CknComisionCadenaFactura', 'value' => $nComisionCadenaFactura, 'type' =>'d'),
                            array('name' => 'CknComisionRed', 'value' => $nComisionRed, 'type' =>'d'),
                            array('name' => 'CknIdEstatus', 'value' => $permiso['nIdEstatusPermiso'], 'type' =>'i'),
                        );

                        $oWdb->setSDatabase('redefectiva');
                        $oWdb->setSStoredProcedure('sp_insert_permiso_cliente');
                        $oWdb->setParams($array_params);
                        $result = $oWdb->execute();

                        array_push($sqls, array($nIdUsuario, $nIdCliente, $permiso['nIdCadena'], $permiso['nIdSubCadena'], $permiso['nIdCorresponsal'], $permiso['nIdRuta'], $permiso['nIdProducto'], $idFevPermiso, $idFsvPermiso, $nPerComGrupo, $nImpComGrupo, $nPerCostoPermiso, $nImpCostoPermiso, $nTipoComision, $nComisionUsuario, $nComisionEspecial, $nComisionCadena, $nComisionFrente, $nComisionCadenaFactura, $nComisionRed, $permiso['nIdEstatusPermiso']));
        
                        if ($result['nCodigo'] != 0) {
                            $msn = ''; 
                            
                            if ($result['nCodigo'] == 1062) {
                                $msn = 'Ya cuenta con permisos asignados. Solo se puede asignar permisos a un producto con un proveedor.';
                            }

                            $res = array('producto' => $permiso['sNombreProducto'], 'mensaje' => $msn, 'result' => $result);
                            array_push($datos, $res);
                        }

                        $oWdb->closeStmt();

                    } else {
                        $array_params = array(
                            array('name' => 'CknIdPermisoValidacion', 'value' => $permiso['nIdPermisoValidacion'], 'type' =>'i'),
                            array('name' => 'CknIdPermiso', 'value' => $permiso['nIdPermiso'], 'type' =>'i'),
                            array('name' => 'CknIdEmpleado', 'value' => $nIdUsuario, 'type' =>'i'),
                            array('name' => 'CknIdRuta', 'value' => $permiso['nIdRuta'], 'type' =>'i'),
                            array('name' => 'CknTipoComision', 'value' => $nTipoComision, 'type' =>'i'),
                            array('name' => 'CknComisionUsuario', 'value' => $nComisionUsuario, 'type' =>'d'),
                            array('name' => 'CknComisionEspecial', 'value' => $nComisionEspecial, 'type' =>'d'),
                            array('name' => 'CknComisionFrente', 'value' => $nComisionFrente, 'type' =>'d'),
                            array('name' => 'CknComisionCadena', 'value' => $nComisionCadena, 'type' =>'d'),
                            array('name' => 'CknComisionCadenaFactura', 'value' => $nComisionCadenaFactura, 'type' =>'d'),
                            array('name' => 'CknComisionRed', 'value' => $nComisionRed, 'type' =>'d'),
                            array('name' => 'CknIdEstatus', 'value' => $permiso['nIdEstatusPermiso'], 'type' =>'i')
                        );
    
                        $oWdb->setSDatabase('redefectiva');
                        $oWdb->setSStoredProcedure('sp_update_permiso_cliente');
                        $oWdb->setParams($array_params);
                        $result = $oWdb->execute();
                        array_push($sqls, $array_params);

                        if ($result['nCodigo'] != 0) {
                            $msn = ''; 
                            
                            if ($result['nCodigo'] == 1062) {
                                $msn = 'Ya cuenta con permisos asignados. Solo se puede asignar permisos a un producto con un proveedor.';
                            }

                            $res = array('producto' => $permiso['sNombreProducto'], 'mensaje' => $msn, 'result' => $result);
                            array_push($datos, $res); 
                        }

                        $oWdb->closeStmt();
                    }
                }
            }
            
            echo json_encode(array(
                'bExito'    => true,
                'nCodigo'   => 0,
                'data'      => $datos,
                'sMensaje'  => '',
                'sqls'      => $sqls
            ));
        break;
        case 8:
            $permisos = $_POST['permisos'];
		    $nIdUsuario = $_SESSION["idU"];

            $mensaje = 'No hay permisos pendientes de autorizar.';
            if (count($permisos) > 0) {
                $mensaje = '';
                foreach ($permisos as $key => $permiso) {
                    $array_params = array(
                        array('name' => 'CknIdEmpleado', 'value' => $nIdUsuario, 'type' =>'i'),
                        array('name' => 'CknIdPermiso', 'value' => $permiso, 'type' =>'i')
                    );

                    $oWdb->setSDatabase('redefectiva');
                    $oWdb->setSStoredProcedure('sp_autorizar_permiso');
                    $oWdb->setParams($array_params);
                    $result = $oWdb->execute();

                    $aaa[] = $oWdb->fetchAll();
                    $datos = array();
                    if ($result['nCodigo'] != 0) {
                        $res = array('producto' => $permiso['sNombreProducto'], 'mensaje' => '', 'result' => $result);
                        array_push($datos, $res);
                    }
                    
                    $oWdb->closeStmt();
                }
            }

            echo json_encode(array(
                'bExito'    => true,
                'nCodigo'   => 0,
                'data'      => $datos,
                'sMensaje'  => $mensaje,
                'aaa'       => $aaa
            )); 
        break;
        default:
            # code...
        break;
    }
 
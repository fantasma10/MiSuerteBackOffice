<?php
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/session2.ajax.inc.php");
    include($_SERVER['DOCUMENT_ROOT']."/inc/customFunctions.php");

    $nIdCliente = $_POST['idCliente'];
	$nIdCadena = $_POST['cadena'];
	$nIdSubCadena = $_POST['subcadena'];
	$nIdCorresponsal = $_POST['corresponsal'];
	$nIdProveedor = $_POST['proveedor'] == '' ? 0 : $_POST['proveedor'];
	$nTipoReporte = $_POST['tipoReporte'] == '' ? 1 : $_POST['tipoReporte'];
    $nIdFiltro = $_POST['nIdFiltro'] == '' ? -1 : $_POST['nIdFiltro'];
	$nMostrarPermisosAutorizados = $_POST['mostrarPermisosAutorizados'] == '' ? 0 : $_POST['mostrarPermisosAutorizados'];
	$sNombreCliente = utf8_encode($_POST['nombreCliente']);
    $sNombreArchivo = "{$sNombreCliente} ({$nIdCliente})";
    
    echo pack("CCC",0xef,0xbb,0xbf);

    function obtenerTipoComision($nIdCliente, $nIdFamilia, $comisionesRutaImporte, $comisionesRutaPorcentaje) {
        $tipoComision = 0;
        
        if ($nIdCliente == 2168) {
            return $tipoComision = 1;
        }

        if ($comisionesRutaImporte == 0 && $comisionesRutaPorcentaje == 1) {
            $tipoComision = 1;
        }

        if (($comisionesRutaImporte == 0 && $comisionesRutaPorcentaje == 0) || 
            ($comisionesRutaImporte == 1 && $comisionesRutaPorcentaje == 1)) {
            if ($nIdFamilia == 1) {
                $tipoComision = 1;
            }
        }

        return $tipoComision;
    }

    function convertirEstatusATexto($nEstatus) {
        if ($nEstatus == 0) return 'Autorizado';
        
        if ($nEstatus == 1) return 'Pendiente';

        if ($nEstatus == 10) return 'Sin permiso';
    }
	
    $array_params = array (
        array('name' => 'CknIdCliente', 'value' => $nIdCliente, 'type' => 'i'),
        array('name' => 'CknIdCadena', 'value' => $nIdCadena, 'type' => 'i'),
        array('name' => 'CknIdSubCadena', 'value' => $nIdSubCadena, 'type' => 'i'),
        array('name' => 'CknIdCorresponsal', 'value' => $nIdCorresponsal, 'type' => 'i'),
        array('name' => 'CknIdProveedor', 'value' => $nIdProveedor, 'type' => 'i'),
        array('name' => 'CknTipoReporte', 'value' => $nTipoReporte, 'type' => 'i'),
    );

    $oRdb->setSDatabase('redefectiva');
    $oRdb->setSStoredProcedure('sp_select_reporte_ops_permisos');
    $oRdb->setParams($array_params);
    $resultado = $oRdb->execute();

    $tabla = '<table border="1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="15" style="text-align: center;">Listado de permisos (comisiones) - '.$sNombreCliente.' ('.$nIdCliente.')</th>
                    </tr>
                    <tr>
                        <th rowspan="2">PERMISO <br> ASIGNADO</th>
                        <th rowspan="2">PRODUCTO</th>
                        <th rowspan="2">PROVEEDOR</th>
                        <th rowspan="2">TIPO COMISI&Oacute;N</th>
                        <th rowspan="2">COMISI&Oacute;N COBRO <br> AL PROVEEDOR</th>
                        <th rowspan="2">COMISI&Oacute;N PAGO <br> AL PROVEEDOR</th>
                        <th rowspan="2">COMISI&Oacute;N M&Iacute;NIMA <br> MARGEN RED</th>
                        <th rowspan="2">COMISI&Oacute;N M&Aacute;XIMA <br> USUARIO</th>
                        <th rowspan="2">COMISI&Oacute;N <br> USUARIO</th>
                        <th rowspan="2">COMISI&Oacute;N <br> ESPECIAL</th>
                        <th rowspan="2">COMISI&Oacute;N FRENTE <br> (NO SE VALIDA)</th>
                        <th rowspan="2">COMISI&Oacute;N <br> CADENA</th>
                        <th rowspan="2">COMISI&Oacute;N CADENA <br> (FACTURA)</th>
                        <th rowspan="2">COMISI&Oacute;N RED <br> (FACTURA)</th>
                        <th rowspan="2">ESTATUS <br> PERMISO</th>
                    </tr>
                    <tr></tr>
                </thead>
                <tbody>
            ';

	if($resultado['bExito'] == true){
		$rows				= $oRdb->fetchAll();
		$array_resultado	= array();

        if (count($rows) > 0) {
            foreach($rows as $key => $row){
                $sPermisoAsignado = $row['sPermisoAsignado'];
                $nIdFamilia = $row['nIdFamilia'];
                $comisionCobroProveedor = $row['nImpComisionProducto'];
                $comisionPagoProveedor = $row['nImpPagoProveedor'];
                $comisionMargenRed = $row['nImpMargen'];
                $comisionUsuarioMaxima = $row['nImpComClienteMaxima'];
                $comisionUsuario = $row['nImpComClienteOP'];
                $comisionEspecial = $row['nImpComEspecialOP'];
                $comisionFrente = $row['nImpComFrenteOP'];
                $comisionCadena = $row['nImpComCorresponsalOP'];
                $comisionCadenaFactura = $row['nImpComCadenaFacturaOP'];
                $comisionRedFactura = $row['nImpRedOP'];
                $tipoComision = obtenerTipoComision($nIdCliente, $nIdFamilia, $row['nComisionesRutaImporte'], $row['nComisionesRutaPorcentaje']);
                $textoTipoComision = ($tipoComision == 0) ? 'Importe' : 'Porcentaje';
                $signo = ($tipoComision == 0) ? '$' : '%';
                $nEstatus = $row['nIdEstatusPermisoOP'];

                if ($row['nTipoComisionOP'] ==  1) {
                    $textoTipoComision = 'Porcentaje';
                    $signo = '% ';
                    $comisionCobroProveedor = $row['nPerComisionProducto'];
                    $comisionPagoProveedor = $row['nPerPagoProveedor'];
                    $comisionMargenRed = $row['nPerMargen'];
                    $comisionUsuarioMaxima = $row['nPerComClienteMaxima'];
                    $comisionUsuario = $row['nPerComClienteOP'];
                    $comisionEspecial = $row['nPerComEspecialOP'];
                    $comisionFrente = $row['nPerComFrenteOP'];
                    $comisionCadena = $row['nPerComCorresponsalOP'];
                    $comisionCadenaFactura = $row['nPerComCadenaFacturaOP'];
                    $comisionRedFactura = $row['nPerRedOP'];
                    $tipoComision = obtenerTipoComision($nIdCliente, $nIdFamilia, $row['nComisionesRutaImporte'], $row['nComisionesRutaPorcentaje']);
                    $textoTipoComision = ($tipoComision == 0) ? 'Importe' : 'Porcentaje';
                    $signo = ($tipoComision == 0) ? '$' : '%';
                    $nEstatus = $row['nIdEstatusPermisoOP'];
                }

                // if ($nMostrarPermisosAutorizados == 1 && !is_null($row['nIdPermisoValidacion'])) {
                if (!is_null($row['nIdPermisoValidacion'])) {
                    $textoTipoComision = 'Importe';
                    $signo = '$ ';
                    $comisionCobroProveedor = $row['nImpComisionProducto'];
                    $comisionPagoProveedor = $row['nImpPagoProveedor'];
                    $comisionMargenRed = $row['nImpMargen'];
                    $comisionUsuarioMaxima = $row['nImpComClienteMaxima'];
                    $comisionUsuario = $row['nImpComClienteOPV'];
                    $comisionEspecial = $row['nImpComEspecialOPV'];
                    $comisionFrente = $row['nImpComFrenteOPV'];
                    $comisionCadena = $row['nImpComCorresponsalOPV'];
                    $comisionCadenaFactura = $row['nImpComCadenaFacturaOPV'];
                    $comisionRedFactura = $row['nImpRedOPV'];
                    $nEstatus = $row['nIdEstatusPermisoOPV'];

                    if ($row['nTipoComisionOPV'] ==  1) {
                        $textoTipoComision = 'Porcentaje';
                        $signo = '% ';
                        $comisionCobroProveedor = $row['nPerComisionProducto'];
                        $comisionPagoProveedor = $row['nPerPagoProveedor'];
                        $comisionMargenRed = $row['nPerMargen'];
                        $comisionUsuarioMaxima = $row['nPerComClienteMaxima'];
                        $comisionUsuario = $row['nPerComClienteOPV'];
                        $comisionEspecial = $row['nPerComEspecialOPV'];
                        $comisionFrente = $row['nPerComFrenteOPV'];
                        $comisionCadena = $row['nPerComCorresponsalOPV'];
                        $comisionCadenaFactura = $row['nPerComCadenaFacturaOPV'];
                        $comisionRedFactura = $row['nPerRedOPV'];
                        $nEstatus = $row['nIdEstatusPermisoOPV'];
                    }
                }

                if ($sPermisoAsignado == 'NO') {
                    $nEstatus = 10;
                }

                $sEstatus = convertirEstatusATexto($nEstatus);

                if (($nEstatus == $nIdFiltro) || ($nIdFiltro == -1)) {
                    $tabla .= '<tr>
                        <td>'.$sPermisoAsignado.'</td>
                        <td>'.$row['sDescProducto'].'</td>
                        <td>'.$row['sNombreProveedor'].'</td>
                        <td>'.$textoTipoComision.'</td>
                        <td><span>'.$signo.' </span>'.number_format($comisionCobroProveedor, 4).'</td>
                        <td><span>'.$signo.' </span>'.number_format($comisionPagoProveedor, 4).'</td>
                        <td>'.$signo.number_format($comisionMargenRed, 4).'</td>
                        <td>'.$signo.number_format($comisionUsuarioMaxima, 4).'</td>
                        <td>'.$signo.number_format($comisionUsuario, 4).'</td>
                        <td>'.$signo.number_format($comisionEspecial, 4).'</td>
                        <td>'.$signo.number_format($comisionFrente, 4).'</td>
                        <td>'.$signo.number_format($comisionCadena, 4).'</td>
                        <td>'.$signo.number_format($comisionCadenaFactura, 4).'</td>
                        <td>'.$signo.number_format($comisionRedFactura, 4).'</td>
                        <td>'.$sEstatus.'</td>
                    </tr>';
                }
            }
        } else {
            $tabla .= '<tr><td colspan="15">No se encontrar&oacute;n permisos</td></tr>';
        }
	}
	else{
		// $errmsg = $oReporte->GetErrorCode.' : '.$oReporte->GetErrorMsg();
	}

    $tabla .= '</tbody></table>';

    header("Content-type: application/octet-stream; charset=UTF-8");
    header("Content-Disposition: attachment;filename=\"Permisos {$sNombreArchivo}.xls\"");

    echo utf8ize($tabla);

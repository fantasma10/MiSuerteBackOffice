<?php
$clientes = array();
$idEstatus = 0;

function obtenerClientes ($oRdb, $idEstatus) {
    $_clientes = array();

    $array_params = array( array( 'name' => 'CknIdEstatus', 'value' => $idEstatus, 'type' => 'i') );

    $oRdb->setSDatabase('redefectiva');
    $oRdb->setSStoredProcedure('sp_select_cliente_por_estatus');
    $oRdb->setParams($array_params);
    $result = $oRdb->execute();

    if ($result['nCodigo'] == 0) {
        $rows = $oRdb->fetchAll();

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $_clientes[] = array(
                    'nIdCliente' => $row['idCliente'],
                    'sRazonSocial' => utf8_encode($row['RazonSocial']),
                    'sNombre' => utf8_encode($row['NombreCliente']),
                    'sRFC' => $row['RFC'],
                    'nTicketFiscal' => $row['nTicketFiscal']
                );
            }
        }
    }

    return $_clientes;
}


$clientes = obtenerClientes($oRdb, $idEstatus);

<?php
	include($_SERVER['DOCUMENT_ROOT']."/inc/config.inc.php");
	include($_SERVER['DOCUMENT_ROOT']."/inc/session.inc.php");

    $familia   	    = (!empty($_POST['id_familia_excel'])) ? $_POST['id_familia_excel'] : 2;
	$proveedor 	    = (!empty($_POST['id_proveedor_excel'])) ? $_POST['id_proveedor_excel'] : NULL;
	$producto		= (!empty($_POST['id_producto_excel'])) ? $_POST['id_producto_excel'] : NULL;
    $estatus        = ($_POST['id_estatus_producto'] >= 0) ? $_POST['id_estatus_producto'] : NULL;
    
	$fileNameChange = $fechaTipo == 1 ? "FechaCorte" : "FechaPago";
	
		header("Content-type=application/x-msdownload; charset=UTF-8");
		header("Content-disposition:attachment;filename=ReporteRuta_$familia.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		echo "\xEF\xBB\xBF";
		echo $out;

		if ( !empty($familia) ) {
            $query = "CALL `redefectiva`.`sp_select_rutas_proveedores`(";
            
            $query .= "'$familia', ";

            // Verificar si $proveedor es null
            if ($proveedor === null) {
                $query .= "NULL, ";
            } else {
                $query .= "'$proveedor', ";
            }
            
            // Verificar si $producto es null
            if ($producto === null) {
                $query .= "NULL";
            } else {
                $query .= "'$producto'";
            }

            $query .= ", NULL, NULL, ";

            // Verificar si $producto es null
            if ($estatus === null) {
                $query .= "NULL";
            } else {
                $query .= "$estatus";
            }

            $query .= ", NULL);";
			$res = $RBD->query($query);

			if($RBD->error() == ''){

                $c = "<table>";
                $c .= "<tr><th colspan='9'>REPORTE DE RUTAS POR PROVEEDORES</th></tr>";
                $c .= "<tr><td colspan='9'></td></tr>";
                $c .= "</table>";

				if($res != '' && mysqli_num_rows($res) > 0){
					$c .= "<table>";
					$c .= "<thead>";
					$c .= "<tr>";
					$c .= "<th>FAMILIA</th>";
                    $c .= "<th>ID_PROVEEDOR</th>";
                    $c .= "<th>NOMBRE_COM_PROVEEDOR</th>";
                    $c .= "<th>NOMBRE_PROVEEDOR</th>";
                    $c .= "<th>ID_RUTA</th>";
                    $c .= "<th>RUTA</th>";
                    $c .= "<th>ID_PRODUCTO</th>";
                    $c .= "<th>PRODUCTO</th>";
                    $c .= "<th>ESTATUS_PRODUCTO</th>";
                    $c .= "<th>PORCENTAJE_USUARIO_MAX_POSIBLE</th>";
                    $c .= "<th>IMP_USUARIO_MAX_POSIBLE</th>";
                    $c .= "<th>PORCENTAJE_COBRO_PROVEEDOR</th>";
                    $c .= "<th>IMP_COBRO_PROVEEDOR</th>";
                    $c .= "<th>PORCENTAJE_PAGO_PROVEEDOR</th>";
                    $c .= "<th>IMP_PAGO_PROVEEDOR</th>";
                    $c .= "<th>SUMA_INGRESO_RED</th>";
                    $c .= "<th>MARGEN_MINIMO</th>";
                    $c .= "<th>MAXIMO_COMISION_RUTAS</th>";
                    $c .= "<th>PORCENTAJE_COMISION_CADENA</th>";
                    $c .= "<th>IMP_MAX_COMISION_CADENA</th>";
                    $c .= "<th>MARGEN_RED</th>";
					$c .= "</tr>";
					$c .= "</thead>";
					$c .= "<tbody>";
					
					while( list($FAMILIA,$ID_PROVEEDOR,$NOMBRE_COM_PROVEEDOR,$NOMBRE_PROVEEDOR,$ID_PRODUCTO,$PRODUCTO,$ID_RUTA,$RUTA,$PORCENTAJE_USUARIO_MAS_POSIBLE,$IMP_USUARIO_MAS_POSIBLE,$PORCENTAJE_COBRO_PROVEEDOR,$IMP_COBRO_PROVEEDOR,$PORCENTAJE_PAGO_PROVEEDOR,$IMP_PAGO_PROVEEDOR,$SUMA_INGRESO_RED,$MARGEN_MINIMO,$MAXIMO_COMISION_RUTAS,$PORCENTAJE_COMISION_CADENA,$IMP_MAX_COMISION_CADENA,$MARGEN_RED,$ESTATUS_PRODUCTO_ID) = mysqli_fetch_array($res)){
                        $ESTATUS_PRODUCTO = ($ESTATUS_PRODUCTO_ID == 0) ? 'ACTIVO' : 'INACTIVO';
						$d .= "<tr>";
						$d .= "<td>".$FAMILIA."</td>";
                        $d .= "<td>".$ID_PROVEEDOR."</td>";
                        $d .= "<td>".$NOMBRE_COM_PROVEEDOR."</td>";
                        $d .= "<td>".$NOMBRE_PROVEEDOR."</td>";
                        $d .= "<td>".$ID_RUTA."</td>";
                        $d .= "<td>".$RUTA."</td>";
                        $d .= "<td>".$ID_PRODUCTO."</td>";
                        $d .= "<td>".$PRODUCTO."</td>";
                        $d .= "<td>".$ESTATUS_PRODUCTO."</td>";
                        $d .= "<td>".$PORCENTAJE_USUARIO_MAS_POSIBLE."</td>";
                        $d .= "<td>".$IMP_USUARIO_MAS_POSIBLE."</td>";
                        $d .= "<td>".$PORCENTAJE_COBRO_PROVEEDOR."</td>";
                        $d .= "<td>".$IMP_COBRO_PROVEEDOR."</td>";
                        $d .= "<td>".$PORCENTAJE_PAGO_PROVEEDOR."</td>";
                        $d .= "<td>".$IMP_PAGO_PROVEEDOR."</td>";
                        $d .= "<td>".$SUMA_INGRESO_RED."</td>";
                        $d .= "<td>".$MARGEN_MINIMO."</td>";
                        $d .= "<td>".$MAXIMO_COMISION_RUTAS."</td>";
                        $d .= "<td>".$PORCENTAJE_COMISION_CADENA."</td>";
                        $d .= "<td>".$IMP_MAX_COMISION_CADENA."</td>";
                        $d .= "<td>".$MARGEN_RED."</td>";
						$d .= "</tr>";
					}			
					$d .= "</tbody>";
					$d .= "</table>";
					echo $c;
					echo utf8_encode($d);		
				}else{
					echo "Lo sentimos pero no se encontraron resultados";
				}
			}else{
				echo "Error al realizar la consulta: ".$RBD->error();
			}
		}	
?>

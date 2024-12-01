<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");
$idPermiso = (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

$proveedor = (isset($_POST['proveedor']))?$_POST['proveedor']:0;
$familia = (isset($_POST['familia']))?$_POST['familia']:0;
$fecha1 = (isset($_POST['fecha1']))?$_POST['fecha1']:'';
$fecha2 = (isset($_POST['fecha2']))?$_POST['fecha2']:'';
$AND = "";
if($proveedor > 0)
    $AND.= " AND O.`idProveedor` = $proveedor ";
if($familia > 0){
    $AND.= " AND O.`idFamilia` = $familia";
}
if($fecha1 != '' && $fecha2 != '')
    $AND.=" AND O.`fecAltaOperacion` BETWEEN '$fecha1' AND '$fecha2' ";
    
/*//CONSULTAR Y PASAR LOS PROVEEDORES A UN ARREGLO
$proveedores = array();
$sql = "SELECT `idProveedor`,`nombreProveedor` FROM `dat_proveedor`;";
$rows = $RBD->query($sql);
while($row = mysqli_fetch_array($rows)){
    $proveedores[] = $row;
}*/

//CONSULTAR Y PASAR LAS FAMILIAS A UN ARREGLO
$subfamilias = array();
$sql = "SELECT `idSubFamilia`,`descSubFamilia` FROM `redefectiva`.`cat_subfamilia`;";
$rows = $RBD->query($sql);
while($row = mysqli_fetch_array($rows)){
    $subfamilias[] = $row;
}   
  
//CONSULTAR Y PASAR LOS PRODUCTOS A UN ARREGLO
$productos = array();
$sql = "SELECT `idProducto`,`descProducto` FROM `redefectiva`.`dat_producto`;";
$rows = $RBD->query($sql);
while($row = mysqli_fetch_array($rows)){
    $productos[] = $row;
}
  
    
/*$sql = "SELECT O.`idProveedor`,`idFamilia`,COUNT(O.`idsOperacion`),SUM(O.`importeOperacion`)
FROM `redefectiva`.`mops_operacion` as O
WHERE O.`idEstatusOperacion` = 0 $AND GROUP BY O.`idProveedor`,O.`idFamilia`;";
*/

$sql = "SELECT `idSubFamilia`,`idProducto`,COUNT(O.`idsOperacion`),SUM(O.`importeOperacion`),SUM(IF(O.`idFlujoImp` = 1,O.`importeOperacion`,0)),SUM(IF(O.`idFlujoImp` = 0,O.`importeOperacion`,0)),SUM(`totComOperacion`),SUM(O.`totComCorresponsal`),SUM(O.`totComOperacion`),`perIvaOperacion`
FROM `redefectiva`.`ops_operacion` as O
WHERE O.`idEstatusOperacion` = 0 $AND GROUP BY O.`idFamilia`,O.`idSubFamilia`,O.`idProducto`,`perIvaOperacion`;";
//echo $sql;
$error = 0;
$res = '';
$res = $RBD->query($sql);
$totalpagar =  0;
$totmov = 0;
$entradas = 0;
$salidas = 0;
$comtotal = 0;
$comcliente = 0;
$comtotre = 0;
$tsubtotal = 0;
$ivatotal = 0;
if($RBD->error() == ''){
    if($res != '' && mysqli_num_rows($res) > 0){
        $d = "<table id='ordertabla' border='0' cellspacing='0' cellpadding='0' class='tablesorter'>
        <thead>
            <tr>
             <th>SubFamilia</th><th>Producto</th><th>Cantidad De Operaciones</th><th>Importe De Operaciones</th><th>Subtotal</th>
             <th>Ivsss</th><th>Entradas</th><th>Salidas</th><th>Comision Total</th><th>Comision Cliente</th><th>Comision RE</th>
            </tr>
        </thead>
        <tbody>";
        while(list($subfamilia,$producto,$cantidad,$total,$entrada,$salida,$totcomop,$comcorresponsal,$totcomision,$iva) = mysqli_fetch_array($res)){
            $d.="<tr><td>";
            $i = 0;
            while($i < count($subfamilias)){
                if($subfamilias[$i][0] == $subfamilia){
                    $d.= $subfamilias[$i][1];
                    break;
                }
                $i++;
            }
            $d.="</td><td>";
            $i = 0;
            while($i < count($productos)){
                if($productos[$i][0] == $producto){
                    $d.= $productos[$i][1];
                    break;
                }
                $i++;
            }
            $comre = $totcomision - $comcorresponsal;
            $entradas+=$entrada;
            $salidas+=$salida;
            $comtotal+=$totcomop;
            $comcliente+= $comcorresponsal;
            $comtotre+= $comre;
            $subtotal = ($total + $comcorresponsal)/1.16;
            $ivaop = $subtotal * $iva;
            $d.="</td><td>$cantidad</td><td>$".number_format($total,2)."</td><td>$".number_format($subtotal,2)."</td><td>$".number_format($ivaop,2)."</td><td>$".number_format($entrada,2)."</td><td>$".number_format($salida,2)."</td><td>$".number_format($totcomop,2)."</td><td>$".number_format($comcorresponsal,2)."</td><td>$".number_format($comre,2)."</td></tr>";
            $totmov+= $cantidad;
            $totalpagar+= $total;
            $tsubtotal+=$subtotal;
            $ivatotal+=$ivaop;
        }
        $d.="<tr><td colspan='2'>TOTALES:</td><td>$totmov</td><td>$".number_format($totalpagar,2)."</td><td>$".number_format($tsubtotal,2)."</td><td>$".number_format($ivatotal,2)."</td><td>$".number_format($entradas,2)."</td><td>$".number_format($salidas,2)."</td><td>$".number_format($comtotal,2)."</td><td>$".number_format($comcliente,2)."</td><td>$".number_format($comtotre,2)."</td></tr>";
        $check = "";
        if($familia == 1)
            $check = "<input type='checkbox' id='chkieps' onclick='BuscaTotalProveedores();' /><label for='chkieps' style='color:green;font-weight:bold;'> Incluir IEPS</label>";
        $sql = "SELECT `idTipoLiqProveedor`,`descTipoLiqProveedor` FROM `redefectiva`.`cat_tipoliqproveedor`;";
        $res = $RBD->query($sql);
        
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $select = "<label style='font-weight:bold;'>Seleccione La Forma De Pago</label><br /><select id='ddlTipo' onchange='BuscaTotalProveedores();'>";
                while($r = mysqli_fetch_array($res)){
                    $select.="<option value='$r[0]'>$r[1]</option>";
                }
                $select.="</select>";
            }
        }
        //obtiene las cuentas
        $sql = "SELECT `numCuenta` FROM `redefectiva`.`ops_cuenta_global` WHERE `idReferencia` = $proveedor AND `idTipoCuentaPago` = 2;";
        $res = $RBD->query($sql);
        $selectcuentas = "";
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $selectcuentas.="<div><label style='font-weight:bold;width:100%;'>Numero De Cuenta A Depositar</label><br /><select id='ddlNumCuenta'>";
                while($r = mysqli_fetch_array($res)){
                    $selectcuentas.="<option>$r[0]</option>";
                }
                $selectcuentas.="</select></div><label id='lblimporte'>El importe total a pagar es: </label><br /><input name='' type='button' class='button2' value='GENERAR ORDEN DE PAGO' onclick='InsertPagoProveedor();' />";
            }else{
                $selectcuentas.="<label class='subtitulo_contenido'>Lo Sentimos Pero No Se Encontraron Numeros De Cuentas Para Este Proveedor</label>";
            }
        }
        
        $d.="</tbody></table><input type='hidden' name='busq' id='busq' value='1' />".$select.$selectcuentas.$check."<br /><br />";
        echo $d;
    }else{
        echo "<label class='subtitulo_contenido'>Lo sentimos pero no se encontraron resultados</label>";
        $error = 1;
    }
}else{
    echo $RBD->error();
    $error = 1;
}
echo "<input type='hidden' name='busq' id='busq' value='$error' />";
?>
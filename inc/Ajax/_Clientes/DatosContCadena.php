<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena = (isset($_POST['cadena']))?$_POST['cadena']:-1;
if($cadena > -1){
 $sql = "SELECT `numCuenta`,`SaldoCuenta`,`SaldoCredito`,`FORELO` FROM `redefectiva`.`ops_cuenta` WHERE `idCadena` = $cadena AND `idSubCadena` = -1 AND `idCorresponsal` = -1;";

 $res = $RBD->query($sql);
    if($RBD->error() == ''){
        $d = "<table border='0'>";
        if($res != '' && mysqli_num_rows($res) > 0){
            while(list($cuenta,$saldocta,$saldocredito,$forelo) = mysqli_fetch_array($res)){
                $d.="<tr>
                <td>Pagare</td><td>";
                $sqlp = "SELECT `Importe` FROM `redefectiva`.`dat_pagare` WHERE `idEstatusPagare` = 0 AND `idCadena` = $cadena;";
                $resp = $RBD->query($sqlp);
                if($resp != '' && mysqli_num_rows($resp) > 0){
                    $r = mysqli_fetch_array($resp);
                    $d.=$r[0];
                }else{
                    $d.="No Tiene";
                }
                $d.="</td>
                </tr>
                <tr>
                <td>N&uacute;mero De Cuenta</td><td>$cuenta</td>
                </tr>
                <tr>
                <td>Saldo Actual</td><td>$".number_format($saldocta,2)."</td>
                </tr>
                <tr>
                <td>Cr&eacute;dito</td><td>$".number_format($saldocredito,2)."</td>
                </tr>
                <tr>
                <td>Forelo</td><td>$forelo</td>
                </tr>";
            }
            $d.="</table>";
            echo utf8_encode($d);
        }else{
            echo "Lo Sentimos Pero No Se Encontraron Datos";
        }
    }else{
        echo "Error al ejecutar la consulta: ".$RBD->error();
    }
}
?>
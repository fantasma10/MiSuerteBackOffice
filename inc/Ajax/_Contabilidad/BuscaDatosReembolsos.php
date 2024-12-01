<?php
include("../../../inc/config.inc.php");
include("../../../inc/session.ajax.inc.php");

$cadena         = (isset($_POST['cadena']))?$_POST['cadena']:'';
$subcadena      = (isset($_POST['subcadena']))?$_POST['subcadena']:'';
$corresponsal   = (isset($_POST['corresponsal']))?$_POST['corresponsal']:'';

//buscar numero de cuenta
if($cadena != '' || $subcadena != '' || $corresponsal != ''){

    $categoria  = (!empty($_POST['categoria']))? $_POST['categoria'] : 0;

    switch($categoria){
        case '1':

        break;

        case '2':
            $oSub = new SubCadena($RBD, $WBD);
            $oSub->load($subcadena);

            echo "1|".$oSub->getCuentaForelo()."|\$".number_format($oSub->getSaldo(),2);
        break;

        case '3':
            $oCorresponsal = new Corresponsal($RBD, $WBD);
            $oCorresponsal->load($corresponsal);

            echo "1|".$oCorresponsal->getNumCuenta()."|\$".number_format($oCorresponsal->getSaldoCuenta(), 2);
        break;
    }


    /*$sql = "SELECT D.`numeroCuenta`,C.`FORELO`
            FROM `redefectiva`.`dat_corresponsal` as D
            INNER JOIN `redefectiva`.`ops_cuenta` as C on D.`numeroCuenta` = C.`numCuenta`
            WHERE D.`idCadena` = $cadena AND D.`idSubCadena` = $subcadena AND D.`idCorresponsal` =  $corresponsal; ";
    $res =  $RBD->query($sql);
    if($RBD->error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            echo "1|".$r[0]."|\$".number_format($r[1],2);
        }else{
            echo "|Lo Sentimos Pero No Se Encontraron Resultados";
        }
    }else{
        echo $RBD->error();
    }*/
}
?>
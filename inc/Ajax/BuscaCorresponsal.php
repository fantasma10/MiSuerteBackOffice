<?php
include("../../inc/config.inc.php");
include("../../inc/session.ajax.inc.php");
$band = true;
try{
$cad		= (isset($_POST['idcad']))?$_POST['idcad']:'';

if(isset($_POST['al']) && isset($_POST['idcad']) && isset($_POST['idsubcad'])){

$desabilitar = "";
	if($cad == 0)
		$desabilitar = "disabled='disabled'";

$seccion = (isset($_POST['seccion']))?$_POST['seccion']:'';
$res = null;
$funcion2 = (isset($_POST['funcion2']))?"window.setTimeout(\"".$_POST['funcion2']."\",100);":"";
        //$res = $RBD->query("SELECT `idCorresponsal`,`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` where idCadena = ".$_POST['idcad']." and     idSubCadena = ".$_POST['idsubcad']." ORDER BY `nombreCorresponsal`;");
        $res = $RBD->query("call SP_LOAD_CORRESPONSALES(".$_POST['idcad'].",". $_POST['idsubcad'].")");
        $d = "";
        if($res != null){
				$d = "<select id='ddlCorresponsal' class='form-control m-bot15' onchange='$funcion2;ClearScreen();' ><option value='-2' onclick='$funcion2;' selected='selected'>Todos</option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]' onclick='$funcion2'>$r[1]</option>";
            }
            $d.="</select>";
            echo utf8_encode($d);
        }else{
            echo "<select id='ddlCorresponsal' class='form-control m-bot15'><option value='-2'>Todos</option></select>";
        }
		$band = false;
}elseif(isset($_POST['idcad']) && isset($_POST['idsubcad']) && $band == true){
		$res = null;
        $res = $RBD->query("call SP_LOAD_CORRESPONSALES(".$_POST['idcad'].",". $_POST['idsubcad'].")");
        $d = "";
        if($res != null){
            $d = "<select id='ddlCorresponsal' class='form-control m-bot15' onchange='$funcion2;ClearScreen();'><option value='-2' onclick='$funcion2' selected='selected'>Todos</option>";

            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[idCorresponsal]' onclick='$funcion2'>$r[nombreCorresponsal]</option>";
            }
            $d.="</select>";
            echo $d;
        }else{
            echo "<select id='ddlCorresponsal' class='form-control m-bot15'><option value='-2' selected='selected'>Todos</option></select>";
        }
}else{ echo "<select id='ddlCorresponsal' class='form-control m-bot15'><option value='-2' selected='selected'>Todos</option></select>";}
}catch(Exception $e){echo $e->getMessage();}
?>
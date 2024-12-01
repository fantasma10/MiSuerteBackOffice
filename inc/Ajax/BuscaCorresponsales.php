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
				$d = "<select id='ddlCorresponsal' class='textfield' onchange='$funcion2;ClearScreen();' ><option value='-1' onclick='$funcion2;' selected='selected'></option>";
            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]' onclick='$funcion2'>$r[1]</option>";
            }
            $d.="</select>";
            echo utf8_encode($d);
        }else{
            echo "<select id='ddlCorresponsal' class='textfield'><option value='-1'></option></select>";
        }
		$band = false;
}elseif(isset($_POST['idcad']) && isset($_POST['idsubcad']) && $band == true){
		$res = null;
        $res = $RBD->query("SELECT `idCorresponsal`,`nombreCorresponsal` FROM `redefectiva`.`dat_corresponsal` where idCadena = ".$_POST['idcad']." and idSubCadena = ".$_POST['idsubcad']." ORDER BY `nombreCorresponsal`;");
        $d = "";
        if($res != null){
            $d = "<select id='ddlCorresponsal' class='textfield' onchange='$funcion2;ClearScreen();'><option value='-1'></option>";

            while($r = mysqli_fetch_array($res)){
                $d.="<option value='$r[0]' onclick='$funcion2'>$r[1]</option>";
            }
            $d.="</select>";
            echo $d;
        }else{
            echo "<select id='ddlCorresponsal' class='textfield'><option value='-1' selected='selected'></option></select>";
        }
}else{ echo "<select id='ddlCorresponsal' class='textfield'><option value='-1' selected='selected'></option></select>";}
}catch(Exception $e){echo $e->getMessage();}
?>
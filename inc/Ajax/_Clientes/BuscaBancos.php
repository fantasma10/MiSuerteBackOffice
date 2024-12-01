<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idcorresponsal = (isset($_POST['idCorresponsal'])) ? $_POST['idCorresponsal'] : -1;
if($idcorresponsal > -1){
    //CONSULTAR Y PASAR LOS PRODUCTOS A UN ARREGLO
    $bancos = array();
    $sql = "SELECT `idBanco`,`nombreBanco` FROM `redefectiva`.`cat_banco`;";
    $rows = $RBD->query($sql);
    while($row = mysqli_fetch_array($rows)){
        $bancos[] = $row;
    }
    
    
    $sql = "SELECT I.`idBanco`,I.`idEstatus`,A.`LongDesc`
        FROM `redefectiva`.`inf_corresponsalbanco` as I
        INNER JOIN `data_info`.`banco_actividad` as A on I.`idGiro` = A.`idActividad`
        WHERE I.`idCorresponsal` = $idcorresponsal AND `idEstatus` < 3 ;";
    $res = $RBD->query($sql);
    $d = "";
    if($RBD->error() == ''){
        $class = "";
        $band = true;
        if($res != ''  && mysqli_num_rows($res) > 0){
            $d = "<table width='90%' border='0' cellspacing='0' cellpadding='0' style='margin-left:5%'><thead><tr width='8%' align='center' valign='middle' class='encabezado_tabla'><th>Banco</th><th>Estatus</th><th>Actividad</th></tr></thead><tbody>";
            while(list($banco,$estatus,$actividad) = mysqli_fetch_array($res)){
                $class = ($band) ? "renglon1_tabla" : "renglon2_tabla";
                $band = !$band;
                $d.="<tr align='center' valign='middle' class='$class'><td>";
                $i = 0;
                while($i < count($bancos)){
                    if($bancos[$i][0] == $banco){
                        $d.= $bancos[$i][1];
                        break;
                    }
                    $i++;
                }
                $d.="</td><td>$estatus</td><td>$actividad</td></tr>";
            }
            $d.="<tbody></table>";
            echo $d;
        }else{
            echo "Lo sentimos pero no se encontraron resultados";
        }
    }else{
        echo "error al realizar la consulta: ".$RBD->error();
    }
}

?>
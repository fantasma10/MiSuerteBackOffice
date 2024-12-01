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

    $sql = "SELECT I.`idCorresponsalBanco`,I.`idBanco`
        FROM `redefectiva`.`inf_corresponsalbanco` as I
        WHERE I.`idCorresponsal` = $idcorresponsal AND `idEstatus` < 3";
    $res = $RBD->query($sql);
    $d = "";
    if($RBD->error() == ''){
        if($res != ''  && mysqli_num_rows($res) > 0){
            /*
                <div class="titulo">
                    <i class="fa fa-bank"></i> Bancos Activos
                </div>
                <ul>
                    <li>Scotiabank  <a href="#"><i class="fa fa-times"></i></a> </li>
                    <li>Banamex  <a href="#"><i class="fa fa-times"></i></a> </li>
                </ul>
            */
            $d = "<div class='titulo'>
                    <i class='fa fa-bank'></i> Bancos Activos
                </div>
                <ul>";
            while(list($idcb,$banco) = mysqli_fetch_array($res)){
                
                $d.="<li>";
                $i = 0;
                while($i < count($bancos)){
                    if($bancos[$i][0] == $banco){
                        $bancoI = $bancos[$i][1];
                        $d.= ((!preg_match('!!u', $bancoI))? utf8_encode($bancoI) : $bancoI);
                        break;
                    }
                    $i++;
                }
                $d.=" <a href='#' onclick='eliminarCorresponsaliaBanc($idcb);' onmouseout='' onmouseover=''><i class='fa fa-times'></i></a>
                    </li>";
            }
            $d.="</ul>";
            echo $d;
        }else{
            echo "<div class='titulo'>
                    <i class='fa fa-bank'></i> Bancos Activos
                </div>
                Lo sentimos pero no se encontraron resultados";
        }
    }else{
        echo "error al realizar la consulta: ".$RBD->error();
    }
}
?>
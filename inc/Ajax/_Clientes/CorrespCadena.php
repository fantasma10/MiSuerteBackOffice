<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena = (isset($_POST['cadena']))?$_POST['cadena']:-1;
$subcadena = (isset($_POST['subcadena']))?$_POST['subcadena']:-1;
$v = (isset($_POST['v']))?$_POST['v']:-1;
$_SESSION['sqlcorresponsales'] = "";

if($cadena > -1){
    if($v == 0){
        //$AND = "";
        //if($cadena > -1)
        //    $AND.=" AND C.`idCadena` = $cadena ";
        //if($nombre != '')
        //    $AND.= " AND C.`nombreCadena` LIKE %$nombre% ";
            
        $sql =  "SELECT COUNT(C.`idCorresponsal`),S.`nombreSubCadena`,S.`idSubCadena`
        FROM `redefectiva`.`dat_subcadena` as S INNER JOIN `redefectiva`.`dat_corresponsal` as C on S.`idSubCadena` = C.`idSubCadena` 
        WHERE S.`idCadena` = $cadena GROUP BY S.`idSubCadena`;";
        
        $d = "";
        $aux = "";
        $tcorresponsales = 0;
        
        $res = $RBD->query($sql);
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $aux.="<table id='ordertabla' style='width:700px;' class='tablesorter'><thead><th>No. Corresponsales</th><th>Nombre SubCadena</th><th></th></thead>";
                while($r = mysqli_fetch_array($res)){
                 $aux.="<tr align='center'>
                            <td>$r[0] </td><td>$r[1]</td>
                            <td><a href='#' onclick='ListaCorresponsales($cadena,$r[2]);' style='color:#3399ff;'>Ver Corresponsales</a></td>
                        </tr>";
                 $tcorresponsales+= $r[0];
                }
                $aux.="</table>";
                $d.="<div style='font-weight:bold;font-size:20px;color:green;width:100%;text-align:center;margin-bottom:20px;'>Se ";if($tcorresponsales == 1){$d.="Encontro $tcorresponsales Corresponsal";}else{ $d.="Encontraron $tcorresponsales Corresponsales";} $d.=" Para Esta Cadena</div><div style='text-align:center;'><a href='#' onclick='ListaCorresponsales($cadena,-1)'>Ver Todos Los Corresponsales</a></div>".$aux;
                echo utf8_encode($d);
            }else{
                echo "Lo Sentimos Pero No Se Encontraron Datos";
            }
        }else{
            echo "Error al ejecutar la consulta: ".$RBD->error();
        }
    }else if($v == 1 && $cadena > -1){
        //REGRESA LA LISTA DE LOS CORRESPONSALES
        $AND = "";
        if($subcadena >-1){
            $AND.= " AND C.`idSubCadena` = $subcadena ";
        }
        $sql =  "SELECT C.`idCorresponsal`,C.`nombreCorresponsal`
        FROM `redefectiva`.`dat_corresponsal` as C 
        WHERE C.`idCadena` = $cadena $AND;";
        $_SESSION['sqlcorresponsales'] = $sql;
        $d = "";
        $res = $RBD->query($sql);
        if($RBD->error() == ''){
            if($res != '' && mysqli_num_rows($res) > 0){
                $d.="<table id='ordertabla' style='width:80%;margin-left:10%;' class='tablesorter'><thead><th>Id Corresponsal</th><th>Nombre Corresponsal</th></thead>";
                while($r = mysqli_fetch_array($res)){
                 $d.="<tr align='center'>
                            <td>$r[0] </td><td>$r[1]</td>
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
}
?>
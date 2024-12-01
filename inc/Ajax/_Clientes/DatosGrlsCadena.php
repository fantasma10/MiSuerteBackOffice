<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$cadena = (isset($_POST['cadena']))?$_POST['cadena']:-1;
$nombre = (isset($_POST['nombre']))?$_POST['nombre']:'';

if($cadena > -1){
$AND = "";
if($cadena > -1)
    $AND.=" AND C.`idCadena` = $cadena ";
if($nombre != '')
    $AND.= " AND C.`nombreCadena` LIKE %$nombre% ";

//CONSULTAR Y PASAR LOS EJECUTIVOS A UN ARREGLO
$sql = "SELECT `idEjecutivo`,`nombreEjecutivo`,`apPaternoEjecutivo`,`apMaternoEjecutivo` FROM `redefectiva`.`dat_ejecutivo` WHERE `idEstatusEjecutivo` = 0;";

$rows = $RBD->query($sql);
$ejecutivos = array();
while($row = mysqli_fetch_array($rows)){
    $ejecutivos[] = $row;
}

//CONSULTAR Y PASAR LOS USUARIOS DE RE A UN ARREGLO
$sql = "SELECT `idusuario`,`nombreUsuario`,`paternoUsuario`,`maternoUsuario` FROM `data_acceso`.`in_usuarioad` WHERE `idEstatusUsuario` = 0;";

$rows = $RBD->query($sql);
$usuarios = array();
while($row = mysqli_fetch_array($rows)){
    $usuarios[] = $row;
}


//$sql =  "SELECT C.`telefono1`,C.`telefono2`,C.`fax`,C.`email`,C.`idEstatusCadena`,C.`fecAltaCadena`,C.`idEmpleado`,I.`idEjecutivo`
//FROM `redefectiva`.`dat_cadena` as C INNER JOIN `redefectiva`.`inf_cadenaejecutivo` as I on C.`idCadena` = I.`idCadena`
//WHERE C.`idEstatusCadena` = 0 AND C.`idCadena` = $cadena;";

$sql =  "SELECT C.`telefono1`,C.`telefono2`,C.`fax`,C.`email`, CASE WHEN C.`idEstatusCadena` = 0 THEN 'Activo' END,C.`fecAltaCadena`,C.`idEmpleado`,I.`idEjecutivo`
FROM `redefectiva`.`dat_cadena` as C LEFT JOIN `redefectiva`.`inf_cadenaejecutivo` as I on C.`idCadena` = I.`idCadena`
WHERE C.`idEstatusCadena` = 0 $AND;";

$d = "";

$rescad = $RBD->query($sql);
if($RBD->error() == ''){
    
    if($rescad != '' && mysqli_num_rows($rescad) > 0){
        $sqldir = "SELECT D.`calle`,D.`numeroInterno`,D.`numeroExterno`,D.`nombreColonia`,D.`nombreCiudad`,D.`nombreEstado`,D.`codigoPostal`
        FROM `redefectiva`.`inf_cadenadireccion` as I
        INNER JOIN `redefectiva`.`v_direccion` as D on I.`idDireccion` = D.`idDireccion`
        WHERE I.`idCadena` = $cadena;";
        
        $resdir = $RBD->query($sqldir);
        $calle = "";
        $numint = "";
        $numext = "";
        $colonia = "";
        $municipio = "";
        $estado =  "";
        $cp = "";
        $band = true;
        if($RBD->error() == ''){
            if($resdir != '' && mysqli_num_rows($resdir) > 0){
                $rd = mysqli_fetch_array($resdir);
                $calle = $rd[0];
                $numint = $rd[1];
                $numext = $rd[2];
                $colonia = $rd[3];
                $municipio = $rd[4];
                $estado = $rd[5];
                $cp = $rd[6];
            }else{
                $band = false;
            }
        }else{
            $band = false;
        }
        
       
        
        //CONSULTAR Y PASAR LOS CONTACTOS A UN ARREGLO
        $contactos = array();
        $sqlcon = "SELECT D.`nombreContacto`,D.`apPaternoContacto`,D.`apMaternoContacto`,D.`telefono1`,D.`correoContacto`
        FROM `redefectiva`.`inf_cadenacontacto` as I
        INNER JOIN `redefectiva`.`dat_contacto` as D on I.`idContacto` = D.`idContacto`
        WHERE I.`idCadena` = $cadena;";
        $rows = $RBD->query($sqlcon);
        while($row = mysqli_fetch_array($rows)){
            $contactos[] = $row;
        }
        
        $d.="<table border='0' id='ordertabla' style='width:700px;' class='tablesorter'>";
        while(list($tel1,$tel2,$fax,$email,$estatus,$fecalta,$empleado,$ejecutivo) = mysqli_fetch_array($rescad)){
            $d.="<tr>
                    <td>Primer Telefono:</td><td>$tel1</td>
                </tr>
                <tr>
                    <td>Segundo Telefono:</td><td>$tel2</td>
                </tr>
                <tr>
                    <td>Fax:</td><td>$fax</td>
                </tr>
                <tr>
                    <td>Correo:</td><td>$email</td>
                </tr>
                <td>Direcci&oacute;n:</td>";
                if($band){
                    $d.="<td>$calle #$numext No Int ";if($numint == ''){$d.="S/N";}else{$d.=$numint;}$d.="</td>
                    </tr>
                    <tr>
                    <td></td><td>$colonia $municipio , $estado</td>
                    </tr>
                    <tr>
                    <td></td><td>CP. $cp</td>";
                }else{
                    $d.="<td></tr><tr><td></td><td></td></tr><tr><td></td><td></td>";
                }
                $d.="</tr>
                <tr>
                <tr>
                    <td>Estatus:</td><td>$estatus</td>
                </tr>
                <tr>
                    <td>Fecha Alta:</td><td>$fecalta</td>
                </tr>
                <tr>
                    <td>Usuario Alta:</td><td>";
                    if($empleado != null){
                        $i = 0;
                        while($i < count($usuarios)){
                            if($usuarios[$i][0] == $empleado){
                                $d.= $usuarios[$i][1]." ".$usuarios[$i][2]." ".$usuarios[$i][3];
                                break;
                            }
                            $i++;
                        }
                    }
                $d.="</td>
                </tr>
                <tr>
                    <td>Ejecutivo:</td><td>";
                    if($ejecutivo != null){
                        $i = 0;
                        while($i < count($ejecutivos)){
                            if($ejecutivos[$i][0] == $ejecutivo){
                                $d.= $ejecutivos[$i][1]." ".$ejecutivos[$i][2]." ".$ejecutivos[$i][3];
                                break;
                            }
                            $i++;
                        }
                    }
                    $d.="</td>
                </tr>
                <tr>
                
                <td>Contactos:</td><td></td>
                </tr>";
                if(count($contactos) > 0){
                    $i = 0;
                    while($i < count($contactos)){
                        $d.="<tr><td></td><td>Nombre: ".$contactos[$i][0]." ".$contactos[$i][1]." ".$contactos[$i][2]."<br />Telefono: ".$contactos[$i][3]."<br />Correo Electr&oacute;nico: ".$contactos[$i][4]."</td></tr>";
                        $i++;
                    }
                }
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
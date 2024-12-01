<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$sql = "SELECT CONVERT(`XML` USING utf8)
            FROM `redefectiva`.`dat_precadena`
            WHERE `idPreClave` =  ".$_SESSION['idPreCadena']." ;";
    $res =  $RBD->query($sql);
    
    if($RBD->error() == ''){
        if($res != '' && mysqli_num_rows($res) > 0){
            $r = mysqli_fetch_array($res);
            $xml = simplexml_load_string($r[0]);
           
           //GENERALES
           echo "<br />Generales<br />";
            if($xml->DG[0]->Tel1 != '' && $xml->DG[0]->MailE != '' && $xml->DG[0]->Grupo != '' && $xml->DG[0]->Giro && $xml->DG[0]->Referencia){
                echo "verde";
                
            }else if($xml->DG[0]->Tel1 != '' || $xml->DG[0]->MailE != '' || $xml->DG[0]->Grupo != '' || $xml->DG[0]->Giro  != '' || $xml->DG[0]->Referencia != ''){
                echo "amarillo";
            }else{
                echo "rojo";
            }
            
            //DIRECCION
            echo "<br />Direccion<br />";
            if($xml->Direccion != ''){
                
                $sql = "SELECT `calleDireccion`,`numeroExtDireccion`,`idPais`,`idcEntidad`,`idcMunicipio`
                    FROM `redefectiva`.`dat_predireccion`
                    WHERE `idDireccion` = ".$xml->Direccion.";";
                $res = $RBD->query($sql);
                if($RBD->error() == ''){
                    if($res != '' && mysqli_num_rows($res) > 0){
                        list($calle,$next,$idpais,$idedo,$idciudad) = mysqli_fetch_array($res);
                        if($calle != '' && $next != '' && $idpais != '' && $idedo != '' && $idciudad != ''){
                            echo "verde";
                        }else if($calle != '' || $next != '' || $idpais != '' || $idedo != '' || $idciudad != ''){
                            echo "amarillo";
                        }else{
                            echo "rojo";
                        }
                    }
                }
            }else{
                echo "rojo";
            }
            
            
            //CONTACTO
            echo "<br />Contacto<br />";
            $i = 0;
            foreach($xml->Contactos->Contacto as $cont){
                $i++;
            }
            if($i >  0){
                echo "verde";
            }else{
                echo "rojo";
            }
            //EJECUTIVO
            echo "<br />Ejecutivo<br />";
            if($xml->ECuenta != '' && $xml->EVenta != ''){
                echo "verde";
            }else if($xml->ECuenta != '' || $xml->EVenta != ''){
                echo "amarillo";
            }else{
                echo "rojo";
            }
            
        }
    }

?>
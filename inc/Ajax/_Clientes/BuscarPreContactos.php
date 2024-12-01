<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../../config.inc.php");
include("../../session.ajax.inc.php");
?>
<table class="tablanueva">
  <thead class="theadtablita">
  <tr>
      <th class="theadtablitauno">Contacto</th>
      <th class="theadtablita">Tel&eacute;fono</th>
      <th class="theadtablita">Extensi&oacute;n</th>
      <th class="theadtablita">Correo</th>
      <th class="theadtablita">Tipo de Contacto</th>
      <th class="theadtablitados">Editar</th>
      <th class="theadtablitados">Eliminar</th>    
  </tr>
  </thead>
  <tbody class="tablapequena">                                     
      <?php
        $sql = "CALL `prealta`.`SP_LOAD_PRECADENA`({$_SESSION['idPreCadena']});";
        $ax = $sql;
        $res = $RBD->SP($sql);
        $AND = "";
        if ( $RBD->error() == '' ) {
            if ( $res != '' && mysqli_num_rows($res) > 0 ) {
                $r = mysqli_fetch_array($res);
                $reg = $r[0];
                $xml = simplexml_load_string(utf8_encode($reg));
                /*$r = mysqli_fetch_array($res);

                $reg = base64_decode($r[0]);
                $xml = simplexml_load_string(utf8_encode($reg));*/
                //$r = mysqli_fetch_array($res);
                //$xml = simplexml_load_string($r[0]);
                $band = false;
                foreach ( $xml->Contactos->Contacto as $cont ) {
                    if ( $band == false && $cont != '' ) {
                        $AND .= " AND I.`idCadenaContacto` = $cont ";
                        $band = true;
                    } else if ( $band ) {
                        $AND .= " OR I.`idCadenaContacto` = $cont ";
                    }
                }
                if ( $AND != '' ) {
                    $sql = "CALL `prealta`.`SP_LOAD_CONTACTOSPDFAUTORIZACIONPRECADENA`('$AND');";
                    $Result = $RBD->SP($sql);
                    if ( $RBD->error() == '' ) {
                        if ( $Result != '' && mysqli_num_rows($Result) > 0 ) {
                            $i = 0;
                            while ( list($infid,$tipo,$id,$nombre,$paterno,$materno,$telefono,$ext,$correo,$desc) = mysqli_fetch_array($Result) ) {
                                if ( !preg_match('!!u', $nombre) ) {
                                    $nombre = utf8_encode($nombre);
                                }
                                if ( !preg_match('!!u', $paterno) ) {
                                    $paterno = utf8_encode($paterno);
                                }
                                if ( !preg_match('!!u', $materno) ) {
                                    $materno = utf8_encode($materno);
                                }                                                             																	
                                echo "<tr>";														
                                echo "<td class=\"tdtablita\">$nombre $paterno $materno</td>";
                                echo "<td class=\"tdtablita\">$telefono</td>";
                                echo "<td class=\"tdtablita\">$ext</td>";
                                echo "<td class=\"tdtablita\">$correo</td>";
                                echo "<td class=\"tdtablita\">".utf8_encode($desc)."</td>";
                                echo "<td class=\"tdtablita\">";
                                echo "<a href=\"#\" onclick=\"bandedcont = 1;EditarPreContacto($infid,0,0)\">";
                                echo "<img src=\"../../img/edit.png\" title=\"Editar\" name=\"Image3\" border=\"0\" id=\"Image3\" />";
                                echo "</a>";
								echo "</td>";
								echo "<td class=\"tdtablita\">";
                                echo "<a href=\"#\" onclick=\"EliminarPreContacto($infid);\">";
                                echo "<img src=\"../../img/delete.png\" title=\"Borrar\" name=\"Image26\" border=\"0\" id=\"Image26\" />";
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";														
                                $i++;
                            }
                        }
                    }
                } else {
                  echo "<td class=\"tdtablita\"></td>";
                  echo "<td class=\"tdtablita\"></td>";
                  echo "<td class=\"tdtablita\"></td>";
                  echo "<td class=\"tdtablita\"></td>";
                  echo "<td class=\"tdtablita\"></td>";
                }							
            }
        } else {
          echo "<td class=\"tdtablita\"></td>";
          echo "<td class=\"tdtablita\"></td>";
          echo "<td class=\"tdtablita\"></td>";
          echo "<td class=\"tdtablita\"></td>";
          echo "<td class=\"tdtablita\"></td>";								
        }						  
      ?>
    </tbody>
 </table>
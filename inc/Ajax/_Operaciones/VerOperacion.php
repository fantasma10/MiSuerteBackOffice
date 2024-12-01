<?php
include("../../config.inc.php");
include("../../session.ajax.inc.php");

$idPermiso 		= (isset($_SESSION['Permisos']['Tipo'][3]))?$_SESSION['Permisos']['Tipo'][3]:1;

$idO			= (isset($_POST['idO']))?$_POST['idO']:-1;

	if($idO > -1){
	$oOperacion = new Operacion($LOG,$RBD,$WBD);		
	$oOperacion->load($idO);
	
	$RES = '<div class="recuadro_contenido_detalle2">
	  <table class="tablacentrada" style="width:100%; margin-bottom:10px; border:1px solid #e4e4e4;">
        <thead>
          <th style="text-align:left;">Folio</th>
          <th style="text-align:left;">Núm Cuenta</th>
          <th style="text-align:left;">Fecha Solicitud</th>
          <th style="text-align:left;">Fecha Conciliación</th>
          <th style="text-align:left;">Proveedor</th>
          <th style="text-align:left;">Cod. Resp.</th>
        </thead>
		<tbody>
        <tr>
          <td>'.$oOperacion->getidsOperacion().'</td>
          <td>'.$oOperacion->getnumCuenta().'</td>
          <td><!-- Fecha Solicitud -->
                            	<!---->'.substr($oOperacion->getfecSolicitudOperacion(),0,10).'</td>
          <td><!-- Fecha Conciliacion -->
									<!---->';
										if($oOperacion->getfecConOperacion()==null) $RES.='Pendiente'; 
										else $RES.=substr($oOperacion->getfecConOperacion(),0,10);
								
								$RES.='</td>
          <td><!-- Proveedor -->'.$oOperacion->getNombreProv().'</td>
          <td><!-- Respuesta -->'.$oOperacion->getrespuestaOperacion().'</td>
        </tr>
        <tr>
          <td style="font-weight:bold;">Estatus</td>
          <td style="font-weight:bold;">Autorización</td>
          <td style="font-weight:bold;">Fecha de Aplicación</td>
          <td style="font-weight:bold;">Producto</td>
          <td style="font-weight:bold;">Ticket del Proveedor</td>
          <td style="font-weight:bold;">IdEquipo</td>
        </tr>
        <tr>
          <td><!-- Estatus -->'.$oOperacion->getNombreEstatus().'</td>
          <td><!-- Autorizacion de la Opc -->'.$oOperacion->getautorizacionOperacion().'</td>
          <td><!-- Fecha Aplicacion -->'.substr($oOperacion->getfecAplicacionOperacion(),0,10).'</td>
          <td><!-- Producto -->'.$oOperacion->getNombreProd().'</td>
          <td><!-- Ticket Proveedor -->'.$oOperacion->getticket().'</td>
          <td><!-- idEquipo -->'.$oOperacion->getequipo().'</td>
        </tr>
        <tr>
          <td style="font-weight:bold;">Fecha Alta</td>
          <td style="font-weight:bold;">Operador</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><!-- Fecha Alta -->'.$oOperacion->getfecAplicacionOperacion().'</td>
          <td><!-- Operador -->'.$oOperacion->getoperador().'</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		</tbody>
      </table>
  </div>

    <div>
      <table class="tablacentrada" style="width:100%; margin-bottom:10px; border:1px solid #e4e4e4;">
        <thead>
          <th style="text-align:left;">Número Emisor</th>
          <th style="text-align:left;">Cadena</th>
          <th style="text-align:left;">SKU</th>
          <th style="text-align:left;">Importe</th>
          <th style="text-align:left;">Comisión</th>
          <th style="text-align:left;">Imp. Total</th>
        </thead>
		<tbody>
        <tr>
          <td><!-- Numero Emisor -->'.$oOperacion->getNombreEmisor().'</td>
          <td><!-- Cadena -->'.$oOperacion->getNombreCadena().'</td>
          <td><!-- Sku -->'.$oOperacion->getsku().'</td>
          <td><!-- Importe -->$ '.number_format($oOperacion->getimporteOperacion(),2).'</td>
          <td><!-- Comicion -->$ '.number_format($oOperacion->gettotComCliente(),2).'</td>
          <td><!-- Importe -->$ '.number_format($oOperacion->getimporteOperacionTotal(),2).'</td>
        </tr>
        <tr>
          <td style="font-weight:bold;">Número Tran Type</td>
          <td style="font-weight:bold;">Corresponsal</td>
          <td style="font-weight:bold;">SKU de Proveedor</td>
          <td style="font-weight:bold;">Referencia</td>
          <td style="font-weight:bold;">&nbsp;</td>
          <td style="font-weight:bold;">&nbsp;</td>
        </tr>
        <tr>
          <td valign="middle" class="renglon1_tabla"><!-- Numero Tran type -->'.$oOperacion->getNombreTranType().'</td>
          <td valign="middle" class="renglon1_tabla"><!-- Corresponsal -->'.$oOperacion->getNombreCorresposnal().'</td>
          <td valign="middle" class="renglon1_tabla"><!-- Sku del Prod -->';
							if($oOperacion->getskuProveedor()==null) $RES.="No tiene";
							else $RES.=$oOperacion->getskuProveedor();
					
					$RES.='</td>
          <td valign="middle" class="renglon1_tabla"><!-- Numero Referencia-->'.$oOperacion->getreferenciaOperacion().'</td>
          <td valign="middle" class="renglon1_tabla">&nbsp;</td>
          <td valign="middle" class="renglon1_tabla">&nbsp;</td>
        </tr>
		</tbody>
      </table>
    </div>

';	
	
		
	 }else{	$RES.="<label class='subtitulo_contenido'>Favor de enviar un Folio de Operacion</label>"; }

echo utf8_encode($RES);

?>
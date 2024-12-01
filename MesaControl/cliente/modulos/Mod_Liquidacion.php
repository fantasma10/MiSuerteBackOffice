<div id="loadstep5" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep5" style="display: none">

<div class="form-group col-xs-12">
    <h4 id="h4_liquidacion"><span><i class="fa fa-gear"></i></span> Liquidaciones</h4>
</div>

<!-- Apartado de liquidacion de operaciones -->
<div class="form-group col-xs-12" id="div_tipo_proveedorVS">
    <div class="form-group col-xs-6">
        <!--<input type="radio" name="tipoLiqRecaudo" id="tipoLiqRecaudoForelo" value="1"/>-->
        <input type="radio" name="tipoLiqRecaudo" id="tipoLiqRecaudo" value="1"/>
        <label class="control-label">
            FORELO (Prepago)
        </label>
    </div>
    <div class="form-group col-xs-6">
        <!--<input type="radio" name="tipoLiqRecaudo" id="tipoLiqRecaudoCredito" value="2"/>-->
        <input type="radio" name="tipoLiqRecaudo" id="tipoLiqRecaudo" value="2"/>
        <label class=" control-label">
            Crédito
        </label>
    </div>
    <div id="div_credito_liquidaciones" style="display: none">
        <div class="form-group col-xs-4">
            <label class="form-group col-xs-12">Aplica limite de credito</label>
            <div class="form-group col-xs-6">
                <input type="radio" name="limitCredit" id="limitCreditY" value="1"/>
                <label class="control-label">
                    Si
                </label>
            </div>
            <div class="form-group col-xs-6">
                <input type="radio" name="limitCredit" id="limitCreditN" value="2"/>
                <label class=" control-label">
                    NO
                </label>
            </div>
        </div>
        <div id="limiteCredito" class="form-group col-xs-4" style="display: none">
            <label>Límite de crédito: </label>
            <input type="number" id="montoLimiteCredito" class='form-control m-bot15'>
        </div>
        <div class="form-group col-xs-4">
            <label>Tipo de liquidación *</label>
            <select class="form-control" id="cmbTipoLiquidacionOperaciones" name="cmbTipoLiquidacionOperaciones">
                <option value="-1">Seleccione</option>
                <?php echo $htmlTipoLiquidaciones ?>
            </select>
        </div>
        <div class="form-group col-xs-12" id="divTndiasOperaciones" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3 col-xs-offset-4">
                <center><label>T+n días *</label></center>
                <input type="text" id="tnDiasOperaciones" class="form-control m-bot15">
            </div>                                     
        </div>
        <div class="form-group col-xs-12" id="divCalendarioOperaciones" style="display:none;margin-top:20px;margin-bottom:30px;">
            <center><label>Por períodos *</label></center>
            <div style="text-align:center;">
                <table style="margin: 0 auto;">
                    <?php 
                    $semana = array ("Lunes","Martes","Miercoles","Jueves","Viernes");
                    for ($i=0; $i < 5; $i++) { 
                        if($i==0){ $dia="Lu_Check_Recaudo"; }
                        if($i==1){ $dia="Ma_Check_Recaudo"; }
                        if($i==2){ $dia="Mi_Check_Recaudo"; }
                        if($i==3){ $dia="Ju_Check_Recaudo"; }
                        if($i==4){ $dia="Vi_Check_Recaudo"; }
                    ?>
                    <tr>
                        <td rowspan="2">
                            <input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php echo $semana[$i]?>" disabled>
                        </td>
                        <td width="20">L</td><td width="20">M</td><td width="20">M</td><td width="20">J</td><td width="20">V</td><td width="20">S</td><td width="20">D</td>	
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="0" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="1" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="2" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="3" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="4" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="5" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                        <td><input type="checkbox" id="6" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Recaudo')"></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>                           
        </div>
        <div class="form-group col-xs-12" id="divSemanalOperaciones" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3"><label></label></div>
            <div class="col-xs-3">
                <center><label> Día Fecha Pago *</label></center><br>
                <select class="form-control" id="cmbSemanalDiaOperaciones">
                    <option value="-1">Seleccione...</option>
                    <option value="0">Lunes</option>
                    <option value="1">Martes</option>
                    <option value="2">Miércoles</option>
                    <option value="3">Jueves</option>
                    <option value="4">Viernes</option>
                </select>
            </div>
            <div class="col-xs-4">
                <center><label>¿Cuántos días hacia atrás <br>no se contemplarán para el pago? *</label></center>
                <input type="number" min="0" max="31" maxlength="2" id="semanalAtrasOperaciones" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
            </div>
        </div>
    </div>
</div>
<div id="costoTransferencia" class="form-group col-xs-12 hidden">
    <div class="form-group col-xs-4">
        <label class=" control-label">¿Retiene Costo por Transferencia? *</label>
        <select class="form-control m-bot15" name="cmbCostoTransferencia" id="cmbCostoTransferencia">
            <option value="-1">Seleccione</option>
            <option value="0">NO</option>
            <option value="1">SI</option>
        </select>
    </div>
    <div class="form-group col-xs-4" id="div_monto_transferencia" style="display: none">
        <label>Monto por Transferencia *</label>
        <input type="number" id="nMontoTransferencia" class='form-control m-bot15'>
    </div>
</div>

<!-- <div class="form-group col-xs-12" id="div_tipo_proveedorVS">
    <div class="form-group col-xs-2" id="div_pagaran_comisiones">
        <label>¿Pagarán Comisiones?</label>
        <select id="pagan_comisiones" class="form-control">
            <option value="0">NO</option>
            <option value="1">SI</option>
        </select>
    </div>
    <div class="form-group col-xs-2" id="div_cobran_comision">
        <label>¿Cobrarán Comisiones?</label>
        <select class="form-control" id="cobran_comision" name="cobran_comision">
            <option value="0">NO</option>
            <option value="1">SI</option>
        </select>
    </div>
</div> -->

<!-- Apartado de pago de comisiones -->
<div id="div_pago_comisiones">
    <div class="form-group col-xs-12">
        <h4><span><i class="fa fa-file-text"></i></span> Pago de Comisiones</h4>
    </div>
    <div class="form-group col-xs-12">
        <h5>Comisión a usuario final</h5>
    </div>
    <div class="form-group col-xs-12">
        <div class="form-check col-xs-12">
            <input type="checkbox" class="form-check-input pagoComisiones" id="checkDescFDM">
            <label class="form-check-label" for="checkDescFDM">Descuentos en FORELO-Factura a Cliente Fin de Mes</label>
        </div>
        <div class="form-check col-xs-12">
            <input type="checkbox" class="form-check-input pagoComisiones" id="checkDescGD">
            <label class="form-check-label" for="checkDescGD">Descuentos en FORELO-Factura a Público en General Diario</label>
        </div>
        <div class="form-check col-xs-12">
            <input type="checkbox" class="form-check-input pagoComisiones" id="checkTicketResp">
            <label class="form-check-label" for="checkTicketResp">De la cadena- Cliente responsable Ticket Fiscal</label>
        </div>
        <div id="validaCobroUsuario" class="form-group col-xs-4">
            <label>¿Sistema Valida Monto Cobro a Usuario? *</label>
            <select class="form-control" id="cmb_valida_monto" name="cmb_valida_monto">
                <option value="-1">Seleccione</option>
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-xs-4" id="div_cmb_comision_integrador" style="display: none">
            <label>¿Comisión adicional como Integrador? *</label>
            <select class="form-control" id="cmbComisionIntegrador" name="cmbComisionIntegrador">
                <option value="-1">Seleccione</option>
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-xs-3" id="div_monto_comision_adicional" style="display: none">
            <label>Monto comisión adicional *</label>
            <input type="number" id="nMontoIntegrador" class='form-control m-bot15'>
        </div>
        <div class="form-group col-xs-4" id="div_cmb_retiene_comision" style="display: none">
            <label>¿Cliente retiene su comisión? *</label>
            <select class="form-control" id="cmbRetieneComision" name="cmbRetieneComision">
                <option value="-1">Seleccione</option>
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
    </div>
    <div class="form-group col-xs-12">
        <div class="form-group col-xs-4" id="divPeriodoPagoComision">
            <label>Período para pago de comisiones *</label>
            <select class="form-control" id="cmbPeriodoPagoCom" name="cmbPeriodoPagoCom">
                <option value="-1">Seleccione</option>
                <?php echo $htmlTipoLiquidaciones ?>
            </select>
        </div>
        <div class="form-group col-xs-4">
            <label>Tipo Prepago de Comisiones *</label>
            <select class="form-control" id="cmbPeriodoPrepPagoCom" name="cmbPeriodoPrepPagoCom">
                <option value="-1">Seleccione</option>
                <option value="1">Pago a FORELO (con factura)</option>
                <option value="2">Pago a FORELO (sin factura)</option>
                <option value="3">Pago a Bancos</option>
                <option value="4">Pago en Prepago (se descuenta la comisión en la liquidación del crédito)</option>
            </select>
        </div>
        <div class="form-group col-xs-12" id="divTndiasPago" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3 col-xs-offset-4">
                <center><label>T+n días *</label></center>
                <input type="text" id="tnDiasPago" class="form-control m-bot15">
            </div>                                     
        </div>
        <div class="form-group col-xs-12" id="divCalendarioPago" style="display:none;margin-top:20px;margin-bottom:30px;">
            <center><label>Por períodos *</label></center>
            <div style="text-align:center;">
                <table style="margin: 0 auto;">
                    <?php 
                    $semana = array ("Lunes","Martes","Miercoles","Jueves","Viernes");
                    for ($i=0; $i < 5; $i++) { 
                        if($i==0){ $dia="Lu_Check_Pago"; }
                        if($i==1){ $dia="Ma_Check_Pago"; }
                        if($i==2){ $dia="Mi_Check_Pago"; }
                        if($i==3){ $dia="Ju_Check_Pago"; }
                        if($i==4){ $dia="Vi_Check_Pago"; }
                    ?>
                    <tr>
                        <td rowspan="2">
                            <input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php echo $semana[$i]?>" disabled>
                        </td>
                        <td width="20">L</td><td width="20">M</td><td width="20">M</td><td width="20">J</td><td width="20">V</td><td width="20">S</td><td width="20">D</td>	
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="0" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="1" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="2" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="3" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="4" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="5" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                        <td><input type="checkbox" id="6" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Pago')"></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>                           
        </div>
        <div class="form-group col-xs-12" id="divSemanalPago" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3"><label></label></div>
            <div class="col-xs-3">
                <center><label> Día Fecha Pago *</label></center><br>
                <select class="form-control" id="cmbSemanalDiaPago">
                    <option value="-1">Seleccione...</option>
                    <option value="0">Lunes</option>
                    <option value="1">Martes</option>
                    <option value="2">Miércoles</option>
                    <option value="3">Jueves</option>
                    <option value="4">Viernes</option>
                </select>
            </div>
            <div class="col-xs-4">
                <center><label>¿Cuántos días hacia atrás <br>no se contemplarán para el pago? *</label></center>
                <input type="number" min="0" max="31" maxlength="2" id="semanalAtrasPago" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
            </div>
        </div>
        <div class="form-group col-xs-12" id="divCorreosNotificaciones">
            <label>Correos para envío del pago *</label>
            <div class="row field_wrapper" id="">
                <div class="col-xs-12">
                    <input type="text" id="nuevocorreonotificaciones" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
                    <button id="btnCorreoNotificaciones" class="add_button btn btn-sm btn-default" onclick="agregarCorreoNotificaciones();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="row field_wrapper" id="contenedordecorreosliquidacion"></div> 
        </div>
    </div>
    <div>
        <div class="form-group col-lg-12">
            <h5>Datos bancarios para pago de comisiones</h5>
        </div>
        <div class="form-group col-xs-12">
            <div class="form-group col-xs-3">
                <label>CLABE *</label>
                <input type="text" class="form-control" name="sCLABE" id="txtCLABE" onkeyup="analizarCLABE();" onkeypress="analizarCLABE();">
            </div>
            <div class="form-group col-xs-3">
                <label>Banco *</label>
                <select class="form-control" id="cmbBancoPago" name="cmbBancoPago" disabled style="display: none">
                    <option value="-1"></option>
                    <?php echo $htmlBancos ?>
                </select>
                <input type="text" class="form-control" name="txtBanco" id="txtBanco" disabled>
            </div>
            <div class="form-group col-xs-3">
                <label>Cuenta *</label>
                <input type="text" class="form-control" name="sCuenta" id="txtCuenta" disabled>
            </div>
            <div class="form-group col-xs-3">
                <label>Beneficiario *</label>
                <input type="text" class="form-control" name="sBeneficiario" id="txtBeneficiario" disabled>
            </div>
            <div class="form-group col-xs-3">
                <label>Swift:</label>
                <input type="text" class="form-control" name="sSwift" id="txtsSwift" style="text-transform: uppercase;">
            </div>
            <div class="form-group col-xs-3">
                <label>ABA:</label>
                <input type="text" class="form-control" name="sABA" id="txtABA">
            </div>
            <div class="form-group col-xs-3">
                <label>País de pago:</label>
                <select class="form-control" id="cmbPaisPago" name="cmbPaisPago">
                    <option value="-1">Seleccione</option>
                    <?php echo $htmlPais ?>
                </select>
            </div>
            <div class="form-group col-xs-3">
                <label>Moneda de pago al Extranjero:</label>
                <select class="form-control" id="cmbMonedaExt" name="cmbMonedaExt">
                    <option value="-1">Seleccione</option>
                    <?php echo $htmlMonedas ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Apartado de cobro de comisiones -->
<div id="div_cobrar_comisiones">
    <div class="form-group col-lg-12">
        <h4><span><i class="fa fa-file-text"></i></span> Cobro de Comisiones</h4>
    </div>
    <div class="form-group col-xs-12">
        <div class="form-group col-xs-4">
            <label>Período para Cobro</label>
            <select class="form-control" id="cmbPeriodoCobroCom" name="cmbPeriodoCobroCom">
                <option value="-1">Seleccione</option>
                <?php echo $htmlTipoLiquidaciones ?>
            </select>
        </div>
        <div class="form-group col-xs-4">
            <label>Cuenta bancaria RED para depósito</label>
            <select class="form-control" id="cmbCuentaRED" name="cmbCuentaRED">
                <option value="-1">Seleccione</option>
                <?php echo $htmlCuentasRE ?>
            </select>
        </div>
        <div class="form-group col-xs-12" id="divTndiasCobro" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3 col-xs-offset-4">
                <center><label>T+n días *</label></center>
                <input type="text" id="tnDiasCobro" class="form-control m-bot15">
            </div>                                     
        </div>
        <div class="form-group col-xs-12" id="divCalendarioCobro" style="display:none;margin-top:20px;margin-bottom:30px;">
            <center><label>Por períodos *</label></center>
            <div style="text-align:center;">
                <table style="margin: 0 auto;">
                    <?php 
                    $semana = array ("Lunes","Martes","Miercoles","Jueves","Viernes");
                    for ($i=0; $i < 5; $i++) { 
                        if($i==0){ $dia="Lu_Check_Cobro"; }
                        if($i==1){ $dia="Ma_Check_Cobro"; }
                        if($i==2){ $dia="Mi_Check_Cobro"; }
                        if($i==3){ $dia="Ju_Check_Cobro"; }
                        if($i==4){ $dia="Vi_Check_Cobro"; }
                    ?>
                    <tr>
                        <td rowspan="2">
                            <input type="text" class="form-control m-bot15" style="text-align: center;" id="" valorConfig="$i" value="<?php echo $semana[$i]?>" disabled>
                        </td>
                        <td width="20">L</td><td width="20">M</td><td width="20">M</td><td width="20">J</td><td width="20">V</td><td width="20">S</td><td width="20">D</td>	
                    </tr>
                    <tr>
                        <td><input type="checkbox" id="0" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="1" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="2" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="3" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="4" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="5" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                        <td><input type="checkbox" id="6" value="0" class="<?php echo $dia; ?>" onclick="validarCalendario('Cobro')"></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>                           
        </div>
        <div class="form-group col-xs-12" id="divSemanalCobro" style="display:none;margin-top:20px;margin-bottom:30px;">
            <div class="col-xs-3"><label></label></div>
            <div class="col-xs-3">
                <center><label> Día Fecha Pago *</label></center><br>
                <select class="form-control" id="cmbSemanalDiaCobro">
                    <option value="-1">Seleccione...</option>
                    <option value="0">Lunes</option>
                    <option value="1">Martes</option>
                    <option value="2">Miércoles</option>
                    <option value="3">Jueves</option>
                    <option value="4">Viernes</option>
                </select>
            </div>
            <div class="col-xs-4">
                <center><label>¿Cuántos días hacia atrás <br>no se contemplarán para el pago? *</label></center>
                <input type="number" min="0" max="31" maxlength="2" id="semanalAtrasCobro" onkeyup="validarMinMax(this.id);" class="form-control m-bot15">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <span id="span_paso5" class="" style="display: none;"></span>
    </div>
</div>

<?php if ($permisos) { ?>
    <ul class="list-inline pull-right">
        <li><button onclick="actualizarApartadoLiquidacion('sSeccion5')" type="button" id="btnGuardar5" class="btn btn-default next-step">Guardar cambios</button></li>
        <li><button onclick="actualizarControlCambios('sSeccion5')" type="button" id="btnActualizarControlCambios" class="btn btn-default next-step btnActualizarControlCambios" style="display: none;">Actualizar</button></li>
        <!-- <li><button id="paso5" type="button" class="btn btn-primary next-step">Continuar</button></li> -->
    </ul>
<?php } ?>

</div>
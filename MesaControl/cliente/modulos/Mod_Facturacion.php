<div id="loadstep6" style="display: flex; justify-content: center;">
    <img src=<?php echo $PATHRAIZ.'/img/cargando3.gif' ?>>
</div>

<div id="contentStep6" style="display: none">

<div class="form-group col-xs-12">
    <h4 id="h4_liquidacion"><span><i class="fa fa-list-alt"></i></span> Datos de Facturación</h4>
</div>

<div id="contenidoFacturaComision" class="col-xs-12">
	<div class="form-group col-xs-12">
		<h5>Factura de comisiones a cliente</h5>
	</div>
	<div class="form-group col-xs-4">
		<label>Uso del CFDI *</label><select class="form-control" id="cmbCFDIComision" disabled><option value="-1">Seleccione</option></select>
	</div> 
	<div class="form-group col-xs-4">
		<label>Forma de pago *</label><select class="form-control" id="cmbFormaPagoComision"><option value="-1">Seleccione</option></select>
	</div>
	<div class="form-group col-xs-4">
		<label>Método de pago *</label><select class="form-control" id="cmbMetodoPagoComision" disabled><option value="-1">Seleccione</option></select>
	</div>                                   	
	<div class="form-group col-xs-6">
		<label>Clave del producto *</label><select class="form-control" id="cmbProductoServicioComision"><option value="-1">Seleccione</option></select>
	</div>
	<div class="form-group col-xs-6">
		<label>Clave de Unidad *</label><select class="form-control" id="cmbClaveUnidadComision"><option value="-1">Seleccione</option></select>
	</div>                                   	
	<div class="form-group col-xs-4">
		<label>Periodicidad de facturación *</label>
		<select class="form-control" id="periocidadComision">
			<option value="-1">Seleccione</option>
			<option value="1">Semanal</option>
			<option value="2">Quincenal</option>
			<option value="3">Mensual</option>
		</select>
	</div>
	<div class="form-group col-xs-4">
		<label>Días para liquidar la factura *</label>
		<input class="form-control" type="text" id="diasLiquidacionComision">
	</div>	
	<div class="col-xs-7" id="divCorreosFacturaComision">
		<label>Correos a enviar la factura:</label>
		<div class="row field_wrapper" id="contenedordecorreosfacturas">
			<div class="col-xs-12">
				<input type="text" id="nuevocorreofacturasComision" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
				<button id="btnCorreoFacturasComision" class="add_button btn btn-sm btn-default" onclick="agregarcorreosfacturasComision();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="row field_wrapper" id="contenedordecorreosfacturasComision"></div> 
	</div>
	<div class="col-xs-12"></div>
</div>

<div id="contenidoFacturaTae" class="col-xs-12" style="display: none">
	<div class="form-group col-xs-12" style="margin-top: 20px">
		<h5>Factura TAE (Si aplica)</h5>
	</div>
	<div class="form-group col-xs-4">
		<label>Uso del CFDI *</label><select class="form-control" id="cmbCFDITAE" disabled><option value="-1">Seleccione</option></select>
	</div> 
	<div class="form-group col-xs-4">
		<label>Forma de pago *</label><select class="form-control" id="cmbFormaPagoTAE"><option value="-1">Seleccione</option></select>
	</div>
	<div class="form-group col-xs-4">
		<label>Método de pago *</label><select class="form-control" id="cmbMetodoPagoTAE" disabled><option value="-1">Seleccione</option></select>
	</div>                                   	
	<div class="form-group col-xs-6">
		<label>Clave del producto *</label><select class="form-control" id="cmbProductoServicioTAE"><option value="-1">Seleccione</option></select>
	</div>
	<div class="form-group col-xs-6">
		<label>Clave de Unidad *</label><select class="form-control" id="cmbClaveUnidadTAE"><option value="-1">Seleccione</option></select>
	</div>                                   	
	<div class="form-group col-xs-4">
		<label>Periodicidad de facturación *</label>
		<select class="form-control" id="periocidadTAE">
			<option value="-1">Seleccione</option>
			<option value="1">Semanal</option>
			<option value="2">Quincenal</option>
			<option value="3">Mensual</option>
		</select>
	</div>
	<div class="form-group col-xs-4">
		<label>Días para liquidar la factura *</label>
		<input class="form-control" type="text" id="diasLiquidacionTAE">
	</div>	
	<div class="col-xs-7" id="divCorreosFacturaTAE">
		<label>Correos a enviar la factura *</label>
		<div class="row field_wrapper" id="contenedordecorreosfacturas">
			<div class="col-xs-12">
				<input type="text" id="nuevocorreofacturasTAE" class="form-control m-bot15" name="correos" style="width:270px;display:inline-block;">
				<button id="btnCorreoFacturasTAE" class="add_button btn btn-sm btn-default" onclick="agregarcorreosfacturasTAE();"><i class="fa fa-plus-circle" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<div class="row field_wrapper" id="contenedordecorreosfacturasTAE"></div> 
	</div>
</div>

<div id="div_impuestos_comisiones" class="col-xs-12">
    <div class="form-group col-xs-12">
        <h4><span><i class="fa fa-file-text"></i></span> Impuestos y retenciones</h4>
    </div>
    <div class="form-group col-xs-12">
        <div class="form-group col-xs-4">
            <label>IVA Impuesto Aplicable a Facturas de Comisiones *</label>
            <select class="form-control" id="cmbIVAComision" name="cmbIVAComision">
                <option value="-1">Seleccione</option>
                <option value="0.1600">16%</option>                                    		
                <option value="0.0800">8%</option>
                <option value="0.0000">0%</option>
            </select>
        </div>
    </div>
    <div class="form-group col-xs-12">
        <div class="form-group col-xs-4">
            <label>¿Retiene IVA? *</label>
            <select class="form-control" id="nRetieneIVA" name="nRetieneIVA">
                <option value="-1">Seleccione</option>
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
            <small><strong>La cantidad de IVA que se retiene es 10.6667%</strong></small>
        </div>
        <div class="form-group col-xs-4">
            <label>¿Retiene ISR? *</label>
            <select class="form-control" id="nRetieneISR" name="nRetieneISR">
                <option value="-1">Seleccione</option>
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <span id="span_paso6" class="" style="display: none;"></span>
    </div>
</div>

<?php if ($permisos) { ?>
	<ul class="list-inline pull-right">
		<li><button onclick="actualizarApartadoFacturas('sSeccion6')" type="button" id="btnGuardar6" class="btn btn-default next-step">Guardar cambios</button></li>
        <li><button onclick="actualizarControlCambios('sSeccion6')" type="button" id="btnActualizarControlCambios" class="btn btn-default next-step btnActualizarControlCambios" style="display: none;">Actualizar</button></li>
		<!-- <li><button id="paso6" type="button" class="btn btn-primary next-step">Continuar</button></li> -->
	</ul>
<?php } ?>

</div>

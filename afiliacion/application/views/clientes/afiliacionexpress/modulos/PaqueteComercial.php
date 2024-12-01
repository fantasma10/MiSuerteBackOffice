

<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="">
	<div class="panel-heading">
		<h4 class="panel-title">Paquete Comercial</h4>
		<div class="panel-controls panel-controls-right">
			<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a>
		</div>
	</div>
	<div class="panel-body">
		<table width="100%" class="table-bordered table-condensed table-striped table-hover mt5 hidess">
			<tr>
				<th>Paquete</th>
				<th>Cuota de Activación</th>
				<th>Afiliación Única</th>
				<th>Afiliación Mensual</th>
				<th>Afiliación Anual</th>
				<th>Sucursales</th>
				<th>Agregar</th>
			</tr>
			<?php
				echo $tbl_paquetes;
			?>
		</table> 
		<div class="row mt20">
			<form name="paqueteSeleccionado" id="formPaqueteSeleccionado">
				<div class="col-xs-1">
					<div class="form-group">
						<label>Inscripción</label>
						<input type="text" class="form-control" name="nInscripcionCliente" id="txtInscripcionCliente"/>
						<input type="hidden" name="nIdPaquete" id="txtIdPaquete" value="0">
					</div>
				</div> 
				<div class="col-xs-1">
					<div class="form-group">
						<label>Afiliación</label>
						<input type="text" class="form-control" name="nAfiliacionSucursal" id="txtAfiliacionSucursal"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label>Renta Mensual</label>
						<input type="text" class="form-control" name="nRentaSucursal" id="txtRentaSucursal"/>
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label>Anualidad</label>
						<input type="text" class="form-control" name="nAnualSucursal" id="txtAnualSucursal"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label>Sucursales</label>
						<input type="text" class="form-control" name="nLimiteSucursales" id="txtLimiteSucursales"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label>Fecha Inicio</label>
						<input type="text" name="dFechaInicio" class="form-control" id="txtDFechaInicio" disabled="disabled">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label>Vencimiento</label>
						<input type="text" class="form-control" name="dFechaVencimiento" id="txtFechaVencimiento"/>
						<input type="hidden" class="" name="bPromocion" id="txtBPromocion"/>
					</div>
				</div>
			</form>
		</div> 
	</div>
</div>


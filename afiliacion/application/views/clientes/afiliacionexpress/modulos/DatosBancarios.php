<div class="panel panel-default toggle panelMove panelClose panelRefresh" id=""> 
	<div class="panel-heading">
		<h4 class="panel-title">Datos Bancarios</h4>
			<div class="panel-controls panel-controls-right">
				<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
			</div>
	</div> 
	<div class="panel-body">
		<form name="datosBancarios" id="formDatosBancarios">
			<div class="row">
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">CLABE <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sCLABE" id="txtCLABE">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Banco <span class="asterisco">*</span></label>
						<select class="form-control" name="nIdBanco" id="cmbBanco" disabled="">
							<option value="-1">--</option>
						</select>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Cuenta <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="nCuenta" id="txtCuenta" readonly>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Beneficiario <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sBeneficiario" id="txtBeneficiario">
					</div>
				</div>
				<div class="col-xs-3">
					<div class="form-group">
						<label class="">Descripción</label>
						<input type="text" class="form-control" name="sDescripcion" id="txtDescripcion">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label class="">Estado de Cuenta <span class="asterisco">*</span></label>
					<input type="file" class="hidess" style="" name="sFileEstadoDeCuenta" id="txtFileEstadoDeCuenta" idtipodoc="4">
                    <input type="button" id="btnFileEdocta" value="Ver Documento">
					<input type="hidden" class="" style="" name="nIdDocEstadoCuenta" id="txtNIdDocEstadoCuenta" idtipodoc="4">
				</div>
			</div>
		</form>
	</div>
</div>
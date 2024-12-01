<div class="row ">
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Calle<span class="asterisco">*</span></label>
				<input type="text" class="form-control" name="sCalle" id="txtCalle">
				<input type="hidden" name="nIdDireccion"/>
			</div>
	</div>
	<div class="col-xs-1">
		<div class="form-group">
			<label class="">Num. Ext <span class="asterisco">*</span></label>
			<input type="text" class="form-control" name="nNumExterno" id="txtNumExterno">
		</div>
	</div>
	<div class="col-xs-1">
		<div class="form-group">
			<label class="">Num. Int</label>
			<input type="text" class="form-control" name="sNumeroInterno" id="txtNumInterno">
		</div>
	</div>
	<div class="col-xs-1">
		<div class="form-group">
			<label class="">C.P.<span class="asterisco">*</span></label>
			<input type="text" class="form-control" name="nCodigoPostal" id="txtCodigoPostal">
		</div>
	</div>
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Colonia<span class="asterisco">*</span></label>
			<select class="form-control" name="nNumColonia" id="cmbColonia">
				<option value="-1">--</option>
			</select>
		</div>
	</div> 
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Ciudad<span class="asterisco">*</span></label>
			<select class="form-control" disabled="" name="cmbCiudad" id="cmbCiudad">
				<option>--</option>
			</select>
		</div>
	</div>
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Estado<span class="asterisco">*</span></label>
			<select class="form-control" disabled="" name="cmbEntidad" id="cmbEntidad">
				<option>--</option>
			</select>
		</div>
	</div>
	<div class="col-xs-1">
		<div class="form-group">
			<label class="">País <span class="asterisco">*</span></label>
			<!--<input type="text" class="form-control" placeholder="México" disabled="">-->
			<select class="form-control" disabled="" name="cmbEntidad" id="cmbPais">
				<option value="164">Mexico</option>
			</select>
		</div>
	</div>
</div>
<div class="row ">
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Calle<span class="asterisco">*</span></label>
				<input type="text" class="form-control mayusculas" name="sCalle" id="txtCalle">
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
			<input type="text" class="form-control mayusculas" name="sNombreColonia" id="txtColonia" maxlength="50">
		</div>
	</div> 
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Ciudad<span class="asterisco">*</span></label>
			<input type="text" class="form-control mayusculas" name="sNombreMunicipio" id="txtMunicipio" maxlength="50">
		</div>
	</div>
	<div class="col-xs-2">
		<div class="form-group">
			<label class="">Estado<span class="asterisco">*</span></label>
			<input type="text" class="form-control mayusculas" name="sNombreEstado" id="txtEstado" maxlength="50">
		</div>
	</div>
	<div class="col-xs-1">
		<div class="form-group">
			<label class="">País <span class="asterisco">*</span></label>
			<!--<input type="text" class="form-control" placeholder="México" disabled="">-->
			<select class="form-control mayusculas" name="nIdPais" id="cmbPais" disabled="">
				<option value="68">Estados Unidos</option>
			</select>
		</div>
	</div>
</div>
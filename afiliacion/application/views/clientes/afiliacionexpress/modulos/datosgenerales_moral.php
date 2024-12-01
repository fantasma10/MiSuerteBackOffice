<div class="row">
	<div class="col-xs-4">
		<div class="form-group">
			<label class="">Giro <span class="asterisco">*</span></label>
			<select class="form-control" name="nIdGiro" id="cmbGiro">
				<option value="-1">--</option>
                <?php echo $giros; ?>
			</select>
		</div>
	</div>
	<div class="col-xs-4">
		<div class="form-group">
			<label class="">Razón Social <span class="asterisco">*</span></label>
			<input type="text" class="form-control mayusculas" name="sRazonSocial" id="txtRazonSocial" maxlength="150">
		</div>
	</div>
	<div class="col-xs-4">
		<div class="form-group">
			<label class="">Nombre Comercial<span class="asterisco">*</span></label>
			<input type="text" class="form-control mayusculas" name="sNombreComercial" id="txtNombreComercial" maxlength="150">
		</div>
	</div>
</div>
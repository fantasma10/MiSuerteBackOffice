<div class="row">
	<div class="col-xs-3">
		<div class="form-group">
			<label class="">Giro <span class="asterisco">*</span></label>
			<select class="form-control" name="nIdGiro" id="cmbGiro">
				<option value="-1">--</option>
                <?php  echo $giros; ?>
			</select>
		</div>
	</div>
	<div class="col-xs-3">
		<div class="form-group">
			<label class="">Nombre (s) <span class="asterisco">*</span></label>
			<input type="text" class="form-control fisico mayusculas" name="sNombreCliente" maxlength="50" id="nombrefisico">
		</div>
	</div>
	<div class="col-xs-3">
		<div class="form-group">
			<label class="">Apellido Paterno <span class="asterisco">*</span></label>
			<input type="text" class="form-control fisico mayusculas" name="sPaternoCliente" maxlength="50" id="sPaternoCliente">
		</div>
	</div>
	<div class="col-xs-3">
		<div class="form-group">
			<label class="">Apellido Materno <span class="asterisco">*</span></label>
			<input type="text" class="form-control fisico mayusculas" name="sMaternoCliente" maxlength="50" id="sMaternoCliente">
		</div>
	</div>
</div>
<div class="row"> 
	<div class="col-xs-6">
		<div class="form-group">
			<label class="">Razón Social <span class="asterisco">*</span></label>
			<input type="text" class="form-control" name="sRazonSocial" id="txtRazonSocial" maxlength="150" disabled="">
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group">
			<label class="">Nombre Comercial<span class="asterisco">*</span></label>
			<input type="text" class="form-control mayusculas" name="sNombreComercial" id="txtNombreComercial" maxlength="150">
		</div>
	</div>
</div>
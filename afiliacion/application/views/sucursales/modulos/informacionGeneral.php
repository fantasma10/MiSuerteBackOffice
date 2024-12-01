<form id="frmDatosGenerales">
	<div class="row "> 
		<div class="col-xs-3">
			<div class="form-group"> 
				<label class="">Nombre de Cliente</label>
				<input type="text" class="form-control mayusculas form-control2" name="sNombreCliente" id="txtSNombreCliente">
				<input type="hidden" name="sRFC" id="txtSRFC">
			</div>
		</div>
		<div class="col-xs-2">
			<div class="form-group">
				<label>No. Identificador</label>
				<input class="form-control mayusculas form-control2" name="nIdSucursal" id="txtNIdSucursal" maxlength="10">
			</div>
		</div>
		<div class="col-xs-3">
			<div class="form-group">
				<label>Nombre de Sucursal</label>
				<input class="form-control mayusculas form-control2" name="sNombreSucursal" id="txtSNombreSucursal" maxlength="100">
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<label>Correo Electrónico</label>
				<input class="form-control form-control2" name="sEmail" id="txtSEmail" maxlength="150">
			</div>
		</div>
	</div>
	<div class="row">  
		<div class="col-xs-2">
			<div class="form-group">
				<label class="">Teléfono<span class="asterisco">*</span></label>
				<input type="text" class="form-control form-control2" name="sTelefono" id="txtSTelefono" maxlength="10">
			</div>
		</div> 
		<div class="col-xs-4">
			<div class="form-group">
				<label class="">Giro<span class="asterisco">*</span></label>
				<select class="form-control form-control2" name="nIdGiro" id="cmbGiro">
					<option value="-1">--</option>
                     <?php  echo $giros; ?>
				</select>
			</div>
		</div>
		<div class="col-xs-2">
			<div class="form-group">
				<label class="">Nombre (s) <span class="asterisco">*</span></label>
				<input type="text" class="form-control mayusculas form-control2" name="sNombre" id="sNombre" maxlength="50">
			</div>
		</div>
		<div class="col-xs-2">
			<div class="form-group">
				<label class="">Apellido Paterno <span class="asterisco">*</span></label>
				<input type="text" class="form-control mayusculas form-control2" name="sPaterno" id="sPaterno" maxlength="50">
			</div>
		</div>
		<div class="col-xs-2">
			<div class="form-group">
				<label class="">Apellido Materno <span class="asterisco">*</span></label>
				<input type="text" class="form-control mayusculas form-control2" name="sMaterno" id="sMaterno" maxlength="50">
			</div>
		</div> 
	</div>
</form> 
<div id="tables">    
	
        </div> 
<div class="panel-body" id="formContactos">
	<form id="frmContactos">
		<div class="row">	
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Nombre (s) <span class="asterisco">*</span></label>
					<input type="text" class="form-control mayusculas contactos-input" name="sNombre" id="txtSNombre" maxlength="50">
				</div>
			</div>
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Apellido Paterno <span class="asterisco">*</span></label>
					<input type="text" class="form-control mayusculas contactos-input" name="sPaterno" id="txtSPaterno">
				</div>
			</div>
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Apellido Materno <span class="asterisco">*</span></label>
					<input type="text" class="form-control mayusculas contactos-input" name="sMaterno" id="txtsMaterno">
				</div>
			</div> 
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Teléfono <span class="asterisco">*</span></label>
					<input type="text" class="form-control contactos-input" name="sTelefono" id="sTelContacto" maxlength="10"/>
				</div>
			</div>
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Extensión</label>
					<input type="text" class="form-control contactos-input" name="sExtTelefono" id="sExtTelefono" maxlength="10"/>
				</div>
			</div>
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Teléfono Móvil <span class="asterisco">*</span></label>
					<input type="text" class="form-control contactos-input" id="sMovilContacto" name="sCelular" maxlength="10"/>
				</div>
			</div>
		</div> 
		<div class="row "> 
			<div class="col-xs-4">
				<div class="form-group">
					<label class="">Correo Electrónico</label>
					<input type="text" class="form-control contactos-input" name="sEmail" id="txtsEmail">
				</div>
			</div>
			<div class="col-xs-2">
				<div class="form-group">
					<label class="">Descripción</label>
					<input type="text" class="form-control mayusculas contactos-input" name="sDescripcion" id="txtsDescripcion">
				</div>
			</div>
			<div class="col-xs-4">
				<button type="button" class="btn btn-xs btn-primary mt15 btn1" id="btnAgregarContacto">Agregar</button>
					<input type="hidden" name="nIdContacto" id="nIdContacto" value="0">
                    <button type="button" class="btn btn-xs btn-primary mt15 btn1 btn2" id="btnEditarContacto">Editar</button>
                    	<button type="button" class="btn btn-xs btn-primary mt15 btn1 btn2" id="btnNuevoContacto">Nuevo</button>
			</div>
		</div>
	</form> 
</div>

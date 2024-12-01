<?php
	$contactos = $contactos['contactos'];
?>
<div class="panel panel-default toggle panelMove panelClose panelRefresh div-contactos" id=""> 
	<div class="panel-heading">
		<h4 class="panel-title">Contactos</h4>
		<div class="panel-controls panel-controls-right">
			<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
		</div>
	</div> 
	<div class="panel-body"> 
      <div id="tables">    
	
        </div>  
        <br>
		<form name="capturaContacto" id="formCapturaContacto" class="hidess">
			<div class="row mt10">	
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Nombre (s) <span class="asterisco ">*</span></label>
						<input type="text" class="form-control mayusculas" name="sNombreContacto" id="txtNombreContacto"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Apellido Paterno <span class="asterisco ">*</span></label>
						<input type="text" class="form-control mayusculas" name="sPaternoContacto" id="txtPaternoContacto"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Apellido Materno <span class="asterisco ">*</span></label>
						<input type="text" class="form-control mayusculas" name="sMaternoContacto" id="txtMaternoContacto"/>
					</div>
				</div> 
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Teléfono <span class="asterisco">*</span></label>
						<input type="text" class="form-control " name="sTelefonoContacto" id="txtTelefonoContacto" placeholder="(00) 00-00-00-00">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Extensión</label>
						<input type="text" class="form-control" name="sExtensionContacto" id="txtExtensionContacto"/>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Teléfono Móvil <span class="asterisco">*</span></label>
						<input type="text" class="form-control" name="sTelefonoMovilContacto" id="txtTelefonoMovilContacto" placeholder="(00) 00-00-00-00">
					</div>
				</div>
			</div> 
			<div class="row "> 
				<div class="col-xs-4">
					<div class="form-group">
						<label class="">Correo Electrónico</label>
						<input type="text" class="form-control" name="sEmailContacto" id="txtEmailContacto">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Descripción</label>
						<input type="text" class="form-control" name="sDescripcionContacto" id="txtDescripcionContacto">
					</div>
				</div>
				<div class="col-xs-2">
					<div class="form-group">
						<label class="">Tipo de Contacto</label>
						<select class="form-control" name="nIdTipoContacto" id="cmbTipoContacto">
							<option value="-1">--</option>
                            <?php echo $contactoTipo; ?>
						</select>
					</div>
				</div> 
			<!--</div>
			<div class="row">-->
				<div class="col-xs-4">
					<button type="button" class="btn btn-xs btn-primary mt15 btn1" id="btnAgregarContacto">Agregar</button>
					<input type="hidden" name="nIdContacto" id="nIdContacto" value="0">
                    <button type="button" class="btn btn-xs btn-primary mt15 btn1 btn2" id="btnEditarContacto">Editar</button>
                    	<button type="button" class="btn btn-xs btn-primary mt15 btn1 btn2" id="btnNuevoContacto">Nuevo</button>
				</div>
			</div>
          
		</form>
	</div>
</div>


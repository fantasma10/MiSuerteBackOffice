<div id="content" class="page-content clearfix">
	<div class="contentwrapper">
		<form name="formBack" id="formModUno">
			<!--Content wrapper-->
			<div class="heading">
				<!--  .heading-->
				<h3>Nuevo Cliente</h3>  
				<ul class="breadcrumb">
					<li>Estás Aquí:</li>
					<li>
						<a href="#" class="tip" title="back to dashboard">
							<i class="s16 icomoon-icon-screen-2"></i>
						</a>
						<span class="divider">
							<i class="s16 icomoon-icon-arrow-right-3"></i>
						</span>
					</li>
					<li class="active">Afiliación Prospecto</li>
				</ul>
			</div> 
			
			<div class="panel panel-default toggle panelMove panelClose panelRefresh" id="supr6"> 
				<div class="panel-heading">
					<h4 class="panel-title">Registro de Prospecto</h4>
						<div class="panel-controls panel-controls-right">
							<a href="#" class="toggle panel-minimize"><i class="icomoon-icon-plus"></i></a> 
						</div>
				</div> 
				<div class="panel-body"> 
					<div class="row">
						<div class="col-xs-2">
							<div class="form-group">
								<label>País</label>
								<select class="form-control" id="cmbPais" name="nIdPais">
									<option value="-1">--</option>
								</select>
							</div>
						</div>
						<div class="col-xs-2"> 
							<div class="form-group" id="div-regimenfiscal">
								<label>Regimen Fiscal</label>
								<select class="form-control" id="cmbRegimen">
									<option value="-1">--</option>
								</select>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group" id="div-rfc">
								<label>R.F.C.</label>
								<input class="form-control mex" id="txtRFC" maxlength="13" name="sRFC"/>
							</div>
						</div>
						
						<div class="col-xs-4">
							<div class="form-group">
								<label>Correo</label>
								<input class="form-control" id="txtEmail" maxlength="150" name="sEmail"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Teléfono</label>
								<input class="form-control" id="txtTelefono" maxlength="" placeholder="(00) 00-00-00-00" name="sTelefono"/>
							</div>
						</div>
					</div>
					<div class="row"> 
						<div class="col-xs-3">
							<div class="form-group">
								<label>Nombre (s)</label>
								<input class="form-control nombre" id="txtNombre" maxlength="50" name="sNombre"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Apellido Paterno</label>
								<input class="form-control nombre" id="txtPaterno" maxlength="50" name="sPaterno"/>
							</div>
						</div>
						<div class="col-xs-2">
							<div class="form-group">
								<label>Apellido Materno</label>
								<input class="form-control nombre" id="txtMaterno" maxlength="50" name="sMaterno"/>
							</div>
						</div>
						<div class="col-xs-5 mt15"> 
							<a href="#" class="btn btn-info btn-xs" id="btnRegistraCliente">Registrar Cliente</a>
						</div> 
					</div> 
				</div>
			</div>

			<input type="hidden" name="backUrl" value="<?php echo base_url();?>index.php/clientes/afiliacionexpress/cliente">
			<input type="hidden" name="nIdRegimen">
		</form>
	</div> 
</div>
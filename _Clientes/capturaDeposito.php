<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	include("../inc/config.inc.php");
	include("../inc/session.inc.php");

	/*function words($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}*/

?>

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-revision">
				<span>
					<i class="fa fa-check-square"></i>
				</span>
				<h3>Nombre de Corresponsal</h3>
				<span class="rev-combo pull-right"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></span>
			</div>

			<div class="modal-body">
				<div class="legmed">
					<i class="fa fa-dollar"></i> Registro de Pago
				</div>

				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-lg-2 control-label"> Importe: </label>
						<div class="col-lg-2">
							<input type="text" class="form-control">
						</div>

						<label class="col-lg-1 control-label"> Banco: </label>
						<div class="col-lg-2">
							<select class="form-control m-bot15">
								<option value='-1'>Seleccione Banco</option>
								<?php
									$sql = $RBD->query("CALL `prealta`.`SP_LOAD_BANCOS`()");

									while($row = mysqli_fetch_assoc($sql)){

										echo "<option value='".$row['idBanco']."'>".$row['nombreBanco']."</option>";
									}
								?>
							</select>
						</div>

						<label class="col-lg-2 control-label"> Cuenta de Depósito: </label>
						<div class="col-lg-2">
							<input type="text" class="form-control">
						</div>
					</div>

					<form class="form-horizontal">
						<div class="form-group">
							<label class="col-lg-2 control-label"> Autorización/Folio: </label>
							<div class="col-lg-2">
								<input type="text" class="form-control">
							</div>

							<label class="col-lg-1 control-label">Fecha:</label>
							<div class="col-lg-2">
								<input id="fechaDeposito" class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" onkeypress="return validaFecha(event,'txtFechaVenc')" onkeyup="validaFecha2(event,'txtFechaVenc')" maxlength="10"  />
								<span class="help-block">Seleccionar Fecha.</span>
							</div>

							<label class="col-lg-2 control-label"> Referencia: </label>
							<div class="col-lg-2">
								<input type="text" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-2 control-label"> Ficha de Depósito: </label>                                   
							<input type="file" class="col-lg-3" style="background:none;"><i class="fa fa-check"></i>
						</div>
					</form>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
			</div>
		</div>
	</div>

<?php
	
	$numCuenta = (!empty($_POST["numCuenta"]))? $_POST["numCuenta"] : "";

?>

<table>
	<tr>
		<td>Tipo Movimiento</td>
		<td>Tipo Instrucción</td>
		<td>Destino</td>
	</tr>
	<tr>
		<td>
			<select id="ddlTipoMovimiento">
				<!--option value="-1">Seleccione</option-->
				<!--option value="0">Cobro</option-->
				<option value="0">Pago</option>
			</select>
		</td>
		<td>
			<div id="selectInstruccion">
				<select id="ddlInstruccion">
					<option value="-1">Seleccione</option>
				</select>
			</div>
		</td>
		<td>
			<select id="ddlDestino">
				<option value="-1">Seleccione</option>
				<option value="1">Forelo</option>
				<option value="2">Banco</option>
			</select>
		</td>
	</tr>
</table>

<div id="fieldsBanco" style="display:none;">
	<table>
		<tr>
			<td>CLABE</td>
			<td>No Cuenta</td>
			<td>Banco</td>
		</tr>
		<tr>
			<td><input type="text" id="txtCLABE"></td>
			<td><input type="text" id="txtNumCuenta" value="<?php echo $numCuenta; ?>"></td>
			<td><input type="text" id="txtBanco"></td>
		</tr>
		<tr>
			<td>Beneficiario</td>
			<td>RFC</td>
			<td>Correo</td>
		</tr>
		<tr>
			<td><input type="text" id="txtBeneficiario" /></td>
			<td><input type="text" id="txtRFC" onkeyup="javascript:this.value=this.value.toUpperCase();"/></td>
			<td><input type="text" id="txtCorreo"/></td>
		</tr>
	</table>
</div>
<table>
	<tr>
		<td colspan="3"><input type="button" value="Agregar" onclick="crearConf()" /></td>
	</tr>
</table>
function CambioPassword() {
	
	var passwordActual = txtValue('txtContra');
	var passwordNuevo = txtValue('txtNewPass');
	var passwordNuevoConfirmacion = txtValue('txtConfirma');
	
	var parametros = '{';
	parametros += '"datos": [';
	parametros += ' { "passwordActual": \"'+ passwordActual +'\", ';
	parametros += '"passwordNuevo": \"' + passwordNuevo + '\", ';
	parametros += '"passwordNuevoConfirmacion": \"'+ passwordNuevoConfirmacion + '\"';
	parametros += ' }]';
	parametros += '}';
	
	MetodoAjaxJSON2('../../../inc/Ajax/_Sesion/UpdatePass.php', parametros);
}
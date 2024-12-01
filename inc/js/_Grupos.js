function RellenarTelefonoDatosGenerales() {
	if ( document.getElementById("txttel1") ) {
		if ( txtValue("txttel1") == '' ) {
			document.getElementById("txttel1").value = "52-";
			$("#txttel1").putCursorAtEnd();
		}
	}
}

function RellenarTelefonoContactos() {
	if ( document.getElementById("txttelefono") ) {
		if ( txtValue("txttelefono") == '' ) {
			document.getElementById("txttelefono").value = "52-";
			$("#txttelefono").putCursorAtEnd();
		}
	}
}
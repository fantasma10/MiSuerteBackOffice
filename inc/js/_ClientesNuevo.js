function BuscarPreContactos(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactos.php",'','divRES');
}

function CambioPagina( i, existenCambios ) {
	var r;
	if ( existenCambios ) {
		r = confirm('Est\u00E1 a punto de ir a otro paso. Perder\u00E1 todos los cambios que no haya guardado. \u00BFDesea continuar?');
	} else {
		r = true;
	}
	if ( r ) {
		switch ( i ) {
			case 0:
				window.location = "Crear.php";
			break;
			case 1:
				window.location = "Crear1.php";
			break;
			case 2:
				window.location = "Crear2.php";
			break;
			case 3:
				window.location = "Crear3.php";
			break;
			case 4:
				window.location = "Crear4.php";
			break;
			case 5:
				window.location = "CrearResumen.php";
			break;
		}
	}
}

function agregarPreContacto() {
	$("#datos-generales-contacto").slideDown("normal");
	$("#boton-nuevo-contacto").hide();
}

function EditarGrlsPreCadena(id){
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var mail = txtValue("txtmail");
	var band = true;
	var parametros = "idpreclave="+id;
	if(grupo > -1){
		parametros+="&idgrupo="+grupo;
		if(ref > -1){
			parametros+="&idref="+ref;
			if(tel1 != ''){
				if(validaTelefono("txttel1")){
					parametros+="&tel1="+tel1;
					if(mail != ''){
						if(validarEmail("txtmail")){
							parametros+="&mail="+mail;							
						}else{
							band = false;
							alert("El Correo Electr\u00F3nico es incorrecto")
						}
					}
				}else{
					band = false;
					alert("El n\u00FAmero de Tel\u00E9fono no es correcto")
				}
			}
		}else{
			band = false;
			alert("Favor de seleccionar la Referencia de la Cadena");	
		}
	}else{
		band = false;
		alert("Favor de seleccionar el Grupo de la Cadena");
	}
	if(band){
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreCadena.php",parametros);
	}
}

function RellenarTelefono() {
	if ( txtValue("txttel1") == '' ) {
		document.getElementById("txttel1").value = "52-";
		$("#txttel1").putCursorAtEnd();
	}
}
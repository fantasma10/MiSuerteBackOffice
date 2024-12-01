function CrearPreCadena(){
	var texto = txtValue("txtcrear");
	var nombre = texto.trim();
	if ( nombre != '' /*&& validaCadenaNumero(nombre)*/ ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreCadena.php","nombre="+nombre,"Cadena/Crear.php");
	} else {
		alert("El nombre de la cadena es invalido");
	}
}

function CrearPreSubCadena(){
	var texto = txtValue("txtcrear");
	var nombre = texto.trim();
	if ( nombre != '' /*&& validaCadenaNumero(nombre)*/ ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreSubCadena.php","nombre="+nombre,"Subcadena/Crear.php");
	} else {
		alert("El nombre de la subcadena es invalido");
	}
}

function CrearPreCorresponsal(){	
	var texto = txtValue("txtcrear");
	var nombre = texto.trim();
	if ( nombre != '' /*&& validaCadenaNumero(nombre)*/ ) {
		MetodoAjax3("../../inc/Ajax/_Clientes/CrearPreCorresponsal.php","nombre="+nombre, "Corresponsal/Crear.php");
	} else {
		alert("El nombre del corresponsal es invalido");
	}
}

var tipoconsulta = 0;
function CrearGeneral( j ) {
	$("#tablacrear").fadeIn("normal");
	switch ( tipoconsulta ) {
		case 0:
			$("#tipoDeCreacion").html('Cadena');
			$("#creacion").css("display", "block");
			$("#rdbCadena").prop("checked", true);
			$("#rdbSubCadena").prop("checked", false);
			$("#rdbCorresponsal").prop("checked", false);
			if ( j == true ) {
				CrearPreCadena();
			}
		break;
		case 1:
			$("#tipoDeCreacion").html('Sub Cadena');
			$("#creacion").css("display", "block");
			$("#rdbCadena").prop("checked", false);
			$("#rdbSubCadena").prop("checked", true);
			$("#rdbCorresponsal").prop("checked", false);			
			if ( j == true ) {
				CrearPreSubCadena();
			}
		break;
		case 2:
			$("#tipoDeCreacion").html('Corresponsal');
			$("#creacion").css("display", "block");
			$("#rdbCadena").prop("checked", false);
			$("#rdbSubCadena").prop("checked", false);
			$("#rdbCorresponsal").prop("checked", true);			
			if ( j == true ) {
				CrearPreCorresponsal();
			}
		break;
	}
}
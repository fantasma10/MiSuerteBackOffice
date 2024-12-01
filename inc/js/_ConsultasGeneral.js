function desplegarModalSubCadena(idCadena, idSubCadena) {
	$("#excelReporte").html("");
	$("#tablaReporte").html("");
	$.post("../../../inc/Ajax/_Clientes/GetCorresponsales.php",
	{ "idCadena": idCadena, "idSubCadena": idSubCadena },
	function(response){
		var corresponsal = jQuery.parseJSON(response);
		if ( corresponsal.codigoDeRespuesta == 0 ) {
			var nombreCadena = $("#nombreCadena").html();
			var totalCorresponsales = corresponsal.id.length;
			var corresponsales = "<div>";
			corresponsales += "<div style=\"text-align:center;\">";
			corresponsales += "<span>";
			corresponsales += corresponsal.id.length;
			corresponsales += "</span>";
			corresponsales += " Corresponsales - ";
			corresponsales += "<span>";
			corresponsales += nombreCadena;
			corresponsales += "</span>";
			corresponsales += "<br />";
			corresponsales += "</div>";
			corresponsales += "<div style=\"text-align:center;\">";
			corresponsales += "<span>";
			corresponsales += "<a href=\"#\" onclick=\"downloadExcelListaCorresponsales('"+idCadena+"', '"+idSubCadena+"', '"+nombreCadena+"', '"+totalCorresponsales+"')\">";
			corresponsales += "Descargar a Excel";
			corresponsales += "</a>";
			corresponsales += "</span>";
			corresponsales += "<br />";
			corresponsales += "<br />";
			corresponsales += "</div>";
			corresponsales += "</div>";
			corresponsales += "<table class='tablacentrada'>";	
			corresponsales += "<thead>";
			corresponsales += "<tr>";
			corresponsales += "<th>ID</th>";
			corresponsales += "<th>Nombre del Corresponsal</th>";
			corresponsales += "<th>Ver</th>";
			corresponsales += "</tr>";
			corresponsales += "</thead>";
			corresponsales += "<tbody>";
			for ( var i = 0; i < corresponsal.id.length; i++ ) {
				corresponsales += "<tr>";
				corresponsales += "<td>" + corresponsal.id[i] + "</td>";
				corresponsales += "<td>" + corresponsal.nombre[i] + "</td>";
				corresponsales += "<td class='centrado'>";
				corresponsales += "<a href=\"#\" onclick=\"GoCorresponsal(" + corresponsal.id[i] + ")\">";
				//corresponsales += "<img src=\"../../img/buscar.png\">";
				corresponsales += "<i class='fa fa-search'></i>";
				corresponsales += "</a>";
				corresponsales += "</td>";
				corresponsales += "</tr>";
			}
			corresponsales += "</tbody>";
			corresponsales += "</table>";
			$("#tablaReporte").html("");
			$("#tablaReporte").html(corresponsales);
		} else if ( corresponsal.codigoDeRespuesta == 1 ) {
			alert(corresponsal.mensajeDeRespuesta);	
		} else if ( corresponsal.codigoDeRespuesta == 2 ) {
			alert("Error: " + corresponsal.mensajeDeRespuesta);		
		}
	})	
}

function MetodoAjaxContactos3(url,parametros,tipoz,valorz){	
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			//div para  [cargando....]
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);
			
			if(RESserv[0] == 0){
				var parametros2 = "tipoCliente="+tipoz+"&idValor="+valorz;
				//BuscarParametros2("../../inc/Ajax/_Clientes/BuscaContactosClientes.php",parametros2,'divRES');
				Persiana(true);

				//alert(RESserv[1]);
				irAListado();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];
					
				alert("Error: "+RESserv[0]+"  "+RESserv[1]);
			}			
		} 
	}
	http.send(parametros+"&pemiso="+true);
}

function UpdateContactos(idCadSubCor,idTipoCliente){
	var NomC = txtValue("txtContacNom");
	if(NomC != ""){
		var apPC = txtValue("txtContacAP");
		if(apPC != ""){
			var apMC = txtValue("txtContacAM");
			if(apMC != ""){
				var telC = txtValue("txtTelContac");
				if(telC != "" && validaTelefono("txtTelContac")){
					
					var mailC = txtValue("txtMailContac");
					if(mailC != "" && validarEmail("txtMailContac")){
						var tipoC = txtValue("ddlTipoContac");
						if(tipoC > -1){

							var idContac = txtValue("HidContacto");
							var extension = txtValue("txtExtTelContac");
							var parametros = "id="+idCadSubCor+"&idContacto="+idContac+"&NomC="+NomC+"&apPC="+apPC+"&apMC="+apMC+"&telC="+telC+"&mailC="+mailC+"&tipoC="+tipoC+"&idTipoCliente="+idTipoCliente+"&extension="+extension;
							//alert(parametros);
			/*el 1 es para cadenas el 2 es para subcadenas y el 3 para corresponsales PARA LAS BUSQUEDAS DE CONTACTOS*/
							MetodoAjaxContactos3("../../inc/Ajax/_Clientes/UpdateContactosClientes.php",parametros,idTipoCliente,idCadSubCor);
					
						}else{alert("Favor de seleccionar un Tipo de Contacto");}	
					}else{alert("Favor de escribir un correo valido para el Contacto");}	
				}else{alert("Favor de escribir un telefono valido para el Contacto");}	
			}else{alert("Favor de escribir un apellido materno para el Contacto");}	
		}else{alert("Favor de escribir un apellido paterno para el Contacto");}	
	}else{alert("Favor de escribir un nombre de Contacto");}
}

function DeleteContactos3(idCliente,idContacto,tipoCliente){
	if(confirm('\u00BFDesea Eliminar el Contacto?')){
		var parametros = "tipoCliente="+tipoCliente+"&id="+idCliente+"&idContacto="+idContacto;
		MetodoAjaxContactos3("../../inc/Ajax/_Clientes/DeleteContacto.php",parametros,tipoCliente,idCliente);
	}
}

function RellenarTelefono() {
	if ( document.getElementById("txttel1") ) {
		if ( txtValue("txttel1") == '' ) {
			document.getElementById("txttel1").value = "52-";
			$("#txttel1").putCursorAtEnd();
		}
	}
	if ( document.getElementById("txttelefono") ) {
		if ( txtValue("txttelefono") == '' ) {
			document.getElementById("txttelefono").value = "52-";
			$("#txttelefono").putCursorAtEnd();
		}
	}
}

function editarDireccion( tipoDireccion, tipoConsulta, id ) {
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("paisID");
	if ( tipoDireccion == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipoDireccion == "extranjera" ) {
		var edo = txtValue("txtEstado");
		var ciudad = txtValue("txtMunicipio");
		var colonia = txtValue("txtColonia");
	}
	var  cp = txtValue("txtcp");
	var parametros = "f=0";	
	var caracterVacio = /^\s$/i;
	
	if ( pais != '' ) {
		if ( !pais.match(caracterVacio) ) {
			parametros += "&idpais="+pais;
		} else {
			alert("El Pa\u00EDs no puede estar vac\u00EDo");
			return false;
		}
	} else {
		alert("Falta llenar el Pa\u00EDs");
		return false;
	}	
	
	if ( calle != '' ) {
		if ( !calle.match(caracterVacio) ) {
			parametros += "&calle="+calle;
		} else {
			alert("La Calle no puede estar vac\u00EDa");
			return false;
		}
	} else {
		alert("Falta llenar la Calle");
		return false;
	}
		
	if ( !nint.match(caracterVacio) ) {
		parametros += "&nint="+nint;
	} else {
		alert("El N\u00FAmero Interior no puede estar vac\u00EDo");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El N\u00FAmero Exterior no puede estar vac\u00EDo");
			return false;
		}
	} else {
		alert("Falta llenar el N\u00FAmero Exterior");
		return false;
	}

	if ( cp != '' ) {
		if ( !cp.match(caracterVacio) ) {
			parametros += "&cp="+cp;
		} else {
			alert("El C\u00F3digo Postal no puede estar vac\u00EDo");
			return false;
		}
	} else {
		alert("Falta llenar el C\u00F3digo Postal");
		return false;
	}

	if ( colonia != '' ) {
		if ( colonia == '-1' ) {
			alert("Falta seleccionar Colonia");
			return false;
		}
		if ( !colonia.match(caracterVacio) ) {
			parametros += "&idcolonia="+colonia;
		} else {
			alert("La Colonia no puede estar vac\u00EDa");
			return false;
		}
	} else {
		alert("Falta llenar la Colonia");
		return false;
	}

	if ( edo != '' ) {
		if ( edo == '-2' ) {
			alert("Fala seleccionar Estado");
			return false;
		}
		if ( !edo.match(caracterVacio) ) {
			parametros += "&idestado="+edo;
		} else {
			alert("El Estado no puede estar vac\u00EDo");
			return false;
		}
	} else {
		alert("Falta llenar el Estado");
		return false;
	}
		
	if ( ciudad != '' ) {
		if ( ciudad == '-2' ) {
			alert("Falta seleccionar Ciudad");
			return false;
		}
		if ( !ciudad.match(caracterVacio) ) {
			parametros += "&idciudad="+ciudad;
		} else {
			alert("La Ciudad no puede estar vac\u00EDa");
			return false;
		}
	} else {
		alert("Falta llenar la Ciudad");
		return false;
	}
	
	parametros += "&tipodireccion=" + tipoDireccion;
	parametros += "&id=" + id;
	if ( tipoConsulta == 1 ) { //Cadena
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionCadena.php",parametros);
		window.setTimeout("irAListado()",100);
	} else if ( tipoConsulta == 2 ) { //Sub Cadena
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionSubCadena.php",parametros);
		window.setTimeout("irAListado()",100);
	}
	//window.setTimeout("Recargar()",100);	
}
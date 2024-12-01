var existenCambios = false;
var noEncontroColonias = true;

/*
** Funcion utilizada cuando se hace clic en el icono de autorizar en la lista de las precadenas
*/
function goToAutorizarCadena(idCadena){
	var inputs = {
		idCadena : idCadena
	}

	/* common-scripts.js */
	submitFormPost("Cadena/Autorizar.php", inputs);
}

function irAAutorizarCadena(idCadena){
	var inputs = {
		idCadena : idCadena
	}
	
	/* common-scripts.js */
	submitFormPost("Autorizar.php", inputs);
}

function AutoEjecutivoVenta(){
	if(Existe("txtejecutivoventa"))
		AutoCompletar("txtejecutivoventa","../../inc/Ajax/AutoEjecutivoVenta.php",2);
}

function AutoEjecutivoCuenta(){
	if(Existe("txtejecutivocuenta"))
		AutoCompletar("txtejecutivocuenta","../../inc/Ajax/AutoEjecutivoCuenta.php",3);
}

function AutoCalleDir2(){
	if(Existe("txtcalle"))
		AutoCompletar("txtcalle","../../inc/Ajax/AutoCalleDireccion.php",2);
}

function BuscarPreContactos(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactos.php",'','divRES');
}

function CambioPagina( i, existenCambios ) {
	var r;
	var botonGuardarEstaDeshabilitado = $("#guardarCambios").is(":disabled");
	if ( existenCambios && !botonGuardarEstaDeshabilitado ) {
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

function irAValidacion( idPreCadena ) {
	if ( idPreCadena != null && idPreCadena != "" ) {
		window.location = "Validar.php?id=" + idPreCadena;
	} else {
		alert("Error: No fue posible encontrar el ID de la Pre Cadena");	
	}
}

function irABusqueda() {
	window.location = "../PrealtaBuscarCadenas.php";	
}

function agregarPreContacto() {
	$("#datos-generales-contacto").slideDown("normal");
	$("#boton-nuevo-contacto").css("display", "none");
	$("#guardarCambios").prop("disabled", false);
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
							//parametros+="&mail="+mail;							
						}else{
							band = false;
							alert("El Correo Electr\u00F3nico es incorrecto");
						}
					}
				}else{
					band = false;
					alert("El n\u00FAmero de Tel\u00E9fono no es correcto");
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
	parametros +="&idgrupo="+grupo+"&idref="+ref+"&tel1="+tel1+"&mail="+mail;
	
	if(band){
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreCadena.php",parametros);
		window.setTimeout("Recargar()",100);
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

function VerificarGrls(){
	var permitirGuardarCambios = false;
	if(txtValue("ddlGrupo") > -1 && txtValue("ddlGrupo") != "") {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if(txtValue("ddlReferencia") > -1 && txtValue("ddlReferencia") != "") {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if (txtValue("txttel1") != '' && validaTelefono("txttel1")) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if(txtValue("txtmail") != '' && validarEmail('txtmail')) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txttel1") == '52-' ) {
		document.getElementById("txttel1").value = "";
	}
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
		}
	}
}

$(document).ready(function(){
	AutoEjecutivoVenta();
	AutoEjecutivoCuenta();
	AutoCalleDir2();
});

function VerificarDireccionCad( tipo, primeraCarga ) {
	var caracteresValidos = /^\d{5}$/i;
	var permitirGuardarCambios = false;
	if ( txtValue("txtcalle") != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txtnext") !=  '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( tipo == "nacional" ) {
		if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("paisID") > 0 ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("ddlColonia") > -1 ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( txtValue("txtnint") != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txtcp").match(caracteresValidos) ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( tipo == "extranjera" ) {
		if ( txtValue("txtColonia") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("txtEstado") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("txtMunicipio") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( permitirGuardarCambios && !primeraCarga ) {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
		}
	}
}

/**
* Permite cargar un Drop Down List con todas
* las ciudades basandose en la seleccion de
* algun pais. Tambien permite seleccionar
* una ciudad en particular por default.
* Parametro		paisID				ID del pais al que pertenecen
*									las ciudades que se quieren cargar.
* Parametro		listaID				ID del DIV HTML que contiene la lista
*									de ciudades que se quiere cargar.
* Parametro		estadoSeleccionado	Ciudad que se quiere seleccionar por
*									default. Si no hay ninguno entonces
*									poner un valor de -2 o aquel que corresponda
*									a la opcion generica por default.
* Parametro		disabled			Booleano que indica si la nueva lista debe
*									estar deshabilitada.
* Valor de retorno:	Un elemento SELECT HTML con las Ciudades. En caso de no
* encontrarlos se regresa un elemento SELECT HTML con un mensaje de Error.
* Autor:	Ing. Roberto Cortina
* Fecha de creacion:		7 de febrero de 2014
* Fecha de modificacion:	7 de febrero de 2014
**/
function cambiarCiudad( paisID, estadoID, listaID, ciudadSeleccionada, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/BuscaSelectCd.php', { "idpais": paisID, "idedo": estadoID } ).done(
		function( listaCiudades ) {
			if ( paisID == 164 ) {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					//$("#"+listaID).append( '<input type="text" style="display:none;" name="txtMunicipio" id="txtMunicipio" value="" />' );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					if ( disabled ) {
						$("#ddlMunicipio").prop("disabled", true);
					} else {
						$("#ddlMunicipio").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}
				}
			} else {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					$("#ddlMunicipio").css("display", "none");
					$("#txtMunicipio").css("display", "block");
					setValue("txtMunicipio", $("#ddlMunicipio option:selected").text());
					Bloquear("txtMunicipio");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}					
				}
			}
		}
	);
}

/**
* Permite cargar un Drop Down List con todos
* los estados basandose en la seleccion de
* algun pais. Tambien permite seleccionar
* un estado en particular por default.
* Parametro		paisID				ID del pais al que pertenecen
*									los estados que se quieren cargar.
* Parametro		listaID				ID del DIV HTML que contiene la lista
*									de estados que se quiere cargar.
* Parametro		estadoSeleccionado	Estado que se quiere seleccionar por
*									default. Si no hay ninguno entonces
*									poner un valor de -2 o aquel que corresponda
*									a la opcion generica por default.
* Parametro		disabled			Booleano que indica si la nueva lista debe
*									estar deshabilitada.
* Valor de retorno:	Un elemento SELECT HTML con los Estados. En caso de no
* encontrarlos se regresa un elemento SELECT HTML con un mensaje de Error.
* Autor:	Ing. Roberto Cortina
* Fecha de creacion:		7 de febrero de 2014
* Fecha de modificacion:	7 de febrero de 2014
**/
function cambiarEstado( paisID, listaID, estadoSeleccionado, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/CambioEstado.php', { "idpais": paisID } ).done(
		function( listaEstados ) {
			if ( paisID == 164 ) {
				if ( listaEstados != null || listaEstados != '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					if ( disabled ) {
						$("#ddlEstado").prop("disabled", true);
					} else {
						$("#ddlEstado").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}
				}
			} else {
				if ( listaEstados != null || listaEstados == '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					$("#ddlEstado").css("display", "none");
					$("#txtEstado").css("display", "block");
					setValue("txtEstado", $("#ddlEstado option:selected").text());
					Bloquear("txtEstado");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}					
				}
			}
		}
	);
}

function buscarColonias() {
	if ( tipoDireccion == "nacional" ) {
		var codigoPostal = $("#txtcp").val();
		var caracteresValidos = /^\d{5}$/i;
		var maxlength = $("#txtcp").attr("maxlength");
		if ( codigoPostal.length < maxlength ) {
			noEncontroColonias = true;
		}
		if ( codigoPostal != '' && codigoPostal != null ) {
			if ( codigoPostal.match(caracteresValidos) ) {
				$.post( '../../inc/Ajax/_Clientes/buscarColonia.php', { "codigoPostal": codigoPostal } ).done(
					function(data) {
						var colonia = jQuery.parseJSON( data );
						if ( colonia.codigoDeRespuesta == 0 ) {
							var option = [];
							option.push('<option value="-1" selected="selected">Seleccione colonia</option>');
							for ( var i = 0; i < colonia.idColonia.length; i++ ) {
								option.push( '<option value="' + colonia.idColonia[i] + '">' + colonia.nombre[i] + '</option>' );
							}
							$("#ddlColonia").html(option.join(''));
							$("#ddlColonia").prop( "disabled", false );
							$("#ddlEstado").attr( "value", colonia.idEntidad );
							$("#ddlMunicipio").attr( "value", colonia.idCiudad );
							cambiarCiudad( 164, colonia.idEntidad, 'divCd', colonia.idCiudad, true, "PreCadena" );
							cambiarEstado( 164, 'divCd', colonia.idEntidad, true, true, "PreCadena" );
							noEncontroColonias = true;
							window.setTimeout("VerificarDireccionCad(tipoDireccion)",100);
						} else {
							if ( $("#txtcp").val().length == maxlength && noEncontroColonias ) {
								noEncontroColonias = false;
								alert(colonia.mensajeDeRespuesta);
							}
						}			
				} );					
			} else {
				var option = [];
				$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
				$("#ddlColonia").prop( "disabled", true );
				$("#ddlMunicipio").val('');
				$("#ddlEstado").val('');
			}
	}
	} else {
		var option = [];
		$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
		$("#ddlColonia").prop( "disabled", true );
	}		
}

function CrearDirPreCadena( tipo ) {
	var calle = txtValue("txtcalle");
	var nint = txtValue("txtnint");
	var next = txtValue("txtnext");
	var pais = txtValue("paisID");
	if ( tipo == "nacional" ) {
		var edo = txtValue("ddlEstado");
		var ciudad = txtValue("ddlMunicipio");
		var colonia = txtValue("ddlColonia");
	} else if ( tipo == "extranjera" ) {
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
	
	parametros += "&tipodireccion=" + tipo;
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreCadena.php",parametros);
	window.setTimeout("Recargar()",100);
}

function cambiarPantalla() {
	var pais = txtValue('paisID');
	var coloniaDisplay = document.getElementById('ddlColonia').style.display;
	var estadoDisplay = document.getElementById('ddlEstado').style.display;
	var ciudadDisplay = document.getElementById('ddlMunicipio').style.display;
	if ( pais != 164 && pais != "" ) {
		if ( coloniaDisplay != 'none' ) {
			document.getElementById('ddlColonia').style.display = 'none';
		}
		if ( estadoDisplay != 'none' ) {
			document.getElementById('ddlEstado').style.display = 'none';
		}
		if ( ciudadDisplay != 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'none';
		}		
		document.getElementById('txtColonia').style.display = 'block';
		document.getElementById('txtEstado').style.display = 'block';
		document.getElementById('txtMunicipio').style.display = 'block';
		tipoDireccion = "extranjera";
	} else if ( pais == 164 && pais != "" ) {
		if ( coloniaDisplay == 'none' ) {
			document.getElementById('ddlColonia').style.display = 'block';
		}
		if ( estadoDisplay == 'none' ) {
			document.getElementById('ddlEstado').style.display = 'block';
		}
		if ( ciudadDisplay == 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'block';
		}		
		document.getElementById('txtColonia').style.display = 'none';
		document.getElementById('txtEstado').style.display = 'none';
		document.getElementById('txtMunicipio').style.display = 'none';
		document.getElementById('txtcp').value = '';
		tipoDireccion = "nacional";
	}
}

function EditarPreContacto(id,x,t){
	if(x == 0){
		precontid = id;
		var url = "../../inc/Ajax/_Clientes/EdPreContacto.php";
		if(t >= 0){
			
			if(t == 0)
				url = "../../inc/Ajax/_Clientes/EdPreContacto.php";
			if(t == 1)
				url = "../../inc/Ajax/_Clientes/EdPreContactoSubCadena.php";
			if(t == 2)
				url = "../../inc/Ajax/_Clientes/EdPreContactoCorresponsal.php";
			
			http.open("POST",url, true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
			http.onreadystatechange=function() 
			{ 
				if (http.readyState==1)
				{
					//div para  [cargando....]
					//Emergente();
				}
				if (http.readyState==4)
				{
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);
					var valores = RespuestaServidor.split(",");
					document.getElementById("txtnombre").value = valores[0];
					document.getElementById("txtpaterno").value = valores[1];
					document.getElementById("txtmaterno").value = valores[2];
					document.getElementById("txttelefono").value = valores[3];
					document.getElementById("txtext").value = valores[4];
					document.getElementById("txtcorreo").value = valores[5];
					document.getElementById("ddlTipoContacto").value = valores[6];
					//OcultarEmergente();
					$("#datos-generales-contacto").slideDown("normal");
					$("#boton-nuevo-contacto").css('display', 'none');
					$("#guardarCambios").prop("disabled", false);
				} 
			}
			http.send("id="+id);
		}
	}else{
		var nombre = txtValue("txtnombre");
		var paterno = txtValue("txtpaterno");
		var materno = txtValue("txtmaterno");
		var telefono = txtValue("txttelefono");
		var ext = txtValue("txtext");
		var correo = txtValue("txtcorreo");
		var tipocontacto = txtValue("ddlTipoContacto");
		var parametros = "id="+precontid;
		if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
			if(validaTelefono("txttelefono")){
				if(validarEmail("txtcorreo")){
					parametros+= "&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContacto.php",parametros);
					window.setTimeout("LimpiarPreContactos(false)",40);
					window.setTimeout("BuscarPreContactos()",100);
					$("#boton-nuevo-contacto").css('display', 'block');
					$("#guardarCambios").prop("disabled", true);
				}else{
					alert("El Correo Electr\u00D3nico es incorrecto");
				}
			}else{
				alert("El Tel\u00E9fono es incorrecto");
			}
		}else{
			alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
		}
	}	
}

function EliminarPreContacto(id){
	if(confirm("\u00BFEsta seguro de eliminar el contacto?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreContacto.php","id="+id)
		window.setTimeout("BuscarPreContactos()",100);
	}
}

var bandedcont = 0;
function DesPreContactos(id){
	if(bandedcont == 0)
		AgregarPreContactos();
	if(bandedcont == 1)
		EditarPreContacto(id,1);
}

function LimpiarPreContactos(value){
	document.getElementById("txtnombre").value = "";
	document.getElementById("txtpaterno").value = "";
	document.getElementById("txtmaterno").value = "";
	document.getElementById("txttelefono").value = "";
	document.getElementById("txtext").value = "";
	document.getElementById("txtcorreo").value = "";
	document.getElementById("ddlTipoContacto").value = -1;
	bandedcont = 0;
	if ( value ) {
		$('#datos-generales-contacto').slideDown('normal');
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
		}
	} else {
		$('#datos-generales-contacto').slideUp('normal');
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
		}
		if ( document.getElementById("boton-nuevo-contacto") ) {
			$("#guardarCambios").prop("disabled", true);
		}
	}
}

function VerificaContAd(){
	if(contad == 0){
		window.setTimeout("LimpiarPreContactos(false)",40);
		window.setTimeout("BuscarPreContactos()",100);
	}
}

function AgregarPreContactos(){
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var telefono = txtValue("txttelefono");
	var ext = txtValue("txtext");
	var correo = txtValue("txtcorreo");
	var tipocontacto = txtValue("ddlTipoContacto");
	var parametros = "";
	if(nombre != '' && paterno != '' && materno != '' && telefono != '' && correo != '' && txtValue("ddlTipoContacto") > -1){
		if(validaTelefono("txttelefono")){
			if(validarEmail("txtcorreo")){
				parametros += "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContacto.php",parametros);
				$("#boton-nuevo-contacto").css('display', 'block');
				window.setTimeout("VerificaContAd()",100);
				
			}else{
				alert("El Correo El\u00E9ctronico es incorrecto");
			}
			
		}else{
			alert("El Tel\u00E9fono es incorrecto");	
		}
	}else{
		alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)");
	}
}

function VerificarContactos() {
	if( txtValue("txtnombre") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("txtpaterno") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("txtmaterno") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("txttelefono") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("txtext") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("txtcorreo") != "" ) {
		existenCambios = true;	
	}
	if( txtValue("ddlTipoContacto") > -1 ) {
		existenCambios = true;	
	}
}

function verificarEjecutivos() {
	/*if ( txtValue('txtejecutivoventa') == '' && txtValue('txtejecutivocuenta') == '' ) {
		if ( document.getElementById('guardarCambios') ) {
			$("#guardarCambios").prop("disabled", true);
			existenCambios = false;
		}
	} else {
		if ( document.getElementById('guardarCambios') ) {
			$("#guardarCambios").prop("disabled", false);
			existenCambios = true;
		}			
	}*/
	if ( document.getElementById('guardarCambios') ) {
		$("#guardarCambios").prop("disabled", false);
		existenCambios = true;
	}
}

function Recargar(){
	window.location.reload();
}

function EditarEjecutivosPreCadena(){
	
	var parametros = "f=0";
	var ejecutivoVenta = $("#txtejecutivoventa").val();
	var ejecutivoCuenta = $("#txtejecutivocuenta").val();
	
	if(sel3 > -1){
		parametros+="&idecuenta="+sel3;
	} else if ( ejecutivoCuenta == "" || ejecutivoCuenta == null ) {
		parametros+="&idecuenta=-500";	
	}
	if(sel2 > -1){
		parametros+="&ideventa="+sel2;
	} else if ( ejecutivoVenta == "" || ejecutivoVenta == null ) {
		parametros+="&ideventa=-500";
	}
	
	//if ( sel3 > -1 || sel2 > -1 ) {
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarEjecutivosPreCadena.php",parametros);
		window.setTimeout("Recargar()",100);
	//} else {
		//alert("Falta seleccionar Ejecutivos");
	//}
	
}

function EliminarPreCadena2(id){
	if(confirm("\u00BFEsta seguro de eliminar la Pre Cadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCadena.php","id="+id);
		window.setTimeout("Recargar()",100);
	}
}

function PreValidarSeccionesPreCadena(){
	var cargos = document.getElementById("chkcargos").checked ? 1 : 0;
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var ejecutivos = document.getElementById("chkejecutivos").checked ? 1 : 0;
	var permitirGuardarCambios = false;
	
	parametros = "generales="+generales+"&direccion="+direccion+"&contactos="+contactos+"&ejecutivos="+ejecutivos+"&cargos="+cargos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/PreRevisarSeccionesPreCadena.php",parametros);
	
	if ( generales && direccion && contactos && ejecutivos && cargos ) {
		permitirGuardarCambios = true;
	}
	
	if ( permitirGuardarCambios ) {
		if ( document.getElementById("validarCambios") ) {
			$("#validarCambios").prop("disabled", false);
		}
	} else {
		if ( document.getElementById("validarCambios") ) {
			$("#validarCambios").prop("disabled", true);
		}
	}	
}

function agregarConcepto() {
	var tipoConcepto = $("#ddlConcepto").val();
	var importe = $("#txtImporte").val();
	var importeAux = parseFloat(importe);
	if ( importeAux != 0 ) {
		importe = importe.replace(/^0+/, '');
	} else {
		importe = 0.00;	
	}
	var fechaInicio = $("#txtFecha").val();
	var observaciones = $("#txtObservaciones").val();
	var tipo = $("#ddlTipo").val();
	var cadenaID = $("#cadenaID").val();
	var parametros = "";
	
	var fechaActual = new Date();
	var anoFechaInicio = parseInt(fechaInicio.split("/")[2]);
	var mesFechaInicio = parseInt(fechaInicio.split("/")[0]);
	mesFechaInicio = mesFechaInicio - 1;
	var diaFechaInicio = parseInt(fechaInicio.split("/")[1]);
	var fechaInicioCargo = new Date();
	fechaInicioCargo = fechaInicioCargo.setFullYear(anoFechaInicio, mesFechaInicio, diaFechaInicio);
	var seAgrega = true;
	var idPreCargo = $("#idPreCargo").val();
	
	if ( idPreCargo != "" && idPreCargo != null ) {
		seAgrega = false;
	}
	
	if ( !(fechaInicioCargo >= fechaActual) ) {
		alert("La Fecha Inicio tiene que ser una fecha posterior al d\u00EDa de hoy");
		return false;
	}
	
	if ( tipoConcepto <= 0 ) {
		alert("Falta seleccionar un Tipo de Concepto");
		return false;
	}
	if ( importe.length == 0 ) {
		alert("Falta escribir un Importe");
		return false;
	}
	if ( importe < 0.00 ) {
		alert("El Importe debe ser mayor a cero");
		return false;			
	}	
	/*if ( importe < 0.00 ) {
		if ( importe == null || importe == "" ) {
			alert("Falta escribir un Importe");
			return false;
		}
	}*/	
	if ( fechaInicio == null || fechaInicio == "" ) {
		alert("Falta seleccionar una Fecha");
		return false;
	}
	if ( observaciones == null || observaciones == "" ) {
		alert("Falta escribir Observaciones");
		return false;
	}
	if ( tipo == null || tipo == "" ) {
		alert("Falta seleccionar un Tipo");
		return false;
	}
	if ( cadenaID == null || cadenaID == "" ) {
		alert("Error: No pudo cargarse el ID de la Cadena");
		return false;
	}
	
	if ( seAgrega ) {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID;
		
		$.post( "../../inc/Ajax/_Clientes/agregarPreCargoPreCadena.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID );
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);
	} else {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID + "&idPreCargo=" + idPreCargo;
		
		$.post( "../../inc/Ajax/_Clientes/editarPreCargoPreCadena.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID, "idPreCargo": idPreCargo },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID );
					$("#idPreCargo").val("");
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);		
	}
}

function editarCargo( idPreCargo ) {
	var nombreConcepto = $("#nombreConcepto-"+idPreCargo).val();
	var importe = $("#importe-"+idPreCargo).val();
	var fechaInicio = $("#fechaInicio-"+idPreCargo).val();
	fechaInicio = fechaInicio.split("-");
	anoFechaInicio = fechaInicio[0];
	mesFechaInicio = fechaInicio[1];
	diaFechaInicio = fechaInicio[2];
	fechaInicio = mesFechaInicio + "/" + diaFechaInicio + "/" + anoFechaInicio;	
	var observaciones = $("#observaciones-"+idPreCargo).val();
	var configuracion = $("#configuracion-"+idPreCargo).val();
	
	$("#ddlConcepto").val(nombreConcepto);
	$("#txtImporte").val(importe);
	$("#txtFecha").val(fechaInicio);
	$("#txtObservaciones").val(observaciones);
	$("#ddlTipo").val(configuracion);
	$("#idPreCargo").val(idPreCargo);
	$("#botonAgregar").text("Guardar");
}

function prepararCamposCargo() {
	$("#ddlConcepto").val(-1);
	$("#txtImporte").val("");
	$("#txtFecha").val("");
	$("#txtObservaciones").val("");
	$("#botonAgregar").text("Agregar");
}

function actualizarCargos( cadenaID ) {
	$.post( "../../inc/Ajax/_Clientes/getAfiliaciones.php", { "cadenaID": cadenaID },
	function( data ) {
		$("#wrapperAfiliaciones").html(data);
	}, "html" );
}

function eliminarCargo( idPreCargo, cadenaID ) {
	$.post( "../../inc/Ajax/_Clientes/eliminarPreCargo.php", { "cadenaID": cadenaID, "idPreCargo": idPreCargo },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			actualizarCargos( cadenaID );	
		} else {
			alert( resultado[1] );
		}
	}, "html" );
}

function validar() {
	var cargos = document.getElementById("chkcargos").checked ? 1 : 0;
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var ejecutivos = document.getElementById("chkejecutivos").checked ? 1 : 0;
	var cadenaID = $("#cadenaID").val();
	
	$.post( "../../inc/Ajax/_Clientes/RevisarSeccionesPreCadena.php",
	{ "cargos": cargos, "generales": generales, "direccion": direccion, "contactos": contactos, "ejecutivos": ejecutivos },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			window.location = "Validar1.php?id=" + cadenaID;
		} else {
			alert( resultado[1] );
		}		
	}, "html" );
}

function irAValidacion() {
	var cadenaID = document.getElementById('idCadena').value;
	if ( cadenaID != null && cadenaID != "" ) {
		window.location = "Validar.php?id=" + cadenaID;
	} else {
		alert("No es posible enviar a Validaci\u00F3n. No pudo cargarse el ID de la Pre Cadena.");	
	}	
}
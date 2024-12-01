var existenCambios = false;

/*
** Funcion utilizada cuando se hace clic en el icono de autorizar en la lista de las precadenas
*/
function goToAutorizarSubCadena(idSubCadena){
	var inputs = {
		idSubCadena : idSubCadena
	}

	/* common-scripts.js */
	submitFormPost("SubCadena/Autorizar.php", inputs);
}

function AutoCalleDir2(){
	if(Existe("txtcalle"))
		AutoCompletar("txtcalle","../../inc/Ajax/AutoCalleDireccion.php",2);
}

function BuscarPreContactos(){
	BuscarParametros2("../../inc/Ajax/_Clientes/BuscarPreContactosSubCadena.php",'','divRES');
}

function irAAutorizarSubCadena(idSubCadena){
	var inputs = {
		idSubCadena : idSubCadena
	}

	/* common-scripts.js */
	submitFormPost("Autorizar.php", inputs);
}

function CambioPagina( i, existenCambios ) {
	var r;
	var botonGuardarEstaDeshabilitado = $("#guardarCambios").is(":disabled");
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
				window.location = "Crear5.php";
			break;
			case 6:
				window.location = "Crear6.php";
			break;
			case 7:
				window.location = "Crear7.php";
			break;
			case 8:
				window.location = "Crear8.php";
			break;
		}
	}
}

$(document).ready(function(){
	AutoCalleDir2();
	//AutoEjecutivoVenta();
	//AutoEjecutivoCuenta();
	if ( $("input[name='version']").length ) {
		$("input[name='version']").data("last-value", $("input[name='version']").val())
		$("input[name='version']").click(function() {
			var ultimoValor = $(this).data("last-value");
			var value = $(this).val();
			//if ( ultimoValor != value ) {
				if ( $("#guardarCambios").length ) {
					existenCambios = true;
					$("#guardarCambios").prop("disabled", false);
				}
			//}								  
		});
	}
	/*if ( $("#txtCLABE").length ) {
		$("#txtCLABE").bind( "paste", function() {
			setTimeout( function() {
				analizarCLABE();
			}, 100);
			analizarCLABE();									  
		});
	}*/
});

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

function VerificarGrlsSub(){
	var permitirGuardarCambios = false;
	if ( txtValue("txtNombreCadena") != '' && txtValue("cadenaID") > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("ddlGrupo") > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("ddlReferencia") > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txttel1") != '' && validaTelefono("txttel1") ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( validarEmail("txtmail") ) {
		permitirGuardarCambios = true;
		existenCambios = true;
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

function EditarGrlsPreSubCadena(){
	var idcadena = txtValue("cadenaID");
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var mail = txtValue("txtmail");
	var band = true;
	var parametros = "idcadena="+idcadena;
	
	if(txtValue("txtNombreCadena") != '' && idcadena > -1 && idcadena != ''){
			if(grupo > -1){
				parametros+="&idgrupo="+grupo;
				if(ref > -1){
					parametros+="&idref="+ref;
					if(tel1 != ''){
						if(validaTelefono("txttel1")){
							parametros+="&tel1="+tel1;
						}else{
							band = false;
							alert("El Tel\u00E9fono es incorrecto");
						}
					}
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
					alert("Favor de seleccionar la Referencia de la Pre Sub Cadena");	
				}
			}else{
				band = false;
				alert("Error: La Cadena no est\u00E1 asociada a ning\u00FAn Grupo.");
			}
		if ( band ) {
			MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreSubCadena.php",parametros);
			window.setTimeout("Recargar()",100);
		}	
	}else{
		alert("Favor de seleccionar una Cadena");
	}	
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
							cambiarCiudad( 164, colonia.idEntidad, 'divCd', colonia.idCiudad, true, "PreSubCadena" );
							cambiarEstado( 164, 'divCd', colonia.idEntidad, true, true, "PreSubCadena" );
							noEncontroColonias = true;
							window.setTimeout("VerificarDireccionSub(tipoDireccion)",100);
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

function CrearDirPreSubCadena( tipo ){
	var permitirGuardarCambios = true;
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
		alert("El Número Interior no puede estar vac\u00EDo");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El Número Exterior no puede estar vac\u00EDo");
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
			alert("Falta seleccionar Estado");
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
	MetodoAjax2("../../inc/Ajax/_Clientes/EditarDireccionPreSubCadena.php",parametros);
	window.setTimeout("Recargar()",100);
}

function VerificarDireccionSub( tipo ){
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
function cambiarColonia( paisID, estadoID, ciudadID, listaID, coloniaSeleccionada, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/BuscaSelectColonias.php', { "idpais": paisID, "idedo": estadoID, "idcd": ciudadID } ).done(
		function( listaColonias ) {
			if ( paisID == 164 ) {
				if ( listaColonias != null || listaColonias != '' ) {
					$("#ddlColonia").replaceWith( listaColonias );
					$("#ddlColonia").val(coloniaSeleccionada);
					if ( disabled ) {
						$("#ddlColonia").prop("disabled", true);
					} else {
						$("#ddlColonia").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				}
			} else {
				if ( listaColonias != null || listaColonias != '' ) {
					$("#ddlColonia").replaceWith( listaColonias );
					$("#ddlColonia").val(coloniaSeleccionada);
					$("#ddlColonia").css("display", "none");
					$("#txtColonia").css("display", "block");
					setValue("txtColonia", $("#ddlColonia option:selected").text());
					Bloquear("txtColonia");
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

function agregarPreContacto() {
	$("#datos-generales-contacto").slideDown("normal");
	$("#boton-nuevo-contacto").css("display", "none");
	$("#guardarCambios").prop("disabled", false);
}

var bandedcont = 0;
function DesPreContactos(id){
	if(bandedcont == 0)
		AgregarPreContactos();
	if(bandedcont == 1)
		EditarPreContacto(id,1);
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
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContactoSubCadena.php",parametros);
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

function EditarPreContacto(id,x,t){
	if(x == 0){
		precontid = id;
		var url = "../../inc/Ajax/_Clientes/EdPreContactoSubCadena.php";
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
					var RespuestaServidor = http.responseText;
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
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContactoSubCadena.php",parametros);
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
		existenCambios = false;
		window.setTimeout("LimpiarPreContactos(false)",40);
		window.setTimeout("BuscarPreContactos()",100);
	}
}

function Recargar(){
	window.location.reload();
}

function EliminarPreContacto(id){
	if(confirm("\u00BFEsta seguro de eliminar el contacto?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreContactoSubCadena.php","id="+id)
		window.setTimeout("BuscarPreContactos()",100);
	}
}

function EliminarPreSubCadena2(id){
	if(confirm("\u00BFEsta seguro de eliminar la Pre Sub Cadena?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreSubCadena.php","id="+id);
		window.setTimeout("Recargar()",100);
	}
}

function VerificarContrato(){
	var permitirGuardarCambios = false;
	if(txtValue("txtrfc") != '') {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if(txtValue("txtrazon") !=  '') {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if(txtValue("txtfecha") !=  '') {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if(txtValue("ddlRegimen") > -1) {
		permitirGuardarCambios = true;
		existenCambios = true;
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

function verificarRepresentanteLegal() {
	var permitirGuardarCambios = false;
	if ( txtValue('txtnombre') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('txtpaterno') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('txtmaterno') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('txtnumiden') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('ddlTipoIden') > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('txtrrfc') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue('txtcurp') != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
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

function mostrarDatosPersonaMoral() {
	var tipoDePersona = txtValue("ddlRegimen");
	if ( tipoDePersona == 1 ) {
		$("#txtrazon").css('visibility', 'hidden');
		$("#labelRazonSocial").css('visibility', 'hidden');
		$("#txtfecha").css('visibility', 'hidden');
		$("#txtfecha").prop('disable', true);
		$("#labelConstitucion").css('visibility', 'hidden');
		$("#textoSeleccionarFecha").css('visibility', 'hidden');
		$("#txtrrfc").css('visibility', 'hidden');
		$("#labelRepLegalRFC").css('visibility', 'hidden');
		$("#txtrfc").attr("maxlength", "13");
		$("#txtrrfc").attr("maxlength", "13");
	} else if ( tipoDePersona == 2 ) {
		$("#txtrazon").css('visibility', 'visible');
		$("#labelRazonSocial").css('visibility', 'visible');
		$("#txtfecha").css('visibility', 'visible');
		$("#txtfecha").prop('disable', false);
		$("#labelConstitucion").css('visibility', 'visible');
		$("#textoSeleccionarFecha").css('visibility', 'visible');
		$("#txtrrfc").css('visibility', 'visible');
		$("#labelRepLegalRFC").css('visibility', 'visible');
		$("#txtrfc").attr("maxlength", "12");	
	}
}

function CheckDirGral( tipoAlta, tipoDir )
{
	var isChecked = document.getElementById("chkDirGral").checked;
	if ( isChecked ) {
		var urlAjax = "";
		if ( tipoAlta == "PreSubCadena" ) {
			urlAjax = "../../inc/Ajax/_Clientes/PreCargarDireccionPreSubCadena.php";
		} else if ( tipoAlta == "PreCorresponsal" ) {
			urlAjax = "../../inc/Ajax/_Clientes/PreCargarDireccionPreCorresponsal.php";
		}
		$.post( urlAjax ).done(
			function( data ) {
				var direccion = jQuery.parseJSON( data );
				if ( direccion.codigoDeRespuesta == 0 ) {
					$("#txtcalle").val(direccion.calle);
					$("#txtnext").val(direccion.numeroExterior);
					$("#txtnint").val(direccion.numeroInterior);
					$("#paisID").val(direccion.pais);
					$("#txtPais").val(direccion.nombrePais);
					if ( direccion.pais == 164 ) {
						tipoDireccion = "nacional";
						tipoDir = "nacional";
						$("#txtColonia").css("display", "none");
						$("#txtEstado").css("display", "none");
						$("#txtMunicipio").css("display", "none");
					} else {
						tipoDireccion = "extranjera";
						tipoDir = "extranjera";
					}
					cambiarEstado( direccion.pais, 'selectestados', direccion.estado, true, tipoAlta, tipoDir );
					cambiarCiudad( direccion.pais, direccion.estado, 'divCd', direccion.ciudad, true, tipoAlta, tipoDir );
					cambiarColonia( direccion.pais, direccion.estado, direccion.ciudad, 'divCol', direccion.colonia, true, tipoAlta, tipoDir );
					$("#txtcp").val(direccion.codigoPostal);
					Bloquear("txtPais");
					Bloquear("txtcalle");
					Bloquear("txtnext");
					Bloquear("txtnint");
					Bloquear("txtcp");
					Bloquear("paisID");
					Bloquear("ddlColonia");
					Bloquear("ddlMunicipio");
					Bloquear("ddlEstado");					
					if ( tipoAlta == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipoAlta == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				} else {
					alert(direccion.mensajeDeRespuesta);
					$("#chkDirGral").attr("checked", false);
					Desbloquear("txtPais");
					Desbloquear("txtcalle");
					Desbloquear("txtnext");
					Desbloquear("txtnint");
					Desbloquear("ddlColonia");
					Desbloquear("txtcp");
					Desbloquear("paisID");
					setValue("txtPais", "");
					setValue("txtcalle","");
					setValue("txtnext","");
					setValue("txtnint","");
					setValue("txtcp","");
					setValue("ddlColonia",-1);
					setValue("ddlMunicipio",-2);
					setValue("ddlEstado",-2);
					setValue("paisID",-2);
					if ( tipoDir == "nacional" ) {
						vaciarCiudades("divCd");
						vaciarColonias("divCol");
					} else if ( tipoDir == "extranjera" ) {
						setValue("txtColonia", "");
						setValue("txtEstado", "");
						setValue("txtMunicipio", "");
					}
					Bloquear("ddlMunicipio");
					if ( tipoAlta == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipoAlta == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					}
				}
			}
		);
		
	} else {
		var txtColoniaDisplay = $("#txtColonia").css("display");
		var txtEstadoDisplay = $("#txtEstado").css("display");
		var txtMunicipioDisplay = $("#txtMunicipio").css("display");
		Desbloquear("txtPais");
		Desbloquear("txtcalle");
		Desbloquear("txtnext");
		Desbloquear("txtnint");
		Desbloquear("ddlColonia");
		Desbloquear("txtcp");
		Desbloquear("paisID");
		Desbloquear("txtColonia");
		Desbloquear("txtEstado");
		Desbloquear("txtMunicipio");
		if ( tipoAlta == "PreSubCadena" ) {
			VerificarDireccionSub(tipoDir);
		} else if ( tipoAlta == "PreCorresponsal" ) {
			VerificarDireccionCorr(tipoDir);
		}
	}
}

function vaciarCiudades( listaID ) {
	var listaCiudades = "<select name=\"ddlMunicipio\" id=\"ddlMunicipio\" class=\"form-control m-bot15\" title=\"Favor de selecionar un Edo. antes\">";
	listaCiudades += "<option value='-2'>Seleccione una Ciudad</option>";
	listaCiudades += "</select>";
	$("#ddlMunicipio").replaceWith(listaCiudades);	
}

function vaciarColonias( listaID ) {
	var listaColonias = "<select name=\"ddlColonia\" id=\"ddlColonia\" class=\"form-control m-bot15\"";
	listaColonias += "onchange=\"VerificarDireccionSub(tipoDireccion);\"";
	listaColonias += "style=\"display:block;\">";
	listaColonias += "<option value='-1'>Seleccione una Colonia</option>";
	listaColonias += "</select>";
	$("#ddlColonia").replaceWith(listaColonias);
}

function EditarContratoSubCadena( tipo ){
	var rfc = txtValue("txtrfc");
	var rsocial = document.getElementById("txtrazon").value;
	var fconst = txtValue("txtfecha");
	var regimen = txtValue("ddlRegimen");
	var parametros = "f=0";
	var band = false;
	
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

	var cp = txtValue("txtcp");
	var parametros = "f=0";
	
	var nombre = txtValue("txtnombre");
	var paterno = txtValue("txtpaterno");
	var materno = txtValue("txtmaterno");
	var numiden = txtValue("txtnumiden");
	var tipoiden = txtValue("ddlTipoIden");
	var rrfc = txtValue("txtrrfc");
	var curp = txtValue("txtcurp");
	var figura = (document.getElementById("chkfigura").checked) ? 0 : 1;
	var familia = (document.getElementById("chkfamilia").checked) ? 0 : 1;
	
	var dirGral = (document.getElementById("chkDirGral").checked) ? "false" : "true";
	
	if ( nombre.match(".*\\.\\..*") ) {
		alert("El nombre del Representante Legal no puede contener dos o m\u00E1s puntos consecutivos.");
		return false;
	} else if ( paterno.match(".*\\.\\..*") ) {
		alert("El apellido paterno del Representante Legal no puede contener dos o m\u00E1s puntos consecutivos.");
		return false;
	} else if ( materno.match(".*\\.\\..*") ) {
		alert("El apellido materno del Representante Legal no puede contener dos o m\u00E1s puntos consecutivos.");
		return false;
	}
	
	if ( regimen == 1 ) {
		if ( $("#txtrfc").val().length != 13 ) {
			alert("La longitud del RFC en la secci\u00F3n de Datos Generales es incorrecta.\nCuando el R\u00E9gimen es persona f\u00EDsica debe ser de 13 caracteres. Ejemplo: VECJ880326XXX");
			band = false;
			return false;
		}
	} else if ( regimen == 2 ) {
		if ( $("#txtrfc").val().length != 12 ) {
			alert("La longitud del RFC en la secci\u00F3n de Datos Generales es incorrecta.\nCuando el R\u00E9gimen es persona moral debe ser de 12 caracteres. Ejemplo: ABC680524P76");
			band = false;
			return false;
		}
	}
	
	if(validaRFC("txtrfc")){
		parametros+="&rfc="+rfc;
		if(regimen != ''){
			parametros+="&regimen="+regimen;
			band = true;
		}else{
			alert("Favor de seleccionar un R\u00E9gimen");
			return false;
		}
		if ( regimen == 2 ) {
			if(rsocial != ''){
				parametros+="&rsocial="+rsocial;
				if(fconst != ''){
					parametros+="&fconstitucion="+fconst;
				}else{
					alert("Favor de seleccionar una Fecha de Constituci\u00F3n");
					return false;
				}
			}else{
				alert("Favor de escribir una Raz\u00F3n Social");
				return false;
			}
		}
		if ( regimen == 1 ) {
			rsocial = nombre + " " + paterno + " " + materno;
			parametros += "&rsocial=" + rsocial;
		}
	}else{
		alert("El RFC es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
		return false;
	}
	
	if(calle != '')
		parametros+="&calle="+calle;
	if(nint != '')
		parametros+="&nint="+nint;
	if(next != '')
		parametros+="&next="+next;
	if(pais != '')
		parametros+="&idpais="+pais;
	if(edo != '')
		parametros+="&idestado="+edo;
	if(ciudad != '')
		parametros+="&idciudad="+ciudad;
	if(colonia != '')
		parametros+="&idcolonia="+colonia;
	if(cp != '')
		parametros+="&cp="+cp;
		
	if ( regimen == 2 ) {
		if(!validaRFCPersona("txtrrfc")){
			band = false;
			alert("El RFC del Representante Legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
			return false;
		}
	}
	
	//if(validaCURP("txtcurp")){
		if ( nombre != '' && paterno != '' && materno != '' && numiden != '' && tipoiden > -1 ) {
			if ( regimen == 1 ) {
				rrfc = rfc;
			}
			if ( curp != '' ) {
				if ( validaCURP("txtcurp") ) {
					parametros += "&curp="+curp;
				} else {
					alert("El CURP tiene un formato incorrecto. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: BEML920313HCMLNS09");
					band = false;
				}
			}
			parametros += "&nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&numiden="+numiden+"&tipoiden="+tipoiden+"&rrfc="+rrfc+"&figura="+figura+"&familia="+familia;
		} else {
			band = false;
			//alert("Favor de escribir los datos del Representante Legal");
			if ( nombre == '' ) {
				alert("Favor de escribir el nombre del Representante Legal.");
				return false;
			} else if ( paterno == '' ) {
				alert("Favor de escribir el apellido paterno del Representante Legal.");
				return false;
			} else if ( materno == '' ) {
				alert("Favor de escribir el apellido materno del Representante Legal.");
				return false;
			} else if ( numiden == '' ) {
				alert("Favor de escribir el n\u00FAmero de identificaci\u00F3n del Representante Legal.");
				return false;
			} else if ( tipoiden <= 0 ) {
				alert("Favor de seleccionar un tipo de identificaci\u00F3n para el Representante Legal.");
				return false;
			} else if ( curp == '' ) {
				alert("Favor de escribir un CURP para el Representante Legal");
				return false;
			}
			return false;
		}
	/*}else{
		band = false;
		alert("El CURP del Representante Legal es incorrecto. Favor de escribirlo en un formato v\u00E1lido. Ejemplo: PUXB571021HNELXR00");
		return false;
	}*/	
	
	if ( pais < 0 ) {
		band = false;
		alert("Falta seleccionar Pa\u00EDs");
		return false;
	}
	
	if ( pais == '' ) {
		band = false;
		alert("Falta seleccionar Pa\u00EDs");
		return false;
	}
	
	if ( calle == '' ) {
		band = false;
		alert("Falta escribir Calle");
		return false;
	}
	
	if ( next == '' ) {
		band = false;
		alert("Falta escribir N\u00FAmero Exterior");
		return false;
	}
	
	if ( cp == '' ) {
		band = false;
		alert("Falta escribir C\u00F3digo Postal");
		return false;
	}	
	
	if ( pais == 164 ) {
		if ( colonia < 0 ) {
			band = false;
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( edo < 0 ) {
			band = false;
			alert("Falta seleccionar Estado");
			return false;
		}
		if ( ciudad < 0 ) {
			band = false;
			alert("Falta seleccionar Ciudad");
			return false;
		}
	}	
	
	if ( pais != 164 && pais > 0 ) {
		if ( colonia == '' ) {
			band = false;
			alert("Falta escribir Colonia");
			return false;
		}
		if ( edo == '' ) {
			band = false;
			alert("Falta escribir Estado");
			return false;
		}		
		if ( ciudad == '' ) {
			band = false;
			alert("Falta escribir Ciudad");
			return false;
		}
	}
	
	if ( band ) {
		parametros+="&dirGral="+dirGral;
		parametros += "&tipodireccion=" + tipo;
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarContratoPreSubCadena.php",parametros);
		window.setTimeout("Recargar()",100);
	}
	
}

function EditarVersionPreSubCadena(){
	var version = $("input[name='version']:checked").val();
	if ( version != "" ) {
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarVersionPreSubCadena.php","ver="+version);
		window.setTimeout("Recargar()",100);
	} else {
		alert("Favor de seleccionar una versi\u00F3n");
	}
}

function analizarCLABE(e) {
	var CLABE = $("#txtCLABE").val();
	existenCambios = true;
	if ( (e.which || e.keyCode) == 9 ) {
		if ( CLABE.length == 18 ) {
			var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
			if ( CLABE_EsCorrecta ) {
				$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
				function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#ddlBanco").val(banco.bancoID);
					$("#txtCuenta").val(CLABE.substring(6, 17));
					if ( document.getElementById("guardarCambios") ) {
						$("#guardarCambios").prop("disabled", false);
					}			
				}
				);
			} else {
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
				if ( document.getElementById("guardarCambios") ) {
					$("#guardarCambios").prop("disabled", true);
				}
				$("#ddlBanco").val(-1);
				$("#txtCuenta").val("");
			}
		} else {
			$("#ddlBanco").val(-1);	
			$("#txtCuenta").val("");
			if ( document.getElementById("guardarCambios") ) {
				$("#guardarCambios").prop("disabled", true);
			}	
		}
	} else if ( (e.which || e.keyCode) != 9 && (e.which || e.keyCode) != 8 && CLABE.length == 18 ) {
		if ( CLABE.length == 18 ) {
			var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
			if ( CLABE_EsCorrecta ) {
				$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
				function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("#ddlBanco").val(banco.bancoID);
					$("#txtCuenta").val(CLABE.substring(6, 17));
					if ( document.getElementById("guardarCambios") ) {
						$("#guardarCambios").prop("disabled", false);
					}					
				}
				);
			} else {
				alert("La CLABE escrita es incorrecta. Favor de verificarla.");
				if ( document.getElementById("guardarCambios") ) {
					$("#guardarCambios").prop("disabled", true);
				}
				$("#ddlBanco").val(-1);
				$("#txtCuenta").val("");
			}
		} else {
			$("#ddlBanco").val(-1);	
			$("#txtCuenta").val("");
			if ( document.getElementById("guardarCambios") ) {
				$("#guardarCambios").prop("disabled", true);
			}	
		}		
	} else if ( CLABE.length < 18 ) {
		$("#ddlBanco").val(-1);	
		$("#txtCuenta").val("");
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
		}	
	}
}

function validarDigitoVerificador( CLABE ) {
	var factoresDePeso = [ 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7, 1, 3, 7 ];
	var productos = new Array();
	var digitoVerificador = 0;
	
	for ( var i = 0; i < factoresDePeso.length; i++ ) {
		productos[i] = CLABE.charAt(i) * factoresDePeso[i];
	}
	
	for ( var i = 0; i < productos.length; i++ ) {
		productos[i] = productos[i] % 10;
	}
	
	for ( var i = 0; i < productos.length; i++ ) {
		digitoVerificador += productos[i];
	}
	
	digitoVerificador = 10 - ( digitoVerificador % 10 );
	
	return CLABE.charAt(17) == digitoVerificador;
	
}

function EditarCuentaBancoSubCadena(){
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtCLABE");
	var beneficiario = txtValue("txtBeneficiario");
	var cuenta = txtValue("txtCuenta");
	var descripcion = txtValue("txtDescripcionCuenta");
	var parametros = "f=0";
	var band = false;
	
	if ( clabe != "" ) {
		parametros+="&clabe="+clabe;
		band = true;
	}
	
	var CLABE_EsCorrecta = validarDigitoVerificador( clabe );
	if ( !CLABE_EsCorrecta ) {
		alert("La CLABE escrita es incorrecta. Favor de verificarla.");
		return false;
	}
	
	if ( banco > -1 ) {
		parametros+="&idbanco="+banco;
	}
	
	if ( beneficiario != "" ) {
		parametros+="&beneficiario="+beneficiario;
		band = true;
	} else {
		band = false;
		alert("No es posible guardar un Beneficiario vac\u00EDo.");
	}
	
	if(band){
		if(cuenta != '')
			parametros+="&cuenta="+cuenta;
		if(descripcion != '')
			parametros+="&descripcion="+descripcion;
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarCuentaPreSubCadena.php",parametros);
		window.setTimeout("Recargar()",100);
	}
	
}

function validarCamposPaso6() {
	var permitirGuardarCambios = false;
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtCLABE");
	var beneficiario = txtValue("txtBeneficiario");
	var cuenta = txtValue("txtCuenta");
	var descripcion = txtValue("txtDescripcionCuenta");	
	
	if ( banco > 0 && banco != "" ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( clabe != "" && clabe == 18 ) {
		var CLABE_EsCorrecta = validarDigitoVerificador( clabe );
		if ( CLABE_EsCorrecta ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	
	if ( beneficiario != "" ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( cuenta != "" && cuenta.length == 11 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
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

function verificarArchivos() {
	var permitirGuardarCambios = false;
	existenCambios = true;
	if ( document.getElementById('fudomicilio') ) {
		if ( document.getElementById('fudomicilio').value != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( document.getElementById('fudomiciliofiscal') ) {
		if ( document.getElementById('fudomiciliofiscal').value != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( document.getElementById('fucabanco').value != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( document.getElementById('fuidenrep').value != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( document.getElementById('fursocial').value != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( document.getElementById('fuactacons') ) {
		if ( document.getElementById('fuactacons').value != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( document.getElementById('fupoderes') ) {
		if ( document.getElementById('fupoderes').value != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
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

function CargarArchivos(){
	var band = true;
	var equivocados = "";
	if(Existe("fudomicilio") && document.getElementById("fudomicilio").value != ''){
		if(!filtrarArchivos("fudomicilio")){
			band = false;
			equivocados+= "\n Comprobante de domicilio";
		}
	}
	if(Existe("fudomiciliofiscal") && document.getElementById("fudomiciliofiscal").value != ''){
		if(!filtrarArchivos("fudomiciliofiscal")){
			band = false;
			equivocados+= "\n Comprobante de domicilio fiscal";
		}
	}
	if(Existe("fucabanco") && document.getElementById("fucabanco").value != ''){
		if(!filtrarArchivos("fucabanco")){
			band = false;
			equivocados+= "\n Caratula de banco";
		}
	}
	if(Existe("fuidenrep") && document.getElementById("fuidenrep").value != ''){
		if(!filtrarArchivos("fuidenrep")){
			band = false;
			equivocados+= "\n Identificacion de representante legal";
		}
	}
	if(Existe("fursocial") && document.getElementById("fursocial").value != ''){
		if(!filtrarArchivos("fursocial")){
			band = false;
			equivocados+= "\n RFC razon social";
		}
	}
	if(Existe("fuactacons") && document.getElementById("fuactacons").value != ''){
		if(!filtrarArchivos("fuactacons")){
			band = false;
			equivocados+= "\n Acta constitutiva";
		}
	}
	if(Existe("fupoderes") && document.getElementById("fupoderes").value != ''){
		if(!filtrarArchivos("fupoderes")){
			band = false;
			equivocados+= "\n Poderes";
		}
	}
	if(band)
		document.getElementById("formulario").submit();
	else
		alert("Los documentos solo pueden ser PDF o JPG en los sig. archivos: "+equivocados)
}

function RellenarContrato(e){
	var RFC = document.getElementById("txtrfc").value;
	var maximaLongitud = $("#txtrfc").attr("maxlength");
	var permitirGuardarCambios = false;
	if ( (e.which || e.keyCode) == 9 ) {
		if ( RFC != '' ) {
			if ( RFC.length == maximaLongitud ) {
				if ( validaRFC("txtrfc") ) {
					permitirGuardarCambios = true;	
					http.open("POST","../../inc/Ajax/_Clientes/RellenarContrato.php", true);
					http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					
					http.onreadystatechange=function() { 
						if ( http.readyState==1 ) {
							//div para  [cargando....]
							Emergente();
						}
						if ( http.readyState==4 ) {
							OcultarEmergente();
							var RespuestaServidor = http.responseText;
							var RESserv = RespuestaServidor.split("|");
						
							validaSession(RESserv[0]);
						
							if ( RESserv[0] == 0 ) {
								if ( RESserv[1] == "" ) {
									setValue("txtrazon","");
									$("#txtrazon").prop("disabled", false);
									//Desbloquear("txtrazon");
								} else {
									setValue("txtrazon",RESserv[1]);
								}
								
								if ( RESserv[2] == "" ) {
									setValue("txtfecha","");
									$("#txtfecha").prop("disabled", false);
									//Desbloquear("txtfecha");
								} else {
									setValue("txtfecha",RESserv[2]);
								}
								
							if ( RESserv[3] == "" ) {
								//setValue("ddlRegimen","-1");
								//Desbloquear("ddlRegimen");
							} else {
								//setValue("ddlRegimen",RESserv[3]);
							}
							//VerificarDireccionCorr();
						} else {
							alert("Error: "+RESserv[0]+" "+RESserv[1]);
							if(document.getElementById('daniel') != null)
								document.getElementById('daniel').innerHTML = RESserv[1];
						}			
					} 
				}
				http.send("rfc="+RFC+"&pemiso="+true);	
				}else{
					alert("El RFC no es v\u00E1lido. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");
				}
			} else {
				permitirGuardarCambios = false;
				alert("El RFC no es v\u00E1lido. Favor de escribirlo en un formato v\u00E1lido.\nEjemplo: VECJ880326XXX para persona f\u00EDsica o ABC680524P76 para persona moral.");	
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
	}
}

function irABusqueda() {
	window.location = "../PrealtaBuscarSubCadenas.php";	
}

function actualizarCargos( cadenaID, subcadenaID ) {
	$.post( "../../inc/Ajax/_Clientes/getAfiliacionesPreSubCadena.php", { "cadenaID": cadenaID, "subcadenaID": subcadenaID },
	function( data ) {
		$("#wrapperAfiliaciones").html(data);
	}, "html" );
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
	var subcadenaID = $("#subcadenaID").val();
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
	if ( subcadenaID == null || subcadenaID == "" ) {
		alert("Error: No pudo cargarse el ID de la Sub Cadena");
		return false;
	}

	if ( seAgrega ) {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID + "&subcadenaID=" + subcadenaID;
		$.post( "../../inc/Ajax/_Clientes/agregarPreCargoPreSubCadena.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID, "subcadenaID": subcadenaID },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID, subcadenaID );	
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);
	} else {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID + "&subcadenaID=" + subcadenaID + "&idPreCargo=" + idPreCargo;
		$.post( "../../inc/Ajax/_Clientes/editarPreCargoPreSubCadena.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID, "subcadenaID": subcadenaID, "idPreCargo": idPreCargo },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID, subcadenaID );
					$("#idPreCargo").val("");
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);		
	}
}

function eliminarCargo( idPreCargo, cadenaID, subcadenaID ) {
	$.post( "../../inc/Ajax/_Clientes/eliminarPreCargoPreSubCadena.php", { "cadenaID": cadenaID, "subcadenaID": subcadenaID, "idPreCargo": idPreCargo },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			actualizarCargos( cadenaID, subcadenaID );	
		} else {
			alert( resultado[1] );
		}
	}, "html" );
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
	$("#ddlTipo").val(-1);
	$("#botonAgregar").text("Agregar");
}

function PreValidarSeccionesPreSubCadena(){
	if ( document.getElementById("chkcargos") ) {
		var cargos = document.getElementById("chkcargos").checked ? 1 : 0;
	} else {
		var cargos = 1;
	}
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var contrato = document.getElementById("chkcontrato").checked ? 1 : 0;
	var version = document.getElementById("chkversion").checked ? 1 : 0;
	var cuenta = document.getElementById("chkcuenta").checked ? 1 : 0;
	var documentacion = document.getElementById("chkdocumentacion").checked ? 1 : 0;
	var permitirGuardarCambios = false;
	
	parametros = "generales="+generales+"&direccion="+direccion+"&contactos="+contactos+"&cargos="+cargos+"&contrato="+contrato+"&version="+version+"&cuenta="+cuenta+"&documentacion="+documentacion;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/PreRevisarSeccionesPreSubCadena.php",parametros);
	
	if ( generales && direccion && contactos && cargos && contrato && version && cuenta && documentacion ) {
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

function validar() {
	if ( document.getElementById("chkcargos") ) {
		var cargos = document.getElementById("chkcargos").checked ? 1 : 0;	
	} else {
		var cargos = 1;	
	}
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var contrato = document.getElementById("chkcontrato").checked ? 1 : 0;
	var version = document.getElementById("chkversion").checked ? 1 : 0;
	var cuenta = document.getElementById("chkcuenta").checked ? 1 : 0;
	var documentacion = document.getElementById("chkdocumentacion").checked ? 1 : 0;
	var cadenaID = $("#cadenaID").val();
	var subcadenaID = $("#subcadenaID").val();

	$.post( "../../inc/Ajax/_Clientes/RevisarSeccionesPreSubCadena.php",
	{ "cargos": cargos, "generales": generales, "direccion": direccion, "contactos": contactos, "contrato": contrato, "version": version, "cuenta": cuenta, "documentacion": documentacion },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			window.location = "Validar1.php?id=" + subcadenaID;
		} else {
			alert( resultado[1] );
		}		
	}, "html" );
}

function irAValidacion() {
	var subcadenaID = document.getElementById('idSubcadena').value;
	if ( subcadenaID != null && subcadenaID != "" ) {
		window.location = "Validar.php?id=" + subcadenaID;
	} else {
		alert("No es posible enviar a Validaci\u00F3n. No pudo cargarse el ID de la Pre Sub Cadena.");	
	}	
}
var existenCambios = false;

function goToAutorizarCorresponsal(idCorresponsal){
	var inputs = {
		idCorresponsal : idCorresponsal
	}

	/* common-scripts.js */
	submitFormPost("Corresponsal/Autorizar.php", inputs);
}

function AutoCalleDir2(){
	if(Existe("txtcalle"))
		AutoCompletar("txtcalle","../../inc/Ajax/AutoCalleDireccion.php",2);
}

$(document).ready(function(){
	AutoCalleDir2();
	$('.pencilAgregar').tooltip('show');

	$(":input").bind("paste", function(){return false;});

	/* Configuraciones y Validaciones para los Campos del Horario */
	if($("#checkall").length){
		$("#checkall").change(function(event){
			if($("#checkall").is(':checked')){
				fillHorario = true;

				llenaHorario("1", $("#txt1").val());
				llenaHorario("2", $("#txt2").val());

				$("#txt1, #txt2").bind("keyup", function(e){
					var targ	= e.target;
					var id		= targ.id;
					var tip 	= id[id.length - 1];
					var valor	= $(targ).val();

					llenaHorario(tip, valor);
				});
			}
			else {
				fillHorario = false
				$("#txt1, #txt2").unbind("keyup");
			}  
		});
	}

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").attr('maxlength', '5');

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").keyup(function(event) {
		if(event.keyCode != 8 && event.keyCode != 46){
			var id = event.currentTarget.id;
			return validaHoras2(event, id);
		}
	});

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").keypress(function(event) {
		if(event.keyCode != 8 && event.keyCode != 46){
			var id = event.currentTarget.id;
			return validaHoras(event, id);
		}
	});

	if($("#txtPais").length){
		$("#txtPais").autocomplete({
			source: function(request, respond){
				$.post( "../../inc/Ajax/_Clientes/getPaises.php", { "pais": request.term },
				function(response) {
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function(event, ui) {
				$("#txtPais").val(ui.item.nombre);
				return false;
			},
			select: function(event, ui) {
				$("#paisID").val(ui.item.idPais);
				VerificarDireccionCad(tipoDireccion, false);
				cambiarPantalla();
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>" + item.nombre + "</a>" )
			.appendTo( ul );
		};
	}

	if($("#tblContactosPreCor").length){
		cargarPreContactosPreCorresponsalPaso3();
	}
	
	if ( $("#txtCLABE").length ) {
		$("#txtCLABE").unbind();
		$("#txtCLABE").bind( "paste", function() {
			setTimeout( function() {
				analizarCLABE();
			}, 100);
			analizarCLABE();									  
		});
	}	
	
});

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

function irAAutorizarCorresponsal(idCorresponsal){
	var inputs = {
		idCorresponsal : idCorresponsal
	}
	/* common-scripts.js */
	submitFormPost("Autorizar.php", inputs);
}

function desplegarVersiones( cadenaID, subcadenaID, tipoSubCadena ) {
	$.post( "../../inc/Ajax/_Clientes/getVersionSubCadena.php", { "subcadenaID": subcadenaID, "cadenaID": cadenaID, "tiposubcadena": tipoSubCadena },
	function( data ) {
		$("#versiones").html(data);
		//$("#versiones").html(resultado.versiones);
	}, "html" );	
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

function Recargar(){
	window.location.reload();
}

function EditarGrlsPreCorresponsal(){
	var idcadena = txtValue("cadenaID");
	var subcadena = txtValue("subcadenaID").split("-");
	var idsubcadena = subcadena[0];
	var tiposubcadena = subcadena[1];
	var giro = txtValue("ddlGiro");
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var mail = txtValue("txtmail");
	var NumSucu = txtValue("txtNumSucursal");
	var NomSucu = txtValue("txtNomSucursal");
	var iva = txtValue("ddlIva");
	var versionID = "";
	if ( $("#versionID").length ) {
		versionID = $("#versionID").val();
	}
	band = true;
	var parametros = "";
	
	if ( idcadena > -1 ) {
		parametros = "idcadena="+idcadena;
	}
	
	if ( idsubcadena > -1 ) {
		parametros += "&nomsubcadena="+$("#txtNombreSubCadena").val();
		parametros += "&idsubcadena="+idsubcadena;
		parametros += "&tiposubcadena="+tiposubcadena;
	}
	
	if ( giro > -1 ) {
		parametros+="&idgiro="+giro;
	}
	
	if ( grupo > -1 ) {
		parametros+="&idgrupo="+grupo;
	}
	
	if ( ref > -1 ) {
		parametros+="&idref="+ref;
	}
	
	if ( tel1 != '' ) {
		if ( validaTelefono("txttel1") ) {
			parametros+="&tel1="+tel1;
		} else {
			band = false;
			alert("El Tel\u00E9fono es incorrecto");			
		}
	}
	
	if ( mail != '' ) {
		if ( validarEmail("txtmail") ) {
			parametros+="&mail="+mail;
		} else {
			band = false;
			alert("El Correo Electr\u00F3nico es incorrecto");	
		}
	}
	
	if ( iva > -1 ) {
		parametros+="&iva="+iva;
	}
	
	if ( versionID != "" ) {
		parametros+="&versionid="+versionID;
	}
	
	if(band){
		if(NumSucu != '')
			parametros+="&numSucursal="+NumSucu;
		if(NomSucu != '')
			parametros+="&nomSucursal="+NomSucu;
		
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarGrlsPreCorresponsal.php",parametros);
		window.setTimeout("Recargar()",100);
	}
	
}

function validarCamposGenerales() {
	var idcadena = txtValue("cadenaID");
	var subcadena = txtValue("subcadenaID").split("-");
	var idsubcadena = subcadena[0];
	var tiposubcadena = subcadena[1];
	var giro = txtValue("ddlGiro");
	var grupo = txtValue("ddlGrupo");
	var ref = txtValue("ddlReferencia");
	var tel1 = txtValue("txttel1");
	var mail = txtValue("txtmail");
	var NumSucu = txtValue("txtNumSucursal");
	var NomSucu = txtValue("txtNomSucursal");
	var iva = txtValue("ddlIva");
	var permitirGuardarCambios = false;
	
	if ( idcadena > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( idsubcadena > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( giro > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( grupo > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( ref > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( tel1 != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( mail != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	
	if ( iva > -1 ) {
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

function ocultarVersion() {
	if ( $("#txtNombreCadena").val() == "" ) {
		$("#cadenaID").val("");
		$("#versiones").empty();
		$("#txtNombreSubCadena").val("");
		$("#subcadenaID").val("");
	} else if ( $("#txtNombreSubCadena").val() == "" ) {
		$("#versiones").empty();
		$("#subcadenaID").val("");
	}
}

function desplegarCamposDeCuenta() {
	var tipoFORELO = $("#tipoFORELO").val();
	if ( tipoFORELO == 1 ) {
		$("#divCLABE").css("display", "none");
		$("#divBanco").css("display", "none");
		$("#divBeneficiario").css("display", "none");
	} else if ( tipoFORELO == 2 ) {
		$("#divCLABE").css("display", "block");
		$("#divBanco").css("display", "block");
		$("#divBeneficiario").css("display", "block");		
	}
}

function analizarCLABE() {
	var CLABE = $("#txtCLABE").val();
	existenCambios = true;
	if ( CLABE.length == 18 ) {
		var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
		if ( CLABE_EsCorrecta ) {
			$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
			function ( data ) {
				var banco = jQuery.parseJSON( data );
				$("#ddlBanco").val(banco.bancoID);
				$("#txtCuenta").val(CLABE.substring(6, 17));
			}
			);
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			if ( document.getElementById("guardarCambios") ) {
				$("#guardarCambios").prop("disabled", false);
			}			
		}
	} else {
		$("#ddlBanco").val(-1);	
		$("#txtCuenta").val("");
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
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
	var tipoFORELO = $("#tipoFORELO").val();
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtCLABE");
	var beneficiario = txtValue("txtBeneficiario");
	var cuenta = txtValue("txtCuenta");
	var descripcion = txtValue("txtDescripcionCuenta");
	var parametros = "f=0";
	var band = true;
	
	if ( tipoFORELO > -1 ) {
		parametros += "&tipoforelo=" + tipoFORELO;
	}
	if ( banco > -1 ) {
		parametros += "&idbanco=" + banco;
	}
	if ( clabe != "" ) {
		parametros += "&clabe=" + clabe;
	}
	if ( tipoFORELO == 1 ) {
		parametros += "&beneficiario=" + beneficiario;
	} else if ( tipoFORELO == 2 ) {
		if ( beneficiario != "" ) {
			parametros += "&beneficiario=" + beneficiario;
		} else {
			band = false;
			alert("No es posible guardar un Beneficiario vac\u00EDo.");
		}
	}
	
	if ( band ) {
		if ( cuenta != '' ) {
			parametros+="&cuenta="+cuenta;
		}
		if ( descripcion != '' ) {
			parametros+="&descripcion="+descripcion;
		}
		MetodoAjax2("../../inc/Ajax/_Clientes/EditarCuentaPreCorresponsal.php",parametros);
		window.setTimeout("Recargar()",100);
	}
	
}

function verificarCamposCuenta() {
	var tipoFORELO = $("#tipoFORELO").val();
	var banco = txtValue("ddlBanco");
	var clabe = txtValue("txtCLABE");
	var beneficiario = txtValue("txtBeneficiario");
	var cuenta = txtValue("txtCuenta");
	var descripcion = txtValue("txtDescripcionCuenta");
	var permitirGuardarCambios = false;
	
	if ( tipoFORELO > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( banco > -1 ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( clabe != "" ) {
		permitirGuardarCambios = true;
	}
	if ( beneficiario != "" ) {
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

function CargarArchivos(){
	var band = true;
	var equivocados = "";
	if(Existe("fudomicilio") && document.getElementById("fudomicilio").value != ''){
		if(!filtrarArchivos("fudomicilio")){
			band = false;
			equivocados+= "\n Comprobante de domicilio";
		}
	}
	if(Existe("fucabanco") && document.getElementById("fucabanco").value != ''){
		if(!filtrarArchivos("fucabanco")){
			band = false;
			equivocados+= "\n Car\u00E1tula de banco";
		}
	}
	if(band)
		document.getElementById("formulario").submit();
	else
		alert("Los documentos solo pueden ser PDF o JPG en los sig. archivos: "+equivocados)
}

function verificarArchivos() {
	var permitirGuardarCambios = false;
	existenCambios = true;
	if ( document.getElementById('fudomicilio').value != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( document.getElementById('fucabanco') ) {
		if ( document.getElementById('fucabanco').value != '' ) {
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

function esValido(valor){
	if(valor != "" && valor != undefined){
		return true;
	}
	else{
		return false;
	}
}

function cargarPreContactosPreCorresponsal(){
	var idCorresponsal = $("#idCorresponsal").val();

	if(!esValido(idCorresponsal)){
		alert("No es posible Cargar los Contactos del Corresponsal");
	}

	$.post("../../../inc/Ajax/_Clientes/ListaContactosPreCorresponsalResumen.php",
	{
		idCorresponsal : idCorresponsal
	},
	function(response){
		$("#tblContactosPreCorresponsal").html(response);
	}
	);
}

function agregarContactoDeSubCadena(idContacto, idCorresponsal, idTipoContacto, nombre, paterno, materno, ext, telefono, correo){
	$.post("../../../inc/Ajax/_Clientes/AgregaPreContactoDeSubCadena.php",
	{
		idContacto		: idContacto,
		idCorresponsal	: idCorresponsal,
		idTipoContacto	: idTipoContacto,
		nombre			: nombre,
		paterno			: paterno,
		materno			: materno,
		ext				: ext,
		telefono		: telefono,
		correo			: correo
	},
	function(response){
		if(showMsg(response)){
			alert(response.msg);
		}
		else{
			cargarPreContactosPreCorresponsalPaso3();
		}
	},
	"json");
}

function cargarPreContactosPreCorresponsalPaso3(){
	var idCorresponsal = $("#idCorresponsal").val();

	if(!esValido(idCorresponsal)){
		alert("No es posible Cargar los Contactos del Corresponsal");
	}

	$.post("../../../inc/Ajax/_Clientes/ListaContactosPreCorresponsal.php",
	{
		idCorresponsal : idCorresponsal
	},
	function(response){
		$("#tblContactosPreCor").html(response);

		$("#boton-nuevo-contacto").show();
		$("#guardarCambios").show();
	}
	);
}

function llenaHorario(tip, valor){
	if(fillHorario == true){
		var cont = 0;

		while(cont < 6){
			tip = parseInt(tip) + 2;
			$("#txt"+tip).val(valor);
			cont++;
		}
	}
}

var bandedcont3 = 0;
function DesPreContactosCorresponsal(){
	if(bandedcont3 == 0)
		AgregarPreContactosCorresponsal();
	if(bandedcont3 == 1)
		EditarPreContactoCorresponsal();
}

function AgregarPreContactosCorresponsal(){
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
				parametros+= "nombre="+nombre+"&paterno="+paterno+"&materno="+materno+"&telefono="+telefono+"&ext="+ext+"&correo="+correo+"&tipocontacto="+tipocontacto;
				MetodoAjax2("../../inc/Ajax/_Clientes/CrearPreContactoCorresponsal.php",parametros);
				
				window.setTimeout("LimpiarPreContactos(false)",40);
				window.setTimeout("VerificaContAdCorresponsal()",100);
				window.setTimeout(cargarPreContactosPreCorresponsalPaso3(), 100);
				
			}else{
				alert("El correo electronico es incorrecto")
			}
		}else{
			alert("El Telefono es incorrecto");
		}
	}else{
		alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
	}
}

function EditarPreContactoCorresponsal(id,x){
	if(x == 0){
		precontid = id;
		http.open("POST","../../inc/Ajax/_Clientes/EdPreContacto.php", true);
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
				OcultarEmergente();
				$("#agregarcontacto").slideDown("normal");
				cargarPreContactosPreCorresponsalPaso3();
			} 
		}
		http.send("id="+id);
		
		
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
					MetodoAjax2("../../inc/Ajax/_Clientes/EditarPreContactoCorresponsal.php",parametros);
					window.setTimeout("LimpiarPreContactos(false)",40);
					//window.setTimeout("BuscarPreContactosCorresponsal()",100);
					cargarPreContactosPreCorresponsalPaso3();
				}else{
					alert("El correo electronico es incorrecto");
				}
			}else{
				alert("El telefono es incorrecto");
			}			
		}else{
			alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
		}
	}
	
}

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

actualizaDireccion = true;
function CrearDirPreCorresponsal( tipo ){
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
	var caracterVacio = /^\s$/i;
	
	if ( calle != '' ) {
		if ( !calle.match(caracterVacio) ) {
			parametros += "&calle="+calle;
		} else {
			alert("La Calle no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Calle");
		return false;
	}
		
	if ( !nint.match(caracterVacio) ) {
		parametros += "&nint="+nint;
	} else {
		alert("El Número Interior no puede estar vacío");
		return false;
	}
		
	if ( next != '' ) {
		if ( !next.match(caracterVacio) ) {
			parametros += "&next="+next;
		} else {
			alert("El N\u00FAmero Exterior no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el N\u00FAmero Exterior");
		return false;
	}
		
	if ( pais != '' ) {
		if ( !pais.match(caracterVacio) ) {
			parametros += "&idpais="+pais;
		} else {
			alert("El Pa\u00EDs no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el Pa\u00EDs");
		return false;
	}
		
	if ( edo != '' ) {
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
		
	if ( colonia != '' ) {
		if ( colonia == '-1' ) {
			alert("Falta seleccionar Colonia");
			return false;
		}		
		if ( !colonia.match(caracterVacio) ) {
			parametros += "&idcolonia="+colonia;
		} else {
			alert("La Colonia no puede estar vacía");
			return false;
		}
	} else {
		alert("Falta llenar la Colonia");
		return false;
	}
		
	if ( cp != '' ) {
		if ( !cp.match(caracterVacio) ) {
			parametros += "&cp="+cp;
		} else {
			alert("El C\u00F3digo Postal no puede estar vacío");
			return false;
		}
	} else {
		alert("Falta llenar el C\u00F3digo Postal");
		return false;
	}
	parametros += UpdateHorariosPreCorr();
	parametros += "&tipodireccion=" + tipo;
	if(actualizaDireccion){
		MetodoAjax22("../../inc/Ajax/_Clientes/EditarDireccionPreCorresponsal.php",parametros);
	}
}

function UpdateHorariosPreCorr(idCorr){
		
	var parametros = "";
	var DE1 = txtValue("txt1");
	var DE2 = txtValue("txt3");
	var DE3 = txtValue("txt5");
	var DE4 = txtValue("txt7");
	var DE5 = txtValue("txt9");
	var DE6 = txtValue("txt11");
	var DE7 = txtValue("txt13");
	
	var A1 = txtValue("txt2");
	var A2 = txtValue("txt4");
	var A3 = txtValue("txt6");
	var A4 = txtValue("txt8");
	var A5 = txtValue("txt10");
	var A6 = txtValue("txt12");
	var A7 = txtValue("txt14");
	
	
	if(validaHorasDia(DE1,A1,"txt2","Lunes")){
		if(validaHorasDia(DE2,A2,"txt4","Martes")){
			if(validaHorasDia(DE3,A3,"txt6","Miercoles")){
				if(validaHorasDia(DE4,A4,"txt8","Jueves")){
					if(validaHorasDia(DE5,A5,"txt10","Viernes")){
						if(validaHorasDia(DE6,A6,"txt12","Sabado")){
							if(validaHorasDia(DE7,A7,"txt14","Domingo")){
								
								parametros += "&DE1="+DE1+"&DE2="+DE2+"&DE3="+DE3+"&DE4="+DE4+"&DE5="+DE5+"&DE6="+DE6+"&DE7="+DE7+"";
								parametros += "&A1="+txtValue("txt2")+"";
								parametros += "&A2="+txtValue("txt4")+"";
								parametros += "&A3="+txtValue("txt6")+"";
								parametros += "&A4="+txtValue("txt8")+"";
								parametros += "&A5="+txtValue("txt10")+"";
								parametros += "&A6="+txtValue("txt12")+"";
								parametros += "&A7="+txtValue("txt14")+"";
								actualizaDireccion = true;
							}
							else{
								actualizaDireccion = false;
								return false;
							}
						}
						else{
							actualizaDireccion = false;
							return false;
						}
					}
					else{
						actualizaDireccion = false;
						return false;
					}
				}
				else{
					actualizaDireccion = false;
					return false;
				}
			}
			else{
				actualizaDireccion = false;
				return false;
			}
		}
		else{
			actualizaDireccion = false;
			return false;
		}
	}
	else{
		actualizaDireccion = false;
		return false;
	}
	return parametros;
}

function validaHorasDia(valorDe,valorA,txt,dia){
	if(valorDe != ""){
		if(valorA != ""){
			if(validaHorasRegex(valorDe)){
				if(validaHorasRegex(valorA)){
					return true;
				}
				else{
					alert("Favor de escribir la Hora de Cierre correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
					return false;
				}
			}
			else{
				alert("Favor de escribir la Hora de Inicio correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
				return false;
			}
		}
		else{
			alert("Favor de escribir la Hora de Cierre del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
			return false;
		}
	}
	else{
		//setValue(txt,'');
		alert("Favor de escribir la Hora de Inicio correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
		return false;
	}

	return true;
}

function MetodoAjax22(url,parametros){
                
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);
                        
			if(RESserv[0] == 0){
                contad = 0;
                Recargar();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];
					
				alert(RESserv[1]);
                contad = 1;
			}			
		} 
	}
	http.send(parametros+"&pemiso="+true);
}

function LimpiarPreContactosCorresponsal(value){
	/*document.getElementById("txtnombre").value = "";
	document.getElementById("txtpaterno").value = "";
	document.getElementById("txtmaterno").value = "";
	document.getElementById("txttelefono").value = "";
	document.getElementById("txtext").value = "";
	document.getElementById("txtcorreo").value = "";
	document.getElementById("ddlTipoContacto").value = -1;*/
	bandedcont3 = 0;
	if(value){
		$('#agregarcontacto').slideDown('normal');
	}
	else{
		$('#agregarcontacto').slideUp('normal');
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
					Emergente();
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
					OcultarEmergente();
					$("#agregarcontacto").slideDown("normal");
					agregarPreContacto();
				//	cargarPreContactosPreCorresponsalPaso3();
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
					/*window.setTimeout("BuscarPreContactos()",100);*/
					cargarPreContactosPreCorresponsalPaso3();

				}else{
					alert("El correo electr\u00F3nico es incorrecto");
				}
			}else{
				alert("El tel\u00E9fono es incorrecto")
			}
		}else{
			alert("Favor de llenar todos los datos requeridos marcados con asterisco (*)")
		}
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
		$('#agregarcontacto').slideDown('normal');
		if ( document.getElementById("guardarCambios") ) {
			document.getElementById('guardarCambios').style.visibility = "visible";
		}
		if ( document.getElementById("nuevoContacto") ) {
			document.getElementById('nuevoContacto').style.display = "none";	
		}
	} else {
		$('#agregarcontacto').slideUp('normal');
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
			//document.getElementById('guardarCambios').style.visibility = "hidden";
		}
	}
}

function EliminarPreContactoCorresponsal(id){
	if(confirm("\u00BFEst\u00E1 seguro de eliminar el contacto?")){
		MetodoAjax22("../../inc/Ajax/_Clientes/EliminarPreContactoCorresponsal.php","id="+id)
		window.setTimeout("cargarPreContactosPreCorresponsal()",100);
	}	
}

function VerificaContAdCorresponsal(){
	if(contad == 0){
		window.setTimeout("LimpiarPreContactosCorresponsal(false)",40);
		window.setTimeout("cargarPreContactosPreCorresponsalPaso3()",100);	
	}
}

function showMsg(obj){
	if(obj.showMsg == 1){
		return true;
	}
	else{
		return false;
	}
}

function verificarHorarioCambios() {
	existenCambios = true;
	var permitirGuardarCambios = true;
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

function agregarPreContacto() {
	$("#boton-nuevo-contacto").css("display", "none");
	$("#guardarCambios").show();
	$("#guardarCambios").prop("disabled", false);
}

function irABusqueda() {
	window.location = "../PrealtaBuscarCorresponsales.php";	
}

function actualizarCargos( cadenaID, subcadenaID, corresponsalID ) {
	$.post( "../../inc/Ajax/_Clientes/getAfiliacionesPreCorresponsal.php", { "cadenaID": cadenaID, "subcadenaID": subcadenaID, "corresponsalID": corresponsalID },
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
	var corresponsalID = $("#corresponsalID").val();
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
	if ( corresponsalID == null || corresponsalID == "" ) {
		alert("Error: No pudo cargarse el ID del Corresponsal");
		return false;
	}

	if ( seAgrega ) {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID + "&subcadenaID=" + subcadenaID + "&corresponsalID=" + corresponsalID;
		$.post( "../../inc/Ajax/_Clientes/agregarPreCargoPreCorresponsal.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID, "subcadenaID": subcadenaID, "corresponsalID": corresponsalID },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID, subcadenaID, corresponsalID );
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);
	} else {
		parametros += "tipoConcepto=" + tipoConcepto + "&importe=" + importe + "&fechaInicio=" + fechaInicio +
		"&observaciones=" + observaciones + "&tipo=" + tipo + "&cadenaID=" + cadenaID + "&subcadenaID=" + subcadenaID + "&corresponsalID=" + corresponsalID + "&idPreCargo=" + idPreCargo;
		$.post( "../../inc/Ajax/_Clientes/editarPreCargoPreCorresponsal.php",
			{ "tipoConcepto": tipoConcepto, "importe": importe, "fechaInicio": fechaInicio, "observaciones": observaciones, "tipo": tipo, "cadenaID": cadenaID, "subcadenaID": subcadenaID, "corresponsalID": corresponsalID, "idPreCargo": idPreCargo },
			function( data ) {
				var resultado = data.split("|");
				if ( resultado[0] == 0 ) {
					actualizarCargos( cadenaID, subcadenaID, corresponsalID );
					$("#idPreCargo").val("");
					$('#ayc').modal('hide');
				} else {
					alert( resultado[1] );
				}				
			}
		);		
	}
}

function eliminarCargo( idPreCargo, cadenaID, subcadenaID, corresponsalID ) {
	$.post( "../../inc/Ajax/_Clientes/eliminarPreCargoPreCorresponsal.php", { "cadenaID": cadenaID, "subcadenaID": subcadenaID, "corresponsalID": corresponsalID, "idPreCargo": idPreCargo },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			actualizarCargos( cadenaID, subcadenaID, corresponsalID );	
		} else {
			alert( resultado[1] );
		}
	}, "html" );
}

function agregarBanco(){
	var bancoID = $("#ddlBanco").val();
	var corresponsalID = $("#corresponsalID").val();
	if ( bancoID > 0 ) {
		$.post( "../../inc/Ajax/_Clientes/agregarBancoPreCorresponsal.php", { "bancoID": bancoID, "corresponsalID": corresponsalID },
		function( data ) {
			if ( data != "" ) {
				$("#divddlBanco").empty();
				$("#divddlBanco").html(data);
				bancosDePreCorresponsal();
				imprimirBancosDePreCorresponsal();
			} else {
				alert( "Error al agregar Banco al Corresponsal" );
			}
		}, "html" );		
	}
}

function bancosDePreCorresponsal(){
	var corresponsalID = $("#corresponsalID").val();
	if ( corresponsalID > 0 ) {
		$.post( "../../inc/Ajax/_Clientes/getBancosPreCorresponsal.php", { "corresponsalID": corresponsalID },
		function( data ) {
			if ( data != "" ) {
				$("#divcorrbanc").empty();
				$("#divcorrbanc").html(data);
			} else {
				alert( "Error al actualizar lista de Bancos del Corresponsal" );
			}
		}, "html" );		
	}	
}

function eliminarCorresponsalia( corresponsalID, bancoID ){
	$.post( "../../inc/Ajax/_Clientes/eliminarBancoPreCorresponsal.php", { "corresponsalID": corresponsalID, "bancoID": bancoID },
	function( data ) {
		if ( data != "" ) {
			$("#divddlBanco").empty();
			$("#divddlBanco").html(data);
			bancosDePreCorresponsal();
			imprimirBancosDePreCorresponsal();
		} else {
			alert( "Error al actualizar lista de Bancos del Corresponsal tras haber eliminado una Corresponsalia Bancaria" );
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

function imprimirBancosDePreCorresponsal(){
	var corresponsalID = $("#corresponsalID").val();
	$.post( "../../inc/Ajax/_Clientes/imprimirBancosPreCorresponsal.php", { "corresponsalID": corresponsalID },
	function( data ) {
		if ( data != "" ) {
			$("#bancosDeCorresponsal").empty();
			$("#bancosDeCorresponsal").html(data);
		} else {
			alert( "Error al actualizar lista de Bancos del Corresponsal" );
		}
	}, "html" );	
}

function validar() {
	var cargos = document.getElementById("chkcargos").checked ? 1 : 0;
	if ( document.getElementById("chkbancos") ) {
		var bancos = document.getElementById("chkbancos").checked ? 1 : 0;
	} else {
		var bancos = 1;	
	}
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var version = document.getElementById("chkversion").checked ? 1 : 0;
	var cuenta = document.getElementById("chkcuenta").checked ? 1 : 0;
	var documentacion = document.getElementById("chkdocumentacion").checked ? 1 : 0;
	var permitirGuardarCambios = false;
	var corresponsalID = $("#corresponsalID").val();
	var horario = 0;
	if ( direccion == 1 ) {
		horario = 1;
	}
	
	$.post( "../../inc/Ajax/_Clientes/RevisarSeccionesPreCorresponsal.php",
	{ "cargos": cargos, "generales": generales, "bancos": bancos, "direccion": direccion, "contactos": contactos, "version": version, "cuenta": cuenta, "documentacion": documentacion },
	function( data ) {
		var resultado = data.split("|");
		if ( resultado[0] == 0 ) {
			window.location = "Validar1.php?id=" + corresponsalID;
		} else {
			alert( resultado[1] );
		}		
	}, "html" );
}

function PreValidarSeccionesPreSubCadena(){
	var cargos = document.getElementById("chkcargos").checked ? 1 : 0;
	if ( document.getElementById("chkbancos") ) {
		var bancos = document.getElementById("chkbancos").checked ? 1 : 0;
	} else {
		var bancos = 1;	
	}
	var generales = document.getElementById("chkgenerales").checked ? 1 : 0;
	var direccion = document.getElementById("chkdireccion").checked ? 1 : 0;
	var contactos = document.getElementById("chkcontactos").checked ? 1 : 0;
	var version = document.getElementById("chkversion").checked ? 1 : 0;
	var cuenta = document.getElementById("chkcuenta").checked ? 1 : 0;
	var documentacion = document.getElementById("chkdocumentacion").checked ? 1 : 0;
	var permitirGuardarCambios = false;
	var horario = 0;
	if ( direccion == 1 ) {
		horario = 1;
	}	
	parametros = "generales="+generales+"&direccion="+direccion+"&contactos="+contactos+"&cargos="+cargos+"&version="+version+"&cuenta="+cuenta+"&documentacion="+documentacion+"&bancos="+bancos;
	
	MetodoAjax2("../../inc/Ajax/_Clientes/PreRevisarSeccionesPreCorresponsal.php",parametros);
	
	if ( generales && direccion && contactos && cargos && version && cuenta && documentacion && bancos && horario ) {
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

function irABusqueda() {
	window.location = "../PrealtaBuscarCorresponsales.php";	
}

function irAValidacion(){
	var corresponsalID = document.getElementById('idCorresponsal').value;
	if ( corresponsalID != null && corresponsalID != "" ) {
		window.location = "Validar.php?id=" + corresponsalID;
	} else {
		alert("No es posible enviar a Validaci\u00F3n. No pudo cargarse el ID del Pre Corresponsal.");	
	}
}

function EliminarPreCorresponsal2(id){
	if(confirm("\u00BFEsta seguro de eliminar el Pre Corresponsal?")){
		MetodoAjax2("../../inc/Ajax/_Clientes/EliminarPreCorresponsal.php","id="+id);
		window.setTimeout("Recargar()",100);
	}
}

$(function(){

	$("#txtContacNom, #txtMailContac").attr('maxlength','100');
	$("#txtContacAP, #txtContacAM").attr('maxlength','50');
	$("#txtExtTelContac").attr('maxlength', '10');

	$("#txtContacNom, #txtContacAP, #txtContacAM, #txtTelContac, #txtExtTelContac, #txtMailContac").bind("paste", function(){return false;})

});

var contad = 0;
function editarInfo(url,parametros){
                
	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	Emergente();
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
				//alert(RESserv[1]);
				//irAEditar();
                irAListado();
				contad = 0;
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

function agregarVersion(idGrupo, idCadena, idSubCadena, idCorresponsal){

	var idVersion = $("#ddlVersion").val();

	if(idVersion == -1){
		alert("Seleccione una Versión");
		return false;
	}

	$.post("../../../inc/Ajax/_Clientes/agregarVersion.php", {
		idGrupo			: idGrupo,
		idCadena		: idCadena,
		idSubCadena		: idSubCadena,
		idCorresponsal	: idCorresponsal,
		idVersion		: idVersion
	},
	function(response){
		if(response.showMsg == 1){
			alert(response.msg);
		}
		irAEditar();
	}, "json");
}

function crearConf(){
	var tipoMovimiento	= $("#ddlTipoMovimiento").val();
	var destino			= $("#ddlDestino").val();
	var instruccion		= $("#ddlInstruccion").val();

	if(tipoMovimiento == "" || tipoMovimiento == -1){
		alert("Seleccione Tipo de Movimiento");
		return false;
	}

	if(instruccion == "" || instruccion < -1){
		alert("Seleccione Tipo de Instrucción");
		return false;
	}

	if(destino == "" || destino == -1){
		alert("Seleccione Destino");
		return false;
	}

	var clabe			= "";
	//var numCuenta		= $("#txtNumCuenta").val();
	var numCuenta		= $("#txtNumCuentaForelo").val();
	var beneficiario	= "";
	var rfc				= "";
	var correo			= "";

	/* si seleccionó banco */
	if(destino == 2){
		clabe			= $("#txtCLABE").val();
		//numCuenta		= $("#txtNumCuenta").val();
		numCuenta		= $("#txtNumCuentaForelo").val();
		beneficiario	= $("#txtBeneficiario").val();
		rfc				= $("#txtRFC").val();
		correo			= $("#txtCorreo").val();

		if(clabe == ""){
			alert("Inserte CLABE");
			return false;
		}
		if(numCuenta == ""){
			alert("Inserte Cuenta");
			return false;
		}
		if(beneficiario == ""){
			alert("Inserte Beneficiario");
			return false;
		}
		if(rfc == ""){
			alert("Inserte RFC");
			return false;
		}
		/*if(correo == ""){
			alert("Inserte Correo Electrónico");
			return false;
		}*/
		if(!validaRFC("txtRFC")){
			alert("El RFC no tiene un formato válido");
			return false;
		}
		if(correo != ""){
			if(!validar_email(correo)){
				alert("El Correo no tiene un formato válido");
				return false;
			}
		}
	}

	$.post("../../../inc/Ajax/_Clientes/CrearConfigCuenta.php",
	{
		tipoMovimiento	: tipoMovimiento,
		destino			: destino,
		instruccion		: instruccion,
		clabe			: clabe,
		numCuenta		: numCuenta,
		beneficiario	: beneficiario,
		rfc				: rfc,
		correo			: correo
	},
	function(resp){
		if(resp.showMessage == 1){
			alert(resp.msg);
		}
		else{
			irAListado();
		}
	}, "json");

}

function crearConfEd(){
	var tipoMovimiento	= $("#ddlTipoMovimiento").val();
	var destino			= $("#ddlDestino").val();
	var instruccion		= $("#ddlInstruccion").val();

	if(!permitirGuardarCta){
		alert("Inserte una CLABE Válida");
		return false;
	}

	if(tipoMovimiento == "" || tipoMovimiento == -1){
		alert("Seleccione Tipo de Movimiento");
		return false;
	}

	if(instruccion == "" || instruccion < -1){
		alert("Seleccione Tipo de Instrucción");
		return false;
	}

	if(destino == "" || destino == -1){
		alert("Seleccione Destino");
		return false;
	}

	var clabe			= "";
	var numCuenta		= $("#txtNumCuenta").val();
	var beneficiario	= "";
	var rfc				= "";
	var correo			= "";

	/* si seleccionó banco */
	if(destino == 1){
		clabe			= $("#txtCLABE").val();
		numCuenta		= $("#txtNumCuenta").val();
		beneficiario	= $("#txtBeneficiario").val();
		rfc				= $("#txtRFC").val();
		correo			= $("#txtCorreo").val();

		if(clabe == ""){
			alert("Inserte CLABE");
			return false;
		}
		if(numCuenta == ""){
			alert("Inserte Cuenta");
			return false;
		}
		if(beneficiario == ""){
			alert("Inserte Beneficiario");
			return false;
		}
		if(rfc == ""){
			alert("Inserte RFC");
			return false;
		}
		/*if(correo == ""){
			alert("Inserte Correo Electrónico");
			return false;
		}*/
		if(!validaRFC("txtRFC")){
			alert("El RFC no tiene un formato válido");
			return false;
		}
		if(correo != ""){
			if(!validar_email(correo)){
				alert("El Correo no tiene un formato válido");
				return false;
			}
		}
	}

	$.post("../../../inc/Ajax/_Clientes/CrearConfigCuenta.php",
	{
		tipoMovimiento	: tipoMovimiento,
		destino			: destino,
		instruccion		: instruccion,
		clabe			: clabe,
		numCuenta		: numCuenta,
		beneficiario	: beneficiario,
		rfc				: rfc,
		correo			: correo
	},
	function(resp){
		if(resp.showMessage == 1){
			alert(resp.msg);
		}
		else{
			irAEditar();
		}
	}, "json");

}

function irANuevaBusqueda(){
	window.location = "../menuConsulta.php";
}

/*
	obj		object : respuesta del servidor
	valida si en el obj se encuentra la propiedad showMsg = 1
*/
function showMsg(obj){
	if(obj.showMsg == 1){
		return true;
	}
	else{
		return false;
	}
}

$(function(){
	if($("#txtEjecutivoCuenta").length){
		autoCompletaEjecutivos("txtEjecutivoCuenta", 5, "ddlEjecutivo");

		var txtejecutivo = $("#txtEjecutivoCuenta");

		$(txtejecutivo).keypress(function(event) {
			return validaCadenaConAcentos(event);
		});

		$(txtejecutivo).bind("paste", function(){return false;})
	}

	if($("#txtEjecutivoVenta").length){
		autoCompletaEjecutivos("txtEjecutivoVenta", 2, "ddlEjecutivoVenta");

		var txtejecutivo = $("#txtEjecutivoVenta");

		$(txtejecutivo).keypress(function(event) {
			return validaCadenaConAcentos(event);
		});

		$(txtejecutivo).bind("paste", function(){return false;})
	}
});



function autoCompletaEjecutivos(txtField, idTipoEjecutivo, idField){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post( "../../inc/Ajax/BuscaEjecutivos.php",
			{
				idTipoEjecutivo	: idTipoEjecutivo,
				texto			: request.term
			},
			function( response ) {
				respond(response);
			}, "json" );					
		},
		minLength: 1,
		focus: function( event, ui ) {
			$("#"+txtField).val(ui.item.nombreCompleto);
			return false;
		},
		select: function( event, ui ) {
			$("#"+ idField).val(ui.item.idUsuario);
			return false;
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		return $( '<li>' )
		.append( "<a>" + item.nombreCompleto + "</a>" )
		.appendTo( ul );
	};
}

/*
	txtField	string	: id del textbox en el cual se va a autocompletar
	idField		string	: id del campo en el que se va a poner el id del item seleccionado
	url			string	: url del archivo php que nos devolverá los datos para la lista
	valueText	string	: nombre del campo devuelto por la consulta que queremos que se visualice en el textbox autocompletable
	valueId		string	: nombre del campo devuelto por la consulta que queremos que se ponga en el campo de idField
	adParams	object	: parametros adicionales ej
	{
		idCadena	: 2
	}
*/
function autoCompletaGeneral(txtField, idField, url, valueTxt, valueId, adParams){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post(url,
				formatParams(adParams, {texto : request.term, term : request.term})
			,
			function( response ) {
				respond(response);
			}, "json" );					
		},
		minLength: 1,
		focus: function( event, ui ) {
			var select = eval("ui.item." + valueTxt);
			$("#"+txtField).val(select);
			return false;
		},
		select: function( event, ui ) {
			var id = eval("ui.item."+valueId);
			$("#"+ idField).val(id);
			return false;
		}
	})
	.data( "ui-autocomplete" )._renderItem = function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + eval("item." + valueTxt) + "</a>" )
		.appendTo( ul );
	};
}

/*
	obj			object : objeto principal al cual se le quieren agregar más propiedades
	newParams	object : objeto con las propiedades que se quieren agregar a obj
*/
function formatParams(obj, newParams){

	if(typeof(obj) == 'object' && typeof(newParams) == 'object'){
		for(var i in newParams){
			obj[i] = newParams[i];
		}

		return obj;
	}
	else{
		alert("Los parámetros recibidos no son de tipo Objeto");
		return false;
	}

}

function irAListado(){
	irAForm('formPase','Listado.php');
}

function analizarCLABEConsulta(){
	var CLABE = $("#txtCLABE").val();
	existenCambios = true;
	if ( CLABE.length == 18 ) {
		var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
		if ( CLABE_EsCorrecta ) {
			$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
			function ( data ) {
				var banco = jQuery.parseJSON( data );
				$("#ddlBanco").val(banco.bancoID);
				console.log(CLABE.substring(6, 17));
				$("#txtNumCuenta").val(CLABE.substring(6, 17));
				permitirGuardarCta = true;
			}
			);
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			permitirGuardarCta = false;
			if ( document.getElementById("guardarCambios") ) {
				$("#guardarCambios").prop("disabled", false);
				permitirGuardarCta = false;
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
$( document ).ready(function() {

//Propiedades de los inputs de texto//
$('#cmbEstado, #cmbMunicipio, #txtPais').prop('disabled', true);

 
$("#nombreComercial").alphanum({
	allow				: '-.,',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});

$("#razonSocial").alphanum({
	allow				: '-.,',
	allowNumeric		: true,
	allowOtherCharSets	: true,
	maxLength			: 50
});

$("#rfc").alphanum({
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 12
});

$("#rfc").attr('style', 'text-transform: uppercase;');

$("#beneficiario").alphanum({
	allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
	allowNumeric		: false,
	allowOtherCharSets	: false,
	maxLength			: 100
});

$("#telefono").prop('maxlength', 10);	
$('#telefono').mask('(00) 0000-0000');

$("#correo").alphanum({
	allow				: '-.@_',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 120
});	

$("#txtCalle").alphanum({
	allow				: 'áéíóúÁÉÍÓÚñÑ',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 50
});

$("#int").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 10
});

$("#ext").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false,
	maxDigits			: 10
});

$("#txtCP").prop('maxlength', 5);
$("#txtCP").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#socioId").prop('maxlength', 9);
$("#socioId").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#comision").prop('maxlength', 6);
$("#comision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});

$("#porcentajeComision").prop('maxlength', 6);
$("#porcentajeComision").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});

$("#liquidacionPagos").prop('maxlength', 6);
$("#liquidacionPagos").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#pagoComisiones").prop('maxlength', 6);
$("#pagoComisiones").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#port").prop('maxlength', 6);
$("#port").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#clabe").prop('maxlength', 18);
$("#clabe").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referencia").prop('maxlength', 10);
$("#referencia").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

$("#referenciaAlfa").alphanum({
	allow				: '-',
	allowNumeric		: true,
	allowOtherCharSets	: false,
	maxLength			: 20
});

$("#numCuenta").prop('maxlength', 4);
$("#numCuenta").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});



$("#adicional").prop('maxlength', 6);
$("#adicional").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : true,
	allowLeadingSpaces  : false
});

$("#liquidacion").prop('maxlength', 2);
$("#liquidacion").numeric({
	allowPlus           : false,
	allowMinus          : false,
	allowThouSep        : false,
	allowDecSep         : false,
	allowLeadingSpaces  : false
});

});


// Se agrega campo de captura del metodo de pago por nuevas disposiciones al pagar facturas //
var  opcionRetencion = "";
/*
$("#retencion").on("change", function(){
	opcionRetencion = $("#retencion option:selected").val();
	
	if(opcionRetencion == 1 ){
		document.getElementById("selectMetodo").style.display="block";
		document.getElementById("labelMetodo").style.display="block";
	}else{
		
		document.getElementById("selectMetodo").style.display="none";
		document.getElementById("labelMetodo").style.display="none";
	}
});*/



	$("#guardarP").click(function () {
		var clabe = $("#clabe").val();
		if(clabe.length == 18){

	//var $this = $(this);
	//$this.button('loading');

	// Extraccion de datos de los inputs y alacenaje en variables //
	var nombreComercial = $("#nombreComercial").val();
	var razonSocial = $("#razonSocial").val();
	var rfc = $("#rfc").val();
	var beneficiario = $("#beneficiario").val();
	var telefono = $("#telefono").val();
	var correo = $("#correo").val();
	var idPais = $("#idPais").val();
	var calle = $("#txtCalle").val();
	var numeroInterior = $("#int").val();
	var numeroExterior = $("#ext").val();
	var codigoPostal = $("#txtCP").val();
	var idColonia = $("#cmbColonia").val();
	var idMunicipio = $("#cmbMunicipio").val();
	var idEstado = $("#cmbEstado").val();
	var comision = $("#comision").val();
	var porcentajeComision = $("#porcentajeComision").val();
	var liquidacionPagos = $("#liquidacionPagos").val();
	var pagoComisiones = $("#pagoComisiones").val();
	var retencion = $("#retencion option:selected").val();
	var clabe = $("#clabe").val();
	var idBanco = $("#idBanco").val();
	var referencia = $("#referencia").val();
	var referenciaAlfa = $("#referenciaAlfa").val();
	var metodoPago = $("#opcionMetodo").val();

	var horaInicial = $("#timepicker1").val();
	var horaFinal = $("#timepicker2").val();
	var host = $("#host").val();
	var port = $("#port").val();
	var user = $("#user").val();
	var password = $("#password").val();
	var remoteFolder = $("#remoteFolder").val();


	if(porcentajeComision != 0){
		porcentajeComision = porcentajeComision / 100;
	}else{
		porcentajeComision = 0;
	}


	// Validacion de campos contengan informacion //

	var lack = "";
	var error = "";

	if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){
		lack +='Nombre Comercial\n';
	}

	if(razonSocial == undefined || razonSocial.trim() == '' || razonSocial <= 0){
		lack +='Razon Social\n';
	}

	if(rfc == undefined || rfc.trim() == '' || rfc <= 0){
		lack +='RFC\n';
	}

	if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){
		lack +='Beneficiario\n';
	}

	if(telefono == undefined || telefono.trim() == '' || telefono <= 0){
		lack +='Telefono\n';
	}

	if(correo == undefined || correo.trim() == '' || correo <= 0){
		lack +='Correo\n';
	}

	if(calle == undefined || calle.trim() == '' || calle <= 0){
		lack +='Calle\n';
	}

	if(numeroExterior == undefined || numeroExterior.trim() == '' || numeroExterior <= 0){
		lack +='Numero Exterior\n';
	}

	if(codigoPostal == undefined || codigoPostal.trim() == '' || codigoPostal <= 0){
		lack +='Codigo Postal\n';
	}

	if(idColonia == undefined || idColonia.trim() == '' || idColonia <= 0){
		lack +='Colonia\n';
	}

	if(comision == undefined || comision.trim() == ''){
		lack +='Comision\n';
	}


	if(liquidacionPagos == undefined || liquidacionPagos.trim() == '' || liquidacionPagos <= 0){
		lack +='Dias para liquidar pagos\n';
	}

	if(pagoComisiones == undefined || pagoComisiones.trim() == '' || pagoComisiones <= 0){
		lack +='Dias para pago de comisiones\n';
	}

	if(retencion == undefined || retencion.trim() == '' || retencion < 0){
		lack +='Retencion de comisiones\n';
	}

	if(clabe == undefined || clabe.trim() == '' || clabe <= 0){
		lack +='Cuenta CLABE\n';
	}


	/*if(opcionRetencion == 1){
		if(metodoPago == undefined || metodoPago.trim() == '' || metodoPago <= 0){
			lack +='Metodo de Pago\n';
		}		
	}*/

	// Mensaje de error en caso de no contener algun valor en la cassilla //
	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		jAlert(black + '\n' + lack+'\n' );
		event.preventDefault();
	}
	else{
		var $this = $(this);
			$this.button('loading');
		// envio de datos para su guaradado en base de datos
		$.post("../../misuerte/ajax/afiliacion.php",{
			nombreComercial,
			razonSocial,
			rfc,
			beneficiario,
			telefono,
			correo,
			idPais,
			calle,
			numeroInterior,
			numeroExterior,
			codigoPostal,
			idColonia,
			idMunicipio,
			idEstado,
			comision,
			porcentajeComision,
			liquidacionPagos,
			pagoComisiones,
			retencion,
			clabe,
			idBanco,
			referencia,
			referenciaAlfa,
			metodoPago,
			horaInicial,
			horaFinal,
			host,
			port,
			user,
			password,
			remoteFolder,
			tipo: 1
		},
		function(response){
			setTimeout("location.reload()", 3000);
			jAlert("informacion guardada exitosamente");
		})
		.fail(function(response){
				$this.button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	})
	}
}else{
	jAlert("La CLABE escrita es incorrecta. Favor de verificarla.");
}
});

$("#guardarC").click(function () {
	
	var clabe = $("#clabe").val();
	if(clabe.length == 18){

	var nombreComercial = $("#nombreComercial").val();
	var razonSocial = $("#razonSocial").val();
	var rfc = $("#rfc").val();
	var beneficiario = $("#beneficiario").val();
	var telefono = $("#telefono").val();
	var correo = $("#correo").val();
	var idPais = $("#idPais").val();
	var calle = $("#txtCalle").val();
	var numeroInterior = $("#int").val();
	var numeroExterior = $("#ext").val();
	var codigoPostal = $("#txtCP").val();
	var idColonia = $("#cmbColonia").val();
	var idMunicipio = $("#cmbMunicipio").val();
	var idEstado = $("#cmbEstado").val();
	var comision = $("#comision").val();
	var porcentajeComision = $("#porcentajeComision").val();
	var liquidacionPagos = $("#liquidacionPagos").val();
	var pagoComisiones = $("#pagoComisiones").val();
	var retencion = $("#retencion option:selected").val();
	var clabe = $("#clabe").val();
	var idBanco = $("#idBanco").val();
	var referencia = $("#referencia").val();
	var referenciaAlfa = $("#referenciaAlfa").val();
	var metodoPago = $("#opcionMetodo").val();
	var socioId = $("#socioId").val();



	if(porcentajeComision != 0){
		porcentajeComision = porcentajeComision / 100;
	}else{
		porcentajeComision = 0;
	}

	// Validacion de campos contengan informacion //
	var lack = "";
	var error = "";

	if(nombreComercial == undefined || nombreComercial.trim() == '' || nombreComercial <= 0){
		lack +='Nombre Comercial\n';
	}

	if(razonSocial == undefined || razonSocial.trim() == '' || razonSocial <= 0){
		lack +='Razon Social\n';
	}

	if(rfc == undefined || rfc.trim() == '' || rfc <= 0){
		lack +='RFC\n';
	}

	if(beneficiario == undefined || beneficiario.trim() == '' || beneficiario <= 0){
		lack +='Beneficiario\n';
	}

	if(telefono == undefined || telefono.trim() == '' || telefono <= 0){
		lack +='Telefono\n';
	}

	if(correo == undefined || correo.trim() == '' || correo <= 0){
		lack +='Correo\n';
	}

	if(calle == undefined || calle.trim() == '' || calle <= 0){
		lack +='Calle\n';
	}

	if(numeroExterior == undefined || numeroExterior.trim() == '' || numeroExterior <= 0){
		lack +='Numero Exterior\n';
	}

	if(codigoPostal == undefined || codigoPostal.trim() == '' || codigoPostal <= 0){
		lack +='Codigo Postal\n';
	}

	if(idColonia == undefined || idColonia.trim() == '' || idColonia <= 0){
		lack +='Colonia\n';
	}

	if(comision == undefined || comision.trim() == '' || comision <= 0){
		lack +='Comision\n';
	}


	if(liquidacionPagos == undefined || liquidacionPagos.trim() == '' || liquidacionPagos <= 0){
		lack +='Dias para liquidar pagos\n';
	}

	if(pagoComisiones == undefined || pagoComisiones.trim() == '' || pagoComisiones <= 0){
		lack +='Dias para pago de comisiones\n';
	}

	if(retencion == undefined || retencion.trim() == '' || retencion < 0){
		lack +='Retencion de comisiones\n';
	}

	if(clabe == undefined || clabe.trim() == '' || clabe <= 0){
		lack +='Cuenta CLABE\n';
	}

	if(socioId == undefined || socioId.trim() == '' || socioId <= 0){
		lack +='Número de Socio\n';
	}


	if(opcionRetencion == 1){
		if(metodoPago == undefined || metodoPago.trim() == '' || metodoPago <= 0){
			lack +='Método de Pago\n';
		}		
	}

	// Mensaje de error en caso de no contener algun valor en la cassilla //
	if(lack != "" || error != ""){
		var black = (lack != "")? "Los siguientes datos son Obligatorios : " : "";
		jAlert(black + '\n' + lack+'\n' );
		event.preventDefault();
	}
	else{

		var $this = $(this);
		$this.button('loading');

		$.post("../../misuerte/ajax/afiliacion.php",{
			nombreComercial,
			razonSocial,
			rfc,
			beneficiario,
			telefono,
			correo,
			idPais,
			calle,
			numeroInterior,
			numeroExterior,
			codigoPostal,
			idColonia,
			idMunicipio,
			idEstado,
			comision,
			porcentajeComision,
			liquidacionPagos,
			pagoComisiones,
			retencion,
			clabe,
			idBanco,
			referencia,
			referenciaAlfa,
			metodoPago,
			socioId,
			tipo: 2
		},
		function(response){
			jAlert("informacion guardada exitosamente");
			setTimeout("location.reload()", 3000);
		})
		.fail(function(response){
				$this.button('reset');
				alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	})
	}
}else{
	jAlert("La CLABE escrita es incorrecta. Favor de verificarla.");
}
});


// Busca las colonias con el codigo postal
$("#txtCP").on('keyup', function(event){
	var value = event.target.value;
	value = value.trim();
	if(value.length == 5){
		$.post(BASE_PATH + '/misuerte/ajax/Afiliacion/buscarColonia.php',
		{
			codigoPostal : value
		},
		function(response){
			if(response.codigoDeRespuesta == 0){
				$('#cmbEstado').on('estadosloaded', function(){
					$("#cmbEstado").val(response.idEntidad);
				});

				$('#cmbMunicipio').on('municipiosloaded', function(){
					$("#cmbMunicipio").val(response.idCiudad);
				});

				cargarEstados($("#idPais").val());
				cargarMunicipios($("#idPais").val(), response.idEntidad);
						//cargarColonias($('#idPais').val(), response.idEntidad, response.idCiudad);
						appendList("cmbColonia", response.listaColonias, {text :'nombreColonia', value : 'idColonia'});
					}
					else{
						limpiaStore("cmbEstado");
						limpiaStore("cmbMunicipio");
						limpiaStore("cmbColonia");

						jAlert(response.mensajeDeRespuesta);
					}
				},
				"json"
				);
	}
	else if(value.length == 0){
		$("#cmbEstado, #cmbMunicipio, #cmbColonia").val(-1);
		limpiaStore("cmbEstado");
		limpiaStore("cmbMunicipio");
		limpiaStore("cmbColonia");
	}
});

//Carga de datos de acuerdo al codigo postal//
function cargarEstados(idPais){
	cargarStore(BASE_PATH+"/misuerte/ajax/Afiliacion/storeEstados.php", "cmbEstado", {idpais : idPais}, {text : 'descEstado', value : "idEstado"}, {}, 'estadosloaded');
}

function cargarMunicipios(idPais, idEstado){
	cargarStore(BASE_PATH+"/misuerte/ajax/Afiliacion/storeMunicipios.php", "cmbMunicipio", {idPais : idPais, idEstado : idEstado}, {text : 'descMunicipio', value : "idMunicipio"}, {}, 'municipiosloaded');
}

// Se analiza la cuenta clabe cuente con los requisitos y se extraen el banco emisor de dicha cuenta //
function analizarCLABE(){
	var CLABE = event.target.value;

	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
				).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("[name='idBanco']").val(banco.bancoID);
					$("[name='txtBanco']").val(banco.nombreBanco);
					$("[name='numCuenta']").val(CLABE.substring(6, 17));			
				});
			}
			else{
				jAlert("La CLABE escrita es incorrecta. Favor de verificarla.");
				$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
			}
		}
		else{
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
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

		if ( digitoVerificador == 10 ) {
			digitoVerificador = 0;
		}

		return CLABE.charAt(17) == digitoVerificador;

	}



function RFCFormato(){ //funcion para  el comportamiento del  texto RFC
	var rfc = event.target.value;

	if(rfc.length == 12){

    	if($('#idPais').val() == 164 & $('#rfc').val().length == 12){ //verifica el formato del rfcde la persona moral es correcto

    		var rfcm = $('#rfc').val();
    		if(verif_rfcm(rfcm) == false){                   
    			jAlert("Capture un RFC valido.");
    			return false;
    		}else{
    			return true
    		}

    	}
    	if($('#idPais').val() == 164 & $('#rfc').val().length < 12){
    		jAlert("Capture un RFC valido.");
    		return false
    	}
    }
}


    function verif_rfcm(rfcs) {  //verifica RFC persona Moral

    	var for_rfc= /^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))/;
    	if(for_rfc.test(rfcs))
    		{ return true; }
    	else 
    		{ return false; }
    }

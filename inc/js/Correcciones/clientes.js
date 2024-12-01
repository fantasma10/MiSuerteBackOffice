$(document).ready(function() {
	initCorreccionCliente();

	function initCorreccionCliente(){
		$("#txtSNombreSubCadena").autocomplete({
			source: function(request,respond){
				$.post( "../../inc/Ajax/_Clientes/Correcciones/clientes_lista.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtSNombreSubCadena").val(ui.item.sNombreSubCadena);
				return false;
			},
			select: function(event,ui){
				$("#txtNIdSubCadena").val(ui.item.nIdSubCadena);
				buscaDatosSubCadena(ui.item.nIdSubCadena);
				resetFormulario();
				return false;
			},
			search: function(){
				resetFormulario();
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>ID :" + item.id + ' ' + item.value + "</a>" )
			.appendTo( ul );
		};

		$('#txtSsNombreCliente').on('change', function(e){
			if(myTrim(e.target.value) == ''){
				$('#txtNIdSubCadena').val('');
			}
		});


		$('#cmbVersion').customLoadStore({
			url				: '../../inc/Ajax/_Clientes/Correcciones/storeVersion.php',
			labelField		: 'sNombreVersion',
			idField			: 'nIdVersion',
			firstItemId		: '-1',
			firstItemValue	: 'Seleccione Versión'
		});

		$('#txtSEmail, #txtSCorreo').alphanum({
			allow				: '@-._',
			allowOtherCharSets	: false,
			allowSpace			: false
		});

		$('#txtNNumCuentaForelo').numeric({
			allowPlus           : false,
			allowMinus          : false,
			allowThouSep        : false,
			allowDecSep         : false,
			allowLeadingSpaces  : false,
			maxDigits           : 15
		});

		$('#txtSTelefono').alphanum({
			allow             	: '-',
			allowOtherCharSets	: false,
			allowNumeric		: true
		});

		$('#cmbRegimen').on('change', function(e){
			var nIdRegimen = e.target.value;

			if(nIdRegimen == 1){
				rowFisico();
			}
			else if(nIdRegimen == 2){
				rowMoral();
			}
			else{
				$('#row-moral, #row-fisico').remove();
			}

		});

		$('#txtSTelefono').val('52-');
		$('#txtSTelefono').mask('00-000-000-0000');

		$('#btnActualizarCliente').on('click', function(){
			guardarCambiosCliente();
		});

		$("#txtNCLABE").keyup(function(event) {
			var clabe = $("#txtNCLABE").val();
			//buscaBancoClabe(clabe);
			analizarCLABEConsulta();
		});

		$("#txtNCLABE").keypress(function(event) {
			var clabe = $("#txtNCLABE").val();
			//buscaBancoClabe(clabe);
			analizarCLABEConsulta();
		});

		$("#txtSNombreBeneficiario").alpha();

		$("#txtSRFCBen").alphanum({
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 13
		});
		$('#txtSRFCBen').css('text-transform', 'uppercase');
		$("#txtNCLABE").numeric();

		var idTipoMovimiento = $("#ddlTipoMovimiento").val();
		$('#ddlInstruccion').customLoadStore({
			url				: '../../inc/Ajax/stores/storeTiposInstruccion2.php',
			labelField		: 'descripcion',
			idField			: 'idTipoInstruccion',
			firstItemId		: '-1',
			firstItemValue	: 'Seleccione',
			params			: {
				idTipoMovimiento : idTipoMovimiento
			}
		});
	}

	function rowMoral(){
		if($('#row-moral').length == 0){
			var row = '<div class="row" id="row-moral">';
			row += '<div class="col-xs-3">';
			row += '<div class="form-group">';
			row += '<label>R.F.C.</label>';
			row += '<input type="text" class="form-control" name="sRFC" id="txtSRFC" maxlength="13" />';
			row += '</div>';
			row += '</div>';
			row += '<div class="col-xs-9">';
			row += '<div class="form-group">';
			row += '<label>Razón Social</label>';
			row += '<input type="text" class="form-control" name="sRazonSocial" id="txtSRazonSocial" maxlength="150" />';
			row += '</div>';
			row += '</div>';
			row += '</div>';
			if($('#row-fisico').length > 0){
				$("#row-fisico").remove();
			}
			$('#first-row-cliente').after(row);
		}

		initRowMoral();
	}

	function initRowMoral(){
		$('#txtSRFC').alphanum({
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 13
		});

		$('#txtSRFC').css('text-transform', 'uppercase');


		$('#txtSRazonSocial').alphanum({
			allow              : 'áéíóúÁÉÍÓÚüÜñÑ.,',
			allowOtherCharSets : false
		});
	}

	function rowFisico(){
		if($('#row-fisico').length == 0){
			var row = '<div class="row" id="row-fisico">';
			row += '<div class="col-xs-3">';
			row += '<div class="form-group">';
			row += '<label>R.F.C.</label>';
			row += '<input type="text" class="form-control" name="sRFC" id="txtSRFC" maxlength="13"/>';
			row += '</div>';
			row += '</div>';
			row += '<div class="col-xs-3">';
			row += '<div class="form-group">';
			row += '<label>Nombre(s)</label>';
			row += '<input type="text" class="form-control" name="sNombre" id="txtSNombre" maxlength="150" />';
			row += '</div>';
			row += '</div>';
			row += '<div class="col-xs-3">';
			row += '<div class="form-group">';
			row += '<label>Apellido Paterno</label>';
			row += '<input type="text" class="form-control" name="sPaterno" id="txtSPaterno" maxlength="45" />';
			row += '</div>';
			row += '</div>';
			row += '<div class="col-xs-3">';
			row += '<div class="form-group">';
			row += '<label>Apellido Materno</label>';
			row += '<input type="text" class="form-control" name="sMaterno" id="txtSMaterno" maxlength="45"/>';
			row += '</div>';
			row += '</div>';
			row += '</div>';

			if($('#row-moral').length > 0){
				$("#row-moral").remove();
			}
			$('#first-row-cliente').after(row);
		}

		initRowFisico();
	}

	function initRowFisico(){

		$('#txtSNombre, #txtSPaterno, #txtSMaterno').alphanum({
			allow              : 'áéíóúÁÉÍÓÚüÜñÑ',
			allowOtherCharSets : false
		});

		$('#txtSRFC').alphanum({
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 13
		});

		$('#txtSRFC').css('text-transform', 'uppercase');

	}

	function buscaDatosSubCadena(nIdCliente){
		$.ajax({
			url			: '../../inc/Ajax/_Clientes/Correcciones/buscaDatosSubCadena.php',
			type		: 'post',
			dataType	: 'json',
			data		: {
				nIdCliente : nIdCliente
			},
		})
		.done(function(resp){
			if(resp.bExito == false){
				alert(resp.sMensaje);
			}
			else{
				var data = resp.data;
				$('#txtSTelefono').val(data.telefono1);
				$('#txtSEmail').val(data.email);
				$('#txtNNumCuentaForelo').val(data.nNumCuentaForelo);
				$('#txtSTelefono').mask('00-000-000-0000');

			}
		})
		.fail(function(){
			console.log("error");
		});

	}

	function guardarCambiosCliente(){
		var params = $('#frmCapturaCliente').getSimpleParams();

		console.log(params);

		if(params.nIdSubCadena == undefined || params.nIdSubCadena == '' || params.nIdSubCadena <= 0){
			alert('Seleccione un Cliente');
			return false;
		}

		if(params.nIdVersion == undefined || params.nIdVersion == '' || params.nIdVersion <= 0){
			alert('Seleccione Versi\u00F3n');
			return false;
		}

		if(params.nIdRegimen == undefined || params.nIdRegimen == '' || params.nIdRegimen <= 0){
			alert('Seleccione R\u00E9gimen Fiscal');
			return false;
		}

		if(params.nNumCuentaForelo == undefined || params.nNumCuentaForelo == '' || params.nNumCuentaForelo <= 0){
			alert('Capture Cuenta de Forelo');
			return false;
		}

		if(params.sRFC == undefined || params.sRFC == ''){
			alert('Capture RFC');
			return false;
		}
		else{
			if((params.nIdRegimen == 2 && params.sRFC.length != 12) || (params.nIdRegimen == 1 && params.sRFC.length != 13)){
				alert('El Formato del RFC es Inv\u00E1lido');
				return false;
			}
			params.sRFC = params.sRFC.toUpperCase();
			if(!isValidRFC(params.sRFC)){
				alert('El Formato del RFC es Inv\u00E1lido');
				return false;
			}
		}

		if(params.nIdRegimen == 1){
			if(params.sNombre == undefined || params.sNombre == ''){
				alert('Capture Nombre');
				return false;
			}
			else{
				params.sNombre = $('#txtSNombre').val();
				if(params.sNombre.length < 3){
					alert('El Nombre debe ser m\u00EDnimo de 3 caracteres');
					return false
				}
				if(params.sNombre.length > 150){
					alert('El Nombre debe ser m\u00E1ximo de 150 caracteres');
					return false
				}
			}

			if(params.sPaterno == undefined || params.sPaterno == ''){
				alert('Capture Apellido Paterno');
				return false;
			}
			else{
				params.sPaterno = $('#txtSPaterno').val();
				if(params.sPaterno.length < 3){
					alert('El Apellido Paterno debe ser m\u00EDnimo de 3 caracteres');
					return false
				}
				if(params.sPaterno.length > 45){
					alert('El Apellido Paterno debe ser m\u00E1ximo de 45 caracteres');
					return false
				}
			}

			if(params.sMaterno == undefined || params.sMaterno == ''){
				alert('Capture Apellido Materno');
				return false;
			}
			else{
				params.sMaterno = $('#txtSMaterno').val();
				if(params.sMaterno.length < 3){
					alert('El Apellido Materno debe ser m\u00EDnimo de 3 caracteres');
					return false
				}
				if(params.sMaterno.length > 45){
					alert('El Apellido Materno debe ser m\u00E1ximo de 45 caracteres');
					return false
				}
			}
		}
		if(params.nIdRegimen == 2){
			if(params.sRazonSocial == undefined || params.sRazonSocial == ''){
				alert('Capture Raz\u00F3n Social');
				return false;
			}
			else{
				params.sRazonSocial = $('#txtSRazonSocial').val();
				if(params.sRazonSocial.length < 3){
					alert('La Raz\u00F3n Social debe ser m\u00EDnimo de 3 caracteres');
					return false
				}
				if(params.sRazonSocial.length > 150){
					alert('La Raz\u00F3n Social debe ser m\u00E1ximo de 150 caracteres');
					return false
				}
			}
		}

		if(params.sTelefono == undefined || params.sTelefono == ''){
			alert('Capture Telefono');
			return false;
		}

		if(params.sEmail == undefined || params.sEmail == ''){
			alert('Capture Correo Electr\u00F3nico');
			return false;
		}
		else{
			params.sEmail = $('#txtSEmail').val();
			if(!esCorreoValido(params.sEmail)){
				alert('El Formato del Correo Electr\u00F3nico es Inv\u00E1lido');
				return false;
			}
		}

		var arrTipoReembolso		= $('#frmCapturaCliente :radio[name=nIdTipoReembolso]:checked');
		var nLengthTipoReembolso	= arrTipoReembolso.length;

		if(nLengthTipoReembolso <= 0){
			alert('Seleccione un Tipo de Reembolso');
			return false;
		}

		params.nIdTipoReembolso = $('#frmCapturaCliente :radio[name=nIdTipoReembolso]:checked')[0].value;

		var arrTipoComision		= $('#frmCapturaCliente :radio[name=nIdTipoComision]:checked');
		var nLengthTipoComision	= arrTipoComision.length;

		if(nLengthTipoComision <= 0){
			alert('Seleccione un Tipo de Comision');
			return false;
		}

		params.nIdTipoComision = $('#frmCapturaCliente :radio[name=nIdTipoComision]:checked')[0].value;

		var arrTipoLiquidacionReembolso		= $('#frmCapturaCliente :radio[name=nIdTipoLiquidacionReembolso]:checked');
		var nLengthTipoLiquidacionReembolso	= arrTipoLiquidacionReembolso.length;

		if(nLengthTipoLiquidacionReembolso <= 0){
			alert('Seleccione Pago de Reembolso');
			return false;
		}

		params.nIdTipoLiquidacionReembolso = $('#frmCapturaCliente :radio[name=nIdTipoLiquidacionReembolso]:checked')[0].value;

		var arrTipoLiquidacionComision		= $('#frmCapturaCliente :radio[name=nIdTipoLiquidacionComision]:checked');
		var nLengthTipoLiquidacionComision	= arrTipoLiquidacionComision.length;

		if(nLengthTipoLiquidacionComision <= 0){
			alert('Seleccione Pago de Comision');
			return false;
		}

		params.nIdTipoLiquidacionComision = $('#frmCapturaCliente :radio[name=nIdTipoLiquidacionComision]:checked')[0].value;

		if(params.nIdTipoMovimiento == undefined || params.nIdTipoMovimiento == '' || params.nIdTipoMovimiento < 0){
			alert('Seleccione Tipo de Movimiento');
			return false;
		}

		if(params.nIdTipoInstruccion == undefined || params.nIdTipoInstruccion == '' || params.nIdTipoInstruccion < -1){
			alert('Seleccione Tipo de Instrucci\u00F3n');
			$('#ddlInstruccion').focus();
			return false;
		}

		if(params.nIdDestino == undefined || params.nIdDestino == '' || params.nIdDestino < 0){
			alert('Seleccione Destino');
			$('#ddlInstruccion').focus();
			return false;
		}

		if(params.nIdTipoLiquidacionReembolso == 2 || params.nIdTipoLiquidacionComision == 2 || params.ddlDestino == 2){
			if(params.nClabe == undefined || params.nClabe == ''){
				alert('Capture Clabe');
				$('#txtNCLABE').focus();
				return false;
			}

			if(params.sNombreBeneficiario == undefined || params.sNombreBeneficiario == ''){
				alert('Capture Nombre de Beneficiario');
				$('#txtSNombreBeneficiario').focus();
				return false;
			}

			params.sNombreBeneficiario = $('#txtSNombreBeneficiario').val();

			if(params.sRfcBen == undefined || params.sRfcBen == ''){
				alert('Capture RFC de Beneficiario');
				$('#txtSRFCBen').focus();
				return false;
			}

			params.sRfcBen = params.sRfcBen.toUpperCase();
			if(!isValidRFC(params.sRfcBen)){
				alert('El Formato del RFC del Beneficiario es Inv\u00E1lido');
				$('#txtSRFCBen').focus();
				return false;
			}

			if(params.sCorreoBen == undefined || params.sCorreoBen == ''){
				alert('Capture Correo del Beneficiario');
				$('#txtSCorreo').focus();
				return false;
			}

			params.sCorreoBen = $('#txtSCorreo').val();
		}

		$.ajax({
			url			: '../../inc/Ajax/_Clientes/Correcciones/guardaCambiosCliente.php',
			type		: 'post',
			dataType	: 'json',
			data		: params
		})
		.done(function(resp){
			if(resp.bExito == false){
				alert(resp.sMensaje);
			}
			else{
				if($('#frmCliente').length == 0){
					var form = '<form id="frmCliente" method="post" target="_blank" action="'+location.protocol+'//'+location.host+'/_Clientes/SubCadena/ListadoCliente.php">';
					form += '<input type="hidden" name="idCliente"/>';
					form += '</form>';

					$('body').append(form);
				}

				$('#frmCliente :input[name=idCliente]').val(resp.data.idCliente);
				$('#frmCliente').submit();
			}
		})
		.fail(function(resp){
			console.log("error");
		});

	}

	function isValidRFC(strRFC){
		var pattern = '';
		if(strRFC.length == 12)
		{
			pattern = /^([A-Z|]{3}\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)|([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$|^([A-Z|a-z]{4}\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)|([02468][048]|[13579][26])0229)((\w{2})([A-z|a-z|0-9]{1})){0,3}$/;
		}
		else
		{
			pattern = /^([A-Z|]{3}\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)|([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$|^([A-Z|a-z]{4}\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)|([02468][048]|[13579][26])0229)((\w{2})([A-z|a-z|0-9]{1})){0,3}$/;
		}
	    return pattern.test(strRFC);
	}

	function esCorreoValido( email ) {
		var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(expr.test(email)){
			return true;
		}
		else{
			return false;
		}
	}

});
/*$.fn.customLoadStore = function(oCfg){
	var $cmb = $(this.selector);

	$(this.selector).customEmptyStore(oCfg);

	if(oCfg.url != undefined && oCfg.url.trim() != ''){
		$.ajax({
			url			: oCfg.url,
			type		: 'POST',
			dataType	: 'json',
			data		: oCfg.params || {}
		})
		.done(function(resp, msg) {

			if(resp.nCodigo == 0){
				if(oCfg.arrResultName != undefined && oCfg.arrResultName.trim() != ''){
					var arrResult = eval("resp ." + oCfg.arrResultName);
				}
				else{
					var arrResult = resp.data;
				}

				for(var index = 0; index < arrResult.length; index++){
					var oElemento	= arrResult[index];
					var option		= document.createElement("option");
					option.text		= eval("oElemento." + oCfg.labelField);
					option.value	= eval("oElemento." + oCfg.idField);
					$cmb.append(option);
				}
			}
		})
		.fail(function(resp) {
			console.log(resp, "error");
		})
		.always(function() {
			console.log("complete");
		});

	}
}

$.fn.customEmptyStore = function(oCfg){
	var $cmb = $(this.selector);
	$cmb.empty();

	if(oCfg.firstItemId != undefined && oCfg.firstItemId != '' && oCfg.firstItemValue != undefined && oCfg.firstItemValue != ''){
		$cmb.append('<option value="' + oCfg.firstItemId + '">' + oCfg.firstItemValue + '</option>');
	}
}

$.fn.getSimpleParams = function(){
	var objParams	= {};
	var serialized	= $(this.selector + ' :input').serialize();
	var elements	= serialized.split("&");

	for(i=0; i<elements.length;i++){
		var element = elements[i].split("=");
		var name	= element[0];
		var value	= element[1];

		var inputActual = $(this.selector + ' :input[name=' + name + ']');

		if($(inputActual).attr('type') == "checkbox"){
			value = ($(inputActual).is(':checked'))? 1 : 0;
		}

		if(value != undefined){
			value = value.replace(/\+/g, " ")
		}
		else{
			value = '';
		}
		objParams[name] = myTrim(value);
	}

	var disabledEls = $(this.selector + ' :disabled');
	for(i=0; i<disabledEls.length; i++){
		var valor = $(disabledEls[i]).val();
		var name = $(disabledEls[i]).attr('name');
		objParams[name] = (valor != undefined)? valor.replace(/\+/g, " ") : '';
	}

	return objParams;
}*/

function buscaBancoClabe(CLABE){
	$.post("../../inc/Ajax/_Clientes/BuscaBanco.php",
	{
		CLABE : CLABE,
	},
	function(resp){
		if(resp.showMessage == 1){
			alert(resp.msg);
		}
		else{
			$("#txtBanco").val(resp.data.nombreBanco);
		}
	}, "json");
}

function analizarCLABEConsulta(){
	var CLABE = $("#txtNCLABE").val();

	if ( CLABE.length == 18 ) {
		var CLABE_EsCorrecta = validarDigitoVerificador( CLABE );
		if ( CLABE_EsCorrecta ) {
			$.post( '../../inc/Ajax/_Clientes/getBancoCLABE.php', { "CLABE": CLABE } ).done(
			function ( data ) {
				var banco = jQuery.parseJSON( data );
				$("#txtNIdBanco").val(banco.bancoID);
				$("#txtSNombreBanco").val(banco.nombreBanco);
				$("#txtNNumCuenta").val(CLABE.substring(6, 17));
				permitirGuardarCta = true;
			}
			);
		} else {
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
		}
	} else {
		$("#txtNIdBanco").val(0);
		$("#txtSNombreBanco").val('');
		$("#txtNNumCuenta").val('');
	}
}

function resetFormulario(){
	$('#cmbVersion').val('-1');
	$('#cmbRegimen').val(0);
	$('#cmbRegimen').trigger('change');
	$('#txtNNumCuentaForelo').val('');
	$('#txtSTelefono').val('');
	$('#txtSEmail').val('');
	$('#frmCapturaCliente :input[name=nIdTipoReembolso]').prop('checked', false);
	$('#frmCapturaCliente :input[name=nIdTipoComision]').prop('checked', false);
	$('#frmCapturaCliente :input[name=nIdTipoLiquidacionReembolso]').prop('checked', false);
	$('#frmCapturaCliente :input[name=nIdTipoLiquidacionComision]').prop('checked', false);
	$('#ddlInstruccion').val(-1);
	$('#ddlDestino').val(-1);
	$('#txtNCLABE').val('');
	$('#txtSNombreBanco').val('');
	$('#txtNNumCuenta').val('');
	$('#txtSNombreBeneficiario').val('');
	$('#txtSRFCBen').val('');
	$('#txtSCorreo').val('');
}

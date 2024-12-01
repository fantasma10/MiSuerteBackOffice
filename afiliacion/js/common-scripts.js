function myTrim(txt){
	if(txt != undefined && typeof txt == 'string'){
		return txt.trim();
	}
	else if(txt != undefined && typeof txt == 'number'){
		return txt;
	}
	else{
		return '';
	}
}

$.fn.getSimpleParams = function(){
	var objParams	= {};
	var disabled	= $(this.selector).find(':input:disabled').removeAttr('disabled');
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
			if(typeof value == "string"){
				value = value.replace(/\+/g, " ");
				value = value.replace(/%3A/g, ":");
			}
		}
		else{
			value = '';
		}
		objParams[name] = (typeof value != "number")? myTrim(value) : value;
	}

	var disabledEls = $(this.selector + ' :disabled');
	for(i=0; i<disabledEls.length; i++){
		var valor = $(disabledEls[i]).val();
		var name = $(disabledEls[i]).attr('name');
		objParams[name] = (valor != undefined)? valor.replace(/\+/g, " ") : '';
	}

	disabled.attr('disabled','disabled');
	return objParams;
}

function isValidEmail( email ) {
	var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(expr.test(email)){
		return true;
	}
	else{
		return false;
	}
}


function validaRFC(str){

	if(str.length >= 3){

		var extractF= str.substring(0,4);
		var extractM= str.substring(0,3);

		var pattern = /^[A-Z]+$/;

		if(pattern.test(extractF)){
			return 1;
		}
		else if(pattern.test(extractM)){
			return 2;
		}

	}
	return 0;
} // validaRFC

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

$.fn.customLoadStore = function(oCfg){
	var $cmb = $(this.selector);

	$(this.selector).customEmptyStore(oCfg);

	if(oCfg.url != undefined && oCfg.url.trim() != ''){
		$.ajax({
			url			: oCfg.url,
			type		: 'POST',
			dataType	: 'json',
			data		: oCfg.params || {}
		})
		.done(function(resp, msg){

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
				$cmb.trigger('load', [arrResult]);
			}
		})
		.fail(function(resp) {
			console.error(resp, "error");
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

/*
	funcion basica para validar que no vengan vacios los campos, minimos y maximos de longitud y alguna funcion especial como validar correo valido
	recibe como parametro un objeto con la propiedad 'lista', donde viene contenido un arreglo de objetos.
	cfg = {
		lista	: [
			{
				name			: 'sNombreCadena',
				sLabel			: 'Cadena',
				type			: 'text',
				maxLength		: 100,
				minLength		: 3,
				allowBlank		: false,
				blankMsg		: 'Capture Nombre de Cadena.',
				maxLengthMsg	: 'La longitud Máxima para la Cadena es de {nChars} Caracteres',
				minLengthMsg	: 'La longitud Minima para la Cadena es de {nChars} Caractferes'
			},{
				name			: 'sEmail',
				sLabel			: 'Email',
				type			: 'text',
				maxLength		: 100,
				minLength		: 5,
				allowBlank		: false,
				blankMsg		: 'Capture Email.',
				maxLengthMsg	: 'La longitud Máxima para el Email es de {nChars} Caracteres',
				minLengthMsg	: 'La longitud Minima para el Email es de {nChars} Caracteres',
				validationTypes	: ['email'],
				validationMsgs	: ['Capture un Email Valido.']
			}
		]
	}
*/
$.fn.simpleValidate = function(cfg){
	var elements = cfg.lista;

	DEFAULT_BLANK_MSG		= cfg.DEFAULT_BLANK_MSG || " could not be empty.";
	DEFAULT_MAXLENGTH_MSG	= cfg.DEFAULT_MAXLENGTH_MSG || " is larger than ";
	DEFAULT_MINLENGTH_MSG	= cfg.DEFAULT_MINLENGTH_MSG || " is shorter than ";
	DEFAULT_VALIDATION_MSG	= cfg.DEFAULT_VALIDATION_MSG || " wrong format : ";

	for(var index=0; index < elements.length; index++){
		var element = elements[index];
		var elName	= element.name;

		var el = $(this).find(':input[name='+ elName +']');

		if(el != undefined){

			var value		= ($(el).val() != undefined)? $(el).val() : '';
			var minValue	= (element.minValue != undefined)? element.minValue : 1;

			if(element.type == 'text' && element.allowBlank != undefined && element.allowBlank == false){
				if(value == undefined || myTrim(value) == ''){
					alert(element.blankMsg || (element.sLabel + DEFAULT_BLANK_MSG));
					return false;
				}
			}

			if(element.type == 'select' && element.allowBlank != undefined && element.allowBlank == false){
				if(value == undefined || myTrim(value) == '' || myTrim(value) < minValue){
					alert(element.blankMsg || (element.sLabel + DEFAULT_BLANK_MSG));
					return false;
				}
			}

			if(((element.allowBlank != undefined && element.allowBlank == false) || value != undefined) && element.maxLength != undefined && element.maxLength > 0){
				if(myTrim(value) != '' && value.length > element.maxLength){
					if(element.maxLengthMsg != undefined){
						alert(element.maxLengthMsg.replace('{nChars}', element.maxLength));
						return false;
					}
					else{
						alert(element.sLabel + DEFAULT_MAXLENGTH_MSG + element.maxLength);
						return false;
					}
				}
			}

			if(((element.allowBlank != undefined && element.allowBlank == false) || value != undefined) && element.minLength != undefined && element.minLength > 0){
				if(myTrim(value) != '' && value.length < element.minLength){
					if(element.minLengthMsg != undefined){
						alert(element.minLengthMsg.replace('{nChars}', element.minLength));
						return false;
					}
					else{
						alert(element.sLabel + DEFAULT_MINLENGTH_MSG + element.minLength);
						return false;
					}
				}
			}

			if(((element.allowBlank != undefined && element.allowBlank == false) || value != undefined) && element.validationTypes != undefined && Array.isArray(element.validationTypes) == true && Array.isArray(element.validationMsgs) == true){
				var validationTypes = element.validationTypes;

				for(var idx = 0; idx < validationTypes.length; idx++){
					var validationType = (validationTypes[idx] != undefined && myTrim(validationTypes[idx]) != '')? myTrim(validationTypes[idx]) : '';

					switch(validationType){
						case 'email':
							if(!isValidEmail(value)){
								var validationMsg = (element.validationMsgs[idx] != undefined && myTrim(element.validationMsgs[idx]))? myTrim(element.validationMsgs[idx]) : '';
								alert(validationMsg || DEFAULT_VALIDATION_MSG + element.sLabel);
								return false;
							}
						break;
						case 'rfc':
							if(!isValidRFC(value)){
								var validationMsg = (element.validationMsgs[idx] != undefined && myTrim(element.validationMsgs[idx]))? myTrim(element.validationMsgs[idx]) : '';
								alert(validationMsg || DEFAULT_VALIDATION_MSG + element.sLabel);
								return false;	
							}
						break;
					} // switch
				} // for
			}
		}
	}

	return true;
} // simpleValidate


/*
	funcion basica para seter el alphanum

	cfg = {

		lista	: [
			{
				name			: 'sNombreCadena',	#obligatorio
				alphanum		: 'alphanum',
				allowChars		: '@.-_',
				maxLength		: 100
			}
	}
*/
$.fn.iniciarAlphanum = function(cfg){
	var elements = cfg.lista;

	for(var index=0; index < elements.length; index++){
		var element = elements[index];
		var elName	= element.name;

		var el = $(this).find(':input[name='+ elName +']');

		if(element.alphanum != undefined && myTrim(element.alphanum) != ''){

			var allowChars	= (element.allowChars != undefined && myTrim(element.allowChars) != '')? myTrim(element.allowChars) : '';
			var maxLength	= (element.maxLength != undefined && element.maxLength != '')? element.maxLength : '';

			switch(element.alphanum){
				case 'alphabetic':
					$(el).alpha({
						allow				: allowChars,
						maxLength			: maxLength,
						allowOtherCharSets	: false
					});
				break;
				case 'numeric':
					$(el).numeric({
						allowMinus		: false,
						allowThouSep	: false,
						allowDecSep		: false,
					});
				break;
				case 'alphanum':
					$(el).alphanum({
						allow				: allowChars,
						maxLength			: maxLength,
						allowOtherCharSets	: false
					});
				break;
			}
		}
	} // for
} // iniciarAlphanum


/*====================================================================================================*/
/* esta funcion valida las fechas con formatos    AAAA/MM/DD    en el onkeypress					  */
/*====================================================================================================*/
function validaFecha(e,txt){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 
		
	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 4:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 7:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			default:
				if(tecla < 48 && tecla != 8){
					return false;
				}if(tecla > 57){
					return false;
				}
				return true;
			break;
		}
		
		return true;
	}
	return false;
}

/*====================================================================================================*/
/* esta funcion valida las fechas con formatos    AAAA/MM/DD    en el onkeyup						  */
/*====================================================================================================*/
function validaFecha2(e,txt){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; 

	if(tecla != 8){
		txtVal =  document.getElementById(txt).value;
			//if(txt.indexOf(".") > -1 && (tecla==45))
				//return false;
				//alert(txt.length);
		switch(txtVal.length){
			case 4:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 7:
				 document.getElementById(txt).value = txtVal+"-";
			break;
		}
	}
}

$.fn.fillForm = function(obj){
	var $form = $(this.selector);

	var arrInputs = $form.find(':input');

	var index		= 0;
	var totalInputs	= arrInputs.length;

	for(index=0; index < totalInputs; index++){
		var inputEl = arrInputs[index];
		var name	= inputEl.name;
		if(name != undefined && name != ""){
			var valor = eval("obj." + name);

			if(valor != undefined && myTrim(valor) != ''){
				inputEl.value = valor;
			}
		}
	}
}

function validarsession(e){
	$.ajax({
		url			: BASE_PATH + '/inc/ajax/session.inc.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {},
	})
	.done(function(response){
		if(response.bExito == false){
			if(response.nCodigo == 999){
				alert(response.sMensajeDetallado);
				window.location = BASE_PATH + '/';
			}
		}
	})
	.fail(function(){
		console.log('fail error');
	});
	
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

function normalize(str){
	var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇçABCDEFGHIJKLMNOPQRSTUVWXYZ", 
	to		 = "aaaaaeeeeiiiioooouuuuaaaaaeeeeiiiioooouuuunnccabcdefghijklmnopqrstuvwxyz",
	mapping = {};

	for(var i = 0, j = from.length; i < j; i++)
		mapping[ from.charAt( i ) ] = to.charAt( i );


	var ret = [];
	for(var i = 0, j = str.length; i < j; i++){
		var c = str.charAt( i );
		if(mapping.hasOwnProperty(str.charAt(i)))
			ret.push(mapping[c]);
		else
		ret.push(c);
	}
	return ret.join( '' );
}

function quitarEspacios(str){
	return str.replace(/ /g,"");
}


function isValidTINEIN(tinein){
	var patternTIN = /^\d{3}-\d{2}-\d{4}$/;
	var patternEIN = /^\d{2}-\d{7}$/;
	
	if(tinein.length == 11){
		var pattern = patternTIN;
	}
	else if(tinein.length == 10){
		var pattern = patternEIN;
	}

	return pattern.test(tinein);
}

function validarFormatoPasaporte(sNumeroIdentificacion) {
	var formatoPasaporte1 = /^[0-9{8}]*[a-zA-Z]{1}[0-9{8}]*$/i;
	var formatoPasaporte2 = /[0-9]{11}/i;

	if ( !((sNumeroIdentificacion.length == 9 && sNumeroIdentificacion.match(formatoPasaporte1))
	|| (sNumeroIdentificacion.length == 11 && sNumeroIdentificacion.match(formatoPasaporte2))) ) {
		return false;
	}
	
	return true;
}

function validarFormatoIFE(sNumeroIdentificacion) {
	var formatoIFE = /^(\d{9}|\d{10}|\d{13})$/i;

	if ( !sNumeroIdentificacion.match(formatoIFE) ) {
		return false;
	}
	
	return true;
}

function validarFormatoCedulaProfesional(sNumeroIdentificacion) {
	var formatoCedula = /^\d{8}$/i;

	if(!sNumeroIdentificacion.match(formatoCedula)){
		return false;
	}
	
	return true;
}

function validarFormatoCartillaMilitar(sNumeroIdentificacion) {
	var formatoCedula = /^([a-zA-Z]{1}\-\d+)$/i;
	var formatoCedula = /^([a-zA-Z]{1}\d+)$/i;

	if(!sNumeroIdentificacion.match(formatoCedula)){
		return false;
	}
	
	return true;
}

function ValidateInputInt(element, e)
{
	if(e.which == 13 || e.which == 8) 
	{
		e.preventDefault();
        return;
    }
	
	var yourInput = $(element).val();
	//	re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
	re = /[^0-9]/g;
	var isSplChar = re.test(yourInput);
	if(isSplChar)
	{
		//var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
		var no_spl_char = yourInput.replace(/[^0-9]/g,'');
		
		$(element).val(no_spl_char);
	}

}

function ValidateInputTxtInt(element, e)
{
	if(e.which == 13 || e.which == 8) 
	{
		e.preventDefault();
        return;
    }
	
	var yourInput = $(element).val();
	//	re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
	re = /[^0-9a-zA-Z\s]/g;
	var isSplChar = re.test(yourInput);
	if(isSplChar)
	{
		//var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
		var no_spl_char = yourInput.replace(re,'');
		
		$(element).val(no_spl_char);
	}
}

function mostrarErrorGeneral(){
	$().toastmessage('showToast', {
		text		: 'Ha ocurrido un Error, intente de Nuevo más tarde',
		sticky		: false,
		position	: 'top-center',
		type		: 'error'
	});
}

/*

la fecha debe venir asi yyyy-mm-dd

*/
function sumaDias(days, fecha){
	var date	= new Date(fecha);
	var newdate = new Date(date);

	newdate.setDate(newdate.getDate() + days);

	var dd	= newdate.getDate();
	var mm	= newdate.getMonth() + 1;
	var y	= newdate.getFullYear();

	mm	= (mm < 10)? '0'+mm : mm;
	dd	= (dd < 10)? '0'+dd : dd;	

	var finalDate = y + '-' + mm + '-' + dd;

	return finalDate;
}

function fechaHoy(){
	var today	= new Date();
	var yyyy	= today.getFullYear();
	var mm		= today.getMonth();
	var dd		= today.getDate();

	mm++;

	mm	= (mm < 10)? '0'+mm : mm;
	dd	= (dd < 10)? '0'+dd : dd;

	return yyyy + '-' + mm + '-' + dd;
}

function soloNumeros(str){
	return str.replace(/[^0-9]/g, "");
}

function showToastMsg(msg, type){
	$().toastmessage('showToast', {
		text		: msg,
		sticky		: false,
		position	: 'top-center',
		type		: type || 'warning'
	});
}

function calcular_edad(fecha) {
    var fechaActual	= new Date()
    var diaActual	= fechaActual.getDate();
    var mmActual	= fechaActual.getMonth() + 1;
    var yyyyActual	= fechaActual.getFullYear();
    var FechaNac	= fecha.split("-");
    var diaCumple	= FechaNac[2];
    var mmCumple	= FechaNac[1];
    var yyyyCumple	= FechaNac[0];

    if (mmCumple.substring(0,1) == 0) {
	    mmCumple= mmCumple.substring(1, 2);
    }

    if (diaCumple.substring(0, 1) == 0) {
	    diaCumple = diaCumple.substring(1, 2);
    }
    var edad = yyyyActual - yyyyCumple;

    if ((mmActual < mmCumple) || (mmActual == mmCumple && diaActual < diaCumple)) {
	    edad--;
    }
    return edad;
}

function validate_fechaMayorQue(fecha1,fecha2){
    valuesStart=fecha1.split("-");
    valuesEnd=fecha2.split("-");

    // Verificamos que la fecha no sea posterior a la actual
    var dateStart=new Date(valuesStart[0],(valuesStart[1]-1),valuesStart[2]);
    var dateEnd=new Date(valuesEnd[0],(valuesEnd[1]-1),valuesEnd[2]);
    if(dateStart>=dateEnd)
    {
        return 0;
    }
    return 1;
}

function validarEntero(str){
	var pattern = /^[0-9]+$/;
	return pattern.test(str);
}

function verif_curp(curps) { 

var for_curp=/(^[A-Z]{4})(\d\d)(0[1-9]|0[12])(0[1-9]|[12]\d|3[01])[HM]([A-Z]{5})(\d\d)?$/;
if(for_curp.test(curps))
{ return true ; }
else { return false ; }
}
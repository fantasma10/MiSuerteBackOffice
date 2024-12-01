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

				$cmb.trigger('storeLoaded');
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

function fnHoy(){
	var date	= new Date();
	var yyyy	= date.getFullYear();
	var mm		= date.getMonth()+1;
	var dd		= date.getDate();

	if(mm < 10){
		mm = '0' + mm;
	}

	if(dd < 10){
		dd = '0' + dd;
	}

	return yyyy + '-' + mm + '-' + dd;
}

function restaFechas(f1,f2){
	var aFecha1 = f1.split('-');
	var aFecha2 = f2.split('-');
	var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
	var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);

	var dif = fFecha2 - fFecha1;

	var dias = Math.floor(dif / (1000 * 60 * 60 * 24));

	return dias;
}

function showSpinner(){
	var html_spinner = '<div id="spinner" class="spinner" style="display:none;position: fixed;top: 0%;z-index: 1234567;overflow: auto;width: 100%;height: 100%;background-color: rgba(0, 0, 0, 0.6);background-color: rgb(0, 0, 0);background-color: rgba(0, 0, 0, 0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";"><img id="img-spinner" src="'+BASE_PATH+'/img/loading.gif" alt="Loading" style="position:fixed;margin-top:25%;margin-left:48%;padding:5px;background-color:#FFFFFF;"/></div>';

	if($('#spinner').length == 0){
		$('body').append(html_spinner);
	}
	$('#spinner').fadeIn();
}

function hideSpinner(){
	if($('#spinner').length > 0){
		$('#spinner').fadeOut();
	}
}

function customGetSelectedOptionText(cmb){
	if(cmb == undefined){
		return '';
	}
	if(cmb.selectedIndex >= 0){
		return cmb[cmb.selectedIndex].text;
	}
	else{
		if(cmb.tagName == 'INPUT'){
			return cmb.value;
		}
		else{
			return '';
		}
	}
}

function validarDigitoV( CLABE ) {
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

	if(digitoVerificador == 10){
		digitoVerificador = 0;
	}
	
	return CLABE.charAt(17) == digitoVerificador;
	
}

function validateCardNumber(sTarjeta){
	// 1. Convert to string
	// 2. Split with empty string so it splits character by character
	var pieces = sTarjeta.toString().split('');

	// pieces = ["4", "5", "3", "2", "8", "1", "4", "1", "4", "8", "9", "3", "7", "8", "2", "7"]
	// In the above array, every item is a string. So we will convert them to number when we want to process on them

	// pop() removes last item and returns it
	var checksum = Number(pieces.pop());

	// Reverse the array for looping convenience
	pieces.reverse();

	var total = 0;

	for (var i = 0; i < pieces.length; i++) {

	    // Convert the current number to integer
	    pieces[i] = Number(pieces[i]);

	    // If alternative number
	    if (i % 2 === 0) {
	        // Double it
	        pieces[i] = pieces[i] * 2;
	        // If result is greater than 9 then sum it or else just subtract by 9, the result is same
	        if (pieces[i] > 9) {
	            pieces[i] -= 9;
	        }
	    }

	    // Add to total for sum of all the numbers
	    total += pieces[i];

	}

	if ((total * 9) % 10 == checksum) {
	    return true;
	} else {
	    return false;
	}
}
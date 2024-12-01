/*$(function(){
	$(".modal").attr("data-backdrop", "static");
});*/

/*---barra izquierda----*/
$(function() {
	$('#nav-accordion').dcAccordion({
		eventType: 'click',
		autoClose: true,
		saveState: true,
		disableLink: true,
		speed: 'slow',
		showCount: false,
		autoExpand: true,
//        cookie: 'dcjq-accordion-1',
		classExpand: 'dcjq-current-parent'
	});
});

var Script = function () {

//    sidebar dropdown menu auto scrolling

	jQuery('#sidebar .sub-menu > a').click(function () {
		var o = ($(this).offset());
		diff = 250 - o.top;
		if(diff>0)
			$("#sidebar").scrollTo("-="+Math.abs(diff),500);
		else
			$("#sidebar").scrollTo("+="+Math.abs(diff),500);
	});

//    sidebar toggle

	$(function() {
		function responsiveView() {
			var wSize = $(window).width();
			if (wSize <= 768) {
				$('#container').addClass('sidebar-close');
				$('#sidebar > ul').hide();
			}

			if (wSize > 768) {
				$('#container').removeClass('sidebar-close');
				$('#sidebar > ul').show();
			}
		}
		$(window).on('load', responsiveView);
		$(window).on('resize', responsiveView);
	});

	$('.fa-bars').click(function () {
		if ($('#sidebar > ul').is(":visible") === true) {
			$('#main-content').css({
				'margin-left': '0px'
			});
			$('#sidebar').css({
				'margin-left': '-210px'
			});
			$('#sidebar > ul').hide();
			$("#container").addClass("sidebar-closed");
		} else {
			$('#main-content').css({
				'margin-left': '210px'
			});
			$('#sidebar > ul').show();
			$('#sidebar').css({
				'margin-left': '0'
			});
			$("#container").removeClass("sidebar-closed");
		}
	});

// barra scroll derecha  que ya no existe :c
	//$("#sidebar").niceScroll({styler:"fb",cursorcolor:"#0056CC", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});

   // $("html").niceScroll({styler:"fb",cursorcolor:"#0056CC", cursorwidth: '12', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});

// widget tools

	jQuery('.panel .tools .fa-chevron-down').click(function () {
		var el = jQuery(this).parents(".panel").children(".panel-body");
		if (jQuery(this).hasClass("fa-chevron-down")) {
			jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
			el.slideUp(200);
		} else {
			jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
			el.slideDown(200);
		}
	});

	jQuery('.panel .tools .fa-times').click(function () {
		jQuery(this).parents(".panel").parent().remove();
	});


//    tool tips

	$('.tooltips').tooltip();

//    popovers

	$('.popovers').popover();



// custom bar chart

	if ($(".custom-bar-chart")) {
		$(".bar").each(function () {
			var i = $(this).find(".value").html();
			$(this).find(".value").html("");
			$(this).find(".value").animate({
				height: i
			}, 2000)
		})
	}


}();

//Abrir en otra ventana :D


function nuevaVentana(){
	window.open("dummyimage.html","_blank","Location=0,menubar=0,toolbar=no, scrollbars=yes, resizable=yes, top=0, left=800, width=800, height=600");
}

function OpenWindowWithPost(url, windowoption, name, params){
	var form = document.createElement("form");
	form.setAttribute("method", "post");
	form.setAttribute("action", url);
	form.setAttribute("target", name);

	for (var i in params) {
		if (params.hasOwnProperty(i)) {
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = i;
			input.value = params[i];
			form.appendChild(input);
		}
	}

	document.body.appendChild(form);

	window.open("post.php", name, windowoption);

	form.submit();

	document.body.removeChild(form);
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

function reloadPage(obj){
	if(obj.reload == 1){
		return true;
	}
	else{
		return false;
	}
}

/*
** action : string , pagina a la que se quiere ir ej 'Cadena/Autorizar.php'
** inputs : object , objeto con los nombres y valores de los inputs a agregar ej var inputs = {idCadena : idCadena, idSubCadena : 0, otroValor : 1}
*/
function submitFormPost(action, inputs){
	//creamos un form
	var form = $("<form action='"+ action +"' method='post' enctype='multipart/form-data'></form>");
	//se recorre el objeto 'inputs' y por cada elemento se crea un campo de tipo hidden con su respectivo valor
	$.each(inputs, function(key, value){
		form.append("<input type='hidden' name='"+ key +"' value='"+ value +"'>");
	});
	//hacer submit del form para ir a la pagina
	$("#container").append(form);
	form.submit();
}

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
function validaFecha2(e,txt){
	/*====================================================================================================*/
	/* esta funcion valida las fechas con formatos    AAAA/MM/DD    en el onkeyup						  */
	/*====================================================================================================*/
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

//limpia las opciones de un combo
function limpiaStore(cmb){
	$('#'+cmb)
	.find('option')
	.remove()
	.end()
	.append('<option value="-1">Seleccione</option>')
	.val('-1');
}

//realiza la llamada a la url , la cual devuelve un objeto json con la lista de opciones que se deben mostrar en un combo
/*
	url						: url del archivo que cargará la lista
	cmb						: id del combo/select donde se agregarán las opciones
	opts					: parametros que se enviaran al archivo que carga la lista de opciones
	fields					: campos a mapear {text : 'campoQueContieneElTexto', value : 'CampoQueContieneElValor'},
	opcionesAdicionales		: arreglo que contiene objetos que serán las opciones adicionales, no devueltas por el archivo con la consulta,
		los objetos deben tener dos propiedades : value y label. value contiene el valor que tendrá la opcion y label la etiqueta
		var adicionales = [
	        {value : '-3', label : '- Nuevo / Agregar Proveedor -'},
	        {value : '-5', label : 'Prueba'}
	    ]
*/
function cargarStore(url, cmb, opts, fields, opcionesAdicionales, strTrigger){
	limpiaStore(cmb);

	//$('#'+cmb).bind('load', fnEvent);
	$.post(url, opts,
	function(response){
		limpiaStore(cmb);
		//console.log("cmb: " + cmb);
		$.each(response.data, function(index, item) {
		    $("#"+cmb).append(new Option(eval("item."+fields.text), eval("item."+fields.value)));
		});

		if(opcionesAdicionales != undefined){
			$.each(opcionesAdicionales, function(index, item){
				$("#"+cmb).append(new Option(item.label, item.value));
			});
		}
		if(strTrigger != undefined){
			$('#'+cmb).trigger(strTrigger);
		}
	}, "json");
}

function appendList(cmb, opts, fields, strTrigger){
	limpiaStore(cmb);

	$.each(opts, function(index, item){
		$("#"+cmb).append(new Option(eval("item."+fields.text), eval("item."+fields.value)));
	});

	if(strTrigger != undefined){
		$('#'+cmb).trigger(strTrigger);
	}
}

function DisplayNone(div){
	try{
		document.getElementById(div).style.display = "none";
	}catch(e){ alert(e.description+" "+div);}
}
function DisplayBlock(div){
	try{
		document.getElementById(div).style.display = "block";
	}catch(e){ alert(e.description+" "+div); }
}

function resetSelect( id ) {
	$( '#' + id  + ' option:first-child' ).attr('selected', true);
	removeAllOptions( id );
	setDisabled( id );
}

function removeAllOptions( id ) {
	$( '#' + id  ).children( 'option:not(:first)' ).remove();
}

function setDisabled( id ) {
	$( '#' + id ).prop( 'disabled', true );
}

function CheckTrue(cb) {
	try{
	  return document.getElementById(cb).checked = true;
	}catch(e){ alert(e.description+" "+cb); }
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
function autoCompletaGeneral(txtField, idField, url, valueTxt, valueId, adParams, nuevaFn){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post(url,
				formatParams(adParams, {texto : request.term, pais : request.term, text : request.term, term : request.term})
			,
			function( response ) {
				if(!response.data){
					respond(response);
				}
				else{
					respond(response.data);
				}
			}, "json" );
			GLOBAL_SELECCIONADO = false;
		},
		minLength: 1,
		focus: function( event, ui ) {
			var select = eval("ui.item." + valueTxt);
			$("#"+txtField).val(select);
			$("#"+ idField).val("");
			GLOBAL_SELECCIONADO = true;
			return false;
		},
		select: function( event, ui ) {
			var id = eval("ui.item."+valueId);
			console.log("select");
			$("#"+ idField).val(id);
			$("#"+txtField).trigger('itemselected')
			return false;
		},
		close: function(event, ui){
			var valorId = $("#"+ idField).val();
			console.log(GLOBAL_SELECCIONADO);
			if((valorId == "" || valorId == undefined) && (GLOBAL_SELECCIONADO != undefined && GLOBAL_SELECCIONADO == true)){
				$("#"+txtField).val("");
			}
			GLOBAL_SELECCIONADO = false;
		}
	})
	.data( "ui-autocomplete" )._renderItem = nuevaFn || function( ul, item ){
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

function validaTelefono1(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which;

	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guion  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		var txtInput = document.getElementById(txt);
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 5:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 8:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 11:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 14:
				if(tecla != separador && tecla != 8){
					var caracter = String.fromCharCode(tecla);
					txtInput.value = txtInput.value + "-" + caracter;
					return false;
				}
			break;
			case 17:
				if(tecla != separador && tecla != 8){
					var caracter = String.fromCharCode(tecla);
					txtInput.value = txtInput.value + "-" + caracter;
					return false;
				}
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

function validaTelefono2(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
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
			case 2:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 5:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 8:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 11:
				 document.getElementById(txt).value = txtVal + "-";
			break;
			case 14:
				document.getElementById(txt).value = txtVal;
			break;
			case 17:
				document.getElementById(txt).value = txtVal;
			break;
		}
	}
}

//function validaTelefono1(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	/*if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which; */

	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	/*var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 6:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 10:
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
}*/

//function validaTelefono2(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
	/*if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which;

	if(tecla != 8){
		txtVal =  document.getElementById(txt).value;
			//if(txt.indexOf(".") > -1 && (tecla==45))
				//return false;
				//alert(txt.length);
		switch(txtVal.length){
			case 2:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 6:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 10:
				 document.getElementById(txt).value = txtVal+"-";
			break;
		}
	}
}*/

function llenaDataTable(id, obj, url){

	dataTableObj = $("#" + id).dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: url,
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
		},
		"fnPreDrawCallback"	: function() {
			$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ) {
			dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});

			dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});

			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});
}

// la unica diferencia con llenaDataTable es el cuarto parametro, en el cual se le envia la configuración de las columnas
// ej : var customsettings = {
//		aoColumns	: [
//			null, null, null, {'sClass' : 'align-right'}, {'sClass' : 'align-right'}, {'sClass' : 'align-right'}, null, null, {'bSortable' : false}
//		]
//	}
function llenarDataTable(id, obj, url, customsettings){

	dataTableObj = $("#" + id).dataTable({
		"iDisplayLength"	: 10,
		"bProcessing"		: false,
		"bServerSide"		: true,
		"sAjaxSource"		: url,
		"aoColumnDefs"		: customsettings.aoColumnDefs,
		"oLanguage": {
			"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
			"sZeroRecords"		: "No se ha encontrado nada",
			"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
			"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
			"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
		},
		"fnPreDrawCallback"	: function() {
			$('body').trigger('cargarTabla');
		},
		"fnDrawCallback": function ( oSettings ) {

			dataTableObj.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});

			dataTableObj.$('i').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250
			});

			$('#'+id).trigger('tablaLlena');
			$('body').trigger('tablaLlena');
		},
		"fnServerParams" : function (aoData){
			$.each(obj, function(index, val){
				aoData.push({name : index, value : val });
			});
		}
	});

}

//funcion utilizada en la pantall apara autorizar las comisiones (reales) para regresar al menú de búsqueda
function regresaA(url, idCadena, idSubCadena, idCorresponsal){
	submitFormPost(url, {idCadena : idCadena, idSubCadena : idSubCadena, idCorresponsal : idCorresponsal});
}

function formatNumber(number, digits, decimalPlaces, withCommas) {
    number       = number.toString();
    var simpleNumber = '';

    // Strips out the dollar sign and commas.
    for (var i = 0; i < number.length; ++i) {
        if ("0123456789.".indexOf(number.charAt(i)) >= 0)
            simpleNumber += number.charAt(i);
    }
    number = parseFloat(simpleNumber);

    if (isNaN(number))      number     = 0;
    if (withCommas == null) withCommas = false;
    if (digits     == 0)    digits     = 1;

    var integerPart = (decimalPlaces > 0 ? Math.floor(number) : Math.round(number));
    var string      = "";

    for (var i = 0; i < digits || integerPart > 0; ++i) {
        // Insert a comma every three digits.
        if (withCommas && string.match(/^\d\d\d/))
            string = "," + string;

        string      = (integerPart % 10) + string;
        integerPart = Math.floor(integerPart / 10);
    }

    if (decimalPlaces > 0) {
        number -= Math.floor(number);
        number *= Math.pow(10, decimalPlaces);

        string += "." + formatNumber(number, decimalPlaces, 0);
    }

    return string;
}

/*
	obj es el objeto a recorrer ej : proveedor = { RFC : 'WERT498038TGR', RazonSocial : 'Datalogic', CodigoPostal : '89700' }
	prefijo (puede venir vacio) es un string con el prefijo que se debe agregar para completar el id de los campos ej : 'txt' para completar #txtRFC, #txtRazonSocial
*/
function simpleFillFields(obj, prefijo){
	$.each(obj, function(key, value) {
		if($('#' + prefijo + key).length){
			$('#' + prefijo + key).val(value);
			$('#' + prefijo + key).trigger('valuechanged');
		}
	});

	$('body').trigger('loaded');
}

function simpleFillFieldsHtml(obj, prefijo){
	$.each(obj, function(key, value) {
		if($('#' + prefijo + key).length){
			$('#' + prefijo + key).html(value);
			$('#' + prefijo + key).trigger('valuechanged');
		}
	});

	$('body').trigger('loaded');
}

function simpleFillForm(obj, idForm, eventoT){

	$.each(obj, function(key, value){
		var elemento = $("#" + idForm +" [name='"+ key +"']");
		$(elemento).val(value);
		$(elemento).trigger('valuechanged');
	});

	if(eventoT != undefined){
		$('body').trigger(eventoT);
	}

}

function simpleFillHtmlByName(obj, eventoT){

	$.each(obj, function(key, value){
		var elemento = $("[name='"+ key +"']");
		$(elemento).html(value)/*.val(value)*/;
		//$(elemento).trigger('valuechanged');
	});

	if(eventoT != undefined){
		$('body').trigger(eventoT);
	}

}

function fillFieldsChange(obj, prefijo){
	$.each(obj, function(key, value) {
		if($('#' + prefijo + key).length){
			$('#' + prefijo + key).val(value).change();
		}
	});

	$("body").trigger('doneFill');
}

/*
	recibe una cadena con formato parametro1=valor1&parametro2=valor2&parametro3=valor3
	devuelve un objeto donde cada propiedad es un parametro de la cadena recibida
*/
function getParams(params){
	var newParams = params.split("\&");
	var parametros = {}

	$.each(newParams, function(index, val){
		var param = val.split("\=");
		var p = decodeURIComponent(param[1]);
		//p = p.replace(/\+/g, "");
		parametros[param[0]] = p.trim();
	});

	return parametros;
}

function submitForm(url, params, functionResp){
	$.post(url,
	params,
	function(response){
		if(showMsg(response)){
			alert(response.msg);
		}
		else{
			eval(functionResp);
		}
	}, "json");
}

function txtValue(id){
	return $('#'+id).val();
}

function showExcelCommon(todo, url, idForm){
	var form = (idForm == undefined)? "form" : idForm;
	var parametros	= getParams($(form).serialize());
	var oBusqueda	= dataTableObj._fnDataToSearch();
	var strToFind	= oBusqueda.oPreviousSearch.sSearch;

	var paging			= dataTableObj.fnPagingInfo();

	parametros.start	= (todo == 1)? 0 : paging.iStart;
	parametros.end		= (todo == 1)? paging.iTotal : paging.iLength;
	parametros.strToFind= (todo == 1)? '' : strToFind;

	parametros.iSortCol_0	= dataTableObj.fnSettings().aaSorting[0][0];
	parametros.sSortDir_0	= dataTableObj.fnSettings().aaSorting[0][1];

	var params = "";
	$.each(parametros, function(index, val){
		params += index + "=" + val + "&";
	});

	$.fileDownload(url + "?" + params, {
		successCallback: function(url) {
			//OcultarEmergente();
		},
		failCallback: function(responseHtml, url){
			//OcultarEmergente();
			alert("Ha ocurrido un error");
		}
	});
	return false;
}

function cargarContenidoHtml(url, div, functionAfterResponse, params){

	var parametros = (params != undefined)? params : {};
	$.post(url,
		parametros,
		function(response){
			$('#'+div).empty().html(response);
			console.log(functionAfterResponse);
			eval(functionAfterResponse);
		}
	).done($('body').trigger('contenidocargado'));
}


function prependHtml(url, div, params){
	var parametros = (params != undefined)? params : {};
	$.post(url,
		parametros,
		function(response){
			$('#'+ div +' >div').remove();
			$('#'+div).prepend(response);
			$('body').trigger('prependHtmldone');
		}
	).done($('body').trigger('contenidocargado'));
}

/*
**	Limpia los campos de un formulario
*/
function resetForm(id){
	$('#' + id).get(0).reset();
}

/*
**	Transforma minusculas a mayusculas
*/
function cUpper(cObj) {
	cObj.value = cObj.value.toUpperCase();
}


/*
**	Realiza una comparacion entre una fecha inicial y una fecha final, si la fecha inicial es menor o igual a la fecha final devuelve verdadero, en caso contraro devuelve falso
*/
function validarFechas(fechaInicio, fechaFin){
	if(fechaInicio <= fechaFin){
		return true;
	}
	else{
		return false;
	}
}

/*
**	REcibe la fecha y la retorna formateada
*/
function obtenerFecha(fecha){
	var day		= (fecha.getDate() < 10)? '0'+fecha.getDate() : fecha.getDate();
	var month	= parseInt(fecha.getMonth()) + 1;
	month		= (month < 10)? '0' + month : month;
	var year	= fecha.getFullYear();

	return year + '-' + month + '-' + day;
}

function toIsoString(date) {
	const tzo = -date.getTimezoneOffset(),
	dif = tzo >= 0 ? '+' : '-',
	pad = function(num) {
		return (num < 10 ? '0' : '') + num;
	};

	return date.getFullYear() +
	'-' + pad(date.getMonth() + 1) +
	'-' + pad(date.getDate()) +
	'T' + pad(date.getHours()) +
	':' + pad(date.getMinutes()) +
	':' + pad(date.getSeconds()) +
	dif + pad(Math.floor(Math.abs(tzo) / 60)) +
	':' + pad(Math.abs(tzo) % 60);
}

function toFloat(str){
	return parseFloat(str.replace(/[\$,]/g, ""));
}


/*
**	Recibe como parametro un elemento html
**	devuelve un objeto con los atributos y valores del elemento,
**	por ejemplo de <a href="#" id="a1" tipo="link"> Ver </a>
**	devolveria
**	{
**		href	: "#",
**		id		: "a1",
**		tipo	: "link"
**	}
*/
function getAttrs(el){

    var params = {}

    $.each(el.attributes, function( index, attr ) {
        params[attr.nodeName] = attr.nodeValue;
    });

    return params;
}

/*
**	Obtener la descripcion cuando se asigna una factura a un corte y los importes no coinciden
*/
function obtenerDescripcion(){
	var desc = prompt("El importe del Corte y el de la Factura no coinciden, deje un comentario", "");

	if(typeof desc === 'string'){
		var des = desc.trim();

		if(des == ''){
			return obtenerDescripcion();
		}
		else{
			if(des.length > 20){
				alert('El comentario no debe ser mayor de 20 caracteres');
				return obtenerDescripcion();
			}

			var vsExprReg=/^[\w\s\sáéíóúñÁÉÍÓÚÑüÜ]+$/i;
			if(!vsExprReg.test(des)){
				alert('El comentario no debe tener caracteres especiales');
				return obtenerDescripcion();
			}
		}
	}
	return desc;
}

function myTrim(txt){
	return txt.trim();
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

	if(digitoVerificador == 10){
		digitoVerificador = 0;
	}

	return CLABE.charAt(17) == digitoVerificador;

}

function validar_email(valor){
	// creamos nuestra regla con expresiones regulares.
	var filter = /[\w-\.]{1,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	// utilizamos test para comprobar si el parametro valor cumple la regla
	if(filter.test(valor))
		return true;
	else
		return false;
}

function validaTelefono(valor) {
	valor = document.getElementById(valor).value;
	var longitud = valor.length;
	var re;
	switch ( longitud ) {
		case 14:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}$/;
		break;
		case 17:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}$/;
		break;
		case 19:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
		case 20:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{2}$/;
		break;
		default:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
	}
	if ( re.exec(valor) ) {
		//alert( "Si" );
		return true;
    } else {
		//alert( "No" );
		return false;
    }
}


function validaTelefonoAnterior1(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el keypress						  	  */
	/*====================================================================================================*/
	if( window.event)
        var tecla = window.event.keyCode;//
	else
		var tecla = (document.all) ? e.keyCode : e.which;

	/*la tecla 47 es el Diagonal [ / ]    la tecla  45 es el Guio  [ - ]  */
	var separador = 45;
	if((tecla==8) || (tecla==separador) || (tecla >= 48 && tecla <= 57) && (tecla != 16)){
		txt =  document.getElementById(txt).value;
		switch(txt.length){
			case 2:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 6:
				if(tecla != separador && tecla != 8)
					return false;
			break;
			case 10:
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

function validaTelefonoAnterior2(e,txt){
	/*====================================================================================================*/
	/* esta funcion telefonos con formatos    12-123-123-1234    en el onkeyup						  	  */
	/*====================================================================================================*/
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
			case 2:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 6:
				 document.getElementById(txt).value = txtVal+"-";
			break;
			case 10:
				 document.getElementById(txt).value = txtVal+"-";
			break;
		}
	}
}

function validaTelefonoAnterior(valor) {
	valor = document.getElementById(valor).value;
	re=/\d{2}\-\d{3}\-\d{3}\-\d{4}$/
     if(re.exec(valor))    {
          //alert("Si");
		  return true;
     }else{
         //alert("No");
		 return false;
     }
}

function validaTelefonoAnterior3(valor) {
	valor = document.getElementById(valor).value;
	var longitud = valor.length;
	var re;
	switch ( longitud ) {
		case 14:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}$/;
		break;
		case 15:
			re=/\d{2}\-\d{3}\-\d{3}\-\d{4}$/;
		break;
		case 17:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}$/;
		break;
		case 20:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{2}$/;
		break;
		case 19:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
		default:
			re = /\d{2}\-\d{2}\-\d{2}\-\d{2}-\d{2}-\d{2}-\d{1}$/;
		break;
	}
	if ( re.exec(valor) ) {
		//alert( "Si" );
		return true;
    } else {
		//alert( "No" );
		return false;
    }
}


function formSubmit(idForm){
	$("#"+idForm).submit();
}


// funcion para validar formato de fechas : yyyy-mm-dd
// txtDate : string de fecha Ej 2014-01-31
function isDate(txtDate)
{
	var currVal = txtDate;
	if(currVal == '')
		return false;

	var rxDatePattern = /^(\d{4})(-)(\d{2})(-)(\d{2})$/;
	var dtArray = currVal.match(rxDatePattern);

	if (dtArray == null)
		return false;

	dtMonth	= dtArray[3];
	dtDay	= dtArray[5];
	dtYear	= dtArray[1];

	if(dtMonth < 1 || dtMonth > 12){
		return false;
	}
	else if (dtDay < 1 || dtDay> 31){
		return false;
	}
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31){
		return false;
	}
	else if (dtMonth == 2){
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if(dtDay > 29 || (dtDay ==29 && !isleap)){
			return false;
		}
	}
	return true;
}


function getDoc(frame) {
     var doc = null;

     // IE8 cascading access check
     try {
         if (frame.contentWindow) {
             doc = frame.contentWindow.document;
         }
     } catch(err) {
     }

     if (doc) { // successful getting content
         return doc;
     }

     try { // simply checking may throw in ie8 under ssl or mismatched protocol
         doc = frame.contentDocument ? frame.contentDocument : frame.document;
     } catch(err) {
         // last attempt
         doc = frame.document;
     }
     return doc;
 }

 function removerEmojis (str) {
	let strCopy = str;
	const emojiKeycapRegex = /[\u0023-\u0039]\ufe0f?\u20e3/g;
	const emojiRegex = /\p{Extended_Pictographic}/gu;
	const emojiComponentRegex = /\p{Emoji_Component}/gu;

	if (emojiKeycapRegex.test(strCopy)) {
		strCopy = strCopy.replace(emojiKeycapRegex, '');
	}

	if (emojiRegex.test(strCopy)) {
		strCopy = strCopy.replace(emojiRegex, '');
	}

	if (emojiComponentRegex.test(strCopy)) {
		for (const emoji of (strCopy.match(emojiComponentRegex) || [])) {
			if (/[\d|*|#]/.test(emoji)) {
				continue;
			}
			strCopy = strCopy.replace(emoji, '');
		}
	}

	return strCopy;
}

function reemplazarCaracteresEspeciales (str) {
	const regex = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gu;
	return str.replace(regex, '');
}

function contieneCaracteresEspeciales (str) {
	const regex = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/u;
	return regex.test(str);
}

function reemplazarAcentosNoValidosEsMx (str) {
	const regex = /ÀÂÃÄÅĄĀāàâãäåąßÒÔÕÕÖØŐòôőõöøĎďDŽdžÈÊËĘèêëęðÇçČčĆćÐÌÎÏĪìîïīÙÛŰùűûĽĹŁľĺłŇŃňńŔŕŠŚŞšśşŤťŸÝÿýŽŻŹžżźđĢĞģğ/gu;
	return str.replace(regex, '');
}

function contieneAcentosNoValidosEsMx (str) {
	const regex = /ÀÂÃÄÅĄĀāàâãäåąßÒÔÕÕÖØŐòôőõöøĎďDŽdžÈÊËĘèêëęðÇçČčĆćÐÌÎÏĪìîïīÙÛŰùűûĽĹŁľĺłŇŃňńŔŕŠŚŞšśşŤťŸÝÿýŽŻŹžżźđĢĞģğ/u;
	return regex.test(str);
}

function obtenerSoloLetrasValidasEsMx (str) {
	const result = str.match(/[A-Za-zÁáÉéÍíÓóÜüÚú]/gu);
	if (result == null) {
		return '';
	}

	return result.join('');
}

function contieneSoloLetrasValidasEsMx (str) {
	const regex = /[A-Za-zÁáÉéÍíÓóÜüÚú]/u;
	return regex.test(str);
}

function obtenerSoloLetrasYNumerosValidosEsMx (str) {
	const result = str.match(/[A-Za-z0-9\sÁáÉéÍíÓóÜüÚú]/gu);
	if (result == null) {
		return '';
	}

	return result.join('');
}

function contieneSoloLetrasYNumerosValidosEsMx (str) {
	const regex = /[A-Za-z0-9\sÁáÉéÍíÓóÜüÚú]/u;
	return regex.test(str);
}

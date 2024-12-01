var opcionesLocales = [
	{
		value: "Todos",
		idCadena: -1,
		idSubCadena: -1,
		idCorresponsal: -1,
		nombreCadena: "Todos",
		nombreSubCadena: "Todos",
		nombreCorresponsal: "Todos",
		label: "ID : -1 Todos"
	}
];

function initComponents() {
	$("#idCadena").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});	
	
	$("#idSub").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	
	$("#idCor").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	
	$("#txtFechaIni").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	
	$("#txtFechaFin").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	
	$("#txtNombre").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	
	$("#txtApellido").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	
	$("#txtNombreRemitente").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	
	if($("#idCadena").length){
		$("#idCadena").autocomplete({
			source: function( request, respond ) {
				//Resultados locales
				var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);
				
				$.post(BASE_PATH + "/inc/Ajax/_Clientes/getListaCategoria.php",{ text : request.term, categoria : 1 },
				function( response ) {
					respond(response.concat(resultadosLocales));
				}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idCadena").val(ui.item.nombreCadena);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlCad").val(ui.item.idCadena);
				return false;
			}
		})
		.data("ui-autocomplete")._renderItem = function( ul, item ) {
			return $('<li>')
			.append( "<a>" + item.label + "</a>" )
			.appendTo( ul );
		}
		$("#idCadena").on( "keypress keyup", function() {
			if ( $("#idCadena").val() == "" ) {
				$("#ddlCad").val("-2");
			}
		});
		$("#idCadena").on( "mouseup", function() {
		  var $input = $(this),
			  oldValue = $input.val();
		
		  if (oldValue == "") return;
		
		  // When this event is fired after clicking on the clear button
		  // the value is not cleared yet. We have to wait for it.
		  setTimeout(function(){
			var newValue = $input.val();
		
			if (newValue == ""){
			  // Gotcha
			  $("#ddlCad").val("-1");
			}
		  }, 1);										  
		});
	}
	
	if($("#idSub").length){
		$("#idSub").autocomplete({
			source: function( request, respond ) {
				//Resultados locales
				var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);
				
				$.post(BASE_PATH + "/inc/Ajax/_Clientes/getListaCategoria.php",
					{
						idCadena	: $("#ddlCad").val(),
						categoria	: 2,
						text		: request.term
					},
					function( response ) {
						respond(response.concat(resultadosLocales));
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idSub").val(ui.item.nombreSubCadena);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlSub").val(ui.item.idSubCadena);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
			.appendTo( ul );
		}
		$("#idSub").on( "keypress keyup", function() {
			if ( $("#idSub").val() == "" ) {
				$("#ddlSub").val("-2");
			}
		});
		$("#idSub").on( "mouseup", function() {
		  var $input = $(this),
			  oldValue = $input.val();
		
		  if (oldValue == "") return;
		
		  // When this event is fired after clicking on the clear button
		  // the value is not cleared yet. We have to wait for it.
		  setTimeout(function(){
			var newValue = $input.val();
		
			if (newValue == ""){
			  // Gotcha
			  $("#ddlSub").val("-1");
			}
		  }, 1);										  
		});
	}
	
	if($("#idCor").length){
		$("#idCor").autocomplete({
			source: function( request, respond ) {
				//Resultados locales
				var resultadosLocales = $.ui.autocomplete.filter(opcionesLocales, request.term);
				
				$.post(BASE_PATH + "/inc/Ajax/_Clientes/getListaCategoria.php",
					{
						idCadena	: $("#ddlCad").val(),
						idSubCadena	: $("#ddlSub").val(),
						categoria	: 3,
						text		: request.term
					},
					function( response ) {
						respond(response.concat(resultadosLocales));
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#idCor").val(ui.item.nombreCorresponsal);
				return false;
			},
			select: function( event, ui ) {
				$("#idCadena").val(ui.item.nombreCadena);
				$("#idSub").val(ui.item.nombreSubCadena);
				$("#ddlSub").val(ui.item.idSubCadena);
				$("#ddlCad").val(ui.item.idCadena);
				$("#ddlCorresponsal").val(ui.item.idCorresponsal);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
			.appendTo( ul );
		}
		$("#idCor").on( "keypress keyup", function() {
			if ( $("#idCor").val() == "" ) {
				$("#ddlCorresponsal").val("-2");
			}
		});
		$("#idCor").on( "mouseup", function() {
		  var $input = $(this),
			  oldValue = $input.val();
		
		  if (oldValue == "") return;
		
		  // When this event is fired after clicking on the clear button
		  // the value is not cleared yet. We have to wait for it.
		  setTimeout(function(){
			var newValue = $input.val();
		
			if (newValue == ""){
			  // Gotcha
			  $("#ddlCorresponsal").val("-1");
			}
		  }, 1);										  
		});
	}
}

/*$(function(){

});*/

function Mostrar(){
	if ( $("#divRES").length ) {
		$("#divRES").css("display", "block");
	}
}

function obtenerFechas(){
	var fecIni 	= txtValue("fecIni");
	var fecFin 	= txtValue("fecFin");

	var str = 'fecIni='+fecIni +'&fecFin='+fecFin;

	return str;
}

function BuscaOperaciones(i){
	var Folio 	= txtValue("txtFolio");
	var Auto	= txtValue("txtAutori");
	var Ref		= txtValue("txtRef");
	var fecIni = txtValue("fecIni");
	var fecFin = txtValue("fecFin");
	var formatoFecha = /^(\d{4})-(\d{2})-(\d{2})$/;
	if ( txtValue("fecIni") == "" || txtValue("fecIni") == null ) {
		alert("Falta seleccionar una Fecha Inicial");
		return false;
	}
	if ( txtValue("fecFin") == "" || txtValue("fecFin") == null ) {
		alert("Falta seleccionar una Fecha Final");
		return false;
	}	
	if ( !fecIni.match(formatoFecha) ) {
		alert("La Fecha Inicial no tiene el formato correcto");
		return false;
	}
	if ( !fecFin.match(formatoFecha) ) {
		alert("La Fecha Final no tiene el formato correcto");
		return false;
	}
	var fechaInicial = new Date(fecIni);
	var fechaFinal = new Date(fecFin);
	if ( fechaInicial > fechaFinal ) {
		alert("La Fecha Inicial debe ser menor a la Fecha Final");
		return false;
	}
	var fechas = obtenerFechas();
	var params = 'Folio='+Folio+'&Auto='+Auto+'&Ref='+Ref+'&'+fechas;
	BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOperaciones2.php",params,'',i);
}

function BuscaOperacionesFolio(i){
	var Folio 	= txtValue("txtFolio");
	var fechas = obtenerFechas();
	var params = 'Folio='+Folio+'&'+fechas;
	if(Folio != ""){
		$("#divRES").empty();
		Emergente();
		BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOperaciones2.php",params,'',i);
	}
	else{
		alert("Favor de ingresar un Folio");
	}
}
function BuscaOperacionesAuto(i){
	var Auto	= txtValue("txtAutori");
	var fechas = obtenerFechas();
	var params = 'Auto='+Auto+'&'+fechas;
	if(Auto != ""){
		$("#divRES").empty();
		Emergente();
		BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOperaciones2.php",params,'',i);
	}
	else{
		alert("Favor de ingresar una Autorizacion");
	}
}
function BuscaOperacionesRef(i){
	var Ref		= txtValue("txtRef");
	var fechas	= obtenerFechas();
	var params	= 'Ref='+Ref+'&'+fechas;
	if(Ref != ""){
		$("#divRES").empty();
		Emergente();
		BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOperaciones2.php",params,'',i);
	}
	else{
		alert("Favor de ingresar una Ref");
	}
}

function enterBuscaOperacionesFol(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla == 13)
	{
		BuscaOperacionesFolio();
	}
}
function enterBuscaOperacionesAut(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla == 13)
	{
		BuscaOperacionesAuto();
	}
}
function enterBuscaOperacionesRef(e){
	if( window.event)  
        var tecla = window.event.keyCode;//
	else
		tecla = (document.all) ? e.keyCode : e.which; 
	
	if(tecla == 13)
	{
		BuscaOperacionesRef();
	}
}

/*$("#cerrar").live("click",function(){
	$("#base").fadeOut("normal");
	$("#base2").fadeOut("normal");
})*/



function BuscarOperacionVerPoPUp(id){

	$("#base").css({"visibility":"visible"});
	$("#base").fadeTo("normal",0.4);
	$("#base4").css({"visibility":"visible"});
	$("#base4").fadeIn("normal");
	
	http.open("POST", BASE_PATH + "/inc/Ajax/_Operaciones/VerOperacion.php", true);
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
			MostrarPopUp(RespuestaServidor);
			//document.getElementById('ContentPopUp').innerHTML = RespuestaServidor;
			OcultarEmergente();
			//Ordenar();
		} 
	}
	
	http.send("idO="+id);
}


function BuscaOperaIncompletas(i){
	var cad 	= txtValue('ddlCad');
	var subcad 	= txtValue('ddlSub');
	var corr 	= txtValue('ddlCorresponsal');

	Emergente();
	BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOpeIncompletas.php","cad="+cad+"&subcad="+subcad+"&corr="+corr,'',i);
}

function BuscaRemesas(i){
		BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaRemesas.php","",'',i);
}

function BuscarMonitor2(i){
	var fechai	= txtValue('txtFechaIni');
	if(fechai != '')
	{
		if(validaFechaRegex("txtFechaIni")){
			var fechaf 	= txtValue('txtFechaFin');
			if(fechaf != '')
			{
				if(validaFechaRegex("txtFechaFin")){
					//if(fechai != fechaf){
						//if(fechai < fechaf){
							var cad 	= txtValue('ddlCad');
							var subcad	= txtValue('ddlSub');
							var corr 	= txtValue('ddlCorresponsal');
							var prov	= txtValue('ddlProveedor');
							if(Existe('ddlProducto'))
								var prod 	= txtValue('ddlProducto');
							else
								var prod	= -2
							var fam		= txtValue('ddlFam');
							if(Existe('ddlProducto'))
								var subfam	= txtValue('ddlSubFam');
							else
								var subfam	= -2
							
							var emisor 	= txtValue('ddlEmisor');
							var tipo	= 1;
							
							if(Check('Proveedor')){
								tipo	= 2;
							}
							if(Check('Emisor')){
								tipo	= 3;
							}
							var parametros = "cad="+cad+"&subcad="+subcad+"&corr="+corr+"&prov="+prov+"&prod="+prod+"&fam="+fam+"&subfam="+subfam+"&emisor="+emisor+"&tipoBus="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
							showGraph();
						/*}else{
							alert("La Fecha Inicial debe ser menor a la Fecha Final");
						}*/
					/*}else{
						alert("Favor de seleccionar fechas distintas");
					}*/
				}else{
					alert("El formato de la fecha final es incorrecto");
				}
			}else{
				alert("Favor de Selecionar una Fecha Final");
			}		
		}else{
			alert("El formato de la fecha inicial es incorrecto");
		}
	}else{
		alert("Favor de Selecionar una Fecha Inicial");
	}
}

function BuscarDetalleOpGraf(i){
	var fecha = txtValue('txtFecha');
	if(fecha != ''){
		var cad 	= txtValue('ddlCad');
		
		var act = false;
		if(Check('Actualizar')){
				act	= true;
		}
		
		var con = false;
		if(Check('Continuidad')){
				con	= true;
		}

		var parametros = "cad="+cad+"&fechai="+fecha+"&actualizar="+act+"&continuidad="+con;
		BuscarParametros(BASE_PATH + "/inc/Ajax/_Operaciones/BuscaOpDetalle.php", parametros,'',i);
		//BuscarParametros("../../../inc/Ajax/_Operaciones/OPDetalle.php", parametros,'',i);
	}else{
		alert("Favor de Selecionar una Fecha Inicial");
	}
}


function RefreshGraficaDetalle(){
	if(validaFechaRegex("txtFecha")){
		setValue('hFechaGrafica', txtValue("txtFecha"));
		setValue('hidCadeGrafica',txtValue("ddlCad"));
		SubmitForm("RefreshGraficaDetalleForm")
	}else{alert("Favor de escribir la Fecha correctamente")}
}

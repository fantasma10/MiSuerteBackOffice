$(document).ready(function(){
	$("#txtcrear").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});	
	$("#txtcp").numeric({
		allowMinus: false,
		allowThouSep: false
	});
	$("#txtnext").numeric({
		allowMinus: false,
		allowThouSep: false
	});
	$("#txtImporte").numeric({
		allowPlus: false,
		allowMinus: false,
		allowThouSep: false,
		allowDecSep: true,
		allowLeadingSpaces: false,
		maxDigits: 12,
		maxDecimalPlaces: 2,
		maxPreDecimalPlaces: 10
	});
	$("#txtext").numeric({
		allowMinus: false,
		allowThouSep: false
	});	
	$("#txtPais").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});	
	$("#txtcalle").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtnint").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$(".txthorario").alphanum({
		allow: "\u003A",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtbeneficiario").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E"			 
	});
	$("#txtdescripcion").alphanum({
		allowOtherCharSets: false							  
	});
	$("#txtColonia").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtEstado").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtMunicipio").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtnumiden").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtrrfc").alphanum({
		disallow: "\u002D\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtcurp").alphanum({
		disallow: "\u002D\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtrfc").alphanum({
		disallow: "\u002D\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtNombreCadena").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtmail").alphanum({
		allow: "\u002D\u002E\u005F\u0040",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtcorreo").alphanum({
		allow: "\u002D\u002E\u005F\u0040",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtNomSucursal").alphanum({
		allow: "\u002D\u002E\u005F\u0040\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtnombre").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	$("#txtnombrereferencia").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});	
	$("#txtpaterno").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		allowLatin: true,
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	$("#txtmaterno").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowNumeric: false,
		allowOtherCharSets: false
	});
	$("#txttelefono").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtext").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtejecutivoventa").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtejecutivocuenta").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txttel1").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txttel2").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtfax").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtrazon").alphanum({
		allow: "\u002D\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u002E\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtfecha").alphanum({
		allow: "\u002D",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtclabe").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtbeneficiario").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtcuenta").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtforelo").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: true,
		allowOtherCharSets: false
	});
	$("#txtreferencia").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: true,
		allowOtherCharSets: false
	});
	$("#txtNumSucursal").alphanum({
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtafilicacion").alphanum({
		allow: "\u002E",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E\u002D",
		allowLatin: false,
		allowOtherCharSets: false
	});
	$("#txtCLABE").numeric({
		allowMinus: false,
		allowThouSep: false
	});
	$("#txtBeneficiario").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});
	$("#txtDescripcionCuenta").alphanum({
		allow: "\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00DA\u00F1\u00D1\u00FC\u00DC\u00D3",
		disallow: "\u00BF\u00A1\u00B0\u00B4\u00A8\u007E",
		allowOtherCharSets: false
	});	
	$("#check4").click(function(){
		if ( $("#check4").is(":checked") && $("#txt2").val() != "" ) {
			$("#txt4").val( $("#txt2").val() );
		}
		if ( $("#check4").is(":checked") && $("#txt1").val() != "" ) {
			$("#txt3").val( $("#txt1").val() );
		}		
	});
	$("#check6").click(function(){
		if ( $("#check6").is(":checked") && $("#txt4").val() != "" ) {
			$("#txt6").val( $("#txt4").val() );
		}
		if ( $("#check6").is(":checked") && $("#txt3").val() != "" ) {
			$("#txt5").val( $("#txt3").val() );
		}		
	});
	$("#check8").click(function(){
		if ( $("#check8").is(":checked") && $("#txt6").val() != "" ) {
			$("#txt8").val( $("#txt6").val() );
		}
		if ( $("#check8").is(":checked") && $("#txt5").val() != "" ) {
			$("#txt7").val( $("#txt5").val() );
		}		
	});
	$("#check10").click(function(){
		if ( $("#check10").is(":checked") && $("#txt8").val() != "" ) {
			$("#txt10").val( $("#txt8").val() );
		}
		if ( $("#check10").is(":checked") && $("#txt7").val() != "" ) {
			$("#txt9").val( $("#txt7").val() );
		}		
	});
	$("#check12").click(function(){
		if ( $("#check12").is(":checked") && $("#txt10").val() != "" ) {
			$("#txt12").val( $("#txt10").val() );
		}
		if ( $("#check12").is(":checked") && $("#txt9").val() != "" ) {
			$("#txt11").val( $("#txt9").val() );
		}		
	});
	$("#check14").click(function(){
		if ( $("#check14").is(":checked") && $("#txt12").val() != "" ) {
			$("#txt14").val( $("#txt12").val() );
		}
		if ( $("#check14").is(":checked") && $("#txt11").val() != "" ) {
			$("#txt13").val( $("#txt11").val() );
		}		
	});
	$("#paso1").hover(
		function(){
			$("#paso1").attr("src", "../../img/1_h.png");
		},
		function() {
			$("#paso1").attr("src", "../../img/1.png");
		}
	);
	$("#paso2").hover(
		function(){
			$("#paso2").attr("src", "../../img/2_h.png");
		},
		function() {
			$("#paso2").attr("src", "../../img/2.png");
		}
	);
	$("#paso3").hover(
		function(){
			$("#paso3").attr("src", "../../img/3_h.png");
		},
		function() {
			$("#paso3").attr("src", "../../img/3.png");
		}
	);
	$("#paso4").hover(
		function(){
			$("#paso4").attr("src", "../../img/4_h.png");
		},
		function() {
			$("#paso4").attr("src", "../../img/4.png");
		}
	);
	$("#paso5").hover(
		function(){
			$("#paso5").attr("src", "../../img/5_h.png");
		},
		function() {
			$("#paso5").attr("src", "../../img/5.png");
		}
	);
	$("#paso6").hover(
		function(){
			$("#paso6").attr("src", "../../img/6_h.png");
		},
		function() {
			$("#paso6").attr("src", "../../img/6.png");
		}
	);
	$("#paso7").hover(
		function(){
			$("#paso7").attr("src", "../../img/7_h.png");
		},
		function() {
			$("#paso7").attr("src", "../../img/7.png");
		}
	);
	$("#atras").hover(
		function() {
			$("#atras").attr("src", "../../img/atras_h.png");	
		},
		function() {
			$("#atras").attr("src", "../../img/atras.png");	
		}
	);
	$("#adelante").hover(
		function() {
			$("#adelante").attr("src", "../../img/adelante_h.png");	
		},
		function() {
			$("#adelante").attr("src", "../../img/adelante.png");
		}
	);
	$("#paso1Actual").hover(
		function() {
			$("#paso1Actual").attr("src", "../../img/1a_h.png");	
		},
		function() {
			$("#paso1Actual").attr("src", "../../img/1a.png");
		}
	);
	$("#paso2Actual").hover(
		function() {
			$("#paso2Actual").attr("src", "../../img/2a_h.png");	
		},
		function() {
			$("#paso2Actual").attr("src", "../../img/2a.png");
		}
	);
	$("#paso3Actual").hover(
		function() {
			$("#paso3Actual").attr("src", "../../img/3a_h.png");	
		},
		function() {
			$("#paso3Actual").attr("src", "../../img/3a.png");
		}
	);
	$("#paso4Actual").hover(
		function() {
			$("#paso4Actual").attr("src", "../../img/4a_h.png");	
		},
		function() {
			$("#paso4Actual").attr("src", "../../img/4a.png");
		}
	);
	$("#paso5Actual").hover(
		function() {
			$("#paso5Actual").attr("src", "../../img/5a_h.png");	
		},
		function() {
			$("#paso5Actual").attr("src", "../../img/5a.png");
		}
	);
	$("#paso6Actual").hover(
		function() {
			$("#paso6Actual").attr("src", "../../img/6a_h.png");	
		},
		function() {
			$("#paso6Actual").attr("src", "../../img/6a.png");
		}
	);
	$("#paso7Actual").hover(
		function() {
			$("#paso7Actual").attr("src", "../../img/7a_h.png");	
		},
		function() {
			$("#paso7Actual").attr("src", "../../img/7a.png");
		}
	);
	$("#home").hover(
		function() {
			$("#home").attr("src", "../../img/h_h.png");	
		},
		function() {
			$("#home").attr("src", "../../img/h.png");
		}
	);
	$("#homeActual").hover(
		function() {
			$("#homeActual").attr("src", "../../img/h_a_h.png");	
		},
		function() {
			$("#homeActual").attr("src", "../../img/h_a.png");
		}
	);
	$("#resumen").hover(
		function() {
			$("#resumen").attr("src", "../../img/r_h.png");	
		},
		function() {
			$("#resumen").attr("src", "../../img/r.png");
		}
	);
	$("#resumenActual").hover(
		function() {
			$("#resumenActual").attr("src", "../../img/r_a_h.png");
		},
		function() {
			$("#resumenActual").attr("src", "../../img/r_a.png");
		}
	);
});
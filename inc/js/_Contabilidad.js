$(function(){
	$('#divRES').delegate('#cpag', 'focus', function(){
		var valor = $("#cpag").val();
		if(valor == "" || valor == 0){
			$("#cpag").val(1);
		}
	});

	$('#divRES').delegate('#cpag', 'keyup', function(){
		var valor = $("#cpag").val();
		if(valor == "" || valor == 0){
			$("#cpag").val(1);
		}
	});

	$('#divRES').delegate('#cpag', 'blur', function(){
		var valor = $("#cpag").val();
		if(valor == "" || valor == 0){
			$("#cpag").val(1);
		}
	});

	$('#divRES').delegate('#linkExcelConsulta', 'click', function(){
		showEXCELConsulta();
	});
});
/*
	funciones utilizadas en la pantalla de Conceptos
*/
$(document).ready(function(){
	$('#txt_importe').bind("paste", function(e){
		return false;
	});

	$('#area_observaciones').bind("paste", function(e){
		return false;
	});

	$('#txt_nombre').bind("paste", function(e){
		return false;
	});

	$('#txt_nombres').bind("paste", function(e){
		return false;
	});

	$('#txt_numCuenta').bind("paste", function(e){
		return false;
	});

	$('#txt_nombreConcepto').bind("paste", function(e){
		return false;
	});

	$('#txt_descConcepto').bind("paste", function(e){
		return false;
	});

	$('#fechaInicio').bind("paste", function(e){
		return false;
	});
});

function mostrarConceptos(){
	BuscarParametros("../../inc/Ajax/_Contabilidad/Conceptos/listaConceptos.php");
}

function mostrarCapturaConceptos(){
	$("#hide_seek_concepto").show();
	$('#txt_nombreConcepto').val('');
	$('#txt_descConcepto').val('');
	$('#txt_idConcepto').val('');
}

function hideCapturaConceptos(){
	$("#hide_seek_concepto").hide();
	$('#txt_nombreConcepto').val('');
	$('#txt_descConcepto').val('');
	$('#txt_idConcepto').val('');
}

function eliminarConcepto(idConcepto){

	if(confirm("Desea eliminar el Concepto")){
		if(idConcepto != ""){
			var params = "idConcepto="+ idConcepto;

			http.open("POST", "../../inc/Ajax/_Contabilidad/Conceptos/deleteConcepto.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function(){
				if (http.readyState==1){
					//Emergente();
				}
				if (http.readyState==4){
					var RespuestaServidor = http.responseText;
					validaSession(RespuestaServidor);

					var response = eval("("+ RespuestaServidor +")");
					var datos = response.data;

					if(response.data.error == 0){
						mostrarConceptos();
					}
					else{
						alert(response.data.msg);
					}
				}
			}
			http.send(params);
		}
	}
}// function eliminarConcepto

/*
	funcion utilizada para cargar la información del concepto en el div hide_seek_concepto
*/
function editarConcepto(idConcepto){
	if(idConcepto != ""){
		var params = "idConcepto="+ idConcepto;

		http.open("POST", "../../inc/Ajax/_Contabilidad/Conceptos/getConcepto.php", true);
		http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		http.onreadystatechange=function(){
			if (http.readyState==1){
				//Emergente();
			}
			if (http.readyState==4){
				var RespuestaServidor = http.responseText;
				validaSession(RespuestaServidor);

				var response = eval("("+ RespuestaServidor +")");
				var datos = response.data;

				mostrarCapturaConceptos();

				for(var key in datos){
					if(datos.hasOwnProperty(key)){
						var id = "#txt_"+key;
						var value = datos[key];
						if($(id)){
							$(id).val(value);
						}
					}
				}
				OcultarEmergente();
			}
		}
		http.send(params);
	}
}

function guardarNuevoConcepto(){
	var nombreConcepto = document.getElementById("txt_nombreConcepto").value;
	var descConcepto = document.getElementById("txt_descConcepto").value;
	var idConcepto = document.getElementById("txt_idConcepto").value;

	if(nombreConcepto != ""){
		if(descConcepto != ""){

			var params = "idConcepto=" + idConcepto + "&nombreConcepto="+nombreConcepto+"&descConcepto="+descConcepto;

			http.open("POST", "../../inc/Ajax/_Contabilidad/Conceptos/crearNuevoConcepto.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				
			http.onreadystatechange=function(){
				if (http.readyState==1){
					//Emergente();
				}
				if (http.readyState==4){
					var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
					validaSession(RespuestaServidor);

					var response = eval("("+ RespuestaServidor +")");
					if(response.data.error == 0){
						hideCapturaConceptos();
						mostrarConceptos();
					}
					else{
						alert(response.data.msg);
					}
				}
			}
			http.send(params);
		}
		else{
			alert("Capture la Descripción del Concepto");
		}
	}
	else{
		alert("Capture el Nombre del Concepto");
	}
}

/*
	funciones utilizadas en la pantalla del CAC
*/
tipoconsulta = 0;

$(document).ready(function(){
	$('#txt_importe').bind("paste", function(e){
		return false;
	});
	$('#area_observaciones').bind("paste", function(e){
		return false;
	});
	$('#txt_nombre').bind("paste", function(e){
		return false;
	});
});

function changeSelect(){
	$("#opCadena").removeClass("item_selected");
	$("#opSubCadena").removeClass("item_selected");
	$("#opCorresponsal").removeClass("item_selected");

	if(tipoconsulta == 1){
		$("#opCadena").addClass("item_selected");
		//$("#chk_cargo_a").show();
		//$("#lbl_cargo_a").show();
		$('#txt_nombre').prop('disabled', false);
	}
	if(tipoconsulta == 2){
		$("#opSubCadena").addClass("item_selected");
		//$("#chk_cargo_a").show();
		//$("#lbl_cargo_a").show();
		$('#txt_nombre').prop('disabled', false);
	}
	if(tipoconsulta == 3){
		$("#opCorresponsal").addClass("item_selected");
		//$("#chk_cargo_a").hide();
		//$("#lbl_cargo_a").hide();
		$('#txt_nombre').prop('disabled', false);
	}
}

$(function(){
	if($("#txt_nombre").length) {
		$("#txt_nombre").autocomplete({
			source: function( request, respond ) {
				$.post( "../../inc/Ajax/_Contabilidad/CAC/cargaLista.php",
					{
						tipoconsulta	: tipoconsulta,
						"texto": request.term
					},
				function( response ) {
					if(!response.error){
						respond(response);
					}
					else{
						var msg = "Ha ocurrido un error";
						if(response.error > 1){
							msg = response.errmsg;
						}
						alert(msg);
					}
				}, "json" );
			},
			minLength: 2,
			focus: function( event, ui ) {
				if(ui.item.label == '' || ui.item.label == null){
					$("#txt_nombre").val( ui.item.label);
				} else {
					$("#txt_nombre").val( ui.item.label );
				}
				return false;	
			},
			select: function( event, ui ) {
				if ( ui.item.label == '' || ui.item.label == null ) {
					$("#txt_nombre").val(ui.item.label);
				} else {
					$("#txt_nombre").val(ui.item.label);
				}

				$("#id_choice").val(tipoconsulta);
				$("#ddlCad").val(ui.item.idCadena);
				$("#ddlSubCad").val(ui.item.idSubCadena);
				$("#ddlCorresponsal").val(ui.item.idCorresponsal);

				var mayor = " > ";
				$("#lblCad").text(ui.item.nombreCadena);
				if(ui.item.nombreSubCadena == ""){mayor="";}
				$("#lblSubCad").text(mayor + ui.item.nombreSubCadena);
				if(ui.item.nombreCorresponsal == ""){mayor="";}
				$("#lblCorr").text(mayor + ui.item.nombreCorresponsal);
				return false;	
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			if(tipoconsulta == 1 || tipoconsulta == 3){
				return $( '<li>' )
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
			}
			if(tipoconsulta == 2){
				return $( '<li>' )
				.append( "<a>" + item.label + "<br/><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.appendTo( ul );
			}
		};
	}

	$('#txt_nombre').blur(function(){
		if(!this.value){
			$("#ddlCad").val('');
			$("#ddlSubCad").val('');
			$("#ddlCorresponsal").val('');
			document.getElementById('divRES').innerHTML = "";
			$("#btn_nuevo_cargo").hide();
			$("#lblCad").text("");
			$("#lblSubCad").text("");
			$("#lblCorr").text("");
		}
	});
} );

function clearBusqueda(){
	$("#txt_nombre").val('');
	$("#id_choice").val('');
	$("#idCadena").val('');
	$("#idSubCadena").val('');
	$("#idCorresponsal").val('');

	$("#idConf").val('');
	$("#ddlCad").val('');
	$("#ddlSubCad").val('');
	$("#ddlCorresponsal").val('');
	$("#lblCad").text('');
	$("#lblSubCad").text('');
	$("#lblCorr").text('');

	document.getElementById('divRES').innerHTML = "";
}

function mostrarCapturaCAC(){
	$('#cfg_cac').show("slow");
	$('#idConf').val('');
	$('#txt_importe').val('');
	$('#area_observaciones').val('');
	//$('input[name=cargo_a]').attr('checked', false);
	$('#cmb_concepto').val(1);
	if(tipoconsulta != 3){
		//$("#chk_cargo_a").show();
		//$("#lbl_cargo_a").show();
	}
}

function hideCapturaCAC(){
	$('#cfg_cac').hide("slow");
	$('#txt_importe').val('');
	$('#area_observaciones').val('');
	//$('input[name=cargo_a]').attr('checked', false);
	$('#cmb_concepto').val(1);
}

function eliminarCargo(idConf){
	if(confirm("Desea eliminar el Cargo")){
		if(idConf != ""){
			var params = "idConf="+ idConf;

			http.open("POST", "../../inc/Ajax/_Contabilidad/CAC/deleteCAC.php", true);
			http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

			http.onreadystatechange=function(){
				if (http.readyState==1){
					Emergente();
				}
				if (http.readyState==4){
					var RespuestaServidor = http.responseText;
					validaSession(RespuestaServidor);

					var response = eval("("+ RespuestaServidor +")");

					if(response.error == 0){
						var msg = response.msg;
						alert(msg);
						mostrarCargosCAC();
					}
					else{
						alert(response.msg);
					}
				}
			}
			http.send(params);
		}
	}	
}

function clearSelect(){
	$("#opCadena").removeClass("item_selected");
	$("#opSubCadena").removeClass("item_selected");
	$("#opCorresponsal").removeClass("item_selected");
}

function editarCargo(idConf){
	clearSelect();
	var params = 'idConf=' + idConf;

	$.post( "../../inc/Ajax/_Contabilidad/CAC/cargaCAC.php",
		{idConf : idConf},
		function(response){
			if(!response.error){
				mostrarCapturaCAC();
				console.log(response);

				if(response.msg){
					var msg = response.msg;
					alert(msg);
				}

				//$("#chk_cargo_a").hide();
				//$("#lbl_cargo_a").hide();
				$("#cmb_concepto").val(response.idConcepto);
				$("#txt_importe").val(response.importe);
				$("#fechaInicio").val(response.fechaInicio);
				$("#area_observaciones").val(response.observaciones);
				$("#idConf").val(response.idConf);
				$("#idCadena").val(response.idCadena);
				$("#idSubCadena").val(response.isSubCadena);
				$("#idCorresponsal").val(response.idCorresponsal);
				$("#ddlCad").val(response.idCadena);
				$("#ddlSubCadena").val(response.idSubCadena);
				$("#ddlCorresponsal").val(response.idCorresponsal);
			}
			else{
				var msg = "Ha ocurrido un error";
				if(response.error > 1){
					msg = response.errmsg;
				}
				alert(msg);
			}
		}
	, "json" );
}

function guardarCAC(){
	var idConf			= $('#idConf').val();
	var idCadena		= $('#ddlCad').val();
	var idSubCadena		= $('#ddlSubCad').val();
	var idCorresponsal	= $('#ddlCorresponsal').val();
	var idConcepto		= $('#cmb_concepto').val();
	var importe			= $('#txt_importe').val();
	var fechaInicio		= $('#fechaInicio').val();
	var observaciones	= $('#area_observaciones').val();

	/*if($("#chk_cargo_a").is(':checked')){
		var cargo_corresponsal = 1;
	}
	else{
		var cargo_corresponsal = 0;
	}*/

	if(idCadena <= -1 && idSubCadena <= -1 && idCorresponsal <= -1){
		alert("Capture Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	if(idCadena =="" && idSubCadena == "" && idCorresponsal == ""){
		alert("Capture Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	if(idConcepto == ""){
		alert("Capture Concepto");
		return false;
	}

	if(importe == ""){
		alert("Capture Importe");
		return false;
	}

	if(fechaInicio == ""){
		alert("Capture fechaInicio");
		return false;
	}

	if(observaciones == ""){
		alert("Capture Observaciones");
		return false;
	}

	var params = 'idConf='+idConf +'&tipoconsulta='+tipoconsulta /*+'&cargo_corresponsal='+cargo_corresponsal*/ +'&idCadena='+idCadena +'&idSubCadena='+idSubCadena +'&idCorresponsal='+idCorresponsal +'&idConcepto='+idConcepto +'&importe='+importe +'&fechaInicio='+fechaInicio +'&observaciones='+observaciones;

	http.open("POST", "../../inc/Ajax/_Contabilidad/CAC/crearCAC.php", true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function(){
		if (http.readyState==1){
			Emergente();
		}
		if (http.readyState==4){
			var RespuestaServidor = http.responseText;
			validaSession(RespuestaServidor);

			var response = eval("("+ RespuestaServidor +")");
			if(response.error == 0){
				alert(response.msg);
				hideCapturaCAC();
				mostrarCargosCAC();
				OcultarEmergente();
			}
			else{
				alert(response.errmsg);
				OcultarEmergente();
			}
		}
	}
	http.send(params);
}

/*
	Obtiene los parametros idCadena, idSubCadena y idCorresponsal y envia una petición ajax para cargar la pantalla de la lista de Cargos
*/
function mostrarCargosCAC(){
	resetDivConsulta();
	var idCadena		= $('#ddlCad').val();
	var idSubCadena		= $('#ddlSubCad').val();
	var idCorresponsal	= $('#ddlCorresponsal').val();

	if(idCadena == "" && idSubCadena == "" && idCorresponsal == ""){
		alert("Seleccione Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	if(idCadena <= -1 && idSubCadena <= -1 && idCorresponsal <= -1){
		alert("Seleccione Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	var params = 'idCadena='+idCadena +'&idSubCadena='+idSubCadena +'&idCorresponsal='+idCorresponsal;
	Emergente();
	BuscarParametros("../../inc/Ajax/_Contabilidad/CAC/ListaCargosCAC.php", params);
	$("#btn_nuevo_cargo").show();
	Ordenar();
	Ordenar2();
	Ordenar3();
}


/*
	FUNCIONES UTILIZADAS EN LA CONSULTA DE CARGOS DEL CAC
*/

function resetDivConsulta(){
	clearBusquedaCompleta();
	$('#txt_nombres').val('');
	$('#txt_numCuenta').val('');
	$('#txt_nombres').prop('disabled', true);
	$("#opSubCadenas").removeClass("item_selected");
	$("#opCorresponsales").removeClass("item_selected");
	$("#cpag").val(20);
}

function consultaCargosCAC(){
	resetDivConsulta();
	var idCadena		= $('#ddlCad').val();
	var idSubCadena		= $('#ddlSubCad').val();
	var idCorresponsal	= $('#ddlCorresponsal').val();

	if(idCadena == "" && idSubCadena == "" && idCorresponsal == ""){
		alert("Seleccione Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	if(idCadena <= -1 && idSubCadena <= -1 && idCorresponsal <= -1){
		alert("Seleccione Cadena, SubCadena y/o Corresponsal");
		return false;
	}

	var params = 'idCadena='+idCadena +'&idSubCadena='+idSubCadena +'&idCorresponsal='+idCorresponsal;
	Emergente();

	BuscarParametros("../../inc/Ajax/_Contabilidad/ConsultaCargos/ListaCargos.php", params);
	$("#divFiltrosConsultaCompleta").hide();
	$("#divFiltrosConsulta").show();
}

$(function(){
	$("#btn_reset_busqueda_completa").on("click", function(){
		resetDivConsulta();
		var idCad		= $("#idCad").val();
		var idSubCad	= $("#idSubCad").val();
		var idCorr		= $("#idCorr").val();

		if(idCad == "" || idCad == undefined){
			$("#idCad").val($("#ddlCad").val());
			idCad = $("#ddlCad").val();
		}
		if(idSubCad == "" || idSubCad == undefined){
			$("#idSubCad").val($("#ddlSubCad").val());
			idSubCad = $("#ddlSubCad").val();
		}
		if(idCorr == "" || idCorr == undefined){
			$("#idCorr").val($("#ddlCorresponsal").val());
			idCorr = $("#ddlCorresponsal").val();
		}

		listaCompletaCargos(idCad, idSubCad, idCorr, undefined, 0, 20);
	});

	/*
		"Cierra" la ventana de detalle en la PAntalla de Consultas de Cargos del CAC
	*/
	$("#cerrar").on("click",function(){
		$("#base").fadeOut("normal");
		$("#base2").fadeOut("normal");
		$("#base").fadeOut("normal");
		$("#base4").fadeOut("normal");
	});
});

function listaCompletaCargos(idCadena, idSubCadena, idCorresponsal, tipoCategoria, start, limit){
	/*$("#base").css({"visibility":"visible"});
	$("#base").fadeTo("normal",0.4);
	$("#base4").css({"visibility":"visible"});
	$("#base4").fadeIn("normal");*/

	var lbl = "";
	if(tipoCategoria == 1){
		lbl = "Cadena";
	}
	if(tipoCategoria == 2){
		lbl = "SubCadena";
	}
	if(tipoCategoria == 3){
		lbl = "Corresponsal";
	}

	$("#title_dtl_cac").text(lbl);

	Emergente();
	limit = (limit != undefined)?limit : 20;

	$.post("../../inc/Ajax/_Contabilidad/ConsultaCargos/ListaCompletaCargos.php",{
		idCadena		: (idCadena != undefined)? idCadena : $('#idCad').val(),
		idSubCadena		: (idSubCadena != undefined)? idSubCadena : $('#idSubCad').val(),
		idCorresponsal	: (idCorresponsal != undefined)? idCorresponsal : $('#idCorr').val(),
		tipoCategoria	: (tipoCategoria != undefined)? tipoCategoria : tipoCategoriaSelected,
		numeroCuenta	: $("#txt_numCuenta").val(),
		cant			: ($("#cpag").length)? $("#cpag").val() : limit,
		actual			: (start != undefined)? start : $("#actual").val()
	},
		function(response){
			$("#divFiltrosConsulta").hide();
			$("#divFiltrosConsultaCompleta").show();
			
			$("#divRES").empty();
			$("#divRES").html(response);
			$("#divRES").fadeIn("slow");
			OcultarEmergente();
			Ordenar();
		}
	);
}

function validaParametrosBusquedaCompleta(){

	var idCad		= $("#idCad").val();
	var idSubCad	= $("#idSubCad").val();
	var idCorr		= $("#idCorr").val();
	var numCuenta	= $("#txt_numCuenta") .val();

	if(idCad == "" || idCad == undefined){
		$("#idCad").val($("#ddlCad").val());
	}

	if((idSubCad == "" && idCorr == "" && numCuenta == "") || (idSubCad == undefined && idCorr == undefined && numCuenta == undefined)){
		alert("Seleccione una SubCadena o Corresponsal, o Teclee un Número de Cuenta");
		return false;
	}

	listaCompletaCargos(undefined, undefined, undefined, undefined, 0, 20);
}

function clearBusquedaCompleta(){
	$("#idCad").val("");
	$("#idSubCad").val("");
	$("#idCorr").val("");
}

tipoConsultaCompleta = 0;
function changeSelectCompleta(){
	$("#opCadenas").removeClass("item_selected");
	$("#opSubCadenas").removeClass("item_selected");
	$("#opCorresponsales").removeClass("item_selected");

	if(tipoConsultaCompleta == 1){
		$("#opCadenas").addClass("item_selected");
		$('#txt_nombres').prop('disabled', false);
	}
	if(tipoConsultaCompleta == 2){
		$("#opSubCadenas").addClass("item_selected");
		$('#txt_nombres').prop('disabled', false);
	}
	if(tipoConsultaCompleta == 3){
		$("#opCorresponsales").addClass("item_selected");
		$('#txt_nombres').prop('disabled', false);
	}
}

$(function(){
	if($("#txt_nombres").length) {
		$("#txt_nombres").autocomplete({
			source: function( request, respond ) {
				$.post( "../../inc/Ajax/_Contabilidad/ConsultaCargos/cargaListaNombres.php",
					{
						tipoconsulta	: tipoConsultaCompleta,
						texto			: request.term,
						idCadena		: $("#ddlCad").val()
					},
				function( response ) {
					if(!response.error){
						respond(response);
					}
					else{
						var msg = "Ha ocurrido un error";
						if(response.error > 1){
							msg = response.errmsg;
						}
						alert(msg);
					}
				}, "json" );
			},
			minLength: 2,
			focus: function( event, ui ) {
				if(ui.item.label == '' || ui.item.label == null){
					$("#txt_nombres").val( ui.item.label);
				} else {
					$("#txt_nombres").val( ui.item.label );
				}
				return false;	
			},
			select: function( event, ui ) {
				if ( ui.item.label == '' || ui.item.label == null ) {
					$("#txt_nombres").val(ui.item.label);
				} else {
					$("#txt_nombres").val(ui.item.label);
				}

				$("#idCad").val(ui.item.idCadena);
				$("#idSubCad").val(ui.item.idSubCadena);
				$("#idCorr").val(ui.item.idCorresponsal);

				/*var mayor = " > ";
				$("#lblCad").text(ui.item.nombreCadena);
				if(ui.item.nombreSubCadena == ""){mayor="";}
				$("#lblSubCad").text(mayor + ui.item.nombreSubCadena);
				if(ui.item.nombreCorresponsal == ""){mayor="";}
				$("#lblCorr").text(mayor + ui.item.nombreCorresponsal);*/
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			if(tipoConsultaCompleta == 1 || tipoConsultaCompleta == 3){
				return $( '<li>' )
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
			}
			if(tipoConsultaCompleta == 2){
				if(item.nombreCadena == ""){
					item.nombreCadena = $('#lblCad').text();
				}
				return $( '<li>' )
				.append( "<a>" + item.label + "<br/><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.appendTo( ul );
			}
		};
	}

	$('#txt_nombres').blur(function(){
		if(!this.value){
			$("#idCad").val('');
			$("#idSubCad").val('');
			$("#idCorr").val('');
		}
	});

	$('#linkExcelConsulta').on('click', function(){
		showEXCELConsulta();
		//alert("alertalertalert");
	});
});

function showEXCELConsulta(){
	var inputTodos = $("#todoexcelbusqueda");
	$("#formExcel").empty();
	$("#formExcel").append('<input type="checkbox" id="todoexcelbusqueda"/><label for="todoexcelbusqueda">Todo</label><br/><a href="#" class="liga_descarga_archivos" id="linkExcelConsulta">Exportar a Excel</a>');

	var allInputs = $(".div_params_busqueda :input");
	allInputs.push($("#actual"));
	allInputs.push($("#cpag"));
	var nInputs = allInputs.length;

	var labels = new Array();
	var values = new Array();

	for(var i = 0; i < nInputs; i++){
		var inputActual = allInputs[i];

		var id = $(inputActual).attr("id");
		var valor = $(inputActual).val();
		if(valor == ""){
			var nid = id.replace("id", "ddl");
			valor = $("#"+nid).val();
		}

		var newInput = "<input type=\"hidden\" name = '"+id+"' value = '"+valor+"'>";

		$("#formExcel").append(newInput);

		/*if(id != "actual" && id != "cpag" && id != "" && id != undefined){
			var tipo = $(inputActual).type;
			if((valor > -1 && tipo == 'select') ||(valor != "" && tipo == 'text')){
				if(tipo == 'select'){
					valor = $("#"+id+" option:selected").text();
				}
				var lbl = $("label[for='"+id+"']");
				labels.push(lbl[0].innerHTML);
				values.push(valor);
			}
		}*/
	}//for

	$("#formExcel").append("<input type=\"hidden\" name=\"tipoCategoria\" value='" + tipoCategoriaSelected + "'>");
	$("#formExcel").append("<input type=\"hidden\" name=\"labels\" value='"+labels.join(",")+"'>");
	$("#formExcel").append("<input type=\"hidden\" name=\"values\" value='"+values.join(",")+"'>");

	var form = $("#formExcel");

	if($(inputTodos).is(':checked')){
		var total = $("#totalreg").val();
		form[0].cpag.value	= total;
	}

	$("#formExcel").submit();
}

/*
	función utilizada para los filtros de referencias bancarias, ya que esos filtros no llevan
	la opción 'Todos'
*/
function buscarCorresponsalRefBanc(j){
	var subcadena = document.getElementById("ddlSubCad").value;
	if(subcadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 1)
		BuscarAccesos()
		
	}
	else{
	ClearRes();
	var parametros = "";
	switch(j){
		case 1:parametros = "&j=1&funcion2= BuscaCorresponsal()";
		break;
		case 2:parametros = "&j=2&funcion2= BuscaCorresponsal()";
		break;
		case 3:parametros = "&j=3&funcion2= BuscaCorresponsal()";
		break;
		case 4:parametros = "&j=4&funcion2= BuscaOperaIncompetas()";
		break;
	}
	document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield'><option value='-3'>Seleccione un corresponsal</option><option value='-1'>General</option>";
	if(document.getElementById("divcodigo") != null)
		document.getElementById("divcodigo").innerHTML = "<p class='anuncio'>No se Encontro codigo,<a onclick='CrearCodigoSinTenerlo()' style='cursor:pointer'> <span class='anuncio-import'>Crear uno aqui</span></a></p>";
		
    var i = document.getElementById("ddlSubCad").selectedIndex;
	http.open("POST","../../inc/Ajax/BuscaCorresponsales.php", true);
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
			document.getElementById("divcorresponsal").innerHTML = RespuestaServidor;
			OcultarEmergente();
		} 
	}
	http.send("idcad="+document.getElementById("ddlCad").value+"&idsubcad="+document.getElementById("ddlSubCad").value+"&al=1"+parametros);	
	}
}
/*
	función utilizada para los filtros de referencias bancarias, ya que esos filtros no llevan
	la opción 'Todos'
*/
function buscarSubCadenaRefBanc(j){
	var cadena = document.getElementById("ddlCad").value;

	if(cadena == -2){//Busqueda de todos los accesos
		document.getElementById("ddlSubCad").value = -2;
		document.getElementById("ddlCorresponsal").value = -2;
		document.getElementById("ddlSubCad").disabled = true;
		document.getElementById("ddlCorresponsal").disabled = true;
		//Aqui mandar llamar a la busqueda de accesos!!
		if(j == 4)
			BuscaOperaIncompetas()
			
	}else{
		ClearRes();
		//busqueda de select subcadena
			document.getElementById("divsubcad").innerHTML = "<select id='ddlSubCad' class='textfield' disabled='disabled'><option value='-3'>Seleccione una subcadena</option><option value='-1' selected='selected'></option></select>";
			document.getElementById("divcorresponsal").innerHTML = "<select id='ddlCorresponsal' class='textfield' disabled='disabled'><option value='-3'>Seleccione un corresponsal</option><option value='-1' selected='selected'></option></select>";
							
			var parametros = "";
			switch(j){
				case 1:parametros = "&j=1&funcion2= buscarCorresponsalRefBanc()";
				break;
				case 2:parametros = "&j=2&funcion2= buscarCorresponsalRefBanc()";
				break;
				case 3:parametros = "&j=3&funcion2= buscarCorresponsalRefBanc()";
				break;
				case 4:parametros = "&j=4&funcion2= BuscaOperaIncompetas()";
				break;
                                case 5: parametros = "&j=4";
                                break;
			}
			
			var i = document.getElementById("ddlCad").selectedIndex;
			
			
			http.open("POST","../../inc/Ajax/BuscaSubCadena.php", true);
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
					document.getElementById("divsubcad").innerHTML = RespuestaServidor;
					OcultarEmergente();
					if(cadena == 0){
						window.setTimeout("buscarCorresponsalRefBanc("+j+")",10);
					}
					switch(j){
						
						case 4:BuscaOperaIncompetas();
						break;
					}
				} 
			}
			http.send("idcad="+cadena+parametros);	
	}
}

function crearReferenciaBancaria(numCuenta){
	var http;
	if(window.XMLHttpRequest){
		http = new XMLHttpRequest();
	}
	else{
		http = new ActiveXObject("Microsoft.XMLHTTP");
	}
	http.onreadystatechange=function(){
		if(http.readyState == 4 && http.status == 200){
			var response = eval("(" + http.responseText + ")");

			alert(response[0].DescRespuesta);

			BuscarReferenciasBancarias();
		}
	}

	http.open("GET","../../../inc/Ajax/_Contabilidad/createReferenciaBancaria.php?numCuenta="+numCuenta,true);
	http.send();
}

function BuscarReferenciasBancarias(){
	var cadena = document.getElementById("ddlCad").value;
	var subcadena = document.getElementById("ddlSubCad").value;
	var corresponsal = document.getElementById("ddlCorresponsal").value;

	var parametros = "";

	if(cadena > -2 || subcadena >-2 || corresponsal > -2){

		parametros += "idCadena="+ cadena +"&idSubCadena=" + subcadena + "&idCorresponsal=" + corresponsal;
		BuscarParametros("../../inc/Ajax/_Contabilidad/BuscaReferenciasBancarias.php",parametros);
	}
	else{
		alert("Seleccione una opción");
	}
}

function ExportarRefBancarias(){
	document.getElementById("formRefBanc").submit();
}

function BuscarPagoCorresponsal(i){
	var cad 	= txtValue('ddlCad');
	var subcad	= txtValue('ddlSubCad');
	var corr	= txtValue('ddlCorresponsal');
	var mes		= txtValue('ddlMes');
	var ano		= txtValue('ddlAno');
/*	if(mes > 0){
		
		if(ano > 0){*/
			parametros = "&cadena="+cad+"&subcadena="+subcad+"&corresponsal="+corr+"&mes="+mes+"&ano="+ano;
			BuscarParametros("../../../inc/Ajax/_Contabilidad/BuscaPagoCorresponsal.php","status=3"+parametros,'',i);
			
	/*	}else{alert("Selecione un año por favor");}
	}else{alert("Selecione un mes por favor");}*/
}


function BuscarPagoIntermediarios(i){
	
	var inter 	= txtValue('ddlIntermediario');
	var mes		= txtValue('ddlMes');
	var ano		= txtValue('ddlAno');
/*	if(mes > 0){
		
		if(ano > 0){*/
			parametros = "&inter="+inter+"&mes="+mes+"&ano="+ano;
			//alert(parametros);
			BuscarParametros("../../../inc/Ajax/_Contabilidad/BuscaPagoIntermediario.php","status=3"+parametros,'',i);
			
	/*	}else{alert("Selecione un año por favor");}
	}else{alert("Selecione un mes por favor");}*/
}

function NewFactura(i) {
    //alert(Date.parse(txtValue('txtFechaFin')));
    var error = "";
    var tipDcto = "";
    var idprov		= txtValue('ddlProveedor');

    if(txtValue('ddlProveedor') == -1)
    	error += "- Seleccione Proveedor\n";
    if(txtValue('txtTipoDcto') == 0) 
        error += "- Seleccione un tipo de documento\n";
    if(txtValue('txtTipoDcto') == 1) 
        tipDcto = "Factura";
    else if(txtValue('txtTipoDcto') == 2) 
        tipDcto = "Recibo";
    if(txtValue('ddlProveedor') == -2)
        error += "- Seleccione un proveedor\n"; 
    if(txtValue('txtRFC').length <= 11)
        error += "- RFC inv\u00E1lido\n"; 
    if(txtValue('txtNumCta').length < 3)
        error += "- No. Cuenta, m\u00EDnimo 3 caracteres\n";
    
    if ( !$('#txtTipoCambio').is('[readonly]') ){
    	var tipoC = $('#txtTipoCambio').val();
    	tipoC = tipoC.replace('$', '');
    	if(tipoC.trim() == '' || tipoC == 0){
    		error += "-Capture Tipo de Cambio \n";
    	}
    }
    if(txtValue('txtFechaFactura').length <= 5)
        error += "- Fecha de " + tipDcto + " inv\u00E1lida\n"; 
    if(txtValue('txtFechaIni').length <= 5)
        error += "- Fecha Inicio no v\u00E1lida\n"; 
    if(txtValue('txtFechaFin').length <= 5)
        error += "- Fecha Fin no v\u00E1lida\n"; 
    if(Date.parse(txtValue('txtFechaIni')) > Date.parse(txtValue('txtFechaFin')))
        error += "- Fecha Fin no puede ser menor a Fecha Inicio\n";
    
    var valFactura = txtValue('txtNumFactura');
    if(valFactura.length < 1 || valFactura.trim() == '' || valFactura == 0)
        error += "- No. Factura, inv\u00E1lido\n"; 

    if(txtValue('txtTipoDcto') == 1) {
        if(txtValue('txtSubtotal') == "$0.00")
            error += "- Subtotal debe ser mayor a $0.00\n";
        /*if(txtValue('txtIVA') == "$0.00")
            error += "- IVA debe ser mayor a $0.00\n"; */       
		
    }
    if(txtValue('txtTotal') == "$0.00")
        error += "- Total debe ser mayor a $0.00\n"; 
    if(txtValue('txtTipoDcto') == 1) {
        numSubtotal = Number(formatNumber(txtValue('txtSubtotal'),0,2,false));
        numIVA = Number(formatNumber(txtValue('txtIVA'),0,2,false));
        sumTotal = formatNumber(numSubtotal + numIVA,0,2,false)
        if(formatNumber(txtValue('txtTotal'),0,2,false) != sumTotal)
            error += "- El total no es igual a la suma de Subtotal + el IVA";     
    }
    if(txtValue('txtDetalle').length < 5)
        error += "- Detalle, m\u00EDnimo 5 caracteres\n"; 
    if(error != "")
    alert('Se encontraron errores en el formulario\n'+error);    
    else {
        /* Alta de nuevo registro */
        $('#ddlProveedor').prop('disabled', false);
        $('#txtMoneda').prop('disabled', false);
        $('#txtFechaFactura').prop('disabled', false);
		$("#txtRazonSocial").val($("#ddlProveedor option:selected").text());
        /*MetodoAjax5("../../inc/Ajax/_Contabilidad/NewFactura.php", $("form").serialize());    */

        $("#formAlta").submit(function(e){

			if(window.FormData !== undefined){
				var items = $('#formAlta :disabled');
				items.prop('disabled', false);
				var formData = new FormData(this);
				$(items).prop('disabled', true);

				$.ajax({
					url			: BASE_PATH + '/inc/Ajax/_Contabilidad/NewFactura.php',
					type		: 'POST',
					data		: formData,
					mimeType	: "multipart/form-data",
					contentType	: false,
					cache		: false,
					processData	: false,

					success		: function(response, textStatus, jqXHR){
						var items = response.split("|");
						alert(items[1]);
						if($("#idFactura").val() == 0){
							if(items[0] == 0){
								$('#formAlta [name="txtTipoDcto"]').val(-1).change();
							}
						}
						else{
							if($("#idFactura").val() > 0){
								BuscarFacturaRecibo();
							}
						}
					},
					error		: function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR, textStatus, errorThrown);
					}
				});
				e.preventDefault();
				$(this).unbind();
			}
			else{
				var iframeId = 'unique' + (new Date().getTime());
				var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');

				iframe.hide();
				formObj.attr('target',iframeId);
				iframe.appendTo('body');

				iframe.load(function(e){
					var doc		= getDoc(iframe[0]);
					var docRoot = doc.body ? doc.body : doc.documentElement;
					var data	= docRoot.innerHTML;
					$("#multi-msg").html('<pre><code>'+data+'</code></pre>');
				});
			}
		});
		$("#formAlta").submit();

    }
}
function BuscarFacturaRecibos(i){
	
	var prov 	= txtValue('ddlProveedor');
	var numfac	= txtValue('txtNumFactura');
	var numcta	= txtValue('txtNumCta');
	if(prov > 0 || numfac != "" || numcta != ""){
		var tipo = 1;
		if(Check('Factura'))
			tipo = 0;
		parametros ="tipoDoc="+tipo;
		
		if(prov > 0 && numcta == "")
			parametros += "&numcta="+prov;
		if(numcta != "")
			parametros += "&numcta="+numcta;
		if(numfac != "" && numfac != "----------------")
			parametros += "&numfac="+numfac;
			//alert(parametros);
			BuscarParametros("../../inc/Ajax/_Contabilidad/BuscaFacturaRecibo.php",parametros,'',i);
	}
}


function DatosProv() {
    var idProveedor = txtValue('ddlProveedor');
    if(idProveedor > -1){
        http.open("POST","../../../inc/Ajax/_Contabilidad/DatosProveedor.php", true);
        http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        http.onreadystatechange=function() { 
            if (http.readyState==1) {
                Emergente();
            }
            if (http.readyState==4) {
                OcultarEmergente();
                var RespuestaServidor = http.responseText;
                var RESserv = RespuestaServidor.split("|");
                if(RESserv[0] == 0) {
                    if(Existe('txtRFC')) setValue('txtRFC',RESserv[2]);
                    if(Existe('txtRazonSocial')) setValue('txtRazonSocial',RESserv[3]);
                    if(Existe('txtNumCta')) setValue('txtNumCta',RESserv[4]);
                }
                else {
                        alert("Error: "+RESserv[0]+" "+RESserv[1]);
                }			
            } 
        }
        http.send("idProveedor="+idProveedor);	
    } else {
        if(Existe('txtNumCta')) setValue('txtNumCta','');
        validaTipoDcto();
    }
}

function RF(){
	if(Check('Factura')){
		Desbloquear('txtNumFactura');
		setValue('txtNumFactura','');
		
		if(Existe('txtSubtotal')){
			Desbloquear('txtSubtotal');
			setValue('txtSubtotal','');
		}
		if(Existe('txtIva')){
			Desbloquear('txtIva');
			setValue('txtIva','');
		}
		setDivHTML('subtit','Factura');
	}else{
		Bloquear('txtNumFactura');
		setValue('txtNumFactura','----------------');
		
		if(Existe('txtSubtotal')){
			Bloquear('txtSubtotal');
			setValue('txtSubtotal','----------------');
		}
		if(Existe('txtIva')){
			Bloquear('txtIva');
			setValue('txtIva','----------------');
		}
		setDivHTML('subtit','Recibo');
	}
}





/* =============================================================================*/
/*		esta funcion es para agregar el detalle a la tabla de las facturas		*/
/* =============================================================================*/
function AgregarDetalle(){
	var index		= txtValue('Index');
	
	alert(index);
	
	
	var objTr = document.createElement("tr");
		//objTr.id = "rowDetalle_" + index;
		var objTd1 = document.createElement("td");
		//objTd1.id = "tdDetalle_1_" + index;
		objTd1.innerHTML = '<input type="text" id="txtCant'+index+'" name="txtCant'+index+'" class="textfield"/>';
		var objTd2 = document.createElement("td");
		//objTd2.id = "tdDetalle_2_" + index;	
		objTd2.innerHTML = '<input type="text" id="txtDesc'+index+'" name="txtDesc'+index+'" class="textfield"/>';
		var objTd3 = document.createElement("td");
		//objTd3.id = "tdDetalle_3_" + index;	
		objTd3.innerHTML = '<input type="text" id="txtPrecio'+index+'" name="txtPrecio'+index+'" class="textfield"/>';
		var objTd4 = document.createElement("td");
		//objTd4.id = "tdDetalle_4_" + index;	
		objTd4.innerHTML = '<input type="text" id="txtTotal'+index+'" name="txtTotal'+index+'" class="textfield"/>';

	
		objTr.appendChild(objTd1);
		objTr.appendChild(objTd2);
		objTr.appendChild(objTd3);
		objTr.appendChild(objTd4);

	
		var objTbody = document.getElementById("tbDetalle");
		objTbody.appendChild(objTr);
	document.getElementById("Index").value = parseInt(index)+1;
}



function BuscaReporteContaDeposito(i){
	//var parametros ="numcuenta="+tipo+"&fechai="+fechai+"&fechaf="+fechaf;
	var parametros ="numcuenta=70020108914&importe=-1&folio=-1&status=-1&importe=-1&tipo=-1";
			
	BuscarParametros("../../inc/Ajax/_Contabilidad/BuscaDepositos.php",parametros,'',i);
}
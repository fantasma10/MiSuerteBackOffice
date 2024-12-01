
$(function(){
	$("#txtCorreo, #txtTel1, #txtNombreCadena").bind("paste", function(){return false;});

	$("#txtTelCadena").focus(function(){
		var valor = $("#txtTelCadena").val();
		if(valor.trim() == ""){
			$("#txtTelCadena").val("52-");
			$("#txtTelCadena").putCursorAtEnd();
		}
	});

	$("#txtTelSub").focus(function(){
		var valor = $("#txtTelSub").val();
		if(valor.trim() == ""){
			$("#txtTelSub").val("52-");
			$("#txtTelSub").putCursorAtEnd();
		}
	});

	/*$("#txtTelCadena").keyup(function(){
		var valor = $("#txtTelCadena").val();
		if(valor.trim() == ""){
			$("#txtTelCadena").val("52-");
		}
	});*/

	$("#txtTel1").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑ",
		disallow: "¿¡°´¨~-",
		allowLatin: true,
		allowOtherCharSets: false
	});

	$("#txtCorreo, #txtMailContac").alphanum({
		allow: "@.",
		disallow: "¿¡°´¨~-áéíóúÁÉÍÓÚñÑ",
		allowLatin: true,
		allowOtherCharSets: false
	});

	$("#txtNombreCadena").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑ",
		disallow: "¿¡°´¨~-",
		allowLatin: true,
		allowOtherCharSets: false
	});

	$("#txtContacNom, #txtContacAP, #txtContacAM, #txtTelContac, #txtExtTelContac, #txtMailContac").bind("paste", function(){return false;});

	$("#txtContacNom, #txtContacAP, #txtContacAM").alphanum({
		allow: "áéíóúÁÉÍÓÚñÑ",
		disallow: "¿¡°´¨~-1234567890-+",
		allowLatin: true,
		allowOtherCharSets: false
	});
});

function verCorresponsalesPopUp2(idCade,cantidad, nombre){
	if(idCade >= 0){
		setDivHTML('NomCorPopUp',"Corresponsales");
		MetodoAjaxDiv("../../inc/Ajax/_Clientes/VerCorresponsales.php","idCadena="+idCade+"&cantidad="+cantidad+"&nombreSub="+nombre);
	}else{alert("no tienes cadena ni subcadena, favor de verificar");}
}

function downloadExcelListaCorresponsales(idCadena, idSubCadena, nombre, cantidad){
	Emergente();

	$.fileDownload("../../../inc/Ajax/_Clientes/VerCorresponsales.php?idCadena="+idCadena+"&idSubcadena="+idSubCadena+"&nombreSub="+nombre+"&cantidad="+cantidad+"&downloadExcel=true", {
		successCallback: function(url) {
			OcultarEmergente();
		},
		failCallback: function(responseHtml, url){
			OcultarEmergente();
			alert("Ha ocurrido un error");
		}
	});
	return false;
}

function eliminarVersion(idGrupo, idCadena, idVersion){
	$.post("../../../inc/Ajax/_Clientes/eliminarVersion.php",
	{
		idGrupo		: idGrupo,
		idCadena	: idCadena,
		idVersion	: idVersion
	},function(response){
		if(showMsg(response)){
			alert(response.msg);
			return false;
		}
		irAEditar();
	}, "json");
}


function showNuevaCuentaBancaria(numCuenta){
	setDivHTML('NomCorPopUp',"Corresponsales");

	$.post("../../../_Clientes/CrearConfCuenta.php",{
		numCuenta : numCuenta
	},
		function(response){
			MostrarPopUp(response);
		}
	)
}

function DeleteConfiguracionCuenta(idConfiguracion){
	var g = confirm("\u00BFSeguro que desea Eliminar?");
	if(g){
		$.post("../../../inc/Ajax/_Clientes/DestroyConfigCuenta.php",
		{
			idConfiguracion	: idConfiguracion
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
}

$(function(){

	//$("#ddlTipoMovimiento").change(function(){
		cargarTiposInstruccion();
	//});
	$("#ddlDestino").change(function(){
		HideShowDiv();
		changeCuenta();
	});

});

function changeCuenta(){
	var destino = $("#ddlDestino").val();

	if(destino != 2){
		var valor = $("#txtNumCuentaForelo").val();
		$("#txtNumCuenta").val(valor);

		$("#txtCLABE").val("");
		$("#txtBeneficiario").val("");
		$("#txtRFC").val("");
		$("#txtCorreo").val("");
		$("#txtBanco").val("");
	}
}


function resetConfs(){
	$('#txtCLABE').unbind();
	$('#txtNumCuenta').unbind();
	$('#txtBeneficiario').unbind();
	$('#txtRFC').unbind();
	$('#txtCorreo').unbind();
}

permitirGuardarCta = true;
function setSomeConfs(){
	resetConfs();
	$("#txtCLABE").attr('maxlength','18');
	$("#txtCLABE").unbind("paste");
	$("#txtNumCuenta").attr('maxlength','10');
	$("#txtBeneficiario").attr('maxlength','35');
	$("#txtRFC").attr('maxlength','13');
	$("#txtMailContac").attr('maxlength','100');
	$("#txtCorreo").attr('maxlength','100');
	$("#txtNumCuenta").attr("readonly", true);
	$("#txtCuenta").attr("readonly", true);
	$("#txtBanco").attr("readonly", true);

	$("#txtCLABE").keyup(function(event) {
		var texto = $("#txtCLABE").val();
		var ncar = texto.length;

		if(ncar < 3){
			$("#txtBanco").val("");
		}
	});

	$("#txtCLABE").keyup(function(event) {
		var clabe = $("#txtCLABE").val();
		buscaBancoClabe(clabe);
		analizarCLABEConsulta();
	});

	$("#txtCLABE").keypress(function(event) {
		var clabe = $("#txtCLABE").val();
		buscaBancoClabe(clabe);
		analizarCLABEConsulta();
	});

	$("#txtNumCuenta, #txtCLABE").bind('keypress', function(e){  
		if(e.keyCode == '9' || e.keyCode == '16'){  
			return;  
		}  
		var code;  
		if (e.keyCode) code = e.keyCode;  
		else if (e.which) code = e.which;   
		if(e.which == 46)  
			return false;  
		if (code == 8 || code == 46)  
			return true;  
		if (code < 48 || code > 57)  
			return false;  
		}  
	);

	$("#txtCLABE").bind('keypress', function(e){
		if(e.keyCode == '9' || e.keyCode == '16'){  
			return;  
		}  
		var code;  
		if (e.keyCode) code = e.keyCode;  
		else if (e.which) code = e.which;   
		if(e.which == 46)  
			return false;  
		if (code == 8 || code == 46)  
			return true;  
		if (code < 48 || code > 57)  
			return false;  
	});

	$("#txtBeneficiario").alpha();
	$("#txtRFC").alphanum();
	$("#txtCLABE").numeric();

	$("#txtNumCuenta, #txtBeneficiario, #txtCorreo, #txtRFC").bind("paste", function(){
		return false;
	});

	$("#txtRFC").blur(function(e){
		var rfc = $("#txtRFC").val();

		if(rfc != "" && rfc != undefined && rfc != null){
			if(!validaRFC("txtRFC")){
				alert("El RFC no tiene un formato válido");
				return false;
			}
		}
	});

	$("#txtCorreo").blur(function(e){
		var correo = $("#txtCorreo").val();

		if(correo != "" && correo != undefined && correo != null){
			if(!validar_email(correo)){
				alert("El Correo no tiene un formato válido");
				return false;
			}
		}
	});

	$("#txtCLABE").blur(function(e){
		var clabe = $("#txtCLABE").val();

		buscaBancoClabe(clabe);
	});
	/*$("#txtCLABE").keyup(function(e){
		var clabe = $("#txtCLABE").val();

		buscaBancoClabe(clabe);
	});
	$("#txtCLABE").keypress(function(e){
		var clabe = $("#txtCLABE").val();

		buscaBancoClabe(clabe);
	});*/
}

function buscaBancoClabe(CLABE){
	$.post("../../../inc/Ajax/_Clientes/BuscaBanco.php",
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

function HideShowDiv(){
	setSomeConfs();

	var destino = $("#ddlDestino").val();

	if(destino == 2){
		showFieldsBanco();
	}
	else{
		hideFieldsBanco();
	}
}

function cargarTiposInstruccion(){
	var idTipoMovimiento = $("#ddlTipoMovimiento").val();

	$.post("../../../inc/Ajax/_Clientes/GetTiposInstruccion.php",{
		idTipoMovimiento	: idTipoMovimiento
	},
	function(response){
		setRespOnDiv(response, "selectInstruccion");
	})
}

function setRespOnDiv(html, div){
	try{
		$("#"+div).html(html);
	}
	catch(e){
		alert(e.message);
	}
}

function showFieldsBanco(){
	$("#fieldsBanco").show();
}

function hideFieldsBanco(){
	$("#fieldsBanco").hide();
}

function GoCorresponsal(idCorr){
	if(idCorr > -1 ){
		setValue('hidCorresponsalX',idCorr);		
		irAForm('formPase','../Corresponsal/Listado.php','../Cadena/Listado.php');
		
	}else{
		alert("Favor de escribir un ID de Corresponsal valido");
	}
}
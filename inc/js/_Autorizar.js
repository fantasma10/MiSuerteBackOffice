/* Muestra el pdf de la preCadena, como parametro recibe el id de la precadena que se quiere consultar */
function showPdfCadena(idCadena){
	var params = { idCadena : idCadena}

	OpenWindowWithPost("../../../inc/Ajax/_Clientes/PDFAutPreCadena.php",
	" toolbar=no, location=no, menubar=0,scrollbars=yes, resizable=yes, top=0, left=800, width=800, height=600",
	"Cadena", params);
}
/* Muestra el pdf de la presubcadena, como parametro recibe el id de la presubcadena que se quiere consultar */
function showPdfSubCadena(idSubCadena){
	var params = { idSubCadena : idSubCadena}

	OpenWindowWithPost("../../../inc/Ajax/_Clientes/PDFAutPreSubCadena.php",
	" toolbar=no, location=no, menubar=0,scrollbars=yes, resizable=yes, top=0, left=800, width=800, height=600",
	"Cadena", params);
}

function irABuscarCadena(){
	irABusquedaClientes("PrealtaBuscarCadenas.php");
}

function irABuscarSubCadena(){
	irABusquedaClientes("PrealtaBuscarSubCadenas.php");	
}

function irABuscarCorresponsal(){
	irABusquedaClientes("PrealtaBuscarCorresponsales.php");	
}

function irABusquedaClientes(pagina){
	window.location = "../../../_Clientes/"+pagina;
}

function showComprobante(id, categoria, idComprobante){
	var params = {
		id				: id,
		categoria		: categoria,
		idComprobante	: idComprobante
	}

	OpenWindowWithPost("../../../inc/Ajax/_Clientes/getComprobante.php",
	"toolbar=no, scrollbars=yes, resizable=yes, top=0, left=800, width=800, height=600",
	"Cadena", params);
}

function autorizarCadena(idCadena){
	$.post("../../../inc/Ajax/_Clientes/autorizaPreCadena.php",
	{
		idCadena : idCadena
	},
	function(response){
		if(showMsg(response)){
			alert(response.msg);
			irABuscarCadena();
		}
		else{
			irABuscarCadena();
		}
	}, "json");
}

function autorizarSubCadena(idSubCadena){
	$.post("../../../inc/Ajax/_Clientes/autorizaPreSubCadena.php",
	{
		idSubCadena : idSubCadena
	},
	function(response){
		if(showMsg(response)){
			alert(response.msg);
			irABuscarSubCadena();
		}
		else{
			irABuscarSubCadena();
		}
	}, "json");
}

function autorizarCorresponsal(idCorresponsal){

	var tipoC = $("#ddlTipoCliente").val();
	var tipoA = $("#ddlTipoAcceso").val();

	/*var venta	= $("#txtEjecutivoVenta");
	var cuenta	= $("#txtEjecutivoCuenta");

	if(venta <= 0){
		alert("Seleccione Ejecutivo de Venta");
		return false;
	}

	if(cuenta <= 0){
		alert("Seleccione Ejecutivo de Cuenta");
		return false;
	}*/

	if(tipoC == -1){
		alert("Seleccione el Tipo de Cliente");
		return false;
	}

	if(tipoA == -1){
		alert("Seleccione el Tipo de Acceso");
		return false;
	}

	$.post("../../../inc/Ajax/_Clientes/autorizaPreCorresponsal.php",
	{
		idCorresponsal	: idCorresponsal,
		idTipoCliente	: tipoC,
		idTipoAcceso	: tipoA
	},
	function(response){
		if(showMsg(response)){
			alert(response.msg);
			irABuscarCorresponsal();
		}
		else{
			if(response.id > 0){
				submitFormPost('Listado.php', {hidCorresponsalX : response.id});
			}
			else{
				irABuscarCorresponsal();
			}
		}
	}, "json");
}

function showCapturaDepositos(id, categoria, referencia){

	$.post("../capturaDeposito.php",
	{

	},
	function(response){
		$("#contenidoModal").html(response);
	});

}

$(function(){

	if($("#ddlTipoCliente").length){
		$("#ddlTipoCliente").change(function(){
			var tipoC = this.value;
			if(tipoC > -1){
				cargarStore("../../inc/Ajax/_Clientes/tipoAccesoOpciones.php", "ddlTipoAcceso", {idTipoCliente : tipoC}, {value : 'idTipoAcceso', text : 'descTipoAcceso'});
			}
			else{
				limpiaStore("ddlTipoAcceso");
			}
		});
	}

	if($("#fechaDeposito").length){
		var checkin = $("#fechaDeposito").datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
			function(ev){
				var d		= new Date();
				var anio	= d.getFullYear();
				var mes		= d.getMonth()+1;
				var dia		= d.getDate();

				if(mes < 10){
					mes = "0"+mes;
				}

				if(dia < 10){
					dia = "0"+dia;
				}

				var hoy =  anio + "-" + mes + "-" + dia;
				var choice = $("#fechaDeposito").val();

				if(choice > hoy){
					/*alert("La fecha no debe ser mayor al día de Hoy");
					$("#fechaDeposito").val("");*/
				}
				checkin.hide();
			}			
		).data('datepicker');
	}

	$(":input").bind("paste", function(){return false;});

	$("#txtimporte, #numeroCuenta").bind('keypress', validaEntero);

	$('#txtimporte, #txtAut, #numeroCuenta').attr('maxlength', '11');

	$("#txtAut").alphanum({
		allow				: "",
		disallow			: "¿¡°´¨~-",
		allowLatin			: true,
		allowOtherCharSets	: false
	});

	/*autoCompletaGeneral('txtEjecutivoCuenta', 'idEjecutivoCuenta', '../../inc/Ajax/BuscaEjecutivos.php', 'nombreCompleto', 'idUsuario', {idTipoEjecutivo: 5});
	autoCompletaGeneral('txtEjecutivoVenta', 'idEjecutivoVenta', '../../inc/Ajax/BuscaEjecutivos.php', 'nombreCompleto', 'idUsuario', {idTipoEjecutivo: 2});

	$("#txtEjecutivoCuenta, #txtEjecutivoVenta").keyup(function(e){
		var targ	= e.target;
		var id		= targ.id;
		var tip 	= id.substring(0, 3);
		var last	= id.substring(3, id.length);

		var val = $("#"+id).val();
		var valor = val.trim();

		var arr = {'txt' : 'id'};

		if(valor == ""){
			$("#" +arr[tip] + last).val(-1);
		}
	});*/
});

function validaEntero(e){
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

function guardarDeposito(idSubCadena, idCorresponsal){
	/*if (!("FormData" in window)) {
		alert("No va a jalar");
	}*/

	var importe 		= $("#txtimporte").val();
	var banco			= $("#ddlBanco").val();
	var numeroCuenta	= $("#numeroCuenta").val();
	var aut				= $("#txtAut").val();
	var fecha			= $("#fechaDeposito").val();
	var ref				= $("#txtReferencia").val();

	if(aut > 2147483647){
		alert("Número de Autorización Fuera de Rango");
		return false;
	}

	if(importe == "" || importe == 0){
		alert("Capture Importe");
		return false;
	}

	if(banco == -1){
		alert("Capture Banco");
		return false;
	}

	if(numeroCuenta == ""){
		alert("Capture Número de Cuenta");
		return false;
	}

	if(aut == ""){
		alert("Capture Autorización");
		return false;
	}

	if(fecha == ""){
		alert("Capture Fecha");
		return false;
	}

	var d		= new Date();
	var anio	= d.getFullYear();
	var mes		= d.getMonth()+1;
	var dia		= d.getDate();

	if(mes < 10){
		mes = "0"+mes;
	}

	if(dia < 10){
		dia = "0"+dia;
	}

	var hoy =  anio + "-" + mes + "-" + dia;
	var choice = $("#fechaDeposito").val();

	if(choice > hoy){
		alert("La Fecha no debe ser mayor al día de hoy");
		return false;
	}

	var archivos = document.getElementById("archivo");//Damos el valor del input tipo file
	var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
	var texto = document.getElementById("texto").value;
	
	if(archivos.value == ""){
		alert("Adjunte un Comprobante");
		return false;
	}

	/*if(archivo.length == 0){
		alert("Adjunte un Comprobante");
		return false;
	}*/

	if (!("FormData" in window)){
		var inputs = {
			texto			: texto,
			importe			: importe,
			banco			: banco,
			numeroCuenta	: numeroCuenta,
			aut				: aut,
			fecha			: fecha,
			ref				: ref,
			idSubCadena		: idSubCadena,
			idCorresponsal	: idCorresponsal,
			reenviar		: 1
		}
		var form = $("<form action='"+ "../../../inc/Ajax/_Clientes/crearDeposito.php" +"' method='post' enctype='multipart/form-data'></form>");
		$.each(inputs, function(key, value){
			form.append("<input type='hidden' name='"+ key +"' value='"+ value +"'>");
		});
		
		form.append(document.getElementById("archivo"));
		
		//hacer submit del form para ir a la pagina
		console.log(form);
		$("#container").append(form);
		form.submit();
	}
	else{
		var data = new FormData();
		
		for(i=0; i<archivo.length; i++){
			data.append('archivo',archivo[i]);	
		}
		data.append('texto',texto);
		data.append('importe', importe);
		data.append('banco', banco);
		data.append('numeroCuenta', numeroCuenta);
		data.append('aut', aut);
		data.append('fecha', fecha);
		data.append('ref', ref);
		data.append('idSubCadena', idSubCadena);
		data.append('idCorresponsal', idCorresponsal);

		$.ajax({
			url		:'../../../inc/Ajax/_Clientes/crearDeposito.php', //Url a donde la enviaremos
			type:'POST', //Metodo que usaremos
			contentType:false, //Debe estar en false para que pase el objeto sin procesar
			data:data, //Le pasamos el objeto que creamos con los archivos
			processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
			cache:false, //Para que el formulario no guarde cache
			complete : function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				else{
					//submitFormPost('Listado.php', {hidCorresponsalX : response.id});
					submitFormPost('Autorizar.php', {idCorresponsal : idCorresponsal, idSubCadena : idSubCadena});
				}
			}
		});
	}
}


function agregarComisionesEspeciales(idCadena, idSubCadena, idCorresponsal, idGrupo, idVersion, url, nombre){
	var params = {
		idCadena		: idCadena,
		idSubCadena		: idSubCadena,
		idCorresponsal	: idCorresponsal,
		idGrupo			: idGrupo,
		idVersion		: idVersion,
		regresaA		: url,
		nombre			: nombre
	}

	submitFormPost("../../_ComisionesEspeciales/ComisionesEspeciales.php", params);
}
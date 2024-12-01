
function initConsultaCliente(){

	autoCompletaGeneral('txtCliente', 'idCliente', BASE_PATH+'/inc/Ajax/_Afiliaciones/listaClientes.php', 'nombreCliente', 'idCliente', {}, renderCliente);
	autoCompletaGeneral('txtRFC', 'idCliente', BASE_PATH+'/inc/Ajax/_Afiliaciones/listaClientes.php', 'nombreCliente', 'idCliente', {}, renderCliente);

	$("#txtCliente, #txtRFC").on('keyup', function(event){
		var id = event.target.id;
		var value = event.target.value;

		var cfg = {
			txtCliente	: 'txtRFC',
			txtRFC		: 'txtCliente'
		}

		var txt = eval("cfg."+id);

		if(value == "" || value == undefined){
			$("#"+txt).prop('disabled', false);
		}
		else{
			$("#"+txt).prop('disabled', true);
		}
	});

	$("#txtCliente, #txtRFC").on('blur', function(event){
		var id = event.target.id;
		var value = event.target.value;

		var cfg = {
			txtCliente	: 'txtRFC',
			txtRFC		: 'txtCliente'
		}

		var txt = eval("cfg."+id);

		if(value == "" || value == undefined){
			$("#"+txt).prop('disabled', false);
		}
		else{
			$("#"+txt).prop('disabled', true);
		}
	});

	$("#btnSeleccion").on('click', seleccionarCliente);
}

function seleccionarCliente(){
	var idCliente = $("#idCliente").val();

	if(idCliente > 0 && idCliente != "" && idCliente != undefined){
		verificarAfiliacion(idCliente);
	}
	else{
		alert("Seleccione un Cliente");
	}
}

function verificarAfiliacion(idCliente){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/loadAfiliacion.php",
		{
			idAfiliacion : idCliente
		},
		function(response){
			
			if(!validarExpediente(response.data.idNivel)){
				alert('No se encontró Afiliación');
			}

			if(showMsg(response)){
				alert(response.msg);
			}

			if(response.success == true){
				window.location = "Cliente.php?idCliente="+idCliente;
			}

			
		},
		"json"
	)
}

function renderCliente( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.idCliente + " " + item.nombreCliente + "</a>" )
	.appendTo( ul );
}

function validarExpediente(idExpediente){

	switch(idExpediente){
		case '1':
			return true;
		break;

		case '2':
			return true;
		break;

		case '3':
			return true;
		break;

		default :
			return false
		break;
	}
}
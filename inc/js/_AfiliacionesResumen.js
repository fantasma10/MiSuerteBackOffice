
function initResumen(){
	loadAfiliacion(ID_CLIENTE);

	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	if(!ES_CONSULTA){
		if(!ES_CONSULTA_SUC){
			$('.esconsultas').hide();
			$('.esconsulta').hide();
			$('.noesconsulta').show();
		}
		else{
			$('.esconsultas').show();
			$('.esconsulta').hide();
			$('.noesconsulta').hide();
		}
	}
	else{
		$('.esconsulta').show();
		$('.esconsultas').hide();
		$('.noesconsulta').hide();
	}
}

function loadAfiliacion(idCliente){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/loadAfiliacion.php",
		{
			idAfiliacion	: idCliente,
			real			: ES_SUBCADENA
		},
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}

			if(response.success == true){
				idExp = response.data.idNivel;

				if(!validarExpediente(idExp)){
					alert('El Tipo de Expediente es inv\u00E1lido');
					if(!ES_CONSULTA){
						window.location ="Cliente.php?idCliente=" + ID_CLIENTE;
					}
					else{
						window.location = "newuser.php?idCliente=" + ID_CLIENTE;
					}
				}
				
				//var lblCliente = (response.data.tipoPersona == 1)? response.data.nombrePersona +" "+ response.data.apPPersona +" "+ response.data.apMPersona: response.data.razonSocial;
				var lblCliente = response.data.nombreCompletoCliente;
				$("#lblCliente").html(lblCliente);

				if(response.data.tipoForelo != 1){
					delete(response.data.referenciaBancaria);
				}
				else{
					$('.deposito-activo').find('th').eq(3).after('<th><span class="deposito-activo">Referencia Bancaria</span></th>');
					$('.deposito-activo').find('tr').each(function(){
						$(this).find('td').eq(3).after('<td rowspan="' + ROW_SPAN + '"><h3 id="referenciaBancaria"></h3></td>');
					});
				}

				if(response.data.idEstatusCuenta == 0){
					simpleFillFieldsHtml(response.data, "");
				}
				else{
					var obj = {
						'costo'			: response.data.costo,
						'CostoTotal'	: response.data.CostoTotal
					}
					if(response.data.tipoForelo == 1){
						obj.referenciaBancaria = response.data.referenciaBancaria
					}
					simpleFillFieldsHtml(obj, "");
				}

				mostrarListaSucursales(response.data);

			}
		},
		"json"
	)
}

function mostrarListaSucursales(data){

	var extraHeader = "";
	if(data.tipoForelo == 2){
		extraHeader = "<th>Referencia Bancaria</th>";
	}
	var tbl = "<table id='tblgridbox' class='display table table-bordered table-striped'><thead><tr><th>Nombre Sucursal</th>"+extraHeader+"</tr></thead><tbody></tbody></table>";

	$("#htmlTbl").html(tbl);

	var params = {
		idAfiliacion 	: ID_CLIENTE,
		real			: ES_SUBCADENA
	}
	llenaDataTable("tblgridbox", params, BASE_PATH + "/inc/Ajax/_Afiliaciones/listaSucursales.php");
}

function enviarCorreo(){
	if(!validarEmail("email")){
		alert("Escriba una direcci\u00F3n de correo v\u00E1lida");
	}
	else{
		var email = $("#email").val();
		$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/enviarReferenciasBancarias.php",
			{
				email			: email,
				idAfiliacion	: ID_CLIENTE
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg)
				}
				$("#correo").modal("hide");
			},
			"json"
		);
	}
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

function finalizarAltaCliente(){
	$.post(BASE_PATH + '/inc/Ajax/_Afiliaciones/autorizarCliente.php',
		{
			idAfiliacion	: ID_CLIENTE
		},
		function(response){
			if(showMsg(response)){
				alert(response.msg);
			}

			
		},
		"json"
	);
}



function initResumen2(){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/obtenerDatosDeSubCadena.php",
		{
			idSubCadena	: ID_SUBCADENA
		},
		function(response){
			if(response.success == true)			{
				$('.deposito-activo').find('th').eq(3).after('<th><span class="deposito-activo">Referencia Bancaria</span></th>');
				$('.deposito-activo').find('tr').each(function(){
					$(this).find('td').eq(3).after('<td rowspan="' + ROW_SPAN + '"><h3 id="referenciaBancaria">'+ response.data.referenciaBancaria +'</h3></td>');
				});
			}
		},
		"json"
	);
}

function mostrarListaSucursales2(){

	var extraHeader = "";
	/*if(data.tipoForelo == 2){*/
		extraHeader = "<th>Referencia Bancaria</th>";
	/*}*/
	var tbl = "<table id='tblgridbox' class='display table table-bordered table-striped'><thead><tr><th>Nombre Sucursal</th>"+extraHeader+"</tr></thead><tbody></tbody></table>";

	$("#htmlTbl").html(tbl);

	var params = {
		idAfiliacion	: 0,
		idSubCadena		: ID_SUBCADENA
	}
	llenaDataTable("tblgridbox", params, BASE_PATH + "/inc/Ajax/_Afiliaciones/listaSucursalSubCadena.php");
}

function enviarCorreo2(){
	if(!validarEmail("email")){
		alert("Escriba una direcci\u00F3n de correo v\u00E1lida");
	}
	else{
		var email = $("#email").val();
		$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/enviarReferenciasBancarias2.php",
			{
				email			: email,
				idAfiliacion	: 0,
				idSubCadena		: ID_SUBCADENA
			},
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}
				$("#correo").modal("hide");
			},
			"json"
		);
	}
}

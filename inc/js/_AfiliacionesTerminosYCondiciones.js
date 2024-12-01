
function initTerminosYCondiciones(){
	loadAfiliacion(ID_CLIENTE);

	if(!ES_ESCRITURA){
		$(':input').prop('readonly', true);
		$('select').prop('disabled', true);

		$('.boton_guardar').remove();
	}

	if(!ES_CONSULTA){
		$('.esconsulta').hide();
		$('.noesconsulta').show();
	}
	else{
		$('.esconsulta').show();
		$('.noesconsulta').hide();
	}
}

function loadAfiliacion(idCliente){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/loadAfiliacion.php",
		{
			idAfiliacion : idCliente
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

				$("#tbl"+response.data.idEstatusTerminos).show();
			}
			else{
				if(!ES_CONSULTA){
						window.location ="Cliente.php?idCliente=" + ID_CLIENTE;
					}
					else{
						window.location = "newuser.php?idCliente=" + ID_CLIENTE;
					}
			}
		},
		"json"
	)
}

function enviarCorreo(){
	if(!validarEmail("email")){
		alert("Escriba una direcci\u00F3n de correo v\u00E1lida");
	}
	else{
		var email = $("#email").val();
		$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/enviarTerminosYCondiciones.php",
			{
				email		: email,
				idCliente	: ID_CLIENTE
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
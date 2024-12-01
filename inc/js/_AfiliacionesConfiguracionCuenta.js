
function initNumeroSucursales(){
	loadAfiliacion(ID_CLIENTE);
}

function initConfiguracionCuenta(){
	$("#cmbReembolsos, #cmbComisiones").on('change', function(event){
		/* obtener id y valor del combo que ha sido cambiado su valor */
		var id = event.target.id;
		var value = event.target.value;

		var cfg = {
			cmbReembolsos : 'cmbComisiones',
			cmbComisiones : 'cmbReembolsos'
		}

		/* obtener valor del otro combo  */
		var cmb = eval("cfg."+id);
		var valor = $("#"+cmb).val();

		if(value == 1 || valor == 1){
			$(".confCuenta").show();
		}
		else{
			$(".confCuenta").hide();
		}
	});

	$("[name='CLABE']").numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		maxDigits			: 18
	});

	$(":input").bind("paste", function(){return false;});

	$("[name='CLABE']").unbind("paste");
	
	$("[name='CLABE']").bind('paste', analizarCLABE);
	$("[name='CLABE']").on('keyup', analizarCLABE);

	$("[name='numCuenta'], [name='idBanco'], [name='txtBanco']").prop('readonly', true);

	$("[name='numCuenta']").numeric({
		allowMinus			: false,
		allowThouSep		: false,
		allowDecSep			: false,
		maxDigits			: 11
	});

	$("[name='beneficiario']").alphanum({
		allowNumeric		: false,
		allow				: "áéíóúñÁÉÍÓÚÑ",
		allowOtherCharSets	: false,
		maxLength			: 45
	});

	$("[name='descripcion']").alphanum({
		allowNumeric		: true,
		allow				: "áéíóúñÁÉÍÓÚÑ@-_.",
		allowOtherCharSets	: false,
		maxLength			: 30
	});

	$("#btnNext").on('click', function(event){
		guardarConfiguracionCuenta(event);
	});

	$('body').trigger("configuracioniniciada");

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

				//var lblCliente = (response.data.tipoPersona == 1)? response.data.nombrePersona +" "+ response.data.apPPersona +" "+ response.data.apMPersona: response.data.razonSocial;
				var lblCliente = response.data.nombreCompletoCliente;
				$("#lblCliente").html(lblCliente);

				if(!validarExpediente(idExp)){
					alert('El Tipo de Expediente es inv\u00E1lido');
					if(!ES_CONSULTA){
						window.location ="Cliente.php?idAfiliacion=" + ID_AFILIACION;
					}
					else{
						window.location = "newuser.php?idAfiliacion=" + ID_AFILIACION;
					}
				}
				else{
					$('body').on('configuracioniniciada', function(){
						loadConfiguracionCuenta(response.data);
					});
					initConfiguracionCuenta();
				}
			}
		},
		"json"
	)
}

function loadConfiguracionCuenta(data){
	simpleFillForm(data, "formCuenta", '');

	if(data.comisiones == 1 || data.reembolso == 1){
		$(".confCuenta").show();
	}
}

function guardarConfiguracionCuenta(event){
	var params = getParams($("#formCuenta").serialize());

	var lack = "";
	var error = "";

	if(params.comisiones == "" || params.comisiones == undefined || params.comisiones <= -1){
		lack += "- Liquidaci\u00F3n de Comisiones \n";
	}
	if(params.reembolso == "" || params.reembolso == undefined || params.reembolso <= -1){
		lack += "- Reembolsos \n";
	}

	if(params.reembolso == 1 || params.comisiones == 1){
		if((params.CLABE).trim() == "" || params.CLABE == undefined){
			lack += "- CLABE\n";
		}
		else{
			var clabe = (params.CLABE).trim();
			if(clabe.length != 18){
				error += "- La CLABE debe ser de 18 d\u00EDgitos \n";
			}
		}
		if(params.idBanco == "" || params.idBanco == undefined || params.idBanco <= -1){
			lack += "- Banco \n";
		}
		if((params.numCuenta).trim() == "" || params.numCuenta == undefined){
			lack += "- N\u00FAmero de Cuenta \n";
		}
		if((params.beneficiario).trim() == "" || params.beneficiario == undefined){
			lack += "- Beneficiario\n";
		}
		if((params.descripcion).trim() == "" || params.descripcion == undefined){
			lack += "- Descripci\u00F3n \n";
		}
	}

	if(lack.trim() != "" || error.trim() != ""){
		var lack1	= (lack.trim() != "")? "Los siguientes datos son Obligatorios :\n" + lack : "";
		var error1	= (error.trim() != "")?"Los siguientes datos son Incorrectos :\n" + error : "";

		alert(lack1 + "\n" + error1);
		event.preventDefault();
	}
	else{
		params.idCliente = ID_CLIENTE;

		$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/guardarConfiguracionCuenta.php",
			params,
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					if(!ES_CONSULTA){
						window.location = "formnew5.php?idCliente="+ID_CLIENTE;
					}
				}
			},
			"json"
		);
	}
}

function analizarCLABE(event){
	var CLABE = event.target.value;

	if(CLABE.length == 18){
		var CLABE_EsCorrecta = validarDigitoVerificador(CLABE);
		if(CLABE_EsCorrecta){
			$.post(BASE_PATH + '/inc/Ajax/_Clientes/getBancoCLABE.php',
				{ "CLABE": CLABE }
			).done(function ( data ) {
					var banco = jQuery.parseJSON( data );
					$("[name='idBanco']").val(banco.bancoID);
					$("[name='txtBanco']").val(banco.nombreBanco);
					$("[name='numCuenta']").val(CLABE.substring(6, 17));			
			});
		}
		else{
			alert("La CLABE escrita es incorrecta. Favor de verificarla.");
			$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");
		}
	}
	else{
		$("[name='idBanco'], [name='txtBanco'], [name='numCuenta']").val("");	
	}
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
	
	return CLABE.charAt(17) == digitoVerificador;
	
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
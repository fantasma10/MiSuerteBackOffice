var vNvlExp= false;
var vInfGral= false;
var vFroleo= false;
var vCONF= false;

function initCliente(){
	loadAfiliacion(ID_CLIENTE);
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
					window.location = "newuser.php";
				}

				//var lblCliente = (response.data.tipoPersona == 1)? response.data.nombrePersona +" "+ response.data.apPPersona +" "+ response.data.apMPersona: response.data.razonSocial;
				var lblCliente = response.data.nombreCompletoCliente;
				$("#lblCliente").html(lblCliente);

				$("#nombreNivel").html(response.data.nombreNivel);
				$("#lblTipoForelo").html(response.data.lblTipoForelo);

				if(response.data.maximoPuntos == 0){
					var maximo = "Ilimitado";
				}
				else{
					var maximo = response.data.maximoPuntos;
				}
				
				$("#lblSucursales").html(response.data.numeroCorresponsales + " de " + maximo);
				
				if ( parseInt(response.data.maximoPuntos) > 0 ) {
					if ( parseInt(response.data.numeroCorresponsales) > parseInt(response.data.maximoPuntos) ) {
						$("#lblSucursales").css("color", "red");
					}
				}

				var arrayChecks = new Array();
				arrayChecks.push("fa-check-square-o");
				arrayChecks.push("fa-square-o");

				if(response.data.COMPLETO_NIVEL == 0){
					$('#iExpediente').removeClass(arrayChecks[1]).addClass(arrayChecks[0]);
					 vNvlExp= true;
				}

				if(response.data.tipoForelo == 2){
					$("#liComisiones").empty().html('<form><a href="#"><i class="fa fa-dollar"></i> Comisiones y Reembolsos</a><i class="fa fa-check-square-o pull-right" id="iConfig"></i></form>');
				}

				var representanteValido = false;
				if(response.data.idNivel == 1){
					representanteValido = true;
				}
				else if(response.data.idNivel > 1){
					representanteValido = (response.data.COMPLETO_REPRESENTANTE == 0)? true : false;
				}
								
				if(response.data.COMPLETO_GENERALES == 0 && response.data.COMPLETO_DIRECCION == 0 && representanteValido){
					$('#iGenerales').removeClass(arrayChecks[1]).addClass(arrayChecks[0]);
					vInfGral= true;
				}
				if(response.data.COMPLETO_FORELO == 0){
					$("#iNumSucursales").removeClass(arrayChecks[1]).addClass(arrayChecks[0]);
					vFroleo= true;
				}
				if(response.data.COMPLETO_CONF_CUENTA == 0){
					$("#iConfig").removeClass(arrayChecks[1]).addClass(arrayChecks[0]);
					vCONF= true;
				}
				if(vNvlExp && vInfGral && vFroleo && vCONF){
					$("#btn_crear").show();
				}else{
					$("#btn_crear").hide();
				}

				$("#pagoPendiente").html("Pago Pendiente " + response.data.pagoTotal);
			}
		},
		"json"
	)
}

function submitForm(idform){
	$('#'+idform).submit();
}
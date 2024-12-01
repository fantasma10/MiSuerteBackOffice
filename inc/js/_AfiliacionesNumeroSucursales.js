
function initNumeroSucursales(){
	loadAfiliacion(ID_CLIENTE);
	//loadCostos();

	btnSiguiente = $("#btnSiguiente");
	$("#btnSiguiente").remove();

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
			$("#contenidoHTML").empty();
			//console.log(response);
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
						window.location ="Cliente.php?idCliente=" + ID_CLIENTE;
					}
					else{
						$("#formStart").submit();
					}
				}
				else{

					$('body').on('costoscargados', function(){
						//$("#" + response.data.idCosto).css("background-color", "#C7143F");
						console.log($("#" + response.data.idCosto));
						$("#" + response.data.idCosto).removeClass("btn-danger");
						$("#" + response.data.idCosto).addClass("btn-express");

						//var btn = document.getElementById(response.data.idCosto);
						var btn = $("button [idcosto='"+response.data.idCosto+"']")
						console.log(btn);
						if(response.data.idCosto > 0){
							$("#formSiguiente").append(btnSiguiente);

							var url = $(btn).attr('url');
							console.log(url);
							$("#formSiguiente").attr('action', url);
						}
						$('body').unbind('costoscargados');
					});

					loadCostos();
				}
			}
		},
		"json"
	)
}

function loadCostos(){
	$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/loadCostos.php",
		{
			idCliente : ID_CLIENTE
		},
		function(response){

			$.each(response, function( key, arr ){
				var idul = "paquetes-lista-"+key;
				$("#contenidoHTML").append("<div class='col-xs-6'><div class='tipo-forelo'><h6>FORELO</h6><h5>"+ arr.descTipoForelo +"</h5><ul id='"+idul+"'></ul></div></div>");
				$.each(arr.data, function(index, item){
					if(item.min == null && item.max == null){
						var label = item.otro;
						var btnlabel = "Comercial";
					}
					else{
						if(item.max == 0){
							label = "+"+item.min + " Sucursales";
						}
						else{
							var label = item.min + "-" + item.max + " Sucursales ";
						}
						var btnlabel = item.costo + " por Sucursal<span idCosto='"+item.idCosto+"' tipoForelo='"+arr.idTipoForelo+"' url='"+item.url+"?idCliente="+ID_AFILIACION+"'>Cuota " + item.cuota;
					}
					$("#" +idul).append("<li><div class='view'><label>"+ label +"</label><a onclick='guardarTipoForelo(event)' href='#' idCosto='"+item.idCosto+"' tipoForelo='"+arr.idTipoForelo+"' url='"+item.url+"?idCliente="+ID_AFILIACION+"'><button id='"+item.idCosto+"' type='button' tipoForelo='"+arr.idTipoForelo+"' idCosto='"+item.idCosto+"' url='"+item.url+"?idCliente="+ID_AFILIACION+"' class='btn btn-labeled btn-danger'>" + btnlabel + "</span></button></a></div></li>");
				});
			});

			$('body').trigger('costoscargados');
		},
		"json"
	);
}

function guardarTipoForelo(event){
	if(!ES_ESCRITURA){
		event.preventDefault();
		return false;
	}
	if(confirm("Confirmar")){
		var url = $(event.target).attr('url');
		console.log(event.target, url);
		var params = {
			idCosto			: $(event.target).attr('idcosto'),
			idTipoForelo	: $(event.target).attr('tipoforelo'),
			idCliente		: ID_CLIENTE
		}

		$.post(BASE_PATH + "/inc/Ajax/_Afiliaciones/guardarPaquete.php",
			params,	
			function(response){
				if(showMsg(response)){
					alert(response.msg);
				}

				if(response.success == true){
					if(!ES_CONSULTA){
						window.location = url;
					}
					else{
						$("#contenidoHTML").empty();
						$("#contenidoHTML").html();
						event.preventDefault();
						loadAfiliacion(ID_CLIENTE);
					}
				}
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

function renderItemCadena( ul, item ){
	return $( '<li>' )
	.append( "<a>" + item.label + "</a>" )
	.appendTo( ul );
}
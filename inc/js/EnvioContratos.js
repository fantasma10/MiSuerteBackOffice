function initComponents() {		
	$("#buscar").on('click', function(){
		buscar();
	});
	
	$("#txtCliente").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1.',
		allowNumeric		: true,
		allowOtherCharSets	: false
	});	

	$("#txtRepresentanteLegal").alphanum({
		allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1.',
		allowNumeric		: true,
		allowOtherCharSets	: false
	});	
	
	$("#txtCliente").on('keyup', function(event){
		var id = event.target.id;
		var value = event.target.value;
	
		var cfg = {
			txtCliente	: 'txtRFCCliente'
		}
	
		var txt = eval("cfg."+id);
	
		if(value == "" || value == undefined){
			$("#"+txt).prop('disabled', false);
		}else{
			$("#"+txt).prop('disabled', true);
		}
	
		var valorCliente = $("#txtCliente").val();
		//var valorRepLegal = $("#txtRepresentanteLegal").val();
		$("#idRepresentanteLegal").val("");
		$("#nombreRepresentanteLegal").val("");
		$("#txtRepresentanteLegal").val("");
		
		/*if ( myTrim(valorCliente) == "" ) {
			$("#idCliente").val("");
			$("#nombreCliente").val("");
		}
		if ( myTrim(valorRepLegal) == "" ) {
			$("#idRepresentanteLegal").val("");
			$("#nombreRepresentanteLegal").val("");
		}*/
	});
	
	$("#txtRepresentanteLegal").on('keyup', function(event){
		var valorCliente = $("#txtCliente").val();
		if ( valorCliente != "" ) {
			$("#txtCliente").val("");
			$("#idCliente").val("");
			$("#nombreCliente").val("");
		}
	});

	$("#txtCliente").autocomplete({
		source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Clientes/getClientes.php", { "text": request.term },
				function( response ) {
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$(this).val(ui.item.nombre);
				return false;				
			},
			select: function( event, ui ) {
				$("#idCliente").val(ui.item.idCliente);
				$("#nombreCliente").val(ui.item.nombre);
				$("#tipoBusqueda").val("1"); //Cliente
				return false;				
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>" + "ID: " + item.idCliente + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.appendTo( ul );
		};
		
	$("#txtRepresentanteLegal").autocomplete({
		source: function( request, respond ) {
				$.post( BASE_PATH + "/inc/Ajax/_Clientes/getRepresentanteLegal.php", { "text": request.term },
				function( response ) {
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$(this).val(ui.item.nombreCompleto);
				return false;				
			},
			select: function( event, ui ) {
				$("#idCliente").val(ui.item.idCliente);
				$("#idRepresentanteLegal").val(ui.item.idRepresentanteLegal);
				$("#nombreRepresentanteLegal").val(ui.item.nombreCompleto);
				$("#tipoBusqueda").val("2"); //Representante Legal
				return false;				
			}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>" + "ID: " + item.idRepresentanteLegal + " " + item.nombreCompleto + "<br><span class='thinTitle'>Cliente: " + item.nombreCliente + "</span></a>" )
			.appendTo( ul );
		};
}

function buscar() {
	var idCliente = $("#idCliente").val();
	var nombreCliente = $("#nombreCliente").val();
	var nombreRepresentanteLegal = $("#nombreRepresentanteLegal").val();
	var tipoBusqueda = $("#tipoBusqueda").val();
	if ( idCliente == "" ) {
		alert("Es necesario introducir un Cliente o un Representante Legal");
		return true;
	}
	if ( tipoBusqueda == "" ) {
		alert("No es posible enviar correo electr\u00F3nico. Por favor contacte al Administrador del Sistema.");
		return false;
	}
	if ( tipoBusqueda == 1 ) {
		if ( nombreCliente == "" ) {
			alert("No es posible enviar correo electr\u00F3nico porque no se encontr\u00F3 un nombre asigando al Cliente. Por favor contacte al Administrador del Sistema.");
			return false;
		}
	} else if ( tipoBusqueda == 2 ) {
		if ( nombreRepresentanteLegal == "" ) {
			alert("No es posible enviar correo electr\u00F3nico porque no se encontr\u00F3 un nombre asigando al Representante Legal. Por favor contacte al Administrador del Sistema.");
			return false;
		}		
	}
	$.post( BASE_PATH + "/inc/Ajax/_Clientes/enviarCorreoContrato.php",
	{ idCliente: idCliente, nombreCliente: nombreCliente, nombreRepresentanteLegal: nombreRepresentanteLegal, tipoBusqueda: tipoBusqueda },
	function( respuesta ){
		if ( respuesta.success ) {
			if ( respuesta.showMsg ) {
				alert(respuesta.msg);
			}
		} else {
			if ( respuesta.showMsg ) {
				alert(respuesta.msg);
			}
		}
	}, "json");
}
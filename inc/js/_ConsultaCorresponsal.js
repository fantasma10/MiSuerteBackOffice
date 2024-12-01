
$(function(){

	$(":input").bind("paste", function(){return false;});

	if($("#cPais").length){
		$("#cPais").autocomplete({
			source: function( request, respond ) {
				$.post("../../../inc/Ajax/_Clientes/getPaises.php",
					{
						pais : request.term
					},
					function( response ) {
						respond(response);
					}, "json" );					
			},
			minLength: 1,
			focus: function( event, ui ) {
				$("#cPais").val(ui.item.nombre);
				return false;
			},
			select: function( event, ui ) {
				$("#ddlPais").val(ui.item.idPais);
				cambiarPantalla();
				VerificarDireccionSub(tipoDireccion)
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $('<li>')
			//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
			.append("<a>" + item.label + "</a>")
			.appendTo( ul );
		}
	}

	if($("#txtreplegal").length){
		autoCompletaGeneral("txtreplegal", "ddlRepLegal", "../../inc/Ajax/AutoRepLegal.php", "label", "id", {something : 1});
	}

	/*  */
	fillHorario = false;
	if($("#checkall").length){
		$("#checkall").change(function(event){
			if($("#checkall").is(':checked')){
				fillHorario = true;

				llenaHorario("1", $("#txt1").val());
				llenaHorario("2", $("#txt2").val());

				$("#txt1, #txt2").bind("keyup", function(e){
					var targ	= e.target;
					var id		= targ.id;
					var tip 	= id[id.length - 1];
					var valor	= $(targ).val();

					llenaHorario(tip, valor);
				});
			}
			else {
				fillHorario = false
				$("#txt1, #txt2").unbind("keyup");
			}  
		});
	}



	if($('#txtFechaVenc').length){

		$("#txtFechaVenc").change(function(event) {
			var fecha = $("#txtFechaVenc").val();

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

			if(fecha < hoy){
				alert("La fecha no debe ser menor al día de Hoy");
				$("#txtFechaVenc").val(hoy);
			}
		});

		var checkin = $('#txtFechaVenc').datepicker({format: 'yyyy-mm-dd'}).on('changeDate',
			function(ev){
				var fecha = ev.date;

				var df		= fecha;
				var aniof	= df.getFullYear();
				var mesf	= df.getMonth()+1;
				var diaf	= df.getDate();

				if(mesf < 10){
					mesf = "0"+mesf;
				}

				if(diaf < 10){
					diaf = "0"+diaf;
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
				//var choice = $("#txtFechaVenc").val();
				var choice = aniof + "-" + mesf + "-" + diaf;

				if(choice < hoy){
					checkin.hide();
					alert("La fecha no debe ser menor al día de Hoy");
					checkin.setValue(hoy);
				}
				else{
					checkin.hide();
				}
			}			
		).data('datepicker');
	}

	getBancosCorresponsaliaBancaria();

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").attr('maxlength', '5');

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").keyup(function(event) {
		if(event.keyCode != 8 && event.keyCode != 46){
			var id = event.currentTarget.id;
			return validaHoras2(event, id);
		}
	});

	$("#txt1, #txt2, #txt3, #txt4, #txt5, #txt6, #txt7, #txt8, #txt9, #txt10, #txt11, #txt12, #txt13, #txt14").keypress(function(event) {
		if(event.keyCode != 8 && event.keyCode != 46){
			var id = event.currentTarget.id;
			return validaHoras(event, id);
		}
	});

});


function showOperaciones(idCorresponsal){
	Emergente();
	$("#divTbl").empty();
	$.post("../../inc/Ajax/_Clientes/BuscaOperaciones.php",
	{ idCorresponsal : idCorresponsal },
	function(response){
		$("#divTbl").html(response);
		OcultarEmergente();
	});
}

function showMovimientosCorresponsal(numCuenta){
	Emergente();
	$("#divTbl").empty();
	$.post("../../inc/Ajax/_Clientes/BuscaMovimientos.php",
	{ numcta : numCuenta },
	function(response){
		$("#divTbl").html(response);
		OcultarEmergente();
	});
}

function showDepositosCorresponsal(numCuenta){
	Emergente();
	$("#divTbl").empty();
	$.post("../../inc/Ajax/_Clientes/BuscaDepositos.php",
	{ numcta : numCuenta },
	function(response){
		$("#divTbl").html(response);
		OcultarEmergente();
	});
}

function showRemesasCorresponsal(id){
	Emergente();
	$("#divTbl").empty();
	$.post("../../inc/Ajax/_Clientes/BuscaRemesas.php",
	{ idCorresponsal : id },
	function(response){
		$("#divTbl").html(response);
		OcultarEmergente();
	});
}

function llenaHorario(tip, valor){
	if(fillHorario == true){
		var cont = 0;

		while(cont < 6){
			tip = parseInt(tip) + 2;
			$("#txt"+tip).val(valor);
			cont++;
		}
	}
}

function agregarContactoDeSubCadena(idContacto, idCorresponsal){
	$.post("../../../inc/Ajax/_Clientes/AgregaContactoDeSubCadena.php",
	{
		idContacto		: idContacto,
		idCorresponsal	: idCorresponsal
	},
	function(response){
		if(showMsg(response)){
			alert(response.msg);
		}
		else{
			irAListado();
		}
	},
	"json");
}

function getDdlBanco(){
	var idCorresponsal = $("#idCorresponsal").val();

	$.post("../../../inc/Ajax/_Clientes/BancosCorresponsalias.php",
		{
			idCorresponsal : idCorresponsal
		},
		function(response){
			$("#divddlBanco").html(response);
		});
}

function UpdateContactosCor(idCadSubCor,idTipoCliente){
	var NomC = txtValue("txtContacNom");
	if(NomC != ""){
		var apPC = txtValue("txtContacAP");
		if(apPC != ""){
			var apMC = txtValue("txtContacAM");
			if(apMC != ""){
				var telC = txtValue("txtTelContac");
				if(telC != "" && validaTelefonoAnterior3("txtTelContac")){
					
					var mailC = txtValue("txtMailContac");
					if(mailC != "" && validarEmail("txtMailContac")){
						var tipoC = txtValue("ddlTipoContac");
						if(tipoC > -1){

							var idContac = txtValue("HidContacto");
							var extension = txtValue("txtExtTelContac");
							var parametros = "id="+idCadSubCor+"&idContacto="+idContac+"&NomC="+NomC+"&apPC="+apPC+"&apMC="+apMC+"&telC="+telC+"&mailC="+mailC+"&tipoC="+tipoC+"&idTipoCliente="+idTipoCliente+"&extension="+extension;
							//alert(parametros);
			/*el 1 es para cadenas el 2 es para subcadenas y el 3 para corresponsales PARA LAS BUSQUEDAS DE CONTACTOS*/
							MetodoAjaxContactos2("../../inc/Ajax/_Clientes/UpdateContactosClientes.php",parametros,idTipoCliente,idCadSubCor);
					
						}else{alert("Favor de seleccionar un Tipo de Contacto");}	
					}else{alert("Favor de escribir un correo valido para el Contacto");}	
				}else{alert("Favor de escribir un telefono valido para el Contacto");}	
			}else{alert("Favor de escribir un apellido materno para el Contacto");}	
		}else{alert("Favor de escribir un apellido paterno para el Contacto");}	
	}else{alert("Favor de escribir un nombre de Contacto");}
}

function DeleteContactos2(idCliente,idContacto,tipoCliente){
	if(confirm('\u00BFDesea Eliminar el Contacto?')){
		var parametros = "tipoCliente="+tipoCliente+"&id="+idCliente+"&idContacto="+idContacto;
		MetodoAjaxContactos2("../../inc/Ajax/_Clientes/DeleteContacto.php",parametros,tipoCliente,idCliente);
	}
}

function MetodoAjaxContactos2(url,parametros,tipoz,valorz){	
	http.open("POST",url, true);
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
			OcultarEmergente();
			var RespuestaServidor = http.responseText;//alert("respuesta "+RespuestaServidor);
			var RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);
			
			if(RESserv[0] == 0){
				var parametros2 = "tipoCliente="+tipoz+"&idValor="+valorz;
				//BuscarParametros2("../../inc/Ajax/_Clientes/BuscaContactosClientes.php",parametros2,'divRES');
				Persiana(true);

				//alert(RESserv[1]);
				irAListado();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];
					
				alert("Error: "+RESserv[0]+"  "+RESserv[1]);
			}			
		} 
	}
	http.send(parametros+"&pemiso="+true);
}

editarCorresponsal = true;
function UpdateCorresponsal2(iddato, tipoCliente){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= txtValue("txtmail");
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= txtValue("ddlGiro");
	var referencia				= txtValue("ddlReferencia");
	var estatus					= txtValue("ddlEstatus");
	var corresponsaliaBancaria	= txtValue("ddlCorBanc");
	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var representanteLegal		= $("#ddlRepLegal").val();
	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= $("#ddlIva").val();

	if(!esValido(telefono1)){
		alert("Agregue Teléfono 1 ");return false;
	}
	if(!esValido(telefono2)){
		telefono2 = "";
		//alert("Agregue Teléfono 2");return false;
	}
	if(!esValido(fechaVencimiento)){
		alert("Agregue Fecha de Vencimiento");return false;
	}
	if(!esValido(giro) || giro < 0){
		alert("Seleccione Giro");return false;
	}
	if(!esValido(estatus)){
		alert("Seleccione Estatus");return false;
	}
	if(!esValido(corresponsaliaBancaria)){
		alert("Seleccione Corresponsal Bancario");return false;
	}
	if(!esValido(ejecutivoVenta) || ejecutivoVenta <= 0){
		alert("Seleccione Ejecutivo de Venta");return false;
	}
	if(!esValido(ejecutivoCuenta) || ejecutivoCuenta <= 0){
		alert("Seleccione Ejecutivo de Cuenta");return false;
	}
	if(!esValido(representanteLegal) || representanteLegal <= 0){
		alert("Agregue Representante Legal");return false;
	}
	if(!esValido(calle) || calle <= 0){
		alert("Agregue Calle");return false;
	}
	if(!esValido(numeroExterior) || numeroExterior <= 0){
		alert("Agregue Número Exterior");return false;
	}
	if(!esValido(numeroInterior) || numeroInterior <= 0){
		alert("Agregue Número Interior");return false;
	}

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var pais				= txtValue("ddlPais");
	var codigoPostal		= txtValue("txtcp");
	var nombreSucursal		= txtValue("txtnombresucursal");
	var numeroSucursal		= txtValue("txtnumerosucursal");
	//var banco				= txtValue("ddlBanco");
	//var actividadBanco		= txtValue("txtactbanc");
	//var divisionGeografica	= txtValue("ddlEntDiv");

	if(!esValido(colonia) || colonia <= 0){
		alert("Seleccione Colonia");return false;
	}
	if(!esValido(estado) || estado <= 0){
		alert("Seleccione Estado");return false;
	}
	if(!esValido(municipio) || municipio <= 0){
		alert("Seleccione Municipio");return false;
	}
	if(!esValido(pais) || pais <= 0){
		alert("Seleccione País");return false;
	}
	if(!esValido(codigoPostal) || codigoPostal <= 0){
		alert("Agregue Código Postal");return false;
	}
	if(!esValido(nombreSucursal) || nombreSucursal <= 0){
		alert("Agregue Nombre de Sucursal");return false;
	}
	if(!esValido(iva) || iva <= 0){
		alert("Seleccione Iva");return false;
	}

	parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva;

	if(editarCorresponsal){
		MetodoAjax44("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
	}
}

function UpdateCorresponsalBancario(iddato, tipoCliente){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= ''/*txtValue("txtmail")*/;
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= -1;
	var referencia				= txtValue("ddlReferencia");
	var estatus					= -1;
	var corresponsaliaBancaria	= txtValue("ddlCorBanc");
	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var representanteLegal		= $("#ddlRepLegal").val();
	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= $("#ddlIva").val();

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var pais				= txtValue("ddlPais");
	var codigoPostal		= txtValue("txtcp");
	var nombreSucursal		= ''/*txtValue("txtnombresucursal")*/;
	var numeroSucursal		= ''/*txtValue("txtnumerosucursal")*/;

	parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva;

	if(editarCorresponsal){
		MetodoAjax44("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
	}
}


function UpdateCorresponsalDireccion(iddato, tipoCliente){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= txtValue("txtmail");
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= -1;
	var referencia				= txtValue("ddlReferencia");
	var estatus					= -1;
	var corresponsaliaBancaria	= 0;
	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var representanteLegal		= $("#ddlRepLegal").val();
	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= $("#ddlIva").val();

	if(!esValido(calle) || calle <= 0){
		alert("Agregue Calle");return false;
	}
	if(!esValido(numeroExterior) || numeroExterior <= 0){
		alert("Agregue Número Exterior");return false;
	}
	/*if(!esValido(numeroInterior) || numeroInterior <= 0){
		alert("Agregue Número Interior");return false;
	}*/

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var pais				= txtValue("ddlPais");
	var codigoPostal		= txtValue("txtcp");
	var nombreSucursal		= txtValue("txtnombresucursal");
	var numeroSucursal		= txtValue("txtnumerosucursal");
	//var banco				= txtValue("ddlBanco");
	//var actividadBanco		= txtValue("txtactbanc");
	//var divisionGeografica	= txtValue("ddlEntDiv");

	if(!esValido(colonia) || colonia <= 0){
		alert("Seleccione Colonia");return false;
	}
	if(!esValido(estado) || estado <= 0){
		alert("Seleccione Estado");return false;
	}
	if(!esValido(municipio) || municipio <= 0){
		alert("Seleccione Ciudad");return false;
	}
	if(!esValido(pais) || pais <= 0){
		alert("Seleccione País");return false;
	}
	if(!esValido(codigoPostal) || codigoPostal <= 0){
		alert("Agregue Código Postal");return false;
	}

	parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva;
	UpdateHorariosCorr2(idCorresponsal);

	/*if(editarCorresponsal){
		MetodoAjax44("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
	}*/
}

function UpdateCorresponsalGenerales(iddato, tipoCliente){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= ''/*txtValue("txtmail")*/;
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= txtValue("ddlGiro");
	var referencia				= txtValue("ddlReferencia");

	var estatus					= txtValue("ddlEstatus");

	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var ejecutivoRemesas		= $("#ddlEjecutivoAfIn").val();
	var ejecutivoBancario		= $("#ddlEjecutivoAfAv").val();
	var representanteLegal		= $("#ddlRepLegal").val();

	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= 0/*$("#ddlIva").val()*/;
	var pais					= txtValue("ddlPais");
	var codigoPostal			= txtValue("txtcp");

	var corresponsaliaBancaria	= 0;

	if(!esValido(telefono1)){
		alert("Agregue Teléfono 1 ");return false;
	}
	if ( !validaTelefonoAnterior3("txttel1") ) {
		alert("Favor de agregar un tel\u00E9fono v\u00E1lido.");
		return false;
	}
	if(!esValido(telefono2)){
		telefono2 = "";
	}
	if(!esValido(fechaVencimiento)){
		alert("Agregue Fecha de Vencimiento");return false;
	}
	if(!esValido(giro) || giro < 0){
		alert("Seleccione Giro");return false;
	}
	if(!esValido(estatus)){
		alert("Seleccione Estatus");return false;
	}

	if(!esValido(ejecutivoVenta) || ejecutivoVenta <= 0){
		alert("Seleccione Ejecutivo de Venta");return false;
	}
	if(!esValido(ejecutivoCuenta) || ejecutivoCuenta <= 0){
		alert("Seleccione Ejecutivo de Cartera");return false;
	}
	
	if ( REMESAS || SORTEOS ) {
		if(!esValido(ejecutivoRemesas) || ejecutivoRemesas <= 0){
			alert("Seleccione Ejecutivo de Remesas y Sorteos");return false;
		}
	}
	if ( BANCARIOS ) {
		if(!esValido(ejecutivoBancario) || ejecutivoBancario <= 0){
			alert("Seleccione Ejecutivo de Bancos");return false;
		}
	}

	/*if(!validarEmail('txtmail')){
		alert("Favor de escribir un correo v\u00E1lido");return false;
	}*/

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var nombreSucursal		= ''/*txtValue("txtnombresucursal")*/;
	var numeroSucursal		= ''/*txtValue("txtnumerosucursal")*/;

	/*if(!esValido(nombreSucursal) || nombreSucursal <= 0){
		alert("Agregue Nombre de Sucursal");return false;
	}*/
	/*if(!esValido(iva) || iva <= 0){
		alert("Seleccione Iva");return false;
	}*/

	parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva+"&ejecutivoRemesas="+ejecutivoRemesas+"&ejecutivoBancario="+ejecutivoBancario;
	//UpdateHorariosCorr2(idCorresponsal);

	if(editarCorresponsal){
		MetodoAjax44("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
	}
}

function MetodoAjax44(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
                contad = 0;
                irAListado();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
                contad = 1;
			}			
		} 
	}
	http.send(parametros+"&pemiso="+true);
}

function VerificarDireccionCorr2( tipo ){
	var caracteresValidos = /^\d{5}$/i;
	/*if ( txtValue("txtcalle") != '' )
		//document.getElementById("calleok").style.display = "inline-block";
	else
		document.getElementById("calleok").style.display = "none";
	if ( txtValue("txtnext") !=  '' )
		//document.getElementById("nextok").style.display = "inline-block";
	else
		document.getElementById("nextok").style.display = "none";
	if ( tipo == "nacional" ) {
		if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" )
			//document.getElementById("ciudadok").style.display = "inline-block";
		else
			document.getElementById("ciudadok").style.display = "none";
		if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" )
			//document.getElementById("estadook").style.display = "inline-block";
		else
			document.getElementById("estadook").style.display = "none";
		if ( txtValue("ddlPais") > -1 )
			//document.getElementById("paisok").style.display = "inline-block";
		else
			document.getElementById("paisok").style.display = "none";
		if ( txtValue("ddlColonia") > -1 )
			//document.getElementById("colok").style.display = "inline-block";
		else
			//document.getElementById("colok").style.display = "none";
	}
	if ( txtValue("txtnint") != '' )
		//document.getElementById("nintok").style.display = "inline-block";	
	else
		//document.getElementById("nintok").style.display = "none";
	if ( txtValue("txtcp").match(caracteresValidos) )
		//document.getElementById("cpok").style.display = "inline-block";	
	else
		//document.getElementById("cpok").style.display = "none";
	if ( tipo == "extranjera" ) {
		if ( txtValue("txtColonia") != '' )
			//document.getElementById("colok").style.display = "inline-block";	
		else
			//document.getElementById("colok").style.display = "none";
		if ( txtValue("txtEstado") != '' )
			//document.getElementById("estadook").style.display = "inline-block";	
		else
			//document.getElementById("estadook").style.display = "none";
		if ( txtValue("txtMunicipio") != '' )
			//document.getElementById("ciudadok").style.display = "inline-block";	
		else
			//document.getElementById("ciudadok").style.display = "none";
	}*/
	if(Existe("txtnombre"))
	    VerificarRepresentanteLeg();
}

function VerificarDireccionCad( tipo, primeraCarga ) {
	var caracteresValidos = /^\d{5}$/i;
	var permitirGuardarCambios = false;
	if ( txtValue("txtcalle") != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txtnext") !=  '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( tipo == "nacional" ) {
		if ( txtValue("ddlMunicipio") > -2 && txtValue("ddlMunicipio") != "" ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("ddlEstado") > -2 && txtValue("ddlEstado") != "" ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("paisID") > 0 ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("ddlColonia") > -1 ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( txtValue("txtnint") != '' ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( txtValue("txtcp").match(caracteresValidos) ) {
		permitirGuardarCambios = true;
		existenCambios = true;
	}
	if ( tipo == "extranjera" ) {
		if ( txtValue("txtColonia") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("txtEstado") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
		if ( txtValue("txtMunicipio") != '' ) {
			permitirGuardarCambios = true;
			existenCambios = true;
		}
	}
	if ( permitirGuardarCambios && !primeraCarga ) {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", false);
		}
	} else {
		if ( document.getElementById("guardarCambios") ) {
			$("#guardarCambios").prop("disabled", true);
		}
	}
}

function cambiarPantalla() {
	var pais = txtValue('paisID');
	var coloniaDisplay = document.getElementById('ddlColonia').style.display;
	var estadoDisplay = document.getElementById('ddlEstado').style.display;
	var ciudadDisplay = document.getElementById('ddlMunicipio').style.display;
	if ( pais != 164 && pais != "" ) {
		if ( coloniaDisplay != 'none' ) {
			document.getElementById('ddlColonia').style.display = 'none';
		}
		if ( estadoDisplay != 'none' ) {
			document.getElementById('ddlEstado').style.display = 'none';
		}
		if ( ciudadDisplay != 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'none';
		}		
		document.getElementById('txtColonia').style.display = 'block';
		document.getElementById('txtEstado').style.display = 'block';
		document.getElementById('txtMunicipio').style.display = 'block';
		tipoDireccion = "extranjera";
	} else if ( pais == 164 && pais != "" ) {
		if ( coloniaDisplay == 'none' ) {
			document.getElementById('ddlColonia').style.display = 'block';
		}
		if ( estadoDisplay == 'none' ) {
			document.getElementById('ddlEstado').style.display = 'block';
		}
		if ( ciudadDisplay == 'none' ) {
			document.getElementById('ddlMunicipio').style.display = 'block';
		}		
		document.getElementById('txtColonia').style.display = 'none';
		document.getElementById('txtEstado').style.display = 'none';
		document.getElementById('txtMunicipio').style.display = 'none';
		document.getElementById('txtcp').value = '';
		tipoDireccion = "nacional";
	}
}

function buscarColonias() {
	if ( tipoDireccion == "nacional" ) {
		var codigoPostal = $("#txtcp").val();
		var caracteresValidos = /^\d{5}$/i;
		var maxlength = $("#txtcp").attr("maxlength");
		if ( codigoPostal.length < maxlength ) {
			noEncontroColonias = true;
		}
		if ( codigoPostal != '' && codigoPostal != null ) {
			if ( codigoPostal.match(caracteresValidos) ) {
				$.post( '../../inc/Ajax/_Clientes/buscarColonia.php', { "codigoPostal": codigoPostal } ).done(
					function(data) {
						var colonia = jQuery.parseJSON( data );
						if ( colonia.codigoDeRespuesta == 0 ) {
							var option = [];
							option.push('<option value="-1" selected="selected">Seleccione colonia</option>');
							for ( var i = 0; i < colonia.idColonia.length; i++ ) {
								option.push( '<option value="' + colonia.idColonia[i] + '">' + colonia.nombre[i] + '</option>' );
							}
							$("#ddlColonia").html(option.join(''));
							$("#ddlColonia").prop( "disabled", false );
							$("#ddlEstado").attr( "value", colonia.idEntidad );
							$("#ddlMunicipio").attr( "value", colonia.idCiudad );
							cambiarCiudad( 164, colonia.idEntidad, 'divCd', colonia.idCiudad, true, "PreCadena" );
							cambiarEstado( 164, 'divCd', colonia.idEntidad, true, true, "PreCadena" );
							noEncontroColonias = true;
							window.setTimeout("VerificarDireccionCad(tipoDireccion)",100);
						} else {
							if ( $("#txtcp").val().length == maxlength && noEncontroColonias ) {
								noEncontroColonias = false;
								alert(colonia.mensajeDeRespuesta);
							}
						}			
				} );					
			} else {
				var option = [];
				$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
				$("#ddlColonia").prop( "disabled", true );
				$("#ddlMunicipio").val('');
				$("#ddlEstado").val('');
			}
	}
	} else {
		var option = [];
		$("#ddlColonia").html('<option value="-1" selected="selected">Seleccione colonia</option>');
		$("#ddlColonia").prop( "disabled", true );
	}		
}

function cambiarCiudad( paisID, estadoID, listaID, ciudadSeleccionada, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/BuscaSelectCd.php', { "idpais": paisID, "idedo": estadoID } ).done(
		function( listaCiudades ) {
			if ( paisID == 164 ) {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					//$("#"+listaID).append( '<input type="text" style="display:none;" name="txtMunicipio" id="txtMunicipio" value="" />' );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					if ( disabled ) {
						$("#ddlMunicipio").prop("disabled", true);
					} else {
						$("#ddlMunicipio").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}
				}
			} else {
				if ( listaCiudades != null || listaCiudades != '' ) {
					$("#ddlMunicipio").replaceWith( listaCiudades );
					$("#ddlMunicipio").val(ciudadSeleccionada);
					$("#ddlMunicipio").css("display", "none");
					$("#txtMunicipio").css("display", "block");
					setValue("txtMunicipio", $("#ddlMunicipio option:selected").text());
					Bloquear("txtMunicipio");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);
					} else if ( tipo == "PreCadena" ) {
						VerificarDireccionCad(tipoDir);	
					}					
				}
			}
		}
	);
}

function cambiarEstado( paisID, listaID, estadoSeleccionado, disabled, tipo, tipoDir ) {
	$.post( '../../inc/Ajax/_Clientes/CambioEstado.php', { "idpais": paisID } ).done(
		function( listaEstados ) {
			if ( paisID == 164 ) {
				if ( listaEstados != null || listaEstados != '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					if ( disabled ) {
						$("#ddlEstado").prop("disabled", true);
					} else {
						$("#ddlEstado").prop("disabled", false);		
					}
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}
				}
			} else {
				if ( listaEstados != null || listaEstados == '' ) {
					$("#ddlEstado").replaceWith( listaEstados );
					$("#ddlEstado").val(estadoSeleccionado);
					$("#ddlEstado").css("display", "none");
					$("#txtEstado").css("display", "block");
					setValue("txtEstado", $("#ddlEstado option:selected").text());
					Bloquear("txtEstado");
					if ( tipo == "PreSubCadena" ) {
						VerificarDireccionSub(tipoDir);
					} else if ( tipo == "PreCorresponsal" ) {
						VerificarDireccionCorr(tipoDir);	
					}					
				}
			}
		}
	);
}

actualizaDireccion = true;



function UpdateHorariosCorr2(idCorr){
		
	var parametros = "idCorresponsal="+idCorr;
	var DE1 = txtValue("txt1");
	var DE2 = txtValue("txt3");
	var DE3 = txtValue("txt5");
	var DE4 = txtValue("txt7");
	var DE5 = txtValue("txt9");
	var DE6 = txtValue("txt11");
	var DE7 = txtValue("txt13");
	
	var A1 = txtValue("txt2");
	var A2 = txtValue("txt4");
	var A3 = txtValue("txt6");
	var A4 = txtValue("txt8");
	var A5 = txtValue("txt10");
	var A6 = txtValue("txt12");
	var A7 = txtValue("txt14");
	
	if(DE1 != "" || DE2 != "" || DE3 != "" || DE4 != "" || DE5 != "" || DE6 != "" || DE7 != "" || A1 != "" || A2 != "" || A3 != "" || A4 != "" || A5 != "" || A6 != "" || A7 != ""){

		if(validaHorasDia2(DE1,A1,"txt2","Lunes")){
			if(validaHorasDia2(DE2,A2,"txt4","Martes")){
				if(validaHorasDia2(DE3,A3,"txt6","Miercoles")){
					if(validaHorasDia2(DE4,A4,"txt8","Jueves")){
						if(validaHorasDia2(DE5,A5,"txt10","Viernes")){
							if(validaHorasDia2(DE6,A6,"txt12","Sabado")){
								if(validaHorasDia2(DE7,A7,"txt14","Domingo")){
									
									parametros += "&DE1='"+DE1+"'&DE2='"+DE2+"'&DE3='"+DE3+"'&DE4='"+DE4+"'&DE5='"+DE5+"'&DE6='"+DE6+"'&DE7='"+DE7+"'";
									parametros += "&A1='"+txtValue("txt2")+"'";
									parametros += "&A2='"+txtValue("txt4")+"'";
									parametros += "&A3='"+txtValue("txt6")+"'";
									parametros += "&A4='"+txtValue("txt8")+"'";
									parametros += "&A5='"+txtValue("txt10")+"'";
									parametros += "&A6='"+txtValue("txt12")+"'";
									parametros += "&A7='"+txtValue("txt14")+"'";
									
									//alert(parametros);
									editarCorresponsal = true;
									MetodoAjaxHorario("../../inc/Ajax/_Clientes/UpdateHorarios.php",parametros);
								}
								else{
									editarCorresponsal = false;
									return false
								}
							}
							else{
								editarCorresponsal = false;
								return false
							}
						}
						else{
							editarCorresponsal = false;
							return false
						}
					}
					else{
						editarCorresponsal = false;
						return false
					}
				}
				else{
					editarCorresponsal = false;
					return false
				}
			}
			else{
				editarCorresponsal = false;
				return false
			}
		}
		else{
			editarCorresponsal = false;
			return false
		}
	}
	else{
		editarCorresponsal = true;
		actualizarDireccion();
	}
}

function MetodoAjaxHorario(url,parametros){

	http.open("POST",url, true);
	http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	http.onreadystatechange=function() 
	{ 
		if (http.readyState==1)
		{
			Emergente();
		}
		if (http.readyState==4)
		{
			OcultarEmergente();
			var RespuestaServidor = http.responseText;
			RESserv = RespuestaServidor.split("|");

			validaSession(RESserv[0]);

			if(RESserv[0] == 0){
                contad = 0;

                actualizarDireccion();
				//                irAListado();
			}
			else
			{
				if(document.getElementById('daniel') != null)
					document.getElementById('daniel').innerHTML = RESserv[1];

				alert(RESserv[1]);
                contad = 1;
			}			
		} 
	}
	http.send(parametros+"&pemiso="+true);
}

function actualizarDireccion(){
	var parametros				= "";
	var idCorresponsal			= txtValue("idCorresponsal");
	var nombreCorresponsal		= txtValue("txtnomcor");
	var telefono1				= txtValue("txttel1");
	var telefono2				= txtValue("txttel2");
	var fax						= txtValue("txtfax");
	var correo					= txtValue("txtmail");
	var fechaVencimiento		= txtValue("txtFechaVenc");
	var giro					= -1;
	var referencia				= txtValue("ddlReferencia");
	var estatus					= -1;
	var corresponsaliaBancaria	= 0;
	var usuarioAlta				= sel5;
	var ejecutivoVenta			= $("#ddlEjecutivoVenta").val();
	var ejecutivoCuenta			= $("#ddlEjecutivo").val();
	var representanteLegal		= $("#ddlRepLegal").val();
	var calle					= txtValue("txtcalle");
	var numeroExterior			= txtValue("txtnext");
	var numeroInterior			= txtValue("txtnint");
	var iva						= $("#ddlIva").val();

	if(!esValido(calle) || calle <= 0){
		alert("Agregue Calle");return false;
	}
	if(!esValido(numeroExterior) || numeroExterior <= 0){
		alert("Agregue Número Exterior");return false;
	}

	if(tipoDireccion == "nacional"){
		var colonia		= txtValue("ddlColonia");
		var estado		= txtValue("ddlEstado");
		var municipio	= txtValue("ddlMunicipio");		
	}
	else{
		var colonia		= txtValue("txtColonia");
		var estado		= txtValue("txtEstado");
		var municipio	= txtValue("txtMunicipio");		
	}

	var pais				= txtValue("ddlPais");
	var codigoPostal		= txtValue("txtcp");
	var nombreSucursal		= txtValue("txtnombresucursal");
	var numeroSucursal		= txtValue("txtnumerosucursal");
	//var banco				= txtValue("ddlBanco");
	//var actividadBanco		= txtValue("txtactbanc");
	//var divisionGeografica	= txtValue("ddlEntDiv");

	if(!esValido(colonia) || colonia <= 0){
		alert("Seleccione Colonia");return false;
	}
	if(!esValido(estado) || estado <= 0){
		alert("Seleccione Estado");return false;
	}
	if(!esValido(municipio) || municipio <= 0){
		alert("Seleccione Ciudad");return false;
	}
	if(!esValido(pais) || pais <= 0){
		alert("Seleccione País");return false;
	}
	if(!esValido(codigoPostal) || codigoPostal <= 0){
		alert("Agregue Código Postal");return false;
	}

    parametros += "idCorresponsal="+idCorresponsal+"&nombreCorresponsal="+nombreCorresponsal+"&telefono1="+telefono1+"&telefono2="+telefono2+"&fax="+fax+"&correo="+correo+"&fechaVencimiento="+fechaVencimiento+"&giro="+giro+"&referencia="+referencia+"&estatus="+estatus+"&corresponsaliaBancaria="+corresponsaliaBancaria+"&usuarioAlta="+usuarioAlta+"&ejecutivoVenta="+ejecutivoVenta+"&representanteLegal="+sel3+"&calle="+calle+"&numeroExterior="+numeroExterior+"&numeroInterior="+numeroInterior+"&colonia="+colonia+"&pais="+pais+"&estado="+estado+"&municipio="+municipio+"&codigoPostal="+codigoPostal+"&nombreSucursal="+nombreSucursal+"&numeroSucursal="+numeroSucursal+/*"&banco="+banco+"&actividadBanco="+actividadBanco+"&divisionGeografica="+divisionGeografica+*/"&ejecutivoCuenta="+ejecutivoCuenta+"&iva="+iva;
    MetodoAjax44("../../inc/Ajax/_Clientes/ActualizaCorresponsal.php",parametros);
}

function validaHorasDia2(valorDe,valorA,txt,dia){
	if(valorDe != ""){
		if(valorA != ""){
			if(validaHorasRegex2(valorDe)){
				if(validaHorasRegex2(valorA)){
					return true;
				}
				else{
					alert("Favor de escribir la Hora de Cierre correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
					return false;
				}
			}
			else{
				alert("Favor de escribir la Hora de Inicio correctamente del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
				return false;
			}
		}
		else{
			alert("Favor de escribir la Hora de Cierre del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
			return false;
		}
	}
	else{
		alert("Favor de escribir la Hora de Inicio del " + dia + ". Ejemplo: hh:mm en formato 24 horas.");
		setValue(txt,'');
		return false;
	}

	return true;
}

function validaHorasRegex2(valor){
	var re = /^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/;
	if ( re.exec(valor) ) {
		return true;
	} else {
		return false;
	}
}
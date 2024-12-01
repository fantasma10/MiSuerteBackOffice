	function goToPage(a)
    {
        window.location.href="Consulta.php?id=" + a;
    }

    function clickCadena(){
  		DisplayNone('busquedaCliente');
  		//DisplayNone('divBusCorr');
  		//DisplayBlock('divBusCad-Sub');
  		//DisplayBlock('busquedaCadena');
		DisplayInlineBlock('busquedaCadena');
  		DisplayNone('busquedaCorresponsal');
  		DisplayNone('busquedaSubCadena');
  		resetSelect('ddlSubCad');
  		resetSelect('ddlCorresponsal');
  		resetSelect('ddlEstado');
  		resetSelect('ddlMunicipio');
  		resetSelect('ddlCalle');
  		emptyDivRES();
  		$("#divRESParent").hide();
  	}

	function clickSubCadena(){
		DisplayNone('busquedaCliente');
		DisplayNone('busquedaCadena');
		DisplayNone('busquedaCorresponsal');
		//DisplayNone('divBusCorr');
		//DisplayBlock('divBusCad-Sub');
		DisplayBlock('busquedaSubCadena');
		DisplayNone('busquedaCadena');
		resetSelect('ddlSubCad');
		resetSelect('ddlCorresponsal');
		resetSelect('ddlEstado');
		resetSelect('ddlMunicipio');
		resetSelect('ddlCalle');
		emptyDivRES();
		$("#divRESParent").hide();	
	}

	function clickCliente(){
		DisplayNone('busquedaCadena');
		DisplayNone('busquedaSubCadena');
		DisplayNone('busquedaCorresponsal');
		//DisplayBlock('busquedaCliente');
		document.getElementById("busquedaCliente").style.display="inline-block";

		emptyDivRES();
		$("#divRESParent").hide();
	}

	function clickCorresponsal(){
		//DisplayBlock('divBusCad-Sub');
		//DisplayBlock('divBusCorr');
		DisplayBlock('busquedaCorresponsal');
	    DisplayNone('busquedaSubCadena');
	    DisplayNone('busquedaCadena');
	    DisplayNone('busquedaCliente');
		resetSelect('ddlSubCad');
		resetSelect('ddlCorresponsal');
		resetSelect('ddlEstado');
		buscarSelectEdo(true);
		resetSelect('ddlMunicipio');
		resetSelect('ddlCalle');
		emptyDivRES();
		$("#divRESParent").hide();
	}

	function emptyDivRES(){
		if(!$('#divRES').is(':empty')){
			$("#divRES").empty();
		}
	}
	$( document ).ready( function() {
		
		$("input[name='radio']").change(radioValueChanged);

		function radioValueChanged(){
			radioValue = $(this).val();

			emptyDivRES();
		}

		$('#rdbCadena').click(clickCadena);

		$('#rdbSubcadena').click(clickSubCadena);

		$('#rdbCorresponsal').click(clickCorresponsal);
		
	} );
	function setDefaultValueSelect( id ) {
		$( '#' + id  + ' option:first-child' ).attr('selected', true);
	}
	function resetSelect( id ) {
		$( '#' + id  + ' option:first-child' ).attr('selected', true);
		removeAllOptions( id );
		setDisabled( id );
	}
	function removeAllOptions( id ) {
		$( '#' + id  ).children( 'option:not(:first)' ).remove();
	}
	function setDisabled( id ) {
		$( '#' + id ).prop( 'disabled', true );
	}
	$( function() {
		if ( $("#cadena").length ) {
			$("#cadena").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getCadenas.php", { "cadena": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#cadena").val(ui.item.nombre);
					return false;
				},
				select: function( event, ui ) {
					$("#cadenaID").val(ui.item.idCadena);
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + "ID: " + item.idCadena + " " + item.nombre + "</a>" )
				.appendTo( ul );
			};
			$("#cadena2").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getCadenas.php", { "cadena": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#cadena2").val(ui.item.nombre);
					return false;				
				},
				select: function( event, ui ) {
					$("#cadena2ID").val(ui.item.idCadena);
					return false;				
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + "ID: " + item.idCadena + " " + item.nombre + "</a>" )
				.appendTo( ul );
			};
			$("#subcadena").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getSubCadenas.php", { "subcadena": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#subcadena").val(ui.item.nombre);
					return false;				
				},
				select: function( event, ui ) {
					$("#subcadenaID").val(ui.item.idSubCadena);
					return false;				
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.appendTo( ul );
			};
			$("#txtCliente, #txtRFCCliente, #txtCuenta").on('keyup', function(event){
				var id = event.target.id;
				var value = event.target.value;
				
				/*var cfg = {
					txtCliente	: 'txtRFCCliente',
					txtRFCCliente		: 'txtCliente'
				}

				var txt = eval("cfg."+id);
				if(value == "" || value == undefined){
					$("#"+txt).prop('disabled', false);
				}
				else{
					$("#"+txt).prop('disabled', true);
				}*/

				if(value == "" || value == undefined){
					if(id == "txtCliente"){
						$("#txtRFCCliente, #txtCuenta").prop('disabled', false);
					}
					if(id == "txtRFCCliente"){
						$("#txtCliente, #txtCuenta").prop('disabled', false);
					}
					if(id == "txtCuenta"){
						$("#txtCliente, #txtRFCCliente").prop('disabled', false);
					}
				}
				else{
					if(id == "txtCliente"){
						$("#txtRFCCliente, #txtCuenta").prop('disabled', true);
					}
					if(id == "txtRFCCliente"){
						$("#txtCliente, #txtCuenta").prop('disabled', true);
					}
					if(id == "txtCuenta"){
						$("#txtCliente, #txtRFCCliente").prop('disabled', true);
					}
				}

				var valorC = $("#txtCliente").val();
				var valorR = $("#txtRFCCliente").val();
				var valorCta = $("#txtCuenta").val();

				if(myTrim(valorC) == "" && myTrim(valorR) == "" && myTrim(valorCta) == ""){
					$("#idCliente").val(0);
				}
			});
			$("#txtCliente, #txtRFCCliente").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getClientes.php", { "text": request.term },
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
					return false;				
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + "ID: " + item.idCliente + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.appendTo( ul );
			};
			$("#txtCuenta").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getClientes.php", { "text": request.term },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$(this).val(ui.item.ctaContable);
					return false;				
				},
				select: function( event, ui ) {
					$("#idCliente").val(ui.item.idCliente);
					return false;				
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $( '<li>' )
				.append( "<a>" + "ID: " + item.idCliente + " " + item.nombre + "<br><span class='thinTitle'> Cta-Contable: " + item.ctaContable + "</span></a>" )
				.appendTo( ul );
			};						
		}
		$("#cadena").alphanum({
			allow: "áéíóúÁÉÍÓÚñÑ-",
			disallow: "¿¡°´¨~",
			allowLatin: true,
			allowOtherCharSets: false
		});
		$("#cadena2").alphanum({
			allow: "áéíóúÁÉÍÓÚñÑ-",
			disallow: "¿¡°´¨~",
			allowLatin: true,
			allowOtherCharSets: false
		});		
		$("#subcadena, #txtCliente").alphanum({
			allow: "áéíóúÁÉÍÓÚñÑ",
			disallow: "¿¡°´¨~-",
			allowLatin: true,
			allowOtherCharSets: false
		});

		$("#txtRFCCliente").alphanum({
			disallow: "¿¡°´¨~-",
			allowNumeric	: true,
			allowOtherCharSets: false
		});
		$("#txtRFCCliente").attr('style', 'text-transform: uppercase;');

		$("#idCadena, #idSub, #idCor").alphanum({
			allow: "áéíóúÁÉÍÓÚñÑ",
			disallow: "¿¡°´¨~-",
			allowLatin: true,
			allowOtherCharSets: false
		});
		$("#txtTel").alphanum({
			allow: "1234567890-",
			disallow: "¿¡°´¨~-abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
			allowSpace: false,
			allowLatin: true,
			allowOtherCharSets: false
		});

		$("#cadena, #cadena2, #subcadena, #idCadena, #idSub, #idCor, #txtTel, #cPais").bind("paste", function(){return false;});
	} );

	$(function(){

		$("#txtTel").keyup(function(){
			sel2 = 0; sel3 = 0;
			var fields = ["idCadena", "idSub", "idCor","ddlCad", "ddlSubCad", "ddlCorresponsal", ""]
			if($("#txtTel").val() != ""){
				resetSomeFields(fields, true);
			}
			else{
				resetSomeFields(fields, false)
			}
		});
	});

	function resetSomeFields(allFields, bool){
		for(key in allFields){			
			var id = allFields[key];

			var val = "";
			var tipo = $("#"+id).prop('type');

			switch(tipo){
				case "text" :
					val = "";
				break;
				case "select-one" :
					val = -1;
				break;
				case "hidden":
					val = -1;
				break;

			}

			$("#"+id).val(val);
			$("#"+id).prop("disabled", bool);
		}
	}

	function validarParametrosCorresponsal(i){
		var idCadena = $("#ddlCad").val();
		var idSubCad = $("#ddlSub").val();
		var idCor	 = $("#ddlCorresponsal").val();

		var idPais	= $("#ddlPais").val();
		var idEdo	= $("#ddlEstado").val();
		var idMun	= $("#ddlMunicipio").val();
		var idCol	= $("#ddlColonia").val();

		if(idCor < 0 &&(sel2 > 0 || sel3 > 0)){
			if(sel2 > 0){
				idCor = sel2;
			}
			if(sel3 > 0){
				idCor = sel3;
			}
		}

		if((idSubCad == "" || idSubCad < 0 || idSubCad == undefined) && (idCadena == "" || idCadena < 0 || idCadena == undefined) && (idCor == "" || idCor < 0 || idCor == undefined) && ((idPais < 0 || idPais == undefined) && (idEdo < 0 || idEdo == undefined) && (idMun < 0 || idMun == undefined) && (idCol < 0 || idCol == undefined))){
			alert("Seleccione un Corresponsal");
		}
		else{
			var parametros = "idCadena="+idCadena+"&idSubCad="+idSubCad+"&idCor="+idCor+"&idPais="+idPais+"&idEdo="+idEdo+"&idMun="+idMun+"&idCol="+idCol;
			//alert("parametros: " + parametros);
			return parametros;
			//BuscarParametros("../../inc/Ajax/_Clientes/BuscaCorresponsalXDirecc.php",parametros,"divRES",i);
			/*BuscaCorresponsales(parametros);*/
		}
	}

	function BuscaCorresponsales(i){
		var params = validarParametrosCorresponsal();
		var strParams = params.split("&");
		var obj = {}
		$.each(strParams, function(index, value){
			var param = strParams[index];
			param = param.split("=");

			obj[param[0]] = param[1];
		});
		$.post("../../inc/Ajax/_Clientes/showTblCorresponsal.php", {},
			function( response ) {
				if(response != ""){
					$("#divRES").html(response);
					$("#divRESParent").show();
					getCorresponsales(obj);
				}
				else{
					//$("#divRESParent").hide();
				}
			}
		);
	}

	function getCorresponsales(obj){

		$('#tblListaCorresponsales').dataTable({
			"iDisplayLength"	: 10,
			"bProcessing"		: false,
			"bServerSide"		: true,
			"sAjaxSource"		: "../../inc/Ajax/_Clientes/BuscaCorresponsalXDirecc.php",
			//"sPaginationType"	: "full_numbers",
			/*"oLanguage"			: {
				"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
				"sZeroRecords"		: "No se ha encontrado nada",
				"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
				"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
				"sInfoFiltered"		: "(Filtrado de _MAX_ total de Registros)"
			},*/
			"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		},
			"fnPreDrawCallback"	: function() {
				Emergente();
			},
			"fnDrawCallback": function() {
				OcultarEmergente();
			},
			fnServerParams : function (aoData){
				$.each(obj, function(index, val){
					aoData.push({name : index, value : val });
				});
			}
		});
	}

	function BuscaSubCadena22(i){
		var cadenaID = txtValue('cadena2ID');
		if ( cadenaID != "" && cadenaID >= 0 ) {
			var parametros = "idCadena="+cadenaID;
			BuscarParametros3("../inc/Ajax/_Clientes/ShowTblSubCadena.php",parametros,'divRES',i);
		} else {
			alert("Favor de buscar una Cadena y seleccionarla");
		}
	}

	function BuscarParametros3(url,parametros,div){

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
				var RespuestaServidor = http.responseText;//alert(RespuestaServidor);
				validaSession(RespuestaServidor);
	            if(div == null || div == '')
	                    document.getElementById(div).innerHTML = RespuestaServidor;//alert("ddd");
	            else{
	                    //document.getElementById(div).innerHTML = RespuestaServidor;
						$("#divRESParent").show();
						setDivHTML(div,RespuestaServidor);
	            }
				OcultarEmergente();
				someFn();
			} 
		}
		http.send(parametros);
	}

	function someFn(){
		$('#example').dataTable({
			"iDisplayLength"	: 10,
			"bProcessing"		: false,
			"bServerSide"		: true,
			"sAjaxSource"		: "../../inc/Ajax/_Clientes/BuscaSubCadena.php",
			//"sPaginationType"	: "full_numbers",
			"oLanguage": {
				"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
				"sZeroRecords"		: "No se ha encontrado nada",
				"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
				"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
				"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)"
			},
			"fnPreDrawCallback"	: function() {
				Emergente();
			},
			"fnDrawCallback": function() {
				OcultarEmergente();
			},
			fnServerParams : function (aoData){
				var cadenaID = txtValue('cadena2ID');

				if(cadenaID != "" && cadenaID >= 0) {
					aoData.push({name : "idCadena",value : cadenaID});
				}
			}
		});
	}

	$(function(){
		if($("#idCadena").length){
			$("#idCadena").autocomplete({
				source: function( request, respond ) {
					$.post( "../inc/Ajax/_Clientes/getListaCategoria.php",{ text : request.term, categoria : 1 },
					function( response ) {
						respond(response);
					}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#idCadena").val(ui.item.nombreCadena);
					return false;
				},
				select: function( event, ui ) {
					$("#ddlCad").val(ui.item.idCadena);
					return false;
				}
			})
			.data("ui-autocomplete")._renderItem = function( ul, item ) {
				return $('<li>')
				.append( "<a>" + item.label + "</a>" )
				.appendTo( ul );
			}
		}

		if($("#idSub").length){
			$("#idSub").autocomplete({
				source: function( request, respond ) {
					$.post("../inc/Ajax/_Clientes/getListaCategoria.php",
						{
							idCadena	: $("#ddlCad").val(),
							categoria	: 2,
							text		: request.term
						},
						function( response ) {
							respond(response);
						}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#idSub").val(ui.item.nombreSubCadena);
					return false;
				},
				select: function( event, ui ) {
					$("#ddlSub").val(ui.item.idSubCadena);
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $('<li>')
				//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
				.appendTo( ul );
			}
		}

		if($("#idSub").length){
			$("#idSub").autocomplete({
				source: function( request, respond ) {
					$.post("../inc/Ajax/_Clientes/getListaCategoria.php",
						{
							idCadena	: $("#ddlCad").val(),
							categoria	: 2,
							text		: request.term
						},
						function( response ) {
							respond(response);
						}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#idSub").val(ui.item.nombreSubCadena);
					return false;
				},
				select: function( event, ui ) {
					$("#ddlSub").val(ui.item.idSubCadena);
					if ( ui.item.idCadena != 0 ) {
						$("#ddlCad").val(ui.item.idCadena);
					}
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $('<li>')
				//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
				.appendTo( ul );
			}
		}

		if($("#txtTel").length){
			$("#txtTel").autocomplete({
				source: function( request, respond ) {
					$.post("../inc/Ajax/AutoCorresponsalTel.php",
						{
							term		: request.term
						},
						function( response ) {
							respond(response);
						}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					//$("#txtTel").alphanum();				
					$("#txtTel").val(ui.item.label);
					//console.log($("#txtTel").val());
					return false;
				},
				select: function( event, ui ) {				
					$("#ddlCorresponsal").val(ui.item.id);
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

		if($("#idCor").length){
			$("#idCor").autocomplete({
				source: function( request, respond ) {
					$.post("../inc/Ajax/_Clientes/getListaCategoria.php",
						{
							idCadena	: $("#ddlCad").val(),
							idSubCadena	: $("#ddlSub").val(),
							categoria	: 3,
							text		: request.term
						},
						function( response ) {
							respond(response);
						}, "json" );					
				},
				minLength: 1,
				focus: function( event, ui ) {
					$("#idCor").val(ui.item.nombreCorresponsal);
					return false;
				},
				select: function( event, ui ) {
					$("#idCadena").val(ui.item.nombreCadena);
					$("#idSub").val(ui.item.nombreSubCadena);
					$("#ddlSub").val(ui.item.idSubCadena);
					$("#ddlCad").val(ui.item.idCadena);
					$("#ddlCorresponsal").val(ui.item.idCorresponsal);
					return false;
				}
			})
			.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
				return $('<li>')
				//.append( "<a>" + "ID: " + item.idSubCadena + " " + item.nombre + "<br><span class='thinTitle'>" + item.nombreCadena + "</span></a>" )
				.append("<a>" + item.label + "<br>"+item.nombreCadena + "</a>")
				.appendTo( ul );
			}
		}

		if($("#cPais").length){
			$("#cPais").autocomplete({
				source: function( request, respond ) {
					$.post("../inc/Ajax/_Clientes/getPaises.php",
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
					buscarSelectEdo(true);
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

		buscarSelectEdo(true);

		$("#idCadena").keyup(function(){
			if($("#idCadena").val() == '' || $("#idCadena").val() == undefined){
				$("#ddlCad").val(-1);
			}
		});

		$("#idSub").keyup(function(){
			if($("#idSub").val() == '' || $("#idSub").val() == undefined){
				$("#ddlSub").val(-1);
			}
		});

		$("#idCor").keyup(function(){
			if($("#idCor").val() == '' || $("#idCor").val() == undefined){
				$("#ddlCorresponsal").val(-1);
			}
		});

	});



	function buscarCliente(){
		var idCliente = $("#formBusquedaCliente [id='idCliente']").val();

		if(idCliente == 0 || idCliente == "" || idCliente == undefined){
			alert("Seleccione un Cliente");
		}
		else{
			$("#formBusquedaCliente").submit();
		}
	}
$(document).ready(function(){
  
   var cp = $('#txtNCodigoPostal').val();
     var Paiss = $('#cmbPais').val();
   // showInputdireccion();
    direccionInputs();
   //algunos formatos iniciales
    initInputFiles();
    formatosiniciales();
    datatablasucursales();
    //
    $('.ro').prop('disabled',true);
    $('#popupmap').css('display','none');
    $('#aMapa').on('click', function(e){$('#popupmap').css('display','block');  initMap(); });  
    $('#btnclosemap').click(function(){$('#popupmap').css('display','none');}); 
     $('#nuevospn').on('click', function(){iniciacaptura();  });
    $('#cmbPais').on('change', function(e){direccionInputs();});
  
   $('#txtNCodigoPostal').on('keyup', function(e){
       if(Paiss == 164){  
         
       buscarColonias(e.target.value, 0);
    }
       
       
 // $('#txtNIdSucursal').blur(function(){validaridsucursal();});
   });
    
     
   /* $('#txtSNombreCliente').autocomplete({
			serviceUrl				: './application/models/RE_Clientes.php',
			type					: 'post',
			dataType				: 'json',
			/*showNoSuggestionNotice	: true,
			noSuggestionNotice		: 'No se encontraron coincidencias',*/
			/*onSearchStart			: function (query) {
				$('#txtSRFC').val('');
			},
			onSelect				: function (suggestion) {
				$('#txtSRFC').val(suggestion.data);
                listadeaccesos(suggestion.data);
			}
		});*/
		
		
			$("#txtSNombreCliente").autocomplete({
			source: function(request,respond){
				$.post( "./application/models/RE_Clientes.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtSNombreCliente").val(ui.item.sRazonSocial);
				return false;
			},
			select: function(event,ui){
				$("#txtSRFC").val(ui.item.nIdCliente);
				
				//alert(ui.item.nIdCliente);
				//buscaDatosSubCadena(ui.item.nIdCliente);
				//resetFormulario();
				listadeaccesos(ui.item.nIdCliente);
			
				return false;
			},
			search: function(){
				//resetFormulario();
				$("#txtSRFC").val('');
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a style=\"color:black\">"+ item.value + "</a>" )
			.appendTo( ul );
		};
    
    $('#btnGuardarSucursal').click(function(){
      
       validaridsucursal();
    
    });
    
     $('#btnAgregarContacto').click(function(){nuevocontacto(' ');});
    $('#btnNuevoContacto').click(function(){formcontactosreset(); });
    $('#btnEditarContacto').click(function(){editarcontacto(); });
    
    
    $('#btnFileCompDom').click(function(){ var doc = $('#txtNIdDocDomicilios').val();verdocumento(doc);});//Domicilio prospecto
    $('#closepdf').click(function(){$('#pdfvisor').css('display','none')});
});
/////////////////////////////////////////////////////////////
/////////////////////seccion variables//////////////////////
/////////////////////////////////////////////////////////////

        var validarcompDom = false;
        var nCodigoPostal			= 0;
		var nIdColonia				= 0;
		var nIdEntidad				= 0;
		var nIdCiudad				= 0;
		var nIdPais					= 0;
	   var map;
	   var marker = false;
	   var geocoder;
	   var infowindow;
	   var elevator;
	   var fromPlace = 0;
	   var locationFromPlace;
	   var addressFromPlace;
	   var placeName;
///////////////////////////////////////////////////////


function autoCompletaGeneral(txtField, idField, url, valueTxt, valueId, adParams, nuevaFn){
	$("#"+txtField).autocomplete({
		source: function( request, respond ) {
			$.post(url,
				formatParams(adParams, {texto : request.term, pais : request.term, text : request.term, term : request.term})
			,
			function( response ) {
				if(!response.data){
					respond(response);
				}
				else{
					respond(response.data);
				}
			}, "json" );
			GLOBAL_SELECCIONADO = false;
		},
		minLength: 1,
		focus: function( event, ui ) {
			var select = eval("ui.item." + valueTxt);
			$("#"+txtField).val(select);
			$("#"+ idField).val("");
			GLOBAL_SELECCIONADO = true;
			return false;
		},
		select: function( event, ui ) {
			var id = eval("ui.item."+valueId);
			console.log("select");
			$("#"+ idField).val(id);
			$("#"+txtField).trigger('itemselected')
			return false;
		},
		close: function(event, ui){
			var valorId = $("#"+ idField).val();
			console.log(GLOBAL_SELECCIONADO);
			if((valorId == "" || valorId == undefined) && (GLOBAL_SELECCIONADO != undefined && GLOBAL_SELECCIONADO == true)){
				$("#"+txtField).val("");
			}
			GLOBAL_SELECCIONADO = false;
		}
	})
	.data( "ui-autocomplete" )._renderItem = nuevaFn || function( ul, item ){
		return $( '<li>' )
		.append( "<a>" + eval("item." + valueTxt) + "</a>" )
		.appendTo( ul );
	};
}


/////////////////////////////////////////////////////////
 function formatosiniciales(){
     
      $('#txtSTelefono, #sTelContacto, #sMovilContacto').mask('(00) 00-00-00-00');
     
     	
     $('#txtNNumExterno, #txtNCodigoPostal').alphanum({
			disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
			allow				: '',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: false,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 10
		});
 
     
     $('#txtSCalle,  #sNombre, #sPaterno, #sMaterno, #txtNIdSucursal, #txtSNombreSucursal').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC\u0026\u002C\u002E',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			
		});
 
     
 }
 function direccionInputs(){
     var Pais = $('#cmbPais').val();
     if(Pais == 164){
        $(".dirnac").css('display','inline-block');
         $(".dirext").css('display','none');
    }
    if(Pais == 68){
        $(".dirnac").css('display','none');
         $(".dirext").css('display','inline-block');
      $('#txtSNombreMunicipio, #txtSNombreEstado, #txtSNombreColonia ').prop('disabled', false);
    }   
     
 }
/////////////////////////////////////////////////////////////////
var trans = {
    
		DefaultLat			: 40.7127837,
		DefaultLng			: -74.0059413,
		DefaultAddress		: "New York, NY, USA",
		Geolocation			: "Geolocalización:",
		Latitude			: "Latitud:",
		Longitude			: "Longitud:",
		GetAltitude			: "Obtener Altitud",
		NoResolvedAddress	: "Sin dirección resuelta",
		GeolocationError	: "Error de geolocalización.",
		GeocodingError		: "Error de codificación geográfica: ",
		Altitude			: "Altitud: ",
		Meters				: " metros",
		NoResult			: "No result found",
		ElevationFailure	: "Elevation service failed due to: ",
		SetOrigin			: "Establecer como origen",
		SetDestination		: "Establecer como destino",
		Address				: "Dirección: ",
		Bicycling			: "En bicicleta",
		Transit				: "Transporte público",
		Walking				: "A pie",
		Driving				: "En coche",
		Kilometer			: "Kilómetro",
		Mile				: "Milla",
		Avoid				: "Evitar",
		DirectionsError		: "Calculating error or invalid route.",
		North				: "N",
		South				: "S",
		East				: "E",
		West				: "O",
		Type				: "tipo",
		Lat					: "latitud",
		Lng					: "longitud",
		Dd					: "GD",
		Dms					: "GMS",
		CheckMapDelay		: 7e3
	};



function initMap(){
		infowindow = new google.maps.InfoWindow;

		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 25.6714, lng: -100.309},
			zoom: 8,
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.HYBRID
		});

		google.maps.event.addListener(map, 'click', function(event) {                
	        var clickedLocation = event.latLng;
	        if(marker === false){
	            marker = new google.maps.Marker({
	                position	: clickedLocation,
	                map			: map,
	                draggable	: true //make it draggable
	            });

	            google.maps.event.addListener(marker, 'dragend', function(event){
	                markerLocation();
	            });
	        }
	        else{
	            marker.setPosition(clickedLocation);
	        }
	        markerLocation();
	       
	    });
	}
////////////////////////////////////////////////////////////////////////
function markerLocation(){
		//Get location.
		var currentLocation = marker.getPosition();
		//Add lat and lng values to a field that we can save.
		document.getElementById('txtNLatitud').value	= currentLocation.lat(); //latitude
		document.getElementById('txtNLongitud').value	= currentLocation.lng(); //longitude
	}
//////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////


function customEmptyStore(id){
	var cmb		= document.getElementById(id);
	var length	= cmb.options.length;

	var i;
    for(i = cmb.options.length - 1 ; i >= 0 ; i--){
		cmb.remove(i);
    }
}
function customTrim(txt){
	txt = txt.toString();
	return txt.replace(/^\s+|\s+$/g, '');
}

////////////////////////////////////////////

function buscarColonias(nCodigoPostal, nIdColonia){
    
  
	if(nCodigoPostal == undefined){
		resetDatosColonias();
		return false;
	}

	var sCodigoPostal = customTrim(nCodigoPostal.toString());

	resetDatosColonias();
	if(sCodigoPostal.length > 5){
		resetDatosColonias();
		return false;
        
	}

	if(sCodigoPostal.length < 5 || sCodigoPostal.length > 5){
        
		resetDatosColonias();
		return false;
      
	}
///// id el combo colonia
	$('#cmbColonia').prop('disabled', true);
    
	$.ajax({
		url			: './ws/buscaDatosCodigoPostal.php',
		type		: 'POST',
		dataType	: 'json',
		data		: {nCodigoPostal : nCodigoPostal}
	})
	.done(function(resp){
		if(resp.bExito == true){
			customLlenarComboColonia('cmbColonia', resp.data);
			customLlenarComboEstado('cmbEntidad', resp.data);
			customLlenarComboCiudad('cmbCiudad', resp.data);
            
            if(nIdColonia == undefined){}else{
                
              $('#cmbColonia').val(nIdColonia);  
            }
            

		}
	})
	.fail(function() {
	})
	.always(function() {
		$('#cmbColonia').prop('disabled', false);
	});
	
}


function resetDatosColonias(){
	customEmptyStore('cmbColonia');
	customEmptyStore('cmbEntidad');
	customEmptyStore('cmbCiudad');
}

function customLlenarComboEstado(id, data){
	customEmptyStore('cmbEntidad');
	var cmb		= document.getElementById(id);
	var option	= document.createElement("option");

	if(typeof option.textContent === 'undefined'){
		option.innerText = data[0].sDEstado;
	}
	else{
		option.textContent = data[0].sDEstado;
	}
	option.value	= data[0].nIdEstado;

	cmb.appendChild(option);
}

function customLlenarComboCiudad(id, data){
	customEmptyStore('cmbCiudad');
	var cmb		= document.getElementById(id);
	var option	= document.createElement("option");

	if(typeof option.textContent === 'undefined'){
		option.innerText = data[0].sDMunicipio;
	}
	else{
		option.textContent = data[0].sDMunicipio;
	}
	option.value	= data[0].nNumMunicipio;

	cmb.appendChild(option);
}

function customLlenarComboColonia(id, data){
	var data	= data;
	var length	= data.length;
	var cmb		= document.getElementById(id);

	customEmptyStore('cmbColonia');

	for(var i=0; i<length; i++){
		var option	= document.createElement("option");
		option.text	= data[i].sNombreColonia;

		if(typeof option.textContent === 'undefined'){
			option.innerText = data[i].sNombreColonia;
		}
		else{
			option.textContent = data[i].sNombreColonia;
		}
		option.value	= data[i].nIdColonia;

		cmb.appendChild(option);
	}
}



/////////////////////////////////////////////////////////////
function validaridsucursal(){
    var idsucursal = $('#txtNIdSucursal').val();
    $.post('./application/models/RE_SucursalValidarId.php',{idsucur:idsucursal},function(respuesta){
      
        if(respuesta.cuenta== 0){validartelsucursal();}else{showToastMsg('El Identificador de la sucursal  ya Existe', 'warning');}
    }, "json");
}

//////////////////////////////////////////////////////////////////
function validartelsucursal(){
    var telsucursal = $('#txtSTelefono').val();
    $.post('./application/models/RE_SucursalValidarTelefono.php',{telsucur:telsucursal},function(respuesta){
      
        if(respuesta.cuenta== 0){guardarSucursal();}else{showToastMsg('El Telefono ya ha sido registrado previamente', 'warning');}
    }, "json");
}
//////////////////////////////////////////////////////////


/////////////////////////////////////
function listadeaccesos(idcte){ 
	
	//$('#txtSRFC').val(idcte);
    
    $.post('./application/models/RE_ClienteAccesos.php',{idcte:idcte},function(respuesta){
        
      
         $('input[type=checkbox][name=nIdTipoAcceso]').prop('checked', false);
                var access = respuesta.accesos;
                var fams = respuesta.fams;
        validarcompDom = false;
        if(access == undefined){alert('no hay tipos de acceso configurado para este cliente');}else{
            for(var i=0; i< access.length; i++) {
                    $('input[type=checkbox][name=nIdTipoAcceso][value='+access[i]+']').prop('checked', true);
                }}
        
        
         if(fams == undefined){alert('no hay familias configuradas para este cliente');}else{   
            for(var i=0; i< fams.length; i++) {
                if(fams[i] == 3 || fams[i] == 5||fams[i] == 7){
                    
                    validarcompDom = true;
                }
                    
                }
         }
            
         
                
                    
        
        
    },"json");
                            
                            }

////////////////////////////////////////////////////
function initNuevaSucursal(){
	var CONTACTOS = new Array();
	var BCOMPROBANTEOBLIGATORIO = false;

	initVerMapa();

	initFormGeneral();
	initFormDireccion();
	initContactos();
	initInputFiles();
	initBtnGuardar();
}
	

////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////

	function initFormGeneral(){
		/*$('#txtSNombreCliente').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 150
		});*/

		$('#txtNIdSucursal').alphanum({
			//allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 10
		});

		$('#txtSNombreSucursal').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 50
		});

		$('#frmDatosGenerales :input[name=sNombre], #frmDatosGenerales :input[name=sPaterno], #frmDatosGenerales :input[name=sMaterno]').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: false,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 50
		});

		$('#cmbGiro').customLoadStore({
			url				: BASE_PATH + 'index.php/giro/combo',
			labelField		: 'nombreGiro',
			idField			: 'idGiro',
			firstItemId		: '-1',
			firstItemValue	: '--'
		});

		$('#txtSTelefono').alphanum({
			disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
			allow				: '()-',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: false,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 16
		});

		$('#txtSEmail').alphanum({
			'allow'				: '@.-_',
			allowSpace			: false,
			allowNumeric		: true,
			allowOtherCharSets	: false,
			maxLength			: 150
		});

	
	}


	function initFormDireccion(){
		$('#cmbPais').customLoadStore({
			url				: BASE_PATH + 'index.php/pais/combo',
			labelField		: 'nombre',
			idField			: 'idPais',
			firstItemId		: '-1',
			firstItemValue	: '--'
		});

		$('#cmbPais').on('load', function(e){
			$(e.target).val(164);
			$(e.target).trigger('change');
		});

		

		$('#txtNLatitud').numeric({
			allowThouSep		: false,
			maxDigits			: 44,
			maxDecimalPlaces	: 15,
			maxPreDecimalPlaces	: 18,
			max					: 99.999999999999999,
			min					: -99.999999999999999
		});
		$('#txtNLongitud').numeric({
			allowThouSep		: false,
			maxDigits			: 44,
			maxDecimalPlaces	: 15,
			maxPreDecimalPlaces	: 18,
			max					: 99.999999999999999,
			min					: -99.999999999999999
		});

		initInputsDireccion();

		$('#txtSCalle').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false
		});

		$('#txtNNumExterno').numeric({
			allowPlus			: false,
			allowMinus			: false,
			allowThouSep		: false,
			allowDecSep			: false,
			allowLeadingSpaces	: false,
			maxDigits			: 5,
			maxDecimalPlaces	: 0,
			maxPreDecimalPlaces	: 0
		});

		$('#txtNNumInterno').alphanum({
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 6
		});

		$('#txtNCodigoPostal').alphanum({
			disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 6
		});
	}

	function initInputsDireccion(){
		$('#txtSNombreColonia, #txtSNombreMunicipio, #txtSNombreEstado').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: false,
			allowNumeric		: false,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 50
		});
	}

	function showInputColonia(e){
		var nIdPais = e.target.value;
		$('#txtSNombreMunicipio, #txtSNombreEstado').prop('disabled', true);
		$('#txtNCodigoPostal').unbind('keyup');

		if(nIdPais == 164){
			var html = '<label class="">Colonia<span class="asterisco">*</span></label>';
			html += '<select class="form-control" name="nNumColonia" id="cmbColonia">';
			html += '<option>--</option>';
			html += '</select>';

			$('#div-colonia').html(html);
			initInputsDireccion();
			resetDir();
			if($('#txtNCodigoPostal').val() != ''){
				fillCmbColonia($('#txtNCodigoPostal').val());
				$('#txtNCodigoPostal').trigger('keyup');
			}
			$('#txtNCodigoPostal').on('keyup', function(e){
				var nCodigoPostal = e.target.value;
				var buscarColonias = false;

				if(nCodigoPostal != undefined && nCodigoPostal > 0){
					if(nCodigoPostal.charAt(0) == '0' && nCodigoPostal.length == 6){
						buscarColonias = true;
					}
					else if(nCodigoPostal.charAt(0) != '0' && nCodigoPostal.length == 5){
						buscarColonias = true;
					}
					else{
						resetDir();
					}
				}
				else{
					resetDir();
				}

				if(buscarColonias){
					fillCmbColonia(nCodigoPostal);
				}
			});

			$('#cmbColonia').unbind('load');
			$('#cmbColonia').on('load', function(e, lista){
				var oColonia = lista[0];

				if(oColonia != undefined){
					var nIdEstado		= lista[0].nIdEstado;
					var nNumMunicipio	= lista[0].nNumMunicipio;

					var sNombreEstado		= lista[0].sNombreEstado;
					var sNombreMunicipio	= lista[0].sNombreMunicipio;

					$('#txtSNombreMunicipio').val(sNombreMunicipio);
					$('#txtNNumMunicipio').val(nNumMunicipio);

					$('#txtSNombreEstado').val(sNombreEstado);
					$('#txtNIdEstado').val(nIdEstado);
				}
				else{
					resetDir();
				}
			});
		}
		if(nIdPais == 68){
			var html = '<label class="">Colonia<span class="asterisco">*</span></label>';
			html += '<input type="text" class="form-control" name="sNombreColonia" id="txtSNombreColonia">';
			$('#txtSNombreMunicipio, #txtSNombreEstado').prop('disabled', false);
			$('#div-colonia').html(html);
			initInputsDireccion();
			resetDir();
		}
	}




function armartrow(params){
		var numContactos	= CONTACTOS.length;
		var numContacto		= numContactos + 1;

		var trow = '<tr>';
		trow += '<td>' + params.sNombre + ' ';
		trow += params.sPaterno + ' ';
		trow += params.sMaterno + '</td>';

		var lblExt = '';
		if(params.sExtTelefono != undefined && myTrim(params.sExtTelefono) != ''){
			lblExt = ' - ' + params.sExtTelefono;
		}

		if(params.nIdContacto <= 0){
			params.nIdContacto = numContacto;
			CONTACTOS.push(params);
		}
		else{
			numContacto = params.nIdContacto;
		}
		trow += '<td align="center">'+ params.sTelefono + lblExt + '</td>';
		trow += '<td align="center">'+ params.sCelular +'</td>';
		trow += '<td align="center">'+ params.sEmail +'</td>';
		trow += '<td align="center">'+ params.sDescripcion +'</td>';
		trow += '<td align="center"><button class="btn btn-xs btn-info btnEditar">Editar</button> <button class="btn btn-xs btn-danger btnEliminar">Eliminar</button><input type="hidden" name="nIdContacto" value="'+numContacto+'"/></td>';
		trow += '</tr>';



		return trow;
	}

function initInputFiles(){
		$(':input[type=file]').unbind('change');
		$(':input[type=file]').on('change', function(e){
			var input		= e.target;
			var nIdTipoDoc	= input.getAttribute('idtipodoc');
			var file = $(input).prop('files')[0];
	
     
			var formdata = new FormData();
			formdata.append('sFile',file);
			formdata.append('nIdTipoDoc', nIdTipoDoc);
			formdata.append('nIdSucursal', $('#frmDatosGenerales :input[name=nIdSucursal]').val());
            formdata.append('usr',usr);
                
            if(file.type != 'application/pdf'){
				showToastMsg('El archivo debe ser formato pdf');
				return;
            }else{
				$.ajax({
					url			: './application/controllers/documentosSucursal.php',
					type		: 'POST',
					contentType	: false,
					data		: formdata,
					processData	: false,
					cache		: false,
					dataType	: 'json',
				})
				.done(function(resp){
					if(resp.idDocs > 0){
						
                        $(':input[type=hidden][idtipodoc='+nIdTipoDoc+']').val(resp.idDocs);
                        
                        showToastMsg('Documento Cargado Exitosamente!!');
					}
					else{
					   showToastMsg(resp.idDocs);	
					}
				})
				.fail(function(){
					showToastMsg('Error al Intentar Subir el Archivo');
				});
            }
			
		});
	}

function validarInformacionGeneral(){
		var params = $('#frmDatosGenerales').getSimpleParams();
         params.usuario = usr;
		if(params.sRFC == undefined || params.sRFC == ''){
			showToastMsg('Seleccione Cliente');
			return false;
		}

		if(params.nIdSucursal == undefined || params.nIdSucursal == ''){
			showToastMsg('Capture Identificador de Sucursal');
			return false;
		}
        
   
        
        //////
		params.nIdSucursal = $('#frmDatosGenerales :input[name=nIdSucursal]').val();

		if(params.sNombreSucursal == undefined || params.sNombreSucursal == ''){
			showToastMsg('Capture Nombre de Sucursal');
			return false;
		}
		else{
			params.sNombreSucursal = $('#frmDatosGenerales :input[name=sNombreSucursal]').val();

			if(params.sNombreSucursal.length < 3){
				showToastMsg('El nombre de la Sucursal es de 3 caracteres m\u00EDnimo');
				return false;
			}
			if(params.sNombreSucursal.length > 50){
				showToastMsg('El nombre de la Sucursal es de 50 caracteres m\u00E1ximo');
				return false;
			}
		}

		if(params.sEmail == undefined || params.sEmail == ''){
			showToastMsg('Capture Correo Electr\u00F3nico');
			return false;
		}
		else{
			params.sEmail = $('#frmDatosGenerales :input[name=sEmail]').val();
			if(params.sEmail.length > 150){
				showToastMsg('El Correo Electr\u00F3nico es de 150 caracteres m\u00E1ximo');
				return false;
			}
			if(!isValidEmail(params.sEmail)){
				showToastMsg('El Formato del Correo Electr\u00F3nico es incorrecto');
				return false;
			}
		}

		if(params.sTelefono == undefined || params.sTelefono == ''){
			showToastMsg('Capture Tel\u00E9fono');
			return false;
		}
		else{
			if(params.sTelefono.length != 16){
				showToastMsg('El Tel\u00E9fono debe ser de 10 d\u00EDgitos');
				return false;
			}
		}

		if(params.nIdGiro == undefined || params.nIdGiro <= 0){
			showToastMsg('Seleccione Giro');
			return false;
		}

		if(params.sNombre == undefined || params.sNombre == ''){
			showToastMsg('Capture Nombre');
			return false;
		}
		else{
			params.sNombre = $('#frmDatosGenerales :input[name=sNombre]').val();

			if(params.sNombre.length < 3){
				showToastMsg('El nombre del Responsable de la Sucursal es de 3 caracteres m\u00EDnimo');
				return false;
			}
			if(params.sNombre.length > 50){
				showToastMsg('El nombre del Responsable de la Sucursal es de 50 caracteres m\u00E1ximo');
				return false;
			}
		}

		if(params.sPaterno == undefined || params.sPaterno == ''){
			showToastMsg('Capture Apellido Paterno');
			return false;
		}
		else{
			params.sPaterno = $('#frmDatosGenerales :input[name=sPaterno]').val();

			if(params.sPaterno.length < 3){
				showToastMsg('El Aapellido Paterno del Responsable de la Sucursal es de 3 caracteres m\u00EDnimo');
				return false;
			}
			if(params.sPaterno.length > 50){
				showToastMsg('El Aapellido Paterno del Responsable de la Sucursal es de 50 caracteres m\u00E1ximo');
				return false;
			}
		}

		if(params.sMaterno == undefined || params.sMaterno == ''){
			showToastMsg('Capture Apellido Materno');
			return false;
		}
		else{
			params.sMaterno = $('#frmDatosGenerales :input[name=sMaterno]').val();

			if(params.sMaterno.length < 3){
				showToastMsg('El Apellido Materno del Responsable de la Sucursal es de 3 caracteres m\u00EDnimo');
				return false;
			}
			if(params.sMaterno.length > 50){
				showToastMsg('El Apellido Materno del Responsable de la Sucursal es de 50 caracteres m\u00E1ximo');
				return false;
			}
		}

		return params;
	}

function validarDireccion(){
		var params = $('#frmDireccion').getSimpleParams();
       
		if(params.nIdPais == undefined || params.nIdPais <= 0){
			showToastMsg('Seleccione Pa\u00EDs');
			return false;
		}

		if(params.sCalle == undefined || myTrim(params.sCalle) == ''){
			showToastMsg('La Calle de la Direcci\u00F3n es Obligatoria');
			return false;
		}
		params.sCalle = $('#frmDireccion :input[name=sCalle]').val();
        params.nidDocDom = $('#txtNIdDocDomicilios').val();

		if(params.nNumExterno == undefined || myTrim(params.nNumExterno) == ''){
			showToastMsg('El N\u00FAmero Externo de la Direcci\u00F3n es Obligatorio');
			return false;
		}

		if(params.nCodigoPostal == undefined || myTrim(params.nCodigoPostal) == ''){
			showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n es Obligatorio');
			return false;
		}
		else if(params.nCodigoPostal.length < 5 || params.nCodigoPostal.length > 6){
			showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n es de 5 ó 6 dígitos');
			return false;
		}

		if(params.nIdPais == 164){
			if(params.nNumColonia == undefined || myTrim(params.nNumColonia) == '' || params.nNumColonia <= 0){
				showToastMsg('Seleccione Colonia de la Direcci\u00F3n el Cliente', 'warning');
				return false;
			}

	
		}

		if(params.nIdPais == 68){
			if(params.sNombreColonia != undefined && params.sNombreColonia != ''){
				params.sNombreColonia = $('#frmDireccion :input[name=sNombreColonia]').val();
			}
			if(params.sNombreMunicipio == undefined || myTrim(params.sNombreMunicipio) == ''){
				showToastMsg('Capture el Nombre de la Ciudad de la Direcci\u00F3n del Cliente');
				return false;
			}
			params.sNombreMunicipio = $('#frmDireccion :input[name=sNombreMunicipio]').val();
			if(params.sNombreEstado == undefined || myTrim(params.sNombreEstado) == ''){
				showToastMsg('Capture el Nombre del Estado de la Direcci\u00F3n del Cliente');
				return false;
			}
			params.sNombreEstado = $('#frmDireccion :input[name=sNombreEstado]').val();
		}

		var fileComprobante = $('#frmDireccion :input[name=sFile]').prop('files')[0];
	
		if(validarcompDom == true){
            
			if(fileComprobante == undefined){
				showToastMsg('El Comprobante de Domicilio es Obligatorio');
				return false;
			}
		}
		else{
			params.nIdDocDomicilio = 0;
		}

		if(fileComprobante != undefined){
			if(fileComprobante.type != 'application/pdf'){
				showToastMsg('El archivo de Comprobante de Domicilio debe ser formato pdf');
				return false;
			}
		}

		return params;
	}

function validarTipoAcceso(){
		var lengthchk = $('#frmTipoAcceso :input[type=checkbox]:checked').length;

		if(lengthchk == undefined || lengthchk <= 0 || lengthchk == ''){
			showToastMsg('No se encontraro tipos de Acceso en el cliente seleccionado.');
			return false;
		}

		var params		={};
		var elementos	= $('#frmTipoAcceso :input[type=checkbox]:checked');
		var chk			= new Array();
		
		for(var i=0; i < elementos.length; i++){
			var nIdTipoAcceso = elementos[i].value;
			chk.push(nIdTipoAcceso);
		}

		params.arrTipoAccesos = chk.join(',');
		
		return params;
	}

function guardarSucursal(){
    
    
		var params1 = validarInformacionGeneral();
		if(!params1){
			return false;
		}
        
        
		var params2 = validarDireccion();
		if(!params2){
			return false;
		}

		var params3 = validarTipoAcceso();
		if(!params3){
			return false;
		}

		/*var params4 = validarContactos();
		f(!params4){
			return false;
		}*/
         var conf = confirm('Si afirma que todos los datos ingresados son verdaderos haga clic en aceptar');
		var params = Object.assign({}, params1, params2, params3/*,params4*/);
        var idsuc = $("#txtNIdSucursal").val();
        if(conf == true){
		      $.ajax({
			     url			: 'application/controllers/NuevaSucursal.php',
			     type		: 'POST',
			     dataType	: 'json',
			     data		: params,
		      })
		      .done(function(resp){
			  if(resp.registros == 1){
                  showToastMsg('La sucursal se  registró exitosamente');
                    editar(idsuc);
                    RefreshTable('#presubcadenas', "./application/models/SucursalRegistroDatatable.php");
              
              
              }else{}
		}) 
        
		.fail(function(){
			console.log("error");
		});
        
     }
       
		
	}

function datatablasucursales(){  
    
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/SucursalRegistroDatatable.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {
				return row[1];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {
				return row[2];
			},"aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) {
				return row[3];
				
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) {
				return row[4];
			}, "aTargets": [ 3 ] },
            //5a columna
			
			{ "mRender": function ( data, type, row ) {
                var rfcstr = row[3];
				var iconoEditar = "<a href='#' onclick='editar(\""+row[1]+"\",\""+row[4]+"\")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 4 ] },
            
            //6a columna
            
            { "mRender": function ( data, type, row ) {
                var rfcstr = row[3];
				var iconoEditar = "<a href='#' onclick='eliminarsucursal(\""+row[1]+"\");'><center><img src=\"../img/delete.png\" title='Editar'></center></a>";
				return iconoEditar;
                
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 5 ] },
          
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreSubCadenas.$('tr:odd').css( "background-color", "#D4DDED" );

		},
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
			$('td:eq(0)', nRow).addClass( "dataTableNombre" );
			$('td:eq(1)', nRow).addClass( "dataTableAvance" );
		},		
		"oLanguage": {
			"sLengthMenu": "Mostrar _MENU_ registros por p&aacute;gina.",
			"sZeroRecords": "No se encontr&oacute; ning&uacute;n resultado.",
			"sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros.",
			"sInfoEmpty": "Mostrando 0 de 0 de 0 registros.",
			"sInfoFiltered": "(filtrados de un total de _MAX_ registros)",
			"sSearch": "Buscar",
			"sProcessing": "Procesando..."
		}
	} );
        
   }

function eliminar(){
    
    alert('aqui va la funcion eliminar');
}

function editar(idsuc,rsoc){  
    
formcontactosreset(); 
$(".form-control2").prop('disabled',true);    
$(".contactos-input").prop('disabled',false);  
$("#btnGuardarSucursal").css('display','none'); 
 
    

    
   $.post('./application/models/RE_SucursalCargar.php',{idsucur:idsuc},function(resp){
        if(resp.idsuc == idsuc){
            
            $('#pannel1').css('display', 'block');
             $("#divcontactos").css('display','block');
            //datos generales
            $("#txtSNombreCliente").val(rsoc);
            $("#txtNIdSucursal").val(resp.identsuc);
            $("#txtSNombreSucursal").val(resp.nomsuc);
            $("#txtSEmail").val(resp.correo);
            $("#txtSTelefono").val(resp.telefono);
            $("#cmbGiro").val(resp.giro);
            $("#sNombre").val(resp.nombre);
            $("#sPaterno").val(resp.paterno);
            $("#sMaterno").val(resp.materno);
            //direccion
             $("#txtNLatitud").val(resp.latitud);
             $("#txtNLongitud").val(resp.longitud);
             $("#cmbPais").val(resp.idpais);
            $("#cmbPais").val(resp.idpais);
            $("#txtSCalle").val(resp.calle);
            $("#txtNNumExterno").val(resp.numext);
            $("#txtSNumInterno").val(resp.numint);
            $("#txtNCodigoPostal").val(resp.cp);
            $("#txtNIdDocDomicilios").val(resp.iddoc);
            // direccion nacional
                if(resp.idpais == 164){
                    
                    $(".dirnac").css('display','inline-block');
                    $(".dirext").css('display','none');
                    buscarColonias(resp.cp, resp.numcol);
                    
                    
                    
                }
            // direccion usa
                if(resp.idpais == 68){
                    
                    $(".dirnac").css('display','none');
                    $(".dirext").css('display','inline-block');
                    //divcontactos
                    $("#txtSNombreColonia").val(resp.nomcol);
                    $("#txtSNombreMunicipio").val(resp.nommun);
                    $("#txtSNombreEstado").val(resp.nomedo);
                    
                    
                }
            
            
            $('input[type=checkbox][name=nIdTipoAcceso]').prop('checked', false);
            var access = resp.accessos;
                for(var i=0; i< access.length; i++) {$('input[type=checkbox][name=nIdTipoAcceso][value='+access[i]+']').prop('checked', true);}
            
            
            actualizacontactos(resp.identsuc);
            
        }
        
    },"json");
    
}

function actualizacontactos(idsuc) {	
    		if (idsuc != "") {
        		$.post("./application/models/SucursalContactoLista.php", {idsuc: idsuc }, function(mensaje) {
            	$("#tables").html(mensaje); }); 
    		} else { ("#tables").html('no se mando ningun post');};
	}

function validacionescontactos(){ 
    
    // validaciones a ejecitar antes de  insertar y de actualizar.
            var nomcont        =    $('#txtSNombre').val();
            var paterno        =    $('#txtSPaterno').val();
            var materno        =    $('#txtsMaterno').val();
            var telefono       =    $('#sTelContacto').val();
            var extension      =    $('#sExtTelefono').val();
            var celular        =    $('#sMovilContacto').val();
            var mail           =    $('#txtsEmail').val();
            var descripcion    =    $('#txtsDescripcion').val();
            
            //var rfcs           =    $('#txtRFC').val();
    if(nomcont == '' || nomcont.length < 3 ){//validacion del nombre
        $().toastmessage('showToast', {
                   text		: "El Nombre del Contacto debe contener almenos 3 carácteres",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
        return false;
    }
    
   if(paterno == '' || paterno.length < 3){//validacion del apellido paterno
        $().toastmessage('showToast', {
                   text		: "El Apellido Paterno del Contacto debe contener almenos 3 carácteres",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
   if(materno !== '' & materno.length < 3){//validacion del apellido materno
        $().toastmessage('showToast', {
                   text		: "El Apellido Materno del Contacto debe contener almenos 3 carácteres",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
   if(telefono == '' || telefono.length < 16){//validacion del telefono
        $().toastmessage('showToast', {
                   text		: "Capture un número telefónico Válido",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
   if(celular == '' || celular.length < 16){//validacion del celular
        $().toastmessage('showToast', {
                   text		: "Capture un número de Celular Válido",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
    
    
    
   	if(mail == undefined || mail == ''){// validacion del correo electronico si  no se captura
            
			$().toastmessage('showToast', {
				text		: 'Debes Capturar un Correo',
				sticky		: false,
				position	: 'top-center',
				type		: 'warning'
			});
			return false;
		}
		else{
			
			if(mail.length > 150){ // validacion del largo del correo electronico
				$().toastmessage('showToast', {
					text		: 'La Longitud M\u00E1xima del Correo son 150 caracteres',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}

			if(!isValidEmail(mail)){ // validacion del formato del correo elctrónico
				$().toastmessage('showToast', {
					text		: 'El Formato del Correo es Inv\u00E1lido',
					sticky		: false,
					position	: 'top-center',
					type		: 'warning'
				});
				return false;
			}
		}
   if(descripcion !== '' & descripcion.length > 25){//validacion de la descricion
        $().toastmessage('showToast', {
                   text		: "La Longitud M\u00E1xima de la Decripción son 25 carácteres",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
    
   
    
}

function nuevocontacto(param){
    if( validacionescontactos() == false){return}
    crearcontacto(param);
}

function crearcontacto(param){
    
            var nomcont        =    $('#txtSNombre').val();
            var paterno        =    $('#txtSPaterno').val();
            var materno        =    $('#txtsMaterno').val();
            var telefono       =    $('#sTelContacto').val();
            var extension      =    $('#sExtTelefono').val();
            var celular        =    $('#sMovilContacto').val();
            var mail           =    $('#txtsEmail').val();
            var descripcion    =    $('#txtsDescripcion').val();
            var tipocont       =    1;
            var idsuc           =    $('#txtNIdSucursal').val();
     $.post( "./application/models/SucursalContactoNuevo.php",
                            { nom: nomcont, pat: paterno, mat: materno, tel: telefono, ext: extension, cel: celular, mail: mail, desc: descripcion, tipo: tipocont, idsuc: idsuc, usuario:usr},
	           function ( respuesta ) {
                     if ( respuesta.rows > 0 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Contacto fue creado Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(idsuc); 
                            formcontactosreset();    
                       } else {
                           $().toastmessage('showToast', {
                                 text		: "No se Hizo Ninguna Modificación",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
                            //formcontactosreset();
                                          }
                                }, "json");
}


function formcontactosreset(){
         document.getElementById("frmContactos").reset(); 
       $('.btn2').css('display','none');
     $('#btnAgregarContacto').css('display','inline-block');
      // $('#txtEmailContacto').prop('disabled', false);
      // $('#txtDescripcionContacto').prop('disabled', false);    
    
}

function eliminarcontacto(param){
    
  var r =   confirm("¿Desea Eliminar Este Contacto?");
            var idsuc         =    $('#txtNIdSucursal').val();
    if(r == true){
     $.post( "./application/models/SucursalContactoEliminar.php",
                            { idcont: param,idsuc:idsuc},
	           function ( respuesta ) {
                     if ( respuesta.rows > 0 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Registro del Contacto fue eliminado  Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(idsuc); 
                            formcontactosreset();    
                       } else {
                           $().toastmessage('showToast', {
                                 text		: "No se Hizo Ninguna Modificación",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
                            //formcontactosreset();
                                          }
                                }, "json");
    }
  
}

function llenaedicion(param,param2,param3,param4,param5,param6,param7,param8,param9){
        var telmask = "("+param5.substring(0,2)+") "+param5.substring(2,4)+"-"+param5.substring(4,6)+"-"+param5.substring(6,8)+"-"+param5.substring(8,10);
        var celmask = "("+param7.substring(0,2)+") "+param7.substring(2,4)+"-"+param7.substring(4,6)+"-"+param7.substring(6,8)+"-"+param7.substring(8,10);
    
     $('.btn2').css('display','inline-block');
     $('#btnAgregarContacto').css('display','none');
    
         $('#txtSNombre').val(param2);
          $('#txtSPaterno').val(param3);
          $('#txtsMaterno').val(param4);
          $('#sTelContacto').val(telmask);
          $('#sExtTelefono').val(param6);
          $('#sMovilContacto').val(celmask);
          $('#txtsEmail').val(param8);
          $('#txtsDescripcion').val(param9);
            //var tipocont       =    1;
           $('#nIdContacto').val(param);
    
}

function actualizarcontacto(){
           var nomcont        =    $('#txtSNombre').val();
            var paterno        =    $('#txtSPaterno').val();
            var materno        =    $('#txtsMaterno').val();
            var telefono       =    $('#sTelContacto').val();
            var extension      =    $('#sExtTelefono').val();
            var celular        =    $('#sMovilContacto').val();
            var mail           =    $('#txtsEmail').val();
            var descripcion    =    $('#txtsDescripcion').val();
            var tipocont       =    1;
            var idcont           =    $('#nIdContacto').val();
            var idsuc          =    $('#txtNIdSucursal').val();
     $.post( "./application/models/ProspectoContactoEditar.php",
                            { nom: nomcont, pat: paterno, mat: materno, tel: telefono, ext: extension, cel: celular, mail: mail, desc: descripcion, tipo: tipocont, idcont: idcont, usuario:usr},
	           function ( respuesta ) {
                     if ( respuesta.rows > 0 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Contacto se actualizó Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(idsuc); 
                            formcontactosreset();    
                       } else {
                           $().toastmessage('showToast', {
                                 text		: "No se Hizo Ninguna Modificación",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
                            //formcontactosreset();
                                          }
                                }, "json");
    
  
    
}

function editarcontacto(){
       if( validacionescontactos() == false){return}
    actualizarcontacto();
    
}

function iniciacaptura(){
    
    
    
     document.getElementById("frmDatosGenerales").reset(); 
     document.getElementById("frmDireccion").reset(); 
     document.getElementById("frmContactos").reset(); 
    document.getElementById("frmTipoAcceso").reset();
  
$('#pannel1').css('display', 'block');   
$("#divcontactos").css('display','none');    
 $(".form-control2").prop('disabled',false);    
$(".contactos-input").prop('disabled',false);  
$("#btnGuardarSucursal").css('display','block'); 
$("#txtNIdDocDomicilio").css('display','block'); 
    
}
function RefreshTable(tableId, urlData){
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();

    table.fnClearTable(this);

    for (var i=0; i<json.aaData.length; i++)
    {
      table.oApi._fnAddData(oSettings, json.aaData[i]);
    }

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
  });
    
}

function eliminarsucursal(idsucur){
     
    var r = confirm('¿Desea eliminar esta solicitud?');
   if(r == true){
        $.post('./application/models/sucursaleliminar.php',{idsuc:idsucur},function(resp){
        if(resp.recs == 0){
           showToastMsg('La Solicitud Ha sido eliminada  Exitosamente'); 
            iniciacaptura();
            RefreshTable('#presubcadenas', "./application/models/SucursalRegistroDatatable.php");
            $('#pannel1').css('display', 'none'); 
        }
        
    },"json");}
    
}

function verdocumento(iddoc){
    
    if(iddoc == '' || iddoc == 0 ){showToastMsg('No se ha seleccionado ningun archivo');}else{
    
    $.post('./application/models/DocumentosVer.php',{iddoc:iddoc},function(resp){
        if(!resp.ruta){showToastMsg('No Hay Documento para mostar');}else{verdocs(resp.ruta);}
    },"json");
    
    }
}

function verdocs(ruta){
    jQuery('#pdfdata').attr('data', 'pdfoutside.php?pdf='+ruta);
    
    $('#pdfvisor').css('display','block');
    

}

 // }
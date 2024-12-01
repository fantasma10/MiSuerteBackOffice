$(document).ready(function(){

   var cp = $('#txtNCodigoPostal').val();
   var Paiss = $('#cmbPais').val();
 
    direccionInputs();
    formatosiniciales();
    datatablasucursales();
    
   
    $("#formContactos").css('display','none');
    $('.ro').prop('disabled',true);
    $('#popupmap').css('display','none');
    $('#aMapa').on('click', function(e){$('#popupmap').css('display','block');  initMap(); });  
    $('#btnclosemap').click(function(){$('#popupmap').css('display','none');}); 
    $('#cmbPais').on('change', function(e){direccionInputs();});
    $('#btnAutorizarSolicitud').on('click', function(e){alert('La autorizacion de hará de forma automática via sistema');/*autorizarsolicitud();*/});
    $('#btnValidarSolicitud').on('click', function(e){valiarsolicitud();});
    
    
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


/////////////////////////////////////////////////////////
 function formatosiniciales(){
     
      $('#txtSTelefono, #sTelContacto, #sMovilContacto').mask('(00) 00-00-00-00');
     
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
		data		: {
			nCodigoPostal : sCodigoPostal
		}
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
		$('#txtSNombreCliente').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 150
		});

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

		$('#txtSNombreCliente').autocomplete({
			serviceUrl				: BASE_PATH + 'index.php/prospecto/autocomplete',
			type					: 'post',
			dataType				: 'json',
			/*showNoSuggestionNotice	: true,
			noSuggestionNotice		: 'No se encontraron coincidencias',*/
			onSearchStart			: function (query){
				$('#txtSRFC').val('');
			},
			onSelect				: function (suggestion){
				$('#txtSRFC').val(suggestion.data);
				obtenerListaTipoAcceso(suggestion.data);

				esComprobanteDomicilioObligatorio(suggestion.data);
			}
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



function initInputFiles(){
		$(':input[type=file]').unbind('change');
		$(':input[type=file]').on('change', function(e){
			var input		= e.target;
			var nIdTipoDoc	= input.getAttribute('idtipodoc');
			var file = $(input).prop('files')[0];
	
			/*if(file == undefined){
				showToastMsg('El archivo es Obligatorio');
				return false;
			}
			else if(file.type != 'application/pdf'){
				showToastMsg('El archivo debe ser formato pdf');
				return false;
			}*/

			var formdata = new FormData();
			formdata.append('sFile',file);
			formdata.append('nIdTipoDoc', nIdTipoDoc);
			formdata.append('nIdSucursal', $('#frmDatosGenerales :input[name=nIdSucursal]').val());

			Pace.track(function(){
				$.ajax({
					url			: BASE_PATH + 'index.php/documento/subirDocumentoSucursal',
					type		: 'POST',
					contentType	: false,
					data		: formdata,
					processData	: false,
					cache		: false,
					dataType	: 'json',
				})
				.done(function(resp){
					if(resp.bExito == false){
						showToastMsg(resp.sMensaje);
					}
					else{
						$(':input[type=hidden][idtipodoc='+nIdTipoDoc+']').val(resp.data.nIdDocumento);
					}
				})
				.fail(function(){
					showToastMsg('Error al Intentar Subir el Archivo');
				});
			});
		});
	}

function datatablasucursales(){  
    
    
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/SucursalAutorizarDatatable.php",
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
            //7a columna
            
            { "mRender": function ( data, type, row ) {
              var iconoRevisado = "";   
				
					if ( row[5] == 3 ||  row[5] == 1)  {
						iconoRevisado = "<center><img title=\"Solicitud Validada\" src=\"../../img/ico_revision2.png\"/></center>";
					} else {
						iconoRevisado = "<center><img title=\"Solicitud No Validada\" src=\"../../img/ico_revision1.png\"/></center>";
					}
				
				return iconoRevisado;
			
            }, "bSortable": false, "aTargets": [ 6 ] },
            
            //8a columna
            
            { "mRender": function ( data, type, row ) {
              var iconoRevisado1 = "";
				
					if ( row[5] == 0 ) {
						iconoRevisado1 = "<center><img title=\"Solicitud Autorizada\" src=\"../../img/ico_revision2.png\"/></center>";
					} else {
						iconoRevisado1 = "<center><img title=\"Solicitud por Autorizar\" src=\"../../img/ico_revision1.png\"/></center>";
					}
				
				return iconoRevisado1;
            }, "bSortable": false, "aTargets": [ 7 ] },
            
            
            
          
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

function editar(idsuc,rsoc){  
    

$(".form-control2").prop('disabled',true);    
$(".contactos-input").prop('disabled',false);  
$("#btnGuardarSucursal").css('display','none'); 
$("#txtNIdDocDomicilio").css('display','none'); 
    

    
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
                    buscarColonias(resp.cp, resp.numcol);/// aqui esta la chamba pendiente
                    
                    
                    
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
            botonesvisibles(resp.idestatus);
           
            
        }
        
    },"json");
    
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

function actualizacontactos(idsuc) {	
    
    		if (idsuc != "") {
        		$.post("./application/models/SucursalContactoLista.php", {idsuc: idsuc }, function(mensaje) {
            	$("#tables").html(mensaje); }); 
    		} else { ("#tables").html('no se mando ningun post');};
	}

function valiarsolicitud(){
    var idsuc = $('#txtNIdSucursal').val();
    
     var conf = confirm('¿Confirma que toda la información ingresada es correcta?');
    if(conf == true){
    $.post('./application/models/sucursaValidar.php',{idsuc:idsuc},function(resp){
        if(resp.recs == 1){validado();}else{showToastMsg('La sucursal no pudo ser validada.');}
        
    },"json");
    
    }
}
function autorizarsolicitud(){
    
      var idsuc = $('#txtNIdSucursal').val();
    
     var confi = confirm('¿Confirma la autorizacion de la Sucursal?');
    if(confi == true){
    $.post('./application/models/sucursaAutorizar.php',{idsuc:idsuc},function(resp){
        
        if(resp.recs == 1){autorizado();}else{showToastMsg('La sucursal no pudo ser utorizada.');}
    },"json");
    }
}

function validado(){ 
    $('#pannel1').css('display', 'none');
    $('#btnAutorizarSolicitud').css('display','inline');
    $('#btnValidarSolicitud').css('display','none');
    
    RefreshTable('#presubcadenas', "./application/models/SucursalRegistroDatatable.php");
}

function autorizado(){
    $('#pannel1').css('display', 'none');
      $('#btnAutorizarSolicitud').css('display','none');
    $('#btnValidarSolicitud').css('display','none');
    RefreshTable('#presubcadenas', "./application/models/SucursalRegistroDatatable.php");
}

function botonesvisibles(idstatus){
    
    if(idstatus == 2){
        $('#btnAutorizarSolicitud').css('display','none');
        $('#btnValidarSolicitud').css('display','inline');  
    }else if(idstatus == 3){
        $('#btnAutorizarSolicitud').css('display','inline');
        $('#btnValidarSolicitud').css('display','none');
    }else if(idstatus == 0){
        $('#btnAutorizarSolicitud').css('display','none');
        $('#btnValidarSolicitud').css('display','none');
    }
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
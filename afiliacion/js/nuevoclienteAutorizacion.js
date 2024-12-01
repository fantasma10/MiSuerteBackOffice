$(document).ready(function(){  

    if(est == 1 || est == 3){  $(".btnini").css('display','inline');}
    
    if(est == 1){ $("#btnAutorizarSolicitud").css('display','none');$("#btnReenviarReferencia").css('display','none') }
    if(est == 3){$("#btnValidarSolicitud").css('display','none')}
    
    $("#btnValidarSolicitud").click(function(){validarSolicitud(); });
    
     $("#btnAutorizarSolicitud").click(function(){autorizarSolicitud();});
    $("#btnReenviarReferencia").click(function(){
        var rfc = $('#txtRFC').val();
       
       $.post('./application/models/ProspectoReferencia.php',{rfc:rfc},function(resp){
           if(!resp.mail){showToastMsg('No Hay ningun correo de destino registrado', 'warning');}else{ renviarcorreo(resp.mail, resp.razon, resp.referencia);}
           
       },"json");
        
       
    
    });
    //btnReenviarReferencia
    
    
    $(".form-control").attr("disabled","true");
    $(".ro").attr("disabled","true");
    $('.ro').prop('disabled', true);
    $(".hidess").css("display","none");
    $("#btneditar").css("display","none");
    $("#btneliminar").css("display","none");
    
    //input:checkbox

    actualizacontactos(incre);
    initFormDatosGenerales();
    datosInicial(incre);
    
    setTimeout(function(){llenaDatosEdicion();},500);
    
    
   
    
     $('#btnFileCompDom').click(function(){ var doc = $('#txtIdDocDomicilio').val();verdocumento(doc);});//rfc prospecto
    $('#btnFileRfc').click(function(){ var doc = $('#txtIdDocRFC').val();verdocumento(doc);});//Domicilio prospecto
    $('#btnFileActa').click(function(){ var doc = $('#txtIdDocActaConstitutiva').val();verdocumento(doc);});//acta prospecto
    $('#btnFileEdocta').click(function(){ var doc = $('#txtNIdDocEstadoCuenta').val();verdocumento(doc);});//EDOCTA prospecto
    $('#btnFileIdRL').click(function(){ var doc = $('#txtNIdDocIdentificacion').val();verdocumento(doc);});//ID RL prospecto
    $('#btnFilePoderRL').click(function(){ var doc = $('#txtNIdDocPoder').val();verdocumento(doc);});//podr RL prospecto
    
    $('#closepdf').click(function(){$('#pdfvisor').css('display','none')});
    
    
    
      $('#btnVerListas').click(function(){mostrarlistas();mostrarlistasProspecto();});
}); 

///////////////////////////////////////////////////
/////algunas variables//////////////////////
////////////////////////////////////////////
var rfcpros = $("#txtRFC").val();
var referenciaBancaria = 0;
var razonsocial = ' ';
var correo = ' ';
var famsarr = [0];
var familiasarr = '';
 var cuentafams = 0;

 

///////////////////////////////////////////////

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
			formdata.append('sRFC', datos_cliente.sRFC);

		
				$.ajax({
					url			: BASE_PATH + 'index.php/documento/subirDocumento',
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
	}  

////////////////////////////////////////////

function validarn(e) { // 1  mandar esta funcion a las funciones comunes
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	 if (tecla==9) return true; // 3
	 if (tecla==11) return true; // 3
    patron = /[A-Za-zñÑ'áéíóúÁÉÍÓÚüÜ\s\t]/; // 4
 
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 

function datosInicial(increm){
    
     $.post( "./application/models/ProspLlenadoIniciar.php",
             { incr: increm },
	           function ( respuesta ) {
                 
                    $('#txtRFC').val(respuesta.rfc);
                    $('#cmbRegimen').val(respuesta.idregimen);
         
            consultaforelo(respuesta.rfc ,est);
		           
            }, "json");  
    
}

////////////////////////////////////////////////////

var nCodigoPostal			= 0;
		var nIdColonia				= 0;
		var nIdEntidad				= 0;
		var nIdCiudad				= 0;
		var nIdPais					= 0;

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
//////////////////////////////////////////////////////////////////////
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
		$('#cmbColonia').prop('disabled', true);
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

////////////////////////////////////////////////////////////////////////////////////////////////
function buscarColoniasRL(nCodigoPostal, nIdColonia){
	if(nCodigoPostal == undefined){
		resetDatosColoniasRL();
		return false;
	}

	var sCodigoPostal = customTrim(nCodigoPostal.toString());

	resetDatosColoniasRL();
	if(sCodigoPostal.length > 5){
		resetDatosColoniasRL();
		return false;
	}

	if(sCodigoPostal.length < 5 || sCodigoPostal.length > 5){
		resetDatosColoniasRL();
		return false;
	}
///// id el combo colonia
	$('#cmbColoniaRepresentante').prop('disabled', true);
    
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
			customLlenarComboColoniaRL('cmbColoniaRepresentante', resp.data);
			customLlenarComboEstadoRL('txtSEstadoRepresentante', resp.data);
			customLlenarComboCiudadRL('txtSMunicipioRepresentante', resp.data);

            
            if(nIdColonia !== undefined){
                
                 $('#cmbColoniaRepresentante').val(nIdColonia);
            }
		}
	})
	.fail(function() {
	})
	.always(function() {
		$('#cmbColoniaRepresentante').prop('disabled', true);
	});
	
}

function resetDatosColoniasRL(){
	customEmptyStore('cmbColoniaRepresentante');
	customEmptyStore('txtSEstadoRepresentante');
	customEmptyStore('txtSMunicipioRepresentante');
}

function customLlenarComboEstadoRL(id, data){
	customEmptyStore('txtSEstadoRepresentante');
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

function customLlenarComboCiudadRL(id, data){
	customEmptyStore('txtSMunicipioRepresentante');
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
function customLlenarComboColoniaRL(id, data){
	var data	= data;
	var length	= data.length;
	var cmb		= document.getElementById(id);

	customEmptyStore('cmbColoniaRepresentante');

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
//////////////////////////////////////////////////////////////////////////

function datosbancarios(sCLABE){
    
    var cuenta	= sCLABE.substring(6,17)
    if(sCLABE.length == 18){
    
      $.post( "./application/models/RE_Banco.php",
             { clabe: sCLABE },
	           function ( respuesta ) {
                     
		           if ( respuesta.records == 1) {//idincr
                       //alert("debe de funcionar");
                      $("select[id='cmbBanco'] option").remove();
                       $('#cmbBanco').append("<option value= '"+respuesta.idbanco+"' selected>"+respuesta.nombrebanco+"</option>");
		              $("#txtCuenta").val(cuenta);                              
                 } else {
                      $("select[id='cmbBanco'] option").remove();
                       $('#cmbBanco').append("<option value= '-1' selected>--</option>");  
                     $("#txtCuenta").val(""); 
                     $().toastmessage('showToast', {
                        text		: "la CLABE no es correcta",
				        sticky		: false,
				        position	: 'top-center',
				        type		: 'warning'
                    }); 
                 }
            }, "json");
    }else{
        
        $().toastmessage('showToast', {
            text		: "Capture una CLABE de 18 dígitos",
			sticky		: false,
			position	: 'top-center',
			type		: 'warning'
           }); 
    }
}
function initFormDatosGenerales(){
//txtFechaNacimientoRepresentante
    
    $('#txtTelefono').mask('(00) 00-00-00-00');
    $('#txtTelefonoContacto').mask('(00) 00-00-00-00');
    $('#txtTelefonoMovilContacto').mask('(00) 00-00-00-00');
	$('#txtTelefonoRepresentante').mask('(00) 00-00-00-00');	

		

	
		 //$('#txtFechaNacimiento, #txtFechaConstitutiva').datepicker(); 

		

	

	

		$('#txtSCadena').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false
		});

		$('.fisico').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC',
			allowSpace			: true,
			allowNumeric		: false,
			allowUpper			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 50
		});

		$('#txtRazonSocial, #txtNombreComercial').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1\u00FC\u00DC\u0026\u002C\u002E',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxLength			: 150
		});

		$('#txtTelefono').alphanum({
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

		$('#txtTelefono').mask('(00) 00-00-00-00');

		$('#txtEmail').alphanum({
			'allow'				: '@.-_',
			allowSpace			: false,
			allowNumeric		: true,
			allowOtherCharSets	: false,
			maxLength			: 150
		});

		

		$('#txtSCadena').autocomplete({
			serviceUrl				: './application/models/RE_Cadena.php',
			type					: 'post',
			dataType				: 'json',
			/*showNoSuggestionNotice	: true,
			noSuggestionNotice		: 'No se encontraron coincidencias',*/
			onSearchStart			: function (query) {
				$('#txtIdCadena').val('');
			},
			onSelect				: function (suggestion) {
				$('#txtIdCadena').val(suggestion.data);
			}
		});
	}

function actualizacontactos(idincrmental) {
    		
    		if (idincrmental != "") {
        		$.post("./application/models/RE_ContactoLista.php", {increm: idincrmental }, function(mensaje) {
            	$("#tables").html(mensaje); }); 
    		} else { ("#tables").html('no se mando ningun post');};
	}

////////////////////////////////////////////////////////////////////////////////////////////////////

function toasts(mensaje){
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
}

//////////////////////////////////////////////////

var  repleg = false;

function cargarListaFamilias(){
    
		$('#div-familias :input[type=checkbox]').unbind('click');
		$('#div-familias :input[type=checkbox]').on('click', function(e){
			var mostrarrep	= false;
			var array_chk	= $('#div-familias :input[type=checkbox]');
			var i			= 0;

			for(i=0; i<array_chk.length; i++){
				var item = array_chk[i];

				if($(item).is(':checked') && (item.value == 3 || item.value == 5 || item.value == 7)){
					mostrarrep = true;
                    repleg = true;
                }
			}

			if(mostrarrep == true){
		
                $("#div-representanteLegal").css('display','block');
			}
			else{
				if(mostrarrep == false){
                    repleg = false;
					if($('#div-representanteLegal').length > 0){
					
                        $("#div-representanteLegal").css('display','none');
					}
				}
			}
			
		});
		
	}
/////////////////////////////////////////////////////////////////////////////////////////////
function validarRepresentanteLegal(){
	var nIdPais		= idpaisvar;
	var nIdRegimen	= idregimenvar;

	var params7 = $('#formRepresentanteLegal').getSimpleParams();

	if(params7.sNombreRepresentante == undefined || myTrim(params7.sNombreRepresentante) == ''){
		showToastMsg('Captura Nombre del Representante Legal', 'warning');
		return false;
	}
	else if(params7.sNombreRepresentante.length < 3){
		showToastMsg('La Longitud M\u00EDnima para el Nombre del Representante Legal es de 3 caracteres');
		return false;
	}
	else if(params7.sNombreRepresentante.length > 50){
		showToastMsg('La Longitud M\u00E1xima para el Nombre del Representante Legal es de 50 caracteres');
		return false;
	}
	params7.sNombreRepresentante = $('#formRepresentanteLegal :input[name=sNombreRepresentante]').val();

	if(params7.sPaternoRepresentante == undefined || myTrim(params7.sPaternoRepresentante) == ''){
		showToastMsg('Captura Apellido Paterno del Representante Legal', 'warning');
		return false;
	}
	else if(params7.sPaternoRepresentante.length < 3){
		showToastMsg('La Longitud M\u00EDnima para el Apellido Paterno del Representante Legal es de 3 caracteres');
		return false;
	}
	else if(params7.sPaternoRepresentante.length > 50){
		showToastMsg('La Longitud M\u00E1xima para el Apellido Paterno del Representante Legal es de 50 caracteres');
		return false;
	}
	params7.sPaternoRepresentante = $('#formRepresentanteLegal :input[name=sPaternoRepresentante]').val();

	if(params7.sMaternoRepresentante != undefined && myTrim(params7.sMaternoRepresentante) != ''){
		if(params7.sMaternoRepresentante.length < 3){
			showToastMsg('La Longitud M\u00EDnima para el Apellido Materno del Representante Legal es de 3 caracteres');
			return false;
		}
		else if(params7.sMaternoRepresentante.length > 50){
			showToastMsg('La Longitud M\u00E1xima para el Apellido Materno del Representante Legal es de 50 caracteres');
			return false;
		}
	}
	params7.sMaternoRepresentante = $('#formRepresentanteLegal :input[name=sMaternoRepresentante]').val();

	if(params7.dFechaNacimientoRepresentante == undefined || params7.dFechaNacimientoRepresentante == ''){
		showToastMsg('Selecciona Fecha de Nacimiento del Representante Legal');
		return false;
	}
	if((nIdPais == 164 && calcular_edad(params7.dFechaNacimientoRepresentante) < 18) ||(nIdPais == 68 && calcular_edad(params7.dFechaNacimientoRepresentante) < 21)){
		showToastMsg('El Representante Legal debe ser Mayor de Edad');
		return false;
	}

	if(params7.nIdNacionalidadRepresentante == undefined || params7.nIdNacionalidadRepresentante == '' || params7.nIdNacionalidadRepresentante <= 0){
		showToastMsg('Selecciona la Nacionalidad del Representante Legal');
		return false;
	}

	if(params7.sRFCRepresentante == undefined || myTrim(params7.sRFCRepresentante) == ''){
		showToastMsg('Captura RFC del Representante Legal', 'warning');
		return false;
	}
	else{
		//if(nIdPais == 164){
			if(!isValidRFC(params7.sRFCRepresentante.toUpperCase())){
				showToastMsg('El Formato del RFC es Inv\u00E1lido', 'warning');
				return false;
			}
		/*}
		else if(nIdPais == 68){
			if(params7.sRFCRepresentante.length == 11 || params7.sRFCRepresentante.length == 10){
				if(params7.sRFCRepresentante.length == 10){
					$('#txtRFCRepresentante').mask('00-0000000');
				}
				else if(params7.sRFCRepresentante.length == 11){
					$('#txtRFCRepresentante').mask('000-00-0000');
				}
				if(!isValidTINEIN(params7.sRFCRepresentante)){
					showToastMsg('El Formato del TIN es Inv\u00E1lido', warning);
					return false;
				}
			}
			else{
				showToastMsg('La Longitud de RFC es Inv\u00E1lida', 'warning');
				return false;
			}
		}*/
	}

	if(params7.sCURPRepresentante == undefined || myTrim(params7.sCURPRepresentante) == ''){
		showToastMsg('Captura CURP del Representante Legal');
		return false;
	}
	else{
		if(params7.sCURPRepresentante.length != 18){
			showToastMsg('Captura CURP del Representante Legal');
			return false;
		}
	}

	if(params7.nIdTipoIdentificacionRepresentante == -1){
		showToastMsg('Selecciona Tipo de Identificaci\u00F3n del Representante Legal');
		return false;
	}

	if(params7.sNumeroIdentificacionRepresentante == undefined || params7.sNumeroIdentificacionRepresentante == ''){
		showToastMsg('Capture N\u00FAmero de identificaci\u00F3n del Representante Legal');
		return false;
	}
	else{
		var showmsg = false;
		if(nIdPais == 164){
			if(params7.nIdTipoIdentificacionRepresentante == 1 && !validarFormatoIFE(params7.sNumeroIdentificacionRepresentante)){
				showmsg = true;
			}
			if(params7.nIdTipoIdentificacionRepresentante == 2 && !validarFormatoCartillaMilitar(params7.sNumeroIdentificacionRepresentante)){
				showmsg = true;
			}
			if(params7.nIdTipoIdentificacionRepresentante == 3 && !validarFormatoPasaporte(params7.sNumeroIdentificacionRepresentante)){
				showmsg = true;
			}
			if(params7.nIdTipoIdentificacionRepresentante == 4 && !validarFormatoCedulaProfesional(params7.sNumeroIdentificacionRepresentante)){
				showmsg = true;
			}

		}
		else{
			if(!validarEntero(params7.sNumeroIdentificacionRepresentante)){
				showmsg = true;
			}
		}
		if(showmsg){
			showToastMsg('El Formato del N\u00FAmero de identificaci\u00F3n es Incorrecto');
			return false;
		}
	}	

	if(params7.sTelefonoRepresentante == undefined || params7.sTelefonoRepresentante == ''){
		showToastMsg('Captura Tel\u00E9fono del Representante Legal');
		return false;
	}
	else{
		params7.sTelefonoRepresentante = soloNumeros(params7.sTelefonoRepresentante);
		if(params7.sTelefonoRepresentante.length != 10){
			showToastMsg('La longitud del Tel\u00E9fono del Representante Legal debe ser de 10 d\u00EDgitos.');
			return false;
		}
	}

	if(params7.sEmailRepresentante == undefined || params7.sEmailRepresentante == ''){
		showToastMsg('Captura Correo Electr\u00F3nico del Representante Legal');
		return false;
	}
	else{
		params7.sEmailRepresentante = $('#formRepresentanteLegal :input[name=sEmailRepresentante]').val();
		if(params7.sEmailRepresentante.length > 150){
			showToastMsg('El Correo Electr\u00F3nico del Representante Legal ser de M\u00E1ximo 150 caracteres');
			return false;
		}
		else if(!isValidEmail(params7.sEmailRepresentante)){
			showToastMsg('El formato del Correo Electr\u00F3nico del Representante Legal es Inv\u00E1lido', 'warning');
			return false;
		}
	}

	if(params7.sCalleRepresentante == undefined || myTrim(params7.sCalleRepresentante) == ''){
		showToastMsg('La Calle de la Direcci\u00F3n del Representante Legal es Obligatoria');
		return false;
	}

	if(params7.sNumExtRepresentante == undefined || myTrim(params7.sNumExtRepresentante) == ''){
		showToastMsg('El N\u00FAmero Externo de la Direcci\u00F3n del Representante Legal es Obligatorio');
		return false;
	}

	if(params7.nCodigoPostalRepresentante == undefined || myTrim(params7.nCodigoPostalRepresentante) == ''){
		showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n del Representante Legal es Obligatorio');
		return false;
	}
	else if(params7.nCodigoPostalRepresentante.length < 5 || params7.nCodigoPostalRepresentante.length > 6){
		showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n del Representante Legal es de 5 ó 6 dígitos');
		return false;
	}

	if(nIdPais == 164){
		if(params7.nNumColoniaRepresentante == undefined || myTrim(params7.nNumColoniaRepresentante) == '' || params7.nNumColoniaRepresentante <= 0){
			showToastMsg('Seleccione Colonia de la Direcci\u00F3n del Representante Legal', 'warning');
			return false;
		}

	
	}

	if(nIdPais == 68){
		if(params7.sMunicipioRepresentante == undefined || myTrim(params7.sMunicipioRepresentante) == ''){
			showToastMsg('Capture el Nombre de la Ciudad de la Direcci\u00F3n del Representante Legal');
			return false;
		}
		if(params7.sEstadoRepresentante == undefined || myTrim(params7.sEstadoRepresentante) == ''){
			showToastMsg('Capture el Nombre del Estado de la Direcci\u00F3n del Representante Legal');
			return false;
		}
	}

	if(params7.nIdOcupacionRepresentante == -1 ){
		showToastMsg('Seleccione Ocuapaci\u00F3n del Representante Legal');
		return false;
	}

	var fileRFCRepresentante = $('#formRepresentanteLegal :input[name=sFileIdentificacionRepresentante]').prop('files')[0];

	if(fileRFCRepresentante == undefined){
		showToastMsg('El archivo de Identificaci\u00F3n del Representante Legal es Obligatorio');
		return false;
	}
	else if(fileRFCRepresentante.type != 'application/pdf'){
		showToastMsg('El archivo de Identificaci\u00F3n del Representante Legal debe ser formato pdf');
		return false;
	}

	var sFilePoderRepresentanteLegal = $('#formRepresentanteLegal :input[name=sFilePoderRepresentanteLegal]').prop('files')[0];

	if(sFilePoderRepresentanteLegal != undefined){
		if(sFilePoderRepresentanteLegal.type != 'application/pdf'){
			showToastMsg('El archivo de Poder del Representante Legal debe ser formato pdf');
			return false;
		}
	}

    //FORM_DATA = new FormData();
    
      
       var nombreRep = $('#txtNombreRepresentante').val();
        var paternoRep = $('#txtPaternoRepresentante').val();
        var maternoRep = $('#txtMaternoRepresentante').val();
        var callerep = $('#txtCalleRepresentante').val();

        //FORM_DATA = new FormData();
        FORM_DATA.append('sNomReps',nombreRep);
        FORM_DATA.append('sPatReps',paternoRep);
        FORM_DATA.append('sMatReps',maternoRep);
        FORM_DATA.append('sCalleReps',callerep);
    
    
    
    
	FORM_DATA.append('fileRFCRepresentante',fileRFCRepresentante);	
	FORM_DATA.append('sFilePoderRepresentanteLegal',sFilePoderRepresentanteLegal);	

	for(i in params7){
		FORM_DATA.append(i, params7[i]);
	}

	//params7 = data;
	return true;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////

function llenaDatosEdicion(){
    var rfcssss = $("#txtRFC").val();
     
       
          $.post( "./application/models/CargarDatosGenerales.php",
                                    { rfc: rfcssss },
	                                   function ( respuesta ) {
                     
		                                     
                                                $('#txtIdCadena').val(respuesta.idcad);
                                                $('#txtSCadena').val(respuesta.nomcad);
                                                $('#cmbSocio').val(respuesta.idsoc);
              
                                        if(idregimenvar == 1){
                                               
                                                  $('#nombrefisico').val(respuesta.nombre);
                                                  $('#sPaternoCliente').val(respuesta.paterno);
                                                  $('#sMaternoCliente').val(respuesta.materno);
                                            
                                            
                                            //informacion especial persona fisica
                                                  $('#txtPoliticamenteExpuesto').val(respuesta.polexp1);
                                                  $('#txtFechaNacimiento').val(respuesta.fechanacim);
                                                  $('#txtNumeroIdentificacion').val(respuesta.numidentif);
                                                  $('#txtCURP').val(respuesta.curp);
                                                  $('#cmbIdTipoIdentificacion').val(respuesta.tipoid);
                                                  $('#cmbIdPaisNacimiento').val(respuesta.idpaisnac);
                                                  $('#cmbIdNacionalidad').val(respuesta.idnacion);
                                            
                                               if(respuesta.polexp1 == 1){
                                                
                                                $('#txtPoliticamenteExpuesto').prop('checked', true);
                                            }
                                               
                                        }
              
              
                                         if(idregimenvar == 2){
                                               
                                                                                       
                                            
                                            //informacion especial persona moral
                                                  
                                                  $('#chkPoliticamenteExpuesto').val(respuesta.polexp2);
                                                  $('#cmbIdTipoSociedad').val(respuesta.tiposoc);
                                                  $('#txtFechaConstitutiva').val(respuesta.fechconst);
                                                  $('#txtIdDocActaConstitutiva').val(respuesta.actconst);
                                             
                                               if(respuesta.polexp2 == 1){
                                                    
                                                    $('#chkPoliticamenteExpuesto').prop('checked', true);
                                                    
                                                }
                                            
                                               
                                        }
                                    
                                                $('#cmbGiro').val(respuesta.idgiro);
                                                $('#txtRazonSocial').val(respuesta.razonSoc);
                                                $('#txtNombreComercial').val(respuesta.nomComer);
                                                $('#txtTelefono').val(respuesta.telefono); 
                                                $('#txtEmail').val(respuesta.correo);
                                                $('#cmbEjecutivoCuenta').val(respuesta.ejecutivo);
                                                $('#txtCalle').val(respuesta.calle);
                                                $('#txtNumExterno').val(respuesta.externo);
                                                $('#txtNumInterno').val(respuesta.interno);
                                                ///$('#txtCodigoPostal').val(respuesta.cp);
              
                                                $('#txtCLABE').val(respuesta.clabe);
                                                $('#cmbBanco').val(respuesta.banco);
                                                $('#txtCuenta').val(respuesta.cuenta);
                                                $('#txtBeneficiario').val(respuesta.benefi);
                                                $('#txtDescripcion').val(respuesta.descrip);
              
              
                                                $('#txtIdPaquete').val(respuesta.idpaquete);
                                                $('#txtInscripcionCliente').val(respuesta.incripcion);
                                                $('#txtAfiliacionSucursal').val(respuesta.afiliacion);
                                                $('#txtRentaSucursal').val(respuesta.renta);
              
                                                $('#txtAnualSucursal').val(respuesta.anual);
                                                $('#txtLimiteSucursales').val(respuesta.sucursales);
                                                $('#txtDFechaInicio').val(respuesta.finicio);
                                                $('#txtFechaVencimiento').val(respuesta.fvencim);
                                                $('#txtBPromocion').val(respuesta.promo);
              
                                                $('#txtIdDocDomicilio').val(respuesta.idcdom);
                                                $('#txtIdDocRFC').val(respuesta.idrfc);
                                                $('#txtNIdDocEstadoCuenta').val(respuesta.idedocta);
              
                                        if(idpaisvar == 164){
                                          var codPost = respuesta.cp;
                                            
                                         
                                              if(codPost.length== 4){
                                                var codpostal = '0'+codPost
                                                  
                                               
                                              } else{codpostal = respuesta.cp}
                                          $('#txtCodigoPostal').val(codpostal);
                                           buscarColonias(codpostal, respuesta.numcolonia);  
                                        } else {
                                            
                                                $('#txtColonia').val(respuesta.colext);
                                                $('#txtMunicipio').val(respuesta.monext);
                                                $('#txtEstado').val(respuesta.edoext);
                                            $('#txtCodigoPostal').val(respuesta.cp);
                                            
                                        }
                                               
                                          datosbancarios(respuesta.clabe); 
                                        
                var fams = respuesta.familias;
               
                var datsRL = false;
                for(var i=0; i< fams.length; i++) {
                    cuentafams = parseInt(cuentafams) + parseInt(fams[i]) ;
                $('input[type=checkbox][name=nIdFamilia][value='+fams[i]+']').prop('checked', true);
                 if(fams[i] == 3 || fams[i] == 5  ||fams[i] == 7) { datsRL = true;}  // para mostrar  o esconder los datos del RL                              
                                                  
                }
              
              console.log('cuentafamilias: '+cuentafams);
                var access = respuesta.accesos;
                for(var i=0; i< access.length; i++) {$('input[type=checkbox][name=nIdTipoAcceso][value='+access[i]+']').prop('checked', true);}
                var perfils = respuesta.perfil;
                $('input[type=radio][name=nIdPerfil][value='+perfils+']').prop('checked', true); 
              
                 $('#comboVersiones').val(respuesta.version);
              
              //informacion liquidacion
              
                $('#comboReembolso').val(respuesta.tiporeemb);
                $('#comboComisiones').val(respuesta.tipocom);
                $('#comboLiqReembolso').val(respuesta.liqreemb);
                $('#comboLiqComisiones').val(respuesta.liqcom);
              
              /// mostrar datos del RL
              if(datsRL){ $("#div-representanteLegal").css('display','block'); }
              
                            //info de datos  del represntante legal
                                                $('#txtNombreRepresentante').val(respuesta.nombreRL);
                                                $('#txtPaternoRepresentante').val(respuesta.paternoRL);
                                                $('#txtMaternoRepresentante').val(respuesta.maternoRL);
                                                $('#txtFechaNacimientoRepresentante').val(respuesta.fnacRL); 
                                                $('#cmbNacionalidadRepresentante').val(respuesta.nacionalidadRL);
                                                $('#txtRFCRepresentante').val(respuesta.rfcRL);
                                                $('#txtCURPRepresentante').val(respuesta.curpRL);
                                                //$('#cmbTipoIdentificacionRepresentante').val(respuesta.externo); 
                                                $('#txtNumeroIdentificacionRepresentante').val(respuesta.numidRL);
                                                $('#txtTelefonoRepresentante').val(respuesta.telefRL);
                                                $('#txtEmailRepresentante').val(respuesta.mailRL);
                                                $('#cmbOcupacionRepresentante').val(respuesta.ocupacionRL);
              
                              if(respuesta.expuestoRL == 1){
                                            
                                            $('#chkPoliticamenteExpuestoRepresentante').prop('checked', true);
                                        }
                                //dierccion representante legal
              
                                                $('#txtCalleRepresentante').val(respuesta.calleRL); //falta este
                                                $('#txtNumExtRepresentante').val(respuesta.nexternoRL);
                                                $('#txtNumIntRepresentante').val(respuesta.ninternoR);
                                                $('#txtCodigoPostalRepresentante').val(respuesta.cpR);
              
              
                                //documentos Representante Legal
                                                $('#txtNIdDocIdentificacion').val(respuesta.ididrl);
                                                $('#txtNIdDocPoder').val(respuesta.idpodrl);
                                              
                                            if(respuesta.cpR !== undefined){
                                                    buscarColoniasRL(respuesta.cpR, respuesta.ncoloniaRL);
              
                                                }
                                                    referenciaBancaria = respuesta.refbanc;
                                                    razonsocial  = respuesta.razonSoc;
                                                    correo  = respuesta.correo;
                                
              
                                     
              
                                }, "json");
       
    
    
}

function cargadocs(){}


function validarSolicitud(){
 var rfcpros = $("#txtRFC").val(); 

 var r =   confirm("¿Desea Validar los Datos de la solicitud?");
    
    if(r == true){
    $.post('./application/models/ProspValidarSolicitud.php',{RFC : rfcpros, usuario : usr},function(respuesta){
       
        if(respuesta.cod !== 0){
            
        enviacorreoprev();
            
        }else{alert('algo salio mal');}
        
    }, "json");
    }   
    
}

function autorizarSolicitud(){
    
    var rfcpros = $("#txtRFC").val();
     var r =   confirm("¿Desea autorizar los Datos de la solicitud?");
  if(r == true){  
    if(cuentafams == 5 &&  $("input[type=checkbox][name=nIdFamilia][value='5']").is(':checked')) {
        
       //alert('yeah esto si jala'); return;
        $.post('./application/models/autorizacionCliente.php',{rfc:rfcpros},function(res){
            
            if(res.cod == 0){
                
               
                
               $('body').append('<form id="verprospectos" method="post" action="autorizacionProspecto.php"><input  type="hidden" name="a" value="0"/></form>');
                
                $("#verprospectos").submit();
                
            }else{
                
                 alert(res.msg); 
            }
            
            
            
        },"JSON");
        
    }else{
        
       alert('El proceso de autorizacion se hará automaticamente por el sistema.'); 
    }
  
    }
}


function accionvalidado(){
     
           document.location.href = 'autorizacionProspecto.php'
    
}


 function enviarcorreo( mail, razon, referencia){
    
    
        $.post( "./correos/enviareferencia.php",
	               { mail: mail,razon:razon,referencia:referencia},
	               function ( respuesta ) {
                     
		              if ( respuesta.bExito == true ) {
                                  $().toastmessage('showToast', {
				                text		: respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         });    
                           accionvalidado();
                                         
                          } else {
                              
                         $().toastmessage('showToast', {
				                text		:  respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                          //inicial();
                         
                        }
                    }, "json");
    
}
function renviarcorreo( mail, razon, referencia){
    
    
        $.post( "./correos/enviareferencia.php",
	               { mail: mail,razon:razon,referencia:referencia},
	               function ( respuesta ) {
                     
		              if ( respuesta.bExito == true ) {
                                  $().toastmessage('showToast', {
				                text		: respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         });    
                          
                                         
                          } else {
                              
                         $().toastmessage('showToast', {
				                text		:  respuesta.sMensaje,
				                sticky		: false,
				                position	: 'top-center',
				                type		: 'warning'
			         }); 
                          //inicial();
                         
                        }
                    }, "json");
    
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

function enviacorreoprev(){
     var rfcprosp = $("#txtRFC").val(); 
      $.post('./application/models/ProspectoReferencia.php',{rfc:rfcprosp},function(resp){
           if(!resp.mail){showToastMsg('No Hay ningun correo de destino registrado', 'warning');}else{ enviarcorreo(resp.mail, resp.razon, resp.referencia);}
           
       },"json"); 
    
}

function consultaforelo(rfc,est){
    
   if(est == 3){
       
    $('#divforelo').css('display','block');
       
  $.post('./application/models/ConusltaForelo.php',{rfc:rfc},function(resp){
        
        $('#refbanc').val(resp.referencia);
        $('#cuota').val(resp.iniscripcion);
        $('#depositado').val(resp.depositado);
        $('#fechaultima').val(resp.fecha);
        $('#pendiente').val(resp.pendiente);
        
    },'JSON');
   }
}


function mostrarlistas(){

 var idvers =   $('#comboVersiones').val();
    
    
    if(idvers == -1){showToastMsg('Por Favor seleccione una Versión'); }else{ 
        var cadena = $('#txtIdCadena').val();
       
        $.post('./application/models/listasComisiones.php',{vers:idvers,fam:familiasarr,cadena:cadena},function(mensaje){
           $("#tablalista").html(mensaje); 
            
        });
        
        
        $('#comisionesListado').modal('show');
    
    
    }

   
    
}



function mostrarlistasProspecto(){
    
    //alert('si entra');
 var rfc =   $('#txtRFC').val();
    
    
  
       
        $.post('./application/models/listasComisionesProspecto.php',{rfc:rfc},function(mensaje){
           $("#tablalistaProspecto").html(mensaje); 
            
        });
        
        
        $('#comisionesListado').modal('show');
    
   
}





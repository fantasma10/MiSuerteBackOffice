
$(document).ready(function(){  
    
    if(est == 1 || est == 2){  $(".btnini").css('display','inline');}
    
       
    initInputFiles();
    actualizacontactos(incre);
    initFormDatosGenerales();
    datosInicial(incre);
    $('.fisico').on('keypress', function(){ return validarn(event); });
    $('#btnEditarContacto').on('click', function(){ editarcontactoprev(incre);});
    $('#btnAgregarContacto').on('click', function(){ nuevocontacto(incre);});
    $('#btnGuardarSolicitud').on('click', function(){ validarRepRfCId();   validarCuentaBancaria();  setTimeout(function(){guardarSolicitud()},1000);});
    $('#btnEliminarSolicitud').on('click', function(){eliminarsolicitud();});
    $('#div-familias :input[type=checkbox]').on('click',function(){cargarListaFamilias();/*familiasarray($(this),$(this).attr('value'));*/});
    $('#txtCodigoPostal').on('keyup', function(e){buscarColonias(e.target.value, 0);});
    $('#txtCodigoPostalRepresentante').on('keyup', function(e){buscarColoniasRL(e.target.value, 0);});
    $('#txtCLABE').on('blur', function(e){
        var sCLABE = $("#txtCLABE").val();
        datosbancarios(sCLABE);});
    
   /* $('#txtSCadena').autocomplete({
			serviceUrl				: './application/models/RE_Cadena.php',
			type					: 'post',
			dataType				: 'json',
		
			onSearchStart			: function (query) {
				$('#txtIdCadena').val('');
			},
			onSelect				: function (suggestion) {
				$('#txtIdCadena').val(suggestion.data);
			}
		});*/
		
	///////////////////////////////////////////////////////////
	
	$("#txtSCadena").autocomplete({
			source: function(request,respond){
				$.post( "./application/models/RE_Cadena.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtSCadena").val(ui.item.sNombreCadena);
				return false;
			},
			select: function(event,ui){
				$("#txtIdCadena").val(ui.item.nIdCadena);
				
				
			
				return false;
			},
			search: function(){
			
				$("#txtIdCadena").val('');
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a style=\"color:black\">" + item.value + "</a>" )
			.appendTo( ul );
		};	
		
		
		
		
		
		////////////////////////////////////////////////////////////////////
  setTimeout(function(){llenaDatosEdicion()},1000);
    
    $('#btnFileCompDom').click(function(){ var doc = $('#txtIdDocDomicilio').val();verdocumento(doc);});//rfc prospecto
    $('#btnFileRfc').click(function(){ var doc = $('#txtIdDocRFC').val();verdocumento(doc);});//Domicilio prospecto
    $('#btnFileActa').click(function(){ var doc = $('#txtIdDocActaConstitutiva').val();verdocumento(doc);});//acta prospecto
    $('#btnFileEdocta').click(function(){ var doc = $('#txtNIdDocEstadoCuenta').val();verdocumento(doc);});//EDOCTA prospecto
    $('#btnFileIdRL').click(function(){ var doc = $('#txtNIdDocIdentificacion').val();verdocumento(doc);});//ID RL prospecto
    $('#btnFilePoderRL').click(function(){ var doc = $('#txtNIdDocPoder').val();verdocumento(doc);});//podr RL prospecto
    
    $('#closepdf').click(function(){$('#pdfvisor').css('display','none')});
    
    
    $('#txtRFCRepresentante').on('blur', function(){ buscarRepresentanteLegal();});
    
      $('#btnVerListas').click(function(){mostrarlistas();mostrarlistasProspecto();});
    
});

///////////////////////////////////////////////////


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
		           
            }, "json");  
    
}

////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////

        var nCodigoPostal			= 0;
		var nIdColonia				= 0;
		var nIdEntidad				= 0;
		var nIdCiudad				= 0;
		var nIdPais					= 0;
        var edicion = false;
       
        var codrlidnum = false;
        var codCtaBanc = false;

        var cuentabancaria = 0;
        var replegRFC = 0;
        var replegidnum = 0;
        var replegeditar = 0;

        var famsarr = [0];
        var familiasarr = '';

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
		$('#cmbColoniaRepresentante').prop('disabled', false);
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
//var sCLABE = $("#txtCLABE").val();
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

		$('.fisico').on('keyup', function(e){
			var nombre = $('#formDatosGenerales [name=sNombreCliente]').val();
			var paterno = $('#formDatosGenerales [name=sPaternoCliente]').val();
			var materno = $('#formDatosGenerales [name=sMaternoCliente]').val();
            var nombreConcatenado = nombre + ' ' + paterno + ' ' + materno;
			$('#formDatosGenerales [name=sRazonSocial]').val(nombreConcatenado.toUpperCase());
			$('#formDatosGenerales [name=sNombreComercial]').val(nombreConcatenado.toUpperCase());

			if($('#txtBeneficiario').length > 0){
				$('#txtBeneficiario').val(nombreConcatenado.toUpperCase());
			}
		});

	
		 //$('#txtFechaNacimiento, #txtFechaConstitutiva').datepicker(); 

	     $('#txtFechaNacimiento, #txtFechaConstitutiva, #txtFechaVencimiento, #txtFechaNacimientoRepresentante ').datepicker({ format: "yyyy-mm-dd" }).on('changeDate', function(){
          $(this).blur();
        }); 
		

	

		$('#txtSCadena').on('change', function(e){//no se si esto aun no estba terminado
			if(myTrim(e.target.value) == ''){
				$('#txtIdCadena').val('');
			}
		});


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
    
    	$('#txtNumExterno, #txtCodigoPostal, #txtNumExtRepresentante, #txtCodigoPostalRepresentante').alphanum({
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
    
    	$('.montos2').alphanum({
			disallow			: 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ',
			allow				: '.',
			allowSpace			: false,
			allowNumeric		: true,
			allowUpper			: false,
			allowLower			: false,
			allowLatin			: false,
			allowOtherCharSets	: false,
			maxLength			: 10
		});
	}

function actualizacontactos(idincrmental) {
    		
    		if (idincrmental != "") {
        		$.post("./application/models/RE_ContactoLista.php", {increm: idincrmental }, function(mensaje) {
            	$("#tables").html(mensaje); }); 
    		} else { ("#tables").html('no se mando ningun post');};
	}

function llenaedicion(param){
    
    
    
                            $.post( "./application/models/ProspectoContactoLlenadoEditar.php",
                                    { contacto: param },
	                                   function ( respuesta ) {
                     
		                                      if ( respuesta.idct == param ) {//idincr
                                                  $('#txtNombreContacto').val(respuesta.nom);
                                                  $('#txtPaternoContacto').val(respuesta.pat);
                                                  $('#txtMaternoContacto').val(respuesta.mat);
                                                  $('#txtTelefonoContacto').val(respuesta.tel);
                                                  $('#txtExtensionContacto').val(respuesta.ext);
                                                  $('#txtTelefonoMovilContacto').val(respuesta.cel);
                                                  $('#txtEmailContacto').val(respuesta.mail);
                                                  $('#txtDescripcionContacto').val(respuesta.desc);
                                                  $('#cmbTipoContacto').val(respuesta.tipo);
                                                  $('#nIdContacto').val(respuesta.idct);
                                                  
                                                  ///////btnAgregarContacto
                                                  $('.btn2').css('display','inline-block');
                                                  $('#btnAgregarContacto').css('display','none');
                                                  
                                                  if(respuesta.desc == 'Solicita el Alta'){$('#txtEmailContacto').prop('disabled', true);$('#txtDescripcionContacto').prop('disabled', true);}
                                                  else{$('#txtEmailContacto').prop('disabled', false);$('#txtDescripcionContacto').prop('disabled', false);}
                                                 
                                                   
                                        } else {
                              
                                                $().toastmessage('showToast', {
                                                            text		: "no se regreso ningun dato",
				                                            sticky		: false,
				                                            position	: 'top-center',
				                                            type		: 'warning'
                                                        }); 
                                                //inicial();
                                          }
                                }, "json");
    
}
////////////////////////////////////////////////////////////////////////////////////////////////////
function editarcontactoprev(param){
   if( validacionescontactos() == false){return}
    actualizarcontacto(param);
}


///////////////////////////////////////////////////////////////////////////////////////////////////
function actualizarcontacto(param){
            var nomcont        =    $('#txtNombreContacto').val();
            var paterno        =    $('#txtPaternoContacto').val();
            var materno        =    $('#txtMaternoContacto').val();
            var telefono       =    $('#txtTelefonoContacto').val();
            var extension      =    $('#txtExtensionContacto').val();
            var celular        =    $('#txtTelefonoMovilContacto').val();
            var mail           =    $('#txtEmailContacto').val();
            var descripcion    =    $('#txtDescripcionContacto').val();
            var tipocont       =    $('#cmbTipoContacto').val();
            var idcont         =    $('#nIdContacto').val();
     $.post( "./application/models/ProspectoContactoEditar.php",
                            { nom: nomcont, pat: paterno, mat: materno, tel: telefono, ext: extension, cel: celular, mail: mail, desc: descripcion, tipo: tipocont, idcont: idcont, usuario:usr},
	           function ( respuesta ) {
                     if ( respuesta.rows == 1 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Contacto se actualizó Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(param); 
                            formcontactosreset();    
                       } else {
                           $().toastmessage('showToast', {
                                 text		: "No se Hizo Ninguna Modificación",
				                 sticky		: false,
				                 position	: 'top-center',
				                 type		: 'warning'
                               }); 
                            formcontactosreset();
                                          }
                                }, "json");
    
  
    
}


//////////////////////////////////////////////////////////////////////////////////////////////////
function formcontactosreset(){
    
     document.getElementById("formCapturaContacto").reset(); 
       $('.btn2').css('display','none');
       $('#btnAgregarContacto').css('display','inline-block');
       $('#txtEmailContacto').prop('disabled', false);
       $('#txtDescripcionContacto').prop('disabled', false);    
    
}
///////////////////////////////////////////////////////////////////////////////////////////////////
function validacionescontactos(){ // validaciones a ejecitar antes de  insertar y de actualizar.
            var nomcont        =    $('#txtNombreContacto').val();
            var paterno        =    $('#txtPaternoContacto').val();
            var materno        =    $('#txtMaternoContacto').val();
            var telefono       =    $('#txtTelefonoContacto').val();
            var extension      =    $('#txtExtensionContacto').val();
            var celular        =    $('#txtTelefonoMovilContacto').val();
            var mail           =    $('#txtEmailContacto').val();
            var descripcion    =    $('#txtDescripcionContacto').val();
            var tipocont       =    $('#cmbTipoContacto').val();
            var rfcs           =    $('#txtRFC').val();
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
    
     if(tipocont == -1){//validacion del tipo de contacto
        $().toastmessage('showToast', {
                   text		: "Seleccione un Tipo de Contacto",
				   sticky		: false, position	: 'top-center', type		: 'warning'}); 
      return false;  
    }
    
}

function nuevocontacto(param){
    if( validacionescontactos() == false){return}
    crearcontacto(param);
}

function crearcontacto(param){
            var nomcont        =    myTrim($('#txtNombreContacto').val());
            var paterno        =    myTrim($('#txtPaternoContacto').val());
            var materno        =    myTrim($('#txtMaternoContacto').val());
            var telefono       =    $('#txtTelefonoContacto').val();
            var extension      =    $('#txtExtensionContacto').val();
            var celular        =    $('#txtTelefonoMovilContacto').val();
            var mail           =    $('#txtEmailContacto').val();
            var descripcion    =    myTrim($('#txtDescripcionContacto').val());
            var tipocont       =    $('#cmbTipoContacto').val();
            var rfcs           =    $('#txtRFC').val();
     $.post( "./application/models/ProspectoContactoNuevo.php",
                            { nom: nomcont, pat: paterno, mat: materno, tel: telefono, ext: extension, cel: celular, mail: mail, desc: descripcion, tipo: tipocont, rfc: rfcs,usuario:usr},
	           function ( respuesta ) {
                     if ( respuesta.rows > 0 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Contacto fue creado Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(param); 
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
function eliminarcontacto(param){
  var r =   confirm("¿Desea Eliminar Este Contacto?");
            var idcont         =    $('#nIdContacto').val();
    if(r == true){
     $.post( "./application/models/ProspectoContactoEliminar.php",
                            { idcont: param},
	           function ( respuesta ) {
                     if ( respuesta.rows > 0 ) {
                            $().toastmessage('showToast', {
                                 text		: "El Registro del Contacto fue eliminado  Exitosamente",
				                 sticky		: false, position	: 'top-center', type		: 'warning'}); 
                            actualizacontactos(incre); 
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
function copiapaqutes(idpaquete,incrip,afili,renta,anual,sucursales,feinicio,vencimiento,promocion){
incrip = incrip.toFixed(2)
afili = afili.toFixed(2)
renta = renta.toFixed(2)
anual = anual.toFixed(2)
    var incripcion  = incrip.toLocaleString("en-US");
     var afiliacion  = afili.toLocaleString("en-US");
     var mensual = renta.toLocaleString("en-US");
    var anuals = anual.toLocaleString("en-US");
     
     var fechavencimiento; 
     var fechainicio;
    if(vencimiento == 0){ fechavencimiento = sumaDias(35 ,fechaHoy());}else{fechavencimiento = vencimiento}
      if(feinicio == 0){ fechainicio = '0000-00-00'}else{fechainicio = feinicio}
    
    $("#txtIdPaquete").val(idpaquete);
    $("#txtInscripcionCliente").val(incripcion);
    $("#txtAfiliacionSucursal").val(afiliacion);
    $("#txtRentaSucursal").val(mensual);
    $("#txtAnualSucursal").val(anuals);
    $("#txtLimiteSucursales").val(sucursales);
    $("#txtDFechaInicio").val(fechainicio);
    $("#txtFechaVencimiento").val(fechavencimiento );
    $("#txtBPromocion").val(promocion);
    
 
    
}
////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////VALIDACIONES/////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

function toasts(mensaje){
       $().toastmessage('showToast', {
       text	: mensaje,
		sticky: false, position	: 'top-center', type: 'warning'}); 
}

////////////////////////////////////////////////////////////////////////////////////
function validarGenerales(){
    
    FORM_DATA = new FormData();
	var nIdPais		= idpaisvar;
	var nIdRegimen	= idregimenvar;
	var params1		= $('#formDatosGenerales').getSimpleParams();

	if(params1.sRFC == undefined || myTrim(params1.sRFC) == ''){
		showToastMsg('Capture RFC', 'warning');
		return false;
	}
	else{
		if(nIdPais == 164){
			if(!isValidRFC(params1.sRFC.toUpperCase())){
				showToastMsg('El Formato del RFC es Inv\u00E1lido', 'warning');
				return false;
			}
		}
		else if(nIdPais == 68){
			if(params1.sRFC.length == 11 || params1.sRFC.length == 10){
				if(!isValidTINEIN(params1.sRFC)){
					showToastMsg('El Formato del TIN es Inv\u00E1lido', 'warning');
					return false;
				}
			}
			else{
				showToastMsg('La Longitud de RFC es Inv\u00E1lida', 'warning');
				return false;
			}
		}
	}

	if(params1.nIdRegimen == undefined || myTrim(params1.nIdRegimen) == '' || params1.nIdRegimen <= 0){
		showToastMsg('No existe un R\u00E9gimen Seleccionado');
		return false;
	}

	if(params1.nIdGiro == undefined || myTrim(params1.nIdGiro) == '' || params1.nIdGiro <= 0){
		showToastMsg('Seleccione Giro', 'warning');
		return false;
	}

	/* validaciones persona fisica */
	if(params1.nIdRegimen == 1){
		if(params1.sNombreCliente == undefined || myTrim(params1.sNombreCliente) == '' || params1.sNombreCliente <= 0){
			showToastMsg('Nombre es Obligatorio');
			return false;
		}
		else{
			if(params1.sNombreCliente.length < 3){
				showToastMsg('La Longitud M\u00CDnima para el Nombre del Cliente es de 3 caracteres');
				return false;
			}
			else if(params1.sNombreCliente.length > 50){
				showToastMsg('La Longitud M\u00E1xima para el Nombre del Cliente es de 50 caracteres');
				return false;
			}
		}
		params1.sNombreCliente = myTrim($('#formDatosGenerales :input[name=sNombreCliente]').val());
        var sNombreCliente1 = myTrim($('#formDatosGenerales :input[name=sNombreCliente]').val());

		if(params1.sPaternoCliente == undefined || myTrim(params1.sPaternoCliente) == '' || params1.sPaternoCliente <= 0){
			showToastMsg('Apellido Paterno es Obligatorio');
			return false;
		}
		else{
			if(params1.sPaternoCliente.length < 3){
				showToastMsg('La Longitud M\u00CDnima para el Apellido Paterno del Cliente es de 3 caracteres');
				return false;
			}
			else if(params1.sPaternoCliente.length > 50){
				showToastMsg('La Longitud M\u00E1xima para el Apellido Paterno del Cliente es de 50 caracteres');
				return false;
			}
		}
		params1.sPaternoCliente = myTrim($('#formDatosGenerales :input[name=sPaternoCliente]').val());
       var sPaternoCliente1 = myTrim($('#formDatosGenerales :input[name=sPaternoCliente]').val());

		if(nIdPais == 164){
			if(params1.sMaternoCliente == undefined || myTrim(params1.sMaternoCliente) == '' || params1.sMaternoCliente <= 0){
				showToastMsg('Apellido Paterno es Obligatorio');
				return false;
			}
			else{
				if(params1.sMaternoCliente.length < 3){
					showToastMsg('La Longitud M\u00CDnima para el Apellido Materno del Cliente es de 3 caracteres');
					return false;
				}
				else if(params1.sMaternoCliente.length > 50){
					showToastMsg('La Longitud M\u00E1xima para el Apellido Materno del Cliente es de 50 caracteres');
					return false;
				}
			}
			params1.sMaternoCliente = myTrim($('#formDatosGenerales :input[name=sMaternoCliente]').val());
            var sMaternoCliente1 = myTrim($('#formDatosGenerales :input[name=sMaternoCliente]').val());
		}
        
        //var nombress = $('#nombrefisico').val();
       // var paternoss = $('#sPaternoCliente').val();
        //var maternoss = $('#sMaternoCliente').val();
        
        //usr
       
        FORM_DATA.append('sNombress1',sNombreCliente1);
        FORM_DATA.append('sPaternoss1',sPaternoCliente1);
        FORM_DATA.append('sMaternoss1',sMaternoCliente1);

	}

	if(params1.sRazonSocial == undefined || myTrim(params1.sRazonSocial) == ''){
		showToastMsg('La Raz\u00F3n Social del Cliente es Obligatoria');
		return false;
	}
	else{
		if(params1.sRazonSocial.length < 3){
			showToastMsg('La Longitud M\u00CDnima para la Raz\u00F3n Social del Cliente es de 3 caracteres');
			return false;
		}
		else if(params1.sRazonSocial.length > 150){
			showToastMsg('La Longitud M\u00E1xima para la Raz\u00F3n Social del Cliente es de 150 caracteres');
			return false;
		}
	}
	params1.sRazonSocial = myTrim($('#formDatosGenerales :input[name=sRazonSocial]').val());

	if(params1.sNombreComercial == undefined || myTrim(params1.sNombreComercial) == ''){
		showToastMsg('El Nombre Comercial del Cliente es Obligatorio');
		return false;
	}
	else{
		if(params1.sNombreComercial.length < 3){
			showToastMsg('La Longitud M\u00CDnima para el Nombre Comercial del Cliente es de 3 caracteres');
			return false;
		}
		else if(params1.sNombreComercial.length > 150){
			showToastMsg('La Longitud M\u00E1xima para el Nombre Comercial del Cliente es de 150 caracteres');
			return false;
		}
	}
	params1.sNombreComercial = myTrim($('#formDatosGenerales :input[name=sNombreComercial]').val());

	if(params1.sTelefono == undefined || myTrim(params1.sTelefono) == ''){
		showToastMsg('El Tel\u00E9fono del Cliente es Obligatorio')
		return false;
	}
	else{
		params1.sTelefono = soloNumeros(params1.sTelefono);
		if(params1.sTelefono.length != 10){
			showToastMsg('La longitud del Tel\u00E9fono debe ser de 10 d\u00EDgitos.');
			return false;
		}
	}

	if(params1.sEmail == undefined || myTrim(params1.sEmail) == ''){
		showToastMsg('El Correo Electr\u00F3nico del Cliente es Obligatorio');
		return false;
	}
	else{
		params1.sEmail = myTrim($('#formDatosGenerales :input[name=sEmail]').val());
		if(params1.sEmail.length > 150){
			showToastMsg('La Longitud M\u00E1xima para el Correo Electr\u00F3nico del Cliente es de 150 caracteres');
			return false;
		}
		else if(!isValidEmail(params1.sEmail)){
			showToastMsg('El Formato del Correo Electr\u00F3nico del Cliente es Inv\u00E1lido', 'warning');
			return false;
		}
	}

	if(params1.nIdEjecutivoCuenta == undefined || myTrim(params1.nIdEjecutivoCuenta) == '' || params1.nIdEjecutivoCuenta <= 0){
		showToastMsg('Seleccione Ejecutivo de Cuenta para el Cliente', 'warning');
		return false;
	}

	if(params1.sCalle == undefined || myTrim(params1.sCalle) == ''){
		showToastMsg('La Calle de la Direcci\u00F3n del Cliente es Obligatoria');
		return false;
	}

	if(params1.nNumExterno == undefined || myTrim(params1.nNumExterno) == ''){
		showToastMsg('El N\u00FAmero Externo de la Direcci\u00F3n del Cliente es Obligatorio');
		return false;
	}

	if(params1.nCodigoPostal == undefined || myTrim(params1.nCodigoPostal) == ''){
		showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n del Cliente es Obligatorio');
		return false;
	}
	else if(params1.nCodigoPostal.length < 5 || params1.nCodigoPostal.length > 6){
		showToastMsg('El C\u00F3digo Postal de la Direcci\u00F3n del Cliente es de 5 ó 6 dígitos');
		return false;
	}

	if(nIdPais == 164){
		if(params1.nNumColonia == undefined || myTrim(params1.nNumColonia) == '' || params1.nNumColonia <= 0){
			showToastMsg('Seleccione Colonia de la Direcci\u00F3n el Cliente', 'warning');
			return false;
		}

		

		
	}

	if(nIdPais == 68){
		if(params1.sNombreMunicipio == undefined || myTrim(params1.sNombreMunicipio) == ''){
			showToastMsg('Capture el Nombre de la Ciudad de la Direcci\u00F3n del Cliente');
			return false;
		}
		params1.sMunicipio = $('#formDatosGenerales :input[name=sNombreMunicipio]').val();
		if(params1.sNombreEstado == undefined || myTrim(params1.sNombreEstado) == ''){
			showToastMsg('Capture el Nombre del Estado de la Direcci\u00F3n del Cliente');
			return false;
		}
		params1.sEstado = $('#formDatosGenerales :input[name=sNombreEstado]').val();
      
        
	}
if($('#txtIdDocRFC').val() == undefined || $('#txtIdDocRFC').val() == 0 ){
	var fileRFC = $('#formDatosGenerales :input[name=sFileRFC]').prop('files')[0];
	
	if(fileRFC == undefined){
		showToastMsg('El archivo de RFC es Obligatorio');
		return false;
	}
	else if(fileRFC.type != 'application/pdf'){
		showToastMsg('El archivo RFC debe ser formato pdf');
		return false;
	}
    
}
    
    
if($('#txtIdDocDomicilio').val() == undefined || $('#txtIdDocDomicilio').val() == 0 ){
	var fileComprobanteDomicilio = $('#formDatosGenerales :input[name=sFileComprobanteDomicilio]').prop('files')[0];
	
	if(fileComprobanteDomicilio == undefined){
		showToastMsg('El archivo de Comprobante de Domicilio es Obligatorio');
		return false;
	}
	else if(fileComprobanteDomicilio.type != 'application/pdf'){
		showToastMsg('El archivo de Comprobante de Domicilio debe ser formato pdf');
		return false;
	}
}
	//params1.files = [fileRFC, fileComprobanteDomicilio];
    
    
	//FORM_DATA = new FormData();
    
      
        var nomcolonia = $('#txtColonia').val();
        var nomciudad = $('#txtMunicipio').val();
        var nomestado = $('#txtEstado').val();

        //FORM_DATA = new FormData();
        FORM_DATA.append('sNomColonia',nomcolonia);
        FORM_DATA.append('sNomCiudad',nomciudad);
        FORM_DATA.append('sNomEstado',nomestado);
    
		
	FORM_DATA.append('fileRFCCliente',fileRFC);	
	FORM_DATA.append('fileComprobanteDomicilioCliente',fileComprobanteDomicilio);	
      FORM_DATA.append('idpais',nIdPais);
    
    
   
    
    
    
    
    var calless = $('#txtCalle').val();
    var razonSocial = $('#txtRazonSocial').val();
    var nombreComercial = $('#txtNombreComercial').val();
     FORM_DATA.append('usuario', usr);
    FORM_DATA.append('sNomCalles',calless);
    FORM_DATA.append('sRazon',razonSocial);
    FORM_DATA.append('sComercial',nombreComercial);
	
	for(i in params1){
		FORM_DATA.append(i, params1[i]);
	}
		
	return true;
}
//////////////////////////////////////////////////

function validarEspeciales(){
    
 	var nIdPais		= idpaisvar;
	var nIdRegimen	= idregimenvar;
   
	var params2 = $('#formInformacionEspecial').getSimpleParams();
	if(nIdRegimen == 1){
        
        
		if(params2.dFechaNacimiento == undefined || params2.dFechaNacimiento == ''){
			showToastMsg('Seleccione Fecha de Nacimiento en Informaci\u00F3n Especial');
			return false;
		}
		if((nIdPais == 164 && calcular_edad(params2.dFechaNacimiento) < 18) ||(nIdPais == 68 && calcular_edad(params2.dFechaNacimiento) < 21)){
			showToastMsg('El Cliente debe ser Mayor de Edad');
			return false;
		}

		if(nIdPais == 164 && (params2.sCURP == undefined || params2.sCURP == '')){
			showToastMsg('El CURP es Obligatorio (Informaci\u00F3n Especial)');
			return false;
		}

		if(params2.nIdTipoIdentificacion == undefined || params2.nIdTipoIdentificacion == '' || params2.nIdTipoIdentificacion <= 0){
			showToastMsg('Selecciona Tipo de identificaci\u00F3n del Cliente');
			return false;
		}

		if(params2.sNumeroIdentificacion == undefined || params2.sNumeroIdentificacion == ''){
			showToastMsg('Capture N\u00FAmero de identificaci\u00F3n del Cliente');
			return false;
		}
		else{
			var showmsg = false;
			if(nIdPais == 164){
				if(params2.nIdTipoIdentificacion == 1 && !validarFormatoIFE(params2.sNumeroIdentificacion)){
					showmsg = true;
				}
				if(params2.nIdTipoIdentificacion == 2 && !validarFormatoCartillaMilitar(params2.sNumeroIdentificacion)){
					showmsg = true;
				}
				if(params2.nIdTipoIdentificacion == 3 && !validarFormatoPasaporte(params2.sNumeroIdentificacion)){
					showmsg = true;
				}
				if(params2.nIdTipoIdentificacion == 4 && !validarFormatoCedulaProfesional(params2.sNumeroIdentificacion)){
					showmsg = true;
				}
			}
			else{
				if(!validarEntero(params2.sNumeroIdentificacion)){
					showmsg = true;
				}
			}
			if(showmsg){
				showToastMsg('El Formato del N\u00FAmero de identificaci\u00F3n es Incorrecto');
				return false;
			}
		}

		if(params2.nIdPaisNacimiento == undefined || params2.nIdPaisNacimiento == '' || params2.nIdPaisNacimiento <= 0){
			showToastMsg('Seleccione Pa\u00EDs de Nacimiento (Informaci\u00F3n Especial)');
			return false;
		}

		if(params2.nIdNacionalidad == undefined || params2.nIdNacionalidad == '' || params2.nIdNacionalidad <= 0){
			showToastMsg('Seleccione Nacionalidad (Informaci\u00F3n Especial)');
			return false;
		}
	}
	else if(nIdRegimen == 2){
		if(params2.nIdTipoSociedad == undefined || params2.nIdTipoSociedad == '' || params2.nIdTipoSociedad <= 0){
			showToastMsg('Selecccione Tipo de Sociedad del Cliente (Informaci\u00F3n Especial)');
			return false;
		}

		if(params2.dFechaConstitutiva == undefined || params2.dFechaConstitutiva == ''){
			showToastMsg('Selecccione Fecha Constitutiva (Informaci\u00F3n Especial)');
			return false;
		}

    if($('#txtIdDocActaConstitutiva').val() == undefined || $('#txtIdDocActaConstitutiva').val() == 0 ){
		var fileActaConstitutiva = $('#formInformacionEspecial :input[name=sFileActaConstitutiva]').prop('files')[0];
	
		if(fileActaConstitutiva == undefined){
			showToastMsg('El archivo de Acta Constitutiva es Obligatorio');
			return false;
		}
		else if(fileActaConstitutiva.type != 'application/pdf'){
			showToastMsg('El archivo de Acta Constitutiva debe ser formato pdf');
			return false;
		}}

		FORM_DATA.append('sFileActaConstitutiva',fileActaConstitutiva);	
      
	}
	for(i in params2){
		console.log(i, params2[i]);
		FORM_DATA.append(i, params2[i]);
	}
    
   
    //bPolitcamente
	console.log(params2);

	return true;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////

function validarConfiguracion(){
	var nIdPais		= idpaisvar;
	var nIdRegimen	= idregimenvar;

	var params3 = {
		'nIdTipoAccesos': [],
		'nIdFamilias'	: [],
		//'nIdPerfil'		: 0,
        'nIdVersion'	: 0
	};
		
    //validar Versiones
    
    var idversion = $('#comboVersiones').val();
    if(idversion == -1){
        toasts('Debe Seleccionar una Versi\u00F3n (Configuraci\u00F3n)');
		return false;
        
    }else{
        
        params3.nIdVersion = idversion;
    }
    
	// validacion de familias
	var array_familias = $('input[name=nIdFamilia]:checked');
	if(array_familias == undefined || array_familias.length <= 0){
		toasts('Debe Seleccionar por lo Menos una Familia (Configuraci\u00F3n)');
		return false;
	}
	else{
		var num_fam = array_familias.length;
		var i		= 0;
		for(i=0; i < num_fam; i++){
			var item = array_familias[i];
			params3.nIdFamilias.push($(item).val());
		}
	}
	// validacion de tipo de acceso
	var array_tipoacceso = $('input[name=nIdTipoAcceso]:checked');
	if(array_tipoacceso == undefined || array_tipoacceso.length <= 0){
		toasts('Debe Seleccionar por lo Menos un Tipo de Acceso (Configuraci\u00F3n)');
		return false;
	}
	else{
	
      	var num_tipoa	= array_tipoacceso.length;
		var i			= 0;
		for(i=0; i < num_tipoa; i++){
			var item = array_tipoacceso[i];
			params3.nIdTipoAccesos.push($(item).val());
		}
        
			//params3.nIdTipoAccesos = array_tipoacceso;
		
	}

	/*var nIdPerfil = $('input[name=nIdPerfil]:checked').val();
	if(nIdPerfil == undefined || nIdPerfil <= 0){
		toasts('Debe Seleccionar un Perfil (Configuraci\u00F3n)');
		return false;
	}
	else{
		params3.nIdPerfil = nIdPerfil;
	}*/
    
    var nIdVersion = $('#comboVersiones').val();
    	if(nIdVersion == undefined || nIdVersion < 0){
		toasts('Debe Seleccionar una Versión (Configuraci\u00F3n)');
		return false;
	}
	else{
		params3.nIdVersion = nIdVersion;
	}
    
    
 
	for(i in params3){
		FORM_DATA.append(i, params3[i]);
	}

	return params3;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validarLiquidacion(){
   var params6 = {
		'nIdTiporeembolso'   : 0,
		'nIdTipocomision'	 : 0,
		'nIdTipoliqreembolso': 0,
       'nIdTipoloqcomsion'	 : 0
	};
    
    var nIdTiporeembolso = $('#comboReembolso').val();
    if(nIdTiporeembolso == undefined || nIdTiporeembolso < 0   ){ toasts('Debe Seleccionar un tipo de reembolso(Liquidaci\u00F3n)');return false;}else{
        
         params6.nIdTiporeembolso = nIdTiporeembolso; 
    }
    var nIdTipocomision = $('#comboComisiones').val();
    if(nIdTipocomision == undefined || nIdTipocomision < 0 ){toasts('Debe Seleccionar un tipo de comisión (Liquidaaci\u00F3n)');return false;}else{
      params6.nIdTipocomision = nIdTipocomision;  
        
    }
    var nIdTipoliqreembolso = $('#comboLiqReembolso').val();
    if(nIdTipoliqreembolso == undefined || nIdTipoliqreembolso < 0 ){toasts('Debe Seleccionar un tipo de liquidación del Reembolso (Liquidaci\u00F3n)');return false;}else{
        
      params6.nIdTipoliqreembolso = nIdTipoliqreembolso;  
    }
    var nIdTipoloqcomsion = $('#comboLiqComisiones').val();  
    if(nIdTipoloqcomsion == undefined || nIdTipoloqcomsion < 0 ){toasts('Debe Seleccionar un tipo de liquidación de la comisión (Liquidaci\u00F3n)');return false;}else{
        
       params6.nIdTipoloqcomsion = nIdTipoloqcomsion; 
    }
    
  
     	for(i in params6){
		FORM_DATA.append(i, params6[i]);
	}

	return params6;
     
     
    
    
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function validarPaqueteComercial(){
    
    
	var params4 = $('#formPaqueteSeleccionado').getSimpleParams();

	if(params4.nIdPaquete == undefined || params4.nIdPaquete == '' || params4.nIdPaquete <= 0 || params4.nIdPaquete == '0'){
		toasts('Debe Seleccionar un Paquete en la Sección de Paquete Especial');
		return false;
	}

	if(params4.nInscripcionCliente == undefined || params4.nInscripcionCliente == ''){
		toasts('El Costo de la Incripci\u00F3n del Cliente es Obligatorio');
		return false;
	}
	else if(params4.nInscripcionCliente < 0){
		toasts('El Costo de la Incripci\u00F3n del Cliente debe ser Mayor o igual a 0');
		return false;
	}

	if(params4.nAfiliacionSucursal == undefined || params4.nAfiliacionSucursal == ''){
		toasts('El Costo de la Afiliaci\u00F3n es Obligatorio');
		return false;
	}
	else if(params4.nAfiliacionSucursal < 0){
		toasts('El Costo de la Afiliaci\u00F3n debe ser Mayor o igual a 0');
		return false;
	}

	if(params4.nRentaSucursal == undefined || params4.nRentaSucursal == ''){
		toasts('El Costo de la Renta Mensual de la Sucursal es Obligatorio');
		return false;
	}
	else if(params4.nRentaSucursal < 0){
		toasts('El Costo de la Renta Mensual debe ser Mayor o igual a 0');
		return false;
	}

	if(params4.nAnualSucursal == undefined || params4.nAnualSucursal == ''){
		toasts('El Costo de la Anualidad de la Sucursal es Obligatorio');
		return false;
	}
	else if(params4.nAnualSucursal < 0){
		toasts('El Costo de la Anualidad debe ser Mayor o igual a 0');
		return false;
	}

	if(params4.nLimiteSucursales == undefined || params4.nLimiteSucursales == ''){
		toasts('El L\u00EDmite de Sucursales es Obligatorio');
		return false;
	}
	else if(params4.nLimiteSucursales < 1){
		toasts('El L\u00EDmite de Sucursales debe ser Mayor o igual a 1');
		return false;
	}

	if(params4.dFechaVencimiento == undefined || params4.dFechaVencimiento == ''){
		toasts('Debe Seleccionar Fecha de Vencimiento para el Paquete');
		return false;
	}
	else{
		if(params4.dFechaVencimiento == fechaHoy() || (validate_fechaMayorQue(params4.dFechaVencimiento, fechaHoy()) == 1)){
			toasts('La Fecha de Vencimiento debe ser posterior al día de hoy');
			return false;
		}
	}

	for(i in params4){
		FORM_DATA.append(i, params4[i]);
	}

	return true;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

function validarDatosBancarios(){
    
    
	var params5 = $('#formDatosBancarios').getSimpleParams();

	if(params5.sCLABE == undefined || params5.sCLABE == ''){
		toasts('Captura CLABE Interbancaria (Datos Bancarios)');
		return false;
	}
	else if(params5.sCLABE.length != 18){
		toasts('La CLABE debe ser de 18 d\u00EDgitos');
		return false;
	}
	/*else if(!validarDigitoVerificador(params5.sCLABE)){
		toasts('El Formato de la CLABE es Inv\u00E1lido');
		return false;
	}*/

	if(params5.nIdBanco == undefined || params5.nIdBanco == '' || params5.nIdBanco <= 0){
		toasts('Captura nuevamente la CLABE para seleccionar el Banco');
		return false;
	}

	if(params5.nCuenta == undefined || params5.nCuenta == ''){
		toasts('Captura nuevamente la CLABE para obtener el N\u00FAmero de Cuenta');
		return false;	
	}
    
    
	else if(params5.nCuenta.length != 11){
		toasts('Captura nuevamente la CLABE para obtener el N\u00FAmero de Cuenta');
		return false;	
	}

	params5.sBeneficiario =  $('#formDatosBancarios :input[name=sBeneficiario]').val();
	if(params5.sBeneficiario == undefined || params5.sBeneficiario == ''){
		toasts('Captura Nombre de Beneficiario');
		return false;
	}
	else if(params5.sBeneficiario.length < 3){
		toasts('La Longitud M\u00EDnima para el Nombre de Beneficiario es de 3 caracteres');
		return false;
	}
	else if(params5.sBeneficiario.length > 50){
		toasts('La Longitud M\u00E1xima para el Nombre de Beneficiario es de 50 caracteres');
		return false;
	}
if($('#txtNIdDocEstadoCuenta').val() == undefined || $('#txtNIdDocEstadoCuenta').val() == 0 ){
	var sFileEstadoDeCuenta = $('#formDatosBancarios :input[name=sFileEstadoDeCuenta]').prop('files')[0];
	params5.sDescripcion = $('#formDatosBancarios :input[name=sDescripcion]').val();
	if(sFileEstadoDeCuenta != undefined){
		if(sFileEstadoDeCuenta.type != 'application/pdf'){
			toasts('El archivo de Estado de Cuenta debe ser formato pdf');
			return false;
		}
    }
        
     //if(codCtaBanc == false){toasts('El Número de Cuenta Bancaria ya existe'); return false;}   
        	
    
      
       
        var beneficiarioss = $('#formDatosBancarios :input[name=sBeneficiario]').val();
        var descripcionss = $('#formDatosBancarios :input[name=sDescripcion]').val();

        //FORM_DATA = new FormData();
        FORM_DATA.append('sBeneficiarioss',beneficiarioss);
        FORM_DATA.append('sDescripcionss',descripcionss);
     
        
        
		FORM_DATA.append('sFileEstadoDeCuenta',sFileEstadoDeCuenta);		


		//params5 = data;
	}

	for(i in params5){
		FORM_DATA.append(i, params5[i]);
	}

	return params5;
}

/////////////////////////////////////////////////////////////////////////////////////////////////
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
        
  //if(codrlrfc == false){showToastMsg('El RFC del Representante Legal ya Ha sido previamente Registrado', 'warning'); return false;}   
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
			if(params7.nIdTipoIdentificacionRepresentante == 1 && params7.length == 13){
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
    
if($('#txtNIdDocIdentificacion').val() == undefined || $('#txtNIdDocIdentificacion').val() == 0 ){
    
    var fileRFCRepresentante = $('#formRepresentanteLegal :input[name=sFileIdentificacionRepresentante]').prop('files')[0];

	if(fileRFCRepresentante == undefined){
		showToastMsg('El archivo de Identificaci\u00F3n del Representante Legal es Obligatorio');
		return false;
	}
	else if(fileRFCRepresentante.type != 'application/pdf'){
		showToastMsg('El archivo de Identificaci\u00F3n del Representante Legal debe ser formato pdf');
		return false;
	}
    
    
}
	
if($('#txtNIdDocPoder').val() == undefined || $('#txtNIdDocPoder').val() == 0 ){
	var sFilePoderRepresentanteLegal = $('#formRepresentanteLegal :input[name=sFilePoderRepresentanteLegal]').prop('files')[0];

	if(sFilePoderRepresentanteLegal != undefined){
		if(sFilePoderRepresentanteLegal.type != 'application/pdf'){
			showToastMsg('El archivo de Poder del Representante Legal debe ser formato pdf');
			return false;
		}
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function crearprospecto(){
    
    
  if(validarGenerales(idregimenvar, idpaisvar)== false){return;}; 
 if(validarEspeciales() == false){return;}
  if(validarConfiguracion() == false){return; } 
  if(validarPaqueteComercial() == false){return; } 
  if(validarDatosBancarios() == false){return; } 

   
  if(repleg == true){
      
      if(validarRepresentanteLegal() == false){return; }
  }
    alert('aqui es donde se insertan los  datos..  a trabajar en ello');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
function guardarSolicitud(){
    
    
	/*
	#	Validar informacion de datos generales
	*/
	var params1 = validarGenerales();
	if(!params1){
		return false;
	}

	/*
	#	Validacion de Informacion Especial
	*/
	var params2 = validarEspeciales();
	if(!params2){
		return false;
	}

	/*
	#	Validacion del Modulo de configuacion
	*/
	var params3 = validarConfiguracion();
	if(!params3){
		return false;
	}
    
    var params6 = validarLiquidacion();
    if(!params6){ return false;}

	/*
	#	Validacion del Paquete Comercial
	*/
	var params4 = validarPaqueteComercial();
	if(!params4){
		return false;
	}

	/*
	#	Validar datos Bancarios
	*/
	var params5 = validarDatosBancarios();
	if(!params5){
		return false;
	}
    var ctaclabe = $('#txtCLABE').val();
    if(edicion == true){ 
       
       
        if(cuentabancaria == ctaclabe){}else{
            if(codCtaBanc == false){showToastMsg('El Numero de Cuenta Bancario ya ha sido previamente regirstrado');return;} 
        }
    
    
    }else{if(codCtaBanc == false){showToastMsg('El Numero de Cuenta Bancario ya ha sido previamente regirstrado...');return;} }
 
	/*
	#	Validar Contactos
	*/
	/*var params6 = validarContactos();
	if(!params6){
		return false;
	}*/


	var familias				= params3.nIdFamilias;
	var validar_representante	= false;

	for(i in familias){
		if(familias[i] == 3 || familias[i] == 5 || familias[i] == 7){
			validar_representante = true;
		}
	}

	if(validar_representante){
        
		var params7 = validarRepresentanteLegal();
		if(!params7){
			return false;
		}
        
  //var RlRFC     = $('#txtRFCRepresentante').val();
  var RlIdent   = $('#txtNumeroIdentificacionRepresentante').val();
          if(replegeditar == 1 || edicion == true){ 
           
            
                 if(replegidnum == RlIdent){}else{
                if(codrlidnum == false){showToastMsg('El Numero de Identificacion del Representante Legal ya ha sido previamente regirstrado');return;} 
                }
        }else{
            
            if(codrlidnum == false){showToastMsg('El Numero de Identificacion del Representante Legal ya ha sido previamente regirstrado...');return;} 
        }
        
        
	}

	var params = {
		datosGenerales 		: params1,
		informacionEspecial	: params2,
		configuracion		: params3,
		paqueteComercial	: params4,
		datosBancarios		: params5,
		Liquidaciones		: params6
	}

	if(validar_representante){
		params.representanteLegal = params7;
	}

	$.ajax({
		url			: './application/controllers/NuevoProspecto.php',
		type		: 'POST',
		contentType	: false,
        
		data		: FORM_DATA,
		processData	: false,
		cache		: false,
		dataType	: 'json'
	})
	.done(function(resp){
        if(resp.records == 1){redireccionar();}else{toasts('Algo salio mal, contacte al departamento de sistemas');}
        
    
    
    })
	.fail(function() {console.log("error");})
	.always(function() {
	console.log("complete");
	});

	console.log(params);
     //document.location.href = 'registroCliente.php'
}

function redireccionar(){document.location.href = 'registroCliente.php'}

function llenaDatosEdicion(){
    
    
    var rfcssss = $("#txtRFC").val();
     if(est == 2){
       
          $.post( "./application/models/CargarDatosGenerales.php",
                                    { rfc: rfcssss },
	                                   function ( respuesta ) {
                     
		                                      edicion = true;
                                                
              
                                                $('#txtIdCadena').val(respuesta.idcad);
                                                $('#txtSCadena').val(respuesta.nomcad);
                                                $('#cmbSocio').val(respuesta.idsoc);
              
                                        if(idregimenvar == 1){
                                               
                                                  $('#nombrefisico').val(respuesta.nombre);
                                                  $('#sPaternoCliente').val(respuesta.paterno);
                                                  $('#sMaternoCliente').val(respuesta.materno);
                                            
                                            
                                            //informacion especial persona fisica
                                                  //$('#txtPoliticamenteExpuesto').val(respuesta.polexp1);
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
                                                  
                                                  //$('#chkPoliticamenteExpuesto').val(respuesta.polexp2);
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
                                                //$('#txtCodigoPostal').val(respuesta.cp);
              
                                                $('#txtCLABE').val(respuesta.clabe);
                                                $('#cmbBanco').val(respuesta.banco);
                                                $('#txtCuenta').val(respuesta.cuenta);
                                                cuentabancaria = respuesta.clabe;
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
              
              ///informacion configuracion
                                        
                var fams = respuesta.familias;
                var datsRL = false;
                for(var i=0; i< fams.length; i++) {
                $('input[type=checkbox][name=nIdFamilia][value='+fams[i]+']').prop('checked', true);
                 if(fams[i] == 3 || fams[i] == 5  ||fams[i] == 7) { datsRL = true;}  // para mostrar  o esconder los datos del RL                              
                                                  
                }
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
              
                                                replegRFC = respuesta.rfcRL;    
                                                $('#txtCURPRepresentante').val(respuesta.curpRL);
                                                //$('#cmbTipoIdentificacionRepresentante').val(respuesta.externo); 
                                                $('#txtNumeroIdentificacionRepresentante').val(respuesta.numidRL);
                                                replegidnum = respuesta.numidRL; 
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
                                        
                               //respuesta.ncoloniaRL                 
                                            if(respuesta.cpR !== undefined){
                                                    buscarColoniasRL(respuesta.cpR, respuesta.ncoloniaRL);
              
                                                }
              
                                }, "json");
       
     }
    
}

function cargadocs(){}

function eliminarsolicitud(){
    var r = confirm('¿Desea Eliminar esta Solicitud?');
    if(r == true){
    var RFCPROS = $('#txtRFC').val();
    
    $.post("./application/models/RE_EliminarSolicitud.php",{rfcpros : RFCPROS},function(respuesta){
        if(respuesta.records > 0){
         
            alert('no se ha podido eliminar la solicitud'); 
        }else{document.location.href = 'registroCliente.php'}
    });
    }
  
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
			formdata.append('rfc', $('#formDatosGenerales :input[name=sRFC]').val());
            formdata.append('usr',usr);
                
            if(file.type != 'application/pdf'){
				showToastMsg('El archivo debe ser formato pdf');
				return;
            }else{
				$.ajax({
					url			: './application/controllers/documentosProspecto.php',
					type		: 'POST',
                    
					contentType	: false,
					data		: formdata,
                    mimeType :"multipart/form-data",
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

function validarRepRfCId(){// verifica si ya existe un  rfc y numero de identificacion en  las bases de datos
 
    var RlIdent = $('#txtNumeroIdentificacionRepresentante').val(); 
    
    $.post('./application/models/RepLegalValidaciones.php',{idnum:RlIdent},function(resp){
        
        if(resp.codid == 0){ codrlidnum = true;}else{ codrlidnum = false;}
        
        
    },"JSON");
    
}


function validarCuentaBancaria(){//verfica si ya existe una cuenta bancaria en las bases de datos.
    var txtclabe = $('#txtCLABE').val();
    $.post('./application/models/ProspectoCuentaBancariaValidar.php',{cuenta:txtclabe},function(resp){
        
       
       if(resp.codcta == 0){ codCtaBanc = true;}else{codCtaBanc = false;}
        
    },"JSON");
}

function buscarRepresentanteLegal(){
    
    var rfc  = $('#txtRFCRepresentante').val();
    
    $.post('./application/models/RepresentanteLegalBuscar.php',{rfc:rfc},function(resp){
        

            //$('#txtRFCRepresentante').val(resp.rfc);
            $('#txtNombreRepresentante').val(resp.nombre);
            $('#txtPaternoRepresentante').val(resp.paterno);
            $('#txtMaternoRepresentante').val(resp.materno);
            $('#txtFechaNacimientoRepresentante').val(resp.fnac);
            $('#cmbNacionalidadRepresentante').val(resp.idnac);
            $('#txtCURPRepresentante').val(resp.curp);
        
            $('#cmbTipoIdentificacionRepresentante').val(resp.tipoid);
            $('#txtNumeroIdentificacionRepresentante').val(resp.numid);
            $('#txtTelefonoRepresentante').val(resp.telefono);
            $('#txtEmailRepresentante').val(resp.mail);
            $('#txtCalleRepresentante').val(resp.calle);
            $('#txtNumIntRepresentante').val(resp.numint);
            $('#txtNumExtRepresentante').val(resp.numext);
            $('#txtCodigoPostalRepresentante').val(resp.cp);
            $('#txtNIdDocIdentificacion').val(resp.idocid);
            $('#txtNIdDocPoder').val(resp.idocpod);
            $('#cmbOcupacionRepresentante').val(resp.idocup)            
            buscarColoniasRL(resp.cp, resp.idcol);
            $('#cmbColoniaRepresentante').val(resp.idcol);
        
         if(resp.expuesto == 1){$('#chkPoliticamenteExpuestoRepresentante').prop('checked', true); }
        
        var r = resp.rfc;
        if(r.length > 0){  replegeditar = 1;  replegidnum = resp.numid; }else{      }
        
    },"JSON");
    
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




function familiasarray(cb,valor){
    
    
//console.log(cb);
  if (cb.checked==true) 
        {
      //alert(valor);
 
  	             famsarr.push(valor);
            familiasarr = 'in('+famsarr+')';
                
  
    } 

  if (cb.checked==false) 

    {


		for(var i = 0; i< famsarr.length; i++){
        while(famsarr[i] == valor) famsarr.splice(i,1);
            
		}

familiasarr = 'in('+famsarr+')';

  
  }

  //alert(familiasarr);  
    
}

function editarcom(idpermiso){
    
    
    $.post('./application/models/listaPermisosporID.php',{permiso:idpermiso},function(res){
        
        if(res.perm > 0){
            
           // $('#cmbVer').val(res.perm);
            $('#cmbVer').val(res.version);
            $('#cmbRuta').val(res.ruta);
            $('#cmbProductos').val(res.producto);
            $('#txtporcom').val(res.porComCorr);
            $('#txtimpcom').val(res.impComCorr);
            $('#txtporgrp').val(res.porComGrp);
            $('#txtimpgrp').val(res.impComGrp);
            $('#txtporusr').val(res.porComCte);
            $('#txtimpousr').val(res.impComCte);
            $('#txtporesp').val(res.porComEsp);
            $('#txtimpesp').val(res.impComEsp);
            $('#txtporcost').val(res.porCostPerm);
            $('#txtimpcost').val(res.impcostPerm);
            $('#txtimpmax').val(res.impMaxPerm);
            $('#txtimpmin').val(res.impMinPerm);
            
            cargaruta(res.producto,res.ruta);
        }else{showToastMsg('No se encontraron datos del con el Id del permiso');}
        
    },"JSON");
   
    
}

function cargaruta(producto,ruta){
    
    //alert(producto+' '+ruta);
    
    $.post('./application/models/Cat_rutasPorProducto.php',{prod:producto,ruta:ruta},function(mensaje){ 
        
        $("#cmbRuta").html(mensaje); });
    
    
    setTimeout(function(){ consultaruta($("#cmbRuta").val())},500); 
}





 var validadoper= false;
 var valido = false;

function guardarpermisos(){     
    
   var rfcprospecto = $('#txtRFC').val();
    var productop = $('#cmbProductos').val();
    var rutap = $('#cmbRuta').val();
    
    
    if($('#cmbVer').val() == -1){showToastMsg('Por Favor seleccione una version'); return;    }
     if($('#cmbProductos').val() == -1){showToastMsg('Por Favor seleccione un Producto'); return;    }
     if($('#cmbRuta').val() == '' ||$('#cmbRuta').val() == undefined){showToastMsg('Por Favor seleccione una Ruta'); return;   }
    
    
     if($('#txtporcom').val() == '' ||$('#txtimpcom').val() == '' ||$('#txtporgrp').val() == '' ||$('#txtimpgrp').val() == '' ||$('#txtporusr').val() == '' ||$('#txtimpousr').val() == '' ||$('#txtporesp').val() == '' ||$('#txtimpesp').val() == '' ||$('#txtporcost').val() == '' ||$('#txtimpcost').val() == '' ||$('#txtimpmax').val() == '' ||$('#txtimpmin').val() == ''){showToastMsg('Todos los campos son requeridos'); return;   }
    if($('#txtimpmax').val() < $('#txtimpmin').val()){showToastMsg('El Importe Maximo debe ser igual o mayor que el Importe Minimo'); return; }
    
    
    
   validarpermisosduplicados(rfcprospecto,productop,rutap);
    
     validarutas();
    
    setTimeout(function(){
    if(validadoper == true){
        if(valido == true){
            
            guardaractuliazarpermiso();
            setTimeout(function(){ mostrarlistasProspecto()},500); 
        }else{
            
             showToastMsg('El porcentaje o el importe de la comisión del cliente no debe ser mayor al establecido en la ruta.. verifique');
        }
        
        
    }else{
        showToastMsg('El permiso con  el  producto y ruta ya ha sido previamente registrado');
        
    } },1000);
    
    
    
  
}


function guardaractuliazarpermiso(){
    
var idperm = $('#txtidperm').val(); 
var rfc = $('#txtRFC').val();
var cadena = $('#txtIdCadena').val();
var subcadena = -1;
var version = $('#cmbVer').val();
var ruta = $('#cmbRuta').val();
var producto = $('#cmbProductos').val();
var prioridad = 2;
var vigenciaini = 0;
var vigenciafin = 0;
var percte = $('#txtporcom').val();
var impcte = $('#txtimpcom').val();
var pergrp = $('#txtporgrp').val();
var impgrp = $('#txtimpgrp').val();
var perusr = $('#txtporusr').val();
var impusr = $('#txtimpousr').val();
var peresp = $('#txtporesp').val();
var impesp = $('#txtimpesp').val();
var percosto = $('#txtporcost').val();
var impcosto = $('#txtimpcost').val();
var impmax = $('#txtimpmax').val();
var impmin = $('#txtimpmin').val();
var estatus = 0; 
var empleado = usr; //verificar  de donde viene
    
    
    $.post('./application/models/CrearPermisosProspecto.php',{idperm:idperm,
                                                              rfc:rfc,
                                                              cadena:cadena,
                                                              subcadena:subcadena,
                                                              version:version,
                                                              ruta:ruta,
                                                              producto:producto,
                                                              prioridad:prioridad,
                                                              vigenciaini:vigenciaini,
                                                              vigenciafin:vigenciafin,
                                                              percte:percte,
                                                              impcte:impcte,
pergrp:pergrp,impgrp:impgrp,perusr:perusr,impusr:impusr,peresp:peresp,impesp:impesp,percosto:percosto,impcosto:impcosto,impmax:impmax,impmin:impmin,estatus:estatus,empleado:empleado},function(res){
        
        if(res.codigo = 0){
            
             
            
            showToastMsg(res.mensaje);
           
           
        }else{
             showToastMsg(res.mensaje);
            
        }
    },'JSON');
    
    
    
}


function mostrarlistasProspecto(){
    
    //alert('si entra');
 var rfc =   $('#txtRFC').val();
    
    
  
       
        $.post('./application/models/listasComisionesProspecto.php',{rfc:rfc},function(mensaje){
           $("#tablalistaProspecto").html(mensaje); 
            
        });
        
        
        //$('#comisionesListado').modal('show');
    
    
    

   
    
}

function editarcompros(idperm){
    
    alert(idperm);
}

function eliminarcomision(idperm){
     eliminarcompros(idperm);
     setTimeout(function(){ mostrarlistasProspecto()},500);
}


function eliminarcompros(idperm){
    
    
    var r= confirm('Desea eliminar el permiso?');
    
    //alert(idperm);
    
    if(r== true){
    
    $.post('./application/models/listasComisionesProspectoEliminar.php',{idperm:idperm},function(res){
        
        if(res.cod = 0){
           
             showToastMsg(res.msg);
        }else{
            
            showToastMsg(res.msg); 
            
        }
        
    },'JSON');
    }
}


function validarpermisosduplicados(rfc,producton,rutan){
    
    $.post('./application/models/listasComisionesProspectoValidar.php',{rfc:rfc,producto:producton,ruta:rutan},function(res){
        if(res.cuenta > 0){validadoper = false;} else {validadoper = true;}
    },"JSON");
    
}


function consultaruta(ruta){
    
    $.post('./application/models/listaConsultaRuta.php',{ruta:ruta},function(res){
        
            
            $('#txtporcom').val(res.perComCor);
            $('#txtimpcom').val(res.impComCor);
            $('#txtporgrp').val('0.0000');
            $('#txtimpgrp').val('0.0000');
            $('#txtporusr').val(res.perComCli);
            $('#txtimpousr').val(res.impComCli);
            $('#txtporesp').val('0.0000');
            $('#txtimpesp').val('0.0000');
            $('#txtporcost').val(res.perCosto);
            $('#txtimpcost').val(res.impCosto);
            $('#txtimpmax').val(res.impMax);
            $('#txtimpmin').val(res.impMin);
        
    },"JSON");
    
}

function validarutas(){
    
var ruta = $('#cmbRuta').val();
var percte = $('#txtporcom').val();
var impcte = $('#txtimpcom').val();
    
   
    
    $.post('./application/models/listaConsultaRutaValidar.php',{ruta:ruta,perCor:percte,impCor:impcte},function(res){
        
            if(res.cod == 0){valido = true;}else{ valido = false;}
    
        
    },"JSON");
    
    if(valido == 0){return  true;} else {return false;}
    
}

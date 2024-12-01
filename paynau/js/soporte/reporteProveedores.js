// sp_select_proveedor -- Obtiene el proveedor por id. Para obtener Perfil

function initView(){
		var Layout = {
				buscarInformacion : function(){
					Layout._llenarTabla();
				},

		_llenarTabla : function(){
				var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
									"oLanguage": {
									"sZeroRecords": "No se encontraron registros",
									"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
									"sLengthMenu": "Mostrar _MENU_ registros",
									"sSearch": "Buscar:"  ,
									"sInfoFiltered": " - filtrado de _MAX_ registros",
									"oPaginate": {
									"sNext": "Siguiente",
									"sPrevious": " Anterior"
										}
									},
									"bSort" :false
									};
				
				$("#data tbody").empty();
				var datos = $("#data").DataTable();
				datos.fnClearTable();
				datos.fnDestroy();

				
				
				$.post(BASE_URL +"/paynau/ajax/soporte/getProveedores.php",
				{
					nIdProveedor : 0,
					itipo : 1
				}, 
				function(response){
					 var obj = jQuery.parseJSON(response);
					  jQuery.each(obj, function(index,value) {
					 
					 $('#data tbody').append('<tr>'+
							'<td >'+obj[index]['nIdProveedor']+'</td>'+
							'<td >'+obj[index]['sRFC']+'</td>'+
							'<td > '+obj[index]['sRazonSocial']+'</td>'+
							'<td >'+obj[index]['sNombre']+'</td>'+
							'<td >'+obj[index]['sCorreo']+'</td>'+
							'<td > '+obj[index]['sTelefono']+'</td>'+
							'<td > '+obj[index]['sCLABE']+'</td>'+
							'<td > <button id="verDetalle" data-proveedor='+obj[index]['nIdProveedor']+' data-nombreProveedor ="'+obj[index]['sNombre']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+
							'</tr>');
					  });
					  datos.DataTable(settings);
				})
				.fail(function(resp){
						alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
				});
		},



		initBotones : function(){
			$('#miEmpresa').on('click', function(){
				if ($('#empresaEmpresa').val()==0) {
					jAlert("Aun no se ha seleccionado una empresa");
					return false;
				}
			});

			$(document).on('click','#verDetalle',function(e){
				$('#empresaEmpresa').val(0);
				proveedor = this.attributes['data-proveedor'].value;
				nombreProveedor = this.attributes['data-nombreProveedor'].value;
				 $('#nIdProveedor').val(proveedor);
				 
				initProveedor(proveedor);
				getDetalleProveedor(proveedor,nombreProveedor);
				$('#miProveedor').click();
			});

			$(document).on('click','#verDetalleEmpresa',function(e){
				
				nIdEmpresa = this.attributes['data-empresa'].value;
				nombreEmpresa = this.attributes['data-nombreEmpresa'].value;
				nIdEmisor = this.attributes['data-emisor'].value;
				$('#empresaEmpresa').val(nIdEmpresa);
				getDetalleEmpresa(nIdEmpresa, nIdEmisor);
			});

			$(document).on('click','#listaProveedores',function(e){
				$("#dataOrdenes tbody").empty();
				Layout._llenarTabla();
			});

			$('#btnReporteUsuario').on('click', (e)=>{
				e.preventDefault();
				reporteUSuarios();
			});
		}
	}

	
	Layout.initBotones();
	
	Layout._llenarTabla();

} // initViewComision


var settings = {"iDisplayLength": 10, // configuracion del lenguaje del plugin de la tabla
									"oLanguage": {
									"sZeroRecords": "No se encontraron registros",
									"sInfo": "Mostrando _TOTAL_ registros (_START_ de _END_)",
									"sLengthMenu": "Mostrar _MENU_ registros",
									"sSearch": "Buscar:"  ,
									"sInfoFiltered": " - filtrado de _MAX_ registros",
									"oPaginate": {
									"sNext": "Siguiente",
									"sPrevious": " Anterior"
										}
									},
									"bSort" :false
									};

function initProveedor(nIdProveedor){
var proveedor = null;
proveedor = {
		init : function(){
			proveedor.initInputs();
			proveedor.initBotones();
			proveedor.initCombos();
			proveedor.cargaInformacion();
			proveedor.initLogotipo();
		},

		initInputs : function(){

			$('#txtSRFC, #txtSRFC').alphanum({
				allowSpace			: false,
				allowOtherCharSets	: false,
				maxLength			: 13
			});

			$('#txtSRFC, #txtSRFC').css('text-transform', 'uppercase');

			
			//$('#txtSTelefono1, #txtSTelefono, #txtSCelular, #txtSCelular1').unmask().mask('00 0000 0000');

			$('#txtSTelefono, #txtSCelular, #txtSTelefono1, #txtSCelular1').alphanum({
				allow				: '()-',
				disallow			: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
				allowNumeric		: true,
				allowLatin			: true,
				allowOtherCharSets	: false,
				maxLength			: 13
			});

			$('#txtSNombreComercial').alphanum({
				allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00FC\u00F1\u00D1\u00C1\u00C9\u00CD\u00D3\u00DA\u00DC',
				allowOtherCharSets	: false,
				maxLength			: 100
			});

			$('#txtSTarjeta').numeric({
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				allowLeadingSpaces	: false,
				maxDigits			: 16,
				maxDecimalPlaces	: 0
			});

			$('#txtSCLABE').numeric({
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				allowLeadingSpaces	: false,
				maxDigits			: 18,
				maxDecimalPlaces	: 0
			});

			$('#txtSCalle').alphanum({
				allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00FC\u00F1\u00D1\u00C1\u00C9\u00CD\u00D3\u00DA\u00DC.',
				allowOtherCharSets	: false,
				allowNumeric		: false,
				maxLength			: 30
			});

			$('#txtSNumeroExterior').numeric({
				allowPlus			: false,
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				maxDigits			: 10,
				maxDecimalPlaces	: 0
			});

			$('#txtSNumeroInterior').alphanum({
				allowOtherCharSets	: false,
				allowNumeric		: true,
				maxLength			: 10
			});

			$('#txtSCodigoPostal').numeric({
				allowPlus			: false,
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: false,
				maxDigits			: 5,
				maxDecimalPlaces	: 0
			});

			$('#txtSCodigoPostal').on('keyup', function(e){
				var sCodigoPostal = e.currentTarget.value;

				if(sCodigoPostal.length == 5){
					proveedor.cargaInformacionCP(sCodigoPostal);
				}
				else{
					$('#cmbColonia, #cmbEstado, #cmbCiudad').val(0);
				}
			});
			$('#empresaCodigoPostal').on('keyup', function(e){
				var sCodigoPostalEmpresa = e.currentTarget.value;

				if(sCodigoPostalEmpresa.length == 5){
					cargarColonias(sCodigoPostalEmpresa);
				}
				else{
					$('#empresaColonia, #empresaEstado, #empresaCiudad').val(0);
				}
			});
		},

		initBotones : function(){
			$('#aLogotipo').on('click', function(e){
				$('#fLogotipo').trigger('click');
			});

			$('#fLogotipo').on('change', function(e){
				proveedor.subeImagen();
			});

			$('#btnEditar').on('click', function(){
				proveedor.muestraInputs();
			});


		},

		muestraInputs : function(){

			sRfc = $('#txtSRFC').val();
			if($('#cmbRegimen').val() == 1){
				$('#txtSTelefono1').prop('disabled', false);
				$('#txtSCelular1').prop('disabled', false);
			}
			else{
				$('#txtSTelefono').prop('disabled', false);
				$('#txtSCelular').prop('disabled', false);
				$('#cmbGiro').prop('disabled', false);
				$('#txtSNombreComercial').prop('disabled', false);
			}

			if(nIdTipoCuenta == 1 && sRfc == ""){
				
				$('#txtSRFC').prop('disabled', false);
			
			}


			$('#txtSTarjeta').prop('disabled', false);
			$('#txtSCLABE').prop('disabled', false);

			$('#btnGuardar').show();
			$('#btnEditar').hide();

			$('#btnGuardar').unbind('click');
			$('#btnGuardar').on('click', function(e){
				proveedor.guardarInformacion();
			});

			$('#txtSCalle').prop('disabled', false);
			$('#txtSNumeroExterior').prop('disabled', false);
			$('#txtSNumeroInterior').prop('disabled', false);
			$('#txtSCodigoPostal').prop('disabled', false);
			$('#cmbColonia').prop('disabled', false);
		},

		initCombos : function(){

		},

		initLogotipo : function(){
//			$('#imgLogotipoProv').hover(function(){
//				if($('#imgLogotipoProv').attr('src') != ''){
//					$('.pt-user-name').html('CAMBIA TU LOGOTIPO');
//					$('#aLogotipo').show();
//					$('#imgLogotipoProv').hide();
//				}
//			});
//
//			$('#aLogotipo').hover(function(){
//
//			}, function(){
//				if($('#imgLogotipoProv').attr('src') != ''){
//					$('#aLogotipo').hide();
//					$('#imgLogotipoProv').show();
//					$('#imgLogotipoProv').show();
//				}
//			});
		},

		cargaInformacion : function(){
			showSpinner();
			$.ajax({
				url			: BASE_URL + '/paynau/ajax/soporte/getProveedores.php',
				type		: 'POST',
				dataType	: 'json',
				data : {itipo : 2, nIdProveedor : nIdProveedor }
			})
			.done(function(resp){
					
					$('#datosProveedor').click();
					
					var prov = resp[0];

					prov.nIdEstatus = mostrarActivacionCuenta(prov.nIdEstatus, nIdProveedor);

					proveedor.nIdRegimen = prov.nIdRegimen;

					$('#cmbRegimen').customLoadStore({
						url				: BASE_URL + '/paynau/ajax/soporte/storeRegimen.php',
						labelField		: 'sNombre',
						idField			: 'nIdRegimen',
						firstItemId		: '0',
						firstItemValue	: 'Seleccione'
					});

					$('#cmbGiro').customLoadStore({
						url				: BASE_URL + '/paynau/ajax/soporte/storeGiro.php',
						labelField		: 'sNombreGiro',
						idField			: 'nIdGiro',
						firstItemId		: '0',
						firstItemValue	: 'Seleccione'
					});

					$('#cmbRegimen').on('storeLoaded', function(e){
						$('#cmbRegimen').val(prov.nIdRegimen);
					});

					$('#cmbGiro').on('storeLoaded', function(e){
						$('#cmbGiro').val(prov.nIdGiro);
					});

					if(prov.nIdRegimen == 1){
						$('#span-sNombreComercial').html(prov.sNombre + ' ' + prov.sApellidoPaterno + ' ' + prov.sApellidoMaterno);
						$('#span-sRazonSocial').html(prov.sCorreo);

						prov.sCorreo1	= prov.sCorreo;
						prov.sTelefono1 = prov.sTelefono;
						prov.sCelular1	= prov.sCelular;
					}
					else{
						$('#span-sNombreComercial').html(prov.sNombreComercial);
						$('#span-sRazonSocial').html(prov.sRazonSocial);
					}

					if(prov.nIdRegimen == 1){
						$('.blockmoral').removeClass('d-block').addClass('d-none');
						$('.blockfisica').removeClass('d-none').addClass('d-block');
					}
					else{
						$('.blockmoral').removeClass('d-none').addClass('d-block');
						$('.blockfisica').removeClass('d-block').addClass('d-none');
					}

					$('#span-nIdNivel').html('Nivel ' + prov.nIdNivel);
					for(var propiedad in prov){
						var sPropiedad = propiedad.charAt(0).toUpperCase() + propiedad.slice(1);
						if($('#txt' + sPropiedad).length > 0){
							$('#txt' + sPropiedad).val(prov[propiedad]);
						}
					}


					$.ajax({
						url			: BASE_URL + '/paynau/ajax/soporte/getDetalleCuentaProveedor.php',
						type		: 'POST',
						dataType	: 'json',
						data : { nIdProveedor : nIdProveedor }
					})
					.done(function(resp){

						
						if (resp.oDireccion.length != 0) {

							var oDireccion = resp.oDireccion[0];
							var oCuenta = resp.oCuenta[0];
							
							for(var propiedad in oDireccion){
								var sPropiedad = propiedad.charAt(0).toUpperCase() + propiedad.slice(1);
								if($('#txt' + sPropiedad).length > 0){
									$('#txt' + sPropiedad).val(oDireccion[propiedad]);
								}
							}

							$('#cmbColonia').append('<option value="'+oDireccion.nIdColonia+'">'+oDireccion.sNombreColonia+'</option>');
							$('#cmbColonia').val(oDireccion.nIdColonia);

							$('#cmbEstado').append('<option value="'+oDireccion.nIdEntidad+'">'+oDireccion.sNombreEntidad+'</option>');
							$('#cmbEstado').val(oDireccion.nIdEntidad);

							$('#cmbCiudad').append('<option value="'+oDireccion.nIdCiudad+'">'+oDireccion.sNombreCiudad+'</option>');
							$('#cmbCiudad').val(oDireccion.nIdCiudad);

							

							for(var propiedad in oCuenta){
								var sPropiedad = propiedad.charAt(0).toUpperCase() + propiedad.slice(1);
								if($('#txt' + sPropiedad).length > 0){
									$('#txt' + sPropiedad).val(oCuenta[propiedad]);
								}
							}

							if(prov.sNombreImagen != ''){
//								document.getElementById("imgLogotipoProv").src=prov.sNombreImagen+"?random="+new Date().getTime();;
								$('#aLogotipo').hide();
							}

							//$('#txtSTelefono1, #txtSTelefono, #txtSCelular, #txtSCelular1').unmask().mask('00 0000 0000');
							$('#cmbBanco').customLoadStore({
								url				: BASE_URL + '/paynau/ajax/soporte/storeBanco.php',
								labelField		: 'sNombreBanco',
								idField			: 'nIdBanco',
								firstItemId		: '0',
								firstItemValue	: 'Seleccione'
							});

							$('#cmbBanco').on('storeLoaded', function(e){
								var sCLABE = oCuenta.sCLABE;
								if(sCLABE != null && myTrim(sCLABE) != ''){
									var nIdBanco = sCLABE.substr(0,3);
									$('#cmbBanco').val(parseInt(nIdBanco));
								}
							});
						}else{
							jAlert("No se encontraron los datos de la diteccion y cuenta");
						}
					}).fail(function(){
							jAlert("Error en la carga de la diteccion y cuenta");
					});
			})
			.fail(function(){
			})
			.always(function(){
				hideSpinner();
			});
		},

		subeImagen : function(){
			var sNombreImagen	= $('#fLogotipo').val();
			var arr_n			= sNombreImagen.split('.');

			var formato			= 'jpg';
			var ext				= arr_n.pop();

			if(ext.toLowerCase() != formato){
				swal({icon : 'warning', text : 'El formato de la imagen debe ser '+ formato});
				return false;
			}

			var formData = new FormData();

			if(sNombreImagen != undefined && myTrim(sNombreImagen) != ''){
				var archivo	= $('#fLogotipo')[0].files[0];
				formData.append('sImagenProveedor', archivo);
			}
			console.log(archivo);
			$.ajax({
				url			: BASE_URL + '/ajax/proveedor/subeImagen.php',
				type		: 'POST',
				dataType	: 'json',
				contentType	: false,
      			processData	: false,
				data		: formData
			})
			.done(function(resp){
				console.log(resp);
				var sesion = validarSesion(resp);

				if(!sesion){
					return false;
				}
				else{
					if(resp.nCodigo == 0){
					
						var newImage = new Image();
						/*newImage.src = resp.sUrl;

						document.getElementById("imgLogotipoProv").src = newImage.src;

						newImage.src = resp.sUrl + "?" + new Date().getTime();*/
//						document.getElementById("imgLogotipoProv").src=resp.sUrl+"?random="+new Date().getTime();;
						$('#aLogotipo').hide();
					}
					else{
						swal({icon : 'error', text : resp.sMensaje});
					}
				}
			})
			.fail(function(){
			})
			.always(function(){
			});
		},

		guardarInformacion : function(){

			sRfc = $("#txtSRFC").val();

			if(nIdTipoCuenta == 1 && sRfc !=""){

				sRfc = myTrim(sRfc);

				if(sRfc.length != 13){
					swal({icon : 'warning', text : 'Captura un RFC válido'}).then(function(){
							$('#txtSRFC').focus();
					});
					return false;
				}

				if(!isValidRFC(sRfc)){
					swal({icon : 'warning', text : 'Captura un RFC válido'}).then(function(){
						$('#txtSRFC').focus();
					});
					return false;
				}
			}

			if(nIdTipoCuenta == 2){
				sRfc = '';
			}

			if(proveedor.nIdRegimen == 2){
				var sTelefono			= $('#txtSTelefono').val();
				var sCelular			= $('#txtSCelular').val();
				var sNombreComercial	= $('#txtSNombreComercial').val();
				var nIdGiro				= $('#cmbGiro').val();
			
				if(sNombreComercial == undefined || myTrim(sNombreComercial) == ''){
					swal({icon : 'warning', text : 'Captura Nombre Comercial'}).then(function(){
						$('#txtSNombreComercial').focus();
					});
				}

				if(sTelefono == undefined || myTrim(sTelefono) == '' || sTelefono.length != 12){
					swal({icon : 'warning', text : 'Capture Número de Teléfono'}).then(function(){
						$('#txtSTelefono').focus();
					});
					return false;
				}

				if(sCelular == undefined || myTrim(sCelular) == '' || sCelular.length != 12){
					swal({icon : 'warning', text : 'Capture Número de Celular'}).then(function(){
						$('#txtSCelular').focus();
					});
					return false;
				}

				if(nIdGiro == undefined || nIdGiro == '' || nIdGiro <= 0){
					swal({icon : 'warning', text : 'Seleccine Giro'}).then(function(){
						$('#cmbGiro').focus();
					});
					return false;
				}
			}
			else{
				var sTelefono			= $('#txtSTelefono1').val();
				var sCelular			= $('#txtSCelular1').val();

				if(sTelefono == undefined || myTrim(sTelefono) == '' || sTelefono.length != 12){
					swal({icon : 'warning', text : 'Capture Número de Teléfono'}).then(function(){
						$('#txtSTelefono1').focus();
					});
					return false;
				}

				if(sCelular == undefined || myTrim(sCelular) == '' || sCelular.length != 12){
					swal({icon : 'warning', text : 'Capture Número de Celular'}).then(function(){
						$('#txtSCelular1').focus();
					});
					return false;
				}
			}

			var sCalle				= $('#txtSCalle').val();
			var nNumeroExterior		= $('#txtSNumeroExterior').val();
			var nNumeroInterior		= $('#txtSNumeroInterior').val();
			var sCodigoPostal		= $('#txtSCodigoPostal').val();
			var nIdColonia			= $('#cmbColonia').val();
			var nIdCiudad			= $('#cmbCiudad').val();
			var nIdEstado			= $('#cmbEstado').val();

			if(sCalle == undefined || myTrim(sCalle) == ''){
				swal({icon : 'warning', text : 'Captura Calle'}).then(function(){
					$('#txtSCalle').focus();
				});
				return false;
			}

			if(nNumeroExterior == undefined || myTrim(nNumeroExterior) == ''){
				swal({icon : 'warning', text : 'Captura Número Exterior'}).then(function(){
					$('#txtSNumeroExterior').focus();
				});
				return false;
			}

			if(sCodigoPostal == undefined || myTrim(sCodigoPostal) == ''){
				swal({icon : 'warning', text : 'Captura Código Postal'}).then(function(){
					$('#txtSCodigoPostal').focus();
				});
				return false;
			}

			if(nIdColonia == undefined || nIdColonia == '' || nIdColonia <= 0){
				swal({
					icon : 'warning',
					text : 'Selecciona Colonia'
				}).then(function(){
					$('#cmbColonia').focus();
				});
				return false;
			}

			if(nIdColonia == undefined || nIdCiudad == undefined || nIdEstado == undefined || nIdColonia == '' || nIdCiudad == '' || nIdEstado == '' ||
				nIdColonia <= 0 || nIdCiudad <= 0 || nIdEstado <= 0){
				swal({icon : 'warning', text : 'Captura Código Postal nuevamente para cargar Colonia, Ciudad y Estado'}).then(function(){
					$('#txtSCodigoPostal').focus();
				});
				return false;
			}

			var sCLABE		= $('#txtSCLABE').val();
			var sTarjeta	= $('#txtSTarjeta').val();

			if((sTarjeta == undefined || myTrim(sTarjeta) == '') && (sCLABE == undefined || myTrim(sCLABE) == '')){
				swal({icon : 'warning', text : 'Captura Tarjeta o CLABE'}).then(function(e){
					$('#txtSCLABE').focus();
				});
				return false;
			}

			/*if(sTarjeta != '' && sTarjeta.length != 16){
				swal({icon : 'warning', text : 'La longitud de la Tarjeta debe ser de 16 dígitos'}).then(function(){
					$('#txtSNumTarjeta').focus();
				});
				return false;
			}*/

			if(sTarjeta != ''){
				
				if(!(sTarjeta.indexOf("************") > -1)){
					if(!validateCardNumber(sTarjeta)){
						swal({icon : 'warning', text : 'Capture un número de Tarjeta Válido'}).then(function(){
							$('#txtSNumTarjeta').focus();
						});
						return false;
					}
				}
			}

			if(sCLABE != '' && sCLABE.length != 18){
				swal({icon : 'warning', text : 'La longitud de la CLABE debe ser de 18 dígitos'}).then(function(){
					$('#txtSCLABE').focus();
				});
				return false;
			}

			if(!validarDigitoVerificador(sCLABE)){
				swal({icon : 'warning', text : 'Capture un Número de CLABE válido'}).then(function(){
					$('#txtSCLABE').focus();
				});
				return false;
			}

			swal({
				title		: "Guardar Información",
				text		: "¿Desea guardar la información capturada?",
				icon		: "warning",
				buttons		: true,
				dangerMode	: true,
				buttons		: {
					cancel: {
						text		: "No",
						value		: false,
						visible		: true,
						className	: 'btn-swal-cancelar'
					},
					confirm: {
						text		: "Sí",
						value		: true,
						visible		: true,
						closeModal	: false
					}
				},
				closeOnClickOutside : false
			})
			.then(function(willSave){
				if(willSave){
					$('.btn-swal-cancelar').prop('disabled', true);
					$.ajax({
						url			: BASE_URL + '/ajax/proveedor/actualizarProveedor.php',
						type		: 'POST',
						dataType	: 'json',
						data		: {
							sTarjeta			: sTarjeta,
							sCLABE				: sCLABE,
							sNombreComercial	: sNombreComercial,
							sTelefono			: sTelefono,
							sCelular			: sCelular,
							nIdGiro				: nIdGiro,
							sCalle				: sCalle,
							nNumeroExterior		: nNumeroExterior,
							nNumeroInterior		: nNumeroInterior,
							sCodigoPostal		: sCodigoPostal,
							nIdColonia			: nIdColonia,
							nIdCiudad			: nIdCiudad,
							nIdEstado			: nIdEstado,
							sRfc 				: sRfc
						}
					})
					.done(function(resp){
						var sesion = validarSesion(resp);

						if(!sesion){
							return false;
						}
						else{
							if(resp.bExito){
								if($('#cmbRegimen').val() == 1){
									$('#txtSTelefono1').prop('disabled', true);
									$('#txtSCelular1').prop('disabled', true);
									$('#txtSRFC').prop('disabled', true);
								}
								else{

									$('#txtSTelefono').prop('disabled', true);
									$('#txtSCelular').prop('disabled', true);
									$('#cmbGiro').prop('disabled', true);
									$('#txtSNombreComercial').prop('disabled', true);
								}

								$('#txtSTarjeta').prop('disabled', true);
								$('#txtSCLABE').prop('disabled', true);
								swal.close();

								$('#btnGuardar').hide();
								$('#btnEditar').show();

								sTarjeta = '************'+sTarjeta.substr(-4);
								$('#txtSTarjeta').val(sTarjeta);

								if($('#cmbRegimen').val() == 2){
									$('#span-sNombreComercial').html(sNombreComercial);
								}

								var sCLABE = $('#txtSCLABE').val();

								if(sCLABE != null && myTrim(sCLABE) != ''){
									var nIdBanco = sCLABE.substr(0,3);

									$('#cmbBanco').val(parseInt(nIdBanco));
								}
							}
							else{
								swal({icon : 'warning', text : resp.sMensaje});
							}
						}
					})
					.fail(function(){
					})
					.always(function(){
						hideSpinner();
					});
					
				}
			});

		},

		cargaInformacionCP : function(sCodigoPostal){
			$('#cmbColonia').customEmptyStore({
				firstItemId		: '0',
				firstItemValue	: 'Seleccione',
			});
			$('#cmbColonia').customLoadStore({
				url				: BASE_URL + '/paynau/ajax/soporte/storeColonias.php',
				labelField		: 'sNombreColonia',
				idField			: 'nIdColonia',
				firstItemId		: '0',
				firstItemValue	: 'Seleccione',
				params			: {
					sCodigoPostal : $('#txtSCodigoPostal').val()
				}
			});
			
			$('#cmbColonia').unbind('storeLoaded');
			$('#cmbColonia').on('storeLoaded', function(e, resp){
				if(resp.bExito){
					var elemento = resp.data[0];

					$('#cmbEstado').customEmptyStore({
						firstItemId		: '0',
						firstItemValue	: 'Seleccione',
					});
					$('#cmbEstado').append('<option value="'+elemento.nIdEntidad+'">'+elemento.sNombreEntidad+'</option>');
					$('#cmbEstado').val(elemento.nIdEntidad);

					$('#cmbCiudad').customEmptyStore({
						firstItemId		: '0',
						firstItemValue	: 'Seleccione',
					});
					$('#cmbCiudad').append('<option value="'+elemento.nNumMunicipio+'">'+elemento.sNombreMunicipio+'</option>');
					$('#cmbCiudad').val(elemento.nNumMunicipio);



					if(resp.data.length == 1){
						$('#cmbColonia').val(resp.data[0].nIdColonia);
					}
				}
			});
		}
	}
	proveedor.init();
}

function getDetalleEmpresa(idEmpresa, nIdEmisor){
 //  $('#empresaCodigoPostal').blur(function(){
	//   var sCodigoPostal = $('#empresaCodigoPostal').val();
	//   cargarColonias(sCodigoPostal);
	// });
	  	
  showSpinner();
  var empresa = idEmpresa;
  $.post(BASE_URL + "/factura/ajax/factura_manual.php",{tipo : 13,idUnidadNegocio:0},
		function(response){
			var obj = jQuery.parseJSON(response);
			if(obj !== null){
				jQuery.each(obj,function(index,value){
					var nombre_cfdi = obj[index]['strRegimenFiscal']+" "+obj[index]['strDescripcion'];
					if(obj[index]['strRegimenFiscal'] == 'P01'){
						$('#empresaActividaFiscal').append('<option selected value="'+obj[index]['strRegimenFiscal']+'">'+nombre_cfdi+'</option>');
					}else{
						$('#empresaActividaFiscal').append('<option value="'+obj[index]['strRegimenFiscal']+'">'+nombre_cfdi+'</option>');
					}
				});
			}
		}
	).fail(function(resp){alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');}).always(function(){hideSpinner();});

  $.post(BASE_URL +'/paynau/ajax/soporte/getDetalleEmpresas.php',{ nIdProveedor : 0, nIdEmpresa : empresa, tipo : 1},
    function(response){   
      var obj = jQuery.parseJSON(response);
      
      conteo = obj.length; 
      datosEmpresa = obj[0];  
      	
      if(conteo > 0){
      	loadLine(nIdEmisor);

      	$('#empresaRFC').val(datosEmpresa.sRFC);
		$('#empresaRazonSocial').val(datosEmpresa.sRazonSocial);
		$('#empresaNombreComercial').val(datosEmpresa.sNombreComercial);
		$('#empresaRegimenFiscal').val(datosEmpresa.nIdRegimen);
		$('#empresaActividaFiscal').val(datosEmpresa.sRegimenFiscal);
		$('#empresaCalle').val(datosEmpresa.sCalle);
		$('#empresaNumeroExterior').val(datosEmpresa.nNumeroExterior);
		$('#empresaNumeroInterno').val(datosEmpresa.nNumeroInterior);
		$('#empresaCodigoPostal').val(datosEmpresa.sCodigoPostal);
		$('#empresaColonia').val(datosEmpresa.nIdColonia);
		$('#empresaCiudad').val(datosEmpresa.nIdCiudad);
		$('#empresaEstado').val(datosEmpresa.nIdEstado);
		$('#empresaEmpresaFacturacion').val(datosEmpresa.nIdEmpresaFacturacion);
		// $('#btnEmpresaCancelar').val(datosEmpresa.);
		$('#btnEditarEmpresa').val(datosEmpresa.nIdEmisor);
		//$('#btnLogo').val(datosEmpresa.sLogo);
		if ($('#empresaRFC').val()!='') {
			// cargarColonias(sCodigoPostal);
			cargarColonias($('#empresaCodigoPostal').val());
		}
      }else{
      	jAlert('No se encontraron datos relacionados a la empresa');
      } 
   })
  .fail(function(resp){
          jAlert('Error al cargar los datos de la empresa');
  }).always(function(){
        hideSpinner();
   });
	$('#miEmpresa').click();
} 

 function loadLine (nIdEmisor){
  		var tabla = $("#dataLineas").DataTable();
				
	    tabla.fnClearTable();
	    tabla.fnDestroy();
  		// gridboxLineas
  		$.post(BASE_URL +"/paynau/ajax/soporte/getDetalleEmpresas.php",
  			{
  				tipo:2, 
  				nIdEmpresa : nIdEmisor
  			},
	    function(response){   
	      var obj = jQuery.parseJSON(response);
	      
	      conteo = obj.length;   
	      if(conteo > 0){
	      	$('#sLineasNegocio').show();
	          // Llenado de la tabla con la informacion de la consulta
	           jQuery.each(obj, function(index,value) {
	        		
	              $('#dataLineas tbody').append('<tr><td style="width: 13%!important;">'+obj[index]['sNombreLineaNegocio']+'</td>'+
	              '<td style="text-align:center;">'+obj[index]['sSerie']+'</td>'+
	              '<td style="text-align:center;">'+obj[index]['nFolioActual']+'</td>'+
	              '<td style="text-align:center;">'+obj[index]['nIdLineaNegocio']+'</td>'+'</td>');
	              // '<td style="text-align:center;"> <button id="verDetalleLinea" data-emisor = '+obj[index]['nIdLineaNegocio']+' data-empresa='+obj[index]['nIdLineaNegocio']+' data-nombreEmpresa ="'+obj[index]['nIdLineaNegocio']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+'</td>');    
	            });

	           table = $("#dataLineas").DataTable(settings);

	      }else{
	      	$('#sLineasNegocio').hide();
	        table = $("#dataLineas").DataTable(settings);
	      } 
	   })
	  .fail(function(resp){
	          alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
	  });
  	}
function getDetalleProveedor(proveedor,empresa){

	var tabla = $("#dataEmpresas").DataTable();
				
    tabla.fnClearTable();
    tabla.fnDestroy();

    $.post(BASE_URL +"/paynau/ajax/soporte/getProveedores.php",{
      nIdProveedor : proveedor,
      nIdEmpresa : empresa,
      itipo : 3
    },
    function(response){   
      var obj = jQuery.parseJSON(response);
      
      conteo = obj.length;   
	 

	  
      if(conteo > 0){
      	$('#sEmpresas').show();
          // Llenado de la tabla con la informacion de la consulta
           jQuery.each(obj, function(index,value) {
        		
              $('#dataEmpresas tbody').append('<tr><td style="width: 13%!important;">'+obj[index]['sRFC']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sRazonSocial']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sNombreComercial']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sCorreo']+'</td>'+
              '<td style="text-align:center;">'+obj[index]['sTelefono']+'</td>'+
              '<td style="text-align:center;"> <button id="verDetalleEmpresa" data-emisor = '+obj[index]['nIdEmisor']+' data-empresa='+obj[index]['nIdEmpresa']+' data-nombreEmpresa ="'+obj[index]['sNombreComercial']+'";  data-placement="top" rel="tooltip" title="Ver Detalle" class="btn habilitar btn-default btn-xs" data-title="Ver Informacion"><span class="fa fa-search"></span></button>'+'</td>');    
            });

           table = $("#dataEmpresas").DataTable(settings);

      }else{
      	$('#sEmpresas').hide();
        table = $("#dataEmpresas").DataTable(settings);
      } 
   })
  .fail(function(resp){
          alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde');
  })
}

function validarBanco(){
	var sCLABE = $("#txtSCLABE").val();

	if(validarDigitoV(sCLABE)==true){
		if(sCLABE != null && myTrim(sCLABE) != ''){
			var nIdBanco = sCLABE.substr(0,3);
			$('#cmbBanco').val(parseInt(nIdBanco));
		}
	}else{

	}
}
function mostrarActivacionCuenta(nIdEstatus,nIdProveedor){
	$('#activaCuenta').empty();
        var colorEstatus = nIdEstatus != 0 ? 'style="color: #22AA22;"' : 'style="color: #FF0000;"';
	accionCuenta = nIdEstatus != 0 ? 'Activar Cuenta <i class="fa fa-check" aria-hidden="true" '+colorEstatus+'></i>' : 'Desactivar cuenta <i class="fa fa-times" aria-hidden="true" '+colorEstatus+'></i>'; 
	
	$('#activaCuenta').append('<button href ="#" onclick ="cambiarStatus('+nIdEstatus+','+nIdProveedor+')" '+colorEstatus+'>'+accionCuenta+'</button>');
	return nIdEstatus = nIdEstatus != 0 ? 0:1;
}
function cambiarStatus(nIdStatus, nIdProveedor){
	jConfirm('\u00BFSeguro que desea cambiar el Estatus de la cuenta?', 'Confirmaci\u00F3n', function(e){
		if(e == true){
			

			nStatus = nIdStatus != 0 ? 0:1;
			
			$.ajax({
				url: BASE_URL +'/paynau/ajax/soporte/setStatusProveedor.php',
				type: 'POST',
				dataType: 'json',
				data: {nIdStatus: nStatus, nIdProveedor : nIdProveedor},
			})
			.done(function(resp) {
				estadoActual = mostrarActivacionCuenta(nStatus,nIdProveedor);
			})
			.fail(function() {
				console.log("error al actualizar la cuenta");
			});
			
		}
	});	  

}

 function cargarColonias(sCodigoPostal){

		$('#empresaColonia').customEmptyStore({
				firstItemId		: '0',
				firstItemValue	: 'Seleccione',
			});
			$('#empresaColonia').customLoadStore({
				url				: BASE_URL + '/paynau/ajax/soporte/storeColonias.php',
				labelField		: 'sNombreColonia',
				idField			: 'nIdColonia',
				firstItemId		: '0',
				firstItemValue	: 'Seleccione',
				params			: {
					sCodigoPostal : $('#empresaCodigoPostal').val()
				}
			});

		$('#empresaColonia').unbind('storeLoaded');
		$('#empresaColonia').on('storeLoaded', function(e, resp){
			if(e.bExito){
				var elemento = e.data[0];

				$('#empresaEstado').customEmptyStore({
					firstItemId		: '0',
					firstItemValue	: 'Seleccione',
				});
				$('#empresaEstado').append('<option value="'+elemento.nIdEntidad+'">'+elemento.sNombreEntidad+'</option>');
				$('#empresaEstado').val(elemento.nIdEntidad);

				$('#empresaCiudad').customEmptyStore({
					firstItemId		: '0',
					firstItemValue	: 'Seleccione',
				});
				$('#empresaCiudad').append('<option value="'+elemento.nNumMunicipio+'">'+elemento.sNombreMunicipio+'</option>');
				$('#empresaCiudad').val(elemento.nNumMunicipio);

				if(e.data.length == 1){
					$('#empresaColonia').val(e.data[0].nIdColonia);
				}

			}
		});
	}

	const reporteUSuarios = ()=>{
		
		if ($('#p_dFechaInicio').val() <= $('#p_dFechaFin').val() ) {

			reporte = `<form method="post" action = "${BASE_URL}paynau/ajax/soporte/reporteUsuarios.php" id="formReporteUsuarios">
				<input type="hidden" name="h_dFechaInicio" id="h_dFechaInicio" value="${$('#p_dFechaInicio').val()}" />
		        <input type="hidden" name="h_dFechaFin" id="h_dFechaFin" value="${$('#p_dFechaFin').val()}" />
			</form>`;
			 $('body').append(reporte);
			$('#formReporteUsuarios').submit();
			$('#formReporteUsuarios').remove();
		}
		else{
			jAlert('La fecha inicial no puede ser mayor a la fecha final');
		}
	}

	




	


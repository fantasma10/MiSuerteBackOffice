function initViewCfg(){

	var Cfg = {
		initCampos : function(){
			$('#txtNPosicionInicial, #txtNPosicionFinal').numeric({
				allowMinus			: false,
				allowThouSep		: false,
				allowDecSep			: true
			});
		},

		initComboTipoConciliacion : function(){
			$('#cmbNIdTipoConciliacion').customLoadStore({
				url				: BASE_PATH + '/inc/Ajax/stores/storeTipoConciliacion.php',
				labelField		: 'sNombreTipoConciliacion',
				idField			: 'nIdTipoConciliacion',
				firstItemId		: '-1',
				firstItemValue	: 'Seleccione'
			});

			$('#cmbNIdTipoConciliacion').on('change', function(e){
				var nIdTipoConciliacion = $(this).val();

				if(nIdTipoConciliacion == 1){
					$('#txtNPosicionFinal').val('');
					$('#txtNPosicionFinal').prop('disabled', true);
					$('#txtSCaracter').prop('disabled', false);
					$('#txtSCaracter').focus();
				}

				if(nIdTipoConciliacion == 2){
					$('#txtNPosicionFinal').prop('disabled', false);
					$('#txtSCaracter').prop('disabled', true);
					$('#txtSCaracter').val('');
				}
			});
		},

		initComboCampos : function(){
			$('#cmbNIdCampo').customLoadStore({
				url				: BASE_PATH + '/inc/Ajax/stores/storeCampoConciliacion.php',
				labelField		: 'sNombreCampo',
				idField			: 'nIdCampo',
				firstItemId		: '-1',
				firstItemValue	: 'Seleccione'
			});
			
			$('#cmbNIdCampo').on('change', function(e){
				var nIdCampo = $(this).val();

				if(nIdCampo == 1){
					$('#txtSValorComparar').prop('disabled', false);
				}
				else{
					$('#txtSValorComparar').prop('disabled', true);
					$('#txtSValorComparar').val('');
				}
			});
		},

		initComboNivelConciliacion : function(){
			$('#cmbNIdNivelConciliacion').customLoadStore({
				url				: BASE_PATH + '/inc/Ajax/stores/storeNivelConciliacion.php',
				labelField		: 'sDescripcion',
				idField			: 'nIdNivelConciliacion',
				firstItemId		: '0',
				firstItemValue	: 'Seleccione'
			});
		},

		initToolTips : function(){
			$('.class-show_tooltip').powerTip('destroy');
			$('.class-show_tooltip').powerTip({
				mouseOnToPopup	: true
			});
		},

		initBotones : function(){
			$('#btnGuardar1').on('click', function(e){
				Cfg.guardarFormato();
			});

			$('#btnGuardar2').on('click', function(e){
				Cfg.guardarCampo();
			});

			$('#btnRegresar').on('click', function(e){
				window.location = "../ConfiguracionLayout/";
			});
		},

		guardarFormato : function(){
			var params = $('#_formFormato').getSimpleParams();

			if(params.nIdNivelConciliacion == undefined || params.nIdNivelConciliacion <= 0){
				jAlert('Seleccione un Nivel de Conciliaci\u00F3n', 'Mensaje');
				return false;
			}

			if(params.nIdTipoConciliacion == undefined || params.nIdTipoConciliacion <= 0){
				jAlert('Seleccione un Formato', 'Mensaje');
				return false;
			}

			if(params.nIdTipoConciliacion == 1 && (params.sCaracter == undefined || myTrim(params.sCaracter) == '')){
				jAlert('Capture Caracter Separador', 'Mensaje', function(){
					document.getElementById('txtSCaracter').focus();
				});
				return false;
			}

			params.nIdCadena = $('#_formParamsTabla :input[name=nIdCadena]').val();
			params.sCaracter = document.getElementById('txtSCaracter').value;

			jConfirm('\u00BFDesea continuar para guardar la informaci\u00F3n\u003F', 'Confirmaci\u00F3n', function(confirmado){
				if(confirmado){
					showSpinner();
					$.ajax({
						url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ConfiguracionLayout/guardarFormato.php',
						type		: 'POST',
						dataType	: 'json',
						data		: params
					})
					.done(function(resp){
						if(!resp.bExito){
							jAlert(resp.sMensaje, 'Mensaje');
						}
					})
					.fail(function(){})
					.always(function() {
						hideSpinner();
					});
				}
			});
		},

		guardarCampo : function(){
			var params = $('#_formCampo').getSimpleParams();

			if(params.nIdCampo == undefined || params.nIdCampo == '' || params.nIdCampo <= 0){
				jAlert('Seleccione Campo', 'Mensaje', function(e){
					document.getElementById('cmbNIdCampo').focus();
				});
				return false;
			}

			if(params.nPosicionInicial == undefined || myTrim(params.nPosicionInicial) == ''){
				jAlert('Capture Posicion Inicial', 'Mensaje', function(e){
					document.getElementById('txtNPosicionInicial').focus();
				});
				return false;
			}

			var nIdTipoConciliacion = $('#cmbNIdTipoConciliacion').val();
			if(nIdTipoConciliacion == 2){
				if(params.nPosicionFinal == undefined || myTrim(params.nPosicionFinal) == ''){
					jAlert('Capture Posicion Final', 'Mensaje', function(e){
						document.getElementById('txtNPosicionFinal').focus();
					});
					return false;
				}
			}

			if(params.nIdCampo == 1 && myTrim(params.sValorComparar) == ''){
				jAlert('Capture Valor a Comparar', 'Mensaje', function(e){
					document.getElementById('txtSValorComparar').focus();
				});
				return false;
			}

			params.nIdCadena		= $('#_formParamsTabla :input[name=nIdCadena]').val();
			params.sCaracter		= document.getElementById('txtSValorComparar').value;

			if(nIdTipoConciliacion == 1){
				params.nPosicionFinal = params.nPosicionInicial;
			}

			jConfirm('\u00BFDesea continuar para guardar la informaci\u00F3n\u003F', 'Confirmaci\u00F3n', function(confirmado){
				if(confirmado){
					showSpinner();
					$.ajax({
						url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ConfiguracionLayout/guardarCampo.php',
						type		: 'POST',
						dataType	: 'json',
						data		: params
					})
					.done(function(resp){
						if(!resp.bExito){
							jAlert(resp.sMensaje, 'Mensaje');
						}

						Cfg.dibujarTabla();
					})
					.fail(function(){})
					.always(function() {
						hideSpinner();
					});
				}
			});
		},

		dibujarTabla : function(){
			var params = {
				nIdCadena : $('#_formParamsTabla :input[name=nIdCadena]').val()
			}

			$.ajax({
				url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ConfiguracionLayout/listaCamposTbl.php',
				type		: 'POST',
				dataType	: 'json',
				data		: params
			})
			.done(function(resp){

				if(!resp.bExito){
					jAlert(resp.sMensaje, 'Mensaje');
				}
				else{
					var data		= resp.data;
					var esEscritura	= resp.esEscritura;

					var tabla		= "";

					if(data.length > 0){

						var length = data.length;
						for(var i=0; i < length; i++){
							var row = data[i];

							tabla += "<tr>";
								tabla += "<td>" + row['sNombreCampo'] + "</td>";
								tabla += "<td>" + row['sCampoClase'] + "</td>";
								tabla += "<td>" + row['nPosicionInicial'] + "</td>";
								tabla += "<td>" + row['nPosicionFinal'] + "</td>";
								tabla += "<td>" + row['sValorComparar'] + "</td>";
								if(esEscritura){
									tabla += "<td align='center'><a href='javascript:;' class='class-show_tooltip a-class-eliminar-campo' title='Eliminar' nidcampo='"+row['nIdCampo']+"'><img src='../../../img/delete.png'/></a></td>";
								}
								else{
									tabla += "<td></td>";
								}
							tabla += "</tr>";
						}
					}

					$('#tbl-lista-campos tbody').html(tabla).promise().done(function(elem){
						$('.a-class-eliminar-campo').on('click', function(e){
							var nIdCampo = $(this).attr('nidcampo');
							Cfg.eliminarCampo(nIdCampo);
						});
					});
				}
			})
			.fail(function(){
			})
			.always(function(){
				hideSpinner();
			});
			
		},

		eliminarCampo : function(nIdCampo){
			if(nIdCampo == undefined || nIdCampo == ''){
				jAlert('No es posible eliminar la informaci\u00F3n, haga clic en la tecla F5 y vuelva a intentarlo', 'Mensaje');
			}
			else{

				jConfirm('\u00BFDesea eliminar el Campo seleccionado\u003F', 'Confirmaci\u00F3n', function(confirmado){
					if(confirmado){
						showSpinner();


						var params = {
							nIdCadena	: $('#_formParamsTabla :input[name=nIdCadena]').val(),
							nIdCampo	: nIdCampo
						}

						$.ajax({
							url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ConfiguracionLayout/eliminarCampo.php',
							type		: 'POST',
							dataType	: 'json',
							data		: params
						})
						.done(function(resp){
							if(!resp.bExito){
								jAlert(resp.sMensaje, 'Mensaje');
							}
							else{
								Cfg.dibujarTabla();
							}
						})
						.fail(function(){
						})
						.always(function(){
							hideSpinner();
						});
					}
				});

				
			}
		}
	}

	showSpinner();
	Cfg.initCampos();
	Cfg.initComboTipoConciliacion();
	Cfg.initComboCampos();
	Cfg.initToolTips();
	Cfg.initBotones();
	Cfg.dibujarTabla();
	Cfg.initComboNivelConciliacion();
}
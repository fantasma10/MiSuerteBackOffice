function initViewReporteConciliacion(){
	var Reporte = {
		initFiltros : function(){
			$('form[name=formFiltros] :input[name=sNombreCadena]').autocomplete({
				serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
				type					: 'post',
				dataType				: 'json',
				preventBadQueries		: false,
				width					: 300,
				paramName				: 'text',
				params					: {
					categoria				: 1
				},
				onSearchStart			: function (query){
					$('form[name=formFiltros] :input[name=nIdCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');
					$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
					//resetCuentaForelo();
				},
				onSelect				: function (suggestion){
					$('form[name=formFiltros] :input[name=nIdCadena]').val(suggestion.data);
					//buscaCuentaForelo(suggestion.data, -1, -1);
				}
			});

			$('form[name=formFiltros] :input[name=sNombreCadena]').on('keyup', function(e){
				if(e.target.value == ''){
					$('form[name=formFiltros] :input[name=nIdCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');
					$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
				}
			});

			$('form[name=formFiltros] :input[name=sNombreSubCadena]').autocomplete({
				serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
				type					: 'post',
				dataType				: 'json',
				preventBadQueries		: false,
				width					: 300,
				paramName				: 'text',
				params					: {
					categoria			: 2
				},
				onSearchStart			: function (options){
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
					options.nIdCadena = $('form[name=formFiltros] :input[name=nIdCadena]').val();

					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
				},
				onSelect				: function (suggestion){
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val(suggestion.data);
					$('form[name=formFiltros] :input[name=sNombreCadena]').val(suggestion.nombreCadena);
					$('form[name=formFiltros] :input[name=nIdCadena]').val(suggestion.idCadena);
				}
			});

			$('form[name=formFiltros] :input[name=sNombreSubCadena]').on('keyup', function(e){
				if(e.target.value == ''){
					$('form[name=formFiltros] :input[name=nIdCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');

					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=sNombreCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=sNombreCadena]').val('');
				}
			});

			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').autocomplete({
				serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
				type					: 'post',
				dataType				: 'json',
				preventBadQueries		: false,
				width					: 300,
				paramName				: 'text',
				params					: {
					categoria			: 3
				},
				onSearchStart			: function (options){
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					options.nIdSubCadena = $('form[name=formFiltros] :input[name=nIdSubCadena]').val();
				},
				onSelect				: function (suggestion){
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val(suggestion.data);

					$('form[name=formFiltros] :input[name=nIdCadena]').val(suggestion.idCadena);
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val(suggestion.idSubCadena);
					$('form[name=formFiltros] :input[name=sNombreCadena]').val(suggestion.nombreCadena);
					$('form[name=formFiltros] :input[name=sNombreSubCadena]').val(suggestion.nombreSubCadena);
				}
			});

			$('form[name=formFiltros] :input[name=sNombreCorresponsal]').on('keyup', function(e){
				if(e.target.value == ''){
					$('form[name=formFiltros] :input[name=nIdCorresponsal]').val('');
					$('form[name=formFiltros] :input[name=nIdCadena]').val('');
					$('form[name=formFiltros] :input[name=nIdSubCadena]').val('');
					$('form[name=formFiltros] :input[name=sNombreCadena]').val('');
					$('form[name=formFiltros] :input[name=sNombreSubCadena]').val('');
				}
			});

			$('#cmbNIdNivelConciliacion').customLoadStore({
				url				: BASE_PATH + '/inc/Ajax/stores/storeNivelConciliacion.php',
				labelField		: 'sDescripcion',
				idField			: 'nIdNivelConciliacion',
				firstItemId		: '0',
				firstItemValue	: 'Seleccione'
			});

			$('#cmbNIdNivelConciliacion').on('change', function(e){
				Reporte.muestraFiltros();
			});

			$('#txtFechaIni, #txtFechaFin').datepicker({
				format : 'yyyy-mm-dd'
			});
		},

		initTooltips : function(){
			$('.class-show_tooltip').powerTip('destroy');
			$('.class-show_tooltip').powerTip();
		},

		initLinks : function(){
			$('.a-ver-detalle-diferencias').on('click', function(e){
				Reporte.verDetalleDiferencias(e);
			});

			$('.class-liberar_corte').on('click', function(e){
				Reporte.liberarCorte(e);
			});
		},

		initClicks : function(){
			$('.class-subir_archivo').on('click', function(e){
				var nIdCorte = e.currentTarget.getAttribute('nidcorte');

				if(nIdCorte != undefined && nIdCorte != '' && nIdCorte > 0){
					Reporte._showModalArchivo(nIdCorte);
				}
				else{
					jAlert('Refresque la P\u00E1gina (F5) y vuelva a intentar subir el archivo', 'Mensaje');
				}
			});
		},

		initSubirArchivo : function(){
			$('#btnSubirArchivo').unbind('click');
			$('#btnSubirArchivo').on('click', function(e){
				Reporte._subirArchivo();
			});
		},

		muestraFiltros : function(){
			var nIdNivelConciliacion = $('#cmbNIdNivelConciliacion').val();

			switch(nIdNivelConciliacion){
				case '1' :
					$('#txtSNombreSubCadena').val('');
					$('#txtSNombreCorresponsal').val('');
					$('#txtSNombreCadena').prop('disabled', false);
					$('#txtSNombreSubCadena').prop('disabled', true);
					$('#txtSNombreCorresponsal').prop('disabled', true);
				break;
				case '2' :
					$('#txtSNombreCadena').prop('disabled', false);
					$('#txtSNombreSubCadena').prop('disabled', false);
					$('#txtSNombreCorresponsal').prop('disabled', true);
					$('#txtSNombreCorresponsal').val('');
				break;
				case '3' :
					$('#txtSNombreCadena').prop('disabled', false);
					$('#txtSNombreSubCadena').prop('disabled', false);
					$('#txtSNombreCorresponsal').prop('disabled', false);
				break;
				default :
					$('#txtSNombreCadena').prop('disabled', true);
					$('#txtSNombreSubCadena').prop('disabled', true);
					$('#txtSNombreCorresponsal').prop('disabled', true);
					$('#txtSNombreCadena').val('');
					$('#txtSNombreSubCadena').val('');
					$('#txtSNombreCorresponsal').val('');
				break;
			}
		},

		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
				Reporte.mostrarReporte();
			});

			$('#btnExportarAExcel').on('click', function(e){
				Reporte.exportarAExcel();
			});
		},

		mostrarReporte : function(){
			var params = $('form[name=formFiltros]').getSimpleParams();

			if(params.nIdNivelConciliacion == undefined || params.nIdNivelConciliacion <= 0){
				jAlert('Seleccione Nivel de Conciliaci\u00F3n para buscar la Informaci\u00F3n', 'Mensaje', function(){
					document.getElementById('cmbNIdNivelConciliacion').focus();
				});
				return false;
			}

			var fechaInicio	= params.dFechaInicial;
			var fechaFinal	= params.dFechaFinal;
			var dif			= restaFechas(fechaInicio, fechaFinal);

			if(dif < 0){
				jAlert('La Fecha Final debe ser mayor o igual a la Fecha Inicial', 'Mensaje', function(){
					document.getElementById('txtFechaFin').focus();
				});
				return false;
			}

			Reporte.buscarInformacion();
		},

		buscarInformacion : function(){
			showSpinner();

			$('#txtHMostrarReporte').val(1);
			$('form[name=formFiltros]').submit();
		},

		_showModalArchivo : function(nIdCorte){
			Reporte.initSubirArchivo();
			$('#_formSubirArchivo :input[name=nIdCorte]').val(nIdCorte);
			$('#modal-subir_archivo').modal('show');
		},

		_subirArchivo : function(){
			var input		= $('#fArchivo');
			var file		= $(input).prop('files')[0];

			if(file == undefined || file == null){
				jAlert('Seleccione Archivo', 'Mensaje');
				return false;
			}

			var filenombre	= $(input).prop('files')[0]['name'];
			var exts		= filenombre.split('.').pop();
			exts			= exts.toLowerCase();

			if(exts != 'txt'){
			    jAlert('El archivo debe ser formato txt', 'Mensaje', function(){
			    	$('#fArchivo').val('');
			    });
			    return false;
			}

			var params					= $('#_formSubirArchivo').getSimpleParams();
			var nIdNivelConciliacion	= $('#cmbNIdNivelConciliacion').val();
			var formdata				= new FormData();

			formdata.append('sFile', file);
			formdata.append('nIdCorte', params.nIdCorte);
			formdata.append('nIdNivelConciliacion', nIdNivelConciliacion);

			showSpinner();
		    $.ajax({
				url			: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteConciliacion/subirArchivo.php',
				type		: 'POST',
				contentType	: false,
				data		: formdata,
				mimeType	: "multipart/form-data",
				processData	: false,
				cache		: false,
				dataType	: 'json'
			})
			.done(function(resp){
				hideSpinner();
				jAlert(resp.sMensaje, 'Mensaje', function(e){
					if(resp.bExito){
						Reporte.buscarInformacion();
					}
				});
			})
			.fail(function(){
				//jAlert('Error al Intentar Subir el Archivo');
				hideSpinner();
			});
		},

		verDetalleDiferencias : function(e){
			var nIdCorte				= $(e.currentTarget).attr('nidcorte');
			var nIdArchivo              = $(e.currentTarget).attr('nidarchivo');
			var nIdNivelConciliacion	= $(e.currentTarget).attr('nidnivelconciliacion');

			$('#txtHNIdCorte').val(nIdCorte);
			$('#txtHNIdArchivo').val(nIdArchivo);
			$('#txtHNIdNivelConciliacion').val(nIdNivelConciliacion);

			$('#gridbox').html('<table id="tbl-mostrar_diferencias" class="display table table-bordered table-striped"><thead><tr><th>&nbsp;</th><th>Folio</th><th>Fecha de<br/>operación</th><th>Id Emisor</th><th>Emisor</th><th>Referencia</th><th>Monto</th><th>Fecha<br/>Conciliada</th><th>Estatus<br/>Conciliación</th></tr></thead><tbody></tbody></table>');
			
			var dataTableObj = $('#tbl-mostrar_diferencias').dataTable({
				"iDisplayLength"	: 10,
				"bProcessing"		: false,
				"bServerSide"		: true,
				"bFilter"			: false,
				"sAjaxSource"		: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteConciliacion/dt_diferencias.php',
				"sServerMethod"		: 'POST',
				"aaSorting"			: [[0, 'desc']],
				"bAutoWidth"		: false,
				"oLanguage"			: {
					"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
					"sZeroRecords"		: "No se ha encontrado nada",
					"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
					"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
					"sProcessing"		: "Cargando"
				},
				"aoColumnDefs"		: [
					{
						"bSortable"	: false,
						'aTargets'	: [0,1,2,3,4,5,6,7,8]
					},
					{
						"mData"		: 'sIdTipo',
						'aTargets'	: [0]
					},
					{
						"mData"		: 'nIdFolio',
						'aTargets'	: [1]
					},
					{
						"mData"		: 'dFechaOperacion',
						'aTargets'	: [2]
					},
					{
						"mData"		:'nIdEmisor',
						'aTargets'	: [3]
					},
					{
						"mData"		:'sNombreEmisor',
						'aTargets'	: [4]
					},
					{
						"mData"		:'sReferencia',
						'aTargets'	: [5]
					},	
					{
						"mData"		: 'nImporte',
						'aTargets'	: [6],
						'sClass'	: 'align-right'
					},
					{
						"mData"		: 'dFecConciliacion',
						'aTargets'	: [7],
						mRender: function(data, type, row) {	
							if (row.dFecConciliacion) {
								var dateFormat = new Date(row.dFecConciliacion);
								return dateFormat.getFullYear() + "-" +
									(dateFormat.getMonth()+1).toString().padStart(2, "0") + "-" +
									(dateFormat.getDate().toString().padStart(2, "0"));
							}
							return "";
						}
					},
					{
						"mData"   : 'sEstatus',
						'aTargets'  : [8]
					}
				],
				"fnPreDrawCallback"	: function() {
					showSpinner();
				},
				"fnDrawCallback": function ( oSettings ) {
					hideSpinner();
				},
				"fnServerParams" : function (aoData){
					var params = {
						nIdCorte			: nIdCorte,
						nIdArchivo          :nIdArchivo
					}

					$.each(params, function(index, val){
						aoData.push({name : index, value : val });
					});
				}
			});
			$('#modal-mostrar_detalle').modal('show');
		},

		exportarAExcel : function(){
			$('#txtHExportarAExcel').val(1);
			document.formExportarAExcel.method = "POST";
			document.formExportarAExcel.action = "";
			document.formExportarAExcel.submit();
		},

		liberarCorte : function(e){
			var nIdCorte= $(e.currentTarget).attr('nidcorte');

			if(nIdCorte == undefined  || nIdCorte <= 0 ){
				jAlert('No es posible liberar el corte, refresque la p\u00E1gina(f5) y vuelva a intentarlo', 'Mensaje');
				return false;
			}

			jConfirm('Al liberar el corte se podr\u00E1 subir otro archivo para una nueva conciliaci\u00F3n.<br/>Haga clic en "Continuar" para liberar el corte', 'Confirmaci\u00F3n', function(confirm){
				if(confirm){
					showSpinner();
					$.ajax({
						url		: '/inc/Ajax/_Contabilidad/Conciliacion/ReporteConciliacion/liberarCorte.php',
						type	: 'POST',
						dataType: 'json',
						data	: {
							nIdCorte			: nIdCorte
						}
					})
					.done(function(resp){
						if(!resp.bExito){
							JAlert(resp.sMensaje, 'Mensaje', function(){

							});
						}
						else{
							Reporte.buscarInformacion();
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

	Reporte.initFiltros();
	Reporte.initBotones();
	Reporte.initTooltips();
	Reporte.initClicks();
	Reporte.initLinks();
}
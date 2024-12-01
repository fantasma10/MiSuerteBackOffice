function initViewConfiguracionLayout(){
	var Cfg = {
		initFiltros : function(){
			$('form[name=formFiltros] :input[name=sNombreCadena]').autocomplete({
				serviceUrl				: BASE_PATH + '/inc/ajax/_Contabilidad/movimiento_forelo/autocomplete_getListaCategoria.php',
				type					: 'post',
				dataType				: 'json',
				preventBadQueries		: false,
				width					: 300,
				paramName				: 'text',
				params					: {
					categoria			: 1
				},
				onSearchStart			: function (query){
					$('form[name=formFiltros] :input[name=nIdCadena]').val('0');
				},
				onSelect				: function (suggestion){
					$('form[name=formFiltros] :input[name=nIdCadena]').val(suggestion.data);
				}
			});

			$('form[name=formFiltros] :input[name=sNombreCadena]').on('keyup', function(e){
				if(e.target.value == ''){
					$('form[name=formFiltros] :input[name=nIdCadena]').val('0');
				}
			});
		},

		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
				Cfg._buscarInformacion();
			});

			$('#btnNuevo').on('click', function(e){
				Cfg.nuevaConfiguracion();
			});
		},

		_buscarInformacion : function(){
			var params = $('form[name=frmFiltros]').getSimpleParams();

			$('#gridbox').html('<table id="tblGridBox" class="display table table-bordered table-striped"><thead><tr><th>Id</th><th>Cadena</th><th>Nivel</th><th>Tipo</th><th>Acciones</th></tr></thead><tbody></tbody></table>');

			showSpinner();
			var dataTableObj = $('#tblGridBox').dataTable({
				"iDisplayLength"	: 10,
				"bProcessing"		: true,
				"bServerSide"		: true,
				"sAjaxSource"		: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ConfiguracionLayout/buscarInformacionConfiguracion.php',
				"sServerMethod"		: 'POST',
				"bFilter"			: false,
				"bAutoWidth"		: false,
				"oLanguage": {
					"sLengthMenu"		: "Mostrar _MENU_ Registros por P&aacute;gina",
					"sZeroRecords"		: "No se ha encontrado nada",
					"sInfo"				: "Mostrando _START_ a _END_ de _TOTAL_ Registros",
					"sInfoEmpty"		: "Mostrando 0 a 0 de 0 Registros",
					"sInfoFiltered"		: "(filtrado de _MAX_ total de Registros)",
					"sProcessing"		: "Cargando"
				},
				"aoColumnDefs"		: [
					{
						'bSortable'	: false,
						'aTargets'	: [0,1,2,3,4]
					},
					{
						"mData"		: 'nIdCadena',
						'aTargets'	: [0]
					},
					{
						"mData"		: 'nombreCadena',
						'aTargets'	: [1]
					},
					{
						"mData"		: 'sNivelConciliacion',
						'aTargets'	: [2]
					},
					{
						"mData"		:'sTipoConciliacion',
						'aTargets'	: [3]
					},
					{
						"mData"		: null,
						'aTargets'	: [4],
						'sClass'	: 'centrado',
						fnRender	: function(a, b){
							var html = '<a class="ver-detalles" href="javascript:;" fila="'+a.iDataRow+'"><span class="class-show_tooltip" title="Ver Detalles y Editar"><img title="" src="../../../img/edit.png"/></span></a>';

							return html;
						}
					}
				],
				"fnPreDrawCallback"	: function() {
					//$('body').trigger('cargarTabla');
					showSpinner();
				},
				"fnDrawCallback": function ( oSettings ) {
					hideSpinner();
					$('.class-show_tooltip').powerTip('destroy');
					$('.class-show_tooltip').powerTip({
						mouseOnToPopup	: true
					});

					$('.ver-detalles').on('click', function(e){
						var target			= e.currentTarget;
						var nFila			= $(target).attr('fila');
						var Datos			= oSettings.aoData[nFila];
						var aData			= Datos._aData;
						var nIdCadena		= aData.nIdCadena;
						var sNombreCadena	= aData.nombreCadena;

						Cfg.redireccionar(nIdCadena, sNombreCadena);
					})
				},
				"fnServerParams" : function (aoData){
					var params = $('form[name=formFiltros]').getSimpleParams();

					$.each(params, function(index, val){
						aoData.push({name : index, value : val });
					});
				}
			});
		},

		redireccionar : function(nIdCadena, sNombreCadena){

			if($('#formRedireccionar').length == 0){
				$('body').append('<form id="formRedireccionar" method="POST" action="Configuracion.php"><input type="hidden" id="txtHNIdCadena" name="nIdCadena" value="'+nIdCadena+'"/><input type="hidden" id="txtHSNombreCadena" name="sNombreCadena" value="'+sNombreCadena+'"/></form>');
			}
			else{
				$('#txtHNIdCadena').val(nIdCliente);
				$('#txtHSNombreCadena').val(sNombreCadena);
			}
			$('#formRedireccionar').submit();
		},

		nuevaConfiguracion : function(){
			var nIdCadena = $('#frmFiltros :input[name=nIdCadena]').val();

			if(nIdCadena == undefined || nIdCadena == null || nIdCadena == '' || nIdCadena <= 0){
				jAlert('Seleccione una Cadena', 'Mensaje');
				return false;
			}

			var sNombreCadena = $('#txtSNombreCadena').val();
			if(sNombreCadena != undefined && sNombreCadena != ''){
				arr_cadena = sNombreCadena.split(":");
				sNombreCadena = arr_cadena[1];
			}

			Cfg.redireccionar(nIdCadena, sNombreCadena);
		},


	}

	Cfg.initFiltros();
	Cfg.initBotones();
	Cfg._buscarInformacion();
	Cfg.init();
}
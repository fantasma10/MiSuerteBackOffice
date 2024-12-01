var dataTableObj = null;
var totalImporteBusqueda = 0;
var contBusqueda = true;

function initViewReporteDiferencias(){
	var Reporte = {

		llenarComboCadena	: function() {	
			$.get(BASE_PATH + '/inc/Ajax/stores/storeCadenas.php',
                function(response) {
                    var obj = jQuery.parseJSON(response);
					for(let cadena of obj.data) {
						$("#cmbCadena").append('<option value="'+cadena.idCadena+'">'+cadena.nombreCadena+'</option>')
					}
                }
            )
		},

		llenarComboMotivo  : function() {
			$.get(BASE_PATH + '/inc/Ajax/stores/storeAutorizacionMotivos.php',
                function(response) {
                    var obj = jQuery.parseJSON(response);
					for(let motivo of obj.data) {
						$("#cmbMotivo").append('<option value="'+motivo.nIdAutorizacion+'">'+motivo.sNombreAutorizacion+'</option>')
					}
                }
            )
		},

		initFiltros : function() {
			$('#txtFechaIni, #txtFechaFin').datepicker({
				format : 'yyyy-mm-dd'
			});

			$('#checkAutorizados').on('change', function(e) {
				Reporte.buscarInformacion();
			});

			$('#cmbEstatus').on('change', function(e) {
				const value = $(this).val();
				if (value == -1 || value == 1) {
					$('#checkAutorizados').prop('disabled', false);
				} else {
					$('#checkAutorizados').prop('checked', false);
					$('#checkAutorizados').prop('disabled', true);
				}
			})
		},

		initTooltips : function(){
			$('.class-show_tooltip').powerTip('destroy');
			$('.class-show_tooltip').powerTip();
		},

		initBotones : function(){
			$('#btnBuscar').on('click', function(e){
				Reporte.mostrarReporte();
			});

			$('#btnExportarAExcel').on('click', function(e){
				Reporte.exportarAExcel();
			});

			$('#btnAutorizarDiferencia').on('click', function(e) {
				var cmbMotivos = $("#cmbMotivo");

				if (cmbMotivos.val() == "-1") {
					showError(cmbMotivos, "Campo requerido", true);
				} else {
					showSuccess(cmbMotivos, true);
					Reporte.autorizarDiferencia();
				}
			});

			$('#btnCancelar').on('click', function(e) {
				if ($('#btnCancelar').html() == "Rechazar") {
					Reporte.rechazarDiferencia();
				} else {
					$('#modal-autorizacion').modal('hide');
				}
			});
		},

		mostrarReporte : function(){
			var params = $('form[name=formFiltros]').getSimpleParams();

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

			if (!PERM_CONTRALOR) {
				$("#checkAutorizados").prop('checked', false);
				$("#divCheckAutorizados").hide();
			} 

			let nIdCadena 		= $('#cmbCadena').val();
			let dFechaInicial	= $('#txtFechaIni').val();
			let dFechaFinal 	= $('#txtFechaFin').val();
			let nIdEstatus 		= $("#cmbEstatus").val();
			let nPorAutorizar   = $("#checkAutorizados").prop('checked') ? 1 : 0;

			var params = {
				nIdCadena		: nIdCadena,
				dFechaInicial 	: dFechaInicial,
				dFechaFinal		: dFechaFinal,
				nIdEstatus      : nIdEstatus,
				nPorAutorizar   : nPorAutorizar
			}

			$('#reporte-diferencias').html('<table id="tbl-reporte-diferencias" class="display table table-bordered table-striped"><thead><tr><th>Cadena</th><th>Tipo</th><th>Folio</th><th>Fecha de<br/>operación</th><th>Emisor</th><th>Referencia</th><th>Monto</th><th>Fecha<br/>Conciliada</th><th>Estatus<br/>Conciliación</th><th>IdEstatus</th><th>Acciones</th></tr></thead><tbody></tbody></table>');
			$("#nTotalBusqueda").html("Total: $0.00");
			$('#divExcel').show();

			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteDiferencias/buscarImporteTotal.php', 
				params,
				function(response) {
					var obj = jQuery.parseJSON(response);
					if (obj.bExito) {
						const importe = obj.data[0].nTotalImporte;
						if (importe) {
							$("#nTotalBusqueda").html("Total: $" + importe);
						}
					}
				}
			)

			dataTableObj = $('#tbl-reporte-diferencias').dataTable({
				"iDisplayLength"	: 20,
				"bProcessing"		: false,
				"bServerSide"		: true,
				"bFilter"			: false,
				"sAjaxSource"		: BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteDiferencias/buscarInformacion.php',
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
						'aTargets'	: [0,1,2,3,4,5,6,7,8,9]
					},
					{
						"mData"		: 'sCadena',
						'aTargets'	: [0]
					},
					{
						"mData"		: 'sTipo',
						'aTargets'	: [1]
					},
					{
						"mData"		: 'nIdFolio',
						'aTargets'	: [2],
						'sClass'	: 'align-right'
					},
					{
						"mData"		: 'dFechaOperacion',
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
						"mData"		:'dFecConciliacion',
						'aTargets'	: [7],
						mRender: function(data, type, row) {	
							if (row.dFecConciliacion) {
								var dateFormat = new Date(row.dFecConciliacion);
								return '<div id="fecConc_dif_'+row.nId+'">' +
									dateFormat.getFullYear() + "-" +
									(dateFormat.getMonth()+1).toString().padStart(2, "0") + "-" +
									(dateFormat.getDate().toString().padStart(2, "0"))
									+ '</div>';
							}
							return '<div id="fecConc_dif_'+row.nId+'"></div>';
						}
					},
					{
						"mData"		:'sEstatus',
						'aTargets'	: [8],
						mRender: function(data, type, row) {	
							return '<div id="estatus_dif_'+row.nId+'">'+row.sEstatus+'</div>';
						}
					},
					{
						"mData"     : 'nIdEstatus',
						'aTargets'  : [9],
						'bVisible'  : false
					},
					{
						'mData' 	: 'nId',
						'aTargets' 	: [10],
						'bVisible'  : (PERM_CONCILIADOR || PERM_CONTRALOR) ? true : false,
						mRender		: function(data, type, row) {
							var botonAccion = "";

							// Estatus no conciliado
							if (row.nIdEstatus == 1) {
								switch(row.nEstatusAutorizacion) {
									// Solicitar autorizacion
									case 0:
										if (PERM_CONCILIADOR) {
											botonAccion = '<div id="btn_dif_'+row.nId+'"><button onclick="modalAutorizacion('+row.nId+','+row.nEstatusAutorizacion+');" data-placement="top" rel="tooltip" title="Solicitar autorización" class="btn btn-default btn-xs"><span class="fa fa-hand-o-up"></span></button></div>';
										}
										break;
									// Autorizacion en espera
									case 2:
										if (PERM_CONCILIADOR) {  
											botonAccion = `<button data-placement="top" rel="tooltip" title="Autorización en espera" class="btn btn-warning btn-xs"><span class="fa fa-clock-o"></span></button>`;
										} 
										else if (PERM_CONTRALOR) {
											botonAccion = '<div id="btn_dif_'+row.nId+'"><button onclick="modalAutorizacion('+row.nId+','+row.nEstatusAutorizacion+','+row.nIdAutorizacion+');" data-placement="top" rel="tooltip" title="Autorizar diferencia" class="btn btn-primary btn-xs"><span class="fa fa-check"></span></button>';
										}
										break;
								}
							}
							// Estatus aprobada contraloria
							else if (row.nIdEstatus == 6) {
								if (PERM_CONTRALOR) {
									botonAccion = '<button data-placement="top" rel="tooltip" title="Diferencia autorizada" class="btn btn-secondary btn-xs" disabled><span class="fa fa-check"></span></button>';
								}
							}
							
							return `<center>${botonAccion}</center>`;
						}
					}
				],
				"fnPreDrawCallback"	: function() {
					showSpinner();
				},
				"fnDrawCallback": function ( oSettings ) {
					hideSpinner();
				},
				"fnServerParams" : function (aoData){
					$("#nTotalBusqueda").html("Total: $0.00");

					$.each(params, function(index, val){
						aoData.push({name : index, value : val });
					});
				},
			});

			//Reporte.initFiltros();
		},

		exportarAExcel : function(){
			$('#txtHExportarAExcel').val(1);
			$('#excel_idCadena').val($('#cmbCadena').val());
			$('#excel_fecInicial').val($('#txtFechaIni').val());
			$('#excel_fecFinal').val($('#txtFechaFin').val());
			$('#excel_estatus').val($('#cmbEstatus').val());
			$('#excel_autorizar').val($("#checkAutorizados").prop('checked') ? 1 : 0);
			document.formExportarAExcel.method = "POST";
			document.formExportarAExcel.action = "";
			document.formExportarAExcel.submit();
		},

		autorizarDiferencia : function () {
			$("#btnAutorizarDiferencia, #btnCancelar").prop("disabled", true);
			$("#btnAutorizarDiferencia").html("<i class='fa fa-spinner fa-spin '></i>");

			var nId = $('#nIdDiferencia').val();
			
			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteDiferencias/actualizarEstatus.php', 
				{ 
					nIdDiferencia: nId,
					nIdAutorizacion: $("#cmbMotivo").val()
				},
				function(response) {
					var obj = jQuery.parseJSON(response);
					if (obj.bExito) {
						
						if (PERM_CONCILIADOR) {
							$("#btn_dif_"+nId).html('<button data-placement="top" rel="tooltip" title="Autorización en espera" class="btn btn-warning btn-xs"><span class="fa fa-clock-o"></span></button>');
							jAlert("Solicitud de autorización exitosa");
						}
						else if (PERM_CONTRALOR) {
							$("#btn_dif_"+nId).html('<button data-placement="top" rel="tooltip" title="Diferencia autorizada" class="btn btn-secondary btn-xs" disabled><span class="fa fa-check"></span></button>');
							$("#estatus_dif_"+nId).html('Aprobada Contraloria');
							$("#fecConc_dif_"+nId).html(FECHA_HOY);
							jAlert("Autorización existosa");
						}

						$('#modal-autorizacion').modal('hide');
						$("#btnAutorizarDiferencia, #btnCancelar").prop("disabled", false);
						$("#btnAutorizarDiferencia").html("Aceptar");
					} else {
						jAlert("Error al autorizar la diferencia, intente de nuevo m\u00E1s tarde");
					}
				}
			).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
		},

		rechazarDiferencia : function () {
			$("#btnAutorizarDiferencia, #btnCancelar").prop("disabled", true);
			$("#btnCancelar").html("<i class='fa fa-spinner fa-spin '></i>");

			var nId = $('#nIdDiferencia').val();
			
			$.post(BASE_PATH + '/inc/Ajax/_Contabilidad/Conciliacion/ReporteDiferencias/actualizarEstatus.php', 
				{ 
					nIdDiferencia: nId,
					nIdAutorizacion: -1 // Motivo rechazar
				},
				function(response) {
					var obj = jQuery.parseJSON(response);
					if (obj.bExito) {
						
						if (PERM_CONTRALOR) {
							$("#btn_dif_"+nId).html('');
							jAlert("Autorización rechazada");
						}

						$('#modal-autorizacion').modal('hide');
						$("#btnAutorizarDiferencia, #btnCancelar").prop("disabled", false);
						$("#btnCancelar").html("Rechazar");
					} else {
						jAlert("Error al rechazar la diferencia, intente de nuevo m\u00E1s tarde");
					}
				}
			).fail(function(resp) { alert('Ha ocurrido un error, intente de nuevo m\u00E1s tarde'); })
		}

	}

	Reporte.llenarComboCadena();
	Reporte.llenarComboMotivo();
	Reporte.initFiltros();
	Reporte.initBotones();
	Reporte.initTooltips();
}

function modalAutorizacion(nId, nEstatusAutorizacion, nIdMotivo=-1) {
	$('#nIdDiferencia').val(nId);
	$('#nIdEstatusDif').val(nEstatusAutorizacion);
	$('#cmbMotivo').val(nIdMotivo);

	$('#modalTitle').html(nEstatusAutorizacion == 2 			? 'Autorizar' : 'Solicitar Autorización');
	$('#btnAutorizarDiferencia').html(nEstatusAutorizacion == 2 ? 'Autorizar' : 'Solicitar');
	$('#btnCancelar').html(nEstatusAutorizacion == 2 			? 'Rechazar'  : 'Cancelar');
	$('#modal-autorizacion').modal('show');
}

const showError = (input, mensaje, isInput = true) => {
    let formField = null;
    let error = null;

    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('success');
    formField.addClass('error');

    error.text(mensaje);
};

const showSuccess = (input, isInput = true) => {
    let formField = null;
    let error = null;
    if (isInput) {
        formField = input.parent();
        error = input.siblings('small');
    } else {
        formField = input;
        error = input;
    }

    formField.removeClass('error');
    formField.addClass('success');

    error.text('');
}

function addCommas(number) {   
	var parts = number.toString().split(".");   
	parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");   
	return parts.join("."); 
} 

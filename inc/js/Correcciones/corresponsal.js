$(document).ready(function(){

	$.fn.getSimpleParams = function(){
		var objParams	= {};
		var serialized	= $(this.selector + ' :input').serialize();
		var elements	= serialized.split("&");

		for(i=0; i<elements.length;i++){
			var element = elements[i].split("=");
			var name	= element[0];
			var value	= element[1];

			var inputActual = $(this.selector + ' :input[name=' + name + ']');

			if($(inputActual).attr('type') == "checkbox"){
				value = ($(inputActual).is(':checked'))? 1 : 0;
			}

			if(value != undefined){
				value = value.replace(/\+/g, " ")
			}
			else{
				value = '';
			}
			objParams[name] = myTrim(value);
		}

		var disabledEls = $(this.selector + ' :disabled');
		for(i=0; i<disabledEls.length; i++){
			var valor = $(disabledEls[i]).val();
			var name = $(disabledEls[i]).attr('name');
			objParams[name] = (valor != undefined)? valor.replace(/\+/g, " ") : '';
		}

		return objParams;
	}

	initCorreccionCorresponsal();

	$.fn.customLoadStore = function(oCfg){
		var $cmb = $(this.selector);

		$(this.selector).customEmptyStore(oCfg);

		if(oCfg.url != undefined && oCfg.url.trim() != ''){
			$.ajax({
				url			: oCfg.url,
				type		: 'POST',
				dataType	: 'json',
				data		: oCfg.params || {}
			})
			.done(function(resp, msg) {

				if(resp.nCodigo == 0){
					if(oCfg.arrResultName != undefined && oCfg.arrResultName.trim() != ''){
						var arrResult = eval("resp ." + oCfg.arrResultName);
					}
					else{
						var arrResult = resp.data;
					}

					for(var index = 0; index < arrResult.length; index++){
						var oElemento	= arrResult[index];
						var option		= document.createElement("option");
						option.text		= eval("oElemento." + oCfg.labelField);
						option.value	= eval("oElemento." + oCfg.idField);
						$cmb.append(option);
					}
				}
			})
			.fail(function(resp) {
				console.log(resp, "error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}
	}

	$.fn.customEmptyStore = function(oCfg){
		var $cmb = $(this.selector);
		$cmb.empty();

		if(oCfg.firstItemId != undefined && oCfg.firstItemId != '' && oCfg.firstItemValue != undefined && oCfg.firstItemValue != ''){
			$cmb.append('<option value="' + oCfg.firstItemId + '">' + oCfg.firstItemValue + '</option>');
		}
	}

	function initCorreccionCorresponsal(){
		$("#txtSNombreCorresponsal").autocomplete({
			source: function(request,respond){
				$.post( "../../inc/Ajax/_Clientes/Correcciones/corresponsales_lista.php", { "strBuscar": request.term },
				function( response ) {
					$('#cmbCliente').customEmptyStore({});
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtSNombreCorresponsal").val(ui.item.nombreCorresponsal);
				return false;
			},
			select: function(event,ui){
				$("#txtNIdCorresponsal").val(ui.item.idCorresponsal);
				cargarStoreClientes(ui.item.idCorresponsal);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>ID :" + item.id + ' ' + item.value + "</a>" )
			.appendTo( ul );
		};

		$('#txtSNombreCorresponsal').on('change', function(e){
			if(myTrim(e.target.value) == ''){
				$('#txtNIdCorresponsal').val('');
				$('#cmbCliente').customEmptyStore({});
			}
		});

		$('#btnActualizarCorresponsal').on('click', function(e){
			guardarCambiosCorresponsal();
		});
	}

	function cargarStoreClientes(nIdCorresponsal){
		$('#cmbCliente').customLoadStore({
			url				: '../../inc/Ajax/_Clientes/Correcciones/storeCliente.php',
			labelField		: 'sNombreCliente',
			idField			: 'nIdCliente',
			firstItemId		: '-1',
			firstItemValue	: 'Seleccione Cliente',
			params			: {
				nIdCorresponsal : nIdCorresponsal
			}
		});
	}

	function guardarCambiosCorresponsal(){
		var params = $('#frmCorreccionCorresponsal').getSimpleParams();

		if(params.nIdCorresponsal == undefined || params.nIdCorresponsal <= 0 || params.nIdCorresponsal == ''){
			alert('Seleccione Corresponsal');
			return false;
		}

		if(params.nIdCliente == undefined || params.nIdCliente == '' || params.nIdCliente <= 0){
			alert('Seleccione Cliente');
			return false;
		}

		$.ajax({
			url			: '../../inc/Ajax/_Clientes/Correcciones/guardarCambiosCorresponsal.php',
			type		: 'POST',
			dataType	: 'json',
			data		: params,
		})
		.done(function(resp){
			if(resp.bExito == false){
				alert(resp.sMensaje);
			}
			else{

				if($('#formcambios').length == 0){
					var form = '<form id="formcambios" method="post" action="http://intranet/Corresponsales/Corresponsal/Modificaciones.php" target="_blank">';
					form+= '<input type="hidden" name="identificador" value="idCorresponsal">';
					form+= '<input type="hidden" name="txtB" value="'+ params.nIdCorresponsal +'">';
					form+= '<input type="hidden" name="Corr" value="'+ params.nIdCorresponsal +'">';
					form+= '</form>';
					$('body').append(form);
				}
				else{
					$('#formcambios :input[name=Corr]').val(params.nIdCorresponsal);
					$('#formcambios :input[name=txtB]').val(params.nIdCorresponsal);
				}
			}


			$('#formcambios').submit();
		})
		.fail(function() {
			console.log("error");
		});
		
	}

});
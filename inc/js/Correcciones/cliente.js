$(document).ready(function() {
	initCorreccionCliente();

	function initCorreccionCliente(){

		$("#txtSNombreCliente").autocomplete({
			source: function(request,respond){
				$.post( "../../inc/Ajax/_Clientes/Correcciones/clientes_lista.php", { "strBuscar": request.term },
				function( response ) {
					respond(response);
				}, "json" );					
			},
			minLength: 1,
			focus: function(event,ui){
				$("#txtSNombreCliente").val(ui.item.sNombreCliente);
				return false;
			},
			select: function(event,ui){
				$("#txtNIdCliente").val(ui.item.nIdCliente);
				return false;
			}
		})
		.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
			return $( '<li>' )
			.append( "<a>ID :" + item.nIdCliente + ' ' + item.sNombreCliente + "</a>" )
			.appendTo( ul );
		};

		$('#cmbVersion').customLoadStore({
			url				: '../../inc/Ajax/_Clientes/Correcciones/storeVersion.php',
			labelField		: 'sNombreVersion',
			idField			: 'nIdVersion',
			firstItemId		: '-1',
			firstItemValue	: 'Seleccione Versión'
		});

		$('#txtSRazonSocial').alphanum({
			allow				: '\u00E1\u00E9\u00ED\u00F3\u00FA\u00C1\u00C9\u00CD\u00D3\u00DA\u00F1\u00D1',
			allowSpace			: true,
			allowNumeric		: true,
			allowUpper			: true,
			allowLower			: true,
			allowLatin			: true,
			allowOtherCharSets	: false,
			maxlength			: 150
		});

		$('#txtNNumCuentaForelo').numeric({
			allowPlus			: false,
			allowMinus			: false,
			allowThouSep		: false,
			allowDecSep			: false,
			allowLeadingSpaces	: false,
			maxDigits			: 15
		});
	}
});
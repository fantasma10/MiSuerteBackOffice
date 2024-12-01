$(document).ready(function() {
						   		   
	/* Crear la tabla de PreCadenas */
	var tablaPreCadenas = $('#precadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "../inc/Ajax/_Clientes/PreCadenasDataTable.php",
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[2];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			}, "aTargets": [ 1 ], "bSortable" : true },
			{ "mRender": function ( data, type, row ) {
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Cadena/Crear.php?id=" + row[0] + "\';\"><img src=\"../../img/edit.png\"  title=\"Editar\"></a>";
				return iconoEditar;
			}, "bSortable": false, "aTargets": [ 2 ] }
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
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
	
	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "../inc/Ajax/_Clientes/PreSubcadenasDataTable.php",
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[3];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			}, "aTargets": [ 1 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Subcadena/Crear.php?id=";
				iconoEditar += row[0] + "\';\">";
				iconoEditar += "<img title=\"Editar\" src=\"../img/edit.png\">";
				iconoEditar += "</a>";
				return iconoEditar;
			}, "bSortable": false, "sClass": "contenido-centrado", "aTargets": [ 2 ] }
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
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
	
	/* Crear la tabla de PreCorresponsales */
	var tablaPreCorresponsales = $('#precorresponsales').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "../inc/Ajax/_Clientes/PreCorresponsalesDataTable.php",
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[4];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			}, "aTargets": [ 1 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Corresponsal/Crear.php?id=";
				iconoEditar += row[0] + "\';\">";
				iconoEditar += "<img title=\"Editar\" src=\"../img/edit.png\">";
				iconoEditar += "</a>";
				return iconoEditar;
			}, "bSortable": false, "aTargets": [ 2 ] }
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreCorresponsales.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
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
	
	$('.dataTables_filter input').attr( 'maxlength', 50 );
	$('.dataTables_processing').css('padding-bottom', '30px');
	
} );
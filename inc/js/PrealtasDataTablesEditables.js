$(document).ready(function() {
						   		   
	/* Crear la tabla de PreCadenas */
	var tablaPreCadenas = $('#precadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "../inc/Ajax/_Clientes/PreCadenasDataTable.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[2];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			},/* "sWidth": "20px",*/ "aTargets": [ 1 ], "bSortable" : true },
			{ "mRender": function ( data, type, row ) {
				var iconoRevisado = "";
				if ( row[1] == 100 ) {
					if ( row[3] == 0 ) {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Cadena/Validar1.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"Validado\" src=\"../../img/ico_revision2.png\" /></a>";
					} else {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Cadena/Validar.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"No Validado\" src=\"../../img/ico_revision1.png\" /></a>";
					}
				}
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 2 ] },
			{ "mRender": function ( data, type, row ) {
				/*var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Cadena/Crear.php?id=";
				iconoEditar += row[0] + "\';\">";
				iconoEditar += "<img title=\"Editar\" src=\"../img/edit.png\">";
				iconoEditar += "</a>";*/
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Cadena/Crear.php?id=" + row[0] + "\';\"><img src=\"../../img/edit.png\"  title=\"Editar\"></a>";
				return iconoEditar;
			}, "bSortable": false, "aTargets": [ 3 ] },
			{ "mRender": function ( data, type, row ) {
				/*var iconoEliminar = "<a href=\"#\" onclick=\"EliminarPreCadena2(";
				iconoEliminar += row[0];
				iconoEliminar += ")\">";
				iconoEliminar += "<img title=\"Borrar\" src=\"../img/delete.png\">";
				iconoEliminar += "</a>";*/
				//<div data-original-title="Ocultar Menú" data-placement="right" class="fa fa-bars tooltips"></div>
				var iconoEliminar = "<a title='Borrar' href=\"#\" onclick=\"EliminarPreCadena2("+row[0]+")\"><img src=\"../../img/delete.png\" title=\"Borrar\"></i></a>";
				return iconoEliminar;
			}, "bSortable": false, "aTargets": [ 4 ] },
			{ "mRender": function ( data, type, row ) {
				if ( row[1] == 100 && row[3] == 0 ) {
					//var iconoAutorizar = "<a href=\"#\" onclick=\"window.location.href=\'Cadena/Aut2.php?id=";
					var iconoAutorizar = "<a href='#' title='Autorizar' onclick='goToAutorizarCadena("+row[0]+")'><img src=\"../../img/autorizar.png\" title=\"Autorizar\"></i></a>";
					/*iconoAutorizar += row[0]+")";
					//iconoAutorizar += "\';\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage(\'Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\',\'\',\'../../img/btn_ico_autorizar2.png\',1)\">";
					iconoAutorizar += "<img title=\"Autorizar\" src=\"../../img/btn_ico_autorizar1.png\" name=";
					iconoAutorizar += "\"Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\" width=\"22\" height=\"22\" border=\"0\" id=\"Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\" /></a>";*/
				}
				if ( iconoAutorizar != null ) {
					return iconoAutorizar;
				} else {
					return "";
				}
			}, "bSortable": false, "aTargets": [ 5 ]}
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreCadenas.$('tr:odd').css( "background-color", "#D4DDED" );
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
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[3];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoRevisado = "";
				if ( row[1] == 100 ) {
					if ( row[2] == 0 ) {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Subcadena/Validar1.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"Validado\" src=\"../../img/ico_revision2.png\"/></a>";
					} else {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Subcadena/Validar.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"No Validado\" src=\"../../img/ico_revision1.png\"/></a>";
					}
				}
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 2 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Subcadena/Crear.php?id=";
				iconoEditar += row[0] + "\';\">";
				iconoEditar += "<img title=\"Editar\" src=\"../img/edit.png\">";
				iconoEditar += "</a>";
				return iconoEditar;
			}, "bSortable": false, "sClass": "contenido-centrado", "aTargets": [ 3 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEliminar = "<a href=\"#\" onclick=\"EliminarPreSubCadena2(";
				iconoEliminar += row[0];
				iconoEliminar += ")\">";
				iconoEliminar += "<img title=\"Borrar\" src=\"../img/delete.png\">";
				iconoEliminar += "</a>";
				return iconoEliminar;
			}, "bSortable": false, "aTargets": [ 4 ] },
			{ "mRender": function ( data, type, row ) {
				if ( row[1] == 100 && row[2] == 0 ) {
					var iconoAutorizar = "<a href='#' onclick='goToAutorizarSubCadena("+row[0]+")'><img src=\"../../img/autorizar.png\" title='Autorizar'></a>";
				}
				if ( iconoAutorizar != null ) {
					return iconoAutorizar;
				} else {
					return "";
				}
			}, "bSortable": false, "sClass": "contenido-centrado", "aTargets": [ 5 ]}
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreSubCadenas.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreSubCadenas.$('tr:odd').css( "background-color", "#D4DDED" );

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
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
			{ "mRender": function ( data, type, row ) {
				return row[4];
			}, "aTargets": [ 0 ] },
			{ 	"mRender": function ( data, type, row ) {
				return row[1] + "%";
			},/* "sWidth": "20px",*/ "aTargets": [ 1 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoRevisado = "";
				if ( row[1] == 100 ) {
					if ( row[3] == 0 ) {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Corresponsal/Validar1.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"Validado\" src=\"../../img/ico_revision2.png\" /></a>";
					} else {
						iconoRevisado = "<a href=\"#\"><img onclick=\"window.location.href=\'Corresponsal/Validar.php?id=";
						iconoRevisado += row[0];
						iconoRevisado += "\';\" title=\"No Validado\" src=\"../../img/ico_revision1.png\" /></a>";
					}
				}
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 2 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEditar = "<a href=\"#\" onclick=\"window.location.href=\'Corresponsal/Crear.php?id=";
				iconoEditar += row[0] + "\';\">";
				iconoEditar += "<img title=\"Editar\" src=\"../img/edit.png\">";
				iconoEditar += "</a>";
				return iconoEditar;
			}, "bSortable": false, "aTargets": [ 3 ] },
			{ "mRender": function ( data, type, row ) {
				var iconoEliminar = "<a href=\"#\" onclick=\"EliminarPreCorresponsal2(";
				iconoEliminar += row[0];
				iconoEliminar += ")\">";
				iconoEliminar += "<img title=\"Borrar\" src=\"../img/delete.png\">";
				iconoEliminar += "</a>";
				return iconoEliminar;
			}, "bSortable": false, "aTargets": [ 4 ] },
			{ "mRender": function ( data, type, row ) {
				if ( row[1] == 100 && row[3] == 0 ) {
					/*var iconoAutorizar = "<a href=\"#\" onclick=\"window.location.href=\'Corresponsal/Aut5.php?id=";
					iconoAutorizar += row[0];
					iconoAutorizar += "\';\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage(\'Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\',\'\',\'../../img/btn_ico_autorizar2.png\',1)\">";
					iconoAutorizar += "<img title=\"Autorizar\" src=\"../../img/btn_ico_autorizar1.png\" name=";
					iconoAutorizar += "\"Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\" width=\"22\" height=\"22\" border=\"0\" id=\"Image122-";
					iconoAutorizar += row[0] + "0";
					iconoAutorizar += "\" /></a>";*/
					var iconoAutorizar = "<a href='#' onclick='goToAutorizarCorresponsal("+row[0]+")'><img src='../../img/autorizar.png' title=\"Autorizar\" class=\"tooltips\"></a>";
				}
				if ( iconoAutorizar != null ) {
					return iconoAutorizar;
				} else {
					return "";
				}
			}, "bSortable": false, "aTargets": [ 5 ]}
		],
		"fnDrawCallback": function ( oSettings ) {
			/* Aplicar tooltips */
			tablaPreCorresponsales.$('img').tooltip({
				"delay": 0,
				"track": true,
				"fade": 250					  
			});
			//tablaPreCorresponsales.$('tr:odd').css( "background-color", "#D4DDED" );
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
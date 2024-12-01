

	$(document).ready(function(){
       datatablaprosp();
     
       
        
	
    });
	




  function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/ValidacionProspectosDataTable.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {
				return row[1];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {
				return row[2];
			},  "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) {
				var iconoRevisado = "";
				
					if ( row[4] == 1 ) {
						iconoRevisado = "<center><img title=\"No Verificado\" src=\"../../img/ico_revision1.png\"/></center>";
					} else {
						iconoRevisado = "<center><img title=\"Correo Verificado\" src=\"../../img/ico_revision2.png\"/></center>";
					}
				
				return iconoRevisado;
			}, "bSortable": false, "aTargets": [ 2 ] },
            
          
			
            //4a columna
			
			{ "mRender": function ( data, type, row ) {
        var rfcstr = "'"+row[1]+"'";
				var iconoEditar = '<a href="#" onclick="editar('+row[0]+','+row[6]+','+row[5]+','+row[4]+','+rfcstr+')" ><center><img src=\"../img/edit.png\" title="Editar"></center></a>';
				return iconoEditar;
                
              
			
            }, "bSortable": false, "aTargets": [ 3 ] },
          
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
        
   }


function RefreshTable(tableId, urlData){
  $.getJSON(urlData, null, function( json )
  {
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();

    table.fnClearTable(this);

    for (var i=0; i<json.aaData.length; i++)
    {
      table.oApi._fnAddData(oSettings, json.aaData[i]);
    }

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
  });
    
}


     function editar(idincr, pais, regimen, idEstatus,rfc){
       
         
             var form = $('<form action="ProspectoValidacion.php" method="post" >'+
                          '<input type="hidden" name="idincr" value="'+idincr+'"/>'+
                          '<input type="hidden" name="pais" value="'+pais+'"/>'+
                          '<input type="hidden" name="regimen" value="'+regimen+'"/>'+
                          '<input type="hidden" name="estatus" value="'+idEstatus+'"/>'+
                          '<input type="hidden" name="sRfc" value="'+rfc+'"/>'+
                          
                           '</form>');
             $('body').append(form);
             $(form).submit();
             
          
         
    }



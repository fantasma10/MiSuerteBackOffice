	$(document).ready(function(){
       datatablaprosp();
        inicial();
        $('#btnRegistraCliente').on('click', function(e){ registrar();});
        $('#btnNuevoCte').on('click', function(){ inicial();});
        $('#btnGuardaCliente').on('click', function(){ validaractualizacte(); });
   });
/////////////////////////////////////////////
////////////////VARIABLES////////////////////
/////////////////////////////////////////////

var idcte = $('#txtIdCliente').val();

///////////////////////////////////////////////////
 
    function datatablaprosp(){     
        
        	/* Crear la tabla de PreSubCadenas */
	var tablaPreSubCadenas = $('#presubcadenas').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "./application/models/ClientesNuevosDataTable.php",
		/*"bJQueryUI": true,*/
		/*"sDom": '<"H"<"elementos"lr><"search-box"f>>t<"F"ip>',*/
		"aaSorting": [ [1, "desc"] ],
		"aoColumnDefs": [
            //1ra columna
			{ "mRender": function ( data, type, row ) {
				return row[2];
			}, "aTargets": [ 0 ] },
            //segunda columna
			{ 	"mRender": function ( data, type, row ) {
				return row[3];
			}, /*"sWidth": "20px",*/ "aTargets": [ 1 ] },
            //3a columna
			{ "mRender": function ( data, type, row ) {
			
				
					return row[1];
				
			}, "aTargets": [ 2 ] },
            
             //4a columna
			{ "mRender": function ( data, type, row ) {
			return row[0];
			},  "aTargets": [ 3 ] },
            //5a columna
			
			{ "mRender": function ( data, type, row ) {
              
                return row[5]; 
                //src=\"../img/edit.png\"
			
            }, "bSortable": true, "aTargets": [ 4 ] },
              //5a columna
			
			{ "mRender": function ( data, type, row ) {
               
               
                  var rfcstr = row[4];
				var iconoEditar = "<a href='#' onclick='editar(\""+row[1]+"\")'><center><img src=\"../img/edit.png\" title='Editar'></center></a>";
				return iconoEditar;
                //src=\"../img/edit.png\"
			
            }, "bSortable": false, "aTargets": [ 5] },
        
          
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
    function inicial(){
        $('#pannel1').css('display', 'none');
        document.getElementById("formModUno").reset(); 
        
   }

    function editar(rfccte){
         
      
                         $.post( "./application/models/ClienteNuevoContabilidaCargar.php",
                                    { rfc: rfccte },
	                                   function ( respuesta ) {
                     
		                                      if ( respuesta.idcliente > 0 ) {
                                                  $('#pannel1').css('display', 'block');
                                                  $('#txtIdCliente').val(respuesta.idcliente);
                                                  $('#txtIdSubcadena').val(respuesta.idsubcadena);
                                                  $('#txtRFC').val(respuesta.rfc);
                                                  $('#txtRazonSocial').val(respuesta.razonsocial);
                                                  $('#txtFechaAlta').val(respuesta.recharegistro);
                                                  $('#txttel').val(respuesta.telefonocliente);
                                                  $('#txtRegimen').val(respuesta.nombreregimen);
                                                  $('#txtCadena').val(respuesta.nombrecadena);
                                                  $('#txtSocio').val(respuesta.correo);
                                                  $('#txtCtaForelo').val(respuesta.numerocuenta);
                                                  $('#txtTipoForelo').val(respuesta.tipoforelo);
                                                  $('#txtTipoComision').val(respuesta.tiporeembolso);
                                                  $('#txtTipoLiquidacion').val(respuesta.tipoliquidacion);
                                                  $('#txtCuentaContable').val(respuesta.cuentacontable);
                                                  $('#txtReferencia').val(respuesta.referencia);
                                                  $('#txtClabe').val(respuesta.clabe);   
                                                  
                                                  $('#txtcalle').val(respuesta.calle);
                                                  $('#txtnumext').val(respuesta.numeroexterior);
                                                  $('#txtnumint').val(respuesta.numerointerior);
                                                  $('#txtcolonia').val(respuesta.colonia);
                                                  $('#txtmunucipio').val(respuesta.municipio);
                                                  $('#txtestado').val(respuesta.estado);
                                                  $('#txtpais').val(respuesta.paiss);
                                                  $('#txtcp').val(respuesta.cp);
                                                   
                                                  
                                                  
                                        } else {
                              
                                                $().toastmessage('showToast', {
                                                            text		: "No se encontraron Registros",
				                                            sticky		: false,
				                                            position	: 'top-center',
				                                            type		: 'warning'
                                                        }); 
                                            
                                            inicial();
                                          }
                                }, "json");
         
    }

